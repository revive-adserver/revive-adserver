<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: logConversion.class.php 33995 2009-03-18 23:04:15Z chris.nutting $
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
        return array();
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

    /**
     * A method that returns the bucket to statistics column mapping
     * for the component. Where multiple components migrate bucket data
     * into the same statistics table, it is a requirement that the
     * bucket source columns in the different components have identical
     * names.
     *
     * @return array The array describing how the bucket data should
     *               be migrated to the final statistics table. Contains
     *               ..... to be completed
     */
    public function getEarliestLoggedDataDate()
    {
        parent::getEarliestLoggedDataDate('date_time');
    }

}

?>