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

require_once LIB_PATH . '/Plugin/Component.php';
require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';
require_once LIB_PATH . '/Util/CodeMunger.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Ordered.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * Global location for storing merged plugins files code
 */
define('OX_BUCKETS_COMPILED_FILE', MAX_PATH.'/var/cache/' . OX_getHostName() . '_mergedDeliveryFunctions.php');

/**
 * Generates delivery log plugins cache and order the dependencies
 * between components per each delivery log hook.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 */
class OX_Extension_DeliveryLog_Setup extends OX_Component
{

    const DATA_EXTENSION = 'deliveryDataPrepare';
    const LOG_EXTENSION  = 'deliveryLog';

    public $aDeliveryLogHooks = array(
        'preLog',
        'logRequest',
        'logImpression',
        'logClick',
        'logConversion',
        'logConversionVariable',
    );

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
     * Template for generating delivery cache
     *
     * @var string
     */
    public $header = "<?php\n\n{TEMPLATE}\n\n?>";

    /**
     * Code generator
     *
     * @var OX_Util_CodeMunger
     */
    private $oCodeMunger;

    /**
     * Keeps the reference to already installed components, so it
     * can perform uninstall in case of any error.
     *
     * @var array
     */
    private $aInstalledComponents = array();

    /**
     * Check the dependencies for active delivery log components and
     * sort the in the correct order so each dependency is resolved.
     *
     * @param array $aComponentsToSchedule  Array of components Ids which need to be schedules
     *                                      format: array(hook name => array(components Ids))
     * @param array $aAllComponentIdsByHooks  Array of all components identifiers
     * @return array  Array of components ids schedules in order of dependency
     */
    function getDependencyOrderedPlugins($aComponentsToSchedule, $aAllComponentIdsByHooks)
    {
        $aDeliveryComponentsHooks = $this->filterDeliveryHooks($aAllComponentIdsByHooks);
        $pluginsDependencies = $this->getComponentsDependencies($aDeliveryComponentsHooks);
        if (!$pluginsDependencies) {
            $this->_logError('No dependencies are defined');
            return false;
        }
        $source = new OA_Algorithm_Dependency_Source_HoA($pluginsDependencies);
        // should we update this value only if the result of sorting is positive?
        $dep = new OA_Algorithm_Dependency_Ordered($source, array(), $ignoreOrphans = true);
        return array_values($dep->schedule($aComponentsToSchedule));
    }

    /**
     * Filter out components by delivery hooks
     *
     * @param array $aAllComponentsIds  Array of components per hooks keys
     * @return array  Filtered array of components per delivery hooks keys
     */
    function filterDeliveryHooks($aAllComponentsIds)
    {
        $aDeliveryHooksComponents = array();
        foreach ($aAllComponentsIds as $hook => &$aComponents) {
            if (in_array($hook, $this->aDeliveryLogHooks)) {
                $aDeliveryHooksComponents[$hook] = $aComponents;
            }
        }
        return $aDeliveryHooksComponents;
    }

