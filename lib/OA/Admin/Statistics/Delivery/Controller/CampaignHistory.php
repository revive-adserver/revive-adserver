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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonHistory.php';

/**
 * The class to display the delivery statistcs for the page:
 *
 * Statistics -> Advertisers & Campaigns -> Campaigns -> Campaign Statistics
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_Controller_CampaignHistory extends OA_Admin_Statistics_Delivery_CommonHistory
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
        $this->entity    = 'campaign';
        $this->breakdown = 'history';

        // This page uses the day span selector element
        $this->showDaySpanSelector = true;

        parent::__construct($aParams);
    }

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

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
        $this->_checkObjectsExist($advertiserId, $placementId);
        $this->_checkAccess(array('advertiser' => $advertiserId, 'placement' => $placementId));

        // Add standard page parameters
        $this->aPageParams = array(
            'clientid'   => $advertiserId,
            'campaignid' => $placementId
        );

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // Load $_GET parameters
        $this->_loadParams();

        // HTML Framework
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $this->pageId = '2.1.2.1';
            $this->aPageSections = array('2.1.2.1', '2.1.2.2', '2.1.2.3', '2.1.2.4');
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $this->pageId = '1.2.1';
            $this->aPageSections = array('1.2.1', '1.2.2', '1.2.3');
        }

        // Add breadcrumbs
        $this->_addBreadcrumbs('campaign', $placementId);

        // Add context
        $this->aPageContext = array('campaigns', $placementId);

        // Add shortcuts
        if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $this->_addShortcut(
                $GLOBALS['strClientProperties'],
                'advertiser-edit.php?clientid='.$advertiserId,
                'iconAdvertiser'
            );
        }
        $this->_addShortcut(
            $GLOBALS['strCampaignProperties'],
            'campaign-edit.php?clientid='.$advertiserId.'&campaignid='.$placementId,
            'iconCampaign'
        );

        // Prepare the data for display by output() method
        $aParams = array(
            'placement_id' => $placementId
        );
        $this->prepare($aParams, 'stats.php');

    }

    /**
     * Function check if advertiser or placement exists
     * if not: display proper error message
     * Error message contains link to:
     * - advertiser summary statistics if campaign does not exists
     * - stats.php if advertiser does not exists
     *
     * @param int $advertiserId Advertiser Id
     * @param int $placementId  Placement Id (Campaign Id)
     */
    function _checkObjectsExist($advertiserId, $placementId)
    {
        // Check if placement (campaign) exist
        if (0 == count(Admin_DA::getPlacements(
                $this->coreParams +
                array(  'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId)))) {
            phpAds_PageHeader('2');
            // Check if advertiser (clientid) exist
            if (0 == count(Admin_DA::getPlacements(
                $this->coreParams +
                    array(  'advertiser_id' => $advertiserId)))) {
                phpAds_Die($GLOBALS['strDeadLink'], str_replace('{link}', 'stats.php', $GLOBALS['strNoAdvertiser']));
            } else {
                $link = "stats.php?".htmlspecialchars(preg_replace('#campaignid=[0-9]*&?#', '', $_SERVER['QUERY_STRING']), ENT_QUOTES);
                phpAds_Die($GLOBALS['strDeadLink'], str_replace('{link}', $link, $GLOBALS['strNoPlacement']));
            }
        }
    }
}

?>