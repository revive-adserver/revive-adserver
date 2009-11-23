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
$Id$
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
$result = array('name'=>@$_REQUEST['plugin'],'status'=>'Invalid Request','errors'=>&$aErrors);
if (OA_Upgrade_Login::checkLogin(false))
{
    // Hack! - Plugins pre 2.7.31 may require [pluginpaths][extensions] to be set
    $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] = $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'];
    $GLOBALS['_MAX']['CONF']['pluginPaths']['packages']   = $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] . 'etc/';

    if (validRequest($result))
    {
        if ($_REQUEST['status']==='0')
        {
            $result = installPlugin($_REQUEST['plugin']);
        }
        else if ($_REQUEST['status']==='1')
        {
            $result = checkPlugin($_REQUEST['plugin']);
        }
    }

    // Undo hack
    unset($GLOBALS['_MAX']['CONF']['pluginPaths']['extensions']);
    $oSettings = new OA_Admin_Settings();
    $oSettings->writeConfigChange();
} else {
    OX_Upgrade_Util_Job::logError($result, 'Permissions error');
    $result['status'] = 'Permissions error';
}
$result['type'] = 'plugin';
// Save job results in session
OX_Upgrade_Util_Job::saveJobResult($result);

require_once MAX_PATH.'/lib/JSON/JSON.php';
$json = new Services_JSON();
$output = $json->encode($result);
header ("Content-Type: text/javascript");
echo $output;

function getPlugin($pluginName)
{
    include MAX_PATH.'/etc/default_plugins.php';
    if ($aDefaultPlugins) {
        foreach ($aDefaultPlugins AS $idx => $aPlugin) {
            if ($pluginName == $aPlugin['name']) {
                return $aPlugin;
            }
        }
    }
    return array('path'=>MAX_PATH.'/etc/plugins/', 'name'=>$pluginName, 'ext'=>'zip', 'disabled' => true);
}

function installPlugin($pluginName)
{
    $aErrors = array();
    $aResult = array('name'=>$pluginName,'status'=>'','errors'=>&$aErrors);
    // make sure this is a legitimate bundled plugin request
    if ($aPlugin = getPlugin($pluginName)) {
        require_once MAX_PATH.'/lib/OA.php';
        //OA::logMem('start deliveryLog/installPlugin');
        require_once LIB_PATH.'/Plugin/PluginManager.php';
        $oPluginManager = new OX_PluginManager();
        if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins'])) {
            $filename = $aPlugin['name'].'.'.$aPlugin['ext'];
            $filepath = $aPlugin['path'].$filename;
            // TODO: refactor for remote paths?
            $oPluginManager->installPackage(array('tmp_name'=>$filepath, 'name'=>$filename));
            if ($oPluginManager->countErrors()) {
                $aResult['status'] = 'Failed';
                foreach ($oPluginManager->aErrors as $errmsg) {
                    OX_Upgrade_Util_Job::logError($aResult, $errmsg);
                }
            } else {
                $aResult['status'] = 'OK';
            }
        } else {
            $aResult['status'] = 'Already Installed';
            OX_Upgrade_Util_Job::logError($aResult, 'Could not be installed because previous installation (whole or partial) was found');
        }
        unset($oPluginManager);
        //OA::logMem('stop deliveryLog/installPlugin');
    } else {
        $aResult['status'] = 'Invalid';
        OX_Upgrade_Util_Job::logError($aResult, 'Not a valid default plugin');
    }
    return $aResult;
}

