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



class StatsZoneBannerHistoryController extends StatsCrossHistoryController
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
        $zoneId      = (int)MAX_getValue('zoneid', '');

        // Cross-entity
        $adId = (int)MAX_getValue('bannerid', 0);

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
        if (!MAX_checkZone($publisherId, $zoneId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Use the day span selector
        $this->initDaySpanSelector();

        // Fetch campaigns
        $aAds = $this->getZoneBanners($zoneId);

        // Cross-entity security check
        if (!isset($aAds[$adId])) {
            $this->noStatsAvailable = true;
        }

        // Add standard page parameters
        $this->pageParams = array('affiliateid' => $publisherId, 'zoneid' => $zoneId,
                                  'entity' => 'zone', 'breakdown' => 'banner-history'
                                 );
        $this->pageParams['campaignid'] = $aAds[$adId]['placement_id'];
        $this->pageParams['bannerid']   = $adId;
        $this->pageParams['period_preset'] = MAX_getStoredValue('period_preset', 'today');
        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

        $this->loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.4.2.2.2';
            $this->pageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $this->pageId = '1.2.2.2';
            $this->pageSections = array($this->pageId);
        }

        $this->addBreadcrumbs('zone', $zoneId);
        $this->addCrossBreadcrumbs('banner', $adId);

        // Add context
        $params = $this->pageParams;
        foreach ($aAds as $k => $v){
            $params['campaignid'] = $v['placement_id'];
            $params['bannerid'] = $k;
            phpAds_PageContext (
                phpAds_buildName($k, MAX_getAdName($v['name'], null, null, $v['anonymous'], $k)),
                $this->uriAddParams($this->pageName, $params, true),
                $adId == $k
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

        $this->addShortcut(
            $GLOBALS['strZoneProperties'],
            'zone-edit.php?affiliateid='.$publisherId.'&zoneid='.$zoneId,
            'images/icon-zone.gif'
        );

        $aParams = array();
        $aParams['zone_id'] = $zoneId;
        $aParams['ad_id'] = $adId;


        $this->pageParams['breakdown'] = 'daily';

        $this->prepareHistory($aParams, 'stats.php');

        $this->pageParams['breakdown'] = 'banner-history';
    }
}

?>
