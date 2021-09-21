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

require_once MAX_PATH . '/lib/max/Plugin.php';

/**
 * MAX_Plugin_Common is an abstract class, defining the common methods and
 * interface for plugin classes.
 *
 * @package    OpenXPlugin
 * @abstract
 */
class MAX_Plugin_Common
{
    public $module;
    public $package;
    public $name;

    /**
     * Method for reading the specific plugin config file
     *
     * @param bool $processSections        If true the configuration data is returned
     *                                     as one dimension array
     * @param bool $commonPackageConfig    If true read the global plugin.conf.php file
     *                                     for specific package
     *
     * @return array                       Configuration array
     *
     */
    public function getConfig($processSections = false, $commonPackageConfig = true)
    {
        $name = $commonPackageConfig ? null : $this->name;
        return MAX_Plugin::getConfig($this->module, $this->package, $name, $processSections);
    }

    /**
     * Method return the string containing package or plugin config name
     *
     * @param bool $commonPackageConfig    If true read the global plugin.conf.php file
     *                                     for specific package
     *
     * @return string  Config file name
     *
     */
    public function getConfigFileName($commonPackageConfig = true)
    {
        $name = $commonPackageConfig ? null : $this->name;
        return MAX_Plugin::getConfigFileName($this->module, $this->package, $name);
    }

    /**
     * Method return module config file name
     *
     * @return string  Module config file name
     *
     */
    public function getModuleConfigFileName()
    {
        return MAX_Plugin::getConfigFileName($this->module);
    }

    /**
     * Return the cache
     * (Test if a cache is available and if $doNotTestCacheValidity is false)
     *
     * @static
     * @param string $id                       Cache id
     * @param bool   $doNotTestCacheValidity   If set to true, the cache validity won't be tested
     * @param array  $options                  Options - see Cache_Lite()
     *
     * @return mixed                            Data of the cache (or false if no cache available)
     *
     */
    public function getCacheById($id, $doNotTestCacheValidity = true, $options = null)
    {
        return MAX_Plugin::getCacheForPluginById(
            $id,
            $this->module,
            $this->package,
            $this->name,
            $doNotTestCacheValidity,
            $options
        );
    }

    /**
     * Save some data in a cache file
     *
     * @static
     * @param string $data      Data to put in cache (can be another type than strings if automaticSerialization is on)
     * @param string $id        Cache id
     * @param array  $options   Options - see Cache_Lite()
     *
     * @return bool             True if no problem, else false
     *
     */
    public function saveCache($data, $id, $options = null)
    {
        return MAX_Plugin::saveCacheForPlugin(
            $data,
            $id,
            $this->module,
            $this->package,
            $this->name,
            $options
        );
    }

    /**
     * Save some data in a cache file
     *
     * @static
     * @param string $mode  Flush cache mode : 'old', 'ingroup', 'notingroup'
     *
     * @return bool         True if no problem, else false
     *
     */
    public function cleanCache($mode = 'ingroup')
    {
        return MAX_Plugin::cleanPluginCache($this->module, $this->package, $this-> name, $mode);
    }

    /**
     * Translates string using module/package translation file
     *
     * @param string $string  String to translate
     * @return string  Translated string
     */
    public function translate($string)
    {
        return MAX_Plugin_Translation::translate($string, $this->module, $this->package);
    }
}
