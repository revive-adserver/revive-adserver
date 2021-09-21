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

function Plugin_deliveryLog_oxLogClick_logClick_Delivery_logClick($adId = 0, $zoneId = 0, $okToLog = true)
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
    return OX_bucket_updateTable('data_bkt_c', $aQuery);
}
