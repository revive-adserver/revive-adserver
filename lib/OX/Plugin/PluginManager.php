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

// Required files
require_once LIB_PATH . '/Extension/deliveryLog/Setup.php';
require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';
require_once LIB_PATH . '/Plugin/ParserPlugin.php';

define('OX_PLUGIN_ERROR_PACKAGE_OK', 1);
define('OX_PLUGIN_ERROR_PACKAGE_NAME_EXISTS', 0);
define('OX_PLUGIN_ERROR_PACKAGE_DEFINITION_NOT_FOUND', -1);
define('OX_PLUGIN_ERROR_PACKAGE_EXTRACT_FAILED', -2);
define('OX_PLUGIN_ERROR_PACKAGE_PARSE_FAILED', -3);
define('OX_PLUGIN_ERROR_PACKAGE_VERSION_NOT_FOUND', -4);
define('OX_PLUGIN_ERROR_PLUGIN_DEFINITION_MISSING', -5);
define('OX_PLUGIN_ERROR_PLUGIN_NAME_EXISTS', -6);
define('OX_PLUGIN_ERROR_PACKAGE_CONTENTS_MISMATCH', -7);
define('OX_PLUGIN_ERROR_PLUGIN_EXTRACT_FAILED', -8);
define('OX_PLUGIN_ERROR_PLUGIN_PARSE_FAILED', -9);
define('OX_PLUGIN_ERROR_FILE_COUNT_MISMATCH', -10);
define('OX_PLUGIN_ERROR_ILLEGAL_FILE', -11);
define('OX_PLUGIN_ERROR_PLUGIN_DECLARATION_MISMATCH', -12);
define('OX_PLUGIN_OLDER_VERSION_INSTALLED', 1);
define('OX_PLUGIN_SAME_VERSION_INSTALLED', 2);
define('OX_PLUGIN_NEWER_VERSION_INSTALLED', 3);


//define('OX_PLUGIN_DIR_WRITE_MODE', 0755);
define('OX_PLUGIN_DIR_WRITE_MODE', 0777);

/**
 * @package OpenXPlugin
 */
class OX_PluginManager extends OX_Plugin_ComponentGroupManager
{
    public $errcode;

    public $aExtensionsAffected = [];
    public $oExtensionManager;

    public $aParse = ['package' => [], 'plugins' => []];

    public $pluginLogSwitchCounter = 0;

    public $previousVersionInstalled;

    public $configLocked;

    /** @var string */
    public $basePath;

    /**
     * return the path to the packages folder
     *
     * @return string
     */
    public function getPathToPackages()
    {
        return $this->basePath . $this->pathPackages;
    }

    /**
     * @todo write test
     *
     * @param string $name
     * @return boolean
     */
    public function isEnabled($name)
    {
        return ($GLOBALS['_MAX']['CONF']['plugins'][$name] ? true : false);
    }

    /**
     * An extension may need to run tasks when plugins change
     * It can provide a class with methods that hook onto some plugin manager events
     *
     * BeforePluginInstall
     * AfterPluginInstall
     * BeforePluginUninstall
     * AfterPluginInstall
     * BeforePluginEnable
     * AfterPluginEnable
     * BeforePluginDisable
     * AfterPluginDisable
     *
     * @param unknown_type $event
     */
    public function _runExtensionTasks($event)
    {
        if (!$this->oExtensionManager) {
            require_once(LIB_PATH . '/Extension.php');
            $this->oExtensionManager = $this->_instantiateClass('OX_Extension');
        }
        $this->oExtensionManager->aExtensions = $this->aExtensionsAffected;
        $this->oExtensionManager->runTasksForEvent($event);
    }

    public function _getParsedPackage()
    {
        return $this->aParse['package'];
    }

    public function _getParsedPlugins()
    {
        return $this->aParse['plugins'];
    }

    public function _setParsedPluginVersionsFromDB()
    {
        foreach ($this->aParse['plugins'] as $idx => $aGroup) {
            $dbVersion = $this->getComponentGroupVersion($aGroup['name']);
            if (!empty($dbVersion)) {
                $this->aParse['plugins'][$idx]['version'] = $dbVersion;
            }
        }
    }

    public function upgradePackage($aFile, $name, $allowEqualVersion = false)
    {
        $this->_switchToPluginLog();
        try {
            if (!@file_exists($aFile['tmp_name'])) {
                throw new Exception('Failed to read the uploaded file');
            }
            if (!$this->_matchPackageFilename($name, $aFile['name'])) {
                throw new Exception('Package filename mismatch, the file must contain the package name ' . $aFile['name']);
            }
            if (!$this->_parsePackage($name)) {
                throw new Exception('Failed to parse the current package ' . $name);
            }
            $aPackageOld = $this->_getParsedPackage();
            if (!$this->_parseComponentGroups($aPackageOld['install']['contents'])) {
                throw new Exception('Failed to parse the current plugins in package ' . $name);
            }
            $this->_setParsedPluginVersionsFromDB();
            $aPluginsOld = $this->_getParsedPlugins();
            $this->aParse = [];

            // Parse the plugin file in the var/tmp folder
            $this->unpackPlugin($aFile, true, true);

            $aPackageNew = $this->_getParsedPackage();
            if ($name != $aPackageNew['name']) {
                throw new Exception('Upgrade package name ' . $aPackageNew['name'] . '" does not match the package you are upgrading ' . $name);
            }
            if (version_compare($aPackageOld['version'], $aPackageNew['version'], '<')) {
                $this->previousVersionInstalled = OX_PLUGIN_OLDER_VERSION_INSTALLED;
            } elseif (version_compare($aPackageOld['version'], $aPackageNew['version'], '>')) {
                $this->previousVersionInstalled = OX_PLUGIN_NEWER_VERSION_INSTALLED;
                throw new Exception('Upgrade package ' . $aPackageNew['name'] . '" has a version stamp that is older than that of the package you have installed');
            } elseif (version_compare($aPackageOld['version'], $aPackageNew['version'], '==') && !$allowEqualVersion) {
                $this->previousVersionInstalled = OX_PLUGIN_SAME_VERSION_INSTALLED;
                throw new Exception('Upgrade package ' . $aPackageNew['name'] . '" has the same version stamp as that of the package you have installed');
            }

            $enabled = (!empty($GLOBALS['_MAX']['CONF']['plugins'][$name])) ? true : false;
            $this->disablePackage($name, true);
            if (!$this->unpackPlugin($aFile, true)) {
                throw new Exception();
            }
            if ($enabled) {
                $this->enablePackage($name);
            }
            $aPluginsNew = $this->_getParsedPlugins();
            $this->_runExtensionTasks('BeforePluginInstall');
            $this->_auditSetKeys(
                ['upgrade_name' => 'upgrade_' . $name,
                                        'version_to' => $aPackageNew['version'],
                                        'version_from' => $aPackageOld['version'],
                                        'logfile' => 'plugins.log'
                                        ]
            );
            $auditId = $this->_auditStart(
                ['description' => 'PACKAGE UPGRADE FAILED',
                                                'action' => UPGRADE_ACTION_UPGRADE_FAILED,
                                               ]
            );
            if (!$this->_canUpgradeComponentGroups($aPluginsNew, $aPluginsOld)) {
                if ($this->oUpgrader) {
                    $this->aErrors = $this->oUpgrader->getErrors();
                    $this->aWarning = $this->oUpgrader->getMessages();
                }
                throw new Exception('One or more plugins cannot be upgraded');
            }
            if (!$this->_upgradeComponentGroups($aPluginsNew, $aPluginsOld)) {
                throw new Exception('Failed to install plugins for package ' . $name);
            }
            $this->_auditUpdate(
                ['description' => 'UPGRADE COMPLETE',
                                      'action' => UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                      'id' => $auditId,
                                     ]
            );
            $this->_runExtensionTasks('AfterPluginInstall');
            $result = true;
        } catch (Exception $e) {
            $this->_logError($e->getMessage());
            $result = false;
        }
        $this->_switchToDefaultLog();
        return $result;
    }

