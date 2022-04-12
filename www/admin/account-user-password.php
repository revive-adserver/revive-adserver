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
require_once MAX_PATH . '/lib/OX/Extension/authentication/authentication.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('user');

// Prepare an array for storing error messages
$aErrormessage = [];

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobalUnslashed(
        'pwold',
        'pw',
        'pw2'
    );

    OA_Permission::checkSessionToken();

    // Get the current authentication plugin instance
    $oPlugin = OA_Auth::staticGetAuthPlugin();

    // Check password
    if (!isset($pwold) || !$oPlugin->checkPassword(OA_Permission::getUsername(), $pwold)) {
        $aErrormessage[0][] = $GLOBALS['strPasswordWrong'];
    }

    $auth = new Plugins_Authentication();
    $auth->validateUsersPassword($pw ?? '', $pw2 ?? '');

    if (!empty($auth->aValidationErrors)) {
        $aErrormessage[0] = array_merge($aErrormessage[0] ?? [], $auth->aValidationErrors);
    }

    if (!count($aErrormessage)) {
        if (!$oPlugin->setNewPassword(OA_Permission::getUserId(), $pw)) {
            // Unable to update the preferences
            $aErrormessage[0][] = $GLOBALS['strUnableToWritePrefs'];
        } else {
            // Regenerate session ID and clear all other sessions
            phpAds_SessionRegenerateId(true);

            $translation = new OX_Translation();
            $translated_message = $translation->translate($GLOBALS['strPasswordChanged']);
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            // The "preferences" were written correctly saved to the database,
            // go to the "next" preferences page from here
            OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
        }
    }
}

// Set the correct section of the preference pages and display the drop-down menu
$prefSection = "password";
$setPref = $oOptions->getSettingsPreferences($prefSection);
$title = $setPref[$prefSection]['name'];

// Display the settings page's header and sections
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-user-index', $oHeaderModel);


// Get the current logged in user details
$oUser = OA_Permission::getCurrentUser();
$aUser = $oUser->aUser;

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = [
    [
        'text' => $strChangePassword,
        'items' => [
            [
                'type' => 'plaintext',
                'name' => 'username',
                'value' => $aUser['username'],
                'text' => $strUsername,
                'size' => 35,
                'autocomplete' => 'username',
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'plaintext',
                'name' => 'contact_name',
                'value' => $aUser['contact_name'],
                'text' => $strFullName,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'plaintext',
                'name' => 'email_address',
                'value' => $aUser['email_address'],
                'text' => $strEmailAddress,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'password',
                'name' => 'pwold',
                'text' => $strCurrentPassword,
                'disabled' => '',
                'autocomplete' => 'current-password',
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'password',
                'name' => 'pw',
                'text' => $strChooseNewPassword,
                'strengthIndicator' => true,
                'check' => 'string+' . ($conf['security']['passwordMinLength'] ?? OA_Auth::DEFAULT_MIN_PASSWORD_LENGTH),
                'autocomplete' => 'new-password',
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'password',
                'name' => 'pw2',
                'text' => $strReenterNewPassword,
                'check' => 'compare:pw',
                'autocomplete' => 'new-password',
            ]
        ]
    ]
];

$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();
