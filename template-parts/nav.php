<?php
/**
 * Template part for displaying Navigation Menu
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ta
 */
?>

<header>
	<nav id="nav-desktop" class="nav-desktop">
		<div id="main-navigation" class="main-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</div>
	</nav><!-- #main-navigation -->
</header>
