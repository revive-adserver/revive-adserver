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
 * Light Cache methods
 *
 */

$file = '/lib/max/Delivery/cache.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

/**
 * Constant used for permanent caching
 *
 */
define ('OA_DELIVERY_CACHE_FUNCTION_ERROR', 'Function call returned an error');


/**
 * Global variable to keep cache informations
 *
 * @var array
 */
$GLOBALS['OA_Delivery_Cache'] = array(
    'prefix' => 'deliverycache_',
    'host'   => OX_getHostName(),
    'expiry' => $GLOBALS['_MAX']['CONF']['delivery']['cacheExpire']
);

/**
 * A function to fetch a cache entry.
 *
 * @param string $name The cache entry name
 * @param bool $isHash Is $name a hash already or should hash be created from it?
 * @param bool $expiryTime If null uses default expiry time (from config) but
 *                         Determine how long cache is valid
 * @return mixed False on error, or the cache content as a string
 */
function OA_Delivery_Cache_fetch($name, $isHash = false, $expiryTime = null)
{
    $filename = OA_Delivery_Cache_buildFileName($name, $isHash);

    $aCacheVar = OX_Delivery_Common_hook(
        'cacheRetrieve',
        array($filename),
        $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']
    );
    if ($aCacheVar !== false) {
        if ($aCacheVar['cache_name'] != $name) {
            OX_Delivery_logMessage("Cache ERROR: {$name} != {$aCacheVar['cache_name']}", 7);
            return false;
        }
        // The method used to implement cache expiry imposes two cache writes if the cache is
        // expired and the database is available, but avoid the need to check for file existence
        // and modification time.
        if ($expiryTime === null) {
            $expiryTime = $GLOBALS['OA_Delivery_Cache']['expiry'];
        }
        $now = MAX_commonGetTimeNow();
        if (    (isset($aCacheVar['cache_time']) && $aCacheVar['cache_time'] + $expiryTime < $now)
             || (isset($aCacheVar['cache_expire']) && $aCacheVar['cache_expire'] < $now) )
        {
            // Update expiry, needed to enable permanent caching if needed
            OA_Delivery_Cache_store($name, $aCacheVar['cache_contents'], $isHash);
            OX_Delivery_logMessage("Cache EXPIRED: {$name}", 7);

            return false;
        }
        OX_Delivery_logMessage("Cache HIT: {$name}", 7);

        return $aCacheVar['cache_contents'];
    }
    OX_Delivery_logMessage("Cache MISS {$name}", 7);

    return false;
}


/**
 * A function to store content a cache entry.
 *
 * @param string $name  The cache entry name
 * @param string $cache The cache content
 * @param string $isHash Define if $name is already a cached value or not
 * @param int $expireAt  Define the exact time when cache is expired
 * @return bool True if the entry was succesfully stored
 */
function OA_Delivery_Cache_store($name, $cache, $isHash = false, $expireAt = null)
{
    if ($cache === OA_DELIVERY_CACHE_FUNCTION_ERROR) {
        // Don't store the result to enable permanent caching
        return false;
    }

    $filename = OA_Delivery_Cache_buildFileName($name, $isHash);

    $aCacheVar = array();
    $aCacheVar['cache_contents'] = $cache;
    $aCacheVar['cache_name'] = $name;
    $aCacheVar['cache_time'] = MAX_commonGetTimeNow();
    $aCacheVar['cache_expire'] = $expireAt;

    return OX_Delivery_Common_hook(
        'cacheStore',
        array($filename, $aCacheVar),
        $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']
    );
}


/**
 * A function to store content a cache entry and return the cache content,
 * useful for retrieving the permanent cache content.
 *
 * @param string $name  The cache entry name
 * @param string $cache The cache content
 * @param bool $isHash  true indicates that $name is already hash, else the hash is created from it
 * @param int $expireAt Time when the cache should expire
 * @return string The cache content
 */
