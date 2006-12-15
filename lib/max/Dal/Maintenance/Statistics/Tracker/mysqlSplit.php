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
$Id: mysqlSplit.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics/Tracker/mysql.php';
require_once 'Date.php';

/**
 * The data access layer code for summarising raw data into statistics, for
 * the Tracker module, when split tables are in use.
 *
 * @package    MaxDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Dal_Maintenance_Statistics_Tracker_mysqlSplit extends MAX_Dal_Maintenance_Statistics_Tracker_mysql
{

    /**
     * The constructor method.
     *
     * @uses MAX_Dal_Maintenance_Statistics_Tracker_mysql::MAX_Dal_Maintenance_Statistics_Tracker_mysql()
     */
    function MAX_Dal_Maintenance_Statistics_Tracker_mysqlSplit()
    {
        parent::MAX_Dal_Maintenance_Statistics_Tracker_mysql();
    }

    /**
     * A method to find the last time that maintenance statistics was run.
     *
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
    function getMaintenanceStatisticsLastRunInfo($type, $now = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] .
                 $conf['table']['data_raw_tracker_impression'] . '_' .
                 date('Ymd');
        return $this->_getMaintenanceStatisticsLastRunInfo($type, $table, $now);
    }

    /**
     * A method to delete old (ie. summarised) raw data.
     *
     * @param Date $summarisedTo The date/time up to which data have been summarised (i.e. if there
     *                           is no newer data than this date (minus any compact_stats_grace window)
     *                           then the raw table will be dropped, unless required by the tracking
     *                           module, where installed).
     * @return integer The number of raw tables dropped.
     */
    function deleteOldData($summarisedTo)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $now = new Date();  // Current day
        $deleteDate = $summarisedTo;
        if ($conf['maintenance']['compactStatsGrace'] > 0) {
            $deleteDate->subtractSeconds((int) $conf['maintenance']['compactStatsGrace']);
        }
        $tablesDropped = 0;
        // As split tables are in use, look over all possible tables
        $tables = $this->dbh->getListOf('tables');
        if (PEAR::isError($result)) {
            return MAX::raiseError($result, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        // Find the largest, active impression and click connection windows
        list($impressionWindow, $clickWindow) = $this->oDalMaintenanceStatistics->maxConnectionWindows();
        // Find the largest of the two windows
        if ($impressionWindow > $clickWindow) {
            $maxWindow = $impressionWindow;
        } else {
            $maxWindow = $clickWindow;
        }
        MAX::debug('Found maximum connection window of ' . $maxWindow . ' seconds', PEAR_LOG_DEBUG);
        $deleteDate->subtractSeconds((int) $maxWindow); // Cast to int, as Date class
                                                        // doesn't deal with strings
        foreach ($tables as $table) {
            // Look at the data_raw_tracker_impression tables
            if (preg_match('/^' . $conf['table']['prefix'] . $conf['table']['data_raw_tracker_impression'] . '_' .
                           '(\d{4})(\d{2})(\d{2})$/', $table, $matches)) {
                $date = new Date("{$matches[1]}-{$matches[2]}-{$matches[3]}");
                // Is this today's table?
                if (($date->getYear() == $now->getYear()) &&
                    ($date->getMonth() == $now->getMonth()) &&
                    ($date->getDay() == $now->getDay())) {
                    // Don't drop today's table
                    continue;
                }
                $table = $conf['table']['prefix'] .
                         $conf['table']['data_raw_tracker_impression'] . '_' .
                         $date->format('%Y%m%d');
                $query = "
                    SELECT
                        *
                    FROM
                        $table
                    WHERE
                        date_time > '" . $deleteDate->format('%Y-%m-%d %H:%M:%S') ."'
                    LIMIT 1";
                MAX::debug("Selecting non-summarised (later than '" . $deleteDate->format('%Y-%m-%d %H:%M:%S') .
                           "') tracker impressions from the $table table", PEAR_LOG_DEBUG);
                $innerResult = $this->dbh->query($query);
                if (PEAR::isError($innerResult)) {
                    return MAX::raiseError($innerResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
                if ($innerResult->numRows() == 0) {
                    // No current data in the table - drop it
                    $query = "DROP TABLE $table";
                    MAX::debug("No non-summarised tracker impressions in the $table table, so dropping",
                               PEAR_LOG_DEBUG);
                    $innerResult = $this->dbh->query($query);
                    $tablesDropped++;
                }
            }
            // Look at the data_raw_tracker_variable_value tables
            if (preg_match('/^' . $conf['table']['prefix'] . $conf['table']['data_raw_tracker_variable_value'] . '_' .
                           '(\d{4})(\d{2})(\d{2})$/', $table, $matches)) {
                $date = new Date("{$matches[1]}-{$matches[2]}-{$matches[3]}");
                // Is this today's table?
                if (($date->getYear() == $now->getYear()) &&
                    ($date->getMonth() == $now->getMonth()) &&
                    ($date->getDay() == $now->getDay())) {
                    // Don't drop today's table
                    continue;
                }
                $table = $conf['table']['prefix'] .
                         $conf['table']['data_raw_tracker_variable_value'] . '_' .
                         $date->format('%Y%m%d');
                $query = "
                    SELECT
                        *
                    FROM
                        $table
                    WHERE
                        date_time > '" . $deleteDate->format('%Y-%m-%d %H:%M:%S') ."'
                    LIMIT 1";
                MAX::debug("Selecting non-summarised (later than '" . $deleteDate->format('%Y-%m-%d %H:%M:%S') .
                           "') tracker variable values from the $table table", PEAR_LOG_DEBUG);
                $innerResult = $this->dbh->query($query);
                if (PEAR::isError($innerResult)) {
                    return MAX::raiseError($innerResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
                if ($innerResult->numRows() == 0) {
                    // No current data in the table - drop it
                    $query = "DROP TABLE $table";
                    MAX::debug("No non-summarised tracker variable values in the $table table, so dropping",
                               PEAR_LOG_DEBUG);
                    $innerResult = $this->dbh->query($query);
                    $tablesDropped++;
                }
            }
            // Look at the data_raw_tracker_click tables
            if (preg_match('/^' . $conf['table']['prefix'] . $conf['table']['data_raw_tracker_click'] . '_' .
                           '(\d{4})(\d{2})(\d{2})$/', $table, $matches)) {
                $date = new Date("{$matches[1]}-{$matches[2]}-{$matches[3]}");
                // Is this today's table?
                if (($date->getYear() == $now->getYear()) &&
                    ($date->getMonth() == $now->getMonth()) &&
                    ($date->getDay() == $now->getDay())) {
                    // Don't drop today's table
                    continue;
                }
                $table = $conf['table']['prefix'] .
                         $conf['table']['data_raw_tracker_click'] . '_' .
                         $date->format('%Y%m%d');
                $query = "
                    SELECT
                        *
                    FROM
                        $table
                    WHERE
                        date_time > '" . $deleteDate->format('%Y-%m-%d %H:%M:%S') ."'
                    LIMIT 1";
                MAX::debug("Selecting non-summarised (later than '" . $deleteDate->format('%Y-%m-%d %H:%M:%S') .
                           "') tracker clicks from the $table table", PEAR_LOG_DEBUG);
                $innerResult = $this->dbh->query($query);
                if (PEAR::isError($innerResult)) {
                    return MAX::raiseError($innerResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
                if ($innerResult->numRows() == 0) {
                    // No current data in the table - drop it
                    $query = "DROP TABLE $table";
                    MAX::debug("No non-summarised tracker clicks in the $table table, so dropping",
                               PEAR_LOG_DEBUG);
                    $innerResult = $this->dbh->query($query);
                    $tablesDropped++;
                }
            }
        }
        return $tablesDropped;
    }

}

?>
