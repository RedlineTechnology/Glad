<?php

require get_template_directory() . '/inc/Textmagic/Services/TextmagicRestClient.php';

use inc\Textmagic\Services\TextmagicRestClient;
use inc\Textmagic\Services\RestException;

define('VERSION', '0.01');

/** Client object */
$apiKey = get_theme_mod('textmagic_api');
global $tmApiClient;

$tmApiClient = new TextmagicRestClient('christineblair', $apiKey );

$user = false;
$page  = 1;
$limit = 100;
$paginatedFunction = 'exitOk';

$sendingContacts = array();
$sendingLists    = array();

/**
 * Default "Back to main menu" link
 */
$backMenu = array(
    'Back to main menu' => 'showMainMenu'
);

/**
 *  Show main menu
 */
function showMainMenu() {
    flushPagination();

    $items = array(
        'Contacts'  => 'showAllContacts',
        'Lists' => 'showAllLists',
        'Messages' => 'showMessagesMenu',
        'Templates' => 'showAllTemplates',
        'Information' => 'showInformation'
    );

    showMenu($items);
}

/**
 *  Show messages menu
 */
function showMessagesMenu() {
    global $backMenu;

    $items = array(
        'Show outgoing messages'  => 'showMessagesOut',
        'Show incoming messages'  => 'showMessagesIn',
        'Send message'  => 'sendMessage'
    );

    showMenu($items + $backMenu);
}

/**
 *  Show base account information
 */
function showInformation() {
    global $user, $backMenu;

    print <<<EOT

ACCOUNT INFORMATION
===================

ID          : {$user['id']}
Username    : {$user['username']}
First Name  : {$user['firstName']}
Last Name   : {$user['lastName']}
Balance     : {$user['balance']} {$user['currency']['id']}
Timezone    : {$user['timezone']['timezone']} ({$user['timezone']['offset']})

EOT;

}

/**
 *  Show all user contacts (including shared)
 */
function showAllContacts() {
    global $tmApiClient, $page, $limit, $paginatedFunction, $backMenu;

    try {
        $response = $tmApiClient->contacts->getList(
            array(
                'page' => $page,
                'limit' => $limit,
                'shared' => true
            )
        );
    } catch (\ErrorException $e) {
        error($e);
    }

    $contacts = $response['resources'];

    print <<<EOT

ALL CONTACTS
============
Page {$response['page']} of {$response['pageCount']}

EOT;

    foreach ($contacts as $contact) {
        print "{$contact['id']}. {$contact['firstName']} {$contact['lastName']}, {$contact['phone']} <br>";
    }
}

/**
 *  Show one contact details
 */
function showContact( $id ) {
    global $tmApiClient;

    if (!$id) {
        return false;
    }

    try {
        $contact = $tmApiClient->contacts->get($id);
    } catch (\ErrorException $e) {
        error($e);
    }
    // echo 'Name: ' . $contact['firstName'] . ' ' . $contact['lastName'] . '<br>Phone: ' . $contact['phone'] . '<br><br>';

    return $contact;
}


/**
 *  Search for a contact by query
 */
function findContact( $searchquery ) {
    global $tmApiClient;

    if (!$searchquery) {
        return false;
    }

    $searchresult = [];
    $params = array(
      'query' => $searchquery
    );

    try {
        $search = $tmApiClient->contacts->search( $params );
    } catch (\ErrorException $e) {
        error($e);
    }

    foreach( $search['resources'] as $contact ) {
      // echo '<!-- Found Contact ' . $contact['id'] . ' via ' . $contact['phone'] . '-->';
      $searchresult[] .= $contact['id'];
    }

    return $searchresult;
}


/**
 *  Add new contact
 */
function createContact( $name, $number, $lists ) {
    global $tmApiClient;

    if (!$number) {
        return false;
    }

    // Split the Name into First and Last
    $name = explode( ' ', $name );

    // Clear extra digits, prep for validation
    $number = stripPhoneNumber( $number );

    $params = array(
      'firstName' => $name[0],
      'lastName' => $name[1],
      'phone' => $number,
      'lists' => $lists
    );

    try {
        $newContact = $tmApiClient->contacts->create( $params );
    } catch (\ErrorException $e) {
        error($e);
    }
    // echo '<!-- Contact ' . $newContact['id'] . ' created successfully -->';

    return $newContact['id'];
}


/**
 *  Delete contact permanently
 */
function deleteContact( $id ) {
    global $tmApiClient;

    if (!$id) {
        return false;
    }

    try {
        $tmApiClient->contacts->delete($id);
    } catch (\ErrorException $e) {
        error($e);
    }
    // echo '<!-- Contact ' . $id . ' deleted successfully -->';

    return true;
}

/**
 *  Show all user lists (including shared)
 */
function showAllLists() {
    global $tmApiClient, $page, $limit, $paginatedFunction, $backMenu;

    try {
        $response = $tmApiClient->lists->getList(
            array(
                'page' => $page,
                'limit' => $limit,
                'shared'  => true
            )
        );
    } catch (\ErrorException $e) {
        error($e);
    }

    $lists = $response['resources'];

    print <<<EOT

ALL LISTS
=========
Page {$response['page']} of {$response['pageCount']}

EOT;

    foreach ($lists as $list) {
        print "{$list['id']}. {$list['name']} ({$list['description']})<br>";
    }
}

