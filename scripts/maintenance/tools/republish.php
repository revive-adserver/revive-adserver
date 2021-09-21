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
 * A script that can be run to process orphaned data when running OpenX in distributed mode,
 * the 'orphaned' data is bucket data which arrived in the central server, after central maintenace
 * had already processed that time period
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

define('INTERVAL_START', $argv[2]);
define('INTERVAL_END', $argv[3]);

/***************************************************************************/

// Initialise the OpenX environment....
$path = dirname(__FILE__);
require_once $path . '/../../../init.php';

// Required files
require_once LIB_PATH . '/OperationInterval.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseIntermediate.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseFinal.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once LIB_PATH . '/Dal/Maintenance/Statistics/Factory.php';
require_once OX_PATH . '/lib/pear/Date.php';

// Standard messages
$haltMessage = "\nThe " . basename(__FILE__) . " script will NOT be run.\n\n";

/***************************************************************************/

if (!defined('INTERVAL_START') || !defined('INTERVAL_END')) {
    echo "
Please ensure that you have read the comments in the " . basename(__FILE__) . " script, to ensure that
you fully understand the types of issues with data that the script will address - this script is NOT a
general panacea for every possible kind of data problem!

You will also find out how to make this script work by reading the comments. :-)
";
    echo $haltMessage;
    exit;
}

/***************************************************************************/

// Initialise the script
RV::disableErrorHandling();
$result = OX_OperationInterval::checkOperationIntervalValue(OX_OperationInterval::getOperationInterval());
RV::enableErrorHandling();
if (PEAR::isError($result)) {
    $message = "\nThe operation interval in your OpenX configuration file is not valid. Please see the OpenX\ndocumentation for more details on valid operation interval values.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

$oStartDate = new Date(INTERVAL_START);
$result = OX_OperationInterval::checkDateIsStartDate($oStartDate);
if (!$result) {
    $message = "\nThe start date passed into the " . basename(__FILE__) . " script is not a valid operation interval start date.\nPlease pass in the start date in '%Y-%M-%d %H:%m:%s' format\n";
    echo $message;
    echo $haltMessage;
    exit;
}
$oEndDate = new Date(INTERVAL_END);
$result = OX_OperationInterval::checkDateIsEndDate($oEndDate);
if (!$result) {
    $message = "\nThe end date passed into the " . basename(__FILE__) . " script is not a valid operation interval end date.\nPlease pass in the end date in '%Y-%M-%d %H:%m:%s' format.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

$oMigrator = new OX_Maintenance_Statistics_Task_MigrateBucketData();
if (PEAR::isError($oMigrator->oDbh)) {
    $message = "\nUnable to connect to the OpenX database.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

/***************************************************************************/

// Advise the user of the operations that will be performed, and ask for
// permission before running.
echo "
The " . basename(__FILE__) . " script will look for any data_bkt_% records which are 'orphaned', and will perform summarisation of these records
for all operation intervals between '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "' and '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'.

Please ensure that you have read the comments in the " . basename(__FILE__) . " script

Depending on the speed of your database, this may take a long time to run. You may want to temporarily
disable your central maintenance script while this script runs.

Do you want to proceed with the republishing? [y/N]: ";

if (empty($argv[4]) || ($argv[4] != '-f')) {
    $response = trim(fgets(STDIN));
    if ($response != 'y' && $response != 'Y') {
        echo $haltMessage;
        exit;
    }
    echo "\n";
}

/***************************************************************************/

$oOIStart = new Date(INTERVAL_START);
$oOIEnd = OX_OperationInterval::addOperationIntervalTimeSpan($oOIStart);
$oOIEnd->subtractSeconds(1);

$aRunDates = [];
while ($oOIEnd->before($oEndDate) || $oOIEnd->equals($oEndDate)) {
    echo "Adding " . $oOIStart->format('%Y-%m-%d %H:%M:%S') . "' -> '" . $oOIEnd->format('%Y-%m-%d %H:%M:%S') . " to the list of run dates<br />\n";
    // Store the dates
    $oStoreStartDate = new Date();
    $oStoreStartDate->copy($oOIStart);
    $oStoreEndDate = new Date();
    $oStoreEndDate->copy($oOIEnd);
    $aRunDates[] = [
        'start' => $oStoreStartDate,
        'end' => $oStoreEndDate
    ];
    $oOIEnd = OX_OperationInterval::addOperationIntervalTimeSpan($oOIEnd);
    $oOIStart = OX_OperationInterval::addOperationIntervalTimeSpan($oOIStart);
}

// The summariseFinal process requires complete hours (not OI's), so record these too
$oOIStart = new Date(INTERVAL_START);
$oOIEnd = new Date(INTERVAL_START);
$oOIEnd->addSeconds((60 * 60) - 1);

$aRunHours = [];
while ($oOIEnd->before($oEndDate) || $oOIEnd->equals($oEndDate)) {
    echo "Adding " . $oOIStart->format('%Y-%m-%d %H:%M:%S') . "' -> '" . $oOIEnd->format('%Y-%m-%d %H:%M:%S') . " to the list of run dates<br />\n";
    // Store the dates
    $oStoreStartDate = new Date();
    $oStoreStartDate->copy($oOIStart);
    $oStoreEndDate = new Date();
    $oStoreEndDate->copy($oOIEnd);
    $aRunHours[] = [
        'start' => $oStoreStartDate,
        'end' => $oStoreEndDate
    ];
    $oOIEnd->addSeconds(60 * 60);
    $oOIStart->addSeconds(60 * 60);
}

// Create and register an instance of the OA_Dal_Maintenance_Statistics DAL class for the following tasks to use
$oServiceLocator = OA_ServiceLocator::instance();
if (!$oServiceLocator->get('OX_Dal_Maintenance_Statistics')) {
    $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
    $oDal = $oFactory->factory();
    $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
}

$oMigrator->aRunDates = $aRunDates;
$oMigrator->oController->updateIntermediate = true;

echo "Starting migration task...<br />\n";
$result = $oMigrator->run();
echo "Finished! \$result = " . $result . "<br />\n";

// OK, so now we (should?) have moved the orphaned stats from the bucket tables over to the intermediate tables
// We should now wipe out the data_summary table (gulp) and call summariseFinal() for the affected intervals

$oDbh = OA_DB::singleton();
$oMigratorFinal = new OX_Maintenance_Statistics_Task_SummariseFinal();

foreach ($aRunHours as $aDates) {
    echo "Recomputing data_summary_ad_hourly totals from " . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . " -> " . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "<br />\n";
    $query = "DELETE FROM " . $oDbh->quoteIdentifier($conf['table']['prefix'] . 'data_summary_ad_hourly', true) . " WHERE date_time >= '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "' AND date_time <= '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'";
    $oDbh->exec($query);

    $oMigratorFinal->_saveSummary($aDates['start'], $aDates['end']);
}

echo "\n\nThe " . basename(__FILE__) . " script has completed running!\n\n";

?>
