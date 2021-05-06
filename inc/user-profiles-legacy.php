<?php
/**
 * Functions which alter Member Profiles by hooking into Memberpress
 *
 * @package _glad
 */

 /** **************************************************
  *               CREATE NEW USER ROLES               *
  *************************************************** */

 add_role(
  'applicant', __( 'Applicant' ),
  array(
    'read'         => true,
    'edit_posts'   => false,
  )
 );

 add_role(
   'approved', __( 'Approved' ),
   array(
     'read'                    => true,
     'upload_files'            => true,
     'edit_posts'              => true,
     'delete_posts'            => false,
     'delete_published_posts'  => false,
     'edit_posts'              => true,
     'edit_published_posts'    => true,
     'publish_posts'           => true
   )
 );

 add_role(
   'promoted', __( 'Promoted' ),
   array(
     'read'                    => true,
     'upload_files'            => true,
     'edit_posts'              => true,
     'delete_posts'            => false,
     'delete_published_posts'  => false,
     'edit_posts'              => true,
     'edit_published_posts'    => true,
     'publish_posts'           => true
   )
 );

 add_role(
   'managed', __( 'Managed' ),
   array(
     'read'                    => true,
     'upload_files'            => true,
     'edit_posts'              => true,
     'delete_posts'            => false,
     'delete_others_posts'     => false,
     'delete_published_posts'  => false,
     'edit_posts'              => true,
     'edit_others_posts'       => true,
     'edit_published_posts'    => true,
     'publish_posts'           => true
   )
 );

 add_role(
   'dealer', __( 'Dealer' ),
   array(
     'read'                    => true,
     'upload_files'            => true,
     'edit_posts'              => true,
     'delete_posts'            => false,
     'delete_published_posts'  => false,
     'edit_posts'              => true,
     'edit_published_posts'    => true,
     'publish_posts'           => true
   )
 );

 add_role(
   'industry', __( 'Industry' ),
   array(
     'read'                    => true,
     'upload_files'            => true,
     'edit_posts'              => true,
     'delete_posts'            => false,
     'delete_published_posts'  => false,
     'edit_posts'              => true,
     'edit_published_posts'    => true,
     'publish_posts'           => true
   )
 );


 /** ********************************************************
  *               FINALIZE APPLICATION SURVEY               *
  ********************************************************* */

  // DEPRECATED

 // During Application, Redirect Dealer Member Applicants to Proper Thank You Page
 // function finalize_application(){
 // 	// Are we going to the "Finalize Application" page?
 // 	if( is_page( 'finalize-application' ) ) {
 //
 // 		// Check Which Application Type This Is
 // 		global $current_user;
 // 		get_currentuserinfo();
 // 		$user_id = $current_user->ID;
 // 		$applicationType = get_user_meta($user_id, 'mepr_membership_type', true);
 //
 //    // echo '<!-- member data: '; var_dump($current_user); echo '-->';
 //    // echo '<!-- app type: '; var_dump($applicationType); echo '-->';
 //
 // 		// If not a Dealer Member, get out of here!
 // 		if( $applicationType == 'industry' ) {
 // 			$post_url = '/thank-you';
 // 			echo '<!-- This is an INDUSTRY application. Move along to: ';
 // 			var_dump( $post_url );
 // 			echo '-->';
 // 			wp_redirect( $post_url );
 // 		}
 // 	}
 // } add_action('template_redirect', 'finalize_application');


 /** ********************************************************
  *                      ACCOUNT PAGE                       *
  ********************************************************* */


/* EXTEND BUDDYPRESS */

function profile_tab_employees() {
      global $bp;

      bp_core_new_nav_item( array(
            'name' => 'employees',
            'slug' => 'employees',
            'screen_function' => 'employees_screen',
            'position' => 40,
            'parent_url'      => bp_loggedin_user_domain() . '/employees/',
            'parent_slug'     => $bp->profile->slug,
            'default_subnav_slug' => 'employees'
      ) );
}
add_action( 'bp_setup_nav', 'profile_tab_employees' );

function employees_screen() {

    // Add title and content here - last is to call the members plugin.php template.
    add_action( 'bp_template_title', 'employees_title' );
    add_action( 'bp_template_content', 'employees_content' );
    bp_core_load_template( 'buddypress/members/single/plugins' );
}
function employees_title() {
    echo 'Employees';
}

function employees_content() {
    echo 'Content';
}




/** Add to ACCOUNT HEADER Box */
function add_account_header() {
	echo '<h3 class="section-title">Account Information</h3>
				<p>Edit Your Account Information Below</p>';
}
add_filter('mepr-account-home-before-name', 'add_account_header');

