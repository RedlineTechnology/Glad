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

$header_img = ( $posttype == 'listing' ) ? '/images/bg-interior.jpg' : '/images/bg-engine.jpg';

	?>

	<section class="hero" style="background-image: url(' <?php echo get_stylesheet_directory_uri() . $header_img; ?>')">
		<?php echo '<div class="title-wrapper"><h1 id="title">' . post_type_archive_title( '', false ) . '</h1></div>'; ?>
	</section>

	<div id="archive" class="content-area">
		<main id="main" class="site-main">

			<?php get_template_part('template-parts/nav-members'); ?>

      <section class="archive">

        <?php
      	if ( have_posts() ) : ?>
          <article class="the-content">

					<?php
					// Do a check. Only Dealer Members can view Opportunity Listings.
					// if ( $posttype === 'opportunity' && !current_user_can('mepr-active','membership:19,232,580,588') ) {
					//
					// 	echo '<p>You do not have access to this page.</p>';
	        //   echo do_shortcode('[mepr-login-form use_redirect="true"]');
					//
					// } else {
					// Everyone can view Listings, and Dealers can view Opportunities

						// OPPORTUNITIES
						if ( $posttype === 'opportunity' ) {
							// Let's Sort Opportunities, I guess? ?>
							<div class="upper">
								<form action="#" method="POST" id="filter">
									<?php

										if( $terms = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name' ) ) ) :

											echo '<div class="select"><select name="category">
											<option value="">Opportunity Type...</option>';
											foreach ( $terms as $term ) :
												echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
											endforeach;
											echo '</select></div>';
										endif;
									?>
									<div class="radio-wrapper">
										<label>
											<input type="radio" name="date" value="ASC" /> Date: Ascending
										</label>
										<label>
											<input type="radio" name="date" value="DESC" selected="selected" /> Date: Descending
										</label>
									</div>
									<input type="hidden" name="action" value="sortopportunities">
									<button>Update</button>
								</form>
								<?php
								if( current_user_can('mepr-active','rule:37') && !current_user_can('mepr-active','membership:1416') ) {
									echo '<a class="button inverted" id="createopportunity"href="/members/submit-opportunity">Create an Opportunity</a>';
								}
								?>
							</div>
						<?php

						// LISTINGS
					} elseif ( $posttype === 'listing' ) { ?>
						<div class="upper">
							<form action="#" method="POST" id="filter">
								<?php
									if( $terms = get_terms( array( 'taxonomy' => 'aircraft', 'orderby' => 'name' ) ) ) :

										echo '<div class="select"><select name="aircrafttype">
											<option selected value="">Aircraft Type...</option>';
											foreach ( $terms as $term ) :
												echo '<option value="' . $term->slug . '">' . $term->name . '</option>'; // ID of the category as the value of an option
											endforeach;
										echo '</select></div>';
									endif;
								?>
								<?php
									// if( $terms = get_terms( array( 'taxonomy' => 'marketstatus', 'orderby' => 'name' ) ) ) :
									//
									// 	echo '<div class="select"><select name="marketstatus">';
									// 	foreach ( $terms as $term ) :
									// 		echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
									// 	endforeach;
									// 	echo '</select></div>';
									// endif;
								?>
								<!-- <input type="text" name="price_min" placeholder="Min price" /> -->
								<!-- <input type="text" name="price_max" placeholder="Max price" /> -->
								<?php
									$aircraftmakes = get_meta_values('make','listing');
									echo '<div class="select"><select name="make">
										<option selected value="all">Make...</option>';
										foreach ( $aircraftmakes as $make ) :
											echo '<option value="' . $make . '">' . $make . '</option>';
										endforeach;
									echo '</select></div>';
								?>
								<!-- <label>
									<input type="checkbox" name="featured_image" /> Only posts with featured images
								</label> -->
								<label class="radio-wrapper">
									Year
									<input type="radio" name="date" value="ASC" /> <i class="fas fa-chevron-up"></i>
									<input type="radio" name="date" value="DESC" /> <i class="fas fa-chevron-down"></i>
								</label>
								<input type="hidden" name="action" value="sortlistings">
								<button>Update</button>
							</form>
							<?php
							if( current_user_can('mepr-active','rule:37') && !current_user_can('mepr-active','membership:1416') ) {
								echo '<a class="button inverted" id="submitalisting" href="/members/submit-a-listing">Submit a Listing</a>';
							}
							?>
						</div>

						<?php
						// Regular Post
						} else {
							// Do Nothing
						} ?>

						<div id="response">
							<?php
							$posttype = get_queried_object()->name;
							/* Start the Loop */
							$i = 0;
							while ( have_posts() ) : the_post();

								echo '<div class="' . $posttype . '-list-item">';
								if ( $posttype === 'listing' ) {
									get_template_part('template-parts/listing');
								} elseif ( $posttype === 'opportunity' ) {
									get_template_part('template-parts/opportunity');
								} else { ?>
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
									  <?php echo '<h2 id="post-' . get_the_ID() . '">' . get_the_title() . '</h2>'; ?>
									</a> <?php
								}
								echo '</div>';
								if ( $posttype === 'listing' ) {
									switch( $i ) {
										case 2:
											insert_ad( get_theme_mod('feature_listings_dealer'), get_theme_mod('feature_listings_dealer_text') );
											break;
										case 8:
											insert_ad( get_theme_mod('feature_listings_industry'), get_theme_mod('feature_listings_industry_text') );
											break;
									}
								}
								$i++;
							endwhile; ?>
						</div>

						<div class="post-response">

							<div class="loaderwrapper">
								<img src="<?php echo get_stylesheet_directory_uri() . '/images/ajax-loader.gif'; ?>">
							</div>

							<?php
								if (  $wp_query->max_num_pages > 1 ) :
									echo '<a class="button" style="margin-right:2em;" id="loadmore"><i class="fas fa-arrow-to-bottom"></i> Load More...</a>';
								endif;

						//	} ?>

						</div>

				</article>

				<?php
        else :

          echo 'Nothing Found Matching Your Criteria';

        endif;
        ?>
      </section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

// Localize loadmore.js with PHP variables
global $wp_query;
wp_register_script( 'loadmore', get_stylesheet_directory_uri() . '/js/loadmore.min.js', array('jquery'), '20210212' );
// we have to pass parameters to loadmore.js script but we can get the parameters values only in PHP
wp_localize_script( 'loadmore', 'loadmore_params', array(
	'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
	'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
	'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
	'max_page' => $wp_query->max_num_pages
) );
wp_enqueue_script( 'loadmore' );

get_footer();

get_template_part( 'template-parts/resize-hero' );
