<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsHistoryController.php';



class StatsCampaignHistoryController extends StatsHistoryController
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

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
        if (!MAX_checkPlacement($advertiserId, $placementId)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }

        // Add standard page parameters
        $this->pageParams = array('clientid' => $advertiserId, 'campaignid' => $placementId,
                                  'entity' => 'campaign', 'breakdown' => 'history');

        $this->loadParams();

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.1.2.1';
            $this->pageSections = array('2.1.2.1', '2.1.2.2', '2.1.2.3');
        } elseif (phpAds_isUser(phpAds_Client)) {
            $this->pageId = '1.2.1';
            $this->pageSections = array('1.2.1', '1.2.2', '1.2.3');
        }

        $this->addBreadcrumbs('campaign', $placementId);

        // Add context
        $this->pageContext = array('campaigns', $placementId);

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

        // Use the day span selector
        $this->initDaySpanSelector();

        $aParams = array();
        $aParams['placement_id'] = $placementId;

        $this->pageParams['entity']    = 'campaign';
        $this->pageParams['breakdown'] = 'daily';


        $this->prepareHistory($aParams, 'stats.php');

        $this->pageParams = array('clientid' => $advertiserId, 'campaignid' => $placementId,
                                  'entity' => 'campaign', 'breakdown' => 'history');

        $this->loadParams();
//        $this->pageParams['period_preset'] = MAX_getStoredValue('period_preset', 'today');
//        $this->pageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');

    }
}

?>
