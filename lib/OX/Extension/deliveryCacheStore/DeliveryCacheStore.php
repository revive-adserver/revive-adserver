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

require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once LIB_PATH . '/Plugin/Component.php';

/**
 * Plugins_DeliveryCacheStore is an abstract class for every DeliveryCacheStore plugin
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryCacheStore
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 * @abstract
 */
abstract class Plugins_DeliveryCacheStore extends OX_Component
{

    /**
     * Constructor method
     */
    function __construct($extension, $group, $component) {
    }

    /**
     * Return information about cache store
     * (is it available etc.)
     *
     * @abstract
     * @return bool|array True if there is no problems or array of string with error messages otherwise
     */
    abstract function getStatus();

    /**
     * A function to delete a single cache entry or the entire delivery cache.
     *
     * @param string $name The cache entry name
     * @return bool True if the entres were succesfully deleted
     */
    function deleteCacheFile($name = '')
    {
        if ($name != '') {
            $filename = OA_Delivery_Cache_buildFileName($name);
            return $this->_deleteCacheFile($filename);
        }
        return $this->_deleteAll();
    }

    /**
     * A function to delete a single cache entry
     *
     * @abstract
     * @param string $filename The cache entry filename (hashed name)
     * @return bool True if the entres were succesfully deleted
     */
    abstract function _deleteCacheFile($filename);

    /**
     * A function to delete entire delivery cache
     *
     * @abstract
     * @return bool True if the entres were succesfully deleted
     */
    abstract function _deleteAll();
}

?>