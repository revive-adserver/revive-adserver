<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';

require_once MAX_PATH . '/lib/OA.php';
require_once 'Date.php';

/**
 * The Data Abstraction Layer (DAL) class for obtaining statistics for
 * display in the UI, for cases where the statistcs are too complicated
 * to be obtained via the appropriate DB_DataObject.
 *
 * @package    OpenadsDal
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Dal_Statistics extends OA_Dal
{

    /**
     * A method for obtaining the information required for the placement overview level
     * targeting statistics screen.
     *
     * @param integer    $placementId The placement ID.
     * @param PEAR::Date $oStartDate  The start date of the range required.
     * @param PEAR::Date $oEndDate    The end date the range required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     * array(
     *     ['2007-04-20'] => array(
     *                          ['placement_required_impressions']  => integer
     *                          ['placement_requested_impressions'] => integer
     *                          ['placement_actual_impressions']    => integer
     *                          ['zones_forecast_impressions']      => integer
     *                          ['zones_actual_impressions']        => integer
     *                       )
     *          .
     *          .
     *          .
     * )
     *
     * For the placement and date range specified, returns an array for each day
     * in the date range, consisting of the total number of impressions requested
     * by all ads in the placement (for all zones the ads are linked to), as well
     * as the total number of impressions actually delivered by all ads in the
     * placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getPlacementOverviewTargetingStatistics($placementId, $oStartDate, $oEndDate)
    {
        // Ensure the parameters are valid
        if (empty($placementId) || !is_int($placementId)) {
            return false;
        }
        if (empty($oStartDate) || !is_a($oStartDate, 'Date')) {
            return false;
        }
        if (empty($oEndDate) || !is_a($oEndDate, 'Date')) {
            return false;
        }
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Get all ads in the placement
        $aAdIds = array();
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->find();
        while ($doBanners->fetch()) {
            $aAdIds[] = (int) $doBanners->bannerid;
        }
        if (empty($aAdIds)) {
            return false;
        }
        // Prepare the temporary results array
        $aResult = array();
        // How many days in the span?
        $oStartDateCopy = new Date();
        $oStartDateCopy->copy($oStartDate);
        $oStartDateCopy->setHour(0);
        $oStartDateCopy->setMinute(0);
        $oStartDateCopy->setSecond(0);
        $oEndDateCopy = new Date();
        $oEndDateCopy->copy($oEndDate);
        $oEndDateCopy->setHour(0);
        $oEndDateCopy->setMinute(0);
        $oEndDateCopy->setSecond(0);
        $oSpan = new Date_Span();
        $oSpan->setFromDateDiff($oStartDateCopy, $oEndDateCopy);
        $days = $oSpan->toDays();
        for ($counter = 0; $counter <= $days; $counter++) {
            $aTemp = $this->getPlacementDailyTargetingStatistics($placementId, $oStartDateCopy);
            $aResult[$oStartDateCopy->format('%Y-%m-%d')] = $this->_getPlacementOverviewTargetingStatistics($aTemp);
            $oStartDateCopy->addSeconds(SECONDS_PER_DAY);
        }
        return $aResult;
    }

    /**
     * A private method to sum the operatin interval level results from the
     * getPlacementDailyTargetingStatistics() method in order to obtain the
     * information required for one day of the the placement overview level
     * targeting statistics screen.
     *
     * @access private
     * @param array $aValues An array of the output from the
     *                       getPlacementDailyTargetingStatistics() method.
     *
     * @return mixed Returns false in the event of incorrect input, otherwise,
     *               returns an array:
     * array(
     *    ['placement_required_impressions']  => integer
     *    ['placement_requested_impressions'] => integer
     *    ['placement_actual_impressions']    => integer
     *    ['zones_forecast_impressions']      => integer
     *    ['zones_actual_impressions']        => integer
     * )
     *
     * For the placement and date range specified, returns an array for each day
     * in the date range, consisting of the total number of impressions requested
     * by all ads in the placement (for all zones the ads are linked to), as well
     * as the total number of impressions actually delivered by all ads in the
     * placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function _getPlacementOverviewTargetingStatistics($aValues)
    {
        // Ensure the parameters are valid
        if (!is_array($aValues) || empty($aValues)) {
            return false;
        }
        reset($aValues);
        while (list(,$aValue) = each($aValues)) {
            if (!is_array($aValue) || empty($aValue) || count($aValue) != 7) {
                return false;
            }
        }
        // Sum the values
        $aResult = array(
            'placement_required_impressions'  => 0,
            'placement_requested_impressions' => 0,
            'placement_actual_impressions'    => 0,
            'zones_forecast_impressions'      => 0,
            'zones_actual_impressions'        => 0
        );
        reset($aValues);
        while (list(,$aValue) = each($aValues)) {
            $aResult['placement_required_impressions']  += $aValue['placement_required_impressions'];
            $aResult['placement_requested_impressions'] += $aValue['placement_requested_impressions'];
            $aResult['placement_actual_impressions']    += $aValue['placement_actual_impressions'];
            $aResult['zones_forecast_impressions']      += $aValue['zones_forecast_impressions'];
            $aResult['zones_actual_impressions']        += $aValue['zones_actual_impressions'];
        }
        return $aResult;
    }

    /**
     * A method for obtaining the information required for the placement daily level
     * targeting statistics screen.
     *
     * @param integer    $placementId The placement ID.
     * @param PEAR::Date $oDate       A date representing the day required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     * array(
     *     [$operationIntervalId] => array(
     *                                  ['interval_start']                  => PEAR::Date
     *                                  ['interval_end']                    => PEAR::Date
     *                                  ['placement_required_impressions']  => integer
     *                                  ['placement_requested_impressions'] => integer
     *                                  ['placement_actual_impressions']    => integer
     *                                  ['zones_forecast_impressions']      => integer
     *                                  ['zones_actual_impressions']        => integer
     *                               )
     *      .
     *      .
     *      .
     * )
     *
     * For the placement and day specified, returns an array for each operation
     * interval in the day, consisting of the operation interval start and end
     * dates, and the total number of impressions requested by all ads in the
     * placement (for all zones the ads are linked to), as well as the total
     * number of impressions actually delivered by all ads in the placement
     * (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getPlacementDailyTargetingStatistics($placementId, $oDate)
    {
        // Ensure the parameters are valid
        if (empty($placementId) || !is_int($placementId)) {
            return false;
        }
        if (empty($oDate) || !is_a($oDate, 'Date')) {
            return false;
        }
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Get all ads in the placement
        $aAdIds = array();
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->find();
        while ($doBanners->fetch()) {
            $aAdIds[] = (int) $doBanners->bannerid;
        }
        if (empty($aAdIds)) {
            return false;
        }
        // Prepare the results array
        $aResult = array();
        // Get a date for the start of the day
        $oStartDate = new Date();
        $oStartDate->copy($oDate);
        $oStartDate->setHour(0);
        $oStartDate->setMinute(0);
        $oStartDate->setSecond(0);
        // Get a date for the end of the day
        $oEndOfDayDate = new Date();
        $oEndOfDayDate->copy($oDate);
        $oEndOfDayDate->setHour(23);
        $oEndOfDayDate->setMinute(59);
        $oEndOfDayDate->setSecond(59);
        // Get the first operation interval of the day
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
        // Get dates to be used in date comparisons
        $oCompareDate = new Date();
        $oCompareDate->copy($aDates['start']);
        $oCompareEndDate = new Date();
        $oCompareEndDate->copy($oEndOfDayDate);
        while ($oCompareDate->before($oEndOfDayDate)) {
            // Get the operation interval ID
            $operationIntervalId = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
            // Get the results for this operation interval
            $aResult[$operationIntervalId] = $this->_getPlacementDailyTargetingStatistics($aAdIds, $aDates['start'], $aDates['end']);
            if ($aResult[$operationIntervalId] === false) {
                return false;
            }
            // Get the next operation interval dates
            $aDates = MAX_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($aDates['start']);
            // Update the comparison dates
            $oCompareDate = new Date();
            $oCompareDate->copy($aDates['start']);
            $oCompareEndDate = new Date();
            $oCompareEndDate->copy($oEndOfDayDate);
        }
        return $aResult;
    }

    /**
     * A private method for obtaining the information required for one operation interval
     * of the placement daily level targeting statistics screen.
     *
     * @access private
     * @param array      $aAdIds     An array of ad IDs.
     * @param PEAR::Date $oStartDate The start date of the operation interval.
     * @param PEAR::Date $oEndDate   The end date of the operation interval.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array:
     * array(
     *      ['interval_start']                  => PEAR::Date
     *      ['interval_end']                    => PEAR::Date
     *      ['placement_required_impressions']  => integer
     *      ['placement_requested_impressions'] => integer
     *      ['placement_actual_impressions']    => integer
     *      ['zones_forecast_impressions']      => integer
     *      ['zones_actual_impressions']        => integer
     *  )
     *
     * For the placement and operation interval specified, returns an array,
     * consisting of the operation interval start and end dates, and the total
     * number of impressions requested by all ads in the placement (for all
     * zones the ads are linked to), as well as the total number of impressions
     * actually delivered by all ads in the placement (for all zones the ads
     * are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function _getPlacementDailyTargetingStatistics($aAdIds, $oStartDate, $oEndDate)
    {
        // Ensure the parameters are valid
        if (!is_array($aAdIds) || empty($aAdIds)) {
            return false;
        }
        reset($aAdIds);
        while (list(,$adId) = each($aAdIds)) {
            if (!is_int($adId)) {
                return false;
            }
        }
        if (empty($oStartDate) || !is_a($oStartDate, 'Date')) {
            return false;
        }
        if (empty($oEndDate) || !is_a($oEndDate, 'Date')) {
            return false;
        }
        // Ensure that the date range specified is indeed an operation interval
        if (!MAX_OperationInterval::checkIntervalDates($oStartDate, $oEndDate)) {
            return false;
        }
        // Obtain the placement level targeting statistcs for this operation interval
        $aResult = array(
            'interval_start'                  => $oStartDate,
            'interval_end'                    => $oEndDate,
            'placement_required_impressions'  => 0,
            'placement_requested_impressions' => 0,
            'placement_actual_impressions'    => 0,
            'zones_forecast_impressions'      => 0,
            'zones_actual_impressions'        => 0
        );
        $aZoneIds = array();
        reset($aAdIds);
        while (list(,$adId) = each($aAdIds)) {
            $aAdStats = $this->getAdTargetingStatistics($adId, $oStartDate, $oEndDate);
            if ($aAdStats === false) {
                return $false;
            }
            reset($aAdStats);
            while (list($zoneId,$aValues) = each($aAdStats)) {
                $aResult['placement_required_impressions']  += $aValues['ad_required_impressions'];
                $aResult['placement_requested_impressions'] += $aValues['ad_requested_impressions'];
                $aResult['placement_actual_impressions']    += $aValues['ad_actual_impressions'];
                if (!in_array($zoneId, $aZoneIds)) {
                    $aZoneIds[] = $zoneId;
                    $aResult['zones_forecast_impressions']      += $aValues['zone_forecast_impressions'];
                    $aResult['zones_actual_impressions']        += $aValues['zone_actual_impressions'];
                }
            }
        }
        return $aResult;
    }

    /**
     * A method for obtaining the information required for the ad view targeting
     * statistics screen.
     *
     * @param integer    $adId       The ad ID.
     * @param PEAR::Date $oStartDate The start date of the operation interval.
     * @param PEAR::Date $oEndDate   The end date of the operation interval.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     * array(
     *     [$zoneId] => array(
     *                    ['interval_start']                => PEAR::Date
     *                    ['interval_end']                  => PEAR::Date
     *                    ['ad_required_impressions']       => integer
     *                    ['ad_requested_impressions']      => integer
     *                    ['ad_priority']                   => double
     *                    ['ad_priority_factor']            => double
     *                    ['ad_priority_factor_limited']    => integer
     *                    ['ad_past_zone_traffic_fraction'] => double
     *                    ['ad_actual_impressions']         => integer
     *                    ['zone_forecast_impressions']     => integer
     *                    ['zone_actual_impressions']       => integer
     *                  )
     *         .
     *         .
     *         .
     * )
     *
     * For the operation interval specified by the start end end dates, the method
     * should return the impressions requested, priority, priority factor and
     * actual impressions delivered for each possible zone the ad was linked to.
     * This requires searching the data_intermediate_ad table for the zones the ad
     * delivered in, to get the number of acutal impressions, and also searching the
     * data_summary_ad_zone_assoc table for the zones the ad was targeted to deliver
     * in.
     *
     * The impressions requested, priority and priority factor may need to be
     * calculated as an "averge" value, in the event that there are multiple, differing
     * values for the ad in a zone, in much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo().
     */
    function getAdTargetingStatistics($adId, $oStartDate, $oEndDate)
    {
        if (!$this->_testParameters($adId, $oStartDate, $oEndDate)) {
            return false;
        }
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Extract the required data for the operation interval
        $query = "
            SELECT
                dsaza.interval_start AS interval_start,
                dsaza.interval_end AS interval_end,
                dsaza.zone_id AS zone_id,
                dsaza.required_impressions AS ad_required_impressions,
                dsaza.requested_impressions AS ad_requested_impressions,
                dsaza.priority AS ad_priority,
                dsaza.priority_factor AS ad_priority_factor,
                dsaza.priority_factor_limited AS ad_priority_factor_limited,
                dsaza.past_zone_traffic_fraction AS ad_past_zone_traffic_fraction,
                dsaza.created AS created,
                dsaza.expired AS expired,
                dia.impressions AS ad_actual_impressions,
                dszih.forecast_impressions AS zone_forecast_impressions,
                dszih.actual_impressions AS zone_actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']} AS dsaza
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad']} AS dia
            ON
                dsaza.operation_interval = dia.operation_interval
                AND
                dsaza.interval_start = dia.interval_start
                AND
                dsaza.interval_end = dia.interval_end
                AND
                dsaza.ad_id = dia.ad_id
                AND
                dsaza.zone_id = dia.zone_id
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']} AS dszih
            ON
                dsaza.operation_interval = dszih.operation_interval
                AND
                dsaza.interval_start = dszih.interval_start
                AND
                dsaza.interval_end = dszih.interval_end
                AND
                dsaza.zone_id = dszih.zone_id
            WHERE
                dsaza.operation_interval = {$aConf['maintenance']['operationInterval']}
                AND
                dsaza.interval_start = '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                dsaza.interval_end = '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                dsaza.ad_id = $adId
                AND
                dsaza.required_impressions > 0
            ORDER BY
                dsaza.ad_id";
        $message = "Getting the targeting statistcs for ad ID $adId for OI starting " .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S');
        OA::debug($message, PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            $message = "Error getting the targeting statistcs for ad ID $adId for OI starting " .
                       $oStartDate->format('%Y-%m-%d %H:%M:%S');
            return false;
        }
        $averagesExist = false;
        $aResult = array();
        $aAverageValues = array();
        while ($aRow = $rc->fetchRow()) {
            $zoneId = $aRow['zone_id'];
            unset($aRow['zone_id']);
            $aRow['interval_start'] = new Date($aRow['interval_start']);
            $aRow['interval_end']   = new Date($aRow['interval_end']);
            if (!isset($aResult[$zoneId])) {
                // First time this value has been seen, so okay to set it
                $aResult[$zoneId] = $aRow;
            } else {
                if ($aResult[$zoneId] != 'average') {
                    // Store the old value
                    $aAverageValues[$zoneId][] = $aResult[$zoneId];
                }
                // Store this value as part of an average value
                $averagesExist = true;
                $aResult[$zoneId] = 'average';
                $aAverageValues[$zoneId][] = $aRow;
            }
        }
        // Do average values need to be calculated?
        reset($aResult);
        while (list($zoneId, $value) = each($aResult)) {
            if ($averagesExist) {
                if ($value == 'average') {
                    // Calculate the average values for this ad
                    $aResult[$zoneId] = $this->_calculateAverages($aAverageValues[$zoneId], $oEndDate);
                }
            } else {
                unset($aResult[$zoneId]['created']);
                unset($aResult[$zoneId]['expired']);
            }
        }
        return $aResult;
    }

    /**
     * A method for obtaining the information required for the zone view targeting
     * statistics screen.
     *
     * @param integer    $zoneId     The zone ID.
     * @param PEAR::Date $oStartDate The start date of the operation interval.
     * @param PEAR::Date $oEndDate   The end date of the operation interval.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     * array(
     *     [$adId] => array(
     *                    ['interval_start']                => PEAR::Date
     *                    ['interval_end']                  => PEAR::Date
     *                    ['ad_required_impressions']       => integer
     *                    ['ad_requested_impressions']      => integer
     *                    ['ad_priority']                   => double
     *                    ['ad_priority_factor']            => double
     *                    ['ad_priority_factor_limited']    => integer
     *                    ['ad_past_zone_traffic_fraction'] => double
     *                    ['ad_actual_impressions']         => integer
     *                    ['zone_forecast_impressions']     => integer
     *                    ['zone_actual_impressions']       => integer
     *                )
     *        .
     *        .
     *        .
     * )
     *
     * For the operation interval specified by the start end end dates, the method
     * should return the impressions requested, priority, priority factor and
     * actual impressions delivered for each possible ad that was linked to the
     * specified zone. This requires searching the data_intermediate_ad table for
     * the ads which delivered in the zone, to get the number of acutal impressions,
     * and also searching the data_summary_ad_zone_assoc table for the ads which were
     * targeted to deliver in the zone.
     *
     * The impressions requested, priority and priority factor may need to be
     * calculated as an "averge" value, in the event that there are multiple, differing
     * values for the ad in a zone, in much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo().
     */
    function getZoneTargetingStatistics($zoneId, $oStartDate, $oEndDate)
    {
        if (!$this->_testParameters($zoneId, $oStartDate, $oEndDate)) {
            return false;
        }
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Extract the required data for the operation interval
        $query = "
            SELECT
                dsaza.interval_start AS interval_start,
                dsaza.interval_end AS interval_end,
                dsaza.ad_id AS ad_id,
                dsaza.required_impressions AS ad_required_impressions,
                dsaza.requested_impressions AS ad_requested_impressions,
                dsaza.priority AS ad_priority,
                dsaza.priority_factor AS ad_priority_factor,
                dsaza.priority_factor_limited AS ad_priority_factor_limited,
                dsaza.past_zone_traffic_fraction AS ad_past_zone_traffic_fraction,
                dsaza.created AS created,
                dsaza.expired AS expired,
                dia.impressions AS ad_actual_impressions,
                dszih.forecast_impressions AS zone_forecast_impressions,
                dszih.actual_impressions AS zone_actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_zone_assoc']} AS dsaza
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad']} AS dia
            ON
                dsaza.operation_interval = dia.operation_interval
                AND
                dsaza.interval_start = dia.interval_start
                AND
                dsaza.interval_end = dia.interval_end
                AND
                dsaza.ad_id = dia.ad_id
                AND
                dsaza.zone_id = dia.zone_id
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_zone_impression_history']} AS dszih
            ON
                dsaza.operation_interval = dszih.operation_interval
                AND
                dsaza.interval_start = dszih.interval_start
                AND
                dsaza.interval_end = dszih.interval_end
                AND
                dsaza.zone_id = dszih.zone_id
            WHERE
                dsaza.operation_interval = {$aConf['maintenance']['operationInterval']}
                AND
                dsaza.interval_start = '" . $oStartDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                dsaza.interval_end = '" . $oEndDate->format('%Y-%m-%d %H:%M:%S') . "'
                AND
                dsaza.zone_id = $zoneId
                AND
                dsaza.required_impressions > 0
            ORDER BY
                dsaza.ad_id";
        $message = "Getting the targeting statistcs for zone ID $zoneId for OI starting " .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S');
        OA::debug($message, PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            $message = "Error getting the targeting statistcs for zone ID $zoneId for OI starting " .
                       $oStartDate->format('%Y-%m-%d %H:%M:%S');
            return false;
        }
        $averagesExist = false;
        $aResult = array();
        $aAverageValues = array();
        while ($aRow = $rc->fetchRow()) {
            $adId = $aRow['ad_id'];
            unset($aRow['ad_id']);
            $aRow['interval_start'] = new Date($aRow['interval_start']);
            $aRow['interval_end']   = new Date($aRow['interval_end']);
            if (!isset($aResult[$adId])) {
                // First time this value has been seen, so okay to set it
                $aResult[$adId] = $aRow;
            } else {
                if ($aResult[$adId] != 'average') {
                    // Store the old value
                    $aAverageValues[$adId][] = $aResult[$adId];
                }
                // Store this value as part of an average value
                $averagesExist = true;
                $aResult[$adId] = 'average';
                $aAverageValues[$adId][] = $aRow;
            }
        }
        // Do average values need to be calculated?
        reset($aResult);
        while (list($adId, $value) = each($aResult)) {
            if ($averagesExist) {
                if ($value == 'average') {
                    // Calculate the average values for this ad
                    $aResult[$adId] = $this->_calculateAverages($aAverageValues[$adId], $oEndDate);
                }
            } else {
                unset($aResult[$adId]['created']);
                unset($aResult[$adId]['expired']);
            }
        }
        return $aResult;
    }

    /**
     * A private method to test the parameters of the getAdTargetingStatistics()
     * and getZoneTargetingStatistics methods.
     *
     * @param integer    $id         The ad or zone ID.
     * @param PEAR::Date $oStartDate The start date of the operation interval.
     * @param PEAR::Date $oEndDate   The end date of the operation interval.
     * @return boolean True if the parameters are okay, false otherwise.
     */
    function _testParameters($id, $oStartDate, $oEndDate)
    {
        // Ensure the parameters are valid
        if (empty($id) || !is_int($id)) {
            return false;
        }
        if (empty($oStartDate) || !is_a($oStartDate, 'Date')) {
            return false;
        }
        if (empty($oEndDate) || !is_a($oEndDate, 'Date')) {
            return false;
        }
        // Ensure that the date range specified is indeed an operation interval
        if (!MAX_OperationInterval::checkIntervalDates($oStartDate, $oEndDate)) {
            return false;
        }
        return true;
    }

    function _calculateAverages($aValues, $oEndDate)
    {
        if (!is_array($aValues) || empty($aValues)) {
            return array();
        }
        $counter = 0;
        $totalSeconds = 0;
        $aResult = array(
            'ad_required_impressions'       => 0,
            'ad_requested_impressions'      => 0,
            'ad_priority'                   => 0,
            'ad_priority_factor'            => 0,
            'ad_priority_factor_limited'    => 0,
            'ad_past_zone_traffic_fraction' => 0
        );
        reset($aValues);
        while (list(,$aAdValues) = each($aValues)) {
            if ($counter == 0) {
                $aResult['interval_start']            = $aAdValues['interval_start'];
                $aResult['interval_end']              = $aAdValues['interval_end'];
                $aResult['ad_actual_impressions']     = $aAdValues['ad_actual_impressions'];
                $aResult['zone_forecast_impressions'] = $aAdValues['zone_forecast_impressions'];
                $aResult['zone_actual_impressions']   = $aAdValues['zone_actual_impressions'];
            }
            $oCreatedDate = new Date($aAdValues['created']);
            if (is_null($aAdValues['expired'])) {
                $oExpiredDate = new Date();
                $oExpiredDate->copy($oEndDate);
            } else {
                $oExpiredDate = new Date($aAdValues['expired']);
            }
            $oSpan = new Date_Span();
            $oSpan->setFromDateDiff($oCreatedDate, $oExpiredDate);
            $seconds = $oSpan->toSeconds();
            $aResult['ad_required_impressions']       += $aAdValues['ad_required_impressions']       * $seconds;
            $aResult['ad_requested_impressions']      += $aAdValues['ad_requested_impressions']      * $seconds;
            $aResult['ad_priority']                   += $aAdValues['ad_priority']                   * $seconds;
            $aResult['ad_priority_factor']            += $aAdValues['ad_priority_factor']            * $seconds;
            $aResult['ad_past_zone_traffic_fraction'] += $aAdValues['ad_past_zone_traffic_fraction'] * $seconds;
            if ($aAdValues['ad_priority_factor_limited'] == 1) {
                $aResult['ad_priority_factor_limited'] = 1;
            }
            $counter++;
            $totalSeconds += $seconds;
        }
        $aResult['ad_required_impressions']       /= $totalSeconds;
        $aResult['ad_requested_impressions']      /= $totalSeconds;
        $aResult['ad_priority']                   /= $totalSeconds;
        $aResult['ad_priority_factor']            /= $totalSeconds;
        $aResult['ad_past_zone_traffic_fraction'] /= $totalSeconds;
        return $aResult;
    }

}

?>