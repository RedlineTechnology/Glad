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

// Add Dev Class if Admin
if ( is_user_logged_in() ) {
    add_filter('body_class','add_role_to_body');
    add_filter('admin_body_class','add_role_to_body');
}
function add_role_to_body($classes) {
    $current_user = new WP_User(get_current_user_id());
    $user_role = array_shift($current_user->roles);
    if (is_admin()) {
        $classes .= 'role-'. $user_role;
    } else {
				if( current_user_can('edit_others_pages') ) {
					$classes[] = 'dev';
				} else {
	        $classes[] = 'role-'. $user_role;
				}
    }
    return $classes;
}


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
	// We'll Register this here so we can use it later on different pages
	wp_register_script( 'loadmore', get_stylesheet_directory_uri() . '/js/loadmore.min.js', array('jquery'), '20210521' );
}
add_action( 'wp_enqueue_scripts', 'glad_scripts' );

function localize_vars() {
    return array(
				'locations' => memberlocations(),
        'template_directory' => get_template_directory_uri(),
				'userid' => get_current_user_id()
    );
}

/**
 * Enqueue Accordion Tabs, but only when called
 * @link https://github.com/thomashigginbotham/responsive-accordion-tabs
 * Accordion built on jquery ui - only load the necessary components and dependencies
 * https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 */
function load_accordion_tabs() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui' );
  wp_enqueue_script( 'jquery-ui-tabs' );
  wp_enqueue_script( 'jquery-ui-accordion' );
  wp_enqueue_script( 'jquery-effects-core' );
  wp_enqueue_script( 'jquery-effects-fade' );
	wp_enqueue_script( 'responsive-accordion-tabs', get_template_directory_uri() . '/js/accordion-tabs.js', array('jquery'), '20190423', true );
  wp_enqueue_script( 'accordion-options', get_template_directory_uri() . '/js/accordion-options.js', array('jquery','responsive-accordion-tabs'), '20190424', true );
}

function load_leaflet() {
	/**
	 * Geocoder
	 * https://github.com/perliedman/leaflet-control-geocoder
	 */
	wp_enqueue_style('leaflet', get_template_directory_uri() . '/vendor/leaflet/leaflet.css' );
	wp_enqueue_style('geocoder', get_template_directory_uri() . '/vendor/leaflet/geocoder/Control.Geocoder.css' );
	wp_enqueue_script('leaflet', get_template_directory_uri() . '/vendor/leaflet/leaflet-src.js', array(), '20200921', true);
	wp_enqueue_script('geocoder', get_template_directory_uri() . '/vendor/leaflet/geocoder/Control.Geocoder.js', array('leaflet'), '20200921', true);
	wp_enqueue_script('leafletsettings', get_template_directory_uri() . '/js/leaflet-settings.min.js', array('jquery'), '20200930', true);
	wp_localize_script('leafletsettings', 'themevars', localize_vars() );
}

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

/**
 * User Meta additions.
 */
require get_template_directory() . '/inc/user-profiles.php';

/**
 * Wild Apricot Integration
 */
// require get_template_directory() . '/inc/wildapricot.php';

/**
 * Some Memberpress Support functions
 */
require get_template_directory() . '/inc/mepr.php';

/**
 * TextMagic Integration
 */
require get_template_directory() . '/inc/Textmagic/textmagic.php';

/**
 * Email Templates
 */
require get_template_directory() . '/inc/emails.php';


// Schedule a daily check on referrals
// https://developer.wordpress.org/reference/functions/wp_schedule_event/
// function glada_deactivate() {
//     wp_clear_scheduled_hook( 'glada_cron' );
// }

add_action('init', function() {
    add_action( 'glada_cron', 'glada_run_cron' );
    // register_deactivation_hook( __FILE__, 'glada_deactivate' );

    if (! wp_next_scheduled ( 'glada_cron' )) {
        wp_schedule_event( time(), 'daily', 'glada_cron' );
    }
});

function glada_run_cron() {
	try {
		update_referrals();
	} catch (Exception $e) {
		error_log( $e->getMessage() );
	}
}

/**
 * EDIT LISTINGS
 */
 // function update_exiting_listing( $post_args, $form_data, $fields ) {
 //
	//  global $post;
 //
	//  if( is_singular('listings') ) {
	//  	 $post_args['ID'] = $post->ID;
	//  }
 //
	//  // // Check for Post ID defined in custom post meta.
	//  // if ( ! empty( $settings['post_submissions_meta'] ) ) {
	//  //
	// 	//  if ( $settings['post_submissions_meta']['36'] ) {
	//  //
	// 	// 	 echo '<h1>SUBMITTING ID 36</h1>';
	//  //
	// 	//  } else if ( $settings['post_submissions_meta']['post-id'] ) {
	//  //
	// 	// 	 echo '<h1>SUBMITTING POST ID</h1>';
	//  //
	// 	//  }
	//  // }
 //
	//  // $settings = $form_data['settings'];
	//  // $fields   = $form_data['fields'];
	//  //
	//  // // If we're editing an existing post, say so.
	//  // if( !empty( $settings['post_submissions_meta']['post-id'] ) ) {
	//  //
	//  // }
	//  // $post_args['ID'] = $settings['post_submissions_meta']['post-id'] ? : '0';
 //
	//  //return $post_args;
 //
	//  return $post_args;
 // }
 // add_filter('wpforms_post_submissions_post_args', 'update_existing_listing', 10, 2);

