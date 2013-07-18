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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';

require_once LIB_PATH . '/Dal/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task.php';
require_once OX_PATH . '/lib/OX.php';

/**
 * The MSE process task class that logs the completion of MSE process
 * to the database.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 *
 *
 */
class OX_Maintenance_Statistics_Task_LogCompletion extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_LogCompletion
     */
    function OX_Maintenance_Statistics_Task_LogCompletion()
    {
        parent::OX_Maintenance_Statistics_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of logging the completion of the MSE process.
     *
     * @param PEAR::Date $oEndDate Optional date/time representing the end of the tasks.
     */
    function run($oEndDate = null)
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oNowDate =& $oServiceLocator->get('now');
        if (is_null($oEndDate)) {
            $oEndDate = new Date();
        }

        // Prepare the duraction to log from the start and end dates
        $oDuration = new Date_Span();
        $oStartDateCopy = new Date();
        $oStartDateCopy->copy($oNowDate);
        $oEndDateCopy = new Date();
        $oEndDateCopy->copy($oEndDate);
        $oDuration->setFromDateDiff($oStartDateCopy, $oEndDateCopy);

        $message = '- Logging the completion of the maintenance statistics run';
        $this->oController->report .= "$message.\n";
        OA::debug($message, PEAR_LOG_DEBUG);

        // Determine the type of MSE completion logging required
        if (($this->oController->updateFinal) && ($this->oController->updateIntermediate)) {

            // Need to log that both the intermediate and final tables were updated;
            // however, need to ensure that we log the correct "updated to" times
            $oUpdateIntermediateToDate = new Date();
            $oUpdateIntermediateToDate->copy($this->oController->oUpdateIntermediateToDate);
            $oUpdateFinalToDate = new Date();
            $oUpdateFinalToDate->copy($this->oController->oUpdateFinalToDate);

            if ($oUpdateIntermediateToDate->equals($oUpdateFinalToDate)) {

                // The dates are the same, log info with one row
                $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
                $doLog_maintenance_statistics->start_run         = $oNowDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->end_run           = $oEndDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->duration          = $oDuration->toSeconds();
                $doLog_maintenance_statistics->adserver_run_type = OX_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH;
                $doLog_maintenance_statistics->updated_to        = $this->oController->oUpdateIntermediateToDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->insert();

            } else {

                // The dates are not the same, log info with two rows
                $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
                $doLog_maintenance_statistics->start_run         = $oNowDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->end_run           = $oEndDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->duration          = $oDuration->toSeconds();
                $doLog_maintenance_statistics->adserver_run_type = OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI;
                $doLog_maintenance_statistics->updated_to        = $this->oController->oUpdateIntermediateToDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->insert();

                $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
                $doLog_maintenance_statistics->start_run         = $oNowDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->end_run           = $oEndDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->duration          = $oDuration->toSeconds();
                $doLog_maintenance_statistics->adserver_run_type = OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR;
                $doLog_maintenance_statistics->updated_to        = $this->oController->oUpdateFinalToDate->format('%Y-%m-%d %H:%M:%S');
                $doLog_maintenance_statistics->insert();

            }
        } else if ($this->oController->updateIntermediate) {

            $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
            $doLog_maintenance_statistics->start_run         = $oNowDate->format('%Y-%m-%d %H:%M:%S');
            $doLog_maintenance_statistics->end_run           = $oEndDate->format('%Y-%m-%d %H:%M:%S');
            $doLog_maintenance_statistics->duration          = $oDuration->toSeconds();
            $doLog_maintenance_statistics->adserver_run_type = OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI;
            $doLog_maintenance_statistics->updated_to        = $this->oController->oUpdateIntermediateToDate->format('%Y-%m-%d %H:%M:%S');
            $doLog_maintenance_statistics->insert();

        } else if ($this->oController->updateFinal) {

            $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
            $doLog_maintenance_statistics->start_run         = $oNowDate->format('%Y-%m-%d %H:%M:%S');
            $doLog_maintenance_statistics->end_run           = $oEndDate->format('%Y-%m-%d %H:%M:%S');
            $doLog_maintenance_statistics->duration          = $oDuration->toSeconds();
            $doLog_maintenance_statistics->adserver_run_type = OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR;
            $doLog_maintenance_statistics->updated_to        = $this->oController->oUpdateFinalToDate->format('%Y-%m-%d %H:%M:%S');
            $doLog_maintenance_statistics->insert();

        } else {

            return false;

        }

        // Log the report to the "user log"
        $this->_setMaintenanceStatisticsRunReport($this->oController->report);
        return true;
    }

    /**
     * A private method to store the a maintenance statistics run report.
     *
     * @access private
     * @param String $report The report to be logged.
     */
    function _setMaintenanceStatisticsRunReport($report)
    {
        OA::debug('Logging the maintenance statistics run report', PEAR_LOG_DEBUG);
        $oUserlog = OA_Dal::factoryDO('userlog');
        $oUserlog->timestamp = time();
        $oUserlog->usertype  = phpAds_userMaintenance;
        $oUserlog->userid    = 0;
        $oUserlog->action    = phpAds_actionBatchStatistics;
        $oUserlog->object    = 0;
        $oUserlog->details   = addslashes(trim($report));
        $oUserlog->insert();
    }

}

?>