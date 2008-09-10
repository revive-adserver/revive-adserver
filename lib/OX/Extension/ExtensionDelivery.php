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

require_once(LIB_PATH.'/Extension/ExtensionCommon.php');
require_once(LIB_PATH.'/Extension/deliveryLog/Setup.php');

class OX_Extension_Delivery extends OX_Extension_Common
{

    function __construct()
    {

    }

    function runTasksAfterPluginInstall()
    {
        parent::runTasksAfterPluginInstall();
        return $this->_cacheDeliveryHooks();
    }

    function runTasksAfterPluginUninstall()
    {
        parent::runTasksAfterPluginUninstall();
        return $this->_cacheDeliveryHooks();
    }

    function runTasksAfterPluginEnable()
    {
        parent::runTasksAfterPluginEnable();
        return $this->_cacheDeliveryHooks();
    }

    function runTasksAfterPluginDisable()
    {
        parent::runTasksAfterPluginDisable();
        return $this->_cacheDeliveryHooks();
    }

    /**
     * For execution of house-keeping tasks
     * initiated from the configuration admin menu
     *
     * @return boolean
     */
    function runTasksOnDemand()
    {
        return $this->_cacheDeliveryHooks();
    }

    function _cacheDeliveryHooks()
    {
        require_once LIB_PATH . '/Plugin/PluginManager.php';
        $oPluginManager = new OX_PluginManager();
        $aHooks = $oPluginManager->getComponentHooks();
        $this->_saveComponentHooks($aHooks);
        $this->_generateDeliveryHooksCacheFile($aHooks);
    }


    /**
     * This method takes the array of registered hooks from the plugin/component group's XML files and saves a structured list in the config file
     *
     * @return boolean True if writing the config file change was sucessful false otherwise
     */
    function _saveComponentHooks($aHooks = array())
    {
        $oSettings = new OA_Admin_Settings();
        if (!$oSettings)
        {
            return false;
        }
        // Clear out any existing hooks
        $oSettings->aConf['deliveryHooks'] = array();
        foreach ($aHooks as $hookName => $aComponentIdentifiers) {
            $aComponentIdentifiers = $this->orderDependencyComponents($hookName, $aComponentIdentifiers, $aHooks);
            $oSettings->settingChange('deliveryHooks', $hookName, implode('|', $aComponentIdentifiers));
        }
        return $oSettings->writeConfigChange();
    }

    /**
     * This method allows to set the components in the order of their dependency
     * between each other.
     *
     * @param string $hookName  Hook name
     * @param array $aComponentIdentifiers  Array of components assigned to sorted hook
     * @param array $aHooks  Array with all hooks and all components in the system
     * @return unknown
     */
    function orderDependencyComponents($hookName, $aComponentIdentifiers = array(), $aHooks = array())
    {
        switch ($hookName) {
            case 'logClick':
            case 'logConversion':
            case 'logConversionVariable':
            case 'logImpression':
            case 'logRequest':
                $deliveryLogSetup = new OX_Plugins_DeliveryLog_Setup();
                return $deliveryLogSetup->getDependencyOrderedPlugins($aComponentIdentifiers, $aHooks);
                break;
            default:
                return $aComponentIdentifiers;
        }
    }

    /**
     * This method takes the array of registered hooks from the plugin/component
     * group's XML files, merge the delivery plugins files into one file
     * and save such cache in var folder.
     *
     * @return boolean True if writing the config file change was sucessful false otherwise
     */
    function _generateDeliveryHooksCacheFile($aHooks = array())
    {
        $deliveryLogSetup = new OX_Plugins_DeliveryLog_Setup();
        return $deliveryLogSetup->regenerateDeliveryPluginsCodeCache($aHooks);
    }

}

?>