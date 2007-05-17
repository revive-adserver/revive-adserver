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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Common.php';

/**
 * The non-DB specific Data Abstraction Layer (DAL) class for the
 * Maintenance Forecasting Engine (MFE).
 *
 * @package    OpenadsDal
 * @subpackage MaintenanceForecasting
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class OA_Dal_Maintenance_Forecasting extends OA_Dal_Maintenance_Common
{

    /**
     * The class constructor method.
     */
    function OA_Dal_Maintenance_Forecasting()
    {
        parent::OA_Dal_Maintenance_Common();
    }

    /**
     * A method to store details on the last time that the maintenance forecasting
     * process ran.
     *
     * @param Date $oStart The time that the maintenance forecasting run started.
     * @param Date $oEnd The time that the maintenance forecasting run ended.
     * @param Date $oUpdateTo The end of the last operation interval ID that
     *                        has been updated.
     */
    function setMaintenanceForecastingLastRunInfo($oStart, $oEnd, $oUpdateTo)
    {
        return $this->setProcessLastRunInfo($oStart, $oEnd, $oUpdateTo, 'log_maintenance_forecasting', true);
    }

    /**
     * A method to return the time that the maintenance forecasting scripts
     * were last run, and the operation interval that was in use at the time.
     *
     * @param string $rawTable The name of a raw table which will be searched
     *                         for the earliest date/time, in the event that no valid
     *                         'updated_to' field could be found in the main table.
     * @return mixed False on error, null no no result, otherwise, an array containing the
     *               'updated_to' and 'operation_interval' fields, which represent the time
     *               that the Maintenance Forecasting process last completed updating data until
     *               and the Operation Interval length at that time.
     */
    function getMaintenanceForecastingLastRunInfo($rawTable)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['log_maintenance_forecasting'];
        return $this->getProcessLastRunInfo(
            $table,
            array('operation_interval'),
            null,
            'updated_to',
            array(
                'tableName' => $rawTable,
                'type'      => 'hour'
            )
        );
    }

    /**
     * A method to summarise the number of raw records matching a channel, in a given
     * set of zone IDs, using only SQL limitations.
     *
     * @param array $aSqlLimitations Array of delivery limitation groups, each group
     *                               containing an array of "AND" grouped delivery
     *                               limitations in SQL format, which need to be "OR"
     *                               tested.
     * @param Date $oStartDate The start of the day to summarise.
     * @param Date $oEndDate The end of the day to summarise.
     * @param array $aZoneIds An array of the zone IDs.
     * @param string $tableName The raw table name to test in.
     * @return array An array, each containing the number of records that matched the channel
     *               for each zone, indexed by zone ID.
     */
    function summariseRecordsInZonesBySqlLimitations($aSqlLimitations, $oStartDate, $oEndDate, $aZoneIds, $tableName)
    {
        $query = $this->_buildQueryFromLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        if ($query === false) {
            return array();
        }
        PEAR::pushErrorHandling(null);
        $rc = $this->oDbh->query($query);
        PEAR::popErrorHandling();
        if (!PEAR::isError($rc)) {
            $aResult = array();
            while ($aRow = $rc->fetchRow()) {
                $aResult[$aRow['zone_id']] = $aRow['count'];
            }
            $result = $rc->free();
            return $aResult;
        } elseif (!PEAR::isError($rc, DB_ERROR_NOSUCHTABLE)) {
            MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        } else {
            return array();
        }
    }

    /**
     * A private method to build a final SQL query from an "OR" collection of delivery
     * limitation "AND" groups.
     *
     * @param array $aSqlLimitations Array of delivery limitation groups, each group
     *                               containing an array of "AND" grouped delivery
     *                               limitations in SQL format, which need to be "OR"
     *                               tested.
     * @param Date $oStartDate The start of the day to summarise.
     * @param Date $oEndDate The end of the day to summarise.
     * @param array $aZoneIds An array of the zone IDs.
     * @param string $tableName The raw table name to test in.
     * @return mixed False if input is not valid or the input would not result in any
     *               matching values, otherwise, a string of the created SQL query.
     */
    function _buildQueryFromLimitations($aSqlLimitations, $oStartDate, $oEndDate, $aZoneIds, $tableName)
    {
        // Check input
        if (!is_array($aSqlLimitations) || empty($aSqlLimitations)) {
            return false;
        }
        foreach ($aSqlLimitations as $aSqlLimitationGroup) {
            if (!is_array($aSqlLimitationGroup) || empty($aSqlLimitationGroup)) {
                return false;
            }
            foreach ($aSqlLimitationGroup as $sqlLimitation) {
                if (!(is_string($sqlLimitation) || is_bool($sqlLimitation))) {
                    return false;
                }
            }
        }
        if (!is_a($oStartDate, 'Date')) {
            return false;
        }
        if (!is_a($oEndDate, 'Date')) {
            return false;
        }
        if (!is_array($aZoneIds) || empty($aZoneIds)) {
            return false;
        }
        if (empty($tableName)) {
            return false;
        }
        // Prepare query
        $aWhere = array();
        foreach ($aSqlLimitations as $aSqlLimitationGroup) {
            // Search the $aSqlLimitationGroup array to see if any of the
            // limitations are the boolean false
            $anyFalse = false;
            foreach ($aSqlLimitationGroup as $sqlLimitation) {
                if ($sqlLimitation === false) {
                    // No need to store this set of ANDed limitations,
                    // as one of the limitations was found to ALWAYS be
                    // false, so this set will ALWAYS never match
                    $anyFalse = true;
                    break;
                }
            }
            if (!$anyFalse) {
                $aWhere[] = '(' . implode(' AND ', $aSqlLimitationGroup) . ')';
            }
        }
        // Did any of the AND grouped sets have limitations that *may* result
        // in some impressions matching, or were they all false?
        if (empty($aWhere)) {
            return false;
        }
        $where = "
                date_time >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND date_time <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND zone_id IN (" .  implode(',', $aZoneIds) . ")
                AND (" . implode(' OR ', $aWhere) . ")";
        $query = "
            SELECT
                COUNT(*) AS count,
                zone_id AS zone_id
            FROM
                $tableName
            WHERE $where
            GROUP BY
                zone_id";
        return $query;
    }

    /**
     * A method to save the summarised channel counts to the database.
     *
     * @param Date $oDate A date in the day that has been summarised.
     * @param integer $channelId The ID of the channel.
     * @param array $aCount An array, indexed by zone ID, of the summarised
     *                      count of impressions in the channel.
     * @return boolean True on success, false otherwise.
     */
    function saveChannelSummaryForZones($oDate, $channelId, $aCount)
    {
        // Select existing channel/zone pairs that may already exist
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table   = $aConf['table']['prefix'] .
                   $aConf['table']['data_summary_channel_daily'];
        $aExistingData = array();
        $query = "
            SELECT
                zone_id AS zone_id
            FROM
                $table
            WHERE
                channel_id = $channelId
                AND day = '" . $oDate->format('%Y-%m-%d 00:00:00') . "'";
        OA::debug('Selecting existing zones IDs from the ' . $table . ' table for channel ' .
                   $channelId . ' and day ' . $oDate->format('%Y-%m-%d'), PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        while ($aRow = $rc->fetchRow()) {
            if (!is_null($aCount[$aRow['zone_id']])) {
                // A value needs to be logged for this channel/zone,
                // but a forecast already exists - note this
                $aExistingData[$aRow['zone_id']] = true;
            }
        }
        // Log the data
        foreach ($aCount as $zoneId => $impressions) {
            if ($aExistingData[$zoneId]) {
                // Update the record
                $query = "
                    UPDATE
                        $table
                    SET
                        actual_impressions = $impressions
                    WHERE
                        day = '" . $oDate->format('%Y-%m-%d 00:00:00') . "'
                        AND channel_id = $channelId
                        AND zone_id = $zoneId";
            } else {
                // Insert new record
                $query = "
                    INSERT INTO
                        $table
                        (
                            day,
                            channel_id,
                            zone_id,
                            actual_impressions
                        )
                    VALUES
                        (
                            '" . $oDate->format('%Y-%m-%d 00:00:00') . "',
                            $channelId,
                            $zoneId,
                            $impressions
                        )";
            }
            $rows = $this->oDbh->exec($query);
            if (PEAR::isError($rows)) {
                return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }
        }
        return true;
    }

}

?>