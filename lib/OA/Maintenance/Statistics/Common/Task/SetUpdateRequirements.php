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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/Common/Task.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * A abstract class, definine a common method for setting the update
 * requirements of maintenance statistics module classes.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Statistics_Common_Task_SetUpdateRequirements extends OA_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return OA_Maintenance_Statistics_Common_Task_SetUpdateRequirements
     */
    function OA_Maintenance_Statistics_Common_Task_SetUpdateRequirements()
    {
        parent::OA_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the task of this class. Intended to be inherited by children of this
     * class.
     */
    function run()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oNowDate =& $oServiceLocator->get('now');
        if (!$oNowDate) {
            $oNowDate = new Date();
        }
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_' . $this->oController->module);
        $module = $this->oController->module . ' Module';
        $this->oController->report = 'Maintenance Statistics Report: ' . $module . "\n";
        OA::debug('Running Maintenance Statistics Engine: ' . $module, PEAR_LOG_INFO);
        $this->oController->report .= "=====================================\n\n";
        // Is this the Tracker module? If so, is conversion tracking disabled?
        if ($this->oController->module == 'Tracker' && $aConf['logging']['trackerImpressions'] == false) {
            // No need to test for if the module needs to run - it's not active
            $this->oController->updateIntermediate = false;
            $this->oController->updateFinal        = false;
            // Log this fact
            $message = "- Conversion tracking has been disabled.";
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_INFO);
            $this->oController->report .= "\n";
            $message = "- Maintenance statistics will NOT be run for the $module";
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_INFO);
            $this->oController->report .= "\n";
            return;
        }
        $message = '- Maintenance start run time is ' . $oNowDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oNowDate->tz->getShortName();
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        // Which of the operation interval and an hour is smaller?
        if ($aConf['maintenance']['operationInterval'] <= 60) {
            $this->oController->updateUsingOI = true;
        } else {
            $this->oController->updateUsingOI = false;
        }
        // Don't update unless the time is right!
        $this->oController->updateIntermediate = false;
        $this->oController->updateFinal        = false;
        // Test to see if a date for when the statistics were last updated
        // has been set in the service locator (for re-generation of stats)
        $oLastUpdatedDate =& $oServiceLocator->get('lastUpdatedDate');
        // Determine when the last intermediate table update happened
        if ($oLastUpdatedDate === false) {
            $this->oController->oLastDateIntermediate =
                $oDal->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI, $oNowDate);
        } else {
            $this->oController->oLastDateIntermediate = $oLastUpdatedDate;
        }
        if (is_null($this->oController->oLastDateIntermediate)) {
            // Couuld not find a last update date, and no raw impressions, so don't run MSE
            $message = '- Maintenance statistics has never been run before, and there is no raw data in ';
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
            $message = '  the database, so maintenance statistics will not be run for the intermediate tables';
            $this->oController->report .= $message . "\n\n";
            OA::debug($message, PEAR_LOG_DEBUG);
        } else {
            // Found a last update date
            $message = '- Maintenance statistics last updated intermediate table statistics to ' .
                       $this->oController->oLastDateIntermediate->format('%Y-%m-%d %H:%M:%S') . ' ' .
                       $this->oController->oLastDateIntermediate->tz->getShortName();
            $this->oController->report .= $message . ".\n";
            OA::debug($message, PEAR_LOG_DEBUG);
            // Does the last update date found occur on the end of an operation interval?
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->oController->oLastDateIntermediate);
            if (Date::compare($this->oController->oLastDateIntermediate, $aDates['end']) != 0) {
                $message = '- Last intermediate table updated to date of ' .
                           $this->oController->oLastDateIntermediate->format('%Y-%m-%d %H:%M:%S') . ' ' .
                           $this->oController->oLastDateIntermediate->tz->getShortName() .
                           ' is not on the current operation interval boundary';
                $this->oController->report .= $message . "\n";
                OA::debug($message, PEAR_LOG_DEBUG);
                $message = '- OPERATION INTERVAL LENGTH CHANGE SINCE LAST RUN';
                $this->oController->report .= $message . "\n";
                OA::debug($message, PEAR_LOG_DEBUG);
                $message = '- Extending the time until next update';
                $this->oController->report .= $message . "\n";
                OA::debug($message, PEAR_LOG_DEBUG);
                $this->oController->sameOI = false;
            }
            // Calculate the date after which the next operation interval-based update can happen
            $oRequiredDate = new Date();
            if ($this->oController->sameOI) {
                $oRequiredDate->copy($this->oController->oLastDateIntermediate);
                $oRequiredDate->addSeconds($aConf['maintenance']['operationInterval'] * 60);
            } else {
                $oRequiredDate->copy($aDates['end']);
            }
            $message = '- Current time must be after ' . $oRequiredDate->format('%Y-%m-%d %H:%M:%S') . ' ' .
                       $oRequiredDate->tz->getShortName() . ' for the next intermediate table update to happen';
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
            if (Date::compare($oNowDate, $oRequiredDate) > 0) {
                $this->oController->updateIntermediate = true;
                // Update intermediate tables to the end of the previous (not current) operation interval
                $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNowDate);
                $this->oController->oUpdateIntermediateToDate = new Date();
                $this->oController->oUpdateIntermediateToDate->copy($aDates['start']);
                $this->oController->oUpdateIntermediateToDate->subtractSeconds(1);
            } else {
                // An operation interval hasn't passed, so don't update
                $message = "- At least {$aConf['maintenance']['operationInterval']} minutes have " .
                           'not passed since the last operation interval update';
                $this->oController->report .= $message . "\n";
                OA::debug($message, PEAR_LOG_DEBUG);
            }
        }
        // Determine when the last final table update happened
        if ($oLastUpdatedDate === false) {
            $this->oController->oLastDateFinal =
                $oDal->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR, $oNowDate);
        } else {
            $this->oController->oLastDateFinal = $oLastUpdatedDate;
        }
        if (is_null($this->oController->oLastDateFinal)) {
            // Couuld not find a last update date, and no raw impressions, so don't run MSE
            $message = '- Maintenance statistics has never been run before, and there is no raw data in ';
            $this->oController->report .= $message . "\n" .
            OA::debug($message, PEAR_LOG_DEBUG);
            $message = '  the database, so maintenance statistics will not be run for the final tables';
            $this->oController->report .= $message . "\n\n";
            OA::debug($message, PEAR_LOG_DEBUG);
        } else {
            // Found a last update date
            $message = '- Maintenance statistics last updated final table statistics to ' .
                       $this->oController->oLastDateFinal->format('%Y-%m-%d %H:%M:%S') . ' ' .
                       $this->oController->oLastDateFinal->tz->getShortName();;
            $this->oController->report .= $message . ".\n";
            OA::debug($message, PEAR_LOG_DEBUG);
            // Calculate the date after which the next hour-based update can happen
            $oRequiredDate = new Date();
            $oRequiredDate->copy($this->oController->oLastDateFinal);
            $oRequiredDate->addSeconds(60 * 60);
            $message = '- Current time must be after ' . $oRequiredDate->format('%Y-%m-%d %H:%M:%S') . ' ' .
                       $oRequiredDate->tz->getShortName() . ' for the next intermediate table update to happen';
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
            if (Date::compare($oNowDate, $oRequiredDate) > 0) {
                $this->oController->updateFinal = true;
                // Update final tables to the end of the previous (not current) hour
                $this->oController->oUpdateFinalToDate = new Date($oNowDate->format('%Y-%m-%d %H:00:00'));
                $this->oController->oUpdateFinalToDate->subtractSeconds(1);
            } else {
                // An hour hasn't passed, so don't update
                $message = '- At least 60 minutes have NOT passed since the last final table update';
                $this->oController->report .= $message . "\n";
                OA::debug($message, PEAR_LOG_DEBUG);
            }
        }
        if ($this->oController->updateIntermediate || $this->oController->updateFinal) {
            $message = "- Maintenance statistics will be run";
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_INFO);
            if ($this->oController->updateIntermediate) {
                $message = '- The intermediate table statistics will be updated';
                $this->oController->report .= $message . "\n";
                OA::debug($message, PEAR_LOG_INFO);
            }
            if ($this->oController->updateFinal) {
                $message = '- The final table statistics will be updated';
                $this->oController->report .= $message . "\n";
                OA::debug($message, PEAR_LOG_INFO);
            }
            $this->oController->report .= "\n";
        } else {
            $message = "- Maintenance statistics will NOT be run for the $module";
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_INFO);
            $this->oController->report .= "\n";
        }
    }

}

?>
