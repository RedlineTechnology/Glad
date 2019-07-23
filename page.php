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

?>

	<section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
		<?php echo '<div class="title-wrapper"><h1 id="title">' . get_the_title( $post->ID ) . '</h1></div>'; ?>
	</section>

	<div id="page" class="content-area">
		<main id="main" class="site-main">

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