/**
 *  Add Users to a List
 */
function addToList( $list, $users ) {
    global $tmApiClient;

    if( is_array( $users ) ) {
      $users = implode( ', ', $users );
    }

    try {
        $response = $tmApiClient->lists->updateContacts(
            $list,
            array(
                'contacts' => $users
            )
        );
    } catch (\ErrorException $e) {
        error($e);
    }

    $listid = $response['id'];

    return $listid;
}


/**
 *  Remove Users from a List
 */
function removeFromList( $list, $users ) {
    global $tmApiClient;

    if( is_array( $users ) ) {
      $users = implode( ', ', $users );
    }

    try {
        $response = $tmApiClient->lists->deleteContacts(
            $list,
            array(
                'contacts' => $users
            )
        );
    } catch (\ErrorException $e) {
        error($e);
    }

    $listid = $response['id'];

    return $listid;
}


/**
 *  Show all sent messages
 */
function showMessagesOut() {
    global $tmApiClient, $page, $limit, $paginatedFunction, $backMenu;

    $paginatedFunction = 'showMessagesOut';

    try {
        $response = $tmApiClient->messages->getList(
            array(
                'page' => $page,
                'limit' => $limit
            )
        );
    } catch (\ErrorException $e) {
        error($e);
    }

    $messages = $response['resources'];

    print <<<EOT

SENT MESSAGES
=========
Page {$response['page']} of {$response['pageCount']}

EOT;

    foreach ($messages as $message) {
        print "{$message['id']}. {$message['text']} (from {$message['receiver']})<br>";
    }

    $items = array(
        'Previous page' => 'goToPreviousPage',
        'Next page' => 'goToNextPage',
        'Delete message' => 'deleteMessageOut'
    );

    showMenu($items + $backMenu);
}

/**
 *  Delete one sent message
 */
function deleteMessageOut() {
    global $tmApiClient;

    $id = readNumber("Enter message ID");

    if (!$id) {
        return showMessagesOut();
    }

    try {
        $tmApiClient->messages->delete($id);
    } catch (\ErrorException $e) {
        error($e);
    }

    print "<br>Message deleted successfully<br>";
    return showMessagesOut();
}

/**
 *  Show all received messages
 */
function showMessagesIn() {
    global $tmApiClient, $page, $limit, $paginatedFunction, $backMenu;

    $paginatedFunction = 'showMessagesIn';

    try {
        $response = $tmApiClient->replies->getList(
            array(
                'page' => $page,
                'limit' => $limit
            )
        );
    } catch (\ErrorException $e) {
        error($e);
    }

    $replies = $response['resources'];

    print <<<EOT

RECEIVED MESSAGES
=========
Page {$response['page']} of {$response['pageCount']}

EOT;

    foreach ($replies as $message) {
        print "{$message['id']}. {$message['text']} (from {$message['sender']})<br>";
    }

    $items = array(
        'Previous page' => 'goToPreviousPage',
        'Next page' => 'goToNextPage',
        'Delete message' => 'deleteMessageIn'
    );

    showMenu($items + $backMenu);
}

/**
 *  Delete one received message
 */
function deleteMessageIn() {
    global $tmApiClient;

    $id = readNumber("Enter message ID");

    if (!$id) {
        return showMessagesIn();
    }

    try {
        $tmApiClient->replies->delete($id);
    } catch (\ErrorException $e) {
        error($e);
    }

    print "<br>Message deleted successfully<br>";
    return showMessagesIn();
}

/**
 *  Show all message templates
 */
function showAllTemplates() {
    global $tmApiClient, $page, $limit, $paginatedFunction, $backMenu;

    $paginatedFunction = 'showAllTemplates';

    try {
        $response = $tmApiClient->templates->getList(
            array(
                'page' => $page,
                'limit' => $limit
            )
        );
    } catch (\ErrorException $e) {
        error($e);
    }

    $templates = $response['resources'];

    print <<<EOT

TEMPLATES
=========
Page {$response['page']} of {$response['pageCount']}

EOT;

    foreach ($templates as $template) {
        print "{$template['id']}. {$template['name']}: {$template['content']}<br>";
    }

    $items = array(
        'Previous page' => 'goToPreviousPage',
        'Next page' => 'goToNextPage',
        'Delete template' => 'deleteTemplate'
    );

    showMenu($items + $backMenu);
}

/**
 *  Delete one message template
 */
function deleteTemplate() {
    global $tmApiClient;

    $id = readNumber("Enter template ID");

    if (!$id) {
        return showAllTemplates();
    }

    try {
        $tmApiClient->templates->delete($id);
    } catch (\ErrorException $e) {
        error($e);
    }

    print "<br>Template deleted successfully<br>";
    return showAllTemplates();
}

