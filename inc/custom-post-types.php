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
 		'name'                  => __( 'Listings', 'Post Type General Name', '_glad' ),
 		'singular_name'         => __( 'Listing', 'Post Type Singular Name', '_glad' ),
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
 		'supports'              => array( 'title', 'author', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes' ),
 		'taxonomies'            => array( 'aircraft', 'marketstatus', 'post_tag' ),
 		'hierarchical'          => false,
 		'public'                => true,
 		'show_ui'               => true,
 		'show_in_menu'          => true,
 		'menu_position'         => 10,
 		'menu_icon'             => 'dashicons-airplane',
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
   'name'                  => __( 'Service Listings', 'Post Type General Name', '_glad' ),
   'singular_name'         => __( 'Service Listing', 'Post Type Singular Name', '_glad' ),
   'menu_name'             => __( 'Services', '_glad' ),
   'name_admin_bar'        => __( 'Services', '_glad' ),
   'archives'              => __( 'Services', '_glad' ),
   'attributes'            => __( 'Service Listing Details', '_glad' ),
   'parent_item_colon'     => __( 'Parent Listing:', '_glad' ),
   'all_items'             => __( 'All Service Listings', '_glad' ),
   'add_new_item'          => __( 'Add New Listing', '_glad' ),
   'add_new'               => __( 'Add New', '_glad' ),
   'search_items'          => __( 'Search Service Listings', '_glad' ),
 );
 $rewrite = array(
   'slug'                  => 'opportunities',
   'with_front'            => false,
   'pages'                 => true,
   'feeds'                 => true,
 );
 $args = array(
   'label'                 => __( 'Services', '_glad' ),
   'description'           => __( 'Member-Submitted Service Listings', '_glad' ),
   'labels'                => $labels,
   'supports'              => array( 'title', 'author', 'editor', 'thumbnail', 'custom-fields', 'page-attributes' ),
   'taxonomies'            => array( 'type', 'post_tag' ),
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
   'name'                  => __( 'Comps', 'Post Type General Name', '_glad' ),
   'singular_name'         => __( 'Comp', 'Post Type Singular Name', '_glad' ),
   'menu_name'             => __( 'Comps', '_glad' ),
   'name_admin_bar'        => __( 'Comps', '_glad' ),
   'archives'              => __( 'Comps', '_glad' ),
   'attributes'            => __( 'Comp Details', '_glad' ),
   'parent_item_colon'     => __( 'Parent Comp:', '_glad' ),
   'all_items'             => __( 'All Comps', '_glad' ),
   'add_new_item'          => __( 'Add New Comp', '_glad' ),
   'add_new'               => __( 'Add New', '_glad' ),
   'new_item'              => __( 'New Comp', '_glad' ),
   'edit_item'             => __( 'Edit Comp', '_glad' ),
   'update_item'           => __( 'Update Comp', '_glad' ),
   'view_item'             => __( 'View Comp', '_glad' ),
   'view_items'            => __( 'View Comps', '_glad' ),
   'search_items'          => __( 'Search Comp', '_glad' ),
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
 'slug'                  => 'comps',
 'with_front'            => false,
 'pages'                 => true,
 'feeds'                 => true,
);
 $args = array(
   'label'                 => __( 'Comp', '_glad' ),
   'description'           => __( 'Member-Submitted Comps', '_glad' ),
   'labels'                => $labels,
   'supports'              => array( 'title', 'author', 'editor', 'excerpt', 'custom-fields', 'thumbnail', 'page-attributes' ),
   'taxonomies'            => array( 'aircraft', 'marketstatus', 'post_tag' ),
   'hierarchical'          => false,
   'public'                => true,
   'show_ui'               => true,
   'show_in_menu'          => true,
   'menu_position'         => 10,
   'menu_icon'             => 'dashicons-portfolio',
   'show_in_admin_bar'     => true,
   'show_in_nav_menus'     => true,
   'can_export'            => true,
   'has_archive'           => true,
   'exclude_from_search'   => false,
   'publicly_queryable'    => true,
   'rewrite'               => $rewrite,
   'capability_type'       => 'page',
 );
 register_post_type( 'comp', $args );

	$labels = array(
		'name'                  => __( 'People', 'Post Type General Name', '_glad' ),
		'singular_name'         => __( 'Person', 'Post Type Singular Name', '_glad' ),
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

  $labels = array(
 		'name'                  => __( 'Testimonials', 'Post Type General Name', '_glad' ),
 		'singular_name'         => __( 'Testimonial', 'Post Type Singular Name', '_glad' ),
 		'menu_name'             => __( 'Testimonials', '_glad' ),
 		'name_admin_bar'        => __( 'Testimonials', '_glad' ),
 		'archives'              => __( 'Testimonial Archives', '_glad' ),
 		'attributes'            => __( 'Testimonial Attributes', '_glad' ),
 		'parent_item_colon'     => __( 'Parent Testimonial:', '_glad' ),
 		'all_items'             => __( 'All Testimonials', '_glad' ),
 		'add_new_item'          => __( 'Add New Testimonial', '_glad' ),
 		'add_new'               => __( 'Add New', '_glad' ),
 		'new_item'              => __( 'New Testimonial', '_glad' ),
 		'edit_item'             => __( 'Edit Testimonial', '_glad' ),
 		'update_item'           => __( 'Update Testimonial', '_glad' ),
 		'view_item'             => __( 'View Testimonial', '_glad' ),
 		'view_items'            => __( 'View Testimonials', '_glad' ),
 		'search_items'          => __( 'Search Testimonials', '_glad' ),
 		'not_found'             => __( 'Not found', '_glad' ),
 		'not_found_in_trash'    => __( 'Not found in Trash', '_glad' ),
 		'featured_image'        => __( 'Featured Image', '_glad' ),
 		'set_featured_image'    => __( 'Set featured image', '_glad' ),
 		'remove_featured_image' => __( 'Remove featured image', '_glad' ),
 		'use_featured_image'    => __( 'Use as featured image', '_glad' ),
 		'insert_into_item'      => __( 'Insert into Testimonial', '_glad' ),
 		'uploaded_to_this_item' => __( 'Uploaded to this item', '_glad' ),
 		'items_list'            => __( 'Items list', '_glad' ),
 		'items_list_navigation' => __( 'Items list navigation', '_glad' ),
 		'filter_items_list'     => __( 'Filter items list', '_glad' ),
 	);
 	$args = array(
 		'label'                 => __( 'Testimonial', '_glad' ),
 		'description'           => __( 'Short Client Testimonials', '_glad' ),
 		'labels'                => $labels,
 		'supports'              => array( 'title', 'author', 'editor' ),
 		'taxonomies'            => array( 'category', 'post_tag' ),
 		'hierarchical'          => false,
 		'public'                => true,
 		'show_ui'               => true,
 		'show_in_menu'          => true,
 		'menu_position'         => 31,
 		'menu_icon'             => 'dashicons-format-quote',
 		'show_in_admin_bar'     => true,
 		'show_in_nav_menus'     => false,
 		'can_export'            => true,
 		'has_archive'           => false,
 		'exclude_from_search'   => true,
 		'publicly_queryable'    => true,
 		'capability_type'       => 'page',
 	);
 	register_post_type( 'testimonials', $args );

  $labels = array(
 		'name'                  => __( 'Member Referrals', 'Post Type General Name', '_glad' ),
 		'singular_name'         => __( 'Referral', 'Post Type Singular Name', '_glad' ),
 		'menu_name'             => __( 'Referrals', '_glad' ),
 		'name_admin_bar'        => __( 'Referrals', '_glad' ),
 		'archives'              => __( 'Referral Archives', '_glad' ),
 		'attributes'            => __( 'Referral Attributes', '_glad' ),
 		'parent_item_colon'     => __( 'Parent Referral:', '_glad' ),
 		'all_items'             => __( 'All Referrals', '_glad' ),
 		'add_new_item'          => __( 'Add New Referral', '_glad' ),
 		'add_new'               => __( 'Add New', '_glad' ),
 		'new_item'              => __( 'New Referral', '_glad' ),
 		'edit_item'             => __( 'Edit Referral', '_glad' ),
 		'update_item'           => __( 'Update Referral', '_glad' ),
 		'view_item'             => __( 'View Referral', '_glad' ),
 		'view_items'            => __( 'View Referrals', '_glad' ),
 		'search_items'          => __( 'Search Referrals', '_glad' ),
 		'insert_into_item'      => __( 'Insert into Referral', '_glad' ),
 		'uploaded_to_this_item' => __( 'Uploaded to Referral', '_glad' ),
 		'items_list'            => __( 'Referrals list', '_glad' ),
 		'items_list_navigation' => __( 'Referrals list navigation', '_glad' ),
 		'filter_items_list'     => __( 'Filter Referrals list', '_glad' ),
 	);
 	$args = array(
 		'label'                 => __( 'Referrals', '_glad' ),
 		'description'           => __( 'Member Referrals', '_glad' ),
 		'labels'                => $labels,
 		'supports'              => array( 'title', 'author', 'editor', 'custom-fields' ),
 		'taxonomies'            => array( 'referraltype' ),
 		'hierarchical'          => false,
 		'public'                => true,
 		'show_ui'               => true,
 		'show_in_menu'          => true,
 		'menu_position'         => 32,
 		'menu_icon'             => 'dashicons-thumbs-up',
 		'show_in_admin_bar'     => true,
 		'show_in_nav_menus'     => false,
 		'can_export'            => true,
 		'has_archive'           => false,
 		'exclude_from_search'   => true,
 		'publicly_queryable'    => true,
 		'capability_type'       => 'page',
 	);
 	register_post_type( 'referrals', $args );

  $labels = array(
    'name'                  => __( 'Coupon', 'Post Type General Name', '_glad' ),
    'singular_name'         => __( 'Coupon', 'Post Type Singular Name', '_glad' ),
    'menu_name'             => __( 'Coupons', '_glad' ),
    'name_admin_bar'        => __( 'Coupons', '_glad' ),
    'archives'              => __( 'Coupon Archives', '_glad' ),
    'attributes'            => __( 'Coupon Attributes', '_glad' ),
    'parent_item_colon'     => __( 'Parent Coupon:', '_glad' ),
    'all_items'             => __( 'All Coupons', '_glad' ),
    'add_new_item'          => __( 'Add New Coupon', '_glad' ),
    'add_new'               => __( 'Add New', '_glad' ),
    'new_item'              => __( 'New Coupon', '_glad' ),
    'edit_item'             => __( 'Edit Coupon', '_glad' ),
    'update_item'           => __( 'Update Coupon', '_glad' ),
    'view_item'             => __( 'View Coupon', '_glad' ),
    'view_items'            => __( 'View Coupons', '_glad' ),
    'search_items'          => __( 'Search Coupons', '_glad' ),
    'insert_into_item'      => __( 'Insert into Coupon', '_glad' ),
    'uploaded_to_this_item' => __( 'Uploaded to Coupon', '_glad' ),
    'items_list'            => __( 'Coupons list', '_glad' ),
    'items_list_navigation' => __( 'Coupons list navigation', '_glad' ),
    'filter_items_list'     => __( 'Filter Coupons list', '_glad' ),
  );
  $args = array(
    'label'                 => __( 'Coupons', '_glad' ),
    'description'           => __( 'Member Coupons', '_glad' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'author', 'custom-fields' ),
    'taxonomies'            => array( 'coupontype' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 32,
    'menu_icon'             => 'dashicons-money-alt',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => false,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => true,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'coupons', $args );

  $labels = array(
 		'name'                  => __( 'Alerts', 'Post Type General Name', '_glad' ),
 		'singular_name'         => __( 'Alert', 'Post Type Singular Name', '_glad' ),
 		'menu_name'             => __( 'Alerts', '_glad' ),
 		'name_admin_bar'        => __( 'Alerts', '_glad' ),
 		'archives'              => __( 'Alert Archives', '_glad' ),
 		'attributes'            => __( 'Alert Attributes', '_glad' ),
 		'parent_item_colon'     => __( 'Parent Alert:', '_glad' ),
 		'all_items'             => __( 'All Alerts', '_glad' ),
 		'add_new_item'          => __( 'Add New Alert', '_glad' ),
 		'add_new'               => __( 'Add New', '_glad' ),
 		'new_item'              => __( 'New Alert', '_glad' ),
 		'edit_item'             => __( 'Edit Alert', '_glad' ),
 		'update_item'           => __( 'Update Alert', '_glad' ),
 		'view_item'             => __( 'View Alert', '_glad' ),
 		'view_items'            => __( 'View Alerts', '_glad' ),
 		'search_items'          => __( 'Search Alerts', '_glad' ),
 		'insert_into_item'      => __( 'Insert into Alert', '_glad' ),
 		'uploaded_to_this_item' => __( 'Uploaded to Alert', '_glad' ),
 		'items_list'            => __( 'Alerts list', '_glad' ),
 		'items_list_navigation' => __( 'Alerts list navigation', '_glad' ),
 		'filter_items_list'     => __( 'Filter Alerts list', '_glad' ),
 	);
 	$args = array(
 		'label'                 => __( 'Alerts', '_glad' ),
 		'description'           => __( 'GLADA Text Alerts', '_glad' ),
 		'labels'                => $labels,
 		'supports'              => array( 'title', 'author', 'editor', 'custom-fields', 'comments' ),
 		'taxonomies'            => array( 'alerttype' ),
 		'hierarchical'          => false,
 		'public'                => true,
 		'show_ui'               => true,
 		'show_in_menu'          => true,
 		'menu_position'         => 33,
 		'menu_icon'             => 'dashicons-welcome-comments',
 		'show_in_admin_bar'     => true,
 		'show_in_nav_menus'     => false,
 		'can_export'            => true,
 		'has_archive'           => false,
 		'exclude_from_search'   => true,
 		'publicly_queryable'    => true,
 		'capability_type'       => 'page',
 	);
 	register_post_type( 'alert', $args );

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
   <div style="display:flex; flex-wrap:wrap;">
     <p style="margin: 1em;">
       <label for="person_fields[jobtitle]">Job Title</label>
       <br>
       <input type="text" name="person_fields[jobtitle]" id="person_fields[jobtitle]" class="regular-text" value="<?php echo $meta['jobtitle']; ?>">
     </p>
     <p style="margin: 1em;">
       <label for="person_fields[location]">Location</label>
       <br>
       <input type="text" name="person_fields[location]" id="person_fields[location]" class="regular-text" value="<?php echo $meta['location']; ?>">
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
       <label for="url">Website URL</label>
       <br>
       <input type="url" name="url" id="url" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'url', true ); ?>">
     </p>
     <p style="margin: 1em;">
       <label for="pdf">Specsheet</label>
       <br>
       <a class="button media-button"> Choose File </a>
       <input type="hidden" name="pdf" id="pdf" value="<?php echo get_post_meta( $post->ID, 'pdf', true ); ?>" />
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
 $new = intval(str_replace(',','', $_POST['landings'] ));

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
 $new = intval(str_replace(',','', $_POST['aftt-number'] ));

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

 // save specsheet
 $old = get_post_meta( $post_id, 'pdf', true );
 $new = $_POST['pdf'];

 if ( $new && $new !== $old ) {
   update_post_meta( $post_id, 'pdf', $new );
 } elseif ( '' === $new && $old ) {
   delete_post_meta( $post_id, 'pdf', $old );
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
	register_taxonomy( 'aircraft', array( 'listing', 'comp' ), $args );

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
  register_taxonomy( 'marketstatus', array( 'listing', 'comp' ), $args );

  $labels = array(
    'name'                       => _x( 'Types', 'Taxonomy General Name', '_glad' ),
    'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', '_glad' ),
    'menu_name'                  => __( 'Types', '_glad' ),
    'all_items'                  => __( 'All Types', '_glad' ),
    'new_item_name'              => __( 'New Type', '_glad' ),
    'add_new_item'               => __( 'Add New Type', '_glad' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'rewrite'                    => array(
      'slug' => 'type',
      'with_front' => false
    ),
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'opptype', array( 'opportunity' ), $args );

  $labels = array(
    'name'                       => _x( 'Referral Type', 'Taxonomy General Name', '_glad' ),
    'singular_name'              => _x( 'Referral Type', 'Taxonomy Singular Name', '_glad' ),
    'menu_name'                  => __( 'Referral Type', '_glad' ),
    'all_items'                  => __( 'All Types', '_glad' ),
    'new_item_name'              => __( 'New Type', '_glad' ),
    'add_new_item'               => __( 'Add New Type', '_glad' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'rewrite'                    => array(
      'slug' => 'referraltype',
      'with_front' => false
    ),
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'referraltype', array( 'referrals' ), $args );

  $labels = array(
    'name'                       => _x( 'Coupon Type', 'Taxonomy General Name', '_glad' ),
    'singular_name'              => _x( 'Coupon Type', 'Taxonomy Singular Name', '_glad' ),
    'menu_name'                  => __( 'Coupon Type', '_glad' ),
    'all_items'                  => __( 'All Types', '_glad' ),
    'new_item_name'              => __( 'New Type', '_glad' ),
    'add_new_item'               => __( 'Add New Type', '_glad' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'rewrite'                    => array(
      'slug' => 'coupontype',
      'with_front' => false
    ),
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'coupontype', array( 'coupons' ), $args );

  $labels = array(
    'name'                       => _x( 'Alert Type', 'Taxonomy General Name', '_glad' ),
    'singular_name'              => _x( 'Alert Type', 'Taxonomy Singular Name', '_glad' ),
    'menu_name'                  => __( 'Alert Type', '_glad' ),
    'all_items'                  => __( 'All Types', '_glad' ),
    'new_item_name'              => __( 'New Type', '_glad' ),
    'add_new_item'               => __( 'Add New Type', '_glad' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'rewrite'                    => array(
      'slug' => 'alerttype',
      'with_front' => false
    ),
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'alerttype', array( 'alert' ), $args );

}
add_action( 'init', 'register_custom_taxonomies', 0 );

// Set default Market Status
function set_default_marketstatus($post_id, $post)
{
    if ( 'publish' === $post->post_status ) {
        $marketstatus = wp_get_post_terms( $post_id, 'marketstatus' );

        if ( empty($marketstatus) ) {
            wp_set_object_terms( $post_id, 6, 'marketstatus' );
        }
    }
}
add_action('save_post_listing', 'set_default_marketstatus', 10, 3);
