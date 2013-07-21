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
 * @subpackage openxDeliveryLogCountry
 */

function Plugin_deliveryLog_oxLogCountry_logImpressionCountry_Delivery_logImpression()
{
    $data = $GLOBALS['_MAX']['deliveryData'];
    $aQuery = array(
        'interval_start' => $data['interval_start'],
        'creative_id'    => $data['creative_id'],
        'zone_id'        => $data['zone_id'],
        'country'        => $data['geo']['country_code'],
    );
    return OX_bucket_updateTable('data_bkt_country_m', $aQuery);
}

?>