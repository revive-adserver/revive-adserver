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
 * Statistics -> Publishers & Zones -> Campaign Distribution
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Delivery_Controller_AffiliateCampaigns extends OA_Admin_Statistics_Delivery_CommonCrossEntity
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
        $this->breakdown = 'campaigns';

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
    function OA_Admin_Statistics_Delivery_Controller_AffiliateCampaigns($aParams)
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
        // Get the preferences
        $aPref = $GLOBALS['_MAX']['PREF'];

        // Get parameters
        $publisherId = $this->_getId('publisher');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
        $this->_checkAccess(array('publisher' => $publisherId));

        // Add standard page parameters
        $this->aPageParams = array(
            'affiliateid' => $publisherId
        );

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // Load $_GET parameters
        $this->_loadParams();

        // HTML Framework
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $this->pageId = '2.4.3';
            $this->aPageSections = array('2.4.1', '2.4.2', '2.4.3');
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $this->pageId = '1.3';
            $this->aPageSections = array('1.1', '1.2', '1.3');
        }

        // Add breadcrumbs
        $this->_addBreadcrumbs('publisher', $publisherId);

        // Add context
        $this->aPageContext = array('publishers', $publisherId);

        // Add shortcuts
        if (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $this->_addShortcut(
                $GLOBALS['strAffiliateProperties'],
                'affiliate-edit.php?affiliateid='.$publisherId,
                'images/icon-affiliate.gif'
            );
        }




        // Fix entity links
        $this->entityLinks['c'] = 'stats.php?entity=affiliate&breakdown=campaign-history';
        $this->entityLinks['b'] = 'stats.php?entity=affiliate&breakdown=banner-history';

        $this->hideInactive = MAX_getStoredValue('hideinactive', ($aPref['ui_hide_inactive'] == true), null, true);
        $this->showHideInactive = true;

        $this->startLevel = MAX_getStoredValue('startlevel', 0, null, true);

        // Init nodes
        $this->aNodes   = MAX_getStoredArray('nodes', array());
        $expand         = MAX_getValue('expand', '');
        $collapse       = MAX_getValue('collapse');

        // Adjust which nodes are opened closed...
        MAX_adjustNodes($this->aNodes, $expand, $collapse);

        $aParams = $this->coreParams;
        $aParams['publisher_id'] = $publisherId;

        // Limit by advertiser
        $advertiserId = (int)MAX_getValue('clientid', '');
        if (!empty($advertiserId)) {
            $aParams['advertiser_id'] = $advertiserId;
        }

        // Limit by advertiser
        $advertiserId = (int)MAX_getValue('clientid', '');
        if (!empty($advertiserId)) {
            $aParams['advertiser_id'] = $advertiserId;
        }

        switch ($this->startLevel)
        {
            case 1:
                $this->aEntitiesData = $this->getBanners($aParams, $this->startLevel, $expand, true);
                break;
            default:
                $this->startLevel = 0;
                $this->aEntitiesData = $this->getCampaigns($aParams, $this->startLevel, $expand);
                break;
        }

        // Summarise the values into a the totals array, & format
        $this->_summariseTotalsAndFormat($this->aEntitiesData);

        $this->showHideLevels = array();
        switch ($this->startLevel)
        {
            case 1:
                $this->showHideLevels = array(
                    0 => array('text' => $GLOBALS['strShowParentCampaigns'], 'icon' => 'images/icon-campaign.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveBannersHidden']}";
                break;
            case 0:
                $this->showHideLevels = array(
                    1 => array('text' => $GLOBALS['strHideParentCampaigns'], 'icon' => 'images/icon-campaign-d.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveCampaignsHidden']}";
                break;
        }


        // Save prefs
        $this->aPagePrefs['startlevel']     = $this->startLevel;
        $this->aPagePrefs['nodes']          = implode (",", $this->aNodes);
        $this->aPagePrefs['hideinactive']   = $this->hideInactive;
        $this->aPagePrefs['startlevel']     = $this->startLevel;
    }

}

?>