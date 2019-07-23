<?php
  /**
  * The Main Blog Template
  *
  * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
  *
  * @package _glad
  */

get_header();

$posttype = get_queried_object()->name;

$header_img = ( $posttype == 'listing' ) ? '/images/bg-interior.jpg' : '/images/bg-engine.jpg'; ?>

	<section class="hero" style="background-image: url(' <?php echo get_stylesheet_directory_uri() . $header_img; ?>')">
		<?php echo '<div class="title-wrapper"><h1 id="title">' . post_type_archive_title( '', false ) . '</h1></div>'; ?>
	</section>

	<div id="archive" class="content-area">
		<main id="main" class="site-main">

      <section class="archive">
        <?php
        if ( have_posts() ) : ?>
          <article class="the-content"> <?php

						$posttype = get_queried_object()->name;
	          /* Start the Loop */
	          while ( have_posts() ) : the_post(); ?>
							<div class="<?php echo $posttype ?>-list-item"> <?php
							if ( $posttype === 'listing' ) {
								get_template_part('template-parts/listing');
							} else {
								?>
		              <h2 id="post-<?php the_ID(); ?>">
		                <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		              </h2>
									<?php if ( $posttype === 'opportunity' ) {
										echo '<p>' . the_content() . '</p>';
									} ?>
		              <small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>
								<?php
							} ?>
						</div> <?php
	          endwhile;

						if ( $posttype === 'opportunity' ) {
							echo '<p>To create your own Aircraft Opportunity Listing, <a href="/submit-opportunity">Click Here</a>.</p>';
						}

	          ?>
          </article> <?php

          the_posts_navigation();

        else :

          echo 'Looks like there\'s nothing here. Why don\'t you try searching?';

        endif;
        ?>
      </section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();

get_template_part( 'template-parts/resize-hero' );
