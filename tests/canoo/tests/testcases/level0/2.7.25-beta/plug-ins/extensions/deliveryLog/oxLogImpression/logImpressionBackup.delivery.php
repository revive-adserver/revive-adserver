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

function Plugin_deliveryLog_oxLogImpression_logImpressionBackup_Delivery_logImpression()
{
    $data = $GLOBALS['_MAX']['deliveryData'];
    $aQuery = array(
        'interval_start'      => $data['interval_start'],
        'creative_id'         => $data['creative_id'],
        'zone_id'             => $data['zone_id'],
        'primary_creative_id' => 1, // @todo
    );
    return OX_bucket_updateTable('data_bkt_m_backup', $aQuery);
}

?>