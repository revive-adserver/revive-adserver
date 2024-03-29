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
 */
abstract class Plugins_DeliveryCacheStore extends OX_Component
{
    /**
     * Constructor method
     */
    public function __construct($extension, $group, $component) {}

    /**
     * Return information about cache store
     * (is it available etc.)
     *
     * @return bool|array True if there is no problems or array of string with error messages otherwise
     */
    abstract public function getStatus();

    /**
     * A function to delete a single cache entry or the entire delivery cache.
     *
     * @param string $name The cache entry name
     * @return bool True if the entres were succesfully deleted
     */
    public function deleteCacheFile($name = '')
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
     * @param string $filename The cache entry filename (hashed name)
     * @return bool True if the entres were succesfully deleted
     */
    abstract public function _deleteCacheFile($filename);

    /**
     * A function to delete entire delivery cache
     *
     * @return bool True if the entres were succesfully deleted
     */
    abstract public function _deleteAll();
}