    /**
     * check uploaded file
     * check file contents
     * unpack file contents
     *
     * @param array $aFile
     * @return boolean
     */
    public function unpackPlugin($aFile, $overwrite = true, $checkOnly = false)
    {
        //OA::logMem('enter unpackPlugin');
        $this->_switchToPluginLog();
        try {
            if ($this->configLocked) {
                throw new Exception('Configuration file is locked unable to unpack' . $aFile['name']);
            }
            if (!@file_exists($aFile['tmp_name'])) {
                throw new Exception('Failed to read the uploaded file');
            }
            if (!$this->_unpack($aFile, $overwrite, $checkOnly)) {
                throw new Exception('The uploaded file ' . $aFile['name'] . ' was not unpacked');
            }
            $result = true;
        } catch (Exception $e) {
            $this->_logError($e->getMessage());
            $result = false;
        }
        //OA::logMem('exit unpackPlugin');
        $this->_switchToDefaultLog();
        return $result;
    }

    public function installPackageCodeOnly($aFile)
    {
        if (!$this->unpackPlugin($aFile, true)) {
            return false;
        }
        $this->_switchToPluginLog();
        try {
            foreach ($this->aParse['plugins'] as &$aGroup) {
                if (!empty($aGroup['install']['schema']['dataobjects'])) {
                    $aSchema = $aGroup['install']['schema'];
                    $name = $aGroup['name'];
                    if (!$this->_putDataObjects($name, $aSchema)) {
                        throw new Exception('Failed to copy dataobject classes for ' . $name);
                    }
                    if (!$this->_cacheDataObjects($name, $aSchema)) {
                        throw new Exception('Failed to merge dataobject schema for ' . $name);
                    }
                }
            }
            $result = true;
        } catch (Exception $e) {
            $this->_logError($e->getMessage());
            $result = false;
        }
        $this->_switchToDefaultLog();
        return $result;
    }

    /**
     * parse a package definition file
     * parse each of the plugins contained therein
     * install each of the plugins contained therein
     * set the conf value of the package to installed but disabled
     *
     * @param array $aFile
     * @return boolean
     */
    public function installPackage($aFile)
    {
        //OA::logMem('enter installPackage');
        if (!$this->unpackPlugin($aFile, false)) {
            return false;
        }
        $this->_switchToPluginLog();
        try {
            $aPackage = &$this->aParse['package'];
            $aPlugins = &$this->aParse['plugins'];
            $this->_runExtensionTasks('BeforePluginInstall');
            $this->_auditSetKeys(
                ['upgrade_name' => 'install_' . ($aPackage['name'] ?? ''),
                                        'version_to' => $aPackage['version'] ?? 0,
                                        'version_from' => 0,
                                        'logfile' => 'plugins.log'
                                        ]
            );
            $auditId = $this->_auditStart(
                ['description' => 'PACKAGE INSTALL FAILED',
                                                'action' => UPGRADE_ACTION_INSTALL_FAILED,
                                                ]
            );

            if (!$this->_installComponentGroups($aPlugins)) {
                $this->_logError('Failed to install plugins for package ' . ($aPackage['name'] ?? ''));
                $this->_uninstallComponentGroups($aPlugins);
                throw new Exception();
            }
            // this sets up conf but leaves package disabled
            if (!$this->_registerPackage($aPackage['name'] ?? '')) {
                throw new Exception();
            }
            $this->_auditUpdate(
                ['description' => 'PACKAGE INSTALL COMPLETE',
                                      'action' => UPGRADE_ACTION_INSTALL_SUCCEEDED,
                                      'id' => $auditId,
                                     ]
            );
            $this->_runExtensionTasks('AfterPluginInstall');
            $result = true;
        } catch (Exception $e) {
            $this->_logError($e->getMessage());
            $result = false;
        }
        if ($result && !empty($GLOBALS['_MAX']['CONF']['pluginSettings']['enableOnInstall']) && empty($_REQUEST['disabled'])) {
            $this->enablePackage($aPackage['name']);
        }

        //OA::logMem('exit installPackage');
        $this->_switchToDefaultLog();
        return $result;
    }

