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

require_once MAX_PATH . '/lib/OA/Permission.php';
require_once LIB_PATH . '/Plugin/PluginManager.php';

/**
 * Ancestor class for extension manager classes
 *
 * @package    OpenXExtension
 */
class OX_Extension_Common
{
    public function __construct()
    {
    }

    public function runTasksAfterPluginInstall()
    {
        $this->cachePreferenceOptions();
        $this->cacheComponentHooks();
        return true;
    }

    public function runTasksAfterPluginUninstall()
    {
        $this->cachePreferenceOptions();
        $this->cacheComponentHooks();
        return true;
    }

    public function runTasksBeforePluginUninstall()
    {
        return true;
    }

    public function runTasksBeforePluginInstall()
    {
        return true;
    }

    public function runTasksBeforePluginEnable()
    {
        return true;
    }

    public function runTasksAfterPluginEnable()
    {
        $this->cachePreferenceOptions();
        $this->cacheComponentHooks();
        return true;
    }

    public function runTasksBeforePluginDisable()
    {
        return true;
    }

    public function runTasksAfterPluginDisable()
    {
        $this->cachePreferenceOptions();
        $this->cacheComponentHooks();
        return true;
    }

    /**
     * caches hooks for enabled plugins only
     * indexed by hookname
     *
     * @return boolean
     */
    public function cacheComponentHooks()
    {
        $oPluginManager = new OX_PluginManager();
        $aHooks = $oPluginManager->getComponentHooks();
        $oCache = $oPluginManager->_getOA_Cache('Plugins', 'ComponentHooks');
        $oCache->setFileNameProtection(false);
        return $oCache->save($aHooks);
    }

    public function getCachedComponentHooks()
    {
        require_once(MAX_PATH . '/lib/OA/Cache.php');
        $oCache = new OA_Cache('Plugins', 'ComponentHooks');
        $oCache->setFileNameProtection(false);
        return $oCache->load(true);
    }
    /**
     * caches hooks for enabled plugins only
     * indexed by group name
     *
     * @return boolean
     */
    public function cachePreferenceOptions()
    {
        $oComponentGroupManager = new OX_Plugin_ComponentGroupManager();
        $aComponentGroups = ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] ? $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] : []);
        $aOptions = [];

        foreach ($aComponentGroups as $name => $enabled) {
            if ($enabled || OA_Permission::getAccountType() == OA_ACCOUNT_ADMIN) {
                $aConfig[$name] = $oComponentGroupManager->_getComponentGroupConfiguration($name);
                if (!empty($aConfig[$name]['preferences'])) {
                    $aOptions[$name] = [
                                                'name' => $name,
                                                'text' => ($aConfig[$name]['option'] ? $aConfig[$name]['option'] : $name),
                                                'value' => 'account-preferences-plugin.php?group=' . $name,
                                                'perm' => [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER]
                                             ];
                }
            }
        }
        $oCache = $oComponentGroupManager->_getOA_Cache('Plugins', 'PrefOptions');
        $oCache->setFileNameProtection(false);
        return $oCache->save($aOptions);
    }

    public function getPluginsDiagnostics()
    {
        require_once LIB_PATH . '/Plugin/PluginManager.php';
        $oPluginManager = new OX_PluginManager();
        $aPlugins = ($GLOBALS['_MAX']['CONF']['plugins'] ? $GLOBALS['_MAX']['CONF']['plugins'] : []);
        $aComponentGroups = ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] ? $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] : []);

        foreach ($aPlugins as $name => $enabled) {
            $aPlugin = $oPluginManager->getPackageDiagnostics($name, true);
            $aResult['detail'][] = $aPlugin;
            $aGroups = $aPlugin['groups'];
            $aPlugin = $aPlugin['plugin'];
            if ($aPlugin['error']) {
                foreach ($aPlugin['errors'] as $i => $msg) {
                    $aResult['errors'][] = $name . ': ' . $msg;
                }
            }
            foreach ($aGroups as $i => &$aGroup) {
                if (array_key_exists($aGroup['name'], $aComponentGroups)) {
                    unset($aComponentGroups[$aGroup['name']]);
                }
                if ($aGroup['error']) {
                    foreach ($aGroup['errors'] as $i => $msg) {
                        $aResult['errors'][] = $aGroup['name'] . ': ' . $msg;
                    }
                    $aPlugin['error'] = true;
                }
            }
            $aResult['simple'][] = ['name' => $aPlugin['name'], 'version' => $aPlugin['version'], 'enabled' => $enabled, 'error' => $aPlugin['error']];
        }
        foreach ($aComponentGroups as $name => $enabled) {
            $aResult['errors'][] = $name . ': ' . ' is configured as installed but not found to exist';
        }
        return $aResult;
    }

    public function runTasksOnDemand($task = '')
    {
        if ($task) {
            if (method_exists($this, $task));
            {
               $this->$task();
           }
        }
    }
}
