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
 * @package    OpenadsDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openads.org>
 */

require_once MAX_PATH . '/lib/max/Maintenance.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Statistics.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics.php';

/**
 * Definitions of class constants.
 */
define('DAL_STATISTICS_COMMON_UPDATE_OI',   0);
define('DAL_STATISTICS_COMMON_UPDATE_HOUR', 1);
define('DAL_STATISTICS_COMMON_UPDATE_BOTH', 2);

/**
 * Definition of the default connection window (different to the conversion
 * window, which is specific to individual trackers.)
 */
define('OA_DAL_MAINTENANCE_STATISTICS_CONNECTION_WINDOW_DAYS', 30);

/**
 * An abstract class that defines the interface and some common methods for the data
 * access layer code for summarising raw data into statistics, for all Max modules.
 *
 * @abstract
 */
class OA_Dal_Maintenance_Statistics_Common
{

    /**
     * Local copy of the MDB2_Driver_Common connection to the database.
     *
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    var $tables;
    var $tempTables;
    var $oDalMaintenanceStatistics;

    /**
     * A sting that can be used in SQL to cast a value into a date.
     *
     * For example, if the SQL DATE_FORMAT() function returns a result of
     * type text, this may need to be cast into the "date" type to be
     * inserted into a "date" column.
     *
     *  INSERT INTO
     *      table_name
     *      (
     *          date_column
     *      )
     *  VALUES
     *      (
     *          DATE_FORMAT('2007-04-11 13:49:18', '%Y-%m-%d'){$this->dateCastString}
     *      );
     *
     * @var string
     */
    var $dateCastString;

    /**
     * A sting that can be used in SQL to cast a value into an hour.
     *
     * For example, if the SQL DATE_FORMAT() function returns a result of
     * type text, this may need to be cast into the "hour" type to be
     * inserted into a "hour" column.
     *
     *  INSERT INTO
     *      table_name
     *      (
     *          hour_column
     *      )
     *  VALUES
     *      (
     *          DATE_FORMAT('2007-04-11 13:49:18', '%k'){$this->dayCastString}
     *      );
     *
     * @var string
     */
    var $hourCastSting;

    /**
     * The constructor method.
     *
     * @return OA_Dal_Maintenance_Statistics_Common
     */
    function OA_Dal_Maintenance_Statistics_Common()
    {
        $this->oDbh = &OA_DB::singleton();
        $this->tables = &OA_DB_Table_Core::singleton();
        $this->tempTables = &OA_DB_Table_Statistics::singleton();
        $this->oDalMaintenanceStatistics = new OA_Dal_Maintenance_Statistics();
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
    function getMaintenanceStatisticsLastRunInfo($type, $now = null)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        return false;
    }


