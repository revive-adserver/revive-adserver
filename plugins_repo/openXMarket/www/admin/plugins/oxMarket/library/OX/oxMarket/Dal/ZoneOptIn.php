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
require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheManager.php';

/**
 * Zones DAL Library. Wraps plugin DO object
 *
 * @package    openXMarket
 * @author     Bernard Lange  <bernard.lange@openx.org>
 */
class OX_oxMarket_Dal_ZoneOptIn
{
    /**
     * Updates zone's market opt in status to the given one.
     * 
     * @param int $zoneId 
     * @package boolean $optedIn indicates whether this zone has market enabled
     */    
    public function updateZoneOptInStatus($zoneId, $optedIn)
    {
        if(empty($zoneId)) {
            return false;
        }
        
        $aConf = $GLOBALS['_MAX']['CONF'];
        
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref');
        $oExt_market_zone_pref->updateZoneStatus($zoneId, $optedIn);

        if ($optedIn) {
            //remove cached zone chaining (if any)
            $cacheManager = new OA_Cache_DeliveryCacheManager();
            $cacheManager->invalidateZoneCache($zoneId);
        }
            
        // invalidate zone-market delivery cache 
        if (!function_exists('OX_cacheInvalidateGetZoneMarketInfo')) {
            require_once MAX_PATH . $aConf['pluginPaths']['plugins'] . 'deliveryAdRender/oxMarketDelivery/oxMarketDelivery.delivery.php';
        }
        OX_cacheInvalidateGetZoneMarketInfo($zoneId);
        


        return true;
    }
    
    
    /**
     * Checks if given zone is opted in to market.
     * 
     * @param int $zoneId
     * @return boolean true if zone opted in, false if not.  
     */      
    public function isOptedIn($zoneId)
    {
        if (empty($zoneId)) {
            return false;
        }        
        $marketEnabled = false;
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref');
        if ($oExt_market_zone_pref->get($zoneId)) {
            $marketEnabled = $oExt_market_zone_pref->is_enabled;
        }
        
        return $marketEnabled;
    }
}
