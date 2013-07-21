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
    function __construct()
    {

    }

    function runTasksAfterPluginInstall()
    {
        $this->cachePreferenceOptions();
        $this->cacheComponentHooks();
        return true;
    }

    function runTasksAfterPluginUninstall()
    {
        $this->cachePreferenceOptions();
        $this->cacheComponentHooks();
        return true;
    }

    function runTasksBeforePluginUninstall()
    {
        return true;
    }

    function runTasksBeforePluginInstall()
    {
        return true;
    }

    function runTasksBeforePluginEnable()
    {
        return true;
    }

    function runTasksAfterPluginEnable()
    {
        $this->cachePreferenceOptions();
        $this->cacheComponentHooks();
        return true;
    }

    function runTasksBeforePluginDisable()
    {
        return true;
    }

    function runTasksAfterPluginDisable()
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
    function cacheComponentHooks()
    {
        $oPluginManager = new OX_PluginManager();
        $aHooks = $oPluginManager->getComponentHooks();
        $oCache = $oPluginManager->_getOA_Cache('Plugins', 'ComponentHooks');
        $oCache->setFileNameProtection(false);
        return $oCache->save($aHooks);
    }

    function getCachedComponentHooks()
    {
        require_once(MAX_PATH.'/lib/OA/Cache.php');
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
   function cachePreferenceOptions()
    {
        $oComponentGroupManager = new OX_Plugin_ComponentGroupManager();
        $aComponentGroups = ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] ? $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] : array());
        $aOptions = array();

        foreach ($aComponentGroups AS $name => $enabled)
        {
            if ($enabled || OA_Permission::getAccountType()==OA_ACCOUNT_ADMIN)
            {
                $aConfig[$name] = $oComponentGroupManager->_getComponentGroupConfiguration($name);
                if (count($aConfig[$name]['preferences']))
                {
                    $aOptions[$name] =  array(
                                                'name' => $name,
                                                'text' => ($aConfig[$name]['option'] ? $aConfig[$name]['option'] : $name),
                                                'value' => 'account-preferences-plugin.php?group='.$name,
                                                'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                                             );
                }
            }
        }
        $oCache = $oComponentGroupManager->_getOA_Cache('Plugins', 'PrefOptions');
        $oCache->setFileNameProtection(false);
        return $oCache->save($aOptions);
    }

    function getPluginsDiagnostics()
    {
        require_once LIB_PATH.'/Plugin/PluginManager.php';
        $oPluginManager = new OX_PluginManager();
        $aPlugins = ($GLOBALS['_MAX']['CONF']['plugins'] ? $GLOBALS['_MAX']['CONF']['plugins'] : array());
        $aComponentGroups = ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] ? $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] : array());

        foreach ($aPlugins AS $name => $enabled)
        {
            $aPlugin = $oPluginManager->getPackageDiagnostics($name, true);
            $aResult['detail'][] = $aPlugin;
            $aGroups = $aPlugin['groups'];
            $aPlugin = $aPlugin['plugin'];
            if ($aPlugin['error'])
            {
                foreach ($aPlugin['errors'] AS $i => $msg)
                {
                    $aResult['errors'][] = $name.': '.$msg;
                }
            }
            foreach ($aGroups as $i => &$aGroup)
            {
                if (array_key_exists($aGroup['name'],$aComponentGroups))
                {
                    unset($aComponentGroups[$aGroup['name']]);
                }
                if ($aGroup['error'])
                {
                    foreach ($aGroup['errors'] AS $i => $msg)
                    {
                        $aResult['errors'][] = $aGroup['name'].': '.$msg;
                    }
                    $aPlugin['error'] = true;
                }
            }
            $aResult['simple'][] = array('name'=>$aPlugin['name'], 'version'=>$aPlugin['version'], 'enabled'=>$enabled, 'error'=>$aPlugin['error']);
        }
        foreach ($aComponentGroups AS $name => $enabled)
        {
            $aResult['errors'][] = $name.': '.' is configured as installed but not found to exist';
        }
        return $aResult;
    }

    function runTasksOnDemand($task='')
    {
        if ($task)
        {
           if (method_exists($this, $task));
           {
               $this->$task();
           }

        }
    }
}

?>