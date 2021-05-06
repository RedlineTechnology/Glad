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

<div class="textpreview" style="display:none;">
	<h2>Welcome to GLADA</h2>
	<h4>The Global Licensed Aircraft Dealer Association (GLADA) was formed to be a common force helping to influence and support growth in the Business Aviation Industry and to provide a foundation for Industry Leaders to network and grow their businesses with integrity.</h4>
</div>

<div class="cssgridwarning alert">
	<h2><i class="fas fa-exclamation-triangle"></i>Your Browser is out of date!</h2>
	<h4>You are using an outdated browser. Please update your browser to the most current version.</h4>
</div>

<div class="optin-banner">
	<div>
		Get the GLADA Newsletter!
	</div>
	<?php echo do_shortcode( '[wpforms id="1267"]' ); ?>
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
		<?php get_template_part('template-parts/nav') ?>
	</div>
</section>

<section class="front-page-login">
	<div class="login-wrapper">
		<a href="/login" class="button">Member Login</a>
	</div>
</section>

<?php
get_footer();
