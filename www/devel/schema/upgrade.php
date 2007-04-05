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

// Required files
require_once MAX_DEV.'/lib/pear.inc.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';
require_once 'Config.php';
require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_DEV.'/lib/openads/DB_Upgrade.php';

$welcome = false;
$backup  = false;
$upgrade = false;

//$version = 3;
//$timing = 'constructive';

$version = 4;
$timing = 'constructive';

//$version = 5;
//$timing = 'destructive';

//$version = 6;
//$timing = 'destructive';

if (array_key_exists('btn_initialise', $_REQUEST))
{
    $oUpgrade = new OA_DB_Upgrade();
    $oUpgrade->init($timing, $version);
//    $backup = true;
    $upgrade = true;
    include 'tpl/upgrade.html';
}
else if (array_key_exists('btn_backup', $_REQUEST))
{
    $oUpgrade = new OA_DB_Upgrade();
    $oUpgrade->init($timing, $version);
    $oUpgrade->backup();
    $upgrade = true;
    include 'tpl/upgrade.html';
}
else if (array_key_exists('btn_upgrade', $_POST))
{
    $oUpgrade = new OA_DB_Upgrade();
    if ($oUpgrade->init($timing, $version))
    {
        $oUpgrade->upgrade();
    }
    include 'tpl/upgrade.html';
}
else
{
    $welcome = true;
    include 'tpl/upgrade.html';
}


?>


