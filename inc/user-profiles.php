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
     'edit_published_posts'    => true,
     'publish_posts'           => true
   )
 );

 add_role(
   'promoted', __( 'Promoted' ),
   array(
     'read'                    => true,
     'upload_files'            => true,
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
     'delete_posts'            => false,
     'delete_published_posts'  => false,
     'edit_posts'              => true,
     'edit_published_posts'    => true,
     'publish_posts'           => true
   )
 );

 remove_role( 'subscriber' );
 remove_role( 'author' );
 remove_role( 'contributor' );
 remove_role( 'editor' );

 // Allow Members to Appear in Editor Drop-downs
 add_action('wp_dropdown_users_args', 'filter_authors');
 function filter_authors( $args ) {
	if ( isset( $args['who'])) {
		$args['role__in'] = ['dealer', 'industry', 'administrator', 'managed', 'promoted'];
		unset( $args['who']);
	}
	return $args;
 }


/** ********************************************************
*                      ACCOUNT PAGE                       *
********************************************************* */

/** Add to ACCOUNT HEADER Box */
function add_account_header() {
	// echo '<h3 class="section-title">Notice</h3>
	// 			<p>Some Account Features will be temporarily unavailable while we update our systems.</p>';
}
add_filter('mepr-account-home-before-name', 'add_account_header');


/* EXTEND BUDDYPRESS */
function glada_xprofile_cover_image( $settings = array() ) {
    $settings['width']  = 1000;
    $settings['height'] = 600;

    return $settings;
}
add_filter( 'bp_before_members_cover_image_settings_parse_args', 'glada_xprofile_cover_image', 10, 1 );

/* https://codex.buddypress.org/developer/navigation-api/#remove-subnav-tabs-from-group-settings */
function change_profile_menu_tabs() {
    global $bp;

    $bp->members->nav->edit_nav( array( 'name' => __('Profile Photo', '_glad'), ), 'change-avatar', 'profile' );
    $bp->members->nav->edit_nav( array( 'name' => __('Company Logo', '_glad'), ), 'change-cover-image', 'profile' );
}
add_action( 'bp_actions', 'change_profile_menu_tabs' );

// We can hide "ACTIVITY" because we changed the default Buddypress Profile page. Otherwise this breaks profiles.
function hide_some_nav_items() {
  // if ( ! bp_is_group() || ! ( bp_is_current_action( 'admin' ) && bp_action_variable( 0 ) ) || is_super_admin() ) {
  //     return;
  // }
  $hide_tabs = array(
    'activity'        => 1,
    'notifications'   => 1,
    'messages'        => 1,
  );
  //$parent_nav_slug = bp_displayed_user_domain();
  //bp_core_remove_subnav_item( $parent_nav_slug, $tab, etc )
  foreach( array_keys( $hide_tabs ) as $tab ) {
    bp_core_remove_nav_item( $tab );
  }
}
add_action( 'bp_actions', 'hide_some_nav_items' );

/* DIRECTORY MENU */
// function extend_directory() {
//   global $bp;
//
//   $nav_items['all'] = array(
//         'component' => 'members',
//         'slug'      => 'all', // slug is used because BP_Core_Nav requires it, but it's the scope
//         'li_class'  => array(),
//         'link'      => bp_get_members_directory_permalink(),
//         'text'      => __( 'All Members', 'buddyboss' ),
//         'count'     => bp_get_total_member_count(),
//         'position'  => 5,
//     );
//
//   $nav_items['membermap'] = array(
//     'component' => 'members',
//     'slug'      => 'membermap',
//     'li_class'  => array(),
//     'link'      => bp_get_members_directory_permalink() . 'member-map/',
//     'text'      => __( 'Member Map', '_glada' ),
//     'position'  => 20,
//   );
//   return $nav_items;
// }
// add_filter( 'bp_nouveau_get_members_directory_nav_items', 'extend_directory', 10, 1 );


/** ********************************************************
 *                       EMPLOYEES                         *
 ********************************************************* */

