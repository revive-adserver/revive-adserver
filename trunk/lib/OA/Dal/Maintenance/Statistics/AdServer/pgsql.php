<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
$Id: mysql.php 5411 2007-03-27 16:00:31Z andrew.hill@openads.org $
*/

require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Common.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * The data access layer code for summarising raw data into statistics, for
 * the AdServer module.
 *
 * @package    OpenXDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Dal_Maintenance_Statistics_AdServer_pgsql extends OA_Dal_Maintenance_Statistics_Common
{

    /**
     * The constructor method.
     *
     * @uses OA_Dal_Maintenance_Statistics_Common::OA_Dal_Maintenance_Statistics_Common()
     */
    function OA_Dal_Maintenance_Statistics_AdServer_pgsql()
    {
        parent::OA_Dal_Maintenance_Statistics_Common();
        $this->dateCastString = '::date';
        $this->hourCastString  = '::integer';
        $this->timestampCastString = '::timestamp';
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
     *              statistics has never been run for the OpenX module before.
     *              Returns null if no raw data is available.
     */
    function getMaintenanceStatisticsLastRunInfo($type, $oNow = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['data_raw_ad_impression'];
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
        // Summarise the requests
        return $this->_summariseData($oStart, $oEnd, 'request');
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
        // Summarise the impressions
        return $this->_summariseData($oStart, $oEnd, 'impression');
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
        // Summarise the clicks
        return $this->_summariseData($oStart, $oEnd, 'click');
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
            AS SELECT
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
        OA::debug('- Selecting the possible connections that are the most recent connections ' .
                   '(ie. they have the most recent connection_date_time field)', PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        // Mark these "latest" connections in the tmp_ad_connection table
        $tac = 'tmp_ad_connection';
        $query = "
            UPDATE
                {$tac}
            SET
                latest = 1
            FROM
                tmp_connection_latest AS tcl
            WHERE
                {$tac}.server_raw_tracker_impression_id = tcl.server_raw_tracker_impression_id
                AND {$tac}.server_raw_ip = tcl.server_raw_ip
                AND {$tac}.connection_date_time = tcl.connection_date_time";
        OA::debug('- Setting the \'latest connection\' flag in the temporary tmp_connection table',
                   PEAR_LOG_DEBUG);
        $connectionRows = $this->oDbh->exec($query);
        if (PEAR::isError($connectionRows)) {
            return MAX::raiseError($connectionRows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        // Drop the tmp_connection_latest table
        OA::setTempDebugPrefix('- ');
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
        $query = "
            CREATE TEMPORARY TABLE
                tmp_union
            AS";
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
        $var   = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true);
        $diac  = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $diavv = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $query = "
            UPDATE
                {$diac}
            SET
                connection_status = ". MAX_CONNECTION_STATUS_DISAPPROVED .",
                updated = '". OA::getNow() ."',
                comments = 'Rejected because ' || COALESCE(NULLIF(v.description, ''), v.name) || ' is empty'
            FROM
                {$diac} AS diac2
            JOIN
                {$var} AS v
            ON
                (
                    diac2.tracker_id = v.trackerid
                )
            LEFT JOIN
                {$diavv} AS diavv
            ON
                (
                    diac2.data_intermediate_ad_connection_id = diavv.data_intermediate_ad_connection_id
                    AND
                    v.variableid = diavv.tracker_variable_id
                )
            WHERE
                {$diac}.data_intermediate_ad_connection_id = diac2.data_intermediate_ad_connection_id
                AND
                {$diac}.tracker_date_time >= '" . $oStart->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                {$diac}.tracker_date_time <= '" . $oEnd->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                {$diac}.inside_window = 1
                AND
                v.reject_if_empty = 1
                AND
                (diavv.value IS NULL OR diavv.value = '')
            ";
        $message = '- Rejecting conversions with empty required variables between "' . $oStart->format('%Y-%m-%d %H:%M:%S') . '"' .
                   ' and "' . $oEnd->format('%Y-%m-%d %H:%M:%S') . '"';
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
    }

    /**
     * A private method to dedup conversions which have associated unique variables.
     * The method check connections from last interval (between $oStart and $oEnd) and
     * deduplicate them between those dates.
     *
     * @access private
     * @param PEAR::Date $oStart The start date/time of current interval.
     * @param PEAR::Date $oEnd   The end date/time of current interval.
     */
    function _saveIntermediateDeduplicateConversions($oStart, $oEnd)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $diac  = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $diavv = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $var   = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true);
        $query = "
            UPDATE
                {$diac}
            SET
                connection_status = ". MAX_CONNECTION_STATUS_DUPLICATE .",
                updated = '". OA::getNow() ."',
                comments = 'Duplicate of connection ID ' || diac2.data_intermediate_ad_connection_id
            FROM
                {$diavv} AS diavv
            JOIN
                {$var} AS v
            ON
                (
                    diavv.tracker_variable_id = v.variableid
                    AND
                    v.is_unique = 1
                )
            JOIN
                {$diac} AS diac2
            ON
                (
                    v.trackerid = diac2.tracker_id
                )
            JOIN
                {$diavv} AS diavv2
            ON
                (
                    diac2.data_intermediate_ad_connection_id = diavv2.data_intermediate_ad_connection_id
                    AND
                    diavv2.tracker_variable_id = diavv.tracker_variable_id
                    AND
                    diavv2.value = diavv.value
                )
            WHERE
                {$diac}.data_intermediate_ad_connection_id = diavv.data_intermediate_ad_connection_id
                AND
                {$diac}.inside_window = 1
                AND
                {$diac}.tracker_date_time >= '" . $oStart->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                {$diac}.tracker_date_time <= '" . $oEnd->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                {$diac}.inside_window = 1
                AND
                UNIX_TIMESTAMP({$diac}.tracker_date_time) - UNIX_TIMESTAMP(diac2.tracker_date_time) < v.unique_window
                AND
                UNIX_TIMESTAMP({$diac}.tracker_date_time) - UNIX_TIMESTAMP(diac2.tracker_date_time) > 0
            ";
        $message = '- Deduplicating conversions between "' . $oStart->format('%Y-%m-%d %H:%M:%S') . '"' .
                   ' and "' . $oEnd->format('%Y-%m-%d %H:%M:%S') . '"';
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
    }

}

?>
