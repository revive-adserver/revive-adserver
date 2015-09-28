<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

require_once MAX_PATH . '/lib/RV/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/RV/Admin/Languages.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('user');
$prefSection = "name-language";


// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobalUnslashed(
        'contact_name',
        'language'
    );

    OA_Permission::checkSessionToken();

    // Get the DB_DataObject for the current user
    $doUsers = OA_Dal::factoryDO('users');
    $doUsers->get(OA_Permission::getUserId());

    // Get the current authentication plugin instance
    $oPlugin = OA_Auth::staticGetAuthPlugin();

    if (isset($contact_name)) {
        $doUsers->contact_name = $contact_name;
    }
    if (isset($language)) {
        $doUsers->language = $language;
    }

    if (!count($aErrormessage)) {
        if (($doUsers->update() === false)) {
            // Unable to update the preferences
            $aErrormessage[0][] = $strUnableToWritePrefs;
        }
        else {
        	//Add the new username to the session
            $oUser = &OA_Permission::getCurrentUser();
            $oUser->aUser['contact_name'] = $contact_name;
            $oUser->aUser['language'] = $language;

            phpAds_SessionDataStore();

            // Queue confirmation message
            $setPref = $oOptions->getSettingsPreferences($prefSection);
            $title = $setPref[$prefSection]['name'];

            $translation = new OX_Translation ();
            $translated_message = $translation->translate($GLOBALS['strUserPreferencesUpdated'],
                array(htmlspecialchars($title)));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            // The "preferences" were written correctly saved to the database,
            // go to the "next" preferences page from here
            OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
        }
    }
}

// Set the correct section of the preference pages and display the drop-down menu
$setPref = $oOptions->getSettingsPreferences($prefSection);
$title = $setPref[$prefSection]['name'];

// Display the settings page's header and sections
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-user-index', $oHeaderModel);

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show all "Preferences" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.3", "5.5", "5.6", "5.4"));
}
else if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Show the "Account Preferences", "User Log" and "Channel Management" sections of the "Preferences" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.7"));
}
else if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER, OA_ACCOUNT_ADVERTISER)) {
    // Show the "User Preferences" section of the "Preferences" sections
    $sections = array("5.1", "5.2");
    if (OA_Permission::hasPermission(OA_PERM_USER_LOG_ACCESS)) {
        $sections[] = "5.4";
    }
    phpAds_ShowSections($sections);
}


// Get the current logged in user details
$oUser = OA_Permission::getCurrentUser();
$aUser = $oUser->aUser;

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
        'text'  => $strUserDetails,
        'items' => array (
         array (
                'type'     => 'plaintext',
                'name'     => 'username',
                'value'    => $aUser['username'],
                'text'     => $strUsername,
                'size'     => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'plaintext',
                'name'    => 'email_address',
                'value'   => $aUser['email_address'],
                'text'    => $strEmailAddress,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'contact_name',
                'value'   => $aUser['contact_name'],
                'text'    => $strFullName,
                'size'    => 35
            )
        )
    ),
    array (
        'text'  => $strLanguage,
        'items' => array (
            array (
                'type'    => 'select',
                'name'    => 'language',
                'text'    => $strLanguage,
                'items'   => RV_Admin_Languages::getAvailableLanguages(),
                'value'   => $GLOBALS['_MAX']['PREF']['language']
            )
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>