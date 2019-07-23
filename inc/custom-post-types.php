<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _glad
 */

/**
 * Adds custom classes to the array of body classes.
 */

 // Register Custom Post Type
 function register_custom_posts() {

   $labels = array(
 		'name'                  => _x( 'Listings', 'Post Type General Name', '_glad' ),
 		'singular_name'         => _x( 'Listing', 'Post Type Singular Name', '_glad' ),
 		'menu_name'             => __( 'Listings', '_glad' ),
 		'name_admin_bar'        => __( 'Listings', '_glad' ),
 		'archives'              => __( 'Listings', '_glad' ),
 		'attributes'            => __( 'Listing Details', '_glad' ),
 		'parent_item_colon'     => __( 'Parent Listing:', '_glad' ),
 		'all_items'             => __( 'All Listings', '_glad' ),
 		'add_new_item'          => __( 'Add New Listing', '_glad' ),
 		'add_new'               => __( 'Add New', '_glad' ),
 		'new_item'              => __( 'New Listing', '_glad' ),
 		'edit_item'             => __( 'Edit Listing', '_glad' ),
 		'update_item'           => __( 'Update Listing', '_glad' ),
 		'view_item'             => __( 'View Listing', '_glad' ),
 		'view_items'            => __( 'View Listings', '_glad' ),
 		'search_items'          => __( 'Search Listing', '_glad' ),
 		'not_found'             => __( 'Not found', '_glad' ),
 		'not_found_in_trash'    => __( 'Not found in Trash', '_glad' ),
 		'featured_image'        => __( 'Featured Image', '_glad' ),
 		'set_featured_image'    => __( 'Set featured image', '_glad' ),
 		'remove_featured_image' => __( 'Remove featured image', '_glad' ),
 		'use_featured_image'    => __( 'Use as featured image', '_glad' ),
 		'insert_into_item'      => __( 'Insert into item', '_glad' ),
 		'uploaded_to_this_item' => __( 'Uploaded to this item', '_glad' ),
 		'items_list'            => __( 'Items list', '_glad' ),
 		'items_list_navigation' => __( 'Items list navigation', '_glad' ),
 		'filter_items_list'     => __( 'Filter items list', '_glad' ),
 	);
  $rewrite = array(
		'slug'                  => 'listings',
		'with_front'            => false,
		'pages'                 => true,
		'feeds'                 => true,
	);
 	$args = array(
 		'label'                 => __( 'Listing', '_glad' ),
 		'description'           => __( 'Member-Submitted Aircraft Listings', '_glad' ),
 		'labels'                => $labels,
 		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes' ),
 		'taxonomies'            => array( 'aircraft', 'marketstatus', 'post_tag' ),
 		'hierarchical'          => false,
 		'public'                => true,
 		'show_ui'               => true,
 		'show_in_menu'          => true,
 		'menu_position'         => 10,
 		'menu_icon'             => 'dashicons-images-alt',
 		'show_in_admin_bar'     => true,
 		'show_in_nav_menus'     => true,
 		'can_export'            => true,
 		'has_archive'           => true,
 		'exclude_from_search'   => false,
 		'publicly_queryable'    => true,
    'rewrite'               => $rewrite,
 		'capability_type'       => 'page',
 	);
 	register_post_type( 'listing', $args );

  $labels = array(
   'name'                  => _x( 'Aircraft Opportunities', 'Post Type General Name', '_glad' ),
   'singular_name'         => _x( 'Aircraft Opportunity', 'Post Type Singular Name', '_glad' ),
   'menu_name'             => __( 'Opportunities', '_glad' ),
   'name_admin_bar'        => __( 'Opportunities', '_glad' ),
   'archives'              => __( 'Aircraft Opportunities', '_glad' ),
   'attributes'            => __( 'Opportunity Details', '_glad' ),
   'parent_item_colon'     => __( 'Parent Listing:', '_glad' ),
   'all_items'             => __( 'All Opportunities', '_glad' ),
   'add_new_item'          => __( 'Add New Opportunity', '_glad' ),
   'add_new'               => __( 'Add New', '_glad' ),
   'new_item'              => __( 'New Opportunity', '_glad' ),
   'edit_item'             => __( 'Edit Opportunity', '_glad' ),
   'update_item'           => __( 'Update Opportunity', '_glad' ),
   'view_item'             => __( 'View Opportunity', '_glad' ),
   'view_items'            => __( 'View Opportunities', '_glad' ),
   'search_items'          => __( 'Search Opportunity', '_glad' ),
   'not_found'             => __( 'Not found', '_glad' ),
   'not_found_in_trash'    => __( 'Not found in Trash', '_glad' ),
   'featured_image'        => __( 'Featured Image', '_glad' ),
   'set_featured_image'    => __( 'Set featured image', '_glad' ),
   'remove_featured_image' => __( 'Remove featured image', '_glad' ),
   'use_featured_image'    => __( 'Use as featured image', '_glad' ),
   'insert_into_item'      => __( 'Insert into item', '_glad' ),
   'uploaded_to_this_item' => __( 'Uploaded to this item', '_glad' ),
   'items_list'            => __( 'Items list', '_glad' ),
   'items_list_navigation' => __( 'Items list navigation', '_glad' ),
   'filter_items_list'     => __( 'Filter items list', '_glad' ),
 );
 $rewrite = array(
   'slug'                  => 'opportunities',
   'with_front'            => false,
   'pages'                 => true,
   'feeds'                 => true,
 );
 $args = array(
   'label'                 => __( 'Opportunity', '_glad' ),
   'description'           => __( 'Member-Submitted Aircraft Opportunity Listings', '_glad' ),
   'labels'                => $labels,
   'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes' ),
   'taxonomies'            => array( 'aircraft', 'category', 'post_tag' ),
   'hierarchical'          => false,
   'public'                => true,
   'show_ui'               => true,
   'show_in_menu'          => true,
   'menu_position'         => 10,
   'menu_icon'             => 'dashicons-tag',
   'show_in_admin_bar'     => true,
   'show_in_nav_menus'     => true,
   'can_export'            => true,
   'has_archive'           => true,
   'exclude_from_search'   => false,
   'publicly_queryable'    => true,
   'rewrite'               => $rewrite,
   'capability_type'       => 'page',
 );
 register_post_type( 'opportunity', $args );

	$labels = array(
		'name'                  => _x( 'People', 'Post Type General Name', '_glad' ),
		'singular_name'         => _x( 'Person', 'Post Type Singular Name', '_glad' ),
		'menu_name'             => __( 'People', '_glad' ),
		'name_admin_bar'        => __( 'People', '_glad' ),
		'archives'              => __( 'Peson Archives', '_glad' ),
		'attributes'            => __( 'Person Attributes', '_glad' ),
		'parent_item_colon'     => __( 'Parent:', '_glad' ),
		'all_items'             => __( 'All People', '_glad' ),
		'add_new_item'          => __( 'Add New Person', '_glad' ),
		'add_new'               => __( 'Add New Person', '_glad' ),
		'new_item'              => __( 'New Person', '_glad' ),
		'edit_item'             => __( 'Edit Person', '_glad' ),
		'update_item'           => __( 'Update Person', '_glad' ),
		'view_item'             => __( 'View Person', '_glad' ),
		'view_items'            => __( 'View People', '_glad' ),
		'search_items'          => __( 'Search Person', '_glad' ),
		'not_found'             => __( 'Person Not found', '_glad' ),
		'not_found_in_trash'    => __( 'Not found in Trash', '_glad' ),
		'featured_image'        => __( 'Headshot', '_glad' ),
		'set_featured_image'    => __( 'Set headshot', '_glad' ),
		'remove_featured_image' => __( 'Remove headshot', '_glad' ),
		'use_featured_image'    => __( 'Use as headshot', '_glad' ),
		'insert_into_item'      => __( 'Insert into item', '_glad' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', '_glad' ),
		'items_list'            => __( 'Items list', '_glad' ),
		'items_list_navigation' => __( 'Items list navigation', '_glad' ),
		'filter_items_list'     => __( 'Filter items list', '_glad' ),
	);
	$args = array(
		'label'                 => __( 'Person', '_glad' ),
		'description'           => __( 'GLAD Owners', '_glad' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 30,
		'menu_icon'             => 'dashicons-admin-users',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
    'rewrite'               => array( 'with_front' => false ),
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'people', $args );

 }
 add_action( 'init', 'register_custom_posts', 0 );


 // CUSTOM FIELDS
 ///////////////////////////////////////////////////////////////////////////////
 //www.taniarascia.com/wordpress-part-three-custom-fields-and-metaboxes/

// PEOPLE
// Add People Meta Box
function add_people_meta_box() {
 add_meta_box(
   'people_meta_box', // $id
   'Additional Information', // $title
   'show_person_meta_box', // $callback
   'people', // post type
   'normal', // $context
   'high' // $priority
 );
}
add_action( 'add_meta_boxes', 'add_people_meta_box' );

// Show People Custom Fields
function show_person_meta_box() {
 global $post;
   $meta = get_post_meta( $post->ID, 'person_fields', true ); ?>

 <input type="hidden" name="people_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

   <!-- All fields will go here -->
   <div style="width: 100%; padding-left: 1em;">
     <p class="regular-text" style="margin-bottom:0;">Show on Contact Page</p>
     <br>
     <input type="radio" id="person_fields_show_1" name="person_fields[show]" value="Yes" <?php echo $meta['show']=='Yes'?'checked':''; ?>>
     <label for="person_fields_show_1">Yes</label>
     <input type="radio" id="person_fields_show_2" name="person_fields[show]" value="No" <?php echo $meta['show']=='No'?'checked':''; ?>>
     <label for="person_fields_show_2">No</label>
   </div>
   <div style="display:flex; flex-wrap:wrap;">
     <p style="margin: 1em;">
       <label for="person_fields[jobtitle]">Job Title</label>
       <br>
       <input type="text" name="person_fields[jobtitle]" id="person_fields[jobtitle]" class="regular-text" value="<?php echo $meta['jobtitle']; ?>">
     </p>
     <p style="margin: 1em;">
       <label for="person_fields[phone]">Phone Number</label>
       <br>
       <input type="text" name="person_fields[phone]" id="person_fields[phone]" class="regular-text" value="<?php echo $meta['phone']; ?>">
     </p>
     <p style="margin: 1em;">
       <label for="person_fields[email]">Email Address</label>
       <br>
       <input type="text" name="person_fields[email]" id="person_fields[email]" class="regular-text" value="<?php echo $meta['email']; ?>">
     </p>
     <p style="margin: 1em;">
       <label for="person_fields[mailto]">Mailto Subject Line</label>
       <br>
       <input type="text" name="person_fields[mailto]" id="person_fields[mailto]" class="regular-text" value="<?php echo $meta['mailto']; ?>">
     </p>
   </div>

 <?php }

// Save People Custom Fields
function save_people_fields_meta( $post_id ) {
 // verify nonce
 if ( !wp_verify_nonce( $_POST['people_meta_box_nonce'], basename(__FILE__) ) ) {
   return $post_id;
 }
 // check autosave
 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
   return $post_id;
 }
 // check permissions
 if ( 'people' === $_POST['post_type'] ) {
   if ( !current_user_can( 'edit_page', $post_id ) ) {
     return $post_id;
   } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
     return $post_id;
   }
 }

 $old = get_post_meta( $post_id, 'person_fields', true );
 $new = $_POST['person_fields'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'person_fields', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'person_fields', $old );
 }
}
add_action( 'save_post', 'save_people_fields_meta' );

