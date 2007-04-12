<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Common/Task.php';

/**
 * A abstract class, definine a common method for logging the completion
 * of the maintenance statistics process of maintenance statistics module
 * classes.
 *
 * @abstract
 * @package    MaxMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Statistics_Common_Task_LogCompletion extends MAX_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return MAX_Maintenance_Statistics_Common_Task_LogCompletion
     */
    function MAX_Maintenance_Statistics_Common_Task_LogCompletion()
    {
        parent::MAX_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the MAX_Core_Task::run() method that performs
     * the task of this class. Intended to be inherited by childred of this
     * class. Logs the completion of the running of MSE tasks.
     *
     * @param string $runTypeField The name of DB field to hold $type value;
     *                             currently 'adserver_run_type' or 'tracker_run_type'.
     * @param PEAR::Date $oEndDate Optional date/time representing the end of the tasks.
     */
    function logCompletion($runTypeField, $oEndDate = null)
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oNowDate = &$oServiceLocator->get('now');
        if (is_null($oEndDate)) {
            $oEndDate = new Date();
        }
        // Get instance of OA_Dal_Maintenance_Statistics
        $oDal = new OA_Dal_Maintenance_Statistics();
        if (($this->oController->updateFinal) && ($this->oController->updateIntermediate)) {
            $oDal->setMaintenanceStatisticsLastRunInfo(
                $oNowDate,
                $oEndDate,
                $this->oController->updateIntermediateToDate,
                $runTypeField,
                OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH
            );
        } elseif ($this->oController->updateFinal) {
            $oDal->setMaintenanceStatisticsLastRunInfo(
                $oNowDate,
                $oEndDate,
                $this->oController->updateFinalToDate,
                $runTypeField,
                OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR
            );
        } elseif ($this->oController->updateIntermediate) {
            $oDal->setMaintenanceStatisticsLastRunInfo(
                $oNowDate,
                $oEndDate,
                $this->oController->updateIntermediateToDate,
                $runTypeField,
                OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI
            );
        } else {
            MAX::debug(
                'Call to MAX_Maintenance_Statistics_Common_Task_LogCompletion::logCompletion() failed.',
                PEAR_LOG_DEBUG
            );
            return false;
        }
        $oDal->setMaintenanceStatisticsRunReport($this->oController->report);
        return true;
    }

}

?>
