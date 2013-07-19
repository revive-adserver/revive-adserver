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

require_once LIB_PATH . '/Extension/deliveryCacheStore/DeliveryCacheStore.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * A File based cache store plugin for delivery cache
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryCacheStore
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_DeliveryCacheStore_oxCacheFile_oxCacheFile extends Plugins_DeliveryCacheStore
{
    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('File based cache');
    }

    /**
     * Return information about cache store
     *
     * @return bool|array True if there is no problems or array of string with error messages otherwise
     */
    function getStatus()
    {
        $deliveryPath = $this->_getCachePath();
        if (!is_writable($deliveryPath)) {
            return array($this->translate('strUnableToWriteTo') . ' ' . htmlspecialchars($deliveryPath));
        }
        return true;
    }

    /**
     * A function to delete a single cache entry
     *
     * @param string $filename The cache entry filename (hashed name)
     * @return bool True if the entres were succesfully deleted
     */
    function _deleteCacheFile($filename)
    {
        $filename = $this->_getCachePath().$filename;
        if (file_exists($filename)) {
            @unlink ($filename);
            return true;
        }
        return false;
    }


    /**
     * A function to delete entire delivery cache
     *
     * @return bool True if the entres were succesfully deleted
     */
    function _deleteAll()
    {
        $cachedir = @opendir($this->_getCachePath());

        while (false !== ($filename = @readdir($cachedir))) {
            if (preg_match("#^{$GLOBALS['OA_Delivery_Cache']['prefix']}[0-9A-F]{32}.php$#i", $filename)) {
                @unlink ($this->_getCachePath().$filename);
            }
        }
        @closedir($cachedir);

        return true;
    }

    function _getCachePath() {
        if (!empty($GLOBALS['_MAX']['CONF'][$this->group]['cachePath'])) {
            return trim($GLOBALS['_MAX']['CONF'][$this->group]['cachePath']).'/';
        } else {
            return MAX_PATH.'/var/cache/';
        }
    }
}
?>