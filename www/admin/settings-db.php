<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once MAX_PATH . '/lib/max/Admin/DB.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    phpAds_registerGlobal('database_type', 'database_host', 'database_port', 'database_username',
                          'database_password', 'database_name', 'database_persistent');
    if (isset($database_password) && ereg('^\*+$', $database_password)) {
        $database_password = $conf['database']['password'];
    }
    if (isset($database_type) && isset($database_host) && isset($database_username) &&
        isset($database_password) && isset($database_name)) {
        unset($GLOBALS['_MAX']['ADMIN_DB_LINK']);
        $GLOBALS['_MAX']['CONF']['database']['type']        = $database_type;
        $GLOBALS['_MAX']['CONF']['database']['host']        = $database_host;
        $GLOBALS['_MAX']['CONF']['database']['port']        = $database_port;
        $GLOBALS['_MAX']['CONF']['database']['username']    = $database_username;
        $GLOBALS['_MAX']['CONF']['database']['password']    = $database_password;
        $GLOBALS['_MAX']['CONF']['database']['name']        = $database_name;
        $GLOBALS['_MAX']['CONF']['database']['persistent']  = isset($database_persistent) ? true : false;
        if (!phpAds_dbConnect()) {
            $errormessage[0][] = $strCantConnectToDb;
        } else {
            // Set up the configuration .ini file
            $config = new MAX_Admin_Config();
            $config->setConfigChange('database', 'type',       $database_type);
            $config->setConfigChange('database', 'host',       $database_host);
            $config->setConfigChange('database', 'port',       $database_port);
            $config->setConfigChange('database', 'username',   $database_username);
            $config->setConfigChange('database', 'password',   $database_password);
            $config->setConfigChange('database', 'name',       $database_name);
            $config->setConfigChange('database', 'persistent', $GLOBALS['_MAX']['CONF']['database']['persistent']);
            if (!$config->writeConfigChange()) {
                // Unable to write the config file out
                $errormessage[0][] = $strUnableToWriteConfig;
            } else {
                MAX_Admin_Redirect::redirect('settings-debug.php');
            }
        }
    }
}

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_SettingsSelection("db");

$settings = array (
    array (
        'text'  => $strDatabaseServer,
        'items' => array (
            array (
                'type'       => 'select', 
                'name'       => 'database_type',
                'text'       => $strDbType,
                'items'   => Max_Admin_DB::getServerTypes()
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'       => 'text', 
                'name'       => 'database_host',
                'text'       => $strDbHost,
                'req'      => true,
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'       => 'text', 
                'name'       => 'database_port',
                'text'       => $strDbPort,
                'req'      => true,
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'       => 'text', 
                'name'       => 'database_username',
                'text'       => $strDbUser,
                'req'      => true,
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'       => 'password', 
                'name'       => 'database_password',
                'text'       => $strDbPassword,
                'req'      => false,
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'       => 'text', 
                'name'       => 'database_name',
                'text'       => $strDbName,
                'req'      => true,
            )
        )
    ),
    array (
        'text'  => $strDatabaseOptimalisations,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'database_persistent',
                'text'      => $strPersistentConnections
            )
        )
    )
);

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
