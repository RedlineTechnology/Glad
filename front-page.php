<?php
/**
 * Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _glad
 */

get_header();
?>

<div class="cssgridwarning">
	<h2><i class="fas fa-exclamation-triangle"></i>Your Browser is out of date!</h2>
	<h4>Your browser is not compatible with this website, and as a result your stay here may not live up to the great experience we have designed for you. To experience this website as it was intended, please update your browser to the most current version.</h4>
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
			<p>The Global Licensed Aircraft Dealer Association (GLAD) was formed to be a common force helping to influence and support growth in the Corporate Aviation Industry and to provide a foundation for Industry Leaders to network and grow their businesses with integrity.</p>
		</div>
		<img id="weareglad-img" src="<?php echo get_stylesheet_directory_uri() ?>/images/weareglad.png">
		<?php get_template_part('template-parts/nav') ?>
	</div>
</section>

<!-- <div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php //esc_html_e( 'Skip to content', '_glad' ); ?></a>

	<div id="content" class="site-content"> -->

<section class="hero row">
</section>

<section id="about-us" class="about-us">
	<div class="right">
		<img id="aboutus-img" data-enllax-ratio="-0.6" data-enllax-type="foreground" src="<?php echo get_stylesheet_directory_uri() ?>/images/aboutus.png">
		<div class="info">
			<p>GLAD seeks to be a leading advocate in the fair business of buying, selling and leasing corporate aircraft. The association’s goal is to be a resource and leader in developing standards for efficient, effective and ethical business practices in buying and selling aircraft.  GLAD provides a foundation for professional development, welcoming the exchange of information amongst its members for the purpose of business growth and integrity.</p>
		</div>
	</div>
	<div class="left padded">
		<h3 class="section-title">Who we are</h3>
		<p>Our association is composed of Licensed Corporate Aircraft Dealers and Brokers, salespeople, management companies, appraisers and others engaged in the Corporate Aircraft Resale industry.</p>
		<div id="people" class="people">
			<?php
		    $args = array(
		      'post_type'       => 'people',     // searching the 'testimonials'
		      'post_status'     => 'publish',          // we only want published posts
		      'orderby'         => 'title',            // we will sort posts by title
		      'order'           => 'ASC',              // descending order
		      'nopaging'        => true
		    );

		    $query = new WP_Query( $args ); // make the query
		    if( $query->have_posts() ) :
		      // Here's the thing!
		      while( $query->have_posts() ): $query->the_post();

					  $headshot = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
						$person = get_post_meta( $post->ID, 'person_fields', true );

		        echo'<div class="person">';
						  echo '<div class="headshot" style="background-image:url(' . $headshot . ');"></div>';
		          echo '<div class="bubble"><div class="nametitle"><h2 class="name">' . get_the_title() . '</h2><h2 class="title">' . $person['jobtitle'] . '</h2></div><p>' . apply_filters( 'the_content', get_the_content() ) . '</p></div>';
		        echo '</div>';

		      endwhile;
		    endif;

		    // Now reset all the things before we do it again
		    $query = null;
		    $args = null;
		    wp_reset_postdata();
		  ?>
		</div>
	</div>
</section>

<section id="about-lower" class="about-lower">
	<div class="left padded" data-enllax-ratio="-0.05" data-enllax-type="foreground">
		<h3 class="section-title">Benefits & Services</h3>
		<p>GLAD serves its members by setting and enforcing the standard for ethical practice within the industry</p>
		<p>GLAD supports the development of innovative ideas and collaboration on improving business.</p>
		<p>The value of membership in GLAD is clear, fundamental and positive.</p>
		<img class="article-img" src="<?php echo get_stylesheet_directory_uri() ?>/images/aboutus-pilot.jpg">
	</div>
	<div class="right">
		<a class="button" href="/members">Become a Member</a>
	</div>
</section>

<section class="values">
	<div class="right">
		<img id="ourvalues-img" data-enllax-ratio="-0.35" data-enllax-type="foreground" src="<?php echo get_stylesheet_directory_uri() ?>/images/ourvalues.png">
	</div>
	<div class="left padded">
		<div data-slick='{"autoplay": true, "autoplaySpeed": 6000, "arrows": false, "dots": true}' class="value-slider">
			<div class="value">
				<h3 class="section-title">Insight</h3>
				<p>We are guided by a deep understanding and sensitivity to our members’ needs and concerns and stay focused on removing barriers to their success.</p>
			</div>
			<div class="value">
				<h3 class="section-title">Collaboration</h3>
				<p>We believe that by sharing expertise, ideas and resources with others, we can build relationships and solutions that will advance the industry. GLAD seeks to find best in brand companies, partners or platforms, rather than build or develop it ourselves.</p>
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
	<script>
	jQuery(document).ready( function($){
			$('.value-slider').slick();
	});
	</script>
</section>

<!-- Custom Footer for Front Page -->
<?php wp_enqueue_script( 'sticky-home', get_template_directory_uri() . '/js/sticky-home.js', array('jquery'), '20190713', true ); ?>
<footer class="footer-hero">
	<div class="left">
		<img src="<?php echo get_stylesheet_directory_uri() . '/images/GLAD_logo_sm.png'; ?>" />
	</div>
	<div class="right">
		<div class="footer-contactinfo">
			<h3 class="section-title">Contact</h3>
			<p class="email"><a href="mailto:<?php echo get_theme_mod('contact_email'); ?>"><?php echo get_theme_mod('contact_email'); ?></a></p>
			<p class="phone"><?php echo get_theme_mod('phone_number'); ?></p>
			<p class="address"><?php echo get_theme_mod('address_line1') . ', ' . get_theme_mod('address_line2') . '<br>' . get_theme_mod('city-st') . ', ' . get_theme_mod('zipcode'); ?></p>
		</div>
		<div class="footer-nav">
			<nav>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-3',
						'menu_id'        => 'footer-menu',
					) );
					?>
			</nav>
		</div><!-- .footer-nav -->
		<div class="nbaa"></div>
		<div class="copyright">
			<p>All Content Copyright &copy; <?php echo date("Y") . ' ' . get_bloginfo( 'name' ); ?></p>
		</div>
	</div>
</footer>

</div><!-- #page-wrapper -->

<script>
document.addEventListener('DOMContentLoaded', function(){
	var query = Modernizr.mq('(min-width: 48em)');
	 if (query) {
	   var trigger = new ScrollTrigger();
		 jQuery('#page-wrapper').enllax();
	 }
});
</script>

<?php wp_footer(); ?>

</body>
</html>
