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

 wp_reset_postdata();
 wp_reset_query();

 $header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/mplex_header.jpg';

 ?>

 	<div id="primary" class="content-area">
 		<main id="main" class="site-main">

 			<div class="hero section" style="background-image: url(' <?php echo $header_img ?>')">
 				<div class="filter"></div>
 				<div class="content-container">
 					<?php echo '<div class="mobile-hidden"><h1>' . get_the_title( $post->ID ) . '</h1></div>'; ?>
 				</div>
 			</div>

 			<section class="page-content section">

				<div id="google_map">
					<iframe width="100%" height="300" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJ1UWp-RrdToYRllnKj3E-EJo&key=AIzaSyDHCQNgQ7NREbQxvecFaBux5P0lMa24wOE" allowfullscreen></iframe>
				</div>

				<div>
					<?php
					while (have_posts()) : the_post();
						the_content();
					endwhile;
					?>
				</div>

				<center><h2>Texas Motorplex Staff</h2></center>
				<div id="people" class="section">
					<div>
						<?php
						$args = array(
				      'post_type'       => 'people',
				      'post_status'     => 'publish',
				      'orderby'         => 'date',
				      'order'           => 'ASC',
				      'nopaging'        => true,
							'posts_per_page'	=> 20
				    );

						$wp_query = new WP_Query( $args );

						$offset = 0;

						if( $wp_query->have_posts() ) :
							while ( $wp_query->have_posts() ) : $wp_query->the_post();

							$person_info = get_post_meta( $post->ID, 'person_fields', true );

							if ( $person_info['show']=='Yes') :

								echo '<div data-scroll="offset(0,' . $offset . 'px)" class="person animate">
									<h4>' . get_the_title() . '</h4>
									<p>' . $person_info['jobtitle'] . '<br />
										<a href="mailto:' . $person_info['email'] .  '?subject=Texas Motorplex%20General%20Inquiry">' . $person_info['email'] . '</a>
									</p>
								</div>';

								$offset += 15;

							endif;

							endwhile;
						endif;
						wp_reset_postdata();

						?>
					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
