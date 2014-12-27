#!/usr/bin/php -q
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

/**
 * @package    OpenXMaintenance
 * @subpackage Tools
 *
 * A script that can be run to correct issues with statistics.
 *
 * The bucket-based logging system (see
 * https://developer.openx.org/wiki/display/COMM/Buckets) introduced in
 * OpenX 2.7-beta now means that "logged" data is now deleted immediately
 * after it has been migrated to an upstream server (if running OpenX in
 * distributed statistics mode), and immediately after if has been
 * summarised into the statistics table(s) (data_intermediate_%, stats_%)
 * on the central database.
 *
 * As a result, there is no longer the possibility of double-counting
 * "raw" data as there was with OpenX 2.4 or 2.6.
 *
 * However, there are two ways that data could be "incorrect" in
 * OpenX 2.7-beta:
 *
 * - Firstly, if the maintenance engine has failed to complete running
 *   correctly, it is possible (although unlikely) that the data in the
 *   data_intermediate_% tables was migrated to the data_summary_% tables,
 *   but the fact this this occurred was not recorded. In this event,
 *   the data_summary_% tables may contain 2, or 3, or 4, or more times
 *   the number of requests, impressions, clicks and conversions than
 *   in the data_intermediate_% tables, depending on how many times the
 *   same hour is summarised.
 *
 * - Secondly, when running OpenX in distributed statistics mode, it is
 *   possible that not all bucket data from the delivery servers was
 *   correctly in place on the central database server when the central
 *   maintenance process ran.
 *
 * To address the above issues, this script carries out two different
 * tests/corrections over the date range defined:
 *
 * - If, for any hour/creative/zone combinations, the data_summary_% tables
 *   have a higher number of requests, impressions, clicks and conversions
 *   than are stored in the corresponding data_intermediate_% tables,
 *   and the differences are a multiple of those in the data_intermediate_%
 *   tables, then the data_sumamry_% tables are reset back to the original
 *   values from the data_intermediate_% tables. (This is the correction
 *   for any multiple-summarisation-of-an-hour issues.)
 *
 * - If, for any hour/creative/zone combinations, the data_summary_% tables
 *   have fewer requests, impressions, clicks and conversions that are stored
 *   in the corresponding data_intermediate_% tables, then the data_summary_%
 *   tables are updated to the higher data_intermediate_% tables values.
 *   (This is the correction for any missing-bucket-data-when-first-summarised
 *   issues.)
 *
 * @param string Requires the hostname to be passed in as a string, as per
 *               the standard maintenance CLI script.
 */

/**
 * The start and end date/times of the first and last operation intervals to
 * operate over must be defined in this script before running. For example,
 * with a standard operation interval of 60 minutes, if INTERVAL_START is set
 * to"2009-02-10 12:00:00" and INTERVAL_END is set to "2009-02-11 10:59:59",
 * then all of the data between "2009-02-10 12:00:00" and
 * "2009-02-11 10:59:59" will be inspected and corrected as required.
 *
 * The define statements below will need to be un-commented for the script
 * to be able to be run!
 */
//define('INTERVAL_START', '2009-02-01 00:00:00');
//define('INTERVAL_END',   '2009-02-01 23:59:59');

/**
 * Comment the following line out to disable the debug-only mode
 */
define('DEBUG_ONLY', true);

/***************************************************************************/

// Initialise the OpenX environment....
$path = dirname(__FILE__);
require_once $path . '/../../../init.php';

// Required files
require_once LIB_PATH . '/OperationInterval.php';
require_once LIB_PATH . '/Maintenance/Statistics/TestAndCorrect.php';
require_once OX_PATH . '/lib/pear/Date.php';

// Standard messages
$haltMessage = "\nThe statisticsTestAndCorrect.php script will NOT be run.\n\n";

/***************************************************************************/

