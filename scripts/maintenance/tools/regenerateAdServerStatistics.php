#!/usr/bin/php -q
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

/**
 * @package    OpenXMaintenance
 * @subpackage Tools
 * @author     Andrew Hill <andrew.hill@openx.org>
 *
 * A script file to run to re-generate the AdServer statistics for a given
 * interval, in the event that the raw data tables were incorrect when the
 * Maintenance Statistics Engine ran.
 *
 * Requires that the start and end dates of the operation interval to be
 * re-generated are defined at the top of the script before being run
 *
 * @param string Requires the hostname to be passed in as a string.
 */

/**
 * The operation interval start and end dates.
 */
define('INTERVAL_START', '2006-05-09 13:00:00');
define('INTERVAL_END',   '2006-05-09 13:59:59');

/**
 * Perform cookieless conversion regeneration?
 */
$GLOBALS['_MAX']['MSE']['COOKIELESS_CONVERSIONS'] = false;

/***************************************************************************/

$path = dirname(__FILE__);
require_once $path . '/../../../init.php';

// Required files

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

// Create Date objects of the start and end dates, set the "current time"
// to be 5 seconds after the end of the operation interval
$oStartDate = new Date(INTERVAL_START);
$oEndDate   = new Date(INTERVAL_END);
$oNowDate   = new Date(INTERVAL_END);
$oNowDate->addSeconds(5);
$oServiceLocator =& OA_ServiceLocator::instance();
$oServiceLocator->register('now', $oNowDate);

// Check start/end dates - note that check is the reverse of normal check:
// if the operation interval is <= 60, must be start/end of an hour, to
// make sure we update all the operation intervals in the hour, and if
// the operation interval > 60, must be the start/end of an operation
// interval, to make sure we update all the hours in the operation interval.
$datesOkay = true;
$operationInterval = $conf['maintenance']['operation_interval'];
if ($operationInterval <= 60) {
    // Must ensure that only one hour is being summarised
    if (!OA_OperationInterval::checkDatesInSameHour($oStartDate, $oEndDate)) {
        $datesOkay = false;
    }
    // Now check that the start and end dates are match the start and
    // end of the hour
    $oHourStart = new Date();
    $oHourStart->setYear($oStartDate->getYear());
    $oHourStart->setMonth($oStartDate->getMonth());
    $oHourStart->setDay($oStartDate->getDay());
    $oHourStart->setHour($oStartDate->getHour());
    $oHourStart->setMinute('00');
    $oHourStart->setSecond('00');
    $oHourEnd = new Date();
    $oHourEnd->setYear($oEndDate->getYear());
    $oHourEnd->setMonth($oEndDate->getMonth());
    $oHourEnd->setDay($oEndDate->getDay());
    $oHourEnd->setHour($oEndDate->getHour());
    $oHourEnd->setMinute('59');
    $oHourEnd->setSecond('59');
    if (!$oStartDate->equals($oHourStart)) {
        $datesOkay = false;
    }
    if (!$oEndDate->equals($oHourEnd)) {
        $datesOkay = false;
    }
} else {
    // Must ensure that only one operation interval is being summarised
    $operationIntervalID =
        OA_OperationInterval::convertDaySpanToOperationIntervalID($oStartDate, $oEndDate, $operationInterval);
    if (is_bool($operationIntervalID) && !$operationIntervalID) {
        $datesOkay = false;
    }
    // Now check that the start and end dates match the start and end
    // of the operation interval
    list($oOperationIntervalStart, $oOperationIntervalEnd) =
        OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate, $operationInterval);
    if (!$oStartDate->equals($oOperationIntervalStart)) {
        $datesOkay = false;
    }
    if (!$oEndDate->equals($oOperationIntervalEnd)) {
        $datesOkay = false;
    }
}
if ($datesOkay == false) {
    echo "\n" . 'Error: The dates set are not valid. See code comments.' . "\n";
    exit();
}

// Give the user a chance to check the dates that will be used
echo 'Regenerating statistics for the range: "' .
     $oStartDate->format('%Y-%m-%d %H:%M:%S') . '" to "' .
     $oEndDate->format('%Y-%m-%d %H:%M:%S') . '"' . "\n";
echo 'Press CTRL-C within 10 seconds to cancel...' . "\n";
sleep(10);

/***************************************************************************/

// Create a Data Access Layer object
$oDbh = &OA_DB::singleton();

// Find the connections (if any) in the data_intermediate_ad_connection table
$query = "
    SELECT
        data_intermediate_ad_connection_id
    FROM
        {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
    WHERE
        tracker_date_time >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
        AND tracker_date_time <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
$rc = $oDbh->query($query);

// Delete any variable values that are attached to these connections
while ($row = $rc->fetchRow()) {
    $query = "
        DELETE FROM
            {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
        WHERE
            data_intermediate_ad_connection_id = {$row['data_intermediate_ad_connection_id']}";
    $rows = $oDbh->exec($query);
}

// Delete any connections in the data_intermediate_ad_connection table
$query = "
    DELETE FROM
        {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
    WHERE
        tracker_date_time >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
        AND tracker_date_time <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
$rows = $oDbh->exec($query);

// Delete any summary rows from the data_intermediate_ad table
$query = "
    DELETE FROM
        {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
    WHERE
        interval_start = '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
        AND interval_end = '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
$rows = $oDbh->exec($query);

// Delete any summary rows from the data_summary_ad_hourly table
$query = "
    DELETE FROM
        {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
    WHERE
        day >= '" . $oStartDate->format('%Y-%m-%d') . "'
        AND hour >= " . $oStartDate->format('%H') . "
        AND day <= '" . $oEndDate->format('%Y-%m-%d') . "'
        AND hour <= " . $oEndDate->format('%H');
$rows = $oDbh->exec($query);

// Delete any impression history data from the data_summary_zone_impression_history table
$query = "
    DELETE FROM
        {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
    WHERE
        interval_start >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
        AND interval_end <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
$rows = $oDbh->exec($query);

// Delete any impression history data from the data_summary_ad_zone_assoc table
$query = "
    DELETE FROM
        {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
    WHERE
        interval_start >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
        AND interval_end <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
$rows = $oDbh->exec($query);

// Ensure emails are not sent due to activation/deactivation effect
define('DISABLE_ALL_EMAILS', 1);

// Set a date to one second before the operation interval, to be used as the last
// time the stats were updated
$oLastUpdatedDate = new Date(INTERVAL_START);
$oLastUpdatedDate->subtractSeconds(1);
$oServiceLocator->register('lastUpdatedDate', $oLastUpdatedDate);

// Run the Maintenance Statistics Engine (MSE) process
OA_Maintenance_Statistics::run();

?>
