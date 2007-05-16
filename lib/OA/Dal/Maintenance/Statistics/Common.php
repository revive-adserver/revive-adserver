<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/OA/Email.php';

/**
 * Definitions of class constants.
 */
define('OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI',   0);
define('OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR', 1);
define('OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH', 2);

/**
 * Definition of the default connection window (different to the conversion
 * window, which is specific to individual trackers.)
 */
define('OA_DAL_MAINTENANCE_STATISTICS_CONNECTION_WINDOW_DAYS', 30);

/**
 * An class that defines a number of abstract methods to define an interface for all drivers
 * that summarising raw data into statistics.
 *
 * Also provides some common private methods for children classes.
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
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI if the update was
     *                      done on the basis of the operation interval,
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR if the update
     *                      was done on the basis of the hour, or
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH if the update
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
     *              statistics has never been run for the Openads module before.
     *              Returns null if no raw data is available.
     */
    function getMaintenanceStatisticsLastRunInfo($type, $now = null)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
    }


    /**
     * A private function to do the job of implementations of
     * {@link OA_Dal_Maintenance_Statistics_Common::getMaintenanceStatisticsLastRunInfo()},
     * but with an extra parameter to specify the raw table to look in, in
     * the case of maintenance statistics not having been run before.
     *
     * @access private
     * @param integer $type The update type that occurred - that is,
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI if the update was
     *                      done on the basis of the operation interval,
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR if the update
     *                      was done on the basis of the hour, or
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH if the update
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
     *               statistics has never been run for the Openads module before.
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
        if ($type == OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI) {
            $whereClause = "WHERE ($column = " . OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI .
                           " OR $column = " . OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH. ')';
            $rawType = 'oi';
        } elseif ($type == OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR) {
            $whereClause = "WHERE ($column = " . OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR .
                           " OR $column = " . OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH . ')';
           $rawType = 'hour';
        } elseif ($type == OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH) {
            $whereClause = "WHERE ($column = " . OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH . ')';
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
        if ($type == OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI) {
            $message .= 'operation interval';
        } elseif ($type == OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR) {
            $message .= 'hour';
        } elseif ($type == OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH) {
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
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd   The end date/time to summarise to.
     * @return integer The number of conversion rows summarised.
     */
    function summariseImpressions($oStart, $oEnd)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
    }

    /**
     * A method for summarising clicks into a temporary table.
     *
     * @abstract
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd   The end date/time to summarise to.
     * @return integer The number of conversion rows summarised.
     */
    function summariseClicks($oStart, $oEnd)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
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
                    ". $this->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ." AS interval_start,
                    ". $this->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ." AS interval_end,
                    drad.ad_id AS ad_id,
                    drad.creative_id AS creative_id,
                    drad.zone_id AS zone_id,
                    COUNT(*) AS $countColumnName
                FROM
                    $baseTable AS drad
                WHERE
                    drad.date_time >= ". $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                    AND drad.date_time <= ". $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
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
     * @param PEAR::Date $oStart The start date/time to summarise from.
     * @param PEAR::Date $oEnd   The end date/time to summarise to.
     * @return integer The number of connections summarised.
     */
    function summariseConnections($oStart, $oEnd)
    {
        $rows = 0;
        // Summarise connections based on ad impressions
        $rows += $this->_summariseConnections($oStart, $oEnd, 'impression', MAX_CONNECTION_AD_IMPRESSION);
        // Summarise connections based on ad clicks
        $rows += $this->_summariseConnections($oStart, $oEnd, 'click', MAX_CONNECTION_AD_CLICK);
        // Return the total summarised connections
        return $rows;
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
                    ". $this->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ." AS interval_start,
                    ". $this->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ." AS interval_end,";
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
                    drti.date_time >= ". $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp')."
                    AND
                    drti.date_time <= ". $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
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
                                IF(tt.date_time < DATE_ADD(drad.date_time, " . OA_Dal::quoteInterval('tt.connection_window', 'SECOND') . "), 1, 0) AS inside_window
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
                                tt.date_time < DATE_ADD(drad.date_time, " . OA_Dal::quoteInterval(OA_DAL_MAINTENANCE_STATISTICS_CONNECTION_WINDOW_DAYS, 'DAY') . ")
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
        $this->_saveIntermediate($oStart, $oEnd, $aActions, $intermediateTable, $saveConnections);
    }

    /**
     * A private method do the work of the saveIntermediate() method.
     *
     * @access private
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
    function _saveIntermediate($oStart, $oEnd, $aActions, $intermediateTable = 'data_intermediate_ad', $saveConnections = true, $split = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Check the start and end dates
        if (!MAX_OperationInterval::checkIntervalDates($oStart, $oEnd, $aConf['maintenance']['operationInterval'])) {
            return 0;
        }
        // Check that there are types to summarise
        if (empty($aActions['types']) || empty($aActions['connections'])) {
            return 0;
        }
        // Get the start and end dates of the operation interval ID
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStart);
        // Get the operation interval ID
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        // Save connections to the intermediate tables, unless set not
        // to do so (and unless the tracker module is not installed)
        if ($saveConnections && $aConf['modules']['Tracker']) {
            // Mark which connections are "latest"
            $connectionRows = $this->_saveIntermediateMarkLatestConnections($oStart, $oEnd);
            if ($connectionRows > 0) {
                // Save the "latest" connections and the associated variable values
                $this->_saveIntermediateSaveConnectionsAndVariableValues($oStart, $oEnd, $split);
            }
            // Drop the tmp_ad_connection table
            $this->tempTables->dropTable('tmp_ad_connection');
        }
        // If the tracker module is installed, there may be connections that need
        // to be put into the main intermediate table, regardless of if the value
        // of $saveConnections is true or not - put the appropriate connections
        // (i.e. that are conversions AND that have one of the connection types
        // passed in) into the tmp_conversions table
        if ($aConf['modules']['Tracker']) {
            $this->_saveIntermediateSummariseConversions($oStart, $oEnd, $aActions);
        }
        // Create a temporary union table (tmp_union) of the required data types
        $query = $this->_saveIntermediateCreateUnionGetSql($aActions);
        $aQueries = array();
        foreach ($aActions['types'] as $type) {
            $innerQuery = "
                SELECT
                    tmp_ad_{$type}.day AS day,
                    tmp_ad_{$type}.hour AS hour,
                    tmp_ad_{$type}.operation_interval AS operation_interval,
                    tmp_ad_{$type}.operation_interval_id AS operation_interval_id,
                    tmp_ad_{$type}.interval_start AS interval_start,
                    tmp_ad_{$type}.interval_end AS interval_end,
                    tmp_ad_{$type}.ad_id AS ad_id,
                    tmp_ad_{$type}.creative_id AS creative_id,
                    tmp_ad_{$type}.zone_id AS zone_id,";
            foreach ($aActions['types'] as $innerType) {
                if ($innerType == $type) {
                    $innerQuery .= "
                    tmp_ad_{$type}.{$type}s AS {$type}s,";
                } else {
                    $innerQuery .= "
                    0 AS {$innerType}s,";
                }
            }
            $innerQuery .= "
                    0 AS conversions,
                    0 AS total_basket_value,
                    0 AS total_num_items
                FROM
                    tmp_ad_{$type}";
            $aQueries[] = $innerQuery;
        }
        $query .= implode("
                UNION ALL", $aQueries);
        if ($aConf['modules']['Tracker']) {
            $query .= "
                UNION ALL
                SELECT
                    tmp_conversions.day AS day,
                    tmp_conversions.hour AS hour,
                    tmp_conversions.operation_interval AS operation_interval,
                    tmp_conversions.operation_interval_id AS operation_interval_id,
                    tmp_conversions.interval_start AS interval_start,
                    tmp_conversions.interval_end AS interval_end,
                    tmp_conversions.ad_id AS ad_id,
                    tmp_conversions.creative_id AS creative_id,
                    tmp_conversions.zone_id AS zone_id,";
            foreach ($aActions['types'] as $type) {
                $query .= "
                    0 AS {$type}s,";
            }
            $query .= "
                    COUNT(*) AS conversions,
                    SUM(tmp_conversions.basket_value) AS total_basket_value,
                    SUM(tmp_conversions.num_items) AS total_num_items
                FROM
                    tmp_conversions";
        $query .= "
                GROUP BY
                    day,
                    hour,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    creative_id,
                    zone_id";
        }
        // Prepare the message about what's about to happen
        $message = 'Creating a union of the ad ' . implode('s, ', $aActions['types']) . 's';
        if ($aConf['modules']['Tracker']) {
            $message .= ' and conversions';
        }
        $message .= '.';
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        // Drop the temporary tables now that the data is summarised
        foreach ($aActions['types'] as $type) {
            $this->tempTables->dropTable("tmp_ad_{$type}");
        }
        if ($aConf['modules']['Tracker']) {
            // Drop the tmp_conversions table
            $this->tempTables->dropTable('tmp_conversions');
        }
        // Summarise the data in temporary union table (tmp_union) into the
        // main (data_intermediate_ad) table, to finally finish the job! ;-)
        $table = $aConf['table']['prefix'] .
                 $aConf['table'][$intermediateTable];
        // See if any rows were inserted into the tmp_union table
        $query = "SELECT COUNT(*) AS count FROM tmp_union";
        $aRows = $this->oDbh->queryRow($query);
        if ($aRows['count'] > 0) {
            $query = "
                INSERT INTO
                    $table
                    (
                        day,
                        hour,
                        operation_interval,
                        operation_interval_id,
                        interval_start,
                        interval_end,
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
                    tu.day AS day,
                    tu.hour AS hour,
                    tu.operation_interval AS operation_interval,
                    tu.operation_interval_id AS operation_interval_id,
                    tu.interval_start AS interval_start,
                    tu.interval_end AS interval_end,
                    tu.ad_id AS ad_id,
                    tu.creative_id AS creative_id,
                    tu.zone_id AS zone_id,";
            foreach ($aActions['types'] as $type) {
                $query .= "
                    SUM(tu.{$type}s) AS {$type}s,";
            }
            $query .= "
                    SUM(tu.conversions) AS conversions,
                    IFNULL(SUM(tu.total_basket_value), 0) AS total_basket_value,
                    IFNULL(SUM(tu.total_num_items), 0) AS total_num_items,
                    '".OA::getNow()."' AS updated
                FROM
                    tmp_union AS tu
                GROUP BY
                    day,
                    hour,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    creative_id,
                    zone_id";
            // Prepare the message about what's about to happen
            $message = 'Inserting the ad ' . implode('s, ', $aActions['types']) . 's';
            if ($aConf['modules']['Tracker']) {
                $message .= ' and conversions';
            }
            $message .= " into the $table table.";
            OA::debug($message, PEAR_LOG_DEBUG);
            $rows = $this->oDbh->exec($query);
            if (PEAR::isError($rows)) {
                return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }
        } else {
            $message = 'No ad ' . implode('s, ', $aActions['types']) . 's';
            if ($aConf['modules']['Tracker']) {
                $message .= ' or conversions';
            }
            $message .= " found to insert into the $table table.";
            OA::debug($message, PEAR_LOG_DEBUG);
        }
        // Drop the tmp_union table
        $this->tempTables->dropTable('tmp_union');
    }

    /**
     * A private method to mark those connections in the tmp_ad_connection
     * temporary table that are the "latest" connections, in the even that
     * there are duplicate connections per tracker impression.
     *
     * @abstract
     * @access private
     * @param PEAR::Date $oStart The start date/time to mark from.
     * @param PEAR::Date $oEnd   The end date/time to mark to.
     * @return integer Returns the number of connections marked as "latest"
     *                 in the tmp_ad_connection table.
     */
    function _saveIntermediateMarkLatestConnections($oStart, $oEnd)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
    }

    /**
     * A private method to summarise those connections that are conversions
     * AND which match a set of given connection types into the
     * tmp_conversions temporary table.
     *
     * @access private
     * @param PEAR::Date $oStart The start date/time to extract from.
     * @param PEAR::Date $oEnd The end date/time to extract to.
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
     */
    function _saveIntermediateSummariseConversions($oStart, $oEnd, $aActions)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Check the start and end dates
        if (!MAX_OperationInterval::checkIntervalDates($oStart, $oEnd, $aConf['maintenance']['operationInterval'])) {
            return 0;
        }
        // Get the start and end dates of the operation interval ID
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStart);
        // Get the operation interval ID
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        // Create the tmp_conversions table
        $this->tempTables->createTable('tmp_conversions');
        // Prepare the connection types that need to be used
        if (empty($aActions['connections'])) {
            // There are no connection types, so can't summarise any
            // conversions, obviously...
            return;
        }
        $connectionActions = '(' . $this->oDbh->escape(implode(', ', $aActions['connections'])) . ')';
        // Select conversions with both basket value and items number or none of them
        $query = "
            INSERT INTO
                tmp_conversions
                (
                    data_intermediate_ad_connection_id,
                    day,
                    hour,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    creative_id,
                    zone_id,
                    basket_value,
                    num_items
                )
            SELECT
                diac.data_intermediate_ad_connection_id AS data_intermediate_ad_connection_id,
                DATE_FORMAT(diac.tracker_date_time, '%Y-%m-%d'){$this->dateCastString} AS day,
                DATE_FORMAT(diac.tracker_date_time, '%k'){$this->hourCastString} AS hour,
                {$aConf['maintenance']['operationInterval']} AS operation_interval,
                $operationIntervalID AS operation_interval_id,
                ". $this->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ." AS interval_start,
                ". $this->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ." AS interval_end,
                diac.ad_id AS ad_id,
                diac.creative_id AS creative_id,
                diac.zone_id AS zone_id,
                SUM(IF(v.purpose = 'basket_value' AND diac.connection_status = ". MAX_CONNECTION_STATUS_APPROVED .", diavv.value, 0)) AS basket_value,
                SUM(IF(v.purpose = 'num_items' AND diac.connection_status = ". MAX_CONNECTION_STATUS_APPROVED .", diavv.value, 0)) AS num_items
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']} AS diac
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_variable_value']} AS diavv
            USING
                (
                    data_intermediate_ad_connection_id
                )
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['variables']} AS v
            ON
                (
                    diavv.tracker_variable_id = v.variableid
                    AND v.purpose IN ('basket_value', 'num_items')
                )
            WHERE
                diac.connection_status = ". MAX_CONNECTION_STATUS_APPROVED ."
                AND diac.connection_action IN $connectionActions
                AND diac.inside_window = 1
                AND diac.tracker_date_time >= ". $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND diac.tracker_date_time <= ". $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
            GROUP BY
                diac.data_intermediate_ad_connection_id,
                day,
                hour,
                ad_id,
                creative_id,
                zone_id";
        OA::debug('Selecting all conversions.', PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
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
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
    }

    /**
     * A private method to save the tacker impression/ad impression and
     * tracker impression/ad click connections that have been marked as
     * "latest", and also save the associated tracker impression
     * variable values.
     *
     * @access private
     * @param PEAR::Date $oStart The start date/time to save from.
     * @param PEAR::Date $oEnd The end date/time to save to.
     * @param boolean    $split  Optional flag, when true, tables are split.
     */
    function _saveIntermediateSaveConnectionsAndVariableValues($oStart, $oEnd, $split = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // How many days does the operation interval span, if using split tables?
        $days = 0;
        if ($split) {
            $days = Date_Calc::dateDiff(
                $oStart->getDay(),
                $oStart->getMonth(),
                $oStart->getYear(),
                $oEnd->getDay(),
                $oEnd->getMonth(),
                $oEnd->getYear()
            );
        }
        // Summarise the data
        $outerTable = $aConf['table']['prefix'] .
                      $aConf['table']['data_intermediate_ad_connection'];
        $innerTable = $aConf['table']['prefix'] .
                      $aConf['table']['data_intermediate_ad_variable_value'];
        $oOuterDate = new Date();
        $oOuterDate->copy($oStart);
        for ($counter = 0; $counter <= $days; $counter++) {
            // Set the appropriate data_raw_tracker_impression table
            // Set the appropriate data_raw_tracker_impression table
            $trackerImpressionTable = $aConf['table']['prefix'] .
                                      $aConf['table']['data_raw_tracker_impression'];
            if ($split) {
                $trackerImpressionTable .= '_' . $oOuterDate->format('%Y%m%d');
            }
            // Save the connections to the data_intermediate_ad_connection table
            $query = "
                INSERT INTO
                    $outerTable
                    (
                        server_raw_tracker_impression_id,
                        server_raw_ip,
                        viewer_id,
                        viewer_session_id,
                        tracker_date_time,
                        connection_date_time,
                        tracker_id,
                        ad_id,
                        creative_id,
                        zone_id,
                        tracker_channel,
                        connection_channel,
                        tracker_channel_ids,
                        connection_channel_ids,
                        tracker_language,
                        connection_language,
                        tracker_ip_address,
                        connection_ip_address,
                        tracker_host_name,
                        connection_host_name,
                        tracker_country,
                        connection_country,
                        tracker_https,
                        connection_https,
                        tracker_domain,
                        connection_domain,
                        tracker_page,
                        connection_page,
                        tracker_query,
                        connection_query,
                        tracker_referer,
                        connection_referer,
                        tracker_search_term,
                        connection_search_term,
                        tracker_user_agent,
                        connection_user_agent,
                        tracker_os,
                        connection_os,
                        tracker_browser,
                        connection_browser,
                        connection_action,
                        connection_window,
                        connection_status,
                        inside_window,
                        updated
                    )
                SELECT
                    drti.server_raw_tracker_impression_id AS server_raw_tracker_impression_id,
                    drti.server_raw_ip AS server_raw_ip,
                    drti.viewer_id AS viewer_id,
                    drti.viewer_session_id AS viewer_session_id,
                    drti.date_time AS tracker_date_time,
                    tac.connection_date_time AS connection_date_time,
                    drti.tracker_id AS tracker_id,
                    tac.connection_ad_id AS ad_id,
                    tac.connection_creative_id AS creative_id,
                    tac.connection_zone_id AS zone_id,
                    drti.channel AS tracker_channel,
                    tac.connection_channel AS connection_channel,
                    drti.channel_ids AS tracker_channel_ids,
                    tac.connection_channel_ids AS connection_channel_ids,
                    drti.language AS tracker_language,
                    tac.connection_language AS connection_language,
                    drti.ip_address AS tracker_ip_address,
                    tac.connection_ip_address AS connection_ip_address,
                    drti.host_name AS tracker_host_name,
                    tac.connection_host_name AS connection_host_name,
                    drti.country AS tracker_country,
                    tac.connection_country AS connection_country,
                    drti.https AS tracker_https,
                    tac.connection_https AS connection_https,
                    drti.domain AS tracker_domain,
                    tac.connection_domain AS connection_domain,
                    drti.page AS tracker_page,
                    tac.connection_page AS connection_page,
                    drti.query AS tracker_query,
                    tac.connection_query AS connection_query,
                    drti.referer AS tracker_referer,
                    tac.connection_referer AS connection_referer,
                    drti.search_term AS tracker_search_term,
                    tac.connection_search_term AS connection_search_term,
                    drti.user_agent AS tracker_user_agent,
                    tac.connection_user_agent AS connection_user_agent,
                    drti.os AS tracker_os,
                    tac.connection_os AS connection_os,
                    drti.browser AS tracker_browser,
                    tac.connection_browser AS connection_browser,
                    tac.connection_action AS connection_action,
                    tac.connection_window AS connection_window,
                    tac.connection_status AS connection_status,
                    tac.inside_window AS inside_window,
                    '".OA::getNow()."'
                FROM
                    tmp_ad_connection AS tac,
                    $trackerImpressionTable AS drti
                WHERE
                    tac.server_raw_tracker_impression_id = drti.server_raw_tracker_impression_id
                    AND
                    tac.server_raw_ip = drti.server_raw_ip
                    AND
                    tac.latest = 1";
            OA::debug("Inserting the connections into the $outerTable table", PEAR_LOG_DEBUG);
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
            }
            // Save the variable values to the data_intermediate_ad_variable_value table
            $oInnerDate = new Date();
            $oInnerDate->copy($oOuterDate);
            $upperBound = 0;
            if ($split) {
                // Need to also check tomorrow's variable values table,
                // in case the tracker impression happend just on midnight...
                $upperBound = 1;
            }
            for ($innerCounter = 0; $innerCounter <= $upperBound; $innerCounter++) {
                // Set the appropriate data_raw_tracker_variable_value table
                $trackerVariableValueTable = $aConf['table']['prefix'] .
                                             $aConf['table']['data_raw_tracker_variable_value'];
                if ($split) {
                    $trackerVariableValueTable .=  '_' . $oInnerDate->format('%Y%m%d');
                }
                $query = "
                    INSERT INTO
                        $innerTable
                        (
                            data_intermediate_ad_connection_id,
                            tracker_variable_id,
                            value
                        )
                    SELECT
                        diac.data_intermediate_ad_connection_id AS data_intermediate_ad_connection_id,
                        drtvv.tracker_variable_id AS tracker_variable_id,
                        drtvv.value AS value
                    FROM
                        {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']} AS diac,
                        $trackerVariableValueTable AS drtvv,
                        $trackerImpressionTable AS drti
                    WHERE
                        diac.server_raw_tracker_impression_id = drti.server_raw_tracker_impression_id
                        AND
                        diac.server_raw_ip = drti.server_raw_ip
                        AND
                        drti.server_raw_tracker_impression_id = drtvv.server_raw_tracker_impression_id
                        AND
                        drti.server_raw_ip = drtvv.server_raw_ip
                        AND
                        diac.tracker_date_time >= " . $oStart->format('%Y-%m-%d %H:%M:%S') . "
                        AND
                        diac.tracker_date_time <= " . $oEnd->format('%Y-%m-%d %H:%M:%S');
                OA::debug("Saving the tracker impression variable values from the $innerTable table", PEAR_LOG_DEBUG);
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
                }
                // Update the split data_raw_tracker_variable_value table being used
                $oInnerDate = $oInnerDate->getNextDay();
            }
            // Update the split data_raw_tracker_impression table being used
            $oOuterDate = $oOuterDate->getNextDay();
        }
        // Reject connections with empty required variables
        $this->_saveIntermediateRejectEmptyVarConversions($oStart, $oEnd);
        // Remove from diac all duplicates
        $this->_saveIntermediateDeduplicateConversions($oStart, $oEnd);
    }

    /**
     * A private method to reject conversions which have empty required variables.
     * The method check connections from last interval (between $start and $end) and
     * marks as disapproved those  them
     * between those dates.
     *
     * @abstract
     * @param PEAR::Date $oStart The start date/time of current interval
     * @param PEAR::Date $oEnd   The end date/time of current interval
     */
    function _saveIntermediateRejectEmptyVarConversions($oStart, $oEnd)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
    }

    /**
     * A private method to dedup conversions which have associated unique variables.
     * The method check connections from last interval (between $start and $end) and dedup them
     * between those dates.
     *
     * @abstract
     * @access private
     * @param PEAR::Date $oStart The start date/time of current interval.
     * @param PEAR::Date $oEnd   The end date/time of current interval.
     */
    function _saveIntermediateDeduplicateConversions($oStart, $oEnd)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
    }

    /**
     * A method to update the zone impression history table from the intermediate tables.
     *
     * @param PEAR::Date $oStart The start date/time to update from.
     * @param PEAR::Date $oEnd   The end date/time to update to.
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
                interval_start >= ". $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                AND interval_end <= ". $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
            GROUP BY
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
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
     * @param PEAR::Date $oEndDate   The end date/time to update to.
     * @param array $aActions        An array of data types to summarise. Contains
     *                               two array, the first containing the data types,
     *                               and the second containing the connection type
     *                               values associated with those data types, if
     *                               appropriate. For example:
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
     *                               Note that the order of the items must match
     *                               the order of the items in the database tables
     *                               (e.g. in data_intermediate_ad and
     *                               data_summary_ad_hourly for the above example).
     * @param string $fromTable      The name of the intermediate table to summarise
     *                               from (e.g. 'data_intermediate_ad').
     * @param string $toTable        The name of the summary table to summarise to
     *                               (e.g. 'data_summary_ad_hourly').
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
     * @access private
     * @param PEAR::Date $oStartDate The start date/time to update from.
     * @param PEAR::Date $oEndDate   The end date/time to update to.
     * @param array $aActions        An array of action types to summarise. Contains
     *                               two array, the first containing the data types,
     *                               and the second containing the connection type
     *                               values associated with those data types, if
     *                               appropriate. For example:
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
     *                             Note that the order of the items must match
     *                             the order of the items in the database tables
     *                             (e.g. in data_intermediate_ad and
     *                             data_summary_ad_hourly for the above example).
     * @param string $fromTable    The name of the intermediate table to summarise
     *                             from (e.g. 'data_intermediate_ad').
     * @param string $toTable      The name of the summary table to summarise to
     *                             (e.g. 'data_summary_ad_hourly').
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
                day = ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d'), 'date')."
                AND hour >= ". $this->oDbh->escape($oStartDate->format('%H'))."
                AND hour <= ". $this->oDbh->escape($oEndDate->format('%H'))."
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
        $this->_saveSummaryUpdateWithFinanceInfo($oStartDate, $oEndDate, $toTable);
    }

    /**
     * A method to set basic financial information in a summary table,
     * on the basis of placement and zone financial information.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of records that need updating.
     * @param PEAR::Date $oEndDate   The end date of records that need updating.
     * @param string $table          The name of the summary table to update with financial
     *                               information (e.g. 'data_summary_ad_hourly').
     */
    function _saveSummaryUpdateWithFinanceInfo($oStartDate, $oEndDate, $table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
            MAX::raiseError('_saveSummaryUpdateWithFinanceInfo called with dates not on the same day.', null, PEAR_ERROR_DIE);
        }
        // Obtain a list of unique ad IDs from the summary table
        $query = "
            SELECT DISTINCT
                ad_id AS ad_id
            FROM
                {$aConf['table']['prefix']}{$aConf['table'][$table]}
            WHERE
                day = ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d'), 'date') ."
                AND hour >= ". $this->oDbh->escape($oStartDate->format('%H')) ."
                AND hour <= ". $this->oDbh->escape($oEndDate->format('%H'));
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $aAdIds = array();
        while ($aRow = $rc->fetchRow()) {
            $aAdIds[] = $aRow['ad_id'];
        }
        // Get the finance information for the ads found
        $aAdFinanceInfo = $this->_saveSummaryGetAdFinanceInfo($aAdIds);
        // Update the recently summarised data with basic financial information
        if ($aAdFinanceInfo !== false) {
            $this->_saveSummaryUpdateAdsWithFinanceInfo($aAdFinanceInfo, $oStartDate, $oEndDate, $table);
        }
        // Obtain the list of unique zone IDs from the summary table
        $query = "
            SELECT DISTINCT
                zone_id AS zone_id
            FROM
                {$aConf['table']['prefix']}{$aConf['table'][$table]}
            WHERE
                day = ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d'), 'date') ."
                AND hour >= ". $this->oDbh->escape($oStartDate->format('%H')) ."
                AND hour <= ". $this->oDbh->escape($oEndDate->format('%H'));
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $aZoneIds = array();
        while ($aRow = $rc->fetchRow()) {
            $aZoneIds[] = $aRow['zone_id'];
        }
        // Get the finance information for the zones found
        $aZoneFinanceInfo = $this->_saveSummaryGetZoneFinanceInfo($aZoneIds);
        // Update the recently summarised data with basic financial information
        if ($aZoneFinanceInfo !== false) {
            $this->_saveSummaryUpdateZonesWithFinanceInfo($aZoneFinanceInfo, $oStartDate, $oEndDate, $table);
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
    function _saveSummaryGetAdFinanceInfo($aAdIds)
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
                a.bannerid IN (" . $this->oDbh->escape(implode(', ', $aAdIds)) . ")
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
     * A method to set the basic financial information in a summary table,
     * on the basis of given ad financial information.
     *
     * @access private
     * @param array $aAdFinanceInfo  An array of arrays, each with the ad_id, revenue and
     *                               revenue_type information for the ads that need updating.
     * @param PEAR::Date $oStartDate The start date of records that need updating.
     * @param PEAR::Date $oEndDate   The end date of records that need updating.
     * @param string $table          The name of the summary table to update with financial
     *                               information (e.g. 'data_summary_ad_hourly').
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
    function _saveSummaryUpdateAdsWithFinanceInfo($aAdFinanceInfo, $oStartDate, $oEndDate, $table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%H') != 0 || $oEndDate->format('%H') != 23) {
            if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
                MAX::raiseError('_saveSummaryUpdateAdsWithFinanceInfo called with dates not on the same day.', null, PEAR_ERROR_DIE);
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
                                total_revenue = {$aAdFinanceMappings[MAX_FINANCE_CPM]} * {$aInfo['revenue']} / 1000,
                                updated = '". OA::getNow() ."'
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND day >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d'), 'date') ."
                                AND day <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d'), 'date') ."
                                AND hour >= ". $this->oDbh->escape($oStartDate->format('%H')) ."
                                AND hour <= ". $this->oDbh->escape($oEndDate->format('%H'));
                        break;
                    case MAX_FINANCE_CPC:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_revenue = {$aAdFinanceMappings[MAX_FINANCE_CPC]} * {$aInfo['revenue']},
                                updated = '". OA::getNow() ."'
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND day >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d'), 'date') ."
                                AND day <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d'), 'date') ."
                                AND hour >= ". $this->oDbh->escape($oStartDate->format('%H'))."
                                AND hour <= ". $this->oDbh->escape($oEndDate->format('%H'));
                        break;
                    case MAX_FINANCE_CPA:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_revenue = {$aAdFinanceMappings[MAX_FINANCE_CPA]} * {$aInfo['revenue']},
                                updated = '". OA::getNow() ."'
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND day >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d'), 'date') ."
                                AND day <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d'), 'date') ."
                                AND hour >= ". $this->oDbh->escape($oStartDate->format('%H')) ."
                                AND hour <= ". $this->oDbh->escape($oEndDate->format('%H'));
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
     * A method to obtain the finance information for a given set of zone IDs.
     *
     * @access private
     * @param array $aZoneIds An array of zone IDs for which the finance information is needed.
     * @return mixed An array of arrays, each containing the zone_id, cost and cost_type
     *               of those zones required, where the financial information exists; or
     *               false if there none of the zones requested have finance information set.
     */
    function _saveSummaryGetZoneFinanceInfo($aZoneIds)
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
                z.zoneid IN (" . $this->oDbh->escape(implode(', ', $aZoneIds)) . ")
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
     * A method to set the basic financial information in a summay table,
     * on the basis of given zone financial information.
     *
     * @access private
     * @param array $aZoneFinanceInfo An array of arrays, each with the zone_id, cost and
     *                                cost_type information for the zones that need updating.
     * @param PEAR::Date $oStartDate  The start date of records that need updating.
     * @param PEAR::Date $oEndDate    The end date of records that need updating.
     * @param string $table           The name of the summary table to update with financial
     *                                information (e.g. 'data_summary_ad_hourly').
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
    function _saveSummaryUpdateZonesWithFinanceInfo($aZoneFinanceInfo, $oStartDate, $oEndDate, $table, $aLimitToTypes = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%H') != 0 || $oEndDate->format('%H') != 23) {
            if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
                MAX::raiseError('_saveSummaryUpdateZonesWithFinanceInfo called with dates not on the same day.', null, PEAR_ERROR_DIE);
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
                                total_cost = {$aZoneFinanceMappings[MAX_FINANCE_CPM]} * {$aInfo['cost']} / 1000,
                                updated = '". OA::getNow() ."'
                            WHERE
                                zone_id = {$aInfo['zone_id']}
                                AND day >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d'), 'date')."
                                AND day <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d'), 'date') ."
                                AND hour >= ". $this->oDbh->escape($oStartDate->format('%H')) ."
                                AND hour <= ". $this->oDbh->escape($oEndDate->format('%H'));
                        break;
                    case MAX_FINANCE_CPC:
                        $query = "
                            UPDATE
                                {$aConf['table']['prefix']}{$aConf['table'][$table]}
                            SET
                                total_cost = {$aZoneFinanceMappings[MAX_FINANCE_CPC]} * {$aInfo['cost']},
                                updated = '". OA::getNow() ."'
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
                                updated = '". OA::getNow() ."'
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
                                updated = '". OA::getNow() ."'
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
                                updated = '". OA::getNow() ."'
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
                                updated = '". OA::getNow() ."'
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
                                    updated = '". OA::getNow() ."'
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
                                        updated = '". OA::getNow() ."'
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
                                    updated = '". OA::getNow() ."'
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
                                        updated = '". OA::getNow() ."'
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
                                updated = '". OA::getNow() ."'
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
                                updated = '". OA::getNow() ."'
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
                                updated = '". OA::getNow() ."')
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
                '". OA::getNow() ."' AS now
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
                if ($campaignRow['end'] != OA_Dal::noDateValue()) {
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
                        $message =& OA_Email::prepareDeactivatePlacementEmail($campaignRow['contact'],
                                                                              $campaignRow['campaign_name'],
                                                                              $disableReason, $advertisements);
                        OA_Email::sendMail("Deactivated Banners: {$campaignRow['campaign_name']}", $message,
                                           $campaignRow['email'], $campaignRow['contact']);
                    }
                }
            } else {
                // The campaign is not active - does it need to be enabled,
                // based on the campaign starting date?
                $start = new Date($campaignRow['start'] . ' 00:00:00');  // Convert day to start of date Date
                if ($campaignRow['end'] != OA_Dal::noDateValue()) {
                    $end   = new Date($campaignRow['end']   . ' 23:59:59');  // Convert day to end of day Date
                } else {
                    $end = null;
                }
                if (($start->format('%Y-%m-%d') != OA_Dal::noDateValue()) && ($oDate->after($start))) {
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
                    // 1) That there is no impression target (<= 0), or, if there is an impression target (> 0),
                    //    then there must be remaining impressions to deliver (> 0); and
                    // 2) That there is no click target (<= 0), or, if there is a click target (> 0),
                    //    then there must be remaining clicks to deliver (> 0); and
                    // 3) That there is no conversion target (<= 0), or, if there is a conversion target (> 0),
                    //    then there must be remaining conversions to deliver (> 0); and
                    // 4) Either there is no end date, or the end date has not been passed
                    if ((($campaignRow['targetimpressions'] <= 0) || (($campaignRow['targetimpressions'] > 0) && ($remainingImpressions > 0))) &&
                        (($campaignRow['targetclicks']      <= 0) || (($campaignRow['targetclicks']      > 0) && ($remainingClicks      > 0))) &&
                        (($campaignRow['targetconversions'] <= 0) || (($campaignRow['targetconversions'] > 0) && ($remainingConversions > 0))) &&
                        (is_null($end) || (($end->format('%Y-%m-%d') != OA_Dal::noDateValue()) && (Date::compare($oDate, $end) < 0)))) {
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
                            $message =& OA_Email::prepareActivatePlacementEmail($campaignRow['contact'],
                                                                                $campaignRow['campaign_name'],
                                                                                $advertisements);
                            OA_Email::sendMail("Activated Banners: {$campaignRow['campaign_name']}", $message,
                                               $campaignRow['email'], $campaignRow['contact']);
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
     *                            to and including this date (minus any compact_stats_grace window)
     *                            will be deleted, unless required by the tracking module, where
     *                            installed).
     * @return integer The number of conversions deleted.
     */
    function deleteOldData($oSummarisedTo)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($aConf['table']['split']) {
            $this->_deleteOldDataSplit($oSummarisedTo);
        } else {
            $this->_deleteOldData($oSummarisedTo);
        }
    }

    /**
     * A private method to delete old (ie. summarised) raw data when normal tables in use.
     *
     * @access private
     * @param Date $oSummarisedTo The date/time up to which data have been summarised (i.e. data up
     *                            to and including this date (minus any compact_stats_grace window)
     *                            will be deleted, unless required by the tracking module, where
     *                            installed).
     * @return integer The number of conversions deleted.
     */
    function _deleteOldData($oSummarisedTo)
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

    /**
     * A private method to delete old (ie. summarised) raw data when split tables are in use.
     *
     * @access private
     * @param Date $oSummarisedTo The date/time up to which data have been summarised (i.e. if there
     *                            is no newer data than this date (minus any compact_stats_grace window)
     *                            then the raw table will be dropped, unless required by the tracking
     *                            module, where installed).
     * @return integer The number of raw tables dropped.
     */
    function _deleteOldDataSplit($oSummarisedTo)
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
