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
 * A script file to run the Maintenance Import Market Statistics task
 *
 * @package    OpenXPlugin
 * @subpackage Tools
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */

// Set the current path
// Done this way so that it works in CLI PHP
$path = dirname(__FILE__);

// Require the initialisation file
require_once $path . '/../../../../init.php';
// Require ImportMarketStatistics class
require_once $path . '/../ImportMarketStatistics.php';

// Require additional classes
require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';

define('ADVISORYLOCK_IMPORT_MARKET_STATS',  99);

// mesure time
$startTime = time();

// Set longer time out, and ignore user abort (use common maintenance settings)
if (!ini_get('safe_mode')) {
    @set_time_limit($conf['maintenance']['timeLimitScripts']);
    @ignore_user_abort(true);
}

$oLock =& OA_DB_AdvisoryLock::factory();
OA::switchLogIdent('importMarketStats');

if ($oLock->get(ADVISORYLOCK_IMPORT_MARKET_STATS)) {
	$oImportStats = new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics(true);
	if ($oImportStats->canRunTask()) {
	   $oImportStats->run();
    } else {
        OA::debug('Import Market Statistics task not run: please set [oxMarket]separateImportStatsScript to true', PEAR_LOG_INFO);
    }
	$oLock->release();
} else {
    OA::debug('Import Market Statistics task not run: could not acquire lock', PEAR_LOG_INFO);
}
OA::switchLogIdent();

// mesure time
$totalTime = time() - $startTime;
echo 'script took '.$totalTime.' seconds.'."\n";
OA::debug('Import Market Statistics script took '.$totalTime.' seconds', PEAR_LOG_INFO);
