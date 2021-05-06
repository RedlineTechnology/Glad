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

$header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-hero-wide.jpg';

	if ( is_page(197) ) {
		// Finalize Application Page. Hide Dealer Stuff for Industry Apps
		global $current_user;
		get_currentuserinfo();
		$user_id = $current_user->ID;
		$applicationType = get_user_meta($user_id, 'mepr_membership_type', true);
		if( $applicationType == 'industry' ) {
			wp_enqueue_script( 'industryapplication', get_template_directory_uri() . '/js/industryapplication.min.js', array('jquery'), '20200717', true );
		}
	}

?>

	<section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
		<?php echo '<div class="title-wrapper"><h1 id="title">' . get_the_title( $post->ID ) . '</h1></div>'; ?>
	</section>

	<div id="page" class="content-area">
		<main id="main" class="site-main">

			<?php get_template_part('template-parts/nav-members'); ?>

			<section class="content">
				<?php
				while (have_posts()) : the_post();
					echo '<div class="the-content">';

						// All The Pages Stuff
						the_content();

					echo '</div>';
				endwhile;
				?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();

get_template_part( 'template-parts/resize-hero' );
