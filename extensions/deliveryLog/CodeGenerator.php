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
require_once MAX_PATH . '/lib/OA/Plugin/ComponentManager.php';
require_once MAX_PATH . '/lib/OA/Util/CodeMunger.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Ordered.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_LogCodeGenerator
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class OX_Plugins_DeliveryLog_CodeGenerator extends OX_Component
{
    private $extensionTypes = array(
        'deliveryDataPrepare',
        'deliveryLog',
    );

    private $extensionsPoints = array(
        'preLog',
        'logRequest',
        'logImpression',
        'logClick',
        'logConversion',
    );

    private $codeMunger;

    /**
     * Should we use the template with GNU license header here?
     *
     * @var string
     */
    public $header = "<?php\n\n{TEMPLATE}\n\n?>";

    function generateDelivery()
    {
        $plugins = $this->getActivePluginsHooks($this->extensionTypes);
        if (!$this->mergeDeliveryPlugins($plugins)) {
            return false;
        }
        if (!$this->orderPluginsByDependency($plugins)) {
            return false;
        }
    }

    function orderPluginsByDependency(array $plugins)
    {
        // @todo - these files should be ordered by hook type - currently they are ordered globally
        $orderedPlugins = $this->getDpendencyOrderedPlugins($plugins);
        // @TODO - save them in config file?
    }

    function getDpendencyOrderedPlugins(array $plugins)
    {
        $pluginsDependencies = $this->getPluginsDependencies($plugins);
        if (!$pluginsDependencies) {
            return false;
        }
        $source = new OA_Algorithm_Dependency_Source_HoA($pluginsDependencies);
        $dep = new OA_Algorithm_Dependency_Ordered($source);
        return array_values($dep->scheduleAll());
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
        if (!$this->includePluginsFiles($plugins)) {
            return false;
        }
        return $GLOBALS['_MAX']['pluginsDependencies'];
    }

    function includePluginsFiles(array $plugins)
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

    function mergeDeliveryPlugins($plugins)
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
    function getActivePluginsHooks($extensionTypes)
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
