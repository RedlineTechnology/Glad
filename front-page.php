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
 ?>

 <div class="textpreview" style="display:none;">
 	<h2>Welcome to GLADA</h2>
 	<h4>The Global Licensed Aircraft Dealer Association (GLADA) was formed to be a common force helping to influence and support growth in the Business Aviation Industry and to provide a foundation for Industry Leaders to network and grow their businesses with integrity.</h4>
 </div>

 <div class="cssgridwarning alert">
 	<h2><i class="fas fa-exclamation-triangle"></i>Your Browser is out of date!</h2>
 	<h4>You are using an outdated browser. Please update your browser to the most current version.</h4>
 </div>

 <section class="front-page-hero">
 	<div class="left">
 		<div class="logo-hero"></div>
 		<div class="values-hero">
 			<ul>
 				<li>Insight</li>
 				<li>Collaboration</li>
 				<li>Stewardship</li>
 			</ul>
 			<ul>
 				<li>Transparency</li>
 				<li>Resilience</li>
 				<li>Inclusivity</li>
 			</ul>
 		</div>
 		<div class="lower-arrow"></div>
 	</div>
 	<div class="right">
 		<div class="info-hero" data-enllax-ratio="1" data-enllax-type="foreground">
 			<p>The Global Licensed Aircraft Dealer Association (GLADA) was formed to be a common force helping to influence and support growth in the Business Aviation Industry and to provide a foundation for Industry Leaders to network and grow their businesses with integrity.</p>
 		</div>
 		<img id="weareglad-img" src="<?php echo get_stylesheet_directory_uri() ?>/images/weareglada.png">
 	</div>
 </section>

 <section id="whoweare" class="front-page-login">
	 <div class="info-wrapper">
		 <h3 class="section-title">Of the Members, For the Members</h3>
		 <p>Our Association is comprised of Licensed US Business Aircraft Dealers and Brokers, International Dealers and Brokers and other Industry Professionals engaged in the Business Aviation Industry.</p>
	</div>
 	<div class="login-wrapper">
 		<a href="/members" class="button">Become a Member</a><a href="/login" class="button inverted">Sign In</a>
 	</div>
 </section>

 <section id="about-us" class="about-us">
 	<div class="left padded">
 		<h3 style="margin-top:2em;" class="section-title">Our Board</h3>
 		<div id="people" class="people righty">
 			<div class="people-left">
 			<p class="section-subtitle">Board of Directors</p>
 			<?php
 		    $args = array(
 		      'post_type'       => 'people',
 		      'post_status'     => 'publish',
 		      'orderby'         => 'date',
 		      'order'           => 'ASC',
 		      'nopaging'        => true
 		    );

 		    $query = new WP_Query( $args ); // make the query
 		    if( $query->have_posts() ) :
 		      // Here's the thing!
          $addendum = '';
 		      while( $query->have_posts() ): $query->the_post();

 					  $headshot = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
 						$person = get_post_meta( $post->ID, 'person_fields', true );

 						if ( $person['jobtitle'] === 'Board of Directors' ) {
 							echo'<div class="person">';
 			          echo '<div class="bubble"><div class="nametitle"><h2 class="name">' . get_the_title() . ' <span>// ' . $person['location'] . '</span></h2></div><p>' . apply_filters( 'the_content', get_the_content() ) . '</p></div>';
 			        echo '</div>';
 						} else {
 							$addendum .= '<div class="person"><p class="section-subtitle">' . $person['jobtitle'] . '</p><div class="bubble"><div class="nametitle"><h2 class="name">' . get_the_title() . '</h2></div><p>' . apply_filters( 'the_content', get_the_content() ) . '</p></div></div>';
 						}

 		      endwhile;

 					echo '</div><div class="people-right">' . $addendum . '</div>';

 		    endif;

 		    // Now reset all the things before we do it again
 		    $query = null;
 		    $args = null;
 		    wp_reset_postdata();
 				wp_reset_query();
 		  ?>
 		</div>
 	</div>
 	<div class="right">
 		<img id="aboutus-img" data-enllax-ratio="-0.6" data-enllax-type="foreground" src="<?php echo get_stylesheet_directory_uri() ?>/images/aboutus.png">
 		<div class="info">
 			<p>GLADA strives to be the leading advocate in the fair business of buying, selling and leasing business aircraft. GLADA champions as a resource and leader in developing standards for efficient, effective and principled business practices in buying and selling aircraft. GLADA provides a foundation for professional development, welcoming the exchange of information amongst its members for the purpose of business growth and integrity.</p>
 			<p><a href="/aboutus/code-of-conduct">Read our Professional Code of Conduct</a></p>
 		</div>
 	</div>
 </section>

 <section class="trusted">

 		<?php
 		// TESTIMONIALS
 		$test_args = array(
 			'post_type'			=> 'testimonials',
 			'post_status'   => 'publish',
 			//'author__in'		=> array( 7 )
 		);

 		$test_query = new WP_Query( $test_args );
 		if( $test_query->have_posts() ) :
 			while ( $test_query->have_posts() ) : $test_query->the_post();

 				echo '<div class="testimonial">';
 					the_content();

 					$author_id = get_the_author_meta('ID');
 					$fname = get_the_author_meta('first_name');
 					$lname = get_the_author_meta('last_name');
 					$company = get_user_meta($author_id, 'mepr_company', true);

 					echo '<h3>- ' . $fname . ' ' . $lname . ', ' . $company . '</h3>';
 				echo '</div>';

 			endwhile;
 		endif;
 		?>

 	<h3 class="section-title">Trusted by</h3>

 		<?php
 		/* Sponsor Slider */
 		wp_enqueue_script( 'logo-slider', get_template_directory_uri() . '/js/logo-slider.min.js', array('slick'), '20190224', true);

 		$args = array(
 			'role__not_in' => array( 'Applicant', 'Managed', 'Administrator' ),
 			'role__in' => array('Industry','Dealer'),
 			'number' => 100
 		);
 		$user_query = new WP_User_Query( $args ); ?>

 		<div data-slick='{"autoplay": true, "autoplaySpeed": 4000}' class="logo-slider">

 		<?php
 		// User Loop
 		if ( ! empty( $user_query->get_results() ) ) {
 			foreach ( $user_query->get_results() as $user ) {

 				$id = $user->ID;
 			  $contact = get_user_meta( $id ); // Get Regular User Info
 				// $member = new MeprUser( $id ); // Get Membership User Info
 				//
 				// $active_ids = $member->active_product_subscriptions('ids'); // self-explanatory
 				// if( !empty )

 				$logo = isset($contact['memberpress_avatar']) ? $contact['memberpress_avatar'][0] : false;
 				$newlogo = bp_attachments_get_attachment( 'url', array( 'item_id' => $id ) );

 				if ( $newlogo ) {
 					echo '<div class="company newlogo"><img src="' . $newlogo . '" /></div>';
 				} elseif ( $logo ) {
 					echo '<div class="company"><img src="' . wp_get_attachment_url( $logo ) . '" /></div>';
 				}
 			}
 		} ?>

 		</div>
 		<p class="seebelow"><a href="#our-members">See Full List</a></p>

 </section>

 <section class="values">
 	<div class="right">
 		<img id="ourvalues-img" data-enllax-ratio="-0.35" data-enllax-type="foreground" src="<?php echo get_stylesheet_directory_uri() ?>/images/ourvalues.png">
 	</div>
 	<div class="left padded">
 		<div>
 			<div class="value">
 				<h3 class="section-title">Insight</h3>
 				<p>We are guided by a deep understanding and sensitivity to our members’ needs and concerns and stay focused on removing barriers to their success.</p>
 			</div>
 			<div class="value">
 				<h3 class="section-title">Collaboration</h3>
 				<p>We believe that by sharing expertise, ideas and resources with others, we can build relationships and solutions that will advance the industry. GLADA seeks to find the best in brand companies, partners or platforms, rather than build or develop it ourselves.</p>
 			</div>
 			<div class="value">
 				<h3 class="section-title">Transparency</h3>
 				<p>We strive for open, two-way communication with members to inform our actions and decisions on their behalf.</p>
 			</div>
 			<div class="value">
 				<h3 class="section-title">Resilience</h3>
 				<p>To lead effectively, we must adapt to our changing environment and be proactive in shaping a future in which our members can thrive.</p>
 			</div>
 			<div class="value">
 				<h3 class="section-title">Inclusivity</h3>
 				<p>We believe that every voice has value in shaping the work we do, and that by embracing our differences, we will learn more, be stronger and develop better solutions.</p>
 			</div>
 		</div>
 	</div>
 </section>

 <section id="our-members" class="members">
 	<h3 class="section-title">Our Members</h3>
 	<div id="members">
 		<?php
 		// User Loop
 		if ( ! empty( $user_query->get_results() ) ) {
 			foreach ( $user_query->get_results() as $user ) {

 				$id = $user->ID;
 				$contact = get_user_meta( $id ); // Get Regular User Info
 				$logo = isset($contact['memberpress_avatar']) ? $contact['memberpress_avatar'][0] : false;
 				$newlogo = bp_attachments_get_attachment( 'url', array( 'item_id' => $id ) );
 				$name = $contact['first_name'][0] . ' ' . $contact['last_name'][0];
 				$comp = $contact['mepr_company'][0];
 				$url = $contact['mepr_company_website'][0];

 				echo '<div class="single">
 					<a href="' . $url . '">';
 						if ( $newlogo ) {
 							echo '<img src="' . $newlogo . '" />';
 						} elseif ( $logo ) {
 							echo '<img src="' . wp_get_attachment_url( $logo ) . '" />';
 						}
 					echo '</a>';
 					echo '<h4>' . $comp . '<h4>';
 				echo '</div>';
 			}
 		} ?>
 	</div>
 </section>

 <section class="cta">
 	<a class="button" href="/members">Become a Member</a>
 </section>

 <script>
 document.addEventListener('DOMContentLoaded', function(){
 	var query = Modernizr.mq('(min-width: 48em)');
 	 if (query) {
 	   var trigger = new ScrollTrigger();
 		 jQuery('#page-wrapper').enllax();
 	 }
 });
 </script>

 <?php
 get_footer();
