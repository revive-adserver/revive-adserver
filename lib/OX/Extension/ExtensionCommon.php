<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once LIB_PATH . '/Plugin/PluginManager.php';

/**
 * Ancestor class for extension manager classes
 *
 */

class OX_Extension_Common
{
    function __construct()
    {

    }

    function runTasksAfterPluginInstall()
    {
        $this->cachePreferenceOptions();
        return true;
    }

    function runTasksAfterPluginUninstall()
    {
        $this->cachePreferenceOptions();
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
        return true;
    }

    function runTasksBeforePluginDisable()
    {
        return true;
    }

    function runTasksAfterPluginDisable()
    {
        return true;
    }

    function cacheComponentHooks()
    {
        $oPluginManager = new OX_PluginManager();
        $aHooks = $oPluginManager->getComponentHooks();
        $oCache = $oPluginManager->_getOA_Cache('Plugins', 'ComponentHooks');
        $oCache->setFileNameProtection(false);
        return $oCache->save($aHooks);
    }

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
            foreach ($aGroups as $i => $aGroup)
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