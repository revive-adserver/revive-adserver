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
 * Statistics -> Publishers & Zones -> Publisher History -> Daily Statistics
 *
 * and:
 *
 * Statistics -> Publishers & Zones -> Campaign Distribution -> Distribution Statistics -> Daily Statistics
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_Controller_AffiliateDaily extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
    public function __construct($aParams)
    {
        // Set this page's entity/breakdown values
        $this->entity = 'affiliate';
        $this->breakdown = 'daily';

        // Use the OA_Admin_Statistics_Daily helper class
        $this->useDailyClass = true;

        parent::__construct($aParams);
    }

    /**
     * The final "child" implementation of the parental abstract method.
     *
     * @see OA_Admin_Statistics_Common::start()
     */
    public function start()
    {
        // Get parameters
        $publisherId = $this->_getId('publisher');
        $placementId = $this->_getId('placement');
        $adId = $this->_getId('ad');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
        $this->_checkAccess(['publisher' => $publisherId]);

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
        $this->aPageParams = [
            'affiliateid' => $publisherId
        ];

        // Add the cross-entity parameters
        if (!empty($adId)) {
            $this->aPageParams['campaignid'] = $aAds[$adId]['placement_id'];
            $this->aPageParams['banner'] = $adId;
        } elseif (!empty($placementId)) {
            $this->aPageParams['campaignid'] = $placementId;
        }

        // Load $_GET parameters
        $this->_loadParams();

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // HTML Framework
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            if (empty($placementId) && empty($adId)) {
                $this->pageId = '2.4.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($adId) ? '2.4.3.1.1' : '2.4.3.2.1';
            }
            $this->aPageSections = [$this->pageId];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            if (empty($placementId) && empty($adId)) {
                $this->pageId = '1.1.1';
            } else {
                // Cross-entity
                $this->pageId = empty($adId) ? '1.3.1.1' : '1.3.2.1';
            }
            $this->aPageSections = [$this->pageId];
        }

        // Add breadcrumbs
        $this->_addBreadcrumbs('publisher', $publisherId);

        // Cross-entity
        if (!empty($adId)) {
            $this->addCrossBreadcrumbs('banner', $adId);
        } elseif (!empty($placementId)) {
            $this->addCrossBreadcrumbs('campaign', $placementId);
        }

        // Add shortcuts
        if (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $this->_addShortcut(
                $GLOBALS['strAffiliateProperties'],
                'affiliate-edit.php?affiliateid=' . $publisherId,
                'iconAffiliate'
            );
        }

        // Prepare the data for display by output() method
        $aParams = [
            'publisher_id' => $publisherId
        ];
        if (!empty($adId)) {
            $aParams['ad_id'] = $adId;
        } elseif (!empty($placementId)) {
            $aParams['placement_id'] = $placementId;
        }
        $this->prepare($aParams);
    }
}
