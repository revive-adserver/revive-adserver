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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsCrossHistoryController.php';



class StatsCampaignZoneHistoryController extends StatsCrossHistoryController
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
        $zoneId = (int)MAX_getValue('zoneid', '');

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
        if (!MAX_checkPlacement($advertiserId, $placementId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Use the day span selector
        $this->initDaySpanSelector();

        // Fetch campaigns
        $aZones = $this->getCampaignZones($placementId);

        // Cross-entity security check
        if (!isset($aZones[$zoneId])) {
            $this->noStatsAvailable = true;
        }

        // Add standard page parameters
        $this->pageParams = array('clientid' => $advertiserId, 'campaignid' => $placementId);
        $this->pageParams['affiliateid'] = $aZones[$zoneId]['publisher_id'];
        $this->pageParams['zoneid'] = $zoneId;
        $this->pageParams['period_preset']  = MAX_getStoredValue('period_preset', 'today');
        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

        $this->loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.1.2.3.2';
            $this->pageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Client)) {
            $this->pageId = '1.2.3.2';
            $this->pageSections = array($this->pageId);
        }

        $this->addBreadcrumbs('campaign', $placementId);
        $this->addCrossBreadcrumbs('zone', $zoneId);

        // Add context
        $params = $this->pageParams;
        foreach ($aZones as $k => $v){
            $params['affiliateid'] = $aZones[$k]['publisher_id'];
            $params['zoneid'] = $k;
            phpAds_PageContext (
                phpAds_buildName($k, MAX_getZoneName($v['name'], null, $v['anonymous'], $k)),
                $this->uriAddParams($this->pageName, $params, true),
                $zoneId == $k
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
        $aParams['zone_id']      = $zoneId;

        $this->prepareHistory($aParams, 'stats.php?entity=campaign&breakdown=daily');
    }

}

?>