function profile_tab_employees() {
      global $bp;

      bp_core_new_nav_item( array(
            'name' => 'team',
            'slug' => 'employees',
            'screen_function' => 'employees_screen',
            'position' => 40,
            'parent_url'      => bp_loggedin_user_domain() . '/employees/',
            'parent_slug'     => $bp->profile->slug,
            'default_subnav_slug' => 'employees'
      ) );
}
add_action( 'bp_setup_nav', 'profile_tab_employees' );

function hide_employees() {

  $displayed = bp_displayed_user_id();
  $user = get_current_user_id();
  $employees = json_decode( get_user_meta( bp_displayed_user_id(), 'mepr_employees', true), true );

  if( !current_user_can('manage_options') && $user != $displayed && ( empty( $employees ) || $employees[0]['name'] == '' ) ) {
    bp_core_remove_nav_item( 'employees' );
  }

}
add_filter( 'bp_actions', 'hide_employees' );

function employees_screen() {

    // Add title and content here - last is to call the members plugin.php template.
    //add_action( 'bp_template_title', 'employees_title' );
    add_action( 'bp_template_content', 'employees_content' );
    bp_core_load_template( 'buddypress/members/single/plugins' );
}
function employees_title() {
    echo 'Team Members';
}

function employees_content() {

  $user_id = bp_displayed_user_id();
  $current = get_current_user_id();

  $instanciate = array(
    'name' => '',
    'title' => '',
    'email' => '',
    'number' => '',
    'ismember' => false,
    'sms_enabled' => false,
    'alert_enabled' => false,
  );
  $employees = json_decode( get_user_meta($user_id, 'mepr_employees', true), true ) ? : array( $instanciate );

  echo '<h3 class="screen-heading">Team Members</h3>';

  if ( current_user_can('manage_options') || $user_id == $current ) { ?>

    <div class="employee-form<?php if( get_user_meta($user_id, 'mepr_sms_enabled', true) ){ echo ' sms_enabled'; } ?>">

          <form action="#" method="POST" id="employee-form" enctype="multipart/form-data">

              <a class="addnumber" id="add_employee" onclick="add_employee();">
                <h4><i class="fas fa-plus"></i> Add Team Member</h4>
              </a>

              <input type="hidden" name="action" value="updateemployees">
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />

              <?php

              if( !empty( $employees ) ) {
                $i = 0;
                foreach( $employees as $employee ){
                  echo '<div class="employee" id="employee_' . $i . '_wrapper">';
                    // if ( $employee['ismember'] ) {
                    //   // get member info
                    // } else { ?>
                      <a class="removenumber" style="display:block;" onclick="remove_employee('<?php echo $i; ?>');"><i class="fas fa-times"></i></a>
                      <input type="text" name="<?php echo 'name_' . $i; ?>" id="<?php echo 'name_' . $i; ?>" class="regular-text" placeholder="Name" value="<?php echo $employee['name']; ?>">
                      <input type="text" name="<?php echo 'title_' . $i; ?>" id="<?php echo 'title_' . $i; ?>" class="regular-text" placeholder="Title" value="<?php echo $employee['title']; ?>">
                      <input type="text" name="<?php echo 'number_' . $i; ?>" id="<?php echo 'number_' . $i; ?>" class="regular-text" placeholder="Mobile Number" value="<?php echo formatPhoneNumber( $employee['number'] ); ?>">
                      <input type="text" name="<?php echo 'email_' . $i; ?>" id="<?php echo 'email_' . $i; ?>" class="regular-text" placeholder="Email" value="<?php echo $employee['email']; ?>">
                      <br>
                      <input type="checkbox" class="sms" name="<?php echo 'sms_enabled_' . $i; ?>" id="<?php echo 'sms_enabled_' . $i; ?>" <?php echo $checked = $employee['sms_enabled'] ? 'checked="checked"' : ''; ?>>
                      <label for="<?php echo 'sms_enabled_' . $i; ?>">Enable SMS Alerts</label>
                      <br>
                      <input type="checkbox" name="<?php echo 'charteroptout_' . $i; ?>" id="<?php echo 'charteroptout_' . $i; ?>" <?php echo $checked = $employee['charteralert_optout'] ? 'checked="checked"' : ''; ?>>
                      <label for="<?php echo 'charteroptout_' . $i; ?>">Turn off Charter Alerts</label><br>
                      <br>
                      <input type="checkbox" name="<?php echo 'serviceoptout_' . $i; ?>" id="<?php echo 'serviceoptout_' . $i; ?>" <?php echo $checked = $employee['servicealert_optout'] ? 'checked="checked"' : ''; ?>>
                      <label for="<?php echo 'serviceoptout_' . $i; ?>">Turn off Service Alerts</label><br>
                      <br>
                      <input type="checkbox" name="<?php echo 'alert_enabled_' . $i; ?>" id="<?php echo 'alert_enabled_' . $i; ?>" <?php echo $checked = $employee['alert_optout'] ? 'checked="checked"' : ''; ?>>
                      <label for="<?php echo 'alert_enabled_' . $i; ?>">Opt out of All Alerts</label><br>
                      <?php
                    // }
                  echo '</div>';
                  $i++;
                }
              } else { ?>

                <div class="employee" id="<?php echo 'employee_' . $i . '_wrapper'; ?>">
                  <a class="removenumber" style="display:block;" onclick="remove_employee('<?php echo $i; ?>');"><i class="fas fa-times"></i></a>
                  <input type="text" name="<?php echo 'name_' . $i; ?>" id="<?php echo 'name_' . $i; ?>" class="regular-text" placeholder="Name" value="">
                  <input type="text" name="<?php echo 'title_' . $i; ?>" id="<?php echo 'title_' . $i; ?>" class="regular-text" placeholder="Title" value="">
                  <input type="text" name="<?php echo 'number_' . $i; ?>" id="<?php echo 'number_' . $i; ?>" class="regular-text" placeholder="Mobile Number" value="">
                  <input type="text" name="<?php echo 'email_' . $i; ?>" id="<?php echo 'email_' . $i; ?>" class="regular-text" placeholder="Email" value="">
                  <br>
                  <input type="checkbox" class="sms" name="<?php echo 'sms_enabled_' . $i; ?>" id="<?php echo 'sms_enabled_' . $i; ?>">
                  <label for="<?php echo 'sms_enabled_' . $i; ?>">Enable SMS Alerts</label>
                  <br>
                  <input type="checkbox" name="<?php echo 'charteroptout_' . $i; ?>" id="<?php echo 'charteroptout_' . $i; ?>">
                  <label for="<?php echo 'charteroptout_' . $i; ?>">Turn off Charter Alerts</label><br>
                  <br>
                  <input type="checkbox" name="<?php echo 'serviceoptout_' . $i; ?>" id="<?php echo 'serviceoptout_' . $i; ?>">
                  <label for="<?php echo 'serviceoptout_' . $i; ?>">Turn off Service Alerts</label><br>
                  <br>
                  <input type="checkbox" name="<?php echo 'alert_enabled_' . $i; ?>" id="<?php echo 'alert_enabled_' . $i; ?>">
                  <label for="<?php echo 'alert_enabled_' . $i; ?>">Opt out of All Alerts</label><br>
                </div>

              <?php
              } ?>

              <button id="employee-submit" value="updateemployees">Save Changes</button>

            </form> <?php

      echo '</div>'; /* end forms */
  } else {
    // Public Facing
    if( !empty( $employees ) && $employees[0]['name'] != '' ) {
      ?><div class="employees-public"><?php
      foreach( $employees as $employee ) { ?>
        <div class="employee">
          <div class="icon">

          </div>
          <div class="info">
            <h3>
              <?php echo $employee['name']; ?>
              <?php if( $employee['title'] ){ echo '<span class="title">' . $employee['title'] . '</span>'; } ?>
            </h3>
            <p>
              <?php if( $employee['email'] ){ echo '<span class="email"><a href="mailto:' . $employee['email'] . '">' . $employee['email'] . '</a></span>'; } ?>
              <?php if( $employee['number'] ){ echo '<span class="number"><a href="tel:' . $employee['number'] . '">' . formatPhoneNumber( $employee['number'] ) . '</a></span>'; } ?>
            </p>
          </div>
        </div>
      <?php
      } ?>
      </div> <?php
    }
  } ?>

    <script>
      function add_employee(){

          // var key = jQuery('.employee').length;
          // var wrapper = key - 1;
          // var $wrapper = jQuery('#employee_'+wrapper+'_wrapper');
          //
          // console.log( $wrapper );

          $last = jQuery('.employee').last();
          key = parseInt( $last.attr('id').split('_', 2).pop() ) + 1;

          console.log( key );

          $last.after('<div class="employee" id="employee_'+key+'_wrapper"><a class="removenumber" style="display:block;" onclick="remove_employee(\''+key+'\');"><i class="fas fa-times"></i></a><input type="text" name="name_'+key+'" id="name_'+key+'" class="regular-text" placeholder="Name"><input type="text" name="title_'+key+'" id="title_'+key+'" class="regular-text" placeholder="Title"><input type="text" name="number_'+key+'" id="number_'+key+'" class="regular-text" placeholder="Mobile Number"><input type="text" name="email_'+key+'" id="email_'+key+'" class="regular-text" placeholder="Email"><br><input type="checkbox" class="sms" name="sms_enabled_'+key+'" id="sms_enabled_'+key+'"><label for="sms_enabled_'+key+'">Enable GLADA SMS Alerts</label><br><input type="checkbox" name="charteroptout_'+key+'" id="charteroptout_'+key+'"><label for="charteroptout_'+key+'">Turn off Charter Alerts</label><br><input type="checkbox" name="servicealerts_'+key+'" id="servicealerts_'+key+'"><label for="servicealerts_'+key+'">Turn off Service Alerts</label><br><input type="checkbox" name="alert_enabled_'+key+'" id="alert_enabled_'+key+'"><label for="alert_enabled_'+key+'">Opt out of All Alerts</label><br></div>');

          return false;
      }
      function remove_employee(key){
          var $wrapper = jQuery('#employee_'+key+'_wrapper');
          $wrapper.find('input').val('');
          $wrapper.remove();
          return false;
      }
    </script>

    <?php
    wp_enqueue_script( 'userprofiles', get_template_directory_uri() . '/js/user_profiles.js', array('jquery'), '20200331', true);
}

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
			$charterKey = 'charteroptout_' . $index;
			$serviceKey = 'serviceoptout_' . $index;

			// Save Name and Number
			$employees[ $i ]['name'] = $value;
			$employees[ $i ]['title'] = $_POST[ $titleKey ] ? : '';
			$employees[ $i ]['number'] = stripPhoneNumber( $_POST[ $numberKey ] ) ? : '';
			$employees[ $i ]['email'] = $_POST[ $emailKey ] ? : '';
			$employees[ $i ]['sms_enabled'] = $_POST[ $smsKey ] ? true : false;
			$employees[ $i ]['alert_optout'] = $_POST[ $alertKey ] ? true : false;
			$employees[ $i ]['charteralert_optout'] = $_POST[ $charterKey ] ? true : false;
			$employees[ $i ]['servicealert_optout'] = $_POST[ $serviceKey ] ? true : false;
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

