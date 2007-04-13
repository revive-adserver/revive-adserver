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
     * A private method to save the tacker impression/ad impression and
     * tracker impression/ad click connections that have been marked as
     * "latest", and also save the associated tracker impression
     * variable values.
     *
     * @access private
     * @param Date $start The start date/time to save from.
     * @param Date $end The end date/time to save to.
     */
    function _saveIntermediateSaveConnectionsAndVariableValues($start, $end)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // How many days does the operation interval span?
        $days = Date_Calc::dateDiff($start->getDay(), $start->getMonth(), $start->getYear(),
                                    $end->getDay(),   $end->getMonth(),   $end->getYear());
        $outerTable = $aConf['table']['prefix'] .
                      $aConf['table']['data_intermediate_ad_connection'];
        $innerTable = $aConf['table']['prefix'] .
                      $aConf['table']['data_intermediate_ad_variable_value'];
        // Save the connections
        $outerDate = &new Date();
        $outerDate->copy($start);
        for ($counter = 0; $counter <= $days; $counter++) {
            // Set the appropriate data_raw_tracker_impression table
            $trackerImpressionTable = $aConf['table']['prefix'] .
                                      $aConf['table']['data_raw_tracker_impression'] . '_' .
                                      $outerDate->format('%Y%m%d');
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
                    '".date('Y-m-d H:i:s')."'
                FROM
                    tmp_ad_connection AS tac,
                    $trackerImpressionTable AS drti
                WHERE
                    tac.server_raw_tracker_impression_id = drti.server_raw_tracker_impression_id
                    AND tac.server_raw_ip = drti.server_raw_ip
                    AND tac.latest = 1";
            MAX::debug("Inserting the connections into the $outerTable table", PEAR_LOG_DEBUG);
            PEAR::pushErrorHandling(null);
            $rows = $this->oDbh->exec($query);
            PEAR::popErrorHandling();
            if (PEAR::isError($rows) && (!PEAR::isError($result, DB_ERROR_NOSUCHTABLE))) {
                MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }
            // Save any variable values associated with the above connections
            $innerDate = &new Date();
            $innerDate->copy($outerDate);
            for ($innerCounter = 0; $innterCounter < 2; $innterCounter++) {
                // Set the appropriate data_raw_tracker_variable_value table
                $trackerVariableValueTable = $aConf['table']['prefix'] .
                                             $aConf['table']['data_raw_tracker_variable_value'] . '_' .
                                             $innerDate->format('%Y%m%d');
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
                        AND diac.server_raw_ip = drti.server_raw_ip
                        AND drti.server_raw_tracker_impression_id = drtvv.server_raw_tracker_impression_id
                        AND drti.server_raw_ip = drtvv.server_raw_ip
                        AND diac.tracker_date_time >= '" . $start->format('%Y-%m-%d %H:%M:%S') . "'
                        AND diac.tracker_date_time <= '" . $end->format('%Y-%m-%d %H:%M:%S') . "'";
                MAX::debug("Saving the tracker impression variable values from the $innerTable table",
                           PEAR_LOG_DEBUG);
                PEAR::pushErrorHandling(null);
                $rows = $this->oDbh->exec($query);
                PEAR::popErrorHandling();
                if (PEAR::isError($rows) && (!PEAR::isError($result, DB_ERROR_NOSUCHTABLE))) {
                    MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
                // Update the split data_raw_tracker_variable_value table being used
                $innerDate = $innerDate->getNextDay();
            }
            // Update the split data_raw_tracker_impression table being used
            $outerDate = $outerDate->getNextDay();
        }
        // Reject connections with empty required variables
        $this->_saveIntermediateRejectEmptyVarConversions($start, $end);
        // Remove from diac all duplicates
        $this->_saveIntermediateDeduplicateConversions($start, $end);
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
