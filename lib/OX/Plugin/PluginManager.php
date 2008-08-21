<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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


// Required files
require_once LIB_PATH.'/Plugin/ComponentGroupManager.php';
require_once LIB_PATH.'/Plugin/ParserPlugin.php';
require_once MAX_PATH.'/extensions/deliveryLog/Setup.php';

define('OX_PLUGIN_ERROR_PACKAGE_OK', 1);
define('OX_PLUGIN_ERROR_PACKAGE_NAME_EXISTS'            ,    0);
define('OX_PLUGIN_ERROR_PACKAGE_DEFINITION_NOT_FOUND'   ,   -1);
define('OX_PLUGIN_ERROR_PACKAGE_EXTRACT_FAILED'         ,   -2);
define('OX_PLUGIN_ERROR_PACKAGE_PARSE_FAILED'           ,   -3);
define('OX_PLUGIN_ERROR_PACKAGE_VERSION_NOT_FOUND'      ,   -4);
define('OX_PLUGIN_ERROR_PLUGIN_DEFINITION_MISSING'      ,   -5);
define('OX_PLUGIN_ERROR_PLUGIN_NAME_EXISTS'             ,   -6);
define('OX_PLUGIN_ERROR_PACKAGE_CONTENTS_MISMATCH'      ,   -7);
define('OX_PLUGIN_ERROR_PLUGIN_EXTRACT_FAILED'          ,   -8);
define('OX_PLUGIN_ERROR_PLUGIN_PARSE_FAILED'            ,   -9);
define('OX_PLUGIN_ERROR_FILE_COUNT_MISMATCH'            ,   -10);
define('OX_PLUGIN_ERROR_ILLEGAL_FILE'                   ,   -11);
define('OX_PLUGIN_ERROR_PLUGIN_DECLARATION_MISMATCH'    ,   -12);


class OX_PluginManager extends OX_Plugin_ComponentGroupManager
{
    var $errcode;

    var $aExtensionsAffected = array();
    var $oExtensionManager;

    function __construct()
    {
        $this->init();
    }

    /**
     * return the path to the packages folder
     *
     * @return string
     */
    function getPathToPackages()
    {
        return MAX_PATH.$this->pathPackages;
    }

    /**
     * @todo write test
     *
     * @param string $name
     * @return boolean
     */
    public function isEnabled($name)
    {
        return ($GLOBALS['_MAX']['CONF']['plugins'][$name] ? true : false);
    }

    /**
     * An extension may need to run tasks when plugins change
     * It can provide a class with methods that hook onto some plugin manager events
     *
     * BeforePluginInstall
     * AfterPluginInstall
     * BeforePluginUninstall
     * AfterPluginInstall
     * BeforePluginEnable
     * AfterPluginEnable
     * BeforePluginDisable
     * AfterPluginDisable
     *
     * @param unknown_type $event
     */
    function _runExtensionTasks($event)
    {
        if (!$this->oExtensionManager)
        {
            require_once(LIB_PATH.'/Extension.php');
            $this->oExtensionManager = $this->_instantiateClass('OX_Extension');
        }
        $this->oExtensionManager->aExtensions = $this->aExtensionsAffected;
        $this->oExtensionManager->runTasksForEvent($event);
    }

    function upgradePackage($aFile, $name)
    {
        OA::switchLogFile('plugins');
        if (!@file_exists ($aFile['tmp_name']))
        {
            $this->_logError('Failed to read the uploaded file');
            return false;
        }
        if (!$this->_matchPackageFilename($name, $aFile['name']))
        {
            $this->_logError('Package filename mismatch, the file must contain the package name '.$aPackage['name']);
            return false;
        }
        $aPackageOld = $this->_parsePackage($name);
        $aPluginsOld = $this->_parseComponentGroups($aPackageOld['install']['contents']);
        if ((!$aPackageOld) || (!$aPluginsOld))
        {
            $this->_logError('Failed to parse the current plugins package '.$aPackage['name']);
            return false;
        }
        $this->disablePackage($name);
        if (!($aParsed = $this->_unpack($aFile,true)))
        {
            $this->_logError('The uploaded file '.$aFile['name'] .' was not unpacked');
            return false;
        }
        $aPackageNew = $aParsed['package'];
        if ($name != $aPackageNew['name'])
        {
            $this->_logError('Upgrade package name '.$aPackageNew['name'].'" does not match the package you are upgrading '.$name);
            return false;
        }
        $aPluginsNew = $aParsed['pluginGroupComponents'];
        $this->_runExtensionTasks('BeforePluginInstall');
        $this->_auditSetKeys( array('upgrade_name'=>'upgrade_'.$name,
                                    'version_to'=>$aPackageNew['version'],
                                    'version_from'=>$aPackageOld['version'],
                                    'logfile'=>'plugins.log'
                                    )
                             );
        $auditId = $this->_auditStart(array('description'=>'PACKAGE UPGRADE FAILED',
                                            'action'=>UPGRADE_ACTION_UPGRADE_FAILED,
                                           )
                                     );
        if (!$this->_canUpgradeComponentGroups($aPluginsNew, $aPluginsOld))
        {
            $this->aErrors = $this->oUpgrader->getErrors();
            $this->aWarning = $this->oUpgrader->getMessages();
            $this->_logError('One or more plugins cannot be upgraded');
            return false;
        }
        if (!$this->_upgradeComponentGroups($aPluginsNew, $aPluginsOld))
        {
            $this->_logError('Failed to install plugins for package '.$name);
            return false;
        }
        $this->_auditUpdate(array('description'=>'UPGRADE COMPLETE',
                                  'action'=>UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                  'id' => $auditId,
                                 )
                           );
        $this->_runExtensionTasks('AfterPluginInstall');
        return true;
    }

