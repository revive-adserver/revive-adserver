<?php

namespace RV\Upgrade;

use OX_PluginManager;
use OX_Upgrade_Util_Job;

require_once LIB_PATH . '/Plugin/PluginManager.php';
require_once MAX_PATH . '/lib/OX/Upgrade/Util/Job.php';

class PluginInstaller
{
    public const ACTION_INSTALL = '0';
    public const ACTION_CHECK = '1';
    public const ACTION_REMOVE = '2';

    private $aDefaultPlugins;

    public function __construct(array $aDefaultPlugins = null)
    {
        if (null === $aDefaultPlugins) {
            $aDefaultPlugins = [];
            include MAX_PATH . '/etc/default_plugins.php';
        }

        $this->aDefaultPlugins = [];
        foreach ($aDefaultPlugins as $aPlugin) {
            $this->aDefaultPlugins[$aPlugin['name']] = $aPlugin;
        }
    }

    public function __invoke(string $plugin, string $status): array
    {
        if ($status === self::ACTION_INSTALL) {
            return $this->installPlugin($plugin);
        }

        if ($status === self::ACTION_CHECK) {
            return $this->checkPlugin($plugin);
        }

        if ($status === self::ACTION_REMOVE) {
            return $this->removePlugin($plugin);
        }

        throw new \InvalidArgumentException("Unexpected status: {$status}");
    }

    /**
     * A method to install any plugins found that are NEW for the upgrade.
     *
     * @param string $pluginName The name of the plugin to install.
     * @return array An array of the 'name', 'status' and any 'errors' as an array.
     */
    public function installPlugin($pluginName): array
    {
        $aErrors = [];
        $aResult = [
            'name' => $pluginName,
            'status' => '',
            'errors' => &$aErrors
        ];

        $aPlugin = $this->getPlugin($pluginName);

        if (null !== $aPlugin) {
            $oPluginManager = new OX_PluginManager();

            if (!array_key_exists($aPlugin['name'], $GLOBALS['_MAX']['CONF']['plugins'])) {
                $filename = $aPlugin['name'] . '.' . $aPlugin['ext'];
                $filepath = $aPlugin['path'] . $filename;

                // TODO: refactor for remote paths?
                $oPluginManager->installPackage(['tmp_name' => $filepath, 'name' => $filename]);

                if ($oPluginManager->countErrors()) {
                    $aResult['status'] = '<br />Failed';
                    foreach ($oPluginManager->aErrors as $errmsg) {
                        OX_Upgrade_Util_Job::logError($aResult, $errmsg);
                    }
                } else {
                    $aResult['status'] = '<br />OK';
                }
            } else {
                $aResult['status'] = '<br />Already Installed';
                OX_Upgrade_Util_Job::logError($aResult, 'Could not be installed because previous installation (whole or partial) was found');
            }

            unset($oPluginManager);
        } else {
            $aResult['status'] = '<br />Invalid';
            OX_Upgrade_Util_Job::logError($aResult, 'Not a valid default plugin');
        }

        return $aResult;
    }

    /**
     * A method to install any plugins found that were found in the previous
     * installation before upgrade, either by installing from the original plugin
     * package, or by migrating the code over from the previous installation.
     *
     * @param string $pluginName The name of the plugin to install.
     * @return array An array of the 'name', 'status' and any 'errors' as an array.
     */
    public function checkPlugin($pluginName)
    {
        $aErrors = [];
        $aResult = [
            'name' => $pluginName,
            'status' => '',
            'errors' => &$aErrors
        ];

        $oPluginManager = new OX_PluginManager();

        // if plugin definition is not found in situ
        // try to import plugin code from the previous installation
        if (!file_exists(MAX_PATH . $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] . $pluginName . '.xml')) {
            if (isset($GLOBALS['_MAX']['CONF']['pluginPaths']['export'])) {
                $file = $GLOBALS['_MAX']['CONF']['pluginPaths']['export'] . $pluginName . '.zip';
                if (file_exists($file)) {
                    $aFile['name'] = $file;
                    $aFile['tmp_name'] = $file;
                    OX_Upgrade_Util_Job::logError($aResult, 'Exported plugin file found, attempting to import from ' . $file);
                    if (!$oPluginManager->installPackageCodeOnly($aFile)) {
                        if ($oPluginManager->countErrors()) {
                            $aResult['status'] = '<br />Failed';
                            foreach ($oPluginManager->aErrors as $errmsg) {
                                OX_Upgrade_Util_Job::logError($aResult, $errmsg);
                            }
                        }
                    } else {
                        $aResult['status'] = '<br />OK';
                    }
                }
            }
        }

        $upgraded = false;
        $aPlugin = $this->getPlugin($pluginName, true);

        if (null !== $aPlugin) {
            $oPluginManager = new OX_PluginManager();
            $aFileName['name'] = $aPlugin['name'] . '.' . $aPlugin['ext'];
            $aFileName['tmp_name'] = $aPlugin['path'] . $aPlugin['name'] . '.' . $aPlugin['ext'];
            $aFileName['type'] = 'application/zip';
            $upgraded = $oPluginManager->upgradePackage($aFileName, $pluginName);
            if (!empty($oPluginManager->aErrors) && !empty($oPluginManager->previousVersionInstalled) &&
                $oPluginManager->previousVersionInstalled != OX_PLUGIN_SAME_VERSION_INSTALLED) {
                foreach ($oPluginManager->aErrors as $i => $msg) {
                    OX_Upgrade_Util_Job::logError($aResult, $msg);
                }
            }
        }