    /**
     * A private function to do the job of implementations of
     * {@link OA_Dal_Maintenance_Statistics_Common::getMaintenanceStatisticsLastRunInfo()},
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
     * @param string $module One of "AdServer" or "Tracker".
     * @param string $rawTable The raw table to use in case of no previous run.
     * @param PEAR::Date $oNow An optional Date, used to specify the "current time", and
     *                         to limit the method to only look for past maintenance
     *                         statistics runs before this date. Normally only used
     *                         to assist with re-generation of statistics in the event
     *                         of faulty raw tables.
     * @return mixed A PEAR::Date representing the date up to which the statistics
     *               have been summarised, for the specified update type, or
     *               the appropriate date based on raw data if maintenance
     *               statistics has never been run for the Max module before.
     *               Returns null if no raw data is available.
     */
    function _getMaintenanceStatisticsLastRunInfo($type, $module, $rawTable, $oNow = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($module == 'AdServer') {
            $column = 'adserver_run_type';
        } elseif ($module == 'Tracker') {
            $column = 'tracker_run_type';
        } else {
            OA::debug('Invalid module type value ' . $module, PEAR_LOG_ERR);
            OA::debug('Aborting script execution', PEAR_LOG_ERR);
            exit();
        }
        if ($type == DAL_STATISTICS_COMMON_UPDATE_OI) {
            $whereClause = "WHERE ($column = " . DAL_STATISTICS_COMMON_UPDATE_OI .
                           " OR $column = " . DAL_STATISTICS_COMMON_UPDATE_BOTH. ')';
            $rawType = 'oi';
        } elseif ($type == DAL_STATISTICS_COMMON_UPDATE_HOUR) {
            $whereClause = "WHERE ($column = " . DAL_STATISTICS_COMMON_UPDATE_HOUR .
                           " OR $column = " . DAL_STATISTICS_COMMON_UPDATE_BOTH . ')';
           $rawType = 'hour';
        } elseif ($type == DAL_STATISTICS_COMMON_UPDATE_BOTH) {
            $whereClause = "WHERE ($column = " . DAL_STATISTICS_COMMON_UPDATE_BOTH . ')';
            $rawType = 'hour';
        } else {
            OA::debug('Invalid update type value ' . $type, PEAR_LOG_ERR);
            OA::debug('Aborting script execution', PEAR_LOG_ERR);
            exit();
        }
        if (!is_null($oNow)) {
            // Limit to past maintenance statistics runs before this Date
            $whereClause .= ' AND updated_to < ' . "'" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'";
        }
        $message = "Getting the details of when maintenance statistics last ran for the $module module " .
                   'on the basis of the ';
        if ($type == DAL_STATISTICS_COMMON_UPDATE_OI) {
            $message .= 'operation interval';
        } elseif ($type == DAL_STATISTICS_COMMON_UPDATE_HOUR) {
            $message .= 'hour';
        } elseif ($type == DAL_STATISTICS_COMMON_UPDATE_BOTH) {
            $message .= 'both the opertaion interval and hour';
        }
        OA::debug($message, PEAR_LOG_DEBUG);
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
            $error = "Error finding details on when maintenance statistics last ran for the $module module.";
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
     * A method for summarising impressions into a temporary table.
     *
     * @abstract
     * @param Date $start The start date/time to summarise from.
     * @param Date $end The end date/time to summarise to.
     * @return integer The number of conversion rows summarised.
     */
    function summariseImpressions($start, $end)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        return false;
    }

