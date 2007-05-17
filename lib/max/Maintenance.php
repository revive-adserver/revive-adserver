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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';
require_once MAX_PATH . '/scripts/maintenance/translationStrings.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';
require_once MAX_PATH . '/lib/OA/Email.php';
require_once 'Date.php';

/**
 * A library class for providing common maintenance process methods.
 *
 * @package    Max
 * @author     Andrew Hill <andrew.hill@opends.org>
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class MAX_Maintenance
{
    var $oDbh;
    var $conf;
    var $pref;

    function MAX_Maintenance()
    {
        $this->conf = $GLOBALS['_MAX']['CONF'];
        $this->pref = $GLOBALS['_MAX']['PREF'];

        // Get a connection to the datbase
        $this->oDbh = &OA_DB::singleton();
        if (PEAR::isError($this->oDbh)) {
            // Unable to continue!
            MAX::raiseError($this->oDbh, null, PEAR_ERROR_DIE);
        }
    }

    /**
     * A method to run maintenance
     */
    function run()
    {
        // Acquire the maintenance lock
        $oLock =& OA_DB_AdvisoryLock::factory();

        if ($oLock->get(OA_DB_ADVISORYLOCK_MAINTENANCE)) {
            OA::debug('Running Maintenance Statistics and Priority', PEAR_LOG_INFO);

            // Update the timestamp for old maintenance code and auto-maintenance
            $this->updateLastRun();

            // Record the current time, and register with the ServiceLocator
            $oDate = new Date();
            $oServiceLocator = &ServiceLocator::instance();
            $oServiceLocator->register('now', $oDate);

            // Check the operation interval is valid
            $result = MAX_OperationInterval::checkOperationIntervalValue($this->conf['maintenance']['operationInterval']);
            if (PEAR::isError($result)) {
                // Unable to continue!
                MAX::raiseError($result, null, PEAR_ERROR_DIE);
            }

            // Create lockfile, if required
            $this->getLock();

            // Run the Maintenance Statistics Engine (MSE) process
            $this->runMSE();

            // Run Midnight phpAdsNew Tasks
            $this->runMidnightTasks();

            // Release lock before starting MPE
            $oLock->release();

            // Run the Maintenance Priority Engine (MPE) process, ensuring that the
            // process always runs, even if instant update of priorities is disabled
            $this->runMPE();

            // Remove lockfile, if required
            $this->releaseLock();

            OA::debug('Maintenance Statistics and Priority Completed', PEAR_LOG_INFO);
        }
    }

    /**
     * A method to run MSE
     */
    function runMSE()
    {
        MAX_Maintenance_Statistics::run();
    }

    /**
     * A method to run midnight maintenance tasks
     */
    function runMidnightTasks()
    {
        if (date('H') == 0) {
            OA::debug('Running Midnight Maintenance Tasks', PEAR_LOG_INFO);
            $this->runReports();
            $this->runOpenadsSync();
            OA::debug('Midnight Maintenance Tasks Completed', PEAR_LOG_INFO);
        }
    }

    /**
     * A method to run MPE
     */
    function runMPE()
    {
        MAX_Maintenance_Priority::run(true);
    }

    /**
     * A method to send the "midnight" reports during maintenance - that
     * is, the delivery information report, showing what the campaign(s)
     * have delivered since the last time the report was sendt.
     */
    function runReports()
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
                $aEmail = OA_Email::preparePlacementDeliveryEmail($aAdvertiser['clientid'], $oReportLastDate, $oReportEndDate);
                if ($aEmail !== false) {
                    OA_Email::sendMail($aEmail['subject'], $aEmail['contents'], $aEmail['userEmail'], $aEmail['userName']);
                    // Update the last run date to "today"
                    OA::debug('   - Updating the date the report was last sent for advertiser ID ' . $aAdvertiser['clientid'] . '.', PEAR_LOG_DEBUG);
                    $doUpdateClients = OA_Dal::factoryDO('clients');
                    $doUpdateClients->clientid = $aAdvertiser['clientid'];
                    $doUpdateClients->reportlastdate = OA::getNow();
                    $doUpdateClients->update();
                }
            }
        }
        OA::debug('  Finished sending advertiser "campaign delivery" reports.', PEAR_LOG_DEBUG);
    }

    /**
     * A method to run Openads Sync
     */
    function runOpenadsSync()
    {
        OA::debug('  Starting Openads Sync process.', PEAR_LOG_DEBUG);

        if ($pref['updates_enabled'] == 't') {
            require_once (MAX_PATH . '/lib/max/OpenadsSync.php');

            $oSync = new MAX_OpenadsSync($this->conf, $this->pref);
            $res = $oSync->checkForUpdates(0, true);

            if ($res[0] != 0 && $res[0] != 800) {
                OA::debug("Openads Sync error ($res[0]): $res[1]", PEAR_LOG_INFO);
            }
        }

        OA::debug('  Finished Openads Sync process.', PEAR_LOG_DEBUG);
    }

    /**
     * A method to get maintenance lock
     */
    function getLock()
    {
        // If split tables, check for lockfile
        if ($this->conf['table']['split']) {
            OA::debug('Checking for lockfile', PEAR_LOG_INFO);
            $attempt = 0;
            // Don't start if lockfile detected
            while (file_exists($this->conf['table']['lockfile'])) {
                if ($attempt > 2) {
                    // Give up on maintenance
                    OA::debug('More than 3 attempts, sending email to admin user', PEAR_LOG_ERR);
                    $message  = "Warning! Maintenance was unable to run - the lockfile was found\n";
                    $message .= "in place while trying to start maintenance, even after 3 iterations.\n\n";
                    $message .= "The lockfile used was: {$this->conf['table']['lockfile']}.\n\n";
                    $query = "
                        SELECT
                            admin_email
                        FROM
                            {$this->conf['table']['prefix']}{$this->conf['table']['preference']}
                        WHERE
                            agencyid = 0
                        ";
                    $row = $this->oDbh->queryRow($query);
                    OA_Email::sendMail('Lockfile altert!', $message, $row['admin_email'], '');
                    MAX::raiseError('Aborting script execution', null, PEAR_ERROR_DIE);
                }
                // Pause for 30 secs
                OA::debug('Lockfile exists, sleeping for 30 secs. Iteration ' . $attempt, PEAR_LOG_INFO);
                sleep(30);
                $attempt ++;
            }
            // Write lockfile so table splitting scripts will abort if they
            // attempt to start during a maintenance run
            OA::debug('No lockfile exists, writing lockfile', PEAR_LOG_INFO);
            $fh = fopen($this->conf['table']['lockfile'], 'w');
        }
    }

    /**
     * A method to release maintenance lock
     */
    function releaseLock()
    {
        if ($this->conf['table']['split']) {
            OA::debug('Removing lockfile', PEAR_LOG_INFO);
            unlink($this->conf['table']['lockfile']);
        }
    }

    /**
     * A method to update maintenance last run information for old maintenance code
     */
    function updateLastRun($bScheduled = false)
    {
        $sField = $bScheduled ? 'maintenance_cron_timestamp' : 'maintenance_timestamp';

        // Update the timestamp (for old maintenance code)
        // TODO: Move this query to the DAL, so that other code (tests, installation) can call it.
        OA::debug('Updating the timestamp in the preference table', PEAR_LOG_DEBUG);
        $query = "
            UPDATE
                {$this->conf['table']['prefix']}{$this->conf['table']['preference']}
            SET
                {$sField} = UNIX_TIMESTAMP('". OA::getNow() ."')";
        $rows = $this->oDbh->exec($query);
    }
}

?>
