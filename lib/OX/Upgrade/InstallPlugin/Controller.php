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
$Id: Controller.php 43465 2009-09-21 08:47:55Z bernard.lange $
*/

require_once MAX_PATH.'/lib/OX/Admin/UI/SessionStorage.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Install/InstallStatus.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Install/InstallUtils.php';


/**
 * Controller to get install plugin tasks urls
 * 
 * @package    OpenXUpgrade
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_InstallPlugin_Controller
{
    
    /**
     * Prepare urls to run install plugin tasks
     *
     * @param string $baseInstalUrl base install url (prepared by OX_Admin_UI_Controller_Request::getBaseUrl)
     * @param OA_Upgrade $oUpgrade optional
     * @return array array of arrays of 'name' and 'url' strings 
     */
    static function getTasksUrls($baseInstallUrl)
    {      
        $aUrls = array();  
        $aPluginZips = array();
        
        // Collect all plugin files present in the etc/plugins folder...
        $PLUGINS_DIR = opendir(MAX_PATH . '/etc/plugins');
        while ($file = readdir($PLUGINS_DIR)) {
            if ((substr($file, 0, 1) == '.') || (substr($file, strrpos($file, '.')) != '.zip')) { continue; }
            $name = substr($file, 0, strrpos($file, '.'));
            $aPluginZips[$name] = array(
                'id'    => 'plugin:' . $name,
                'name'  => $GLOBALS['strPluginTaskChecking'].': ' . $name, 
                'url'   => $baseInstallUrl . 'install-plugin.php?status=0&plugin=' . $name . '&disabled=1'
            );
        }
        closedir($PLUGINS_DIR);
        
        // Get installed plugins if upgrade
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        $oStatus = $oStorage->get('installStatus');
        if (isset($oStatus) && $oStatus->isUpgrade()) {
            foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled) {
                $aUrls[] = array(
                    'id' => 'plugin:'.$name,
                    'name' => $GLOBALS['strPluginTaskChecking'].': '.$name,
                    'url' => $baseInstallUrl.'install-plugin.php?status=1&plugin='.$name);
                unset($aPluginZips[$name]);
            }
        }

        // get the list of bundled plugins, retain order
        include MAX_PATH.'/etc/default_plugins.php';
        if ($aDefaultPlugins) {
            foreach ($aDefaultPlugins AS $idx => $aPlugin) {
                if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins'])) {
                    $url = $baseInstallUrl.'install-plugin.php?status=0&plugin='.$aPlugin['name'];
                    if (!empty($aPlugin['disabled'])) {
                        $url .= '&disabled=1';
                    }
                    $aUrls[] = array(
                        'id' => 'plugin:'.$aPlugin['name'],
                        'name' => $GLOBALS['strPluginTaskInstalling'].': '.$aPlugin['name'], 
                        'url' => $url
                    );
                    unset($aPluginZips[$aPlugin['name']]); 
                }
            }
        }
        
        // Anything left in the $aPluginsZip array are unknown plugins, should be installed but disabled 
        foreach ($aPluginZips as $pluginName => $pluginArray) { 
            $aUrls[] = $pluginArray; 
        }
        
        return $aUrls;
    }


}