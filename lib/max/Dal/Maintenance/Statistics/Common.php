<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

/**
 * @package    MaxDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew@m3.net>
 */

require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/max/Maintenance.php';
require_once MAX_PATH . '/lib/max/Table/Core.php';
require_once MAX_PATH . '/lib/openads/Table/Statistics.php';

/**
 * Definitions of class constants.
 */
define('DAL_STATISTICS_COMMON_UPDATE_OI',   0);
define('DAL_STATISTICS_COMMON_UPDATE_HOUR', 1);
define('DAL_STATISTICS_COMMON_UPDATE_BOTH', 2);

/**
 * An abstract class that defines the interface and some common methods for the data
 * access layer code for summarising raw data into statistics, for all Max modules.
 *
 * @abstract
 */
class MAX_Dal_Maintenance_Statistics_Common
{
    var $tables;
    var $tempTables;
    var $oDalMaintenanceStatistics;

    /**
     * The constructor method.
     *
     * @param string $dbType The database type to use for creating tables.
     * @return MAX_Dal_Maintenance_Statistics_Common
     */
    function MAX_Dal_Maintenance_Statistics_Common($dbType)
    {
        $this->tables = MAX_Table_Core::singleton($dbType);
        $this->tempTables = Openads_Table_Statistics::singleton($dbType);
        $this->oDalMaintenanceStatistics = new MAX_Dal_Maintenance_Statistics();
    }

    /**
     * A method to find the last time that maintenance statistics was run.
     *
     * @abstract
     * @param integer $type The update type that occurred - that is,
     *                      DAL_STATISTICS_COMMON_UPDATE_OI if the update was
     *                      done on the basis of the operation interval,
     *                      DAL_STATISTICS_COMMON_UPDATE_HOUR if the update
     *                      was done on the basis of the hour, or
     *                      DAL_STATISTICS_COMMON_UPDATE_BOTH if the update
     *                      was done on the basis of both the operation
     *                      interval and the hour.
     * @param Date $now An optional Date, used to specify the "current time", and
     *                  to limit the method to only look for past maintenance
     *                  statistics runs before this date. Normally only used
     *                  to assist with re-generation of statistics in the event
     *                  of faulty raw tables.
     * @return Date A Date representing the date up to which the statistics
     *              have been summarised, for the specified update type, or
     *              the appropriate date based on raw data if maintenance
     *              statistics has never been run for the Max module before.
     *              Returns null if no raw data is available.
     */
    function getMaintenanceStatisticsLastRunInfo($type, $now = null) {}

    /**
     * A method for summarising impressions into a temporary table.
     *
     * @abstract
     * @param Date $start The start date/time to summarise from.
     * @param Date $end The end date/time to summarise to.
     * @return integer The number of conversion rows summarised.
     */
    function summariseImpressions($start, $end) {}

    /**
     * A method for summarising clicks into a temporary table.
     *
     * @abstract
     * @param Date $start The start date/time to summarise from.
     * @param Date $end The end date/time to summarise to.
     * @return integer The number of conversion rows summarised.
     */
    function summariseClicks($start, $end) {}

    /**
     * A method for summarising connections into a temporary table.
     *
     * @abstract
     * @param Date $start The start date/time to summarise from.
     * @param Date $end The end date/time to summarise to.
     * @return integer The number of connections summarised.
     */
    function summariseConnections($start, $end) {}

    /**
     * A method to update the intermediate tables with summarised data.
     *
     * @param PEAR::Date $oStart The start date/time to save from.
     * @param PEAR::Date $oEnd The end date/time to save to.
     * @param array $aTypes An array of data types to summarise. Contains
     *                      two array, the first containing the data types,
     *                      and the second containing the connection type
     *                      values associated with those data types, if
     *                      appropriate. For example:
     *          array(
     *              'types'       => array(
     *                                  0 => 'request',
     *                                  1 => 'impression',
     *                                  2 => 'click'
     *                               ),
     *              'connections' => array(
     *                                  1 => MAX_CONNECTION_AD_IMPRESSION,
     *                                  2 => MAX_CONNECTION_AD_CLICK
     *                               )
     *          )
     *                      Note that the order of the items must match
     *                      the order of the items in the database tables
     *                      (e.g. in data_intermediate_ad and
     *                      data_summary_ad_hourly for the above example).
     * @param string $intermediateTable Optional name of the main intermediate table (i.e.
     *                                  non-connections tables) to save the intermediate
     *                                  stats into. Default is 'data_intermediate_ad'.
     * @param boolean $saveConnections When false, connections will NOT be saved to the
     *                                 intermediate table. Allows maintenance plugins to
     *                                 save their data to the intermediate tables WITHOUT
     *                                 trying to re-save the connections, should they need
     *                                 to do so.
     */
    function saveIntermediate($oStart, $oEnd, $aTypes, $intermediateTable, $saveConnections = true) {}

    /**
     * A method to update the summary table from the intermediate tables.
     *
     * @param PEAR::Date $oStartDate The start date/time to update from.
     * @param PEAR::Date $oEndDate The end date/time to update to.
     * @param array $aTypes An array of data types to summarise. Contains
     *                      two array, the first containing the data types,
     *                      and the second containing the connection type
     *                      values associated with those data types, if
     *                      appropriate. For example:
     *          array(
     *              'types'       => array(
     *                                  0 => 'request',
     *                                  1 => 'impression',
     *                                  2 => 'click'
     *                               ),
     *              'connections' => array(
     *                                  1 => MAX_CONNECTION_AD_IMPRESSION,
     *                                  2 => MAX_CONNECTION_AD_CLICK
     *                               )
     *          )
     *                      Note that the order of the items must match
     *                      the order of the items in the database tables
     *                      (e.g. in data_intermediate_ad and
     *                      data_summary_ad_hourly for the above example).
     * @param string $fromTable The name of the intermediate table to summarise
     *                          from (e.g. 'data_intermediate_ad').
     * @param string $toTable The name of the summary table to summarise to
     *                        (e.g. 'data_summary_ad_hourly').
     */
    function saveSummary($oStartDate, $oEndDate, $aTypes, $fromTable, $toTable) {}

    /**
     * A method to delete old (ie. summarised) raw data.
     *
     * @abstract
     * @param Date $summarisedTo The date/time up to which data have been summarised (i.e. data up
     *                           to and including this date (minus any compact_stats_grace window)
     *                           will be deleted, unless required by the tracking module, where
     *                           installed).
     * @return integer The number of conversions deleted.
     */
    function deleteOldData($summarisedTo) {}

}

?>
