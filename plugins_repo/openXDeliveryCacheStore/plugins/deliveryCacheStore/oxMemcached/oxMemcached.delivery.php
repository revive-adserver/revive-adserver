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
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */

/**
 * Function to fetch a cache entry
 *
 * @param string $filename The name of file where cache entry is stored
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
 * @param array $cache_contents  The cache content
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
    } else if (is_numeric($GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedExpireTime'])) {
        $expiryTime = $GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedExpireTime'];
    }
    $serializedCacheExport = serialize($cache_contents); 

    // Store serialized cache
    // @ - to catch "memcached errno=10054: An existing connection was forcibly closed by the remote host", when one of servers is down
    $result = @$oMemcache->replace($filename, $serializedCacheExport, false, $expiryTime);
    if ($result !== true) {
        // Memcache set/replece can return null on error, so ensure, that for all errors results if false
        // @ - to catch "memcached errno=10054: An existing connection was forcibly closed by the remote host", when one of servers is down  
        if (@$oMemcache->set($filename, $serializedCacheExport, false, $expiryTime) !== true) {
            return false; 
        }
    }
    return true;
}

/**
 * Return current Memcache instance
 *
 * @return Memcache 
 */
function _oxMemcached_getMemcache(){
    if (!isset($GLOBALS['OA_Delivery_Cache']['MemcachedObject'])) {
         return _oxMemcached_MemcachedInit();
    }
    return $GLOBALS['OA_Delivery_Cache']['MemcachedObject'];
}

/**
 * Function to initialize Memcache connection
 * Memcache function is stored in $GLOBALS['OA_Delivery_Cache']['MemcachedObject']
 * 
 * @return Memcache|bool Memcache object or false on errors
 */
function _oxMemcached_MemcachedInit() {
    // Don't use memcached if there is no extension in PHP
    if (!class_exists('Memcache')){
        return false;
    }
    $oMemcache = new Memcache(); 
    
    $aServers = (explode(',', $GLOBALS['_MAX']['CONF']['oxMemcached']['memcachedServers']));
    $serversAdded = false;
    foreach ($aServers as $server) {
        if (_oxMemcached_addMemcachedServer($oMemcache, $server)) {
            $serversAdded = true;
        }
    }
    if ($serversAdded === true) {
        $GLOBALS['OA_Delivery_Cache']['MemcachedObject'] =& $oMemcache;
        return $GLOBALS['OA_Delivery_Cache']['MemcachedObject'];
    }
    return false;
}

/**
 * Add server to memcached
 * Split given server address to host and port
 * Host can be unix:///path!
 *
 * @param Memcache $oMemcache Memcache instance
 * @param string $serverAddress memcache server adres in format host:port
 * @return bool
 */
function _oxMemcached_addMemcachedServer(&$oMemcache, $serverAddress) {
    $serverAddress = trim($serverAddress);
    if (($colonPos = strrpos($serverAddress, ':')) === false) {
        return false;
    }
    $port = substr($serverAddress,$colonPos+1);
    if (!is_numeric($port)) {
        return false;
    }
    // @ - to catch memcached notices on errors
    return @$oMemcache->addServer(substr($serverAddress,0,$colonPos), $port);
}

?>