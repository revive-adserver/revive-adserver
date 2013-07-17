<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonCrossHistory.php';

/**
 * The class to display the delivery statistcs for the page:
 *
 * Statistics -> Publishers & Zones -> Zones -> Zone History -> Daily Statistics
 *
 * and:
 *
 * Statistics -> Publishers & Zones -> Zones -> Campaign Distribution -> Distribution History -> Daily Statistics
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Delivery_Controller_ZoneDaily extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
        $this->entity    = 'zone';
        $this->breakdown = 'daily';

        // Use the OA_Admin_Statistics_Daily helper class
        $this->useDailyClass = true;

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
    function OA_Admin_Statistics_Delivery_Controller_ZoneDaily($aParams)
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
        $zoneId      = $this->_getId('zone');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
        $this->_checkAccess(array('publisher' => $publisherId, 'zone' => $zoneId));

        // Cross-entity security check
        if (!empty($adId)) {
            $aAds = $this->getPublisherBanners($publisherId);
            if (!isset($aAds[$adId])) {
                $this->noStatsAvailable = true;
            }
        } elseif (!empty($placementId)) {
            $aPlacements = $this->getPublisherCampaigns($publisherId);
            if (!isset($aPlacements[$placementId])) {
                $this->noStatsAvailable = true;
            }
        }

        // Add standard page parameters
        $this->aPageParams = array(
            'affiliateid' => $publisherId,
            'zoneid'      => $zoneId
        );

        // Add the cross-entity parameters
        if (!empty($adId)) {
            $this->aPageParams['campaignid'] = $aAds[$adId]['placement_id'];
            $this->aPageParams['banner']     = $adId;
        } elseif (!empty($placementId)) {
            $this->aPageParams['campaignid'] = $placementId;
        }

        // Load $_GET parameters
        $this->_loadParams();

        // HTML Framework
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            if (empty($placementId) && empty($adId)) {
                $this->pageId = '2.4.2.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($adId) ? '2.4.2.2.1.1' : '2.4.2.2.2.1';
            }
            $this->aPageSections = array($this->pageId);
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            if (empty($placementId) && empty($adId)) {
                $this->pageId = '1.2.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($adId) ? '1.2.2.1.1' : '1.2.2.2.1';
            }
            $this->aPageSections = array($this->pageId);
        }

        // Add breadcrumbs
        $this->_addBreadcrumbs('zone', $zoneId);
        if (!empty($adId)) {
            $this->addCrossBreadcrumbs('banner', $adId);
        } elseif (!empty($placementId)) {
            $this->addCrossBreadcrumbs('campaign', $placementId);
        }

        // Add shortcuts
        if (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $this->_addShortcut(
                $GLOBALS['strAffiliateProperties'],
                'affiliate-edit.php?affiliateid='.$publisherId,
                'images/icon-affiliate.gif'
            );
        }
        $this->_addShortcut(
            $GLOBALS['strZoneProperties'],
            'zone-edit.php?affiliateid='.$publisherId.'&zoneid='.$zoneId,
            'images/icon-zone.gif'
        );

        // Prepare the data for display by output() method
        $aParams = array(
            'zone_id' => $zoneId
        );
        if (!empty($adId)) {
            $aParams['ad_id'] = $adId;
        } elseif (!empty($placementId)) {
            $aParams['placement_id'] = $placementId;
        }
        $this->prepare($aParams);
    }

}

?>