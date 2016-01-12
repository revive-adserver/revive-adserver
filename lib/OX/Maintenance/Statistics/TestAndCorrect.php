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

require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/OA/Dal.php';

/**
 * A class that implements the functions used by the statistics test and
 * correct script.
 *
 * @package    OpenXMaintenance
 * @subpackage Tools
 */
class OX_Maintenance_Statistics_TestAndCorrect
{

    /**
     * Connection to the database.
     *
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    function __construct()
    {
        // Get a connection to the datbase
        $this->oDbh =& OA_DB::singleton();
    }

    /**
     * A mathod to quickly check the data in the database for the date
     * range given, to ensure that the range being tested & corrected
     * seems reasonable.
     *
     * @param Date $oStartDate The start date/time of the range to test & correct.
     * @param Date $oEndDate   The end date/time of the range to test & correct.
     * @return boolean True if the date range seems okay, false otherwise.
     */
    function checkRangeData($oStartDate, $oEndDate) {

        // Test that there are no rows in the data_intermediate_ad table where the
        // operation interval value does not match that in the configuration file
        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->whereAdd('date_time >= ' . $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp'));
        $doData_intermediate_ad->whereAdd('date_time <= ' . $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp'));
        $doData_intermediate_ad->whereAdd('operation_interval != ' . $this->oDbh->quote(OX_OperationInterval::getOperationInterval(), 'integer'));
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        if ($rows > 0) {
            $message = "\n    Detected at least one row in the data_intermediate_ad table with operation interval != " . OX_OperationInterval::getOperationInterval() . ".\n";
            echo $message;
            return false;
        }

        // Test that all of the date/time values in the data_summary_ad_hourly
        // table align with the start of operation intervals
        $doData_summary_ad_hourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doData_summary_ad_hourly->selectAdd();
        $doData_summary_ad_hourly->selectAdd('DISTINCT date_time');
        $doData_summary_ad_hourly->whereAdd('date_time >= ' . $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp'));
        $doData_summary_ad_hourly->whereAdd('date_time <= ' . $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp'));
        $doData_summary_ad_hourly->find();
        while ($doData_summary_ad_hourly->fetch()) {
            $oDate = new Date($doData_summary_ad_hourly->date_time);
            $result = OX_OperationInterval::checkDateIsStartDate($oDate);
            if (!$result) {
                $message = "\n    Detected at least one row in the data_summary_ad_hourly table with date_time value not on the hour start interval.\n";
                echo $message;
                return false;
            }
        }

        return true;
    }

    /**
     * A method to search for any aligned hours in the data_intermediate_ad and
     * data_summary_ad_hourly tables where the number of requests, impressions,
     * clicks or conversions do not agree with each other, and, where any such
     * hours are found, to search these hours for any cases of duplicate rows
     * in the data_summary_ad_hourly table (based on the ad_id, creative_id,
     * zone_id, requests, impressions, clicks and conversions columns), and
     * remove the duplicates.
     *
     * @param Date $oStartDate The start date/time of the range to operate on.
     * @param Date $oEndDate   The end date/time of the farnce to operate on.
     */
    function issueOne($oStartDate, $oEndDate)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $sQuery = "
            SELECT
                t1.hour_date_time AS date_time,
                t1.requests AS intermediate_requests,
                t2.requests AS summary_requests,
                t1.impressions AS intermediate_impressions,
                t2.impressions AS summary_impressions,
                t1.clicks AS intermediate_clicks,
                t2.clicks AS summary_clicks,
                t1.conversions AS intermediate_conversions,
                t2.conversions AS summary_conversions
            FROM
                (
                    SELECT
                        DATE_FORMAT(date_time, '%Y-%m-%d %H:00:00') AS hour_date_time,
                        SUM(requests) AS requests,
                        SUM(impressions) AS impressions,
                        SUM(clicks) AS clicks,
                        SUM(conversions) AS conversions
                    FROM
                        {$aConf['table']['prefix']}data_intermediate_ad
                    WHERE
                        date_time >= " . $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                        AND
                        date_time <= " . $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                    GROUP BY
                        hour_date_time
                ) AS t1,
                (
                    SELECT
                        DATE_FORMAT(date_time, '%Y-%m-%d %H:00:00') AS hour_date_time,
                        SUM(requests) AS requests,
                        SUM(impressions) AS impressions,
                        SUM(clicks) AS clicks,
                        SUM(conversions) AS conversions
                    FROM
                        {$aConf['table']['prefix']}data_summary_ad_hourly
                    WHERE
                        date_time >= " . $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                        AND
                        date_time <= " . $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                    GROUP BY
                        hour_date_time
                ) AS t2
            WHERE
                t1.hour_date_time = t2.hour_date_time
            HAVING
                intermediate_requests < summary_requests
                OR
                intermediate_impressions < summary_impressions
                OR
                intermediate_clicks < summary_clicks
                OR
                intermediate_conversions < summary_conversions
            ORDER BY
                date_time";
        RV::disableErrorHandling();
        $rsResult = $this->oDbh->query($sQuery);
        RV::enableErrorHandling();
        if (PEAR::isError($rsResult)) {
            $message = "\n    Database error while searching for invalid data:\n    " . $rsResult->getMessage() . "\n    Cannot detect issues, so will not attepmt any corrections.\n";
            echo $message;
            return;
        }
        $rows = $rsResult->numRows();
        if ($rows == 0) {
            $message = "\n    Did not detect any issues; no statistics data correction required.\n";
            echo $message;
            return;
        }
        $message = "\n    Detected $rows operation intervals that need further inspection...\n";
        echo $message;
        while ($aRow = $rsResult->fetchRow()) {
            $message = "        Inspecting operation interval {$aRow['date_time']}...\n";
            echo $message;
            $requestRemainder    = $aRow['summary_requests'] % $aRow['intermediate_requests'];
            $impressionRemainder = $aRow['summary_impressions'] % $aRow['intermediate_impressions'];
            $clickRemainder      = $aRow['summary_clicks'] % $aRow['intermediate_clicks'];
            $conversionRemainder = $aRow['summary_conversions'] % $aRow['intermediate_conversions'];
            if (!($requestRemainder == 0 && $impressionRemainder == 0 && $clickRemainder == 0 && $conversionRemainder == 0)) {
                $message = "            Operation interval's data discrepancy is not a result of multiple summarisation of\n            data_intermediate_ad into data_summary_ad_hourly. Cannot correct this operation\n            interval automatically - you will need to inspect the data manually once this script\n            has completed running!\n";
                echo $message;
            } else {
                $message = "            Correcting...\n";
                echo $message;
                // Deal with the duplicate rows in the data_summary_ad_hourly table for
                // this operation interval
                $sInnerQuery = "
                    SELECT DISTINCT
                        COUNT(*) AS rows,
                        ad_id,
                        creative_id,
                        zone_id,
                        requests,
                        impressions,
                        clicks,
                        conversions
                    FROM
                        {$aConf['table']['prefix']}data_summary_ad_hourly
                    WHERE
                        date_time = " . $this->oDbh->quote($aRow['date_time'], 'timestamp') . "
                    GROUP BY
                        ad_id,
                        creative_id,
                        zone_id,
                        requests,
                        impressions,
                        clicks,
                        conversions";
                RV::disableErrorHandling();
                $rsInnerResult = $this->oDbh->query($sInnerQuery);
                RV::enableErrorHandling();
                if (PEAR::isError($rsInnerResult)) {
                    $message = "                Error while selecting duplicate rows, please re-run script later!\n";
                    echo $message;
                    continue;
                }
                while ($aInnerRow = $rsInnerResult->fetchRow()) {
                    if ($aInnerRow['rows'] <= 1) {
                        $message = "                Found a non-duplicate result row for '{$aRow['date_time']}', Creative ID '{$aInnerRow['ad_id']}', Zone ID '{$aInnerRow['zone_id']}'!\n";
                        echo $message;
                        continue;
                    } else {
                        $message = "                Correcting data for '{$aRow['date_time']}', Creative ID '{$aInnerRow['ad_id']}', Zone ID '{$aInnerRow['zone_id']}'...\n";
                        echo $message;
                        $sDeleteQuery = "
                            DELETE FROM
                                {$aConf['table']['prefix']}data_summary_ad_hourly
                            WHERE
                                date_time = " . $this->oDbh->quote($aRow['date_time'], 'timestamp') . "
                                AND
                                ad_id = " . $this->oDbh->quote($aInnerRow['ad_id'], 'integer') . "
                                AND
                                creative_id = " . $this->oDbh->quote($aInnerRow['creative_id'], 'integer') . "
                                AND
                                zone_id = " . $this->oDbh->quote($aInnerRow['zone_id'], 'integer') . "
                                AND
                                requests = " . $this->oDbh->quote($aInnerRow['requests'], 'integer') . "
                                AND
                                impressions = " . $this->oDbh->quote($aInnerRow['impressions'], 'integer') . "
                                AND
                                clicks = " . $this->oDbh->quote($aInnerRow['clicks'], 'integer') . "
                                AND
                                conversions = " . $this->oDbh->quote($aInnerRow['conversions'], 'integer') . "
                            LIMIT " . $this->oDbh->quote(($aInnerRow['rows'] - 1), 'integer');
                        if (defined('DEBUG_ONLY')) {
                            $message = "                Running in debug mode only, if running correctly, the following would have been performed:\n";
                            echo $message;
                            $message = $sDeleteQuery;
                            $message = preg_replace('/\n/', '', $message);
                            $message = preg_replace('/^ +/', '', $message);
                            $message = preg_replace('/ +/', ' ', $message);
                            $message = wordwrap($message, 75, "\n                    ");
                            $message = "                    " . $message . ";\n";
                            echo $message;
                        } else {
                            RV::disableErrorHandling();
                            $rsDeleteResult = $this->oDbh->exec($sDeleteQuery);
                            RV::enableErrorHandling();
                            if (PEAR::isError($rsDeleteResult)) {
                                $message = "                Error while deleting a duplicate row, please re-run script later!\n";
                                echo $message;
                                continue;
                            }
                            $message = "                Deleted {$rsDeleteResult} duplicate row(s).\n";
                            echo $message;
                        }
                    }
                    if (defined('DEBUG_ONLY')) {
                        sleep(1);
                    }
                }
            }
        }
    }

    /**
     * A method to search for any aligned hours in the data_intermediate_ad and
     * data_summary_ad_hourly tables where the number of requests, impressions,
     * clicks or conversions do not agree with each other, and, where any such
     * hours are found, to search these hours for any cases of the
     * data_summary_ad_hourly table containing fewer requests, impressions,
     * clicks or conversions that the data_intermediate_ad table, and where
     * these cases are found, to update the data_summary_ad_hourly to match
     * the values found in the data_intermediate_ad table.
     *
     * @param Date $oStartDate The start date/time of the range to operate on.
     * @param Date $oEndDate   The end date/time of the farnce to operate on.
     */
    function issueTwo($oStartDate, $oEndDate)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $sQuery = "
            SELECT
                t1.hour_date_time AS date_time,
                t1.requests AS intermediate_requests,
                t2.requests AS summary_requests,
                t1.impressions AS intermediate_impressions,
                t2.impressions AS summary_impressions,
                t1.clicks AS intermediate_clicks,
                t2.clicks AS summary_clicks,
                t1.conversions AS intermediate_conversions,
                t2.conversions AS summary_conversions
            FROM
                (
                    SELECT
                        DATE_FORMAT(date_time, '%Y-%m-%d %H:00:00') AS hour_date_time,
                        SUM(requests) AS requests,
                        SUM(impressions) AS impressions,
                        SUM(clicks) AS clicks,
                        SUM(conversions) AS conversions
                    FROM
                        {$aConf['table']['prefix']}data_intermediate_ad
                    WHERE
                        date_time >= " . $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                        AND
                        date_time <= " . $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                    GROUP BY
                        hour_date_time
                ) AS t1,
                (
                    SELECT
                        DATE_FORMAT(date_time, '%Y-%m-%d %H:00:00') AS hour_date_time,
                        SUM(requests) AS requests,
                        SUM(impressions) AS impressions,
                        SUM(clicks) AS clicks,
                        SUM(conversions) AS conversions
                    FROM
                        {$aConf['table']['prefix']}data_summary_ad_hourly
                    WHERE
                        date_time >= " . $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                        AND
                        date_time <= " . $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                    GROUP BY
                        hour_date_time
                ) AS t2
            WHERE
                t1.hour_date_time = t2.hour_date_time
            HAVING
                intermediate_requests > summary_requests
                OR
                intermediate_impressions > summary_impressions
                OR
                intermediate_clicks > summary_clicks
                OR
                intermediate_conversions > summary_conversions
            ORDER BY
                date_time";
        RV::disableErrorHandling();
        $rsResult = $this->oDbh->query($sQuery);
        RV::enableErrorHandling();
        if (PEAR::isError($rsResult)) {
            $message = "\n    Database error while searching for invalid data:\n    " . $rsResult->getMessage() . "\n    Cannot detect issues, so will not attepmt any corrections.\n";
            echo $message;
            return;
        }
        $rows = $rsResult->numRows();
        if ($rows == 0) {
            $message = "\n    Did not detect any issues; no statistics data correction required.\n";
            echo $message;
            return;
        }
        $message = "\n    Detected $rows operation intervals that need further inspection...\n";
        echo $message;
        while ($aRow = $rsResult->fetchRow()) {
            $message = "        Inspecting operation interval {$aRow['date_time']}...\n";
            echo $message;
            $message = "            Correcting...\n";
            echo $message;
            $oDate = new Date($aRow['date_time']);
            $sInnerQuery = "
                SELECT
                    t1.hour_date_time AS date_time,
                    t1.ad_id AS ad_id,
                    t1.zone_id AS zone_id,
                    t1.requests AS intermediate_requests,
                    t2.requests AS summary_requests,
                    t1.impressions AS intermediate_impressions,
                    t2.impressions AS summary_impressions,
                    t1.clicks AS intermediate_clicks,
                    t2.clicks AS summary_clicks,
                    t1.conversions AS intermediate_conversions,
                    t2.conversions AS summary_conversions
                FROM
                    (
                        SELECT
                            DATE_FORMAT(date_time, '%Y-%m-%d %H:00:00') AS hour_date_time,
                            ad_id AS ad_id,
                            zone_id AS zone_id,
                            SUM(requests) AS requests,
                            SUM(impressions) AS impressions,
                            SUM(clicks) AS clicks,
                            SUM(conversions) AS conversions
                        FROM
                            {$aConf['table']['prefix']}data_intermediate_ad
                        WHERE
                            date_time >= " . $this->oDbh->quote($oDate->format('%Y-%m-%d %H:00:00'), 'timestamp') . "
                            AND
                            date_time <= " . $this->oDbh->quote($oDate->format('%Y-%m-%d %H:59:59'), 'timestamp') . "
                        GROUP BY
                            hour_date_time, ad_id, zone_id
                    ) AS t1,
                    (
                        SELECT
                            DATE_FORMAT(date_time, '%Y-%m-%d %H:00:00') AS hour_date_time,
                            ad_id AS ad_id,
                            zone_id AS zone_id,
                            SUM(requests) AS requests,
                            SUM(impressions) AS impressions,
                            SUM(clicks) AS clicks,
                            SUM(conversions) AS conversions
                        FROM
                            {$aConf['table']['prefix']}data_summary_ad_hourly
                        WHERE
                            date_time >= " . $this->oDbh->quote($oDate->format('%Y-%m-%d %H:00:00'), 'timestamp') . "
                            AND
                            date_time <= " . $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:59:59'), 'timestamp') . "
                        GROUP BY
                            hour_date_time, ad_id, zone_id
                    ) AS t2
                WHERE
                    t1.hour_date_time = t2.hour_date_time
                    AND
                    t1.ad_id = t2.ad_id
                    AND
                    t1.zone_id = t2.zone_id
                HAVING
                    intermediate_requests > summary_requests
                    OR
                    intermediate_impressions > summary_impressions
                    OR
                    intermediate_clicks > summary_clicks
                    OR
                    intermediate_conversions > summary_conversions
                ORDER BY
                    date_time, ad_id, zone_id";
            RV::disableErrorHandling();
            $rsInnerResult = $this->oDbh->query($sInnerQuery);
            RV::enableErrorHandling();
            if (PEAR::isError($rsInnerResult)) {
                $message = "                Error while selecting unsummarised rows, please re-run script later!\n";
                echo $message;
                continue;
            }
            while ($aInnerRow = $rsInnerResult->fetchRow()) {
                $message = "                Correcting data for '{$aRow['date_time']}', Creative ID '{$aInnerRow['ad_id']}', Zone ID '{$aInnerRow['zone_id']}'...\n";
                echo $message;
                $sUpdateQuery = "
                    UPDATE
                        {$aConf['table']['prefix']}data_summary_ad_hourly
                    SET
                        requests = " . $this->oDbh->quote($aInnerRow['intermediate_requests'], 'integer') . ",
                        impressions = " . $this->oDbh->quote($aInnerRow['intermediate_impressions'], 'integer') . ",
                        clicks = " . $this->oDbh->quote($aInnerRow['intermediate_clicks'], 'integer') . ",
                        conversions = " . $this->oDbh->quote($aInnerRow['intermediate_conversions'], 'integer') . "
                    WHERE
                        date_time = " . $this->oDbh->quote($aInnerRow['date_time'], 'timestamp') . "
                        AND
                        ad_id = " . $this->oDbh->quote($aInnerRow['ad_id'], 'integer') . "
                        AND
                        zone_id = " . $this->oDbh->quote($aInnerRow['zone_id'], 'integer') . "
                        AND
                        requests = " . $this->oDbh->quote($aInnerRow['summary_requests'], 'integer') . "
                        AND
                        impressions = " . $this->oDbh->quote($aInnerRow['summary_impressions'], 'integer') . "
                        AND
                        clicks = " . $this->oDbh->quote($aInnerRow['summary_clicks'], 'integer') . "
                        AND
                        conversions = " . $this->oDbh->quote($aInnerRow['summary_conversions'], 'integer') . "
                    LIMIT 1";
                if (defined('DEBUG_ONLY')) {
                    $message = "                Running in debug mode only, if running correctly, the following would have been performed:\n";
                    echo $message;
                    $message = $sUpdateQuery;
                    $message = preg_replace('/\n/', '', $message);
                    $message = preg_replace('/^ +/', '', $message);
                    $message = preg_replace('/ +/', ' ', $message);
                    $message = wordwrap($message, 75, "\n                    ");
                    $message = "                    " . $message . ";\n";
                    echo $message;
                } else {
                    RV::disableErrorHandling();
                    $rsUpdateResult = $this->oDbh->exec($sUpdateQuery);
                    RV::enableErrorHandling();
                    if (PEAR::isError($rsUpdateResult)) {
                        $message = "                Error while updating an incomplete row, please re-run script later!\n";
                        echo $message;
                        continue;
                    }
                    if ($rsUpdateResult > 1) {
                        $message = "                Error: More than one incomplete row updated, please manually inspect data!\n                       once the script has completed running!\n";
                        echo $message;
                        continue;
                    }
                    $message = "                Updated {$rsUpdateResult} incomplete row.\n";
                    echo $message;
                }
                if (defined('DEBUG_ONLY')) {
                    sleep(1);
                }
            }
        }
    }

}

?>