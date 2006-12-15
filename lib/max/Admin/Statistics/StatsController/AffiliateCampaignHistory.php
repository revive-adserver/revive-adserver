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
$Id: AffiliateHistory.php 4735 2006-04-24 13:36:06Z matteo@beccati.com $
*/

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsCrossHistoryController.php';



class StatsAffiliateCampaignHistoryController extends StatsCrossHistoryController
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
        $placementId = (int)MAX_getValue('campaignid', 0);

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
        if (!MAX_checkPublisher($publisherId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Use the day span selector
        $this->initDaySpanSelector();

        // Fetch campaigns
        $aPlacements = $this->getPublisherCampaigns($publisherId);

        // Cross-entity security check
        if (!isset($aPlacements[$placementId])) {
            $this->noStatsAvailable = true;
        }

        // Add standard page parameters
        $this->pageParams = array('affiliateid' => $publisherId, 'zoneid' => $zoneId);
        $this->pageParams['campaignid'] = $placementId;
        $this->pageParams['period_preset']  = MAX_getStoredValue('period_preset', 'today');
        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

        $this->loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.4.3.1';
            $this->pageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $this->pageId = '1.3.1';
            $this->pageSections = array($this->pageId);
        }

        $this->addBreadcrumbs('publisher', $publisherId);
        $this->addCrossBreadcrumbs('campaign', $placementId);

        // Add context
        $params = $this->pageParams;
        foreach ($aPlacements as $k => $v){
            $params['campaignid'] = $k;
            phpAds_PageContext (
                phpAds_buildName($k, MAX_getPlacementName($v)),
                $this->uriAddParams($this->pageName, $params, true),
                $placementId == $k
            );
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
        $aParams['placement_id'] = $placementId;

        $this->prepareHistory($aParams, 'stats.php?entity=affiliate&breakdown=daily');
    }
}

?>
