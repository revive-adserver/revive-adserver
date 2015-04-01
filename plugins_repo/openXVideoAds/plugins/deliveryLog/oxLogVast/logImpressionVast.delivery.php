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


MAX_Dal_Delivery_Include();

function Plugin_deliveryLog_oxLogVast_logImpressionVast_Delivery_logImpressionVast($adId = 0, $zoneId = 0, $okToLog = true)
{
    $aData = $GLOBALS['_MAX']['deliveryData'];

    if (!$okToLog || empty($aData['interval_start']) || empty($aData['vast_event_id'])) {
        return false;
    }

    $aQuery = array(
        'interval_start' => $aData['interval_start'],
        'creative_id'    => $aData['creative_id'],
        'zone_id'        => $aData['zone_id'],
        'vast_event_id'  => $aData['vast_event_id'],
    );

    return OX_bucket_updateTable('data_bkt_vast_e', $aQuery);
}
