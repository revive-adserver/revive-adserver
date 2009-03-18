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
// Using multi-dirname so tests can be run from either plugins or plugins_repo
require_once dirname(__FILE__) . '/oxMemcached.delivery.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * A Memcached cache store plugin for delivery cache
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryCacheStore
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_DeliveryCacheStore_oxMemcached_oxMemcached extends Plugins_DeliveryCacheStore
{
    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('memcached');
    }

    /**
     * Return information about cache storage
     *
     * @return bool|array True if there is no problems or array of string with error messages otherwise
     */
    function getStatus()
    {
        $aErrors = array();
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Check if memcached is enabled in php.ini
        if (!class_exists('Memcache'))
        {
            return array($this->translate('strNoMemcacheModuleInPhp'));
        }
        // Check servers list
        $aServers = (explode(',', $aConf[$this->group]['memcachedServers']));
        if (count($aServers) > 0)
        {
            foreach ($aServers as $key => $server)
            {
                if (empty($server)) {
                    unset($aServers[$key]);
                }
            }
        }
        if (count($aServers) == 0)
        {
            return $this->translate('strEmptyServerList', array('plugin-settings.php?group=oxMemcached'));
        }
        $oMemcache = new Memcache();
        foreach ($aServers as $server)
        {
            if (!_oxMemcached_addMemcachedServer($oMemcache, $server))
            {
                $aErrors[] = $this->translate('strInvalidServerAddress') . " " . $server;
            }
        }
        // Check expire time
        if (!empty($aConf[$this->group]['memcachedExpireTime']) &&
            (
                !is_numeric($aConf[$this->group]['memcachedExpireTime']) ||
                $aConf[$this->group]['memcachedExpireTime'] <= $aConf['delivery']['cacheExpire']
            )
        )
        {
            $aErrors[] = $this->translate('strInvalidExpireTime');
        }
        // Check if memcached server is running

        if (@$oMemcache->getVersion() === false)
        {
            $aErrors[] = $this->translate('strCouldntConnectToMemcached');
        }

        if (count($aErrors) > 0)
        {
            return $aErrors;
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
        $oMemcache = _oxMemcached_getMemcache();
        // @ - to catch memcached notices on errors
        return @$oMemcache->delete($filename);
    }

    /**
     * A function to delete entire delivery cache
     *
     * @return bool True if the entres were succesfully deleted
     */
    function _deleteAll()
    {
        $oMemcache = _oxMemcached_getMemcache();
        if ($oMemcache == false) {
            return false;
        }
        // @ - to catch memcached notices on errors
        return @$oMemcache->flush();
    }
}
?>
