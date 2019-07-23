<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _glad
 */

?>

	<?php get_template_part('template-parts/nav'); ?>
	<?php wp_enqueue_script( 'stickynav', get_template_directory_uri() . '/js/sticky-nav.min.js', array('jquery'), '20190713', true ); ?>
	<div class="footer-logo">
		<a href="/"><img src="<?php echo get_stylesheet_directory_uri() . '/images/GLAD_logo_sm.png'; ?>" /></a>
	</div>
	<footer id="footer" class="site-footer">
		<div class="info">
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
			<div class="copyright">
				<p>All Content Copyright &copy; <?php echo date("Y") . ' ' . get_bloginfo( 'name' ); ?></p>
			</div>
		</div>
	</footer>

</div><!-- #page-wrapper -->

<?php wp_footer(); ?>

</body>
</html>
