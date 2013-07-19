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
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    // Audit Trail
    $aElements += array(
        'audit_enabled' => array(
            'audit' => 'enabled',
            'bool'  => true
        ),
        'audit_enabledForZoneLinking' => array(
            'audit' => 'enabledForZoneLinking',
            'bool'  => true
        )
    );
    // Debug Logging Settings
    $aElements += array(
        'debug_production' => array(
            'debug' => 'production',
            'bool'  => true
        ),
        'log_enabled' => array(
            'log'  => 'enabled',
            'bool' => true
        ),
        'log_methodNames' => array(
            'log'  => 'methodNames',
            'bool' => true
        ),
        'log_lineNumbers' => array(
            'log'  => 'lineNumbers',
            'bool' => true
        ),
        'log_type'           => array('log'  => 'type'),
        'log_name'           => array('log'  => 'name'),
        'log_priority'       => array('log'  => 'priority'),
        'log_ident'          => array('log'  => 'ident'),
        'log_paramsUsername' => array('log'  => 'paramsUsername'),
        'log_paramsPassword' => array('log'  => 'paramsPassword')
    );
    // Create a new settings object, and save the settings!
    $oSettings = new OA_Admin_Settings();
    $result = $oSettings->processSettingsFromForm($aElements);
    if ($result) {
            // Queue confirmation message
            $setPref = $oOptions->getSettingsPreferences($prefSection);
            $title = $setPref[$prefSection]['name'];
            $translation = new OX_Translation ();
            $translated_message = $translation->translate($GLOBALS['strXSettingsHaveBeenUpdated'],
                array(htmlspecialchars($title)));
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
$aSettings = array (
    array (
        'text'  => $strAuditTrailSettings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'audit_enabled',
                'text'    => $strEnableAudit
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'audit_enabledForZoneLinking',
                'text'    => $strEnableAuditForZoneLinking
            )
        )
    ),
    array (
        'text'  => $strDebug,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'debug_production',
                'text'    => $strProductionSystem
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'log_enabled',
                'text'    => $strEnableDebug
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'log_methodNames',
                'text'    => $strDebugMethodNames,
                'depends' => 'log_enabled==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'log_lineNumbers',
                'text'    => $strDebugLineNumbers,
                'depends' => 'log_enabled==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'select',
                'name'    => 'log_type',
                'text'    => $strDebugType,
                'items'   => array(
                    'file'   => $strDebugTypeFile,
                    /* These have to be hidden utill we fix Developer Trac Ticket #789
                    'mcal'   => $strDebugTypeMcal,
                    'sql'    => $strDebugTypeSql,
                    'syslog' => $strDebugTypeSyslog
                    */
                ),
                'depends' => 'log_enabled==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'log_name',
                'text'    => $strDebugName,
                'req'     => true,
                'depends' => 'log_enabled==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'select',
                'name'    => 'log_priority',
                'text'    => $strDebugPriority,
                'items'   => array(
                    'PEAR_LOG_DEBUG'   => $strPEAR_LOG_DEBUG,
                    'PEAR_LOG_INFO'    => $strPEAR_LOG_INFO,
                    'PEAR_LOG_NOTICE'  => $strPEAR_LOG_NOTICE,
                    'PEAR_LOG_WARNING' => $strPEAR_LOG_WARNING,
                    'PEAR_LOG_ERR'     => $strPEAR_LOG_ERR,
                    'PEAR_LOG_CRIT'    => $strPEAR_LOG_CRIT,
                    'PEAR_LOG_ALERT'   => $strPEAR_LOG_ALERT,
                    'PEAR_LOG_EMERG'   => $strPEAR_LOG_EMERG
                ),
                'depends' => 'log_enabled==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'log_ident',
                'text'    => $strDebugIdent,
                'req'     => true,
                'depends' => 'log_enabled==1'
            )
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
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>