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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * The non-DB specific Common Data Access Layer (DAL) class for obtaining
 * statistics data from the database.
 *
 * @package    MaxDal
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Dal_Statistics extends MAX_Dal_Common
{

    /**
     * The constructor method.
     *
     * @return MAX_Dal_Statistics
     */
    function MAX_Dal_Statistics()
    {
        parent::MAX_Dal_Common();
    }

    /**
     * A method to determine the day/hour that a placement first became active,
     * based on the first record of its children ads delivering.
     *
     * @param integer $placementId The placement ID.
     * @return mixed PEAR:Error on database error, null on no result, or a
     *               PEAR::Date object representing the time the placement started
     *               delivery, or, if not yet active, the current date/time.
     */
    function getPlacementFirstStatsDate($placementId)
    {
        // Test the input values
        if (!is_numeric($placementId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $adTable = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['banners'],true);
        $dsahTable = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'],true);
        $query = "
            SELECT
                DATE_FORMAT(dsah.date_time, '%Y-%m-%d') AS day,
                HOUR(dsah.date_time) AS hour
            FROM
                $adTable AS a,
                $dsahTable AS dsah
            WHERE
                a.campaignid = ". $this->oDbh->quote($placementId, 'integer') ."
                AND
                a.bannerid = dsah.ad_id
            ORDER BY
                day ASC, hour ASC
            LIMIT 1";
        $message = "Finding start date of placement ID $placementId based on delivery statistics.";
        OA::debug($message, PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return $rc;
        }
        // Was a result found?
        if ($rc->numRows() == 0) {
            // Return the current time
            $oDate = new Date();
        } else {
            // Store the results
            $aRow = $rc->fetchRow();
            $oDate = new Date($aRow['day'] . ' ' . $aRow['hour'] . ':00:00');
        }
        return $oDate;
    }

    /**
     * A method to obtain the daily forecast inventory (impressions) for a
     * channel and a group of zones, over a given period.
     *
     * @param integer $channelId A channel ID.
     * @param array $aZoneIds An array of zone IDs.
     * @param array $aPeriod An array of PEAR::Date objects, indexed
     *                       by 'start' and 'end', giving the start
     *                       and end dates of the period, inclusive.
     * @param boolean $hack When false, the method returns the correct
     *                      values, when true, returns values based on
     *                      ACTUAL values, instead of forecast. Optional.
     * @return mixed PEAR:Error on database error, null on no records
     *               found or an array of arrays of arrays, containing
     *               the channel/zone forecast inventory (impression)
     *               values, indexed by zone ID, then day. For example:
     *                  array(
     *                      5 => array(
     *                              '2006-10-17' => 49,
     *                              '2006-10-18' => 59
     *                           ),
     *                      8 => array(
     *                              '2006-10-17' => 490,
     *                              '2006-10-18' => null
     *                           )
     *                  )
     *               Values will only be returned in the event that
     *               ['maintenance']['channelForecasting'] is set to
     *               true in the configuration file.
     *
     *               Note that if any day(s) in the period required do not
     *               have valid forecast values, then the method will return
     *               the most recent forecast value for the channel/zone
     *               matching the day of the week of the day(s) not found,
     *               if possible - otherwise a null value for the forecast
     *               values that could not be found will set.
     */
    function getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod, $hack = false)
    {
        // Test to see if anything needs to be done
        $conf = $GLOBALS['_MAX']['CONF'];
        if ($conf['maintenance']['channelForecasting'] != true) {
            return null;
        }
        // Test the input values
        if (!is_numeric($channelId)) {
            return null;
        }
        if (!is_array($aZoneIds)) {
            return null;
        }
        reset($aZoneIds);
        while (list($key, $zoneId) = each($aZoneIds)) {
            if (!is_numeric($zoneId)) {
                return null;
            }
        }
        if (!is_array($aPeriod) || !is_a($aPeriod['start'], 'Date') || !is_a($aPeriod['end'], 'Date')) {
            return null;
        }
        // Get the required data
        $table = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_summary_channel_daily'],true);
        if ($hack) {
            $columnName = 'actual_impressions';
        } else {
            $columnName = 'forecast_impressions';
        }
        $query = "
            SELECT
                zone_id AS zone_id,
                day AS day,
                SUM($columnName) AS forecast_impressions
            FROM
                $table
            WHERE
                channel_id = $channelId
                AND
                zone_id IN (" . $this->oDbh->escape(implode(', ', $aZoneIds)) . ")
                AND
                day >= ". $this->oDbh->quote($aPeriod['start']->format('%Y-%m-%d'), 'date') . "
                AND
                day <= ". $this->oDbh->quote($aPeriod['end']->format('%Y-%m-%d'), 'date') . "
            GROUP BY
                zone_id, day";
        $message = 'Finding all channel/zone forecast inventory data for channel ID ' . $channelId .
                   ' and zone IDs in ' . implode(', ', $aZoneIds) . ' in the period ' .
                   $aPeriod['start']->format('%Y-%m-%d') . ' to ' . $aPeriod['end']->format('%Y-%m-%d');
        OA::debug($message, PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return $rc;
        }
        // Store the results
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            if (!is_null($aRow['forecast_impressions'])) {
                $aResult[$aRow['zone_id']][$aRow['day']] = $aRow['forecast_impressions'];
            }
        }
        // Are any days missing data?
        $aMissingData = array();
        reset($aZoneIds);
        while (list($key, $zoneId) = each($aZoneIds)) {
            $oDate = new Date();
            $oDate->copy($aPeriod['start']);
            while (!$oDate->after($aPeriod['end'])) {
                if (is_null($aResult[$zoneId][$oDate->format('%Y-%m-%d')])) {
                    $aMissingData[$zoneId][$oDate->format('%Y-%m-%d')] = true;
                }
                $oDate->addSeconds(SECONDS_PER_DAY);
            }
        }
        if (!empty($aMissingData)) {
            // For each zone/channel that has missing data, obtain the 7 most
            // recent distinct days where forecast data exists; This might not
            // cover all the required missing data in cases where, for example,
            // a single day's forecast is missing, but under normal conditions
            // this will be fine
            reset($aMissingData);
            while (list($zoneId, $aMissingDays) = each($aMissingData)) {
                $query = "
                    SELECT
                        DISTINCT(day) AS day,
                        $columnName AS forecast_impressions
                    FROM
                        $table
                    WHERE
                        channel_id = ". $this->oDbh->quote($channelId, 'integer') ."
                        AND
                        zone_id = ". $this->oDbh->quote($zoneId, 'integer') ."
                    ORDER BY
                        day DESC
                    LIMIT 7";
                $message = 'Finding the seven most recent days of channel/zone forecast inventory data ' .
                            ' for channel ID ' . $channelId . ' and zone ID ' . $zoneId;
                OA::debug($message, PEAR_LOG_DEBUG);
                $rc = $this->oDbh->query($query);
                if (PEAR::isError($rc)) {
                    return $rc;
                }
                // Prepare an array of the forecast values found, indexed by day
                // of the week
                $aDaysFound = array();
                while ($aRow = $rc->fetchRow()) {
                    if (!is_null($aRow['day']) && !is_null($aRow['forecast_impressions'])) {
                        $oDate = new Date($aRow['day']);
                        $dayOfWeek = $oDate->getDayOfWeek();
                        $aDaysFound[$dayOfWeek] = $aRow[forecast_impressions];
                    }
                }
                // Store this data, where appropriate, in place of the missing values
                reset($aMissingDays);
                while (list($day, $trueMarker) = each($aMissingDays)) {
                    $oDate = new Date($day);
                    $dayOfWeek = $oDate->getDayOfWeek();
                    $aResult[$zoneId][$day] = is_null($aDaysFound[$dayOfWeek]) ? 0 : $aDaysFound[$dayOfWeek];
                }
            }
        }
        // Return the final result
        return $aResult;
    }

    /**
     * A method to get the recent average zone operation interval forecasts,
     * (impressions) taken from over the most recent week's worth of
     * operation intervals, for a given list of zone IDs.
     *
     * @param array $aZoneIds An array of zone IDs.
     * @return mixed PEAR:Error on database error, null on no records
     *               found or an array of average operation interval forecasts
     *               found, indexed by zone ID. For example:
     *                  array(
     *                      12 => 500
     *                  )
     *               Values will only be returned in the event that
     *               ['maintenance']['channelForecasting'] is set to
     *               true in the configuration file.
     */
    function getRecentAverageZoneForecastByZoneIds($aZoneIds)
    {
        // Test to see if anything needs to be done
        $conf = $GLOBALS['_MAX']['CONF'];
        if ($conf['maintenance']['channelForecasting'] != true) {
            return null;
        }
        // Test the input values
        if (!is_array($aZoneIds)) {
            return null;
        }
        reset($aZoneIds);
        while (list($key, $zoneId) = each($aZoneIds)) {
            if (!is_numeric($zoneId)) {
                return null;
            }
        }
        // Get the required data
        $table = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_summary_zone_impression_history'],true);
        $aResult = array();
        reset($aZoneIds);
        while (list($key, $zoneId) = each($aZoneIds)) {
            $query = "
                SELECT
                    SUM(forecast_impressions) / COUNT(forecast_impressions) AS impressions
                FROM
                    $table
                WHERE
                    zone_id = ". $this->oDbh->quote($zoneId, 'integer') ."
                LIMIT
                    " . OA_OperationInterval::operationIntervalsPerWeek();
            $rc = $this->oDbh->query($query);
            if (PEAR::isError($rc)) {
                return $rc;
            }
            while ($aRow = $rc->fetchRow()) {
                if (!is_null($aRow['impressions'])) {
                    $aResult[$zoneId] = $aRow['impressions'];
                }
            }
        }
        if (empty($aResult)) {
            return null;
        }
        return $aResult;
    }

}