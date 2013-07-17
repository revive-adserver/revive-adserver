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
 * Statistics -> Publishers & Zones -> Campaign Distribution -> Distribution History
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Delivery_Controller_AffiliateCampaignHistory extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
        $this->breakdown = 'campaign-history';

        // This page uses the day span selector element
        $this->showDaySpanSelector = true;

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
    function OA_Admin_Statistics_Delivery_Controller_AffiliateCampaignHistory($aParams)
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
        $placementId = $this->_getId('placement', 0);

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
        $this->_checkAccess(array('publisher' => $publisherId));

        // Fetch campaigns
        $aPlacements = $this->getPublisherCampaigns($publisherId);

        // Cross-entity security check
        if (!isset($aPlacements[$placementId])) {
            $this->noStatsAvailable = true;
        }

        // Add standard page parameters
        $this->aPageParams = array(
            'affiliateid' => $publisherId,
            'campaignid'  => $placementId,
            'zoneid'      => $zoneId
        );

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // Load $_GET parameters
        $this->_loadParams();

        // HTML Framework
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $this->pageId = '2.4.3.1';
            $this->aPageSections = array($this->pageId);
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $this->pageId = '1.3.1';
            $this->aPageSections = array($this->pageId);
        }

        // Add breadcrumbs
        $this->_addBreadcrumbs('publisher', $publisherId);
        $this->addCrossBreadcrumbs('campaign', $placementId);

        // Add context
        $params = $this->aPageParams;
        foreach ($aPlacements as $k => $v){
            $params['campaignid'] = $k;
            phpAds_PageContext(
                MAX_buildName($k, MAX_getPlacementName($v)),
                $this->_addPageParamsToURI($this->pageName, $params, true),
                $placementId == $k
            );
        }

        // Add shortcuts
        if (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $this->_addShortcut(
                $GLOBALS['strAffiliateProperties'],
                'affiliate-edit.php?affiliateid='.$publisherId,
                'images/icon-affiliate.gif'
            );
        }

        // Prepare the data for display by output() method
        $aParams = array(
            'publisher_id' => $publisherId,
            'placement_id' => $placementId
        );
        $this->prepare($aParams, 'stats.php');
    }

}

?>