// Ajax Handler for LoadMore
function loadmore_ajax_handler(){

	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if( have_posts() ) :

		$posttype = $args['post_type'];

		// run the loop
		while ( have_posts() ) : the_post();

			if ( $posttype === 'listing' ) {
				echo '<div class="' . $posttype . '-list-item">';
					get_template_part('template-parts/listing');
			} elseif ( $posttype === 'opportunity' ) {
				echo '<div class="list-item-' . $posttype . '">';
					get_template_part('template-parts/opportunity');
			} else {
				echo '<div class="' . $posttype . '-list-item">';
			}
			echo '</div>';

		endwhile;

	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
add_action('wp_ajax_loadmore', 'loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

/**
 * Listings Filter Function
 *
 * @link https://rudrastyh.com/wordpress/ajax-post-filters.html
 * @link https://rudrastyh.com/wordpress/ajax-load-more-with-filters.html
 */
function listing_filter_function(){

	$postorder = $_POST['date'] ? $_POST['date'] : 'ASC';

	$args = array(
		'post_type' => 'listing',
		'order'	=> $postorder,
		'orderby'   => 'year_clause',
		'meta_query' => array(
				 'year_clause' => array(
							'key' => 'year',
							'compare' => 'EXISTS',
							'type' => 'NUMERIC'
					)
			),
		'tax_query'	=> array(
					'relation' => 'AND',
					array(
							'taxonomy' 	=> 'marketstatus',
							'terms' 		=> array('contract', 'sold', 'offmarket'),
							'field' 		=> 'slug',
							'operator' 	=> 'NOT IN'
					),
					array(
							'taxonomy' 	=> 'post_tag',
							'field'		 	=> 'term_id',
							'terms'		 	=> array('29'),
							'operator' 	=> 'NOT IN'
					)
			)
	);

	// for AIRCRAFT TYPE
	if( isset( $_POST['aircrafttype'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' 	=> 'aircraft',
			'terms' 		=> $_POST['aircrafttype'],
			'field' 		=> 'slug',
			'operator'	=> 'IN'
		);
	}

	// for MARKET STATUS
	if( isset( $_POST['marketstatus'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'marketstatus',
			'field' => 'id',
			'terms' => $_POST['marketstatus']
		);
	}

	if( $_POST['make'] == 'all' ) {
		$aircraftmakes = get_meta_values('make','listing');
		$args['meta_query'][] = array(
			'key' => 'make',
			'value' => $aircraftmakes,
			'compare' => 'IN'
		);
	} else {
		$args['meta_query'][] = array(
			'key' => 'make',
			'value' => $_POST['make'],
			'compare' => 'LIKE'
		);
	}

	// create $args['meta_query'] array if one of the following fields is filled
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] || isset( $_POST['price_max'] ) && $_POST['price_max'] || isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
		$args['meta_query'] = array( 'relation'=>'AND' ); // AND means that all conditions of meta_query should be true

	// if both minimum price and maximum price are specified we will use BETWEEN comparison
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] && isset( $_POST['price_max'] ) && $_POST['price_max'] ) {
		$args['meta_query'][] = array(
			'key' => '_price',
			'value' => array( $_POST['price_min'], $_POST['price_max'] ),
			'type' => 'numeric',
			'compare' => 'between'
		);
	} else {
		// if only min price is set
		if( isset( $_POST['price_min'] ) && $_POST['price_min'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_min'],
				'type' => 'numeric',
				'compare' => '>'
			);

		// if only max price is set
		if( isset( $_POST['price_max'] ) && $_POST['price_max'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_max'],
				'type' => 'numeric',
				'compare' => '<'
			);

			if(count( $args['meta_query'] ) > 1) {
			    $args['meta_query']['relation'] = 'AND';
			}
	}

	// if post thumbnail is set
	if( isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
		$args['meta_query'][] = array(
			'key' => '_thumbnail_id',
			'compare' => 'EXISTS'
		);
	// if you want to use multiple checkboxed, just duplicate the above 5 lines for each checkbox

	query_posts( $args );

	global $wp_query;
	if( have_posts() ) :
 		ob_start(); // start buffering because we do not need to print the posts now

		while( have_posts() ): the_post();
			echo '<div class="listing-list-item">';
				get_template_part('template-parts/listing');
			echo '</div>';
		endwhile;

 		$posts_html = ob_get_contents(); // we pass the posts to variable
   	ob_end_clean(); // clear the buffer
	else:
		$posts_html = '<p>Nothing found for your criteria.</p>';
	endif;

	echo json_encode( array(
			'posts' => json_encode( $wp_query->query_vars ),
			'max_page' => $wp_query->max_num_pages,
			'found_posts' => $wp_query->found_posts,
			'content' => $posts_html
		) );

	die();
}
add_action('wp_ajax_sortlistings', 'listing_filter_function'); // wp_ajax_{ACTION HERE}
add_action('wp_ajax_nopriv_sortlistings', 'listing_filter_function');

function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {

    global $wpdb;

    if( empty( $key ) )
        return;

    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = %s
        AND p.post_status = %s
        AND p.post_type = %s
    ", $key, $status, $type ) );

		sort($r);
    return $r;
}


/**
 * Very very Custom Search.
 * We are bypassing the WP Query altogether and going to the DB with our own SQL Query.
 * This will not return any query arguments, rather it will return an array of Post objects
 */

// EXCLUDING tag _deleted is NOT WORKING.  For now, I'm just hiding them in CSS as a stop-gap.
// Yay for Permanent Temporary Solutions
 function search_posts( $value, $posttype = 'opportunity' ) {
    global $wpdb;
    $value = '%'.$wpdb->esc_like($value).'%';
		$deleted = '%deleted%';
    $sql = $wpdb->prepare("SELECT p.ID
        FROM {$wpdb->prefix}posts p
        LEFT JOIN {$wpdb->prefix}postmeta m ON m.post_id = p.ID
        LEFT JOIN {$wpdb->prefix}term_relationships r ON r.object_id = p.ID
        LEFT JOIN {$wpdb->prefix}term_taxonomy tt ON tt.term_taxonomy_id = r.term_taxonomy_id AND tt.taxonomy = 'opptype'
        LEFT JOIN {$wpdb->prefix}terms t ON t.term_id = tt.term_id
        LEFT JOIN {$wpdb->prefix}term_relationships cr ON cr.object_id = p.ID
				LEFT JOIN {$wpdb->prefix}term_taxonomy ct ON ct.term_taxonomy_id = cr.term_taxonomy_id AND ct.taxonomy = 'post_tag'
				LEFT JOIN {$wpdb->prefix}terms c ON c.term_id = ct.term_id
        WHERE p.post_status = 'publish' AND p.post_type = %s
            AND ((m.meta_key = 'services' AND m.meta_value LIKE %s)
                OR (t.name LIKE %s)
							  OR (t.slug LIKE %s)
							  OR (p.post_content LIKE %s)
							  OR (p.post_title LIKE %s))
						AND ( COALESCE(c.name,'valid') NOT LIKE %s )
        GROUP BY p.ID", $posttype, $value, $value, $value, $value, $value, $deleted);
    $ids = $wpdb->get_col($sql);
    if (is_array($ids) && count($ids) > 0)
        return array_map('get_post', $ids);
    else
        return []; // or whatever you like
 }

 // We're Going to Use these custom filters to help make the default Wordpress
 // Search a little better.
 // https://wordpress.stackexchange.com/questions/99849/search-that-will-look-in-custom-field-post-title-and-post-content

 // These will also search the meta key "services" belonging to Opportunity Types
 // function add_join_wpse_99849($joins) {
	//  global $wpdb;
	//  return $joins . " INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)";
	// }
 //
	// function alter_search_opportunity($search,$qry) {
	//  global $wpdb;
	//  $add = $wpdb->prepare("({$wpdb->postmeta}.meta_key = 'services' AND CAST({$wpdb->postmeta}.meta_value AS CHAR) LIKE '%%%s%%')",$qry->get('s'));
	//  $pat = '|\(\((.+)\)\)|';
	//  $search = preg_replace($pat,'(($1 OR '.$add.'))',$search);
	//  return $search;
	// }

 function opp_search() {

	 $vars = json_decode( stripslashes( $_POST['posts'] ), true);
	 $args = array();

	 foreach( $vars as $key => $var) {
		 if( $var ) {
			 $args[ $key ] = $var;
		 }
	 }

	 $posttype = $args['post_type'];
	 $dealers = get_dealers_with_services( $_POST['searchfield'], 10 );
	 $customsearch = search_posts( $_POST['searchfield'], $posttype );
	 $count = count( $customsearch );

	 ob_start();

	 if( !empty( $customsearch )) {
		 while ( list($i, $postobj) = each( $customsearch ) ) :
			 global $post;
			 $post = $postobj;
			 setup_postdata($post);

			 // TODO
			 // is this returning drafts? need to check if non-published posts are being returned
			 // yes it is but we're just going to hide them for now. SQL query is misbehaving (i.e., I don't know what I'm doing)

			 $tags = get_the_tags($post->ID);
			 $tag = $tags ? $tags[0]->slug : '';

			 echo '<div class="list-item-' . $posttype . $tag . '">';
				 get_template_part('template-parts/' . $posttype );
			 echo '</div>';
		 endwhile;
		 wp_reset_postdata();
	 } else {
		 echo 'No Service Listings for Search Term "' . $_POST['searchfield'] . '"';
	 }

	 $html = ob_get_contents(); // we pass the posts to variable
	 ob_end_clean(); // clear the buffer

	 echo json_encode( array(
	 	'content' => $html,
		'secondary' => $dealers,
		'count' => $count
	 ));

	 die();
 }
 add_action('wp_ajax_oppsearch', 'opp_search');
 add_action('wp_ajax_nopriv_oppsearch', 'opp_search');


 function get_dealers_with_services( $service, $number ) {

	 // Get a List of Dealers and Return them along with their Services
	 $args = array(
		 'role__in' => array('Dealer'),
		 'role__not_in' => array('Managed'),
		 'number' => $number,
		 'meta_query' => array(
			 array(
				 'key' => 'mepr_services',
				 'value' => $service,
				 'compare' => 'LIKE'
			 )
		 )
	 );
	 $user_query = new WP_User_Query( $args );

	 ob_start();

	 if ( ! empty( $user_query->get_results() ) ) {
		 foreach ( $user_query->get_results() as $user ) {

			 $id = $user->ID;
			 $services = get_user_meta( $id, 'mepr_services', true );

			 if( !empty( $services )) {
				 $logo = get_company_logo( $id );
				 $url = get_user_meta( $id, 'mepr_company_website', true );

				 echo '<a href="' . $url . '" target="_blank"><div class="dealer_wrapper">
							 <div class="logo_wrapper"><img src="' . $logo . '"></div>';
				 echo '<ul>';
				 foreach( $services as $key => $service ) {
					 echo '<li>' . ucwords( $key ) . '</li>';
				 }
				 echo '</ul>
							 </div></a>';
			 }
		 }
	 }

	 $html = ob_get_contents(); // we pass the posts to variable
	 ob_end_clean(); // clear the buffer

	 return $html;

 }

function expandpost() {
	global $post;
	$postid = preg_split( '/-/', $_POST['post'] );
	$post = get_post( $postid[1] );

	$user_id = $post->post_author;
	$date = new DateTime( $post->post_date );
	$user = get_userdata($user_id);
	$company = get_user_meta($user_id, 'mepr_company', true);
	$name = get_post_meta( $post->ID, 'contactname', true ) ?: $user->first_name . ' ' . $user->last_name;
  $phone = get_post_meta( $post->ID, 'contactnumber', true ) ?: get_user_meta( $user_id, 'mepr_phone_number', true );
  $email = get_post_meta( $post->ID, 'contactemail', true ) ?: $user->user_email;

	ob_start();

	echo '<div class="inner">';

		echo '<a href="#" class="closebox"><i class="fas fa-times"></i></a>';
		echo '<div>';
			echo '<h4>' . get_the_title() . '</h4>';
			echo '<p class="dateposted">posted ' . $date->format('F jS, Y') . '</p>';
			echo '<p class="thestuff">' . get_the_content() . '</p>';

			echo '<h4>Contact</h4>';
			echo '<p>' . $name . ' // ' . formatPhoneNumber( $phone ) . '<br><a href="mailto:' . $email . '">' . $email . '</a></p>';
		echo '</div>';
		echo '<ul class="tags">';
	  $types = get_the_terms($post->ID, 'opptype');
	  foreach( $types as $type ){
	    echo '<li class="' . $type->slug . '" type="' . $type->slug . '">' . $type->name . '</li>';
	  }
		echo '</ul>';
	echo '</div>';

	$html = ob_get_contents(); // we pass the posts to variable
	ob_end_clean(); // clear the buffer

	echo json_encode( array(
	 'content' => $html,
	));

	die();
}
add_action( 'wp_ajax_expandpost', 'expandpost' );
add_action( 'wp_ajax_nopriv_expandpost', 'expandpost' );

// Insert Ad on Listings Page
function insert_ad( $who, $blurb, $cta = 'Click Here', $url = '' ) {

	if( is_numeric( $who ) ) {
		// get member by ID
		$user = get_user_meta( $who );
		if( $user ) {
			$name = $user['mepr_company'][0];
			$url  = $user['mepr_company_website'][0];
			$type = $user['mepr_membership_type'][0];
		} else {
			return 'Error: User does not exist.';
		}
	} else {
		$name = $who;
		$type = 'industry';
	}

	echo '<div class="listing-list-item ad dev ' . $type . '">
		<a target="_blank" href="' . $url . '"><div class="inner">';
		echo '<h5>' . $type . ' Member Spotlight</h5>';
		echo '<h3>' . $name . '</h3>';
		echo '<p>' . $blurb . '</p>';
		// echo '<a class="button" href="' . $url . '">' . $cta . '</a>';
		echo '</div></a>
	</div>';

}


// Managed Account Permissions. In the Loop.
function can_edit() {
	global $post;
	// Get User Info
	$current_user = wp_get_current_user();
	$user = get_userdata( $current_user->ID );
	$user_roles = $user->roles;
	// Get Author ID
	$author_id = $post->post_author;

	if ( $author_id == $current_user->ID ) {
		// User is Author. Can edit.
		return true;
	} elseif ( in_array( 'managed', $user_roles, true ) ) {

		// MANAGED ACCOUNT. Compare to Author
		$author = get_userdata( $author_id );
		$author_email = $author->user_email;

		$manager = get_user_meta( $current_user->ID, 'mepr__managed', true );

		if( $manager ) {
			// User has the "_managed" field properly set. Use it!
			if( $author_email == $manager ) {
				// This account is managed by the author. Bingo!
				return true;
			} else {
				// This account is managed, but not by the author.
				return false;
			}
		} else {
			// The user doesn't have anything set in the "_managed" field.
			// Compare emails.
			$user_email = $user->user_email;
			$author_domain = explode('@', $author_email)[1];
			$user_domain = explode('@', $user_email)[1];

			// Compare Email Domain Names
			if( $author_domain == $user_domain ) {
				return true;
			} else {
				return false;
			}
		}

	} else {
		// User is not Author or Managed. Can not edit.
		return false;
	}

}

// Get Author and Managed User IDs. Outside the Loop.
function icanhaz() {
	$current_user = wp_get_current_user();
	$user = get_userdata( $current_user->ID );

	// Instanciate the array and add the User to it
	$author_array = array();
	$author_array[] = $current_user->ID;

	// Check Roles
	$user_roles = $user->roles;
	if( in_array( 'managed', $user_roles, true ) ) {

		// This is a Managed account. Get the Manager ID
		$manager = get_user_by( 'email', get_user_meta( $current_user->ID, 'mepr__managed', true ) );
		// Add the Manager to the Array
		$author_array[] = $manager->ID;

	} else {
		// This Account is a Primary. We're done here.
	}
	return $author_array;
}


// Achievement Get! (user has gotten the GLAD logo)
function achievementget() {

	$user = $_POST['user_id'];

	update_user_meta( $user, 'achievementget', true );

	die();
}
add_action( 'wp_ajax_achievementget', 'achievementget' );
add_action( 'wp_ajax_nopriv_achievementget', 'achievementget' );


// When a user makes edits to their posts on the members dashboard,
// The dynamic forms call this function to save information
function update_listing_function() {

    $post_id = $_POST['post_id'];

		// Off-Market is the new Delete
		if( isset( $_POST['marketstatus'] )) {
			$status = intval( $_POST['marketstatus'] );
			wp_set_object_terms( $post_id, $status, 'marketstatus' );
			switch( $status ) {
				case 5:
					wp_die( $post_id );
					break;
				case 8:
					wp_die( $post_id );
					break;
				case 30:
					// Set to the DELETED tag and bounce
					wp_set_object_terms( $post_id, 29, 'post_tag' );
					wp_die( $post_id );
					break;
				default:
					// continue
			}
		}

		// Backup Delete, also for non-listings
		if( isset( $_POST['delete_post'] )) {
			wp_set_object_terms( $post_id, 29, 'post_tag' );
			wp_die( $post_id );
		}

		// Set the Other Taxonomies here since users won't be able to in wp_update_post() without role capabilities
		if( isset( $_POST['aircraft'] )) {
			$aircraft = intval( $_POST['aircraft'] );
			wp_set_object_terms( $post_id, $aircraft, 'aircraft' );
		}
		if( isset( $_POST['opptype'] )) {
			$types = $_POST['opptype'];
			wp_set_object_terms( $post_id, $types, 'opptype' );
		}

		// Build the array for wp_update_post
		$updated_post = array(
			'ID' 						=> $post_id,
			'tax_input'			=> array(),
			'meta_input'   	=> array()
		);

		// Real Post Info
		if( $_POST['post_title'] ) {
			$updated_post['post_title'] = sanitize_text_field( $_POST['post_title'] );
		}
		if( $_POST['details'] ) {
			$updated_post['post_content'] = wp_kses_post( $_POST['details'] );
		}

		// Meta Info
		if( $_POST['year'] ) {
			$updated_post['meta_input']['year'] = sanitize_text_field( $_POST['year'] );
		}
		if( $_POST['make'] ) {
			$updated_post['meta_input']['make'] = sanitize_text_field( $_POST['make'] );
		}
		if( $_POST['model'] ) {
			$updated_post['meta_input']['model'] = sanitize_text_field( $_POST['model'] );
		}
		if( $_POST['serialnumber'] ) {
			$updated_post['meta_input']['serialnumber'] = sanitize_text_field( $_POST['serialnumber'] );
		}
		if( $_POST['registration'] ) {
			$updated_post['meta_input']['registration'] = sanitize_text_field( $_POST['registration'] );
		}
		if( $_POST['landings'] ) {
			$updated_post['meta_input']['landings'] = intval(str_replace(',','', $_POST['landings'] ));
		}
		if( $_POST['aftt'] ) {
			$updated_post['meta_input']['aftt'] = sanitize_text_field( $_POST['aftt'] );
		}
		if( $_POST['aftt_number'] ) {
			$updated_post['meta_input']['aftt-number'] = intval(str_replace(',','', $_POST['aftt_number'] ));
		}
		if( $_POST['url'] ) {
			$updated_post['meta_input']['url'] = esc_url_raw( $_POST['url'] );
		}

		if( $_POST['contactname'] ) {
			$updated_post['meta_input']['contactname'] = sanitize_text_field( $_POST['contactname'] );
		}
		if( $_POST['contactnumber'] ) {
			$updated_post['meta_input']['contactnumber'] = formatPhoneNumber( $_POST['contactnumber'] );
		}
		if( $_POST['contactemail'] ) {
			$updated_post['meta_input']['contactemail'] = sanitize_email( $_POST['contactemail'] );
		}

		// Specsheet
		// Cannot use AJAX to upload Files. BOOOOOOO
		// if (!function_exists('wp_generate_attachment_metadata')){
		// 	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		// 	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		// 	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		// }
		// if($_FILES) {
		// 	foreach ($_FILES as $file => $array) {
		//
		// 		if($_FILES[$file]['error'] !== UPLOAD_ERR_OK){ return "upload error : " . $_FILES[$file]['error']; } //If upload error
		//
		// 		$attachment_id = media_handle_upload($file, 0);
		// 		$updated_post['meta_input']['pdf'] = $attachment_id;
		// 	}
		// }

		// Do The Thing
		$post_id = wp_update_post( $updated_post, true );
		// if (is_wp_error($post_id)) {
		//     $errors = $post_id->get_error_messages();
		//     foreach ($errors as $error) {
		//         echo $error;
		//     }
		// }

	wp_die( $post_id );
}
add_action( 'wp_ajax_updatelisting', 'update_listing_function' );
add_action( 'wp_ajax_nopriv_updatelisting', 'update_listing_function' );

// Submit or Update Comp
function comp_function() {

	$author = $_POST['user_id'] ? $_POST['user_id'] : 1;
  $post_id = $_POST['post_id'] ? $_POST['post_id'] : 0;
	$title = sanitize_text_field( $_POST['year_mfr'] ) . ' ' . sanitize_text_field( $_POST['make'] ) . ' ' . sanitize_text_field( $_POST['model'] ) . ' ' . sanitize_text_field( $_POST['serialnumber'] );
	$content = $_POST['notes'] ? sanitize_textarea_field( $_POST['notes'] ) : '';

	// Build the array for wp_update_post
	$postarray = array(
		'ID' 						=> $post_id,
		'post_type'			=> 'comp',
		'post_status'		=> 'publish',
		'post_title'		=> $title,
		'post_content'	=> $content,
		'post_author'		=> $author,
		'tax_input'			=> array(),
		'meta_input'   	=> array()
	);

	// Meta Info
	if( $_POST['make'] ) {
		$postarray['meta_input']['make'] = sanitize_text_field( $_POST['make'] );
	}
	if( $_POST['model'] ) {
		$postarray['meta_input']['model'] = sanitize_text_field( $_POST['model'] );
	}
	if( $_POST['serialnumber'] ) {
		$postarray['meta_input']['serialnumber'] = sanitize_text_field( $_POST['serialnumber'] );
	}
	if( $_POST['registration'] ) {
		$postarray['meta_input']['registration'] = sanitize_text_field( $_POST['registration'] );
	}
	if( $_POST['year_mfr'] ) {
		$postarray['meta_input']['year_mfr'] = sanitize_text_field( $_POST['year_mfr'] );
	}
	if( $_POST['year_del'] ) {
		$postarray['meta_input']['year_del'] = sanitize_text_field( $_POST['year_del'] );
	}
	if( $_POST['date_listed'] ) {
		$date_listed = sanitize_text_field( $_POST['date_listed'] );
		$postarray['meta_input']['date_listed'] = $date_listed;
		$listed = new DateTime( $date_listed );
	} else {
		$listed = false;
	}
	if( $_POST['date_sold'] ) {
		$date_sold = sanitize_text_field( $_POST['date_sold'] );
		$postarray['meta_input']['date_sold'] = $date_sold;
		$sold = new DateTime( $date_sold );
	} else {
		$sold = false;
	}
	if( $listed && $sold ) {
		$interval = $listed->diff($sold);
		$postarray['meta_input']['days_mkt'] = $interval->days;
	}
	if( $_POST['price_ask'] ) {
		$temp = str_replace(array('$',',','.'), array('','',''), $_POST['price_ask']);
		$price_ask = is_numeric( $temp ) ? intval( $temp ) : sanitize_text_field( $temp );
		$postarray['meta_input']['price_ask'] = $price_ask;
	}
	if( $_POST['price_sell'] ) {
		$temp = str_replace(array('$',',','.'), array('','',''), $_POST['price_sell']);
		$price_sell = is_numeric( $temp ) ? intval( $temp ) : sanitize_text_field( $temp );
		$postarray['meta_input']['price_sell'] = $price_sell;
	}
	if( $_POST['direct'] ) {
		$postarray['meta_input']['direct'] = sanitize_text_field( $_POST['direct'] );
	}
	if( $_POST['status_notes'] ) {
		$postarray['meta_input']['status_notes'] = sanitize_textarea_field( $_POST['status_notes'] );
	}

	if( $_POST['airframe_time'] ) {
		$postarray['meta_input']['airframe_time'] = intval(str_replace(',','', $_POST['airframe_time'] ));
	}
	if( $_POST['airframe_cycles'] ) {
		$postarray['meta_input']['airframe_cycles'] = intval(str_replace(',','', $_POST['airframe_cycles'] ));
	}
	if( $_POST['airframe_program'] ) {
		$postarray['meta_input']['airframe_program'] = sanitize_text_field( $_POST['airframe_program'] );
	}
	if( $_POST['engine1_hours'] ) {
		$postarray['meta_input']['engine1_hours'] = intval(str_replace(',','', $_POST['engine1_hours'] ));
	}
	if( $_POST['engine2_hours'] ) {
		$postarray['meta_input']['engine2_hours'] = intval(str_replace(',','', $_POST['engine2_hours'] ));
	}
	if( $_POST['engine3_hours'] ) {
		$postarray['meta_input']['engine3_hours'] = intval(str_replace(',','', $_POST['engine3_hours'] ));
	}
	if( $_POST['engine_time'] ) {
		$postarray['meta_input']['engine_time'] = sanitize_text_field( $_POST['engine_time'] );
	}
	if( $_POST['engine1_cycles'] ) {
		$postarray['meta_input']['engine1_cycles'] = intval(str_replace(',','', $_POST['engine1_cycles'] ));
	}
	if( $_POST['engine2_cycles'] ) {
		$postarray['meta_input']['engine2_cycles'] = intval(str_replace(',','', $_POST['engine2_cycles'] ));
	}
	if( $_POST['engine3_cycles'] ) {
		$postarray['meta_input']['engine3_cycles'] = intval(str_replace(',','', $_POST['engine3_cycles'] ));
	}
	if( $_POST['engine_program'] ) {
		$postarray['meta_input']['engine_program'] = sanitize_text_field( $_POST['engine_program'] );
	}
	if( $_POST['engine_coverage'] ) {
		$postarray['meta_input']['engine_coverage'] = sanitize_text_field( $_POST['engine_coverage'] );
	}
	if( $_POST['apu_model'] ) {
		$postarray['meta_input']['apu_model'] = sanitize_text_field( $_POST['apu_model'] );
	}
	if( $_POST['apu_hours'] ) {
		$postarray['meta_input']['apu_hours'] = intval(str_replace(',','', $_POST['apu_hours'] ));
	}
	if( $_POST['apu_program'] ) {
		$postarray['meta_input']['apu_program'] = sanitize_text_field( $_POST['apu_program'] );
	}
	if( $_POST['fms'] ) {
		$postarray['meta_input']['fms'] = sanitize_text_field( $_POST['fms'] );
	}
	if( $_POST['inspections_cw'] ) {
		$postarray['meta_input']['inspections_cw'] = sanitize_text_field( $_POST['inspections_cw'] );
	}
	if( $_POST['inspections_due'] ) {
		$postarray['meta_input']['inspections_due'] = sanitize_text_field( $_POST['inspections_due'] );
	}
	if( $_POST['paint_year'] ) {
		$postarray['meta_input']['paint_year'] = sanitize_text_field( $_POST['paint_year'] );
	}
	if( $_POST['paint_condition'] ) {
		$postarray['meta_input']['paint_condition'] = sanitize_text_field( $_POST['paint_condition'] );
	}
	if( $_POST['paint_by'] ) {
		$postarray['meta_input']['paint_by'] = sanitize_text_field( $_POST['paint_by'] );
	}
	if( $_POST['interior_year'] ) {
		$postarray['meta_input']['interior_year'] = sanitize_text_field( $_POST['interior_year'] );
	}
	if( $_POST['interior_condition'] ) {
		$postarray['meta_input']['interior_condition'] = sanitize_text_field( $_POST['interior_condition'] );
	}
	if( $_POST['interior_by'] ) {
		$postarray['meta_input']['interior_by'] = sanitize_text_field( $_POST['interior_by'] );
	}

	if( $_POST['compliant'] ) {
		$postarray['meta_input']['compliant'] = sanitize_text_field( $_POST['compliant'] );
	}
	if( $_POST['damage'] ) {
		$postarray['meta_input']['damage'] = sanitize_text_field( $_POST['damage'] );
	}
	if( $_POST['damage_337'] ) {
		$postarray['meta_input']['damage_337'] = sanitize_text_field( $_POST['damage_337'] );
	}
	if( $_POST['pax'] ) {
		$postarray['meta_input']['pax'] = sanitize_text_field( $_POST['pax'] );
	}

	// Check to see if we're ADDING or Updating
	if( $post_id != 0 ) {
		$post_id = wp_update_post( $postarray, true );
	} else {
		$post_id = wp_insert_post( $postarray, true );
	}

	// Error? Let's get the message.
	if (is_wp_error($post_id)) {
			$html = '';
			$errors = $post_id->get_error_messages();
			foreach ($errors as $error) {
				 $html .= $error;
			}
			wp_die( $html );
	} else {
		// If insertion was successful, add tags and stuff
		// Users don't have 'assign_terms' role, so let's do this here.
		$aircraft = intval( $_POST['aircraft'] );
		wp_set_object_terms( $post_id, $aircraft, 'aircraft' );
		$status = intval( $_POST['marketstatus'] );
		wp_set_object_terms( $post_id, $status, 'marketstatus' );
	}

	wp_die( $post_id );
}
add_action( 'wp_ajax_updatecomp', 'comp_function' );
add_action( 'wp_ajax_nopriv_updatecomp', 'comp_function' );

// Sort Comps
function sort_comps() {
	$column = $_POST['column'];
	$order = strtoupper( $_POST['sort'] );
	$page = $_POST['page'] ? intval($_POST['page']) : 1;
	$dir = $_POST['dir'] ? $_POST['dir'] : false;

	if( $dir && $dir == 'next') {
		$page++;
	} elseif( $dir && $page >= 2 ) {
		$page--;
	}

	// When pressing NEXT and PREV, we don't want to FLIP the order, so let's flip the flip in order to be correct.
	// There's probably a better way, but eh. This works.
	if( $dir && $column != 'default' ) {
		switch( $order ) {
			case 'ASC':
				$order = 'DESC';
				break;
			case 'DESC':
				$order = 'ASC';
				break;
		}
	}

	$args = array(
		'post_type'				=> 'comp',
		'order'         	=> $order,
		'posts_per_page' 	=> 10,
		'paged'						=> $page,
		'tag__not_in'   	=> array('29')
	);

	if( $column == 'default' ) {
		$args['orderby'] = 'date';
	} else {
		$args['meta_query'] = array(
			'order_clause' => array(
				'key'	=> $column,
				'compare' => 'EXISTS',
			)
		);
		$args['orderby'] = 'order_clause';
	}

	$comp_query = new WP_Query( $args );

	if( $comp_query->have_posts() ) :
 		ob_start(); // start buffering because we do not need to print the posts now

		while( $comp_query->have_posts() ): $comp_query->the_post();
			get_template_part('template-parts/comp');
		endwhile;

 		$posts_html = ob_get_contents(); // we pass the posts to variable
   	ob_end_clean(); // clear the buffer
	else:
		$posts_html = '<li><p>There was an error retrieving your results.</p></li>';
	endif;

	// strip newlines away
	$string = trim(preg_replace('/\s+/', ' ', $posts_html));

	//echo $string;
	echo json_encode( array(
			'page' => $page,
			'max_page' => $comp_query->max_num_pages,
			'found_posts' => $comp_query->found_posts,
			'content' => $string
		) );

	die();
}
add_action( 'wp_ajax_sortcomps', 'sort_comps' );
add_action( 'wp_ajax_nopriv_sortcomps', 'sort_comps' );

function get_comp() {

	$post_id = $_POST['id'];

	$title = get_the_title( $post_id );
	$content = apply_filters('the_content', get_post_field('post_content', $post_id));

	$aircraft_meta = array(
		'make' 								=> 'Make',
		'model' 							=> 'Model',
		'serialnumber'				=> 'S/N',
		'registration'				=> 'Reg #',
		'year_mfr'						=> 'Year MFR',
		'year_del'						=> 'Year Delivered',
		'date_listed'					=> 'Date Listed',
		'date_sold'						=> 'Date Sold',
		'days_mkt'						=> 'Days on Market',
		'price_ask'						=> 'Asking Price',
		'price_sell'					=> 'Selling Price',
		'direct'							=> 'Directly Involved',
		'airframe_time'				=> 'Airframe Hours',
		'airframe_cycles'			=> 'Cycles / Landings',
		'airframe_program'		=> 'Airframe Program',
		'pax'									=> 'Passengers',
		'engine1_hours'				=> 'Engine 1 Hours',
		'engine2_hours'				=> 'Engine 2 Hours',
		'engine3_hours'				=> 'Engine 3 Hours',
		'engine_time'					=> 'Engine Time',
		'engine1_cycles'			=> 'Engine 1 Cycles',
		'engine2_cycles'			=> 'Engine 2 Cycles',
		'engine3_cycles'			=> 'Engine 3 Cycles',
		'engine_program'			=> 'Engine Program',
		'engine_coverage'			=> 'Engine Coverage',
		'apu_program'					=> 'MSP',
		'apu_model'						=> 'APU Model',
		'apu_hours'						=> 'APU Hours',
		'fms'									=> 'FMS',
		'inspections_cw'			=> 'Inspections c/w',
		'inspections_due'			=> 'Inspections Due',
		'paint_year'					=> 'Paint Year',
		'paint_condition'			=> 'Paint Condition',
		'paint_by'						=> 'Painted By',
		'interior_year'				=> 'Interior Year',
		'interior_condition'	=> 'Interior Condition',
		'interior_by'					=> 'Refurbished By',
		'compliant'						=> '2020 Compliant',
		'damage'							=> 'Damage?',
		'damage_337'					=> '337 Filed?',
	);

	$datakey = array(
		'engine_time'	=> array(
			'ttsn' => 'TTSN',
			'tsoh' => 'TSOH',
			'tcso' => 'TCSO',
			'tshi' => 'TSHI',
			'tcsh' => 'TCSH',
		),
		'engine_program' => array(
			'cmsp' => 'CMSP',
			'cc' => 'CorporateCare',
			'cce' => 'CorporateCare Enhanced',
			'csp' => 'CSP',
			'cspgold' => 'CSP Gold',
			'eap' => 'EAP Comprehensive',
			'emc2' => 'EMC2',
			'new' => 'EngiNEWity Citation Engine Program',
			'esp1' => 'ESP',
			'esp2' => 'ESP Gold',
			'esp3' => 'ESP Gold Flex',
			'esp4' => 'ESP Gold Lite',
			'esp5' => 'ESP Gold Lite Flex',
			'esp6' => 'ESP Platinum',
			'esp7' => 'ESP Silver',
			'esp8' => 'ESP Silver Flex',
			'esp9' => 'ESP Silver Lite',
			'fha' => 'FHA',
			'fmp' => 'FMP Maintenance',
			'jssi01' => 'JSSI',
			'jssi02' => 'JSSI - Complete',
			'jssi03' => 'JSSI - Essential',
			'jssi04' => 'JSSI - Essential LLC',
			'jssi05' => 'JSSI - Essential Select',
			'jssi06' => 'JSSI - Platinum',
			'jssi07' => 'JSSI - Premium',
			'jssi08' => 'JSSI - Premium Plus',
			'jssi09' => 'JSSI - Select',
			'jssi10' => 'JSSI - Term',
			'jssi11' => 'JSSI - Unscheduled',
			'jssi12' => 'JSSI+',
			'mcph' => 'Maintenance Cost Per Hour (MCPH)',
			'msp' => 'MSP',
			'mspgold' => 'MSP Gold',
			'point' => 'On-Point Solutions Program',
			'pbh' => 'PBH',
			'pa' => 'Power Advantage',
			'pap' => 'Power Advantage Plus',
			'pbhpower' => 'Powerplan Pay-By-Hour',
			'smart' => 'Smart Parts Engine',
			'smarter' => 'Smart Parts Plus',
			'tap' => 'TAP',
			'tapa' => 'TAP - Advantage',
			'tapab' => 'TAP - Advantage Blue',
			'tapac' => 'TAP - Advantage Blue Progressive',
			'tapad' => 'TAP - Advantage Elite',
			'tapb' => 'TAP - Blue',
			'tape' => 'TAP - Elite',
			'tapep' => 'TAP - Elite Progressive',
			'tapp' => 'TAP - Preferred',
			'ccc' => 'Triple Crown',
			'vmaxgold' => 'VMAX Gold Program',
			'vmax' => 'VMAX Program',
			'other' => 'Unknown',
		),
		'airframe_program' => array(
			'jssi' => 'JSSI Tip to Tail',
			'msg' => 'MSG-3',
			'proparts' => 'ProParts',
			'plus' => 'Support Plus+',
			'other' => 'Other',
		),
		'paint_condition' => array(
			'1' => 'Needs to be Redone',
			'2' => 'Major Wear',
			'3' => 'Detail Needed',
			'4' => 'Minimal Wear',
			'5' => 'Like-New',
		),
		'interior_condition' => array(
			'1' => 'Needs Replacement',
			'2' => 'Major Wear',
			'3' => 'Moderate Wear',
			'4' => 'Minimal Wear',
			'5' => 'Like-New',
		),
	);

	$aircraft = array();
	foreach( $aircraft_meta as $meta => $string ) {
		$aircraft[$meta] = get_post_meta( $post_id, $meta, true );
	}

	$fmt = numfmt_create( 'en_US', NumberFormatter::CURRENCY );
	$fmt->setTextAttribute( NumberFormatter::CURRENCY_CODE, 'USD');
	$fmt->setAttribute( NumberFormatter::FRACTION_DIGITS, 0);

	ob_start(); // start buffering because we do not need to print the posts now
	echo '<div class="titlebar"><h4>' . $title . '</h4><a href="#" class="close">&nbsp;</a></div>';
	echo '<div>';
	foreach( $aircraft as $id => $data ) {

		$section = false;
		$data_class = '';

		if( $data ) {
			// If Data Exists, we'll Format it Appropriately
			if( array_key_exists( $id, $datakey ) ) {
				// First let's grab data that's in an array and convert to readable string
				$formatted_data = $datakey[$id][$data];
			} else {
				// Now we'll do special formatting
				switch( $id ) {
					case 'date_listed':
						$date = new DateTime( $data );
						$formatted_data = date_format( $date, 'M j, Y' );
						break;
					case 'date_sold':
						$date = new DateTime( $data );
						$formatted_data = date_format( $date, 'M j, Y' );
						break;
					case 'price_ask':
						$formatted_data = is_numeric( $data ) ? $fmt->formatCurrency($data, 'USD') : ucwords( $data );
						break;
					case 'price_sell':
						$formatted_data = is_numeric( $data ) ? $fmt->formatCurrency($data, 'USD') : ucwords( $data );
						break;
					case 'engine1_hours':
						$time = $aircraft['engine_time'];
						$formatted_data = $data . ' ' . $datakey['engine_time'][$time];
						break;
					case 'engine2_hours':
						$time = $aircraft['engine_time'];
						$formatted_data = $data . ' ' . $datakey['engine_time'][$time];
						break;
					case 'engine3_hours':
						$time = $aircraft['engine_time'];
						$formatted_data = $data . ' ' . $datakey['engine_time'][$time];
						break;
					case 'engine_coverage':
						$formatted_data = $data . '%';
						break;
					default:
						$formatted_data = is_numeric( $data ) ? $data : ucwords( $data );
				}
			}
		} else {
			// If no data, hide the elements
			$data_class = ' blank';
			$formatted_data = '<i class="fas fa-times"></i>';
		}
		// Also, arbitrarily hide some stuff that we're displaying elsewhere
		if( $id == 'engine_time') {
			$data_class = ' blank';
		}
		if( $id == 'engine_program' && empty( $data ) ) {
			$hidecoverage = true;
		}
		if( $id == 'engine_coverage' && $hidecoverage ) {
			$data_class = ' blank';
		}

		// insert sections
		$sections = array('date_listed', 'airframe_time', 'engine1_hours', 'inspections_cw');
		if( in_array( $id, $sections ) ) {
			switch( $id ) {
				case 'date_listed':
					$section = 'Transaction';
					break;
				case 'airframe_time':
					$section = 'Airframe';
					break;
				case 'engine1_hours':
					$section = 'Engines & APU';
					break;
				case 'inspections_cw':
					$section = 'Condition';
					break;
				default:
					$section = false;
			}
		}
		if( $section ) {
			echo '<div class="data-section">' . $section . '</div>';
		}

		echo '<div class="data-item' . $data_class . '"><span class="key">' . $aircraft_meta[$id] . ':</span> <span class="dots"></span><span class="data">' . $formatted_data . '</span></div>';
	}

	if( !empty( $content ) ) {
		echo '<div class="data-section">Additional Notes</div>';
		echo '<div class="data-content">' . $content . '</div>';
	}
	echo '</div>';

	$html = ob_get_contents(); // we pass the posts to variable
	ob_end_clean(); // clear the buffer

	echo json_encode( array(
		'content' => $html
		) );

	die();
}
add_action( 'wp_ajax_getcomp', 'get_comp' );
add_action( 'wp_ajax_nopriv_getcomp', 'get_comp' );

// Save Mobile SMS Settings
function update_sms_settings() {

	$user = $_POST['user_id'];
	$sms_main = $_POST['mobile'] ?: get_user_meta($user, 'mepr_mobile', true);
	$sms_main_sanitized = stripPhoneNumber( $sms_main );
	$optout = $_POST['alert_optout'] ? true : false;

	// TODO need to run a check to see if the main contact has entered an alternate phone number into the system AFTER having previously saved their default number so that we can remove their original number but keep the new one.

	// First, let's update the global Opt-Out status
	update_user_meta( $user, 'mepr_alert_optout', $optout );

	// Text Magic
	global $tmApiClient;
	$list = '1399538'; // This is the Dealer Member List in TMSMS

	if ( $_POST['sms_enabled'] && !$optout ) {

		// Add Main Number to TMSMS List
		$search = implode( ', ', findContact( $sms_main_sanitized ) );
		if( $search ) {
			// IF CONTACT EXISTS, add to LIST
			$add = addToList( $list, $search );
		} else {
			// IF CONTACT DOES NOT EXIST, CREATE WITH LIST
			$username = get_user_meta($user, 'first_name', true) . get_user_meta($user, 'last_name', true);
			$newcontact = createContact( $username, $sms_main_sanitized, $list );
		}

		// Now save this info to Wordpress and Wild Apricot
		update_user_meta( $user, 'mepr_sms_enabled', true );
		update_user_meta( $user, 'mepr_sms_main', $sms_main_sanitized );

	} else {
		update_user_meta( $user, 'mepr_sms_enabled', false );
	}

	$oldlist = false;
	$employees = json_decode( get_user_meta( $user, 'mepr_employees', true ), true );
	sync_with_TextMagic( $user, $oldlist, $employees );

	wp_die( $user );

}
add_action( 'wp_ajax_updatemobilesettings', 'update_sms_settings' );
add_action( 'wp_ajax_nopriv_updatemobilesettings', 'update_sms_settings' );


// Save Employee Settings
function update_employees() {

	$user = $_POST['user_id'];
	$sms_ison = get_user_meta($user, 'mepr_sms_enabled', true);
	$employees = array();

	$i = 0;
	foreach( $_POST as $key => $value ) {
		// Is this a new phone number entry?
		if( strpos( $key, 'name' ) !== false ) {

			$index = substr( $key, -1 );
			$emailKey 	= 'email_' . $index;
			$titleKey 	= 'title_' . $index;
			$numberKey 	= 'number_' . $index;
			$smsKey 		= 'sms_enabled_' . $index;
			$alertKey 	= 'alert_enabled_' . $index;

			// Save Name and Number
			$employees[ $i ]['name'] = $value;
			$employees[ $i ]['title'] = $_POST[ $titleKey ] ? : '';
			$employees[ $i ]['number'] = stripPhoneNumber( $_POST[ $numberKey ] ) ? : '';
			$employees[ $i ]['email'] = $_POST[ $emailKey ] ? : '';
			$employees[ $i ]['sms_enabled'] = $_POST[ $smsKey ] ? true : false;
			$employees[ $i ]['alert_optout'] = $_POST[ $alertKey ] ? true : false;
			// Is this already a user?
			$ismember = get_user_by( 'email', $_POST[ $emailKey ] ) ? true : false;
			$employees[ $i ]['ismember'] = $ismember;

			$i++;
		}
	}

	$oldlist = get_user_meta( $user, 'mepr_employees', true );
	update_user_meta( $user, 'mepr_employees', json_encode( $employees ) );
	if( $sms_ison ) {
		sync_with_TextMagic( $user, $oldlist, $employees );
	}
	wp_die( $user );
}
add_action( 'wp_ajax_updateemployees', 'update_employees' );
add_action( 'wp_ajax_nopriv_updateemployees', 'update_employees' );


function sync_with_TextMagic( $user, $oldlistjson, $newlist ) {

	$oldlist = $oldlistjson ? json_decode( $oldlistjson, true ) : false;
	$sms_ison = get_user_meta($user, 'mepr_sms_enabled', true);
	$sms_main = get_user_meta($user, 'mepr_sms_main', true);

	// Text Magic
	global $tmApiClient;
	$list = '1399538'; // This is the Dealer Member List in TMSMS

	if( $sms_ison ) {

		// Get ONLY ENABLED Employees
		$numbersToAdd = array();
		foreach( $newlist as $employee ) {
			if( $employee['sms_enabled'] ) {
				$numbersToAdd[] = $employee;
			}
		}

		// Might we delete numbers?
		if( $oldlist ) {
			$count = count( $oldlist );
			$i = 0;

			while($i <= $count ) {
				$match = false;
				$oldnumber = $oldlist[$i]['number'] ? : '';

				if( $oldnumber ) {
					foreach( $numbersToAdd as $employee ) {
						if( $oldnumber == $employee['number'] ) {
							$match = true;
							break;
						}
					}
					if( !$match ) {
						// This number used to be included, but is not anymore. Purge from TMSMS List
						$search = implode( ', ', findContact( $oldnumber ) );
						if( $search ) {
							// Let's Remove that contact from the TMSMS List
							$delete = removeFromList( $list, $search );
						}
					}
				}
				$i++;
			}
		}

		// Add Employees to the List
		foreach( $numbersToAdd as $employee ) {
			$search = implode( ', ', findContact( $employee['number'] ) );
			if( $search ) {
				// IF CONTACT EXISTS, add to LIST
				$add = addToList( $list, $search );
			} else {
				// IF CONTACT DOES NOT EXIST, CREATE WITH LIST
				$newcontact = createContact( $employee['name'], $employee['number'], $list );
			}
		}

	} else {

		// Remove All Numbers from TMSMS List
		$purgeList = array();
		$purgeList[] = implode( ', ', findContact( $sms_main ) );
		foreach( $newlist as $employee ) {
			$purgeList[] = implode( ', ', findContact( $employee['number'] ) );
		}
		$purgeList = implode( ', ', $purgeList );
		removeFromList( $list, $purgeList );

	}
}

function get_all_member_emails() {
	$members = get_users( array(
		'role__in' => array( 'administrator', 'dealer', 'industry', 'managed' ),
		'fields' => array( 'ID', 'user_email' ),
	) );
	if( !empty( $members ) ) {
		$memberarray = array();
		foreach( $members as $member ) {
			//grab the member's email
			$memberarray[] = $member->user_email;
			//now see if we have team members to retrieve
			$team = json_decode( get_user_meta($member->ID, 'mepr_employees', true), true ) ?: false;
			if( $team ) {
				foreach( $team as $teammember ) {
					if( $teammember['email'] ) {
						//add each team member's email to the list
						$memberarray[] = $teammember['email'];
					}
				}
			}
		}
		return array_unique( $memberarray );
	} else {
		return false;
	}
}

// This functions with the OPTOUT status of Alerts
function get_all_member_names_and_emails() {
	$members = get_users( array(
		'role__in' => array( 'administrator', 'dealer', 'industry', 'managed' ),
		'fields' => array( 'ID', 'user_email' ),
	) );
	if( !empty( $members ) ) {
		$memberarray = array();
		foreach( $members as $member ) {
			//grab the member's name and email ( with OPTOUT )
			$optout = get_user_meta($member->ID, 'mepr_alert_optout', true) ? true : false;
			if( !$optout ) {
				$name = get_user_meta($member->ID, 'first_name', true) . ' ' . get_user_meta($member->ID, 'last_name', true);
				$memberarray[] = $name . ' <' . $member->user_email . '>';
				//now see if we have team members to retrieve
				$team = json_decode( get_user_meta($member->ID, 'mepr_employees', true), true ) ?: false;
				if( $team ) {
					foreach( $team as $teammember ) {
						if( $teammember['email'] && !$teammember['alert_optout'] ) {
							//add each team member's email to the list if enabled (optout is true, receive is false)
							$memberarray[] = $teammember['name'] . ' <' . $teammember['email'] . '>';
						}
					}
				}
			}
		}
		return array_unique( $memberarray );
	} else {
		return false;
	}
}

// Send Alert
function submit_new_alert() {

	if( $_POST['msg_content'] ) {

		$user_id = $_POST['user_id'];
		$title = sanitize_text_field( $_POST['msg_title'] );
		$message = stripslashes( sanitize_textarea_field( $_POST['msg_content'] ) );

		$alert = array(
			'post_type'     => 'alert',
			'post_title'    => $title,
			'post_content'  => $message,
			'post_status'   => 'publish',
			'post_author'   => $_POST['user_id'],
		);

		$test = false;
		if( $title == 'test' ) {
			$alert['post_status'] = 'draft';
			$test = true;
		}

		$post_id = wp_insert_post( $alert );
		send_alert( $post_id, $test );

	} else {
		$post_id = 'Error: No Message Content';
	}

	// Return to the Members Page
	wp_die( $post_id );

}
add_action( 'wp_ajax_sendalert', 'submit_new_alert' );
add_action( 'wp_ajax_nopriv_sendalert', 'submit_new_alert' );


function send_alert($post_id, $test = false) {

	$post = get_post( $post_id );
	$sender = $post->post_author;
	$title = $post->post_title;
	$message = $post->post_content;

	$alert = generate_alert_email( $sender, $message, $title );

	if( $test ) {
		$to_sms = 'dj2896081584467633@textmagic.com';
		$bcc = $alert['name'] . ' <' . $alert['email'] . '>';
	} else {
		$to_sms = 'eh2896081584467959@textmagic.com';
		$bcc_array = get_all_member_names_and_emails();
		$bcc = implode( ',', $bcc_array );
	}

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: GLADA Alerts <alerts@glada.aero>',
		'Reply-To: ' . $alert['name'] . ' <' . $alert['email'] . '>',
	);

	// Send Text Message
	wp_mail( $to_sms, $title, nl2br( strip_tags( $message )), $headers );

	//now add the List and send the email
	$headers[] = 'Bcc: ' . $bcc;
	wp_mail( 'admin@glada.aero', $title, $alert['content'], $headers );

}

function bounce_alert($post_id, $reason = '') {
	$post = get_post( $post_id );
	$title = 'Notice: Your Alert "' . $post->post_title . '" Could Not Be Sent';
	$sender = get_post_meta( $post_id, 'replyto', true );

	$to = is_email( $sender ) ? $sender : $post->post_author;

	switch( $reason ) {
		case 'expired':
			$sorry = '_uhoh';
			$message = 'Looks like there\'s an issue with your GLADA membership. Please Update or Renew your Membership information on the <a href="https://glada.aero/members">Members Dashboard</a> to enable sending and receiving Alerts on your account. Thanks!';
			break;
		case 'non-member':
			$sorry = '_sorry';
			$message = 'GLADA Alerts may only be sent by GLADA Members. To find out more about becoming a GLADA Member, visit <a href="https://www.glada.aero">Glada.aero</a> or simply reply to this email!';
			break;
		case 'timeout':
			$sorry = '_stop';
			$message = 'We love your enthusiasm, but please wait about 10 minutes before sending another Alert to avoid spamming the other Members. If you have more than one Wanted or Off-Market Aircraft to consider, we encourage you to send them all in the same Alert or space them out. Thanks!';
			break;
		default:
			$sorry = '_sorry';
			$message = 'Looks like there was an issue with authorizing this Alert. If you believe this is an error, simply reply to this email and we\'ll look into it. Thanks!';
			break;
	}

	$alert = generate_bounce_email( $message, $sorry );

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: GLADA Alerts <alerts@glada.aero>',
		'Reply-To: GLADA Admin <admin@glada.aero>',
		'Cc: GLADA Admin <admin@glada.aero>',
	);

	wp_mail( $sender, $title, $alert, $headers );

}

// Strip signature patterns from email content
function strip_sigs($post, $headers) {
	$content = $post['post_content'];

	$set_up_matches = array(
		'^--\s?[\r\n]?',
		'^--\s',
		'^---',
		'^\*--\*$',
		'^\*__\*$',
		'\[signature_[0-9]+',
		'\[signature_',
		'^From:\s?',
		'^De:\s?',
		'^Re:\s?',
		'^From:',
		'^De:',
		'^Re:',
		'^>\s?[\r\n]?',
		'^>\s',
		'^>',
		'^With Best Regards[.,\r\n]?',
		'^Best Regards[.,\r\n]?',
		'^Kind Regards[.,\r\n]?',
		'^Regards[.,\r\n]?',
		'^Sincerely[.,\r\n]?',
		'Thx[.,!\r\n]?',
		'Thks[.,!\r\n]?',
		'Thanks[.,!\r\n]?',
		'Thank You[.,!\r\n]?',
		'President & CEO[.,!\r\n]?',
		'Vice President[.,!\r\n]?',
		'VP of Aircraft Sales and Acquisitions[.,!\r\n]?',
		'^Sent from my iPhone',
		'^Enviado desde mi iPhone',
	);

	$matches = '/^--';
	foreach( $set_up_matches as $match ) {
		$matches .= '|' . $match;
	}
	$matches .= '/miu';

	$split = preg_split( $matches, $content );
	$post['post_content'] = $split[0];

	if (array_key_exists('sender', $headers)) {
		$from = $headers['sender']['mailbox'] . '@' . $headers['sender']['host'];
		$try = update_post_meta( $post['ID'], 'replyto', $from );
  } else {
		$try = update_post_meta( $post['ID'], 'headers', $headers );
	}

	return $post;
}
add_filter('postie_post_before', 'strip_sigs', 10, 2);

// https://postieplugin.com/extending/
function send_alert_after_import($post) {

		$bouncereason = '';

		// Membership EXPIRED and NON-MEMBER protection
		$author = new MeprUser( $post['post_author'] );
		$membership = $author->active_product_subscriptions('ids',true);
		if( empty( $membership ) ) {
			$bouncereason = 'expired';
		} else {
			foreach( $membership as $memb_id ) {
				if( $memb_id == '157' || $memb_id == '1416' ) {
					$bouncereason = 'non-member';
				}
			}
		}

		//we need some timeout protection, let's do a check on the author here
		// $recentposts = get_posts( array(
		// 	'post_type'		=> 'alert',
		// 	'post_status' => 'publish',
		// 	'author'			=> $post['post_author'],
		// 	'orderby'			=> 'post_date',
		// 	'order'				=> 'DESC',
		// 	'numberposts'	=> 5,
		// ) );
		// if( $recentposts ) {
		// 	foreach( $recentposts as $post ) {
		// 		$publishtime = new DateTime( $post->post_date );
		// 		$now = new DateTIme();
		// 		$diff = $publishtime->diff( $now );
		// 		$minutes = ($diff->format('%a') * 1440) + // total days converted to minutes
    //        				 ($diff->format('%h') * 60) +   // hours converted to minutes
    //         				$diff->format('%i');          // minutes
		// 		if( $minutes <= 30 ) {
		// 			$bouncereason = 'timeout';
		// 			break;
		// 		}
		// 	}
		// }

		// we also need AUTO REPLY protection
		// First let's build a Regex string search
		$set_up_matches = array(
			'Automatic reply',
			'AutoResponder',
			'Auto-Responder',
			'Auto Responder',
			'Auto responder',
			'Auto-responder',
			'Auto Reply',
			'Auto-Reply',
			'Auto reply',
			'Auto-reply',
			'AutoReply',
			'Autoreply',
			'Out of Office',
			'Out of office',
		);
		$matches = '/^--';
		$matches .= 'Automatic Reply';
		foreach( $set_up_matches as $match ) {
			$matches .= '|' . $match;
		}
		$matches .= '/miu';
		if( preg_match( $matches, $post['post_title'] ) ) {
			$bouncereason = 'autoreply';
		}

		if( $bouncereason ) {
			// Bounce it back. Unpublish the Post, send them why.
			wp_update_post( array( 'ID' => $post['ID'], 'post_status' => 'draft' ) );
			$try = update_post_meta( $post['ID'], 'bouncereason', $bouncereason );
			$post['post_status'] = 'draft';
			if( $bouncereason != 'autoreply' ) {
				// If this is an autoreply, we don't need to send a notice. Just kill it.
				// Otherwise, this function takes care of notifying them
				bounce_alert( $post['ID'], $bouncereason );
			}
		} else {
			send_alert( $post['ID'] );
		}

    return $post;
}
add_filter('postie_post_after', 'send_alert_after_import');

// Check to see if the Alert Email Sender has an account.
function alert_emailcheck($email) {
		$user = get_user_by_email( $email );
		if( $user ) {
			return $email;
		} else {
			// Sender isn't recognized. Let's compare domain names and see if we can find a match.
			$members = get_all_member_emails();
			if( !empty( $members ) ) {
				foreach( $members as $member ) {
					// Compare Sender to Members
					$sender_domain = explode('@', $email)[1];
					$member_domain = explode('@', $member)[1];

					if( $sender_domain == $member_domain ) {
						// yay, let's call this a success
						return $member;
					}
				}
			}
		}

		// If we made it this far, we couldn't find the email address. Postie should reject this based on settings
    return $email;
}
add_filter('postie_filter_email', 'alert_emailcheck');


// Multidimensional Array Search
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

//Format Phone Numbers
function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree.'-'.$lastFour;
    }
    return $phoneNumber;
}

function stripPhoneNumber( $phoneNumber ) {
	$phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);
	// If we only have 10 digits, add a leading "1"
	if(strlen($phoneNumber) == 10) {
		$phoneNumber = sprintf( "%'111d", $phoneNumber );
	}

	return $phoneNumber;
}


