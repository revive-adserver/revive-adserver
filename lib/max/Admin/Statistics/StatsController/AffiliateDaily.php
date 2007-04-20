<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsDailyController.php';



class StatsAffiliateDailyController extends StatsDailyController
{
    function start()
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // Get parameters
        if (phpAds_isUser(phpAds_Affiliate)) {
            $publisherId = phpAds_getUserId();
        } else {
            $publisherId = (int)MAX_getValue('affiliateid', '');
        }

        // Cross-entity
        $placementId = (int)MAX_getValue('campaignid', '');
        $adId        = (int)MAX_getValue('bannerid', '');

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
        if (!MAX_checkPublisher($publisherId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        if (!empty($adId)) {
            // Fetch banners
            $aAds = $this->getPublisherBanners($publisherId);

            // Cross-entity security check
            if (!isset($aAds[$adId])) {
                $this->noStatsAvailable = true;
            }
        } elseif (!empty($placementId)) {
            // Fetch campaigns
            $aPlacements = $this->getPublisherCampaigns($publisherId);

            // Cross-entity security check
            if (!isset($aPlacements[$placementId])) {
                $this->noStatsAvailable = true;
            }
        }

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            if (empty($placementId) && empty($adId)) {
                $this->pageId = '2.4.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($adId) ? '2.4.3.1.1' : '2.4.3.2.1';
            }
            $this->pageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            if (empty($placementId) && empty($adId)) {
                $this->pageId = '1.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($adId) ? '1.3.1.1' : '1.3.2.1';
            }
            $this->pageSections = array($this->pageId);
        }

        // Add standard page parameters
        $this->pageParams = array('affiliateid' => $publisherId);
        $this->pageParams['period_preset']  = MAX_getStoredValue('period_preset', 'today');
        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'history');
        $this->pageParams['day']           = MAX_getValue('day', '');

        // Cross-entity
        if (!empty($adId)) {
            $this->pageParams['campaignid'] = $aAds[$adId]['placement_id'];
            $this->pageParams['banner']     = $adId;
        } elseif (!empty($placementId)) {
            $this->pageParams['campaignid'] = $placementId;
        }

        $this->loadParams();

        $this->addBreadcrumbs('publisher', $publisherId);

        // Cross-entity
        if (!empty($adId)) {
            $this->addCrossBreadcrumbs('banner', $adId);
        } elseif (!empty($placementId)) {
            $this->addCrossBreadcrumbs('campaign', $placementId);
        }

        // Add shortcuts
        if (!phpAds_isUser(phpAds_Affiliate)) {
            $this->addShortcut(
                $GLOBALS['strAffiliateProperties'],
                'affiliate-edit.php?affiliateid='.$publisherId,
                'images/icon-affiliate.gif'
            );
        }

        $aParams = array();
        $aParams['publisher_id'] = $publisherId;

        // Cross-entity
        if (!empty($adId)) {
            $aParams['ad_id'] = $adId;
        } elseif (!empty($placementId)) {
            $aParams['placement_id'] = $placementId;
        }

        $this->prepareHistory($aParams);
    }
}

?>
