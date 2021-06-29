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

$header_img = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, 'full') : get_stylesheet_directory_uri() . '/images/bg-hero-wide.jpg';
?>

	<section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
		<?php echo '<div class="title-wrapper"><h1 id="title">' . get_the_title( $post->ID ) . '</h1></div>'; ?>
	</section>

	<div id="page" class="content-area">
		<main id="main" class="site-main">

			<?php get_template_part('template-parts/nav-members'); ?>

			<section class="content">
				<?php

				while (have_posts()) : the_post();
					echo '<div class="the-content">';

            // try {
						//
            // } catch (Exception $e) {
            //   echo 'Exception: ' . $e->getMessage(), '<br>';
            // }

						$who = 7;
						$blurb = "we like pizza";
						$cta = 'Click Here';

						if( is_numeric( $who ) ) {
							// get member by ID
							$user = get_user_meta( $who );
							if( $user ) {
								$name = $user['mepr_company'][0];
								$url  = $user['mepr_company_website'][0];
								$type = $user['mepr_membership_type'][0];
								$logo = get_company_logo( $who );
								$obj = get_userdata( $who );
								$joined = $obj->user_registered;
							} else {
								return 'Error: User does not exist.';
							}
						} else {
							$name = $who;
							$type = 'industry';
						}

						echo '<div class="list-item-feature ' . $type . '">
							<h5>' . ucwords($type) . ' Member Spotlight</h5>';
							echo '<div class="inner">
								<div class="logo" style="background-image:url(' . $logo . ');"></div>
								<div class="info-wrapper">';
									echo '<h3>' . $name . '</h3>';
									echo '<p class="membersince">' . ucwords($type) . ' Member since ' . date( "M Y", strtotime( $joined ) ) . '</p>';
									echo '<p class="blurb">' . $blurb . '</p>';
									echo '<a class="button cta" target="_blank" href="' . $url . '">' . $cta . '</a>';
								echo '</div>
							</div>
						</div>';

					echo '</div>';
				endwhile;


				?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();

get_template_part( 'template-parts/resize-hero' );
