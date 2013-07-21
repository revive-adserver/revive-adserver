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

/**
 * A class that deals with configuration settings for this group of components
 *
 */
class oxMemcached_processSettings
{

    /**
     * Method that is called on settings form submission
     * Error messages are appended to the 0 index of the array
     *
     * @return boolean
     */
    function validate(&$aErrorMessage)
    {
        // Store current values from config
        // overwrite it by tested ones
        $storeSettings = array();
        if (isset($GLOBALS['oxMemcached_memcachedServers'])) {
            $storeSettings['memcachedServers'] = $GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedServers'];
            $GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedServers'] = $GLOBALS['oxMemcached_memcachedServers'];
        }
        if (isset($GLOBALS['oxMemcached_memcachedExpireTime'])) {
            $storeSettings['memcachedExpireTime'] = $GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedExpireTime'];
            $GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedExpireTime'] = $GLOBALS['oxMemcached_memcachedExpireTime'];
        }

        // Use memcached plugin getStatus function to validate
        $oPlgOxMemcached = &OX_Component::factory('deliveryCacheStore', 'oxMemcached', 'oxMemcached');
        $result = $oPlgOxMemcached->getStatus();
        if ($result !== true) {
            $aErrorMessage[0] = $result;
            $result = false;
        }

        // Restore config values
        foreach ($storeSettings as $key => $value) {
            $GLOBALS['_MAX']['CONF']['oxMemcached'][$key] = $value;
        }

        return $result;
    }
}


?>