function OA_Delivery_Cache_store_return($name, $cache, $isHash = false, $expireAt = null)
{
    OX_Delivery_Common_hook(
        'preCacheStore_'.OA_Delivery_Cache_getHookName($name),
        array($name, &$cache)
    );
    if (OA_Delivery_Cache_store($name, $cache, $isHash, $expireAt)) {
        return $cache;
    }
    $currentCache = OA_Delivery_Cache_fetch($name, $isHash);
    // If cache storage is unavailable return given cache
    if ($currentCache === false) {
        return $cache;
    }
    return $currentCache;
}

/**
 * Returns the function name which output is being stored in
 *
 * @param string $name
 * @return string
 */
function OA_Delivery_Cache_getHookName($name)
{
    $pos = strpos($name, '^');
    return $pos ? substr($name, 0, $pos) : substr($name, 0, strpos($name, '@'));
}

/**
 * A function to build a cache entry filename.
 *
 * @param string $name The cache entry name
 * @return string The file name of the cache file
 */
function OA_Delivery_Cache_buildFileName($name, $isHash = false)
{
    if(!$isHash) {
        // If not a hash yet
        $name = md5($name);
    }
    return $GLOBALS['OA_Delivery_Cache']['prefix'].$name.'.php';
}


/**
 * A function to build a cache entry name.
 *
 * This function accepts any string parameters which are then used
 * to generate the cache name.
 *
 * @return string The generated cache entry name
 */
