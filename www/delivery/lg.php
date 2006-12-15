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
$Id$
*/

/**
 * @package    MaxDelivery
 * @author     Scott Switzer <scott@switzer.org>
 */

require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/log.php';

// Prevent beacon from being cached by browsers
MAX_commonSetNoCacheHeaders();

// Remove any special characters
MAX_commonRemoveSpecialChars($_REQUEST);

$conf = $GLOBALS['_MAX']['CONF'];

// Get the variables
$viewerId   = MAX_cookieGetUniqueViewerID();
$adId       = _getArrRequestConfVariable('adId');
$zoneId     = _getArrRequestConfVariable('zoneId');
$creativeId = _getArrRequestConfVariable('creativeId');

// Get any capping information from the request array
$arrAdCapping['block']           = _getArrRequestVariable('block');
$arrAdCapping['capping']         = _getArrRequestVariable('capping');
$arrAdCapping['session_capping'] = _getArrRequestVariable('session_capping');

$arrZoneCapping['block'] = _getArrRequestConfVariable('blockZone');
$arrZoneCapping['capping'] = _getArrRequestConfVariable('capZone');
$arrZoneCapping['session_capping'] = _getArrRequestConfVariable('sessionCapZone');

// FIXME-Andrzej: Refactor these capping things using proper arrays of indices!!!

for ($i=0;$i<count($adId);$i++) {
    $adId[$i] = _getIValueFromArr($adId, $i);
    $zoneId[$i] = _getIValueFromArr($zoneId, $i);
    $creativeId[$i] = _getIValueFromArr($creativeId, $i);

    if ($adId[$i] > 0) {
        if ($conf['logging']['adImpressions']) {
            MAX_logAdImpression($viewerId, $adId[$i], $creativeId[$i], $zoneId[$i]);
        }

        _setAdLimitations($adId[$i], $arrAdCapping, $i);

        if ($zoneId[$i] != 0) {
            _setZoneLimitations($zoneId[$i], $arrZoneCapping, $i);
        }
    }
}

MAX_cookieFlush();
MAX_querystringConvertParams();

if (!empty($_REQUEST[$conf['var']['dest']])) {
    MAX_header("Location: {$_REQUEST[$conf['var']['dest']]}");
} else {
    // Display a 1x1 pixel gif
    MAX_commonDisplay1x1();
}
// Stop benchmarking
MAX_benchmarkStop();


?>
