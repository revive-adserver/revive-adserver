<?php

MAX_Dal_Delivery_Include();

function Plugin_deliveryLog_{GROUP}_{GROUP}Component_Delivery_logImpression()
{
    if (!empty($_REQUEST['channel_id'])) {
        $aData = $GLOBALS['_MAX']['deliveryData'];
        $aQuery = array(
            'channel_id' => $_REQUEST['channel_id']);

        return OX_bucket_updateTable('data_bkt_channel_m', $aQuery);
    }
    return true;
}