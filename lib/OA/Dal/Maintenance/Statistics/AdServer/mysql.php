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
$Id$
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
                tac.date_time >= " . $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND tac.date_time <= " . $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
            GROUP BY
                tac.server_raw_tracker_impression_id, tac.server_raw_ip";
        OA::debug('- Selecting the possible connections that are the most recent connections ' .
                   '(ie. they have the most recent connection_date_time field)', PEAR_LOG_DEBUG);
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
                diac.updated = '". OA::getNow() ."',
                diac.comments = CONCAT('Rejected because ', COALESCE(NULLIF(v.description, ''), v.name), ' is empty')
            WHERE
                diac.tracker_date_time >= " . $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND
                diac.tracker_date_time <= " . $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND
                diac.inside_window = 1
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
     * The method check connections from last interval (between $start and $end) and dedup them
     * between those dates.
     *
     * @param PEAR::Date $oStart The start date/time of current interval.
     * @param PEAR::Date $oEnd   The end date/time of current interval.
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
                    diac.tracker_date_time >= " . $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                    AND
                    diac.tracker_date_time <= " . $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
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
                diac.updated = '". OA::getNow() ."',
                diac.comments = CONCAT('Duplicate of connection ID ', diac2.data_intermediate_ad_connection_id)";
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
