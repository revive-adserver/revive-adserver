<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once LIB_PATH . '/Extension/deliveryLog/BucketProcessingStrategyFactory.php';
require_once LIB_PATH . '/Extension/deliveryLog/DeliveryLog.php';

/**
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */
class Plugins_DeliveryLog_OxLogClick_LogClick extends Plugins_DeliveryLog
{

    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogClick:logClick' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon'
            )
        );
    }

    /**
     * Returns the bucket table name
     *
     * @return string The bucket table bucket name without prefix.
     */
    function getBucketName()
    {
        return 'data_bkt_c';
    }

    /**
     * Returns the columns in the bucket table.
     *
     * @return array Format: array(column name => column type, ...)
     */
    public function getBucketTableColumns()
    {
        $aColumns = array(
            'interval_start' => self::TIMESTAMP_WITHOUT_ZONE ,
            'creative_id'    => self::INTEGER,
            'zone_id'        => self::INTEGER,
            'count'          => self::INTEGER
        );
        return $aColumns;
    }

    /**
     * Returns the bucket's destination statistics table name, that is,
     * the table that is defined in the component's plugin to store the
     * aggregate bucket data for the components, but without the table
     * prefix
     *
     * @return string The statistics table name without prefix.
     */
    public function getStatisticsName()
    {
        return 'data_intermediate_ad';
    }

    /**
     * A method that returns the bucket to statistics column mapping
     * for the component. Where multiple components migrate bucket data
     * into the same statistics table, it is a requirement that the
     * bucket source columns in the different components have identical
     * names.
     *
     * @return array See class Plugins_DeliveryLog::getStatisticsMigration()
     *               for description.
     */
    public function getStatisticsMigration()
    {
        $aMap = array(
            'method'           => 'aggregate',
            'bucketTable'      => $this->getBucketTableName(),
            'dateTimeColumn'   => 'interval_start',
            'groupSource'      => array(
                0 => 'interval_start',
                1 => 'creative_id',
                2 => 'zone_id'
            ),
            'groupDestination' => array(
                0 => 'date_time',
                1 => 'ad_id',
                2 => 'zone_id'
            ),
            'sumSource'        => array(
                0 => 'count'
            ),
            'sumDestination'   => array(
                0 => 'clicks'
            ),
            'sumDefault'       => array(
                0 => 0
            )
        );
        return $aMap;
    }

}

?>