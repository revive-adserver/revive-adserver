<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';
require_once MAX_PATH . '/www/admin/lib-install-db.inc.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    phpAds_registerGlobal('log_enabled', 'log_methodNames', 'log_lineNumbers', 'log_type',
                          'log_name', 'log_priority', 'log_ident', 'log_paramsUsername',
                          'log_paramsPassword');
    // Set up the configuration .ini file
    $config = new MAX_Admin_Config();
    $config->setConfigChange('log', 'enabled',          $log_enabled);
    $config->setConfigChange('log', 'methodNames',      $log_methodNames);
    $config->setConfigChange('log', 'lineNumbers',      $log_lineNumbers);
    $config->setConfigChange('log', 'type',             $log_type);
    $config->setConfigChange('log', 'name',             $log_name);
    $config->setConfigChange('log', 'priority',         $log_priority);
    $config->setConfigChange('log', 'ident',            $log_ident);
    $config->setConfigChange('log', 'paramsUsername',   $log_paramsUsername);
    $config->setConfigChange('log', 'paramsPassword',   $log_paramsPassword);
    if (!$config->writeConfigChange()) {
        // Unable to write the config file out
        $errormessage[0][] = $strUnableToWriteConfig;
    } else {
        MAX_Admin_Redirect::redirect('settings-delivery.php');
    }
}

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_SettingsSelection("debug");

$settings = array (
    array (
        'text'  => $strDebug,
        'items' => array (
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
                'items'   => array('file'   => $strDebugTypeFile,
                                   'mcal'   => $strDebugTypeMcal,
                                   'sql'    => $strDebugTypeSql,
                                   'syslog' => $strDebugTypeSyslog),
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
                'items'   => array('PEAR_LOG_DEBUG'   => $strPEAR_LOG_DEBUG,
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
            ),
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
            )
        )
    )
);

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
