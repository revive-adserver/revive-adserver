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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/FileScanner.php';

require_once OX_PATH . '/lib/OX.php';
require_once OX_PATH . '/lib/pear/Cache/Lite.php';
require_once OX_PATH . '/lib/pear/Config.php';

/**
 * The default write mode for directories inside MAX_PLUGINS_VAR.
 */
define('MAX_PLUGINS_VAR_WRITE_MODE', 0755);

/**
 * The default file mask for plugins.
 */
define('MAX_PLUGINS_EXTENSION', '.plugin.php');
define('MAX_PLUGINS_PATH', '/plugins/');

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
     * @todo There is currently a mechanism in place to not include plugins from packages which
     *       haven't been enabled in the configuration file, as more modules are refactored,
     *       they should be added to the refactoredModules until this whole section can be removed
     * @return mixed The instantiated plugin object, or false on error.
     */
    public static function factory($module, $package, $name = null)
    {
        if ($name === null) {
            $name = $package;
        }
        if (!MAX_Plugin::_isEnabledPlugin($module, $package, $name)) {
            return false;
        }
        if (!MAX_Plugin::_includePluginFile($module, $package, $name)) {
            return false;
        }
        $className = MAX_Plugin::_getPluginClassName($module, $package, $name);
        $obj = new $className($module, $package, $name);
        $obj->module = $module;
        $obj->package = $package;
        $obj->name = $name;
        return $obj;
    }

    private static function _isEnabledPlugin($module, $package, $name)
    {
        $aRefactoredModules = ['deliveryLimitations', 'bannerTypeHtml', 'bannerTypeText'];
        if (in_array($module, $aRefactoredModules)) {
            $aConf = $GLOBALS['_MAX']['CONF'];
            if (empty($aConf['pluginGroupComponents'][$package])) {
                return false;
            }
            if (!$aConf['pluginGroupComponents'][$package]) {
                return false;
            }
        }
        return true;
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
    public static function _includePluginFile($module, $package, $name = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($name === null) {
            $name = $package;
        }
        $packagePath = empty($package) ? "" : $package . "/";

        $fileName = MAX_PATH . MAX_PLUGINS_PATH . $module . "/" . $packagePath . $name . MAX_PLUGINS_EXTENSION;
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
    public static function _getPluginClassName($module, $package, $name = null)
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
    public static function getPlugins($module, $package = null, $onlyPluginNameAsIndex = true, $recursive = 1)
    {
        $plugins = [];
        $pluginFiles = MAX_Plugin::_getPluginsFiles($module, $package, $recursive);
        foreach ($pluginFiles as $key => $pluginFile) {
            $pluginInfo = explode(':', $key);
            if (count($pluginInfo) > 1) {
                $plugin = MAX_Plugin::factory($module, $pluginInfo[0], $pluginInfo[1]);
                if ($plugin !== false) {
                    if ($onlyPluginNameAsIndex) {
                        $plugins[$pluginInfo[1]] = $plugin;
                    } else {
                        $plugins[$key] = $plugin;
                    }
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
    public static function _getPluginsFiles($module, $package = null, $recursive = 1)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $pluginsDir = MAX_PATH . MAX_PLUGINS_PATH;

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
    public static function _getPluginsFilesFromDirectory($directory, $recursive = 1)
    {
        if (is_readable($directory)) {
            $fileMask = self::_getFileMask();
            $oFileScanner = new MAX_FileScanner();
            $oFileScanner->addFileTypes(['php', 'inc']);
            $oFileScanner->setFileMask($fileMask);
            $oFileScanner->addDir($directory, $recursive);
            return $oFileScanner->getAllFiles();
        } else {
            return [];
        }
    }

    private static function _getFileMask()
    {
        return '#^.*' .
            preg_quote(MAX_PLUGINS_PATH, '#') .
            '/?([a-zA-Z0-9\-_]*)/?([a-zA-Z0-9\-_]*)?/([a-zA-Z0-9\-_]*)' .
            preg_quote(MAX_PLUGINS_EXTENSION, '#') .
            '$#';
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
    public static function callStaticMethod($module, $package, $name, $staticMethod, $aParams = null)
    {
        if ($name === null) {
            $name = $package;
        }
        if (!MAX_Plugin::_isEnabledPlugin($module, $package, $name)) {
            return false;
        }
        if (!MAX_Plugin::_includePluginFile($module, $package, $name)) {
            return false;
        }
        $className = MAX_Plugin::_getPluginClassName($module, $package, $name);

        // PHP4/5 compatibility for get_class_methods.
        $aClassMethods = array_map('strtolower', (get_class_methods($className)));
        if (!$aClassMethods) {
            $aClassMethods = [];
        }
        if (!in_array(strtolower($staticMethod), $aClassMethods)) {
            MAX::raiseError("Method '$staticMethod()' not defined in class '$className'.", MAX_ERROR_INVALIDARGS);
            return false;
        }
        if (is_null($aParams)) {
            return call_user_func([$className, $staticMethod]);
        } else {
            return call_user_func_array([$className, $staticMethod], $aParams);
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
    public static function callOnPlugins(&$aPlugins, $methodName, $aParams = null)
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
        $aReturn = [];
        foreach ($aPlugins as $key => $oPlugin) {
            // Check that the method name can be called
            if (!is_callable([$oPlugin, $methodName])) {
                $message = "Method '$methodName()' not defined in class '" .
                            MAX_Plugin::_getPluginClassName($oPlugin->extension, $oPlugin->group, $oPlugin->name) . "'.";
                MAX::raiseError($message, MAX_ERROR_INVALIDARGS);
                return false;
            }
            if (is_null($aParams)) {
                $aReturn[$key] = call_user_func([$aPlugins[$key], $methodName]);
            } else {
                $aReturn[$key] = call_user_func_array([$aPlugins[$key], $methodName], $aParams);
            }
        }
        return $aReturn;
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
    public static function factoryPluginByModuleConfig($module, $configKey = 'type', $omit = 'none')
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
    public static function getConfig($module, $package = null, $name = null, $processSections = false, $copyDefaultIfNotExists = true)
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
        OA::debug("Config for $package/$module/$name does not exist.", MAX_ERROR_NOFILE);
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
    public static function getConfigFileName($module, $package = null, $name = null, $defaultConfig = false, $host = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($defaultConfig) {
            if (is_null($host)) {
                $host = 'default';
            }
            $startPath = MAX_PATH . '/plugins/';
        } else {
            if (is_null($host)) {
                $host = OX_getHostName();
            }
            $startPath = MAX_PATH . $aConf['pluginPaths']['var'] . 'config/';
        }
        $configName = $host . '.plugin.conf.php';
        if ($package === null) {
            $configPath = $module . '/';
        } elseif ($name === null) {
            $configPath = $module . '/' . $package . '/';
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
    public static function getConfigByFileName($configFileName, $processSections = false, $raiseErrors = true)
    {
        if (!file_exists($configFileName)) {
            if ($raiseErrors) {
                MAX::raiseError("Config file '{$configFileName}' does not exist.", MAX_ERROR_NOFILE);
            }
            return false;
        }
        $conf = parse_ini_file($configFileName, $processSections);
        if (isset($conf['realConfig'])) {
            if (preg_match('#.*/(.*)\.plugin\.conf\.php#D', $configFileName, $match)) {
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
    private static function copyDefaultConfig($module, $package = null, $name = null)
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
    public static function writePluginConfig($aConfig, $module, $package = null, $name = null)
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
                $aConfig = ['realConfig' => $deliveryHost];
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
                $aConfig = ['realConfig' => $deliveryHost];
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
    public static function _mkDirRecursive($directory, $mode = null)
    {
        // Sanity check that the folder to be created is under MAX_PATH
        if (substr($directory, 0, strlen(MAX_PATH)) != MAX_PATH) {
            $directory = MAX_PATH . $directory;
        }
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
    public static function prepareCacheOptions($module, $package, $cacheDir = null, $cacheExpire = 3600)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Prepare the options for PEAR::Cache_Lite
        if (is_null($cacheDir)) {
            $cacheDir = MAX_PATH . $aConf['pluginPaths']['var'] . 'cache/' . $module . '/' . $package . '/';
        }
        $aOptions = [
            'cacheDir' => $cacheDir,
            'lifeTime' => $cacheExpire,
            'automaticSerialization' => true
        ];
        if (!is_dir($aOptions['cacheDir'])) {
            if (!MAX_Plugin::_mkDirRecursive($aOptions['cacheDir'], MAX_PLUGINS_VAR_WRITE_MODE)) {
                MAX::raiseError('Folder: "' . $aOptions['cacheDir'] . '" is not writeable.', PEAR_LOG_ERR);
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
    public static function saveCacheForPlugin($data, $id, $module, $package, $name = null, $aOptions = null)
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
    public static function getCacheForPluginById($id, $module, $package, $name = null, $doNotTestCacheValidity = true, $aOptions = null)
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
    public static function cleanPluginCache($module, $package, $name = null, $mode = 'ingroup', $aOptions = null)
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
