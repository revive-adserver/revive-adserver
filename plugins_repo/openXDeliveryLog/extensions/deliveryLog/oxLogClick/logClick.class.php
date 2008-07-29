<?php

require_once MAX_PATH . '/extensions/deliveryLog/LogCommon.php';
require_once MAX_PATH . '/extensions/deliveryLog/BucketProcessingStrategyFactory.php';

class Plugins_DeliveryLog_OxLogClick_LogClick extends Plugins_DeliveryLog_LogCommon
{
    function __construct()
    {
        // Clicks are aggregate.
        $dbType = $GLOBALS['_MAX']['CONF']['database']['type'];    
        $this->processingStrategy = 
                    Plugins_DeliveryLog_BucketProcessingStrategyFactory::getAggregateBucketProcessingStrategy($dbType);
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