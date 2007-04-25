<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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

/**
 * db upgrade class demonstration script
 */

require_once '../../init.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

$welcome = true;
$backup  = false;
$upgrade = false;

$oUpgrader = new OA_Upgrade();

if ($oUpgrader->oDBUpgrader->seekRecoveryFile())
{
    $oUpgrader->oDBUpgrader->prepRecovery();
}
else if (array_key_exists('btn_view_available', $_REQUEST))
{
    $aPackagesAvail = $oUpgrader->_getPackageList();
}
else if (array_key_exists('btn_parse_pkg', $_REQUEST))
{
    $input_file = $_POST['btn_parse_pkg'];
    $aPkgParsed = $oUpgrader->_parseUpgradePackageFile(MAX_PATH.'/var/upgrade/'.$input_file);
}
else if (array_key_exists('btn_view_changesets', $_REQUEST))
{
    $aChangesetInfo = $oUpgrader->_checkChangesetAudit('tables_core');
}
else if (array_key_exists('btn_view_logs', $_REQUEST))
{
    $aLogfiles = $oUpgrader->oLogger->getLogfilesList();
}
else if (array_key_exists('btn_view_backups', $_REQUEST))
{
    $aBackups = $oUpgrader->oDBUpgrader->_listBackups();
}
else if (array_key_exists('btn_backup_drop', $_REQUEST))
{
    $oUpgrader->oDBUpgrader->dropBackupTable($_POST['btn_backup_drop']);
    $aBackups = $oUpgrader->oDBUpgrader->_listBackups();
}
else if (array_key_exists('btn_logfile_view', $_REQUEST))
{
    $logfile = $_POST['btn_logfile_view'];
    $logcontent = file_get_contents(MAX_PATH.'/var/'.$logfile);
}
else if (array_key_exists('btn_logfile_drop', $_REQUEST))
{
    $logfile = $_POST['btn_logfile_drop'];
    unlink(MAX_PATH.'/var/'.$logfile);
    $aLogfiles = $oUpgrader->oLogger->getLogfilesList();
}
else if (array_key_exists('btn_view_audit', $_REQUEST))
{
    $aAudit = $oUpgrader->oDBUpgrader->oAuditor->queryAuditAll();
}
else if (array_key_exists('btn_initialise', $_REQUEST))
{
    $oUpgrader->oDBUpgrader->init($timing, $schema, $version);
    $upgrade = true;
}
else if (array_key_exists('btn_upgrade', $_POST))
{
    $oUpgrader->init($_POST['btn_upgrade']);
    $oUpgrader->upgradeSchemas();
}
include 'tpl/upgrade.html';


?>