    /**
     * check uploaded file
     * check file contents
     * unpack file contents
     *
     * @param array $aFile
     * @return boolean
     */
    function unpackPlugin($aFile)
    {
        OA::switchLogFile('plugins');
        if (!@file_exists ($aFile['tmp_name']))
        {
            $this->_logError('Failed to read the uploaded file');
            return false;
        }
        if (!($aParsed = $this->_unpack($aFile, true)))
        {
            $this->_logError('The uploaded file '.$aFile['name'] .' was not unpacked');
            return false;
        }
        foreach ($aParsed['plugins'] as $aGroup)
        {
            $aSchema = $aGroup['install']['schema'];
            $name    = $aGroup['name'];
            if (!$this->_putDataObjects($name, $aSchema))
            {
                $this->_logError('Failed to copy dataobject classes for '.$name);
                return false;
            }
            if (!$this->_cacheDataObjects($name, $aSchema))
            {
                $this->_logError('Failed to merge dataobject schema for '.$name);
                return false;
            }
        }
        return $aParsed;
    }

    function installPackageCodeOnly()
    {
        $aParsed = $this->unpackPlugin($aFile);
        if (!$aParsed)
        {
            return false;
        }
        foreach ($aParsed['plugins'] as $aGroup)
        {
            $aSchema = $aGroup['install']['schema'];
            $name    = $aGroup['name'];
            if (!$this->_putDataObjects($name, $aSchema))
            {
                $this->_logError('Failed to copy dataobject classes for '.$name);
                return false;
            }
            if (!$this->_cacheDataObjects($name, $aSchema))
            {
                $this->_logError('Failed to merge dataobject schema for '.$name);
                return false;
            }
        }
        return true;
    }

    /**
     * parse a package definition file
     * parse each of the plugins contained therein
     * install each of the plugins contained therein
     * set the conf value of the package to installed but disabled
     *
     * @param array $aFile
     * @return boolean
     */
    function installPackage($aFile)
    {
        $aParsed = $this->unpackPlugin($aFile);
        if (!$aParsed)
        {
            return false;
        }
        $aPackage = $aParsed['package'];
        $aPlugins = $aParsed['plugins'];
        $this->_runExtensionTasks('BeforePluginInstall');
        $this->_auditSetKeys( array('upgrade_name'=>'install_'.$aPackage['name'],
                                    'version_to'=>$aPackage['version'],
                                    'version_from'=>0,
                                    'logfile'=>'plugins.log'
                                    )
                             );
        $auditId = $this->_auditStart(array('description'=>'PACKAGE INSTALL FAILED',
                                            'action'=>UPGRADE_ACTION_INSTALL_FAILED,
                                            )
                                      );
        if (!$this->_installComponentGroups($aPlugins))
        {
            $this->_logError('Failed to install plugins for package '.$aPackage['name']);
            $this->_uninstallComponentGroups($aPlugins);
            return false;
        }
        // this sets up conf but leaves package disabled
        if (!$this->_registerPackage($aPackage['name']))
        {
            return false;
        }
        $this->_auditUpdate(array('description'=>'PACKAGE INSTALL COMPLETE',
                                  'action'=>UPGRADE_ACTION_INSTALL_SUCCEEDED,
                                  'id' => $auditId,
                                 )
                           );
        $this->_runExtensionTasks('AfterPluginInstall');
        return true;
    }

    /**
     * parse a package definition file
     * parse each of the plugins contained therein
     * uninstall each of the plugins contained therein
     * remove the conf setting for the package
     *
     * @param array string
     * @return boolean
     */
    function uninstallPackage($name)
    {
        OA::switchLogFile('plugins');
        $aPackage = $this->_parsePackage($name);
        if (!$aPackage)
        {
            return false;
        }
        $aGroups = $this->_parseComponentGroups($aPackage['install']['contents']);
        if (!$aGroups)
        {
            $this->_logError('Failed to parse the plugin definitions contained in package '.$name);
            return false;
        }
        krsort($aGroups);
        if (!$this->_canUninstallPlugin($aGroups))
        {
            $this->_logError('You may not uninstall this plugin at this time');
            return false;
        }
        $this->_runExtensionTasks('BeforePluginUninstall');
        $this->_auditSetKeys( array('upgrade_name'=>'uninstall_'.$aPackage['name'],
                                    'version_to'=>0,
                                    'version_from'=>$aPackage['version'],
                                    'logfile'=>'plugins.log'
                                    )
                             );
        $auditId = $this->_auditStart(array('description'=>'PACKAGE UNINSTALL FAILED',
                                            'action'=>UPGRADE_ACTION_UNINSTALL_FAILED,
                                           )
                                     );
        // just in case anything goes wrong, e.g. half uninstall - don't want app trying to use half a package
        $this->disablePackage($name);
        if (!$this->_uninstallComponentGroups($aGroups))
        {
            $this->_logError('Failed to uninstall package '.$name);
            return false;
        }
        if (!$this->_unregisterPackage($name))
        {
            $this->_logError('Failed to unregister package '.$name);
            return false;
        }
        if (!$this->_removeFiles('', $aPackage['install']))
        {
            $this->_logError('Failed to remove some files belonging to '.$name);
        }
        $pkgDefinition = MAX_PATH.$this->pathPackages.$name.'.xml';
        if (file_exists($pkgDefinition))
        {
            @unlink($pkgDefinition);
        }
        $this->_auditUpdate(array('description'=>'PACKAGE UNINSTALL COMPLETE',
                                  'action'=>UPGRADE_ACTION_UNINSTALL_SUCCEEDED,
                                  'id' => $auditId,
                                 )
                           );
        $this->_runExtensionTasks('AfterPluginUninstall');
        return true;
    }

