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

require_once(LIB_PATH.'/Extension/ExtensionCommon.php');
require_once(LIB_PATH.'/Extension/deliveryLog/Setup.php');

/**
 * @package    OpenXExtension
 */
class OX_Extension_Delivery extends OX_Extension_Common
{

    function __construct()
    {

    }

    function runTasksAfterPluginInstall()
    {
        parent::runTasksAfterPluginInstall();
        //return $this->_cacheDeliveryHooks();
    }

    function runTasksAfterPluginUninstall()
    {
        parent::runTasksAfterPluginUninstall();
        //return $this->_cacheDeliveryHooks();
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
    function runTasksOnDemand($task='')
    {
        return $this->_cacheDeliveryHooks();
    }

    function _cacheDeliveryHooks()
    {
        //require_once MAX_PATH.'/lib/OA.php';
        //OA::logMem('enter _cacheDeliveryHooks()');
        $aHooks = $this->getCachedComponentHooks();
        $this->_saveComponentHooks($aHooks);
        $this->_generateDeliveryHooksCacheFile($aHooks);
        //OA::logMem('exit _cacheDeliveryHooks()');
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
        foreach ($aHooks as $hookName => &$aComponentIdentifiers)
        {
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
                $deliveryLogSetup = new OX_Extension_DeliveryLog_Setup();
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
        $deliveryLogSetup = new OX_Extension_DeliveryLog_Setup();
        return $deliveryLogSetup->regenerateDeliveryPluginsCodeCache($aHooks);
    }

}

?>