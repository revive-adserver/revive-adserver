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
 * Statistics -> Advertisers & Campaigns -> Campaigns -> Publisher Distribution -> Distribution Statistics
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_Controller_CampaignZoneHistory extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
        $this->entity = 'campaign';
        $this->breakdown = 'zone-history';

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
        $placementId = $this->_getId('placement');
        $zoneId = $this->_getId('zone');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
        $this->_checkAccess(['advertiser' => $advertiserId, 'placement' => $placementId]);

        // Fetch campaigns
        $aZones = $this->getCampaignZones($placementId);

        // Cross-entity security check
        if (!isset($aZones[$zoneId])) {
            $this->noStatsAvailable = true;
        }

        // Add standard page parameters
        $this->aPageParams = [
            'clientid' => $advertiserId,
            'campaignid' => $placementId,
            'affiliateid' => $aZones[$zoneId]['publisher_id'],
            'zoneid' => $zoneId,
        ];

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // Load $_GET parameters
        $this->_loadParams();

        // HTML Framework
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $this->pageId = '2.1.2.3.2';
            $this->aPageSections = [$this->pageId];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $this->pageId = '1.2.3.2';
            $this->aPageSections = [$this->pageId];
        }

        // Add breadcrumbs
        $this->_addBreadcrumbs('campaign', $placementId);
        $this->addCrossBreadcrumbs('zone', $zoneId);

        // Add context
        $params = $this->aPageParams;
        foreach ($aZones as $k => $v) {
            $params['affiliateid'] = $aZones[$k]['publisher_id'];
            $params['zoneid'] = $k;
            phpAds_PageContext(
                MAX_buildName($k, MAX_getZoneName($v['name'], null, $v['anonymous'], $k)),
                $this->_addPageParamsToURI($this->pageName, $params, true),
                $zoneId == $k,
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
        $this->_addShortcut(
            $GLOBALS['strCampaignProperties'],
            'campaign-edit.php?clientid=' . $advertiserId . '&campaignid=' . $placementId,
            'iconCampaign',
        );

        // Prepare the data for display by output() method
        $aParams = [
            'placement_id' => $placementId,
            'zone_id' => $zoneId,
        ];
        $this->prepare($aParams, 'stats.php');
    }
}
