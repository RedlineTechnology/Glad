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
	<!-- Search Engine -->
	<meta name="description" content="GLADA.aero supports growth in the Business Aviation Industry, providing a foundation for Leaders to network and grow their businesses with integrity.">
	<meta name="image" content="https://www.glada.aero/wp-content/themes/Glad/images/GLADA_logo_tight.png">
	<meta name="keywords" content="Global, Licensed, Aircraft, Dealer, Dealers, Association, Aviation, Airplane, Helicopters, Helicopter, Jets, Jet, Listing, Listings, Member, Members, Membership, Networking, Network, Integrity, Transparency, Insight, Grow, Growth">
	<!-- Schema.org for Google -->
	<meta itemprop="name" content="GLADA.aero - Where Industry Meets Integrity">
	<meta itemprop="description" content="GLADA.aero supports growth in the Business Aviation Industry, providing a foundation for Leaders to network and grow their businesses with integrity.">
	<meta itemprop="image" content="https://www.glada.aero/wp-content/themes/Glad/images/GLADA_logo_tight.png">
	<!-- Twitter -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="GLADA.aero - Where Industry Meets Integrity">
	<meta name="twitter:description" content="GLADA.aero supports growth in the Business Aviation Industry, providing a foundation for Leaders to network and grow their businesses with integrity.">
	<!-- Open Graph general (Facebook, Pinterest & Google+) -->
	<meta name="og:title" content="GLADA.aero - Where Industry Meets Integrity">
	<meta name="og:description" content="GLADA.aero supports growth in the Business Aviation Industry, providing a foundation for Leaders to network and grow their businesses with integrity.">
	<meta name="og:image" content="https://www.glada.aero/wp-content/themes/Glad/images/GLADA_logo_tight.png">
	<meta name="og:url" content="https://glada.aero">
	<meta name="og:site_name" content="GLADA.aero - Where Industry Meets Integrity">
	<meta name="og:type" content="website">
	<!-- Other Stuff -->
	<meta name="robots" content="index, follow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="English">
	<meta name="revisit-after" content="7 days">
	<meta name="author" content="GLADA.aero">
	<!-- Styles -->
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/vendor/css/all.css' ?>" type="text/css"> <!-- fontawesome -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri() . '?' . filemtime( get_stylesheet_directory() . '/style.css'); ?>" type="text/css" media="all" />

	<?php wp_head(); ?>
	<?php get_template_part('template-parts/head-tracking') ?>

</head>

<body <?php body_class(); ?>>

	<?php get_template_part('template-parts/body-tracking') ?>

	<?php get_template_part('template-parts/nav-mobile') ?>

	<div id="page-wrapper">