    /**
     * A method for summarising clicks into a temporary table.
     *
     * @abstract
     * @param Date $start The start date/time to summarise from.
     * @param Date $end The end date/time to summarise to.
     * @return integer The number of conversion rows summarised.
     */
    function summariseClicks($start, $end)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        return false;
    }

    /**
     * A private method to summarise request, impression or click data.
     *
     * @access private
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd   The end date/time to summarise to.
     * @param string     $type   Type of data to summarise.
     * @param boolean    $split  Optional flag, when true, tables are split.
     * @return integer The number of rows summarised.
     */
    function _summariseData($oStart, $oEnd, $type, $split = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (empty($type)) {
            return 0;
        }
        $type = strtolower($type);
        $tmpTableName = 'tmp_ad_' . $type;
        $countColumnName = $type . 's';
        // Check the start and end dates
        if (!MAX_OperationInterval::checkIntervalDates($oStart, $oEnd, $aConf['maintenance']['operationInterval'])) {
            return 0;
        }
        // Get the start and end dates of the operation interval ID
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStart);
        // How many days does the operation interval span, if using split tables?
        $days = 0;
        if ($split) {
            $days = Date_Calc::dateDiff($aDates['start']->getDay(),
                                        $aDates['start']->getMonth(),
                                        $aDates['start']->getYear(),
                                        $aDates['end']->getDay(),
                                        $aDates['end']->getMonth(),
                                        $aDates['end']->getYear());
        }
        // Get the operation interval ID
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        // Create temporary table to store the summarised data into
        $this->tempTables->createTable($tmpTableName);
        // Summarise the data
        $returnRows = 0;
        $oCurrentDate = new Date();
        $oCurrentDate->copy($aDates['start']);
        for ($counter = 0; $counter <= $days; $counter++) {
            // Set the appropriate raw data table table
            $baseTable = $aConf['table']['prefix'] .
                         $aConf['table']['data_raw_ad_' . $type];
            if ($split) {
                $baseTable .= '_' . $oCurrentDate->format('%Y%m%d');
            }
            // Summarise the data
            $query = "
                INSERT INTO
                    $tmpTableName
                    (
                        day,
                        hour,
                        operation_interval,
                        operation_interval_id,
                        interval_start,
                        interval_end,
                        ad_id,
                        creative_id,
                        zone_id,
                        $countColumnName
                    )
                SELECT
                    DATE_FORMAT(drad.date_time, '%Y-%m-%d'){$this->dateCastString} AS day,
                    DATE_FORMAT(drad.date_time, '%k'){$this->hourCastString} AS hour,
                    {$aConf['maintenance']['operationInterval']} AS operation_interval,
                    $operationIntervalID AS operation_interval_id,
                    '".$aDates['start']->format('%Y-%m-%d %H:%M:%S')."' AS interval_start,
                    '".$aDates['end']->format('%Y-%m-%d %H:%M:%S')."' AS interval_end,
                    drad.ad_id AS ad_id,
                    drad.creative_id AS creative_id,
                    drad.zone_id AS zone_id,
                    COUNT(*) AS $countColumnName
                FROM
                    $baseTable AS drad
                WHERE
                    drad.date_time >= '".$oStart->format('%Y-%m-%d %H:%M:%S')."'
                    AND drad.date_time <= '".$oEnd->format('%Y-%m-%d %H:%M:%S')."'
                GROUP BY
                    day, hour, ad_id, creative_id, zone_id";
            OA::debug("Summarising ad $type" . "s from the $baseTable table.", PEAR_LOG_DEBUG);
            OA::disableErrorHandling();
            $rows = $this->oDbh->exec($query);
            OA::enableErrorHandling();
            // Deal with the result from the SQL query
            if (PEAR::isError($rows)) {
                // Can the error be ignored?
                $ignore = true;
                if (!$split) {
                    // Not running in split mode, cannot ignore errors
                    $ignore = false;
                } else {
                    if (!PEAR::isError($rows, DB_ERROR_NOSUCHTABLE)) {
                        // Can't ignore the error in this case either
                        $ignore = false;
                    }
                }
                if (!$ignore) {
                    MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
            } else {
                // Query ran okay, count the rows
                $returnRows += $rows;
            }
            // Progress to the next day, so looping will work if needed
            $oCurrentDate = $oCurrentDate->getNextDay();
        }
        return $returnRows;
    }

    /**
     * A method for summarising connections into a temporary table.
     *
     * @abstract
     * @param Date $start The start date/time to summarise from.
     * @param Date $end The end date/time to summarise to.
     * @return integer The number of connections summarised.
     */
    function summariseConnections($start, $end)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        return false;
    }

    /**
     * A private method to summarise connections (based on impression
     * or click data) to a temporary table.
     *
     * @access private
     * @param PEAR::Date $oStart     The start date/time to summarise from.
     * @param PEAR::Date $oEnd       The end date/time to summarise to.
     * @param string     $action     Type of action to summarise. Either "impression", or "click".
     * @param integer    $connection Action The defined connection action integer that
     *                               matches the $action. Either MAX_CONNECTION_AD_IMPRESSION,
     *                               or MAX_CONNECTION_AD_CLICK.
     * @param boolean    $split      Optional flag, when true, tables are split.
     * @return integer The number of connection rows summarised.
     *
     * Note: The method tests to see if $GLOBALS['_MAX']['MSE']['COOKIELESS_CONVERSIONS']
     *       is set to true, and if so, performs cookieless conversion summarisation.
     */
    function _summariseConnections($oStart, $oEnd, $action, $connectionAction, $split = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // If the tracker module is not installed, don't summarise connections
        if (!$aConf['modules']['Tracker']) {
            return 0;
        }
        // Check the start and end dates
        if (!MAX_OperationInterval::checkIntervalDates($oStart, $oEnd, $aConf['maintenance']['operationInterval'])) {
            return 0;
        }
        // Get the start and end dates of the operation interval ID
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStart);
        // How many days does the operation interval span, if using split tables?
        $days = 0;
        if ($split) {
            $days = Date_Calc::dateDiff($aDates['start']->getDay(),
                                        $aDates['start']->getMonth(),
                                        $aDates['start']->getYear(),
                                        $aDates['end']->getDay(),
                                        $aDates['end']->getMonth(),
                                        $aDates['end']->getYear());
        }
        // Get the operation interval ID
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        // Ensure the temporary table for storing connections is created
        $this->tempTables->createTable('tmp_ad_connection');
        // Summarise the connections
        $returnRows = 0;
        $oCurrentDate = new Date();
        $oCurrentDate->copy($aDates['start']);
        for ($counter = 0; $counter <= $days; $counter++) {
            // Create the temporary table for these connection type
            if ($GLOBALS['_MAX']['MSE']['COOKIELESS_CONVERSIONS']) {
                // Create the cookieless conversion temporary table
                $tempTable = 'tmp_tracker_impression_ad_' . $action . '_connection_cookieless';
            } else {
                // Create the normal conversion temporary table
                $tempTable = 'tmp_tracker_impression_ad_' . $action . '_connection';
            }
            $this->tempTables->createTable($tempTable);
            // Prepare the window type name for the SQL - use
            // "viewwindow" for the impression action, otherwise
            // "clickwindow" for the click action.
            if ($action == 'impression') {
                $windowName = 'viewwindow';
            } else {
                $windowName = $action . 'window';
            }
            // Set the appropriate data_raw_tracker_impressions table
            $trackerImpressionTable = $aConf['table']['prefix'] .
                                      $aConf['table']['data_raw_tracker_impression'];
            if ($split) {
                $trackerImpressionTable .= '_' . $oCurrentDate->format('%Y%m%d');
            }
            // Prepare the SQL to insert tracker impressions that may result in
            // connections into the temporary table for this connection action type
            $query = "
                INSERT INTO
                    $tempTable
                    (
                        server_raw_tracker_impression_id,
                        server_raw_ip,
                        tracker_id,
                        campaign_id,
                        operation_interval,
                        operation_interval_id,
                        interval_start,
                        interval_end,";
            if ($GLOBALS['_MAX']['MSE']['COOKIELESS_CONVERSIONS']) {
                $query .= "
                        ip_address,
                        user_agent,";
            } else {
                $query .= "
                        viewer_id,";
            }
            $query .= "
                        date_time,
                        connection_action,
                        connection_window,
                        connection_status
                    )
                SELECT
                    drti.server_raw_tracker_impression_id AS server_raw_tracker_impression_id,
                    drti.server_raw_ip AS server_raw_ip,
                    drti.tracker_id AS tracker_id,
                    ct.campaignid AS campaign_id,
                    {$aConf['maintenance']['operationInterval']} AS operation_interval,
                    $operationIntervalID AS operation_interval_id,
                    '".$aDates['start']->format('%Y-%m-%d %H:%M:%S')."' AS interval_start,
                    '".$aDates['end']->format('%Y-%m-%d %H:%M:%S')."' AS interval_end,";
            if ($GLOBALS['_MAX']['MSE']['COOKIELESS_CONVERSIONS']) {
                $query .= "
                    drti.ip_address AS ip_address,
                    drti.user_agent AS user_agent,";
            } else {
                $query .= "
                    drti.viewer_id AS viewer_id,";
            }
            $query .= "
                    drti.date_time AS date_time,
                    '$connectionAction' AS connection_action,
                    ct.$windowName AS connection_window,
                    ct.status AS connection_status
                FROM
                    $trackerImpressionTable AS drti,
                    {$aConf['table']['prefix']}{$aConf['table']['campaigns_trackers']} AS ct
                WHERE
                    drti.tracker_id = ct.trackerid";
            if ($GLOBALS['_MAX']['MSE']['COOKIELESS_CONVERSIONS']) {
                $query .= "
                    AND
                    drti.ip_address != ''
                    AND
                    drti.user_agent != ''";
            } else {
                $query .= "
                    AND
                    drti.viewer_id != ''";
            }
            $query .= "
                    AND
                    drti.date_time >= '".$oStart->format('%Y-%m-%d %H:%M:%S')."'
                    AND
                    drti.date_time <= '".$oEnd->format('%Y-%m-%d %H:%M:%S') . "'";
            // Execute the SQL to insert tracker impressions that may result in
            // connections into the temporary table for this connection action type
            OA::debug('Selecting tracker impressions that may connect to ad ' .
                      $action . 's into the ' . $tempTable . ' temporary table.', PEAR_LOG_DEBUG);
            OA::disableErrorHandling();
            $trackerImpressionRows = $this->oDbh->exec($query);
            OA::enableErrorHandling();
            // Deal with the result from the SQL query
            if (PEAR::isError($trackerImpressionRows)) {
                // Can the error be ignored?
                $ignore = true;
                if (!$split) {
                    // Not running in split mode, cannot ignore errors
                    $ignore = false;
                } else {
                    if (!PEAR::isError($trackerImpressionRows, DB_ERROR_NOSUCHTABLE)) {
                        // Can't ignore the error in this case either
                        $ignore = false;
                    }
                }
                if (!$ignore) {
                    MAX::raiseError($trackerImpressionRows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
            } else {
                // Query ran okay
                OA::debug('Selected ' . $trackerImpressionRows . ' tracker impressions that may connect to ad ' .
                           $type . 's into the ' . $tempTable . ' temporary table.', PEAR_LOG_DEBUG);
                if ($trackerImpressionRows > 0) {
                    // Connect the tracker impressions with raw connection types, where possible,
                    // by looking over the necessary past raw tables, given the maximum connection
                    // window for this type
                    $connectionDays = 0;
                    $oCurrentConnectionDate = new Date();
                    $oCurrentConnectionDate->copy($oCurrentDate);
                    if ($split) {
                        $connectionDays = OA_DAL_MAINTENANCE_STATISTICS_CONNECTION_WINDOW_DAYS;
                        $oCurrentConnectionDate->subtractSeconds($connectionDays * SECONDS_PER_DAY);
                    }
                    for ($connectionCounter = 0; $connectionCounter <= $connectionDays; $connectionCounter++) {
                        // Set the appropriate data_raw_ad_* table
                        $adTable = $aConf['table']['prefix'] .
                                   $aConf['table']['data_raw_ad_' . $action];
                        if ($split) {
                            $adTable .= '_' . $oCurrentConnectionDate->format('%Y%m%d');
                        }
                        // Prepare the SQL to connect the tracker impressions with raw connection types
                        // (ie. raw ad impressions, or raw ad clicks, depending on $action), where possible
                        $query = "
                            INSERT INTO
                                tmp_ad_connection
                                (
                                    server_raw_tracker_impression_id,
                                    server_raw_ip,
                                    date_time,
                                    operation_interval,
                                    operation_interval_id,
                                    interval_start,
                                    interval_end,
                                    connection_viewer_id,
                                    connection_viewer_session_id,
                                    connection_date_time,
                                    connection_ad_id,
                                    connection_creative_id,
                                    connection_zone_id,
                                    connection_channel,
                                    connection_channel_ids,
                                    connection_language,
                                    connection_ip_address,
                                    connection_host_name,
                                    connection_country,
                                    connection_https,
                                    connection_domain,
                                    connection_page,
                                    connection_query,
                                    connection_referer,
                                    connection_search_term,
                                    connection_user_agent,
                                    connection_os,
                                    connection_browser,
                                    connection_action,
                                    connection_window,
                                    connection_status,
                                    inside_window
                                )
                            SELECT DISTINCT
                                tt.server_raw_tracker_impression_id AS server_raw_tracker_impression_id,
                                tt.server_raw_ip AS server_raw_ip,
                                tt.date_time AS date_time,
                                tt.operation_interval AS operation_interval,
                                tt.operation_interval_id AS operation_interval_id,
                                tt.interval_start AS interval_start,
                                tt.interval_end AS interval_end,
                                drad.viewer_id AS connection_viewer_id,
                                drad.viewer_session_id AS connection_viewer_session_id,
                                drad.date_time AS connection_date_time,
                                drad.ad_id AS connection_ad_id,
                                drad.creative_id AS connection_creative_id,
                                drad.zone_id AS connection_zone_id,
                                drad.channel AS connection_channel,
                                drad.channel_ids AS connection_channel_ids,
                                drad.language AS connection_language,
                                drad.ip_address AS connection_ip_address,
                                drad.host_name AS connection_host_name,
                                drad.country AS connection_country,
                                drad.https AS connection_https,
                                drad.domain AS connection_domain,
                                drad.page AS connection_page,
                                drad.query AS connection_query,
                                drad.referer AS connection_referer,
                                drad.search_term AS connection_search_term,
                                drad.user_agent AS connection_user_agent,
                                drad.os AS connection_os,
                                drad.browser AS connection_browser,
                                tt.connection_action AS connection_action,
                                tt.connection_window AS connection_window,
                                tt.connection_status AS connection_status,
                                IF(tt.date_time < DATE_ADD(drad.date_time, INTERVAL tt.connection_window SECOND), 1, 0) AS inside_window
                            FROM
                                $tempTable AS tt,
                                $adTable AS drad,
                                {$aConf['table']['prefix']}{$aConf['table']['banners']} AS b,
                                {$aConf['table']['prefix']}{$aConf['table']['campaigns_trackers']} AS ct
                            WHERE";
                            if ($GLOBALS['_MAX']['MSE']['COOKIELESS_CONVERSIONS']) {
                                $query .= "
                                tt.ip_address = drad.ip_address
                                AND
                                tt.user_agent = drad.user_agent";
                            } else {
                                $query .= "
                                tt.viewer_id = drad.viewer_id";
                            }
                            $query .= "
                                AND
                                drad.ad_id = b.bannerid
                                AND
                                b.campaignid = ct.campaignid
                                AND
                                ct.trackerid = tt.tracker_id
                                AND
                                tt.campaign_id = ct.campaignid
                                AND
                                tt.date_time < DATE_ADD(drad.date_time, INTERVAL " . OA_DAL_MAINTENANCE_STATISTICS_CONNECTION_WINDOW_DAYS . " DAY)
                                AND
                                tt.date_time >= drad.date_time";
                        OA::debug('Connecting tracker impressions with ad ' . $action . 's, where possible.', PEAR_LOG_DEBUG);
                        OA::disableErrorHandling();
                        $rows = $this->oDbh->exec($query);
                        OA::enableErrorHandling();
                        // Deal with the result from the SQL query
                        if (PEAR::isError($rows)) {
                            // Can the error be ignored?
                            $ignore = true;
                            if (!$split) {
                                // Not running in split mode, cannot ignore errors
                                $ignore = false;
                            } else {
                                if (!PEAR::isError($rows, DB_ERROR_NOSUCHTABLE)) {
                                    // Can't ignore the error in this case either
                                    $ignore = false;
                                }
                            }
                            if (!$ignore) {
                                MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                            }
                        } else {
                            // Query ran okay
                            $returnRows += $rows;
                        }
                        // Progress to the next day, so looping will work if needed
                        $oCurrentConnectionDate = $oCurrentConnectionDate->getNextDay();
                    }
                }
            }
            // Drop the temporary table
            $this->tempTables->dropTable($tempTable);
            // Progress to the next day, so looping will work if needed
            $oCurrentDate = $oCurrentDate->getNextDay();
        }
        // Return the summarised connection rows
        return $returnRows;
    }

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
    function saveIntermediate($oStart, $oEnd, $aTypes, $intermediateTable, $saveConnections = true)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        return false;
    }

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
    function saveSummary($oStartDate, $oEndDate, $aTypes, $fromTable, $toTable)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        return false;
    }

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
    function deleteOldData($summarisedTo)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        return false;
    }

}

?>
