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
 * Statistics -> Global History
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Delivery_Controller_GlobalDaily extends OA_Admin_Statistics_Delivery_CommonCrossHistory
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
        $this->breakdown = 'daily';

        // Use the OA_Admin_Statistics_Daily helper class
        $this->useDailyClass = true;

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
    function OA_Admin_Statistics_Delivery_Controller_GlobalDaily($aParams)
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
        // Security check
        OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);

        // Load $_GET parameters
        $this->_loadParams();

        // Load the period preset and stats breakdown parameters
        $this->_loadPeriodPresetParam();
        $this->_loadStatsBreakdownParam();

        // HTML Framework
        $this->pageId = '2.2.1';
        $this->aPageSections = array('2.2.1');

        // Prepare the data for display by output() method
        $aParams = array();
        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $aParams['agency_id'] = OA_Permission::getAgencyId();
        }
        $this->statsBreakdown = 'hour';
        $this->prepare($aParams);
    }

}

?>