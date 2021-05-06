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

 get_header();

 $header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-members.jpg';

	get_template_part('template-parts/nav-member') ?>

 	<section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
 		<img id="directory-img" src="<?php echo get_stylesheet_directory_uri() ?>/images/directory.png">
 		<!-- <a class="button" href="/login">Log in</a> -->
 		<div class="membership-box"></div>
 	</section>

 	<div id="page" class="content-area">
 		<main id="main" class="site-main">

 			<section class="content">

        <?php

        // This whole page needs to be wrapped in a Membership Clause since we are apparently overriding the default Rule with our Template here.
        if( current_user_can('mepr-active','rule:37') ) {

          // We need the Industry Types that are set as Field Options in MemberPress
          $mepr_options = MeprOptions::fetch();
          $custom_fields = $mepr_options->custom_fields;
          // custom_fields contains an array of objects, so we can't use array_search() here. Instead we have to iterate over the objects and compare directly

          $industryTypes = null;
          foreach($custom_fields as $field) {
            if ( $field->field_key == 'mepr_industry_type' ) {
              $industryTypes = $field;
              break;
            }
          }
          $options = $industryTypes->options; ?>

          <form action="#" method="POST" id="filter">
            <?php
              echo '<div class="select"><select name="industrytype"><option value="">Filter by Industry...</option>';
              foreach ( $options as $option ) :
                echo '<option value="' . $option->option_value . '">' . $option->option_name . '</option>';
              endforeach;
              echo '</select></div>';
            ?>
            <input type="hidden" name="action" value="sortdirectory">
            <button class="sortdirectory">Update</button>
          </form>

          <div id="response">

            <?php

            $args = array(
              'role__not_in' => array( 'Managed', 'Administrator' ),
              'number' => 100
            );
            $user_query = new WP_User_Query( $args );

            // User Loop
            if ( ! empty( $user_query->get_results() ) ) {
              foreach ( $user_query->get_results() as $user ) {
                // Use INCLUDE and LOCATE_TEMPLATE instead of GET_TEMPLATE_PART since
                // we need the included template to recognize the $user variable
                include( locate_template( 'template-parts/directory-listing.php', false, false ) );
              }
            } else {
              echo 'No users found.';
            } ?>

          </div>

        <?php } else {

          echo '<p>You do not have access to this page. Please Log in.</p>';

          echo do_shortcode('[mepr-login-form use_redirect="true"]');

        } // end Membership Clause ?>

      </section>
    </main><!-- #main -->
  </div><!-- #primary -->

  <?php

  get_footer();
