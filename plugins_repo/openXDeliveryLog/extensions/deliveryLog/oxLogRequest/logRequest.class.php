<?php

require_once MAX_PATH . '/lib/OA/Plugin/Component.php';

class Plugins_DeliveryLog_OxLogRequest_LogRequest extends OX_Component
{
    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogRequest:logRequest' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
            )
        );
    }
}

?>