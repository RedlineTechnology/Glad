<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _glad
 */

    get_header(); ?>

    <section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
  		<img id="members-img" src="<?php echo get_stylesheet_directory_uri() ?>/images/members.png">
  		<a class="button" href="/login">Log in</a>
  		<div class="membership-box"></div>
  	</section>

  	<div id="page" class="content-area">
  		<main id="main" class="site-main">

  			<section class="content" style="overflow-y:auto; font-family: courier, monospace !important;"> <?php

        // $userId = 9; //Guy
        // $updateResponse = updateContact( $userId );
        // var_dump( $updateResponse );

        global $waApiClient;
        global $accountUrl;

        // $allusers = get_users( array( 'fields' => array( 'ID' ) ) );

        // $i = 0;
        // foreach ( $allusers as $user ) {



            //$user_id = $user->ID;
            $user_id = 22;
            $userObj = get_userdata( $user_id );
            $userMeta = get_user_meta( $user_id );
            // Let's get MemberPress
            $member = new MeprUser( $user_id ); // Get Membership User Info
            $sub_ids    = $member->current_and_prior_subscriptions(); //returns an array of Product ID's the user has ever been subscribed to
            $activesubs = $member->active_product_subscriptions('ids'); // self-explanatory

            echo '<h1>USER: ' . $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0] . '</h1>';
            echo 'Active Subscription IDs: '; var_dump( $activesubs ); echo '<br>';
            if( count( $activesubs ) > 1 ) {
              foreach( $activesubs as $sub_id ) {
                if ( $sub_id == '157' ) {
                  break;
                }
                $wp_MembershipID = $sub_id;
              }
            } else {
              $wp_MembershipID = $activesubs[0];
            }

            echo 'Membership ID: ' . $wp_MembershipID . '<br>';

            // Get Roles
            $roles =          $userObj->roles;
            $approved =       in_array( 'Approved', $roles ) ? true : false;
            $promoted =       in_array( 'Promoted', $roles ) ? true : false;
            $managed =        in_array( 'Managed', $roles ) ? true : false;
            $memberRole =     $approved ? 'Approved' : $promoted ? 'Promoted' : $managed ? 'Managed' : null;

            // For this Directory Listing, we want to target Active Memberships without the 'Managed' Role
            if( $activesubs && !in_array('157', $activesubs) && !$managed ) {
              // Let's get WildApricot
              $wa_ID = contactExists( $userObj->data->user_email ) ? : $userMeta['mepr__waid'][0];
              if( $wa_ID ) {

                echo '<h4>User: ' . $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0] . '</h4>';
                checkForUpdates( $user_id );

                $url = $accountUrl . '/contacts/' . $wa_ID . '?getExtendedMembershipInfo=true';
                $contact = $waApiClient->makeRequest($url);
                $membership = $contact['MembershipLevel']['Id'];
                $extendedMembershipInfo = $contact['ExtendedMembershipInfo'];

                var_dump( $contact );

              } else {
                $contact = updateContact( $user_id );
                echo 'CONTACT DUMP: <br>'; var_dump( $contact );
              }
              // $contact = updateContact( $user_id );
            }

        // }


        // OVERWRITE A FIELDDDD
        // echo '<br><h3>Notes</h3>';
        // $args = array(
        //   'nicename' => 'Notes',
        //   'wildapricot' => 'Notes',
        //   'wordpress' => 'notes'
        // );
        // $overwrite = overwriteField( $args );
        // var_dump( $overwrite );
        //
        // $contactsResult = getContactsList();
        // $contacts = $contactsResult['Contacts'];
        //
        // echo '<br><br><h3>Contacts</h3>';
        //
        // // For Each Contact, Set the new Value
        // foreach($contacts as $contact) {
        //
        //   $user = get_user_by( 'email', $contact['Email'] );
        //
        //   if( $user ) {
        //     checkForUpdates( $user->ID );
        //   } else {
        //     echo '<!-- Cannot Find User ' . $contact['Id'] . ' in Wordpress -->';
        //   }
        //
        // }


        // Text Magic
        // global $tmApiClient;
        //
        // // echo '<br><h3>Lists: </h3>';
        // // showAllLists(); --> Dealer Member List is 1399538
        //
        // $name = 'Testy McTesterson';
        // $phoneNumber = '18132878321';
        // $list = '1399538';

        // $search = implode( ', ', findContact( $phoneNumber ) );
        // if( $search ) {
        //   // IF CONTACT EXISTS, add to LIST
        //   $add = addToList( $list, $search );
        // } else {
        //   // IF CONTACT DOES NOT EXIST, CREATE WITH LIST
        //   $newcontact = createContact( $name, $phoneNumber, $list );
        // }

        // $search = implode( ', ', findContact( $phoneNumber ) );
        // if( $search ) {
        //   // REMOVE LIST FROM CONTACT
        //   $delete = removeFromList( $list, $search );
        // }


        // $sms_numbers = array(
        //   array(
        //     'Trinity Subers',
        //     '2102320043'
        //   )
        // );
        //
        // $oldnumbers = array(
        //   array(
        //     'Trinity Subers',
        //     '9136383464'
        //   )
        // );
        //
        // $sms_main_sanitized = '19136383464';
        //
        // // Remove All Numbers from TMSMS List
        // $purgeList = array();
        // $purgeList[] = implode( ', ', findContact( $sms_main_sanitized ) );
        //
        // foreach( $sms_numbers as $number ) {
        //   $purgeList[] = implode( ', ', findContact( $number[1] ) );
        //   echo '<p>uh... ' . $number[1] . '</p>';
        // }
        //
        // $purgeList = implode( ', ', $purgeList );
        //
        // echo '<h3>Purge List: </h3><br>';
        //
        // var_dump( $purgeList );




        // foreach( $sms_numbers as $number ) {
        //   $purgeList[] = implode( ', ', findContact( $number ) );
        // }
        // $purgeList = implode( ', ', $purgeList );
        // removeFromList( $list, $purgeList );

        // $justNumbers[] = stripPhoneNumber('913-638-3464');
        //
        // foreach( $sms_numbers as $array ) {
        //   $justNumbers[] = stripPhoneNumber( $array[1] );
        // }
        //
        // // Add / Update all Contacts to the TMSMS List
    		// foreach( $justNumbers as $number ) {
    		// 	$search = implode( ', ', findContact( $number ) );
    		// 	if( $search ) {
    		// 		// IF CONTACT EXISTS, add to LIST
    		// 		$add = addToList( $list, $search );
    		// 	} else {
    		// 		// IF CONTACT DOES NOT EXIST, CREATE WITH LIST
    		// 		$newcontact = createContact( $name, $phoneNumber, $list );
    		// 	}
    		// }

    		// $i = 0;
    		// while($i <= $count ) {
    		// 	$number = $oldnumbers[$i][1] ? : '';
        //
        //   if( $number ) {
        //     echo 'Old Number: ' . $number . '<br>';
        //
        //     foreach( $sms_numbers as $array ) {
        //
        //       echo 'New Number: ' . $array[1] . '<br>';
        //
        //       if( !in_array( $number, $array ) ) {
        //         echo 'The number is not in the new array, we need to get rid of it<br>';
        //
        // 				$search = implode( ', ', findContact( $number ) );
        //
        //         echo '<br><br>VAR DUMP: <br>';
        //         var_dump( $search );
        //
        //         if( $search ) {
        //           // REMOVE CONTACT FROM LIST
        //           echo '<!-- kill it with fire -->';
        //           $delete = removeFromList( $list, $search );
        //         } else {
        //           echo '<!-- this number does not exist on the server -->';
        //         }
        //
        //       } else {
        //         echo '<br>This number is in the new array';
        //       }
        //     }
        //   }
        //
    		// 	$i++;
    		// }


        // foreach( $search as $id ) {
        //   $contact = showContact( $id );
        //
        //   var_dump( $contact );
        // }

        ?>
        </section>

    </main><!-- #main -->
    </div><!-- #primary -->

    <?php

    get_footer();
