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
define('MAX_CHG', MAX_PATH.'/etc/changes/');
define('MAX_VAR', MAX_PATH.'/var/');

// Required files
require_once MAX_DEV.'/lib/pear.inc.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';
require_once 'Config.php';
require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_DEV.'/lib/openads/DB_Upgrade.php';

$welcome = true;
$backup  = false;
$upgrade = false;

$oUpgrade = new OA_DB_Upgrade();

if ($oUpgrade->_seekRecoveryFile())
{
    $oUpgrade->_prepRecovery();
}
else if (array_key_exists('btn_view_available', $_REQUEST))
{
    $aChangesetsAvail = getChangesetList();
}
else if (array_key_exists('btn_view_logs', $_REQUEST))
{
    $aLogfiles = getLogfilesList();
}
else if (array_key_exists('btn_logfile', $_REQUEST))
{
    $logfile = $_POST['btn_logfile'];
    $logcontent = file_get_contents(MAX_VAR.$logfile);
}
else if (array_key_exists('btn_view_audit', $_REQUEST))
{
    $aAudit = getAuditRecords($oUpgrade);
}
else if (array_key_exists('btn_initialise', $_REQUEST))
{
    $oUpgrade->init($timing, $schema, $version);
    $upgrade = true;
}
else if (array_key_exists('btn_upgrade', $_POST))
{
    $version = $_POST['btn_upgrade'];
    $timing = 'constructive';
    $schema = 'tables_core';
    if ($oUpgrade->init($timing, $schema, $version))
    {
        $oUpgrade->upgrade();
    }
}
include 'tpl/upgrade.html';


function getChangesetList()
{
    $aFiles = array();
    $dh = opendir(MAX_CHG);
    if ($dh) {
        while (false !== ($file = readdir($dh)))
        {
            $aMatches = array();
            if (preg_match('/schema_[\w\W]+_[\d]+\.xml/', $file, $aMatches))
            {
                $fileSchema = basename($file);
                $aFiles[$fileSchema] = array();
                $fileChanges = str_replace('schema', 'changes', $fileSchema);
                $fileMigrate = str_replace('schema', 'migration', $fileSchema);
                $fileMigrate = str_replace('xml', 'php', $fileMigrate);
                if (file_exists(MAX_CHG.$fileChanges))
                {
                    $aFiles[$file]['changeset'] = $fileChanges;
                }
                if (file_exists(MAX_CHG.$fileMigrate))
                {
                    $aFiles[$file]['migration'] = $fileMigrate;
                }
            }
        }
    }
    closedir($dh);
    return $aFiles;
}

function getLogfilesList()
{
    $aFiles = array();
    $dh = opendir(MAX_VAR);
    if ($dh) {
        while (false !== ($file = readdir($dh)))
        {
            $aMatches = array();
            if (preg_match('/upgrade_[\d_]+\.log/', $file, $aMatches))
            {
                $aFiles[] = basename($file);
            }
        }
    }
    closedir($dh);
    return $aFiles;
}

function getAuditRecords($oDBUpgrade)
{
    return $oDBUpgrade->_queryAllLogTable();
}

?>


