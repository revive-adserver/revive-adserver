<?php

require_once MAX_PATH . '/extensions/deliveryAdRender/oxThorium/marketplace.php';

function Plugin_deliveryAdRender_oxIndium_beaconService_Delivery_postAdRender(&$code, $aBanner)
{
    if ($html = MAX_marketplaceProcess($GLOBALS['_OA']['invocationType'], $code, $aBanner)) {
        $code = $html;
    }
    if (MAX_marketplaceNeedsIndium()) {
        $code .= MAX_adRenderImageBeacon(MAX_commonGetDeliveryUrl('fc.php?script=deliveryAdRender:oxIndium:in'), 'indium_');
    }
}

?>