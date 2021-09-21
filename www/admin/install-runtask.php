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
 * A stand-alone fine to handle running of tasks during upgrades.
 *
 */

global $installing;
$installing = true;

require_once '../../init.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Login.php';
require_once MAX_PATH . '/lib/OX/Upgrade/Util/Job.php';

// No upgrade file? No installer!
if (!file_exists(MAX_PATH . '/var/UPGRADE')) {
    header("Location: index.php");
    exit;
}

// Some post-upgrade tasks could take a long time!
@set_time_limit(0);

$aErrors = [];
$result = ['name' => @$_REQUEST['task'], 'status' => 'Invalid Request', 'errors' => &$aErrors, 'type' => 'task'];
if (OA_Upgrade_Login::checkLogin(false)) {
    if (validRequest($result)) {
        $oUpgrader = new OA_Upgrade();
        $aResponse = $oUpgrader->runPostUpgradeTask($_REQUEST['task']);
        $result['errors'] = $aResponse['errors'];
        if (count($result['errors']) > 0) {
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


require_once MAX_PATH . '/lib/JSON/JSON.php';
$json = new Services_JSON();
$output = $json->encode($result);
header("Content-Type: text/javascript");
echo $output;

function validRequest(&$result)
{
    if ((!isset($_REQUEST['task']))) {
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
