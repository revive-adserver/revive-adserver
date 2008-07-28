<?php

require_once MAX_PATH . '/extensions/deliveryLog/LogCommon.php';

class Plugins_DeliveryLog_OxLogCountry_LogClickCountry extends Plugins_DeliveryLog_LogCommon
{
    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogCountry:logClickCountry' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
                'deliveryDataPrepare:oxDeliveryGeo:dataGeo',
            )
        );
    }

    function getBucketName()
    {
        return 'data_bkt_c_country';
    }

    public function getTableBucketColumns()
    {
        $columns = array(
            'interval_start' => self::TIMESTAMP_WITHOUT_ZONE,
            'creative_id' => self::INTEGER,
            'zone_id' => self::INTEGER,
            'country' => self::CHAR,
            'count' => self::INTEGER,
        );
        return $columns;
    }
}

?>