    function _canUninstallPlugin($aGroups)
    {
        $result = true;
        $aDepends = $this->_loadDependencyArray();
        foreach ($aGroups AS $i => $aGroup)
        {
            $aGroups[$i] = $aGroup['name'];
        }
        foreach ($aGroups AS $i => $group)
        {
            $aDependencies = $this->_hasDependencies($group, $aGroups);
            if ($aDependencies)
            {
                $this->_logError($group.' has dependencies'); //.$group.' depends on '.$name);
                $result = false;
            }
        }
        return $result;
    }

    /**
     * set the conf enabled value to true for the package
     * and for each of the plugins belonging to the package
     *
     * parsing the package will retrieve extensions to be handled before and after enable
     *
     * @param array string
     * @return boolean
     */
    public function enablePackage($name)
    {
        $aPackage = $this->_parsePackage($name);
        if (!$aPackage)
        {
            return false;
        }
        $aPlugins = $this->_parseComponentGroups($aPackage['install']['contents']);
        if (!$aPlugins)
        {
            $this->_logError('Failed to parse the plugin definitions contained in package '.$name);
            return false;
        }
        $this->_runExtensionTasks('BeforePluginEnable');
        foreach ($aPackage['install']['contents'] AS $k => $plugin)
        {
            if (!$this->enableComponentGroup($plugin['name']))
            {
                $this->_logError('Failed to enable plugin '.$plugin['name'].' for package '.$name);
                $this->disablePackage($name);
                return false;
            }
        }
        if (!$this->_setPackage($name, 1))
        {
            $this->_logError('Failed to enable package '.$name);
            $this->disablePackage($name);
            return false;
        }
        $this->_runExtensionTasks('AfterPluginEnable');
        return true;
    }

    /**
     * set the conf enabled value to false for the package
     * and for each of the plugins belonging to the package
     *
     * parsing the package will retrieve extensions to be handled before and after disable
     *
     * @param string $name
     * @return boolean
     */
    public function disablePackage($name)
    {
        $aPackage = $this->_parsePackage($name);
        if (!$aPackage)
        {
            if (isset($GLOBALS['extensions']))
            {
                if (!$this->_setPackage($name, 0))
                {
                    $this->_logError('Failed to disable package '.$name);
                    return false;
                }
            }
            return false;
        }
        $aPlugins = $this->_parseComponentGroups($aPackage['install']['contents']);
        if (!$aPlugins)
        {
            $this->_logError('Failed to parse the plugin definitions contained in package '.$name);
            return false;
        }
        $this->_runExtensionTasks('BeforePluginDisable');
        foreach ($aPackage['install']['contents'] AS $k => $plugin)
        {
            if (!$this->disableComponentGroup($plugin['name']))
            {
                $this->_logError('Failed to disable plugin '.$plugin['name'].' for package '.$name);
                return false;
            }
        }
        if (!$this->_setPackage($name, 0))
        {
            $this->_logError('Failed to disable package '.$name);
            return false;
        }
        $this->_runExtensionTasks('AfterPluginDisable');
        return true;
    }

    function _matchPackageFilename($name, $file)
    {
        if (substr($file,0,strlen($name))!=$name)
        {
            $this->_logError('Filename mismatch: name/file'. $name.' / '.$file);
            return false;
        }
        return $this->_parsePackageFilename($file);
    }

    function _parsePackageFilename($file)
    {
        $pattern = '(?P<name>[\w\d]+)_?(?P<version>[\d]+\.[\d]+\.[\d]+[-\w\d]+)?\.(?P<ext>[\w]{3,4})';
        if (!preg_match('/'.$pattern.'/U',$file,$aMatch))
        {
            $this->_logError('Filename not parsed '.$file);
            return false;
        }
        return array('version'=>$aMatch['version'],'name'=>$aMatch['name'],'ext'=>$aMatch['ext']);
    }

    /**
     * parse the xml to array for each of the plugins contained in this package
     *
     * @param array $aContents
     * @return array
     */
    function _parseComponentGroups($aContents=null, $returnOnError=true)
    {
        $aResult = array();
        if ((!$aContents) || empty($aContents) || (!is_array($aContents)))
        {
            $this->_logError('Failed to find any contents in the package');
            $aResult['error'] = true;
            if ($returnOnError)
            {
                return false;
            }
        }
        foreach ($aContents as $idx => $aElement)
        {
            $aResult[$idx]['error'] = false;
            $error = false;
            $file = $this->getFilePathToXMLInstall($aElement['name']);
            if (!@file_exists($file))
            {
                $this->_logError('File not found '.$file);
                $aResult[$idx]['name']  = $aElement['name'];
                $aResult[$idx]['error'] = true;
                if ($returnOnError)
                {
                    return false;
                }
            }
            $aParsed = $this->parseXML($file, 'OX_ParserComponentGroup');
            if (!$aParsed)
            {
                $this->_logError('Failed to parse plugin definition in '.$file);
                $aResult[$idx]['error'] = true;
                if ($returnOnError)
                {
                    return false;
                }
            }
            else
            {
                $aResult[$idx] = $aParsed;
                $this->aExtensionsAffected[] = $aParsed['extends'];
            }
        }
        return $aResult;
    }

