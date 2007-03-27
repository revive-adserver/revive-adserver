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

require_once MAX_PATH . '/lib/max/Maintenance.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Common.php';
require_once 'Date.php';

/**
 * The data access layer code for summarising raw data into statistics, for
 * the Tracker module.
 *
 * @package    MaxDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew@m3.net>
 */
class OA_Dal_Maintenance_Statistics_Tracker_mysql extends OA_Dal_Maintenance_Statistics_Common
{
    var $oDbh;

    /**
     * The constructor method.
     *
     * @uses OA_Dal_Maintenance_Statistics_Common::OA_Dal_Maintenance_Statistics_Common()
     */
    function OA_Dal_Maintenance_Statistics_Tracker_mysql()
    {
        parent::OA_Dal_Maintenance_Statistics_Common();
        $this->oDbh = &OA_DB::singleton();
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
                 $aConf['table']['data_raw_tracker_impression'];
        return $this->_getMaintenanceStatisticsLastRunInfo($type, $table, $oNow);
    }

    /**
     * A private function to do the job of
     * {@link OA_Dal_Maintenance_Statistics_Tracker_mysql::getMaintenanceStatisticsLastRunInfo()},
     * but with an extra parameter to specify the raw table to look in, in
     * the case of maintenance statistics not having been run before.
     *
     * @access private
     * @param integer $type The update type that occurred - that is,
     *                      DAL_STATISTICS_COMMON_UPDATE_OI if the update was
     *                      done on the basis of the operation interval,
     *                      DAL_STATISTICS_COMMON_UPDATE_HOUR if the update
     *                      was done on the basis of the hour, or
     *                      DAL_STATISTICS_COMMON_UPDATE_BOTH if the update
     *                      was done on the basis of both the operation
     *                      interval and the hour.
     * @param string $rawTable The raw table to use in case of no previous run.
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
    function _getMaintenanceStatisticsLastRunInfo($type, $rawTable, $oNow = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($type == DAL_STATISTICS_COMMON_UPDATE_OI) {
            $whereClause = 'WHERE (tracker_run_type = ' . DAL_STATISTICS_COMMON_UPDATE_OI .
                           ' OR tracker_run_type = ' . DAL_STATISTICS_COMMON_UPDATE_BOTH . ')';
            $rawType = 'oi';
        } elseif ($type == DAL_STATISTICS_COMMON_UPDATE_HOUR) {
            $whereClause = 'WHERE (tracker_run_type = ' . DAL_STATISTICS_COMMON_UPDATE_HOUR  .
                           ' OR tracker_run_type = ' . DAL_STATISTICS_COMMON_UPDATE_BOTH . ')';
           $rawType = 'hour';
        } elseif ($type == DAL_STATISTICS_COMMON_UPDATE_BOTH) {
            $whereClause = 'WHERE (tracker_run_type = ' . DAL_STATISTICS_COMMON_UPDATE_BOTH  . ')';
            $rawType = 'hour';
        } else {
            MAX::debug('Invalid update type value ' . $type, PEAR_LOG_ERR);
            MAX::debug('Aborting script execution', PEAR_LOG_ERR);
            exit();
        }
        if (!is_null($oNow)) {
            // Limit to past maintenance statistics runs before this Date
            $whereClause .= ' AND updated_to < ' . "'" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'";
        }
        $message = 'Getting the details of when maintenance statistics last ran for the Tracker module ' .
                   'on the basis of the ';
        if ($type == DAL_STATISTICS_COMMON_UPDATE_OI) {
            $message .= 'operation interval';
        } elseif ($type == DAL_STATISTICS_COMMON_UPDATE_HOUR) {
            $message .= 'hour';
        } elseif ($type == DAL_STATISTICS_COMMON_UPDATE_BOTH) {
            $message .= 'both the opertaion interval and hour';
        }
        MAX::debug($message, PEAR_LOG_DEBUG);
        $aRow = $this->oDalMaintenanceStatistics->getProcessLastRunInfo(
            $aConf['table']['prefix'] . $aConf['table']['log_maintenance_statistics'],
            array(),
            $whereClause,
            'updated_to',
            array(
                'tableName' => $rawTable,
                'type'      => $rawType
            )
        );
        if ($aRow === false) {
            $error = 'Error finding details on when maintenance statistics last ran for the Tracker module.';
            return MAX::raiseError($error, null, PEAR_ERROR_DIE);
        }
        if (!is_null($aRow)) {
            $oDate = new Date($aRow['updated_to']);
            return $oDate;
        }
        // No raw data was found
        return null;
    }

    /**
     * A method to delete old (ie. summarised) raw data.
     *
     * @param Date $oSummarisedTo The date/time up to which data have been summarised (i.e. data up
     *                            to and including this date (minus any compact_stats_grace window)
     *                            will be deleted).
     * @return integer The number of rows deleted.
     */
    function deleteOldData($oSummarisedTo)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDeleteDate = $oSummarisedTo;
        if ($aConf['maintenance']['compactStatsGrace'] > 0) {
            $oDeleteDate->subtractSeconds((int) $aConf['maintenance']['compactStatsGrace']);
        }
        $resultRows = 0;
        // Delete the tracker impressions
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_tracker_impression'];
        $query = "
            DELETE FROM
                $table
            WHERE
                date_time <= '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'";
        MAX::debug("Deleting summarised (earlier than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                   "') tracker impressions from the $table table", PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $resultRows += $rows;
        // Delete the tracker variable values
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_tracker_variable_value'];
        $query = "
            DELETE FROM
                $table
            WHERE
                date_time <= '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'";
        MAX::debug("Deleting summarised (earlier than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                   "') tracker variable values from the $table table", PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $resultRows += $rows;
        // Delete the tracker clicks
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_tracker_click'];
        $query = "
            DELETE FROM
                $table
            WHERE
                date_time <= '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'";
        MAX::debug("Deleting summarised (earlier than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                   "') tracker clicks from the $table table", PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $resultRows += $rows;
        return $resultRows;
    }

}

?>
