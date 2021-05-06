<?php
/**
 * WildApricot Functions and Support
 *
 * @package _glad
 */

 /** **************************************************
  *               CREATE NEW USER ROLES               *
  *************************************************** */

  // Instanciate Wild Apricot API
  global $waApiClient;
  global $accountUrl;

  $waApiClient = WaApiClient::getInstance();
  try {
    $waApiClient->initTokenByApiKey('gnb9yn2costjf4ynocej1qpz80402o');
    // $waApiClient->initTokenByContactCredentials('admin@yourdomain.com', 'your_password');
  } catch (Exception $e) {
    $error = $e->getMessage();
  }


  // Get API URL using API KEY
  // $account = getAccountDetails();
  // $accountUrl = $account['Url'];
  $wa_accountId = '298274';
  $accountUrl = 'https://api.wildapricot.org/v2.2/Accounts/' . $wa_accountId;

  // CALL STUFF WHEN SAVING PROFILE INFO

  // Add a "Last Updated" field to compare with Wild Apricot
  function pushToWildApricot( $user_id ) {
    updateContact( $user_id );
  }
  add_action( 'profile_update', 'pushToWildApricot', 11, 2 );
  add_action( 'personal_options_update', 'pushToWildApricot' );
  add_action( 'edit_user_profile_update', 'pushToWildApricot' );

  function getUpdateOnLogin( $user ) {
    checkForUpdates( $user->ID, true );
  }
  add_action( 'wp_login', 'getUpdateOnLogin' );

  function getAccountDetails()
  {
     global $waApiClient;
     $url = 'https://api.wildapricot.org/v2.2/Accounts/';
     $response = $waApiClient->makeRequest($url);
     return  $response[0]; // usually you have access to one account
  }

  function getContactsList( $count )
  {
     global $waApiClient;
     global $accountUrl;

     $count = $count ? : '';

     $queryParams = array(
      '$async' => 'false', // execute request synchronously
      '$top' => $count, // limit result set to 10 records
      //'$filter' => 'Member eq true', // filter only members
      '$select' => '\'First name\', \'Last name\', \'Fax\', \'Mobile\'',
      '$getExtendedMembershipInfo' => true
     ); // select only first name and last name to reduce size of json data
     $url = $accountUrl . '/contacts/?' . http_build_query($queryParams);
     return $waApiClient->makeRequest($url);
  }

  function contactExists( $email )
  {
     global $waApiClient;
     global $accountUrl;

     $queryParams = array(
      '$async' => 'false', // execute request synchronously
      '$select' => '\'User id\'', // all we want is User ID
      '$filter' => 'Email eq ' . $email, // Let's look for this email address
     );
     $url = $accountUrl . '/contacts/?' . http_build_query($queryParams);
     $contactArray = $waApiClient->makeRequest($url);

     if( !empty( $contactArray['Contacts'] ) ) {

       // This will find FieldValues if needed
       // $data = $contactArray['Contacts'][0];
       // $key = array_filter( $data, function( $val ){
       //   $val['SystemCode'] == 'MemberId';
       // }, ARRAY_FILTER_USE_KEY );
       // $id = $data[$key]['Value'];

       return $contactArray['Contacts'][0]['Id'];
     } else {
       return false;
     }
  }

  function overwriteField( $args )
  {
    // We're PULLING a single field to overwrite from WildApricot to Wordpress
    global $waApiClient;
    global $accountUrl;

    $fieldNameWA =      $args['wildapricot'];
    $fieldNameNice =    '\'' . $args['nicename'] . '\'';
    $fieldNameWP =      $args['wordpress'];

    // Get ALL Contacts
    $queryParams = array(
     '$async' => 'false', // execute request synchronously
     '$top' => '', // no limit
     //'$filter' => 'Member eq true', // filter only members
     '$select' => '\'First name\', \'Last name\', ' . $fieldNameNice
    );
    $url = $accountUrl . '/contacts/?' . http_build_query($queryParams);
    $contactsResult = $waApiClient->makeRequest($url);
    $contacts =  $contactsResult['Contacts'];

    // For Each Contact, Set the new Value
    foreach($contacts as $contact) {

       $vals = $contact['FieldValues'];
       $user = get_user_by( 'email', $contact['Email'] );

       if( $user ) {

         foreach($vals as $array) {
           if ( $array['SystemCode'] === $fieldNameWA ) {

             $updated = update_user_meta( $user->ID, $fieldNameWP, $array['Value']);
             // this will return false if the old and new vals are the same
             if( $updated ) {
               $result .= "Succcessfully updated " . $array['FieldName'] . " for " . $contact['Id'] . "<br>";
             }
             break;
           }
         }
       }
    }

    return $result;
  }

  function updateContact( $userId ) {
    // We're PUSHING from Wordpress to Wild Apricot.

    // TODO create function that only syncs data, then use sync_memberships and sync_finances for a more streamlined and less duplicated thing.

    // Get User Data
    $userId = $userId ? : get_current_user_id(); // If no ID was passed, get the current user
    $userObj = get_userdata( $userId );
    $userMeta = get_user_meta( $userId );

    // Set some variables
    $login =          $userObj->user_login;
    $pass =           $userObj->user_pass;
    $email =          $userObj->user_email;
    $regDate =        new DateTime( $userObj->user_registered );

    $roles =          $userObj->roles;
    $approved =       in_array( 'Approved', $roles ) ? true : false;
    $promoted =       in_array( 'Promoted', $roles ) ? true : false;
    $managed =        in_array( 'Managed', $roles ) ? true : false;
    $memberRole =     $approved ? 'Approved' : $promoted ? 'Promoted' : $managed ? 'Managed' : null;

    $applicationType = $userMeta['mepr_membership_type'][0];
    $applicationKeys = array(
      'dealer' => array( 'Id' => 12773480, 'Label' => 'Dealer' ),
      'industry' => array( 'Id' => 12773479, 'Label' => 'Industry' )
    );
    $groupKeys = array(
      'board' => array( 'Id' => 509705, 'Label' => 'Board Members' ),
      'dealer' => array( 'Id' => 537599, 'Label' => 'Dealer Members' ),
      'industry' => array( 'Id' => 537600, 'Label' => 'Industry Members' )
    );
    $wa_applicationType = $applicationKeys[$applicationType];
    $wa_group = $groupKeys[$applicationType];

    // Get Memberpress Membership ID
    // $membership = $member->get_enabled_product_ids(); This doesn't work. Keeping it for reference
    $memberData = new MeprUser( $userId ); // Create a new Member object to get the other stuff
    $active_subs = $memberData->active_product_subscriptions('ids', true);
    if( !empty($active_subs) ) {

      // it's possible for there to be two memberships. Don't use Application
      if( count( $active_subs ) > 1 ) {
        foreach( $active_subs as $sub_id ) {
          if ( $sub_id == '157' ) {
            break;
          }
          $wp_MembershipID = $sub_id;
        }
      } else {
        $wp_MembershipID = $active_subs[0];
      }

      $membershipKeys = array(
        '157' => 1122131, // Applicant
        '19' => 1088900, // Dealer, Recurring
        '588' => 1122135, // Dealer, Non-Recurring
        '232' => 1122134, // Dealer, Quarterly Recurring
        '580' => 1122136, // Dealer, Quarterly Non-Recurring
    		'1268' => 1222512, // Dealer, Quarterly, 20-Discount
    		'1499' => 1258359, // Dealer, Quarterly, 40-Discount
        '20' => 1088901, // Industry, Recurring
        '589' => 1122137, // Industry, Non-Recurring
        '247' => 1122138, // Industry, Quarterly Recurring
        '587' => 1122139, // Industry, Quarterly Non-Recurring
        '1020' => 1172196, // Industry, Split-payment
    		'1416' => 1248712, // Free Trial
      );
      // 1079373 - Dealer Member Prospect
      $wa_MembershipID = $membershipKeys[$wp_MembershipID];

      // Get Transaction Details
      $transaction = MeprUser::get_user_product_expires_at_date($userId, $wp_MembershipID, true);
        // Object Properties:
          // trans_num -- i.e., "mp-txn-5d5abd68abfd5"
          // txn_type -- i.e., "payment"
          // user_id
          // gateway -- i.e., "manual"
          // status
            // Complete
            // Pending
            // Failed
            // Refunded
      $trans_num  = $transaction->rec->trans_num;
      $txn_type   = $transaction->rec->txn_type;
      $status     = $transaction->rec->status;
      $gateway    = $transaction->rec->gateway;
      // echo '<h3>Transaction Deets</h3><br>' . 'transaction number: ' . $trans_num . '<br>type: ' . $txn_type . '<br>status' . $status . '<br>gateway: ' . $gateway . '<br><br>';

      $statusKeys = array(
        'complete' => 'Active',
        'pending' => 'PendingNew'
      );
      $wa_MembershipStatus  = $statusKeys[$status];

      $creationDate = $transaction->rec->created_at;
      if( $creationDate != '0000-00-00 00:00:00' ) {
        $creationDate = DateTime::createFromFormat('Y-m-d H:i:s', $creationDate );
        $creation = $creationDate->format('Y-m-d\T00:00:00');
      } else {
        $creation = null;
      }

      $expDate = $transaction->rec->expires_at;
      if( $expDate != '0000-00-00 00:00:00' ) {
        $expDate = DateTime::createFromFormat('Y-m-d H:i:s', $expDate );
        $expiration = $expDate->format('Y-m-d\T00:00:00');
        // set status to Lapsed
        $now = new DateTime;
        if( $expDate < $now ) {
          $wa_MembershipStatus = 'Lapsed';
        }
      } else {
        $expiration = null;
      }

      // ASSIGN membership data and
      // INSTANCIATE Nested Array
      $data = array(
       'MembershipEnabled' => true,
       'MembershipLevel' => array(
         'Id' => $wa_MembershipID
       ),
       'Status' => $wa_MembershipStatus,
       'FieldValues' => array()
      );

    } else {
      // ASSIGN membership data and
      // INSTANCIATE Nested Array
      $data = array(
       'MembershipEnabled' => false,
       'FieldValues' => array()
      );
    }

    // Below is the Data Structure for Wild Apricot

    //////////////////////
    // CONTACTS
    //////////////////////
    // FirstName
    // LastName
    // Email
    // DisplayName
    // Organization
    // ProfileLastUpdated
    // MembershipLevel -> Id, Url, Name
    // MembershipEnabled
    // Status
    // FieldValues -->
      // IsArchived
      // IsDonor
      // IsEventAttendee
      // IsMember
      // IsSuspendedMember
      // ReceiveEventReminders
      // ReceiveNewsletters
      // EmailDisabled
      // ReceivingEMailsDisabled
      // Balance
      // TotalDonated
      // RegisteredForEvent
      // LastUpdated
      // LastUpdatedBy
      // CreationDate
      // LastLoginDate
      // AdminRole
      // Notes
      // SystemRulesAndTermsAccepted
      // SubscriptionSource
      // MemberId
      // FirstName
      // LastName
      // Organization
      // custom-11255125 (Title)
      // Email
      // Phone
      // custom-11263510 (Fax)
      // custom-11230723 (Mobile)
      // custom-11227341 (Privacy Policy)
      // custom-11227394 (Affiliations and Organizations)
      // custom-11227416 (Address - FULL)
      // custom-11227417 (Website)
      // custom-11230695 (Referral)
      // custom-11263691 (Advisory Board)
      // custom-11276092 (Service Offered)
      // custom-11659567 (MBPR_ID)
      // custom-11659568 (WA_ID)
      // MemberRole
      // MemberSince
      // RenewalDue
      // MembershipLevelId
      // AccessToProfileByOthers
      // RenewalDateLastChanged
      // LevelLastChanged
      // BundleId
      // Status
        // OPTIONS:
        // "Id": 1, "Label": "Active", "Value": "Active",
        // "Id": 20, "Label": "Pending - New", "Value": "PendingNew",
      // MembershipEnabled
      // Groups
      // custom-11648812 (Application Membership Level)
    // Id
    // Url
    // IsAccountAdministrator
    // TermsOfUseAccepted

    //////////////////////
    // MEMBERSHIPS
    //////////////////////

    // Membership IDs are as follows:
      // Applicant - 157
      // Dealer Members - 19, 588 (non-recurring), 232 (quarterly), 580 (quarterly non-recurring)
      // Industry Members - 20, 589 (non-recurring), 247 (quarterly), 587 (quarterly non-recurring)
    // WildApricot Member IDs:
      // Applicant - 1122131
      // Dealer (Recurring) - 1088900
      // Dealer (Non-Recurring) - 1122135
      // Dealer Quarterly (Recurring) - 1122134
      // Dealer Quarterly (Non-Recurring) - 1122136
      // Industry (Recurring) - 1088901
      // Industry (Non-Recurring) - 1122137
      // Industry Quarterly (Recurring) - 1122138
      // Industry Quarterly (Non-Recurring) - 1122139

    // Membership Status (WA)
      // Active - 1
      // Lapsed - 2
      // PendingRenewal - 3
      // PendingNew - 20
      // PendingLevelChange - 30


    // Set Data
    $data['FieldValues'][] = array(
      'FieldName' => 'First name',
      'SystemCode' => 'FirstName',
      'Value' => $userMeta['first_name'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Last name',
      'SystemCode' => 'LastName',
      'Value' => $userMeta['last_name'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Company name',
      'SystemCode' => 'Organization',
      'Value' => $userMeta['mepr_company'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Title',
      'SystemCode' => 'custom-11255125',
      'Value' => $userMeta['mepr_title'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Website',
      'SystemCode' => 'custom-11227417',
      'Value' => $userMeta['mepr_company_website'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Email',
      'SystemCode' => 'Email',
      'Value' => $email
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Office Phone',
      'SystemCode' => 'Phone',
      'Value' => $userMeta['mepr_phone_number'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Fax',
      'SystemCode' => 'custom-11263510',
      'Value' => $userMeta['mepr_fax'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Mobile',
      'SystemCode' => 'custom-11230723',
      'Value' => $userMeta['mepr_mobile'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Affliations and Organizations',
      'SystemCode' => 'custom-11227394',
      'Value' => $userMeta['mepr_aviation_associations_memberships_and_affiliations'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Referral',
      'SystemCode' => 'custom-11230695',
      'Value' => $userMeta['mepr_referral'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Address Line 1',
      'SystemCode' => 'custom-11227394',
      'Value' => $userMeta['mepr-address-one'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Address Line 2',
      'SystemCode' => 'custom-11227394',
      'Value' => $userMeta['mepr-address-two'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'City',
      'SystemCode' => 'custom-11227394',
      'Value' => $userMeta['mepr-address-city'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Country',
      'SystemCode' => 'custom-11670289',
      'Value' => $userMeta['mepr-address-country'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'State',
      'SystemCode' => 'custom-11670290',
      'Value' => $userMeta['mepr-address-state'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Zip code',
      'SystemCode' => 'custom-11227394',
      'Value' => $userMeta['mepr-address-zip'][0]
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Member role',
      'SystemCode' => 'MemberRole',
      'Value' => $memberRole
    );
    // $data['FieldValues'][] = array(
    //   'FieldName' => 'Member Role',
    //   'SystemCode' => 'custom-11983748',
    //   'Value' => array()
    // );
    $data['FieldValues'][] = array(
      'FieldName' => 'Application Membership Level',
      'SystemCode' => 'custom-11648812',
      'Value' => $wa_applicationType
    );
    // $data['FieldValues'][] = array(
    //   'FieldName' => 'Membership enabled',
    //   'SystemCode' => 'MembershipEnabled',
    //   'Value' => true
    // );
    // $data['FieldValues'][] = array(
    //   'FieldName' => 'Membership level ID',
    //   'SystemCode' => 'MembershipLevelId',
    //   'Value' => $wa_MembershipID
    // );
    // $data['FieldValues'][] = array(
    //   'FieldName' => 'Membership status',
    //   'SystemCode' => 'Status',
    //   'Value' => array(
    //     'Id' => 1,
    //     'Label' => 'Active',
    //     'Value' => 'Active',
    //     'SelectedByDefault' => false,
    //     'Position' => 0
    //   )
    // );
    $data['FieldValues'][] = array(
      'FieldName' => 'Group participation',
      'SystemCode' => 'Groups',
      'Value' => $wa_group
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Member since',
      'SystemCode' => 'MemberSince',
      'Value' => $creation
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Renewal due',
      'SystemCode' => 'RenewalDue',
      'Value' => $expiration
    );
    // $data['FieldValues'][] = array(
    //   'FieldName' => 'Notes',
    //   'SystemCode' => 'Notes',
    //   'Value' => $userMeta['notes'][0]
    // );
    $data['FieldValues'][] = array(
      'FieldName' => 'Terms of use accepted',
      'SystemCode' => 'SystemRulesAndTermsAccepted',
      'Value' => true
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Privacy Policy',
      'SystemCode' => 'custom-11227341',
      'Value' => true
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'MBPR_ID',
      'SystemCode' => 'custom-11659567',
      'Value' => strval( $userId )
    );
    $data['FieldValues'][] = array(
      'FieldName' => 'Creation date',
      'SystemCode' => 'CreationDate',
      'Value' => $regDate->format('Y-m-d\TH:i:sP')
    );
    // $data['FieldValues'][] = array(
    //   'FieldName' => 'Last login date',
    //   'SystemCode' => 'LastLoginDate',
    //   'Value' => strval( $userId )
    // );

    //////////////////
    // DO THE THING!
    global $waApiClient;
    global $accountUrl;

    // Next, let's send this data over to Wild Apricot
    // Does this contact already have an ID in Wild Apricot?
    $wa_ID = contactExists( $email ) ? : $userMeta['mepr__waid'][0];

    if( !$wa_ID ) { // CONTACT DOES NOT EXIST IN WILD APRICOT. POST REQUEST ( create new )

      $verb = 'POST';
      $url = $accountUrl . '/contacts/';

    } else { // CONTACT EXISTS. PUT REQUEST ( update )

      $data['FieldValues'][] = array(
        'FieldName' => 'WA_ID',
        'SystemCode' => 'custom-11659568',
        'Value' => strval( $wa_ID )
      );

      $verb = 'PUT';
      $url = $accountUrl . '/contacts/' . $wa_ID;

      $data['Id'] = $wa_ID;

    }
    return $waApiClient->makeRequest($url,$verb,$data);

  }

  // THIS IS BROKEN. DATETIME from a string is like so:
  // DateTime::createFromFormat('Y-m-d H:i:s', $date );
  // I just need to know the format of the data.
  function checkForUpdates( $userId, $forceUpdate = false ) {

    // Get User Data from WP
    $userId = $userId ? : get_current_user_id(); // If no ID was passed, get the current user
    $userObj = get_userdata( $userId );
    $userMeta = get_user_meta( $userId );

    // Grab the UserData from WildApricot
    global $waApiClient;
    global $accountUrl;

    $wa_ID = contactExists( $userObj->data->user_email ) ? : $userMeta['mepr__waid'][0];
    $url = $accountUrl . '/contacts/' . $wa_ID;
    $contact = $waApiClient->makeRequest($url);

    $wa_lastUpdated = new DateTime( $contact['ProfileLastUpdated'] );
    $wp_lastUpdated = $userMeta['profileLastUpdated'] ? new Datetime( $userMeta['profileLastUpdated'][0], new DateTimeZone('America/Chicago') ) : null;

    if( !$forceUpdate && ( $wp_lastUpdated && $wp_lastUpdated > $wa_lastUpdated ) ) {
      // echo '<!-- ' . $contact['FirstName'] . ' ' . $contact['LastName'] . ' (' . $contact['Id'] . '): Up to Date. ';
      // echo 'Last WildApricot Update: ' . $wa_lastUpdated->format('Y-m-d H:i:sP') . ' -->';
    } elseif( $forceUpdate || ( $wp_lastUpdated && $wa_lastUpdated > $wp_lastUpdated ) ) {
      // echo '<!--' . $contact['FirstName'] . ' ' . $contact['LastName'] . ' (' . $contact['Id'] . '): Outdated. Pull from Wild Apricot. ';
      // echo 'Last Wordpress Update: ' . $wp_lastUpdated->format('Y-m-d H:i:sP') . ' -->';

      // DISABLE FILTER FOR updateContact function UNTIL AFTER WE DO ALL OF THIS
      remove_action( 'profile_update', 'pushToWildApricot' );

      // Instanciate Array and Set UpdateTime to Now
      $data = array(
        'profileLastUpdated' => current_time( 'mysql' )
      );

      // Let's create our Key between WA and WP data
      $dataKey = array(
        'FirstName'       => 'first_name',
        'LastName'        => 'last_name',
        'Organization'    => 'mepr_company',
        'custom-11255125' => 'mepr_title',
        'custom-11227417' => 'mepr_company_website',
        'Phone'           => 'mepr_phone_number',
        'custom-11263510' => 'mepr_fax',
        'custom-11230723' => 'mepr_mobile',
        'custom-11227416' => 'mepr-address-one',
        'custom-11667590' => 'mepr-address-two',
        'custom-11667591' => 'mepr-address-city',
        'custom-11670289' => 'mepr-address-country',
        'custom-11670290' => 'mepr-address-state',
        'custom-11667594' => 'mepr-address-zip',
        'custom-11227394' => 'mepr_aviation_associations_memberships_and_affiliations',
        'custom-11230695' => 'mepr_referral',
        'custom-11648812' => 'mepr_membership_type',
        'Notes'           => 'notes'
      );

      // Parse through all of the Wild Apricot Field Values
      $fieldValues = $contact['FieldValues'];
      foreach( $fieldValues as $array ) {
        $key = $array['SystemCode'];
        $value = $array['Value'];
        if( is_array( $value ) ){
          $value = $value['Label'];
        }
        // If there's a matching Wordpress field, Prep for Update
        if( $dataKey[$key] ) {
          $data[ $dataKey[$key] ] = $value;
        }
      }
      //TODO set user role
      //TODO set membership data

      // Do the Thing
      foreach($data as $key => $value) {
        update_user_meta( $userId, $key, $value );
      }

      // ENABLE FILTER AGAIN
      add_action( 'profile_update', 'pushToWildApricot', 11, 2 );

    } else {
      // wordpress date does not exist
      echo '<!-- ' . $contact['FirstName'] . ' ' . $contact['LastName'] . ' (' . $contact['Id'] . '): No Date In System -->';
    }

    return $contact;
  }

  function filterContent() {
    $queryParams = array(
      '$async' => 'false',
      '$filter' => '"Membership level ID" eq {LEVEL_ID}'
    );
  }

  /**
   * Wild Apricot Support Functions
   */
  function approveMembership( $approve_url ) {
   	global $waApiClient;
   	$verb = 'POST';
   	$data = ' ';
   	$approveResult = $waApiClient->makeRequest( $approve_url, $verb, $data );
   	return $approveResult;
  }

  function updateMembership( $userId, $wa_ID, $wp_MembershipID ) {

   	$transaction = MeprUser::get_user_product_expires_at_date($userId, $wp_MembershipID, true);
   	$status      = $transaction->status;

  	$membershipKeys = array(
  		'157' => 1122131, // Applicant
  		'19' => 1088900, // Dealer, Recurring
  		'588' => 1122135, // Dealer, Non-Recurring
  		'232' => 1122134, // Dealer, Quarterly Recurring
  		'580' => 1122136, // Dealer, Quarterly Non-Recurring
  		'1268' => 1222512, // Dealer, Quarterly, 20-Discount
  		'1499' => 1258359, // Dealer, Quarterly, 40-Discount
  		'1307' => 1231658, // Dealer, 20-Discount
  		'20' => 1088901, // Industry, Recurring
  		'589' => 1122137, // Industry, Non-Recurring
  		'247' => 1122138, // Industry, Quarterly Recurring
  		'587' => 1122139, // Industry, Quarterly Non-Recurring
  		'1020' => 1172196, // Industry, Split Payment
  		'1416' => 1248712, // Free Trial
  	);
   	$wa_MembershipID = $membershipKeys[$wp_MembershipID];
   	$statusKeys = array(
   		'complete' => 'Active',
   		'pending' => 'PendingNew'
   	);
   	$wa_MembershipStatus  = $statusKeys[$status];

   	$expDate = $transaction->expires_at;
   	if( $expDate != '0000-00-00 00:00:00' ) {
   		$expDate = DateTime::createFromFormat('Y-m-d H:i:s', $expDate );
   		$expiration = $expDate->format('Y-m-d\T00:00:00');
   	} else {
   		$expiration = null;
   	}

   	$data = array(
   	 'MembershipEnabled' => true,
   	 'MembershipLevel' => array(
   		 'Id' => $wa_MembershipID
   	 ),
   	 'Status' => $wa_MembershipStatus,
   	 'FieldValues' => array(
   		 array(
   			 'FieldName' => 'Renewal due',
   			 'SystemCode' => 'RenewalDue',
   			 'Value' => $expiration
   		 )
   	 ),
   	 'Id' => $wa_ID
   	);

   	global $waApiClient;
   	global $accountUrl;
   	$url = $accountUrl . '/contacts/' . $wa_ID;
   	$verb = 'PUT';
   	return $waApiClient->makeRequest($url,$verb,$data);
  }

  function generateInvoice( $wa_ID, $membership, $txn ) {

  	global $waApiClient;
  	global $accountUrl;

  	// Set Membership Expiration
  	if( $expDate != '0000-00-00 00:00:00' ) {
  	 $expDate = DateTime::createFromFormat('Y-m-d H:i:s', $txn->expires_at );
  	 $expiration = $expDate->format('Y-m-d\T00:00:00');
  	} else {
  	 $expiration = 'Never';
  	}

  	// Set Membership/Payment Creation
  	$origDate = DateTime::createFromFormat('Y-m-d H:i:s', $txn->created_at );
  	$origination = $origDate->format('Y-m-d\T00:00:00');

  	// Set Tender Type
  	$tenderKeys = array(
  	 'manual'      => 1913448,   // No payment
  	 'pu32dy-32x'  => 1771812,   // Check or Wire (Offline)
  	 'pxkzq9-lt'   => 1159526,   // CC (Stripe)
  	 'puqo6c-37g'  => 1171814    // Paypal
  	);

  	$newID = toNumber($txn->trans_num);

  	// Generate WildApricot Payment Object
  	$invoice = array(
  	 'Value' => $txn->total,
  	 'DocumentDate' => $origination,
  	 'Contact' => array(
  		 'Id' => $wa_ID,
  	 ),
  	 'CreatedBy' => array(
  		 'Id' => 54955609,
  	 ),
  	 'DocumentNumber' => $newID,
  	 'OrderType' => 'MembershipApplication',
  	 'OrderDetails' => array(
  		 array(
  			 'Value' => $txn->total,
  			 'OrderDetailType' => 'MemberLevel',
  			 'Notes' => $membership,
  		 ),
  	 ),
  	 'Memo' => $txn->trans_num,
  	 'PublicMemo' => $txn->trans_num,
  	);

  	$url = $accountUrl . '/invoices/';
  	$verb = 'POST';

  	// SUBMIT PAYMENT DATA
  	$invoiceResult = $waApiClient->makeRequest($url,$verb,$invoice);
  	return $invoiceResult;
  }


  function payInvoice( $wa_ID, $invoice, $txn ) {

  	global $waApiClient;
  	global $accountUrl;

  	// Set Membership Expiration
  	$expDate = $txn->expires_at;
  	if( $expDate != '0000-00-00 00:00:00' ) {
  		$expDate = new DateTime( $expDate );
  		$expiration = $expDate->format('Y-m-d\T00:00:00');
  	} else {
  		$expiration = 'Never';
  	}

  	// Set Membership/Payment Creation
  	$origDate = new DateTime( $txn->created_at );
  	$origination = $origDate->format('Y-m-d\T00:00:00');

  	// Set Tender Type
  	$tenderKeys = array(
  		'manual'      => 1913448,   // No payment
  		'pu32dy-32x'  => 1771812,   // Check or Wire (Offline)
  		'pxkzq9-lt'   => 1159526,   // CC (Stripe)
  		'puqo6c-37g'  => 1771814    // Paypal
  	);
  	// $requestTenders = $accountUrl . '/tenders/';
  	// $tenders = $waApiClient->makeRequest( $requestTenders );
  	// 1771811 - Cash
  	// 1771812 - Check
  	// 1771813 - Wire Transfer
  	// 1771814 - Paypal
  	// 1771815 - Credit Card
  	// 1159526 - Stripe
  	// 1913448 - Manually Entered

  	// Generate WildApricot Payment Object
  	$payment = array(
  		'Value' => $txn->total,
  		'DocumentDate' => $origination,
  		'Invoices' => array(
  			array(
  				'Id' => $invoice['Id'],
  				'Url' => $invoice['Url'],
  			)
  		),
  		'Contact' => array(
  			'Id' => $wa_ID,
  			'Url' => $accountUrl . '/contacts/' . $wa_ID,
  		),
  		'Tender' => array(
  			'Id' => $tenderKeys[$txn->gateway],
  			'Url' => $accountUrl . '/tenders/' . $tenderKeys[$txn->gateway],
  		),
  		'Comment' => $txn->trans_num,
  		'PublicComment' => $txn->trans_num,
  		'PaymentType' => 'InvoicePayment'
  	);
  	// echo 'PAYMENT: <br>'; var_dump($payment);

  	$url = $accountUrl . '/payments/';
  	$verb = 'POST';

  	// SUBMIT PAYMENT DATA
  	$paymentResult = $waApiClient->makeRequest($url,$verb,$payment);
  	return $paymentResult;
  }


  function sync_memberships($user_id, $waApiClient = null, $wa_ID = null, $verbose = false) {

  	// Instanciate the API if we don't have it
  	if( !$waApiClient ) {
  		global $waApiClient;
  		$waApiClient = WaApiClient::getInstance();
  		try {
  			$waApiClient->initTokenByApiKey('gnb9yn2costjf4ynocej1qpz80402o');
  			// $waApiClient->initTokenByContactCredentials('admin@yourdomain.com', 'your_password');
  		} catch (Exception $e) {
  			$error = $e->getMessage();
  		}
  	}
  	global $accountUrl;
  	$wa_accountId = '298274';
  	$accountUrl = 'https://api.wildapricot.org/v2.2/Accounts/' . $wa_accountId;

  	// Check for the contact if we didn't get it passed in
  	if( !$wa_ID ) {
  		// Check and see if the contact exists on WA
  		$userObj = get_userdata( $user_id );
  		$userMeta = get_user_meta( $user_id );
  		$wa_ID = contactExists( $userObj->data->user_email ) ? : $userMeta['mepr__waid'][0];
  	}

  	$member = new MeprUser( $user_id ); // Get Membership User Info
  	$activesubs = $member->active_product_subscriptions('ids');

  	// Got the Data. Do the stuff!

  	// First we need to get WA data and see what we're working with
  	$url = $accountUrl . '/contacts/' . $wa_ID . '?getExtendedMembershipInfo=true';
  	$contact = $waApiClient->makeRequest($url);
  	$membership = 						$contact['MembershipLevel']['Id'];
  	$extendedMembershipInfo = $contact['ExtendedMembershipInfo'];

  	// WILD APRICOT MEMBERSHIP
  	// echo '<div class="wa">';
  	// echo '<h4 style="margin-top:1em;">Wild Apricot</h4>';
  	$membershipKeys = array(
  		'157' => 1122131, // Applicant
  		'19' => 1088900, // Dealer, Recurring
  		'588' => 1122135, // Dealer, Non-Recurring
  		'232' => 1122134, // Dealer, Quarterly Recurring
  		'580' => 1122136, // Dealer, Quarterly Non-Recurring
  		'1268' => 1222512, // Dealer, Quarterly, 20-Discount
  		'1499' => 1258359, // Dealer, Quarterly, 40-Discount
  		'1307' => 1231658, // DEALER, 20-Discount
  		'20' => 1088901, // Industry, Recurring
  		'589' => 1122137, // Industry, Non-Recurring
  		'247' => 1122138, // Industry, Quarterly Recurring
  		'587' => 1122139, // Industry, Quarterly Non-Recurring
  		'1020' => 1172196, // Industry, Split Payment
  		'1416' => 1248712, // Free Trial
  	);

  	$memb = $activesubs[0];
  	if( count($activesubs) == 1 ) {  // && $membershipKeys[$memb] != $membership
  		// Whether or not we need to, we're gonna force an update to the membership.
  		if( $verbose ) { echo 'Updating Membership... '; }
  		$newmemb = updateMembership( $user_id, $wa_ID, $memb );

  	} elseif( count($activesubs) > 1 ) {
  		foreach($activesubs as $memb) {

  			$txn = MeprUser::get_user_product_expires_at_date($user_id, $memb, true);
  			$creationDate = $txn->created_at;
  			$memb_start = new DateTime( $creationDate );
  			$now = new DateTime();

  			if( $memb_start > $now ) {
  				// the membeship hasn't started yet? something is wrong.
  				if( $membershipKeys[$memb] == $membership ) {
  					$uhoh = true;
  				}
  				break;
  			}
  			if( $memb == '157' ) {
  				// this is an application.
  				if( $membershipKeys[$memb] == $membership ) {
  					$uhoh = true;
  				}
  				break;
  			}
  			if( $memb == '1269' ) {
  				// Referral Discount. Ignore.
  				break;
  			}
  			if( $membershipKeys[$memb] == $membership ) {
  				// membership already exists in WA. move along & check the next membership
  				break;
  			}
  			// This membership is not one of the above. It's a good one.
  			$kosher[] = $memb;
  		}

  		if( $uhoh && $kosher ) {
  			// replace current Membership with $kosher[0]
  			$newmemb = updateMembership( $user_id, $wa_ID, $kosher[0] );
  		}
  	}

  	if( $newmemb ) {
  		// WA has been updated. Set new data for later use
  		$contact = $waApiClient->makeRequest($url);
  		$extendedMembershipInfo = $contact['ExtendedMembershipInfo'];
  	}

  	// If the Membership is Pending in WA, we need to Approve it.
  	if( $contact['Status'] == 'PendingNew' ) {
  		$pending = true;
  		$type = $extendedMembershipInfo['PendingMembershipOrderStatusType'];
  			// PendingNotPaidYet
  			// FreeOrderManualApprovalRequired
  			// InvoicePaidManualApprovalRequired
  			// if( $type == 'PendingNotPaidYet' ) { // WE HAVE AN INVOOOOICE!
  			//   //get invoice
  			//   $invoice = $extendedMembershipInfo['PendingMembershipInvoice'];
  			//   $invoiceData = $waApiClient->makeRequest( $invoice['Url'] );
  			// }

  		// Get the Approval API url
  		$actions = $extendedMembershipInfo['AllowedActions'];
  		foreach( $actions as $action ) { // Get Approval URL
  			if( $action['Name'] == 'ApprovePendingMembership' ) {
  				$approve_url = $action['Url'];
  				break;
  			}
  		}

  		if( $verbose ) {
  			echo 'Membership ' . $membership . ' Approval Pending...<br>';
  		  echo 'Status: ' . $type . '<br>'; }
  		$approved = approveMembership( $approve_url );
  		if( $verbose ) {
  			if( $approved ) {
  				echo 'Membership Has Been Approved';
  			} else {
  				echo 'Error. Could Not Approve.';
  			}
  		}
  	} else {
  		if( $verbose ) { echo 'Membership ' . $membership . ' is ' . $contact['Status']; }
  	}

  }

  function sync_finances($user_id, $waApiClient = null, $wa_ID = null, $verbose = false) {

  	// Instanciate the API if we don't have it
  	if( !$waApiClient ) {
  		global $waApiClient;
  		$waApiClient = WaApiClient::getInstance();
  		try {
  			$waApiClient->initTokenByApiKey('gnb9yn2costjf4ynocej1qpz80402o');
  			// $waApiClient->initTokenByContactCredentials('admin@yourdomain.com', 'your_password');
  		} catch (Exception $e) {
  			$error = $e->getMessage();
  		}
  	}
  	global $accountUrl;
  	$wa_accountId = '298274';
  	$accountUrl = 'https://api.wildapricot.org/v2.2/Accounts/' . $wa_accountId;

  	// Check for the contact if we didn't get it passed in
  	if( !$wa_ID ) {
  		// Check and see if the contact exists on WA
  		$userObj = get_userdata( $user_id );
  		$userMeta = get_user_meta( $user_id );
  		$wa_ID = contactExists( $userObj->data->user_email ) ? : $userMeta['mepr__waid'][0];
  	}

  	$member = new MeprUser( $user_id ); // Get Membership User Info
  	$alltransactions = $member->active_product_subscriptions('transactions',true,false);

  	// Got the Data. Do the stuff!

  	// Get All Payments in W.A.
  	$getPayments = $accountUrl . '/payments?contactId=' . $wa_ID;
  	$payments = $waApiClient->makeRequest( $getPayments );

  	foreach($alltransactions as $txn) {
  		if( $verbose ) {
  			echo 'TRANSACTION ID (' . $txn->product_id . '): ' . $txn->trans_num . '<br>';
  		 	echo '<!--'; var_dump( $txn ); echo '-->';
  		}

  		if( $txn->amount == '0.00') {
  			if( $verbose ) { echo '<span>No payment required.</span><br>'; }
  			continue;
  		}

  		$matchedpayments[ $txn->trans_num ] = null;
  		foreach( $payments['Payments'] as $payment ) {
  			if ( $payment['Comment'] == $txn->trans_num ) {
  				$matchedpayments[ $txn->trans_num ] = $payment['Id'];
  				break;
  			}
  		}

  		if( $matchedpayments[ $txn->trans_num ] ) {
  			if( $verbose ) { echo '<span>Found Payment Match: Payment ' . $payment['Id'] . '</span><br>'; }
  		} else {
  			if( $verbose ) { echo '<strong>No Payment found for ' . $txn->trans_num . '</strong><br>'; }

  			// Q1 // Does this contact have any unpaid invoices?
  			$invoiceUrl = $accountUrl . '/invoices?contactId=' . $wa_ID . '&unpaidOnly=true';
  			$invoiceResponse = $waApiClient->makeRequest($invoiceUrl);

  			if( !empty( $invoiceResponse['Invoices'] ) ) {
  				foreach( $invoiceResponse['Invoices'] as $invoice ) {
  					if( $verbose ) { echo 'Checking Invoice ' . $invoice['Id'] . '...<br>'; }
  					// $invoice['Url']
  					// $invoice['Value']
  					// $invoice['Memo']
  					// $invoice['DocumentNumber']
  					// $invoice['isPaid']
  					// $invoice['PaidAmount']
  					// $invoice['PublicMemo']
  					// $invoice['OrderType'] - Undefined, MembershipApplication

  					if( $invoice['Memo'] == $txn->trans_num ) {
  						// this invoice was generated by wordpress and can be paid by this transaction
  						if( $verbose ) { echo 'This invoice is a match...<br>'; }
  						$paid = payInvoice( $wa_ID, $invoice, $txn );
  						if( $verbose ) { echo '<span>Made Payment ' . $paid['Id'] . ' for ' . $paid['Value'] . '.</span><br>'; }
  					} else {
  						// this invoice was created by Wild Apricot.

  						$invoiceData = $waApiClient->makeRequest( $invoice['Url'] );
  						// $invoiceData['OrderDetails'][0]['OrderDetailType']
  						$invoice_name = $invoiceData['OrderDetails'][0]['Notes'];
  						$prd = new MeprProduct($txn->product_id);
  						$memb_name = $prd->post_title;
  						if( strpos($invoice_name, $memb_name) !== false ) {
  							// is this invoice a match for the current membership?
  							if( $verbose ) { echo 'This invoice is a match...<br>'; }
  							$paid = payInvoice( $wa_ID, $invoice, $txn );
  							if( $verbose ) { echo 'Made Payment ' . $paid['Id'] . ' for ' . $paid['Value'] . '.<br>'; }
  						} else {
  							if( $verbose ) { echo 'This invoice is not a match.<br>';
  								echo 'Diagnostic: ' . $invoice_name . ' :: ' . $memb_name . '<br>'; }
  						}
  					}

  				}
  			} else {
  				// There are no unpaid invoices. let's go through all invoices and check
  				$paidInvoiceUrl = $accountUrl . '/invoices?contactId=' . $wa_ID . '&paidOnly=true';
  				$paidInvoiceResponse = $waApiClient->makeRequest($paidInvoiceUrl);

  				// echo 'PAID INVOICES DUMP: <br>';
  				// var_dump( $paidInvoiceResponse['Invoices'] ); echo '<br><br>';

  				// Look for a match for this transaction
  				if( !empty( $paidInvoiceResponse['Invoices'] ) ) {
  					foreach( $paidInvoiceResponse['Invoices'] as $invoice ) {
  						if ( $invoice['Memo'] == $txn->trans_num ) {
  						 $paid = true;
  						 break;
  						}
  					}
  				}
  				if ( !$paid ) {
  					// Create a new Invoice and Settle It
  					if( $verbose ) { echo 'We need to create a new invoice and settle it...<br>'; }
  					$prd = new MeprProduct($txn->product_id);
  					$membership = $prd->post_title;
  					$newInvoiceID = generateInvoice( $wa_ID, $membership, $txn );
  					$newInvoiceUrl = $accountUrl . '/invoices/' . $newInvoiceID;
  					$newInvoice = $waApiClient->makeRequest( $newInvoiceUrl );
  					$paid = payInvoice( $wa_ID, $newInvoice, $txn );
  					if( $verbose ) { echo '<span>Made Payment ' . $paid['Id'] . ' for ' . $paid['Value'] . '.</span><br>'; }
  					// reset
  					$paid = false;
  				}
  			} // end invoice check

  		} // end matching payment check

  	} // end looping over transactions

  }
  

  /**
   * API helper class. You can copy whole class in your PHP application.
   */
  class WaApiClient
  {
     const AUTH_URL = 'https://oauth.wildapricot.org/auth/token';

     private $tokenScope = 'auto';

     private static $_instance;
     private $token;

     public function initTokenByContactCredentials($userName, $password, $scope = null)
     {
        if ($scope) {
           $this->tokenScope = $scope;
        }

        $this->token = $this->getAuthTokenByAdminCredentials($userName, $password);
        if (!$this->token) {
           throw new Exception('Unable to get authorization token.');
        }
     }

     public function initTokenByApiKey($apiKey, $scope = null)
     {
        if ($scope) {
           $this->tokenScope = $scope;
        }

        $this->token = $this->getAuthTokenByApiKey($apiKey);
        if (!$this->token) {
           throw new Exception('Unable to get authorization token.');
        }
     }

     // this function makes authenticated request to API
     // -----------------------
     // $url is an absolute URL
     // $verb is an optional parameter.
     // Use 'GET' to retrieve data,
     //     'POST' to create new record
     //     'PUT' to update existing record
     //     'DELETE' to remove record
     // $data is an optional parameter - data to sent to server. Pass this parameter with 'POST' or 'PUT' requests.
     // ------------------------
     // returns object decoded from response json

     public function makeRequest($url, $verb = 'GET', $data = null)
     {
        if (!$this->token) {
           throw new Exception('Access token is not initialized. Call initTokenByApiKey or initTokenByContactCredentials before performing requests.');
        }

        $ch = curl_init();
        $headers = array(
           'Authorization: Bearer ' . $this->token,
           'Content-Type: application/json'
        );
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($data) {
           $jsonData = json_encode($data);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
           $headers = array_merge($headers, array('Content-Length: '.strlen($jsonData)));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true); // for debug

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $jsonResult = curl_exec($ch);
        if ($jsonResult === false) {
           throw new Exception(curl_errno($ch) . ': ' . curl_error($ch));
        }

        // Uncomment to debug response
        // $info = curl_getinfo($ch);
        // echo '<!-- curl URL: ' . $info['url'] . '-->';
        // echo '<!-- curl Header: ' . $info['request_header'] . '-->';
        // echo '<!--'; var_dump($jsonResult); echo '-->';

        // echo '<!-- ERROR:: --> <!--';
        // var_dump( curl_error($ch) );
        // echo '-->';

        curl_close($ch);
        return json_decode($jsonResult, true);
     }

     private function getAuthTokenByAdminCredentials($login, $password)
     {
        if ($login == '') {
           throw new Exception('login is empty');
        }

        $data = sprintf("grant_type=%s&username=%s&password=%s&scope=%s", 'password', urlencode($login), urlencode($password), urlencode($this->tokenScope));

        throw new Exception('Change clientId and clientSecret to values specific for your authorized application. For details see:  https://help.wildapricot.com/display/DOC/Authorizing+external+applications');
        $clientId = '27kumbt9yv';
        $clientSecret = 'a4l1iuuxvypt9amy7rhuxfzdjrnsaw';
        $authorizationHeader = "Authorization: Basic " . base64_encode( $clientId . ":" . $clientSecret);

        return $this->getAuthToken($data, $authorizationHeader);
     }

     private function getAuthTokenByApiKey($apiKey)
     {
        $data = sprintf("grant_type=%s&scope=%s", 'client_credentials', $this->tokenScope);
        $authorizationHeader = "Authorization: Basic " . base64_encode("APIKEY:" . $apiKey);
        return $this->getAuthToken($data, $authorizationHeader);
     }

     private function getAuthToken($data, $authorizationHeader)
     {
        $ch = curl_init();
        $headers = array(
           $authorizationHeader,
           'Content-Length: ' . strlen($data)
        );
        curl_setopt($ch, CURLOPT_URL, WaApiClient::AUTH_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
           throw new Exception(curl_errno($ch) . ': ' . curl_error($ch));
        }
        // var_dump($response); // Uncomment line to debug response

        $result = json_decode($response , true);
        curl_close($ch);
        return $result['access_token'];
     }

     public static function getInstance()
     {
        if (!is_object(self::$_instance)) {
           self::$_instance = new self();
        }

        return self::$_instance;
     }

     public final function __clone()
     {
        throw new Exception('It\'s impossible to clone singleton "' . __CLASS__ . '"!');
     }

     private function __construct()
     {
        if (!extension_loaded('curl')) {
           throw new Exception('cURL library is not loaded');
        }
     }

     public function __destruct()
     {
        $this->token = null;
     }
  }
