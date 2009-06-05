<?php
/*
 *    Copyright (c) 2009 Bouncing Minds - Option 3 Ventures Limited
 *
 *    This file is part of the Regions plug-in for Flowplayer.
 *
 *    The Regions plug-in is free software: you can redistribute it
 *    and/or modify it under the terms of the GNU General Public License
 *    as published by the Free Software Foundation, either version 3 of
 *    the License, or (at your option) any later version.
 *
 *    The Regions plug-in is distributed in the hope that it will be
 *    useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with the plug-in.  If not, see <http://www.gnu.org/licenses/>.
 */


require_once LIB_PATH . '/Extension/deliveryLog/BucketProcessingStrategyFactory.php';
require_once LIB_PATH . '/Extension/deliveryLog/DeliveryLog.php';

/**
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */
class Plugins_DeliveryLog_OxLogVast_LogImpressionVast extends Plugins_DeliveryLog
{
    function getDependencies()
    {
        return array($this->getComponentIdentifier() => array());
    }

    /**
     * Returns the bucket table name
     *
     * @return string The bucket table bucket name without prefix.
     */
    function getBucketName()
    {
        return 'data_bkt_vast_e';
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
	        'vast_event_id'  => self::INTEGER,
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
        return 'stats_vast';
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
                2 => 'zone_id',
                3 => 'vast_event_id',
            ),
            'groupDestination' => array(
                0 => 'interval_start',
                1 => 'creative_id',
                2 => 'zone_id',
                3 => 'vast_event_id',
            ),
            'sumSource'        => array(
                0 => 'count'
            ),
            'sumDestination'   => array(
                0 => 'count'
            ),
            'sumDefault'       => array(
                0 => 0
            )
        );
        return $aMap;
    }

}

