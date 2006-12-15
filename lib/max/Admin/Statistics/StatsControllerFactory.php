<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController.php';



/**
 * Factory class to create StatsController objects
 *
 * @package    Max
 * @subpackage Admin_Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 *
 * @see StatsController
 */
class StatsControllerFactory
{
    /**
     *  Create a new StatsController object of the appropriate subclass
     *
     * @static
     *
     * @param string Controller type (i.e. global-advertiser)
     * @return StatsController (or inheriting classes) object
     */
    function &newStatsController($controller_type = '', $params = null)
    {
        if (!is_array($params)) {
            $params = array();
        }
        
        if (empty($controller_type))
        {
            $controller_type = basename($_SERVER['PHP_SELF']);
            $controller_type = preg_replace('#^(?:stats-)?(.*)\.php#', '$1', $controller_type);
        }
        
        if ($controller_type == 'global-advertiser')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/GlobalAdvertiser.php';
            
            $product = new StatsGlobalAdvertiserController($params);
        }

        elseif ($controller_type == 'global-affiliates')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/GlobalAffiliate.php';
            
            $product = new StatsGlobalAffiliateController($params);
        }

        elseif ($controller_type == 'global-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/GlobalHistory.php';
            
            $product = new StatsGlobalHistoryController($params);
        }

        elseif ($controller_type == 'global-daily')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/GlobalDaily.php';
            
            $product = new StatsGlobalDailyController($params);
        }

        elseif ($controller_type == 'advertiser-affiliates')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AdvertiserAffiliates.php';
            
            $product = new StatsAdvertiserAffiliatesController($params);
        }

        elseif ($controller_type == 'advertiser-affiliate-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AdvertiserAffiliateHistory.php';
            
            $product = new StatsAdvertiserAffiliateHistoryController($params);
        }

        elseif ($controller_type == 'advertiser-zone-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AdvertiserZoneHistory.php';
            
            $product = new StatsAdvertiserZoneHistoryController($params);
        }

        elseif ($controller_type == 'advertiser-daily')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AdvertiserDaily.php';
            
            $product = new StatsAdvertiserDailyController($params);
        }
        
        elseif ($controller_type == 'advertiser-campaigns')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AdvertiserCampaigns.php';
            
            $product = new StatsAdvertiserCampaignsController($params);
        }

        elseif ($controller_type == 'advertiser-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AdvertiserHistory.php';
            
            $product = new StatsAdvertiserHistoryController($params);
        }

        elseif ($controller_type == 'affiliate-campaigns')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AffiliateCampaigns.php';
            
            $product = new StatsAffiliateCampaignsController($params);
        }

        elseif ($controller_type == 'affiliate-banner-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AffiliateBannerHistory.php';
            
            $product = new StatsAffiliateBannerHistoryController($params);
        }

        elseif ($controller_type == 'affiliate-campaign-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AffiliateCampaignHistory.php';
            
            $product = new StatsAffiliateCampaignHistoryController($params);
        }

        elseif ($controller_type == 'affiliate-daily')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AffiliateDaily.php';
            
            $product = new StatsAffiliateDailyController($params);
        }

        elseif ($controller_type == 'affiliate-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AffiliateHistory.php';
            
            $product = new StatsAffiliateHistoryController($params);
        }

        elseif ($controller_type == 'affiliate-zones')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/AffiliateZones.php';
            
            $product = new StatsAffiliateZonesController($params);
        }

        elseif ($controller_type == 'banner-affiliates')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/BannerAffiliates.php';
            
            $product = new StatsBannerAffiliatesController($params);
        }

        elseif ($controller_type == 'banner-affiliate-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/BannerAffiliateHistory.php';
            
            $product = new StatsBannerAffiliateHistoryController($params);
        }

        elseif ($controller_type == 'banner-zone-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/BannerZoneHistory.php';
            
            $product = new StatsBannerZoneHistoryController($params);
        }

        elseif ($controller_type == 'banner-daily')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/BannerDaily.php';
            
            $product = new StatsBannerDailyController($params);
        }

        elseif ($controller_type == 'banner-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/BannerHistory.php';
            
            $product = new StatsBannerHistoryController($params);
        }

        elseif ($controller_type == 'campaign-affiliates')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/CampaignAffiliates.php';
            
            $product = new StatsCampaignAffiliatesController($params);
        }

        elseif ($controller_type == 'campaign-affiliate-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/CampaignAffiliateHistory.php';
            
            $product = new StatsCampaignAffiliateHistoryController($params);
        }

        elseif ($controller_type == 'campaign-zone-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/CampaignZoneHistory.php';
            
            $product = new StatsCampaignZoneHistoryController($params);
        }

        elseif ($controller_type == 'campaign-banners')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/CampaignBanners.php';
            
            $product = new StatsCampaignBannersController($params);
        }

        elseif ($controller_type == 'campaign-daily')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/CampaignDaily.php';
            
            $product = new StatsCampaignDailyController($params);
        }

        elseif ($controller_type == 'campaign-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/CampaignHistory.php';
            
            $product = new StatsCampaignHistoryController($params);
        }

        elseif ($controller_type == 'zone-campaigns')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/ZoneCampaigns.php';
            
            $product = new StatsZoneCampaignsController($params);
        }

        elseif ($controller_type == 'zone-campaign-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/ZoneCampaignHistory.php';
            
            $product = new StatsZoneCampaignHistoryController($params);
        }

        elseif ($controller_type == 'zone-banner-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/ZoneBannerHistory.php';
            
            $product = new StatsZoneBannerHistoryController($params);
        }

        elseif ($controller_type == 'zone-daily')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/ZoneDaily.php';
            
            $product = new StatsZoneDailyController($params);
        }

        elseif ($controller_type == 'zone-history')
        {
            require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController/ZoneHistory.php';
            
            $product = new StatsZoneHistoryController($params);
        }

        else
        {
            MAX::raiseError("The statistics module discovered a controller type that it didn't know how to handle.", MAX_ERROR_INVALIDARGS);
        }

        return $product;
    }
}

?>
