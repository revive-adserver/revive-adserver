<?php

require_once MAX_PATH . '/lib/max/Delivery/marketplace.php';

function Plugin_deliveryAdRender_openXIndium_beaconService_Delivery_postAdRender($code)
{
    if (MAX_marketplaceNeedsIndium()) {
        $code .= MAX_adRenderImageBeacon(MAX_commonGetDeliveryUrl('in.php'), 'indium_');
    }
}

?>