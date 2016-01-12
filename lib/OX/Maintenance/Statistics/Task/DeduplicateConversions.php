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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/Max.php';

require_once LIB_PATH . '/Maintenance/Statistics/Task.php';
require_once OX_PATH . '/lib/OX.php';

/**
 * The MSE process task class that de-duplicates conversions and rejects
 * conversions that have empty variable values (where a variable value
 * is set to be required).
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Statistics
 */
class OX_Maintenance_Statistics_Task_DeDuplicateConversions extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_DeDuplicateConversions
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of de-duplicating and rejecting conversions.
     */
    function run()
    {
        if ($this->oController->updateIntermediate) {

            // Preapre the start date for the de-duplication/rejection
            $oStartDate = new Date();
            $oStartDate->copy($this->oController->oLastDateIntermediate);
            $oStartDate->addSeconds(1);

            // Get the MSE DAL to perform the de-duplication
            $oServiceLocator =& OA_ServiceLocator::instance();
            $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');

            // De-duplicate conversions
            $oDal->deduplicateConversions($oStartDate, $this->oController->oUpdateIntermediateToDate);

            // Reject empty variable conversions
            $oDal->rejectEmptyVarConversions($oStartDate, $this->oController->oUpdateIntermediateToDate);

        }
    }

}

?>
