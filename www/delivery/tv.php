<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: tv.php 5698 2006-10-12 16:16:22Z chris@m3.net $
*/

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once(MAX_PATH . '/lib/max/Delivery/cache.php');
// Register input variables
if (!empty($_GET['server_raw_tracker_impression_id']) && !empty($_GET['trackerid'])) {
    $serverRawTrackerImpressionId = $_GET['server_raw_tracker_impression_id'];
    $serverRawIp                  = $_GET['server_raw_ip'];
    $trackerId                    = $_GET['trackerid'];
    $variables = MAX_cacheGetTrackerVariables($trackerId);
    MAX_logVariableValues($variables, $trackerId, $serverRawTrackerImpressionId, $serverRawIp);
}

// stop benchmarking
MAX_benchmarkStop();

?>