// LEAFLET -- SUBMIT AJAX FORM
function save_my_location() {

	$user = $_POST['user_id'];
	$latlng = $_POST['latlng'];
	$name = $_POST['loc_name'];

	$locations = get_user_meta( $user, 'mepr_locations', true ) ? json_decode( get_user_meta( $user, 'mepr_locations', true ), true ) : array();

	// check to see if this location already exists
	$new = true;
	if( $locations ) {
		foreach( $locations as $location ) {
			if( $location['latlng'] && $latlng == $location['latlng'] ) {
				$new = false;
				break;
			}
		}
	}

	if( $new ) {
		$latlngObject = json_decode( stripslashes($latlng) );
		$locations[] = array(
			'name' => $name,
			'latlng' => $latlngObject,
		);
		update_user_meta( $user, 'mepr_locations', json_encode( $locations ) );
	}
}
add_action( 'wp_ajax_savelocation', 'save_my_location' );
add_action( 'wp_ajax_nopriv_savelocation', 'save_my_location' );

// LEAFLET -- DELETE NODE AJAX FORM
function delete_map_node() {
	$user = $_POST['user_id'];
	$node = json_decode( stripslashes( $_POST['node'] ), true );

	$locations = json_decode( get_user_meta( $user, 'mepr_locations', true ), true );

	foreach( $locations as $key => $location ) {
		$thisnode = $location['latlng'];

		if( $node['lat'] == $thisnode['lat'] && $node['lng'] == $thisnode['lng'] ) {
			unset( $locations[$key] );
			update_user_meta( $user, 'mepr_locations', json_encode( $locations ) );
			break;
		}
	}
}
add_action( 'wp_ajax_deletenode', 'delete_map_node' );
add_action( 'wp_ajax_nopriv_deletenode', 'delete_map_node' );


