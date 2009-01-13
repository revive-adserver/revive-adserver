<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/max/Plugin.php';

/**
 * MAX_Plugin_Common is an abstract class, defining the common methods and
 * interface for plugin classes.
 *
 * @package    OpenXPlugin
 * @author     Radek Maciaszek <radek@m3.net>
 * @abstract
 */
class MAX_Plugin_Common
{
    var $module;
    var $package;
    var $name;

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
    function getConfig($processSections = false, $commonPackageConfig = true)
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
    function getConfigFileName($commonPackageConfig = true)
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
    function getModuleConfigFileName()
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
    function getCacheById($id, $doNotTestCacheValidity = true, $options = null)
    {
        return MAX_Plugin::getCacheForPluginById($id, $this->module, $this->package, $this->name,
            $doNotTestCacheValidity, $options);
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
    function saveCache($data, $id, $options = null)
    {
        return MAX_Plugin::saveCacheForPlugin($data, $id, $this->module, $this->package, $this->name,
            $options);
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
    function cleanCache($mode = 'ingroup')
    {
        return MAX_Plugin::cleanPluginCache($this->module, $this->package, $this-> name, $mode);
    }
    
    /**
     * Translates string using module/package translation file
     *
     * @param string $string  String to translate
     * @return string  Translated string
     */
    function translate($string)
    {
        return MAX_Plugin_Translation::translate($string, $this->module, $this->package);
    }

}

?>