// AIRCRAFT
// Add Aircraft Meta Box to LISTING and OPPORTUNITY
function add_listing_meta_box() {
$post_types = array ( 'listing', 'opportunity' );
foreach( $post_types as $post_type )
  {
    add_meta_box(
      'listing_meta_box', // $id
      'Aircraft Information', // $title
      'show_listing_meta_box', // $callback
      $post_type, // post type
      'normal', // $context
      'high' // $priority
    );
  }
}
add_action( 'add_meta_boxes', 'add_listing_meta_box' );

// Show Aircraft Custom Fields
function show_listing_meta_box() {
 global $post; ?>

 <input type="hidden" name="listing_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

   <!-- All fields will go here -->
   <div style="display:flex; flex-wrap:wrap;">
     <p style="margin: 1em;">
       <label for="serialnumber">Serial Number</label>
       <br>
       <input type="text" name="serialnumber" id="serialnumber" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'serialnumber', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="registration">Registration</label>
       <br>
       <input type="text" name="registration" id="registration" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'registration', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="year">Model Year</label>
       <br>
       <input type="text" name="year" id="year" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'year', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="make">Make</label>
       <br>
       <input type="text" name="make" id="make" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'make', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="model">Model</label>
       <br>
       <input type="text" name="model" id="model" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'model', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="landings">Landings</label>
       <br>
       <input type="text" name="landings" id="landings" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'landings', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="aftt">Total Time</label>
       <br>
       <select name="aftt" id="aftt">
         <?php $selected = get_post_meta( $post->ID, 'aftt', true ); ?>
         <option value="aftt" <?php selected( $selected, 'aftt' ); ?>>Aircraft Frame Total Time</option>
         <option value="ttsn" <?php selected( $selected, 'ttsn' ); ?>>Total Time Since New</option>
         <option value="tsoh" <?php selected( $selected, 'tsoh' ); ?>>Time Since Overhaul</option>
       </select>
     </p>
     <p style="margin: 1em;">
       <label for="aftt-number">Hours</label>
       <br>
       <input type="text" name="aftt-number" id="aftt-number" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'aftt-number', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="contactname">Contact Name</label>
       <br>
       <input type="text" name="contactname" id="contactname" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'contactname', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="contactnumber">Contact Phone Number</label>
       <br>
       <input type="tel" name="contactnumber" id="contactnumber" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'contactnumber', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="contactemail">Contact Email</label>
       <br>
       <input type="email" name="contactemail" id="contactemail" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'contactemail', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="url">Specsheet or Website URL</label>
       <br>
       <input type="url" name="url" id="url" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'url', true ); ?>">
     </p>
   </div>

 <?php }

