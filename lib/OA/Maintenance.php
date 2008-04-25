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
require_once MAX_PATH . '/scripts/maintenance/translationStrings.php';

if (!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/cache.php']) && !is_callable('MAX_commonGetDeliveryUrl')) {
    require_once(MAX_PATH . '/lib/max/Delivery/cache.php');
}

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';
require_once MAX_PATH . '/lib/OA/Email.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Pruning.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A library class for providing common maintenance process methods.
 *
 * @package    OpenX
 * @author     Andrew Hill <andrew.hill@opends.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_Maintenance
{
    var $oDbh;
    var $aConf;
    var $aPref;

    function OA_Maintenance()
    {
        $this->aConf = $GLOBALS['_MAX']['CONF'];

        OA_Preferences::loadAdminAccountPreferences();
        $this->aPref = $GLOBALS['_MAX']['PREF'];

        // Get a connection to the datbase
        $this->oDbh =& OA_DB::singleton();
        if (PEAR::isError($this->oDbh)) {
            // Unable to continue!
            MAX::raiseError($this->oDbh, null, PEAR_ERROR_DIE);
        }
    }

    /**
     * A method to run maintenance.
     */
    function run()
    {
        // Print a blank line in the debug log file when maintenance starts
        OA::debug();
        // Do not run if distributed stats are enabled
        if (!empty($this->aConf['lb']['enabled'])) {
            OA::debug('Distributed stats enabled, not running maintenance tasks', PEAR_LOG_INFO);
            return;
        }
        // Acquire the maintenance lock
        $oLock =& OA_DB_AdvisoryLock::factory();
        if ($oLock->get(OA_DB_ADVISORYLOCK_MAINTENANCE))
        {
            OA::switchLogFile('maintenance');

            OA::debug();
            OA::debug('Running maintenance tasks', PEAR_LOG_INFO);

            // Attempt to increase PHP memory
            increaseMemoryLimit($GLOBALS['_MAX']['REQUIRED_MEMORY']['MAINTENANCE']);
            // Set UTC timezone
            OA_setTimeZoneUTC();
            // Get last run
            $oLastRun = $this->getLastRun();
            // Update the timestamp for old maintenance code and auto-maintenance
            $this->updateLastRun();
            // Record the current time, and register with the OA_ServiceLocator
            $oDate = new Date();
            $oServiceLocator =& OA_ServiceLocator::instance();
            $oServiceLocator->register('now', $oDate);
            // Check the operation interval is valid
            $result = OA_OperationInterval::checkOperationIntervalValue($this->aConf['maintenance']['operationInterval']);
            if (PEAR::isError($result)) {
                // Unable to continue!
                $oLock->release();
                OA::debug('Aborting maintenance: Invalid Operation Interval length', PEAR_LOG_CRIT);
                exit();
            }
            // Run the Maintenance Statistics Engine (MSE) process
            $this->_runMSE();
            // Run the "midnight" tasks, if required
            if ($this->isMidnightMaintenance($oLastRun)) {
                $this->_runMidnightTasks();
            }
            // Release lock before starting MPE
            $oLock->release();

            // Run the Maintenance Priority Engine (MPE) process, ensuring that the
            // process always runs, even if instant update of priorities is disabled
            $this->_runMPE();

            OA::debug('Maintenance tasks completed', PEAR_LOG_INFO);

            OA::switchLogFile();
        }
        else {
			OA::debug('Maintenance tasks not run: could not acquire lock', PEAR_LOG_INFO);
        }
    }

    /**
     * A private method to run MSE.
     *
     * @access private
     */
    function _runMSE()
    {
        OA_Maintenance_Statistics::run();
    }

    /**
     * A method with returns the last time maintenance was run
     *
     * @return Date A Date object, or null if maintenance did never run
     */
    function getLastRun()
    {
        $iLastRun = OA_Dal_ApplicationVariables::get('maintenance_timestamp');
        if ($iLastRun) {
            return new Date((int)$iLastRun);
        }

        return null;
    }

    /**
     * A method with returns the last time scheduled maintenance was run
     *
     * @return Date A Date object, or null if scheduled maintenance did never run
     */
    function getLastScheduledRun()
    {
        $iLastRun = OA_Dal_ApplicationVariables::get('maintenance_cron_timestamp');
        if ($iLastRun) {
            return new Date((int)$iLastRun);
        }

        return null;
    }

    /**
     * A method to check if midnight tasks should run
     *
     * @param Date $oLastRun
     * @return boolean
     */
    function isMidnightMaintenance($oLastRun)
    {
        global $aServerTimezone;

        if (empty($oLastRun)) {
            return true;
        }

        $oServiceLocator = &OA_ServiceLocator::instance();
        $lastMidnight = new Date($oServiceLocator->get('now'));
        if (!empty($aServerTimezone['tz'])) {
            $lastMidnight->convertTZbyID($aServerTimezone['tz']);
        }
        $lastMidnight->setHour(0);
        $lastMidnight->setMinute(0);
        $lastMidnight->setSecond(0);

        $oLastRunCopy = new Date($oLastRun);

        return $oLastRunCopy->before($lastMidnight);
    }

    /**
     * A private method to run midnight maintenance tasks.
     *
     * @access private
     */
    function _runMidnightTasks()
    {
        OA::debug('Running Midnight Maintenance Tasks', PEAR_LOG_INFO);
        $this->_runReports();
        $this->_runOpenadsSync();
        $this->_runOpenadsCentral();
        $this->_runGeneralPruning();
        $this->_runPriorityPruning();
        $this->_runDeleteUnverifiedAccounts();
        OA::debug('Midnight Maintenance Tasks Completed', PEAR_LOG_INFO);
    }

    /**
     * A private method to run MPE.
     *
     * @access private
     */
    function _runMPE()
    {
        OA_Maintenance_Priority::run(true);
    }

    /**
     * A method to send the "midnight" reports during maintenance - that
     * is, the delivery information report, showing what the campaign(s)
     * have delivered since the last time the report was sendt.
     *
     * @access private
     */
    function _runReports()
    {
        OA::debug('  Starting to send advertiser "campaign delivery" reports.', PEAR_LOG_DEBUG);
        // Get all advertisers where the advertiser preference is to send reports
        OA::debug('   - Getting details of advertisers that require reports to be sent.', PEAR_LOG_DEBUG);
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->report = 't';
        $doClients->find();
        while ($doClients->fetch()) {
            $aAdvertiser = $doClients->toArray();
            // Don't email report by default
            $sendReport = false;
            // Has the report interval date been passed?
            if ($aAdvertiser['reportlastdate'] == OA_Dal::noDateString()) {
                $sendReport = true;
                $oReportLastDate = null;
            } else {
                $oNowDate = new Date();
                $oReportLastDate = new Date($aAdvertiser['reportlastdate']);
                $oSpan = new Date_Span();
                $oSpan->setFromDateDiff($oReportLastDate, $oNowDate);
                $daysSinceLastReport = (int) floor($oSpan->toDays());
                if ($daysSinceLastReport >= $aAdvertiser['reportinterval']) {
                    $sendReport = true;
                }
            }
            if ($sendReport) {
                // Prepare the end date of the report
                $oReportEndDate = new Date();
                $oReportEndDate->setHour(0);
                $oReportEndDate->setMinute(0);
                $oReportEndDate->setSecond(0);
                $oReportEndDate->subtractSeconds(1);
                // Send the advertiser's campaign delivery report
                $oEmail = new OA_Email();
                $oEmail->sendPlacementDeliveryEmail($aAdvertiser['clientid'], $oReportLastDate, $oReportEndDate);
            }
        }
        OA::debug('  Finished sending advertiser "campaign delivery" reports.', PEAR_LOG_DEBUG);
    }

    /**
     * A private method to run OpenX Sync.
     *
     * @access private
     */
    function _runOpenadsSync()
    {
        OA::debug('  Starting OpenX Sync process.', PEAR_LOG_DEBUG);
        if ($this->aConf['sync']['checkForUpdates']) {
            require_once MAX_PATH . '/lib/OA/Sync.php';
            $oSync = new OA_Sync($this->aConf, $this->aPref);
            $res = $oSync->checkForUpdates(0);
            if ($res[0] != 0 && $res[0] != 800) {
                OA::debug("OpenX Sync error ($res[0]): $res[1]", PEAR_LOG_INFO);
            }
        }
        OA::debug('  Finished OpenX Sync process.', PEAR_LOG_DEBUG);
    }



    /**
     * A private method to run OpenX Central related tasks.
     *
     * @access private
     */
    function _runOpenadsCentral()
    {
        OA::debug('  Starting OpenX Central process.', PEAR_LOG_DEBUG);
        if ($this->aConf['sync']['checkForUpdates'] && OA_Dal_ApplicationVariables::get('sso_admin'))
        {
            require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
            $oAdNetworks = new OA_Central_AdNetworks();
            $result = $oAdNetworks->getRevenue();
            if (PEAR::isError($result)) {
                OA::debug("OpenX Central error (".$result->getCode()."): ".$result->getMessage(), PEAR_LOG_INFO);
            }
        }
        OA::debug('  Finished OpenX Central process.', PEAR_LOG_DEBUG);
    }

    function _runPriorityPruning()
    {
        $oDal = new OA_Maintenance_Pruning();
        $oDal->run();
    }

    function _runDeleteUnverifiedAccounts()
    {
        $oPlugin = OA_Auth::staticGetAuthPlugin();
        $oPlugin->deleteUnverifiedUsers($this);
    }

    function _startProcessDebugMessage($processName)
    {
        OA::debug('  Starting OpenX '.$processName.' process.', PEAR_LOG_DEBUG);
    }

    function _stopProcessDebugMessage()
    {
        OA::debug('  Starting OpenX '.$processName.' process.', PEAR_LOG_DEBUG);
    }

    function _debugIfError($processName, $error)
    {
        if (PEAR::isError($error)) {
            OA::debug("OpenX $processName error (".$error->getCode()."): "
                . $error->getMessage(), PEAR_LOG_INFO);
        }
    }

    /**
     * A private method to run the "midnight" general pruning tasks.
     *
     * @access private
     */
    function _runGeneralPruning()
    {
        // Calculate the date before which it is valid to prune data
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oNowDate =& $oServiceLocator->get('now');
        if (is_null($oNowDate) || !is_a($oNowDate, 'Date')) {
            return;
        }
        $oPruneDate = new Date();
        $oPruneDate->copy($oNowDate);
        $oPruneDate->subtractSeconds(OA_MAINTENANCE_FIXED_PRUNING * SECONDS_PER_DAY);
        $oFormattedPruneDate = $this->oDbh->quote($oPruneDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
        $oFormattedPruneTimestamp = $this->oDbh->quote($oPruneDate->getTime(), 'integer');
        // Prune old data from the log_maintenance_statistics table
        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->whereAdd("start_run < $oFormattedPruneDate");
        $doLog_maintenance_statistics->delete(true);
        // Prune old data from the log_maintenance_priority table
        $doLog_maintenance_priority = OA_Dal::factoryDO('log_maintenance_priority');
        $doLog_maintenance_priority->whereAdd("start_run < $oFormattedPruneDate");
        $doLog_maintenance_priority->delete(true);
        // Prune old data from the userlog table
        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->whereAdd("timestamp < $oFormattedPruneTimestamp");
        $doUserlog->delete(true);
    }

    /**
     * A method to update maintenance last run information for
     * old maintenance code.
     */
    function updateLastRun($bScheduled = false)
    {
        $sField = $bScheduled ? 'maintenance_cron_timestamp' : 'maintenance_timestamp';
        OA_Dal_ApplicationVariables::set($sField, OA::getNow('U'));

        // Make sure that the maintenance delivery cache is regenerated
        MAX_cacheCheckIfMaintenanceShouldRun(false);
    }
}

?>
