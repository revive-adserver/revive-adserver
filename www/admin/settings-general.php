<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: settings-general.php 5657 2006-10-10 14:16:40Z arlen $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    phpAds_registerGlobal('max_uiEnabled', 'max_language', 'max_requireSSL', 'max_sslPort');
    // Set up the configuration .ini file
    $config = new MAX_Admin_Config();
    $config->setConfigChange('max', 'uiEnabled',    $max_uiEnabled);
    $config->setConfigChange('max', 'language',     $max_language);
    $config->setConfigChange('max', 'requireSSL',   $max_requireSSL);
    $config->setConfigChange('max', 'sslPort',      $max_sslPort);
    $config->setConfigChange('debug', 'production', $debug_production);
    if (!$config->writeConfigChange()) {
        // Unable to write the config file out
        $errormessage[0][] = $strUnableToWriteConfig;
    } else {
        MAX_Admin_Redirect::redirect('settings-geotargeting.php');
    }
}

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_SettingsSelection("general");

$settings = array (
    array (
        'text'  => $generalSettings,
        'items' => array (
            array (
                'type'    => 'checkbox', 
                'name'    => 'debug_production',
                'text'    => $strProduction
            ),
            array (
                'type'    => 'break'
            ),    
            array (
                'type'  => 'checkbox',
                'name'  => 'max_uiEnabled',
                'text'  => $uiEnabled
            ),
            array (
                'type'  => 'break'
            ),
            array (
                'type'  => 'select',
                'name'  => 'max_language',
                'text'  => $defaultLanguage,
                'items' => MAX_Admin_Languages::AvailableLanguages()
            ),
            array (
                'type'  => 'break'
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'max_requireSSL',
                'text'  => $requireSSL
            ),
            array (
                'type'  => 'break'
            ),
            array (
                'type'  => 'text',
                'name'  => 'max_sslPort',
                'text'  => $sslPort
            ),
        )
    )
);

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