    /**
     * parse a package definition file
     * parse each of the plugins contained therein
     * uninstall each of the plugins contained therein
     * remove the conf setting for the package
     *
     * In case the plugin is not compatible anymore, the force argument will
     * avoid executing the plugin files
     *
     * @param array string
     * @param bool $force
     * @return boolean
     */
    public function uninstallPackage($name, $force = false)
    {
        $this->_switchToPluginLog();
        try {
            if ($this->configLocked) {
                throw new Exception('Configuration file is locked unable to uninstall ' . $name);
            }
            if (!$this->_parsePackage($name)) {
                throw new Exception('Failed to parse the package definition for ' . $name);
            }
            $aPackage = &$this->aParse['package'];
            if (!$this->_parseComponentGroups($aPackage['install']['contents'] ?? null)) {
                throw new Exception('Failed to parse the plugin definitions contained in package ' . $name);
            }
            $aGroups = &$this->aParse['plugins'];
            if (!is_array($aGroups)) {
                throw new Exception('No component groups found in package ' . $name);
            }
            krsort($aGroups);
            if (!$this->_canUninstallPlugin($aGroups)) {
                throw new Exception('You may not uninstall this plugin at this time');
            }
            $this->_runExtensionTasks('BeforePluginUninstall');
            $this->_auditSetKeys(
                ['upgrade_name' => 'uninstall_' . ($aPackage['name'] ?? ''),
                                        'version_to' => 0,
                                        'version_from' => $aPackage['version'] ?? 0,
                                        'logfile' => 'plugins.log'
                                        ]
            );
            $auditId = $this->_auditStart(
                ['description' => 'PACKAGE UNINSTALL FAILED',
                                                'action' => UPGRADE_ACTION_UNINSTALL_FAILED,
                                               ]
            );
            // just in case anything goes wrong, e.g. half uninstall - don't want app trying to use half a package
            $this->disablePackage($name, $force);
            if (!$this->_uninstallComponentGroups($aGroups)) {
                throw new Exception('Failed to uninstall package ' . $name);
            }
            if (!$this->_unregisterPackage($name)) {
                throw new Exception('Failed to unregister package ' . $name);
            }
            if (!$this->_removeFiles('', $aPackage['allfiles'] ?? [])) {
                $this->_logError('Failed to remove some files belonging to ' . $name);
            }
            $pkgDefinition = $this->basePath . $this->pathPackages . $name . '.xml';
            if (file_exists($pkgDefinition)) {
                @unlink($pkgDefinition);
            }

            $this->_auditUpdate(
                ['description' => 'PACKAGE UNINSTALL COMPLETE',
                                      'action' => UPGRADE_ACTION_UNINSTALL_SUCCEEDED,
                                      'id' => $auditId,
                                     ]
            );
            $this->_runExtensionTasks('AfterPluginUninstall');


            $result = true;
        } catch (Exception $e) {
            $this->_logError($e->getMessage());
            $result = false;
        }
        //OA::logMem('exit unpackPlugin');
        $this->_switchToDefaultLog();
        return $result;
    }

    public function _canUninstallPlugin(&$aGroups)
    {
        $result = true;
        $aDepends = $this->_loadDependencyArray();
        foreach ($aGroups as $i => &$aGroup) {
            if (is_array($aGroup)) {
                $aGroups[$i] = $aGroup['name'];
            }
        }
        foreach ($aGroups as $i => &$group) {
            $aDependencies = $this->_hasDependencies($group, $aGroups);
            if ($aDependencies) {
                $this->_logError($group . ' has dependencies'); //.$group.' depends on '.$name);
                $result = false;
            }
        }
        return $result;
    }

    /**
     * set the conf enabled value to true for the package
     * and for each of the plugins belonging to the package
     *
     * parsing the package will retrieve extensions to be handled before and after enable
     *
     * if the currently parsed package has the same name as the arg
     * the package will not be reparsed unless forced
     *
     * @param string $name
     * @param boolean $reparse
     * @return boolean
     */
    public function enablePackage($name, $reparse = '')
    {
        if ($this->configLocked) {
            $this->_logError('Configuration file is locked unable to enable ' . $name);
            return false;
        }
        if ($this->aParse['package']['name'] != $name) {
            $reparse = true;
        }
        if ($reparse && (!$this->_parsePackage($name))) {
            $this->_logError('Failed to parse the package definition for ' . $name);
            return false;
        }
        $aPackage = &$this->aParse['package'];
        if ($reparse && (!$this->_parseComponentGroups($aPackage['install']['contents']))) {
            $this->_logError('Failed to parse the plugin definitions contained in package ' . $name);
            return false;
        }
        $aPlugins = &$this->aParse['plugins'];
        $this->_runExtensionTasks('BeforePluginEnable');
        foreach ($aPackage['install']['contents'] as $k => &$plugin) {
            if (is_array($plugin)) {
                if (!$this->enableComponentGroup($plugin['name'], $aPlugins[$k]['extends'] ?? null)) {
                    $this->_logError('Failed to enable plugin ' . $plugin['name'] . ' for package ' . $name);
                    $this->disablePackage($name);
                    return false;
                }
            }
        }
        if (!$this->_setPackage($name, 1)) {
            $this->_logError('Failed to enable package ' . $name);
            $this->disablePackage($name);
            return false;
        }

        $this->_deleteCacheMenu();
        $this->_deleteCompiledTemplates();

        $this->_runExtensionTasks('AfterPluginEnable');
        return true;
    }

    /**
     * set the conf enabled value to false for the package
     * and for each of the plugins belonging to the package
     *
     * parsing the package will retrieve extensions to be handled before and after disable
     *
     * @param string $name
     * @param bool $force
     * @return boolean
     */
    public function disablePackage($name, $force = false)
    {
        if ($this->configLocked) {
            $this->_logError('Configuration file is locked unable to disable ' . $name);
            return false;
        }
        if (!$this->_parsePackage($name)) {
            if (isset($GLOBALS['extensions'])) {
                if (!$this->_setPackage($name, 0)) {
                    $this->_logError('Failed to disable package ' . $name);
                    return false;
                }
            }
            return false;
        }
        $aPackage = &$this->aParse['package'];
        if (!$this->_parseComponentGroups($aPackage['install']['contents'])) {
            $this->_logError('Failed to parse the plugin definitions contained in package ' . $name);
            return false;
        }
        $aPlugins = &$this->aParse['plugins'];
        if (!$force) {
            $this->_runExtensionTasks('BeforePluginDisable');
        }
        foreach ($aPackage['install']['contents'] as $k => &$plugin) {
            if (is_array($plugin)) {
                if (!$this->disableComponentGroup($plugin['name'], $aPlugins[$k]['extends'] ?? null, $force)) {
                    $this->_logError('Failed to disable plugin ' . $plugin['name'] . ' for package ' . $name);
                    return false;
                }
            }
        }
        if (!$this->_setPackage($name, 0)) {
            $this->_logError('Failed to disable package ' . $name);
            return false;
        }
        if (!$force) {
            $this->_runExtensionTasks('AfterPluginDisable');
        }

        $this->_deleteCacheMenu();
        $this->_deleteCompiledTemplates();
        return true;
    }

    public function _deleteCompiledTemplates()
    {
        $template = new OA_Admin_Template('');
        $template->clear_compiled_tpl();
    }