// All Member Locations
function memberlocations() {
	$memberlocations = array();

	$user_query = new WP_User_Query(
		array(
			'role__in' => array(
				'dealer',
				'industry'
			),
			'meta_query'=> array(
				array(
					'key'=> 'mepr_locations',
					'compare' => 'EXISTS'
				)
			)
		)
	);

	if( !empty( $user_query->get_results() ) ) {
		foreach( $user_query->get_results() as $user ) {

			$loca = get_user_meta( $user->ID, 'mepr_locations', true );

			// the "Exists" check isn't enough - we need to make sure the array isn't empty
			if( $loca && isset( $loca ) ) {
				$name = get_user_meta( $user->ID, 'first_name', true ) . ' ' . get_user_meta( $user->ID, 'last_name', true );
				$link	= bp_core_get_user_domain( $user->ID );
				$comp = get_user_meta( $user->ID, 'mepr_company', true ) ? : '';
				$logo = bp_attachments_get_attachment( 'url', array( 'item_id' => $user->ID ) ) ? : '';

			  $memberlocations[] = array(
					'id'	=> $user->ID,
					'name' => $name,
					'link' => $link,
					'company' => $comp,
					'logo' => $logo,
					'locations' => $loca,
				);
			}
		}
	}

	return $memberlocations;
}

