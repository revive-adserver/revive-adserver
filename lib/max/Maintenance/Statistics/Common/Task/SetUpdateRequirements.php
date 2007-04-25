<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Common/Task.php';

/**
 * A abstract class, definine a common method for setting the update
 * requirements of maintenance statistics module classes.
 *
 * @abstract
 * @package    MaxMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Statistics_Common_Task_SetUpdateRequirements extends MAX_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return MAX_Maintenance_Statistics_Common_Task_SetUpdateRequirements
     */
    function MAX_Maintenance_Statistics_Common_Task_SetUpdateRequirements()
    {
        parent::MAX_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the MAX_Core_Task::run() method that performs
     * the task of this class. Intended to be inherited by childred of this
     * class.
     */
    function run()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator = &ServiceLocator::instance();
        $oNowDate = &$oServiceLocator->get('now');
        if (!$oNowDate) {
            $oNowDate = new Date();
        }
        $oDal = &$oServiceLocator->get('OA_Dal_Maintenance_Statistics_' . $this->oController->module);
        $module = $this->oController->module . ' Module.';
        $this->oController->report = 'Maintenance Statistics Report: ' . $module . "\n";
        MAX::debug('Running Maintenance Statistics: ' . $module, PEAR_LOG_INFO);
        $this->oController->report .= "=====================================\n\n";
        $message = 'Current time is ' . $oNowDate->format('%Y-%m-%d %H:%M:%S') . '.';
        $this->oController->report .= $message . "\n";
        MAX::debug($message, PEAR_LOG_DEBUG);
        // Which of the operation interval and an hour is smaller?
        if ($conf['maintenance']['operationInterval'] <= 60) {
            $this->oController->updateUsingOI = true;
        } else {
            $this->oController->updateUsingOI = false;
        }
        // Don't update unless the time is right!
        $this->oController->updateIntermediate = false;
        $this->oController->updateFinal        = false;
        // Test to see if a date for when the statistics were last updated
        // has been set in the service locator (for re-generation of stats)
        $oLastUpdatedDate = &$oServiceLocator->get('lastUpdatedDate');
        // Determine when the last intermediate table update happened
        if ($oLastUpdatedDate === false) {
            $this->oController->lastDateIntermediate =
                $oDal->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI, $oNowDate);
        } else {
            $this->oController->lastDateIntermediate = $oLastUpdatedDate;
        }
        if (is_null($this->oController->lastDateIntermediate)) {
            $message = 'Maintenance statistics has never been run before, and there is no raw data in ';
            $this->oController->report .= $message . "\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
            $message = 'the database, so maintenance statistics will not be run for the intermediate tables.';
            $this->oController->report .= $message . "\n\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
        } else {
            $message = 'Maintenance statistics last updated intermediate table statistics to ' .
                       $this->oController->lastDateIntermediate->format('%Y-%m-%d %H:%M:%S') . '.';
            $this->oController->report .= $message . ".\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
            $requiredDate = new Date();
            $requiredDate->copy($this->oController->lastDateIntermediate);
            $requiredDate->addSeconds($conf['maintenance']['operationInterval'] * 60);
            $message = 'Current time must be after ' . $requiredDate->format('%Y-%m-%d %H:%M:%S') .
                       ' for the next intermediate table update to happen.';
            $this->oController->report .= $message . "\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
            if (Date::compare($oNowDate, $requiredDate) > 0) {
                $this->oController->updateIntermediate = true;
                // Update intermediate tables to the end of the previous (not current) operation interval
                $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNowDate);
                $this->oController->updateIntermediateToDate = new Date();
                $this->oController->updateIntermediateToDate->copy($aDates['start']);
                $this->oController->updateIntermediateToDate->subtractSeconds(1);
            } else {
                // An operation interval hasn't passed, so don't update
                $message = "At least {$conf['maintenance']['operationInterval']} minutes have " .
                           'not passed since the last operation interval update.';
                $this->oController->report .= $message . "\n";
                MAX::debug($message, PEAR_LOG_DEBUG);
            }
        }
        // Determine when the last final table update happened
        if ($oLastUpdatedDate === false) {
            $this->oController->lastDateFinal =
                $oDal->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR, $oNowDate);
        } else {
            $this->oController->lastDateFinal = $oLastUpdatedDate;
        }
        if (is_null($this->oController->lastDateFinal)) {
            // There are no statistics, cannot run
            $message = 'Maintenance statistics has never been run before, and there is no raw data in ';
            $this->oController->report .= $message . "\n" .
            MAX::debug($message, PEAR_LOG_DEBUG);
            $message = 'the database, so maintenance statistics will not be run for the final tables.';
            $this->oController->report .= $message . "\n\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
        } else {
            $message = 'Maintenance statistics last updated final table statistics to ' .
                       $this->oController->lastDateFinal->format('%Y-%m-%d %H:%M:%S') . '.';
            $this->oController->report .= $message . ".\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
            $requiredDate = new Date();
            $requiredDate->copy($this->oController->lastDateFinal);
            $requiredDate->addSeconds(60 * 60);
            $message = 'Current time must be after ' . $requiredDate->format('%Y-%m-%d %H:%M:%S') .
                       ' for the next final table update to happen.';
            $this->oController->report .= $message . "\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
            if (Date::compare($oNowDate, $requiredDate) > 0) {
                $this->oController->updateFinal = true;
                // Update final tables to the end of the previous (not current) hour
                $this->oController->updateFinalToDate = new Date($oNowDate->format('%Y-%m-%d %H:00:00'));
                $this->oController->updateFinalToDate->subtractSeconds(1);
            } else {
                // An hour hasn't passed, so don't update
                $message = 'At least 60 minutes have NOT passed since the last final table update.';
                $this->oController->report .= $message . "\n";
                MAX::debug($message, PEAR_LOG_DEBUG);
            }
        }
        if ($this->oController->updateIntermediate || $this->oController->updateFinal) {
            $message = "Maintenance statistics will be run.";
            $this->oController->report .= $message . "\n";
            MAX::debug($message, PEAR_LOG_INFO);
            if ($this->oController->updateIntermediate) {
                $message = 'The intermediate table statistics will be updated.';
                $this->oController->report .= $message . "\n";
                MAX::debug($message, PEAR_LOG_INFO);
            }
            if ($this->oController->updateFinal) {
                $message = 'The final table statistics will be updated.';
                $this->oController->report .= $message . "\n";
                MAX::debug($message, PEAR_LOG_INFO);
            }
            $this->oController->report .= "\n";
        } else {
            $message = 'Maintenance statistics will NOT be run.';
            $this->oController->report .= $message . "\n";
            MAX::debug($message, PEAR_LOG_INFO);
            $this->oController->report .= "\n";
        }
    }

}

?>
