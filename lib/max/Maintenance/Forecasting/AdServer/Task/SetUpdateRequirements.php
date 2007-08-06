<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task.php';
require_once 'Date.php';

/**
 * A class for determining the maintenance forecasting update requirements for
 * the AdServer module.
 *
 * @package    MaxMaintenance
 * @subpackage Forecasting
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements extends MAX_Maintenance_Forecasting_AdServer_Task
{

    /**
     * The constructor method.
     *
     * @return MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements
     */
    function MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements()
    {
        parent::MAX_Maintenance_Forecasting_AdServer_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the task of this class.
     *
     * @TODO Is this correct? How often will we run forecasting? Over how many hours?
     */
    function run()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator = &ServiceLocator::instance();
        $oNowDate = &$oServiceLocator->get('now');
        if (!$oNowDate) {
            $oNowDate = new Date();
        }
        MAX::debug('Running Maintenance Forecasting: AdServer', PEAR_LOG_INFO);
        $message = 'Current time is ' . $oNowDate->format('%Y-%m-%d %H:%M:%S') . '.';
        MAX::debug($message, PEAR_LOG_DEBUG);
        // Don't update unless the time is right!
        $this->oController->update = false;
        // Test to see if a date for when the forecasts were last updated
        // has been set in the service locator (for re-generation of forecasts)
        $oLastUpdatedDate = &$oServiceLocator->get('lastUpdatedDate');
        // Determine when the last forecasting update happened
        if ($oLastUpdatedDate === false) {
            $table = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
            if ($conf['table']['split']) {
                // Suffix yesterday's date to table name
                $oTableDate = new Date();
                $oTableDate->copy($oNowDate);
                $oTableDate->subtractSeconds(SECONDS_PER_DAY);
                $table .=  '_' . $oTableDate->format('%Y%m%d');
            }
            $aResult = $this->oDal->getMaintenanceForecastingLastRunInfo($table);
            if (($aResult !== false) && (!is_null($aResult))) {
                $this->oController->oLastUpdateDate = new Date($aResult['updated_to']);
            }
        } else {
            $this->oController->oLastUpdateDate = $oLastUpdatedDate;
        }
        if (is_null($this->oController->oLastUpdateDate) || ($this->oController->oLastUpdateDate === false)) {
            $message = 'Maintenance forecasting has never been run before, and there is no raw data in ';
            MAX::debug($message, PEAR_LOG_DEBUG);
            $message = 'the database, so maintenance forecasting will not be run.';
            MAX::debug($message, PEAR_LOG_DEBUG);
        } else {
            $message = 'Maintenance forecasting last updated to ' .
                       $this->oController->oLastUpdateDate->format('%Y-%m-%d %H:%M:%S') . '.';
            MAX::debug($message, PEAR_LOG_DEBUG);
            // MFE summarises data by day, so we need to decide if there are any
            // complete days that have not yet been summarised; to do so, test
            // to see if the last updated date is before the end of yesterday
            $oRequiredDate = new Date();
            $oRequiredDate->copy($oNowDate);
            $oRequiredDate->subtractSeconds(SECONDS_PER_DAY);
            $oRequiredDate->setHour(23);
            $oRequiredDate->setMinute(59);
            $oRequiredDate->setSecond(59);
            $message = 'Last update of ' . $this->oController->oLastUpdateDate->format('%Y-%m-%d %H:%M:%S') .
                       ' must be before before ' . $oRequiredDate->format('%Y-%m-%d %H:%M:%S') .
                       ' for the next forecasting update to happen.';
            MAX::debug($message, PEAR_LOG_DEBUG);
            if ($this->oController->oLastUpdateDate->before($oRequiredDate)) {
                $this->oController->update = true;
                // Update to the $oRequiredDate
                $this->oController->oUpdateToDate = new Date();
                $this->oController->oUpdateToDate->copy($oRequiredDate);
                // Ensure that $this->oController->oLastUpdateDate is at least a full
                // day behind $oRequiredDate, so that the full day is updated
                $oTestDate = new Date();
                $oTestDate->copy($oRequiredDate);
                $oTestDate->subtractSeconds(SECONDS_PER_DAY);
                if ($oTestDate->before($this->oController->oLastUpdateDate)) {
                    // The $this->oController->oLastUpdateDate value came from
                    // the first value in a raw data table, so set the last
                    // updated date back to the end of the day before that day
                    $this->oController->oLastUpdateDate->subtractSeconds(SECONDS_PER_DAY);
                    $this->oController->oLastUpdateDate->setHour(23);
                    $this->oController->oLastUpdateDate->setMinute(59);
                    $this->oController->oLastUpdateDate->setSecond(59);
                }
            } else {
                // Required time hasn't passed, so don't update
                $message = 'Last update was not before ' . $oRequiredDate->format('%Y-%m-%d %H:%M:%S');
                MAX::debug($message, PEAR_LOG_DEBUG);
            }
        }
        if ($this->oController->update) {
            $message = "Maintenance forecasting will be run.";
            MAX::debug($message, PEAR_LOG_INFO);
        } else {
            $message = 'Maintenance forecasting will NOT be run.';
            MAX::debug($message, PEAR_LOG_INFO);
        }
    }

}

?>
