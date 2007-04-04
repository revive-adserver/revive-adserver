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
$Id$
*/

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';

// No Caching
MAX_commonSetNoCacheHeaders();

// Register any script specific input variables
MAX_commonRegisterGlobals('n');
if (!isset($n)) $n = 'default';

$richMedia = false;     // This is an image tag - we only need the filename (or URL?) of the image...
$target = '';           // Target cannot be dynamically set in basic tags.
$context = array();     // I don't think that $context is valid in adview.php...
$ct0 = '';              // Click tracking should be done using external tags rather than this way...
$withText = 0;          // Cannot write text using a simple tag...
$row = MAX_adSelect($what, $target, $source, $withText, $context, $richMedia, $ct0, $loc, $referer);

if (!empty($row['html'])) {
    // Send bannerid headers
    $cookie = array();
    $cookie[$conf['var']['adId']] = $row['bannerid'];
    // Send zoneid headers
    if ($zoneid != 0) {
    	$cookie[$conf['var']['zoneId']] = $zoneid;
    }
    // Send source headers
    if (!empty($source)) {
    	$cookie[$conf['var']['channel']] = $source;
    }
    // Added code to update the destination URL stored in the cookie to hold the correct random value (Bug # 88)
    global $cookie_random;
    $cookie[$conf['var']['dest']] = str_replace('{random}', $cookie_random, $row['url']);
    // The call to view_raw() above will have tried to log the impression via a beacon,
    // but this type of ad doesn't work with beacons, so the impression must
    // be logged here
    if ($conf['logging']['adImpressions']) {
        MAX_Delivery_log_logAdImpression($userid, $row['bannerid'], null, $zoneid);
    }
    // Redirect to the banner
    MAX_cookieSet($conf['var']['vars'] . "[$n]", serialize($cookie));
    MAX_cookieFlush();
	header("Location: {$row['html']}");
} else {
	MAX_cookieSet($conf['var']['vars'] . "[$n]", 'DEFAULT');
	MAX_cookieFlush();
	// Show 1x1 Gif, to ensure not broken image icon is shown.
	MAX_commonDisplay1x1();
}

// stop benchmarking
MAX_benchmarkStop();

// Run automaintenance, if needed
if (!empty($GLOBALS['_MAX']['CONF']['maintenance']['autoMaintenance']) && empty($GLOBALS['_MAX']['CONF']['lb']['enabled'])) {
    require_once '/lib/OA/Maintenance/Auto.php';

    OA_Maintenance_Auto::run();
}

?>
