<?php

require_once MAX_PATH . '/lib/OA/Plugin/Component.php';

class Plugins_DeliveryLog_OxLogImpression_logImpressionBackup extends OX_Component
{
    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogClick:logImpressionBackup' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
            )
        );
    }
}

?>