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
$Id$
*/

/**
 * A quick and dirty script
 * to execute incremental upgrades from within a browser
 * using the /lib/max/Admin/Upgrade.php class
 * Doesn't look pretty!
 * but it does output error messages
 * and updates the schema version variable
 * as it goes along
 * Uses a crude "template" system
 */

require_once '../../../init.php';
define('MAX_DEV', MAX_PATH.'/www/devel');


// Overwrite $conf, as a reference to $GLOBALS['_MAX']['CONF'],
// so that configuration options can be more easily set during
// the upgrade process
//$conf = &$GLOBALS['_MAX']['CONF'];

// Required files
require_once MAX_DEV.'/lib/pear.inc.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';
require_once 'Config.php';

require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_PATH.'/lib/OA/DB/Table.php';
require_once MAX_PATH.'/lib/OA/Dal/Links.php';

require_once MAX_DEV.'/lib/openads/DB_Upgrade.php';

if (array_key_exists('btn_upgrade', $_POST))
{
    $oUpgrade = new Openads_DB_Upgrade();
    if ($oUpgrade->init(10))
    {
        $oUpgrade->upgrade('constructive');
    }
//    $upgradeFunction = $_REQUEST['function'];
//    $upgradeVersion  = $_REQUEST['version'];
//    $oUpgrade->$upgradeFunction();
//    if (count($oUpgrade->errors)>0)
//    {
//        $errorText = '';
//        foreach ($oUpgrade->errors AS $k => $v)
//        {
//            $errorText.= $v;
//        }
//        include MAX_PATH . '/www//upgrade/templates/error.html';
//    } else {
//        $oUpgrade->upgradeTo = $upgradeVersion;
//        $oUpgrade->_upgradeInstalledVersion();
//        initUpgrade(true);
//    }
}
else if (array_key_exists('btn_continue', $_REQUEST))
{
//    $oUpgrade        = initUpgrade(false);
//    $upgradeVersion  = $_REQUEST['version'];
//    $oUpgrade->upgradeTo = $upgradeVersion;
//    $oUpgrade->_upgradeInstalledVersion();
//    initUpgrade(true);
}
else
{
    $oUpgrade = new Openads_DB_Upgrade();
    $oUpgrade->init(10);
}

include 'tpl/upgrade.html';

function initUpgrade($display=true)
{
    $oUpgrade = new Openads_DB_Upgrade();
//    $oUpgrade->init(10);
//    $verCode = $upgrade->getVersionConstant();
//    $verSchema = $upgrade->getVersionSchema();
//    if (!$verSchema)
//    {
//        $verSchema = 'v0.2.0-alpha';
//        $upgrade->upgradeFrom = 'v0.1.16-beta';
//        $upgrade->upgradeTo = 'v0.2.0-alpha';
//        $upgrade->setInstalledVersion();
//        $upgrade->_upgradeInstalledVersion();
//    }
//    else
//    {
//        $upgradeRequired = $upgrade->previousVersionExists($verCode);
//    }
//    $aUpgrade = $upgrade->getUpgradeFunction();
//    $upgradeRequired = ($aUpgrade['version'] ? true : false);
//    if ($upgradeRequired)
//    {
//        $upgradeVersion = $aUpgrade['version'];
//        $upgradeFunction = $aUpgrade['function'];
//    }
    if ($display)
    {
        include 'tpl/upgrade.html';
    }
    else
    {
        return $oUpgrade;
    }
}
?>