/** Add to ACCOUNT MESSAGE Box */
function glad_branding( $welcome_message, $mepr_current_user ) {

  $user_id = $mepr_current_user->ID;
	$name = $mepr_current_user->first_name;
	$lname = $mepr_current_user->last_name;
	$email = $mepr_current_user->user_email;

	?><!-- <?php
	var_dump( $mepr_current_user );
	?> --><?php

  $profile_pic = get_user_meta($user_id, 'memberpress_avatar', true);
  $image = wp_get_attachment_image_src( $profile_pic, 'full' );
  $color = get_user_meta($user_id, 'branding_color1', true);
  $company = get_user_meta($user_id, 'mepr_company', true);
  $sms_enabled = get_user_meta($user_id, 'mepr_sms_enabled', true);
  $sms_main = get_user_meta($user_id, 'mepr_sms_main', true) ? : get_user_meta($user_id, 'mepr_mobile', true);
  $sms_numbers = get_user_meta($user_id, 'mepr_sms_numbers', true);
  ?>

	<div id="account_header">
    <div class="logo-wrapper">
      <img src="<?php echo $image[0]; ?>" />

      <form name="account_branding" id="account_branding" action="<?php echo site_url(); ?>/wp-admin/admin-post.php" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('memberpress_avatar'); ?>
        <input type="hidden" name="action" value="glad_upload_branding" />
        <label for="brandingLogo">Upload New Logo</label>
        <input type="file" id="brandingLogo" name="brandingLogo" multiple="false" />
        <input id="upload" type="submit" name="upload" value="Upload New Logo" />
      </form>
      <?php
      if( current_user_can('mepr-active','membership:19,232,580,588') ) { ?>
        <form name="branding_colors" id="branding_colors" action="<?php echo site_url(); ?>/wp-admin/admin-post.php" method="post" enctype="multipart/form-data">
          <?php wp_nonce_field('branding_color1'); ?>
          <input type="hidden" name="action" value="glad_upload_branding" />
          <i id="colorPreview" style="<?php echo 'color: ' . $color; ?>" class="fas fa-circle"></i>
          <input id="color_code" class="color-picker" name="color_code" type="text" value="<?php echo $color; ?>" />
          <input id="saveColor" type="submit" name="saveColor" value="Save Branding Color" />
          <!-- <br>
          <label for="use-contact">Use Your Account Information as Default Lisiting Contact Info?</label>
          <input type="checkbox">
            TODO
          </input> -->
        </form><?php
        wp_enqueue_script('glad-uploader', get_stylesheet_directory_uri().'/js/uploader.js', array('jquery'), '20190423', true );
        wp_enqueue_script('color-picker', get_stylesheet_directory_uri().'/js/color-picker.js', array('jquery'), '20190423', true );
      } ?>

    </div>
    <div class="info-wrapper" style="background-color:<?php echo $color; ?>">
      <div class="left">
  			<h3>Hi, <?php echo $company; ?></h3>
        <p><span>User:</span> <?php echo $name . ' ' . $lname; ?><br>
          <span>Account:</span> <?php echo $email; ?><br>
          <span class="mepr-account-change-password"><a class="mobilebtn" href="<?php echo $account_url.$delim.'?action=newpassword'; ?>"><i class="fas fa-lock"></i> <?php _ex('Change Password', 'ui', 'memberpress'); ?></a></span>
        </p>
      </div> <?php if( current_user_can('mepr-active','membership:19,232,580,588') ) { ?>
      <div class="right">
        <div class="dealer-alerts-wrapper">
          <h3>Dealer Alerts</h3>
          <?php if( $sms_enabled == true ) {
            echo '<p><a href="' . get_stylesheet_directory_uri() . '/images/GLADA_Alerts.vcf">Click Here to Download the GLADA Alerts vCard.</a></p>';
          } else {
            echo '<p>Send Member-Only notices to Dealers by emailing <a href="mailto:alerts@glada.aero">alerts@glada.aero</a>.</p>';
          } ?>
          <div class="alert-display">
            <div class="alert-display-icon">
              <i class="fas <?php echo $sms_enabled ? 'fa-check' : 'fa-times' ; ?>"></i>
            </div>
            <div class="alert-display-info">
              <?php if( $sms_enabled == true ) {
                echo '<h4>SMS Alerts are ON</h4>';
                echo '<p>Main Number: ' . formatPhoneNumber( $sms_main ) . '</p>';
                if( $sms_numbers ) {
                  $preformat_array = array();
                  echo '<p>Additional: ';
                  foreach( $sms_numbers as $dataset ) {
                    $preformat_array[] = $dataset[0];
                  }
                  echo implode( ', ', $preformat_array ) . '</p>';
                }
              } else {
                echo '<h4>TO ENABLE ALERTS, CLICK "CHANGE SETTINGS" BELOW.</h4>';
              } ?>
            </div>
          </div>
          <div class="iphone">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/images/DealerAlertPhone.png">
          </div>
        </div>
        <h6><a class="edit mobilebtn" data-user="<?php echo $user_id; ?>" data-form="mobile-alert-formbox" href="#">Change Settings <i class="fas fa-cog"></i></a></h6>
      </div> <?php } ?>
    </div>
	</div>

  <?php include( locate_template( 'template-parts/mobile-alert-form.php', false, false ) );
        wp_enqueue_script( 'mobilealerts', get_template_directory_uri() . '/js/mobilealerts.min.js', array('jquery'), '20200331', true); ?>

  <?php
	echo do_shortcode($welcome_message);
}
add_filter('mepr-account-welcome-message', 'glad_branding', 10, 2);

