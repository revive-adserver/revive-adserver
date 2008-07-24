<?php

require_once MAX_PATH . '/extensions/deliveryLog/logCommon.php';

class Plugins_DeliveryLog_OxLogImpression_logImpressionBackup extends Plugins_DeliveryLog_LogCommon
{
    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogImpression:logImpressionBackup' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
            )
        );
    }
}

?>