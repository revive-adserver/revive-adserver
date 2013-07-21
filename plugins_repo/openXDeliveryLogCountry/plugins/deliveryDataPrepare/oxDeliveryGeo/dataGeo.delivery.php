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

function Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo($adId, $zoneId)
{
    // Prevent the function from running twice
    if (isset($GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo'])) {
        return;
    }
    $GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo'] = true;

    if (!empty($GLOBALS['_MAX']['CLIENT_GEO'])) {
        $GLOBALS['_MAX']['deliveryData']['geo'] = $GLOBALS['_MAX']['CLIENT_GEO'];
    } else {
        $GLOBALS['_MAX']['deliveryData']['geo'] = array(
            'country_code'  => null,
            'region'        => null,
            'city'          => null,
            'postal_code'   => null,
            'latitude'      => null,
            'longitude'     => null,
            'dma_code'      => null,
            'area_code'     => null,
            'organisation'  => null,
            'netspeed'      => null,
            'continent'     => null
        );
    }
}

function Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo_Delivery_logRequest($adId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo($adId, $zoneId);
}

function Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo_Delivery_logImpression($adId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo($adId, $zoneId);
}

function Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo_Delivery_logClick($adId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryGeo_dataGeo($adId, $zoneId);
}

?>