<?php
/*
 *	The template for displaying events calendar on "/events" url slug
 *
 *	Override this template by coping it to yourtheme/eventon/archive-ajde_events.php
 *
 *	@Author: AJDE
 *	@EventON
 *	@version: 2.5
 *
 * @package _glad
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="hero section" style="background-image: url(' <?php echo get_stylesheet_directory_uri() . '/images/mplex_header.jpg'; ?>')">
				<div class="filter"></div>
				<div class="content-container">
					<div class="mobile-hidden"><h1 class="page-title">
            <?php echo post_type_archive_title( '', false ); ?>
          </h1></div>
				</div>
			</div>

			<section class="archive section">

				<?php EVO()->archive_page(); ?>

			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
