<?php
/*
 *	The template for displaying single event
 *
 *	Override this tempalte by coping it to ....yourtheme/eventon/single-ajde_events.php
 *	This template is built based on wordpress twentythirteen theme standards and may not fit your custom
 *	theme correctly, in which case you may have to add custom styles to fix style issues
 *
 *	@Author: AJDE
 *	@EventON
 *	@version: 2.5.6
 */
?>

<?php

do_action('eventon_before_main_content');

get_header();

$header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-hero-wide.jpg';

?>

 <section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
	 <?php echo '<div class="title-wrapper mobile-hidden"><h1 id="title">' . get_the_title( $post->ID ) . '</h1></div>'; ?>
 </section>

 <div id="post" class="content-area">
	 <main id="main" class="site-main">

		 <section class="single-post">

				<div class='evo_page_body'>

					<?php do_action('eventon_single_content_wrapper');?>

						<?php /* The loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

								<div class="entry-content">

								<?php
									do_action('eventon_single_content');
								?>
								</div><!-- .entry-content -->

								<footer class="entry-meta">
									<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
								</footer><!-- .entry-meta -->
							</article><!-- #post -->
						<?php endwhile; ?>

					<?php	do_action('eventon_single_sidebar');	?>

					<?php	do_action('eventon_single_after_loop');	?>

				</div><!-- #primary -->

			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php 	do_action('eventon_after_main_content'); ?>
