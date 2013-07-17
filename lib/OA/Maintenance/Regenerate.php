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

require_once MAX_PATH . '/lib/OA/DB.php';

require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * A class that implements function used in Regenerate Ad Server Statistics script
 *
 * @package    OpenXMaintenance
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OA_Maintenance_Regenerate
{
    /**
     * Check start/end dates - note that check is the reverse of normal check:
     * if the operation interval is <= 60, must be start/end of an hour, to
     * make sure we update all the operation intervals in the hour, and if
     * the operation interval > 60, must be the start/end of an operation
     * interval, to make sure we update all the hours in the operation interval.
     *
     * @static
     * @param Date $oStartDate
     * @param Date $oEndDate
     * @return boolean
     */
    function checkDates($oStartDate, $oEndDate) {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $operationInterval = $aConf['maintenance']['operation_interval'];
        if ($operationInterval <= 60) {
            // Must ensure that only one hour is being summarised
            if (!OX_OperationInterval::checkDatesInSameHour($oStartDate, $oEndDate)) {
                return false;
            }
            // Now check that the start and end dates are match the start and
            // end of the hour
            $oHourStart = new Date();
            $oHourStart->setYear($oStartDate->getYear());
            $oHourStart->setMonth($oStartDate->getMonth());
            $oHourStart->setDay($oStartDate->getDay());
            $oHourStart->setHour($oStartDate->getHour());
            $oHourStart->setMinute('00');
            $oHourStart->setSecond('00');
            $oHourEnd = new Date();
            $oHourEnd->setYear($oEndDate->getYear());
            $oHourEnd->setMonth($oEndDate->getMonth());
            $oHourEnd->setDay($oEndDate->getDay());
            $oHourEnd->setHour($oEndDate->getHour());
            $oHourEnd->setMinute('59');
            $oHourEnd->setSecond('59');
            if (!$oStartDate->equals($oHourStart)) {
                return false;
            }
            if (!$oEndDate->equals($oHourEnd)) {
                return false;
            }
        } else {
            // Must ensure that only one operation interval is being summarised
            $operationIntervalID =
                OX_OperationInterval::convertDaySpanToOperationIntervalID($oStartDate, $oEndDate, $operationInterval);
            if (is_bool($operationIntervalID) && !$operationIntervalID) {
                return false;
            }
            // Now check that the start and end dates match the start and end
            // of the operation interval
            list($oOperationIntervalStart, $oOperationIntervalEnd) =
                OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate, $operationInterval);
            if (!$oStartDate->equals($oOperationIntervalStart)) {
                return false;
            }
            if (!$oEndDate->equals($oOperationIntervalEnd)) {
                return false;
            }
        }
        return true;
    }

   /**
    * Clears intermediate abd summary statistics in selected date range from tables:
    *  - data_intermediate_ad_connection
    *  - data_intermediate_ad_variable_value
    *  - data_intermediate_ad
    *  - data_summary_ad_hourly
    *  - data_summary_ad_zone_assoc
    *
    * @static
    * @param Date $oStartDate
    * @param Date $oEndDate
    */
    function clearIntermediateAndSummaryTables($oStartDate, $oEndDate) {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Create a Data Access Layer object
        $oDbh = &OA_DB::singleton();

        // Find the connections (if any) in the data_intermediate_ad_connection table
        $query = "
            SELECT
                data_intermediate_ad_connection_id
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']}
            WHERE
                tracker_date_time >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND tracker_date_time <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
        $rc = $oDbh->query($query);

        // Delete any variable values that are attached to these connections
        while ($row = $rc->fetchRow()) {
            $query = "
                DELETE FROM
                    {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_variable_value']}
                WHERE
                    data_intermediate_ad_connection_id = {$row['data_intermediate_ad_connection_id']}";
            $rows = $oDbh->exec($query);
        }

        // Delete any connections in the data_intermediate_ad_connection table
        $query = "
            DELETE FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']}
            WHERE
                tracker_date_time >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND tracker_date_time <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
        $rows = $oDbh->exec($query);

        // Delete any summary rows from the data_intermediate_ad table
        $query = "
            DELETE FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad']}
            WHERE
                interval_start >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND interval_end <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
        $rows = $oDbh->exec($query);

        // Delete any summary rows from the data_summary_ad_hourly table
        $query = "
            DELETE FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_hourly']}
            WHERE
                date_time >= '" . $oStartDate->format('%Y-%m-%d %H:00:00') . "'
                AND date_time <= '" . $oEndDate->format('%Y-%m-%d %H:00:00') . "'";
        $rows = $oDbh->exec($query);

        // Delete any impression history data from the data_summary_ad_zone_assoc table
        $query = "
            DELETE FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']}
            WHERE
                interval_start >= '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND interval_end <= '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'";
        $rows = $oDbh->exec($query);
    }
}
?>