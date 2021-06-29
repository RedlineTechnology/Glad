<?php
/**
 * We're going to Hook into Memberpress to do stuff!
 * Dependent on wildApricot.php
 *
 * @link https://docs.memberpress.com/article/325-action-hooks-in-memberpress
 *
 * @package _glad
 */

// Add a New Member
// function mepr_capture_new_member_added($event) {
//   $user = $event->get_data();
//   //Do what you need
// }
// add_action('mepr-event-member-added', 'mepr_capture_new_member_added');

// Any Transaction Completed
// function mepr_transaction_complete($event) {
//   $transaction = $event->get_data();
//   $subscription = $transaction->subscription();
//
// }
// add_action('mepr-event-transaction-completed', 'mepr_transaction_complete');


/** ********************************************************
 *                  REFERRAL DISCOUNTS                     *
 ********************************************************* */

function update_referrals( $verbose = false ) {
  // Instanciate Stripe Gateway
  // Doing it out here and passing it to the discount function saves us some work
  // I have no clue how MEPR grabs the API Keys when it uses this.
  // I've dug and dug through the source files to no avail, so I'm just going to do it manually here by grabbing the Options and extracting them
  $mepr_options = MeprOptions::fetch();
  foreach( $mepr_options->integrations as $gateway ) {
    if( $gateway['gateway'] == 'MeprStripeGateway' ) {
      $keys = $gateway['api_keys'];
      break;
    }
  }
  $stripe = new MeprStripeGateway();
  $stripe->settings->public_key = $keys['live']['public'];
  $stripe->settings->secret_key = $keys['live']['secret'];

  // Grab Each Member who has an active referral on their account
  $coupons = they_did_the_math();

  $diagnostic = array();
  foreach( $coupons as $user_id => $user ) {
    if( $user['active'] ) {
      try {
        $diagnostic[] = apply_referral_discount( $stripe, $user_id, $user['stripecode'], $verbose );
      } catch ( Exception $e ) {
        $diagnostic[] = $e->getMessage();
      }
    }
  }

  if( !empty( $diagnostic )) {
    return $diagnostic;
  }
  return;
}

// Referral Discount Calculator
function they_did_the_math() {
  // Stripe Coupon Codes
  $discounts = array(
    1 => 'lw6X3s25',
    2 => 'Taa8YaSu',
    3 => 'CxQfPl2d',
    4 => 'ybz6ku3d',
    5 => 'WDrz6yia',
  );

  // Get Coupon Posts
  $args = array(
    'post_type'       => 'coupons',
    'post_status'     => 'publish',
    'paged'           => false,
    'tax_query'	=> array(
          array(
              'taxonomy' 	=> 'coupontype',
              'terms' 		=> array('referral'),
              'field' 		=> 'slug',
              'operator' 	=> 'IN'
          ),
      ),
  );

  $coupons = array();

  // Figure out how many active Referrals are on each member's account
  $coupon_query = new WP_Query( $args );
  if( $coupon_query->have_posts() ) :
		while( $coupon_query->have_posts() ): $coupon_query->the_post();

      global $post;
      $author = $post->post_author;

      $details = array();
      $details['by'] = get_the_title();
      $details['created'] = $post->post_date;
      $date = new DateTime( $post->post_date );
      $now = new DateTime();
      $diff = $date->diff( $now );
      $details['days_since_created'] = $diff->format('%a');

      // Has the coupon been used? If yes, how long ago? Coupon will remain active
      // for 12 months from date of use or date of creation
      $details['used'] = $post->used ?: false;
      $details['used_on'] = $post->usedon ?: false;
      if( $post->used ) {
        $usedate = new DateTime( $post->usedon );
        $now = new DateTime();
        $diff = $usedate->diff( $now );
        $details['days_since_used'] = $diff->format('%a');

        $days = $details['days_since_used'];
        $active = 300;
        // 300 Days is ~ 10 months, the longest amount of time any USED coupon would remain active.
        // In the case of an ANNUAL subscription, it will not be used again. In the case of QUARTERLY,
        // the 4th quarter that it is active will begin 9 months after it starts, so we give 10 as a buffer
      } else {
        $days = $details['days_since_created'];
        $active = 365;
      }

      $coupons[ $author ]['name'] = get_the_author_meta( 'display_name', $author );
      $coupons[ $author ]['active'] += ( $days <= $active ) ? 1 : 0;
      $coupons[ $author ]['stripecode'] = $discounts[ $coupons[ $author ]['active'] ] ?: 'none';
      $coupons[ $author ]['referrals'][] = $details;

		endwhile;
	endif;

  return $coupons;

}