// Create Member Types for Buddypress
// https://codex.buddypress.org/developer/member-types/
function register_member_types() {
    bp_register_member_type( 'dealer', array(
        'labels' => array(
            'name'          => 'Dealer Members',
            'singular_name' => 'Dealer Member',
        ),
    ) );
		bp_register_member_type( 'industry', array(
        'labels' => array(
            'name'          => 'Industry Members',
            'singular_name' => 'Industry Member',
        ),
    ) );
		bp_register_member_type( 'child', array(
        'labels' => array(
            'name'          => 'Child Members',
            'singular_name' => 'Child Member',
        ),
    ) );
}
add_action( 'bp_register_member_types', 'register_member_types' );

// FILTER BUDDYPRESS MEMBER LOOP
function only_members( $retval ) {
	$retval['member_type'] = array( 'dealer', 'industry' );
	return $retval;
}
add_filter( 'bp_before_has_members_parse_args', 'only_members' );

// Going to do this for the AJAX Query String as well.
function modify_members_loop( $qs=false, $object=false ) {

  if ( $object != 'members' ) {
		return $qs;
	}

  $members =  get_users(
		array(
			'fields' => 'ID',
			'role__in' => array(
				'industry',
				'dealer',
			)
		) );

	$args = array(
		'include' => $members,
		'paged' => false,
		'per_page' => 50,
	);

  $qs = build_query($args);

  return $qs;
}
add_action( 'bp_ajax_querystring' , 'modify_members_loop', 25, 2 );