function printable_employees( $user_id ) {
  $instanciate = array(
    'name' => '',
    'title' => '',
    'email' => '',
    'number' => '',
    'ismember' => false,
    'sms_enabled' => false,
    'alert_enabled' => false,
  );
  $employees = json_decode( get_user_meta($user_id, 'mepr_employees', true), true ) ? : array( $instanciate );

  if( !empty( $employees ) && $employees[0]['name'] != '' ) { ?>
    <div class="printable_employees">
      <h4>Team</h4>
      <ul>
      <?php
      foreach( $employees as $employee ) { ?>
        <li class="employee">
          <?php echo '<span class="name">' . $employee['name'] . '</span>'; ?>
          <?php if( $employee['title'] ){ echo ' - <span class="title">' . $employee['title'] . '</span>'; } ?>
          <?php if( $employee['email'] ){ echo '</br><span class="email">' . $employee['email'] . '</span>'; } ?>
          <?php if( $employee['number']){ echo '</br><span class="number">' . formatPhoneNumber( $employee['number'] ) . '</span>'; } ?>
        </li>
      <?php
      } ?>
      </ul>
    </div> <?php
  }
}


/** ********************************************************
 *                     ALERT SETTINGS                      *
 ********************************************************* */

function profile_settings_tab_mobilealerts() {
      global $bp;

      bp_core_new_subnav_item( array(
            'name' => 'GLADA Alerts',
            'slug' => 'mobilealerts',
            'show_for_displayed_user' => false,
            'screen_function' => 'mobilealerts_screen',
            'position' => 40,
            'parent_url'      => bp_displayed_user_domain() . $bp->settings->slug . '/mobilealerts/',
            'parent_slug'     => $bp->settings->slug,
            'default_subnav_slug' => 'mobilealerts'
      ) );
}
add_action( 'bp_setup_nav', 'profile_settings_tab_mobilealerts' );

