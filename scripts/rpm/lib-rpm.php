<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
 * Common functions used by both the core and upgrade (rpm) support scripts
 *
 */

define('CORE_UPGRADE_ERROR_EXIT',       -5);
define('CORE_UPGRADE_ERROR_RECOVER',    -2);
define('CORE_UPGRADE_CONTINUE',          0);
define('CORE_UPGRADE_FINISH',            5);

define('PLUGIN_UPGRADE_ERROR_EXIT',     -5);
define('PLUGIN_UPGRADE_ERROR_RECOVER',  -3);
define('PLUGIN_UPGRADE_CONTINUE',        0);
define('PLUGIN_UPGRADE_FINISH',          5);

define('DISABLE_ALL_EMAILS', 1);

require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Login.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';

require_once MAX_PATH . '/lib/OA/Upgrade/UpgradePluginImport.php';
require_once MAX_PATH . '/lib/OX/Plugin/PluginManager.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Login.php';

// protect this script to be used only from command-line
if (php_sapi_name() != 'cli') {
    echo "Sorry, this tool must be run from the command-line";
    exit;
}

error_reporting(E_ALL);
@set_time_limit(0);
OX_increaseMemoryLimit(-1);

/** 
 * Call OX_PluginManager to unpack plugin
 *
 * @params string $pluginName
 * @return boolean
 */
function unpackPlugin($pluginName)
{
    $aErrors = array();
    $aResult = array('name' => $pluginName, 'status' => '', 'errors' => &$aErrors);
    
    // make sure this is a legitimate bundled plugin request
    // if ($aPlugin = getPlugin($pluginName))
    $aPlugin = getPlugin($pluginName);
    
    $oPluginManager = new OX_PluginManager();

    $filename = $aPlugin['name'] . '.' . $aPlugin['ext'];
    $filepath = $aPlugin['path'] . $filename;

    if (!$oPluginManager->unpackPlugin(array('tmp_name'=>$filepath, 'name'=>$filename), true)) {
        echo "Failed to unpackerror unpack at install package: $filename\n";
    }
    if ($oPluginManager->countErrors()) {
        $aResult['status'] = 'Failed';
        foreach ($oPluginManager->aErrors as $errmsg) {
            $aErrors[] = $errmsg;
        }
    } else {
        $aResult['status'] = 'OK';
    }
    unset($oPluginManager);

    return $aResult;
}

/**
 * check or install individual plugin
 */
function upgradePlugin($pluginName, $disabled = true)
{
    // Log in as the admin user for auditing purposes
    OA_Upgrade_Login::autoLogin();
    
    $result = array();
    if (!array_key_exists($pluginName, $GLOBALS['_MAX']['CONF']['plugins'])) {
       //echo "Installing Plugin $pluginName\n";
       $result = installPlugin($pluginName, $disabled);
    } else {
       //echo "Checking Plugin $pluginName\n";
        $oPluginManager = new OX_PluginManager();
        $aFile = array(
            'name'      => $pluginName . '.zip',
            'tmp_name'  => MAX_PATH . '/etc/plugins/' . $pluginName . '.zip',
        );
        $result = $oPluginManager->upgradePackage($aFile, $pluginName, true);
    }
    return $result;
} 
    
/** 
 * execute post upgrade task after installation
 *
 * @param class $oUpgrader
 * @return array('action'=>int, 'message'=>string)
 */
function pluginUpgradePost(&$oUpgrader) 
{
    //undo hack
    unset($GLOBALS['_MAX']['CONF']['pluginPaths']['extensions']);
   
    $oSettings = new OA_Admin_Settings();
    $oSettings->writeConfigChange();

    @unlink(MAX_PATH.'/var/plugins/recover/enabled.log');
    //update the configuration for oUpgrader
    $oUpgrader->oConfiguration->OA_Upgrade_Config();

    $result = $oUpgrader->executePostUpgradeTasks();
    if (is_array($result)) {
        $aPostTasks = $result;
    }
    $message = $strPostUpgradeTasks;
    $action = PLUGIN_UPGRADE_CONTINUE;

    return array('action'=>$action, 'message'=>$message);
}

/**
 * execute some tasks when the installation finishes
 * such as remove upgrade trigger file
 *
 * @param class $oUpgrader
 * @return array('action'=>int, 'message'=>string)
 */
function pluginUpgradeFinish(&$oUpgrader)
{
    //OA_Upgrade_Login::autoLogin();
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

    $oUpgrader->oConfiguration->OA_Upgrade_Config();
    $oUpgrader->setOpenadsInstalledOn();

    if (!$oUpgrader->removeUpgradeTriggerFile()) {
        $message .= '. ' . $strRemoveUpgradeFile;
        $strInstallSuccess = '<div class="sysinfoerror">'.$strOaUpToDateCantRemove.'</div>'.$strInstallSuccess;
    }
    return array('action' => PLUGIN_UPGRADE_FINISH, 'message' => $message);
}