/**
 *  Send outgoing message to phones, contacts and/or contact lists
 */
function sendMessage() {
    global $tmApiClient;

    print <<<EOT

SEND MESSAGE
============

EOT;
    print "Text: ";
    $sendingText = trim(fgets(STDIN));
    print "<br><br>";

    print "Enter phone numbers, separated by [ENTER]. Empty string to break.<br>";

    $sendingPhones = array();
    $sendingContacts = array();
    $sendingLists = array();

    do {
       print "<br>Phone: ";
       $phone = trim(fgets(STDIN));
       array_push($sendingPhones, $phone);
    } while ($phone);
    array_pop($sendingPhones);

    print "<br><br>Enter contact IDs, separated by [ENTER]. Empty string to break.<br>";

    do {
       $contact = readNumber('Contact');
       array_push($sendingContacts, $contact);
    } while ($contact);
    array_pop($sendingContacts);

    print "<br><br>Enter list IDs, separated by [ENTER]. Empty string to break.<br>";

    do {
       $list = readNumber('List');
       array_push($sendingLists, $list);
    } while ($list);
    array_pop($sendingLists);

    $sendingPhones = implode(', ', $sendingPhones);
    $sendingContacts = implode(', ', $sendingContacts);
    $sendingLists = implode(', ', $sendingLists);

    print "<br><br>YOU ARE ABOUT TO SEND MESSAGES TO:" .
          ($sendingPhones ? "<br>Phone numbers: " . $sendingPhones : '') .
          ($sendingContacts ? "<br>Contacts: "  . $sendingContacts : '') .
          ($sendingLists ? "<br>Lists: " . $sendingLists : '');
    print "<br>Are you sure (y/n)? ";

    $answer = strtolower(trim(fgets(STDIN)));
    if ($answer != 'y') {
        return showMainMenu();
    }

    try {
        $result = $tmApiClient->messages->create(
            array(
                'text' => $sendingText,
                'phones' => $sendingPhones,
                'contacts' => $sendingContacts,
                'lists' => $sendingLists
            )
        );
    } catch (\ErrorException $e) {
        error($e);
    }

    print "<br>Message {$result['id']} sent<br>";

    return showMainMenu();
}

/**
 *  Error handler
 */
function error($e) {
    if ($e instanceof RestException) {
        print '[ERROR] ' . $e->getMessage() . "<br>";
        foreach ($e->getErrors() as $key => $value) {
            print '[' . $key . '] ' . $value . "<br>";
        }
    } else {
        print '[ERROR] ' . $e->getMessage() . "<br>";
    }

    exit(0);
}

/**
 *  Show top user banner
 */
function showUserInfo() {
    global $user;

    print 'TextMagic CLI v' . VERSION . " || {$user['firstName']}  {$user['lastName']} ({$user['username']}) || {$user['balance']} {$user['currency']['id']}<br>";
}

/**
 *  Show numered menu and return user choice
 */
function showMenu($itemsRef) {
    $functionsRef = array();
    print "<br>";

    $i = 0;
    foreach ($itemsRef as $key => $value) {
        $i++;
        print $i . ' ' . $key ."<br>";
        $functionsRef[$i] = $value;
    }

    $i++;
    print $i . " Exit<br>";
    $functionsRef[$i] = 'exitOk';

    $choice = readNumber("Your choice ($i)");

    if (!$choice || !isset($functionsRef[$choice])) {
        $function = $functionsRef[$i];
    } else {
        $function = $functionsRef[$choice];
    }

    $function();
}

/**
 *  Go to previous page when browsing paginated resource
 */
function goToPreviousPage() {
    global $page, $paginatedFunction;

    if ($page <= 2) {
        $page = 1;
    } else {
        $page--;
    }

    $paginatedFunction();
}

/**
 *  Go to next page when browsing paginated resource
 */
function goToNextPage() {
    global $page, $paginatedFunction;

    $page++;

    $paginatedFunction();
}

/**
 *  Reset current page, limit and paginated resource fetch function
 */
function flushPagination() {
    global $page, $limit, $paginatedFunction;

    $page = 1;
    $limit = 10;
    $paginatedFunction = 'exitOk';
}

/**
 *  Normal program termination
 */
function exitOk() {
    print "<br>Bye!<br>";
    exit(0);
}

/**
 *  Read number value
 */
function readNumber($text) {
    print "<br>$text: ";
    $choice = intval(trim(fgets(STDIN)));

    return $choice;
}

/**
 *  Main program procedure
 */
// function main() {
//     global $tmApiClient, $user;
//
//     if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
//         procSystem('cls');
//     else
//         procSystem('clear');
//
//     try {
//         $user = $tmApiClient->user->get();
//     } catch (\ErrorException $e) {
//         error($e);
//     }
//
//     showUserInfo();
//     showMainMenu();
// }
//
// /**
//  *  System function handler
//  */
// function procSystem($cmd) {
//     $pp = proc_open($cmd, array(STDIN, STDOUT, STDERR), $pipes);
//     if(!$pp) return 127;
//     return proc_close($pp);
// }
//
// main();
