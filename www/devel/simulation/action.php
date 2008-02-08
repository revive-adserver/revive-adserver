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

/**
 *
 * @package    Max
 * @subpackage SimulationSuite
 * @author
 */

require_once '../../../init.php';
require_once 'simconst.php';

require_once MAX_PATH.'/lib/OA/Upgrade/DB_Integrity.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
global $oUpgrader;

function getUpgradeStatus($dbname)
{
    global $oUpgrader;
    $GLOBALS['_MAX']['CONF']['database']['name'] = $dbname;

    $GLOBALS['_MAX']['CONF']['max']['installed'] = 1;
    $oUpgrader->detectMAX();
    switch ($oUpgrader->existing_installation_status)
    {
        case OA_STATUS_MAX_VERSION_FAILED: break;
        case OA_STATUS_CAN_UPGRADE: $aMessages[] = 'Database '.$dbname.' should be upgraded';return $aMessages;
        case OA_STATUS_MAX_CONFINTEG_FAILED: $aMessages[] = 'Database '.$dbname.' failed schema integrity check failed';return $aMessages;
    }
    $GLOBALS['_MAX']['CONF']['max']['installed'] = 0;
    $oUpgrader->detectOpenads();
    switch ($oUpgrader->existing_installation_status)
    {
        case OA_STATUS_CURRENT_VERSION: $aMessages[] = 'Database '.$dbname.' has current schema version';break;
        case OA_STATUS_OAD_VERSION_FAILED: $aMessages[] = 'Could not retrieve schema version from database '.$dbname;break;
        case OA_STATUS_CAN_UPGRADE: $aMessages[] = 'Database '.$dbname.' should be upgraded';break;
        case OA_STATUS_OAD_CONFINTEG_FAILED: $aMessages[] = 'Database '.$dbname.' failed schema integrity check failed';break;
        case OA_STATUS_OAD_DBCONNECT_FAILED: $aMessages[] = 'Failed to connect to '.$dbname;break;
        case OA_STATUS_OAD_NOT_INSTALLED: $aMessages[] = 'Application is not installed';break;
        default: $aMessages[] = 'Failed to retrieve installation status';break;
    }
    return $aMessages;
}

function doUpgrade($dbname)
{
    global $oUpgrader;
    $GLOBALS['_MAX']['CONF']['database']['name'] = $dbname;
    $oUpgrader->oDBUpgrader->doBackups = false;
    if ($oUpgrader->upgrade())
    {
        $aMessages[] = 'Your database has successfully been upgraded to Openads version '.OA_VERSION;
    }
    else
    {
        $aMessages[] = 'Your database has NOT been upgraded to Openads version '.OA_VERSION;
    }
    return $aMessages;
}

$oIntegrity = new OA_DB_Integrity();
$GLOBALS['_MAX']['CONF']['table']['prefix'] = '';
$scenario = $_REQUEST['scenario'];
$aDatasetFile = $oIntegrity->getSchemaFileInfo(SCENARIOS_DATASETS,$scenario);
$oIntegrity->version = $aDatasetFile['version'];
$oUpgrader = new OA_Upgrade();
$aMessages = getUpgradeStatus($aDatasetFile['name']);

if (array_key_exists('btn_data_integ',$_REQUEST))
{
    if ($oIntegrity->init($_REQUEST['compare_version'],$aDatasetFile['name']))
    {
        $oIntegrity->checkIntegrity();
        $aTasksConstructive = $oIntegrity->aTasksConstructiveAll;
        $aTasksDestructive  = $oIntegrity->aTasksDestructiveAll;
        $aMessages         .= $oIntegrity->getMessages();
        $file_schema        = $oIntegrity->getFileSchema();
        $file_changes       = $oIntegrity->getFileChanges();
        $compare_version    = $oIntegrity->version;
    }
}
else if (array_key_exists('btn_data_load', $_POST))
{
    $aVariables['appver'] = $aDatasetFile['application'];
    $aVariables['schema'] = $aDatasetFile['version'];
    $aVariables['dbname'] = $aDatasetFile['name'];
    $aVariables['prefix'] = '';
    $aVariables['dryrun'] = false;
    $aVariables['datafile'] = $scenario.'.xml';
    $aVariables['directory'] = SCENARIOS_DATASETS;
    $aMessages = $oIntegrity->loadData($aVariables);
    if (PEAR::isError($aMessages))
    {
        $aMessages[] = $aMessages->getUserInfo();
    }
}
else if (array_key_exists('btn_data_upgrade', $_POST))
{
    $aMessages = doUpgrade();
}
else if (array_key_exists('btn_data_dump', $_POST))
{
    $aDatabase = $oIntegrity->getVersion();
    $oIntegrity->init($aDatabase['versionSchema'],$aDatasetFile['name'],false);
    $aVariables['appver']   = $aDatabase['versionSchema'];
    $aVariables['schema']   = $aDatabase['versionApp'];
    $aVariables['exclude']  = $_POST['exclude'];
    $aVariables['output']   = SCENARIOS_DATASETS.$aDatasetFile['name'].'.xml';
    $aResults = $oIntegrity->dumpData($aVariables);
//    $aResults = $oIntegrity->dumpData($aDatabase['versionSchema'],$aDatabase['versionApp'], $_POST['exclude'],SCENARIOS_DATASETS.$aDatasetFile['name'].'.xml');
    if (PEAR::isError($aResults))
    {
        $aMessages[] = $aResults->getUserInfo();
    }
    $aDatasetFile = $oIntegrity->getSchemaFileInfo(SCENARIOS_DATASETS,$scenario);
    $aMessages = getUpgradeStatus($aDatasetFile['name']);
    $aMessages = array_merge($aMessages, $aResults);
}
else if (array_key_exists('btn_action_run', $_REQUEST))
{
    // simulation fakes an arrival installation in case target system has them installed
    // maintenance will detect that arrivals are installed and attempt plugin maintenance
    // tables are created in the common.sql
    // faking the conf vars here
    $GLOBALS['_MAX']['CONF']['table']['data_raw_ad_arrival']='data_raw_ad_arrival';
    $GLOBALS['_MAX']['CONF']['table']['data_intermediate_ad_arrival']='data_intermediate_ad_arrival';
    $GLOBALS['_MAX']['CONF']['table']['data_summary_ad_arrival_hourly']='data_summary_ad_arrival_hourly';

    $start = microtime();

    // Set longer time out
    if (!ini_get('safe_mode'))
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        @set_time_limit($conf['maintenance']['timeLimitScripts']);
    }

    //$file = $_GET['file'];
    //$dir  = $_GET['dir'];

    $simClass = $scenario; //basename($scenario, '.php');
    require_once SCENARIOS.'/'.$scenario.'.php';
    $obj = new $simClass();
    $obj->profileOn = false; //$conf['simdb']['profile'];
    $obj->run();

    $execSecs = get_execution_time($start);
    include SIM_TEMPLATES.'/execution_time.html';
}
else if (array_key_exists('submit', $_REQUEST))
{
    include 'templates/frameheader.html';
    include 'templates/initial.html';
    exit;
}

include 'templates/body_action.html';


?>
