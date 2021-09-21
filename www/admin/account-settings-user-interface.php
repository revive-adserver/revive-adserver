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
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

require_once LIB_PATH . '/Plugin/Component.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "user-interface";
// Prepare an array for storing error messages
$aErrormessage = [];

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = [];
    // General Settings
    $aElements += [
        'ui_enabled' => [
            'ui' => 'enabled',
            'bool' => true
        ],
        'ui_applicationName' => ['ui' => 'applicationName'],
        'ui_headerFilePath' => ['ui' => 'headerFilePath'],
        'ui_footerFilePath' => ['ui' => 'footerFilePath'],
        'ui_logoFilePath' => ['ui' => 'logoFilePath'],
        'ui_headerForegroundColor' => ['ui' => 'headerForegroundColor'],
        'ui_headerBackgroundColor' => ['ui' => 'headerBackgroundColor'],
        'ui_headerActiveTabColor' => ['ui' => 'headerActiveTabColor'],
        'ui_headerTextColor' => ['ui' => 'headerTextColor'],
        'ui_supportLink' => ['ui' => 'supportLink'],
        'ui_gzipCompression' => [
            'ui' => 'gzipCompression',
            'bool' => true
        ]
    ];
    // SSL Settings
    $aElements += [
        'openads_requireSSL' => [
            'openads' => 'requireSSL',
            'bool' => true
        ],
        'openads_sslPort' => ['openads' => 'sslPort']
    ];
    // Dashboard Settings
    $aElements += [
        'ui_dashboardEnabled' => [
        'ui' => 'dashboardEnabled',
        'bool' => true
        ]
    ];

    // Dashboard Settings
    $aElements += ['authentication_type' => ['authentication' => 'type']];


    // Create a new settings object, and save the settings!
    $oSettings = new OA_Admin_Settings();
    $result = $oSettings->processSettingsFromForm($aElements);
    if ($result) {
        // Delete all the sessions if the UI is disabled
        // to force all the users to be logged out
        if (!$GLOBALS['ui_enabled']) {
            $doSession = OA_Dal::factoryDO('session');
            $doSession->whereAdd('1=1');
            $doSession->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        }
        // Rebuild the menu because the Enable Dashboard setting could been changed
        OA_Admin_Menu::_clearCache(OA_ACCOUNT_ADMIN);
        OA_Admin_Menu::_clearCache(OA_ACCOUNT_MANAGER);
        // Queue confirmation message
        $setPref = $oOptions->getSettingsPreferences($prefSection);
        $title = $setPref[$prefSection]['name'];
        $translation = new OX_Translation();
        $translated_message = $translation->translate(
            $GLOBALS['strXSettingsHaveBeenUpdated'],
            [htmlspecialchars($title)]
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        // The settings configuration file was written correctly,
        OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
    }
    // Could not write the settings configuration file, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWriteConfig;
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
        'text' => $strGeneralSettings,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'ui_enabled',
                'text' => $uiEnabled
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_applicationName',
                'text' => $strAppName,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_headerFilePath',
                'text' => $strMyHeader,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_footerFilePath',
                'text' => $strMyFooter,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_logoFilePath',
                'text' => $strMyLogo,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_headerForegroundColor',
                'text' => $strGuiHeaderForegroundColor,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_headerBackgroundColor',
                'text' => $strGuiHeaderBackgroundColor,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_headerActiveTabColor',
                'text' => $strGuiActiveTabColor,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_headerTextColor',
                'text' => $strGuiHeaderTextColor,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'ui_supportLink',
                'text' => $strGuiSupportLink,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_gzipCompression',
                'text' => $strGzipContentCompression
            ]
        ]
    ],
    [
        'text' => $strSSLSettings,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'openads_requireSSL',
                'text' => $requireSSL
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'openads_sslPort',
                'text' => $sslPort,
                'check' => 'wholeNumber'
            ],
        ],
     ],
     [
         'text' => $strDashboardSettings,
         'items' => [
             [
                 'type' => 'checkbox',
                 'name' => 'ui_dashboardEnabled',
                 'text' => ($GLOBALS['_MAX']['CONF']['sync']['checkForUpdates'] ? $strEnableDashboard : $strEnableDashboardSyncNotice),
                 'disabled' => !$GLOBALS['_MAX']['CONF']['sync']['checkForUpdates']
             ]
        ]
    ]
];

$aAuthPlugins = OX_Component::getComponents('authentication');
if (!empty($aAuthPlugins) && is_array($aAuthPlugins)) {
    // Add the 'none' (internal) authentication scheme to the list
    $aItems = ['none' => 'None (internal)'];
    foreach ($aAuthPlugins as $oAuthPlugin) {
        $aItems[$oAuthPlugin->getComponentIdentifier()] = $oAuthPlugin->getName();
    }
    $aSettings[] = [
         'text' => 'Authentication mechanism',
         'items' => [
             [
                 'type' => 'select',
                 'name' => 'authentication_type',
                 'text' => 'Select the plugin-component to be used for authentication',
                 'items' => $aItems,
             ]
        ]
    ];
}

$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();
