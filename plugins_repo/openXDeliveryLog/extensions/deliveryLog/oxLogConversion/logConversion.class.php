<?php

require_once MAX_PATH . '/extensions/deliveryLog/LogCommon.php';
require_once MAX_PATH . '/extensions/deliveryLog/BucketProcessingStrategyFactory.php';

class Plugins_DeliveryLog_OxLogConversion_LogConversion extends Plugins_DeliveryLog_LogCommon
{
    function __construct()
    {
        // Conversions are not aggregate.
        $dbType = $GLOBALS['_MAX']['CONF']['database']['type'];
        $this->processingStrategy =
                    Plugins_DeliveryLog_BucketProcessingStrategyFactory::getRawBucketProcessingStrategy($dbType);
    }

    function onInstall()
    {
        // no additional code (stored procedures) are required for logging conversions
        return true;
    }

    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogConversion:logConversion' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataRawIp',
            )
        );
    }

    function getBucketName()
    {
        return 'data_bkt_a';
    }

    public function getTableBucketColumns()
    {
        return array();
    }
}

?>