function mobilealerts_screen() {

    // Add title and content here - last is to call the members plugin.php template.
    add_action( 'bp_template_title', 'mobilealerts_title' );
    add_action( 'bp_template_content', 'mobilealerts_content' );
    bp_core_load_template( 'buddypress/members/single/plugins' );
}
function mobilealerts_title() {
    echo 'Send and Subscribe to the Alerts You Care About';
}

function mobilealerts_content() {

  $user_id = bp_displayed_user_id();

  $alert_optout =   get_user_meta($user_id, 'mepr_alert_optout', true) ?: false;
  $charter_optout = get_user_meta($user_id, 'mepr_charteralert_optout', true) ?: false;
  $service_optout = get_user_meta($user_id, 'mepr_servicealert_optout', true) ?: false;
  $sms_enabled =    get_user_meta($user_id, 'mepr_sms_enabled', true);
  $sms_main =       get_user_meta($user_id, 'mepr_sms_main', true) ?: get_user_meta($user_id, 'mepr_mobile', true);
  $sms_numbers =    get_user_meta($user_id, 'mepr_sms_numbers', true);

  ?>
  <p class="alerts-notice"><?php if(is_dealer(true)) { ?> Dealer Members – Send/Receive alerts on Off-Market aircraft, aircraft coming to the market and aircraft wanted by emailing <a href="mailto:alerts@glada.aero">alerts@glada.aero</a>.<br> <?php } ?>
  Charter Brokers – Send/Receive alerts on Open Charter legs, an immediate charter need, available charters and more by emailing <a href="mailto:charteralerts@glada.aero">charteralerts@glada.aero</a>.<br>
  Services – Share information on upcoming maintenance requirements/SB’s, open maintenance/service slots, etc by emailing <a href="mailto:servicealerts@glada.aero">servicealerts@glada.aero</a>.</p>
  <div class="dealer-alerts-wrapper" id="<?php echo $user_id; ?>">
    <?php if( $alert_optout ) { ?>
      <div class="alert-display">
        <div class="alert-display-icon">
          <i class="fas fa-times"></i>
        </div>
        <div class="alert-display-info">
          <h4>You are not receiving <span>Email or SMS Alerts</span></h4>
        </div>
      </div>
    <?php } else { ?>

      <div class="alert-display <?php echo $sms_enabled ? 'enabled' : ''; ?>" id="sms">
        <div class="alert-display-icon">
          <i class="fas fa-check"></i>
        </div>
        <div class="alert-display-info enabled">
            <h4><span>SMS Alerts</span> are ON. Receiving at <?php echo formatPhoneNumber( $sms_main ); ?></h4>
            <p>To Subscribe Team Members to GLADA Alerts, manage their settings under 'Team'.</p>
        </div>
        <div class="alert-display-info disabled">
            <h4>You are not receiving <span>SMS Alerts</span></h4>
            <p>You will still receive them via email.</p>
        </div>
      </div>
      <div class="alert-display <?php echo $charter_optout ? '' : 'enabled'; ?>" id="charter">
        <div class="alert-display-icon">
          <i class="fas fa-envelope"></i>
        </div>
        <div class="alert-display-info enabled">
          <h4><span>Charter Alerts</span> are ON.</h4>
        </div>
        <div class="alert-display-info disabled">
          <h4>You are NOT receiving <span>Charter Alerts</span></h4>
        </div>
      </div>
      <div class="alert-display <?php echo $service_optout ? '' : 'enabled'; ?>" id="service">
        <div class="alert-display-icon">
          <i class="fas fa-envelope"></i>
        </div>
        <div class="alert-display-info enabled">
          <h4><span>Service Alerts</span> are ON.</h4>
        </div>
        <div class="alert-display-info disabled">
          <h4>You are NOT receiving <span>Service Alerts</span></h4>
        </div>
      </div> <?php

    } ?>
  	<div class="iphone">
  		<img src="<?php echo get_stylesheet_directory_uri() ?>/images/DealerAlertPhone.png">
  	</div>
  </div>
  <?php if( $sms_enabled == true ) {
    echo '<p class="alerts-vcard"><a href="' . get_stylesheet_directory_uri() . '/images/GLADA_Alerts.vcf">Click Here to Download the GLADA Alerts vCard.</a></p>';
  } ?>

  <div class="mobile-form">
      <form action="#" method="POST" id="mobile-alert-form" enctype="multipart/form-data">

        <input type="hidden" name="action" value="updatemobilesettings">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />

        <div class="mynumber">
            <label for="mobile">Receive at:</label>
            <input type="text" name="mobile" id="mobile" class="regular-text" placeholder="<?php echo get_user_meta($user_id, 'mepr_mobile', true); ?>" value="<?php echo get_user_meta($user_id, 'mepr_sms_main', true) ? formatPhoneNumber( get_user_meta($user_id, 'mepr_sms_main', true) ) : ''; ?>">
        </div><br>
        <div>
          <input type="checkbox" id="service_optout" name="service_optout" <?php if( $alert_optout ){ echo 'checked="checked"'; }; ?>>
          <label for="service_optout">Opt out of all Alerts</label>
        </div>
        <button id="mobile-alert-submit" value="updatemobilesettings">Save Settings</button>
      </form>
  </div>

  <?php
  wp_enqueue_script( 'mobilealerts', get_template_directory_uri() . '/js/mobilealerts.min.js', array('jquery'), '20200331', true);

}

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

		// Now save this info to Wordpress
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

