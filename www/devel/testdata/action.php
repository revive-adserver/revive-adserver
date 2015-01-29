<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 *
 * @package    Max
 * @subpackage SimulationSuite
 */

require_once '../../../init.php';
require_once 'tdconst.php';

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
        $aMessages[] = 'Your database has successfully been upgraded to version '.VERSION;
    }
    else
    {
        $aMessages[] = 'Your database has NOT been upgraded to version '.VERSION;
    }
    return $aMessages;
}

if (array_key_exists('btn_data_drop', $_POST))
{
    OA_DB::dropDatabase($_POST['dbname']);
}

$oIntegrity = new OA_DB_Integrity();
$GLOBALS['_MAX']['CONF']['table']['prefix'] = '';
$datasetfile = $_REQUEST['datasetfile'];
$aDatasetFile = $oIntegrity->getSchemaFileInfo(TD_DATAPATH,$datasetfile);
if (array_key_exists('error',$aDatasetFile))
{
    $aMessages[] = $aDatasetFile['error'];
}
else
{
    $oIntegrity->version = $aDatasetFile['version'];
    $oUpgrader = new OA_Upgrade();
    $aMessages = getUpgradeStatus($aDatasetFile['name']);
}

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
    $aVariables['datafile'] = $datasetfile.'.xml';
    $aVariables['directory'] = TD_DATAPATH;
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
    $aVariables['appver']   = $aDatabase['versionApp'];
    $aVariables['schema']   = $aDatabase['versionSchema'];
    $aVariables['exclude']  = $_POST['exclude'];
    $aVariables['output']   = TD_DATAPATH.$aDatasetFile['name'].'.xml';
    $aResults = $oIntegrity->dumpData($aVariables);
    if (PEAR::isError($aResults))
    {
        $aMessages[] = $aResults->getUserInfo();
    }
    $aDatasetFile = $oIntegrity->getSchemaFileInfo(TD_DATAPATH,$datasetfile);
    $aMessages = getUpgradeStatus($aDatasetFile['name']);
    $aMessages = array_merge($aMessages, $aResults);
}
include 'templates/body_action.html';


?>
