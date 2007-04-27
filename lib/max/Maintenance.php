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
require_once MAX_PATH . '/lib/max/other/lib-reports.inc.php';
require_once MAX_PATH . '/scripts/maintenance/translationStrings.php';

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';
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
        $this->conf =& $GLOBALS['_MAX']['CONF'];
        $this->pref =& $GLOBALS['_MAX']['PREF'];

        // Get a connection to the datbase
        $this->oDbh = &OA_DB::singleton();
        if (PEAR::isError($this->oDbh)) {
            // Unable to continue!
            MAX::raiseError($this->oDbh, null, PEAR_ERROR_DIE);
        }
    }

    /**
     * A method for premaring e-mails, advising of the activation of campaigns.
     *
     * @static
     * @param string $contactName The name of the campaign contact.
     * @param string $campaignName The name of the deactivated campaign.
     * @param array $ads A reference to an array of ads
     *                              in the campaign, indexed by ad_id,
     *                              of an array containing the description, alt
     *                              description, and  destination URL of the
     *                              ad.
     * @return string The email that has been prepared.
     */
    function prepareActivateCampaignEmail($contactName, $campaignName, &$ads)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $message  = "Dear $contactName,\n\n";
        $message .= 'The following ads have been activated because ' . "\n";
        $message .= 'the campaign activation date has been reached.';
        $message .= "\n\n";
        $message .= "-------------------------------------------------------\n";
        foreach ($ads as $ad_id => $data) {
            $message .= "Ad [ID $ad_id] ";
            if ($data[0] != '') {
                $message .= $data[0];
            } elseif ($data[1] != '') {
                $message .= $data[1];
            } else {
                $message .= 'Untitled';
            }
            $message .= "\n";
            $message .= "Linked to: {$data[2]}\n";
            $message .= "-------------------------------------------------------\n";
        }
        $message .= "\nThank you for advertising with us.\n\n";
        $message .= "Regards,\n\n";
        $message .= $conf['email']['admin_name'];
        return $message;
    }

    /**
     * A method for preparing e-mails, advising of the deactivation of campaigns.
     *
     * @static
     * @param string $contactName The name of the campaign contact.
     * @param string $campaignName The name of the deactivated campaign.
     * @param integer $reason A binary flag field containting the reason(s) the campaign
     *                        was deactivated:
     *                        2  - No more impressions
     *                        4  - No more clicks
     *                        8  - No more conversions
     *                        16 - Campaign ended (due to date)
     * @param array $ads A reference to an array of ads
     *                              in the campaign, indexed by ad_id,
     *                              of an array containing the description, alt
     *                              description, and  destination URL of the
     *                              ad.
     * @return string The email that has been prepared.
     */
    function prepareDeactivateCampaignEmail($contactName, $campaignName, $reason, &$ads)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $message  = "Dear $contactName,\n\n";
        $message .= 'The following ads have been disabled because:' . "\n";
        if ($reason & MAX_PLACEMENT_DISABLED_IMPRESSIONS) {
            $message .= '  - There are no impressions remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_CLICKS) {
            $message .= '  - There are no clicks remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_CONVERSIONS) {
            $message .= '  - There are no conversions remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_DATE) {
            $message .= '  - The campaign deactivation date has been reached' . "\n";
        }
        $message .= "\n";
        $message .= '-------------------------------------------------------' . "\n";
        foreach ($ads as $ad_id => $data) {
            $message .= "Ad [ID $ad_id] ";
            if ($data[0] != '') {
                $message .= $data[0];
            } elseif ($data[1] != '') {
                $message .= $data[1];
            } else {
                $message .= 'Untitled';
            }
            $message .= "\n";
            $message .= "Linked to: {$data[2]}\n";
            $message .= '-------------------------------------------------------' . "\n";
        }
        $message .= "\n" . 'If you would like to continue advertising on our website,' . "\n";
        $message .= 'please feel free to contact us.' . "\n";
        $message .= 'We\'d be glad to hear from you.' . "\n\n";
        $message .= 'Regards,' . "\n\n";
        $message .= "{$conf['email']['admin_name']}";
        return $message;
    }

    /**
     * A method to run maintenance
     */
    function run()
    {
        // Acquire the maintenance lock
        $oLock =& OA_DB_AdvisoryLock::factory();

        if ($oLock->get(OA_DB_ADVISORYLOCK_MAINTENANCE)) {
            MAX::debug('Running Maintenance Statistics and Priority', PEAR_LOG_INFO);

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

            MAX::debug('Maintenance Statistics and Priority Completed', PEAR_LOG_INFO);
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
            MAX::debug('Running Midnight Maintenance Tasks', PEAR_LOG_INFO);
            $this->runReports();
            $this->runOpenadsSync();
            MAX::debug('Midnight Maintenance Tasks Completed', PEAR_LOG_INFO);
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
     * A method to send reports during maintenance
     */
    function runReports()
    {
        MAX::debug('  Starting to send advertiser reports.', PEAR_LOG_DEBUG);
        $query = "
            SELECT
                clientid,
                report,
                reportinterval,
                reportlastdate,
                UNIX_TIMESTAMP(reportlastdate) AS reportlastdate_t
            FROM
                {$this->conf['table']['prefix']}{$this->conf['table']['clients']}
            WHERE
                report = 't'";
        MAX::debug('  Getting details of when advertiser reports were last sent.', PEAR_LOG_DEBUG);
        $rResult = phpAds_dbQuery($query);
        if (phpAds_dbNumRows($rResult) > 0) {
            while ($aAdvertiser = phpAds_dbFetchArray($rResult)) {
                // Determine date of interval days ago
                $intervaldaysago = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - ($aAdvertiser['reportinterval'] * (60 * 60 * 24));
                // Check if the date interval has been reached
                if (($aAdvertiser['reportlastdate_t'] <= $intervaldaysago && $aAdvertiser['reportlastdate'] != '0000-00-00') || ($aAdvertiser['reportlastdate'] == '0000-00-00')) {
                    // Determine first and last date
                    $last_unixtimestamp  = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
                    $first_unixtimestamp = $aAdvertiser['reportlastdate_t'];
                    // Send the advertiser's report
                    phpAds_SendMaintenanceReport($aAdvertiser['clientid'], $first_unixtimestamp, $last_unixtimestamp, true);
                }
            }
        }
        MAX::debug('  Finished sending advertiser reports.', PEAR_LOG_DEBUG);
    }

    /**
     * A method to run Openads Sync
     */
    function runOpenadsSync()
    {
        MAX::debug('  Starting Openads Sync process.', PEAR_LOG_DEBUG);

        if ($pref['updates_enabled'] == 't') {
            require_once (MAX_PATH . '/lib/max/OpenadsSync.php');

            $oSync = new MAX_OpenadsSync($this->conf, $this->pref);
            $res = $oSync->checkForUpdates(0, true);

            if ($res[0] != 0 && $res[0] != 800) {
                MAX::debug("Openads Sync error ($res[0]): $res[1]", PEAR_LOG_INFO);
            }
        }

        MAX::debug('  Finished Openads Sync process.', PEAR_LOG_DEBUG);
    }

    /**
     * A method to get maintenance lock
     */
    function getLock()
    {
        // If split tables, check for lockfile
        if ($this->conf['table']['split']) {
            MAX::debug('Checking for lockfile', PEAR_LOG_INFO);
            $attempt = 0;
            // Don't start if lockfile detected
            while (file_exists($this->conf['table']['lockfile'])) {
                if ($attempt > 2) {
                    // Give up on maintenance
                    MAX::debug('More than 3 attempts, sending email to admin user', PEAR_LOG_ERR);
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
                    MAX::sendMail($row['admin_email'], '', 'Lockfile altert!', $message);
                    MAX::raiseError('Aborting script execution', null, PEAR_ERROR_DIE);
                }
                // Pause for 30 secs
                MAX::debug('Lockfile exists, sleeping for 30 secs. Iteration ' . $attempt, PEAR_LOG_INFO);
                sleep(30);
                $attempt ++;
            }
            // Write lockfile so table splitting scripts will abort if they
            // attempt to start during a maintenance run
            MAX::debug('No lockfile exists, writing lockfile', PEAR_LOG_INFO);
            $fh = fopen($this->conf['table']['lockfile'], 'w');
        }
    }

    /**
     * A method to release maintenance lock
     */
    function releaseLock()
    {
        if ($this->conf['table']['split']) {
            MAX::debug('Removing lockfile', PEAR_LOG_INFO);
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
        MAX::debug('Updating the timestamp in the preference table', PEAR_LOG_DEBUG);
        $query = "
            UPDATE
                {$this->conf['table']['prefix']}{$this->conf['table']['preference']}
            SET
                {$sField} = UNIX_TIMESTAMP('". OA::getNow() ."')";
        $rows = $this->oDbh->exec($query);
    }
}

?>
