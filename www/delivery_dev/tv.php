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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once(MAX_PATH . '/lib/max/Delivery/cache.php');

// Register input variables
if (!empty($_GET['trackerid'])) {
    $trackerId = $_GET['trackerid'];
    $serverConvId = $_GET['server_conv_id'] ?? null;
    $serverRawIp = $_GET['server_raw_ip'] ?? null;
    $plugin = $_GET['plugin'] ?? null;

    $aVariables = MAX_cacheGetTrackerVariables($trackerId);
    MAX_Delivery_log_logVariableValues($aVariables, $trackerId, $serverConvId, $serverRawIp, $plugin);
}