// // THE NOUVEAU THEME doesn't use this, so it's worthless. Modified the BP directory-nav.php instead
// function modify_total_member_count() {
//
// 	$members =  get_users(
// 		array(
// 			'fields' => ID,
// 			'role__in' => array(
// 				'industry',
// 				'dealer',
// 			)
// 		) );
// 		$count = count( $members );
//     return $count;
//
// }
// apply_filters( 'bp_get_total_member_count', 'modify_total_member_count', 25, 2 );
// apply_filters( 'bp_get_active_member_count', 'modify_total_member_count', 25, 2 );

/**
 * Reporting Tool
 */
function diagnostic_function() {

		$user_id = $_POST['user'];

		$userObj = get_userdata( $user_id );
		$userMeta = get_user_meta( $user_id );
		//$wa_ID = contactExists( $userObj->data->user_email ) ? : $userMeta['mepr__waid'][0];

		ob_start(); // start buffering because we're not printing yet

		if( $userObj ) {

			// Let's get MemberPress
			$member = new MeprUser( $user_id ); // Get Membership User Info
			//$sub_ids    = $member->current_and_prior_subscriptions(); //returns an array of Product ID's the user has ever been subscribed to
			//$activesubs = $member->active_product_subscriptions('ids'); // self-explanatory

			// Instanciate Wild Apricot API
		  // global $waApiClient;
		  // global $accountUrl;
			//
		  // $waApiClient = WaApiClient::getInstance();
		  // try {
		  //   $waApiClient->initTokenByApiKey('gnb9yn2costjf4ynocej1qpz80402o');
		  //   // $waApiClient->initTokenByContactCredentials('admin@yourdomain.com', 'your_password');
		  // } catch (Exception $e) {
		  //   $error = $e->getMessage();
		  // }
		  // Get API URL using API KEY
		  // $account = getAccountDetails();
		  // $accountUrl = $account['Url'];

			echo '<div>';
				echo '<div class="response-container">';

					$newlogo = bp_attachments_get_attachment( 'url', array( 'item_id' => $user_id ) );
					echo '<img style="max-width:200px;position:absolute;top:0;right:2em;" src="' . $newlogo . '">';
					echo '<h1>' . $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0] . '</h1>';

					$industry = array( 20, 589, 247, 587, 1020 );
					$dealer = array( 19, 588, 232, 580, 1268, 1499, 1307 );

					foreach( $activesubs as $memb ) {
						if( in_array( $memb, $industry ) ) {
							$membType = 'industry';
						} elseif( in_array( $memb, $dealer ) ) {
							$membType = 'dealer';
						} else {
							$membType = 'applicant';
						}
						echo '<h3>' . ucwords( $membType ) . ' Member - Sub ID: ' . $memb . '</h3><br>';
					}

					///////////////////////////////////////////////////////////////

					// WILD APRICOT MEMBERSHIP
					// echo '<div class="wa">';
					// echo '<h4 style="margin-top:1em;">Wild Apricot</h4>';
					//
					// sync_memberships( $user_id, $waApiClient, $wa_ID, true );
					//
					// echo '</div>';
					//
					// /////////////////////////////////////////////////////////////////
					//
					// echo '<div class="lower">';
					// echo '<div>';
					// echo '<h4 style="margin-top:1em;">Sync Finances</h4>';
					//
					// sync_finances( $user_id, $waApiClient, $wa_ID, true );
					//
					// echo '</div>';

					//////////////////////////////////////////////////////////////

					//Test some Buddypress Stuff
					echo '<div>';
					echo '<h4 style="margin-top:1em;">Sync with Buddypress</h4>';
					$buddypressKey = array(
						'Company Name'    => 'mepr_company',
						'Title'           => 'mepr_title',
						'Website'         => 'mepr_company_website',
						'Phone Number'    => 'mepr_phone_number',
						'Fax Number'      => 'mepr_fax',
						'Mobile Number'   => 'mepr_mobile',
						'Industry Type'   => 'mepr_industry_type',
						'Aviation Association Memberships and Affiliations' => 'mepr_aviation_associations_memberships_and_affiliations',
					);

					foreach( $buddypressKey as $bp => $wp ) {
						if ( xprofile_get_field_id_from_name( $bp ) ) {
							$field_value = $userMeta[ $wp ][0];
							if( $field_value ) {
								echo 'Set <span>' . $bp . '</span> to ' . $field_value . '<br>';
								xprofile_set_field_data($bp, $user_id, $field_value);
							} else {
								echo '- No data for ' . $bp . '<br>';
							}
						}
					}

					$roles = $userObj->roles;
					if( in_array( 'managed', $roles )) {
						$child = true;
					}

					$appType = strtolower( $userMeta['mepr_membership_type'][0] );
					$buddypressType = bp_get_member_type( $user_id );

					// Let's double-check that we're working on the correct Membership Level
					if( $child ) {
						bp_set_member_type( $user_id, 'child' );
						echo '<br>Member is a Child Account';
					} elseif( $membType == $appType ) {
						// First lets set the Buddypress Membership Type
						if( $appType != $buddypressType ) {
							bp_set_member_type( $user_id, $appType );
						}
						echo '<br>BP Member Type is ' . $appType;
						// Then join the appropriate Group. We'll automate this later.
						$groups = array(
							'dealer' => 1,
							'industry' => 2,
						);
						$join = groups_join_group( $groups[$membType], $user_id );
						if( $join ) {
							echo '<br>Joined ' . ucwords( $membType ) . ' Group.';
						}
					} else {
						echo '<br>Application Type mis-match. Cannot set Buddypress Type.';
						echo '<br>Diagnostic: Memb = ' . $membType . ' - App = ' . $appType;
					}

					// Set Last Activity to Last Login
					$last_activity = bp_get_user_last_activity( $user_id );
					if( !$last_activity ) {
						$time = $member->get_last_login_data();
						bp_update_user_last_activity( $user_id, $time->created_at );
						echo '<br>Last Active Time Updated to ' . $time->created_at . '<br>';
					} else {
						echo '<br>Last Activity: ' . $last_activity . '<br>';
					}
					echo '</div>';

					echo '</div>';
				echo '</div>';
			echo '</div>';

		} else {
			echo 'User does not exist.';
		}

		$all_the_html = ob_get_contents(); // save what's in the buffer
   	ob_end_clean(); // clean up

		echo json_encode( array(
			'content' => $all_the_html
		) );
		wp_die();
}
add_action( 'wp_ajax_userdiagnostic', 'diagnostic_function' );
add_action( 'wp_ajax_nopriv_userdiagnostic', 'diagnostic_function' );


