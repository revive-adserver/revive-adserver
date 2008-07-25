<?php

require_once LIB_PATH . '/Plugin/Component.php';

class Plugins_DeliveryDataPrepare_OxDeliveryDataPrepare_DataGeo extends OX_Component
{
    function getDependencies()
    {
        return array(
            'deliveryDataPrepare:oxDeliveryDataPrepare:dataGeo' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon'
            )
        );
    }
}

?>