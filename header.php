<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _glad
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="language" content="en" />

	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/vendor/css/all.css' ?>" type="text/css"> <!-- fontawesome -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri() . '?' . filemtime( get_stylesheet_directory() . '/style.css'); ?>" type="text/css" media="screen" />

	<?php wp_head(); ?>

	<?php get_template_part('template-parts/head-tracking') ?>

</head>

<body <?php body_class(); ?>>

	<?php get_template_part('template-parts/body-tracking') ?>

	<?php get_template_part('template-parts/nav-mobile') ?>

	<div id="page-wrapper">
