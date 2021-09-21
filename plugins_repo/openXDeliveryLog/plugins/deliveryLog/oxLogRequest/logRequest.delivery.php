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

function Plugin_deliveryLog_oxLogRequest_logRequest_Delivery_logRequest($adId = 0, $zoneId = 0, $aAd = [], $okToLog = true)
{
    if (!$okToLog) {
        return false;
    }
    $aData = $GLOBALS['_MAX']['deliveryData'];
    $aQuery = [
        'interval_start' => $aData['interval_start'],
        'creative_id' => (int)$aData['creative_id'],
        'zone_id' => (int)$aData['zone_id']
    ];
    return OX_bucket_updateTable('data_bkt_r', $aQuery);
}
