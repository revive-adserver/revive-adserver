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
/**
 * A script to upgrade plugins for rpm install
 *
 * @package    OpenXScripts
 * @subpackage Tools
 * @author     Lun Li <lun.li@openx.org>
 */

define('PLUGIN_UPGRADE_ERROR_EXIT',                -5);
define('PLUGIN_UPGRADE_ERROR_RECOVER',             -3);
define('PLUGIN_UPGRADE_CONTINUE',                   0);
define('PLUGIN_UPGRADE_FINISH',                     5);

global $installing;
$installing = true;

//error_reporting(E_ERROR);
error_reporting(E_ALL);

// Set the current path
$path = dirname(__FILE__);
require_once $path . '/../../init.php';

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH.'/lib/OA/Upgrade/Login.php';
// required files for header & nav
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradePluginImport.php';


// Setup oUpgrader
$oUpgrader = new OA_Upgrade();
@set_time_limit(600);
//  load translations for installer
Language_Loader::load('installer');
$options = new OA_Admin_Option('settings');
// clear the $session variable to prevent users pretending to be logged in.
unset($session);
define('phpAds_installing',     true);
// changed form name for javascript dependent fields
$GLOBALS['settings_formName'] = "frmOpenads";
$imgPath = OX::assetPath() . "/";
$installStatus = 'unknown';

echo "start...\n";
////// start of the db upgrade process ////////
//TODO: logical needs to be rechecked ////////

if (!setupPluginUpgrade())
{
    echo "Error happens at setupPluginUpgrade\n";
    exit;
}

// Install individual plugin 
if (count($argv) >= 3) {
    $pluginName = $argv[2];
    if (count($argv) > 3) {
       $disabled = $argv[3];
       if (strcmp($disabled, "disabled")==0 ) {
           echo "Install Plugin $pluginName as disabled\n";
           installPlugin($pluginName, 1);
           exit;
       }
    }
    echo "Install Plugin $pluginName as enabled\n";
    installPlugin($pluginName, 0);
    exit;
}


// Install bulk plugins from default plugins
$result = pluginUpgradePlugins($oUpgrader);
if ($result['action'] == PLUGIN_UPGRADE_ERROR_EXIT || $result['action'] == PLUGIN_UPGRADE_FINISH) {
    echo "exit at plugin upgrade plugins\n";
    echo $result['message'] . "\n";
    exit;
}
echo "After plugin upgrade plugins : " . $result['message'] . "\n";

$result = pluginUpgradePost($oUpgrader);
if ($result['action'] == PLUGIN_UPGRADE_ERROR_EXIT || $result['action'] == PLUGIN_UPGRADE_FINISH) {
    echo "exit at plugin upgrade post\n";
    echo $result['message'] . "\n";
    exit;
}
echo "After plugin upgrade post : " . $result['message'] . "\n";
/*
$result = pluginUpgradeFinish($oUpgrader);
if ($result['action'] == PLUGIN_UPGRADE_ERROR_EXIT || $result['action'] == PLUGIN_UPGRADE_FINISH) {
    echo "Finish\n";
    echo $result['message'] . "\n";
    exit;
}
echo "After plugin upgrade Finish : " . $result['message'] . "\n";
*/




function getPreviousPath($oUpgrader) 
{

    $aConfig = $oUpgrader->getConfig();
    $prevPathRequired = false;
    $prevPath = '';
    if (!empty($GLOBALS['_MAX']['CONF']['plugins'])) {
        $oPluginImporter = new OX_UpgradePluginImport();
        if (!$oPluginImporter->verifyAll($GLOBALS['_MAX']['CONF']['plugins'])) {
            $prevPathRequired = true;
            // See if we can figure out the previous path
            if (!empty($GLOBALS['_MAX']['CONF']['store']['webDir'])){
                $possPath = dirname(dirname($GLOBALS['_MAX']['CONF']['store']['webDir']));
                $oPluginVerifier = new OX_UpgradePluginImport();
                $oPluginVerifier->basePath = $possPath;
                $oPluginVerifier->destPath = $possPath;
                if ($oPluginVerifier->verifyAll($GLOBALS['_MAX']['CONF']['plugins'], false)) {
                    $prevPath = $possPath;
                }
            }
        }
    }
    return $prevPath;
}


