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
     * Return the name of plugin
     *
     * @abstract
     * @return string
     */
    abstract function getName();

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