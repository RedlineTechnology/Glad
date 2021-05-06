<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _glad
 */

header("HTTP/1.1 301 Moved Permanently");
header("Location: ".get_bloginfo('url'));
exit();

get_header();

$header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-hero-wide.jpg';

?>

 <section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
	 <?php echo '<div class="title-wrapper mobile-hidden"><h1 id="title">' . get_the_title( $post->ID ) . '</h1></div>'; ?>
 </section>

 <div id="post" class="content-area">
	 <main id="main" class="site-main">

			<section class="error-404 not-found">

				<div class="page-content">

					<h3>Page Not Found</h3>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();

get_template_part( 'template-parts/resize-hero' );
