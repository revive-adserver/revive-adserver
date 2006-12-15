#!/usr/bin/php -q
<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

/**
 * A script file to run the Maintenance Statistics Engine and the
 * Maintenance Priority Engine processes.
 */

// Require the initialisation file
// Done differently from elsewhere so that it works in CLI MacOS X
$path = dirname(__FILE__);
require_once $path . '/../../init.php';

// Required files
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';
require_once MAX_PATH. '/scripts/maintenance/translationStrings.php';
require_once 'Date.php';

MAX::debug('Running Maintenance Statistics and Priority', PEAR_LOG_INFO);

// Record the current time, and register with the ServiceLocator
$oDate = new Date();
$oServiceLocator = &ServiceLocator::instance();
$oServiceLocator->register('now', $oDate);

// Get a connection to the datbase
$dbh = &MAX_DB::singleton();
if (PEAR::isError($dbh)) {
    // Unable to continue!
    MAX::raiseError($dbh, null, PEAR_ERROR_DIE);
}

// Check the operation interval is valid
$result = MAX_OperationInterval::checkOperationIntervalValue($conf['maintenance']['operationInterval']);
if (PEAR::isError($result)) {
    // Unable to continue!
    MAX::raiseError($result, null, PEAR_ERROR_DIE);
}

// If split tables, check for lockfile
if ($conf['table']['split']) {
    MAX::debug('Checking for lockfile', PEAR_LOG_INFO);
    $attempt = 0;
    // Don't start if lockfile detected
    while (file_exists($conf['table']['lockfile'])) {
        if ($attempt > 2) {
            // Give up on maintenance
            MAX::debug('More than 3 attempts, sending email to admin user', PEAR_LOG_ERR);
            $message  = "Warning! Maintenance was unable to run - the lockfile was found\n";
            $message .= "in place while trying to start maintenance, even after 3 iterations.\n\n";
            $message .= "The lockfile used was: {$conf['table']['lockfile']}.\n\n";
            $query = "
                SELECT
                    admin_email
                FROM
                    {$conf['table']['prefix']}{$conf['table']['preference']}
                WHERE
                    agencyid = 0
                ";
            $row = $dbh->getRow($query);
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
    $fh = fopen($conf['table']['lockfile'], 'w');
}

// Run the Maintenance Statistics Engine (MSE) process
MAX_Maintenance_Statistics::run();

// Run Midnight phpAdsNew Tasks
if (date('H') == 0) {
    MAX::debug('Running Midnight Maintenance Tasks', PEAR_LOG_INFO);
    include_once MAX_PATH . '/scripts/maintenance/maintenance-reports.php';
    include_once MAX_PATH . '/scripts/maintenance/maintenance-openadssync.php';
    MAX::debug('Midnight Maintenance Tasks Completed', PEAR_LOG_INFO);
}

// Run the Maintenance Priority Engine (MPE) process, ensuring that the
// process always runs, even if instant update of priorities is disabled
MAX_Maintenance_Priority::run(true);

// Remove lockfile, if required
if ($conf['table']['split']) {
    MAX::debug('Removing lockfile', PEAR_LOG_INFO);
    unlink($conf['table']['lockfile']);
}

// Update the timestamp (for old maintenance code)
// TODO: Move this query to the DAL, so that other code (tests, installation) can call it.
MAX::debug('Updating the timestamp in the preference table', PEAR_LOG_DEBUG);
$query = "
    UPDATE
        {$conf['table']['prefix']}{$conf['table']['preference']}
    SET
        maintenance_timestamp = UNIX_TIMESTAMP(NOW())";
$result = $dbh->query($query);

MAX::debug('Maintenance Statistics and Priority Completed', PEAR_LOG_INFO);

?>