        // now diagnose problems
        $aDiag = $oPluginManager->getPackageDiagnostics($pluginName);
        if ($aDiag['plugin']['error']) {
            $aErrors[] = 'Problems found with plugin ' . $pluginName . '.  The plugin has been disabled.  Go to the Configuration Plugins page for details ';
            foreach ($aDiag['plugin']['errors'] as $i => $msg) {
                OX_Upgrade_Util_Job::logError($aResult, $msg);
            }
        }

        foreach ($aDiag['groups'] as $idx => &$aGroup) {
            if ($aGroup['error']) {
                $aDiag['plugin']['error'] = true;
                OX_Upgrade_Util_Job::logError($aResult, 'Problems found with components in group ' . $aGroup['name'] . '.  The ' . $pluginName . ' plugin has been disabled.  Go to the Configuration->Plugins page for details ');
                foreach ($aGroup['errors'] as $i => $msg) {
                    OX_Upgrade_Util_Job::logError($aResult, $msg);
                }
            }
        }

        $enabled = $this->wasPluginEnabled($pluginName); // original setting
        if (!$aDiag['plugin']['error']) {
            if ($upgraded) {
                $aResult['status'] .= '<br />OK; Upgraded';
            } elseif ($oPluginManager->previousVersionInstalled == OX_PLUGIN_NEWER_VERSION_INSTALLED) {
                $aResult['status'] .= '<br />OK; Notice: You have a newer plugin version installed than the one that comes with this upgrade package';
            } elseif ($oPluginManager->previousVersionInstalled == OX_PLUGIN_SAME_VERSION_INSTALLED) {
                $aResult['status'] .= '<br />OK; Up to date';
            } else {
                $aResult['status'] .= '<br />OK';
            }

            if ($enabled) {
                if ($oPluginManager->enablePackage($pluginName)) {
                    $aResult['status'] .= '; Enabled';
                } else {
                    $aResult['status'] .= '; Failed to enable, check plugin configuration';
                }
            } else {
                $aResult['status'] .= '; Disabled';
            }
        } else {
            $aResult['status'] = '<br />Errors; Disabled';
        }

        return $aResult;
    }

    /**
     * A method to remove the configuration setup for any plugins that were found
     * in the previous installation before upgrade, but which have been marked as
     * deprecated plugins.
     *
     * @param string $pluginName The name of the plugin to remove.
     * @return array An array of the 'name', 'status' and any 'errors' as an array.
     */
    public function removePlugin($pluginName)
    {
        $aErrors = [];
        $aResult = [
            'name' => $pluginName,
            'status' => '',
            'errors' => &$aErrors
        ];

        if (array_key_exists($pluginName, $GLOBALS['_MAX']['CONF']['plugins'])) {
            $oPluginManager = new OX_PluginManager();
            $result = $oPluginManager->uninstallPackage($pluginName, true);

            if ($result) {
                $aResult['status'] = '<br />Uninstalled';
            } else {
                $aResult['status'] = '<br />Error';
                $aErrors[] = 'Problems found with plugin ' . $pluginName .
                    '. The plugin was found in the previous installation' .
                    ' and has been marked as deprecated, but was unable to' .
                    ' be removed. Please go to the Configuration Plugins page' .
                    ' and remove it.';
            }
        } else {
            $aResult['status'] = '<br />OK; Not installed';
            $aErrors[] = 'Problems found with plugin ' . $pluginName .
                '. The plugin was found in the previous installation' .
                ' and has been marked as deprecated, but was then not' .
                ' found as being installed when attempting to remove it.' .
                ' Please go to the Configuration Plugins page to ensure' .
                ' it is not installed.';
        }

        return $aResult;
    }

    private function getPlugin(string $pluginName, bool $defaultOnly = false): ?array
    {
        if (isset($this->aDefaultPlugins[$pluginName])) {
            return $this->aDefaultPlugins[$pluginName];
        }

        if ($defaultOnly) {
            return null;
        }

        return [
            'path' => MAX_PATH . '/etc/plugins/',
            'name' => $pluginName,
            'ext' => 'zip', 'disabled' => true
        ];
    }

    /**
     * The upgrader will have disabled all plugins when it started upgrading
     * it should have dropped a file with a record of the orginal settings,
     * read this file and then reconstruct settings array.
     *
     * @param string $pluginName
     * @return boolean
     */
    private function wasPluginEnabled($pluginName)
    {
        $file = MAX_PATH . '/var/plugins/recover/enabled.log';

        if (file_exists($file)) {
            $aContent = explode(';', file_get_contents($file));
            $aResult = [];

            foreach ($aContent as $k => $v) {
                if (trim($v)) {
                    $aLine = explode('=', trim($v));
                    if (is_array($aLine) && (count($aLine) == 2) && (is_numeric($aLine[1]))) {
                        $aResult[$aLine[0]] = $aLine[1];
                    }
                }
            }

            if (array_key_exists($pluginName, $aResult)) {
                return $aResult[$pluginName];
            }
        }

        return false;
    }
}
