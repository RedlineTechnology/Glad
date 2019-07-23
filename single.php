<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _glad
 */

 get_header();

 $header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-hero-wide.jpg';

 ?>

 	<section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
 		<?php echo '<div class="title-wrapper mobile-hidden"><h1 id="title">' . get_the_title( $post->ID ) . '</h1></div>'; ?>
 	</section>

 	<div id="post" class="content-area">
 		<main id="main" class="site-main">

			<section class="single-post">

			<?php
			while ( have_posts() ) : the_post();

        $posttype = get_post_type( $post->ID );
        if( $posttype === 'listing' ) {
          get_template_part('template-parts/listing-page');
        } else {
          echo '<div class="the-deets">' .
  					'Posted on ' . get_the_date( 'l F j, Y' ) .
  				'</div>';

  				echo '<div class="the-content">';
  					echo '<h2 class="mobile">' . get_the_title( $post->ID ) . '</h2>';

  					the_content();

            $obj = get_post_type_object( $posttype );
            echo '<div class="post-nav">';
              echo '<a href="' . get_post_type_archive_link( $posttype ) . '">Back to ' . $obj->labels->name . '</a>';
            echo '</div>';

  				echo '</div>';

        }

			endwhile;
			?>

			</section>

 		</main><!-- #main -->
 	</div><!-- #primary -->

 <?php

 get_footer();

 get_template_part( 'template-parts/resize-hero' );
