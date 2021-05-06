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

$header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-hero-wide.jpg'; ?>

	<div id="page" class="content-area">
		<main id="main" class="site-main">

			<?php get_template_part('template-parts/nav-members'); ?>

			<section class="content">
				<?php
				while (have_posts()) : the_post();
					echo '<div class="the-content">';

						echo '<p> Redirecting, please wait... </p>';
						echo '<p> If page does not automatically redirect, <a href="' . bp_loggedin_user_domain() . $bp->settings->slug . '/mobilealerts/">click here</a></p>';

					echo '</div>';
				endwhile;
				?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

if( is_user_logged_in() ) {
	wp_register_script( 'smsforward', get_stylesheet_directory_uri() . '/js/smsforward.min.js', array('jquery'), '20210212' );
	// we have to pass parameters to script but we can get the parameters values only in PHP
	wp_localize_script( 'smsforward', 'sms_params', array(
		'sms' => true,
		'smsurl' => bp_loggedin_user_domain() . $bp->settings->slug . '/mobilealerts/', // SMS settings page
	) );
	wp_enqueue_script( 'smsforward' );
}

get_footer();

get_template_part( 'template-parts/resize-hero' );
