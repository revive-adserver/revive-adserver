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
$prefSection = "debug";

// Prepare an array for storing error messages
$aErrormessage = [];

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = [];
    // Audit Trail
    $aElements += [
        'audit_enabled' => [
            'audit' => 'enabled',
            'bool' => true
        ],
        'audit_enabledForZoneLinking' => [
            'audit' => 'enabledForZoneLinking',
            'bool' => true
        ]
    ];
    // Debug Logging Settings
    $aElements += [
        'debug_production' => [
            'debug' => 'production',
            'bool' => true
        ],
        'log_enabled' => [
            'log' => 'enabled',
            'bool' => true
        ],
        'log_methodNames' => [
            'log' => 'methodNames',
            'bool' => true
        ],
        'log_lineNumbers' => [
            'log' => 'lineNumbers',
            'bool' => true
        ],
        'log_type' => ['log' => 'type'],
        'log_name' => ['log' => 'name'],
        'log_priority' => ['log' => 'priority'],
        'log_ident' => ['log' => 'ident'],
        'log_paramsUsername' => ['log' => 'paramsUsername'],
        'log_paramsPassword' => ['log' => 'paramsPassword']
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

// Set the correct value of Debug Priority Level
$GLOBALS['_MAX']['CONF']['log']['priority'] = $oOptions->pearLogPriorityToConstrantName($GLOBALS['_MAX']['CONF']['log']['priority']);


// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = [
    [
        'text' => $strAuditTrailSettings,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'audit_enabled',
                'text' => $strEnableAudit
            ],
            [
                'type' => 'checkbox',
                'name' => 'audit_enabledForZoneLinking',
                'text' => $strEnableAuditForZoneLinking
            ]
        ]
    ],
    [
        'text' => $strDebug,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'debug_production',
                'text' => $strProductionSystem
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'log_enabled',
                'text' => $strEnableDebug
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'log_methodNames',
                'text' => $strDebugMethodNames,
                'depends' => 'log_enabled==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'log_lineNumbers',
                'text' => $strDebugLineNumbers,
                'depends' => 'log_enabled==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'select',
                'name' => 'log_type',
                'text' => $strDebugType,
                'items' => [
                    'file' => $strDebugTypeFile,
                    /* These have to be hidden utill we fix Developer Trac Ticket #789
                    'mcal'   => $strDebugTypeMcal,
                    'sql'    => $strDebugTypeSql,
                    'syslog' => $strDebugTypeSyslog
                    */
                ],
                'depends' => 'log_enabled==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'log_name',
                'text' => $strDebugName,
                'req' => true,
                'depends' => 'log_enabled==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'select',
                'name' => 'log_priority',
                'text' => $strDebugPriority,
                'items' => [
                    'PEAR_LOG_DEBUG' => $strPEAR_LOG_DEBUG,
                    'PEAR_LOG_INFO' => $strPEAR_LOG_INFO,
                    'PEAR_LOG_NOTICE' => $strPEAR_LOG_NOTICE,
                    'PEAR_LOG_WARNING' => $strPEAR_LOG_WARNING,
                    'PEAR_LOG_ERR' => $strPEAR_LOG_ERR,
                    'PEAR_LOG_CRIT' => $strPEAR_LOG_CRIT,
                    'PEAR_LOG_ALERT' => $strPEAR_LOG_ALERT,
                    'PEAR_LOG_EMERG' => $strPEAR_LOG_EMERG
                ],
                'depends' => 'log_enabled==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'log_ident',
                'text' => $strDebugIdent,
                'req' => true,
                'depends' => 'log_enabled==1'
            ]
            /* These fields are hidden because mCal debug log type
               is not supported at this moment
            ,
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'log_paramsUsername',
                'text'    => $strDebugUsername,
                'depends' => 'log_enabled==1 && log_type==1 || log_type==2'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'password',
                'name'    => 'log_paramsPassword',
                'text'    => $strDebugPassword,
                'depends' => 'log_enabled==1 && log_type==1 || log_type==2'
            )*/
        ]
    ]
];
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();
