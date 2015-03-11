<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Dal/Maintenance/Statistics.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * The MySQL specific Data Abstraction Layer (DAL) class for the
 * Maintenance Statistics Engine (MSE).
 *
 * @package    OpenXDal
 * @subpackage MaintenanceStatistics
 */
class OX_Dal_Maintenance_Statistics_Mysql extends OX_Dal_Maintenance_Statistics
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
     * @uses OX_Dal_Maintenance_Statistics::OX_Dal_Maintenance_Statistics()
     */
    function __construct()
    {
        parent::__construct();
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
    private function setSortBufferSize()
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
    private function restoreSortBufferSize()
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
     * A method to migrate any old style raw requests into new style, bucket-based
     * requests, in the event of the requirement to process any such data on upgrade
     * to (or beyond) OpenX 2.8.
     *
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    function migrateRawRequests($oStart, $oEnd)
    {
        // Set the MySQL sort buffer size
        $this->setSortBufferSize();
        // Call the parent method
        parent::migrateRawRequests($oStart, $oEnd);
        // Restore the MySQL sort buffer size
        $this->restoreSortBufferSize();
    }

    /**
     * A method to migrate any old style raw impressions into new style, bucket-based
     * impressions, in the event of the requirement to process any such data on upgrade
     * to (or beyond) OpenX 2.8.
     *
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    function migrateRawImpressions($oStart, $oEnd)
    {
        // Set the MySQL sort buffer size
        $this->setSortBufferSize();
        // Perform the default action for migration of raw impressions...
        parent::migrateRawImpressions($oStart, $oEnd);
        // Restore the MySQL sort buffer size
        $this->restoreSortBufferSize();
    }

    /**
     * A method to migrate any old style raw clicks into new style, bucket-based
     * clicks, in the event of the requirement to process any such data on upgrade
     * to (or beyond) OpenX 2.8.
     *
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    function migrateRawClicks($oStart, $oEnd)
    {
        // Set the MySQL sort buffer size
        $this->setSortBufferSize();
        // Perform the default action for migration of raw clicks...
        parent::migrateRawClicks($oStart, $oEnd);
        // Restore the MySQL sort buffer size
        $this->restoreSortBufferSize();
    }

    /**
     * A private method to return the SQL code required to migrate any old style raw
     * data into new style, bucket-based data, in the event of the requirement to
     * process any such data on upgrade to (or beyond) OpenX 2.8.
     *
     * @access private
     * @param string $bucketTable The bucket table to migrate the data into.
     * @param string $rawTable The raw table to migrate the data from.
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    function _getMigrateRawDataSQL($bucketTable, $rawTable, $oStart, $oEnd)
    {
        $query = "
            INSERT INTO
                " . $this->oDbh->quoteIdentifier($bucketTable, true) . "
                (
                    interval_start,
                    creative_id,
                    zone_id,
                    count
                )
            SELECT
                " . $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . $this->timestampCastString . " AS interval_start,
                ad_id AS creative_id,
                zone_id AS zone_id,
                1 AS count
            FROM
                " . $this->oDbh->quoteIdentifier($rawTable, true) . "
            WHERE
                date_time >= " . $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND
                date_time <= " . $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
            ON DUPLICATE KEY UPDATE
                count = count + 1
        ";
        return $query;
    }

    /**
     * A method to de-duplicate conversions which have associated unique variables,
     * between the supplied operation interval start and end dates.
     *
     * @param PEAR::Date $oStart The start date/time of the operation interval.
     * @param PEAR::Date $oEnd   The end date/time of the operation interval.
     */
    function deduplicateConversions($oStart, $oEnd)
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
                diac.comments = CONCAT('Duplicate of conversion ID ', diac2.data_intermediate_ad_connection_id)";
        $message = '- Deduplicating conversions between ' . $oStart->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStart->tz->getShortName() .
                   ' and ' . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName();
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
    }

    /**
     * A method to reject conversions which variables which are required to be
     * non-empty, but which are in reality, empty, between the supplied operation
     * interval start and end dates.
     *
     * @param PEAR::Date $oStart The start date/time of the operation interval.
     * @param PEAR::Date $oEnd   The end date/time of the operation interval.
     */
    function rejectEmptyVarConversions($oStart, $oEnd)
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
        $message = '- Rejecting conversions with empty required variables between ' . $oStart->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStart->tz->getShortName() .
                   ' and ' . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName();
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
    }

}

?>