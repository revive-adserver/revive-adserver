<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/querystring.php';

// Prevent click from being cached by browsers
MAX_commonSetNoCacheHeaders();

// Convert specially encoded params into the $_REQUEST variable
MAX_querystringConvertParams();

// Remove any special characters
MAX_commonRemoveSpecialChars($_REQUEST);

// Get the variables
$viewerId = MAX_cookieGetUniqueViewerID();

if (!empty($GLOBALS['_MAX']['COOKIE']['newViewerId']) && empty($_GET[$conf['var']['cookieTest']])) {
    // No previous cookie was found, and we have not tried to force setting one...
    MAX_cookieSetViewerIdAndRedirect($viewerId);
}

$adId       = isset($_REQUEST[$conf['var']['adId']]) ? explode(MAX_DELIVERY_MULTIPLE_DELIMITER, $_REQUEST[$conf['var']['adId']]) : array();
$zoneId     = isset($_REQUEST[$conf['var']['zoneId']]) ? explode(MAX_DELIVERY_MULTIPLE_DELIMITER, $_REQUEST[$conf['var']['zoneId']]) : array();
$creativeId = isset($_REQUEST[$conf['var']['creativeId']]) ? explode(MAX_DELIVERY_MULTIPLE_DELIMITER, $_REQUEST[$conf['var']['creativeId']]) : array();

if (empty($adId) && !empty($zoneId)) {
    foreach ($zoneId as $index => $zone) {
        $adId[$index] = _getZoneAd($zone);
        $creativeId[$index] = 0;
    }
}
for ($i=0;$i<count($adId);$i++) {
    $adId[$i] = intval($adId[$i]);
    $zoneId[$i] = intval($zoneId[$i]);
    $creativeId[$i] = intval($creativeId[$i]);

    if (($adId[$i] > 0) && ($conf['logging']['adClicks']) && !(isset($_GET['log']) && ($_GET['log'] == 'no'))) {
        $GLOBALS['_MAX']['CHANNELS'] = str_replace($conf['delivery']['chDelimiter'],MAX_DELIVERY_MULTIPLE_DELIMITER,$_REQUEST['channel_ids']);
        MAX_Delivery_log_logAdClick($viewerId, $adId[$i], $creativeId[$i], $zoneId[$i]);
    }
}

// Set the userid cookie
MAX_cookieSet($conf['var']['viewerId'], $viewerId, time() + $conf['cookie']['permCookieSeconds']);
MAX_cookieFlush();

// Get the URL that we are going to redirect to
$destination = MAX_querystringGetDestinationUrl($adId[0]);

// Redirect to the destination url
if (!empty($destination) && empty($_GET['trackonly'])) {
    // Prevent HTTP response split attacks
    if (!preg_match('/[\r\n]/', $destination)) {
        header ("Location: $destination");
    }
}

// Stop benchmarking
MAX_benchmarkStop();

/**
 * Get the ad information when only passed in a zone ID (for email zones)
 *
 * @param int $zoneId The Zone ID of the zone
 * @return int $adId The ad ID of the only linked banner, or 0 if <> 1 active ad linked
 */

function _getZoneAd($zoneId)
{
    $conf = $GLOBALS['conf'];

    require_once MAX_PATH . '/lib/max/Delivery/cache.php';
    $zoneLinkedAds = MAX_cacheGetZoneLinkedAds($zoneId, false);

    if (!empty($zoneLinkedAds['xAds']) && count($zoneLinkedAds['xAds']) == 1) {
        list($adId, $ad) = each($zoneLinkedAds['xAds']);
    } elseif (!empty($zoneLinkedAds['ads']) && count($zoneLinkedAds['ads']) == 1) {
        list($adId, $ad) = each($zoneLinkedAds['ads']);
    } elseif (!empty($zoneLinkedAds['lAds']) && count($zoneLinkedAds['lAds']) == 1) {
        list($adId, $ad) = each($zoneLinkedAds['lAds']);
    }

    if (!empty($ad['url'])) {
        // Store the destination URL to save querying the DB again
        $_REQUEST[$conf['var']['dest']] = $ad['url'];
    }
    return $adId;
}

?>
