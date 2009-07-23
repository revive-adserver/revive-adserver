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


error_reporting(E_ERROR);
//error_reporting(E_ALL);

require_once '../../init.php';
require_once LIB_PATH . '/Plugin/PluginManager.php';

/**
 * a subclass of OX_PluginManager
 * instead of use UI base request to determine whether disabled
 * pass a parameter to do this
 */
class UPGRADE_PluginManager extends OX_PluginManager
{
    /**
     * parse a package definition file
     * parse each of the plugins contained therein
     * install each of the plugins contained therein
     * set the conf value of the package to installed but disabled
     *
     * @param array $aFile
     * @param int $disabled = 0 means enabled
     * @return boolean
     */
    function installPackage($aFile, $disabled=0)
    {
        //OA::logMem('enter installPackage');
        if (!$this->unpackPlugin($aFile, false))
        {
            return false;
        }
        $this->_switchToPluginLog();
        try {
            $aPackage = &$this->aParse['package'];
            $aPlugins = &$this->aParse['plugins'];
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
            echo "installcomponent : ". $aPackage['name']."\n";
            if (!$this->_installComponentGroups($aPlugins))
            {
                $this->_logError('Failed to install plugins for package '.$aPackage['name']);
                $this->_uninstallComponentGroups($aPlugins);
                echo "Error in installcomponent : ". $aPackage['name']."\n";
                throw new Exception();
            }
            // this sets up conf but leaves package disabled
            echo "register package : ". $aPackage['name']."\n";
            if (!$this->_registerPackage($aPackage['name']))
            {
                echo "Error at register package : ". $aPackage['name']."\n";
                throw new Exception();
            }
            echo "audit update : ". $aPackage['name']."\n";
            $this->_auditUpdate(array('description'=>'PACKAGE INSTALL COMPLETE',
                                      'action'=>UPGRADE_ACTION_INSTALL_SUCCEEDED,
                                      'id' => $auditId,
                                     )
                               );
            $this->_runExtensionTasks('AfterPluginInstall');
            $result = true;
        } catch (Exception $e) {
            $this->_logError($e->getMessage());
            $result = false;
        }
        echo "enableOnInstall=".$GLOBALS['_MAX']['CONF']['pluginSettings']['enableOnInstall']."\n";
        if (!empty($GLOBALS['_MAX']['CONF']['pluginSettings']['enableOnInstall']) && ($disabled===0)) {
            echo "enable package\n";
            $this->enablePackage($aPackage['name']);
        }
        
        //OA::logMem('exit installPackage');
        $this->_switchToDefaultLog();
        return $result;
    }

    function _setPackage($name, $enabled=0)
    {
        $oSettings = $this->_instantiateClass('OA_Admin_Settings');
        if (!$oSettings)
        {
            return false;
        }
        echo "setting change for plugins: name=$name, enabled=$enabled\n";
        $oSettings->settingChange('plugins',$name,$enabled);
        echo "!!!! write ConfigChange !!!\n";
        return $oSettings->writeConfigChange();
    }

    function getComponentHooks()
    {
        $aPackages = $GLOBALS['_MAX']['CONF']['plugins'];
        $aResult = array();
        foreach ($aPackages AS $name => $enabled)
        {
            echo "get component hooks for $name\n";
            if ($enabled)
            {
                $aPkgInfo = $this->getPackageInfo($name);
                foreach ($aPkgInfo['contents'] AS &$componentGroup)
                {
                    if (isset($componentGroup['components']))
                    {
                        foreach ($componentGroup['components'] as $componentName => &$aComponent)
                        {
                            if (isset($aComponent['hooks']))
                            {
                                foreach ($aComponent['hooks'] as &$hook)
                                {
                                    $aResult[$hook][] = $componentGroup['extends'] . ':' . $componentGroup['name'] . ':' . $componentName;
                                    echo "get real component hooks for $name\n";
                                }
                            }
                        }
                    }
                }
            }
        }
        return $aResult;
    }


}
