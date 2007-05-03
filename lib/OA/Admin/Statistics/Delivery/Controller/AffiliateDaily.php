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
 * Statistics -> Publishers & Zones -> Publisher History -> Daily Statistics
 *
 * and:
 *
 * Statistics -> Publishers & Zones -> Campaign Distribution -> Distribution History -> Daily Statistics
 *
 * @package    OpenadsAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Delivery_Controller_AffiliateDaily extends OA_Admin_Statistics_Delivery_CommonDaily
{

    /**
     * The final "child" implementation of the PHP5-style constructor.
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function __construct($aParams)
    {
        // Set this page's entity/breakdown values
        $this->entity    = 'affiliate';
        $this->breakdown = 'daily';

        parent::__construct($aParams);
    }

    /**
     * PHP4-style constructor
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function OA_Admin_Statistics_Delivery_Controller_AffiliateDaily($aParams)
    {
        $this->__construct($aParams);
    }

    /**
     * The final "child" implementation of the parental abstract method.
     *
     * @see OA_Admin_Statistics_Common::start()
     */
    function start()
    {
        // Get parameters
        $publisherId = $this->_getId('publisher');
        $placementId = $this->_getId('placement');
        $adId        = $this->_getId('ad');

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
        $this->_checkAccess(array('publisher' => $publisherId));

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
            $this->aPageSections = array($this->pageId);
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            if (empty($placementId) && empty($adId)) {
                $this->pageId = '1.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($adId) ? '1.3.1.1' : '1.3.2.1';
            }
            $this->aPageSections = array($this->pageId);
        }

        // Add standard page parameters
        $this->aPageParams = array('affiliateid' => $publisherId);
        $this->aPageParams['period_preset']  = MAX_getStoredValue('period_preset', 'today');
        $this->aPageParams['statsBreakdown'] = MAX_getStoredValue('statsBreakdown', 'history');
        $this->aPageParams['day']           = MAX_getValue('day', '');

        // Cross-entity
        if (!empty($adId)) {
            $this->aPageParams['campaignid'] = $aAds[$adId]['placement_id'];
            $this->aPageParams['banner']     = $adId;
        } elseif (!empty($placementId)) {
            $this->aPageParams['campaignid'] = $placementId;
        }

        $this->_loadParams();

        $this->_addBreadcrumbs('publisher', $publisherId);

        // Cross-entity
        if (!empty($adId)) {
            $this->addCrossBreadcrumbs('banner', $adId);
        } elseif (!empty($placementId)) {
            $this->addCrossBreadcrumbs('campaign', $placementId);
        }

        // Add shortcuts
        if (!phpAds_isUser(phpAds_Affiliate)) {
            $this->_addShortcut(
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

        $this->prepare($aParams);
    }

}

?>