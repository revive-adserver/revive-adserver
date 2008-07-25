<?php

require_once LIB_PATH . '/Plugin/Component.php';

class Plugins_DeliveryDataPrepare_OxDeliveryDataPrepare_DataUserAgent extends OX_Component
{
    function getDependencies()
    {
        return array(
            'deliveryDataPrepare:oxDeliveryDataPrepare:dataUserAgent' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon'
            )
        );
    }
}

?>