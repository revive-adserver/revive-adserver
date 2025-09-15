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

use RV\Extension\MailerComponentInterface;

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "email";

// Prepare an array for storing error messages
$aErrormessage = [];

$aComponents = OX_Component::getComponents('mailer');
foreach ($aComponents as $name => $oComponent) {
    if ($oComponent->enabled) {
        $aComponentItems[$oComponent->getComponentIdentifier()] = $oComponent;
    }
}

uasort($aComponentItems, function (MailerComponentInterface $a, MailerComponentInterface $b) {
    if ($a->getPriority() === $b->getPriority()) {
        return $a->getName() <=> $b->getName();
    }

    return $b->getPriority() <=> $a->getPriority();
});

$aComponentItems = array_merge(['' => $strNone], array_map(fn(MailerComponentInterface $x) => $x->getName(), $aComponentItems));


// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = [];
    // E-mail Addresses
    $aElements += [
        'email_fromAddress' => ['email' => 'fromAddress'],
        'email_fromName' => ['email' => 'fromName'],
        'email_fromCompany' => ['email' => 'fromCompany'],
        'email_useManagerDetails' => ['email' => 'useManagerDetails',
            'bool' => true,
        ],
    ];
    // E-mail Log
    $aElements += [
        'email_logOutgoing' => [
            'email' => 'logOutgoing',
            'bool' => true,
        ],
    ];
    // Selected Mailer plugin
    $aElements += [
        'email_pluginType' => ['email' => 'pluginType'],
    ];

    if (!empty($_POST['email_pluginType'])) {
        $oMailer = OX_Component::factoryByComponentIdentifier($_POST['email_pluginType']);

        if (!$oMailer instanceof MailerComponentInterface) {
            $aErrormessage[2][] = 'Not a mailer plugin';
        } elseif (!$oMailer->checkConfig()) {
            $aErrormessage[2][] = sprintf(
                'The plugin settings are invalid, please <a href="%s">configure it</a> first!',
                'plugin-settings.php?group=' . urlencode($oMailer->group),
            );
        }
    }

    if (empty($aErrormessage)) {
        // Create a new settings object, and save the settings!
        $oSettings = new OA_Admin_Settings();
        $result = $oSettings->processSettingsFromForm($aElements);
        if ($result) {
            // Queue confirmation message
            $setPref = $oOptions->getSettingsPreferences($prefSection);
            $title = $setPref[$prefSection]['name'];
            $translation = new OX_Translation();
            $translated_message = $translation->translate(
                $GLOBALS['strXSettingsHaveBeenUpdated'],
                [htmlspecialchars($title)],
            );
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
            // The settings configuration file was written correctly,
            OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
        }
        // Could not write the settings configuration file, store this
        // error message and continue
        $aErrormessage[0][] = $strUnableToWriteConfig;
    }
}

// Set the correct section of the settings pages and display the drop-down menu
$setPref = $oOptions->getSettingsPreferences($prefSection);
$title = $setPref[$prefSection]['name'];

// Display the settings page's header and sections
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-settings-index', $oHeaderModel);

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = [
    [
        'text' => $strEmailAddresses,
        'items' => [
            [
                'type' => 'text',
                'name' => 'email_fromAddress',
                'text' => $strEmailFromAddress,
                'req' => true,
                'size' => 35,
                'check' => 'email',
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
                'name' => 'email_fromName',
                'text' => $strEmailFromName,
                'req' => false,
                'size' => 35,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
                'name' => 'email_fromCompany',
                'text' => $strEmailFromCompany,
                'req' => false,
                'size' => 35,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'checkbox',
                'name' => 'email_useManagerDetails',
                'text' => $strUseManagerDetails,
            ],
        ],
    ],
    [
        'text' => $strEmailLog,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'email_logOutgoing',
                'text' => $strUserlogEmail,
            ],
        ],
    ],
    [
        'text' => "Mailer Plugin",
        'items' => [
            [
                'type' => 'select',
                'name' => 'email_pluginType',
                'text' => $strMailerPlugin,
                'items' => $aComponentItems,
            ],
        ],
    ],
];
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();
