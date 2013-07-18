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
class Plugins_DeliveryLog_OxLogConversion_LogConversion extends Plugins_DeliveryLog
{

    function __construct()
    {
        // Conversions are NOT aggregate
        $this->type = 'raw';
        parent::__construct();
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
        return 'data_bkt_a';
    }

    /**
     * Returns the columns in the bucket table.
     *
     * @return array Format: array(column name => column type, ...)
     */
    public function getBucketTableColumns()
    {
        $aColumns = array(
            'server_conv_id'          => self::INTEGER ,
            'server_ip'               => self::CHAR,
            'tracker_id'              => self::INTEGER ,
            'date_time'               => self::TIMESTAMP_WITHOUT_ZONE,
            'action_date_time'        => self::TIMESTAMP_WITHOUT_ZONE,
            'creative_id'             => self::INTEGER ,
            'zone_id'                 => self::INTEGER ,
            'ip_address'              => self::CHAR  ,
            'action'                  => self::INTEGER,
            'window'                  => self::INTEGER,
            'status'                  => self::INTEGER
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
        return 'data_intermediate_ad_connection';
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
            'method'            => 'raw',
            'bucketTable'       => $this->getBucketTableName(),
            'dateTimeColumn'    => 'date_time',
            'source'            => array(
                0  => 'server_conv_id',
                1  => 'server_ip',
                2  => 'tracker_id',
                3  => 'date_time',
                4  => 'action_date_time',
                5  => 'creative_id',
                6  => 'zone_id',
                7  => 'ip_address',
                8  => 'action',
                9  => 'window',
                10 => 'status'
            ),
            'destination'       => array(
                0  => 'server_raw_tracker_impression_id',
                1  => 'server_raw_ip',
                2  => 'tracker_id',
                3  => 'tracker_date_time',
                4  => 'connection_date_time',
                5  => 'ad_id',
                6  => 'zone_id',
                7  => 'tracker_ip_address',
                8  => 'connection_action',
                9  => 'connection_window',
                10 => 'connection_status'
            ),
            'extrasDestination' => array(
                11 => 'creative_id',
                12 => 'inside_window'
            ),
            'extrasValue'       => array(
                11 => '0',
                12 => '1'
            )
        );
        return $aMap;
    }

    
    public function getEarliestLoggedDataDate()
    {
        return parent::getEarliestLoggedDataDate('date_time');
    }

}

?>