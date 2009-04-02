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
$Id: logConversionVariable.class.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

require_once LIB_PATH . '/Extension/deliveryLog/BucketProcessingStrategyFactory.php';
require_once LIB_PATH . '/Extension/deliveryLog/DeliveryLog.php';

/**
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */
class Plugins_DeliveryLog_OxLogConversion_LogConversionVariable extends Plugins_DeliveryLog
{

    function __construct()
    {
        // Conversion variable values are NOT aggregate
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
            'deliveryLog:oxLogConversion:logConversionVariable' => array(
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
        return 'data_bkt_a_var';
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
        return 'data_intermediate_ad_variable_value';
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
        $aConf = $GLOBALS['_MAX']['CONF'];
        $aMap = array(
            'method'                 => 'rawSupplementary',
            'masterTable'            => $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
            'masterTablePrimaryKeys' => array(
                0 => 'data_intermediate_ad_connection_id'
            ),
            'bucketTablePrimaryKeys' => array(
                0 => 'data_intermediate_ad_connection_id'
            ),
            'masterTableKeys'       => array(
                0 => 'server_raw_tracker_impression_id',
                1 => 'server_raw_ip'
            ),
            'bucketTableKeys'       => array(
                0 => 'server_conv_id',
                1 => 'server_ip'
            ),
            'masterDateTimeColumn'   => 'tracker_date_time',
            'bucketTable'            => $this->getBucketTableName(),
            'source'                 => array(
                0  => 'tracker_variable_id',
                1  => 'value'
            ),
            'destination'            => array(
                0  => 'tracker_variable_id',
                1  => 'value'
            )
        );
        return $aMap;
    }

}

?>