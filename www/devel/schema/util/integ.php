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
 * integrity check utility
 */

require_once '../../../../init.php';
define('MAX_DEV', MAX_PATH.'/www/devel');

require_once MAX_PATH.'/lib/OA/Upgrade/DB_Integrity.php';

if (array_key_exists('xajax', $_POST))
{
}
require_once MAX_PATH.'/www/devel/lib/xajax.inc.php';

$oIntegrity = new OA_DB_Integrity();
$aAppInfo = $oIntegrity->getVersion();

if (array_key_exists('btn_integ_check', $_POST))
{
    $version = $_POST['version'];
    if ($oIntegrity->init($version))
    {
        $oIntegrity->checkIntegrity();
        $aTasksConstructive = $oIntegrity->aTasksConstructiveAll;
        $aTasksDestructive  = $oIntegrity->aTasksDestructiveAll;
        $aMessages          = $oIntegrity->getMessages();
        $file_schema        = $oIntegrity->getFileSchema();
        $file_changes       = $oIntegrity->getFileChanges();
    }
}
else if (array_key_exists('btn_integ_exec', $_POST))
{
    $version = $_POST['changes_version'];
    if ($oIntegrity->init($version))
    {
        $oIntegrity->aTasksConstructiveSelected = (isset($_POST['constructive']) ? $_POST['constructive'] : array());
        $oIntegrity->aTasksDestructiveSelected  = (isset($_POST['destructive']) ? $_POST['destructive'] : array());
        $oIntegrity->compileExecuteTasklist('prune', 'execute');
    }
    if ($oIntegrity->init($version))
    {
        $oIntegrity->checkIntegrity();
        $aTasksConstructive = $oIntegrity->aTasksConstructiveAll;
        $aTasksDestructive  = $oIntegrity->aTasksDestructiveAll;
        $aMessages          = $oIntegrity->getMessages();
        $file_schema        = $oIntegrity->getFileSchema();
        $file_changes       = $oIntegrity->getFileChanges();
    }
}
else if (array_key_exists('btn_data_dump', $_POST))
{
    $oIntegrity->init($aAppInfo['versionSchema']);
    $aMessages = $oIntegrity->dumpData($aAppInfo['versionSchema'],$aAppInfo['versionApp'], $_POST['exclude']);
    if (PEAR::isError($aMessages))
    {
        $aMessages[] = $aMessages->getUserInfo();
    }
}
else if (array_key_exists('btn_data_load_dryrun', $_POST))
{
    $aMessages = $oIntegrity->loadData($_POST['datafile'],true);
    if (PEAR::isError($aMessages))
    {
        $aMessages[] = $aMessages->getUserInfo();
    }
}
else if (array_key_exists('btn_data_load', $_POST))
{
    $aMessages = $oIntegrity->loadData($_POST['datafile']);
    if (PEAR::isError($aMessages))
    {
        $aMessages[] = $aMessages->getUserInfo();
    }
}
include 'tpl/integ.html';


?>


