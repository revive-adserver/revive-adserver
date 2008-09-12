<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id$
*/

require_once LIB_PATH . '/Extension/deliveryLog/BucketProcessingStrategyFactory.php';
require_once LIB_PATH . '/Extension/deliveryLog/DeliveryLog.php';

/**
 * @package    Plugin
 * @subpackage openxDeliveryLogCountry
 */
class Plugins_DeliveryLog_OxLogCountry_LogClickCountry extends Plugins_DeliveryLog
{

    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogCountry:logClickCountry' => array(
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon',
                'deliveryDataPrepare:oxDeliveryGeo:dataGeo'
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
        return 'data_bkt_c_country';
    }

    /**
     * Returns the columns in the bucket table.
     *
     * @return array Format: array(column name => column type, ...)
     */
    public function getBucketTableColumns()
    {
        $aColumns = array(
            'interval_start' => self::TIMESTAMP_WITHOUT_ZONE,
            'creative_id'    => self::INTEGER,
            'zone_id'        => self::INTEGER,
            'country'        => self::CHAR,
            'count'          => self::INTEGER,
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
        return 'stats_country';
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
            'method'      => 'aggregate',
            'table'       => $this->getBucketTableName(),
            'source'      => array(
                0 => 'interval_start',
                1 => 'creative_id',
                2 => 'zone_id',
                3 => 'country',
                5 => 'count'
            ),
            'destination' => array(
                0 => 'date_time',
                1 => 'ad_id',
                2 => 'zone_id',
                3 => 'country',
                5 => 'clicks'
            ),
            'type'        => array(
                0 => 'group',
                1 => 'group',
                2 => 'group',
                3 => 'group',
                5 => 'sum'
            ),
            'defaults'    => array(
                5 => 0
            )
        );
        return $aMap;
    }

}

?>