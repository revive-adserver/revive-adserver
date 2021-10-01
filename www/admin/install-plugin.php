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
        if ($_REQUEST['status'] === '0') {
            $result = installPlugin($_REQUEST['plugin']);
        } elseif ($_REQUEST['status'] === '1') {
            $result = checkPlugin($_REQUEST['plugin']);
        } elseif ($_REQUEST['status'] === '2') {
            $result = removePlugin($_REQUEST['plugin']);
        }
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

/**
 * @return array|false
 */
function getPlugin(string $pluginName, bool $defaultOnly = false)
{
    $aDefaultPlugins = [];
    include MAX_PATH . '/etc/default_plugins.php';

    if ($aDefaultPlugins) {
        foreach ($aDefaultPlugins as $idx => $aPlugin) {
            if ($pluginName == $aPlugin['name']) {
                return $aPlugin;
            }
        }
    }

    if ($defaultOnly) {
        return false;
    }

    return ['path' => MAX_PATH . '/etc/plugins/', 'name' => $pluginName, 'ext' => 'zip', 'disabled' => true];
}

/**
 * A function to install any plugins found that are NEW for the upgrade.
 *
 * @param string $pluginName The name of the plugin to install.
 * @return array An array of the 'name', 'status' and any 'errors' as an array.
 */
function installPlugin($pluginName)
{
    $aErrors = [];
    $aResult = [
        'name' => $pluginName,
        'status' => '',
        'errors' => &$aErrors
    ];
    // make sure this is a legitimate bundled plugin request
    if ($aPlugin = getPlugin($pluginName)) {
        require_once RV_PATH . '/lib/RV.php';
        require_once MAX_PATH . '/lib/OA.php';
        require_once LIB_PATH . '/Plugin/PluginManager.php';
        $oPluginManager = new OX_PluginManager();
        if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins'])) {
            $filename = $aPlugin['name'] . '.' . $aPlugin['ext'];
            $filepath = $aPlugin['path'] . $filename;
            // TODO: refactor for remote paths?
            $oPluginManager->installPackage(['tmp_name' => $filepath, 'name' => $filename]);
            if ($oPluginManager->countErrors()) {
                $aResult['status'] = '<br />Failed';
                foreach ($oPluginManager->aErrors as $errmsg) {
                    OX_Upgrade_Util_Job::logError($aResult, $errmsg);
                }
            } else {
                $aResult['status'] = '<br />OK';
            }
        } else {
            $aResult['status'] = '<br />Already Installed';
            OX_Upgrade_Util_Job::logError($aResult, 'Could not be installed because previous installation (whole or partial) was found');
        }
        unset($oPluginManager);
    //OA::logMem('stop deliveryLog/installPlugin');
    } else {
        $aResult['status'] = '<br />Invalid';
        OX_Upgrade_Util_Job::logError($aResult, 'Not a valid default plugin');
    }
    return $aResult;
}

/**
 * A function to install any plugins found that were found in the previous
 * installation before upgrade, either by installing from the original plugin
 * package, or by migrating the code over from the previous installation.
 *
 * @param string $pluginName The name of the plugin to install.
 * @return array An array of the 'name', 'status' and any 'errors' as an array.
 */