/*
function pluginAdminsetup($oUpgrader)
{
        // Acquire the sync settings from session in order to add them
        //no need adminset up for update, all we need is $aConfig
        //For auto install, we need put config into a config file
        session_start();
        $syncEnabled = !empty($_SESSION['checkForUpdates']);

        // Store the detected timezone of the system, whatever that is
        require_once('../../lib/OX/Admin/Timezones.php');
        $timezone['timezone'] = OX_Admin_Timezones::getTimezone();

        if ($oUpgrader->saveConfig($_POST['aConfig']) && $oUpgrader->putSyncSettings($syncEnabled) && $oUpgrader->putTimezoneAccountPreference($aTimezone, true))
        {
            if (!checkFolderPermissions($_POST['aConfig']['store']['webDir'])) {
                $aConfig                    = $_POST['aConfig'];
                $aConfig['store']['webDir'] = stripslashes($aConfig['store']['webDir']);
                $errMessage                 = $strImageDirLockedDetected;
                $action                     = OA_UPGRADE_CONFIGSETUP;
            } else {
                if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL)
                {
                    $action = OA_UPGRADE_ADMINSETUP;
                }
                else
                {
                    $message = $strUpgradeComplete;
                    $action = OA_UPGRADE_PLUGINS;
                }
            }
        }
        else
        {
            $aConfig    = $_POST['aConfig'];
            if ($_COOKIE['oat'] == OA_UPGRADE_INSTALL) {
                $errMessage = $strUnableCreateConfFile;
            } else {
                $errMessage = $strUnableUpdateConfFile;
            }
            $action     = OA_UPGRADE_CONFIGSETUP;
        }
}
*/

function pluginUpgradePlugins($oUpgrader) 
{

        $importErrors = false;
        // Import any plugins present from the previous install
        $previousPath = getPreviousPath($oUpgrader);
        $action = PLUGIN_UPGRADE_ERROR_EXIT;
        $message = '';
        //may not be need here, should be in the core upgrade
        if ($previousPath != MAX_PATH) {
            // Prevent directory traversal and other nasty tricks:
            $path = rtrim(str_replace("\0", '', $previousPath), '\\/');
            if (!stristr($path, '../') && !stristr($path, '..\\')) {
                $oPluginImporter = new OX_UpgradePluginImport();
                $oPluginImporter->basePath = $path;
                if ($oPluginImporter->verifyAll($GLOBALS['_MAX']['CONF']['plugins'], false)) {
                    // For each plugin that's claimed to be installed... (ex|im)port it into the new codebase
                    foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $plugin => $enabled) {
                        $oPluginImporter->import($plugin);
                    }
                    // Plugins may also have placed files in the MAX_PATH . /var/plugins folder,
                    // but these files aren't declared in the XML, for now, copy all files in there up
                    $DO_DIR = opendir($path . '/var/plugins/DataObjects/');
                    while ($file = readdir($DO_DIR)) {
                        if (!is_file($path . '/var/plugins/DataObjects/' . $file)) {
                            continue;
                        }
                        @copy($path . '/var/plugins/DataObjects/' . $file, MAX_PATH . '/var/plugins/DataObjects/' . $file);
                    }
                } else {
                    $importErrors = true;
                    $message = "got import Errors\n";
                }
            }
        }

        if (!$importErrors) {
            $result = array();
            echo "No importErrors\n";
            // Use current url as base path for calling install-plugin
//            $baseInstalUrl = 'http'.((isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) ? 's' : '').'://';
//            $baseInstalUrl .= OX_getHostNameWithPort().substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'], '/')+1);

//            if ($_COOKIE['oat'] == OA_UPGRADE_UPGRADE)
//            {
                foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled)
                {
                    //$aUrls[] = array('name' => $name,
                    //    'url' => $baseInstalUrl.'install-plugin.php?status=1&plugin='.$name);
                    echo "checkinging plugin : " . $name ."\n";
                    $result = checkPlugin($name);
                    //$message = implode(" ", $result['error']);
                    //echo "Result: ". $result['status'] .". message: $message\n";
                    echo "Result: ". $result['status'] ."\n";
                }
//            }

            // get the list of bundled plugins, retain order
            include MAX_PATH.'/etc/default_plugins.php';
            if ($aDefaultPlugins)
            {
                foreach ($aDefaultPlugins AS $idx => $aPlugin)
                {
                    if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins']))
                    {
//                        $url = $baseInstalUrl.'install-plugin.php?status=0&plugin='.$aPlugin['name'];
                        // disabled = 0: enabled
                        $disabled=0;
                        if (!empty($aPlugin['disabled'])) {
                            $disabled=1;
                            echo "disable plugin : " . $aPlugin['name'] ."\n";
                        }
//                        $aUrls[] = array('name' => $aPlugin['name'], 'url' => $url);
                        echo "installing plugin : " . $aPlugin['name'] ."\n";
                        $result = installPlugin($aPlugin['name'], $disabled);
                        //$message = implode(" ", $result['error']);
                        //echo "Result: ". $result['status'] .". message: $message\n";
                        echo "Result: ". $result['status'] ."\n";
                    }
                }
            }

