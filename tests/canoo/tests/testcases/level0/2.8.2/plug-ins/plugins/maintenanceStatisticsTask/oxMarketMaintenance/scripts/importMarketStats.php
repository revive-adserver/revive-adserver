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
$Id: importMarketStats.php 41732 2009-08-19 14:28:22Z lukasz.wikierski $
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
