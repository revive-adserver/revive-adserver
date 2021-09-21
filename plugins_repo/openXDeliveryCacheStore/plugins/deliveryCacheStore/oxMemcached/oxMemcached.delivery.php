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
 *  A Memcached cache storage plugin for delivery cache - delivery functions
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryCacheStorage
 */

/**
 * Function to fetch a cache entry
 *
 * @param string $filename The name of file where cache entry is stored
 *
 * @return mixed False on error, or the cache content
 */
function Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheRetrieve($filename)
{
    $oMemcache = _oxMemcached_getMemcache();
    if ($oMemcache == false) {
        return false;
    }
    // Get serialized cache
    // @ - to catch "memcached errno=10054: An existing connection was forcibly closed by the remote host", when one of servers is down
    $serializedCacheVar = @$oMemcache->get($filename);
    if ($serializedCacheVar === false) {
        return false;
    }
    return unserialize($serializedCacheVar);
}

/**
 * A function to store content a cache entry.
 *
 * @param string $filename The filename where cache entry is stored
 * @param array  $cache_contents The cache content
 *
 * @return bool True if the entry was succesfully stored
 */
function Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheStore($filename, $cache_contents)
{
    $oMemcache = _oxMemcached_getMemcache();
    if ($oMemcache == false) {
        return false;
    }

    $expiryTime = 0;
    if (!empty($cache_contents['cache_expire'])) {
        $expiryTime = $cache_contents['cache_expire'];
    } elseif (is_numeric($GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedExpireTime'])) {
        $expiryTime = $GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedExpireTime'];
    }
    $serializedCacheExport = serialize($cache_contents);

    // Store serialized cache
    // @ - to catch "memcached errno=10054: An existing connection was forcibly closed by the remote host", when one of servers is down
    if ($oMemcache instanceof Memcached) {
        $result = @$oMemcache->replace($filename, $serializedCacheExport, $expiryTime);
    } else {
        $result = @$oMemcache->replace($filename, $serializedCacheExport, false, $expiryTime);
    }
    if ($result !== true) {
        // Memcached set/replace can return null on error, so ensure, that for all errors results if false
        // @ - to catch "memcached errno=10054: An existing connection was forcibly closed by the remote host", when one of servers is down
        if ($oMemcache instanceof Memcached) {
            $setResult = @$oMemcache->set($filename, $serializedCacheExport, $expiryTime);
        } else {
            $setResult = @$oMemcache->set($filename, $serializedCacheExport, false, $expiryTime);
        }
        if ($setResult !== true) {
            return false;
        }
    }
    return true;
}

/**
 * Return current Memcached instance
 *
 * @return Memcached|Memcache|bool
 */
function _oxMemcached_getMemcache()
{
    if (!isset($GLOBALS['OA_Delivery_Cache']['MemcachedObject'])) {
        return _oxMemcached_MemcachedInit();
    }
    return $GLOBALS['OA_Delivery_Cache']['MemcachedObject'];
}

/**
 * Function to initialize Memcached connection
 * Memcached function is stored in $GLOBALS['OA_Delivery_Cache']['MemcachedObject']
 *
 * @return Memcached|Memcache|bool Memcached object or false on errors
 */
function _oxMemcached_MemcachedInit()
{
    // Don't use memcached if there is no extension in PHP
    if (!class_exists('Memcached') && !class_exists('Memcache')) {
        return false;
    }

    if (class_exists('Memcached')) {
        $oMemcache = new Memcached();
    } else {
        $oMemcache = new Memcache();
    }

    $aServers = (explode(',', $GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedServers']));
    $serversAdded = false;
    foreach ($aServers as $server) {
        if (_oxMemcached_addMemcachedServer($oMemcache, $server)) {
            $serversAdded = true;
        }
    }
    if ($serversAdded === true) {
        $GLOBALS['OA_Delivery_Cache']['MemcachedObject'] = &$oMemcache;
        return $GLOBALS['OA_Delivery_Cache']['MemcachedObject'];
    }
    return false;
}

/**
 * Add server to memcached
 * Split given server address to host and port
 * Host can be unix:///path!
 *
 * @param Memcached|Memcache $oMemcache Memcached instance
 * @param string             $serverAddress memcached server address in format host:port
 *
 * @return bool
 */
function _oxMemcached_addMemcachedServer(&$oMemcache, $serverAddress)
{
    $serverAddress = trim($serverAddress);
    if (($colonPos = strrpos($serverAddress, ':')) === false) {
        return false;
    }
    $port = substr($serverAddress, $colonPos + 1);
    if (!is_numeric($port)) {
        return false;
    }
    // @ - to catch memcached notices on errors
    return @$oMemcache->addServer(substr($serverAddress, 0, $colonPos), $port);
}
