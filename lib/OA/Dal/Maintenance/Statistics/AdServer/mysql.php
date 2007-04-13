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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance.php';
require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Common.php';
require_once 'Date.php';

/**
 * The data access layer code for summarising raw data into statistics, for
 * the AdServer module.
 *
 * @package    OpenadsDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Dal_Maintenance_Statistics_AdServer_mysql extends OA_Dal_Maintenance_Statistics_Common
{

    /**
     * A local store for keeping the default MySQL sort_buffer_size
     * session variable value, so that it can be restored after
     * changing it to another value.
     *
     * @var integer
     */
    var $sortBufferSize;

    /**
     * The constructor method.
     *
     * @uses OA_Dal_Maintenance_Statistics_Common::OA_Dal_Maintenance_Statistics_Common()
     */
    function OA_Dal_Maintenance_Statistics_AdServer_mysql()
    {
        parent::OA_Dal_Maintenance_Statistics_Common();
        // Store the original MySQL sort_buffer_size value
        $query = "SHOW SESSION VARIABLES like 'sort_buffer_size'";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $aRow = $rc->fetchRow();
        if (is_array($aRow) && (count($aRow) == 2) && (isset($aRow['Value']))) {
            $this->sortBufferSize = $aRow['Value'];
        }
    }

    /**
     * A method to set the MySQL sort_buffer_size session variable,
     * if appropriate.
     *
     * @access private
     */
    function setSortBufferSize()
    {
        // Only set if the original sort_buffer_size is stored, and
        // if a specified value for the sort_buffer_size has been
        // defined by the user in the configuration
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (isset($this->sortBufferSize) && isset($aConf['databaseMysql']['statisticsSortBufferSize']) &&
            is_numeric($aConf['databaseMysql']['statisticsSortBufferSize'])) {
            $query = 'SET SESSION sort_buffer_size='.$aConf['databaseMysql']['statisticsSortBufferSize'];
            $rows = $this->oDbh->exec($query);
            if (PEAR::isError($rows)) {
                MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }
        }
    }

    /**
     * A method to restore the MySQL sort_buffer_size session variable,
     * if appropriate.
     *
     * @access private
     */
    function restoreSortBufferSize()
    {
        // Only restore if the original sort_buffer_size is stored,
        // and if a specified value for the sort_buffer_size has
        // been defined by the user in the configuration
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (isset($this->sortBufferSize) && isset($aConf['databaseMysql']['statisticsSortBufferSize']) &&
            is_numeric($aConf['databaseMysql']['statisticsSortBufferSize'])) {
            $query = 'SET SESSION sort_buffer_size='.$aConf->sortBufferSize;
            $rows = $this->oDbh->exec($query);
            if (PEAR::isError($rows)) {
                MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }
        }
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
                 $aConf['table']['data_raw_ad_impression'];
        return $this->_getMaintenanceStatisticsLastRunInfo($type, "AdServer", $table, $oNow);
    }

    /**
     * A method for summarising requests into a temporary table.
     *
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd   The end date/time to summarise to.
     * @return integer The number of request rows summarised.
     */
    function summariseRequests($oStart, $oEnd)
    {
        // Set the MySQL sort buffer size
        $this->setSortBufferSize();
        // Summarise the requests
        return $this->_summariseData($oStart, $oEnd, 'request');
        // Restore the MySQL sort buffer size
        $this->restoreSortBufferSize();
    }

    /**
     * A method for summarising impressions into a temporary table.
     *
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd   The end date/time to summarise to.
     * @return integer The number of impression rows summarised.
     */
    function summariseImpressions($oStart, $oEnd)
    {
        // Set the MySQL sort buffer size
        $this->setSortBufferSize();
        // Summarise the impressions
        return $this->_summariseData($oStart, $oEnd, 'impression');
        // Restore the MySQL sort buffer size
        $this->restoreSortBufferSize();
    }

    /**
     * A method for summarising clicks into a temporary table.
     *
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd   The end date/time to summarise to.
     * @return integer The number of click rows summarised.
     */
    function summariseClicks($oStart, $oEnd)
    {
        // Set the MySQL sort buffer size
        $this->setSortBufferSize();
        // Summarise the clicks
        return $this->_summariseData($oStart, $oEnd, 'click');
        // Restore the MySQL sort buffer size
        $this->restoreSortBufferSize();
    }

    /**
     * A private method to mark those connections in the tmp_ad_connection
     * temporary table that are the "latest" connections, in the even that
     * there are duplicate connections per tracker impression.
     *
     * @access private
     * @param PEAR::Date $oStart The start date/time to mark from.
     * @param PEAR::Date $oEnd   The end date/time to mark to.
     * @return integer Returns the number of connections marked as "latest"
     *                 in the tmp_ad_connection table.
     */
    function _saveIntermediateMarkLatestConnections($oStart, $oEnd)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Select the possible connections that are the most recent connections,
        // in the case of duplicate connections per tracker impression, and put
        // them into the tmp_connection_latest table
        $query = "
            CREATE TEMPORARY TABLE
                tmp_connection_latest
            TYPE={$aConf['table']['type']}
            SELECT
                tac.server_raw_tracker_impression_id AS server_raw_tracker_impression_id,
                tac.server_raw_ip AS server_raw_ip,
                MAX(tac.connection_date_time) AS connection_date_time
            FROM
                tmp_ad_connection AS tac
            WHERE
                tac.date_time >= '" . $oStart->format('%Y-%m-%d %H:%M:%S') . "'
                AND tac.date_time <= '" . $oEnd->format('%Y-%m-%d %H:%M:%S') . "'
            GROUP BY
                tac.server_raw_tracker_impression_id, tac.server_raw_ip";
        MAX::debug('Selecting the possible connections that are the most recent connections ' .
                   '(ie. they have the most recent connection_date_time field).', PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        // Mark these "latest" connections in the tmp_ad_connection table
        $query = "
            UPDATE
                tmp_ad_connection AS tac,
                tmp_connection_latest AS tcl
            SET
                tac.latest = 1
            WHERE
                tac.server_raw_tracker_impression_id = tcl.server_raw_tracker_impression_id
                AND tac.server_raw_ip = tcl.server_raw_ip
                AND tac.connection_date_time = tcl.connection_date_time";
        MAX::debug('Setting the \'latest connection\' flag in the temporary tmp_connection table.',
                   PEAR_LOG_DEBUG);
        $connectionRows = $this->oDbh->exec($query);
        if (PEAR::isError($connectionRows)) {
            return MAX::raiseError($connectionRows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        // Drop the tmp_connection_latest table
        $this->tempTables->dropTable('tmp_connection_latest');
        return $connectionRows;
    }

    /**
     * A private method to return the required SQL string to create the temporary
     * "tmp_union" table, which will be prepended to a SELECT statement to fill
     * the table.
     *
     * @abstract
     * @access private
     * @return string The required SQL code.
     */
    function _saveIntermediateCreateUnionGetSql()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = "
            CREATE TEMPORARY TABLE
                tmp_union
            TYPE={$aConf['table']['type']}";
        return $query;
    }

    /**
     * A private method to reject conversions which have empty required variables.
     * The method check connections from last interval (between $start and $end) and
     * marks as disapproved those  them
     * between those dates.
     *
     * @param PEAR::Date $oStart The start date/time of current interval
     * @param PEAR::Date $oEnd   The end date/time of current interval
     */
    function _saveIntermediateRejectEmptyVarConversions($oStart, $oEnd)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = "
            UPDATE
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']} AS diac
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['variables']} AS v
            ON
                (
                    diac.tracker_id = v.trackerid
                )
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_variable_value']} AS diavv
            ON
                (
                    diac.data_intermediate_ad_connection_id = diavv.data_intermediate_ad_connection_id
                    AND
                    v.variableid = diavv.tracker_variable_id
                )
            SET
                diac.connection_status = ". MAX_CONNECTION_STATUS_DISAPPROVED .",
                diac.updated = '". date('Y-m-d H:i:s') ."',
                diac.comments = CONCAT('Rejected because ', COALESCE(NULLIF(v.description, ''), v.name), ' is empty')
            WHERE
                diac.tracker_date_time >= '" . $oStart->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                diac.tracker_date_time <= '" . $oEnd->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                diac.inside_window = 1
                AND
                v.reject_if_empty = 1
                AND
                (diavv.value IS NULL OR diavv.value = '')
            ";
        $message = 'Rejecting conversions with empty required variables between "' . $oStart->format('%Y-%m-%d %H:%M:%S') . '"' .
                   ' and "' . $oEnd->format('%Y-%m-%d %H:%M:%S') . '"';
        MAX::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
    }

    /**
     * A private method to dedup conversions which have associated unique variables.
     * The method check connections from last interval (between $start and $end) and dedup them
     * between those dates.
     *
     * @param PEAR::Date $oStart The start date/time of current interval
     * @param PEAR::Date $oEnd The end date/time of current interval
     */
    function _saveIntermediateDeduplicateConversions($oStart, $oEnd)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = "
            UPDATE
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']} AS diac
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_variable_value']} AS diavv
            ON
                (
                    diac.data_intermediate_ad_connection_id = diavv.data_intermediate_ad_connection_id
                    AND
                    diac.inside_window = 1
                    AND
                    diac.tracker_date_time >= '" . $oStart->format('%Y-%m-%d %H:%M:%S') . "'
                    AND
                    diac.tracker_date_time <= '" . $oEnd->format('%Y-%m-%d %H:%M:%S') . "'
                )
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['variables']} AS v
            ON
                (
                    diavv.tracker_variable_id = v.variableid
                    AND
                    v.is_unique = 1
                )
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']} AS diac2
            ON
                (
                    v.trackerid = diac2.tracker_id
                    AND
                    diac.inside_window = 1
                    AND
                    UNIX_TIMESTAMP(diac.tracker_date_time) - UNIX_TIMESTAMP(diac2.tracker_date_time) < v.unique_window
                    AND
                    UNIX_TIMESTAMP(diac.tracker_date_time) - UNIX_TIMESTAMP(diac2.tracker_date_time) > 0
                )
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_variable_value']} AS diavv2
            ON
                (
                    diac2.data_intermediate_ad_connection_id = diavv2.data_intermediate_ad_connection_id
                    AND
                    diavv2.tracker_variable_id = diavv.tracker_variable_id
                    AND
                    diavv2.value = diavv.value
                )
            SET
                diac.connection_status = ". MAX_CONNECTION_STATUS_DUPLICATE .",
                diac.updated = '". date('Y-m-d H:i:s') ."',
                diac.comments = CONCAT('Duplicate of connection ID ', diac2.data_intermediate_ad_connection_id)";
        $message = 'Deduplicating conversions between "' . $oStart->format('%Y-%m-%d %H:%M:%S') . '"' .
                   ' and "' . $oEnd->format('%Y-%m-%d %H:%M:%S') . '"';
        MAX::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
    }

    /**
     * A method to update the zone impression history table from the intermediate tables.
     *
     * @param PEAR::Date $oStart The start date/time to update from.
     * @param PEAR::Date $oEnd The end date/time to update to.
     */
    function saveHistory($oStart, $oEnd)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $fromTable = $aConf['table']['prefix'] .
                     $aConf['table']['data_intermediate_ad'];
        $toTable   = $aConf['table']['prefix'] .
                     $aConf['table']['data_summary_zone_impression_history'];
        $query = "
            SELECT
                operation_interval AS operation_interval,
                operation_interval_id AS operation_interval_id,
                interval_start AS interval_start,
                interval_end AS interval_end,
                zone_id AS zone_id,
                SUM(impressions) AS actual_impressions
            FROM
                $fromTable
            WHERE
                interval_start >= '".$oStart->format('%Y-%m-%d %H:%M:%S')."'
                AND interval_end <= '".$oEnd->format('%Y-%m-%d %H:%M:%S')."'
            GROUP BY
                zone_id";
        MAX::debug('Selecting total zone impressions from the ' . $fromTable . ' table for data >= ' .
                   $oStart->format('%Y-%m-%d %H:%M:%S') . ', and <= ' . $oEnd->format('%Y-%m-%d %H:%M:%S'),
                   PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        while ($row = $rc->fetchRow()) {
            $query = "
                UPDATE
                    $toTable
                SET
                    actual_impressions = {$row['actual_impressions']}
                WHERE
                    operation_interval = {$row['operation_interval']}
                    AND operation_interval_id = {$row['operation_interval_id']}
                    AND interval_start = '{$row['interval_start']}'
                    AND interval_end = '{$row['interval_end']}'
                    AND zone_id = {$row['zone_id']}";
            $rows = $this->oDbh->exec($query);
            if (PEAR::isError($rows)) {
                return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }
            if ($rows == 0) {
                // Unable to UPDATE, try INSERT instead
                $query = "
                    INSERT INTO
                        $toTable
                        (
                            operation_interval,
                            operation_interval_id,
                            interval_start,
                            interval_end,
                            zone_id,
                            actual_impressions
                        )
                    VALUES
                        (
                            {$row['operation_interval']},
                            {$row['operation_interval_id']},
                            '{$row['interval_start']}',
                            '{$row['interval_end']}',
                            {$row['zone_id']},
                            {$row['actual_impressions']}
                        )";
                $rows = $this->oDbh->exec($query);
                if (PEAR::isError($rows)) {
                    return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
            }
        }
    }

    /**
     * A method to update the summary table from the intermediate tables.
     *
     * @param PEAR::Date $oStartDate The start date/time to update from.
     * @param PEAR::Date $oEndDate The end date/time to update to.
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
     * @param string $fromTable The name of the intermediate table to summarise
     *                          from (e.g. 'data_intermediate_ad').
     * @param string $toTable The name of the summary table to summarise to
     *                        (e.g. 'data_summary_ad_hourly').
     */
    function saveSummary($oStartDate, $oEndDate, $aActions, $fromTable, $toTable)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Check that there are types to summarise
        if (empty($aActions['types']) || empty($aActions['connections'])) {
            return;
        }
        // How many days does the start/end period span?
        $days = Date_Calc::dateDiff($oStartDate->getDay(),
                                    $oStartDate->getMonth(),
                                    $oStartDate->getYear(),
                                    $oEndDate->getDay(),
                                    $oEndDate->getMonth(),
                                    $oEndDate->getYear());
        if ($days == 0) {
            // Save the data
            $this->_saveSummary($oStartDate, $oEndDate, $aActions, $fromTable, $toTable);
        } else {
            // Save each day's data separately
            for ($counter = 0; $counter <= $days; $counter++) {
                if ($counter == 0) {
                    // This is the first day
                    $oInternalStartDate = new Date();
                    $oInternalStartDate->copy($oStartDate);
                    $oInternalEndDate = new Date($oStartDate->format('%Y-%m-%d') . ' 23:59:59');
                } elseif ($counter == $days) {
                    // This is the last day
                    $oInternalStartDate = new Date($oEndDate->format('%Y-%m-%d') . ' 00:00:00');
                    $oInternalEndDate = new Date();
                    $oInternalEndDate->copy($oEndDate);
                } else {
                    // This is a day in the middle
                    $oDayDate = new Date();
                    $oDayDate->copy($oStartDate);
                    $oDayDate->addSeconds(SECONDS_PER_DAY * $counter);
                    $oInternalStartDate = new Date($oDayDate->format('%Y-%m-%d') . ' 00:00:00');
                    $oInternalEndDate = new Date($oDayDate->format('%Y-%m-%d') . ' 23:59:59');
                }
                $this->_saveSummary($oInternalStartDate, $oInternalEndDate, $aActions, $fromTable, $toTable);
            }
        }
    }

    /**
     * A private method to update the summary table from the intermediate tables.
     * Can only be used for start and end dates that are in the same day.
     *
     * @param PEAR::Date $oStartDate The start date/time to update from.
     * @param PEAR::Date $oEndDate The end date/time to update to.
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
     * @param string $fromTable The name of the intermediate table to summarise
     *                          from (e.g. 'data_intermediate_ad').
     * @param string $toTable The name of the summary table to summarise to
     *                        (e.g. 'data_summary_ad_hourly').
     */
    function _saveSummary($oStartDate, $oEndDate, $aActions, $fromTable, $toTable)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
            MAX::raiseError('_saveSummary called with dates not on the same day.', null, PEAR_ERROR_DIE);
        }
        $finalFromTable = $aConf['table']['prefix'] . $aConf['table'][$fromTable];
        $finalToTable   = $aConf['table']['prefix'] . $aConf['table'][$toTable];
        $query = "
            INSERT INTO
                $finalToTable
                (
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,";
        foreach ($aActions['types'] as $type) {
            $query .= "
                    {$type}s,";
        }
        $query .= "
                    conversions,
                    total_basket_value,
                    total_num_items,
                    updated
                )
            SELECT
                day AS day,
                hour AS hour,
                ad_id AS ad_id,
                creative_id AS creative_id,
                zone_id AS zone_id,";
        foreach ($aActions['types'] as $type) {
            $query .= "
                SUM({$type}s) AS {$type}s,";
        }
        $query .= "
                SUM(conversions) AS conversions,
                SUM(total_basket_value) AS total_basket_value,
                SUM(total_num_items) AS total_num_items,
                '".date('Y-m-d H:i:s')."'
            FROM
                $finalFromTable
            WHERE
                day = '".$oStartDate->format('%Y-%m-%d')."'
                AND hour >= ".$oStartDate->format('%H')."
                AND hour <= ".$oEndDate->format('%H')."
            GROUP BY
                day, hour, ad_id, creative_id, zone_id";
        // Prepare the message about what's about to happen
        $message = 'Summarising the ad ' . implode('s, ', $aActions['types']) . 's';
        if ($aConf['modules']['Tracker']) {
            $message .= ' and conversions';
        }
        $message .= " from the $finalFromTable table into the $finalToTable table, for data" .
                    ' between ' . $oStartDate->format('%Y-%m-%d') . ' ' . $oStartDate->format('%H') . ':00:00' .
                    ' and ' . $oStartDate->format('%Y-%m-%d') . ' ' . $oEndDate->format('%H') . ':59:59.';
        MAX::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        // Update the recently summarised data with basic financial information
        $this->_updateWithFinanceInfo($oStartDate, $oEndDate, $toTable);
    }

    /**
     * A method to set basic financial information in a summary table,
     * on the basis of placement and zone financial information.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of records that need updating.
     * @param PEAR::Date $oEndDate The end date of records that need updating.
     * @param string $table The name of the summary table to update with financial
     *                      information (e.g. 'data_summary_ad_hourly').
     */
    function _updateWithFinanceInfo($oStartDate, $oEndDate, $table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
            MAX::raiseError('_updateWithFinanceInfo called with dates not on the same day.', null, PEAR_ERROR_DIE);
        }
        // Obtain a list of unique ad IDs from the summary table
        $query = "
            SELECT DISTINCT
                ad_id AS ad_id
            FROM
                {$aConf['table']['prefix']}{$aConf['table'][$table]}
            WHERE
                day = '".$oStartDate->format('%Y-%m-%d')."'
                AND hour >= ".$oStartDate->format('%H')."
                AND hour <= ".$oEndDate->format('%H');
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $aAdIds = array();
        while ($aRow = $rc->fetchRow()) {
            $aAdIds[] = $aRow['ad_id'];
        }
        // Get the finance information for the ads found
        $aAdFinanceInfo = $this->_getAdFinanceInfo($aAdIds);
        // Update the recently summarised data with basic financial information
        if ($aAdFinanceInfo !== false) {
            $this->_updateAdsWithFinanceInfo($aAdFinanceInfo, $oStartDate, $oEndDate, $table);
        }
        // Obtain the list of unique zone IDs from the summary table
        $query = "
            SELECT DISTINCT
                zone_id AS zone_id
            FROM
                {$aConf['table']['prefix']}{$aConf['table'][$table]}
            WHERE
                day = '".$oStartDate->format('%Y-%m-%d')."'
                AND hour >= ".$oStartDate->format('%H')."
                AND hour <= ".$oEndDate->format('%H');
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $aZoneIds = array();
        while ($aRow = $rc->fetchRow()) {
            $aZoneIds[] = $aRow['zone_id'];
        }
        // Get the finance information for the zones found
        $aZoneFinanceInfo = $this->_getZoneFinanceInfo($aZoneIds);
        // Update the recently summarised data with basic financial information
        if ($aZoneFinanceInfo !== false) {
            $this->_updateZonesWithFinanceInfo($aZoneFinanceInfo, $oStartDate, $oEndDate, $table);
        }
    }

    /**
     * A method to obtain the finance information for a given set of ad IDs.
     *
     * @access private
     * @param array $aAdIds An array of ad IDs for which the finance information is needed.
     * @return mixed An array of arrays, each containing the ad_id, revenue and revenue_type
     *               of those ads required, where the financial information exists; or
     *               false if there none of the ads requested have finance information set.
     */
    function _getAdFinanceInfo($aAdIds)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (empty($aAdIds)) {
            return false;
        }
        $query = "
            SELECT
                a.bannerid AS ad_id,
                c.revenue AS revenue,
                c.revenue_type AS revenue_type
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['campaigns']} AS c,
                {$aConf['table']['prefix']}{$aConf['table']['banners']} AS a
            WHERE
                a.bannerid IN (" . implode(', ', $aAdIds) . ")
                AND a.campaignid = c.campaignid
                AND c.revenue IS NOT NULL
                AND c.revenue_type IS NOT NULL";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            return false;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[] = $aRow;
        }
        if (!empty($aResult)) {
            return $aResult;
        }
        return false;
    }

    /**
     * A method to obtain the finance information for a given set of zone IDs.
     *
     * @access private
     * @param array $aZoneIds An array of zone IDs for which the finance information is needed.
     * @return mixed An array of arrays, each containing the zone_id, cost and cost_type
     *               of those zones required, where the financial information exists; or
     *               false if there none of the zones requested have finance information set.
     */
    function _getZoneFinanceInfo($aZoneIds)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (empty($aZoneIds)) {
            return false;
        }
        $query = "
            SELECT
                z.zoneid AS zone_id,
                z.cost AS cost,
                z.cost_type AS cost_type,
                z.cost_variable_id AS cost_variable_id,
                z.technology_cost AS technology_cost,
                z.technology_cost_type AS technology_cost_type
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['zones']} AS z
            WHERE
                z.zoneid IN (" . implode(', ', $aZoneIds) . ")
                AND z.cost IS NOT NULL
                AND z.cost_type IS NOT NULL";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            return false;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[] = $aRow;
        }
        if (!empty($aResult)) {
            return $aResult;
        }
        return false;
    }

    /**
     * A method to set the basic financial information in a summary table,
     * on the basis of given ad financial information.
     *
     * @access private
     * @param array $aAdFinanceInfo An array of arrays, each with the ad_id, revenue and
     *                              revenue_type information for the ads that need updating.
     * @param PEAR::Date $oStartDate The start date of records that need updating.
     * @param PEAR::Date $oEndDate The end date of records that need updating.
     * @param string $table The name of the summary table to update with financial
     *                      information (e.g. 'data_summary_ad_hourly').
     *
     * Note: The method looks for a special variable in the service locator, called
     *       "aAdFinanceMappings". If found, and an array, the contents of the array
     *       are used to determine the column name that should be used when calculating
     *       the finance information in the SQL statement, for the appropriate revenue
     *       type. If not found, the default mapping is used:
     *       array(
     *           MAX_FINANCE_CPM => impressions,
     *           MAX_FINANCE_CPC => clicks,
     *           MAX_FINANCE_CPA => conversions
     *       )
     *
     * Note: The method looks for a special variable in the service locator, called
     *       "aAdFinanceLimitTypes". If found, and an array, the contents of the array
     *       are tested to see if the revenue type set for the ad ID to be updated is
     *       in the array. If it is not, then the finance information is not set for
     *       the ad.
     *
     * @TODO Update to deal with monthly tenancy.
     */
    function _updateAdsWithFinanceInfo($aAdFinanceInfo, $oStartDate, $oEndDate, $table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%H') != 0 || $oEndDate->format('%H') != 23) {
            if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
                MAX::raiseError('_updateAdsWithFinanceInfo called with dates not on the same day.', null, PEAR_ERROR_DIE);
            }
        }
        $oServiceLocator = &ServiceLocator::instance();
        // Prepare the revenue type to column name mapping array
        $aAdFinanceMappings = &$oServiceLocator->get('aAdFinanceMappings');
        if (($aAdFinanceMappings === false) || (!array($aAdFinanceMappings)) || (empty($aAdFinanceMappings))) {
            $aAdFinanceMappings = array(
                MAX_FINANCE_CPM => 'impressions',
                MAX_FINANCE_CPC => 'clicks',
                MAX_FINANCE_CPA => 'conversions'
            );
        }
        // Try to get the $aAdFinanceLimitTypes array
        $aAdFinanceLimitTypes = &$oServiceLocator->get('aAdFinanceLimitTypes');
        foreach ($aAdFinanceInfo as $aInfo) {
            $query = '';
            $setInfo = true;
            // Test to see if the finance information should NOT be set for this ad
            if ($aAdFinanceLimitTypes !== false) {
                if (is_array($aAdFinanceLimitTypes) && (!empty($aAdFinanceLimitTypes))) {
                    // Try to find the ad's revenue type in the array
                    if (!in_array($aInfo['revenue_type'], $aAdFinanceLimitTypes)) {
                        // It's not in the array, don't set the finance info
                        $setInfo = false;
                    }
                }
            }
            // Prepare the SQL query to set the revenue information, if required
            if ($setInfo) {
                switch ($aInfo['revenue_type']) {
                    case MAX_FINANCE_CPM:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_revenue = ({$aAdFinanceMappings[MAX_FINANCE_CPM]} / 1000) * {$aInfo['revenue']},
                                updated = NOW()
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_CPC:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_revenue = {$aAdFinanceMappings[MAX_FINANCE_CPC]} * {$aInfo['revenue']},
                                updated = NOW()
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_CPA:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_revenue = {$aAdFinanceMappings[MAX_FINANCE_CPA]} * {$aInfo['revenue']},
                                updated = NOW()
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                }
            }
            if (!empty($query)) {
                $rows = $this->oDbh->exec($query);
                if (PEAR::isError($rows)) {
                    return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
            }
        }
    }

    /**
     * A method to set the basic financial information in a summay table,
     * on the basis of given zone financial information.
     *
     * @access private
     * @param array $aZoneFinanceInfo An array of arrays, each with the zone_id, cost and
     *                                cost_type information for the zones that need updating.
     * @param PEAR::Date $oStartDate The start date of records that need updating.
     * @param PEAR::Date $oEndDate The end date of records that need updating.
     * @param string $table The name of the summary table to update with financial
     *                      information (e.g. 'data_summary_ad_hourly').
     *
     * Note: The method looks for a special variable in the service locator, called
     *       "aZoneFinanceMappings". If found, and an array, the contents of the array
     *       are used to determine the column name that should be used when calculating
     *       the finance information in the SQL statement, for the appropriate cost
     *       type. If not found, the default mapping is used:
     *       array(
     *           MAX_FINANCE_CPM   => impressions,
     *           MAX_FINANCE_CPC   => clicks,
     *           MAX_FINANCE_CPA   => conversions,
     *           MAX_FINANCE_RS    => total_revenue,
     *           MAX_FINANCE_BV    => total_basket_value,
     *           MAX_FINANCE_AI    => total_num_items,
     *           MAX_FINANCE_ANYVAR => (no mapping),
     *           MAX_FINANCE_VARSUM => (no mapping)
     *       )
     *
     * Note: The method looks for a special variable in the service locator, called
     *       "aZoneFinanceLimitTypes". If found, and an array, the contents of the
     *       array are tested to see if the cost type set for the zone ID to be updated
     *       is in the array. If it is not, then the finance information is not set for
     *       the zone.
     *
     * @TODO Update to deal with monthly tenancy.
     */
    function _updateZonesWithFinanceInfo($aZoneFinanceInfo, $oStartDate, $oEndDate, $table, $aLimitToTypes = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%H') != 0 || $oEndDate->format('%H') != 23) {
            if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
                MAX::raiseError('_updateZonesWithFinanceInfo called with dates not on the same day.', null, PEAR_ERROR_DIE);
            }
        }
        $oServiceLocator = &ServiceLocator::instance();
        // Prepare the revenue type to column name mapping array
        $aZoneFinanceMappings = &$oServiceLocator->get('aZoneFinanceMappings');
        if (($aZoneFinanceMappings === false) || (!array($aZoneFinanceMappings)) || (empty($aZoneFinanceMappings))) {
            $aZoneFinanceMappings = array(
                MAX_FINANCE_CPM     => 'impressions',
                MAX_FINANCE_CPC     => 'clicks',
                MAX_FINANCE_CPA     => 'conversions',
                MAX_FINANCE_RS      => 'total_revenue',
                MAX_FINANCE_BV      => 'total_basket_value',
                MAX_FINANCE_AI      => 'total_num_items',
                MAX_FINANCE_ANYVAR  => '',
                MAX_FINANCE_VARSUM  => '' // no mapping, it will read intermediate tables
            );
        }
        // Prepare the connection actions array to be tracked with MAX_FINANCE_ANYVAR
        $aZoneFinanceConnectionActions = &$oServiceLocator->get('aZoneFinanceConnectionActions');
        if (($aZoneFinanceConnectionActions === false) || (!array($aZoneFinanceConnectionActions)) || (empty($aZoneFinanceConnectionActions))) {
            $aZoneFinanceConnectionActions = array(
                MAX_CONNECTION_AD_IMPRESSION,
                MAX_CONNECTION_AD_CLICK,
                MAX_CONNECTION_MANUAL
            );
        }
        // Try to get the $aZoneFinanceLimitTypes array
        $aZoneFinanceLimitTypes = &$oServiceLocator->get('aZoneFinanceLimitTypes');
        foreach ($aZoneFinanceInfo as $aInfo) {
            $query = '';
            $setInfo = true;
            // Test to see if the finance information should NOT be set for this zone
            if ($aZoneFinanceLimitTypes !== false) {
                if (is_array($aZoneFinanceLimitTypes) && (!empty($aZoneFinanceLimitTypes))) {
                    // Try to find the zone's cost type in the array
                    if (!in_array($aInfo['cost_type'], $aZoneFinanceLimitTypes)) {
                        // It's not in the array, don't set the finance info
                        $setInfo = false;
                    }
                }
            }
            // Prepare the SQL query to set the cost information, if required
            if ($setInfo) {
                switch ($aInfo['cost_type']) {
                    case MAX_FINANCE_CPM:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_cost = ({$aZoneFinanceMappings[MAX_FINANCE_CPM]} / 1000) * {$aInfo['cost']},
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_CPC:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_cost = {$aZoneFinanceMappings[MAX_FINANCE_CPC]} * {$aInfo['cost']},
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_CPA:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_cost = {$aZoneFinanceMappings[MAX_FINANCE_CPA]} * {$aInfo['cost']},
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_RS:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_cost = {$aZoneFinanceMappings[MAX_FINANCE_RS]} * {$aInfo['cost']} / 100,
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_BV:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_cost = {$aZoneFinanceMappings[MAX_FINANCE_BV]} * {$aInfo['cost']} / 100,
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_AI:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_cost = {$aZoneFinanceMappings[MAX_FINANCE_AI]} * {$aInfo['cost']},
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_ANYVAR:
                        // Get variable ID
                        if (!empty($aInfo['cost_variable_id'])) {
                            // Reset costs to be sure we don't leave out rows without conversions
                            $innerQuery = "
                                UPDATE
                                    {$aConf['table']['prefix']}{$aConf['table'][$table]}
                                SET
                                    total_cost = 0,
                                    updated = NOW()
                                WHERE
                                    zone_id = {$aInfo['zone_id']}
                                    AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                    AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                    AND hour >= ".$oStartDate->format('%H')."
                                    AND hour <= ".$oEndDate->format('%H');
                            $rows = $this->oDbh->exec($innerQuery);

                            $innerQuery = "
                                SELECT
                                    DATE_FORMAT(diac.tracker_date_time, '%Y-%m-%d') AS day,
                                    HOUR(diac.tracker_date_time) AS hour,
                                    diac.ad_id,
                                    diac.creative_id,
                                    COALESCE(SUM(diavv.value), 0) * {$aInfo['cost']} / 100 AS total_cost
                                FROM
                                    {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']} diac,
                                    {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_variable_value']} diavv
                                WHERE
                                    diac.zone_id = {$aInfo['zone_id']}
                                    AND diavv.data_intermediate_ad_connection_id = diac.data_intermediate_ad_connection_id
                                    AND diac.tracker_date_time >= '".$oStartDate->format('%Y-%m-%d %H:00:00')."'
                                    AND diac.tracker_date_time <= '".$oEndDate->format('%Y-%m-%d %H:59:59')."'
                                    AND diac.connection_status = ".MAX_CONNECTION_STATUS_APPROVED."
                                    AND diac.connection_action IN (".join(', ', $aZoneFinanceConnectionActions).")
                                    AND diac.inside_window = 1
                                    AND diavv.tracker_variable_id = {$aInfo['cost_variable_id']}
                                GROUP BY
                                    day,
                                    hour,
                                    ad_id,
                                    creative_id
                            ";
                            $rc = $this->oDbh->query($innerQuery);

                            while ($row = $rc->fetchRow()) {
                                $innermostQuery = "
                                    UPDATE
                                        {$aConf['table']['prefix']}{$aConf['table'][$table]}
                                    SET
                                        total_cost = '".$row['total_cost']."',
                                        updated = NOW()
                                    WHERE
                                        zone_id = {$aInfo['zone_id']}
                                        AND day = '".$row['day']."'
                                        AND hour = ".$row['hour']."
                                        AND ad_id = ".$row['ad_id']."
                                        AND creative_id = ".$row['creative_id'];
                                $rows = $this->oDbh->exec($innermostQuery);
                            }
                        }

                        break;
                    case MAX_FINANCE_VARSUM:
                        // Get variable ID
                        if (!empty($aInfo['cost_variable_id'])) {
                            // Reset costs to be sure we don't leave out rows without conversions
                            $innerQuery = "
                                UPDATE
                                    {$aConf['table']['prefix']}{$aConf['table'][$table]}
                                SET
                                    total_cost = 0,
                                    updated = NOW()
                                WHERE
                                    zone_id = {$aInfo['zone_id']}
                                    AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                    AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                    AND hour >= ".$oStartDate->format('%H')."
                                    AND hour <= ".$oEndDate->format('%H');
                            $rows = $this->oDbh->exec($innerQuery);

                            $innerQuery = "
                                SELECT
                                    DATE_FORMAT(diac.tracker_date_time, '%Y-%m-%d') AS day,
                                    HOUR(diac.tracker_date_time) AS hour,
                                    diac.ad_id,
                                    diac.creative_id,
                                    COALESCE(SUM(diavv.value), 0) * {$aInfo['cost']} / 100 AS total_cost
                                FROM
                                    {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']} diac,
                                    {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_variable_value']} diavv
                                WHERE
                                    diac.zone_id = {$aInfo['zone_id']}
                                    AND diavv.data_intermediate_ad_connection_id = diac.data_intermediate_ad_connection_id
                                    AND diac.tracker_date_time >= '".$oStartDate->format('%Y-%m-%d %H:00:00')."'
                                    AND diac.tracker_date_time <= '".$oEndDate->format('%Y-%m-%d %H:59:59')."'
                                    AND diac.connection_status = ".MAX_CONNECTION_STATUS_APPROVED."
                                    AND diac.connection_action IN (".join(', ', $aZoneFinanceConnectionActions).")
                                    AND diac.inside_window = 1
                                    AND diavv.tracker_variable_id IN ({$aInfo['cost_variable_id']})
                                GROUP BY
                                    day,
                                    hour,
                                    ad_id,
                                    creative_id
                            ";
                            $rc = $this->oDbh->query($innerQuery);

                            while ($row = $rc->fetchRow()) {
                                $innermostQuery = "
                                    UPDATE
                                        {$aConf['table']['prefix']}{$aConf['table'][$table]}
                                    SET
                                        total_cost = '".$row['total_cost']."',
                                        updated = NOW()
                                    WHERE
                                        zone_id = {$aInfo['zone_id']}
                                        AND day = '".$row['day']."'
                                        AND hour = ".$row['hour']."
                                        AND ad_id = ".$row['ad_id']."
                                        AND creative_id = ".$row['creative_id'];
                                $rows = $this->oDbh->exec($innermostQuery);
                            }
                        }

                        break;
                }
            }
            if (!empty($query)) {
                $rows = $this->oDbh->exec($query);
                if (PEAR::isError($rows)) {
                    return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
            }

            // Update technology cost information
            $query = '';
            $setInfo = true;
            // Test to see if the technology finance information should NOT be set for this zone
            if ($aZoneFinanceLimitTypes !== false) {
                if (is_array($aZoneFinanceLimitTypes) && (!empty($aZoneFinanceLimitTypes))) {
                    // Try to find the zone's cost type in the array
                    if (!in_array($aInfo['technology_cost_type'], $aZoneFinanceLimitTypes)) {
                        // It's not in the array, don't set the finance info
                        $setInfo = false;
                    }
                }
            }
            // Prepare the SQL query to set the cost information, if required
            if ($setInfo) {
                // Update Technology cost information
                switch ($aInfo['technology_cost_type']) {
                    case MAX_FINANCE_CPM:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_techcost = ({$aZoneFinanceMappings[MAX_FINANCE_CPM]} / 1000) * {$aInfo['technology_cost']},
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_CPC:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_techcost = {$aZoneFinanceMappings[MAX_FINANCE_CPC]} * {$aInfo['technology_cost']},
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                    case MAX_FINANCE_RS:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_techcost = {$aZoneFinanceMappings[MAX_FINANCE_RS]} * {$aInfo['technology_cost']} / 100,
                                updated = NOW()
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= '".$oStartDate->format('%Y-%m-%d')."'
                                AND day <= '".$oEndDate->format('%Y-%m-%d')."'
                                AND hour >= ".$oStartDate->format('%H')."
                                AND hour <= ".$oEndDate->format('%H');
                        break;
                }
            }
            if (!empty($query)) {
                $rows = $this->oDbh->exec($query);
                if (PEAR::isError($rows)) {
                    return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
            }
        }
    }

    /**
     * A method to activate/deactivate campaigns, based on the date and/or the inventory
     * requirements (impressions, clicks and/or conversions).
     *
     * @param Date $oDate The current date/time.
     * @return string Report on the campaigns activated/deactivated.
     */
    function manageCampaigns($oDate)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $report .= "\n";
        $query = "
            SELECT
                ca.campaignid AS campaign_id,
                ca.campaignname AS campaign_name,
                cl.contact AS contact,
                cl.email AS email,
                ca.views AS targetimpressions,
                ca.clicks AS targetclicks,
                ca.conversions AS targetconversions,
                ca.active AS active,
                ca.activate AS start,
                ca.expire AS end,
                NOW() AS now
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['campaigns']} AS ca,
                {$aConf['table']['prefix']}{$aConf['table']['clients']} AS cl
            WHERE
                ca.clientid = cl.clientid";
        MAX::debug("Selecting all campaigns", PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        while ($campaignRow = $rc->fetchRow()) {
            if ($campaignRow['active'] == 't') {
                // The campaign is currently active, look at the campaign
                $disableReason = 0;
                if (($campaignRow['targetimpressions'] > 0) ||
                    ($campaignRow['targetclicks'] > 0) ||
                    ($campaignRow['targetconversions'] > 0)) {
                    // The campaign has an impression, click and/or conversion target,
                    // so get the sum total statistics for the campaign
                    $query = "
                        SELECT
                            SUM(dia.impressions) AS impressions,
                            SUM(dia.clicks) AS clicks,
                            SUM(dia.conversions) AS conversions
                        FROM
                            {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad']} AS dia,
                            {$aConf['table']['prefix']}{$aConf['table']['banners']} AS b
                        WHERE
                            dia.ad_id = b.bannerid
                            AND b.campaignid = {$campaignRow['campaign_id']}";
                    $rcInner = $this->oDbh->query($query);
                    $valuesRow = $rcInner->fetchRow();
                    if ((!is_null($valuesRow['impressions'])) || (!is_null($valuesRow['clicks'])) || (!is_null($valuesRow['conversions']))) {
                        // There were impressions, clicks and/or conversions for this
                        // campaign, so find out if campaign targets have been passed
                        if (is_null($valuesRow['impressions'])) {
                            // No impressions
                            $valuesRow['impressions'] = 0;
                        }
                        if (is_null($valuesRow['clicks'])) {
                            // No clicks
                            $valuesRow['clicks'] = 0;
                        }
                        if (is_null($valuesRow['conversions'])) {
                            // No conversions
                            $valuesRow['conversions'] = 0;
                        }
                        if ($campaignRow['targetimpressions'] > 0) {
                            if ($campaignRow['targetimpressions'] <= $valuesRow['impressions']) {
                                // The campaign has an impressions target, and this has been
                                // passed, so update and disable the campagin
                                $disableReason |= MAX_PLACEMENT_DISABLED_IMPRESSIONS;
                            }
                        }
                        if ($campaignRow['targetclicks'] > 0) {
                            if ($campaignRow['targetclicks'] <= $valuesRow['clicks']) {
                                // The campaign has a click target, and this has been
                                // passed, so update and disable the campaign
                                $disableReason |= MAX_PLACEMENT_DISABLED_CLICKS;
                            }
                        }
                        if ($campaignRow['targetconversions'] > 0) {
                            if ($campaignRow['targetconversions'] <= $valuesRow['conversions']) {
                                // The campaign has a target limitation, and this has been
                                // passed, so update and disable the campagin
                                $disableReason |= MAX_PLACEMENT_DISABLED_CONVERSIONS;
                            }
                        }
                        if ($disableReason) {
                            // One of the campaign targets was exceeded, so disable
                            $query = "
                                UPDATE
                                    {$aConf['table']['prefix']}{$aConf['table']['campaigns']}
                                SET
                                    active = 'f'
                                WHERE
                                    campaignid = {$campaignRow['campaign_id']}";
                            $report .= ' - Exceeded a campaign quota: Deactivating campaign ID ' .
                                  "{$campaignRow['campaign_id']}: {$campaignRow['campaign_name']}\n";
                            MAX::debug('Exceeded a campaign quota: Deactivating campaign ID ' .
                                       "{$campaignRow['campaign_id']}: {$campaignRow['campaign_name']}");
                            $rows = $this->oDbh->exec($query);
                            if (PEAR::isError($rows)) {
                                return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                            }
                            phpAds_userlogAdd(phpAds_actionDeactiveCampaign, $campaignRow['campaign_id']);
                        }
                    }
                }
                // Does the campaign need to be disabled due to the date?
                $end = new Date($campaignRow['end'] . ' 23:59:59');  // Convert day to end of day Date
                if (($end->format('%Y-%m-%d %H:%M:%S') != '0000-00-00 23:59:59') && ($oDate->after($end))) {
                    $disableReason |= MAX_PLACEMENT_DISABLED_DATE;
                    $query = "
                        UPDATE
                            {$aConf['table']['prefix']}{$aConf['table']['campaigns']}
                        SET
                            active = 'f'
                        WHERE
                            campaignid = {$campaignRow['campaign_id']}";
                    $report .= ' - Past campaign end time: Deactivating campaign ID ' .
                          "{$campaignRow['campaign_id']}: {$campaignRow['campaign_name']}\n";
                    MAX::debug('Found campaign end date of ' . $end->format('%Y-%m-%d %H:%M:%S') . ' has been '.
                               'passed by current time of ' . $oDate->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_DEBUG);
                    MAX::debug('Passed campaign end time: Deactivating campaign ID ' .
                               "{$campaignRow['campaign_id']}: {$campaignRow['campaign_name']}", PEAR_LOG_INFO);
                    $rows = $this->oDbh->exec($query);
                    if (PEAR::isError($rows)) {
                        return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                    }
                    phpAds_userlogAdd(phpAds_actionDeactiveCampaign, $campaignRow['campaign_id']);
                }
                if ($disableReason) {
                    // The campaign was disabled, so send the appropriate
                    // message to the campaign's contact
                    $query = "
                        SELECT
                            bannerid AS advertisement_id,
                            description AS description,
                            alt AS alt,
                            url AS url
                        FROM
                            {$aConf['table']['prefix']}{$aConf['table']['banners']}
                        WHERE
                            campaignid = {$campaignRow['campaign_id']}";
                    MAX::debug("Getting the advertisements for campaign ID {$campaignRow['campaign_id']}", PEAR_LOG_DEBUG);
                    $rcAdvertisement = $this->oDbh->query($query);
                    if (PEAR::isError($rcAdvertisement)) {
                        return MAX::raiseError($rcAdvertisement, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                    }
                    while ($advertisementRow = $rcAdvertisement->fetchRow()) {
                        $advertisements[$advertisementRow['advertisement_id']] =
                            array($advertisementRow['description'], $advertisementRow['alt'],
                                  $advertisementRow['url']);
                    }
                    if ($aConf['email']['sendMail']) {
                        $message =& MAX_Maintenance::prepareDeactivateCampaignEmail($campaignRow['contact'],
                                                                                   $campaignRow['campaign_name'],
                                                                                   $disableReason, $advertisements);
                        MAX::sendMail($campaignRow['email'], $campaignRow['contact'],
                                      "Deactivated Banners: {$campaignRow['campaign_name']}", $message);
                    }
                }
            } else {
                // The campaign is not active - does it need to be enabled,
                // based on the campaign starting date?
                $start = new Date($campaignRow['start'] . ' 00:00:00');  // Convert day to start of date Date
                $end   = new Date($campaignRow['end']   . ' 23:59:59');  // Convert day to end of day Date
                if (($start->format('%Y-%m-%d %H:%M:%S') != '0000-00-00 00:00:00') && ($oDate->after($start))) {
                    // There is an activation date, which has been passed. Find out if
                    // there are any impression, click or conversion targets for the
                    // placement (i.e. if the target values are > 0)
                    $remainingImpressions = 0;
                    $remainingClicks      = 0;
                    $remainingConversions = 0;
                    if (($campaignRow['targetimpressions'] > 0) ||
                        ($campaignRow['targetclicks'] > 0) ||
                        ($campaignRow['targetconversions'] > 0)) {
                        // The placement has an impression, click and/or conversion target,
                        // so get the sum total statistics for the placement so far
                        $query = "
                            SELECT
                                SUM(dia.impressions) AS impressions,
                                SUM(dia.clicks) AS clicks,
                                SUM(dia.conversions) AS conversions
                            FROM
                                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad']} AS dia,
                                {$aConf['table']['prefix']}{$aConf['table']['banners']} AS b
                            WHERE
                                dia.ad_id = b.bannerid
                                AND b.campaignid = {$campaignRow['campaign_id']}";
                        $rcInner = $this->oDbh->query($query);
                        $valuesRow = $rcInner->fetchRow();
                        // Set the remaining impressions, clicks and conversions for the placement
                        $remainingImpressions = $campaignRow['targetimpressions'] - $valuesRow['impressions'];
                        $remainingClicks      = $campaignRow['targetclicks']      - $valuesRow['clicks'];
                        $remainingConversions = $campaignRow['targetconversions'] - $valuesRow['conversions'];
                    }
                    // In order for the placement to be activated, need to test:
                    // 1) That there is no impression target (<=0), or, if there is an impression target (>0),
                    //    then there must be remaining impressions to deliver (>0); and
                    // 2) That there is no click target (<=0), or, if there is a click target (>0),
                    //    then there must be remaining clicks to deliver (>0); and
                    // 3) That there is no conversion target (<=0), or, if there is a conversion target (>0),
                    //    then there must be remaining conversions to deliver (>0); and
                    // 4) Either there is no end date, or the end date has not been passed
                    if ((($campaignRow['targetimpressions'] <= 0) || (($campaignRow['targetimpressions'] > 0) && ($remainingImpressions > 0))) &&
                        (($campaignRow['targetclicks']      <= 0) || (($campaignRow['targetclicks']      > 0) && ($remainingClicks      > 0))) &&
                        (($campaignRow['targetconversions'] <= 0) || (($campaignRow['targetconversions'] > 0) && ($remainingConversions > 0))) &&
                        (($end->format('%Y-%m-%d %H:%M:%S') == '0000-00-00 00:00:00') || (($end->format('%Y-%m-%d %H:%M:%S') != '0000-00-00 00:00:00') && (Date::compare($oDate, $end) < 0)))) {
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table']['campaigns']}
                            SET
                                active = 't'
                            WHERE
                                campaignid = {$campaignRow['campaign_id']}";
                        $report .= ' - Past campaign start time: Activating campaign ID ' .
                              "{$campaignRow['campaign_id']}: {$campaignRow['campaign_name']}\n";
                        MAX::debug('Found campaign start date of ' . $start->format('%Y-%m-%d %H:%M:%S') . ' has been '.
                                   'passed by current time of ' . $oDate->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_DEBUG);
                        MAX::debug('Passed campaign start time: Activating campaign ID ' .
                                   "{$campaignRow['campaign_id']}: {$campaignRow['campaign_name']}", PEAR_LOG_INFO);
                        $rows = $this->oDbh->exec($query);
                        if (PEAR::isError($rows)) {
                            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                        }
                        phpAds_userlogAdd(phpAds_actionActiveCampaign, $campaignRow['campaign_id']);
                        // Get the advertisements associated with the campaign
                        $query = "
                            SELECT
                                bannerid AS advertisement_id,
                                description AS description,
                                alt AS alt,
                                url AS url
                            FROM
                                {$aConf['table']['prefix']}{$aConf['table']['banners']}
                            WHERE
                                campaignid = {$campaignRow['campaign_id']}";
                        MAX::debug("Getting the advertisements for campaign ID {$campaignRow['campaign_id']}",
                                   PEAR_LOG_DEBUG);
                        $rcAdvertisement = $this->oDbh->query($query);
                        if (PEAR::isError($rcAdvertisement)) {
                            return MAX::raiseError($rcAdvertisement, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                        }
                        while ($advertisementRow = $rcAdvertisement->fetchRow()) {
                            $advertisements[$advertisementRow['advertisement_id']] =
                                array($advertisementRow['description'], $advertisementRow['alt'],
                                    $advertisementRow['url']);
                        }
                        if ($aConf['email']['sendMail']) {
                            $message =& MAX_Maintenance::prepareActivateCampaignEmail($campaignRow['contact'],
                                                                                      $campaignRow['campaign_name'],
                                                                                      $advertisements);
                            MAX::sendMail($campaignRow['email'], $campaignRow['contact'],
                                          "Activated Banners: {$campaignRow['campaign_name']}", $message);
                        }
                    }
                }
            }
        }
    }

    /**
     * A method to delete old (ie. summarised) raw data.
     *
     * @param Date $oSummarisedTo The date/time up to which data have been summarised (i.e. data up
     *                           to and including this date (minus any compact_stats_grace window)
     *                           will be deleted, unless required by the tracking module, where
     *                           installed).
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
        // Delete the ad requests before taking into account the maximum connection window
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_ad_request'];
        $query = "
            DELETE FROM
                $table
            WHERE
                date_time <= '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'";
        MAX::debug("Deleting summarised (earlier than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                   "') ad requests from the $table table", PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $resultRows += $rows;
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
        // Delete the ad impressions
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_ad_impression'];
        $query = "
            DELETE FROM
                $table
            WHERE
                date_time <= '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'";
        MAX::debug("Deleting summarised (earlier than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                   "') ad impressions from the $table table", PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $resultRows += $rows;
        // Delete the ad clicks
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_ad_click'];
        $query = "
            DELETE FROM
                $table
            WHERE
                date_time <= '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') ."'";
        MAX::debug("Deleting summarised (earlier than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                   "') ad clicks from the $table table", PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $resultRows += $rows;
        return $resultRows;
    }

}

?>