function checkPlugin($pluginName)
{
    $aErrors = array();
    $aResult = array('name'=>$pluginName,'status'=>'','errors'=>&$aErrors);
    require_once LIB_PATH.'/Plugin/PluginManager.php';
    $oPluginManager = new OX_PluginManager();
    // if plugin definition is not found in situ
    // try to import plugin code from the previous installation
    if (!file_exists(MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$pluginName.'.xml')) {
        if (isset($GLOBALS['_MAX']['CONF']['pluginPaths']['export'])) {
            $file = $GLOBALS['_MAX']['CONF']['pluginPaths']['export'].$pluginName.'.zip';
            if (file_exists($file)) {
                $aFile['name'] = $file;
                $aFile['tmp_name'] = $file;
                OX_Upgrade_Util_Job::logError($aResult, 'Exported plugin file found, attempting to import from '.$file);
                if (!$oPluginManager->installPackageCodeOnly($aFile)) {
                    if ($oPluginManager->countErrors()) {
                        $aResult['status'] = 'Failed';
                        foreach ($oPluginManager->aErrors as $errmsg) {
                            OX_Upgrade_Util_Job::logError($aResult, $errmsg);
                        }
                    }
                } else {
                    $aResult['status'] = 'OK';
                }
            }
        }
    }
    // Try to upgrade bundled plugins
    include_once(MAX_PATH.'/etc/default_plugins.php');
    if ($aDefaultPlugins) {
        foreach ($aDefaultPlugins AS $idx => $aPlugin) {
            if ($aPlugin['name'] == $pluginName) {
                $upgraded = false;
                $oPluginManager = new OX_PluginManager();
                $aFileName['name'] = $aPlugin['name'].'.'.$aPlugin['ext'];
                $aFileName['tmp_name'] = $aPlugin['path'].$aPlugin['name'].'.'.$aPlugin['ext'];
                $aFileName['type'] = 'application/zip';
                $upgraded = $oPluginManager->upgradePackage($aFileName, $pluginName);
                if(!empty($oPluginManager->aErrors) && !empty($oPluginManager->previousVersionInstalled) &&
                          $oPluginManager->previousVersionInstalled != OX_PLUGIN_SAME_VERSION_INSTALLED) {
                    foreach ($oPluginManager->aErrors as $i => $msg) {
                        OX_Upgrade_Util_Job::logError($aResult, $msg);
                    }
                }
            }
        }
    }

    // now diagnose problems
    $aDiag = $oPluginManager->getPackageDiagnostics($pluginName);
    if ($aDiag['plugin']['error']) {
        $aErrors[] = 'Problems found with plugin '.$pluginName.'.  The plugin has been disabled.  Go to the Configuration Plugins page for details ';
        foreach ($aDiag['plugin']['errors'] as $i => $msg) {
            OX_Upgrade_Util_Job::logError($aResult, $msg);
        }
    }
    foreach ($aDiag['groups'] as $idx => &$aGroup) {
        if ($aGroup['error']) {
            $aDiag['plugin']['error'] = true;
            OX_Upgrade_Util_Job::logError($aResult, 'Problems found with components in group '.$aGroup['name'].'.  The '.$pluginName.' plugin has been disabled.  Go to the Configuration->Plugins page for details ');
            foreach ($aGroup['errors'] as $i => $msg) {
                OX_Upgrade_Util_Job::logError($aResult, $msg);
            }
        }
    }
    $enabled = wasPluginEnabled($pluginName); // original setting
    if (!$aDiag['plugin']['error'])
    {
        if ($upgraded) {
            $aResult['status'].= 'OK, Upgraded';
        } elseif ($oPluginManager->previousVersionInstalled == OX_PLUGIN_NEWER_VERSION_INSTALLED) {
            $aResult['status'].= 'OK. Notice: You have a newer plugin version installed than the one that comes with this upgrade package.';
        } elseif ($oPluginManager->previousVersionInstalled == OX_PLUGIN_SAME_VERSION_INSTALLED) {
            $aResult['status'].= 'OK, Up to date';
        } else {
            $aResult['status'].= 'OK';
        }
        if ($enabled) {
            if ($oPluginManager->enablePackage($pluginName)) {
                $aResult['status'].= ', Enabled';
            } else {
                $aResult['status'].= ', failed to enable, check plugin configuration';
            }
        } else {
            $aResult['status'].= ', Disabled';
        }
    } else {
        $aResult['status'] = 'Errors, disabled';
    }
    return $aResult;
}
/**
 * the upgrader will have disabled all plugins when it started upgrading
 * it should have dropped a file with a record of the orginal settings
 * read this file and then reconstruct settings array
 *
 * @param string $pluginName
 * @return boolean
 */
function wasPluginEnabled($pluginName)
{
    $file = MAX_PATH.'/var/plugins/recover/enabled.log';
    if (file_exists($file)) {
        $aContent = explode(';', file_get_contents($file));
        $aResult = array();
        foreach ($aContent as $k => $v) {
            if (trim($v)) {
                $aLine = explode('=', trim($v));
                if (is_array($aLine) && (count($aLine)==2) && (is_numeric($aLine[1]))) {
                    $aResult[$aLine[0]] = $aLine[1];
                }
            }
        }
        return array_key_exists($pluginName,$aResult);
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

?>