    function _canUpgradeComponentGroups(&$aGroupsNew=null, &$aGroupsOld)
    {
        $this->errcode = '';
        if ((!$aGroupsNew) || empty($aGroupsNew) || (!is_array($aGroupsNew)))
        {
            $this->_logError('Failed to find any plugins to upgrade');
            return false;
        }
        foreach ($aGroupsNew as $idx => $aGroup)
        {
            // reduce the list of old plugins to those that need to be deleted only
            foreach ($aGroupsOld AS $k => $aOld)
            {
                if ($aOld['name'] == $aGroup['name'])
                {
                    unset($aGroupsOld[$idx]);
                    break;
                }
            }
            if (!$this->_canUpgradeComponentGroup($aGroup))
            {
                return false;
            }
            $aGroupsNew[$idx]['status'] = $aGroup['status'];
        }
        return true;
    }

    /**
     * upgrade each of the plugins contained in this package
     *
     * @param array $aPlugins
     * @return boolean
     */
    function _upgradeComponentGroups($aGroupsNew=null, $aGroupsOld)
    {
        $this->errcode = '';
        foreach ($aGroupsNew as $idx => $aGroup)
        {
            switch ($aGroup['status'])
            {
                case OA_STATUS_PLUGIN_CAN_UPGRADE:
                        $result = $this->upgradeComponentGroup($aGroup);
                        switch ($result)
                        {
                            case UPGRADE_ACTION_UPGRADE_SUCCEEDED:
                                    $this->_logMessage('Upgrade succeeded '.$aGroup['name']);
                                    $this->_cacheDependencies();
                                    break;
                            case UPGRADE_ACTION_UPGRADE_FAILED:
                                    $this->_logError('Failed to upgrade '.$aGroup['name']);
                                    return false;
                        }
                        break;
                case OA_STATUS_PLUGIN_NOT_INSTALLED:
                        if (!$this->_installComponentGroups(array(0=>$aGroup)))
                        {
                            return false;
                        }
                        break;
            }

        }
        if (count($aGroupsOld))
        {
            return $this->_uninstallComponentGroups($aGroupsOld);
        }
        return true;
    }

    /**
     * install each of the plugins contained in this package
     *
     * @param array $aPlugins
     * @return boolean
     */
    function _installComponentGroups($aGroups=null)
    {
        if ((!$aGroups) || empty($aGroups) || (!is_array($aGroups)))
        {
            $this->_logError('Failed to find any component groups to install');
            return false;
        }
        foreach ($aGroups as $idx => $aGroup)
        {
            $this->_auditSetKeys( array('upgrade_name'=>'install_'.$aGroup['name'],
                                        'version_to'=>$aGroup['version'],
                                        'version_from'=>0,
                                        'logfile'=>'plugins.log'
                                        )
                                 );
            $auditId = $this->_auditStart(array('description'=>'PLUGIN INSTALL FAILED',
                                                             'action'=>UPGRADE_ACTION_INSTALL_FAILED,
                                                            )
                                                      );
            $this->_auditSetID();
            if (!$this->installComponentGroup($aGroup))
            {
                $this->_logError('Failed to install '.$aGroup['name']);
                return false;
            }
            $this->_cacheDependencies(); // need to keep recreating the array
            $this->_auditUpdate(array('description'=>'PLUGIN INSTALL COMPLETE',
                                      'action'=>UPGRADE_ACTION_INSTALL_SUCCEEDED,
                                      'id' => $auditId,
                                     )
                               );
    }
        return true;
    }

    /**
     * uninstall each of the plugins contained in this package
     *
     * @param array $aPlugins
     * @return boolean
     */
    function _uninstallComponentGroups($aGroups=null)
    {
        if (!$aGroups)
        {
            $this->_logError('Failed to find any contents in the package');
            return false;
        }
        //krsort($aGroups);
        foreach ($aGroups as $idx => $aGroup)
        {
            $this->_auditSetKeys(array('upgrade_name'=>'uninstall_'.$aGroup['name'],
                                            'version_to'=>0,
                                            'version_from'=>$aGroup['version'],
                                            'logfile'=>'plugins.log'
                                            )
                                     );
            $auditId = $this->_auditStart(array('description'=>'PLUGIN UNINSTALL FAILED',
                                                 'action'=>UPGRADE_ACTION_UNINSTALL_FAILED,
                                                )
                                          );
            $this->_auditSetID();
            if (!$this->uninstallComponentGroup($aGroup))
            {
                $this->_logError('Failed to uninstall '.$aGroup['name']);
                return false;
            }
            $this->_cacheDependencies(); // need to keep recreating the array
            $this->_auditUpdate(array('description'=>'PLUGIN UNINSTALL COMPLETE',
                                      'action'=>UPGRADE_ACTION_INSTALL_FAILED,
                                      'id' => $auditId,
                                     )
                               );
        }
        return true;
    }

    /**
     * set the enabled conf flag for the package
     *
     * @param string $name
     * @param boolean $enabled
     * @return boolean
     */
    function _setPackage($name, $enabled=0)
    {
        $oSettings = $this->_instantiateClass('OA_Admin_Settings');
        if (!$oSettings)
        {
            return false;
        }
        $oSettings->settingChange('plugins',$name,$enabled);
        return $oSettings->writeConfigChange();
    }

    /**
     * parse the package xml to an array
     *
     * @param string $name
     * @return array
     */
    function _parsePackage($name)
    {
        if (!$name)
        {
            $this->_logError('Null package definition file name');
            return false;
        }
        $file = $name;
        if (!@file_exists($file))
        {
            $file = $this->getPathToPackages().$name.'.xml';
            if (!@file_exists($file))
            {
                $this->_logError('Failed to find package definition file '.$file);
                return false;
            }
        }
        $aPackage = $this->parseXML($file);
        if (!$aPackage )
        {
            $this->_logError('Error parsing package definition for '.$name);
            return false;
        }
        if ((!isset($aPackage['install']['contents'])) || empty($aPackage['install']['contents']) || (!is_array($aPackage['install']['contents'])))
        {
            $this->_logError('Found no contents in package definition for '.$name);
            return false;
        }
        return $aPackage;
    }

