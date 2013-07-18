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
require_once LIB_PATH . '/Plugin/Component.php';

/**
 * The MSE process task class that determines what operation intervals and/or
 * hours, if any, need to be updated during the MSE run.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_Maintenance_Statistics_Task_SetUpdateRequirements extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_SetUpdateRequirements
     */
    function OX_Maintenance_Statistics_Task_SetUpdateRequirements()
    {
        parent::OX_Maintenance_Statistics_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of determining what operation intervals
     * and/or hours, if any, need to be updated during the MSE run.
     */
    function run()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oNowDate =& $oServiceLocator->get('now');
        if (!$oNowDate) {
            $oNowDate = new Date();
        }

        $this->oController->report = "Maintenance Statistics Report\n";
        $this->oController->report .= "=====================================\n\n";
        $message = '- Maintenance start run time is ' . $oNowDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oNowDate->tz->getShortName();
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);

        // Don't update unless the time is right!
        $this->oController->updateIntermediate = false;
        $this->oController->updateFinal        = false;

        // Test to see if a date for when the statistics were last updated
        // has been set in the service locator (for re-generation of stats)
        $oLastUpdatedDate =& $oServiceLocator->get('lastUpdatedDate');

        // Determine when the last intermediate table update happened
        if (is_a($oLastUpdatedDate, 'Date')) {
            $this->oController->oLastDateIntermediate = $oLastUpdatedDate;
        } else {
            $this->oController->oLastDateIntermediate =
                $this->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI, $oNowDate);
            if (is_null($this->oController->oLastDateIntermediate)) {
                // The MSE has never run, look to see if delivery data exists
                $this->oController->oLastDateIntermediate = $this->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
            }
        }

        if (is_null($this->oController->oLastDateIntermediate)) {
            // Could not find a last update date, so don't run MSE
            $message = '- Maintenance statistics has never been run before, and no logged delivery data was located in ';
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
            $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->oController->oLastDateIntermediate);
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
                $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNowDate);
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
        if ($oLastUpdatedDate !== false) {
            $this->oController->oLastDateFinal = $oLastUpdatedDate;
        } else {
            $this->oController->oLastDateFinal =
                $this->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR, $oNowDate);
            if (is_null($this->oController->oLastDateFinal)) {
                // The MSE has never run, look to see if delivery data exists
                $this->oController->oLastDateFinal = $this->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
            }
        }

        if (is_null($this->oController->oLastDateFinal)) {
            // Could not find a last update date, so don't run MSE
            $message = '- Maintenance statistics has never been run before, and no logged delivery data was located in ';
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

        // Is an update of any type going to happen?
        if ($this->oController->updateIntermediate || $this->oController->updateFinal) {
            $message = "- Maintenance statistics will be run";
            $this->oController->report .= $message . ".\n";
            OA::debug($message, PEAR_LOG_INFO);
            if ($this->oController->updateIntermediate) {
                $message = '- The intermediate table statistics will be updated';
                $this->oController->report .= $message . ".\n";
                OA::debug($message, PEAR_LOG_INFO);
            }
            if ($this->oController->updateFinal) {
                $message = '- The final table statistics will be updated';
                $this->oController->report .= $message . ".\n";
                OA::debug($message, PEAR_LOG_INFO);
            }
            $this->oController->report .= "\n";
        } else {
            $message = "- Maintenance statistics will NOT be run";
            $this->oController->report .= $message . ".\n";
            OA::debug($message, PEAR_LOG_INFO);
            $this->oController->report .= "\n";
        }
    }

    /**
     * A private method to find the last time that maintenance statistics was run.
     *
     * @access private
     * @param integer $type The update type that occurred - that is,
     *                      OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI if the update was
     *                      done on the basis of the operation interval; or
     *                      OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR if the update
     *                      was done on the basis of the hour.
     *                      Note that both parameters above will be "found" in the
     *                      event that an update type stored in the database of
     *                      OX_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH is suitable.
     * @param Date $oNow An optional Date, used to specify the "current time", and
     *                   to limit the method to only look for past maintenance
     *                   statistics runs before this date. Normally only used
     *                   to assist with re-generation of statistics.
     * @return Date A Date representing the date up to which the statistics
     *              have been summarised, for the specified update type.
     *              Returns null if no run type for the MSE can be located.
     */
    function _getMaintenanceStatisticsLastRunInfo($type, $oNow = null)
    {
        // Prepare debugging message
        $message = '- Getting the details of when maintenance statistics last ran on the basis of ';
        if ($type == OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI) {
            $message .= 'the operation interval';
        } elseif ($type == OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR) {
            $message .= 'the hour';
        } else {
            OA::debug('Invalid update type value ' . $type, PEAR_LOG_ERR);
            OA::debug('Aborting script execution', PEAR_LOG_ERR);
            exit();
        }
        OA::debug($message, PEAR_LOG_DEBUG);

        // Prepare the DB_DataObject for the "log_maintenance_statistics" table
        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');

        // Set the required WHERE condition for the query
        if ($type == OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI) {
            $sWhereClause = "(adserver_run_type = " . OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI .
                           " OR adserver_run_type = " . OX_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH. ')';
            $doLog_maintenance_statistics->whereAdd($sWhereClause);
        } elseif ($type == OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR) {
            $sWhereClause = "(adserver_run_type = " . OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR .
                           " OR adserver_run_type = " . OX_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH . ')';
            $doLog_maintenance_statistics->whereAdd($sWhereClause);
        }
        if (!is_null($oNow) && is_a($oNow, 'Date')) {
            // Limit to past maintenance statistics runs before this Date
            $sWhereClause = 'updated_to < ' . "'" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'";
            $doLog_maintenance_statistics->whereAdd($sWhereClause);
        }

        // Order the query to return the most recent value, and limit the results
        $doLog_maintenance_statistics->orderBy('updated_to DESC');
        $doLog_maintenance_statistics->limit(1);

        // Query the database
        $doLog_maintenance_statistics->find();
        if ($doLog_maintenance_statistics->getRowCount() == 0) {
            return null;
        }
        if ($doLog_maintenance_statistics->fetch() != true) {
            return null;
        }

        $oDate = new Date($doLog_maintenance_statistics->updated_to);
        return $oDate;
    }

    /**
     * A private method to calculate an equivalent "last time that maintenance
     * statistics was run" value from logged delivery data, if possible.
     *
     * Enables the MSE process to be kick-started for new installations, where
     * the MSE has not been run before; but without causing the MSE to run
     * until the installation is actually logging data.
     *
     * @access private
     * @param integer $type The update type that "occurred" - that is,
     *                      OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI if the required
     *                      calculated "update date" needs to be in terms of the
     *                      operation interval; or
     *                      OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR if the
     *                      required calculated "update date" needs to be in terms
     *                      of the hour.
     * @return Date A Date representing the end of the operation interval
     *              which is before the date found of the earliest known
     *              logged delivery data record. Returns null if no logged
     *              delivery data can be located.
     */
    function _getEarliestLoggedDeliveryData($type)
    {
        // Obtain all components from the deliveryLog plugin group
        $aDeliveryLogComponents = OX_Component::getComponents('deliveryLog');

        // Are there any components?
        if (empty($aDeliveryLogComponents)) {
            return null;
        }

        // Call the "getEarliestLoggedDataDate()" method on each
        // component, to find out what is the date of the earliest
        // logged data that the component knows about
        $aResult = OX_Component::callOnComponents($aDeliveryLogComponents, 'getEarliestLoggedDataDate');
        if ($aResults === false) {
            return null;
        }

        // Iterate over the results from above, and see if any of
        // the components returned valid dates, and if so, which
        // of the results is the earliest
        $oDate = null;
        foreach ($aResult as $oComponentDate) {
            if (is_a($oComponentDate, 'Date')) {
                // Logged data was located! Is this date earlier than
                // any previous "earliest" logged delivery data?
                if (is_null($oDate)) {
                    $oDate = new Date();
                    $oDate->copy($oComponentDate);
                } else {
                    if ($oComponentDate->before($oDate)) {
                        $oDate->copy($oComponentDate);
                    }
                }
            }
        }

        // Was a date found?
        if (is_null($oDate) || !is_a($oDate, 'Date')) {
            return null;
        }

        // Convert the located earliest logged data date into either the
        // end of the previous operation interval, or the end of the previous
        // hour, depending on the required type
        if ($type == OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI) {
            $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        } else {
            $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate, 60);
        }

        // Return the date
        return $aDates['end'];
    }

}

?>