function toggle_sms() {
  $user = $_POST['user'];
  $name = $_POST['name'];
  $needtosync = false;

  switch( $name ) {
    case 'sms' :
      $metakey = 'mepr_sms_enabled';
      $needtosync = true;
      break;
    case 'charter' :
      $metakey = 'mepr_charteralert_optout';
      break;
    case 'service' :
      $metakey = 'mepr_servicealert_optout';
      break;
    default :
      $metakey = false;
  }

  if( $metakey ) {
    $invert = get_user_meta( $user, $metakey, true ) ? false : true;
    $try = update_user_meta( $user, $metakey, $invert );
  }

  if( $needtosync ) {
    $employees = json_decode( get_user_meta( $user, 'mepr_employees', true ), true );
    sync_with_TextMagic( $user, false, $employees );
  }

  wp_die( $try );
}
add_action( 'wp_ajax_togglesms', 'toggle_sms' );
add_action( 'wp_ajax_nopriv_togglesms', 'toggle_sms' );

/* NOTIFICATION ALERTS */

// First, create Alert Submission to Post Type
// Then notify users

// function alert_component( $component_names = array() ) {
//
//     // Force $component_names to be an array
//     if ( ! is_array( $component_names ) ) {
//         $component_names = array();
//     }
//
//     // Add 'custom' component to registered components array
//     array_push( $component_names, 'g_alert' );
//
//     // Return component's with 'g_alert' appended
//     return $component_names;
// }
// add_filter( 'bp_notifications_get_registered_components', 'alert_component' );
//
// function custom_format_buddypress_notifications( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {
//
//     // New custom notifications
//     if ( 'g_alert_action' === $action ) {
//
//         $comment = get_comment( $item_id );
//
//         $custom_title = $comment->comment_author . ' commented on the post ' . get_the_title( $comment->comment_post_ID );
//         $custom_link  = get_comment_link( $comment );
//         $custom_text = $comment->comment_author . ' commented on your post ' . get_the_title( $comment->comment_post_ID );
//
//         // WordPress Toolbar
//         if ( 'string' === $format ) {
//             $return = apply_filters( 'custom_filter', '<a href="' . esc_url( $custom_link ) . '" title="' . esc_attr( $custom_title ) . '">' . esc_html( $custom_text ) . '</a>', $custom_text, $custom_link );
//
//         // Deprecated BuddyBar
//         } else {
//             $return = apply_filters( 'custom_filter', array(
//                 'text' => $custom_text,
//                 'link' => $custom_link
//             ), $custom_link, (int) $total_items, $custom_text, $custom_title );
//         }
//
//         return $return;
//     }
//
// }
// add_filter( 'bp_notifications_get_notifications_for_user', 'custom_format_buddypress_notifications', 10, 5 );

