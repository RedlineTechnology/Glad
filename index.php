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

				<?php // UPPER HERO
				if( $posttype === 'opportunity' || $posttype === 'listing') { ?>
				<div class="<?php echo $posttype; ?>-hero"> <?php
					if ( $posttype === 'opportunity' ) { ?>
						<h1>Services</h1>
						<p>Discover services and discounts offered by other members.</p>
					<?php }
					if ( $posttype === 'listing' ) { ?>
						<h1>Listings</h1>
						<p>Aircraft Listed by Trusted GLADA Members.</p>
						<?php
						wp_enqueue_script( 'autocomplete', get_template_directory_uri() . '/js/autocomplete.min.js', array('jquery'), '20210621', true);
					} ?>
					<div class="searchwrapper cursor">
						<form action="#" method="POST" class="search" id="searchform">
							<input type="text" id="searchfield" name="searchfield" value="" placeholder="What are you looking for?"><!--<i class="blinky"></i>-->
							<input type="hidden" name="action" value="listingsearch">
							<button id="searchsubmit" class="searchsubmit hidden" type="submit"><i class="fas fa-search"></i></button>
						</form>
					</div>
				</div>
				<?php }

      	if ( have_posts() ) : ?>
          <article class="the-content">
					<!-- UPPER POST AREA --> <?php

					// OPPORTUNITIES
					if ( $posttype === 'opportunity' ) {

						echo '<div id="dealerservices" class="dealer_services">';
							echo get_dealers_with_services( '', 5 );
						echo '</div>';

						// LISTINGS
					} elseif ( $posttype === 'listing' ) { ?>

						<div class="upper" style="display:none;">
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
						</div>

						<?php
						// Regular Post
					} else {
						// Do Nothing
					}

					// if( is_dealer() ) {
					// 	echo '<a class="button inverted" id="submitalisting" href="/members/submit-a-listing">Submit a Listing</a>';
					// } ?>

					<!-- MAIN POST AREA -->
					<div id="response"> <?php
						/* Start the Loop */
						$i = 0;
						while ( have_posts() ) : the_post();

							$expanded = '';
							if( $i == 0 ) { $expanded = ' expanded'; }

							if ( $posttype === 'listing' || $posttype === 'opportunity' ) {
								echo '<div class="list-item-' . $posttype . $expanded . '">';
									get_template_part('template-parts/' . $posttype );
							} else {
								echo '<div class="' . $posttype . '-list-item">'; ?>
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

	<!-- dynamic receptacle for post content -->
	<div id="postbox"></div>

<?php

// Localize loadmore.js with PHP variables
global $wp_query;
wp_register_script( 'search', get_stylesheet_directory_uri() . '/js/search.js', array('jquery'), '20210624' );
// we have to pass parameters to loadmore.js script but we can get the parameters values only in PHP
wp_localize_script( 'search', 'query_params', array(
	'ajaxurl' 			=> site_url() . '/wp-admin/admin-ajax.php',
	'posts' 				=> json_encode( $wp_query->query_vars ),
	'manual'				=> false,
	'current_page' 	=> get_query_var( 'paged' ) ?: 1,
	'max_page' 			=> $wp_query->max_num_pages,
	'input' 				=> '#searchfield',
	'output' 				=> '#response',
	'secondary'			=> '#dealerservices',
) );
wp_enqueue_script( 'search' );

get_footer();

get_template_part( 'template-parts/resize-hero' );
