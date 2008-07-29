<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
    'path'   => MAX_PATH.'/var/cache/',
    'prefix' => 'deliverycache_',
    'host'   => getHostName(),
    'expiry' => $GLOBALS['_MAX']['CONF']['delivery']['cacheExpire']
);


/**
 * Make sure that the custom path is used if set
 */
if (!empty($GLOBALS['_MAX']['CONF']['delivery']['cachePath'])) {
    $GLOBALS['OA_Delivery_Cache']['path'] = trim($GLOBALS['_MAX']['CONF']['delivery']['cachePath']).'/';
}


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

    $cache_complete = false;
    $cache_contents = '';

    // We are assuming that most of the time cache will exists
    $ok = @include($filename);

    if ($ok && $cache_complete == true) {
        // Make sure that the cache name matches
        if ($cache_name != $name) {
            return false;
        }
        // The method used to implement cache expiry imposes two cache writes if the cache is
        // expired and the database is available, but avoid the need to check for file existence
        // and modification time.
        if ($expiryTime === null) {
            $expiryTime = $GLOBALS['OA_Delivery_Cache']['expiry'];
        }
        $now = MAX_commonGetTimeNow();
        if (    (isset($cache_time) && $cache_time + $expiryTime < $now)
             || (isset($cache_expire) && $cache_expire < $now) )
        {
            // Update expiry, needed to enable permanent caching if needed
            OA_Delivery_Cache_store($name, $cache_contents, $isHash);
            return false;
        }
        return $cache_contents;
    }

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

    if (!is_writable($GLOBALS['OA_Delivery_Cache']['path'])) {
        return false;
    }

    $filename = OA_Delivery_Cache_buildFileName($name, $isHash);

    $cache_literal  = "<"."?php\n\n";
    $cache_literal .= "$"."cache_contents   = ".var_export($cache, true).";\n\n";
    $cache_literal .= "$"."cache_name       = '".addcslashes($name, "\\'")."';\n";
    $cache_literal .= "$"."cache_time       = ".MAX_commonGetTimeNow().";\n";
    if ($expireAt !== null) {
        $cache_literal .= "$"."cache_expire     = ".$expireAt.";\n";
    }
    $cache_literal .= "$"."cache_complete   = true;\n\n";
    $cache_literal .= "?".">";

    // Write cache to a temp file, then rename it, overwritng the old cache
    // On *nix systems this should guarantee atomicity
    $tmp_filename = tempnam($GLOBALS['OA_Delivery_Cache']['path'], $GLOBALS['OA_Delivery_Cache']['prefix'].'tmp_');
    if ($fp = @fopen($tmp_filename, 'wb')) {
        @fwrite ($fp, $cache_literal, strlen($cache_literal));
        @fclose ($fp);

        if (!@rename($tmp_filename, $filename)) {
            // On some systems rename() doesn't overwrite destination
            @unlink($filename);
            if (!@rename($tmp_filename, $filename)) {
                // Make sure that no temporary file is left over
                // if the destination is not writable
                @unlink($tmp_filename);
            }
        }

        return true;
    }

    return false;
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
    if (OA_Delivery_Cache_store($name, $cache, $isHash, $expireAt)) {
        return $cache;
    }

    return OA_Delivery_Cache_fetch($name, $isHash);
}

/**
 * A function to delete a single cache entry or the entire delivery cache.
 *
 * @param string $name The cache entry name
 * @return bool True if the entres were succesfully stored
 */
function OA_Delivery_Cache_delete($name = '')
{
    if ($name != '') {
        $filename = OA_Delivery_Cache_buildFileName($name);

        if (file_exists($filename)) {
            @unlink ($filename);
            return true;
        }
    } else {
        $cachedir = @opendir($GLOBALS['OA_Delivery_Cache']['path']);

        while (false !== ($filename = @readdir($cachedir))) {
            if (preg_match("#^{$GLOBALS['OA_Delivery_Cache']['prefix']}[0-9A-F]{32}.php$#i", $filename))
                @unlink ($filename);
        }

        @closedir($cachedir);

        return true;
    }

    return false;
}


/**
 * A function to get cache informations.
 *
 * @return array An array of all the cache sizes by entry name
 */
function OA_Delivery_Cache_info()
{
    $result = array();

    $cachedir = @opendir($GLOBALS['OA_Delivery_Cache']['path']);

    while (false !== ($filename = @readdir($cachedir))) {
        if (preg_match("#^{$GLOBALS['OA_Delivery_Cache']['prefix']}[0-9A-F]{32}.php$#i", $filename)) {
            $cache_complete = false;
            $cache_contents = '';
            $cache_name     = '';

            $ok = @include($filename);

            if ($ok && $cache_complete == true) {
                $result[$cache_name] = strlen(serialize($cache_contents));
            }
        }
    }

    @closedir($cachedir);

    return $result;
}


/**
 * A function to build a cache entry filename.
 *
 * @param string $name The cache entry name
 * @return string The full path of the cache file
 */
function OA_Delivery_Cache_buildFileName($name, $isHash = false)
{
    if(!$isHash) {
        // If not a hash yet
        $name = md5($name);
    }
    return $GLOBALS['OA_Delivery_Cache']['path'].$GLOBALS['OA_Delivery_Cache']['prefix'].$name.'.php';
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
 *                      - Exclusive ads are in "xAds"
 *                      - Normal (paid) ads are in "ads"
 *                      - Low-priority ads are in "lAds"
 *                      - Companion ads, in addition to being in one of the above, are
 *                        also in "cAds" and "clAds"
 *                      - Exclusive and low-priority ads have had their priorities
 *                        calculated on the basis of the placement and advertisement
 *                        weight
 */
function MAX_cacheGetZoneLinkedAds($zoneId, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $zoneId);
    if (!$cached || ($aRows = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRows = OA_Dal_Delivery_getZoneLinkedAds($zoneId);
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
        $aTracker = OA_Delivery_Cache_store_return($sName, $aTracker, $isHash = true);
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
        $aTracker = OA_Delivery_Cache_store_return($sName, $aTracker, $isHash = true);
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
    $delay       = !empty($GLOBALS['_MAX']['CONF']['maintenance']['autoMaintenanceDelay']) ?
                       $GLOBALS['_MAX']['CONF']['maintenance']['autoMaintenanceDelay'] * 60 :
                       300;

    // Auto-maintenance is disabled if the delay is lower than the OI
    if ($delay <= 0 || $delay >= $interval) {
        return false;
    }

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
 * Cache-wrapper for MAX_googleGetJavaScript()
 *
 * The function to get and return Google Adsense click tracking code
 *
 * @param boolean  $cached    Should a cache lookup be performed?
 * @return string  $output    The Google Adsense click tracking code
 *
 */
function MAX_cacheGetGoogleJavaScript($cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__);
    if (!$cached || ($output = OA_Delivery_Cache_fetch($sName)) === false) {
        include MAX_PATH . '/lib/max/Delivery/google.php';
        $output = MAX_googleGetJavaScript();
        $output = OA_Delivery_Cache_store_return($sName, $output);
    }

    return $output;
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
