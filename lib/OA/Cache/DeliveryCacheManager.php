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

require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';

/**
 * A library class for advanced invalidating delivery cache functions.
 * 
 * @package    OpenXCache
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OA_Cache_DeliveryCacheManager extends OA_Cache_DeliveryCacheCommon
{   
    /**
     * Method to invalidate delivery cache file related with given banner
     * This invalidate banner's image cache and ZoneLinkedAds cache for linked zones as well
     *  
     * @param int $bannerId Banner Id
     */
    function invalidateBannerCache($bannerId) {
        if(!is_numeric($bannerId)) {
            return;
        }
        $this->invalidateGetAdCache($bannerId);
        
        // Invalidate image cache
        $doBanner = OA_Dal::factoryDO('banners'); 
        $doBanner->get($bannerId);
        $this->invalidateImageCache($doBanner->filename);
        
        // Invalidate ZoneLinkedAds cache files
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->find();
        while($doAdZoneAssoc->fetch()) {
            $this->invalidateZoneLinkedAdsCache($doAdZoneAssoc->zone_id);
        }

        // @todo Add invalidating direct-selection cache files
    }
    
    /** 
     * Method to invalidate delivery cache file related to given image (creative)
     *
     * @param string $filename Filename of cached image (creative)
     */
    function invalidateImageCache($filename) {
        $this->invalidateGetCreativeCache($filename);
    }
    

    /**
     * Invalidate delivery cache files related to given zone
     *
     * @param int $zoneId Zone Id
     */
    function invalidateZoneCache($zoneId) {
        if(!is_numeric($zoneId)) {
            return;
        }
        $this->invalidateGetZoneInfoCache($zoneId);
        $this->invalidateZoneLinkedAdsCache($zoneId);
        
        $doZone = OA_Dal::factoryDO('zones');
        $doZone->get($zoneId);
        $this->invalidatePublisherZonesCache($doZone->affiliateid);
        
        // @todo Add invalidating direct-selection cache files
    }
    
    /**
     * Invalidate website cache files
     *
     * This function should be called only when managing (adding/removing) zones 
     * 
     * @param int $affiliateId Affiliate Id (also know as Website Id or Publisher Id)
     */
    function invalidateWebsiteCache($affiliateId) {
        $this->invalidatePublisherZonesCache($affiliateId);
    }
    
    /**
     * Invalidate zones cache files on linking and unlinking to/from campaign  
     *
     * This function should be called on linking page
     * 
     * @param array $aZones a list of affected zones (linked and unlinked)
     */
    function invalidateZonesLinkingCache($aZones) {
        if(is_array($aZones)) {
            foreach ($aZones as $zoneId) {
                $this->invalidateZoneLinkedAdsCache($zoneId);
            }
        }
    }
    
    /**
     * Invalidate cache files for given tracker.
     *
     * @param int $trackerId Tracker Id
     */
    function invalidateTrackerCache($trackerId) {
        $this->invalidateGetTrackerCache($trackerId);
        $this->invalidateGetTrackerVariablesCache($trackerId);
    }
    
    /**
     * Invalidate cache files for given channel
     *
     * @param int $channelId Channel Id
     */
    function invalidateChannelCache($channelId){
        $this->invalidateGetChannelLimitationsCache($channelId);
    }
    
    /**
     * Invalidate cache files with system settings 
     *
     * Should be used on changing:
     * - maintenance period
     * - Time Zones for accounts
     * - parameters used by Google JavaScript. This happens on:
     *      * changing Delivery File Names
     *      * setting '3rd Party Click Tracking Delimiter' on account-settings-banner-delivery.php (ctDelimiter)
     *      * manipuliation on $GLOBALS['_MAX']['CONF']['var'] array
     */
    function invalidateSystemSettingsCache() {
        $this->invalidateCheckIfMaintenanceShouldRunCache();
        $this->invalidateGetAccountTZsCache();
        $this->invalidateGetGoogleJavaScriptCache();
    }
}

?>