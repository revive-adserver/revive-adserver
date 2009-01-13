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
            if (preg_match("#^{$GLOBALS['OA_Delivery_Cache']['prefix']}[0-9A-F]{32}.php$#i", $filename))
                @unlink ($GLOBALS['OA_Delivery_Cache']['path'].$filename);
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