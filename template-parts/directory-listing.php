<?php

  $id = $user->ID;
  $contact = get_user_meta( $id ); // Get Regular User Info
  $member = new MeprUser( $id ); // Get Membership User Info

  $membership = $member->get_enabled_product_ids(); // This only retrieves Active Subscriptions (recurring payment subs)
  $all_ids    = $member->current_and_prior_subscriptions(); //returns an array of Product ID's the user has ever been subscribed to
  $active_ids = $member->active_product_subscriptions('ids'); // self-explanatory

  $roles = $user->roles;
  $managed = in_array( 'managed', $roles ) ? true : false; // Determine whether this is a Managed User
  $promoted = in_array( 'promoted', $roles ) ? true : false; // Determine whether this is a Promoted User

  // For this Directory Listing, we want to target Active Memberships without the 'Managed' Role
  if( $active_ids && !in_array('157', $active_ids) && !$managed ) {
    // Set Value for Wild Apricot Membership based on MemberPress ID
    //$WA_MEMB = $membership[0] == '157' ? '11080479' : $membership[0] == '20' ? '1080473' : '1080472';
    //Applicant = 1080479
    //Dealer = 1080473
    //Industry = 1080472

    $firstname = $contact['first_name'][0];
    $lastname = $contact['last_name'][0];
    $title = $contact['mepr_title'][0] ? ' | ' . $contact['mepr_title'][0] : '';
    $emailaddr = $user->user_email;
    $company = $contact['mepr_company'][0] ? : '';
    $website = $contact['mepr_company_website'][0] ? '<a target="_blank" href="' . $contact['mepr_company_website'][0] . '">' . $contact['mepr_company_website'][0] . '</a>' : '';
    $phone = '<i class="fas fa-phone"></i> ' . $contact['mepr_phone_number'][0];
    $email = '<a href="mailto:' . strtolower($emailaddr) . '"><i class="fas fa-envelope"></i> ' . strtolower($emailaddr) . '</a>';
    $associations = $contact['mepr_aviation_association_memberships_and_affiliations'][0];
    $logo = $contact['memberpress_avatar'][0];
    $promotedtext = $contact['mepr__promoted'][0] ? '<span class="promo_message"> | ' . $contact['mepr__promoted'][0] . '</span>' : '';

    ?>
    <div class="directory-item<?php if($promoted){ echo ' promoted'; }?>">
      <div class="contact-box">
        <?php
        if( $logo ) {
          echo '<div class="logo"><img src="' . wp_get_attachment_url( $logo ) . '"></div>';
        }
        echo '<div class="info">';
        if( $company ) {
          echo '<span class="name">' . $company . '</span>';
          if ( $promoted ) { echo $promotedtext; }
          echo '<span class="title">' . $website . '</span>' . $firstname . ' ' . $lastname . $title;
        } else {
          echo '<span class="name">' . $firstname . ' ' . $lastname . '</span><span class="title">' . $title . '</span>';
        }
        echo ' - <span class="contact">' . $phone . ' - ' . $email . '</span>';
        if( $associations ){ echo '<br><span class="$associations">' . $associations . '</span>'; }
        echo '<!-- '; var_dump($associations); echo '-->';

          // Contact Form
          $current_user = wp_get_current_user();
          $currentuser_name = $current_user->user_firstname . '%20' . $current_user->user_lastname;
          $currentuser_email = $current_user->user_email;

          // Generate Dynamic Form - not really working
          // echo '<div class="contactform">' . '<a class="button dircon" href="/member-contact?wpf250_5=' . $emailaddr . '&?wpf250_3=' . $currentuser_name . '&?wpf250_4=' . $currentuser_email . '">Send a Message</a>' . '</div>
        echo '</div>
      </div>';

      $args = array(
        'author'        =>  $id,
        'post_type'     =>  'opportunity',
        'orderby'       =>  'post_date',
        'order'         =>  'ASC',
        'post_status'   =>  'publish',
        'tag__not_in'   =>  array('29')
      );
      $opportunity_query = new wp_Query( $args );

      if( $opportunity_query->have_posts() ) :
        echo '<div class="opportunity_listings">';
        while( $opportunity_query->have_posts() ): $opportunity_query->the_post();

          echo '<div><a href="' . get_permalink() . '">' . the_title() . '</a></div>';

        endwhile;
        echo '</div>';
      endif; ?>
    </div>
    <?php
  } ?>
