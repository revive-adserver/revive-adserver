<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: cache.php 5805 2006-10-27 10:56:56Z andrzej.swedrzynski@m3.net $
*/

/**
 * Cache-wrapper for MAX_Dal_Delivery_getAd()
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
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($cached) {
        include_once 'Cache/Lite/Function.php';
        $cache = new Cache_Lite_Function(_prepareCacheOptions());
        $aRows = $cache->call('MAX_cacheGetAd', $ad_id, false);
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery.php');
        MAX_Dal_Delivery_Include();
        $aRows  = MAX_Dal_Delivery_getAd($ad_id);
    }
    return $aRows;
}

/**
 * Cache-wrapper for MAX_Dal_Delivery_getZoneLinkedAds()
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
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($cached) {
        include_once 'Cache/Lite/Function.php';
        $cache = new Cache_Lite_Function(_prepareCacheOptions());
        $aRows = $cache->call('MAX_cacheGetZoneLinkedAds', $zoneId, false);
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery.php');
        MAX_Dal_Delivery_Include();
        $aRows  = MAX_Dal_Delivery_getZoneLinkedAds($zoneId);
    }
    return $aRows;
}

/**
 * Cache-wrapper for MAX_Dal_Delivery_getZoneInfo
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
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($cached) {
        include_once 'Cache/Lite/Function.php';
        $cache = new Cache_Lite_Function(_prepareCacheOptions());
        $aRows = $cache->call('MAX_cacheGetZoneInfo', $zoneId, false);
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery.php');
        MAX_Dal_Delivery_Include();
        $aRows  = MAX_Dal_Delivery_getZoneInfo($zoneId);
    }
    return $aRows;
}


/**
 * Cache-wrapper for MAX_Dal_Delivery_getLinkedAds
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
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($cached) {
        include_once 'Cache/Lite/Function.php';
        $cache = new Cache_Lite_Function(_prepareCacheOptions());
        $aAds = $cache->call('MAX_cacheGetLinkedAds', $search, false);
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery.php');
        MAX_Dal_Delivery_Include();
        $aAds = MAX_Dal_Delivery_getLinkedAds($search);
    }
    return $aAds;
}

/**
 * Cache-wrapper for MAX_Dal_Delivery_getCreative
 *
 * This function gets a creative stored as a BLOB from the database
 *
 * @param string $filename  The filename of the creative as stored in the database
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            An array with the last-modified timestamp, and the binary contents
 */
function MAX_cacheGetCreative($filename, $cached = true)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($cached) {
        include_once 'Cache/Lite/Function.php';
        $cache = new Cache_Lite_Function(_prepareCacheOptions());
        $aCreative = $cache->call('MAX_cacheGetCreative', $filename, false);
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery.php');
        MAX_Dal_Delivery_Include();
        $aCreative = MAX_Dal_Delivery_getCreative($filename);
    }
    return $aCreative;
}

/**
 * Cache-wrapper for MAX_Dal_Delivery_getTracker
 *
 * This function gets a tracker and it's properties from the database
 *
 * @param int $trackerid    The ID of the tracker to get
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            The array of tracker properties
 */
function MAX_cacheGetTracker($trackerid, $cached = true)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($cached) {
        include_once 'Cache/Lite/Function.php';
        $cache = new Cache_Lite_Function(_prepareCacheOptions());
        $aTracker = $cache->call('MAX_cacheGetTracker', $trackerid, false);
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery.php');
        MAX_Dal_Delivery_Include();
        $aTracker = MAX_Dal_Delivery_getTracker($trackerid);
    }
    return $aTracker;
}

/**
 * Cache-wrapper for MAX_Dal_Delivery_getTrackerVariables
 *
 * This function gets all variables linked to a tracker
 *
 * @param int $trackerid    The ID of the tracker
 * @param boolean $cached   Should a cache lookup be performed?
 * @return array            An array indexed by variable_id of the variables linked to this tracker
 */
function MAX_cacheGetTrackerVariables($trackerid, $cached = true)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($cached) {
        include_once 'Cache/Lite/Function.php';
        $cache = new Cache_Lite_Function(_prepareCacheOptions());
        $aVariables = $cache->call('MAX_cacheGetTrackerVariables', $trackerid, false);
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery.php');
        MAX_Dal_Delivery_Include();
        $aVariables = MAX_Dal_Delivery_getTrackerVariables($trackerid);
    }
    return $aVariables;
}

/**
 * Cache-wrapper for MAX_Dal_Delivery_getChannelLimitations
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
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($cached) {
        include_once 'Cache/Lite/Function.php';
        $cache = new Cache_Lite_Function(_prepareCacheOptions());
        $limitations = $cache->call('MAX_cacheGetChannelLimitations', $channelid, false);
    } else {
        require_once(MAX_PATH . '/lib/max/Dal/Delivery.php');
        MAX_Dal_Delivery_Include();
        $limitations = MAX_Dal_Delivery_getChannelLimitations($channelid);
    }
    return $limitations;
}

/**
 * This function is called by all cache functions to get the options to be passed to the cache object
 *
 * @return array    The array of options to be passed to the cache object
 */
function _prepareCacheOptions()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => $conf['delivery']['cacheExpire']);
    return $options;
}
?>