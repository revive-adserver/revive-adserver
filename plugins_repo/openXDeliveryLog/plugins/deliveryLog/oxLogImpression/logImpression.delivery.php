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

function Plugin_deliveryLog_OxLogImpression_LogImpression_Delivery_logImpression($adId = 0, $zoneId = 0, $okToLog = true)
{
    if (!$okToLog) { return false; }
    $aData = $GLOBALS['_MAX']['deliveryData'];
    $aQuery = array(
        'interval_start' => $aData['interval_start'],
        'creative_id'    => (int)$aData['creative_id'],
        'zone_id'        => (int)$aData['zone_id']
    );
    return OX_bucket_updateTable('data_bkt_m', $aQuery);
}

