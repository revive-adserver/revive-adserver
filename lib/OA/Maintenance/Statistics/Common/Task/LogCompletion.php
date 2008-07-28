<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/Max.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Common.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/Common/Task.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once OX_PATH . '/lib/OX.php';

/**
 * A abstract class, definine a common method for logging the completion
 * of the maintenance statistics process of maintenance statistics module
 * classes.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Statistics_Common_Task_LogCompletion extends OA_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return OA_Maintenance_Statistics_Common_Task_LogCompletion
     */
    function OA_Maintenance_Statistics_Common_Task_LogCompletion()
    {
        parent::OA_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the task of this class. Intended to be inherited by children of this
     * class. Logs the completion of the running of MSE tasks.
     *
     * @param string $runTypeField The name of DB field to hold $type value;
     *                             currently 'adserver_run_type' or 'tracker_run_type'.
     * @param PEAR::Date $oEndDate Optional date/time representing the end of the tasks.
     */
    function logCompletion($runTypeField, $oEndDate = null)
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oNowDate =& $oServiceLocator->get('now');
        if (is_null($oEndDate)) {
            $oEndDate = new Date();
        }
        // Get instance of OA_Dal_Maintenance_Statistics
        $oDal = new OA_Dal_Maintenance_Statistics();
        if (($this->oController->updateFinal) && ($this->oController->updateIntermediate)) {
            // Need to log that both the intermediate and final tables were updated;
            // however, need to ensure that we log the correct "updated to" times
            $oUpdateIntermediateToDate = new Date();
            $oUpdateIntermediateToDate->copy($this->oController->oUpdateIntermediateToDate);
            $oUpdateFinalToDate = new Date();
            $oUpdateFinalToDate->copy($this->oController->oUpdateFinalToDate);
            if ($oUpdateIntermediateToDate->equals($oUpdateFinalToDate)) {
                // The dates are the same, log info with one row
                $oDal->setMaintenanceStatisticsLastRunInfo(
                    $oNowDate,
                    $oEndDate,
                    $this->oController->oUpdateIntermediateToDate,
                    $runTypeField,
                    OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH
                );
            } else {
                // The dates are not the same, log info with two rows
                $oDal->setMaintenanceStatisticsLastRunInfo(
                    $oNowDate,
                    $oEndDate,
                    $this->oController->oUpdateIntermediateToDate,
                    $runTypeField,
                    OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI
                );
                $oDal->setMaintenanceStatisticsLastRunInfo(
                    $oNowDate,
                    $oEndDate,
                    $this->oController->oUpdateFinalToDate,
                    $runTypeField,
                    OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR
                );
            }
        } else if ($this->oController->updateIntermediate) {
            $oDal->setMaintenanceStatisticsLastRunInfo(
                $oNowDate,
                $oEndDate,
                $this->oController->oUpdateIntermediateToDate,
                $runTypeField,
                OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI
            );
        } else if ($this->oController->updateFinal) {
            $oDal->setMaintenanceStatisticsLastRunInfo(
                $oNowDate,
                $oEndDate,
                $this->oController->oUpdateFinalToDate,
                $runTypeField,
                OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR
            );
        } else {
            return false;
        }
        // Log the report to the "user log"
        $oDal->setMaintenanceStatisticsRunReport($this->oController->report);
        return true;
    }

}

?>