// Save Listing Custom Fields
function save_listing_fields_meta( $post_id ) {
 // verify nonce
 if ( !wp_verify_nonce( $_POST['listing_meta_box_nonce'], basename(__FILE__) ) ) {
   return $post_id;
 }
 // check autosave
 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
   return $post_id;
 }
 // check permissions
 if ( 'listing' === $_POST['post_type'] || 'opportunity' === $_POST['post_type'] ) {
   if ( !current_user_can( 'edit_page', $post_id ) ) {
     return $post_id;
   } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
     return $post_id;
   }
 }

 // save sn
 $old = get_post_meta( $post_id, 'serialnumber', true );
 $new = $_POST['serialnumber'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'serialnumber', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'serialnumber', $old );
 }

 // save reg
 $old = get_post_meta( $post_id, 'registration', true );
 $new = $_POST['registration'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'registration', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'registration', $old );
 }

 // save year
 $old = get_post_meta( $post_id, 'year', true );
 $new = $_POST['year'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'year', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'year', $old );
 }

 // save make
 $old = get_post_meta( $post_id, 'make', true );
 $new = $_POST['make'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'make', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'make', $old );
 }

 // save model
 $old = get_post_meta( $post_id, 'model', true );
 $new = $_POST['model'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'model', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'model', $old );
 }

 // save landings
 $old = get_post_meta( $post_id, 'landings', true );
 $new = $_POST['landings'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'landings', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'landings', $old );
 }

 // save aftt
 $old = get_post_meta( $post_id, 'aftt', true );
 $new = $_POST['aftt'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'aftt', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'aftt', $old );
 }

 // save aftt-number
 $old = get_post_meta( $post_id, 'aftt-number', true );
 $new = $_POST['aftt-number'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'aftt-number', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'aftt-number', $old );
 }

 // save contactname
 $old = get_post_meta( $post_id, 'contactname', true );
 $new = $_POST['contactname'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'contactname', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'contactname', $old );
 }

 // save contactnumber
 $old = get_post_meta( $post_id, 'contactnumber', true );
 $new = $_POST['contactnumber'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'contactnumber', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'contactnumber', $old );
 }

 // save contactemail
 $old = get_post_meta( $post_id, 'contactemail', true );
 $new = $_POST['contactemail'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'contactemail', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'contactemail', $old );
 }

 // save url
 $old = get_post_meta( $post_id, 'url', true );
 $new = $_POST['url'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'url', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'url', $old );
 }

}
add_action( 'save_post', 'save_listing_fields_meta' );

