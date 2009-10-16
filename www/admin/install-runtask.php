<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: mergeCopyTarget55223.tmp 43400 2009-09-18 09:47:45Z lukasz.wikierski $
*/

global $installing;
$installing = true;

require_once '../../init.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Login.php';
require_once MAX_PATH.'/lib/OX/Upgrade/Util/Job.php';

// No upgrade file? No installer!
if (!file_exists(MAX_PATH.'/var/UPGRADE')) {
    header("Location: index.php");
    exit;
}

$aErrors = array();
$result = array('name'=>@$_REQUEST['task'],'status'=>'Invalid Request','errors'=>&$aErrors, 'type' => 'task');
if (OA_Upgrade_Login::checkLogin(false))
{
    if (validRequest($result))
    {
        $oUpgrader = new OA_Upgrade();
        $aResponse = $oUpgrader->runPostUpgradeTask($_REQUEST['task']);
        $result['errors']  = $aResponse['errors'];
        if (count($result['errors'])>0) {
            $result['status'] = 'Failed';
        } else {
            $result['status'] = 'OK';
        }
    }
} else {
    OX_Upgrade_Util_Job::logError($result, 'Permissions error');
    $result['status'] = 'Permissions error';
}

// Save job results in session
OX_Upgrade_Util_Job::saveJobResult($result);


require_once MAX_PATH.'/lib/JSON/JSON.php';
$json = new Services_JSON();
$output = $json->encode($result);
header ("Content-Type: text/javascript");
echo $output;

function validRequest(&$result)
{
    if ((!isset($_REQUEST['task'])))
    {
        OX_Upgrade_Util_Job::logError($result, 'Bad arguments');
        return false;
    }
    $task = str_replace("\0", '', $_REQUEST['task']);
    if ($task != $_REQUEST['task'] || stristr($task, '../') || stristr($task, '..\\')) {
        OX_Upgrade_Util_Job::logError($result, 'Invalid task name');
        return false;
    }
    $result['name'] = $_REQUEST['task'];
    
    return OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $result);
}

?>
