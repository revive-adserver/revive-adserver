<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_Dal_Maintenance_Statistics_Mysql extends OX_Dal_Maintenance_Statistics
{

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