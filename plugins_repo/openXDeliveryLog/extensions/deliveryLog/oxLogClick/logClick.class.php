<?php

require_once MAX_PATH . '/lib/OA/Plugin/Component.php';

class Plugins_DeliveryLog_OxLogClick_LogClick extends OX_Component
{
    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogClick:logClick' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
            )
        );
    }
}

?>