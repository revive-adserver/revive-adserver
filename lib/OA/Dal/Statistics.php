<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH.'/lib/Max.php';
require_once MAX_PATH.'/lib/max/Dal/Common.php';
require_once MAX_PATH.'/lib/max/OperationInterval.php';
require_once 'Date.php';

/**
 * The Data Abstraction Layer (DAL) class for obtaining statistics for
 * display in the UI.
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
     *     [$oDate] => array(
     *                     ['impressions_requested'] => integer
     *                     ['actual_impressions']    => integer
     *                 )
     *      .
     *      .
     *      .
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
     *                                   ['interval_start']        => PEAR::Date
     *                                   ['interval_end']          => PEAR::Date
     *                                   ['impressions_requested'] => integer
     *                                   ['actual_impressions']    => integer
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
     *                      ['impressions_requested'] => integer
     *                      ['priority']              => double
     *                      ['priority_factor']       => double
     *                      ['actual_impressions']    => integer
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
        // Okay!
        return true;
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
     *                    ['impressions_requested'] => integer
     *                    ['priority']              => double
     *                    ['priority_factor']       => double
     *                    ['actual_impressions']    => integer
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
        // Okay!
        return true;
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

}

?>