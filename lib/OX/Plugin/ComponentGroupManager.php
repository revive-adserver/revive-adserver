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

define('OX_PLUGIN_ERROR_PARSE', -1);
define('OX_PLUGIN_DEPENDENCY_NOTFOUND', -1);
define('OX_PLUGIN_DEPENDENCY_BADVERSION', -2);

define('OX_PLUGIN_PLUGINPATH','{PLUGINPATH}');
define('OX_PLUGIN_GROUPPATH','{GROUPPATH}');
define('OX_PLUGIN_MODULEPATH','{MODULEPATH}');
define('OX_PLUGIN_ADMINPATH' ,'{ADMINPATH}' );

define('OX_PLUGIN_PLUGINPATH_REX','/^\{PLUGINPATH\}/');
define('OX_PLUGIN_GROUPPATH_REX','/^\{GROUPPATH\}/');
define('OX_PLUGIN_MODULEPATH_REX','/^\{MODULEPATH\}/');
define('OX_PLUGIN_ADMINPATH_REX' ,'/^\{ADMINPATH\}/' );


// Required files
require_once LIB_PATH.'/Plugin/ParserComponentGroup.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/VersionController.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradeAuditor.php');
require_once(MAX_PATH.'/lib/OA/DB/Table.php');
require_once(MAX_PATH.'/lib/OA/Dal.php');
require_once(MAX_PATH.'/lib/OA/Cache.php');
require_once LIB_PATH.'/Plugin/UpgradeComponentGroup.php';
require_once LIB_PATH.'/Plugin/Component.php';
require_once(MAX_PATH.'/lib/OA/Admin/Menu.php');

class OX_Plugin_ComponentGroupManager
{
    var $pathPackages;
    var $pathPlugins;
    var $pathPluginsAdmin;
    var $pathDataObjects;

    var $oAuditor;
    var $oUpgrader;

    var $aMenuObjects;

    var $aWarnings;
    var $aErrors;

    function __construct()
    {
        $this->aErrors  = array();
        $this->aWarnings = array();
        $this->init();
    }

