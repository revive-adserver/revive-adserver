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

require_once MAX_PATH . '/lib/OX/Upgrade/InstallPlugin/Controller.php';


/**
 * A class for testing the OX_Upgrade_InstallPlugin_Controller
 *
 * @package    OpenX
 * @subpackage TestSuite
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
                'name' => $GLOBALS['strPluginTaskChecking'].': <br/> '.$this->_correctPluginName($pluginName),
                'url' => $baseInstallUrl.'install-plugin.php?status=1&plugin='.$pluginName
            );
        }
        $aExpected[] = array(
            'id' => 'plugin:'.$lastPlugin,
            'name' => $GLOBALS['strPluginTaskInstalling'].': <br/> '.$this->_correctPluginName($lastPlugin),
            'url' => $baseInstallUrl.'install-plugin.php?status=0&plugin='.$lastPlugin.
                     ((empty($lastPluginData['disabled'])) ? '' : '&disabled=1')
        );

        $result = OX_Upgrade_InstallPlugin_Controller::getTasksUrls($baseInstallUrl);
        $this->assertEqual($result, $aExpected);
        $oStatus = $oStorage->set('installStatus', null);
    }

    function _correctPluginName($pluginName)
    {
        switch ($pluginName) {
            case "openXBannerTypes":
                return "Banner Types Plugin";
            case "openXDeliveryLimitations":
                return "Delivery Rules Plugin";
            case "openX3rdPartyServers":
                return "3rd Party Servers Plugin";
            case "openXReports":
                return "Reports Plugin";
            case "openXDeliveryCacheStore":
                return "Banner Delivery Cache Store Plugin";
            case "openXMaxMindGeoIP":
                return "MaxMind GeoIP Plugin";
            case "openXInvocationTags":
                return "Invocation Tags Plugin";
            case "openXDeliveryLog":
                return "Banner Delivery Logging Plugin";
            case "openXVideoAds":
                return "IAB VAST Plugin";
        }
        return $pluginName;
    }

}

?>