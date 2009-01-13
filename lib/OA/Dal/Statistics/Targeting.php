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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';

require_once OX_PATH . '/lib/OX.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * The Data Abstraction Layer (DAL) class for obtaining statistics for
 * display in the UI, for cases where the statistcs are too complicated
 * to be obtained via the appropriate DB_DataObject.
 *
 * @package    OpenXDal
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Dal_Statistics_Targeting extends OA_Dal
{

    /**
     * A method for obtaining the targeting statistics of an ad or placement
     * for a date span, where the data is summarised by day.
     *
     * @param integer    $id         The ad or placement ID.
     * @param string     $type       Either "ad" or "placement".
     * @param PEAR::Date $oStartDate The start date of the range required.
     * @param PEAR::Date $oEndDate   The end date the range required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     *
     * array(
     *     ['2007-04-20'] => array(
     *                          ['ad_required_impressions']         => integer
     *                          ['ad_requested_impressions']        => integer
     *                          ['ad_actual_impressions']           => integer
     *                          ['zones_forecast_impressions']      => integer
     *                          ['zones_actual_impressions']        => integer
     *                          ['average']                         => boolean
     *                       )
     *          .
     *          .
     *          .
     * )
     *
     * or:
     *
     * array(
     *     ['2007-04-20'] => array(
     *                          ['placement_required_impressions']  => integer
     *                          ['placement_requested_impressions'] => integer
     *                          ['placement_actual_impressions']    => integer
     *                          ['zones_forecast_impressions']      => integer
     *                          ['zones_actual_impressions']        => integer
     *                          ['average']                         => boolean
     *                       )
     *          .
     *          .
     *          .
     * )
     *
     * For the ad, or placement and date range specified, returns an array for each
     * day in the date range, consisting of the total number of impressions requested
     * by the ad, or all ads in the placement (for all zones the ads are linked to),
     * as well as the total number of impressions actually delivered by the ad, or
     * all ads in the placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getTargetingStatisticsSpanByDay($id, $type, $oStartDate, $oEndDate)
    {
        return $this->_getTargetingStatisticsSpan($id, $type, $oStartDate, $oEndDate, 'day');
    }

    /**
     * A method for obtaining the targeting statistics of an ad or placement
     * for a date span, where the data is summarised by week.
     *
     * @param integer    $id         The ad or placement ID.
     * @param string     $type       Either "ad" or "placement".
     * @param PEAR::Date $oStartDate The start date of the range required.
     * @param PEAR::Date $oEndDate   The end date the range required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     *
     * array(
     *     ['2007-50'] => array(
     *                       ['ad_required_impressions']         => integer
     *                       ['ad_requested_impressions']        => integer
     *                       ['ad_actual_impressions']           => integer
     *                       ['zones_forecast_impressions']      => integer
     *                       ['zones_actual_impressions']        => integer
     *                       ['average']                         => boolean
     *                    )
     *          .
     *          .
     *          .
     * )
     *
     * or:
     *
     * array(
     *     ['2007-50'] => array(
     *                       ['placement_required_impressions']  => integer
     *                       ['placement_requested_impressions'] => integer
     *                       ['placement_actual_impressions']    => integer
     *                       ['zones_forecast_impressions']      => integer
     *                       ['zones_actual_impressions']        => integer
     *                       ['average']                         => boolean
     *                    )
     *          .
     *          .
     *          .
     * )
     *
     * For the ad, or placement and date range specified, returns an array for each
     * week in the date range, consisting of the total number of impressions requested
     * by the ad, or all ads in the placement (for all zones the ads are linked to),
     * as well as the total number of impressions actually delivered by the ad, or
     * all ads in the placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getTargetingStatisticsSpanByWeek($id, $type, $oStartDate, $oEndDate)
    {
        return $this->_getTargetingStatisticsSpan($id, $type, $oStartDate, $oEndDate, 'week');
    }

    /**
     * A method for obtaining the targeting statistics of an ad or placement
     * for a date span, where the data is summarised by month.
     *
     * @param integer    $id         The ad or placement ID.
     * @param string     $type       Either "ad" or "placement".
     * @param PEAR::Date $oStartDate The start date of the range required.
     * @param PEAR::Date $oEndDate   The end date the range required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     *
     * array(
     *     ['2007-04'] => array(
     *                       ['ad_required_impressions']         => integer
     *                       ['ad_requested_impressions']        => integer
     *                       ['ad_actual_impressions']           => integer
     *                       ['zones_forecast_impressions']      => integer
     *                       ['zones_actual_impressions']        => integer
     *                       ['average']                         => boolean
     *                    )
     *          .
     *          .
     *          .
     * )
     *
     * or:
     *
     * array(
     *     ['2007-04'] => array(
     *                       ['placement_required_impressions']  => integer
     *                       ['placement_requested_impressions'] => integer
     *                       ['placement_actual_impressions']    => integer
     *                       ['zones_forecast_impressions']      => integer
     *                       ['zones_actual_impressions']        => integer
     *                       ['average']                         => boolean
     *                    )
     *          .
     *          .
     *          .
     * )
     *
     * For the ad, or placement and date range specified, returns an array for each
     * month in the date range, consisting of the total number of impressions requested
     * by the ad, or all ads in the placement (for all zones the ads are linked to),
     * as well as the total number of impressions actually delivered by the ad, or
     * all ads in the placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getTargetingStatisticsSpanByMonth($id, $type, $oStartDate, $oEndDate)
    {
        return $this->_getTargetingStatisticsSpan($id, $type, $oStartDate, $oEndDate, 'month');
    }

    /**
     * A method for obtaining the targeting statistics of an ad or placement
     * for a date span, where the data is summarised by day of week.
     *
     * @param integer    $id         The ad or placement ID.
     * @param string     $type       Either "ad" or "placement".
     * @param PEAR::Date $oStartDate The start date of the range required.
     * @param PEAR::Date $oEndDate   The end date the range required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     *
     * array(
     *     ['2007-04-20'] => array(
     *                          ['ad_required_impressions']         => integer
     *                          ['ad_requested_impressions']        => integer
     *                          ['ad_actual_impressions']           => integer
     *                          ['zones_forecast_impressions']      => integer
     *                          ['zones_actual_impressions']        => integer
     *                          ['average']                         => boolean
     *                       )
     *          .
     *          .
     *          .
     * )
     *
     * or:
     *
     * array(
     *     ['2007-04-20'] => array(
     *                          ['placement_required_impressions']  => integer
     *                          ['placement_requested_impressions'] => integer
     *                          ['placement_actual_impressions']    => integer
     *                          ['zones_forecast_impressions']      => integer
     *                          ['zones_actual_impressions']        => integer
     *                          ['average']                         => boolean
     *                       )
     *          .
     *          .
     *          .
     * )
     *
     * For the ad, or placement and date range specified, returns an array for each
     * day of the week, consisting of the total number of impressions requested
     * by the ad, or all ads in the placement (for all zones the ads are linked to),
     * as well as the total number of impressions actually delivered by the ad, or
     * all ads in the placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getTargetingStatisticsSpanByDow($id, $type, $oStartDate, $oEndDate)
    {
        return $this->_getTargetingStatisticsSpan($id, $type, $oStartDate, $oEndDate, 'dow');
    }

    /**
     * A method for obtaining the targeting statistics of an ad or placement
     * for a date span, where the data is summarised by hour.
     *
     * @param integer    $id         The ad or placement ID.
     * @param string     $type       Either "ad" or "placement".
     * @param PEAR::Date $oStartDate The start date of the range required.
     * @param PEAR::Date $oEndDate   The end date the range required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     *
     * array(
     *     ['0']  => array(
     *                   ['ad_required_impressions']         => integer
     *                   ['ad_requested_impressions']        => integer
     *                   ['ad_actual_impressions']           => integer
     *                   ['zones_forecast_impressions']      => integer
     *                   ['zones_actual_impressions']        => integer
     *                   ['average']                         => boolean
     *               ),
     *     ['1']  => array(
     *                   ['ad_required_impressions']         => integer
     *                   ['ad_requested_impressions']        => integer
     *                   ['ad_actual_impressions']           => integer
     *                   ['zones_forecast_impressions']      => integer
     *                   ['zones_actual_impressions']        => integer
     *                   ['average']                         => boolean
     *               ),
     *          .
     *          .
     *          .
     *     ['23'] => array(
     *                   ['ad_required_impressions']         => integer
     *                   ['ad_requested_impressions']        => integer
     *                   ['ad_actual_impressions']           => integer
     *                   ['zones_forecast_impressions']      => integer
     *                   ['zones_actual_impressions']        => integer
     *                   ['average']                         => boolean
     *               )
     * )
     *
     * or:
     *
     * array(
     *     ['0']  => array(
     *                   ['placement_required_impressions']  => integer
     *                   ['placement_requested_impressions'] => integer
     *                   ['placement_actual_impressions']    => integer
     *                   ['zones_forecast_impressions']      => integer
     *                   ['zones_actual_impressions']        => integer
     *                   ['average']                         => boolean
     *               ),
     *     ['1']  => array(
     *                   ['placement_required_impressions']  => integer
     *                   ['placement_requested_impressions'] => integer
     *                   ['placement_actual_impressions']    => integer
     *                   ['zones_forecast_impressions']      => integer
     *                   ['zones_actual_impressions']        => integer
     *                   ['average']                         => boolean
     *               ),
     *          .
     *          .
     *          .
     *     ['23'] => array(
     *                   ['placement_required_impressions']  => integer
     *                   ['placement_requested_impressions'] => integer
     *                   ['placement_actual_impressions']    => integer
     *                   ['zones_forecast_impressions']      => integer
     *                   ['zones_actual_impressions']        => integer
     *                   ['average']                         => boolean
     *               )
     * )
     *
     * For the ad, or placement and date range specified, returns an array for each
     * hour in the day, consisting of the total number of impressions requested
     * by the ad, or all ads in the placement (for all zones the ads are linked to),
     * as well as the total number of impressions actually delivered by the ad, or
     * all ads in the placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getTargetingStatisticsSpanByHour($id, $type, $oStartDate, $oEndDate)
    {
        return $this->_getTargetingStatisticsSpan($id, $type, $oStartDate, $oEndDate, 'hour');
    }

    /**
     * A method for obtaining the targeting statistics of an ad or placement
     * for a date span, where the data is summarised by one of "day", "week",
     * "month", "dow" or "hour" as specified by the $breakdown parameter.
     *
     * @param integer    $id          The ad or placement ID.
     * @param string     $type        Either "ad" or "placement".
     * @param PEAR::Date $oStartDate  The start date of the range required.
     * @param PEAR::Date $oEndDate    The end date the range required.
     * @param string     $breakdown   One of "day", "week", "month", "dow"
     *                                or "hour"
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     *
     * array(
     *     [key] => array(
     *                  ['ad_required_impressions']         => integer
     *                  ['ad_requested_impressions']        => integer
     *                  ['ad_actual_impressions']           => integer
     *                  ['zones_forecast_impressions']      => integer
     *                  ['zones_actual_impressions']        => integer
     *                  ['average']                         => boolean
     *              )
     *          .
     *          .
     *          .
     * )
     *
     * or:
     *
     * array(
     *     [key] => array(
     *                  ['placement_required_impressions']  => integer
     *                  ['placement_requested_impressions'] => integer
     *                  ['placement_actual_impressions']    => integer
     *                  ['zones_forecast_impressions']      => integer
     *                  ['zones_actual_impressions']        => integer
     *                  ['average']                         => boolean
     *              )
     *          .
     *          .
     *          .
     * )
     *
     * In the above "key" changes with breakdown type.
     *
     * For the ad, or placement and date range specified, returns an array for each
     * $breakdown as required, consisting of the total number of impressions requested
     * by the ad, or all ads in the placement (for all zones the ads are linked to),
     * as well as the total number of impressions actually delivered by the ad, or
     * all ads in the placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function _getTargetingStatisticsSpan($id, $type, $oStartDate, $oEndDate, $breakdown)
    {
        // Ensure the parameters are valid
        if (!$this->_testGetTargetingStatisticsSpanParameters($id, $type, $oStartDate, $oEndDate)) {
            return false;
        }
        // Ensure that, if a placement, the placement has advertisements
        if ($this->_testGetTargetingStatisticsSpanPlacement($id, $type) === false) {
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
        // Re-set the start date from the original date,
        // as PHP5 may cause $oStartDateCopy to change if
        // the time zone is not correctly set
        $oStartDateCopy = new Date();
        $oStartDateCopy->copy($oStartDate);
        $oStartDateCopy->setHour(0);
        $oStartDateCopy->setMinute(0);
        $oStartDateCopy->setSecond(0);
        for ($counter = 0; $counter <= $days; $counter++) {
            // Get this day's data
            $aTemp = $this->getDailyTargetingStatistics($id, $type, $oStartDateCopy);
            // Merge in the data appropriately
            $this->_mergeSpan($aResult, $aTemp, $type, $breakdown);
            $oStartDateCopy->addSeconds(SECONDS_PER_DAY);
        }
        return $aResult;
    }

    /**
     * A method for obtaining the targeting statistics of an ad or placement
     * for a single day, where the data is summarised by operation interval.
     *
     * @param integer    $id    The ad or placement ID.
     * @param string     $type  Either "ad" or "placement".
     * @param PEAR::Date $oDate A date representing the day required.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array of arrays:
     *
     *
     * array(
     *     [$operationIntervalId] => array(
     *                                  ['interval_start']             => PEAR::Date
     *                                  ['interval_end']               => PEAR::Date
     *                                  ['ad_required_impressions']    => integer
     *                                  ['ad_requested_impressions']   => integer
     *                                  ['ad_actual_impressions']      => integer
     *                                  ['zones_forecast_impressions'] => integer
     *                                  ['zones_actual_impressions']   => integer
     *                                  ['average']                    => integer
     *                               )
     *      .
     *      .
     *      .
     * )
     *
     * or:
     *
     * array(
     *     [$operationIntervalId] => array(
     *                                  ['interval_start']                  => PEAR::Date
     *                                  ['interval_end']                    => PEAR::Date
     *                                  ['placement_required_impressions']  => integer
     *                                  ['placement_requested_impressions'] => integer
     *                                  ['placement_actual_impressions']    => integer
     *                                  ['zones_forecast_impressions']      => integer
     *                                  ['zones_actual_impressions']        => integer
     *                                  ['average']                         => integer
     *                               )
     *      .
     *      .
     *      .
     * )
     *
     * For the ad or placement and day specified, returns an array for each
     * operation interval in the day, consisting of the operation interval start
     * and end dates, and the total number of impressions requested by the ad, or
     * all ads in the placement (for all zones the ads are linked to), as well as
     * the total number of impressions actually delivered by the ad, or all ads
     * in the placement (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getDailyTargetingStatistics($id, $type, $oDate)
    {
        if (!$this->_testGetTargetingStatisticsDayParameters($id, $type, $oDate)) {
            return false;
        }
        // Ensure that, if a placement, the placement has advertisements
        $aAdIds = $this->_testGetTargetingStatisticsSpanPlacement($id, $type);
        if ($aAdIds === false) {
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
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
        // Get dates to be used in date comparisons
        $oCompareDate = new Date();
        $oCompareDate->copy($aDates['start']);
        $oCompareEndDate = new Date();
        $oCompareEndDate->copy($oEndOfDayDate);
        while ($oCompareDate->before($oEndOfDayDate)) {
            // Get the operation interval ID
            $operationIntervalId = OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
            // Get the results for this operation interval
            $aResult[$operationIntervalId] = $this->getOperationIntervalTargetingStatistics($aAdIds, $type, $aDates['start'], $aDates['end']);
            if ($aResult[$operationIntervalId] === false) {
                return false;
            }
            // Get the next operation interval dates
            $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($aDates['start']);
            // Update the comparison dates
            $oCompareDate = new Date();
            $oCompareDate->copy($aDates['start']);
            $oCompareEndDate = new Date();
            $oCompareEndDate->copy($oEndOfDayDate);
        }
        return $aResult;
    }

    /**
     * A method for obtaining the targeting statistics of an ad or placement
     * for a single operation interval.
     *
     * @param array      $aAdIds     An array of ad IDs.
     * @param string     $type       Either "ad" or "placement".
     * @param PEAR::Date $oStartDate The start date of the operation interval.
     * @param PEAR::Date $oEndDate   The end date of the operation interval.
     *
     * @return mixed Returns false in the event of incorrect input, or in the case
     *               of being unable to connect to the database, otherwise, returns
     *               an array:
     *
     * array(
     *      ['interval_start']             => PEAR::Date
     *      ['interval_end']               => PEAR::Date
     *      ['ad_required_impressions']    => integer
     *      ['ad_requested_impressions']   => integer
     *      ['ad_actual_impressions']      => integer
     *      ['zones_forecast_impressions'] => integer
     *      ['zones_actual_impressions']   => integer
     *      ['average']                    => integer
     *  )
     *
     * or:
     *
     * array(
     *      ['interval_start']                  => PEAR::Date
     *      ['interval_end']                    => PEAR::Date
     *      ['placement_required_impressions']  => integer
     *      ['placement_requested_impressions'] => integer
     *      ['placement_actual_impressions']    => integer
     *      ['zones_forecast_impressions']      => integer
     *      ['zones_actual_impressions']        => integer
     *      ['average']                         => integer
     *  )
     *
     * For the ad, or ads and operation interval specified, returns an array,
     * consisting of the operation interval start and end dates, and the total
     * number of impressions requested by the ad, or ads (for all zones the
     * ads are linked to), as well as the total number of impressions actually
     * delivered by the ad, or ads (for all zones the ads are linked to).
     *
     * The individual ad/zone impressions requested values may need to be
     * calculated as an "averge" value, in the event that there are multiple,
     * differing values for an ad in a zone for an operation interval -- in
     * much the same way as is done in
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() -- before
     * the total impressions requested value can be calculated.
     */
    function getOperationIntervalTargetingStatistics($aAdIds, $type, $oStartDate, $oEndDate)
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
        if (!OA_OperationInterval::checkIntervalDates($oStartDate, $oEndDate)) {
            return false;
        }
        // Obtain the targeting statistcs for this operation interval
        $aResult = array(
            'interval_start'                 => $oStartDate,
            'interval_end'                   => $oEndDate,
            $type . '_required_impressions'  => 0,
            $type . '_requested_impressions' => 0,
            $type . '_actual_impressions'    => 0,
            'zones_forecast_impressions'     => 0,
            'zones_actual_impressions'       => 0,
            'average'                        => false
        );
        $aZoneIds = array();
        reset($aAdIds);
        while (list(,$adId) = each($aAdIds)) {
            $aAdStats = $this->getAdTargetingStatistics($adId, $oStartDate, $oEndDate);
            if ($aAdStats === false) {
                return $false;
            }
            reset($aAdStats);
            while (list($zoneId, $aValues) = each($aAdStats)) {
                $aResult[$type . '_required_impressions']  += $aValues['ad_required_impressions'];
                $aResult[$type . '_requested_impressions'] += $aValues['ad_requested_impressions'];
                $aResult[$type . '_actual_impressions']    += $aValues['ad_actual_impressions'];
                if (!in_array($zoneId, $aZoneIds)) {
                    $aZoneIds[] = $zoneId;
                    $aResult['zones_forecast_impressions'] += $aValues['zone_forecast_impressions'];
                    $aResult['zones_actual_impressions']   += $aValues['zone_actual_impressions'];
                }
                if ($aValues['average']) {
                    $aResult['average'] = true;
                }
            }
        }
        return $aResult;
    }

    /**
     * A method for obtaining the targeting statistics of an ad for a single
     * operation interval.
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
     *                    ['zone_actual_impressions']       => integer,
     *                    ['average']                       => boolean
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
     *
     * Note that this method does not use left joins, like the
     * OA_Dal_Maintenance_Priority::getPreviousAdDeliveryInfo() method! This is so
     * that all fields are filled in, regardless of if maintenance ran, or not.
     *
     * This helps ensure that the ad impressions delivered and the zone impressions
     * match other statistics screens, even when the MPE failed to run in a given
     * hour.
     */
    function getAdTargetingStatistics($adId, $oStartDate, $oEndDate)
    {
        if (!$this->_testParameters($adId, $oStartDate, $oEndDate)) {
            return false;
        }
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Extract the required MPE run information
        $dsaza = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_ad_zone_assoc'],true);
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
                dsaza.expired AS expired
            FROM
                {$dsaza} AS dsaza
            WHERE
                dsaza.operation_interval = {$aConf['maintenance']['operationInterval']}
                AND
                dsaza.interval_start = ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                AND
                dsaza.interval_end = ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                AND
                dsaza.ad_id = $adId
                AND
                dsaza.zone_id != 0
                AND
                dsaza.required_impressions > 0";
        $message = "Getting the MPE-based targeting statistcs for ad ID $adId for OI starting " .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S');
        OA::debug($message, PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            $message = "Error getting the MPE-based targeting statistcs for ad ID $adId for OI starting " .
                       $oStartDate->format('%Y-%m-%d %H:%M:%S');
            return false;
        }
        // Prepare the results array containing the MPE information
        $aResult = array();
        $averagesExist = false;
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
        // Extract the required ad impressions delivered information
        $dia = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $query = "
            SELECT
                dia.zone_id AS zone_id,
                dia.impressions AS ad_actual_impressions
            FROM
                {$dia} AS dia
            WHERE
                dia.operation_interval = {$aConf['maintenance']['operationInterval']}
                AND
                dia.interval_start = ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                AND
                dia.interval_end = ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                AND
                dia.ad_id = $adId";
        $message = "Getting the ad delivery-based targeting statistcs for ad ID $adId for OI starting " .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S');
        OA::debug($message, PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            $message = "Error getting the ad delivery-based targeting statistcs for ad ID $adId for OI starting " .
                       $oStartDate->format('%Y-%m-%d %H:%M:%S');
            return false;
        }
        // Merge the ad delivery information into the results array
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['zone_id']]['ad_actual_impressions'] += $aRow['ad_actual_impressions'];
        }
        // Extract the required zone forecast impressions information
        $aZonesIds = array();
        foreach (array_keys($aResult) as $zoneId) {
            $aZonesIds[] = $zoneId;
        }
        if (count($aZonesIds) > 0) {
            $dszih = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true);
            $query = "
                SELECT
                    dszih.zone_id AS zone_id,
                    dszih.forecast_impressions AS zone_forecast_impressions,
                    dszih.actual_impressions AS zone_actual_impressions
                FROM
                    {$dszih} AS dszih
                WHERE
                    dszih.operation_interval = {$aConf['maintenance']['operationInterval']}
                    AND
                    dszih.interval_start = ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                    AND
                    dszih.interval_end = ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                    AND
                    dszih.zone_id IN (" . implode(', ', $aZonesIds) . ")";
            $message = "Getting the zone forecast-based targeting statistcs for ad ID $adId for OI starting " .
                       $oStartDate->format('%Y-%m-%d %H:%M:%S');
            OA::debug($message, PEAR_LOG_DEBUG);
            $rc = $this->oDbh->query($query);
            if (PEAR::isError($rc)) {
                $message = "Error getting the zone forecast-based targeting statistcs for ad ID $adId for OI starting " .
                           $oStartDate->format('%Y-%m-%d %H:%M:%S');
                return false;
            }
            // Merge the zone forecast information into the results array
            while ($aRow = $rc->fetchRow()) {
                $aResult[$aRow['zone_id']]['zone_forecast_impressions'] += $aRow['zone_forecast_impressions'];
                $aResult[$aRow['zone_id']]['zone_actual_impressions']   += $aRow['zone_actual_impressions'];
            }
        }
        return $aResult;
    }

    /**
     * A private method for merging arrays of targeting statistics data, summarised
     * by operation interval, into a new array, summarised by one of "day", "week",
     * "month", "dow" or "hour".
     *
     * @access private
     * @param array $aResult    The result array to merge into.
     * @param array $aTemp      An array of targeting statistics data, summarised
     *                          by operation interval.
     * @param string $type      Either "ad" or "placement".
     * @param string $breakdown One of "day", "week", "month", "dow" or "hour"
     */
    function _mergeSpan(&$aResult, $aTemp, $type, $breakdown)
    {
        // Ensure the parameters are valid
        if (!is_array($aResult)) {
            return;
        }
        if (empty($aTemp) || !is_array($aTemp)) {
            return;
        }
        if (!($type == 'ad' || $type == 'placement')) {
            return;
        }
        $oNow = new Date();
        reset($aTemp);
        while (list(,$aValue) = each($aTemp)) {
            $aValue['interval_start']->convertTZ($oNow->tz);
            if ($breakdown == 'day') {
                $key = $aValue['interval_start']->format('%Y-%m-%d');
            } else if ($breakdown == 'week') {
                // Week breakdown uses same format as day, as the
                // week view in the UI also displays the stats by day,
                // it's just that the days are grouped by week - this
                // grouping is done by the
                // OA_Admin_Statistics_History::prepareWeekBreakdown()
                // method
                $key = $aValue['interval_start']->format('%Y-%m-%d');
            } else if ($breakdown == 'month') {
                $key = $aValue['interval_start']->format('%Y-%m');
            } else if ($breakdown == 'dow') {
                $key = $aValue['interval_start']->format('%w');
            } else if ($breakdown == 'hour') {
                $key = $aValue['interval_start']->format('%H');
                if (strpos($key, '0') === 0) {
                    $key = substr($key, 1);
                }
            } else {
                return;
            }
            if (!is_array($aResult[$key]) || empty($aResult[$key])) {
                // Set the default values for the key
                $aResult[$key] = array(
                    $type . '_required_impressions'  => 0,
                    $type . '_requested_impressions' => 0,
                    $type . '_actual_impressions'    => 0,
                    'zones_forecast_impressions'     => 0,
                    'zones_actual_impressions'       => 0,
                    'average'                        => false
                );
            }
            // Sum in the new values
            $aResult[$key][$type . '_required_impressions']  += $aValue[$type . '_required_impressions'];
            $aResult[$key][$type . '_requested_impressions'] += $aValue[$type . '_requested_impressions'];
            $aResult[$key][$type . '_actual_impressions']    += $aValue[$type . '_actual_impressions'];
            $aResult[$key]['zones_forecast_impressions']     += $aValue['zones_forecast_impressions'];
            $aResult[$key]['zones_actual_impressions']       += $aValue['zones_actual_impressions'];
            if ($aValue['average']) {
                $aResult[$key]['average'] = true;
            }
        }
        // Update the target ratio(s)
        reset($aResult);
        foreach (array_keys($aResult) as $key) {
            if ($aResult[$key][$type . '_required_impressions'] > 0) {
                $aResult[$key]['target_ratio'] = 0;
                if ($aResult[$key][$type . '_actual_impressions'] > 0) {
                    $aResult[$key]['target_ratio'] = $aResult[$key][$type . '_actual_impressions'] / $aResult[$key][$type . '_required_impressions'];
                }
            }
        }
    }

    /**
     * A private method to test the parameters of the getTargetingStatisticsSpan...()
     * methods.
     *
     * @access private
     * @param integer    $id         The ad or placement ID.
     * @param string     $type       Either "ad" or "placement".
     * @param PEAR::Date $oStartDate The start date of the range required.
     * @param PEAR::Date $oEndDate   The end date the range required.
     * @return boolean True if the parameters are okay, false otherwise.
     */
    function _testGetTargetingStatisticsSpanParameters($id, $type, $oStartDate, $oEndDate)
    {
        if (empty($id) || !is_int($id)) {
            return false;
        }
        if (!($type == 'ad' || $type == 'placement')) {
            return false;
        }
        if (empty($oStartDate) || !is_a($oStartDate, 'Date')) {
            return false;
        }
        if (empty($oEndDate) || !is_a($oEndDate, 'Date')) {
            return false;
        }
        return true;
    }

    /**
     * A private method to test the parameters of the getDailyTargetingStatistics()
     * method.
     *
     * @access private
     * @param integer    $id    The ad or placement ID.
     * @param string     $type  Either "ad" or "placement".
     * @param PEAR::Date $oDate The start date of the range required.
     * @return boolean True if the parameters are okay, false otherwise.
     */
    function _testGetTargetingStatisticsDayParameters($id, $type, $oDate)
    {
        if (empty($id) || !is_int($id)) {
            return false;
        }
        if (!($type == 'ad' || $type == 'placement')) {
            return false;
        }
        if (empty($oDate) || !is_a($oDate, 'Date')) {
            return false;
        }
        return true;
    }

    /**
     * A private method to test the parameters of the getTargetingStatisticsSpan...()
     * methods, and if the method is of "placement" type, that the placement has
     * ads.
     *
     * @access private
     * @param integer $id    The ad or placement ID.
     * @param string  $type  Either "ad" or "placement".
     * @return boolean|array False if the type is is "placement" and the placement has
     *                       no ads, or false if the type is not valid. Otherwise,
     *                       an array of all the ads in the placement (or the single
     *                       ad ID passed in if the type is "ad).
     */
    function _testGetTargetingStatisticsSpanPlacement($id, $type)
    {
        $aAdIds = array();
        if ($type == 'ad') {
            $aAdIds[] = $id;
            return $aAdIds;
        } else if ($type == 'placement') {
            $doBanners = OA_Dal::factoryDO('banners');
            $doBanners->campaignid = $id;
            $doBanners->active = 't';
            $doBanners->find();
            while ($doBanners->fetch()) {
                $aAdIds[] = (int) $doBanners->bannerid;
            }
            if (!empty($aAdIds)) {
                return $aAdIds;
            }
        }
        return false;
    }

    /**
     * A private method to test the parameters of the getAdTargetingStatistics()
     * and getZoneTargetingStatistics methods.
     *
     * @access private
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
        if (!OA_OperationInterval::checkIntervalDates($oStartDate, $oEndDate)) {
            return false;
        }
        return true;
    }

    /**
     * A private method to calculate average values when an operation interval
     * has more than one targeting value.
     *
     * @access private
     * @param array      $aValues  The array of arrays of values to calculate the
     *                             averages from.
     * @param PEAR::Date $oEndDate The end date/time of the operation interval,
     *                             to be used for those values where no expiration
     *                             date is set.
     * @return array The array of "average" values.
     */
    function _calculateAverages($aValues, $oEndDate)
    {
        if (empty($aValues) || !is_array($aValues)) {
            return array();
        }
        reset($aValues);
        while (list(,$aAdValues) = each($aValues)) {
            if (empty($aAdValues) || !is_array($aAdValues)) {
                return array();
            }
            if (count($aAdValues) != 10) {
                return array();
            }
        }
        if (empty($oEndDate) || !is_a($oEndDate, 'Date')) {
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
            'ad_past_zone_traffic_fraction' => 0,
            'average'                       => true
        );
        reset($aValues);
        while (list(,$aAdValues) = each($aValues)) {
            if ($counter == 0) {
                $aResult['interval_start']            = $aAdValues['interval_start'];
                $aResult['interval_end']              = $aAdValues['interval_end'];
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