/** ********************************************************
 *                      COLOR PICKER                       *
 ********************************************************* */

function enqueue_color_picker() {
    // Enqueuing CSS stylesheet for Iris (the easy part)
    wp_enqueue_style( 'wp-color-picker' );

    // Manually enqueing Iris itself by linking directly
    //    to it and naming its dependencies
    wp_enqueue_script(
        'iris',
        admin_url( 'js/iris.min.js' ),
        array(
            'jquery-ui-draggable',
            'jquery-ui-slider',
            'jquery-touch-punch'
        ),
        false,
        1
    );

    // Now we can enqueue the color-picker script itself,
    //    naming iris.js as its dependency
    wp_enqueue_script(
        'wp-color-picker',
        admin_url( 'js/color-picker.min.js' ),
        array( 'iris' ),
        false,
        1
    );

    // Manually passing text strings to the JavaScript
    $colorpicker_l10n = array(
        'clear' => __( 'Clear' ),
        'defaultString' => __( 'Default' ),
        'pick' => __( 'Select Color' ),
        'current' => __( 'Current Color' ),
    );
    wp_localize_script(
        'wp-color-picker',
        'wpColorPickerL10n',
        $colorpicker_l10n
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_color_picker', 100 );


/** ********************************************************
 *                     ADMIN SCRIPTS                       *
 ********************************************************* */

/** Add Scripts to Admin */
function glad_add_admin_scripts(){
	wp_enqueue_media();
  enqueue_color_picker();
  wp_enqueue_script('color-picker', get_stylesheet_directory_uri().'/js/color-picker.js', array('jquery'), '20190423', true );
	wp_enqueue_script('glad-uploader', get_stylesheet_directory_uri().'/js/uploader.js', array('jquery'), false, true );
}
add_action('admin_enqueue_scripts', 'glad_add_admin_scripts');

/** Add Extra Profile Fields to Admin User Edit Page */
function glad_extra_profile_fields( $user ) {
	$notes = ($user!=='add-new-user') ? get_user_meta($user->ID, 'notes', true): false;
  $color = ($user!=='add-new-user') ? get_user_meta($user->ID, 'branding_color1', true): false;
	$profile_pic = ($user!=='add-new-user') ? get_user_meta($user->ID, 'memberpress_avatar', true): false;
	if( !empty($profile_pic) ){
		$image = wp_get_attachment_image_src( $profile_pic, 'full' );
	} ?>

	<table class="form-table fh-profile-upload-options">
		<tr>
			<th>
				<label for="image"><?php _e('Branding Logo', '_glad') ?></label>
				<input type="button" data-id="glad_image_id" data-src="glad-img" class="button glad-image" style="display: block; margin-top: 10px;" name="glad_image" id="glad-image" value="Upload New" />
				<input type="hidden" class="button" name="glad_image_id" id="glad_image_id" value="<?php echo !empty($profile_pic) ? $profile_pic : ''; ?>" />
			</th>
			<td>
				<img id="glad-img" src="<?php echo !empty($profile_pic) ? $image[0] : ''; ?>" style="<?php echo empty($profile_pic) ? 'display:none;' :'' ?> max-width: 300px;" />
			</td>
		</tr>
    <tr>
      <th>
        <label for="color_code"><?php _e('Branding Color', '_glad') ?></label>
      </th>
      <td>
        <i id="colorPreview" style="<?php echo 'color: ' . $color; ?>" class="fas fa-circle"></i>
        <input id="color_code" class="color-picker" name="color_code" type="text" value="<?php echo $color; ?>" />
      </td>
    </tr>
		<tr>
			<th>
				<label for="notes"><?php _e('Notes', '_glad') ?></label>
			</th>
			<td>
        <textarea cols="300" rows="12" name="notes" wrap="hard" id="notes"><?php echo esc_html( $notes ); ?></textarea>
				<p class="description">Use this space to add notes about the client. This information is not public-facing.</p>
			</td>
		</tr>
	</table><?php

}
add_action( 'show_user_profile', 'glad_extra_profile_fields' );
add_action( 'edit_user_profile', 'glad_extra_profile_fields' );
add_action( 'user_new_form', 'glad_extra_profile_fields' );


/** ********************************************************
 *                      SAVE USER META                     *
 ********************************************************* */
/**
 * Save Updated User Meta on the Front-End
 */
function glad_branding_post() {
	if (is_user_logged_in() && wp_verify_nonce($_POST['_wpnonce'], 'memberpress_avatar')) {
		global $current_user;
		get_currentuserinfo();

		$user_id = $current_user->ID;
		if (!function_exists('wp_generate_attachment_metadata')){
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		}
		if($_FILES)
		{
			foreach ($_FILES as $file => $array)
			{
				if($_FILES[$file]['error'] !== UPLOAD_ERR_OK){return "upload error : " . $_FILES[$file]['error'];}//If upload error
				$attach_id = media_handle_upload($file,$new_post);
				update_user_meta($user_id, 'memberpress_avatar', $attach_id);
        //profileLastUpdated($user_id);
			}
		}
	}
	if (is_user_logged_in() && wp_verify_nonce($_POST['_wpnonce'], 'branding_color1')) {
		global $current_user;
		get_currentuserinfo();

		$user_id = $current_user->ID;
		$color = $_POST['color_code'];
		update_user_meta($user_id, 'branding_color1', $color);
    //profileLastUpdated($user_id);
	}
	wp_redirect('https://glada.aero/members/account');
	die();
}
add_action( 'admin_post_glad_upload_branding', 'glad_branding_post' );
add_action( 'admin_post_nopriv_glad_upload_branding', 'glad_branding_post' );

/**
 * Save Updated User Meta on the Back End
 */
function glad_profile_update($user_id){
	if( current_user_can('edit_users') ){
		// Check for Update to Branding Logo, Save if needed
		$profile_pic = empty($_POST['glad_image_id']) ? '' : $_POST['glad_image_id'];
		update_user_meta($user_id, 'memberpress_avatar', $profile_pic);
		// Check for Update to Branding Color, Save if needed
		$color = empty($_POST['color_code']) ? '' : $_POST['color_code'];
		update_user_meta($user_id, 'branding_color1', $color);
		// Check for Update to Notes, Save if needed
		$notes = empty($_POST['notes']) ? '' : $_POST['notes'];
		update_user_meta($user_id, 'notes', $notes);
    // Check for Update to SMS Toggle
		$sms_enabled = empty($_POST['sms_enabled']) ? '' : $_POST['sms_enabled'];
		update_user_meta($user_id, 'mepr_sms_enabled', $sms_enabled);
    // Check for Update to SMS Numbers
		$sms_numbers = empty($_POST['sms_numbers']) ? '' : $_POST['sms_numbers'];
		update_user_meta($user_id, 'mepr_sms_numbers', $sms_numbers);
    //profileLastUpdated($user_id);
	}

}
add_action('profile_update', 'glad_profile_update');
add_action('user_register', 'glad_profile_update');

/**
 * I legitimately do not know what this does
 */
function my_profile_upload_js() { ?>
	<script type="text/javascript">
		jQuery( document ).ready( function() {

			/* WP Media Uploader */
			var _glad_media = true;
			var _orig_send_attachment = wp.media.editor.send.attachment;

			jQuery( '.glad-image' ).click( function() {

				var button = jQuery( this ),
						textbox_id = jQuery( this ).attr( 'data-id' ),
						image_id = jQuery( this ).attr( 'data-src' ),
						_glad_media = true;

				wp.media.editor.send.attachment = function( props, attachment ) {

					if ( _glad_media && ( attachment.type === 'image' ) ) {
						if ( image_id.indexOf( "," ) !== -1 ) {
							image_id = image_id.split( "," );
							$image_ids = '';
							jQuery.each( image_id, function( key, value ) {
								if ( $image_ids )
									$image_ids = $image_ids + ',#' + value;
								else
									$image_ids = '#' + value;
							} );

							var current_element = jQuery( $image_ids );
						} else {
							var current_element = jQuery( '#' + image_id );
						}

						jQuery( '#' + textbox_id ).val( attachment.id );
										console.log(textbox_id)
						current_element.attr( 'src', attachment.url ).show();
					} else {
						alert( 'Please select a valid image file' );
						return false;
					}
				}

				wp.media.editor.open( button );
				return false;
			} );

		} );
	</script>
<?php }
add_action('admin_head','my_profile_upload_js');

// Add a "Last Updated" field to compare with Wild Apricot
function profileLastUpdated( $user_id ) {
  update_user_meta( $user_id, 'profileLastUpdated', current_time( 'mysql' ) );
}
add_action( 'profile_update', 'profileLastUpdated' );
