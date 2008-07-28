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

require_once LIB_PATH . '/Plugin/Component.php';
require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';
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
     * Keeps the reference to already installed components, so it
     * can perform uninstall in case of any error.
     *
     * @var array
     */
    private $aInstalledComponents = array();

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
            $this->_logError('No dependencies are defined');
            return false;
        }
        $source = new OA_Algorithm_Dependency_Source_HoA($pluginsDependencies);
        $dep = new OA_Algorithm_Dependency_Ordered($source);
        return array_values($dep->schedule($aHooks));
    }

    /**
     * Returns array of dependencies - name of each plugin from requested plugins array
     * with corresponding array of plugins names this plugin depends on.
     *
     * @param array $plugins array(hook name => array(hook components names))
     * @return array  Dependencies array:
     *                  ['extensionType:group:plugin'] = array(
     *                      'extensionType:group:plugin',
     *                      'extensionType:group:plugin',
     *                  );
     */
    function getPluginsDependencies($plugins)
    {
        $dependencies = array();
        static $aCacheComponents = array();
        foreach ($plugins as $hook => $hookComponents) {
            foreach ($hookComponents as $componentId) {
                if (!isset($aCacheComponents[$componentId])) {
                    $component = OX_Component::factoryByComponentIdentifier($componentId);
                    if (!$component) {
                        $this->_logError('Error when creating component: '.$componentId);
                    } else {
                        $aCacheComponents[$componentId] = $component->getDependencies();
                    }
                }
                $dependencies = array_merge($dependencies, $aCacheComponents[$componentId]);
            }
        }
        return $dependencies;
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
                list($extension, $group, $componentName)
                    = $this->getExtensionGroupComponentFromId($componentId);
                $componentFile = $this->getFilePathToPlugin($extension, $componentName);
                if (!$componentFile) {
                    $this->_logError('Error while generating delivery cache, file doesn\'t exist: '
                        .$componentFile);
                    return false;
                }
                $mungedComponent = $this->mungeFile($componentFile);
                if (!$mungedComponent) {
                    $this->_logError('Error while generating delivery cache, file: '.$componentFile);
                    return false;
                }
                $mergedDelivery .= $mungedComponent;
            }
        }
        $mergedDelivery = $this->templateCode($mergedDelivery);
        if(!$this->saveMergedDelivery($mergedDelivery)) {
            $this->_logError('Error when saving delivery cache, file: '.OX_BUCKETS_COMPILED_FILE);
            return false;
        }
        return true;
    }

    /**
     * Saves merged source code into output merged delivery cache
     *
     * @param string $mergedDelivery
     * @return boolean  True on success, else false
     */
    function saveMergedDelivery($mergedDelivery)
    {
        return @file_put_contents(OX_BUCKETS_COMPILED_FILE, $mergedDelivery);
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
     * Calls onInstall method on every component which is installed groups.
     * If for any reason the installation failed it uninstall already installed
     * components.
     *
     * @param string $extension  Extension in which we are gonna to install components
     * @param array $aComponentGroups  Component groups - component groups to install
     * @return boolean  True on success, else false
     */
    function installComponents($extension, $aComponentGroups)
    {
        $component = new OX_Component();
        foreach ($aComponentGroups as $group) {
            $aComponents = $component->getComponents($extension, $group, true, 1, $enabled = false);
            foreach ($aComponents as $component) {
                if (!$component->onInstall()) {
                    $this->_logError('Error when installing component: '.get_class($component));
                    $this->recoverUninstallComponents();
                    return false;
                }
                $this->markComponentAsInstalled($component);
            }
        }
        return true;
    }

    /**
     * Recovery on failed installation. Calls onUninstall method
     * on every component from components groups.
     */
    function recoverUninstallComponents()
    {
        foreach ($this->aInstalledComponents as $componentId) {
            $component = OX_Component::factoryByComponentIdentifier($componentId);
            if(!$component) {
                $this->_logError('Error when creating component: '.$componentId);
                continue;
            }
            if (!$component->onUninstall()) {
                $this->_logError('Error when uninstalling component: '.$componentId);
            }
        }
    }

    /**
     * Keeps the reference of already installed components. In case
     * a recovery uninstall will need to be performed.
     *
     * @param Plugins_DeliveryLog_LogCommon $component
     */
    function markComponentAsInstalled(Plugins_DeliveryLog_LogCommon $component)
    {
        $this->aInstalledComponents[] = $component->getComponentIdentifier();
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
     * Required for mocking OX_ManagerPlugin
     *
     * @return OX_ManagerPlugin
     */
    function _getComponentGroupManager()
    {
        return new OX_Plugin_ComponentGroupManager();
    }

    function _logMessage($msg, $err=PEAR_LOG_INFO)
    {
        OA::debug($msg, $err);
    }

    function _logWarning($msg)
    {
        $this->aWarnings[] = $msg;
        $this->_logMessage($msg, PEAR_LOG_WARNING);
    }

    function _logError($msg)
    {
        $this->aErrors[] = $msg;
        $this->_logMessage($msg, PEAR_LOG_ERR);
    }

}

?>
