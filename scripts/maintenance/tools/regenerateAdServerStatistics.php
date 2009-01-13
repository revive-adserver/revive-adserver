#!/usr/bin/php -q
<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Maintenance/Regenerate.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once OX_PATH . '/lib/pear/Date.php';

// Create Date objects of the start and end dates, set the "current time"
// to be 5 seconds after the end of the operation interval
$oStartDate = new Date(INTERVAL_START);
$oEndDate   = new Date(INTERVAL_END);
$oNowDate   = new Date(INTERVAL_END);
$oNowDate->addSeconds(5);
$oServiceLocator =& OA_ServiceLocator::instance();
$oServiceLocator->register('now', $oNowDate);


if (OA_Maintenance_Regenerate::checkDates($oStartDate, $oEndDate) == false) {
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

OA_Maintenance_Regenerate::clearIntermediateAndSummaryTables($oStartDate, $oEndDate);

// Ensure emails are not sent due to activation/deactivation effect
define('DISABLE_ALL_EMAILS', 1);

// Set a date to one second before the operation interval, to be used as the last
// time the stats were updated
$oLastUpdatedDate = new Date(INTERVAL_START);
$oLastUpdatedDate->subtractSeconds(1);
$oServiceLocator->register('lastUpdatedDate', $oLastUpdatedDate);

// Run the Maintenance Statistics Engine (MSE) process
OX_Maintenance_Statistics::run();

?>