function approve_function() {

	$user_id = $_POST['user'];

	$u = new WP_User( $user_id );
	$u->remove_role( 'applicant' );
	$u->add_role( 'approved' );

	// send notification?
	echo json_encode( array(
		'user' => $u
	) );
	wp_die();
}
add_action( 'wp_ajax_approvemember', 'approve_function' );
add_action( 'wp_ajax_nopriv_approvemember', 'approve_function' );


// Convert a random ascii string into a usable number
function toNumber($ascii) {
    if (( $str_array = str_split( $ascii ))) {
			$num = '';
			foreach( $str_array as $char ) {
				$num .= ord($char);
			}
			return substr( $num, -5 );
		} else {
			return mt_rand(999,99999);
		}
}

// Upload for Specsheet
function upload_specsheet() {

		$post_id = $_POST['post_id'];

		if (!function_exists('wp_generate_attachment_metadata')){
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		}
		if($_FILES) {
			foreach ($_FILES as $file => $array) {
				if($_FILES[$file]['error'] !== UPLOAD_ERR_OK){return "upload error : " . $_FILES[$file]['error'];} //If upload error

				$attach_id = media_handle_upload($file, 0);

				$updated_post = array(
					'ID' 						=> $post_id,
					'meta_input'   	=> array()
				);
				$updated_post['meta_input']['pdf'] = $attach_id;

				$post_id = wp_update_post( $updated_post, true );
				// if (is_wp_error($post_id)) {
				// 		$errors = $post_id->get_error_messages();
				// 		foreach ($errors as $error) {
				// 				echo $error;
				// 		}
				// }
			}
		}
		wp_redirect( $_SERVER['HTTP_REFERER'] );
}
add_action( 'admin_post_upload_specsheet', 'upload_specsheet' );
add_action( 'admin_post_nopriv_upload_specsheet', 'upload_specsheet' );

