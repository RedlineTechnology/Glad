<?php
/**
 * Template part for displaying Member's Navigation Menu
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ta
 */

// DISPLAY MEMBER LINKS
if( current_user_can('mepr-active','rule:37') ):

	echo '<nav class="members-nav">';
		echo '<a href="/"><img src="' . get_stylesheet_directory_uri() . '/images/corner-logo-encircled.png" /></a>';
		wp_nav_menu( array(
			'theme_location' => 'menu-2',
			'menu_id'        => 'members-menu'
		) );
	echo '</nav>';

endif;

?>
