<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonDaily.php';

/**
 * The class to display the delivery statistcs for the page:
 *
 * Statistics -> Advertisers & Campaigns -> Campaign Overview -> Campaign History -> Daily Statistics
 *
 * and:
 *
 * Statistics -> Advertisers & Campaigns -> Campaign Overview -> Publisher Distribution -> Distribution History -> Daily Statistics
 *
 * @package    OpenadsAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Delivery_Controller_CampaignDaily extends OA_Admin_Statistics_Delivery_CommonDaily
{

    /**
     * The final "child" implementation of the parental abstract method.
     *
     * @see OA_Admin_Statistics_Common::start()
     */
    function start()
    {
        // Get parameters
        $advertiserId = $this->_getId('advertiser');
        $placementId  = $this->_getId('placement');
        $publisherId  = $this->_getId('publisher');
        $zoneId       = $this->_getId('zone');

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
        $this->_checkAccess(array('advertiser' => $advertiserId, 'placement' => $placementId));

        if (!empty($zoneId)) {
            // Fetch banners
            $aZones = $this->getCampaignZones($placementId);

            // Cross-entity security check
            if (!isset($aZones[$zoneId])) {
                $this->noStatsAvailable = true;
            }
        } elseif (!empty($publisherId)) {
            // Fetch campaigns
            $aPublishers = $this->getCampaignPublishers($placementId);

            // Cross-entity security check
            if (!isset($aPublishers[$publisherId])) {
                $this->noStatsAvailable = true;
            }
        }

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            if (empty($publisherId) && empty($zoneId)) {
                $this->pageId = '2.1.2.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($zoneId) ? '2.1.2.3.1.1' : '2.1.2.3.2.1';
            }
            $this->aPageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Client)) {
            if (empty($publisherId) && empty($zoneId)) {
                $this->pageId = '1.2.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($zoneId) ? '1.2.3.1.1' : '1.2.3.2.1';
            }
            $this->aPageSections = array($this->pageId);
        }

        // Add standard page parameters
        $this->aPageParams = array('clientid' => $advertiserId, 'campaignid' => $placementId,
                                  'entity' => 'campaign', 'breakdown' => 'daily');
        $this->aPageParams['period_preset'] = MAX_getStoredValue('period_preset', 'today');
        $this->aPageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'day');
        $this->aPageParams['day']           = MAX_getValue('day', '');

        // Cross-entity
        if (!empty($zoneId)) {
            $this->aPageParams['affiliateid'] = $aZones[$zoneId]['publisher_id'];
            $this->aPageParams['zoneid']      = $zoneId;
        } elseif (!empty($publisherId)) {
            $this->aPageParams['affiliateid'] = $publisherId;
        }

        $this->_loadParams();

        $this->_addBreadcrumbs('campaign', $placementId);

        // Cross-entity
        if (!empty($zoneId)) {
            $this->addCrossBreadcrumbs('zone', $zoneId);
        } elseif (!empty($publisherId)) {
            $this->addCrossBreadcrumbs('publisher', $publisherId);
        }

        // Add shortcuts
        if (!phpAds_isUser(phpAds_Client)) {
            $this->_addShortcut(
                $GLOBALS['strClientProperties'],
                'advertiser-edit.php?clientid='.$advertiserId,
                'images/icon-advertiser.gif'
            );
        }
        $this->_addShortcut(
            $GLOBALS['strCampaignProperties'],
            'campaign-edit.php?clientid='.$advertiserId.'&campaignid='.$placementId,
            'images/icon-campaign.gif'
        );

        $aParams = array();
        $aParams['placement_id'] = $placementId;

        // Cross-entity
        if (!empty($zoneId)) {
            $aParams['zone_id'] = $zoneId;
        } elseif (!empty($publisherId)) {
            $aParams['publisher_id'] = $publisherId;
        }

        $this->prepare($aParams);
    }

}

?>