    public function _deleteCacheMenu()
    {
        $accountTypes = [
            OA_ACCOUNT_ADMIN,
            OA_ACCOUNT_MANAGER,
            OA_ACCOUNT_ADVERTISER,
            OA_ACCOUNT_TRAFFICKER,
        ];
        foreach ($accountTypes as $accountType) {
            OA_Admin_Menu::_clearCache($accountType);
        }
    }

    public function _matchPackageFilename($name, $file)
    {
        if (substr($file, 0, strlen($name)) != $name) {
            $this->_logError('Filename mismatch: name / file ' . $name . ' / ' . $file);
            return false;
        }
        return $this->_parsePackageFilename($file);
    }

    public function _parsePackageFilename($file)
    {
        $aFile = pathinfo($file);
        $aFile['filename'] = basename($aFile['basename'], '.' . $aFile['extension']);
        $aResult['version'] = '';
        $aResult['name'] = $aFile['filename'];
        $aResult['ext'] = $aFile['extension'];
        $pattern = '_(?P<version>[\d]+\.[\d\w\W]+)';
        if (preg_match('/' . $pattern . '/', $aFile['filename'], $aMatch)) {
            $aResult['version'] = $aMatch['version'];
            $aResult['name'] = substr($aFile['filename'], 0, strpos($aFile['filename'], $aResult['version']) - 1);
        }
        return $aResult;
    }

    /**
     * parse the xml to array for each of the plugins contained in this package
     *
     * @param array $aContents
     * @return array
     */
    public function _parseComponentGroups($aContents = null, $returnOnError = true)
    {
        $this->aParse['plugins'] = [];
        if ((!$aContents) || empty($aContents) || (!is_array($aContents))) {
            $this->_logError('Failed to find any contents in the package');
            $aResult['error'] = true;
            if ($returnOnError) {
                return false;
            }
        }
        foreach ($aContents as $idx => &$aElement) {
            $aResult[$idx]['error'] = false;
            $file = $this->getFilePathToXMLInstall($aElement['name']);
            if (!@file_exists($file)) {
                $this->_logError('File not found ' . $file);
                $aResult[$idx]['name'] = $aElement['name'];
                $aResult[$idx]['error'] = true;
                if ($returnOnError) {
                    return false;
                }
            }
            $this->aParse['plugins'][$idx] = $this->parseXML($file, 'OX_ParserComponentGroup');
            if (!$this->aParse['plugins'][$idx]) {
                // We should be able to assume that our parent already added a detailed error
                if (count($this->aErrors)) {
                    $lastError = array_pop($this->aErrors);

                    // Save the generic error
                    $this->_logError('Failed to parse plugin definition in ' . $file);

                    // Show the detailed error on the line after the generic error
                    $this->_logError($lastError);
                } else {
                    $this->_logError('Failed to parse plugin definition in ' . $file);
                }

                $this->aParse['plugins'][$idx]['error'] = true;
                if ($returnOnError) {
                    return false;
                }
            } else {
                $this->aExtensionsAffected[] = $this->aParse['plugins'][$idx]['extends'];
            }
        }
        return true;
    }

    public function _canUpgradeComponentGroups(&$aGroupsNew = null, &$aGroupsOld)
    {
        $this->errcode = '';
        if ((!$aGroupsNew) || empty($aGroupsNew) || (!is_array($aGroupsNew))) {
            $this->_logError('Failed to find any plugins to upgrade');
            return false;
        }
        foreach ($aGroupsNew as $idx => &$aGroup) {
            // reduce the list of old plugins to those that need to be deleted only
            foreach ($aGroupsOld as $k => &$aOld) {
                if ($aOld['name'] == $aGroup['name']) {
                    unset($aGroupsOld[$idx]);
                    break;
                }
            }
            if (!$this->_canUpgradeComponentGroup($aGroup)) {
                return false;
            }
            $aGroupsNew[$idx]['status'] = $aGroup['status'] ?? null;
        }
        return true;
    }

    /**
     * upgrade each of the plugins contained in this package
     *
     * @param array $aPlugins
     * @return boolean
     */
    public function _upgradeComponentGroups(&$aGroupsNew = null, &$aGroupsOld)
    {
        $this->errcode = '';
        foreach ($aGroupsNew as $idx => &$aGroup) {
            switch ($aGroup['status']) {
                case OA_STATUS_PLUGIN_CAN_UPGRADE:
                        $result = $this->upgradeComponentGroup($aGroup);
                        switch ($result) {
                            case UPGRADE_ACTION_UPGRADE_SUCCEEDED:
                                    $this->_logMessage('Upgrade succeeded ' . $aGroup['name']);
                                    $this->_cacheDependencies();
                                    break;
                            case UPGRADE_ACTION_UPGRADE_FAILED:
                                    $this->_logError('Failed to upgrade ' . $aGroup['name']);
                                    return false;
                        }
                        break;
                case OA_STATUS_PLUGIN_NOT_INSTALLED:
                        $aGroupList = [0 => $aGroup];
                        if (!$this->_installComponentGroups($aGroupList)) {
                            return false;
                        }
                        break;
            }
        }
        if (!empty($aGroupsOld)) {
            return $this->_uninstallComponentGroups($aGroupsOld);
        }
        return true;
    }

    /**
     * install each of the plugins contained in this package
     *
     * @param array $aPlugins
     * @return boolean
     */
    public function _installComponentGroups(&$aGroups = null)
    {
        if ((!$aGroups) || empty($aGroups) || (!is_array($aGroups))) {
            $this->_logError('Failed to find any component groups to install');
            return false;
        }
        foreach ($aGroups as $idx => &$aGroup) {
            $this->_auditSetKeys(
                ['upgrade_name' => 'install_' . ($aGroup['name'] ?? ''),
                                        'version_to' => $aGroup['version'] ?? 0,
                                        'version_from' => 0,
                                        'logfile' => 'plugins.log'
                                        ]
            );
            $auditId = $this->_auditStart(
                ['description' => 'PLUGIN INSTALL FAILED',
                                                             'action' => UPGRADE_ACTION_INSTALL_FAILED,
                                                            ]
            );
            $this->_auditSetID();
            if (!$this->installComponentGroup($aGroup)) {
                $this->_logError('Failed to install ' . ($aGroup['name'] ?? ''));
                return false;
            }
            $this->_cacheDependencies(); // need to keep recreating the array
            $this->_auditUpdate(
                ['description' => 'PLUGIN INSTALL COMPLETE',
                                      'action' => UPGRADE_ACTION_INSTALL_SUCCEEDED,
                                      'id' => $auditId,
                                     ]
            );
        }
        return true;
    }

