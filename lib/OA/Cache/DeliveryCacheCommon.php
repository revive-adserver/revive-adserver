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

require_once MAX_PATH . '/lib/max/Delivery/cache.php';

/**
 * Basic invalidating delivery cache methods.
 * 
 * @package    OpenXCache
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OA_Cache_DeliveryCacheCommon
{
    /**
     * Stores current delivery cache store plugin
     *
     * @var Plugins_DeliveryCacheStore
     */
    var $oCacheStorePlugin;
    
    /**
     * Constructor
     */
    function __construct() {
        $this->oCacheStorePlugin = 
            &OX_Component::factoryByComponentIdentifier(
                $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']
            );
        // Do not use Plugin if it's not enabled
        if ($this->oCacheStorePlugin->enabled === false) {
            $this->oCacheStorePlugin = false;
        }
    }
    
    /**
     * Method to invalidate all delivery cache files
     * 
     * @return boolean True if the entries were succesfully deleted
     */
    function invalidateAll(){
        return $this->invalidateFile(null);
    }
    
    /**
     * Function to invalidate single cache entry
     * If $sName is not given it's invalidate all cache files
     *
     * @param string $sName The cache entry name
     * @return bool True if the entry was succesfully deleted
     */
    function invalidateFile($sName) {
        // Check if plugin is loaded
        if ($this->oCacheStorePlugin !== false) {
            return $this->oCacheStorePlugin->deleteCacheFile($sName);
        }
        return false;
    }
    
    // Functions invalidating particular cache files
    
    /**
     * Invalidate GetAd cache files for given banner.
     *
     * @param int $zoneId Zone Id
     * @return boolean True if the entry was succesfully deleted
     */
    function invalidateGetAdCache($bannerId){
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetAd', $bannerId);
        return $this->invalidateFile($sName);
    }
     
    /**
     * Invalidate GetAccountTZs cache file
     * @return boolean True if the entry was succesfully deleted
     */
    function invalidateGetAccountTZsCache(){
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetAccountTZs');
        return $this->invalidateFile($sName);
    }
     
    /**
     * Invalidate ZoneLinkedAds cache files for given zone.
     *
     * @param int $zoneId Zone Id
     * @return boolean True if the entry was succesfully deleted
     */
    function invalidateZoneLinkedAdsCache($zoneId){
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetZoneLinkedAds', $zoneId);
        return $this->invalidateFile($sName);
    }
     
    /**
     * Invalidate GetZoneInfo cache files for given zone.
     *
     * @param int $zoneId Zone Id
     * @return boolean True if the entry was succesfully deleted
     */
    function invalidateGetZoneInfoCache($zoneId){
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetZoneInfo', $zoneId);
        return $this->invalidateFile($sName);
    }
    
    /** 
     * Invalidate GetCreative cache files for given file name.
     *
     * @param string $filename Filename of cached image (creative)
     * @return boolean True if the entry was succesfully deleted 
     */
    function invalidateGetCreativeCache($filename) {
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetCreative', $filename);
        return $this->invalidateFile($sName);        
    }
    
    /** 
     * Invalidate GetTracker cache files for given tracker.
     *
     * @param int $trackerId Tracker Id
     * @return boolean True if the entry was succesfully deleted 
     */
    function invalidateGetTrackerCache($trackerId) {
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetTracker', $trackerId);
        return $this->invalidateFile($sName); 
    } 
    
    /** 
     * Invalidate GetTrackerVariables cache files for given tracker.
     *
     * @param int $trackerId Tracker Id
     * @return boolean True if the entry was succesfully deleted 
     */
    function invalidateGetTrackerVariablesCache($trackerId) {
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetTrackerVariables', $trackerId);
        return $this->invalidateFile($sName);
    }

    /** 
     * Invalidate CheckIfMaintenanceShouldRun cache file
     *
     * @return boolean True if the entry was succesfully deleted 
     */
    function invalidateCheckIfMaintenanceShouldRunCache() {
        $sName  = OA_Delivery_Cache_getName('MAX_cacheCheckIfMaintenanceShouldRun');
        return $this->invalidateFile($sName);
    } 
    
    /** 
     * Invalidate GetChannelLimitations cache files for given channel.
     *
     * @param int $channelId Channel Id
     * @return boolean True if the entry was succesfully deleted 
     */
    function invalidateGetChannelLimitationsCache($channelId) {
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetChannelLimitations', $channelId);
        return $this->invalidateFile($sName);
    }

    /** 
     * Invalidate GetGoogleJavaScript cache files for given channel.
     *
     * @return boolean True if the entry was succesfully deleted 
     */
    function invalidateGetGoogleJavaScriptCache() {
        $sName  = OA_Delivery_Cache_getName('MAX_cacheGetGoogleJavaScript');
        return $this->invalidateFile($sName);
    }
   
    /**
     * Invalidate PublisherZones cache files for given zone 
     *
     * @param int $affiliateId Affiliate Id (also know as Website Id or Publisher Id)
     * @return boolean True if the entry was succesfully deleted
     */
    function invalidatePublisherZonesCache($affiliateId){
        $sName  = OA_Delivery_Cache_getName('OA_cacheGetPublisherZones', $affiliateId);
        return $this->invalidateFile($sName);
    }
}
?>