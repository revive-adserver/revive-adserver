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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonCrossEntity.php';

/**
 * The class to display the delivery statistcs for the page:
 *
 * Statistics -> Advertisers & Campaigns -> Campaigns -> Publisher Distribution
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_Controller_CampaignAffiliates extends OA_Admin_Statistics_Delivery_CommonCrossEntity
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
        $this->breakdown = 'affiliates';

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
        // Get the preferences
        $aPref = $GLOBALS['_MAX']['PREF'];

        // Get parameters
        $advertiserId = $this->_getId('advertiser');
        $placementId = $this->_getId('placement');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
        $this->_checkAccess(['advertiser' => $advertiserId, 'placement' => $placementId]);

        // Add standard page parameters
        $this->aPageParams = [
            'clientid' => $advertiserId,
            'campaignid' => $placementId
        ];

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // Load $_GET parameters
        $this->_loadParams();

        // HTML Framework
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $this->pageId = '2.1.2.3';
            $this->aPageSections = ['2.1.2.1', '2.1.2.2', '2.1.2.3', '2.1.2.4'];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $this->pageId = '1.2.3';
            $this->aPageSections = ['1.2.1', '1.2.2', '1.2.3'];
        }

        // Add breadcrumbs
        $this->_addBreadcrumbs('campaign', $placementId);

        // Add shortcuts
        if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $this->_addShortcut(
                $GLOBALS['strClientProperties'],
                'advertiser-edit.php?clientid=' . $advertiserId,
                'iconAdvertiser'
            );
        }
        $this->_addShortcut(
            $GLOBALS['strCampaignProperties'],
            'campaign-edit.php?clientid=' . $advertiserId . '&campaignid=' . $placementId,
            'iconCampaign'
        );




        // Fix entity links
        $this->entityLinks['p'] = 'stats.php?entity=campaign&breakdown=affiliate-history';
        $this->entityLinks['z'] = 'stats.php?entity=campaign&breakdown=zone-history';

        $this->hideInactive = MAX_getStoredValue('hideinactive', ($aPref['ui_hide_inactive'] == true), null, true);
        $this->showHideInactive = true;

        $this->startLevel = MAX_getStoredValue('startlevel', 0, null, true);

        // Init nodes
        $this->aNodes = MAX_getStoredArray('nodes', []);
        $expand = MAX_getValue('expand', '');
        $collapse = MAX_getValue('collapse');

        // Adjust which nodes are opened closed...
        MAX_adjustNodes($this->aNodes, $expand, $collapse);

        $aParams = $this->coreParams;
        $aParams['placement_id'] = $placementId;

        switch ($this->startLevel) {
            case 1:
                $this->aEntitiesData = $this->getZones($aParams, $this->startLevel, $expand);
                break;
            default:
                $this->startLevel = 0;
                $this->aEntitiesData = $this->getPublishers($aParams, $this->startLevel, $expand);
                break;
        }

        // Summarise the values into a the totals array, & format
        $this->_summariseTotalsAndFormat($this->aEntitiesData);

        $this->showHideLevels = [];
        switch ($this->startLevel) {
            case 1:
                $this->showHideLevels = [
                    0 => ['text' => $GLOBALS['strShowParentAffiliates'], 'icon' => 'images/icon-affiliate.gif'],
                ];
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveZonesHidden']}";
                break;
            case 0:
                $this->showHideLevels = [
                    1 => ['text' => $GLOBALS['strHideParentAffiliates'], 'icon' => 'images/icon-affiliate-d.gif'],
                ];
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveAffiliatesHidden']}";
                break;
        }


        // Save prefs
        $this->aPagePrefs['startlevel'] = $this->startLevel;
        $this->aPagePrefs['nodes'] = implode(",", $this->aNodes);
        $this->aPagePrefs['hideinactive'] = $this->hideInactive;
    }
}