if (!defined('INTERVAL_START') || !defined('INTERVAL_END')) {
    echo "
Please ensure that you have read the comments in the statisticsTestAndCorrect.php script, to ensure that
you fully understand the types of issues with data that the script will address - this script is NOT a
general panacea for every possible kind of data problem!

You will also find out how to make this script work by reading the comments. :-)
";
    echo $haltMessage;
    exit;
}

/***************************************************************************/

// Initialise the script
OX::disableErrorHandling();
$result = OX_OperationInterval::checkOperationIntervalValue(OX_OperationInterval::getOperationInterval());
OX::enableErrorHandling();
if (PEAR::isError($result)) {
    $message = "\nThe operation interval in your OpenX configuration file is not valid. Please see the OpenX\ndocumentation for more details on valid operation interval values.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

$oStartDate = new Date(INTERVAL_START);
$result = OX_OperationInterval::checkDateIsStartDate($oStartDate);
if (!$result) {
    $message = "\nThe start date defined in the statisticsTestAndCorrect.php script is not a valid operation interval start date.\nPlease edit the statisticsTestAndCorrect.php script before running.\n";
    echo $message;
    echo $haltMessage;
    exit;
}
$oEndDate   = new Date(INTERVAL_END);
$result = OX_OperationInterval::checkDateIsEndDate($oEndDate);
if (!$result) {
    $message = "\nThe end date defined in the statisticsTestAndCorrect.php script is not a valid operation interval start date.\nPlease edit the statisticsTestAndCorrect.php script before running.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

$oTestAndCorrect = new OX_Maintenance_Statistics_TestAndCorrect();
if (PEAR::isError($oTestAndCorrect->oDbh)) {
    $message = "\nUnable to connect to the OpenX database.\n";
    echo $message;
    echo $haltMessage;
    exit;
}
$result = $oTestAndCorrect->checkRangeData($oStartDate, $oEndDate);
if (!$result) {
    $message = "\nThe data in the OpenX database that falls within the date range of '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "' to\n'" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "' does not appear to be sufficiently valid for the\nstatisticsTestAndCorrect.php script to be able to correct. Please manually inspect your data,\nand check that, for example, the database tables have not become corrupted, and that the\noperation interval value in use in OpenX is still the same as the value that was in use for\nthe entire date range you are trying to correct.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

/***************************************************************************/

// Advise the user of the operations that will be performed, and ask for
// permission before running.
echo "
The statisticsTestAndCorrect.php script will test and, where required, correct, the statistics data in your
OpenX database for all operation intervals between '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "' and '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'.

Please ensure that you have read the comments in the statisticsTestAndCorrect.php script, to ensure that
you fully understand the types of issues with data that the script will address - this script is NOT a
general panacea for every possible kind of data problem!

Depending on the speed of your database, this may take a long time to run. You may want to temporarily
disable your central maintenance script while this script runs.

Do you want to proceed with the testing & correction process? [y/N]: ";

$response = trim(fgets(STDIN));
if (!($response == 'y' || $response == 'Y')) {
    echo $haltMessage;
    exit;
}
echo "\n";

/***************************************************************************/

// Issue 1: Correct any multiple summarisations of intermediate data into
//          summary data.

echo "
Testing for any instances of statistics rows in the data_intermediate_ad table that have been summarised
into the data_summary_ad_hourly table multiple times. Please be patient while this process runs!
";
$oTestAndCorrect->issueOne($oStartDate, $oEndDate);

/***************************************************************************/

// Issue 2: Correct any non-summarisation of late bucket data that exists
//          in the intermediate tables but not in the summary tables.

echo "
Testing for any instances of statistics rows in the data_intermediate_ad table that have not been fully
summarised into the data_summary_ad_hourly table. Please be patient while this process runs!
";
$oTestAndCorrect->issueTwo($oStartDate, $oEndDate);

/***************************************************************************/

echo "\n\nThe statisticsTestAndCorrect.php script has completed running!\n\n";

?>