// Apply a Referral Discount to a user's Stripe Customer Account
// Requires Memberpress Stripe Gateway
// Receives MeprStripeGateway object, User ID, & Coupon ID provided by the above they_did_the_math()
// Can also be set to diagnostic mode using verbose = true
function apply_referral_discount( $stripe, $user_id, $coupon_id, $verbose = false ) {

  // First get the Memberpress Subscription ID for the user
  $author = new MeprUser( $user_id );
  $memberships = $author->active_product_subscriptions('transactions',true);

  // Fail if there are no memberships
  if( empty( $memberships )) {
    if( $verbose ){ return 'FAILED: No Active Subscriptions Found'; }
    return;
  }
  // Only get a Subscription that is not "0"
  foreach( $memberships as $memb ) {
    $temp_id = $memb->subscription_id;
    if( $temp_id != '0' ) {
      $sub_id = $temp_id;
      break;
    }
  }
  if( $sub_id ) {
    // This user has a subscription -- proceed
    $sub = new MeprSubscription($sub_id);
    // Some customers SUBSCRIPTIONS are not noted by their customer number,
    // e.g., cus_XXX -- others have a subscription number, e.g., sub_XXX
    if( strpos($sub->subscr_id, 'cus_') === 0 ) {
      // this is a cus_ id, we're ready to make our Stripe request
      $customer_id = $sub->subscr_id;
    } else {
      // this is (probably) a sub_ id, so we need to take an extra step
      try {
        $subscription = (object)$stripe->send_stripe_request("subscriptions/{$sub->subscr_id}");
      } catch (Exception $e) {
        if( $verbose ){ return $e->getMessage(); }
        return;
      }
      $customer_id = $subscription->customer;
    }

    // Get the Stripe Customer obj
    $customer = (object)$stripe->send_stripe_request("customers/{$customer_id}");
    $current_discount = $customer->discount['coupon']['id'];

    // This happened back when I was trying to get the customer by using
    // sub_XXX id's. Leaving this diagnostic in just in case
    if( property_exists( $customer, 'scalar' ) ) {
      if( $verbose ){ return 'FAILED: Customer ID Mismatch'; }
      return;
    }

    // Do discount logic
    if( $current_discount && $current_discount == $coupon_id ) {
      // Discount is current. Nothing to do
      if( $verbose ){ return 'FAILED: Discount Already Applied'; }
      return;
    }
    if( $current_discount ) {
      // If a current discount exists, but the discount is wrong, we need to delete it before updating
      try {
        $delete = (object)$stripe->send_stripe_request("customers/{$customer->id}/discount", array(), 'delete');
      } catch (Exception $e) {
        if( $verbose ){ return $e->getMessage(); }
        return;
      }
    }
    // otherwise, apply the discount
    try {
      $try = (object)$stripe->send_stripe_request("customers/{$customer->id}", array( 'coupon' => $coupon_id ));
    } catch (Exception $e) {
      if( $verbose ){ return $e->getMessage(); }
      return;
    }

    if( $verbose ){ return 'yay'; }
    return;

  } else {
    // this person might not exist in Stripe
    if( $verbose ){ return 'FAILED: No Customer Found'; }
    return;
  }

}


/** ********************************************************
 *                 MEMBERSHIPS MANAGEMENT                  *
 ********************************************************* */

// Payment has been Completed
// We want to get rid of the "Applicant" Membership once a successful Membership is Completed
function maybe_cancel_application($txn) {
  $application = '157';
  $thismemb = $txn->product_id;

  // is this an application? we don't want to cancel what they are signing up for
  if( $application == $thismemb) {
    return;
  }

  // get our user's transactions 'n stuff
  $usr = $txn->user();
  $active_subs = $usr->active_product_subscriptions('ids', true);

  // we could use $usr->is_already_subscribed_to($application) here, but it's a
  // little redundant since if it's successful, we have to call active_product_subsctiptions
  // again anyways to get the transaction IDs.

  if ( in_array($application, $active_subs) && ($thismemb != $application) ) {
    $txns = $usr->active_product_subscriptions('transactions', true);
    foreach ( $txns as $old_txn ) {
      if( $old_txn->product_id == '157' ) {
        $old_txn->expire();
      }
    }
  }
}
add_action('mepr-txn-status-complete', 'maybe_cancel_application');

function check_alternate_email($recipients, $subject, $message, $headers) {
  // Do what you need
  foreach( $recipients as $i => $email ) {
    $user = get_user_by('email', $email);
    if(isset($user)) {
      if(( $alt = get_user_meta($user->ID, 'mepr_notification_email', true) )) {
        unset($recipients[$i]);
        $recipients[] = $alt;
      }
    }
  }
  return $recipients;
}
add_filter('mepr-wp-mail-recipients', 'check_alternate_email', 10, 4);

// Log in
// function mepr_on_login($event) {
//   $user = $event->get_data();
// }
// add_action('mepr-event-login', 'mepr_on_login');
