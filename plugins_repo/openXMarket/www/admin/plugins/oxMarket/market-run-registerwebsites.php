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
 * A script file to run register websites.
 */

// Send headers to the client before proceeding
flush();

// Prevent output
ob_start();

require_once 'market-common.php';

// Set longer time out, and ignore user abort
if (!ini_get('safe_mode')) {
    @set_time_limit($GLOBALS['_MAX']['CONF']['maintenance']['timeLimitScripts']);
    @ignore_user_abort(true);
}

$oMaintenaceUpdateWebsites = OX_Component::factory(
                                'maintenanceStatisticsTask', 
                                'oxMarketMaintenance', 
                                'oxMarketMaintenanceUpdateWebsites');
$oUpdtateWebsitesTask = $oMaintenaceUpdateWebsites->addMaintenanceStatisticsTask();
$oUpdtateWebsitesTask->run();

// Get and clean output buffer
$buffer = ob_get_clean();

// Flush output buffer, stripping the
echo preg_replace('/^#!.*\n/', '', $buffer);
