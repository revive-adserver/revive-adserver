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
 * Statistics -> Accounts
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_Controller_GlobalAgency extends OA_Admin_Statistics_Delivery_CommonEntity
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
        $this->entity = 'global';
        $this->breakdown = 'agency';

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

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

        // HTML Framework
        $this->pageId = '2.9';
        $this->aPageSections = ['2.4', '2.9'];

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

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        $this->_loadParams();

        $this->aEntitiesData = $this->getAgencies($aParams);

        // Summarise the values into the totals array, & format
        $this->_summariseTotalsAndFormat($this->aEntitiesData);

        // Location params
        $this->aPageParams['period_preset'] = MAX_getStoredValue('period_preset', 'today');
        $this->aPageParams['statsBreakdown'] = htmlspecialchars(MAX_getStoredValue('statsBreakdown', 'day'));
        $this->aPageParams['period_start'] = htmlspecialchars(MAX_getStoredValue('period_start', date('Y-m-d')));
        $this->aPageParams['period_end'] = htmlspecialchars(MAX_getStoredValue('period_end', date('Y-m-d')));
        $this->_loadParams();

        // Save preferences
        $this->aPagePrefs['hideinactive'] = $this->hideInactive;
    }
}