//            $json = new Services_JSON();
//            $jsonJobs = $json->encode($aUrls);

            $message = $strPluginsDefault;
            $action = PLUGIN_UPGRADE_CONTINUE;
        } else {
            
            $aConfig = $oUpgrader->getConfig();
            $prevPathRequired = true;
            $errMessage = $strPathToPreviousError;
            $action = PLUGIN_UPGRADE_ERROR_EXIT;
        }
        return array('action'=>$action, 'message'=>$message);
}


function pluginUpgradePost($oUpgrader) 
{
    //undo hack
    //unset($GLOBALS['_MAX']['CONF']['pluginPaths']['extensions']);
    //$oSettings = new OA_Admin_Settings();
    //$oSettings->writeConfigChange();
   
        @unlink(MAX_PATH.'/var/plugins/recover/enabled.log');
        $result = $oUpgrader->executePostUpgradeTasks();
        if (is_array($result))
        {
            $aPostTasks = $result;
        }
        $message = $strPostUpgradeTasks;
        $action = PLUGIN_UPGRADE_CONTINUE;
        return array('action'=>$action, 'message'=>$message);
}

function pluginUpgradeFinish($oUpgrader)
{
    OA_Upgrade_Login::autoLogin();
    $message = '';
    // Execute any components which have registered at the afterLogin hook
    /*
    $aPlugins = OX_Component::getListOfRegisteredComponentsForHook('afterLogin');
    foreach ($aPlugins as $i => $id) {
        if ($obj = OX_Component::factoryByComponentIdentifier($id)) {
            $obj->afterLogin();
        }
    }
    */
    // Delete the cookie
    $oUpgrader->setOpenadsInstalledOn();

    if (!$oUpgrader->removeUpgradeTriggerFile())
    {
        $message.= '. '.$strRemoveUpgradeFile;
        $strInstallSuccess = '<div class="sysinfoerror">'.$strOaUpToDateCantRemove.'</div>'.$strInstallSuccess;
    }
    return array('action'=>PLUGIN_UPGRADE_FINISH, 'message'=>$message);
}


// Undo hack

function setupPluginUpgrade()
{
    $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] = $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'];
    $GLOBALS['_MAX']['CONF']['pluginPaths']['packages']   = $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] . 'etc/';

    if (!checkLogin())
    {
        echo 'Session user not found';
        return false;
    }
    return true;
}

function getPlugin($pluginName)
{
    include MAX_PATH.'/etc/default_plugins.php';
    if ($aDefaultPlugins)
    {
        foreach ($aDefaultPlugins AS $idx => $aPlugin)
        {
            if ($pluginName == $aPlugin['name'])
            {
                return $aPlugin;
            }
        }
    }
    return false;
}

