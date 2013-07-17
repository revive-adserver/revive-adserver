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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonEntity.php';

/**
 * The class to display the delivery statistcs for the page:
 *
 * Statistics -> Advertisers & Campaigns
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Delivery_Controller_GlobalAdvertiser extends OA_Admin_Statistics_Delivery_CommonEntity
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
        $this->entity    = 'global';
        $this->breakdown = 'advertiser';

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
    function OA_Admin_Statistics_Delivery_Controller_GlobalAdvertiser($aParams)
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

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);

        // HTML Framework
        $this->pageId = '2.1';
        $this->aPageSections = array('2.1', '2.4', '2.2');

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
        if (!OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $aParams['agency_id'] = OA_Permission::getAgencyId();
        }
        switch ($this->startLevel)
        {
            case 2:
                $this->aEntitiesData = $this->getBanners($aParams, $this->startLevel, $expand);
                break;
            case 1:
                $this->aEntitiesData = $this->getCampaigns($aParams, $this->startLevel, $expand);
                break;
            default:
                $this->startLevel = 0;
                $this->aEntitiesData = $this->getAdvertisers($aParams, $this->startLevel, $expand);
                break;
        }

        // Summarise the values into a the totals array, & format
        $this->_summariseTotalsAndFormat($this->aEntitiesData);

        
        $this->showHideLevels = array();
        switch ($this->startLevel)
        {
            case 2:
                $this->showHideLevels = array(
                    0 => array('text' => $GLOBALS['strShowParentAdvertisers'], 'icon' => 'images/icon-advertiser.gif'),
                    1 => array('text' => $GLOBALS['strShowParentCampaigns'], 'icon' => 'images/icon-campaign.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveBannersHidden']}";
                break;
            case 1:
                $this->showHideLevels = array(
                    0 => array('text' => $GLOBALS['strShowParentAdvertisers'], 'icon' => 'images/icon-advertiser.gif'),
                    2 => array('text' => $GLOBALS['strHideParentCampaigns'], 'icon' => 'images/icon-campaign-d.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveCampaignsHidden']}";
                break;
            case 0:
                $this->showHideLevels = array(
                    1 => array('text' => $GLOBALS['strHideParentAdvertisers'], 'icon' => 'images/icon-advertiser-d.gif'),
                    2 => array('text' => $GLOBALS['strHideParentCampaigns'], 'icon' => 'images/icon-campaign-d.gif')
                );
                $this->hiddenEntitiesText = "{$this->hiddenEntities} {$GLOBALS['strInactiveAdvertisersHidden']}";
                break;
        }

        // Location params
        $this->aPageParams['period_preset']  = MAX_getStoredValue('period_preset', 'today');
        $this->aPageParams['statsBreakdown'] = htmlspecialchars(MAX_getStoredValue('statsBreakdown', 'day'));
        $this->aPageParams['period_start']   = htmlspecialchars(MAX_getStoredValue('period_start', date('Y-m-d')));
        $this->aPageParams['period_end']     = htmlspecialchars(MAX_getStoredValue('period_end', date('Y-m-d')));
        $this->_loadParams();

        unset($this->aPageParams['expand']);
        unset($this->aPageParams['clientid']);
        unset($this->aPageParams['collapse']);

        // Save preferences
        $this->aPagePrefs['startlevel']   = $this->startLevel;
        $this->aPagePrefs['nodes']        = implode (",", $this->aNodes);
        $this->aPagePrefs['hideinactive'] = $this->hideInactive;
        $this->aPagePrefs['startlevel']   = $this->startLevel;
    }

}

?>
