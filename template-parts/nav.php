<?php
/**
 * Template part for displaying Navigation Menu
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ta
 */
?>

<header class="<?php if( is_home() ){ echo 'front-page-nav'; }?>">
	<nav id="nav-desktop" class="nav-desktop">
		<div id="main-navigation" class="main-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				if( is_home() ) { ?>
		      <div class="menu-cta-menu-container">
		        <ul id="cta-menu" class="menu">
		          <li class="menu-item nav-button become-a-member"><a href=/members>Become a Member</a></li>
		          <li class="menu-item become-a-member"><a href=/login>Sign In</a></li>
		        </ul>
		      </div> <?php
				}
			?>
		</div>
	</nav><!-- #main-navigation -->
</header>
