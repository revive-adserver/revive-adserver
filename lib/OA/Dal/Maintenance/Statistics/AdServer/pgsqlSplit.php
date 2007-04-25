<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
$Id: mysqlSplit.php 5411 2007-03-27 16:00:31Z andrew.hill@openads.org $
*/

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/AdServer/pgsql.php';
require_once 'Date.php';

/**
 * The data access layer code for summarising raw data into statistics, for
 * the AdServer module, when split tables are in use.
 *
 * @package    OpenadsDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Dal_Maintenance_Statistics_AdServer_pgsqlSplit extends OA_Dal_Maintenance_Statistics_AdServer_pgsql
{

    /**
     * The constructor method.
     *
     * @uses OA_Dal_Maintenance_Statistics_AdServer_pgsql::OA_Dal_Maintenance_Statistics_AdServer_pgsql()
     */
    function OA_Dal_Maintenance_Statistics_AdServer_pgsqlSplit()
    {
        parent::OA_Dal_Maintenance_Statistics_AdServer_pgsql();
    }

    /**
     * A method to find the last time that maintenance statistics was run.
     *
     * @param integer $type The update type that occurred - that is,
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI if the update was
     *                      done on the basis of the operation interval,
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR if the update
     *                      was done on the basis of the hour, or
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH if the update
     *                      was done on the basis of both the operation
     *                      interval and the hour.
     * @param Date $oNow An optional Date, used to specify the "current time", and
     *                   to limit the method to only look for past maintenance
     *                   statistics runs before this date. Normally only used
     *                   to assist with re-generation of statistics in the event
     *                   of faulty raw tables.
     * @return Date A Date representing the date up to which the statistics
     *              have been summarised, for the specified update type, or
     *              the appropriate date based on raw data if maintenance
     *              statistics has never been run for the Openads module before.
     *              Returns null if no raw data is available.
     */
    function getMaintenanceStatisticsLastRunInfo($type, $oNow = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_ad_impression'] . '_' .
                 date('Ymd');
        return $this->_getMaintenanceStatisticsLastRunInfo($type, "AdServer", $table, $oNow);
    }

   /**
     * A private method to summarise request, impression or click data.
     *
     * @access private
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd   The end date/time to summarise to.
     * @param string     $type   Type of data to summarise.
     * @return integer The number of rows summarised.
    */
    function _summariseData($oStart, $oEnd, $type)
    {
        return parent::_summariseData($oStart, $oEnd, $type, true);
    }

    /**
     * A method for summarising connections into a temporary table.
     *
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd The end date/time to summarise to.
     * @return integer The number of connection rows summarised.
     */
    function summariseConnections($oStart, $oEnd)
    {
        $rows = 0;
        // Summarise connections based on ad impressions
        $rows += $this->_summariseConnections($oStart, $oEnd, 'impression', MAX_CONNECTION_AD_IMPRESSION, true);
        // Summarise connections based on ad clicks
        $rows += $this->_summariseConnections($oStart, $oEnd, 'click', MAX_CONNECTION_AD_CLICK, true);
        // Return the total summarised connections
        return $rows;
    }

    /**
     * A method to update the intermediate tables with summarised data.
     *
     * @param PEAR::Date $oStart The start date/time to save from.
     * @param PEAR::Date $oEnd The end date/time to save to.
     * @param array $aActions An array of action types to summarise. Contains
     *                        two array, the first containing the data types,
     *                        and the second containing the connection type
     *                        values associated with those data types, if
     *                        appropriate. For example:
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
    function saveIntermediate($oStart, $oEnd, $aActions, $intermediateTable = 'data_intermediate_ad', $saveConnections = true)
    {
        $this->_saveIntermediate($oStart, $oEnd, $aActions, $intermediateTable = 'data_intermediate_ad', $saveConnections, true);
    }

}

?>
