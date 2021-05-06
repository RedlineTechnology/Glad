<?php
/**
 * Template part for displaying Mobile Navigation Menu
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _glad
 */
?>

<div id="left-tray" class="left tray">
	<?php echo '<img src="' . get_stylesheet_directory_uri() . '/images/corner-logo-encircled.png" />'; ?>
	<nav id="mobilenav">
		<i id="lefttray-close" class="fal fa-times"></i>
		<?php if( !is_home() ) { ?>
			<div class="menu-home-menu-container">
				<ul id="home-menu-mobile" class="menu">
					<li id="menu-item-00" class="home menu-item menu-item-type-home menu-item-object-home menu-item-00">
						<a href="/">Home</a>
					</li>
				</ul>
			</div>
		<?php }
		if( is_user_logged_in() ) {
			if ( current_user_can('mepr-active','rule:37') ) {
				wp_nav_menu( array(
					'theme_location' => 'menu-2',
					'menu_id'        => 'member-menu',
				) );
			}
		} else {
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'main-menu',
			) );
			?>
			<div class="menu-login-menu-container">
				<ul id="login-menu-mobile" class="menu">
					<li id="menu-item-login" class="login menu-item menu-item-type-login menu-item-object-home menu-item-login">
						<a href="/login">Login</a>
					</li>
				</ul>
			</div>
		<?php }
		wp_nav_menu( array(
			'theme_location' => 'menu-3',
			'menu_id'        => 'footer-menu',
		) );
		?>
	</nav>
</div>
<div id="nav-toggle">
	<a href="#" id="lefttray-toggle"><i class="fal fa-bars"></i></a>
</div>
