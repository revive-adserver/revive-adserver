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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/FileScanner.php';
require_once 'Cache/Lite.php';
require_once 'Config.php';

/**
 * The default directory to store plugin configution and cache files.
 */
define('MAX_PLUGINS_VAR', MAX_PATH . '/var/plugins');

/**
 * The default write mode for directories inside MAX_PLUGINS_VAR.
 */
define('MAX_PLUGINS_VAR_WRITE_MODE', 0755);

/**
 * The default file mask for plugins.
 */
define('MAX_PLUGINS_EXTENSION', '.plugin.php');
define('MAX_PLUGINS_EXTENSION_ESC', '\.plugin\.php');
define('MAX_PLUGINS_FILE_MASK', '^.*/([a-zA-Z0-9\-_]*)/([a-zA-Z0-9\-_]*)'.MAX_PLUGINS_EXTENSION_ESC.'$');

/**
 * MAX_Plugin is a static helper class for dealing with plugins. It
 * provides a factory method for including/instantiating plugins, and
 * provides methods for:
 *  - Reading groups of plugins from a module or from a modules/package;
 *  - Calling plugin methods;
 *  - Reading and writing plugin configuration files, if they exist; and
 *  - Reading and writing plugin cache files, if they exist.
 *
 * @static
 * @package    OpenXPlugin
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class MAX_Plugin
{

    /**
     * A factory method, for including and instantiating a plugin, given a
     * module/package (and optional plugin name).
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package The plugin package name (i.e. /plugins/module/package
     *                        directory).
     * @param string $name Optional name of the PHP file which contains the plugin,
     *                     otherwise the plugin with the same name as the package
     *                     is assumed.
     * @return mixed The instantiated plugin object, or false on error.
     */
    function &factory($module, $package, $name = null)
    {
        if (!MAX_Plugin::_includePluginFile($module, $package, $name)) {
            return false;
        }
        if ($name === null) {
            $name = $package;
        }
        $className = MAX_Plugin::_getPluginClassName($module, $package, $name);
        $obj = new $className($module, $package, $name);
        $obj->module  = $module;
        $obj->package = $package;
        $obj->name    = $name;
        return $obj;
    }

    /**
     * A private method to include a plugin file, given a module/package
     * (and optional plugin name).
     *
     * @static
     * @access private
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package The plugin package name (i.e. /plugins/module/package
     *                        directory).
     * @param string $name Optional name of the PHP file which contains the plugin,
     *                     otherwise the plugin with the same name as the package
     *                     is assumed.
     * @return boolean True on success, false otherwise.
     */
    function _includePluginFile($module, $package, $name = null)
    {
        if ($name === null) {
            $name = $package;
        }
        $fileName = MAX_PATH . "/plugins/$module/$package/$name".MAX_PLUGINS_EXTENSION;
        if (!file_exists($fileName)) {
            MAX::raiseError("Unable to include the file $fileName.");
            return false;
        } else {
            include_once $fileName;
        }
        $className = MAX_Plugin::_getPluginClassName($module, $package, $name);
        if (!class_exists($className)) {
            MAX::raiseError("Plugin file included but class '$className' does not exist.");
            return false;
        } else {
            return true;
        }
    }

    /**
     * A private method for generating the (expected) class name of a plugin.
     *
     * @static
     * @access private
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package The plugin package name (i.e. /plugins/module/package
     *                        directory).
     * @param string $name Optional name of the PHP file which contains the plugin,
     *                     otherwise the plugin with the same name as the package
     *                     is assumed.
     * @return string The plugin class name.
     */
    function _getPluginClassName($module, $package, $name = null)
    {
        if ($name === null) {
            $name = $package;
        }
        $className = 'Plugins_' . ucfirst($module) . '_' . ucfirst($package) . '_' . ucfirst($name);
        return $className;
    }

    /**
     * A method to return an array of plugin objects from a selected plugin module
     * or module/package.
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package An optional plugin package name (i.e. /plugins/module/package
     *                        directory). If not given, the search for plugin files will start
     *                        at the module directory level.
     * @param boolean $onlyPluginNameAsIndex If true, the array index for the plugins is
     *                                       "pluginName", otherwise the index is of the
     *                                       format is "packageName:pluginName".
     * @param mixed $recursive If the boolean 'true', returns all plugins in the
     *                         given module (and package, if specified), and all
     *                         subdirectories thereof.
     *                         If an integer, returns all plugins in the given
     *                         module (and package, if specified) and subdirectories
     *                         thereof, down to the depth specified by the parameter.
     * @return array An array of plugin objects, indexed as specified by the
     *               $onlyPluginNameAsIndex parameter.
     */
    function &getPlugins($module, $package = null, $onlyPluginNameAsIndex = true, $recursive = 1)
    {
        $plugins = array();
        $pluginFiles = MAX_Plugin::_getPluginsFiles($module, $package, $recursive);
        foreach ($pluginFiles as $key => $pluginFile) {
            $pluginInfo = explode(':', $key);
            if (count($pluginInfo) > 1) {
                if ($onlyPluginNameAsIndex) {
                    $plugins[$pluginInfo[1]] = MAX_Plugin::factory($module, $pluginInfo[0], $pluginInfo[1]);
                } else {
                    $plugins[$key] = MAX_Plugin::factory($module, $pluginInfo[0], $pluginInfo[1]);
                }
            }
        }
        return $plugins;
    }

    /**
     * A private method to return a list of plugin files in a given plugin module,
     * or a given module/package.
     *
     * @static
     * @access private
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package An optional plugin package name (i.e. /plugins/module/package
     *                        directory). If not given, the search for plugin files will
     *                        start at the module directory level.
     * @param mixed $recursive If the boolean 'true', returns all plugin files in the
     *                         given directory and all subdirectories.
     *                         If an integer, returns all plugin files in the given
     *                         directory and subdirectories down to the depth
     *                         specified by the parameter.
     * @return array An array of the plugin files found, indexed by "directory:filename",
     *               where "directory" is the relative directory path below the
     *               given directory parameter, and "filename" is the filename
     *               before the MAX_PLUGINS_EXTENSION extension of the file.
     */
    function _getPluginsFiles($module, $package = null, $recursive = 1)
    {
        $pluginsDir = MAX_PATH . '/plugins';
        if (!empty($package)) {
            $dir = $pluginsDir . '/' . $module . '/' . $package;
        } else {
            $dir = $pluginsDir . '/' . $module;
        }
        return MAX_Plugin::_getPluginsFilesFromDirectory($dir, $recursive);
    }

    /**
     * A private method to return a list list of files from a directory
     * (and subdirectories, if appropriate)  which match the defined
     * plugin file mask (MAX_PLUGINS_FILE_MASK).
     *
     * @static
     * @access private
     * @param string $directory The directory to search for files in.
     * @param mixed $recursive If the boolean 'true', returns all files in the given
     *                         directory and all subdirectories that match the file
     *                         mask.
     *                         If an integer, returns all files in the given
     *                         directory and subdirectories down to the depth
     *                         specified by the parameter that match the file mask.
     * @return array An array of the files found, indexed by "directory:filename",
     *               where "directory" is the relative directory path below the
     *               given directory parameter, and "filename" is the filename
     *               before the MAX_PLUGINS_EXTENSION extension of the file.
     */
    function _getPluginsFilesFromDirectory($directory, $recursive = 1)
    {
        if (is_readable($directory)) {
            $oFileScanner = new MAX_FileScanner();
            $oFileScanner->addFileTypes(array('php','inc'));
            $oFileScanner->setFileMask(MAX_PLUGINS_FILE_MASK);
            $oFileScanner->addDir($directory, $recursive);
            return $oFileScanner->getAllFiles();
        } else {
            return array();
        }
    }

    /**
     * A method to include a plugin, and call a method statically on the plugin class.
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package The plugin package name (i.e. /plugins/module/package
     *                        directory).
     * @param string $name Optional name of the PHP file which contains the plugin,
     *                     otherwise the plugin with the same name as the package
     *                     is assumed.
     * @param string $staticMethod The name of the method of the plugin to call statically.
     * @param array $aParams An optional array of parameters to pass to the method called.
     * @return mixed The result of the static method call, or false on failure to include
     *               the plugin.
     */
    function &callStaticMethod($module, $package, $name = null, $staticMethod, $aParams = null)
    {
        if ($name === null) {
            $name = $package;
        }
        if (!MAX_Plugin::_includePluginFile($module, $package, $name)) {
            return false;
        }
        $className = MAX_Plugin::_getPluginClassName($module, $package, $name);

        // PHP4/5 compatibility for get_class_methods.
        $aClassMethods = array_map(strtolower, (get_class_methods($className)));
        if (!$aClassMethods) {
            $aClassMethods = array();
        }
        if (!in_array(strtolower($staticMethod), $aClassMethods)) {
            MAX::raiseError("Method '$staticMethod()' not defined in class '$className'.", MAX_ERROR_INVALIDARGS);
            return false;
        }
        if (is_null($aParams)) {
            return call_user_func(array($className, $staticMethod));
        } else {
            return call_user_func_array(array($className, $staticMethod), $aParams);
        }
    }

    /**
     * A method to run a method on all plugin objects in an array of plugins.
     *
     * @static
     * @param array $aPlugins An array of plugin objects.
     * @param string $methodName The name of the method to executed for every plugin.
     * @param array $aParams An optional array of parameters to pass to the method called.
     * @return mixed An array of the results of the method calls, or false on error.
     */
    function &callOnPlugins(&$aPlugins, $methodName, $aParams = null)
    {
        if (!is_array($aPlugins)) {
            MAX::raiseError('Bad argument: Not an array of plugins.', MAX_ERROR_INVALIDARGS);
            return false;
        }
        foreach ($aPlugins as $key => $oPlugin) {
            if (!is_a($oPlugin, 'MAX_Plugin_Common')) {
                MAX::raiseError('Bad argument: Not an array of plugins.', MAX_ERROR_INVALIDARGS);
                return false;
            }
        }
        $aReturn = array();
        foreach ($aPlugins as $key => $oPlugin) {
            // Check that the method name can be called
            if (!is_callable(array($oPlugin, $methodName))) {
                $message = "Method '$methodName()' not defined in class '" .
                            MAX_Plugin::_getPluginClassName($oPlugin->module, $oPlugin->package, $oPlugin->name) . "'.";
                MAX::raiseError($message, MAX_ERROR_INVALIDARGS);
                return false;
            }
            if (is_null($aParams)) {
                $aReturn[$key] = call_user_func(array($aPlugins[$key], $methodName));
            } else {
                $aReturn[$key] = call_user_func_array(array($aPlugins[$key], $methodName), $aParams);
            }
        }
        return $aReturn;
    }

    /**
     * A method to run one method on all the plugins in a group where the plugin
     * has the specified type and plugin hook point. For use with Maintenance
     * plugins only.
     *
     * @static
     * @param array $aPlugins An array of plugin objects.
     * @param string $methodName The name of the method to executed for every plugin
     *                           that should be run.
     * @param integer $type Either MAINTENANCE_PLUGIN_PRE or MAINTENANCE_PLUGIN_POST.
     * @param integer $hook A maintenance plugin hook point. For example,
     *                      MSE_PLUGIN_HOOK_summariseIntermediateRequests.
     * @param array $aParams An optional array of parameters to pass to the method
     *                       called for every plugin that should be run.
     * @return boolean True, except when $type is MAINTENANCE_PLUGIN_PRE, and at least
     *                 one of the plugins is a replacement plugin for a standard
     *                 maintenance engine task (that is, at least one of the plugins
     *                 had a run() method that returned false).
     */
    function &callOnPluginsByHook(&$aPlugins, $methodName, $type, $hook, $aParams = null)
    {
        if (!is_array($aPlugins)) {
            MAX::raiseError('Bad argument: Not an array of plugins.', MAX_ERROR_INVALIDARGS);
            return false;
        }
        foreach ($aPlugins as $key => $oPlugin) {
            if (!is_a($oPlugin, 'MAX_Plugin_Common')) {
                MAX::raiseError('Bad argument: Not an array of plugins.', MAX_ERROR_INVALIDARGS);
                return false;
            }
        }
        $return = true;
        foreach ($aPlugins as $key => $oPlugin) {
            // Ensure the plugin is a maintenance plugin
            if (is_a($oPlugin, 'Plugins_Maintenance')) {
                // Check that the method name can be called
                if (!is_callable(array($oPlugin, $methodName))) {
                    MAX::raiseError("Method '$methodName()' not defined in class '".get_class($oPlugin)."'.", MAX_ERROR_INVALIDARGS);
                    return false;
                }
                // Check that the the plugin's type and hook match
                if (($oPlugin->getHookType() == $type) && ($oPlugin->getHook() == $hook)) {
                    if (is_null($aParams)) {
                        $methodReturn = call_user_func(array($aPlugins[$key], $methodName));
                    } else {
                        $methodReturn = call_user_func_array(array($aPlugins[$key], $methodName), $aParams);
                    }
                    if ($methodReturn === false) {
                        $return = false;
                    }
                }
            }
        }
        return $return;
    }

    /**
     * A factory method, for including and instantiating a plugin, based on the
     * information in that plugin's configuration file(s), given a module (and
     * optional information about the plugin's configuration options).
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $configKey Optional configuration key name, which stores the
     *                          details of the plugin package name. Default is 'type'.
     * @param string $omit An optional setting, where if the value retrieved from the
     *                     configuration file for the $configKey is this, then it is
     *                     known that the plugin module is not been configured, or
     *                     is set to use no package. Default is 'none'.
     * @return mixed The instantiated plugin object, null if configured to return
     *               no plugin, or false on error.
     */
    function &factoryPluginByModuleConfig($module, $configKey = 'type', $omit = 'none')
    {
        // Read the module configuration file
        $conf = MAX_Plugin::getConfig($module);
        // Get the $configKey value from this configuration,
        // and convert into the package/plugin name
        if (!isset($conf[$configKey])) {
            return false;
        } else {
            $packageName = explode(':', $conf[$configKey]);
            if (count($packageName) > 1) {
                $package = $packageName[0];
                $name = $packageName[1];
            } else {
                $package = $conf[$configKey];
                $name = null;
            }
        }
        // Ensure that only real, valid packages/plugins are instantiated
        if ($package == $omit) {
            $r = null;
            return $r;
        }
        // Instantiate the plugin, if possible
        if (!empty($module) && !empty($package)) {
            return MAX_Plugin::factory($module, $package, $name);
        }
        // Error
        return false;
    }

    /**
     * A method to read and parse the configuration file for a plugin.
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package An optional plugin package name (i.e. /plugins/module/package
     *                        directory). If not given, the module level configuration file
     *                        will be read.
     * @param string $name An optional plugin name (i.e. /plugins/module/package/plugin.plugin.php).
     *                     If not given, the package level configuration file will be read, or
     *                     the module level configuration file will be read, depending on the
     *                     $package parameter.
     * @param boolean $processSections Process section names in the configuration file, and return
     *                                 as a multidimenstional array.
     *                                 {@see http://uk.php.net/manual/en/function.parse-ini-file.php}.
     * @param boolean $copyDefaultIfNotExists If true, copy the default configuration file for the
     *                                        plugin to the real configuration file location, if the
     *                                        real configuration file does not (yet) exist.
     * @return mixed An array containing the parsed configuration file, or false on error.
     *
     */
    function getConfig($module, $package = null, $name = null, $processSections = false, $copyDefaultIfNotExists = true)
    {
        // First lets see if the config is saved in our global config file
        $conf = isset($GLOBALS['_MAX']['CONF'][$module]) ? $GLOBALS['_MAX']['CONF'][$module] : false;
        if (!empty($package)) {
            $conf = isset($conf[$package]) ? $conf[$package] : false;
        }

        // Try plugin config
        if ($conf === false) {
            $configFileName = MAX_Plugin::getConfigFileName($module, $package, $name);
            $conf = MAX_Plugin::getConfigByFileName($configFileName, $processSections, false);
        }

        if ($conf !== false) {
            return $conf;
        }
        if ($copyDefaultIfNotExists) {
            MAX_Plugin::copyDefaultConfig($module, $package, $name);
            $defaultConfigFileName = MAX_Plugin::getConfigFileName($module, $package, $name, true);
            return MAX_Plugin::getConfigByFileName($defaultConfigFileName, $processSections, false);
        }
        MAX::raiseError("Config for $package/$module/$name does not exist.", MAX_ERROR_NOFILE);
        return false;
    }

    /**
     * A method to return the path to the configuration file of a given plugin.
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package An optional plugin package name (i.e. /plugins/module/package
     *                        directory). If not given, generates the module level
     *                        configuration file path.
     * @param string $name An optional plugin name (i.e. /plugins/module/package/plugin.plugin.php).
     *                     If not given, generates the package level configuration file path, or
     *                     the module level configuration file path, depending on the $package
     *                     parameter.
     * @param boolean $defaultConfig Optional flag. When true, returns the path to the default
     *                               configuration file distributed with Max; when false, the
     *                               path to the "real" configuration file for the plugin that
     *                               has been written previously is returned.
     * @param string $host An optional parameter to override the host name via which the Max
     *                     installation is currently being accessed.
     * @return string The path to the configuration file.
     */
    function getConfigFileName($module, $package = null, $name = null, $defaultConfig = false, $host = null)
    {
        if ($defaultConfig) {
            if (is_null($host)) {
                $host = 'default';
            }
            $startPath  = MAX_PATH . '/plugins/';
        } else {
            if (is_null($host)) {
                $host = getHostName();
            }
            $startPath  = MAX_PLUGINS_VAR . '/config/';
        }
        $configName = $host.'.plugin.conf.php';
        if ($package === null) {
            $configPath = $module . '/';
        } elseif ($name === null) {
            $configPath = $module . '/' . $package.'/';
        } else {
            $configPath = $module . '/' . $package . '/' . $name . '.';
        }

        return $startPath . $configPath . $configName;
    }

    /**
     * A method to read in and parse a plugin configuration file.
     *
     * @static
     * @param string $configFileName The path to the configuration file.
     * @param boolean $processSections Process section names in the configuration file, and return
     *                                 as a multidimenstional array.
     *                                 {@see http://uk.php.net/manual/en/function.parse-ini-file.php}.
     * @param boolean $raiseErrors If true, raise PEAR errors on failure.
     * @return mixed An array containing the parsed configuration file, or false on error.
     */
    function getConfigByFileName($configFileName, $processSections = false, $raiseErrors = true)
    {
        if (!file_exists($configFileName)) {
            if ($raiseErrors) {
                MAX::raiseError("Config file '{$configFileName}' does not exist.", MAX_ERROR_NOFILE);
            }
            return false;
        }
        $conf = parse_ini_file($configFileName, $processSections);
        if (isset($conf['realConfig'])) {
            if (ereg('.*\/(.*)\.plugin\.conf\.php', $configFileName, $match = null)) {
                $configFileName = str_replace($match[1], $conf['realConfig'], $configFileName);
                return MAX_Plugin::getConfigByFileName($configFileName, $processSections, $raiseErrors);
            } else {
                return false;
            }
        }
        if (is_array($conf)) {
            return $conf;
        } else {
            return false;
        }
    }

    /**
     * A method to copy the default configuration file for a plugin (in /plugins) to the
     * real configuration file for that plugin (in /var).
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package An optional plugin package name (i.e. /plugins/module/package
     *                        directory). If not given, copies the module level
     *                        configuration file path.
     * @param string $name An optional plugin name (i.e. /plugins/module/package/plugin.plugin.php).
     *                     If not given, copies the package level configuration file path, or
     *                     the module level configuration file path, depending on the $package
     *                     parameter.
     * @return boolean True on success, false otherwise.
     *
     */
    function copyDefaultConfig($module, $package = null, $name = null)
    {
        $configFileName = MAX_Plugin::getConfigFileName($module, $package, $name);
        $defaultConfigFileName = MAX_Plugin::getConfigFileName($module, $package, $name, $default = true);
        if (file_exists($defaultConfigFileName)) {
            // Create directory (if not exists)
            MAX_Plugin::_mkDirRecursive(dirname($configFileName), MAX_PLUGINS_VAR_WRITE_MODE);
            // Copy file
            $ret = @copy($defaultConfigFileName, $configFileName);
            return $ret;
        }
        return false;
    }

    /**
     * A method to write the configuration file for plugin. Also creates "fake"
     * configuration files when required by multi-host installations.
     *
     * @static
     * @param array $aConfig The configuration array to save as a configuration file.
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package An optional plugin package name (i.e. /plugins/module/package
     *                        directory). If not given, writes the module level
     *                        configuration file path.
     * @param string $name An optional plugin name (i.e. /plugins/module/package/plugin.plugin.php).
     *                     If not given, writes the package level configuration file, or
     *                     the module level configuration file, depending on the $package
     *                     parameter.
     * @return boolean True on success, false otherwise.
     */
    function writePluginConfig($aConfig, $module, $package = null, $name = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Prepare the config file for writing, using the delivery engine
        // host as the hostname for the "real" config file
        $url = @parse_url('http://' . $conf['webpath']['delivery']);
        if (!isset($url['host'])) {
            return false;
        }
        $deliveryHost = $url['host'];
        $configFileName = MAX_Plugin::getConfigFileName($module, $package, $name, false, $deliveryHost);
        if (!file_exists($configFileName)) {
            MAX_Plugin::copyDefaultConfig($module, $package, $name);
        }
        // Create a new config class, parse the config array, and write to disk
        $oConfig = new Config();
        $oConfig->parseConfig($aConfig, 'phpArray');
        $result = $oConfig->writeConfig($configFileName, 'inifile');
        if ($result == false || PEAR::isError($result)) {
            return false;
        }
        // Check the other possible host names, and write out the fake
        // configuration files if different
        $url = @parse_url('http://' . $conf['webpath']['admin']);
        if (isset($url['host'])) {
            $adminHost = $url['host'];
            if ($adminHost != $deliveryHost) {
                // Create fake file for this host
                $configFileName = MAX_Plugin::getConfigFileName($module, $package, $name, false, $adminHost);
                $aConfig = array('realConfig' => $deliveryHost);
                $oConfig = new Config();
                $oConfig->parseConfig($aConfig, 'phpArray');
                if (!$oConfig->writeConfig($configFileName, 'inifile')) {
                    return false;
                }
            }
        }
        $url = @parse_url('http://' . $conf['webpath']['deliverySSL']);
        if (isset($url['host'])) {
            $deliverySslHost = $url['host'];
            if ($deliverySslHost != $deliveryHost) {
                // Create fake file for this host
                $configFileName = MAX_Plugin::getConfigFileName($module, $package, $name, false, $deliverySslHost);
                $aConfig = array('realConfig' => $deliveryHost);
                $oConfig = new Config();
                $oConfig->parseConfig($aConfig, 'phpArray');
                if (!$oConfig->writeConfig($configFileName, 'inifile')) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * A private method for recursively creating a direcotry. Used when
     * needed to create directories for config files and cache data.
     *
     * @static
     * @access private
     * @param string $directory The directory to create.
     * @param int $mode Optional mode (access permissions).
     * @return boolean True on success (directory created, or already
     *                 exists), false otherwise.
     */
    function _mkDirRecursive($directory, $mode = null)
    {
        if (is_dir($directory)) {
            return true;
        } else {
            if (is_null($mode)) {
                $mode = MAX_PLUGINS_VAR_WRITE_MODE;
            }
            $ret1 = MAX_Plugin::_mkDirRecursive(dirname($directory));
            $ret2 = @mkdir($directory, $mode);
            return $ret1 && $ret2;
        }
    }

    /**
     * A method to build the PEAR::Cache_Lite options for a plugin's cache file(s),
     * given a module/package name. Also creates the required cache store directory
     * if it doesn't exist.
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package The plugin package name (i.e. /plugins/module/package
     *                        directory).
     * @param string $cacheDir An optional specification for the cache directory.
     *                         The default is /var/plugins/cache/module/package/).
     * @param integer $cacheExpire An optional specification for the cache lifetime
     *                             in seconds. The default is 1 hour.
     * @return mixed An array with the cache options for PEAR Cache_Lite class, or
     *               false if the cache directory does not exist/cannot be created.
     */
    function prepareCacheOptions($module, $package, $cacheDir = null, $cacheExpire = 3600)
    {
        // Prepare the options for PEAR::Cache_Lite
        if (is_null($cacheDir)) {
            $cacheDir = MAX_PLUGINS_CACHE . 'cache/' . $module . '/' . $package . '/';
        }
        $aOptions = array(
            'cacheDir' => $cacheDir,
            'lifeTime' => $cacheExpire,
            'automaticSerialization' => true
        );
        if (!is_dir($aOptions['cacheDir'])) {
            if (!MAX_Plugin::_mkDirRecursive($aOptions['cacheDir'], MAX_PLUGINS_VAR_WRITE_MODE)) {
                Max::raiseError('Folder: "' . $aOptions['cacheDir'] . '" is not writeable.');
                return false;
            }
        }
        return $aOptions;
    }

    /**
     * A method for saving a plugin module/package's data in a plugin cache file.
     *
     * @static
     * @param mixed $data The data to save in the cache (automaticSerialization is on, so
     *                    any data type should be okay to save).
     * @param string $id An item ID for the cache data.
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package The plugin package name (i.e. /plugins/module/package
     *                        directory).
     * @param string $name Optional name of the PHP file which contains the plugin,
     *                     otherwise the plugin with the same name as the package
     *                     is assumed.
     * @param array $aOptions An optional array of constructor options for
     *                        PEAR::Cache_Lite. The default values are those
     *                        obtained from {@link MAX_Plugin::prepareCacheOptions()}.
     * @return boolean True on success, false otherwise.
     *
     */
    function saveCacheForPlugin($data, $id, $module, $package, $name = null, $aOptions = null)
    {
        if (is_null($name)) {
            $name = $package;
        }
        if (is_null($aOptions)) {
            $aOptions = MAX_Plugin::prepareCacheOptions($module, $package);
        }
        $cache = new Cache_Lite($aOptions);
        return $cache->save($data, $id, $name);
    }

    /**
     * A method to test if cached is available for a plugin module/package, and if so,
     * return it.
     *
     * @static
     * @param string $id An item ID for the cache data.
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package The plugin package name (i.e. /plugins/module/package
     *                        directory).
     * @param string $name Optional name of the PHP file which contains the plugin,
     *                     otherwise the plugin with the same name as the package
     *                     is assumed.
     * @param boolean $doNotTestCacheValidity An optional flag - when set to true, the
     *                                        cache validity is not tested. Default is
     *                                        true.
     * @param array $aOptions An optional array of constructor options for
     *                        PEAR::Cache_Lite. The default values are those
     *                        obtained from {@link MAX_Plugin::prepareCacheOptions()}.
     * @return mixed The retrieved cache data, or false if no cached data available/the
     *               cache validity was tested, and found to be invalid.
     */
    function getCacheForPluginById($id, $module, $package, $name = null, $doNotTestCacheValidity = true, $aOptions = null)
    {
        if (is_null($name)) {
            $name = $package;
        }
        if (is_null($aOptions)) {
            $aOptions = MAX_Plugin::prepareCacheOptions($module, $package);
        }
        $cache = new Cache_Lite($aOptions);
        return $cache->get($id, $name, $doNotTestCacheValidity);
    }

    /**
     * A method to delete cached plugin data.
     *
     * @static
     * @param string $module The plugin module name (i.e. /plugins/module directory).
     * @param string $package The plugin package name (i.e. /plugins/module/package
     *                        directory).
     * @param string $name Optional name of the PHP file which contains the plugin,
     *                     otherwise the plugin with the same name as the package
     *                     is assumed.
     * @param string $mode An optional PEAR::Cache_Lite cleaning mode. Default is
     *                     'ingroup', to delete all cached data for the plugin.
     * @param array $aOptions An optional array of constructor options for
     *                        PEAR::Cache_Lite. The default values are those
     *                        obtained from {@link MAX_Plugin::prepareCacheOptions()}.
     * @return boolean True on success, false otherwise.
     */
    function cleanPluginCache($module, $package, $name = null, $mode = 'ingroup', $aOptions = null)
    {
        if (is_null($name)) {
            $name = $package;
        }
        if (is_null($aOptions)) {
            $aOptions = MAX_Plugin::prepareCacheOptions($module, $package);
        }
        $oCache = new Cache_Lite($aOptions);
        return $oCache->clean($name, $mode);
    }

}

?>