    /**
     * use the parent method to parse the package xml
     *
     * @param boolean $input_file
     * @param boolean $classname
     * @return boolean
     */
    public function parseXML($input_file, $classname='OX_ParserPlugin')
    {
        return parent::parseXML($input_file, $classname);
    }

    /**
     * write the conf settings for the first time (disabled by default)
     *
     * @param string $name
     * @return boolean
     */
    function _registerPackage($name)
    {
        if (!$this->disablePackage($name))
        {
            $this->_logError('Failed to register package '.$name);
            return false;
        }
        return true;
    }

    /**
     * remove the conf settings
     *
     * @param string $name
     * @return boolean
     */
    function _unregisterPackage($name)
    {
        $oSettings = $this->_instantiateClass('OA_Admin_Settings');
        if (array_key_exists($name,$oSettings->aConf['plugins']))
        {
            unset($oSettings->aConf['plugins'][$name]);
        }
        if (!$oSettings->writeConfigChange())
        {
            $this->_logError('Failed to unregister package '.$name);
            return false;
        }
        return true;
    }

    /**
     * get a list of all installed packages with status
     *
     * @return array
     */
    public function getPackagesList()
    {
        $aResult = $GLOBALS['_MAX']['CONF']['plugins'];
        foreach ($aResult AS $name => $enabled)
        {
            $aResult[$name] = $this->getPackageInfo($name);
            $aResult[$name]['enabled'] = $enabled;
        }
        return $aResult;
    }

    /**
     * get detailed info about the package
     * including optional info on each plugin contained
     *
     * @param string $name
     * @return array
     */
    public function getPackageInfo($name, $getComponentGroupInfo=true)
    {
        $aParse = $this->_parsePackage($name);
        if ((!$aParse) || empty($aParse) || (!is_array($aParse)))
        {
            if (!$this->disablePackage($name))
            {
                $this->_setPackage($name, 0);
            }
            return false;
        }
        $aPkgInfo = array('extensions'=>array(),'contents'=>array(),'readme'=>'');
        foreach ($aParse['install']['files'] as $idx => $aFile)
        {
            if (preg_match('/'.$name.'\.readme\.txt/',$aFile['name']))
            {
                $aPkgInfo['readme'] = MAX_PATH.$this->pathPackages.$aFile['name'];
            }
        }
        foreach ($aParse AS $k => $v)
        {
            if (!is_array($v))
            {
                $aPkgInfo[$k] = $v;
            }
            else if ($k == 'install')
            {
                foreach ($v['contents'] AS $i =>$aPlugin)
                {
                    $aPlugins[] = $aPlugin['name'];
                }
                if ($getComponentGroupInfo)
                {
                    $aPkgInfo['contents'] = $this->getComponentGroupsList($aPlugins);
                    $aPkgInfo['extensions'] = $v['components'];
                }
            }
            unset($aPkgInfo['extends']);
        }
        return $aPkgInfo;
    }

    /**
     * get diagnostic information about the package
     * including optional info on each plugin contained
     *
     * @param string $name
     * @return array
     */
    public function getPackageDiagnostics($name, $getComponentGroupInfo=true)
    {
        $this->clearErrors();
        $aPackage = $this->_parsePackage($name);
        $aPackage['error'] = false;
        $aPackage['errors'] = array();
        if (!$aPackage)
        {
            $aPackage['error']  = true;
        }
        else if (empty($aPackage['install']['contents']))
        {
            $aPackage['error']  = true;
            $this->_logError('Package is missing any plugin declarations');
        }
        $aPlugins = $this->_parseComponentGroups($aPackage['install']['contents'],false);
        if (isset($aPlugins['error']) && $aPlugins['error'])
        {
            $aPackage['error']  = true;
            $aPackage['errors'] = $this->aErrors;
        }
        if ($getComponentGroupInfo)
        {
            foreach ($aPlugins as $idx => $aPlugin)
            {
                $this->clearErrors();
                if (!$aPlugin['error'])
                {
                    $aPlugins[$idx]['error'] = false;
                    $aPlugins[$idx]['errors'] = array();
                    $this->_canUpgradeComponentGroup($aPlugin);
                    switch ($aPlugin['status'])
                    {
                        case OA_STATUS_PLUGIN_NOT_INSTALLED:
                            $this->_logError('Plugin not installed');
                            break;
                        case OA_STATUS_PLUGIN_VERSION_FAILED:
                            $this->_logError('Plugin version information unobtainable');
                            break;
                        case OA_STATUS_PLUGIN_DBINTEG_FAILED:
                            $this->_logError('Plugin schema integrity check failed');
                            break;
                        case OA_STATUS_PLUGIN_CURRENT_VERSION:
                        case OA_STATUS_PLUGIN_CAN_UPGRADE:
                            break;
                    }
                    $this->diagnoseComponentGroup($aPlugin);
                    if ($this->countErrors())
                    {
                        $aPlugins[$idx]['error'] = true;
                        $aPlugins[$idx]['errors'] = $this->aErrors;
                    }
                }
            }
        }
        return array('plugin'=>$aPackage, 'groups'=>$aPlugins);
    }

    /**
     * This method gets an array of hook->componentIdentifiers of any registered (stackable) hooks
     *
     * @return array e.g. array('preAdRender' => array('component1', 'component2'), 'postAdRender' => array('component3')),
     */
    function getComponentHooks()
    {
        $aPackages = $GLOBALS['_MAX']['CONF']['plugins'];
        $aResult = array();
        foreach ($aPackages AS $name => $enabled)
        {
            if ($enabled)
            {
                $aPkgInfo = $this->getPackageInfo($name);
                foreach ($aPkgInfo['contents'] AS $componentGroup)
                {
                    foreach ($componentGroup['components'] as $componentName => $aComponent) {
                        foreach ($aComponent['hooks'] as $hook) {
                            $aResult[$hook][] = $componentGroup['extends'] . ':' . $componentGroup['name'] . ':' . $componentName;
                        }
                    }
                }
            }
        }
        return $aResult;
    }

