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

$header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-members.jpg';

?>

	<section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
		<img id="members-img" src="<?php echo get_stylesheet_directory_uri() ?>/images/members.png">
		<a class="button" href="/login">Log in</a>
	</section>

	<div id="page" class="content-area">
		<main id="main" class="site-main">

			<section class="content">
				<?php
				while (have_posts()) : the_post();
					echo '<div class="the-content">';

						// DISPLAY INDUSTRY MEMBER LINKS
						if( current_user_can('mepr-active','membership:20') ):

								echo '<nav>';
									wp_nav_menu( array(
										'theme_location' => 'member-menu-1',
										'menu_id'        => 'industry-member-menu'
									) );
								echo '</nav>';

						endif;

						// DISPLAY DEALER MEMBER LINKS
						if( current_user_can('mepr-active','membership:19') ):

							echo '<nav>';
								wp_nav_menu( array(
									'theme_location' => 'member-menu-2',
									'menu_id'        => 'dealer-member-menu'
								) );
							echo '</nav>';

						endif;

						// DISPLAY LOGGED-IN CONTENT
						if( current_user_can('mepr-active','membership:19,20') ): ?>

						<div class="my-listings">
							<h3 class="section-title">My Listings: Coming Soon</h3>
							<p>View, edit, and manage your listings.</p>
						</div>

						<?php
						else :

						// LOGGED OUT THINGS
						echo '<h3 class="section-title">Become a Member</h3>';
						echo '<div class="becomeamember">';
							echo '<div class="dealermember">';
								echo '<h3>Dealer Member</h3>';
								echo '<p>This Membersip is tailored to Aircraft Dealers. See and Submit Members\' Off-Market Listings, Members\' Wanted Aircraft, Submit Aircraft listings and refer clients directly to GLAD\'s Hosted Listings Page, receive Industry Discounts, Network with Peers, and more.</p>';
								echo '<a href="/memberships/dealer-member/" class="button">Become a Dealer Member</a>';
							echo '</div>';
							echo '<div class="industrymember">';
								echo '<h3>Industry Member</h3>';
								echo '<p>Choose this Membersip if you are an Industry professional. Submit Aircraft listings, receive Industry Discounts, Network with Peers, and more.</p>';
								echo '<a href="/memberships/industry-member/" class="button">Become an Industry Member</a>';
							echo '</div>';
						echo '</div>';

						endif;

						// All The Pages Stuff
						the_content();

					echo '</div>';
				endwhile;
				?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