    /**
     * uninstall each of the plugins contained in this package
     *
     * @param array $aPlugins
     * @return boolean
     */
    public function _uninstallComponentGroups(&$aGroups = null)
    {
        if (!$aGroups) {
            $this->_logError('Failed to find any contents in the package');
            return false;
        }
        //krsort($aGroups);
        foreach ($aGroups as $idx => &$aGroup) {
            $this->_auditSetKeys(
                ['upgrade_name' => 'uninstall_' . ($aGroup['name'] ?? null),
                                            'version_to' => 0,
                                            'version_from' => $aGroup['version'] ?? 0,
                                            'logfile' => 'plugins.log'
                                            ]
            );
            $auditId = $this->_auditStart(
                ['description' => 'PLUGIN UNINSTALL FAILED',
                                                 'action' => UPGRADE_ACTION_UNINSTALL_FAILED,
                                                ]
            );
            $this->_auditSetID();
            if (!$this->uninstallComponentGroup($aGroup)) {
                $this->_logError('Failed to uninstall ' . ($aGroup['name'] ?? null));
                return false;
            }
            $this->_cacheDependencies(); // need to keep recreating the array
            $this->_auditUpdate(
                ['description' => 'PLUGIN UNINSTALL COMPLETE',
                                      'action' => UPGRADE_ACTION_INSTALL_FAILED,
                                      'id' => $auditId,
                                     ]
            );
        }
        return true;
    }

    /**
     * set the enabled conf flag for the package
     *
     * @param string $name
     * @param boolean $enabled
     * @return boolean
     */
    public function _setPackage($name, $enabled = 0)
    {
        $oSettings = $this->_instantiateClass('OA_Admin_Settings');
        if (!$oSettings) {
            return false;
        }
        $oSettings->settingChange('plugins', $name, $enabled);
        return $oSettings->writeConfigChange();
    }

    /**
     * parse the package xml to an array
     *
     * @param string $name
     * @return array
     */
    public function _parsePackage($name)
    {
        $this->aParse['package'] = [];
        //OA::logMem('enter _parsePackage');
        if (!$name) {
            $this->_logError('Null package definition file name');
            return false;
        }
        $file = $name;
        if (!@file_exists($file)) {
            $file = $this->getPathToPackages() . $name . '.xml';
            if (!@file_exists($file)) {
                if (!empty($GLOBALS['installing']) && file_exists(str_replace('/plugins/', '/extensions/', $file))) {
                    $file = str_replace('/plugins/', '/extensions/', $file);
                } else {
                    $this->_logError('Failed to find package definition file ' . $file);
                    return false;
                }
            }
        }
        $this->aParse['package'] = $this->parseXML($file);
        if (empty($this->aParse['package'])) {
            $this->_logError('Error parsing package definition for ' . $name);
            return false;
        }
        if ((!isset($this->aParse['package']['install']['contents'])) ||
                empty($this->aParse['package']['install']['contents']) ||
                (!is_array($this->aParse['package']['install']['contents']))
           ) {
            $this->aParse['package'] = [];
            $this->_logError('Found no contents in package definition for ' . $name);
            return false;
        }
        //OA::logMem('exit _parsePackage');
        return true;
    }

    /**
     * use the parent method to parse the package xml
     *
     * @param boolean $input_file
     * @param boolean $classname
     * @return boolean
     */
    public function parseXML($input_file, $classname = 'OX_ParserPlugin')
    {
        return parent::parseXML($input_file, $classname);
    }

    /**
     * write the conf settings for the first time (disabled by default)
     *
     * @param string $name
     * @return boolean
     */
    public function _registerPackage($name)
    {
        if (!$this->disablePackage($name)) {
            $this->_logError('Failed to register package ' . $name);
            return false;
        }
        return true;
    }

    /**
     * remove the conf settings
     *
     * @param string $name
     * @return boolean
     */
    public function _unregisterPackage($name)
    {
        $oSettings = $this->_instantiateClass('OA_Admin_Settings');
        if (array_key_exists($name, $oSettings->aConf['plugins'])) {
            unset($oSettings->aConf['plugins'][$name]);
        }
        if (!$oSettings->writeConfigChange()) {
            $this->_logError('Failed to unregister package ' . $name);
            return false;
        }
        return true;
    }

    /**
     * get a list of all installed packages with status
     *
     * @return array
     */
    public function getPackagesList()
    {
        $aResult = array_reverse($GLOBALS['_MAX']['CONF']['plugins']);
        foreach ($aResult as $name => $enabled) {
            $aResult[$name] = $this->getPackageInfo($name);
            $aResult[$name]['enabled'] = $enabled;
        }
        return $aResult;
    }

    /**
     * get detailed info about the package
     * including optional info on each plugin contained
     *
     * @param string $name
     * @return array
     */
    public function getPackageInfo($name, $getComponentGroupInfo = true)
    {
        if (!$this->_parsePackage($name)) {
            return false;
        }
        $aPackage = &$this->aParse['package'];
        $aPkgInfo = ['extensions' => [], 'contents' => [], 'readme' => '', 'uninstallReadme' => ''];
        foreach ($aPackage['install']['files'] as $idx => &$aFile) {
            if (preg_match('/' . $name . '\.readme\.txt/', $aFile['name'])) {
                $aPkgInfo['readme'] = $this->basePath . $this->pathPackages . $aFile['name'];
            }
            if (preg_match('/' . $name . '\.uninstall\.txt/', $aFile['name'])) {
                $aPkgInfo['uninstallReadme'] = $this->basePath . $this->pathPackages . $aFile['name'];
            }
        }
        foreach ($aPackage as $k => &$v) {
            if (!is_array($v)) {
                $aPkgInfo[$k] = $v;
            } elseif ($k == 'install') {
                foreach ($v['contents'] as $i => $aPlugin) {
                    $aPlugins[] = $aPlugin['name'];
                }

                if ($getComponentGroupInfo) {
                    $aPkgInfo['contents'] = $this->getComponentGroupsList($aPlugins);
                    $aPkgInfo['extensions'] = $v['components'] ?? [];
                }
            }
            unset($aPkgInfo['extends']);
        }
        return $aPkgInfo;
    }

