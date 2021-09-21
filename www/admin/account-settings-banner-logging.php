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


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "banner-logging";

// Prepare an array for storing error messages
$aErrormessage = [];

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = [];
    // Banner Logging Settings
    $aElements += [
        'logging_adRequests' => [
             'logging' => 'adRequests',
             'bool' => 'true',
         ],
        'logging_adImpressions' => [
             'logging' => 'adImpressions',
             'bool' => 'true',
         ],
        'logging_adClicks' => [
             'logging' => 'adClicks',
             'bool' => 'true',
         ],
        'logging_reverseLookup' => [
             'logging' => 'reverseLookup',
             'bool' => 'true',
         ],
        'logging_proxyLookup' => [
             'logging' => 'proxyLookup',
             'bool' => 'true',
         ]
    ];
    
    // Block Inactive Banner Settings
    $aElements += [
         'logging_blockInactiveBanners' => [
             'logging' => 'blockInactiveBanners',
             'bool' => 'true',
         ]
     ];
    
    // Block Banner Logging Window Settings
    $aElements += [
         'logging_blockAdClicksWindow' => [
             'logging' => 'blockAdClicksWindow',
         ]
     ];

    // Block Banner Logging Settings
    $aElements += [
        'logging_ignoreHosts' => [
            'logging' => 'ignoreHosts',
            'preg_split' => "/ |,|;|\r|\n/",
            'merge' => ',',
            'merge_unique' => true,
        ]
    ];

    // Block User-Agents
    $aElements += [
        'logging_ignoreUserAgents' => [
            'logging' => 'ignoreUserAgents',
            'preg_split' => "/\r|\n/",
            'merge' => '|',
            'merge_unique' => true,
            'trim' => true,
        ]
    ];

    // Enforce User-Agents
    $aElements += [
        'logging_enforceUserAgents' => [
            'logging' => 'enforceUserAgents',
            'preg_split' => "/\r|\n/",
            'merge' => '|',
            'merge_unique' => true,
            'trim' => true,
        ]
    ];
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
            [htmlspecialchars($title)]
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        // The settings configuration file was written correctly,
        // go to the "next" settings page from here
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
        'text' => $strBannerLogging,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'logging_adRequests',
                'text' => $strLogAdRequests,
            ],
            [
                'type' => 'checkbox',
                'name' => 'logging_adImpressions',
                'text' => $strLogAdImpressions,
            ],
            [
                'type' => 'checkbox',
                'name' => 'logging_adClicks',
                'text' => $strLogAdClicks,
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'logging_reverseLookup',
                'text' => $strReverseLookup,
            ],
            [
                'type' => 'checkbox',
                'name' => 'logging_proxyLookup',
                'text' => $strProxyLookup,
            ]
        ]
    ],
    [
        'text' => $strPreventLogging,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'logging_blockInactiveBanners',
                'text' => $strBlockInactiveBanners,
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'logging_blockAdClicksWindow',
                'text' => $strBlockAdClicks,
                'check' => 'wholeNumber',
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'textarea',
                'name' => 'logging_ignoreHosts',
                'text' => $strIgnoreHosts,
                'preg_split' => '/,/',
                'merge' => "\n",
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'textarea',
                'name' => 'logging_ignoreUserAgents',
                'text' => $strIgnoreUserAgents,
                'preg_split' => '/\|/',
                'merge' => "\n",
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'textarea',
                'name' => 'logging_enforceUserAgents',
                'text' => $strEnforceUserAgents,
                'preg_split' => '/\|/',
                'merge' => "\n",
            ]
        ]
    ]
];
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();
