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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Maintenance/Statistics/Task.php';

/**
 * The MSE process task class that manages (migrates) conversions, as
 * required, during the MSE run.
 *
 * @TODO Deprecate, when conversion data is no longer required in the
 *       old format intermediate and summary tables.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 */
class OX_Maintenance_Statistics_Task_ManageConversions extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_ManageConversions
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of managing conversions.
     */
    function run()
    {
        if ($this->oController->updateIntermediate) {

            // Preapre the start date for the management of conversions
            $oStartDate = new Date();
            $oStartDate->copy($this->oController->oLastDateIntermediate);
            $oStartDate->addSeconds(1);

            // Get the MSE DAL to perform the conversion management
            $oServiceLocator =& OA_ServiceLocator::instance();
            $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');

            // Manage conversions
            $oDal->manageConversions($oStartDate, $this->oController->oUpdateIntermediateToDate);

        }
    }

}

?>