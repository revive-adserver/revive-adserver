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

define('OX_BUCKETS_COMPILED_FILE', MAX_PATH.'/var/cache/deliveryAdLog.php');

require_once MAX_PATH . '/lib/OA/Plugin/Component.php';
require_once MAX_PATH . '/lib/OA/Plugin/ComponentGroupManager.php';
require_once MAX_PATH . '/lib/OA/Util/CodeMunger.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Ordered.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * Generates delivery log plugins cache and order the dependencies
 * between components per each delivery log hook.
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_LogCodeGenerator
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class OX_Plugins_DeliveryLog_CodeGenerator extends OX_Component
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
     * Regenerate delivery plugins code cache and calculate dependencies
     *
     * @return boolean  True on success, otherwise false
     */
    function generateDelivery()
    {
        $plugins = $this->getActivePluginsByExtensions($this->extensionTypes);
        if (!$this->regenerateDeliveryPluginsCodeCache($plugins)) {
            return false;
        }
        $pluginsByHooks = $this->groupPluginsByHooks($plugins);
        if (!$this->orderPluginsByDependency($plugins, $pluginsByHooks)) {
            return false;
        }
        return true;
    }

    /**
     * Get list of deliveryLog hooks from deliveryLog plugins
     *
     * @param array $plugins
     * @return array  Array of hooks ['extension name']['hook'] = array of plugins code-names
     *                where a code name is extensionType:group:component
     */
    function groupPluginsByHooks(array $plugins)
    {
        $hooks = array();
        foreach ($plugins as $extension => $extPlugins) {
            foreach ($extPlugins as $pluginName => $aPluginData) {
                foreach ($aPluginData['register']['delivery'] as $hookName => $aHook) {
                    // should this be more flexible?
                    $hooks[$extension][$hookName][] = $extension.':'.$pluginName.':'.$pluginName;
                }
            }
        }
        return $hooks;
    }

    /**
     * Orders plugins by its dependency in which of hooks categories
     *
     * @param array $plugins
     * @param array $hooks
     * @return
     */
    function orderPluginsByDependency(array $plugins, array $hooks)
    {
        $orderedDependencies = $this->getDpendencyOrderedPlugins($plugins, $hooks);
        // @TODO - save them in config file?
        foreach ($orderedDependencies as $hook => $aComponents) {
            $oConfigWriter['deliveryHooks'] = implode('|', $orderedDependencie);
        }
    }

    /**
     * Check the dependencies for active delivery log components and
     * order them per hook
     *
     * @param array $plugins
     * @param array $hooks
     * @param string $extensionType
     * @return array
     */
    function getDpendencyOrderedPlugins(array $plugins, array $hooks,
        $extensionType = self::LOG_EXTENSION)
    {
        $pluginsDependencies = $this->getPluginsDependencies($plugins);
        if (!$pluginsDependencies) {
            return false;
        }
        $source = new OA_Algorithm_Dependency_Source_HoA($pluginsDependencies);
        $dep = new OA_Algorithm_Dependency_Ordered($source);

        $orderedDependencies = array();
        foreach ($hooks[$extensionType] as $hookName => $hookPlugins) {
            $orderedDependencies[$hookName] = array_values($dep->schedule($hookPlugins));
        }
        return $orderedDependencies;
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
    function getPluginsDependencies(array $plugins)
    {
        if (!$this->includePlugins($plugins)) {
            return false;
        }
        return $GLOBALS['_MAX']['pluginsDependencies'];
    }

    function includePlugins(array $plugins)
    {
        foreach ($plugins as $pluginExtension => $extensionPlugins) {
            foreach ($extensionPlugins as $pluginName => $plugin) {
                $pluginFile = $this->getFilePathToPlugin($pluginExtension, $pluginName);
                if (!file_exists($pluginFile)) {
                    return false;
                }
                include($pluginFile);
            }
        }
        return true;
    }

    function regenerateDeliveryPluginsCodeCache($plugins)
    {
        $pluginsFiles = array();
        $mergedDelivery = '';
        foreach ($plugins as $pluginExtension => $extensionPlugins) {
            foreach ($extensionPlugins as $pluginName => $plugin) {
                $pluginFile = $this->getFilePathToPlugin($pluginExtension, $pluginName);
                if (!$pluginFile) {
                    // error message - logging
                    return false;
                }
                $pluginsFiles[$pluginExtension][$plugin] = $pluginFile;
                $mungedPlugin = $this->mungeFile($pluginFile);
                if (!$mungedPlugin) {
                    // error message - logging
                    return false;
                }
                $mergedDelivery .= $mungedPlugin;
            }
        }
        $mergedDelivery = $this->cleanUpCode($mergedDelivery);
        return $this->saveMergedDelivery($mergedDelivery);
    }

    function saveMergedDelivery($mergedDelivery)
    {
        return file_put_contents(OX_BUCKETS_COMPILED_FILE, $mergedDelivery);
    }

    function cleanUpCode($sourceCode)
    {
        return str_replace('{TEMPLATE}', $sourceCode, $this->header);
    }

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
        foreach ($simpleXml->xpath("register/hook") as $hook) {
            $hookAttributes = $hook->attributes();
            $hookName = (string) $hookAttributes['hook'];
            $hookType = (string) $hookAttributes['type'];
            $hooks[$hookType][$hookName][] = (string) $hook;
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
                $activePlugins[$plugin['extends']][$plugin['name']]['register'] =
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
