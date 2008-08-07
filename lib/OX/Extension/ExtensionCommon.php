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

    function cachePreferenceOptions()
    {
        require_once LIB_PATH.'/Plugin/ComponentGroupManager.php';
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

    function runTasksOnDemand()
    {
        $this->cachePreferenceOptions();
    }
}

?>