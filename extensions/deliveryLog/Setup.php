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

require_once MAX_PATH . '/lib/OA/Plugin/Component.php';
require_once MAX_PATH . '/lib/OA/Plugin/ComponentGroupManager.php';
require_once MAX_PATH . '/lib/OA/Util/CodeMunger.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Ordered.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * Global location for storing merged plugins files code
 */
define('OX_BUCKETS_COMPILED_FILE', MAX_PATH.'/var/plugins/cache/mergedDeliveryFunctions.php');

/**
 * Generates delivery log plugins cache and order the dependencies
 * between components per each delivery log hook.
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_Log_Setup
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class OX_Plugins_DeliveryLog_Setup extends OX_Component
{
    const DATA_EXTENSION = 'deliveryDataPrepare';
    const LOG_EXTENSION  = 'deliveryLog';

    /**
     * Delivery logging related extension types
     *
     * @var array
     */
    private $extensionTypes = array(
        self::DATA_EXTENSION,
        self::LOG_EXTENSION
    );

    /**
     * @todo - get this template from external template file
     *
     * @var string
     */
    public $header = "<?php\n\n{TEMPLATE}\n\n?>";

    /**
     * Code generator
     *
     * @var OX_Util_CodeMunger
     */
    private $codeMunger;

    /**
     * Get list of deliveryLog hooks from deliveryLog plugins
     *
     * @param array $plugins
     * @return array  Array of hooks ['extension name']['hook'] = array of plugins code-names
     *                where a code name is extensionType:group:component
     */
    function groupPluginsByHooks($plugins)
    {
        $hooks = array();
        foreach ($plugins as $extension => $extPlugins) {
            foreach ($extPlugins as $pluginName => $aPluginData) {
                foreach ($aPluginData as $hookName => $aHook) {
                    $hooks[$extension][$hookName][] = $extension.':'.$pluginName.':'.$pluginName;
                }
            }
        }
        return $hooks;
    }

    /**
     * Check the dependencies for active delivery log components and
     * sort the in the correct order so each dependency is resolved.
     *
     * @param array $plugins
     * @param array $hooks
     * @return array
     */
    function getDependencyOrderedPlugins($aHooks, $aComponentIdentifiers)
    {
        $pluginsDependencies = $this->getPluginsDependencies($aComponentIdentifiers);
        if (!$pluginsDependencies) {
            return false;
        }
        $source = new OA_Algorithm_Dependency_Source_HoA($pluginsDependencies);
        $dep = new OA_Algorithm_Dependency_Ordered($source);
        return array_values($dep->schedule($aHooks));
    }

    /**
     * Includes all plugins, read their dependencies and order plugins according
     * to their required dependency
     *
     * Returns array of dependencies - name of each plugin from requested plugins array
     * with corresponding array of plugins names this plugin depends on.
     *
     * @param array $plugins
     * @return array  Dependencies array:
     *                  ['extensionType:group:plugin'] = array(
     *                      'extensionType:group:plugin',
     *                      'extensionType:group:plugin',
     *                  );
     */
    function getPluginsDependencies($plugins)
    {
        if (!$this->includePlugins($plugins)) {
            return false;
        }
        return $GLOBALS['_MAX']['pluginsDependencies'];
    }

    /**
     * Include components files
     *
     * @param array $plugins  Array of components
     * @return boolean  True on success, false if any error occured
     */
    function includePlugins($plugins)
    {
        static $aCacheComponents = array();
        foreach ($plugins as $hook => $hookComponents) {
            foreach ($hookComponents as $componentId) {
                if (isset($aCacheComponents[$componentId])) {
                    continue;
                }
                list($extension, $group, $componentName)
                    = $this->getExtensionGroupComponentFromId($componentId);
                $pluginFile = $this->getFilePathToPlugin($extension, $componentName);
                if (!$pluginFile) {
                    return false;
                }
                include($pluginFile);
                $aCacheComponents[$componentId] = true;
            }
        }
        return true;
    }

    /**
     * Change the component id code into array:
     * input: extension:group:component name
     * returns: array('extension', 'group', 'component name')
     *
     * @param string $componentId
     * @return array
     */
    function getExtensionGroupComponentFromId($componentId)
    {
        return explode(':', $componentId);
    }

    /**
     * Generated delivery component cache
     *
     * @param array $aHooks
     * @return boolean  True on success, else false
     */
    function regenerateDeliveryPluginsCodeCache($aHooks)
    {
        $componentsFiles = array();
        $mergedDelivery = '';
        foreach ($aHooks as $hookName => $hookComponents) {
            foreach ($hookComponents as $componentId) {
                list($extension, $group, $componentName) = $this->getExtensionGroupComponentFromId($componentId);
                $componentFile = $this->getFilePathToPlugin($extension, $componentName);
                if (!$componentFile) {
                    // error message - logging
                    return false;
                }
                $mungedComponent = $this->mungeFile($componentFile);
                if (!$mungedComponent) {
                    return false;
                }
                $mergedDelivery .= $mungedComponent;
            }
        }
        $mergedDelivery = $this->templateCode($mergedDelivery);
        return $this->saveMergedDelivery($mergedDelivery);
    }

    /**
     * Saves merged source code into output merged delivery cache
     *
     * @param string $mergedDelivery
     * @return boolean  True on success, else false
     */
    function saveMergedDelivery($mergedDelivery)
    {
        return file_put_contents(OX_BUCKETS_COMPILED_FILE, $mergedDelivery);
    }

    /**
     * Replaces the {TEMPLATE} mark with generated code
     *
     * @param string $sourceCode
     * @return string
     */
    function templateCode($sourceCode)
    {
        return str_replace('{TEMPLATE}', $sourceCode, $this->header);
    }

    /**
     * Cleans up (munge) the delivery file. For more info see OX_Util_CodeMunger
     *
     * @param string $file  Delivery file path
     * @return string  Generated source code
     */
    function mungeFile($file)
    {
        $codeMunger = $this->_getCodeMunger();
        $code = $codeMunger->flattenFile($file);
        return preg_replace(array('/^<\?php/', '/\?>$/'), array('', ''), $code);
    }

    /**
     * Returns OX_Util_CodeMunger.
     * This method can be used for mocking
     * in delivery.
     *
     * @return OX_Util_CodeMunger
     */
    function _getCodeMunger()
    {
        if (!$this->codeMunger) {
            $this->codeMunger = new OX_Util_CodeMunger();
        }
        return $this->codeMunger;
    }

    /**
     * Returns the file path to generate component based on its extension,
     * group and plugin names.
     *
     * @param string $extensionType
     * @param string $plugin
     * @param string $postfix
     * @return string   File name or false if such file do not exist
     */
    function getFilePathToPlugin($extensionType, $plugin, $postfix = '.delivery.php')
    {
        $oPluginMgr = $this->_getComponentGroupManager();
        $dirPath = MAX_PATH . $oPluginMgr->pathExtensions .
            $extensionType . '/' . $plugin.'/';
        $file = $dirPath . $plugin . $postfix;
        if (!file_exists($file)) {
            return false;
        }
        return $file;
    }

    /**
     * Reads in registered hooks from the plugin XML
     *
     * @param string $pluginName  Plugin name (should be same for both plugin group
     *                            and a plugin itself)
     * @return array
     */
    function getPluginRegisteredHooks($pluginName)
    {
        $oPluginMgr = $this->_getComponentGroupManager();
        $pluginFile = $oPluginMgr->getFilePathToXMLInstall($pluginName);
        $simpleXml = $this->_getSimpleXmlElement($pluginFile);
        if (!$simpleXml) {
            return false;
        }
        $hooks = array();
        foreach ($simpleXml->xpath("components/component") as $component) {
            $hookName = (string) $component->hook;
            $componentName = (string) $component->name;
            $hooks[$hookName][] = (string) $componentName;
        }
        return $hooks;
    }

    /**
     * Createas a new SimpleXMlElement object from given XML file
     *
     * @param string $pluginFile
     * @return SimpleXmlElement
     */
    function _getSimpleXmlElement($pluginFile)
    {
        if (!file_exists($pluginFile)) {
            return false;
        }
        return new SimpleXMLElement(file_get_contents($pluginFile));
    }

    /**
     * Use plugin manager to retreive the list of installed
     * and enabled plugins which extends given extension types.
     *
     * @param array $extensionTypes
     * @return array
     */
    function getActivePluginsByExtensions($extensionTypes)
    {
        $oPluginMgr = $this->_getComponentGroupManager();
        $plugins = $oPluginMgr->getComponentGroupsList();

        $extensionKeys = array_flip($extensionTypes);
        $activePlugins = array();
        foreach ($plugins as $plugin) {
            if (isset($extensionKeys[$plugin['extends']])
                && $plugin['installed'] && $plugin['enabled'])
            {
                $activePlugins[$plugin['extends']][$plugin['name']] =
                    $this->getPluginRegisteredHooks($plugin['name']);
            }
        }
        return $activePlugins;
    }

    /**
     * Required for mocking OX_ManagerPlugin
     *
     * @return OX_ManagerPlugin
     */
    function _getComponentGroupManager()
    {
        return new OX_Plugin_ComponentGroupManager();
    }

}

?>
