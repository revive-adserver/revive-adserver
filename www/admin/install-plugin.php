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
 * A stand-alone fine to handle migrating plugins during upgrades.
 *
 */

global $installing;
$installing = true;

require_once '../../init.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Login.php';
require_once MAX_PATH . '/lib/OX/Upgrade/Util/Job.php';

use RV\Upgrade\PluginInstaller;

// No upgrade file? No installer!
if (!file_exists(MAX_PATH . '/var/UPGRADE')) {
    header("Location: index.php");
    exit;
}

$aErrors = [];
$result = [
    'name' => @$_REQUEST['plugin'],
    'status' => '<br />Invalid Request',
    'errors' => &$aErrors
];

if (OA_Upgrade_Login::checkLogin(false)) {
    // Hack! - Plugins pre 2.7.31 may require [pluginpaths][extensions] to be set
    $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] = $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'];
    $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] . 'etc/';

    if (validRequest($result)) {
        $oPluginInstaller = new PluginInstaller();
        $result = $oPluginInstaller($_REQUEST['plugin'], $_REQUEST['status']);
    }

    // Undo hack
    unset($GLOBALS['_MAX']['CONF']['pluginPaths']['extensions']);
    $oSettings = new OA_Admin_Settings();
    $oSettings->writeConfigChange();
} else {
    OX_Upgrade_Util_Job::logError($result, 'Permissions error');
    $result['status'] = '<br />Permissions error';
}
$result['type'] = 'plugin';
// Save job results in session
OX_Upgrade_Util_Job::saveJobResult($result);

require_once MAX_PATH . '/lib/JSON/JSON.php';
$json = new Services_JSON();
$output = $json->encode($result);
header("Content-Type: text/javascript");
echo $output;

function validRequest(&$result)
{
    if ((!isset($_REQUEST['plugin'])) || (!isset($_REQUEST['status']))) {
        OX_Upgrade_Util_Job::logError($result, 'Bad arguments');
        return false;
    }
    $result['name'] = $_REQUEST['plugin'];

    return OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $result);
}
