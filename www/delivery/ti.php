<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id: ti.php 6005 2006-11-17 15:48:13Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init-delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/tracker.php';

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobals('trackerid');
if (empty($trackerid))    $trackerid = 0;

// Determine the user ID
$userid = MAX_cookieGetUniqueViewerID(false);

// Log the tracker impression
if ($conf['logging']['trackerImpressions']) {
	$conversionInfo = MAX_logTrackerImpression($userid, $trackerid);
	if (isset($conversionInfo['server_raw_tracker_impression_id'])) {
	    // Store tracker impression variable values
	    MAX_logVariableValues(MAX_cacheGetTrackerVariables($trackerid), $trackerid, $conversionInfo['server_raw_tracker_impression_id'], $conversionInfo['server_raw_ip']);
	}
}
MAX_cookieFlush();
// Send a 1 x 1 gif
MAX_commonDisplay1x1();

// stop benchmarking
MAX_benchmarkStop();

?>