// New Featured Image
function upload_featuredimage() {

		$post_id = $_POST['post_id'];

		if (!function_exists('wp_generate_attachment_metadata')){
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		}
		if($_FILES) {
			foreach ($_FILES as $file => $array) {
				if($_FILES[$file]['error'] !== UPLOAD_ERR_OK){return "upload error : " . $_FILES[$file]['error'];} //If upload error

				$attach_id = media_handle_upload($file, 0);
				set_post_thumbnail( $post_id, $attach_id );
			}
		}
		wp_redirect( $_SERVER['HTTP_REFERER'] );
}
add_action( 'admin_post_upload_featuredimage', 'upload_featuredimage' );
add_action( 'admin_post_nopriv_upload_featuredimage', 'upload_featuredimage' );


// Exclude "Deleted" Posts
function exclude_deleted_posts( $query ) {
    if ( !is_admin() && $query->is_main_query() ) {
        $query->set( 'tag__not_in', array('29') );
    }
}
add_action( 'pre_get_posts', 'exclude_deleted_posts' );

// Exclude Off-Market Listings on Listings Page
// Turn off Pagination of Opps page
function exclude_offmarket_listings( $query ) {
    if ( !is_admin() && is_post_type_archive('listing') && $query->is_main_query() ) {
				$query->set( 'tax_query', array(
							array(
								'taxonomy' => 'marketstatus',
								'terms' => array('contract', 'offmarket'),
								'field' => 'slug',
								'operator' => 'NOT IN'
							),
						)
				);
    		$query->query_vars['order'] = 'DESC';
				$query->query_vars['orderby'] = 'year_clause';
				$query->query_vars['meta_query'] = array(
					 'year_clause' => array(
								'key' => 'year',
								'compare' => 'EXISTS',
								'type' => 'NUMERIC'
						)
				);
    }
		if ( is_post_type_archive('opportunity') && $query->is_main_query() ) {
				$query->query_vars['paged'] = false;
				$query->query_vars['posts_per_page'] = 50;
				$query->query_vars['order'] = 'DESC';
				$query->query_vars['orderby'] = 'date';
		}
}
add_action( 'pre_get_posts', 'exclude_offmarket_listings' );

// Change Password Reset Timeout
add_filter( 'password_reset_expiration', function( $expiration ) {
    return MONTH_IN_SECONDS;
});

// Admin Styles
function admin_style() {
  wp_enqueue_style('admin-fontawesome', get_template_directory_uri().'/vendor/css/all.css', array(), '20151215');
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css', array(), '20151222');
}
add_action('admin_enqueue_scripts', 'admin_style');

// test stuff
// add_filter( 'body_class', function( $classes ) {
// 	if( is_page(1148) || is_page(1487) ) {
// 		return array_merge( $classes, array( 'page-aboutus' ) );
// 	} else {
// 		return $classes;
// 	}
// } );
