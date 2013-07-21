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
 * The PostgreSQL specific Data Abstraction Layer (DAL) class for the
 * Maintenance Statistics Engine (MSE).
 *
 * @package    OpenXDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_Dal_Maintenance_Statistics_Pgsql extends OX_Dal_Maintenance_Statistics
{

    /**
     * The constuctor method.
     *
     * @return OX_Dal_Maintenance_Statistics_Pgsql
     */
    function OX_Dal_Maintenance_Statistics_Pgsql()
    {
        $this->timestampCastString = '::timestamp';
        parent::OX_Dal_Maintenance_Statistics();
    }

    /**
     * A private method to return the SQL code required to migrate any old style raw
     * data into new style, bucket-based data, in the event of the requirement to
     * process any such data on upgrade to (or beyond) OpenX 2.8.
     *
     * Note that this method uses a custom PostgreSQL function defined in the
     * openXDeliveryLog plugin, but this is okay, as this code has a pre-call
     * condition that is enforced in the OX_Maintenance_Statistics_Task_MigrateBucketData
     * class that this plugin must be installed.
     *
     * @param string $bucketTable The bucket table to migrate the data into.
     * @param string $rawTable The raw table to migrate the data from.
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    function _getMigrateRawDataSQL($bucketTable, $rawTable, $oStart, $oEnd)
    {
        $query = "
            SELECT bucket_update_{$bucketTable}
            (
                " . $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . $this->timestampCastString . ",
                ad_id,
                zone_id,
                1
            )
            FROM
                " . $this->oDbh->quoteIdentifier($rawTable, true) . "
            WHERE
                date_time >= " . $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND
                date_time <= " . $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
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
        $diac  = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $diavv = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $var   = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true);
        $query = "
            UPDATE
                {$diac}
            SET
                connection_status = ". MAX_CONNECTION_STATUS_DUPLICATE .",
                updated = '". OA::getNow() ."',
                comments = 'Duplicate of conversion ID ' || diac2.data_intermediate_ad_connection_id
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