    function init()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->pathPackages     = $aConf['pluginPaths']['packages'];
        $this->pathPlugins   = $aConf['pluginPaths']['plugins'];
        $this->pathPluginsAdmin = $aConf['pluginPaths']['admin'];
        $this->pathDataObjects  = $aConf['pluginPaths']['var'] . 'DataObjects/';
        // Attempt to increase the memory limit when using the plugin manager
        OX_increaseMemoryLimit(OX_getMinimumRequiredMemory('plugin'));
        $this->basePath = MAX_PATH;
        $this->configLocked = !OA_Admin_Settings::isConfigWritable();
    }

    function countErrors()
    {
        return count($this->aErrors);
    }

    function clearErrors()
    {
        $this->aErrors = array();
    }

    function clearWarnings()
    {
        $this->aWarnings = array();
    }

    function countWarnings()
    {
        return count($this->aWarnings);
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
        if (!empty($msg)) {
            $this->aErrors[] = $msg;
            $this->_logMessage($msg, PEAR_LOG_ERR);
        }
    }

    /**
     * instantiate audit object if not exists
     *
     */
    function _auditInit()
    {
        if (!$this->oAuditor)
        {
            $this->oAuditor = $this->_instantiateClass('OA_UpgradeAuditor');
            $this->oAuditor->init(OA_DB::singleton());
        }
    }

    function _auditSetKeys($aParams, $dbAuditor=false)
    {
        $this->_auditInit();
        if (!$dbAuditor)
        {
            $this->oAuditor->setKeyParams($aParams);
        }
        else
        {
            $this->oAuditor->oDBAuditor->setKeyParams($aParams);
        }
        return true;
    }

    function _auditStart($aParams, $dbAuditor=false)
    {
        if (!$dbAuditor)
        {
            return $this->oAuditor->logAuditAction($aParams);
        }
        else
        {
            return $this->oAuditor->oDBAuditor->logAuditAction($aParams);
        }
    }

    function _auditUpdate($aParams)
    {
        return $this->oAuditor->updateAuditAction($aParams);
    }

    function _auditSetID()
    {
        $this->oAuditor->setUpgradeActionId();
    }

    /**
     * @todo write test
     *
     * @param string $name
     * @return boolean
     */
    public function isEnabled($name)
    {
        return ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'][$name] ? true : false);
    }

    function &_getOX_Plugin_UpgradeComponentGroup(&$aGroup, $oSender)
    {

        return new OX_Plugin_UpgradeComponentGroup($aGroup, $this);
    }

    function _canUpgradeComponentGroup(&$aGroup)
    {
        $this->oUpgrader = $this->_getOX_Plugin_UpgradeComponentGroup($aGroup, $this);
        $this->oUpgrader->canUpgrade();
        $aGroup['status'] = $this->oUpgrader->existing_installation_status;
        switch ($aGroup['status'])
        {
            case OA_STATUS_PLUGIN_CAN_UPGRADE:
                    $this->_logMessage('Plugin can be upgraded '.$aGroup['name']);
                    $result = true;
                    break;
            case OA_STATUS_PLUGIN_NOT_INSTALLED:
                    $this->_logError('Plugin is not yet installed '.$aGroup['name']);
                    $result = true;
                    break;
            case OA_STATUS_PLUGIN_CURRENT_VERSION:
                    $this->_logMessage('Plugin is up to date '.$aGroup['name']);
                    $result = true;
                    break;
            case OA_STATUS_PLUGIN_VERSION_FAILED:
                    $this->_logError('Bad version, cannot upgrade '.$aGroup['name']);
                    $result = false;
                    break;
            case OA_STATUS_PLUGIN_DBINTEG_FAILED:
                    $this->_logError('Plugin failed schema integrity check '.$aGroup['name']);
                    $result = false;
                    break;
        }
        return $result;
    }

    public function upgradeComponentGroup(&$aGroup)
    {
        $this->oUpgrader = $this->_getOX_Plugin_UpgradeComponentGroup($aGroup, $this);
        if ($this->oUpgrader->canUpgrade())
        {
            if (!$this->oUpgrader->upgrade())
            {
                $this->_logError('Failed to upgrade '.$aGroup['name']);
                return UPGRADE_ACTION_UPGRADE_FAILED;
            }
        }
        return UPGRADE_ACTION_UPGRADE_SUCCEEDED;
    }

    public function diagnoseComponentGroup(&$aGroup)
    {
        $aTaskList = $this->getDiagnosticTasks($aGroup);

        return $this->_runTasks($aGroup['name'], $aTaskList, array(), true);
    }

    /**
     * run a series of tasks that installs a single plugin
     *
     * @param array $aGroup
     * @return boolean
     */
    public function installComponentGroup(&$aGroup)
    {
        $aTaskList = $this->getInstallTasks($aGroup);

        $aUndoList = $this->getRollbackTasks($aGroup);

        return $this->_runTasks($aGroup['name'], $aTaskList, $aUndoList);
    }

    /**
     * run a series of tasks the uninstalls a single plugin
     *
     * @param array $aGroup
     * @return boolean
     */
    public function uninstallComponentGroup(&$aGroup)
    {
        $aTaskList = $this->getRollbackTasks($aGroup);

        return $this->_runTasks($aGroup['name'], $aTaskList);
    }

    /**
     * default list of tasks required to install a single plugin
     *
     * @param array $aGroup
     * @return array
     */
    function getDiagnosticTasks(&$aGroup)
    {
        $aTaskList[] = array(
                            'method' =>'_checkOpenXCompatibility',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['oxversion'],
                                             )
                            );
        $aTaskList[] = array(
                            'method' =>'_checkSystemEnvironment',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['syscheck']['php'],
                                             )
                            );
        $aTaskList[] = array(
                            'method' =>'_checkDatabaseEnvironment',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['syscheck']['dbms']
                                             )
                            );
        $aTaskList[] = array(
                            'method' =>'_checkDependenciesForInstallOrEnable',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['syscheck']['depends']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_checkFiles',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['files']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_verifyDataObjects',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['schema']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_checkNavigationCheckers',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['navigation']['checkers'],
                                              $aGroup['install']['files']
                                             ),
                            );
        // settings, preferences
        return $aTaskList;
    }

    /**
     * default list of tasks required to install a single plugin
     *
     * @param array $aGroup
     * @return array
     */
    function getInstallTasks(&$aGroup)
    {
        $aTaskList[] = array(
                            'method' =>'_checkOpenXCompatibility',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['oxversion'],
                                             )
                            );
        $aTaskList[] = array(
                            'method' =>'_checkSystemEnvironment',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['syscheck']['php'],
                                             )
                            );
        $aTaskList[] = array(
                            'method' =>'_checkDatabaseEnvironment',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['syscheck']['dbms']
                                             )
                            );
        $aTaskList[] = array(
                            'method' =>'_runScript',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['prescript']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_checkDependenciesForInstallOrEnable',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['syscheck']['depends']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_checkFiles',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['files']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_checkNavigationCheckers',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['navigation']['checkers'],
                                              $aGroup['install']['files']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_checkMenus',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['navigation'],
                                              $aGroup['install']['files']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_registerSchema',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['schema']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_registerPreferences',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['conf']['preferences']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_registerSettings',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['conf']['settings']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'disableComponentGroup',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['extends']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_registerPluginVersion',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['version']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_runScript',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['postscript']
                                             ),
                            );
        return $aTaskList;
    }

    /**
     * default list of tasks required to uninstall a single plugin
     *
     * @param array $aGroup
     * @return array
     */
    function getRollbackTasks(&$aGroup)
    {
        /*$aTaskList[] = array(
                            'method' =>'_checkDependenciesForUninstallOrDisable',
                            'params' => array(
                                              $aGroup['name']
                                             ),
                            );*/
        $aTaskList[] = array(
                            'method' =>'_runScript',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['uninstall']['prescript']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_unregisterPluginVersion',
                            'params' => array(
                                              $aGroup['name']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_unregisterPreferences',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['conf']['preferences']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_unregisterSettings',
                            'params' => array(
                                              $aGroup['name']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_unregisterSchema',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['install']['schema']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_runScript',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['uninstall']['postscript']
                                             ),
                            );
        $aTaskList[] = array(
                            'method' =>'_removeFiles',
                            'params' => array(
                                              $aGroup['name'],
                                              $aGroup['allfiles'],
                                             ),
                            );
        return $aTaskList;
    }

    function upgrade()
    {
        require_once LIB_PATH.'/Plugin/upgradeComponentGroup.php';
        //$oUpgrader =
    }

    /**
     * parse the plugin XML file into an array
     *
     * @param string $input_file
     * @param string $classname
     * @return boolean
     */
    function parseXML($input_file, $classname='OX_ParserComponentGroup')
    {
        //OA::logMem('enter parseXML');
        if (!file_exists($input_file))
        {
            $this->_logError('file not found '.$input_file);
            return false;
        }
        $oParser = $this->_instantiateClass($classname);
        if (!$oParser)
        {
            return false;
        }
        $result = $oParser->setInputFile($input_file);
        if (PEAR::isError($result)) {
            return $result;
        }
        $result = $oParser->parse();
        if (PEAR::isError($result))
        {
            $this->_logError('problem parsing the file: '.$result->getMessage());
            return false;
        }
        if (PEAR::isError($oParser->error))
        {
            $this->_logError('problem parsing the file: '.$oParser->error);
            return false;
        }
        $aResult = $oParser->aPlugin;
        $oParser = null;
        //OA::logMem('exit parseXML');
        return $aResult;
    }

    /**
     * return an object of type given in param
     *
     * r
     *
     * @param string $classname
     * @return object
     */
    function &_instantiateClass($classname) // cannot take params //, $aParams=null)
    {
        if (!$classname)
        {
            $this->_logError('Cannot instantiate null class');
            return false;
        }
        if (!class_exists($classname))
        {
            $this->_logError('Class not found '.$classname);
            return false;
        }
        $oResult = new $classname();
/*      newInstanceArgs() method not implemented until php 5.1.3
        if (!$aParams)
        {
            $oResult = new $classname();
        }
        else
        {
            // use Reflection to create a new instance, using the $args
            $oReflection = new ReflectionClass($classname);
            $oResult = $oReflection->newInstanceArgs($aParams);
        }*/
        if (!is_a($oResult,$classname))
        {
            $this->_logError('Failed to instantiate class '.$classname);
            return false;
        }
        return $oResult;
    }

    /**
     * return the section of the conf array for a given plugin
     *
     * @param string $name
     * @return array
     */
    public function getComponentGroupSettingsArray($name)
    {
        return $GLOBALS['_MAX']['CONF'][$name] ? $GLOBALS['_MAX']['CONF'][$name] : array();
    }

    /**
     * return the absolute path to the given plugin's schema definition
     *
     * @param string $plugin
     * @param string $schema
     * @return boolean
     */
    function getFilePathToMDB2Schema($plugin, $schema)
    {
        return $this->getPathToComponentGroup($plugin).'etc/'.$schema.'.xml';
    }

    /**
     * return the absolute path to the given plugin's definition file
     *
     * @param string $plugin
     * @return boolean
     */
    function getFilePathToXMLInstall($plugin)
    {
        $file = $this->getPathToComponentGroup($plugin).$plugin.'.xml';
        if (file_exists($file)) {
            return $file;
        } elseif (file_exists(str_replace('/plugins/', '/extensions/', $file))) {
            return str_replace('/plugins/', '/extensions/', $file);
        }
    }

    /**
     * return the absolute path to the given plugin
     *
     * @param string $plugin
     * @return boolean
     */
    function getPathToComponentGroup($plugin)
    {
        return $this->basePath.$this->pathPackages.$plugin.'/';
    }

    /**
     * set a given plugin setting to true
     *
     * @param string $name
     * @return boolean
     */
    public function enableComponentGroup($name, $extends)
    {
        $aComponents = OX_Component::getComponents($extends, $name, true, false);
        $aResult = OX_Component::callOnComponents($aComponents, 'onEnable');
        foreach ($aResult as $componentIdentifier => $value) {
            if (!$value) {
                // Should I call onDisable for those components that were sucessfully enabled?
                return false;
            }
        }
        $result = $this->_setPlugin($name, 1);
        return $result;
    }

    /**
     * set a given plugin setting to false
     *
     * @param string $name
     * @param string $extends
     * @param bool $force
     * @return boolean
     */
    public function disableComponentGroup($name, $extends, $force = false)
    {
        if (!$force) {
            $aComponents = OX_Component::getComponents($extends, $name, true, false);
            $aResult = OX_Component::callOnComponents($aComponents, 'onDisable');
            foreach ($aResult as $componentIdentifier => $value) {
                if (!$value) {
                    // Should I call onEnable for those components that were sucessfully disabled?
                    return false;
                }
            }
        }
        return $this->_setPlugin($name, 0);
    }

    /**
     * set the enabled value for a given plugin
     *
     * @param string $name
     * @param boolean $enabled
     * @return boolean
     */
    function _setPlugin($name, $enabled=0)
    {
        $oSettings = $this->_instantiateClass('OA_Admin_Settings');
        if (!$oSettings)
        {
            return false;
        }
        $oSettings->settingChange('pluginGroupComponents', $name, $enabled);
        return $oSettings->writeConfigChange();
    }

    /**
     * put the plugin version into the application_variable table
     *
     * @param string $name
     * @param string $version
     * @return boolean
     */
    function _registerPluginVersion($name, $version)
    {
        $oVerControl = $this->_getVersionController();
        if (!$oVerControl)
        {
            return false;
        }
        $result = $oVerControl->putApplicationVersion($version, $name);
        return ($result === $version);
    }

    /**
     * put the plugin's schema version into the application_variable table
     *
     * @param string $name
     * @param string $version
     * @return boolean
     */
    function _registerSchemaVersion($name, $version)
    {
        $oVerControl = $this->_getVersionController();
        if (!$oVerControl)
        {
            return false;
        }
        $result = $oVerControl->putSchemaVersion($name,$version);
        return ($result === $version);
    }

    /**
     * remove the plugin's schema version record from the application_variable table
     *
     * @param string $name
     * @return boolean
     */
    function _unregisterSchemaVersion($name)
    {
        $oVerControl = $this->_getVersionController();
        if (!$oVerControl)
        {
            return false;
        }
        if (!$oVerControl->removeVariable($name))
        {
            $this->_logError('Failed to remove schema version for '.$name);
            return false;
        }
        return true;
    }

    /**
     * remove the plugin's version record from the application_variable table
     *
     * @param string $name
     * @return boolean
     */
    function _unregisterPluginVersion($name)
    {
        $oVerControl = $this->_getVersionController();
        if (!$oVerControl)
        {
            return false;
        }
        if (!$oVerControl->removeVersion($name))
        {
            $this->_logError('Failed to remove plugin version for '.$name);
            return false;
        }
        return true;
    }

    /**
     * write a conf section for the given plugin
     * along with any settings that belongs to it
     *
     * @param array $aSettings
     * @return boolean
     */
    function _registerSettings($name, $aSettings=null)
    {
        if ($aSettings)
        {
            $oSettings  = $this->_instantiateClass('OA_Admin_Settings');
            foreach ($aSettings AS &$aSetting)
            {
                $oSettings->settingChange($name,$aSetting['key'],$aSetting['value']);
            }
            if (!$oSettings->writeConfigChange())
            {
                $this->_logError('Failed to write configuration settings');
                return false;
            }
        }
        return true;
    }

    /**
     * remove a conf section for the given plugin
     * along with any settings that belongs to it
     *
     * @param string $name
     * @return boolean
     */
    function _unregisterSettings($name, $self=true)
    {
        $oSettings  = $this->_instantiateClass('OA_Admin_Settings');
        if (array_key_exists($name,$oSettings->aConf))
        {
            unset($oSettings->aConf[$name]);
        }
        if ($self && array_key_exists($name,$oSettings->aConf['pluginGroupComponents']))
        {
            unset($oSettings->aConf['pluginGroupComponents'][$name]);
        }
        if (!$oSettings->writeConfigChange())
        {
            $this->_logError('Failed to remove configuration settings for '.$name);
            return false;
        }
        return true;
    }

    /**
     * write preferences records for the given plugin
     *
     * @param array $aPreferences
     * @return boolean
     */
    function _registerPreferences($name, $aPreferences=null)
    {
        if ($aPreferences)
        {
            $accountId = OA_Permission::getAccountId();
            foreach ($aPreferences AS $k => &$aPreference)
            {
                if (!$this->_registerPreferenceOne($name, $aPreference, $accountId))
                {
                    return false;
                }
            }
        }
        return true;
    }

    function _registerPreferenceOne($name, $aPreference, $accountId)
    {
        if ($aPreference)
        {
            $prefName = $name.'_'.$aPreference['name'];
            $doPreferences = OA_Dal::factoryDO('preferences');
            $doPreferences->preference_name = $prefName;
            if ($doPreferences->find())
            {
                $this->_logError('Failed to write preference '.$prefName.' : duplicate found');
                return false;
            }
            $doPreferences->account_type = empty($aPreference['permission']) ? '' : $aPreference['permission'];
            $preferenceId = $doPreferences->insert();
            if ((!$preferenceId) || PEAR::isError($preferenceId))
            {
                $this->_logError('Failed to write preference '.$prefName.' '.$result->getUserInfo());
                if (PEAR::isError($result))
                {
                    $this->_logError($result->getUserInfo());
                }
                return false;
            }
            $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
            $doAccount_Preference_Assoc->account_id = $accountId;
            $doAccount_Preference_Assoc->preference_id = $preferenceId;
            $doAccount_Preference_Assoc->value = $aPreference['value'];
            $doAccount_Preference_Assoc->insert();
            // TODO: some more error handling ?
        }
        return true;
    }

    /**
     * remove preferences records for the given plugin
     *
     * @param string $name
     * @return boolean
     */
    function _unregisterPreferences($name, $aPreferences)
    {
        if ($aPreferences)
        {
            foreach ($aPreferences AS &$aPreference)
            {
                $prefName = $name.'_'.$aPreference['name'];
                $doPreferences = OA_Dal::factoryDO('preferences');
                $doPreferences->preference_name = $prefName;
                if (!$doPreferences->find())
                {
                    $this->_logMessage('Failed to find preference '.$aPreference['name']);
                }
                else
                {
                    $result = $doPreferences->delete(false, true);
                    if ((!$result) || PEAR::isError($result))
                    {
                        $this->_logError('Failed to delete preference '.$prefName.' '.$result->getUserInfo());
                        if (PEAR::isError($result))
                        {
                            $this->_logError($result->getUserInfo());
                        }
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * create all tables for a plugin as specified by it's schema file
     *
     * @param string $name
     * @return boolean
     */
    function _createTables($name, $aSchema)
    {
        $oTable = $this->_instantiateClass('OA_DB_Table');
        if (!$oTable->init($this->getFilePathToMDB2Schema($name, $aSchema['mdb2schema']),false))
        {
            $this->_logError('Failed to initialise table class for '.$name);
            return false;
        }
        $version = $oTable->aDefinition['version'];
        $schema   = $oTable->aDefinition['name'];
        foreach ($oTable->aDefinition['tables'] AS $table => &$aDef)
        {
            $this->_auditSetKeys(array( 'schema_name'   => $schema,
                                        'version'       => $version,
                                        'timing'        => DB_UPGRADE_TIMING_CONSTRUCTIVE_DEFAULT
                                    ),
                                 true
                                );
            if (!$oTable->createTable($table))
            {
                $this->_logError('Failed to create table for '.$table);
                $this->_auditStart(array('info1'        => 'CREATE FAILED',
                                         'tablename'    => $table,
                                         'action'       => DB_UPGRADE_ACTION_UPGRADE_FAILED,
                                         ),
                                   true
                                   );
                $this->_dropTables($name, $aSchema);
                return false;
            }
            $this->_auditStart(array('info1'    => 'CREATE SUCCEEDED',
                                     'tablename'=> $table,
                                     'action'   => DB_UPGRADE_ACTION_UPGRADE_TABLE_ADDED,
                                     ),
                                   true
                               );
        }
        return $version;
    }

    /**
     * remove all tables belonging to a plugin's schema$this->oAuditor->oDBAuditor->logAuditAction(array('info1'    => 'CREATE FAILED',

     *
     * @param string $name
     * @return boolean
     */
    function _dropTables($name, $aSchema)
    {
        $oTable = $this->_instantiateClass('OA_DB_Table');
        if (!$oTable->init($this->getFilePathToMDB2Schema($name, $aSchema['mdb2schema']),false))
        {
            $this->_logError('Failed to initialise table class for '.$name);
            return false;
        }
        $version = $oTable->aDefinition['version'];
        $schema   = $oTable->aDefinition['name'];
        foreach ($oTable->aDefinition['tables'] AS $table => &$aDef)
        {
            $this->_auditSetKeys(array( 'schema_name'   => $schema,
                                        'version'       => $version,
                                        'timing'        => DB_UPGRADE_TIMING_DESTRUCTIVE_DEFAULT
                                      ),
                                 true
                                );
            if (!$oTable->dropTable($oTable->_generateTableName($table)))
            {
                if ($this->_tableExists($table))
                {
                    $this->_auditStart(array('info1'    => 'DROP FAILED',
                                         'tablename'    => $table,
                                         'action'       => DB_UPGRADE_ACTION_ROLLBACK_FAILED,
                                         ),
                                   true
                                   );
                    $this->_logError('Failed to drop table '.$table);
                    return false;
                }
            }
            $this->_auditStart(array('info1'        => 'DROP SUCCEEDED',
                                     'tablename'    => $table,
                                     'action'       => DB_UPGRADE_ACTION_ROLLBACK_TABLE_DROPPED,
                                    ),
                                   true
                              );
        }
        return true;
    }

    function _tableExists($table)
    {
        return count(OA_DB_Table::listOATablesCaseSensitive($table));
    }

    /**
     *
     * create plugin tables
     *
     * @param string $name
     * @return boolean
     */
    function _registerSchema($name, $aSchema)
    {
        if (!$aSchema['mdb2schema'])
        {
            return true;
        }
        if (!($schema_version = $this->_createTables($name, $aSchema)))
        {
            $this->_logError('Failed to create tables for '.$name);
            $this->_dropTables($name, $aSchema);
            return false;
        }
        if (!$this->_registerSchemaVersion($aSchema['mdb2schema'], $schema_version))
        {
            $this->_logError('Failed to register schema version for '.$name);
            $this->_dropTables($name, $aSchema);
            return false;
        }
        if (!$this->_putDataObjects($name, $aSchema))
        {
            $this->_logError('Failed to implement dataobjects for '.$name);
            $this->_dropTables($name, $aSchema);
            return false;
        }
        if (!$this->_cacheDataObjects($name, $aSchema))
        {
            $this->_logError('Failed to cache dataobject schema for '.$name);
            $this->_dropTables($name, $aSchema);
            return false;
        }
        if (!$this->_verifyDataObjects($name, $aSchema))
        {
            $this->_logError('Failed to verify dataobjects for '.$name);
            $this->_dropTables($name, $aSchema);
            return false;
        }
        return true;
    }

    function _verifyDataObjects($name, $aSchema)
    {
        if (!$aSchema['mdb2schema'])
        {
            return true;
        }
        $oTable = $this->_instantiateClass('OA_DB_Table');
        if (!$oTable->init($this->getFilePathToMDB2Schema($name, $aSchema['mdb2schema']),false))
        {
            $this->_logError('Failed to initialise table class for '.$name);
            return false;
        }
        foreach ($oTable->aDefinition['tables'] AS $table => &$aDef)
        {
            $dboTable = OA_Dal::factoryDO($table);
            if (!$dboTable)
            {
                OA::debug('Failed to instantiate DataObject for table '.$table);
                return false;
            }
        }
        return true;
    }

    /**
     * remove the plugin tables
     * delete the application_variables record
     *
     * @param string $name
     * @return boolean
     */
    function _unregisterSchema($name, $aSchema)
    {
        if ($aSchema['mdb2schema'])
        {
            if (!$this->_dropTables($name, $aSchema))
            {
                $this->_logError('Failed to drop tables for '.$name);
                return false;
            }
            if (!$this->_unregisterSchemaVersion($aSchema['mdb2schema']))
            {
                $this->_logError('Failed to remove schema version for '.$name);
                return false;
            }
            if (!$this->_cacheDataObjects())
            {
                $this->_logError('Failed to recreate old dataobject cache');
                //return false;
            }
            if (!$this->_removeDataObjects($name, $aSchema))
            {
                $this->_logError('Failed to remove dataobjects for '.$name);
                //return false;
            }
        }
        return true;
    }

    function _checkOpenXCompatibility($name, $minVersion)
    {
        return version_compare(OA_VERSION, $minVersion, '>=');
    }

    function _checkSystemEnvironment($name, $aPhp)
    {
        if (count($aPhp)>0)
        {
            require_once MAX_PATH.'/lib/OA/Upgrade/EnvironmentManager.php';
            $oEnvMgr = $this->_instantiateClass('OA_Environment_Manager');
            $oEnvMgr->aInfo['PHP']['actual'] = $oEnvMgr->getPHPInfo();
            foreach ($aPhp AS $k => &$aItem)
            {
                $oEnvMgr->aInfo['PHP']['expected'][$aItem['name']] = $aItem['value'];
            }
            if ($oEnvMgr->_checkCriticalPHP() != OA_ENV_ERROR_PHP_NOERROR)
            {
                if (isset($oEnvMgr->aInfo['PHP']['warning']))
                {
                    foreach ($oEnvMgr->aInfo['PHP']['warning'] as $msg)
                    {
                        $this->_logWarning($msg);
                    }
                }
                if (isset($oEnvMgr->aInfo['PHP']['error']))
                {
                    foreach ($oEnvMgr->aInfo['PHP']['error'] as $msg)
                    {
                        $this->_logError($msg);
                    }
                }
                return false;
            }
        }
        return true;
    }

    function _checkDatabaseEnvironment($name, $aDbms)
    {
        if (count($aDbms)>0)
        {
            $oDbh = OA_DB::singleton();
            $phptype = $oDbh->phptype;
            $supported = false;
            foreach ($aDbms AS $k => &$aItem)
            {
                if ($aItem['name'] == $phptype)
                {
                	$aFound = $aItem;
                }
            }
            if (!($aFound && $aFound['supported']))
            {
                $this->_logError($name.'does not support '.$phptype);
                return false;
            }
        }
        return true;
    }

    /**
     * @todo version dependencies?
     *
     * @param string $name
     * @param array $aDepends
     * @param boolean $require_enabled : check that required plugins are enabled
     * @return boolean
     */
    function _checkDependenciesForInstallOrEnable($name, $aDepends=null)
    {
        if ($aDepends)
        {
            $aConf = $GLOBALS['_MAX']['CONF']['pluginGroupComponents'];
            foreach ($aDepends AS $i => &$aGroup)
            {
                if (!isset($aConf[$aGroup['name']]))
                {
                    $this->_logError('Dependency failure: '.$name.' depends on '.$aGroup['name'].' but '.$aGroup['name'].' is not installed');
                    return false;
                }
                else
                {
                    $installedComponentGroupVersion = $this->getComponentGroupVersion($aGroup['name']);
                    if (version_compare($installedComponentGroupVersion ,$aGroup['version'],'<'))
                    {
                        $this->_logError('Dependency failure: '.$name.' depends on version '.$aGroup['version'].' of '.$aGroup['name'].' but '.$aGroup['name'].' version '.$installedComponentGroupVersion.' is installed');
                        return false;
                    }
                }
                if ($aGroup['enabled'] && (!$aConf[$aGroup['name']]))
                {
                    $this->_logError('Dependency failure: '.$name.' depends on '.$aGroup['name'].' but '.$aGroup['name'].' is not enabled');
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * look for installed groups that depend on $name
     *
     * @param string $name
     * @return boolean
     */
    function _hasDependencies($name, $aExcludes=null)
    {
        $hasDependencies = false;
        $aDepends = $this->_loadDependencyArray();
        if ($aDepends && isset($aDepends[$name]) && isset($aDepends[$name]['isDependedOnBy']) )
        {
            $aConf = $GLOBALS['_MAX']['CONF']['pluginGroupComponents'];
            foreach ($aDepends[$name]['isDependedOnBy'] AS $i => &$group)
            {
                if (isset($aConf[$group]))
                {
                    $hasDependencies[] = $group;
                }
                else
                {
                    // the dependency array lies!  the dependent plugin is not actually installed
                    // never mind, continue and the array will be regenerated after uninstall/disable
                }
            }
        }
        if ($hasDependencies && $aExcludes)
        {
            $hasDependencies = array_diff($hasDependencies, $aExcludes);
        }
        return $hasDependencies;
    }

    /**
     * @todo file checksum?
     *
     * @param string $name
     * @return boolean
     */
    function _checkFiles($name, $aFiles=array())
    {
        foreach ($aFiles AS &$aFile)
        {
            $file = $this->basePath.$this->_expandFilePath($aFile['path'], $aFile['name'], $name);
            if (!file_exists($file))
            {
                $this->_logError('File check failed to find '.$file);
                return false;
            }
        }
        return true;
    }

    /**
     * Check UI Menu checkers
     *  - declared file exists
     *  - declared class exists
     *  - class implements OA_Admin_Menu_IChecker
     *
     * @param string $name
     * @param array $aCheckersList List of checkers
     * @param array $aFiles
     * @return boolean
     */
    function _checkNavigationCheckers($name, $aCheckersList=array(), $aFiles=array())
    {
        if (is_array($aCheckersList) && !empty($aCheckersList))
        {
            foreach ($aCheckersList as &$aChecker) {
                $result = false;
                foreach ($aFiles AS &$aFile)
                {
                    if ($aFile['name'] == $aChecker['include']) {
                        if ($result == true) {
                            $this->_logError('Navigation check found ambigious file name '.$aChecker['name'].', at least two files have the same name declared');
                            return false;
                        }
                        $file = $this->basePath.$this->_expandFilePath($aFile['path'], $aFile['name'], $name);
                        if (file_exists($file) && @include_once $file) {
                            if (!class_exists($aChecker['class'])){
                                $this->_logError('Navigation check failed to find class '.$aChecker['class']);
                                return false;
                            }
                            if(!in_array('OA_Admin_Menu_IChecker', class_implements($aChecker['class']))) {
                                $this->_logError('Navigation check: Class '.$aChecker['class'].' doesn\'t implement OA_Admin_Menu_IChecker interface');
                                return false;
                            }
                            $result = true;
                        }
                    }
                }
                if ($result == false) {
                    $this->_logError('Navigation check failed to find file '.$aChecker['include']);
                    return false;
                }
            }
        }
        return true;
    }

    function _removeFiles($name, $aFiles)
    {
        foreach ($aFiles AS &$aFile)
        {
            $file = $this->basePath.$this->_expandFilePath($aFile['path'], $aFile['name'], $name);
            if (file_exists($file))
            {
                @unlink($file);
                $folder = dirname($file);
                if ($name) // its a group (no name = plugin package)
                {
                    if ( ($folder !=  $this->basePath.rtrim($this->pathPackages,'/')) &&
                         ($folder !=  $this->basePath.rtrim($this->pathPlugins,'/')) &&
                         ($folder !=  $this->basePath.rtrim($this->pathPluginsAdmin,'/')) )
                     {
                        @rmdir($folder);
                     }
                }
            }
        }
        if (!$name) // its a plugin package, won't have files outside the packages folder)
        {
            return true;
        }
        $pathPlugin = $this->basePath.$this->pathPackages.$name;
        $pathEtc = $pathPlugin.'/etc/';

        // upgrade files : files in etc/changes are not declared in definition xml, just delete everything in folder
        $pathChg = $pathEtc.'changes/';
        $dh = @opendir($pathChg);
        if ($dh)
        {
            while (false !== ($file = readdir($dh)))
            {
                if (($file != '.') && ($file != '..'))
                {
                    @unlink($pathChg.$file);
                }
            }
            closedir($dh);
        }
        @rmdir($pathChg);
        @rmdir($pathEtc.'_lang/');
        @rmdir($pathEtc.'_lang/po/');
        @rmdir($pathEtc);
        @rmdir($pathPlugin);
        return true;
    }

    /**
     * @todo if we do manu caching, merge core menu with plugin menu and store
     *
     * @param string $name
     * @param array $aMenus menu section from xml file
     * @param array $aFiles file section from xml file
     * @return boolean
     */
    function _checkMenus($name, $aMenus=null, $aFiles=null)
    {
        if (!$aMenus)
        {
            return true;
        }
        $aCheckers = $this->_prepareMenuCheckers($name, $aMenus['checkers'], $aFiles);
        foreach ($aMenus AS $accountType => &$aMenu)
        {
            if (!$this->aMenuObjects[$accountType])
            {
                $oMenu = $this->_getMenuObject($accountType);
            }
            else
            {
                $oMenu = $this->aMenuObjects[$accountType];
            }
            foreach ($aMenu as $idx => &$aMenu)
            {
                if (!$this->_addMenuSection($oMenu, $aMenu, $aCheckers))
                {
                    return false;
                }
            }
            $this->aMenuObjects[$accountType] = $oMenu;
            return $oMenu;
        }
    }

    /**
     * add full include path to checkers files for Menu Checkers
     * set array keys to checkers classes names
     *
     * @param string $name
     * @param array $aMenuCheckers
     * @param array $aFiles
     * @return array Menu checkers
     */
    function _prepareMenuCheckers($name, $aMenuCheckers = null, $aFiles = null)
    {
        $aCheckers = array();
        if ($aMenuCheckers && $aFiles) {
            foreach($aMenuCheckers as &$aChecker) {
                foreach ($aFiles as &$aFile)
                {
                    if ($aFile['name'] == $aChecker['include']) {
                        $aChecker['path'] = $this->_expandFilePath($aFile['path'], $aFile['name'], $name);
                        break;
                    }
                }
                $aCheckers[$aChecker['class']] = $aChecker;
            }
        }
        return $aCheckers;
    }

    /**
     * return an instance of the core version control class
     *
     * @return object of OA_Version_Controller
     */
    function _getVersionController()
    {
        $oVerControl   = $this->_instantiateClass('OA_Version_Controller');
        $oVerControl->init(OA_DB::singleton());
        return $oVerControl;
    }

    /**
     * @todo make this useful
     *
     * perform a database integrity check
     * perform a dataobject integrity check
     *
     * @param string $name
     * @return boolean
     */
    public function checkDatabase($name, &$aGroup)
    {
        $aResult = array();
        require_once(MAX_PATH.'/lib/OA/Upgrade/DB_Upgrade.php');
        $oDBUpgrader  = $this->_instantiateClass('OA_DB_Upgrade');
        $schema = $aGroup['schema_name'];
        if ($schema)
        {
            $oDBUpgrader->schema = $schema;
            $oDBUpgrader->file_schema = $this->getFilePathToMDB2Schema($name, $schema);
            $enabled = $this->isEnabled($name);
            if (!$enabled)
            {
                $this->enableComponentGroup($name, $aGroup['extends']);
            }
            $oDBUpgrader->buildSchemaDefinition();

            foreach ($oDBUpgrader->oTable->aDefinition['tables'] AS $table => &$aDef)
            {
                $aParams = array($oDBUpgrader->prefix.$table);
                OA_DB::setCaseSensitive();
                $aObjects[$name]['def'] = $oDBUpgrader->oSchema->getDefinitionFromDatabase($aParams);
                OA_DB::disableCaseSensitive();

                $aObjects[$name]['dif'] = $oDBUpgrader->oSchema->compareDefinitions(array('tables'=>array($table=>$aDef)), $aObjects[$name]['def']);
                $aObjects[$name]['dbo'] = OA_Dal::factoryDO($table);
                if ( count($aObjects[$name]['dif']['tables']))
                {
                    $aResult[$table]['schema']      = 'ERROR: schema differences found, details in debug.log';
                    $this->_logError(print_r($aObjects[$name]['dif']['tables'],true),PEAR_LOG_ERR);
                }
                else
                {
                    $aResult[$table]['schema']      = 'OK';
                }
                if ( (!is_a($aObjects[$name]['dbo'],'DataObjects_'.ucfirst($table)))
                     ||
                     (!is_a($aObjects[$name]['dbo'],'DB_DataObjectCommon'))
                   )
                {
                    $aResult[$table]['dataobject']      = 'ERROR: dataobject problems found, details in debug.log ';
                    if (!is_a($aObjects[$name]['dbo'],'DataObjects_'.ucfirst($table)))
                    {
                        $this->_logError('Dataobject classname mismatch '.get_class($aObjects[$name]['dbo']).' should be DataObjects_'.ucfirst($table),PEAR_LOG_ERR);
                    }
                    if (!is_a($aObjects[$name]['dbo'],'DB_DataObjectCommon'))
                    {
                        $this->_logError('Dataobject classtype mismatch '.get_class($aObjects[$name]['dbo']).' is not a DataObjectCommon',PEAR_LOG_ERR);
                    }
                }
                else
                {
                    $aResult[$table]['dataobject']      = 'OK';
                }
                foreach ($aObjects[$name]['def']['tables'][$table]['fields'] AS $field => &$aField)
                {
                    if (!property_exists($aObjects[$name]['dbo'],$field))
                    {
                        $aResult[$table]['dataobject']  = 'ERROR: dataobject problems found, details in debug.log ';
                        $this->_logError('DataObject class definition mismatch '.get_class($aObjects[$name]['dbo']).'::'.$field.' not found',PEAR_LOG_ERR);
                        $this->_logError(print_r($aObjects[$name]['dbo'],true),PEAR_LOG_ERR);
                        $this->_logError(print_r($aField,true),PEAR_LOG_ERR);
                    }
                }
            }
            if (!$enabled)
            {
                $this->disableComponentGroup($name, $aGroup['extends']);
            }
        }
        return $aResult;
    }

    /**
     * execute each of the tasks in the task list
     * on any failure
     * execute each of the tasks in the undo list
     *
     * @param string $name
     * @param array $aTaskList
     * @param array $aUndoList
     * @return boolean
     */
    function _runTasks($name, $aTaskList, $aUndoList=array(), $returnOnError=true)
    {
        foreach ($aTaskList as &$aTask)
        {
            $this->_logMessage('Executing '.$aTask['method'].' for '.$name);
            $result = call_user_func_array(array($this, $aTask['method']), $aTask['params']);
            if (!$result)
            {
                $this->_logError('Task failed '.$aTask['method']);
                if ($aUndoList)
                {
                    $this->_runTasks($name, $aUndoList);
                }
                if ($returnOnError)
                {
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * run a custom php script
     *
     * @param string $name
     * @param string $file
     * @return boolean
     */
    function _runScript($name, $file='')
    {
        static $aClassNames;

        if (!$file)
        {
            //OA::debug('No file to run');
            return true;
        }
        $file = $this->getPathToComponentGroup($name).'etc/'.$file;
        if (!file_exists($file))
        {
            $this->_logError('File does not exist '.$path.$file);
            return false;
        }
        $className = '';
        if (!@require_once $path.$file)
        {
            $this->_logError('Failed to acquire file '.$path.$file);
            return false;
        }
        if (!empty($className)) {
            $aClassNames[$path.$file] = $className;
        } else {
            $className = $aClassNames[$path.$file];
        }
        // $classname is declared in script
        $oScript = $this->_instantiateClass($className);
        if (!$oScript)
        {
            return false;
        }
        if (!is_callable(array($oScript, 'execute')))
        {
            $this->_logError('Execute method not callable '.$className);
            return false;
        }
        if (property_exists($oScript, 'oManager'))
        {
            $oScript->oManager = & $this;
        }
        if (!isset($aParams)) {
            $ret = call_user_func(array($oScript, 'execute'));
        } else {
            if (!is_array($aParams)) {
                $aParams = array($aParams);
            }
            $ret = call_user_func_array(array($oScript, 'execute'), $aParams);
        }
        if (!$ret) {
            $this->_logError('Failed to execute '.$className);
            return false;
        }
        return true;
    }

    /**
     * build and save the dependency array a a cached file
     *
     * @return boolean
     */
    function _cacheDependencies()
    {
        return $this->_saveDependencyArray($this->_buildDependencyArray());
    }

    /**
     * for each plugin, get its dependencies
     * create an array of plugins that rely on other plugins
     * create an array of plugins that are relied on by other plugins
     * store the installed/enabled status of each plugin
     * create an array of warnings where dependencies are broken
     *
     * @return array
     */
    function _buildDependencyArray()
    {
        $aResult = array();
        $aConf = $GLOBALS['_MAX']['CONF']['pluginGroupComponents'];
        foreach ($aConf as $name => $enabled)
        {
            $file = $this->getFilePathToXMLInstall($name);
            if (!file_exists($file))
            {
                $msg = 'PLUGIN DEPENDENCY PROBLEM: : unable to determine dependencies for '.$name.' - could not locate definition at '.$file;
                $this->_logError($msg);
            }
            else
            {
                $aParse = $this->parseXML($file);
                foreach ($aParse['install']['syscheck']['depends'] AS &$aDepends)
                {
                    $aResult[$aDepends['name']]['isDependedOnBy'][] = $name;
                    $installed  = (isset($aConf[$aDepends['name']]) ? true : false );
                    if (!$installed)
                    {
                        $aResult[$name]['dependsOn'][$aDepends['name']] = OX_PLUGIN_DEPENDENCY_NOTFOUND;
                        $msg = 'PLUGIN DEPENDENCY PROBLEM: '.$name.' depends on '.$aDepends['name'].' but '.$aDepends['name'].' is not installed!';
                        $this->_logError($msg);
                    }
                    else
                    {
                        $versionRequired = $aDepends['version'];
                        $version = $this->getComponentGroupVersion($aDepends['name']);
                        $aResult[$name]['dependsOn'][$aDepends['name']] =  $versionRequired;

                        if (version_compare($version, $versionRequired,'<'))
                        {
                            $aResult[$name]['dependsOn'][$aDepends['name']] = OX_PLUGIN_DEPENDENCY_BADVERSION;
                            $msg = 'PLUGIN DEPENDENCY PROBLEM: '.$name.' depends on '.$aDepends['name'].' version '.$versionRequired.' but '.$aDepends['name'].' is version '.$version;
                            $this->_logError($msg);
                        }
                    }
                }
            }
        }
        return $aResult;
    }

    function _getOA_Cache($group, $id)
    {
        $oCache = new OA_Cache($group, $id);
        return $oCache;
    }

    /**
     * save an array of dependency information in a cache file
     *
     * @param array $aDepends
     * @return boolean
     */
    function _saveDependencyArray($aDepends)
    {
        $oCache = $this->_getOA_Cache('Plugins', 'Dependencies');
        $oCache->setFileNameProtection(false);
        return $oCache->save($aDepends);
    }

    /**
     * load an array of dependency information for a cache file
     *
     * @return array
     */
    function _loadDependencyArray()
    {
        $oCache = $this->_getOA_Cache('Plugins', 'Dependencies');
        $oCache->setFileNameProtection(false);
        return $oCache->load(true);
    }

    /**
     * clear the cached dependency array
     *
     * @return boolean
     */
    function _clearDependencyCache()
    {
        $oCache = $this->_getOA_Cache('Plugins', 'Dependencies');
        $oCache->setFileNameProtection(false);
        return $oCache->clear();
    }

    /**
     * merge the plugin dataojbect schema and links ini files and cache them
     *
     * @param string $newPluginName
     * @param array $aNewSchema
     * @param string $pathOutput
     * @return array | boolean false on error
     */
    function _cacheDataObjects($newPluginName=null, $aNewSchema=null, $pathOutput=null)
    {
        $aReturn    = array();
        $pathOutput = (is_null($pathOutput) ? $this->basePath.$this->pathDataObjects : $pathOutput);
        $aConf      = $GLOBALS['_MAX']['CONF']['pluginGroupComponents'];

        $oConfigSchema = $this->_instantiateClass('Config');
        $oConfigLinks  = $this->_instantiateClass('Config');

        // parse the installed plugin's schema configs
        foreach ($aConf as $name => $enabled)
        {
            $aSchema = $this->_getDataObjectSchema($name);
            if ($aSchema)
            {
                if (!$this->_parseDataObjectSchemaConfig($name, $aSchema, $oConfigSchema, $oConfigLinks))
                {
                    return false;
                }
            }
        }
        // parse the new plugin's schema config
        if ($newPluginName)
        {
            if (is_null($aNewSchema))
            {
                // parse the xml to get new schema info
                $aNewSchema = $this->_getDataObjectSchema($newPluginName);
                if (is_null($aNewSchema))
                {
                    return false;
                }
            }
            if (!$this->_parseDataObjectSchemaConfig($newPluginName, $aNewSchema, $oConfigSchema, $oConfigLinks))
            {
                return false;
            }
        }
        // write the schema and links files
        $aReturn['schemas'] = $oConfigSchema->getRoot();
        $aReturn['links']   = $oConfigLinks->getRoot();
        $result = $oConfigSchema->writeConfig($pathOutput.'db_schema.ini', 'inifile');
        if (PEAR::isError($result))
        {
            $this->_logError('Failed to write '.$pathOutput.'db_schema.ini');
            return false;
        }
        $result = $oConfigLinks->writeConfig($pathOutput.'db_schema.links.ini', 'inifile');
        if (PEAR::isError($result))
        {
            $this->_logError('Failed to write '.$pathOutput.'db_schema.links.ini');
            return false;
        }
        return $aReturn;
    }

    /**
     * parse a plugin xml file
     * return only the schema portion of the array
     *
     * @param string $name
     * @return array
     */
    function _getDataObjectSchema($name)
    {
        $file = $this->getFilePathToXMLInstall($name);
        if (!file_exists($file))
        {
            $this->_logError('Unable to determine schema requirements for '.$name.' - could not locate definition at '.$file);
            return $false;
        }
        $aGroup = $this->parseXML($file, 'OX_ParserComponentGroup');
        return $aGroup['install']['schema'];
    }

    /**
     * parse the dataobject schema and links ini files
     * adding them to the appropriate config object
     *
     * @param string $name
     * @param array $aSchema
     * @param object of Config $oConfigSchema
     * @param object of Config $oConfigLinks
     * @return boolean
     */
    function _parseDataObjectSchemaConfig($name, $aSchema, &$oConfigSchema, &$oConfigLinks)
    {
        if ($aSchema['dboschema'])
        {
            $schemaPath     = dirname($this->getFilePathToMDB2Schema($name, $aSchema['mdb2schema']));
            $fileIn = $schemaPath.'/DataObjects/'.$aSchema['dboschema'].'.ini';
            if (!file_exists($fileIn))
            {
                $this->_logError('PLUGIN SCHEMA PROBLEM: : unable to determine schema requirements for '.$name.' - could not locate definition at '.$fileIn);
                return false;
            }
            $oConfigSchema->parseConfig($fileIn, 'inifile');
            if (!empty($aSchema['dbolinks']))
            {
                $fileIn  = $schemaPath.'/DataObjects/'.$aSchema['dbolinks'].'.ini';
                if (!file_exists($fileIn))
                {
                    $this->_logError('PLUGIN SCHEMA PROBLEM: : unable to determine schema requirements for '.$name.' - could not locate definition at '.$fileIn);
                    return false;
                }
                $oConfigLinks->parseConfig($fileIn, 'inifile');
            }
        }
        return true;
    }

    /**
     * copy dataobject files for given plugin
     *
     * @param string $name
     * @param array $aSchema
     * @param string $pathTarget
     * @return boolean
     */
    function _putDataObjects($name=null, $aSchema=null, $pathTarget=null)
    {
        if (empty($aSchema['dataobjects']))
        {
            $this->_logError('No dataobjects defined for '.$name, PEAR_LOG_ERR);
            return false;
        }
        $pathTarget = (is_null($pathTarget) ? $this->basePath.$this->pathDataObjects : $pathTarget);
        if (!file_exists($pathTarget))
        {
            $this->_logError('Invalid source path to plugin dataobjects '.$pathTarget, PEAR_LOG_ERR);
            return false;
        }
        $pathSource = dirname($this->getFilePathToMDB2Schema($name, $aSchema['mdb2schema'])).'/DataObjects/';
        if (!file_exists($pathSource))
        {
            $this->_logError('Invalid target path for plugin dataobjects '.$pathSource, PEAR_LOG_ERR);
            return false;
        }
        foreach ($aSchema['dataobjects'] AS $idx => &$file)
        {
            if (!file_exists($pathSource.$file))
            {
                $this->_logError('Failed to find source file '.$pathSource.$file.' for '.$name, PEAR_LOG_ERR);
                return false;
            }
            if (!@copy($pathSource.$file, $pathTarget.$file))
            {
                $this->_logError('Failed to copy dataobject '.$pathSource.$file.' to '.$pathTarget.$file, PEAR_LOG_ERR);
                return false;
            }
        }
        return true;
    }

    /**
     * delete dataobject files for given plugin
     *
     * @param string $name
     * @param array $aSchema
     * @param string $pathTarget
     * @return boolean
     */
    function _removeDataObjects($name=null, $aSchema=null, $pathTarget=null)
    {
        if (empty($aSchema['dataobjects']))
        {
            $this->_logError('No dataobjects defined for '.$name, PEAR_LOG_ERR);
            return false;
        }
        $pathTarget = (is_null($pathTarget) ? $this->basePath.$this->pathDataObjects : $pathTarget);
        if (!file_exists($pathTarget))
        {
            $this->_logError('Invalid source path to plugin dataobjects '.$pathTarget.' for '.$name, PEAR_LOG_ERR);
            return false;
        }
        foreach ($aSchema['dataobjects'] AS $idx => &$file)
        {
            if (file_exists($pathTarget.$file))
            {
                if (!@unlink($pathTarget.$file))
                {
                    $this->_logError('Failed to remove dataobject '.$pathTarget.$file.' for '.$name, PEAR_LOG_ERR);
                }
            }
        }
        return true;
    }

    function mergeMenu(&$oMenu, $accountType)
    {
        if (is_array($GLOBALS['_MAX']['CONF']['pluginGroupComponents'])) {
            $aGroups = $GLOBALS['_MAX']['CONF']['pluginGroupComponents'];
        } else {
            $aGroups = array();
        }

        foreach ($aGroups as $name => &$enabled)
        {
            if ($enabled)
            {
                $file = $this->getFilePathToXMLInstall($name);
                if (!@file_exists ($file))
                {
                    continue;
                }
                $aParse = $this->parseXML($file);
                if (isset($aParse['install']['navigation'][$accountType]))
                {
                    $aCheckers = $this->_prepareMenuCheckers($name, $aParse['install']['navigation']['checkers'], $aParse['install']['files']);
                    foreach ($aParse['install']['navigation'][$accountType] as $idx => &$aMenu)
                    {
                        if (!$this->_addMenuSection($oMenu, $aMenu, $aCheckers))
                        {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * add a section to a menu object
     *
     * @param object of type OA_Admin_Menu $oMenu
     * @param array $aMenu
     * @param array $aCheckers
     * @return boolean
     */
    function _addMenuSection(&$oMenu, &$aMenu, &$aCheckers)
    {
        if (isset($aMenu['exclusive'])) {
            if ($aMenu['exclusive'] == 'true' || $aMenu['exclusive'] == '1') {
                $aMenu['exclusive'] = true;
            } else {
                $aMenu['exclusive'] = false;
            }
        }
        if ($aMenu['add'])
        {
            if ($oMenu->get($aMenu['add'],false))
            {
                // menu already exists
                $this->_logError('Menu already exists for '.$aMenu['add']);
                return false;
            }
            $oMenuSection = new OA_Admin_Menu_Section($aMenu['add'], $aMenu['value'], $aMenu['link'], $aMenu['exclusive'], $aMenu['helplink']);
            $oMenu->add($oMenuSection);
        }
        elseif ($aMenu['replace'])
        {
			if (!$oMenu->get($aMenu['replace'],false))
			{
			    $this->_logError('Menu to replace does not exist '.$aMenu['replace']);
			    return false;
			}
			if( !empty($aMenu['index']) && $aMenu['index'] != $aMenu['replace'])
			{
			    $this->_logError('When replacing a menu, you can\'t define an \'index\' in the menu definition that is different from the menu index it is replacing.
			    You can also simply remove the \'index='.$aMenu['index'].' from your menu definition file.');
			    return false;
			}
			$oMenuSection = $oMenu->get($aMenu['replace'], false);
			if($aMenu['value']) $oMenuSection->setNameKey($aMenu['value']);
			if($aMenu['link']) $oMenuSection->setLink($aMenu['link']);
			if($aMenu['exclusive']) $oMenuSection->setExclusive($aMenu['exclusive']);
			if($aMenu['helplink']) $oMenuSection->setHelpLink($aMenu['helplink']);
			$oMenuSection->setSectionHasBeenReplaced();
        }
        else
		{
            if ($oMenu->get($aMenu['index'],false))
            {
                $this->_logError('Menu already exists for '.$aMenu['index']);
                return false;
            }
            $oMenuSection = new OA_Admin_Menu_Section($aMenu['index'], $aMenu['value'], $aMenu['link'], $aMenu['exclusive'], $aMenu['helplink']);
            if ($aMenu['addto'])
            {
                if (!$oMenu->get($aMenu['addto'],false))
                {
                    $this->_logError('Parent menu does not exist for '.$aMenu['addto']);
                    return false;
                }
                $oMenu->addTo($aMenu['addto'], $oMenuSection);
            }
            else if ($aMenu['insertafter'])
            {
                if (!$oMenu->get($aMenu['insertafter'],false))
                {
                    $this->_logError('Menu to insert after does not exist '.$aMenu['insertafter']);
                    return false;
                }
                $oMenu->insertAfter($aMenu['insertafter'], $oMenuSection);
            }
            else if ($aMenu['insertbefore'])
            {
                if (!$oMenu->get($aMenu['insertbefore'],false))
                {
                    $this->_logError('Menu to insert before does not exist '.$aMenu['insertbefore']);
                    return false;
                }
                $oMenu->insertBefore($aMenu['insertbefore'], $oMenuSection);
            }
        }
        if ($aMenu['checker'])
        {
            $checkerClassName = $aMenu['checker'];
            @include_once MAX_PATH . $aCheckers[$checkerClassName]['path'];
            if (class_exists($checkerClassName))
            {
                $oMenu->addCheckerIncludePath($checkerClassName, $aCheckers[$checkerClassName]['path']);
                $oChecker = new $checkerClassName;
                $oMenuSection->setChecker($oChecker);
            }
        }
        return true;
    }

    function &_getOA_Admin_Menu($accountType)
    {
        return new OA_Admin_Menu($accountType);
    }

    /**
     * return a menu object for a given account type
     * note: we want a *clean* object, not the global one
     *
     * @return object of type OA_Admin_Menu
     */
    function _getMenuObject($accountType)
    {
        $oMenu = $this->_getOA_Admin_Menu($accountType);
        if (empty($oMenu->aAllSections))
        {
            include_once MAX_PATH. '/lib/OA/Admin/Menu/config.php';
            $oMenu = _buildNavigation($accountType);
        }
        return $oMenu;
    }

    public function getComponentGroupsList($aGroups=null)
    {
        if (!$aGroups)
        {
            $aGroups = array_reverse(array_keys($GLOBALS['_MAX']['CONF']['pluginGroupComponents']));
        }
        $aResult = array();
        foreach ($aGroups as $k => &$v)
        {
            $aResult[] = $this->getComponentGroupInfo($v);
        }
        return $aResult;
    }

    /**
     * return installed plugin version from the application variable table
     *
     * @param string $name
     * @return string
     */
    public function getComponentGroupVersion($name)
    {
        $oVerControl = $this->_getVersionController();
        if (!$oVerControl)
        {
            return false;
        }
        return $oVerControl->getApplicationVersion($name);
    }

    /**
     * return an array of information about the plugin
     *
     * @param string $name
     * @return boolean
     */
    public function getComponentGroupInfo($name)
    {
        $file = $this->getFilePathToXMLInstall($name);
        $aGroup = array();
        if (!@file_exists ($file))
        {
            return array();
        }
        $aParse = $this->parseXML($file,'OX_ParserComponentGroup');
        $aConf = &$GLOBALS['_MAX']['CONF']['pluginGroupComponents'];
        $aGroup['installed']   = (isset($aConf[$name]) ? true : false);
        $aGroup['enabled']     = ($aGroup['installed'] && $aConf[$name] ? true : false);
        $aGroup['settings']    = false;
        $aGroup['preferences'] = false;
        foreach ($aParse AS $k => &$v)
        {
            if (!is_array($v))
            {
                $aGroup[$k] = $v;
            }
            else if ($k == 'install' && isset($v['conf']))
            {
                if (count($v['conf']['settings'])>0)
                {
                    foreach ($v['conf']['settings'] as $setting) {
                        if (!empty($setting['visible'])) {
                            $aGroup['settings'] = true;
                        }
                    }
                }
                if (count($v['conf']['preferences'])>0)
                {
                    $aGroup['preferences'] = true;
                }
            }
        }
        $schema_version = $this->getSchemaInfo($aParse['install']['schema']['mdb2schema']);
        if ($schema_version)
        {
            $aGroup['schema_name']     = $aParse['install']['schema']['mdb2schema'];
            $aGroup['schema_version']  = $schema_version;
        }
        $aGroup['components'] = $aParse['install']['components'];

        unset($aGroup['upgrade']);
        return $aGroup;
    }

    /**
     * return the version of the plugin's schema
     *
     * @param string $schema
     * @return boolean
     */
    public function getSchemaInfo($schema)
    {
        $oVerControl = $this->_getVersionController();
        if (!$oVerControl)
        {
            return false;
        }
        $version = $oVerControl->getSchemaVersion($schema);
        if (!$version)
        {
            return false;
        }
        return $version;
    }

     /**
     * parse a plugin xml file
     * return only the configuration portion of the array
     *
     * @param string $name
     * @return array
     */
    function _getComponentGroupConfiguration($name)
    {
        $file = $this->getFilePathToXMLInstall($name);
        if (!file_exists($file))
        {
            $this->_logError('Unable to determine configuration requirements for '.$name.' - could not locate definition at '.$file);
            return $false;
        }
        $aGroup = $this->parseXML($file);
        return $aGroup['install']['conf'];
    }

    /**
     *
     * @param string $name The name of the group
     * @param bolean $visibleOnly Should only visible settings be returned?
     *
     * @return array The array of settings for this component group
     */
    function getComponentGroupSettings($name, $visibleOnly = false)
    {
        $aGroup = $this->_getComponentGroupConfiguration($name);
        $aSettings = $aGroup['settings'];
        if ($visibleOnly) {
            foreach ($aSettings as $k => $v) {
                if (empty($v['visible'])) {
                    unset($aSettings[$k]);
                }
            }
        }
        return $aSettings;;
    }

    function getComponentGroupObjectsInfo($extends, $group)
    {
        require_once LIB_PATH.'/Plugin/Component.php';
        $aComponents = OX_Component::getComponents($extends, $group, false, true, false);
        foreach ($aComponents as &$obj)
        {
            $aResult[] = (array)$obj;
        }
        return $aResult;
        //$aGroupInfo['pluginGroupComponents'] = OX_Component::_getComponentFiles($aGroupInfo['extends'], $plugin);
    }


    function _expandFilePath($path, $file, $groupname='', $pluginname='')
    {
        $aPattern   = array(OX_PLUGIN_PLUGINPATH_REX, OX_PLUGIN_GROUPPATH_REX, OX_PLUGIN_MODULEPATH_REX, OX_PLUGIN_ADMINPATH_REX);
        $aReplace   = array($this->pathPackages, $this->pathPackages.$groupname, $this->pathPlugins, $this->pathPluginsAdmin.$groupname);
        $result     = preg_replace($aPattern,$aReplace,$path.$file);
        return $result;
    }

    /* possible replacement for _instantiateClass() with params
      function Generator() {

       $numargs = func_num_args();

       $classname = func_get_arg(0);
       $argstring='';
       if ($numargs > 1) {
          $arg_list = func_get_args();

          for ($x=1; $x<$numargs; $x++) {
             $argstring .= '$arg_list['.$x.']';
             if ($x != $numargs-1) $argstring .= ',';
          }
       }

       if (class_exists("Custom{$classname}")) {
          $classname = "Custom{$classname}";
          if ($argstring) return eval("return new $classname($argstring);");
          return new $classname;
       }

       if ($argstring) return eval("return new $classname($argstring);");
       return new $classname;
    } */

}

?>