// CUSTOM TAXONOMIES
// Register Custom Taxonomy
function register_custom_taxonomies() {

	$labels = array(
		'name'                       => _x( 'Aircraft Types', 'Taxonomy General Name', '_glad' ),
		'singular_name'              => _x( 'Aircraft Type', 'Taxonomy Singular Name', '_glad' ),
		'menu_name'                  => __( 'Aircraft Type', '_glad' ),
		'all_items'                  => __( 'All Aircraft Types', '_glad' ),
		'parent_item'                => __( 'Parent Item', '_glad' ),
		'parent_item_colon'          => __( 'Parent Item:', '_glad' ),
		'new_item_name'              => __( 'New Aircraft Type', '_glad' ),
		'add_new_item'               => __( 'Add New Aircraft Type', '_glad' ),
		'edit_item'                  => __( 'Edit Item', '_glad' ),
		'update_item'                => __( 'Update Item', '_glad' ),
		'view_item'                  => __( 'View Item', '_glad' ),
		'separate_items_with_commas' => __( 'Separate items with commas', '_glad' ),
		'add_or_remove_items'        => __( 'Add or remove items', '_glad' ),
		'choose_from_most_used'      => __( 'Choose from the most used', '_glad' ),
		'popular_items'              => __( 'Popular Items', '_glad' ),
		'search_items'               => __( 'Search Items', '_glad' ),
		'not_found'                  => __( 'Not Found', '_glad' ),
		'no_terms'                   => __( 'No items', '_glad' ),
		'items_list'                 => __( 'Items list', '_glad' ),
		'items_list_navigation'      => __( 'Items list navigation', '_glad' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'aircraft', array( 'listing', 'opportunity' ), $args );

  $labels = array(
    'name'                       => _x( 'Market Status', 'Taxonomy General Name', '_glad' ),
    'singular_name'              => _x( 'Market Status', 'Taxonomy Singular Name', '_glad' ),
    'menu_name'                  => __( 'Market Status', '_glad' ),
    'all_items'                  => __( 'All Types', '_glad' ),
    'parent_item'                => __( 'Parent Item', '_glad' ),
    'parent_item_colon'          => __( 'Parent Item:', '_glad' ),
    'new_item_name'              => __( 'New Status', '_glad' ),
    'add_new_item'               => __( 'Add New Status', '_glad' ),
    'edit_item'                  => __( 'Edit Item', '_glad' ),
    'update_item'                => __( 'Update Item', '_glad' ),
    'view_item'                  => __( 'View Item', '_glad' ),
    'separate_items_with_commas' => __( 'Separate items with commas', '_glad' ),
    'add_or_remove_items'        => __( 'Add or remove items', '_glad' ),
    'choose_from_most_used'      => __( 'Choose from the most used', '_glad' ),
    'popular_items'              => __( 'Popular Items', '_glad' ),
    'search_items'               => __( 'Search Items', '_glad' ),
    'not_found'                  => __( 'Not Found', '_glad' ),
    'no_terms'                   => __( 'No items', '_glad' ),
    'items_list'                 => __( 'Items list', '_glad' ),
    'items_list_navigation'      => __( 'Items list navigation', '_glad' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'rewrite'                    => array(
      'slug' => 'listings',
      'with_front' => false
    ),
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'marketstatus', array( 'listing' ), $args );

}
add_action( 'init', 'register_custom_taxonomies', 0 );

// Admin Styles
function admin_style() {
  wp_enqueue_style('admin-fontawesome', get_template_directory_uri().'/vendor/css/all.css', array(), '20151215', all);
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css', array(), '20151222', all);
}
add_action('admin_enqueue_scripts', 'admin_style');
