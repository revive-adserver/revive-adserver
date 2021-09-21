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
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */

MAX_Dal_Delivery_Include();

/**
 * Component prepares data which may be used by deliveryLog plugins
 * or other deliveryDataPrepare components as a base for their data preparations.
 * All data is stored in $GLOBALS['_MAX']['deliveryData']
 *
 * @param int $adId
 * @param int $zoneId
 */
function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon($adId, $zoneId)
{
    // Always update creative and zone IDs using the ones from the parameters
    $GLOBALS['_MAX']['deliveryData']['creative_id'] = (int)$adId;
    $GLOBALS['_MAX']['deliveryData']['zone_id'] = (int)$zoneId;

    // Prevent the function from running twice
    if (!empty($GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon'])) {
        return;
    }
    $GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon'] = true;

    // Calculate start date of current Operation Interval
    if (empty($GLOBALS['_MAX']['NOW'])) {
        $GLOBALS['_MAX']['NOW'] = time();
    }
    $time = $GLOBALS['_MAX']['NOW'];
    $oi = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'];
    $GLOBALS['_MAX']['deliveryData']['interval_start'] = gmdate('Y-m-d H:i:s', $time - $time % ($oi * 60));
    $GLOBALS['_MAX']['deliveryData']['ip_address'] = $_SERVER['REMOTE_ADDR'];
}

// Followig methods are required due to functions names limitations
function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon_Delivery_logRequest($adId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon($adId, $zoneId);
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon_Delivery_logImpression($adId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon($adId, $zoneId);
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon_Delivery_logClick($adId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon($adId, $zoneId);
}
