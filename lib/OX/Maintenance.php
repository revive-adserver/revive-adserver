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
require_once MAX_PATH . '/scripts/maintenance/translationStrings.php';

require_once OX_PATH . '/lib/OX.php';


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
require_once MAX_PATH . '/lib/OA/Maintenance/Pruning.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * A library class for providing common maintenance process methods.
 *
 * @package    OpenXMaintenance
 * @author     Andrew Hill <andrew.hill@opends.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OX_Maintenance
{
    var $oDbh;
    var $aConf;
    var $aPref;

    function OX_Maintenance()
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
        if ($oLock->get(OA_DB_ADVISORYLOCK_MAINTENANCE)) {
            OA::switchLogIdent('maintenance');
            OA::debug();
            OA::debug('Running Maintenance Engine', PEAR_LOG_INFO);
            // Attempt to increase PHP memory
            OX_increaseMemoryLimit(OX_getMinimumRequiredMemory('maintenance'));
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
            $result = OX_OperationInterval::checkOperationIntervalValue($this->aConf['maintenance']['operationInterval']);
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
            // Log the completion of the entire ME process
            OA::switchLogIdent('maintenance');
            $oEndDate = new Date();
            $oDateSpan = new Date_Span();
            $oDateSpan->setFromDateDiff($oDate, $oEndDate);
            OA::debug('Maintenance Engine Completed (Started at ' .
                      $oDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oDate->tz->getShortName() .
                      ', taking ' . $oDateSpan->format('%H:%M:%S') .
                      ')', PEAR_LOG_INFO);
            OA::switchLogIdent();
        } else {
            OA::switchLogIdent('maintenance');
			OA::debug('Maintenance Engine not run: could not acquire lock', PEAR_LOG_INFO);
			OA::switchLogIdent();
        }
    }

    /**
     * A private method to run MSE.
     *
     * @access private
     */
    function _runMSE()
    {
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->run();
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
        global $serverTimezone;

        if (empty($oLastRun)) {
            return true;
        }

        $oServiceLocator = &OA_ServiceLocator::instance();
        $lastMidnight = new Date($oServiceLocator->get('now'));
        if (!empty($serverTimezone)) {
            $lastMidnight->convertTZbyID($serverTimezone);
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
        $this->_runGeneralPruning();
        $this->_runPriorityPruning();
        $this->_runDeleteUnverifiedAccounts();
        $this->_runReviveSync();
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
            if (empty($aAdvertiser['reportlastdate'])) {
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
                // Send the advertiser's campaign delivery report
                $oEmail = new OA_Email();
                $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oReportLastDate);
            }
        }
        OA::debug('  Finished sending advertiser "campaign delivery" reports.', PEAR_LOG_DEBUG);
    }

    /**
     * A private method to run Revive Adserver Sync.
     *
     * @access private
     */
    function _runReviveSync()
    {
        $delay = mt_rand(0, 30); // Delay up to 30 seconds
        OA::debug(sprintf('Delaying ' . PRODUCT_NAME . ' sync process by %d seconds.', $delay), PEAR_LOG_INFO);
        sleep($delay);
        require_once MAX_PATH . '/lib/RV/Sync.php';
        $oSync = new RV_Sync($this->aConf, $this->aPref);
        $oSync->checkForUpdates(0);
        OA::debug('Finished ' . PRODUCT_NAME . ' Sync process.', PEAR_LOG_INFO);
    }



    function _runPriorityPruning()
    {
        if (empty($GLOBALS['_MAX']['CONF']['maintenance']['pruneDataTables'])) {
            return;
        }
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
        if (empty($GLOBALS['_MAX']['CONF']['maintenance']['pruneDataTables'])) {
            return;
        }
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