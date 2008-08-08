<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

require_once LIB_PATH . '/Admin/Redirect.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');

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
        // The settings configuration file was written correctly,
        // go to the "next" settings page from here
        OX_Admin_Redirect::redirect('account-settings-email.php');
    }
    // Could not write the settings configuration file, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWriteConfig;
}

// Display the settings page's header and sections
phpAds_PageHeader('account-settings-index');

// Set the correct value of Debug Priority Level
$GLOBALS['_MAX']['CONF']['log']['priority'] = $oOptions->pearLogPriorityToConstrantName($GLOBALS['_MAX']['CONF']['log']['priority']);

// Set the correct section of the settings pages and display the drop-down menu
$oOptions->selection('debug');

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
        'text'  => $strAudit,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'audit_enabled',
                'text'    => $strEnableAudit
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