function OA_Delivery_Cache_getName($functionName)
{
    $args = func_get_args();
    $args[0] = strtolower(str_replace('MAX_cacheGet', '', $args[0]));

    return join('^', $args).'@'.$GLOBALS['OA_Delivery_Cache']['host'];
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getAd()
 *
 * The function to get and return a single ad
 *
 * @param string        $ad_id     The ad id for the specified ad
 * @param boolean       $cached    Should a cache lookup be performed?
 * @return array|null   $ad        An array containing the ad data or null if nothing found
 *
 */
function MAX_cacheGetAd($ad_id, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $ad_id);
    if (!$cached || ($aRows = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRows = OA_Dal_Delivery_getAd($ad_id);
        $aRows = OA_Delivery_Cache_store_return($sName, $aRows);
    }

    return $aRows;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getAccountTZs()
 *
 * The function to retrieve admin's timezone
 *
 * @param boolean       $cached    Should a cache lookup be performed?
 * @return array An array containing the default timezone and the
 *               list of account IDs and their timezones
 */
function MAX_cacheGetAccountTZs($cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__);
    if (!$cached || ($aResult = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aResult = OA_Dal_Delivery_getAccountTZs();
        $aResult = OA_Delivery_Cache_store_return($sName, $aResult);
    }

    return $aResult;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getZoneLinkedAds()
 *
 * The function to get and return the ads linked to a zone
 *
 * @param  int      $zoneid The id of the zone to get linked ads for
 * @param boolean   $cached Should a cache lookup be performed?
 * @return array|false
 *                   The array containg zone information with nested arrays of linked ads
 *                   or false on failure. Note that:
 *                      - Override ads are in "xAds"
 *                      - Contract campaign ads are in "ads"
 *                      - Remnant campaign ads are in "lAds"
 *                      - Companion ads, in addition to being in one of the above, are
 *                        also in "cAds" and "clAds"
 *                      - Override and Remnant ads have had their priorities
 *                        calculated on the basis of the campaign and creative
 *                        weights
 */
function MAX_cacheGetZoneLinkedAds($zoneId, $cached = true)
{
    $sName = OA_Delivery_Cache_getName(__FUNCTION__, $zoneId);
    if (!$cached || ($aRows = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRows = OA_Dal_Delivery_getZoneLinkedAds($zoneId);
        $aRows = OA_Delivery_Cache_store_return($sName, $aRows);
    }
    return $aRows;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getZoneLinkedAdInfos()
 *
 * The function to get and return the ads linked to a zone
 *
 * @param  int      $zoneid The id of the zone to get linked ads for
 * @param boolean   $cached Should a cache lookup be performed?
 * @return array|false
 *                   The array containg zone information with nested arrays of linked ads
 *                   or false on failure. Note that:
 *                      - Override ads are in "xAds"
 *                      - Normal (paid) ads are in "ads"
 *                      - Low-priority ads are in "lAds"
 *                      - Companion ads, in addition to being in one of the above, are
 *                        also in "cAds" and "clAds"
 *                      - Override and low-priority ads have had their priorities
 *                        calculated on the basis of the placement and advertisement
 *                        weight
 */
function MAX_cacheGetZoneLinkedAdInfos($zoneId, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $zoneId);
    if (!$cached || ($aRows = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRows = OA_Dal_Delivery_getZoneLinkedAdInfos($zoneId);
        $aRows = OA_Delivery_Cache_store_return($sName, $aRows);
    }

    return $aRows;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getZoneInfo
 *
 * This function gets zone properties from the database
 *
 * @param int $zoneid       The ID of the zone to get information about
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array|false      An array containing the properties for that zone
 *                          or false on failure
 */
function MAX_cacheGetZoneInfo($zoneId, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $zoneId);
    if (!$cached || ($aRows = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRows = OA_Dal_Delivery_getZoneInfo($zoneId);
        $aRows = OA_Delivery_Cache_store_return($sName, $aRows);
    }

    return $aRows;
}


/**
 * Cache-wrapper for OA_Dal_Delivery_getLinkedAds
 *
 * The function to get and return the ads for direct selection
 *
 * @param  string       $search     The search string for this banner selection
 *                                  Usually 'bannerid:123' or 'campaignid:123'
 * @param boolean       $cached     Should a cache lookup be performed?
 *
 * @return array|false              The array of ads matching the search criteria
 */
function MAX_cacheGetLinkedAds($search, $campaignid, $laspart, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $search, $campaignid, $laspart);
    if (!$cached || ($aAds = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aAds = OA_Dal_Delivery_getLinkedAds($search, $campaignid, $laspart);
        $aAds = OA_Delivery_Cache_store_return($sName, $aAds);
    }

    return $aAds;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getLinkedAdInfos
 *
 * The function to get and return the ads for direct selection
 *
 * @param  string       $search     The search string for this banner selection
 *                                  Usually 'bannerid:123' or 'campaignid:123'
 * @param boolean       $cached     Should a cache lookup be performed?
 *
 * @return array|false              The array of ads matching the search criteria
 */
function MAX_cacheGetLinkedAdInfos($search, $campaignid, $laspart, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $search, $campaignid, $laspart);
    if (!$cached || ($aAds = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aAds = OA_Dal_Delivery_getLinkedAdInfos($search, $campaignid, $laspart);
        $aAds = OA_Delivery_Cache_store_return($sName, $aAds);
    }

    return $aAds;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getCreative
 *
 * This function gets a creative stored as a BLOB from the database
 * It also make sure that contents is correctly slashed and serialized before
 * writing it into cache file
 *
 * @param string $filename  The filename of the creative as stored in the database
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            An array with the last-modified timestamp, and the binary contents
 */
function MAX_cacheGetCreative($filename, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $filename);
    if (!$cached || ($aCreative = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aCreative = OA_Dal_Delivery_getCreative($filename);
        $aCreative['contents'] = addslashes(serialize($aCreative['contents']));
        $aCreative = OA_Delivery_Cache_store_return($sName, $aCreative);
    }
    $aCreative['contents'] = unserialize(stripslashes($aCreative['contents']));
    return $aCreative;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getTracker
 *
 * This function gets a tracker and it's properties from the database
 *
 * @param int $trackerid    The ID of the tracker to get
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            The array of tracker properties
 */
function MAX_cacheGetTracker($trackerid, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $trackerid);
    if (!$cached || ($aTracker = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aTracker = OA_Dal_Delivery_getTracker($trackerid);
        $aTracker = OA_Delivery_Cache_store_return($sName, $aTracker);
    }

    return $aTracker;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getTrackerLinkedCreatives
 *
 * This function gets a list of creatives which are linked to the specified tracker
 *
 * @param int $trackerid    The ID of the tracker to get
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            The array of creatives
 */
function MAX_cacheGetTrackerLinkedCreatives($trackerid = null, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $trackerid);
    if (!$cached || ($aTracker = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aTracker = OA_Dal_Delivery_getTrackerLinkedCreatives($trackerid);
        $aTracker = OA_Delivery_Cache_store_return($sName, $aTracker);
    }

    return $aTracker;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getTrackerVariables
 *
 * This function gets all variables linked to a tracker
 *
 * @param int $trackerid    The ID of the tracker
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            An array indexed by variable_id of the variables linked to this tracker
 */
function MAX_cacheGetTrackerVariables($trackerid, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $trackerid);
    if (!$cached || ($aVariables = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aVariables = OA_Dal_Delivery_getTrackerVariables($trackerid);
        $aVariables = OA_Delivery_Cache_store_return($sName, $aVariables);
    }

    return $aVariables;
}

/**
 * Check if maintenance should run using cached information
 *
 * This function gets maintenance's last run info
 *
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            The array of tracker properties
 */
function MAX_cacheCheckIfMaintenanceShouldRun($cached = true)
{
    // Default delay is 5 minutes
    $interval    = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'] * 60;
    $delay       = intval(($GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'] / 12) * 60);

    $now         = MAX_commonGetTimeNow();
    $today       = strtotime(date('Y-m-d'), $now);
    $nextRunTime = $today + (floor(($now - $today) / $interval) + 1) * $interval + $delay;

    // Adding the delay could shift the time to the next operation interval,
    // make sure to fix it in case it happens
    if ($nextRunTime - $now > $interval) {
        $nextRunTime -= $interval;
    }

    $cName  = OA_Delivery_Cache_getName(__FUNCTION__);
    if (!$cached || ($lastRunTime = OA_Delivery_Cache_fetch($cName)) === false) {
        MAX_Dal_Delivery_Include();
        $lastRunTime = OA_Dal_Delivery_getMaintenanceInfo();

        // Cache until the next operation interval if scheduled maintenance was run
        // during the delay
        if ($lastRunTime >= $nextRunTime - $delay) {
            $nextRunTime += $interval;
        }

        OA_Delivery_Cache_store($cName, $lastRunTime, false, $nextRunTime);
    }

    return $lastRunTime < $nextRunTime - $interval;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getChannelLimitations
 *
 * The function to get delivery limitations for a channel
 *
 * @param  int $channelid    The channelid for the specified channel
 * @param boolean $cached    Should a cache lookup be performed?
 *
 * @return array             An array with the acls_plugins, and compiledlimitation
 */
function MAX_cacheGetChannelLimitations($channelid, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $channelid);
    if (!$cached || ($limitations = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $limitations = OA_Dal_Delivery_getChannelLimitations($channelid);
        $limitations = OA_Delivery_Cache_store_return($sName, $limitations);
    }

    return $limitations;
}


/**
 * Cache-wrapper for OA_Dal_Delivery_getPublisherZones()
 *
 * The function to get and return a list of zones for a publisher
 *
 * @param boolean  $cached    Should a cache lookup be performed?
 * @return array   $output    An array of zones for the publisher indexed on zone_id
 *
 */
function OA_cacheGetPublisherZones($affiliateid, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $affiliateid);
    if (!$cached || ($output = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $output = OA_Dal_Delivery_getPublisherZones($affiliateid);
        $output = OA_Delivery_Cache_store_return($sName, $output);
    }

    return $output;
}

?>
