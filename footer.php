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

 	get_template_part('template-parts/nav');

	if( !is_home() ): ?>
		<?php wp_enqueue_script( 'stickynav', get_template_directory_uri() . '/js/sticky-nav.min.js', array('jquery'), '20190713', true ); ?>
		<div class="footer-logo">
			<a href="/"><img src="<?php echo get_stylesheet_directory_uri() . '/images/GLADA_logo_sm.png'; ?>" /></a>
		</div>
	<?php endif; ?>

	<footer id="footer" class="site-footer">
		<div class="info">
			<div class="footer-contactinfo">
				<h3 class="section-title">Contact</h3>
				<p class="email"><a href="mailto:<?php echo get_theme_mod('contact_email'); ?>"><?php echo get_theme_mod('contact_email'); ?></a></p>
				<p class="phone"><?php echo get_theme_mod('phone_number'); ?></p>
				<p class="address"><?php echo get_theme_mod('address_line1') . ', ' . get_theme_mod('address_line2') . '<br>' . get_theme_mod('city-st') . ', ' . get_theme_mod('zipcode'); ?></p>
			</div>
			<?php if ( get_theme_mod('display_social_media') ) { ?>

				<div class="footer-social">
					<ul>
						<?php if( get_theme_mod('facebook_url') ){ ?> <li><a href="<?php echo get_theme_mod('facebook_url') ?>"><i class="fab fa-facebook-f"></i></a></li> <?php } ?>
						<?php if( get_theme_mod('linkedin_url') ){ ?> <li><a href="<?php echo get_theme_mod('linkedin_url') ?>"><i class="fab fa-linkedin"></i></a></li> <?php } ?>
						<?php if( get_theme_mod('youtube_url') ){  ?> <li><a href="<?php echo get_theme_mod('youtube_url')  ?>"><i class="fab fa-youtube"></i></a></li> <?php } ?>
						<?php if( get_theme_mod('twitter_url') ){  ?> <li><a href="<?php echo get_theme_mod('twitter_url')  ?>"><i class="fab fa-twitter"></i></i></a></li> <?php } ?>
						<?php if( get_theme_mod('insta_url') ){    ?> <li><a href="<?php echo get_theme_mod('insta_url')    ?>"><i class="fab fa-instagram"></i></a></li> <?php } ?>
					</ul>
				</div>

			<?php } ?>
			<div class="footer-nav">
				<nav>
						<?php
						wp_nav_menu( array(
							'theme_location' => 'menu-3',
							'menu_id'        => 'footer-menu',
						) );
						?>
				</nav>
				<div class="footer-nav-logos">
					<div class="nbaa"></div>
					<div class="ebaa"></div>
					<div class="hai"></div>
				</div>
			</div><!-- .footer-nav -->
			<div class="copyright">
				<p>All Content Copyright &copy; <?php echo date("Y") . ' ' . get_bloginfo( 'name' ); ?></p>
        <?php

        if ( method_exists( 'user_switching', 'maybe_switch_url' ) ) {
          $old_user = user_switching::get_old_user();
          if( $old_user ) {
            $url = user_switching::maybe_switch_url( $old_user );
            $roles = $old_user->roles;
            if ( $url && in_array( 'administrator', $roles, true) ) {
              printf(
                '<a href="%1$s">Switch to %2$s</a>',
                $url,
                $old_user->display_name
              );
            }
          }
        }

        ?>
			</div>
		</div>
	</footer>

</div><!-- #page-wrapper -->

<?php
if( current_user_can('mepr-active','membership:1416') && !current_user_can( 'manage_options' ) ):
	wp_enqueue_script( 'freetrial', get_template_directory_uri() . '/js/freetrial.min.js', array('jquery'), '20210218', true);
endif;
?>

<?php wp_footer(); ?>

</body>
</html>