    /**
     * determine the file format
     * if zip, decompress
     * return the package name
     *
     * @param array $aFile
     * @return string | null
     */
    function _unpack($aFile, $overwrite=false)
    {
        $aPath = pathinfo($aFile['name']);
        if (!isset($aPath['filename']))
        {
            $aPath['filename'] = substr($aPath['basename'],0,strrpos($aPath['basename'],'.'));
        }
        if (!isset($aPath['extension']))
        {
            return false;
        }
        switch ($aPath['extension'])
        {
            case 'zip':
                if (!$aResult = $this->_checkPackageContents($aPath['filename'].'.xml',$aFile['tmp_name'],$overwrite))
                {
                    $this->_logError('The uploaded file did not pass security check');
                    return false;
                }
                if (!$this->_decompressFile($aFile['tmp_name'], MAX_PATH, $overwrite))
                {
                    $this->_logError('Failed to decompress the uploaded file');
                    return false;
                }
                return $aResult;
            /*case 'xml':
                $pkgFile = $aPath['filename'];
                break;*/
            default:
                return false;
        }
    }

    /**
     * use the pclZip lib to list the contents of the file
     *
     * the following files can be acquired and used to trace errors if necessary
     * require_once( MAX_PATH . '/lib/pclzip/pclerror.lib.php' );
     * require_once( MAX_PATH . '/lib/pclzip/pcltrace.lib.php' );
     * require_once( MAX_PATH . '/lib/pclzip/pcltar.lib.php' );
     *
     *
     * @param string $pkgFile
     * @param string $zipFile
     * @return boolean
     */
    function _checkPackageContents($pkgFileUploaded, $zipFile, $overwrite=false)
    {
        if (!file_exists($zipFile))
        {
            $this->_logError('File not found '.$zipFile);
            return false;
        }
        $this->_logMessage('starting _checkPackageContents '.$pkgFileUploaded);
        $aExpectedPackage = $this->_parsePackageFilename($pkgFileUploaded);
        $pkgFile = $aExpectedPackage['name'].'.xml';
        $this->_logMessage('expecting definition '.$pkgFile);
		require_once( MAX_PATH . '/lib/pclzip/pclzip.lib.php' );
		$oZip = new PclZip( $zipFile );
		$aContents = $oZip->listContent();
		if (!$aContents)
		{
		    $this->_logError('Failed to read contents of zip file '.$zipFile);
		    return false;
		}
		$aConf = $GLOBALS['_MAX']['CONF'];

		$pattPluginDefFile = '/'.preg_quote($aConf['pluginPaths']['packages'],'/').'[\w\d]+\.xml/';
		$pattGroupDefFile = '/'.preg_quote($aConf['pluginPaths']['packages'],'/').'[\w\d]+\/[\w\d]+\.xml/';
		$this->_logMessage('pattPluginDefFile = '.$pattPluginDefFile);
		$this->_logMessage('pattGroupDefFile = '.$pattGroupDefFile);
		foreach ($aContents AS $i => $aItem)
		{
	        $aPath = pathinfo($aItem['filename']);
	        $file = '/'.$aItem['filename'];
	        if ($aItem['folder'])  // ignore folders
	        {
	            continue;
	        }
	        if ((!$aPkgFile) && preg_match($pattPluginDefFile, $file, $aMatches)) // its an OpenXtra definition file
	        {
	            $this->_logMessage('detected plugin definition file '.$file);
	            $aPkgFile['pathinfo']   = $aPath;
                $aPkgFile['storedinfo'] = $aItem;
                continue;
	        }
            if (preg_match($pattGroupDefFile, $file, $aMatches)) // its a group definition file
            {
                $this->_logMessage('detected group definition file '.$file);
    		    $aXMLFiles[$aPath['basename']]['pathinfo'] = $aPath;
    		    $aXMLFiles[$aPath['basename']]['storedinfo'] = $aItem;
    		    continue;
            }
            if (strpos($aPath['dirname'],'/etc/changes') == 0) // don't check the changeset files (costly parsing of upgrade definitions etc.)
            {
                $aFilesStored[] = '/'.$aItem['filename'];
                continue;
            }
		}
	    if (!$aPkgFile)
	    {
	        $this->_logError('Plugin definition '.$aExpectedPackage['name'].'.xml not found in uploaded file: '.$pkgFileUploaded);
	        $this->errcode = OX_PLUGIN_ERROR_PACKAGE_DEFINITION_NOT_FOUND;
	        return false;
	    }
        $aResult = $oZip->extractByIndex($aPkgFile['storedinfo']['index'], PCLZIP_OPT_ADD_PATH, MAX_PATH.'/var/tmp', PCLZIP_OPT_REPLACE_NEWER);
		if ((!is_array($aResult)) || ($aResult[0]['status'] != 'ok'))
		{
	        $this->_logError('Error extracting plugin definition file: '.$aResult[0]['status'].' : '.$aResult[0]['stored_filename']);
	        $this->errcode = OX_PLUGIN_ERROR_PACKAGE_EXTRACT_FAILED;
	        return false;
		}
		$pathPackages = '/var/tmp'.$this->pathPackages;
	    $aPackage = $this->_parsePackage(MAX_PATH.$pathPackages.$pkgFile);
	    @unlink(MAX_PATH.$pathPackages.$pkgFile);
        if (!$aPackage || (!is_array($aPackage)))
        {
            $this->_logError('Failed to parse the plugin definition '.$pkgFile);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_PARSE_FAILED;
            return false;
        }
        if (!($overwrite) && array_key_exists($aPackage['name'],$GLOBALS['_MAX']['CONF']['plugins']))
        {
            $this->_logError('Plugin with this name is already installed '.$aPackage['name']);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_NAME_EXISTS;
            return false;
        }
        if (empty($aPackage['version']))
        {
            $this->_logError('Failed to retrieve version from the plugin definition '.$pkgFile);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_VERSION_NOT_FOUND;
            return false;
        }
        if ($aExpectedPackage['version'] && ($aExpectedPackage['version']!=$aPackage['version']))
        {
            $this->_logError('Version found '.$aPackage['version'].' is not that expected '.$aExpectedPackage['version']);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_VERSION_NOT_FOUND;
            return false;
        }
        if (count($aPackage['install']['contents']) != count($aXMLFiles))
        {
            $this->_logError('Expected '.count($aPackage['install']['contents']).' definitions but found '.count($aXMLFiles));
            $this->errcode = OX_PLUGIN_ERROR_PLUGIN_DEFINITION_MISSING;
            return false;
        }
        foreach ($aPackage['install']['contents'] AS $aItem)
        {
            if (!array_key_exists($aItem['name'].'.xml', $aXMLFiles))
            {
                $this->_logError('Group definition missing from plugin '.$pkgFile.' -> '. $aItem['name'].'.xml');
                $this->errcode = OX_PLUGIN_ERROR_PACKAGE_CONTENTS_MISMATCH;
                return false;
            }
            $aResult = $oZip->extractByIndex($aXMLFiles[$aItem['name'].'.xml']['storedinfo']['index'], PCLZIP_OPT_ADD_PATH, MAX_PATH.'/var/tmp', PCLZIP_OPT_REPLACE_NEWER);
    		if ((!is_array($aResult)) || ($aResult[0]['status'] != 'ok'))
    		{
    	        $this->_logError('Error extracting group definition file: '.$aResult[0]['status'].' : '.$aResult[0]['stored_filename']);
    	        $this->errcode = OX_PLUGIN_ERROR_PLUGIN_EXTRACT_FAILED;
    	        return false;
    		}
        }
		$pathPackagesOld = $this->pathPackages;
		$this->pathPackages = '/var/tmp'.$this->pathPackages;
        $aPlugins = $this->_parseComponentGroups($aPackage['install']['contents']);
        foreach ($aXMLFiles AS $i => $aFile)
        {
            @unlink(MAX_PATH.'/var/tmp/'.$aFile['storedinfo']['filename']);
            @rmdir(dirname(MAX_PATH.'/var/tmp/'.$aFile['storedinfo']['filename']));
        }
	    $this->pathPackages = $pathPackagesOld;
        if (!$aPlugins || (!is_array($aPlugins)))
        {
            $this->_logError('Failed to parse the component groups in package '.$pkgFile);
            $this->errcode = OX_PLUGIN_ERROR_PLUGIN_PARSE_FAILED;
            return false;
        }
        $aFilesExpected = array();
        $nFilesExpected = 0;
        // get the list of files belonging to the package 'wrapper' (should only be a 'readme' file)
        foreach ($aPackage['install']['files'] AS $aFiles)
        {
            $aFilesExpected[$aPackage['name']][] = $aFiles;
            $nFilesExpected++;
        }
        // get the list of files belonging to each plugin
        foreach ($aPlugins as $idx => $aPlugin)
        {
            if ((!$overwrite) && array_key_exists($aPlugin['name'],$GLOBALS['_MAX']['CONF']['pluginGroupComponents']))
            {
                $this->_logError('Component group with this name is already installed '.$aPlugin['name']);
                $this->errcode = OX_PLUGIN_ERROR_PLUGIN_NAME_EXISTS;
                return false;
            }
            $aFilesExpected[$aPlugin['name']] = $aPlugin['install']['files'];
            $nFilesExpected+= count($aPlugin['install']['files']);

            $pluginPath = OX_PLUGIN_GROUPPATH.'/etc/';

            if ($aPlugin['install']['prescript'])
            {
                $aFilesExpected[$aPlugin['name']][] = array(
                                                            'path'=>$pluginPath,
                                                            'name'=>$aPlugin['install']['prescript']
                                                           );
                $nFilesExpected++;
            }
            if ($aPlugin['install']['postscript'])
            {
                $aFilesExpected[$aPlugin['name']][] = array(
                                                            'path'=>$pluginPath,
                                                            'name'=>$aPlugin['install']['postscript']
                                                           );
                $nFilesExpected++;
            }
            if ($aPlugin['install']['schema']['mdb2schema'])
            {
                $aFilesExpected[$aPlugin['name']][] = array(
                                                            'path'=>$pluginPath,
                                                            'name'=>$aPlugin['install']['schema']['mdb2schema'].'.xml',
                                                           );
                $nFilesExpected++;
            }
            if ($aPlugin['install']['schema']['dboschema'])
            {
                $aFilesExpected[$aPlugin['name']][] = array(
                                                            'path'=>$pluginPath.'DataObjects/',
                                                            'name'=>$aPlugin['install']['schema']['dboschema'].'.ini',
                                                           );
                $nFilesExpected++;
            }
            if ($aPlugin['install']['schema']['dbolinks'])
            {
                $aFilesExpected[$aPlugin['name']][] = array(
                                                            'path'=>$pluginPath.'DataObjects/',
                                                            'name'=>$aPlugin['install']['schema']['dbolinks'].'.ini',
                                                           );
                $nFilesExpected++;
            }
            foreach ($aPlugin['install']['schema']['dataobjects'] as $k => $v)
            {
                $aFilesExpected[$aPlugin['name']][] = array(
                                                            'path'=>$pluginPath.'DataObjects/',
                                                            'name'=>$v,
                                                           );
                $nFilesExpected++;
            }
        }
        // now see if the files expected match the files in the zipfile
        if ($nFilesExpected != count($aFilesStored))
        {
            $this->_logError($nFilesExpected.' files expected but '.count($aFilesStored).' found');
            $this->errcode = OX_PLUGIN_ERROR_FILE_COUNT_MISMATCH;
            return false;
        }

        foreach ($aFilesExpected AS $pluginName => $aPluginFilesExpected)
        {
            foreach ($aPluginFilesExpected AS $i => $aFileExpected)
            {
                $fileExpected = $aFileExpected['path'].$aFileExpected['name'];
                $fileExpected = $this->_expandFilePath($aFileExpected['path'], $aFileExpected['name'], $pluginName);
                if ($fileExpected == $aFileExpected['path'].$aFileExpected['name'])
                {
                    $this->_logError('Illegal file location found :'.$fileExpected);
                    $this->errcode = OX_PLUGIN_ERROR_ILLEGAL_FILE;
                    return false;
                }
                $found = false;
                foreach ($aFilesStored AS $n => $fileStored)
                {
                    if ($fileStored == $fileExpected)
                    {
                        unset($aFilesStored[$n]);
                        $found = true;
                        break;
                    }
                    //$this->_logMessage($fileStored.' != '.$fileExpected);
                }
                if (!$found)
                {
                    $aFilesNotFound[] = $fileExpected;
                }
            }
        }
        if (count($aFilesStored) > 0)
        {
            $this->_logError(count($aFilesStored).' unexpected files found');
            foreach ($aFilesStored as $file)
            {
                $this->_logError($file);
            }
            $this->errcode = OX_PLUGIN_ERROR_PLUGIN_DECLARATION_MISMATCH;
        }
        if (count($aFilesNotFound) > 0)
        {
            $this->_logError(count($aFilesNotFound).' expected files not found');
            foreach ($aFilesNotFound as $file)
            {
                $this->_logError($file);
            }
            $this->errcode = OX_PLUGIN_ERROR_PLUGIN_DECLARATION_MISMATCH;
        }
        if ($this->errcode == OX_PLUGIN_ERROR_PLUGIN_DECLARATION_MISMATCH)
        {
            return false;
        }
        $this->errcode = OX_PLUGIN_ERROR_PACKAGE_OK;
		return array('package'=>$aPackage, 'plugins'=>$aPlugins);
    }

