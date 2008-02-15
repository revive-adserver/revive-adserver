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

/**
 * db upgrade class demonstration script
 */

function getDBAuditTable($aAudit)
{
    $td = "<td class=\"tablebody\">%s</td>";
    $th = "<th align=\"left\" style='background-color: #ddd; border-bottom: 1px solid #ccc;'><b>%s</b></th>";
    $schemas = "<table width='100%' cellpadding='8' cellspacing='0' style='border: 1px solid #ccc; background-color: #eee;'>";
    $schemas.= "<tr>";
    //$schemas.= sprintf($th, 'schema');
    //$schemas.= sprintf($th, 'version');
    $schemas.= sprintf($th, 'Table origin');
    $schemas.= sprintf($th, 'Backup table');
    $schemas.= sprintf($th, 'Size');
    $schemas.= sprintf($th, 'Rows');
    //$schemas.= sprintf($th, 'Delete');
    $schemas.= "</tr>";
    $totalSize = 0;
    $totalRows = 0;
    foreach ($aAudit AS $k => $aRec)
    {
        $schemas.= "<tr>";
        //$schemas.= sprintf($td, $aRec['schema_name']);
        //$schemas.= sprintf($td, $aRec['version']);
        $schemas.= sprintf($td, $aRec['tablename']);
        $schemas.= sprintf($td, $aRec['tablename_backup']);
        $schemas.= sprintf($td, $aRec['backup_size'] * 1024 . ' kb');
        $schemas.= sprintf($td, $aRec['backup_rows']);
        //$schemas.= sprintf($td, "<input type=\"checkbox\" id=\"chk_tbl[{$aRec['database_action_id']}]\" name=\"chk_tbl[{$aRec['database_action_id']}]\" checked />");
        $schemas.= "</tr>";
        $totalSize = $totalSize + $aRec['backup_size'];
        $totalRows = $totalRows + $aRec['backup_rows'];
    }
    
    $schemas.= "<tr>";
    $schemas.= sprintf($th, 'Total');
    $schemas.= sprintf($th, count($aAudit) . ' tables');
    $schemas.= sprintf($th, $totalSize * 1024 . ' kb');
    $schemas.= sprintf($th, $totalRows);
    //$schemas.= sprintf($th, 'Delete');
    $schemas.= "</tr>";
    
    $schemas.= "</table>";
    return $schemas;
}

require_once '../../../../init.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

define('MAX_DEV', MAX_PATH.'/www/devel');

$welcome = true;
$backup  = false;
$upgrade = false;

$oUpgrader = new OA_Upgrade();

if (array_key_exists('xajax', $_POST))
{
    $_POST['xajaxargs'][1] = $oUpgrader;
}

require_once MAX_DEV.'/lib/xajax.inc.php';

if (array_key_exists('btn_view_available', $_REQUEST))
{
    $aPackagesAvail = $oUpgrader->_getPackageList();
}
else if (array_key_exists('btn_parse_pkg', $_REQUEST))
{
    $input_file = $_POST['btn_parse_pkg'];
    //$aPkgParsed = $oUpgrader->_parseUpgradePackageFile(MAX_PATH.'/var/upgrade/'.$input_file);
    $oUpgrader->_parseUpgradePackageFile(MAX_PATH.'/etc/changes/'.$input_file);
    $aPkgParsed = $oUpgrader->aPackage;
}
else if (array_key_exists('btn_view_changesets', $_REQUEST))
{
    $oUpgrader->initDatabaseConnection();
    $aChangesetInfo = $oUpgrader->_checkChangesetAudit('tables_core');
}
else if (array_key_exists('btn_view_logs', $_REQUEST))
{
    $aLogfiles = $oUpgrader->oLogger->getLogfilesList();
}
else if (array_key_exists('btn_view_environment', $_REQUEST))
{
    $oUpgrader->oSystemMgr->getAllInfo();
    $oUpgrader->oSystemMgr->checkCritical();
    $aSysInfo = $oUpgrader->oSystemMgr->aInfo;
    $oUpgrader->canUpgrade();
}
else if (array_key_exists('btn_view_backups', $_REQUEST))
{
    $oUpgrader->initDatabaseConnection();
    $aBackups = $oUpgrader->oDBAuditor->_listBackups();
}
else if (array_key_exists('btn_backup_drop', $_REQUEST))
{
    $oUpgrader->initDatabaseConnection();
    $oUpgrader->oDBUpgrader->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
    $oUpgrader->oDBUpgrader->dropBackupTable($_POST['btn_backup_drop'],' dropped by user');
    $aBackups = $oUpgrader->oDBAuditor->_listBackups();
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
    $oUpgrader->initDatabaseConnection();
    $aAudit = $oUpgrader->oAuditor->queryAuditAllDescending();
}
else if (array_key_exists('btn_clean_audit', $_REQUEST))
{
    $upgrade_id = $_POST['upgrade_action_id'];
    $oUpgrader->initDatabaseConnection();
    $oUpgrader->oAuditor->cleanAuditArtifacts($upgrade_id);
    $aAudit = $oUpgrader->oAuditor->queryAuditAllDescending();
}
else if (array_key_exists('btn_view_dbaudit', $_REQUEST))
{
    $oUpgrader->initDatabaseConnection();
    $aDBAudit = $oUpgrader->oDBAuditor->queryAuditAll();
}
else if (array_key_exists('btn_initialise', $_REQUEST))
{
//    $oUpgrader->oDBUpgrader->init($timing, $schema, $version);
//    $upgrade = true;
}
else if (array_key_exists('btn_upgrade', $_POST))
{
//    $oUpgrader->init($_POST['btn_upgrade']);
//    $oUpgrader->initDatabaseConnection();
//    $oUpgrader->upgradeSchemas();
}
include 'tpl/upgrade.html';


?>


