<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _glad
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ta_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds page slug to single pages.
	if ( is_singular( 'page' ) ) {
		global $post;
		$classes[] = 'page-' . $post->post_name;
	}

	return $classes;
}
add_filter( 'body_class', 'ta_body_classes' );


/**
 * Get all top-level menu items of a selected menu. Includes active class
 */
function ta_get_menu_parent_children( $menu_name, $rel = 'parent' ) {

	// Find the menu
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
	    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	    $menu_items = wp_get_nav_menu_items( $menu->term_id );

			// get the menu item ID of the current page
			$post = get_the_id();
			foreach( $menu_items as $current ) {
        if( $post == $current->object_id ) {
					if ( !$current->menu_item_parent ) {
						$post=$current->ID;
					}
					else {
						$post=$current->menu_item_parent;
					}
					break;
				}
    	}

			if ( $rel=='children' ) {
				// If menu relationship parameter is 'children', just get the children menu items belonging to the current post
				$menu_list = '<ul id="menu-' . $menu_name . '-children">';
				foreach ( (array) $menu_items as $key => $item ) {
					if ($item->menu_item_parent==$post) {
						$title = $item->title;
		        $url = $item->url;
		        $menu_list .= '<li class="' . $active_class . '"><a href="' . $url . '">' . $title . '</a></li>';
					}
				}
			} else {
				// If the menu relationship is not 'children', get only the parent items belonging to the menu
				$menu_list = '<ul id="menu-' . $menu_name . '">';
				foreach ( (array) $menu_items as $key => $item ) {
					if (empty( $item->menu_item_parent )) {
						$item->ID==$post ? $active_class='active' : $active_class=''; //Set active class
						$title = $item->title;
		        $url = $item->url;
		        $menu_list .= '<li class="' . $active_class . '"><a href="' . $url . '">' . $title . '</a></li>';
					}
				}
			}
			$menu_list .= '</ul>';

	} else {
			// We didn't find a menu in that location
	    $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
	}
	// $menu_list now ready to output
	return $menu_list;
}


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ta_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ta_pingback_header' );