/**
 * given plugin name, find the full information of the plugin
 *
 * @params string $pluginName
 * @return array('path'=>string, 'name'=>string, 'ext'=>string)
 */
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
    return array('path'=>MAX_PATH . '/etc/plugins/', 'name' => $pluginName, 'ext'=>'zip');
}

/**
 * call PluginManager to install plugin
 * 
 * @param string $pluginName
 * @param int $disabled
 * @return array('action'=>int, 'message'=>string)
 */
function installPlugin($pluginName,$disabled)
{
    $aErrors = array();
    $aResult = array('name'=>$pluginName,'status'=>'','errors'=>&$aErrors);
    // make sure this is a legitimate bundled plugin request
    if ($aPlugin = getPlugin($pluginName)) {
        //OA::logMem('start deliveryLog/installPlugin');
        $oPluginManager = new OX_PluginManager();
        if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins'])) {
            $filename = $aPlugin['name'].'.'.$aPlugin['ext'];
            $filepath = $aPlugin['path'].$filename;
            $_REQUEST['disabled'] = $disabled;
            if (!$oPluginManager->installPackage(array('tmp_name'=>$filepath, 'name'=>$filename), $disabled)) {
                echo "error happened at install package: $filename\n";
            }
            if ($oPluginManager->countErrors()) {
                $aResult['status'] = 'Failed';
                foreach ($oPluginManager->aErrors as $errmsg) {
                    $aErrors[] = $errmsg;
                }
            } else {
                $aResult['status'] = 'OK';
            }
        } else {
            $aResult['status'] = 'Already Installed';
            $aErrors[] = 'Could not be installed because previous installation (whole or partial) was found';
        }
        unset($oPluginManager);
        //OA::logMem('stop deliveryLog/installPlugin');
    } else {
        $aResult['status'] = 'Invalid';
        $aErrors[] = 'Not a valid default plugin';
    }
    return $aResult;
}

/** 
 * check plugin
 * 
 * @param string $pluginName
 * @return boolean
 */
function checkPlugin($pluginName)
{
    $aErrors = array();
    $aResult = array('name'=>$pluginName,'status'=>'','errors'=>&$aErrors);
    $oPluginManager = new OX_PluginManager();
    // if plugin definition is not found in situ
    // try to import plugin code from the previous installation
    if (!file_exists(MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$pluginName.'.xml')) {
        if (isset($GLOBALS['_MAX']['CONF']['pluginPaths']['export'])) {
            $file = $GLOBALS['_MAX']['CONF']['pluginPaths']['export'].$pluginName.'.zip';
            if (file_exists($file)) {
                $aFile['name'] = $file;
                $aFile['tmp_name'] = $file;
                $aErrors[] = 'Exported plugin file found, attempting to import from '.$file;
                if (!$oPluginManager->installPackageCodeOnly($aFile)) {
                    if ($oPluginManager->countErrors()) {
                        $aResult['status'] = 'Failed';
                        foreach ($oPluginManager->aErrors as $errmsg) {
                            $aErrors[] = $errmsg;
                        }
                    }
                } else {
                    $aResult['status'] = 'OK Here';
                }
            }
        }
    }
    // Try to upgrade bundled plugins
    // Use include instead of include_once, otherwise wont' include at the second time
    include(MAX_PATH.'/etc/default_plugins.php');
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
                        $aErrors[] = $msg;
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
            $aErrors[] = $msg;
        }
    }

    foreach ($aDiag['groups'] as $idx => &$aGroup) {
        if ($aGroup['error']) {
            $aDiag['plugin']['error'] = true;
            $aErrors[] = 'Problems found with components in group '.$aGroup['name'].'.  The '.$pluginName.' plugin has been disabled.  Go to the Configuration->Plugins page for details ';
            foreach ($aGroup['errors'] as $i => $msg) {
                $aErrors[] = $msg;
            }
        }
    }
    $enabled = wasPluginEnabled($pluginName); // original setting
    if (!$aDiag['plugin']['error']) {
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
function wasPluginEnabled($pluginName) {
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

/**
 * xml2array() will convert the given XML text to an array in the XML structure.
 * Link: http://www.bin-co.com/php/scripts/xml2array/
 * Arguments : $contents - The XML text
 *             $get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
 *             $priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
 * Return: The parsed XML in an array form. Use print_r() to see the resulting array structure.
 * Examples: $array =  xml2array(file_get_contents('feed.xml'));
 *           $array =  xml2array(file_get_contents('feed.xml', 1, 'attribute'));
 */
function xml2array($contents, $get_attributes=1, $priority = 'tag') {
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }

    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

    if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference

    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = array();
        $attributes_data = array();
        
        if(isset($value)) {
            if($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        }

        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                $repeated_tag_index[$tag.'_'.$level] = 1;

                $current = &$current[$tag];

            } else { //There was another element with the same tag name

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2;
                    
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                        unset($current[$tag.'_attr']);
                    }

                }
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                $current = &$current[$tag][$last_item_index];
            }

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

            } else { //If taken, put all things inside a list(array)
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    
                    if($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level]++;

                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $get_attributes) {
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                        
                        if($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                }
            }

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }
    
    return($xml_array);
}

