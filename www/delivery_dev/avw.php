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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';

###START_STRIP_DELIVERY
OA::debug('starting delivery script '.__FILE__);
###END_STRIP_DELIVERY

// No Caching
MAX_commonSetNoCacheHeaders();

// Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('n'));
if (!isset($n)) $n = 'default';

$richMedia = false;     // This is an image tag - we only need the filename (or URL?) of the image...
$target = '';           // Target cannot be dynamically set in basic tags.
$context = array();     // I don't think that $context is valid in adview.php...
$ct0 = '';              // Click tracking should be done using external tags rather than this way...
$withText = 0;          // Cannot write text using a simple tag...
$row = MAX_adSelect($what, $campaignid, $target, $source, $withText, $charset, $context, $richMedia, $ct0, $loc, $referer);

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
    if (!empty($row['clickwindow'])) {
       $cookie[$conf['var']['lastClick']] = 1;
    }
    // addUrlParams hook for plugins to add key=value pairs to the log/click URLs
    $componentParams =  OX_Delivery_Common_hook('addUrlParams', array($row));
    foreach ($componentParams as $params) {
        if (!empty($params) && is_array($params)) {
            foreach ($params as $key => $value) {
                $cookie[$key] = $value;
            }
        }
    }
    // Added code to update the destination URL stored in the cookie to hold the correct random value (Bug # 88)
    global $cookie_random;
    $cookie[$conf['var']['dest']] = str_replace('{random}', $cookie_random, $row['url']);
    // The call to view_raw() above will have tried to log the impression via a beacon,
    // but this type of ad doesn't work with beacons, so the impression must
    // be logged here
    if ($conf['logging']['adImpressions']) {
        MAX_Delivery_log_logAdImpression($row['bannerid'], $zoneid);
    }
    // Redirect to the banner
    MAX_cookieAdd($conf['var']['vars'] . "[$n]", serialize($cookie));
    MAX_cookieFlush();
    if ($row['bannerid'] == '') {
       if ($row['default_banner_image_url'] != '') {
           // Show default banner image url
           MAX_redirect($row['default_banner_image_url']);
       } else {
           // Show 1x1 Gif, to ensure not broken image icon is shown.
           MAX_commonDisplay1x1();
       }
    } else {
       MAX_redirect($row['html']);
    }
} else {
	MAX_cookieAdd($conf['var']['vars'] . "[$n]", 'DEFAULT');
	MAX_cookieFlush();
	// Show 1x1 Gif, to ensure not broken image icon is shown.
	MAX_commonDisplay1x1();
}

// Run automaintenance, if needed
if (!empty($GLOBALS['_MAX']['CONF']['maintenance']['autoMaintenance']) && empty($GLOBALS['_MAX']['CONF']['lb']['enabled'])) {
    if (MAX_cacheCheckIfMaintenanceShouldRun()) {
        include MAX_PATH . '/lib/OA/Maintenance/Auto.php';
        OA_Maintenance_Auto::run();
    }
}

?>
