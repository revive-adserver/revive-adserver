<?php

$scriptName = $argv[0];

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
//define('INTERVAL_START', '2009-07-15 00:00:00');
//define('INTERVAL_END',   '2009-07-15 00:59:59');

// Initialise the OpenX environment....
$path = dirname(__FILE__);
require_once $path . '/../../../init.php';

// Required files
require_once LIB_PATH . '/OperationInterval.php';
require_once LIB_PATH . '/Maintenance/Statistics/MigrateBucketData.php';
require_once OX_PATH . '/lib/pear/Date.php';

// Standard messages
$haltMessage = "\nThe {$scriptName} script will NOT be run.\n\n";

if ($argc !== 2) {
    echo "
Requires the hostname to be passed in as a string, as per the standard maintenance CLI script.
";
    echo $haltMessage;
    exit;
}

if (!defined('INTERVAL_START') || !defined('INTERVAL_END')) {
    echo "
Please ensure that you have read the comments in the {$scriptName} script.

You will also find out how to make this script work by reading the comments. :-)
";
    echo $haltMessage;
    exit;
}

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
    $message = "\nThe start date defined in the {$scriptName} script is not a valid operation interval start date.\nPlease edit the statisticsTestAndCorrect.php script before running.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

$oEndDate   = new Date(INTERVAL_END);
$result = OX_OperationInterval::checkDateIsEndDate($oEndDate);
if (!$result) {
    $message = "\nThe end date defined in the {$scriptName} script is not a valid operation interval start date.\nPlease edit the statisticsTestAndCorrect.php script before running.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

$oMigrateBucketData = new OX_Maintenance_Statistics_MigrateBucketData();
if (PEAR::isError($oMigrateBucketData->oDbh)) {
    $message = "\nUnable to connect to the OpenX database.\n";
    echo $message;
    echo $haltMessage;
    exit;
}

// Check date range?

// Advise the user of the operations that will be performed, and ask for
// permission before running.
echo "
The {$scriptName} script will summarise the aggegate bucket data in your
OpenX database for all operation intervals between '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "' and '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'.

Please ensure that you have read the comments in the {$scriptName} script.

Depending on the speed of your database, this may take a long time to run. You may want to temporarily
disable your central maintenance script while this script runs.

Do you want to proceed with the summarisation process? [y/N]: ";

$response = trim(fgets(STDIN));
if (!($response == 'y' || $response == 'Y')) {
    echo $haltMessage;
    exit;
}
echo "\n";

// For each OA in the range

$oMigrateBucketData->summarise($oStartDate, $oEndDate);