    /**
     * get diagnostic information about the package
     * including optional info on each plugin contained
     *
     * @param string $name
     * @return array
     */
    public function getPackageDiagnostics($name, $getComponentGroupInfo = true)
    {
        $this->clearErrors();
        $err = $this->_parsePackage($name);
        $aPackage = &$this->aParse['package'];
        $aPackage['error'] = false;
        $aPackage['errors'] = [];
        if (!$err) {
            $aPackage['error'] = true;
        } elseif (empty($aPackage['install']['contents'])) {
            $aPackage['error'] = true;
            $this->_logError('Package is missing any plugin declarations');
        }
        $this->_parseComponentGroups($aPackage['install']['contents'], false);
        $aPlugins = &$this->aParse['plugins'];
        if (isset($aPlugins['error']) && $aPlugins['error']) {
            $aPackage['error'] = true;
            $aPackage['errors'] = $this->aErrors;
        }
        if ($getComponentGroupInfo) {
            foreach ($aPlugins as $idx => &$aPlugin) {
                $this->clearErrors();

                if (empty($aPlugin['error'])) {
                    $aPlugins[$idx]['error'] = false;
                    $aPlugins[$idx]['errors'] = [];
                    $this->_canUpgradeComponentGroup($aPlugin);
                    switch ($aPlugin['status']) {
                        case OA_STATUS_PLUGIN_NOT_INSTALLED:
                            $this->_logError('Plugin not installed');
                            break;
                        case OA_STATUS_PLUGIN_VERSION_FAILED:
                            $this->_logError('Plugin version information unobtainable');
                            break;
                        case OA_STATUS_PLUGIN_DBINTEG_FAILED:
                            $this->_logError('Plugin schema integrity check failed');
                            break;
                        case OA_STATUS_PLUGIN_CURRENT_VERSION:
                        case OA_STATUS_PLUGIN_CAN_UPGRADE:
                            break;
                    }
                    $this->diagnoseComponentGroup($aPlugin);
                    if ($this->countErrors()) {
                        $aPlugins[$idx]['error'] = true;
                        $aPlugins[$idx]['errors'] = $this->aErrors;
                    }
                }
            }
        }
        return ['plugin' => $aPackage, 'groups' => $aPlugins];
    }

