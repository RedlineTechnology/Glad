<?php
/**
 * Template part for displaying Member's Navigation Menu
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ta
 */

// DISPLAY INDUSTRY MEMBER LINKS
if( current_user_can('mepr-active','membership:20,247,587,589,1020') ):

		echo '<nav class="member-nav">';
			wp_nav_menu( array(
				'theme_location' => 'member-menu-1',
				'menu_id'        => 'industry-member-menu'
			) );
		echo '</nav>';

endif;

// DISPLAY DEALER MEMBER LINKS
if( current_user_can('mepr-active','membership:19,232,580,588') ):

	echo '<nav class="member-nav">';
		wp_nav_menu( array(
			'theme_location' => 'member-menu-2',
			'menu_id'        => 'dealer-member-menu'
		) );
	echo '</nav>';

endif;

?>
