<?php
/**
 * Template Name: Ajax Canvas
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _glad
 */

while (have_posts()) : the_post();
	echo '<div class="ajax-box">';

		the_content();

	echo '</div>';
endwhile; ?>
