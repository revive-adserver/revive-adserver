<?php

require_once MAX_PATH . '/extensions/deliveryLog/LogCommon.php';
require_once MAX_PATH . '/extensions/deliveryLog/AggregateBucketProcessingStrategy.php';

class Plugins_DeliveryLog_OxLogClick_LogClick extends Plugins_DeliveryLog_LogCommon
{
    function __construct()
    {
        // Clicks are aggregate.
        $this->processingStrategy = new Plugins_DeliveryLog_AggregateBucketProcessingStrategy();
    }
    
    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogClick:logClick' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
            )
        );
    }

    function getBucketName()
    {
        return 'data_bkt_c';
    }

    public function getTableBucketColumns()
    {
        $columns = array(
            'interval_start' => self::TIMESTAMP_WITHOUT_ZONE ,
            'creative_id' => self::INTEGER,
            'zone_id' => self::INTEGER,
            'count' => self::INTEGER
        );
        return $columns;
    }
}

?>