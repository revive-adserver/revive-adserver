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
$Id: Controller.up.test.php 43405 2009-09-18 11:25:38Z lukasz.wikierski $
*/

require_once MAX_PATH . '/lib/OX/Upgrade/InstallPlugin/Controller.php';


/**
 * A class for testing the OX_Upgrade_InstallPlugin_Controller
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_InstallPlugin_ControllerTest extends UnitTestCase 
{
    
    function testgetTasksUrls()
    {
        // Mock install status to mark update process
        Mock::generatePartial(
            'OX_Admin_UI_Install_InstallStatus',
            'OX_Admin_UI_Install_InstallStatusMock',
            array('isUpgrade')
        );
        $oInstallStatus = new OX_Admin_UI_Install_InstallStatusMock($this);
        $oInstallStatus->setReturnValue('isUpgrade', true);
        
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        @$oStatus = $oStorage->set('installStatus', $oInstallStatus);
        
        include MAX_PATH.'/etc/default_plugins.php';
        
        // set default plugins as installed except last one
        
        foreach ($aDefaultPlugins as $idx => $aPlugin) {
            $GLOBALS['_MAX']['CONF']['plugins'][$aPlugin['name']] = true;
            $lastPlugin = $aPlugin['name'];
            $lastPluginData = $aPlugin;
        }
        unset($GLOBALS['_MAX']['CONF']['plugins'][$lastPlugin]);
        
        $baseInstallUrl = 'my base url';
        $GLOBALS['strPluginTaskChecking'] = 'Checking';
        $GLOBALS['strPluginTaskInstalling'] = 'Installing';
        $aExpected = array();
        foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $pluginName => $pluginEnabled) {
            $aExpected[] = array(
                'id' => 'plugin:'.$pluginName,
                'name' => $GLOBALS['strPluginTaskChecking'].': '.$pluginName,
                'url' => $baseInstallUrl.'install-plugin.php?status=1&plugin='.$pluginName
            );
        }
        $aExpected[] = array(
            'id' => 'plugin:'.$lastPlugin,
            'name' => $GLOBALS['strPluginTaskInstalling'].': '.$lastPlugin,
            'url' => $baseInstallUrl.'install-plugin.php?status=0&plugin='.$lastPlugin.
                     ((empty($lastPluginData['disabled'])) ? '' : '&disabled=1') 
        );

        $result = OX_Upgrade_InstallPlugin_Controller::getTasksUrls($baseInstallUrl);
        $this->assertEqual($result, $aExpected);
        $oStatus = $oStorage->set('installStatus', null);
    }
}
