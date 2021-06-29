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

  			<section class="content" style="overflow-y:auto; font-family: courier, monospace !important;">

          <div>
            <h3>Members Pending Approval</h3>
            <?php

            $args = array(
              'role__in' => array( 'Applicant' ),
              'number' => 100
            );
            $user_query = new WP_User_Query( $args );

            // User Loop
            if ( ! empty( $user_query->get_results() ) ) {
              foreach ( $user_query->get_results() as $user ) {

                $id = $user->ID;
                $contact = get_user_meta( $id ); // Get Regular User Info

                $firstname = $contact['first_name'][0];
                $lastname = $contact['last_name'][0];
                $company = $contact['mepr_company'][0] ? : '';

                echo '<div class="approval-item">';
                  echo '<h4>' . $company . ' - ' . $firstname . ' ' . $lastname . '</h4>'; ?>
                  <form action="#" method="POST" id="approval-<?php echo $id ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="approvemember">
                    <input type="hidden" name="user" value="<?php echo $id ?>">
                    <button data-user="<?php echo $id ?>" class="button" id="approval-submit-<?php echo $id ?>" value="approvemember">Approve <?php echo $firstname ?></button>
                  </form>
                </div>
                <?php
                // Use INCLUDE and LOCATE_TEMPLATE instead of GET_TEMPLATE_PART since
                // we need the included template to recognize the $user variable
                // include( locate_template( 'template-parts/directory-listing.php', false, false ) );
              }
            } else {
              echo '<p>No Applicants at this time.</p>';
            }

            ?>
          </div>

          <div>
            <h3>Member Diagnostic & Repair</h3>
            <form action="#" method="POST" id="diagnostic" enctype="multipart/form-data">
              <input type="hidden" name="action" value="userdiagnostic">
              <?php wp_dropdown_users( array( 'name' => 'user' ) ); ?>
              <button class="button light" id="diagnostic-submit" value="userdiagnostic">Do it</button>
            </form>
            <div id="response"></div>
          </div>

        </section>

    </main><!-- #main -->
    </div><!-- #primary -->

    <script>

    jQuery(document).ready(function($){
      $.ajaxSetup({cache:false});
      // Submit the Data.
      $('#diagnostic').submit( function() {

        $.ajax({
            url: 'https://glada.aero/wp-admin/admin-ajax.php',
            type: 'POST',
            data: $(this).find(':input').filter( function(index, element) {
                    return $(element).val() != '';
                  }).serialize(),
            dataType: 'json',
            beforeSend: function( xhr ) {
              $('#diagnostic-submit').addClass('loading').text('Fetching...');
              $('#response').html('<div style="text-align:center; width: 100%;"><center><img style="width:25px; height: 25px; margin:100px auto;" src="https://glad.aero/wp-content/themes/Glad/images/ajax-loader.gif"></center></div>');
            },
            success: function( data ) {
              $('#diagnostic-submit').removeClass('loading').text('Done!');
              $('#response').html(data.content);

              setTimeout(function() {
                  $('#diagnostic-submit').text('Repair');
              }, 4000);
            }
        });
        return false;
      });
      // Submit Approval Form
      $("form[id^='approval']").submit( function() {
        var user = $(this).find(".button").data('user');
        console.log( user );
        $.ajax({
            url: 'https://glada.aero/wp-admin/admin-ajax.php',
            type: 'POST',
            data: $(this).find(':input').filter( function(index, element) {
                    return $(element).val() != '';
                  }).serialize(),
            dataType: 'json',
            beforeSend: function( xhr ) {
              $("button[id^='approval-submit-"+user+"']").addClass('loading').text('Submitting...');
            },
            success: function( data ) {
              $("button[id^='approval-submit-"+user+"']").removeClass('loading').text('Approved!');
            }
        });
        return false;
      });
    });

    </script>


    <?php

    get_footer();