function checkPlugin($pluginName)
{
    $aErrors = [];
    $aResult = [
        'name' => $pluginName,
        'status' => '',
        'errors' => &$aErrors
    ];
    require_once LIB_PATH . '/Plugin/PluginManager.php';
    $oPluginManager = new OX_PluginManager();
    // if plugin definition is not found in situ
    // try to import plugin code from the previous installation
    if (!file_exists(MAX_PATH . $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] . $pluginName . '.xml')) {
        if (isset($GLOBALS['_MAX']['CONF']['pluginPaths']['export'])) {
            $file = $GLOBALS['_MAX']['CONF']['pluginPaths']['export'] . $pluginName . '.zip';
            if (file_exists($file)) {
                $aFile['name'] = $file;
                $aFile['tmp_name'] = $file;
                OX_Upgrade_Util_Job::logError($aResult, 'Exported plugin file found, attempting to import from ' . $file);
                if (!$oPluginManager->installPackageCodeOnly($aFile)) {
                    if ($oPluginManager->countErrors()) {
                        $aResult['status'] = '<br />Failed';
                        foreach ($oPluginManager->aErrors as $errmsg) {
                            OX_Upgrade_Util_Job::logError($aResult, $errmsg);
                        }
                    }
                } else {
                    $aResult['status'] = '<br />OK';
                }
            }
        }
    }

    $upgraded = false;
    if ($aPlugin = getPlugin($pluginName, true)) {
        $oPluginManager = new OX_PluginManager();
        $aFileName['name'] = $aPlugin['name'] . '.' . $aPlugin['ext'];
        $aFileName['tmp_name'] = $aPlugin['path'] . $aPlugin['name'] . '.' . $aPlugin['ext'];
        $aFileName['type'] = 'application/zip';
        $upgraded = $oPluginManager->upgradePackage($aFileName, $pluginName);
        if (!empty($oPluginManager->aErrors) && !empty($oPluginManager->previousVersionInstalled) &&
                  $oPluginManager->previousVersionInstalled != OX_PLUGIN_SAME_VERSION_INSTALLED) {
            foreach ($oPluginManager->aErrors as $i => $msg) {
                OX_Upgrade_Util_Job::logError($aResult, $msg);
            }
        }
    }

    // now diagnose problems
    $aDiag = $oPluginManager->getPackageDiagnostics($pluginName);
    if ($aDiag['plugin']['error']) {
        $aErrors[] = 'Problems found with plugin ' . $pluginName . '.  The plugin has been disabled.  Go to the Configuration Plugins page for details ';
        foreach ($aDiag['plugin']['errors'] as $i => $msg) {
            OX_Upgrade_Util_Job::logError($aResult, $msg);
        }
    }
    foreach ($aDiag['groups'] as $idx => &$aGroup) {
        if ($aGroup['error']) {
            $aDiag['plugin']['error'] = true;
            OX_Upgrade_Util_Job::logError($aResult, 'Problems found with components in group ' . $aGroup['name'] . '.  The ' . $pluginName . ' plugin has been disabled.  Go to the Configuration->Plugins page for details ');
            foreach ($aGroup['errors'] as $i => $msg) {
                OX_Upgrade_Util_Job::logError($aResult, $msg);
            }
        }
    }
    $enabled = wasPluginEnabled($pluginName); // original setting
    if (!$aDiag['plugin']['error']) {
        if ($upgraded) {
            $aResult['status'] .= '<br />OK; Upgraded';
        } elseif ($oPluginManager->previousVersionInstalled == OX_PLUGIN_NEWER_VERSION_INSTALLED) {
            $aResult['status'] .= '<br />OK; Notice: You have a newer plugin version installed than the one that comes with this upgrade package';
        } elseif ($oPluginManager->previousVersionInstalled == OX_PLUGIN_SAME_VERSION_INSTALLED) {
            $aResult['status'] .= '<br />OK; Up to date';
        } else {
            $aResult['status'] .= '<br />OK';
        }
        if ($enabled) {
            if ($oPluginManager->enablePackage($pluginName)) {
                $aResult['status'] .= '; Enabled';
            } else {
                $aResult['status'] .= '; Failed to enable, check plugin configuration';
            }
        } else {
            $aResult['status'] .= '; Disabled';
        }
    } else {
        $aResult['status'] = '<br />Errors; Disabled';
    }
    return $aResult;
}

/**
 * A function to remove the configiration setup for any plugins that were found
 * in the previous installation before upgrade, but which have been marked as
 * deprecated plugins.
 *
 * @param string $pluginName The name of the plugin to remove.
 * @return array An array of the 'name', 'status' and any 'errors' as an array.
 */
function removePlugin($pluginName)
{
    $aErrors = [];
    $aResult = [
        'name' => $pluginName,
        'status' => '',
        'errors' => &$aErrors
    ];
    if (array_key_exists($pluginName, $GLOBALS['_MAX']['CONF']['plugins'])) {
        require_once RV_PATH . '/lib/RV.php';
        require_once MAX_PATH . '/lib/OA.php';
        require_once LIB_PATH . '/Plugin/PluginManager.php';
        $oPluginManager = new OX_PluginManager();
        $result = $oPluginManager->uninstallPackage($pluginName, true);
        if ($result) {
            $aResult['status'] = '<br />Uninstalled';
        } else {
            $aResult['status'] = '<br />Error';
            $aErrors[] = 'Problems found with plugin ' . $pluginName .
                     '. The plugin was found in the previous installation' .
                     ' and has been marked as deprecated, but was unable to' .
                     ' be removed. Please go to the Configuration Plugins page' .
                     ' and remove it.';
        }
    } else {
        $aResult['status'] = '<br />OK; Not installed';
        $aErrors[] = 'Problems found with plugin ' . $pluginName .
                     '. The plugin was found in the previous installation' .
                     ' and has been marked as deprecated, but was then not' .
                     ' found as being installed when attempting to remove it.' .
                     ' Please go to the Configuration Plugins page to ensure' .
                     ' it is not installed.';
    }
    return $aResult;
}

/**
 * The upgrader will have disabled all plugins when it started upgrading
 * it should have dropped a file with a record of the orginal settings,
 * read this file and then reconstruct settings array.
 *
 * @param string $pluginName
 * @return boolean
 */
function wasPluginEnabled($pluginName)
{
    $file = MAX_PATH . '/var/plugins/recover/enabled.log';
    if (file_exists($file)) {
        $aContent = explode(';', file_get_contents($file));
        $aResult = [];
        foreach ($aContent as $k => $v) {
            if (trim($v)) {
                $aLine = explode('=', trim($v));
                if (is_array($aLine) && (count($aLine) == 2) && (is_numeric($aLine[1]))) {
                    $aResult[$aLine[0]] = $aLine[1];
                }
            }
        }
        if (array_key_exists($pluginName, $aResult)) {
            return $aResult[$pluginName];
        }
    }
    return false;
}

function validRequest(&$result)
{
    if ((!isset($_REQUEST['plugin'])) || (!isset($_REQUEST['status']))) {
        OX_Upgrade_Util_Job::logError($result, 'Bad arguments');
        return false;
    }
    $result['name'] = $_REQUEST['plugin'];

    return OX_Upgrade_Util_Job::isInstallerStepCompleted('database', $result);
}
