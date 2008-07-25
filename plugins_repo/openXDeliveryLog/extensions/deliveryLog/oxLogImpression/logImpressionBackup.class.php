<?php

require_once MAX_PATH . '/extensions/deliveryLog/LogCommon.php';

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

    function getBucketName()
    {
        return 'data_bucket_impression_backup';
    }

    public function getTableBucketColumns()
    {
        $columns = array(
            'interval_start' => self::TIMESTAMP_WITHOUT_ZONE ,
            'primary_creative_id' => self::INTEGER,
            'creative_id' => self::INTEGER,
            'zone_id' => self::INTEGER,
            'count' => self::INTEGER
        );
    }
}

?>