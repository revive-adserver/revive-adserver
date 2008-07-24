<?php

require_once MAX_PATH . '/lib/OA/Plugin/Component.php';

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