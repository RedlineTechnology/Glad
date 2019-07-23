<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package _glad
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="hero section" style="background-image: url(' <?php echo get_stylesheet_directory_uri() . '/images/mplex_header.jpg'; ?>')">
				<div class="filter"></div>
				<div class="content-container">
					<div class="mobile-hidden">
						<h1 class="page-title">
							<?php
							/* translators: %s: search query. */
							printf( esc_html__( 'Search Results for: %s', '_glad' ), '<span>' . get_search_query() . '</span>' );
							?>
						</h1>
					</div>
				</div>
			</div>

			<section style="padding-top: 2em !important;" class="search-container"><?php get_search_form(); ?></section>

			<section class="archive-listing section">

	      <?php if ( $wp_query->have_posts() ) :

	        /* Start the Loop */
	        while ( $wp_query->have_posts() ) :
	          the_post();

	 				 $header_img =  wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') ); ?>
	 	       <article data-thumb="<?php echo $header_img ?>">
	 	         <a href="<?php the_permalink() ?>">
	 	           <div class="featured-img" style="background-image:url('<?php echo $header_img ?>');"></div>
	 	           <h2><span><?php the_title(); ?></span></h2>
	 	         </a>
	 	       </article>

	        <?php endwhile;

	        the_posts_navigation();

	      else :

	        echo '<h2>Your Search Returned No Results.</h2>';

	      endif;

	      wp_reset_query();

				get_search_form();
	      ?>

	    </section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