    /**
     * use the pclZip lib to decompress the file
     *
     * the following files can be acquired and used to trace errors if necessary
     * require_once( MAX_PATH . '/lib/pclzip/pclerror.lib.php' );
     * require_once( MAX_PATH . '/lib/pclzip/pcltrace.lib.php' );
     * require_once( MAX_PATH . '/lib/pclzip/pcltar.lib.php' );
     *
     *
     * @param string $file
     * @param string $relPath
     * @return array | boolean false on error
     */
    function _decompressFile($source, $target, $overwrite=false)
    {
		require_once( MAX_PATH . '/lib/pclzip/pclzip.lib.php' );

    	define('OS_WINDOWS',((substr(PHP_OS, 0, 3) == 'WIN') ? 1 : 0));
		$oZip = new PclZip( $source );

		if (!$overwrite)
		{
		  $result = $oZip->extract( PCLZIP_OPT_PATH, $target );
		}
		else
		{
		    $result = $oZip->extract( PCLZIP_OPT_REPLACE_NEWER, PCLZIP_OPT_PATH, $target );
		}
		if($result == 0)
		{
		    $this->_logError('Unrecoverable decompression error: '.$oZip->errorName(true));
			return false;
		}

        foreach ($result as $i => $aInfo)
        {
            if ($aInfo['status'] != 'ok')
            {
                switch ($aInfo['status'])
                {
                    case 'path_creation_fail':
                    case 'write_error':
                    case 'read_error':
                    case 'invalid_header':
                    case 'newer_exist':
                        $this->_logError('Error: '.$aInfo['status'].' : '.$aInfo['filename']);
                        $error = true;
                        break;
                    case 'already_a_directory':
                    case 'filtered':
                    default:
                        break;
                }
            }
        }
        return ($error ? false : $result);
    }

    function checkForUpdates($aParams)
    {
        require_once ('XML/RPC.php' );
        $message = new XML_RPC_Message('OXPS.checkForUpdate', array(
            XML_RPC_encode($aParams)
        ));
        $aConf  = $GLOBALS['_MAX']['CONF']['pluginUpdatesServer'];
        $client = new XML_RPC_Client($aConf['path'].'/xmlrpc.php',$aConf['host'], $aConf['httpPort']);
        $client->debug  = 0;
        // Send the XML-RPC message to the server
        $response = $client->send($message, 60, 'http');

        // Assign the response code strings
        if ($response && $response->faultCode() == 0)
        {
            $response = XML_RPC_decode($response->value());

            switch ($response['status'])
            {
                case 0:
                    if (substr($response['downloadurl'],0,7) == '{local}')
                    {
                        $response['downloadurl'] = str_replace('{local}',$aConf['host'],$response['downloadurl']);
                    }
                    $aResult[] = '<a href="http://'.$response['downloadurl'].'" target="_blank">Download Now</a>';

                    break;
            }
            return $response;
        }
        else
        {
            $this->_logError($response->fs);
            return false;
        }
    }

}

?>
