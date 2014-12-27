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

require_once MAX_PATH.'/lib/OX/Admin/UI/SessionStorage.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Install/InstallStatus.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Install/InstallUtils.php';


/**
 * Controller to get install plugin tasks urls
 *
 * @package    OpenXUpgrade
 */
class OX_Upgrade_InstallPlugin_Controller
{

    private static $DEPRECATED_PLUGINS = array(
        'openXMarket',
        'openXWorkflow'
    );

    /**
     * Prepare urls to run install plugin tasks
     *
     * @param string $baseInstalUrl Base install URL (prepared by
     *                              OX_Admin_UI_Controller_Request::getBaseUrl)
     * @return array Array of arrays of 'id', name' and 'url' strings
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
                'id'   => 'plugin:' . $name,
                'name' => $GLOBALS['strPluginTaskChecking'] . ': <br/> ' .
                          OX_Upgrade_InstallPlugin_Controller::openxToRevivePluginName($name),
                'url'  => $baseInstallUrl . 'install-plugin.php?status=0&plugin=' . $name . '&disabled=1'
            );
        }
        closedir($PLUGINS_DIR);

        // Get installed plugins if upgrade
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();
        $oStatus = $oStorage->get('installStatus');
        if (isset($oStatus) && $oStatus->isUpgrade()) {
            foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled) {
                if (in_array($name, self::$DEPRECATED_PLUGINS)) {
                    $status = '2'; // Remove plugin; deprecated
                } else {
                    $status = '1'; // Install or migrate
                }

                $displayName = $name;
                $oPluginManager = new OX_PluginManager();
                $aPackageInfo = $oPluginManager->getPackageInfo($name);
                if ($aPackageInfo['displayname']) {
                    $displayName = $aPackageInfo['displayname'];
                }

                $aUrls[] = array(
                    'id'   => 'plugin:' . $name,
                    'name' => $GLOBALS['strPluginTaskChecking'].': <br/> ' .
                              OX_Upgrade_InstallPlugin_Controller::openxToRevivePluginName($displayName),
                    'url'  => $baseInstallUrl . 'install-plugin.php?status=' . $status . '&plugin=' . $name);
                unset($aPluginZips[$name]);
            }
        }

        // Get the list of bundled plugins, retain order
        include MAX_PATH.'/etc/default_plugins.php';
        if ($aDefaultPlugins) {
            foreach ($aDefaultPlugins AS $idx => $aPlugin) {
                if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins'])) {
                    $url = $baseInstallUrl . 'install-plugin.php?status=0&plugin=' . $aPlugin['name'];
                    if (!empty($aPlugin['disabled'])) {
                        $url .= '&disabled=1';
                    }
                    $aUrls[] = array(
                        'id'   => 'plugin:' . $aPlugin['name'],
                        'name' => $GLOBALS['strPluginTaskInstalling'] . ': <br/> ' .
                                  OX_Upgrade_InstallPlugin_Controller::openxToRevivePluginName($aPlugin['name']),
                        'url'  => $url
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

    /**
     * A static method that can be used by
     * OX_Upgrade_InstallPlugin_Controller::getTasksUrls() to modify plugin
     * names as displayed in the UI when installing or upgrading plugins which
     * still have old OpenX-based filenames, so that they use the desired
     * new Revive Adserver names for the plugins. A hack, but saves re-writing
     * the plugin system to handle migration of plugins from one filename to
     * another.
     *
     * @param string $pluginName The original, filename-based plugin name
     * @return string The new plugin name, or the original if no match found.
     */
    static function openxToRevivePluginName($pluginName)
    {
        switch ($pluginName) {
            case "openXBannerTypes":
                return "Banner Types Plugin";
            case "openXDeliveryLimitations":
                return "Delivery Limitations Plugin";
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