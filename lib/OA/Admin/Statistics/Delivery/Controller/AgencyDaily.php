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
 * Statistics -> Accounts -> Daily Statistics
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_Controller_AgencyDaily extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
        $this->entity = 'agency';
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
        $agencyId = $this->_getId('agency');

        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

        // Add standard page parameters
        $this->aPageParams = ['agencyid' => $agencyId];

        // Load $_GET parameters
        $this->_loadParams();

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // HTML Framework
        $this->pageId = '2.9.1.1';
        $this->aPageSections = [$this->pageId];

        // Add breadcrumbs
        $this->_addBreadcrumbs('agency', $agencyId);

        // Add shortcuts
        $this->_addShortcut(
            $GLOBALS['strAgencyProperties'],
            'agency-edit.php?agencyid=' . $agencyId,
            'iconAgency',
        );

        // Prepare the data for display by output() method
        $aParams = [
            'agency_id' => $agencyId,
        ];
        $this->prepare($aParams);
    }
}