function getCustomersArrayFromXMLFile($filename, $includeInactive = false) 
{
    $customers = array();
    $customersTable = xml2array(file_get_contents($filename));
    foreach ($customersTable['customers']['customer'] AS $rowIdx => $rowFields) {
        foreach ($rowFields as $fieldIdx => $fieldData) {
            if (substr($fieldIdx, strlen($fieldIdx) - 5) == '_attr') { continue; }
            $customers[$rowIdx][$fieldIdx] = (empty($fieldData) ? '' : $fieldData);
            if ($fieldIdx == 'active' && $fieldData != '1' && !$includeInactive) {
                unset($customers[$rowIdx]);
                break;
            }
        }
    }
    return $customers;
}

function cacheAllDataObjects()
{
    // Ensure that any Plugin DataObject files are made available.
    $oPluginManager = new OX_PluginManager();
    
    // Cheat ;) set fake $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] with the list of all instaled plugin-component-groups
    $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = array();
    
    $pluginXMLPath = MAX_PATH . '/plugins/etc';
    $DIR = opendir($pluginXMLPath);
    while ($file = readdir($DIR)) {
        if (is_dir($pluginXMLPath . '/' . $file) && file_exists($pluginXMLPath . '/' . $file . '/' . $file . '.xml')) {
            $GLOBALS['_MAX']['CONF']['pluginGroupComponents'][$file] = '1';
            $aSchema = $oPluginManager->_getDataObjectSchema($file);
            $oPluginManager->_putDataObjects($file, $aSchema);
        }
    }
    $oPluginManager->_cacheDataObjects();
}

#---------------#

/**
 * Import all the plugins present from the previous install
 * For each plugin in default_plugins.php, if it is not in conf, install it
 * @param Upgrader
 * @return array(action, message)
 */
function importPlugins(&$oUpgrader, $previousPath) 
{
    $action = CORE_UPGRADE_ERROR_EXIT;
    $message = '';
    
    //may not be need here, should be in the core upgrade
    $importSuccess = true; 
    
    if ($previousPath != MAX_PATH && is_dir($previousPath)) {
        // Prevent directory traversal and other nasty tricks:
        $path = rtrim(str_replace("\0", '', $previousPath), '\\/');
        if (!stristr($path, '../') && !stristr($path, '..\\')) {
            // Cheat ;) set fake $GLOBALS['_MAX']['CONF']['plugins'] with the list of all plugins in the (old) filesystem path
            $GLOBALS['_MAX']['CONF']['plugins'] = array();
            $pluginXMLPath = $previousPath . '/plugins/etc';
            $DIR = opendir($pluginXMLPath);
            while ($file = readdir($DIR)) {
                if (is_file($pluginXMLPath . '/' . $file) && substr($file, strrpos($file, '.')) == '.xml') {
                    $pluginName = substr($file, 0, strpos($file, '.'));
                    $GLOBALS['_MAX']['CONF']['plugins'][$pluginName] = '1';
                }
            }
            closedir($DIR);
            
            $oPluginImporter = new OX_UpgradePluginImport();
            $oPluginImporter->basePath = $path;
            if ($oPluginImporter->verifyAll($GLOBALS['_MAX']['CONF']['plugins'], false)) {
                // For each plugin that's claimed to be installed... (ex|im)port it into the new codebase
                foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $plugin => $enabled) {
                    $oPluginImporter->import($plugin);
                }
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
                $importSuccess = false;
                $message = "got import Errors\n";
            }
        }
    return $importSuccess;
}

/**
 * define a parameter which is similar as cookie in UI installation
 * 
 * @param int $installStatus
 * @return int
 */
function getCookieOat($installStatus) 
{
    $oat_cookie = '';
    if ($installStatus == OA_STATUS_OAD_NOT_INSTALLED) {
        $oat_cookie = OA_UPGRADE_INSTALL;
    } elseif ($installStatus !== 'unknown') {
        $oat_cookie = OA_UPGRADE_UPGRADE;
    }
    return $oat_cookie;
}

 /**
 * Checks a folder to make sure it exists and is writable
 *
 * @param  int Folder the directory that needs to be tested
 * @return boolean - true if folder exists and is writable
 */
function checkFolderPermissions($folder) {
    if (!file_exists($folder))
    {
        return false;
    }
    elseif (!is_writable($folder))
    {
        return false;
    }
    return true;
}
