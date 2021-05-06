<?php
  /**
  * The Main Blog Template
  *
  * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
  *
  * @package _glad
  */

get_header();

$header_img = '/images/bg-engine.jpg'; ?>

	<section class="hero" style="background-image: url(' <?php echo get_stylesheet_directory_uri() . $header_img; ?>')">
		<?php echo '<div class="title-wrapper"><h1 id="title">Library</h1></div>'; ?>
	</section>

	<div id="archive" class="content-area">
		<main id="main" class="site-main">

			<?php get_template_part('template-parts/nav-members'); ?>

      <section class="archive">

				<?php
				// Get Posts
				$args = array(
					'post_type'			=> 'post',
					'orderby'       =>  'date',
					'order'         =>  'ASC',
					'nopaging'			=> 	true
				);
				$posts = new WP_Query( $args );

      	if ( have_posts() ) : ?>
          <article class="the-content">

						<?php load_accordion_tabs(); ?>

						<nav class="library accordion-tabs">
							<ul class="accordion-tab-headings">
								<li><a href="#section-1"><span>Documents</span></a></li>
								<li><a href="#section-2"><span>Meetings & Webinars</span></a></li>
								<li><a href="#section-3"><span>Referrals</span></a></li>
							</ul>

							<?php
								// The following structure is required for the script to build the accordion
								// <section>
								//   <h1>header</h1>
								//   <div>content as immediate sibling</div>
								// </section>
							?>

							<section id="section-1">
								<h2 class="section-title">Documents</h2>
								<div class="docs container">
									<?php
									/* Start the Loop */
									while ( $posts->have_posts() ) : $posts->the_post();

										$media = get_attached_media( '', get_the_ID() );
										foreach( $media as $attachment ) {
											$url = $attachment->guid;
											$type = $attachment->post_mime_type;
										}
										$icon = $type == 'application/pdf' ? 'pdf' : 'doc';

										echo '<div class="document-list-item ' . $icon . '">'; ?>
										<a style="display:inline-block;" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"> <?php
									  	echo '<p id="post-' . get_the_ID() . '">' . get_the_title() . '</p>'; ?>
										</a> <?php
										if( $media ) {
											echo '<a class="download" href="' . $url . '" download>Download File</a>';
										}
										echo'</div>';

									endwhile; ?>
								</div>
							</section>

							<section id="section-2">
								<h2 class="section-title">Meetings & Webinars</h2>
								<div class="video container">
									<!-- item -->
									<div class="meeting-list-item meeting">
										<p class="replay"><a href="#" class="jsfirmcareers" data-featherlight="#jsfirmcareers"><i class="fas fa-play"></i></a>JSfirm.com Webinar - Careers in Aviation</p>
										<a href="#" class="jsfirmcareers" data-featherlight="#jsfirmcareers">Watch Now</a>
									</div>
									<div class="featherlight" id="jsfirmcareers">
										<video controls preload="none" style="width:600px; max-width: 100%; height:380px;">
											<source src="https://www.glada.aero/assets/meetings/jsfirm_careers_in_aviation.mp4" type="video/mp4">
											Your browser does not support the HTML5 video tag.
										</video>
									</div>
									<!-- item -->
									<div class="meeting-list-item meeting">
										<p class="replay"><a href="#" class="glada0720" data-featherlight="#glada0720"><i class="fas fa-play"></i></a>GLADA Zoom Call - July 2020</p>
										<a href="#" class="glada0720" data-featherlight="#glada0720">Watch Now</a>
									</div>
									<div class="featherlight" id="glada0720">
										<video controls preload="none" style="width:600px; max-width: 100%; height:380px;">
											<source src="https://www.glada.aero/assets/meetings/glada-mtg-0720.mp4" type="video/mp4">
											Your browser does not support the HTML5 video tag.
										</video>
									</div>
									<!-- item -->
									<div class="meeting-list-item meeting">
										<p class="replay"><a href="#" class="glada0920" data-featherlight="#glada0920"><i class="fas fa-play"></i></a>GLADA Zoom Call - September 2020</p>
										<a href="#" class="glada0920" data-featherlight="#glada0920">Watch Now</a>
									</div>
									<div class="featherlight" id="glada0920">
										<video controls preload="none" style="width:600px; max-width: 100%; height:380px;">
											<source src="https://www.glada.aero/assets/meetings/glada-mtg-0920.mp4" type="video/mp4">
											Your browser does not support the HTML5 video tag.
										</video>
									</div>
									<!-- item -->
									<div class="meeting-list-item webinar">
										<p class="replay"><a href="#" class="vrefmarket" data-featherlight="#vrefmarket"><i class="fas fa-play"></i></a>VREF Webinar: Spring Market Forecast</p>
										<a href="#" class="vrefmarket" data-featherlight="#vrefmarket">Watch Now</a>
									</div>
									<div class="featherlight" id="vrefmarket">
										<video controls preload="none" style="width:600px; max-width: 100%; height:380px;">
											<source src="https://www.glada.aero/assets/vref/vref_webinar_marketforecast.mp4" type="video/mp4">
											Your browser does not support the HTML5 video tag.
										</video>
									</div>
									<!-- item -->
									<div class="meeting-list-item webinar">
										<p class="replay"><a href="#" class="vrefrecovery" data-featherlight="#vrefrecovery"><i class="fas fa-play"></i></a>VREF Webinar: Aircraft Recovery</p>
										<a href="#" class="vrefrecovery" data-featherlight="#vrefrecovery">Watch Now</a>
									</div>
									<div class="featherlight" id="vrefrecovery">
										<video controls preload="none" style="width:600px; max-width: 100%; height:380px;">
											<source src="https://www.glada.aero/assets/vref/vref_webinar_recovery.mp4" type="video/mp4">
											Your browser does not support the HTML5 video tag.
										</video>
									</div>
									<!-- item -->
									<div class="meeting-list-item webinar">
										<p class="replay"><a href="#" class="vrefavionics" data-featherlight="#vrefavionics"><i class="fas fa-play"></i></a>VREF Webinar: Avionics</p>
										<a href="#" class="vrefavionics" data-featherlight="#vrefavionics">Watch Now</a>
									</div>
									<div class="featherlight" id="vrefavionics">
										<video controls preload="none" style="width:600px; max-width: 100%; height:380px;">
											<source src="https://www.glada.aero/assets/vref/vref_webinar_avionics.mp4" type="video/mp4">
											Your browser does not support the HTML5 video tag.
										</video>
									</div>
									<!-- item -->
									<div class="meeting-list-item webinar">
										<p class="replay"><a href="#" class="vrefcovid" data-featherlight="#vrefcovid"><i class="fas fa-play"></i></a>VREF Webinar: How to Maintain Productivity During the Covid-19 Pandemic</p>
										<a href="#" class="vrefcovid" data-featherlight="#vrefcovid">Watch Now</a>
									</div>
									<div class="featherlight" id="vrefcovid">
										<video controls preload="none" style="width:600px; max-width: 100%; height:380px;">
											<source src="https://www.glada.aero/assets/vref/vref_webinar_0420.mp4" type="video/mp4">
											Your browser does not support the HTML5 video tag.
										</video>
									</div>
								</div>
							</section>

							<section id="section-3">
								<h2 class="section-title">Maintenance Referrals</h2>
								<div class="referral container">
									<?php
									$args = array(
										'post_type'			=> 'referrals',
										'orderby'       =>  'title',
										'order'         =>  'ASC',
										'nopaging'			=> 	true
									);
									$referral_query = new WP_Query( $args );

									echo '<a class="addnew" href="/members/submit-a-referral/">Submit a Maintenance Referral</a>';

									if( $referral_query->have_posts() ) :
										echo '<ul>';
										while( $referral_query->have_posts() ): $referral_query->the_post();
											$type = get_the_terms( $post->ID, 'referraltype');
											$title = get_the_title( $post->ID );
											$contact = get_post_meta( $post->ID, 'contact', true );
											$url = get_post_meta( $post->ID, 'url', true );
											$location = get_post_meta( $post->ID, 'location', true );
											$name = get_the_author_meta( 'user_firstname' ) . ' ' . get_the_author_meta( 'user_lastname' );
											?>
											<li class="referral-list-item" data-post="<?php echo $post->ID; ?>">

													<h4 class="title <?php echo $type[0]->slug; ?>">
														<a href="<?php echo $url;?>"><i class="fas fa-link"></i><?php echo $title; ?></a>
													</h4>
													<h6><?php echo $location; ?> - Contact: <?php echo $contact ?></h6>
													<div class="blurb">
														<?php echo the_content(); ?>
													</div>
													<p class="attribution"><span>Referred by: </span><?php echo $name; ?></p>

											</li>
										<?php

										endwhile;
										echo '</ul>';
									endif;
									?>
								</div>
							</section>

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

get_footer();

get_template_part( 'template-parts/resize-hero' );
