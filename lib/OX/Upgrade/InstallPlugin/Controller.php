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
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
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
                if (in_array($name, self::$DEPRECATED_PLUGINS)) {
                    $status = '2'; // Remove plugin; deprecated
                } else {
                    $status = '1'; // Install or migrate
                }

                $aUrls[] = array(
                    'id' => 'plugin:'.$name,
                    'name' => $GLOBALS['strPluginTaskChecking'].': '.$name,
                    'url' => $baseInstallUrl.'install-plugin.php?status='.$status.'&plugin='.$name);
                unset($aPluginZips[$name]);
            }
        }

        // Get the list of bundled plugins, retain order
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