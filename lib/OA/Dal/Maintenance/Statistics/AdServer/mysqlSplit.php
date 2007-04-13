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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/AdServer/mysql.php';
require_once 'Date.php';

/**
 * The data access layer code for summarising raw data into statistics, for
 * the AdServer module, when split tables are in use.
 *
 * @package    OpenadsDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Dal_Maintenance_Statistics_AdServer_mysqlSplit extends OA_Dal_Maintenance_Statistics_AdServer_mysql
{

    /**
     * The constructor method.
     *
     * @uses OA_Dal_Maintenance_Statistics_AdServer_mysql::OA_Dal_Maintenance_Statistics_AdServer_mysql()
     */
    function OA_Dal_Maintenance_Statistics_AdServer_mysqlSplit()
    {
        parent::OA_Dal_Maintenance_Statistics_AdServer_mysql();
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
     *              statistics has never been run for the Max module before.
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

    /**
     * A method to delete old (ie. summarised) raw data.
     *
     * @param Date $oSummarisedTo The date/time up to which data have been summarised (i.e. if there
     *                            is no newer data than this date (minus any compact_stats_grace window)
     *                            then the raw table will be dropped, unless required by the tracking
     *                            module, where installed).
     * @return integer The number of raw tables dropped.
     */
    function deleteOldData($oSummarisedTo)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oNow = new Date();  // Current day
        $oDeleteDate = $oSummarisedTo;
        $oTable = new OA_DB_Table();
        if ($aConf['maintenance']['compactStatsGrace'] > 0) {
            $oDeleteDate->subtractSeconds((int) $aConf['maintenance']['compactStatsGrace']);
        }
        $tablesDropped = 0;
        // As split tables are in use, look over all possible tables
        $aTables = $this->oDbh->manager->listTables();
        if (PEAR::isError($aTables)) {
            return MAX::raiseError($aTables, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        // Delete the requests before taking into account the maximum connection window
        foreach ($aTables as $table) {
            // Look at the data_raw_ad_request tables
            if (preg_match('/^' . $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_request'] . '_' .
                           '(\d{4})(\d{2})(\d{2})$/', $table, $matches)) {
                $oDate = new Date("{$matches[1]}-{$matches[2]}-{$matches[3]}");
                // Is this today's table?
                if (($oDate->getYear() == $oNow->getYear()) &&
                    ($oDate->getMonth() == $oNow->getMonth()) &&
                    ($oDate->getDay() == $oNow->getDay())) {
                    // Don't drop today's table
                    continue;
                }
                $table = $aConf['table']['prefix'] .
                         $aConf['table']['data_raw_ad_request'] . '_' .
                         $oDate->format('%Y%m%d');
                $query = "
                    SELECT
                        *
                    FROM
                        $table
                    WHERE
                        date_time > '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'
                    LIMIT 1";
                MAX::debug("Selecting non-summarised (later than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                           "') ad requests from the $table table", PEAR_LOG_DEBUG);
                $rc = $this->oDbh->query($query);
                if (PEAR::isError($rc)) {
                    MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
                if ($rc->numRows() == 0) {
                    // No current data in the table - drop it
                    MAX::debug("No non-summarised ad requests in the $table table, so dropping",
                               PEAR_LOG_DEBUG);
                    $oTable->dropTable($table);
                    $tablesDropped++;
                }
            }
        }
        // Take into account the maximum connection window, if approproate
        if ($aConf['modules']['Tracker']) {
            // Find the largest, active impression and click connection windows
            list($impressionWindow, $clickWindow) = $this->oDalMaintenanceStatistics->maxConnectionWindows();
            // Find the largest of the two windows
            if ($impressionWindow > $clickWindow) {
                $maxWindow = $impressionWindow;
            } else {
                $maxWindow = $clickWindow;
            }
            MAX::debug('Found maximum connection window of ' . $maxWindow . ' seconds', PEAR_LOG_DEBUG);
            $oDeleteDate->subtractSeconds((int) $maxWindow); // Cast to int, as Date class
                                                             // doesn't deal with strings
        }
        // Delete from remaining tables
        foreach ($aTables as $table) {
            // Look at the data_raw_ad_impression tables
            if (preg_match('/^' . $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression'] . '_' .
                           '(\d{4})(\d{2})(\d{2})$/', $table, $matches)) {
                $oDate = new Date("{$matches[1]}-{$matches[2]}-{$matches[3]}");
                // Is this today's table?
                if (($oDate->getYear() == $oNow->getYear()) &&
                    ($oDate->getMonth() == $oNow->getMonth()) &&
                    ($oDate->getDay() == $oNow->getDay())) {
                    // Don't drop today's table
                    continue;
                }
                $table = $aConf['table']['prefix'] .
                         $aConf['table']['data_raw_ad_impression'] . '_' .
                         $oDate->format('%Y%m%d');
                $query = "
                    SELECT
                        *
                    FROM
                        $table
                    WHERE
                        date_time > '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'
                    LIMIT 1";
                MAX::debug("Selecting non-summarised (later than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                           "') ad impressions from the $table table", PEAR_LOG_DEBUG);
                $rc = $this->oDbh->query($query);
                if (PEAR::isError($rc)) {
                    MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
                if ($rc->numRows() == 0) {
                    // No current data in the table - drop it
                    MAX::debug("No non-summarised ad impressions in the $table table, so dropping",
                               PEAR_LOG_DEBUG);
                    $oTable->dropTable($table);
                    $tablesDropped++;
                }
            }
            // Look at the data_raw_ad_click tables
            if (preg_match('/^' . $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_click'] . '_' .
                           '(\d{4})(\d{2})(\d{2})$/', $table, $matches)) {
                $oDate = new Date("{$matches[1]}-{$matches[2]}-{$matches[3]}");
                // Is this today's table?
                if (($oDate->getYear() == $oNow->getYear()) &&
                    ($oDate->getMonth() == $oNow->getMonth()) &&
                    ($oDate->getDay() == $oNow->getDay())) {
                    // Don't drop today's table
                    continue;
                }
                $table = $aConf['table']['prefix'] .
                         $aConf['table']['data_raw_ad_click'] . '_' .
                         $oDate->format('%Y%m%d');
                $query = "
                    SELECT
                        *
                    FROM
                        $table
                    WHERE
                        date_time > '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'
                    LIMIT 1";
                MAX::debug("Selecting non-summarised (later than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                           "') ad clicks from the $table table", PEAR_LOG_DEBUG);
                $rc = $this->oDbh->query($query);
                if (PEAR::isError($rc)) {
                    MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
                if ($rc->numRows() == 0) {
                    // No current data in the table - drop it
                    MAX::debug("No non-summarised ad clicks in the $table table, so dropping",
                               PEAR_LOG_DEBUG);
                    $oTable->dropTable($table);
                    $tablesDropped++;
                }
            }
        }
        return $tablesDropped;
    }

}

?>
