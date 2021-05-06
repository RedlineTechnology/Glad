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
 load_leaflet();

 $header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-members.jpg'; ?>

 	<div id="page" class="content-area">
 		<main id="main" class="site-main">

      <?php get_template_part('template-parts/nav-members'); ?>

 			<section class="content">

        <?php

        // This whole page needs to be wrapped in a Membership Clause since we are apparently overriding the default Rule with our Template here.
        if( current_user_can('mepr-active','rule:37') ) { ?>

          <h2 class="section-title">Member Map</h2>
          <p>Want to let other GLADA Members know where you are? You can add and remove pins on this map at any time to make Aircraft Viewings and Meetings with other members that much easier!</p>

          <?php

          $haslocation = get_user_meta( get_current_user_id(), 'mepr_locations', true );
          if( empty( $haslocation )) { ?>
            <div class="tips">
              <p>To save your location to the map, click on the map to create a marker or search for the location using the search button in the upper right corner of the map. In the popup that appears over the marker, click "Save to My Locations."</p>
            </div>
          <?php } ?>

          <div id="membermap"></div>

        <?php } else {

          echo '<p>You do not have access to this page. Please Log in.</p>';

          echo do_shortcode('[mepr-login-form use_redirect="true"]');

        } // end Membership Clause ?>

      </section>
    </main><!-- #main -->
  </div><!-- #primary -->

  <?php

  get_footer();
