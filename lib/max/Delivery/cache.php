<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
    'expiry' => $GLOBALS['_MAX']['CONF']['delivery']['cacheExpire']
);

/**
 * A function to fetch a cache entry.
 *
 * @param string $name The cache entry name
 * @param bool $isHash Is $name a hash already or should hash be created from it?
 * @return mixed False on error, or the cache content as a string
 */
function OA_Delivery_Cache_fetch($name, $isHash = false)
{
    $filename = OA_Delivery_Cache_buildFileName($name, $isHash);

    $cache_complete = false;
    $cache_contents = '';

    // We are assuming that most of the time cache will exists
    $ok = @include($filename);

    if ($ok && $cache_complete == true) {
        // The method used to implement cache expiry imposes two cache writes if the cache is
        // expired and the database is available, but avoid the need to check for file existence
        // and modification time.
        if (isset($cache_expiry) && $cache_expiry < MAX_commonGetTimeNow()) {
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
 * @return bool True if the entry was succesfully stored
 */
function OA_Delivery_Cache_store($name, $cache, $isHash = false)
{
    if ($cache === OA_DELIVERY_CACHE_FUNCTION_ERROR) {
        // Don't store the result to enable permanent caching
        return false;
    }

    $filename = OA_Delivery_Cache_buildFileName($name, $isHash);
    $expiry   = MAX_commonGetTimeNow() + $GLOBALS['OA_Delivery_Cache']['expiry'];

    $cache_literal  = "<"."?php\n\n";
    $cache_literal .= "$"."cache_contents = ".var_export($cache, true).";\n\n";
    $cache_literal .= "$"."cache_name     = '".addcslashes($name, "'")."';\n";
    $cache_literal .= "$"."cache_expiry   = ".$expiry.";\n";
    $cache_literal .= "$"."cache_complete = true;\n\n";
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
            @rename($tmp_filename, $filename);
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
 * @return string The cache content
 */
function OA_Delivery_Cache_store_return($name, $cache, $isHash = false)
{
    if (OA_Delivery_Cache_store($name, $cache, $isHash)) {
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
function OA_Delivery_Cache_getName($functionName, $id = null)
{
    $functionName = strtolower(str_replace('MAX_cacheGet', '', $functionName));
    if ($id) {
        return $functionName.$id;
    }
    return $functionName;
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
    if (($aRows = OA_Delivery_Cache_fetch($sName)) !== false) {
    } else {
        MAX_Dal_Delivery_Include();
        $aRows = OA_Dal_Delivery_getAd($ad_id);
        $aRows = OA_Delivery_Cache_store_return($sName, $aRows);
    }

    return $aRows;
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
    if (($aRows = OA_Delivery_Cache_fetch($sName)) === false) {
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
    if (($aRows = OA_Delivery_Cache_fetch($sName)) === false) {
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
function MAX_cacheGetLinkedAds($search, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $search);
    if (($aAds = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aAds = OA_Dal_Delivery_getLinkedAds($search);
        $aAds = OA_Delivery_Cache_store_return($sName, $aAds);
    }

    return $aAds;
}

/**
 * Cache-wrapper for OA_Dal_Delivery_getCreative
 *
 * This function gets a creative stored as a BLOB from the database
 *
 * @param string $filename  The filename of the creative as stored in the database
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            An array with the last-modified timestamp, and the binary contents
 */
function MAX_cacheGetCreative($filename, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $filename);
    if (($aCreative = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aCreative = OA_Dal_Delivery_getCreative($filename);
        $aCreative = OA_Delivery_Cache_store_return($sName, $aCreative);
    }

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
    if (($aTracker = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aTracker = OA_Dal_Delivery_getTracker($trackerid);
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
    if (($aVariables = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aVariables = OA_Dal_Delivery_getTrackerVariables($trackerid);
        $aVariables = OA_Delivery_Cache_store_return($sName, $aVariables);
    }

    return $aVariables;
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
    if (($limitations = OA_Delivery_Cache_fetch($sName)) === false) {
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
    if (($output = OA_Delivery_Cache_fetch($sName)) === false) {
        require_once(MAX_PATH . '/lib/max/Delivery/google.php');
        $output = MAX_googleGetJavaScript();
        $output = OA_Delivery_Cache_store_return($sName, $output);
    }

    return $output;
}

?>