function installPlugin($pluginName,$disabled)
{
    $aErrors = array();
    $aResult = array('name'=>$pluginName,'status'=>'','errors'=>&$aErrors);
    // make sure this is a legitimate bundled plugin request
    if ($aPlugin = getPlugin($pluginName))
    {
        require_once MAX_PATH.'/lib/OA.php';
        //OA::logMem('start deliveryLog/installPlugin');
        $path = dirname(__FILE__);
        require_once $path . '/upgradePluginManager.php';
        $oPluginManager = new Upgrade_PluginManager();
        if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins']))
        {
            $filename = $aPlugin['name'].'.'.$aPlugin['ext'];
            $filepath = $aPlugin['path'].$filename;
            // TODO: refactor for remote paths?
            echo "$filename, path=$filepath \n";
            if (!$oPluginManager->installPackage(array('tmp_name'=>$filepath, 'name'=>$filename), $disabled))
            {
                echo "error happened at install package: $filename\n";
            }
            if ($oPluginManager->countErrors())
            {
                $aResult['status'] = 'Failed';
                foreach ($oPluginManager->aErrors as $errmsg)
                {
                    $aErrors[] = $errmsg;
                }
            }
            else
            {
                $aResult['status'] = 'OK';
            }
        }
        else
        {
            $aResult['status'] = 'Already Installed';
            $aErrors[] = 'Could not be installed because previous installation (whole or partial) was found';
        }
        unset($oPluginManager);
        //OA::logMem('stop deliveryLog/installPlugin');
    }

    else
    {
        $aResult['status'] = 'Invalid';
        $aErrors[] = 'Not a valid default plugin';
    }
    echo "~~~errors~~~". implode("++", $aErros)."\n";
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
    if (!file_exists(MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$pluginName.'.xml'))
    {
        if (isset($GLOBALS['_MAX']['CONF']['pluginPaths']['export']))
        {
            $file = $GLOBALS['_MAX']['CONF']['pluginPaths']['export'].$pluginName.'.zip';
            if (file_exists($file))
            {
                $aFile['name'] = $file;
                $aFile['tmp_name'] = $file;
                $aErrors[] = 'Exported plugin file found, attempting to import from '.$file;
                if (!$oPluginManager->installPackageCodeOnly($aFile))
                {
                    if ($oPluginManager->countErrors())
                    {
                        $aResult['status'] = 'Failed';
                        foreach ($oPluginManager->aErrors as $errmsg)
                        {
                            $aErrors[] = $errmsg;
                        }
                    }
                }
                else
                {
                    $aResult['status'] = 'OK';
                }
            }
        }
    }
    // Try to upgrade bundled plugins
    include_once(MAX_PATH.'/etc/default_plugins.php');
    if ($aDefaultPlugins)
    {
        foreach ($aDefaultPlugins AS $idx => $aPlugin)
        {
            if ($aPlugin['name'] == $pluginName)
            {
                $upgraded = false;
                $oPluginManager = new OX_PluginManager();
                $aFileName['name'] = $aPlugin['name'].'.'.$aPlugin['ext'];
                $aFileName['tmp_name'] = $aPlugin['path'].$aPlugin['name'].'.'.$aPlugin['ext'];
                $aFileName['type'] = 'application/zip';
                $upgraded = $oPluginManager->upgradePackage($aFileName, $pluginName);
                if(!empty($oPluginManager->aErrors) && !empty($oPluginManager->previousVersionInstalled) &&
                          $oPluginManager->previousVersionInstalled != OX_PLUGIN_SAME_VERSION_INSTALLED) {
                    foreach ($oPluginManager->aErrors as $i => $msg) {
                        $aErrors[] = $msg;
                    }
                }
            }
        }
    }

    // now diagnose problems
    $aDiag = $oPluginManager->getPackageDiagnostics($pluginName);
    if ($aDiag['plugin']['error'])
    {
        $aErrors[] = 'Problems found with plugin '.$pluginName.'.  The plugin has been disabled.  Go to the Configuration Plugins page for details ';
        foreach ($aDiag['plugin']['errors'] as $i => $msg)
        {
            $aErrors[] = $msg;
        }
    }
    foreach ($aDiag['groups'] as $idx => &$aGroup)
    {
        if ($aGroup['error'])
        {
            $aDiag['plugin']['error'] = true;
            $aErrors[] = 'Problems found with components in group '.$aGroup['name'].'.  The '.$pluginName.' plugin has been disabled.  Go to the Configuration->Plugins page for details ';
            foreach ($aGroup['errors'] as $i => $msg)
            {
                $aErrors[] = $msg;
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
        if ($enabled)
        {
            echo "Enable package for $pluginName\n";
            if ($oPluginManager->enablePackage($pluginName))
            {
                $aResult['status'].= ', Enabled';
            }
            else
            {
                $aResult['status'].= ', failed to enable, check plugin configuration';
            }
        }
        else
        {
            $aResult['status'].= ', Disabled';
        }
    }
    else
    {
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
    if (file_exists($file))
    {
        $aContent = explode(';', file_get_contents($file));
        $aResult = array();
        foreach ($aContent as $k => $v)
        {
            if (trim($v))
            {
                $aLine = explode('=', trim($v));
                if (is_array($aLine) && (count($aLine)==2) && (is_numeric($aLine[1])))
                {
                    $aResult[$aLine[0]] = $aLine[1];
                }
            }
        }
        return array_key_exists($pluginName,$aResult);
    }
    return false;
}
/*
function validRequest(&$result)
{
    if ((!isset($_REQUEST['plugin'])) || (!isset($_REQUEST['status'])))
    {
        $result['errors'][] = 'Bad arguments';
        return false;
    }
    $result['name'] = $_REQUEST['plugin'];
    if (empty($_COOKIE['oat']) || (($_COOKIE['oat'] != OA_UPGRADE_INSTALL) && ($_COOKIE['oat'] != OA_UPGRADE_UPGRADE)))
    {
        $result['errors'][] = 'Cookie not found';
        return false;
    }
    if (!checkLogin())
    {
        $result['errors'][] = 'Session user not found';
        return false;
    }
    return true;
}
*/

function checkLogin()
{
    require_once MAX_PATH. '/lib/OA/Permission.php';
    require_once MAX_PATH.'/lib/OA/Upgrade/Login.php';
    OA_Upgrade_Login::autoLogin();
    return OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isUserLinkedToAdmin();
}

?>
