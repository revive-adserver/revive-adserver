<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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
require_once MAX_PATH . '/lib/max/Admin/DB.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

$oOptions = new OA_Admin_Option('settings');

// Security check
phpAds_checkAccess(phpAds_Admin);

$aErrormessage = array();
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
            $aErrormessage[0][] = $strCantConnectToDb;
        } else {
            // Set up the configuration .ini file
            $oConfig = new OA_Admin_Settings();
            $oConfig->setConfigChange('database', 'type',       $database_type);
            $oConfig->setConfigChange('database', 'host',       $database_host);
            $oConfig->setConfigChange('database', 'port',       $database_port);
            $oConfig->setConfigChange('database', 'username',   $database_username);
            $oConfig->setConfigChange('database', 'password',   $database_password);
            $oConfig->setConfigChange('database', 'name',       $database_name);
            $oConfig->setConfigChange('database', 'persistent', $GLOBALS['_MAX']['CONF']['database']['persistent']);
            if (!$oConfig->writeConfigChange()) {
                // Unable to write the config file out
                $aErrormessage[0][] = $strUnableToWriteConfig;
            } else {
                MAX_Admin_Redirect::redirect('account-settings-debug.php');
            }
        }
    }
}

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
$oOptions->selection("databaseb");

$oSettings = array (
    array (
        'text'  => $strDatabaseServer,
        'items' => array (
            array (
                'type'       => 'select',
                'name'       => 'database_type',
                'text'       => $strDbType,
                'items'      => array($GLOBALS['_MAX']['CONF']['database']['type'] => $GLOBALS['_MAX']['CONF']['database']['type'])
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

$oOptions->show($oSettings, $aErrormessage);
phpAds_PageFooter();

?>
