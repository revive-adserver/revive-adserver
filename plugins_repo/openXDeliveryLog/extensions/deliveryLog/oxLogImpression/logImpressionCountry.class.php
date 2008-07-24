<?php

require_once MAX_PATH . '/extensions/deliveryLog/logCommon.php';

class Plugins_DeliveryLog_OxLogImpression_LogImpressionCountry extends Plugins_DeliveryLog_LogCommon
{
    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogImpression:logImpressionCountry' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataGeo',
            )
        );
    }
}

?>