function send_glada_alert() {
  $args = array(
    'user_id' => $receiver->id,
    'item_id' => $sender->id,
    'component_name' => 'g_alert',
    'component_action' => 'g_alert_action',
    'date_notified' => bp_core_current_time(),
    'is_new' => 1,
  );
  $notification_id = bp_notifications_add_notification( $args );
}


/** ********************************************************
 *                  BUDDYPRESS SUPPORT                     *
 ********************************************************* */

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

 // Buddypress AJAX Member query
 // Directory Search and Pagination
 // Only include Dealers and Industry Members
 function modify_members_loop( $qs=false, $object=false ) {
   if ( $object != 'members' ) {
 		return $qs;
 	}

   $members =  get_users(
 		array(
 			'fields' => 'ID',
 			'role__not_in' => array(
 				'industry',
 				'dealer',
 			)
 		) );

 	$args = wp_parse_args($qs);
 	$args['exclude'] = $members;

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


function wordpress_to_buddypress( $user_id ) {

  $user_id = $user_id ? : get_current_user_id();
  $userObj = get_userdata( $user_id );
  $userMeta = get_user_meta( $user_id );

  $buddypressKey = array(
    'Company Name'    => 'mepr_company',
    'Title'           => 'mepr_title',
    'Website'         => 'mepr_company_website',
    'Phone Number'    => 'mepr_phone_number',
    'Fax Number'      => 'mepr_fax',
    'Mobile Number'   => 'mepr_mobile',
    'Industry Type'   => 'mepr_industry_type',
    'Services'        => 'mepr_services',
    'Aviation Association Memberships and Affiliations' => 'mepr_aviation_associations_memberships_and_affiliations',
  );

  foreach( $buddypressKey as $bp => $wp ) {
    if ( xprofile_get_field_id_from_name( $bp ) ) {

      if( count( $userMeta[$wp] ) == 1 ) {
        // Only one item. Could be lots of things.
        if( filter_var( $userMeta[ $wp ][0], FILTER_VALIDATE_URL ) ) {
          // This is a URL. Make sure it works
          $field_value = addScheme( $userMeta[ $wp ][0] );
        } elseif( is_serialized( $userMeta[ $wp ][0] ) ) {
          // This is a serialized array. Convert it and check it out.
          $array = unserialize( $userMeta[ $wp ][0] );
          // This is an array, let's figure out what kind
          $firstval = reset( $array );
          $field_value = array();
          if( $firstval == "on" ) {
            // this is probably a checkbox input. make a new array that buddypress will like
            foreach( $array as $key => $on ) {
              $field_value[] = ucwords( $key );
            }
          } else {
            // Not checkboxes. Just uppercase the array.
              $field_value = array_map( 'ucwords', $array );
          }

        } else {
          // Not serialized, just a string (probably)
          $field_value = ucwords( $userMeta[ $wp ][0] );
        }
      } else {
        // More than one item in this array. Uppercase them.
        $field_value = array_map( 'ucwords', $userMeta[ $wp ] );
      }

      if( $field_value ) {
        //echo 'Set ' . $bp . ' to ' . $field_value . '<br>';
        xprofile_set_field_data($bp, $user_id, $field_value);
      } else {
        //echo 'No data for ' . $bp . '<br>';
      }
    }
  }

}
add_action( 'profile_update', 'wordpress_to_buddypress', 11, 2 );
add_action( 'personal_options_update', 'wordpress_to_buddypress' );
add_action( 'edit_user_profile_update', 'wordpress_to_buddypress' );

function buddypress_to_wordpress( $obj ) {

  $dataKey = array(
    13 => 'mepr_company',
    5  => 'mepr_title',
    15 => 'mepr_company_website',
    7  => 'mepr_phone_number',
    59 => 'mepr_fax',
    9  => 'mepr_mobile',
    17 => 'mepr_industry_type',
    98 => 'mepr_services',
    57 => 'mepr_aviation_associations_memberships_and_affiliations',
  );

  foreach( $dataKey as $bp => $wp ) {
    if ( $obj->field_id == $bp ) {
      switch( $wp ) {
        case 'mepr_industry_type':
          $value = strtolower( $obj->value );
          break;
        case 'mepr_services':
          $data = unserialize( $obj->value );
          $value = array();
          foreach( $data as $key ) {
            $value[ strtolower( $key ) ] = 'on';
          }
          break;
        default:
          $value = $obj->value;
      }
      update_user_meta( $obj->user_id, $wp, $value );
      break;
    }
  }
}
add_action( 'xprofile_data_after_save', 'buddypress_to_wordpress' );


remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_format_field_value_by_type', 8);
add_filter(    'bp_get_the_profile_field_value', 'do_it_my_way', 8, 3 );
// replacement of this BP filter to exclude phone numbers and display them how we want to
// buddypress > bp-xprofile > bp-xprofile-filters.php @277
function do_it_my_way( $field_value, $field_type = '', $field_id = '' ) {
	foreach ( bp_xprofile_get_field_types() as $type => $class ) {
		if ( $type !== $field_type ) {
			continue;
		}
    if ( $field_type === 'telephone' ) {
      $field_value = '<a href="tel:' . stripPhoneNumber( $field_value ) . '" rel="nofollow">' . formatPhoneNumber( $field_value ) . '</a>';
      continue;
    }

		if ( method_exists( $class, 'display_filter' ) ) {
			$field_value = call_user_func( array( $class, 'display_filter' ), $field_value, $field_id );
		}
	}

	return $field_value;
}

function get_company_logo( $user_id ) {
  // This function is for getting the Company Logo, checking for the deprecated old Logo and returning it if a new one cannot be found
  $contact = get_user_meta( $user_id );

  $logo = isset($contact['memberpress_avatar']) ? $contact['memberpress_avatar'][0] : false;
  $newlogo = bp_attachments_get_attachment( 'url', array( 'item_id' => $user_id ) );

  if ( $newlogo ) {
    return $newlogo;
  } elseif ( $logo ) {
    return wp_get_attachment_url( $logo );
  } else {
    return '';
    // Should probably make this a temp image
  }
}

function addScheme($url, $scheme = 'http://')
{
  return parse_url($url, PHP_URL_SCHEME) === null ?
    $scheme . $url : $url;
}

// Automatically Set Accounts to MANAGED and CHILD if they are a SUB-ACCOUNT
function check_corporate() {
  // $roles = $user->roles;
  // TODO
}


/** ********************************************************
 *                     ADMIN SCRIPTS                       *
 ********************************************************* */

/** Add Scripts to Admin */
function glad_add_admin_scripts(){
	wp_enqueue_media();
	wp_enqueue_script('glad-uploader', get_stylesheet_directory_uri().'/js/uploader.js', array('jquery'), false, true );
}
add_action('admin_enqueue_scripts', 'glad_add_admin_scripts');

/**
 * Save Updated User Meta on the Back End
 */
function glad_profile_update($user_id){
	if( current_user_can('edit_users') ){
		// Check for Update to Branding Logo, Save if needed
		// $profile_pic = empty($_POST['glad_image_id']) ? '' : $_POST['glad_image_id'];
		// update_user_meta($user_id, 'memberpress_avatar', $profile_pic);
		// // Check for Update to Branding Color, Save if needed
		// $color = empty($_POST['color_code']) ? '' : $_POST['color_code'];
		// update_user_meta($user_id, 'branding_color1', $color);
		// // Check for Update to Notes, Save if needed
		// $notes = empty($_POST['notes']) ? '' : $_POST['notes'];
		// update_user_meta($user_id, 'notes', $notes);
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


// Add a "Last Updated" field to compare with Wild Apricot
function profileLastUpdated( $user_id ) {
  update_user_meta( $user_id, 'profileLastUpdated', current_time( 'mysql' ) );
}
add_action( 'profile_update', 'profileLastUpdated' );