    /**
     * Returns array of dependencies - array contains merged dependencies.
     *
     * @param array $aComponents array(hook name => array(hook components names))
     * @return array  Dependencies array(
     *                  'extensionType:group:plugin' => array(
     *                      'extensionType:group:plugin',
     *                      'extensionType:group:plugin',
     *                      ...
     *                  ),
     *                  ....;
     */
    function getComponentsDependencies($aComponents)
    {
        $dependencies = array();
        static $aCacheComponents = array(); // static in-memory caching
        foreach ($aComponents as $hook => $hookComponents) {
            foreach ($hookComponents as $componentId) {
                if (!isset($aCacheComponents[$componentId])) {
                    $component = $this->_factoryComponentById($componentId);
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
     * Factory component by its Id
     *
     * @param string $componentId  Component Id, for example: ExtensionName:GroupName:ComponentName
     * @return OX_Component  Returns OX_Component or false on error
     */
    function _factoryComponentById($componentId)
    {
        return OX_Component::factoryByComponentIdentifier($componentId);
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
     * Generated delivery component cache and save it into plugins cache
     * folder.
     *
     * @param array $aComponentsByHooks
     * @return boolean  True on success, false on error
     */
    function regenerateDeliveryPluginsCodeCache($aComponentsByHooks)
    {
        // Only attempt to create the merged functions file if required
        if (empty($GLOBALS['_MAX']['CONF']['pluginSettings']['useMergedFunctions'])) {
            return true;
        }
        $aDeliveryComponentsHooks = $this->filterDeliveryHooks($aComponentsByHooks);
        $mergedDelivery = $this->generatePluginsCode($aDeliveryComponentsHooks);
        if (!$mergedDelivery) {
            return false;
        }
        if(!$this->saveMergedDelivery($mergedDelivery)) {
            $this->_logError('Error when saving delivery cache, file: '.OX_BUCKETS_COMPILED_FILE);
            return false;
        }
        return true;
    }

    /**
     * Generated delivery component cache
     *
     * @param array $aComponentsByHooks
     * @return string  Merged delivery code or false on any error
     */
    function generatePluginsCode($aComponentsByHooks)
    {
        $componentsFiles = array();
        $mergedDelivery = '';
        foreach ($aComponentsByHooks as $hookName => &$hookComponents) {
            foreach ($hookComponents as $componentId) {
                list($extension, $group, $componentName)
                    = $this->getExtensionGroupComponentFromId($componentId);
                $componentFile = $this->getFilePathToPlugin($extension, $group, $componentName);
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
        return $this->templateCode($mergedDelivery);
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
        $oCodeMunger = $this->_getCodeMunger();
        $code = $oCodeMunger->flattenFile($file);
        return preg_replace(array('/^<\?php/', '/\?>$/'), array('', ''), $code);
    }

    /**
     * Calls onInstall method on every component which is installed groups.
     * If for any reason the installation failed it uninstall already installed
     * components.
     *
     * @param string $extension  Extension in which we are gonna to install components
     * @param array $aComponentGroups  Component groups - component groups to install
     * @return boolean  True on success, false otherwise
     */
    function installComponents($extension, $aComponentGroups)
    {
        /*require_once MAX_PATH.'/lib/OA.php';
        OA::logMem('enter deliveryLog/Setup::installComponents');*/
        foreach ($aComponentGroups as $group)
        {
            //OA::logMem('installing group '.$group);
            $aComponents = $this->_getComponents($extension, $group);
            foreach ($aComponents as &$oComponent)
            {
                //OA::logMem('installing component '.$oComponent->component);
                if (!$oComponent->onInstall()) {
                    $this->_logError('Error when installing component: ' . get_class($oComponent));
                    $this->recoverUninstallComponents();
                    return false;
                }
                $this->markComponentAsInstalled($oComponent);
            }
        }
        //OA::logMemPeak('exit installComponents');
        return true;
    }

    /**
     * Recovery on failed installation. Calls onUninstall method
     * on every component from components groups.
     */
    function recoverUninstallComponents()
    {
        foreach ($this->aInstalledComponents as $componentId) {
            $oComponent = $this->_factoryComponentById($componentId);
            if (!$oComponent) {
                $this->_logError('Error when creating component: '.$componentId);
                continue;
            }
            if (!$oComponent->onUninstall()) {
                $this->_logError('Error when uninstalling component: '.$componentId);
            }
        }
    }

    /**
     * Keeps the reference of already installed components. In case
     * a recovery uninstall will need to be performed.
     *
     * @param Plugins_DeliveryLog $oComponent
     */
    function markComponentAsInstalled(Plugins_DeliveryLog $oComponent)
    {
        $this->aInstalledComponents[] = $oComponent->getComponentIdentifier();
    }

    /**
     * Returns OX_Util_CodeMunger.
     * This method can be used for mocking in delivery.
     *
     * @return OX_Util_CodeMunger
     */
    function _getCodeMunger()
    {
        if (!$this->oCodeMunger) {
            $this->oCodeMunger = new OX_Util_CodeMunger();
        }
        return $this->oCodeMunger;
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
    function getFilePathToPlugin($extensionType, $group, $component, $postfix = '.delivery.php')
    {
        $oPluginMgr = $this->_getComponentGroupManager();
        $dirPath = MAX_PATH . $oPluginMgr->pathPlugins .
            $extensionType . '/' . $group.'/';
        $file = $dirPath . $component . $postfix;
        if (!file_exists($file)) {
            return false;
        }
        return $file;
    }

    /**
     * Required for mocking OX_Component::getComponents
     *
     * @return array  Array of components in chosen extension, group
     */
    function _getComponents($extension, $group, $recursive = 1, $enabledOnly = false)
    {
        return OX_Component::getComponents($extension, $group, $recursive, $enabledOnly);
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