    /**
     * This method gets an array of hook->componentIdentifiers of any registered (stackable) hooks
     *
     * @return array e.g. array('preAdRender' => array('component1', 'component2'), 'postAdRender' => array('component3')),
     */
    public function getComponentHooks()
    {
        $aPackages = $GLOBALS['_MAX']['CONF']['plugins'];
        $aResult = [];
        foreach ($aPackages as $name => $enabled) {
            if ($enabled) {
                $aPkgInfo = $this->getPackageInfo($name);
                if ($aPkgInfo) {
                    foreach ($aPkgInfo['contents'] as $componentGroup) {
                        if (isset($componentGroup['components'])) {
                            foreach ($componentGroup['components'] as $componentName => $aComponent) {
                                if (isset($aComponent['hooks'])) {
                                    foreach ($aComponent['hooks'] as $hook) {
                                        $aResult[$hook][] = $componentGroup['extends'] . ':' . $componentGroup['name'] . ':' . $componentName;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $aResult;
    }

    /**
     * determine the file format
     * if zip, decompress
     * return the package name
     *
     * @param array $aFile
     * @return string | null
     */
    public function _unpack($aFile, $overwrite = false, $checkOnly = false)
    {
        //OA::logMem('enter _unpack');
        $aPath = pathinfo($aFile['name']);
        if (!isset($aPath['filename'])) {
            $aPath['filename'] = substr($aPath['basename'], 0, strrpos($aPath['basename'], '.'));
        }
        if (!isset($aPath['extension'])) {
            return false;
        }
        switch ($aPath['extension']) {
            case 'zip':
                if (!$this->_checkPackageContents($aPath['filename'] . '.xml', $aFile['tmp_name'], $overwrite)) {
                    $this->_logError('The uploaded file did not pass security check');
                    return false;
                }
                if ($checkOnly) {
                    return true;
                }

                // Get the old file list in case of an upgrade
                if ($overwrite && isset($GLOBALS['_MAX']['CONF']['plugins'][$this->aParse['package']['name']])) {
                    $oExport = new OX_PluginExport();
                    $oExport->_compileContents($this->aParse['package']['name']);
                    $aOldFileList = $oExport->aFileList;
                } else {
                    $aOldFileList = null;
                }

                $result = $this->_decompressFile($aFile['tmp_name'], $this->basePath, $overwrite);
                if (!$result) {
                    $this->_logError('Failed to decompress the uploaded file');
                    return false;
                }

                if (null === $aOldFileList) {
                    return true;
                }

                $aDecompressedFiles = array_map(function ($info) {
                    return $info['filename'];
                }, array_filter($result, function ($info) {
                    return empty($info['folder']);
                }));

                foreach (array_diff($aOldFileList, $aDecompressedFiles) as $deletedFiles) {
                    @unlink($deletedFiles);
                }

                return true;
            /*case 'xml':
                $pkgFile = $aPath['filename'];
                break;*/
            default:
                return false;
        }
        //OA::logMem('exit _unpack');
    }

    /**
     * use the pclZip lib to list the contents of the file
     *
     * the following files can be acquired and used to trace errors if necessary
     * require_once( MAX_PATH . '/lib/pclzip/pclerror.lib.php' );
     * require_once( MAX_PATH . '/lib/pclzip/pcltrace.lib.php' );
     * require_once( MAX_PATH . '/lib/pclzip/pcltar.lib.php' );
     *
     *
     * @param string $pkgFileUploaded
     * @param string $zipFile
     * @param boolean $overwrite
     * @return boolean
     */
    public function _checkPackageContents($pkgFileUploaded, $zipFile, $overwrite = false)
    {
        //OA::logMem('enter _checkPackageContents');
        if (!file_exists($zipFile)) {
            $this->_logError('File not found ' . $zipFile);
            return false;
        }
        $this->_logMessage('starting _checkPackageContents ' . $pkgFileUploaded);
        $aExpectedPackage = $this->_parsePackageFilename($pkgFileUploaded);
        $pkgFile = $aExpectedPackage['name'] . '.xml';
        $this->_logMessage('expecting definition ' . $pkgFile);
        require_once(MAX_PATH . '/lib/pclzip/pclzip.lib.php');
        $oZip = new PclZip($zipFile);
        $aContents = $oZip->listContent();
        if (!$aContents) {
            $this->_logError('Failed to read contents of zip file ' . $zipFile);
            return false;
        }
        $aConf = $GLOBALS['_MAX']['CONF'];

        $pattPluginDefFile = '/' . preg_quote($aConf['pluginPaths']['packages'], '/') . '[\w\d]+\.xml/';
        $pattGroupDefFile = '/' . preg_quote($aConf['pluginPaths']['packages'], '/') . '[\w\d]+\/[\w\d]+\.xml/';
        // find all of the xml definition files and compile a smiple array of files that are stored in the zipfile (exclude folders)
        $aPkgFile = [];
        foreach ($aContents as $i => &$aItem) {
            $aPath = pathinfo($aItem['filename']);
            $file = '/' . $aItem['filename'];
            if ($aItem['folder']) {  // ignore folders
                continue;
            }
            if (!$aPkgFile && preg_match($pattPluginDefFile, $file, $aMatches)) { // its a plugin definition file
                $this->_logMessage('detected plugin definition file ' . $file);
                $aPkgFile['pathinfo'] = $aPath;
                $aPkgFile['storedinfo'] = $aItem;
                $aFilesStored[] = $file;
                continue;
            }
            if (preg_match($pattGroupDefFile, $file, $aMatches)) { // its a group definition file
                $this->_logMessage('detected group definition file ' . $file);
                $aXMLFiles[$aPath['basename']]['pathinfo'] = $aPath;
                $aXMLFiles[$aPath['basename']]['storedinfo'] = $aItem;
                $aFilesStored[] = $file;
                continue;
            }
            if (strpos($aPath['dirname'], '/etc/changes') == 0) { // don't check the changeset files (costly parsing of upgrade definitions etc.)
                $aFilesStored[] = $file;
                continue;
            }
        }
        // must have a plugin package definition file
        if (!$aPkgFile) {
            $this->_logError('Plugin definition ' . $aExpectedPackage['name'] . '.xml not found in uploaded file: ' . $pkgFileUploaded);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_DEFINITION_NOT_FOUND;
            return false;
        }
        // extract the plugin package definition file to var/tmp folder
        $aResult = $oZip->extractByIndex($aPkgFile['storedinfo']['index'], PCLZIP_OPT_ADD_PATH, $this->basePath . '/var/tmp', PCLZIP_OPT_SET_CHMOD, OX_PLUGIN_DIR_WRITE_MODE, PCLZIP_OPT_REPLACE_NEWER);
        if ((!is_array($aResult)) || ($aResult[0]['status'] != 'ok')) {
            $this->_logError('Error extracting plugin definition file: ' . $aResult[0]['status'] . ' : ' . $aResult[0]['stored_filename']);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_EXTRACT_FAILED;
            return false;
        }
        // parse the plugin package definition file
        $pathPackages = '/var/tmp' . $this->pathPackages;
        if (!$this->_parsePackage($this->basePath . $pathPackages . $pkgFile)) {
            $this->_logError('Failed to parse the plugin definition ' . $pkgFile);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_PARSE_FAILED;
            @unlink($this->basePath . $pathPackages . $pkgFile);
            return false;
        }
        $aPackage = &$this->aParse['package'];
        @unlink($this->basePath . $pathPackages . $pkgFile);
        // check that plugin is not already installed
        if (!($overwrite) && array_key_exists($aPackage['name'], $GLOBALS['_MAX']['CONF']['plugins'])) {
            $this->_logError('Plugin with this name is already installed ' . $aPackage['name']);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_NAME_EXISTS;
            return false;
        }
        // ensure the plugin package definition file has a valid version number
        if (empty($aPackage['version'])) {
            $this->_logError('Failed to retrieve version from the plugin definition ' . $pkgFile);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_VERSION_NOT_FOUND;
            return false;
        }
        if ($aExpectedPackage['version'] && ($aExpectedPackage['version'] != $aPackage['version'])) {
            $this->_logError('Version found ' . $aPackage['version'] . ' is not that expected ' . $aExpectedPackage['version']);
            $this->errcode = OX_PLUGIN_ERROR_PACKAGE_VERSION_NOT_FOUND;
            return false;
        }
        // ensure that the number of declaration files that were found in the zip file
        // matches the number of declared component groups
        if (count($aPackage['install']['contents']) != count($aXMLFiles)) {
            $this->_logError('Expected ' . count($aPackage['install']['contents']) . ' definitions but found ' . count($aXMLFiles));
            $this->errcode = OX_PLUGIN_ERROR_PLUGIN_DEFINITION_MISSING;
            return false;
        }
        // extract each of the component group definitions to var/tmp
        foreach ($aPackage['install']['contents'] as &$aItem) {
            if (!array_key_exists($aItem['name'] . '.xml', $aXMLFiles)) {
                $this->_logError('Group definition missing from plugin ' . $pkgFile . ' -> ' . $aItem['name'] . '.xml');
                $this->errcode = OX_PLUGIN_ERROR_PACKAGE_CONTENTS_MISMATCH;
                return false;
            }
            $aResult = $oZip->extractByIndex($aXMLFiles[$aItem['name'] . '.xml']['storedinfo']['index'], PCLZIP_OPT_ADD_PATH, $this->basePath . '/var/tmp', PCLZIP_OPT_SET_CHMOD, OX_PLUGIN_DIR_WRITE_MODE, PCLZIP_OPT_REPLACE_NEWER);
            if ((!is_array($aResult)) || ($aResult[0]['status'] != 'ok')) {
                $this->_logError('Error extracting group definition file: ' . $aResult[0]['status'] . ' : ' . $aResult[0]['stored_filename']);
                $this->errcode = OX_PLUGIN_ERROR_PLUGIN_EXTRACT_FAILED;
                return false;
            }
        }
        // parse each of the component group definitions
        $pathPackagesOld = $this->pathPackages;
        $this->pathPackages = '/var/tmp' . $this->pathPackages;
        if (!$this->_parseComponentGroups($aPackage['install']['contents'])) {
            foreach ($aXMLFiles as $i => &$aFile) {
                @unlink($this->basePath . '/var/tmp/' . $aFile['storedinfo']['filename']);
                @rmdir(dirname($this->basePath . '/var/tmp/' . $aFile['storedinfo']['filename']));
            }
            $this->pathPackages = $pathPackagesOld;
            $this->_logError('Failed to parse the component groups in package ' . $pkgFile);
            $this->errcode = OX_PLUGIN_ERROR_PLUGIN_PARSE_FAILED;
            return false;
        }
        foreach ($aXMLFiles as $i => &$aFile) {
            @unlink($this->basePath . '/var/tmp/' . $aFile['storedinfo']['filename']);
            @rmdir(dirname($this->basePath . '/var/tmp/' . $aFile['storedinfo']['filename']));
        }
        $this->pathPackages = $pathPackagesOld;
        $aPlugins = &$this->aParse['plugins'];

        // the parser compiles and returns an array of files from the plugin declaration
        foreach ($aPackage['allfiles'] as $i => &$aFileExpected) {
            // expand the file declaration's path macro to get the path
            $fileExpected = $this->_expandFilePath($aFileExpected['path'], $aFileExpected['name'], $aPackage['name']);
            // files must have a valid path macro (see _expandFilePath()) else they are illegal, ie could be unzipped outside legal paths
            if ($fileExpected == $aFileExpected['path'] . $aFileExpected['name']) {
                $this->_logError('Illegal file location found :' . $fileExpected);
                $this->errcode = OX_PLUGIN_ERROR_ILLEGAL_FILE;
                return false;
            }
            $aFilesExpected[] = $fileExpected;
        }
        foreach ($aPlugins as $idx => &$aPlugin) {
            // check that group is not already installed
            if ((!$overwrite) && array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['pluginGroupComponents'])) {
                $this->_logError('Component group with this name is already installed ' . $aPlugin['name']);
                $this->errcode = OX_PLUGIN_ERROR_PLUGIN_NAME_EXISTS;
                return false;
            }
            // the parser compiles and returns an array of files from the group declaration
            foreach ($aPlugin['allfiles'] as $i => &$aFileExpected) {
                // expand the file declaration's path macro to get the path
                $fileExpected = $this->_expandFilePath($aFileExpected['path'], $aFileExpected['name'], $aPlugin['name']);
                // files must have a valid path macro (see _expandFilePath()) else they are illegal, ie could be unzipped outside legal paths
                if ($fileExpected == $aFileExpected['path'] . $aFileExpected['name']) {
                    $this->_logError('Illegal file location found :' . $fileExpected);
                    $this->errcode = OX_PLUGIN_ERROR_ILLEGAL_FILE;
                    return false;
                }
                $aFilesExpected[] = $fileExpected;
            }
        }
        // are any declared files missing from the zip?
        $aDiffsExpected = array_diff($aFilesExpected, $aFilesStored);
        if (count($aDiffsExpected)) {
            $this->_logError(count($aDiffsExpected) . ' expected files not found');
            foreach ($aDiffsExpected as &$file) {
                $this->_logError($file);
            }
            $this->errcode = OX_PLUGIN_ERROR_PLUGIN_DECLARATION_MISMATCH;
            return false;
        }
        // are there any files in the zip that are not declared in the definitions?
        // but please ignore lang files
        $aDiffStored = array_filter(array_diff($aFilesStored, $aFilesExpected), function ($file) {
            if (preg_match('#^/plugins/etc/[^/]+/_lang/(?:po/)?[a-z][a-z](?:_[A-Z][A-Z])?\.(?:mo|pot?)$#D', $file)) {
                return false;
            }

            return true;
        });
        if (count($aDiffStored) > 0) {
            $this->_logError(count($aDiffStored) . ' unexpected files found');
            foreach ($aDiffStored as &$file) {
                $this->_logError($file);
            }
            $this->errcode = OX_PLUGIN_ERROR_FILE_COUNT_MISMATCH;
            return false;
        }
        // package is good, return the parsed definitions
        $this->errcode = OX_PLUGIN_ERROR_PACKAGE_OK;
        //OA::logMem('exit _checkPackageContents');
        //return array('package'=>$aPackage, 'plugins'=>$aPlugins);
        return true;
    }

    /**
     * use the pclZip lib to decompress the file
     *
     * the following files can be acquired and used to trace errors if necessary
     * require_once( MAX_PATH . '/lib/pclzip/pclerror.lib.php' );
     * require_once( MAX_PATH . '/lib/pclzip/pcltrace.lib.php' );
     * require_once( MAX_PATH . '/lib/pclzip/pcltar.lib.php' );
     *
     *
     * @param string $file
     * @param string $relPath
     * @return array | boolean false on error
     */
    public function _decompressFile($source, $target, $overwrite = false)
    {
        require_once(MAX_PATH . '/lib/pclzip/pclzip.lib.php');

        if (!defined('OS_WINDOWS')) {
            define('OS_WINDOWS', ((substr(PHP_OS, 0, 3) == 'WIN') ? 1 : 0));
        }

        $oZip = new PclZip($source);

        if (!$overwrite) {
            $result = $oZip->extract(PCLZIP_OPT_PATH, $target, PCLZIP_OPT_SET_CHMOD, OX_PLUGIN_DIR_WRITE_MODE);
        } else {
            $result = $oZip->extract(PCLZIP_OPT_REPLACE_NEWER, PCLZIP_OPT_PATH, $target, PCLZIP_OPT_SET_CHMOD, OX_PLUGIN_DIR_WRITE_MODE);
        }
        if (!$result) {
            $this->_logError('Unrecoverable decompression error: ' . $oZip->errorName(true));
            return false;
        }

        $error = false;

        foreach ($result as $i => &$aInfo) {
            if ($aInfo['status'] != 'ok') {
                switch ($aInfo['status']) {
                    case 'path_creation_fail':
                    case 'write_error':
                    case 'read_error':
                    case 'invalid_header':
                        $this->_logError('Error: ' . $aInfo['status'] . ' : ' . $aInfo['filename']);
                        $error = true;
                        break;
                    case 'newer_exist':
                        $this->_logError('Error: ' . $aInfo['status'] . ' : ' . $aInfo['filename']);
                        if ((!$aInfo['folder']) && ($time = @filectime($aInfo['filename']))) {
                            $this->_logError('Existing file\'s timestamp is ' . date('d/m/Y h:i:s', $time) . ' ... Replacement file\'s timestamp is ' . date('d/m/Y h:i:s', $aInfo['mtime']));
                        } else {
                            $this->_logError('Unable to determine newer file\'s timestamp ... Replacement file\'s timestamp is ' . date('d/m/Y h:i:s', $aInfo['mtime']));
                        }
                        $error = true;
                        break;
                    case 'already_a_directory':
                    case 'filtered':
                    default:
                        break;
                }
            }
        }
        return ($error ? false : $result);
    }

    public function _switchToPluginLog()
    {
        if ($this->pluginLogSwitchCounter == 0) {
            OA::switchLogIdent('plugins');
        }
        $this->pluginLogSwitchCounter++;
    }

    public function _switchToDefaultLog()
    {
        $this->pluginLogSwitchCounter--;
        if ($this->pluginLogSwitchCounter == 0) {
            OA::switchLogIdent();
        }
    }
}
