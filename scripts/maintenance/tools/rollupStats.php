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
 * A script that can be run to execute the stats rollup code indepenent of the core
 * maintenance script.
 *
 * @param string Requires the hostname to be passed in as a string, as per
 *               the standard maintenance CLI script.
 */

/***************************************************************************/

// Initialise the OpenX environment....
$path = dirname(__FILE__);
require_once $path . '/../../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Maintenance/RollupStats.php';

$matches = [];
if (empty($argv[2])) {
    echo "You must provide the date before which stats should be rolled up! (in YYYY-MM-DD format please)\n";
    exit;
} elseif (!preg_match('/(\d{4})-(\d{2})-(\d{2})/', $argv[2], $matches)) {
    echo "The date you passed in ({$argv[2]}) does not appear to be in YYYY-MM-DD format\n";
}
if ($matches[1] > 2032 || $matches[1] < 1970) {
    echo "Invalid year ({$matches[1]}) passed in\n";
    exit;
} elseif ($matches[2] > 12) {
    echo "Invalid month ({$matches[2]}) passed in";
    exit;
} elseif ($matches[3] > 31) {
    echo "Invalid date ({$matches[3]}) passed in\n";
    exit;
}

$oDate = new Date($argv[2]);

$oRollupStats = new OA_Maintenance_RollupStats();
$oRollupStats->run($oDate);

?>
