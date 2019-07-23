<?php
/**
 * ta functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _glad
 */

if ( ! function_exists( 'glad_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function glad_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( '_glad', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Set up Navigation Menus
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Main Menu', '_glad' ),
			'menu-2' => esc_html__( 'Member Menu', '_glad' ),
			'menu-3' => esc_html__( 'Footer Menu', '_glad'),
			'member-menu-1'	=> esc_html__( 'Member Menu 1', '_glad'),
			'member-menu-2'	=> esc_html__( 'Member Menu 2', '_glad')

		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

	}
endif;
add_action( 'after_setup_theme', 'glad_setup' );


// Let's try to fix the image thing
function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}
add_filter( 'wp_image_editors', 'change_graphic_lib' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function glad_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_glad' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', '_glad' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'glad_widgets_init' );

// No admin bar on login
add_filter( 'show_admin_bar' , '__return_false' );

/**
 * Enqueue scripts and styles.
 */
function glad_scripts() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array('jquery'), '20190712', true );
	// Custom Mobile Navigation JS
	wp_enqueue_script( 'glad-navigation', get_template_directory_uri() . '/js/navigation.min.js', array('jquery'), '20190622', true );
	// This thing
	wp_enqueue_script( 'glad-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	// Slick
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '20190220', true);
	// ScrollTrigger
	wp_enqueue_script( 'scrolltrigger', get_template_directory_uri() . '/js/scrolltrigger.min.js', array('jquery'), '20190220', true);
	// Parallax
	wp_enqueue_script( 'enllax', get_template_directory_uri() . '/js/jquery.enllax.min.js', array('jquery'), '20190712', true);
	// Featherlight
	wp_enqueue_script( 'featherlight', get_template_directory_uri() . '/js/featherlight.min.js', array('jquery'), '20190226', true);
	// Kill WPautoP
	wp_enqueue_script( 'wpautopkiller', get_template_directory_uri() . '/js/wpautopkiller.min.js', array('jquery'), '20190711', true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'glad_scripts' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom Post Types
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


function load_accordion_tabs() {
	// Load Scripts for Accordion Tabs
  // https://github.com/thomashigginbotham/responsive-accordion-tabs
  // Accordion built on jquery ui - only load the necessary components and dependencies
  // https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui' );
  wp_enqueue_script( 'jquery-ui-tabs' );
  wp_enqueue_script( 'jquery-ui-accordion' );
  wp_enqueue_script( 'jquery-effects-core' );
  wp_enqueue_script( 'jquery-effects-fade' );
	wp_enqueue_script( 'responsive-accordion-tabs', get_template_directory_uri() . '/js/accordion-tabs.js', array('jquery'), '20190423', true );
  wp_enqueue_script( 'accordion-options', get_template_directory_uri() . '/js/accordion-options.js', array('jquery','responsive-accordion-tabs'), '20190424', true );
}
