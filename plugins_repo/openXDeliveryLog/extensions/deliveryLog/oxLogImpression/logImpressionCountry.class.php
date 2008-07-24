<?php

require_once MAX_PATH . '/lib/OA/Plugin/Component.php';

class Plugins_DeliveryLog_OxLogImpression_LogImpressionCountry extends OX_Component
{
    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogClick:logImpressionCountry' => array(
                'deliveryDataPrepare:oxLogCommon:dataCommon',
                'deliveryDataPrepare:oxLogCommon:dataGeo',
            )
        );
    }
}

?>