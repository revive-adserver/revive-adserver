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
 * Statistics -> Advertisers & Campaigns -> Publisher Distribution -> Distribution Statistics
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_Controller_AdvertiserAffiliateHistory extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
        $this->entity = 'advertiser';
        $this->breakdown = 'affiliate-history';

        // This page uses the day span selector element
        $this->showDaySpanSelector = true;

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
        $advertiserId = $this->_getId('advertiser');
        $publisherId = $this->_getId('publisher');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
        $this->_checkAccess(['advertiser' => $advertiserId]);

        // Cross-entity security check
        if (!empty($advertiserId)) {
            $aPublishers = $this->getAdvertiserPublishers($advertiserId);
            if (!isset($aPublishers[$publisherId])) {
                $this->noStatsAvailable = true;
            }
        }

        // Add standard page parameters
        $this->aPageParams = [
            'clientid' => $advertiserId,
            'affiliateid' => $publisherId,
        ];

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // Load $_GET parameters
        $this->_loadParams();

        // HTML Framework
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $this->pageId = '2.1.3.1';
            $this->aPageSections = [$this->pageId];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $this->pageId = '1.3.1';
            $this->aPageSections = [$this->pageId];
        }

        // Add breadcrumbs
        $this->_addBreadcrumbs('advertiser', $advertiserId);
        $this->addCrossBreadcrumbs('publisher', $publisherId);

        // Add context
        $params = $this->aPageParams;
        foreach ($aPublishers as $k => $v) {
            $params['affiliateid'] = $k;
            phpAds_PageContext(
                MAX_buildName($k, MAX_getPublisherName($v['name'], null, $v['anonymous'], $k)),
                $this->_addPageParamsToURI($this->pageName, $params, true),
                $publisherId == $k,
            );
        }

        // Add shortcuts
        if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $this->_addShortcut(
                $GLOBALS['strClientProperties'],
                'advertiser-edit.php?clientid=' . $advertiserId,
                'iconAdvertiser',
            );
        }

        // Prepare the data for display by output() method
        $aParams = [
            'advertiser_id' => $advertiserId,
            'publisher_id' => $publisherId,
        ];
        $this->prepare($aParams, 'stats.php');
    }
}
