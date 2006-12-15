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
$Id: AdvertiserAffiliates.php 4632 2006-04-06 15:49:36Z matteo@beccati.com $
*/

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsCrossHistoryController.php';



class StatsCampaignAffiliateHistoryController extends StatsCrossHistoryController
{
    function start()
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // Get parameters
        if (phpAds_isUser(phpAds_Client)) {
            $advertiserId = phpAds_getUserId();
        } else {
            $advertiserId = (int)MAX_getValue('clientid', '');
        }
        $placementId   = (int)MAX_getValue('campaignid', '');

        // Cross-entity
        $publisherId = (int)MAX_getValue('affiliateid', '');

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
        if (!MAX_checkPlacement($advertiserId, $placementId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Use the day span selector
        $this->initDaySpanSelector();

        // Fetch campaigns
        $aPublishers = $this->getCampaignPublishers($placementId);

        // Cross-entity security check
        if (!isset($aPublishers[$publisherId])) {
            $this->noStatsAvailable = true;
        }

        // Add standard page parameters
        $this->pageParams = array('clientid' => $advertiserId, 'campaignid' => $placementId);
        $this->pageParams['affiliateid'] = $publisherId;
        $this->pageParams['period_preset']  = MAX_getStoredValue('period_preset', 'today');
        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

        $this->loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.1.2.3.1';
            $this->pageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Client)) {
            $this->pageId = '1.2.3.1';
            $this->pageSections = array($this->pageId);
        }

        $this->addBreadcrumbs('campaign', $placementId);
        $this->addCrossBreadcrumbs('publisher', $publisherId);

        // Add context
        $params = $this->pageParams;
        foreach ($aPublishers as $k => $v){
            $params['affiliateid'] = $k;
            phpAds_PageContext (
                phpAds_buildName($k, MAX_getPublisherName($v['name'], null, $v['anonymous'], $k)),
                $this->uriAddParams($this->pageName, $params, true),
                $publisherId == $k
            );
        }

        // Add shortcuts
        if (!phpAds_isUser(phpAds_Client)) {
            $this->addShortcut(
                $GLOBALS['strClientProperties'],
                'advertiser-edit.php?clientid='.$advertiserId,
                'images/icon-advertiser.gif'
            );
        }
        $this->addShortcut(
            $GLOBALS['strCampaignProperties'],
            'campaign-edit.php?clientid='.$advertiserId.'&campaignid='.$placementId,
            'images/icon-campaign.gif'
        );

        $aParams = array();
        $aParams['placement_id'] = $placementId;
        $aParams['publisher_id'] = $publisherId;

        $this->prepareHistory($aParams, 'stats.php?entity=campaign&breakdown=daily');
    }

}

?>
