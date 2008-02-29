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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Placement.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Zone.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * An abstract class used to define common methods required to calculate the number
 * of required impressions for placements and their children ads.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressions extends OA_Maintenance_Priority_AdServer_Task
{

    /**
     * A variable to store the type of High Priority Campaign being used.
     *
     * @var string
     */
    var $type;

    /**
     * For storing weekly zone impression forecasts, if zone
     * patterning is used, to save on database queries.
     *
     * @var array
     */
    var $aZoneForecasts;

    /**
     * A variable for storing a local instance of the
     * OA_DB_Table_Priority class.
     *
     * @var OA_DB_Table_Priority
     */
    var $oTable;

    /**
     * The class constructor method.
     *
     * @return OA_Maintenance_Priority_Common_Task_GetRequiredAdImpressions
     */
    function OA_Maintenance_Priority_Common_Task_GetRequiredAdImpressions()
    {
        parent::OA_Maintenance_Priority_AdServer_Task();
        $this->aZoneForecasts = array();
        $this->oTable =& $this->_getMaxTablePriorityObj();
    }

    /**
     * The main method of the class, that is run by the controlling
     * task runner class.
     */
    function run()
    {
        OA::debug('Running Maintenance Priority Engine: Get Required Ad Impressions for High Priority Campaigns', PEAR_LOG_DEBUG);
        OA::debug('- Where ' . $this->type, PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        $aAllPlacements = $this->_getValidPlacements();
        if (is_array($aAllPlacements) && (count($aAllPlacements) > 0)) {
            foreach ($aAllPlacements as $k => $oPlacement) {
                $this->getPlacementImpressionInventoryRequirement($aAllPlacements[$k]);
                $aAllPlacements[$k]->setAdverts();
            }
            $this->distributePlacementImpressions($aAllPlacements);
        }
    }

    /**
     * A method to return the current date. Can return the current date:
     *
     * - Based on the optional parameter; or
     * - From the current date registered with the Service Locator; or
     * - Based on the time when called.
     *
     * @access private
     * @param string $date An optional string representation of the current date.
     * @return object The current date.
     */
    function _getDate($date = '')
    {
        if (!empty($date)) {
            return new Date($date);
        }
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDateNow =& $oServiceLocator->get('now');
        if (!$oDateNow) {
            $oDateNow = new Date();
            $oServiceLocator->register('now', $oDateNow);
        }
        return $oDateNow;
    }

    /**
     * An abstract method to be implemented in child classes to obtain all
     * placements that meet the requirements of the child class.
     *
     * @abstract
     * @access private
     * @return array An array of {@link OA_Maintenance_Priority_Placement} objects.
     */
    function _getValidPlacements() {}

    /**
     * A private method that can be used by implementations of _getValidPlacements()
     * in children classes to return an array of OA_Maintenance_Priority_Placement objects.
     *
     * Essentially a convenience method to convert the results of the
     * {@link OA_Dal_Maintenance_Priority::_getPlacements()} method from an array
     * of database records into an array of OA_Maintenance_Priority_Placement objects.
     *
     * @access private
     * @param array $aFields An optional array of extra fields to select from the database
     *                       (see the {@link OA_Dal_Maintenance_Priority::getPlacements()}
     *                       class.)
     * @param array $aWheres An optional array of where statements to limit which placements
     *                      are returned from the database (see the
     *                       {@link MAX_Dal_Maintenance::getPlacements()} class.)
     * @return array An array of {@link OA_Maintenance_Priority_Placement} objects, appropriate to the
     *               $filter given.
     */
    function _getAllPlacements($aFields = array(), $aWheres = array())
    {
        $aPlacementObjects = array();
        $aPlacements = $this->oDal->getPlacements($aFields, $aWheres);
        if (is_array($aPlacements) && (count($aPlacements) > 0)) {
            foreach ($aPlacements as $aPlacement) {
                $aPlacementObjects[] = new OA_Maintenance_Priority_Placement($aPlacement);
            }
        }
        return $aPlacementObjects;
    }

    /**
     * A method to estimate the impressions required to fulfill a placement's
     * impression, click, or conversion requirements.
     *
     * The $oPlacement parameter is passed by reference and will have
     * the calculated impression requirement added to it in the position
     * $oPlacement->requiredImpressions
     *
     * @param OA_Maintenance_Priority_Placement $oPlacement A reference to the placement.
     * @param string $type Ether "total" or "daily", depending on whether the
     *                     required impressions should be based on the placement
     *                     lifetime totals, or the placement daily totals.
     * @param boolean $ignorePast When true, the required impressions will
     *                            ignore any delivery that has occurred to
     *                            date, to the value returned will represent
     *                            the expected TOTAL lifetime or daily
     *                            impressions required.
     */
    function getPlacementImpressionInventoryRequirement(&$oPlacement, $type, $ignorePast = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!$ignorePast) {
            // Get campaign summary statistic totals
            if ($type == 'total') {
                $oPlacement->setSummaryStatisticsToDate();
            } else {
                $oTodayDate = $this->_getDate();
                $oPlacement->setSummaryStatisticsToday($oTodayDate->format('%Y-%m-%d'));
            }
        }
        // Calculate impressions required to fulfill click requirement
        if ($type == 'total') {
            $clickTarget = $oPlacement->clickTargetTotal;
        } else {
            $clickTarget = $oPlacement->clickTargetDaily;
        }
        $clickImpressions = $this->_getInventoryImpressionsRequired(
            $clickTarget,
            $aConf['priority']['defaultClickRatio'],
            $oPlacement->deliveredClicks,
            $oPlacement->deliveredImpressions);
        // Calculate impressions required to fulfill conversion requirement
        if ($type == 'total') {
            $conversionTarget = $oPlacement->conversionTargetTotal;
        } else {
            $conversionTarget = $oPlacement->conversionTargetDaily;
        }
        $conversionImpressions = $this->_getInventoryImpressionsRequired(
            $conversionTarget,
            $aConf['priority']['defaultConversionRatio'],
            $oPlacement->deliveredConversions,
            $oPlacement->deliveredImpressions);
        // Get impression requirement
        if ($type == 'total') {
            $impressionTarget = $oPlacement->impressionTargetTotal;
        } else {
            $impressionTarget = $oPlacement->impressionTargetDaily;
        }

        if ($impressionTarget > 0) {
            $impressions = $impressionTarget - $oPlacement->deliveredImpressions;
        } else {
            $impressions = 0;
        }
        // Choose smallest required impression
        $oPlacement->requiredImpressions = $this->_getSmallestNonZeroInteger(
            array(
                $clickImpressions,
                $conversionImpressions,
                $impressions
            )
        );
    }

    /**
     * A private method to calculate the number of impressions required to achieve
     * delivery of a given click or conversion inventory booking.
     *
     * If historical delivery data does not exist, the ratio provided in $defaultRatio
     * will be use for all calculations.  Please be aware that a default a click ratio
     * and a default conversion rato are provided in the system wide configuration file
     * and should be a value between zero and one ((ratio > 0) && (ratio <= 1)).
     *
     * $GLOBALS['_MAX']['CONF']['priority']['defaultClickRatio']
     * $GLOBALS['_MAX']['CONF']['priority']['defaultConversionRatio']
     *
     * @access private
     * @param integer $inventory Total placement inventory to be achieved over lifetime/day.
     * @param integer $defaultRatio Click/conversion ratio used if historical data does not exist.
     * @param integer $inventoryToDate Total clicks/conversions achieved to date over lifetime/day.
     * @param integer $impressionsToDate Total impressions delivered to date over lifetime/day.
     * @return integer The number of impressions that are required.
     */
    function _getInventoryImpressionsRequired($inventory, $defaultRatio, $inventoryToDate = 0, $impressionsToDate = 0)
    {
        $requiredImpressions = 0;
        if ($inventory > 0) {
            // If historical information exists
            if ($inventoryToDate > 0) {
                $inventoryPerImpression = ($inventoryToDate / $impressionsToDate);
            } else {
                $inventoryPerImpression = $defaultRatio;
            }
            $requiredImpressions = (int)$inventory / $inventoryPerImpression;
        }
        return ceil($requiredImpressions);
    }

    /**
     * A private method to return the smallest non-zero value of a given array of values.
     *
     * If $aValues is empty (or contains no integer values), then zero is returned.
     *
     * @param array $aValues An array of values to evaluated.
     * @return integer The smallest non-zero value from the array, or zero if empty.
     */
    function _getSmallestNonZeroInteger($aValues = array())
    {
        if (!is_array($aValues) || (count($aValues) == 0)) return 0;
        foreach ($aValues as $val) {
            if ((($val > 0) && !isset($minVal)) ||
                (($val > 0) && isset($minVal) && ($val < $minVal))) {
                $minVal = $val;
            }
        }
        return (isset($minVal)) ? $minVal : 0;
    }

    /**
     * A method to distribute the calculated required placement impressions between the placement's
     * children advertisements. Impression allocation takes in to account ad weight, and the number
     * of operations intervals the ad will be active in given date/time delivery limitations, and
     * the pattern of available impressions for the zone(s) the advertisements are linked to.
     *
     * The calculated ad impressions are written to the temporary table tmp_ad_required_impression
     * for later analysis by the {@link OA_Maintenance_Priority_AdServer_Task_AllocateZoneImpressions}
     * class.
     *
     * @param array $aPlacements An array of {@link OA_Maintenance_Priority_Placement} objects which require
     *                           that their total required impressions be distributed between the
     *                           component advertisements.
     */
    function distributePlacementImpressions($aPlacements)
    {
        // Create an array for storing required ad impressions
        $aRequiredAdImpressions = array();
        // Get the current operation interval start/end dates
        $aCurrentOperationIntervalDates =
            OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->_getDate());
        // For each placement
        foreach ($aPlacements as $oPlacement) {
            // Get date object to represent placement expiration date
            // Get date object to represent placement expiration date
            if (
                   ($oPlacement->impressionTargetDaily > 0)
                   ||
                   ($oPlacement->clickTargetDaily > 0)
                   ||
                   ($oPlacement->conversionTargetDaily > 0)
               ) {
                // The placement has a daily target to meet, so treat the
                // placement as if it expires at the end of "today", regardless
                // of the existance of any activation or expiration dates that
                // may (or may not) be set for the placement
                $oDate =& $this->_getDate();
                // Get the end of the day from this date
                $oPlacementExpiryDate = new Date($oDate->format('%Y-%m-%d') . ' 23:59:59');
            } else if (
                   ($oPlacement->expire != OA_Dal::noDateValue())
                   &&
                   (
                       ($oPlacement->impressionTargetTotal > 0)
                       ||
                       ($oPlacement->clickTargetTotal > 0)
                       ||
                       ($oPlacement->conversionTargetTotal > 0)
                   )
               ) {
                // The placement has an expiration date, and has some kind of
                // (total) inventory requirement, so treat the placement as if
                // it expires at the end of the expiration date
                $oPlacementExpiryDate =& $this->_getDate($oPlacement->expire);
                // Placement expires at end of expiry date, so add one day less one
                // second, so we have a date with time portion 23:59:59
                $oPlacementExpiryDate->addSeconds(SECONDS_PER_DAY - 1);
            } else {
                // Error! There should not be any other kind of high-priority
                // placement in terms of activation/expiration dates and
                // either (total) inventory requirements or daily targets
                $message = "- Error calculating the end date for Placement ID {$oPlacement->id}.";
                OA::debug($message, PEAR_LOG_ERR);
                continue;
            }
            // Determine number of remaining operation intervals for placement
            $placementRemainingOperationIntervals =
                OA_OperationInterval::getIntervalsRemaining(
                    $aCurrentOperationIntervalDates['start'],
                    $oPlacementExpiryDate
                );
            // For all ads in the placement, determine:
            // - If the ad is capable of delivery in the current operation
            //   interval, or not, based on delivery limitation(s); and
            // - The result of the weight of the ad multiplied by the
            //   number of operation intervals remaining in which the ad
            //   is capable of delivering
            $aAdCurrentOperationInterval = array();
            $aAdWeightRemainingOperationIntervals = array();
            reset($oPlacement->aAds);
            while (list($adId, $oAd) = each($oPlacement->aAds)) {
                // Only calculate values for active ads
                if ($oAd->active && ($oAd->weight > 0)) {
                    // Prepare a delivery limitation object for the ad
                    $oDeliveryLimitation =
                        new OA_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
                    // Is the ad blocked from delivering in the current operation interval?
                    $aAdCurrentOperationInterval[$oAd->id] =
                        $oDeliveryLimitation->deliveryBlocked($aCurrentOperationIntervalDates['start']);
                    // Determine how many operation intervals remain that the ad can deliver in
                    $adRemainingOperationIntervals =
                        $oDeliveryLimitation->getActiveAdOperationIntervals(
                            $placementRemainingOperationIntervals,
                            $aCurrentOperationIntervalDates['start'],
                            $oPlacementExpiryDate
                        );
                    // Determine the value of the ad weight multiplied by the number
                    // of operation intervals remaining that the ad can deliver in
                    if ($oAd->weight > 0) {
                        $aAdWeightRemainingOperationIntervals[$oAd->id] =
                            $oAd->weight * $adRemainingOperationIntervals;
                    } else {
                        $aAdWeightRemainingOperationIntervals[$oAd->id] = 0;
                    }
                }
            }
            // Get the total sum of the ad weight * remaining OI values
            $sumAdWeightRemainingOperationIntervals = array_sum($aAdWeightRemainingOperationIntervals);
            // For each (active) ad that is capable of delivering in the current
            // operation interval, determine how many of the placement's required
            // impressions should be alloced as the ad's required impressions
            // For each advertisement
            reset($oPlacement->aAds);
            while (list($adId, $oAd) = each($oPlacement->aAds)) {
                // Get impressions required
                $totalRequiredAdImpressions = 0;
                if ($oAd->active && $oAd->weight > 0 && $aAdCurrentOperationInterval[$oAd->id] !== true) {
                    $totalRequiredAdImpressions = $oPlacement->requiredImpressions *
                        ($aAdWeightRemainingOperationIntervals[$oAd->id] / $sumAdWeightRemainingOperationIntervals);
                }
                if ($totalRequiredAdImpressions > 0) {
                    // Based on the average zone pattern of the zones the ad is
                    // linked to, calculate how many of these impressions should
                    // be delivered in the next operation interval
                    $oAd->requiredImpressions = $this->_getAdImpressions(
                            $oAd,
                            $totalRequiredAdImpressions,
                            $aCurrentOperationIntervalDates['start'],
                            $oPlacementExpiryDate
                        );
                    $aRequiredAdImpressions[] = array(
                        'ad_id'                => $oAd->id,
                        'required_impressions' => $oAd->requiredImpressions
                    );
                }
            }
        }
        // Save the required impressions into the temporary database table
        OA::setTempDebugPrefix('- ');
        $this->oTable->createTable('tmp_ad_required_impression');
        $this->oDal->saveRequiredAdImpressions($aRequiredAdImpressions);
    }

    /**
     * A private method to calcuate the number of impressions an advertisement needs to deliver
     * in the next operation interval, based on the total number of impressions the ad needs to
     * deliver over the rest of the placements, the operaion intervals the ad will be active
     * in, and the average zone pattern of the zones the ad is linked to.
     *
     * @access private
     * @param OA_Maintenance_Priority_Ad $oAd An ad object, representing the advertisement.
     * @param integer $totalRequiredAdImpressions The total number of impressions the advertisement
     *                                            needs to deliver.
     * @param PEAR::Date $oDate A Date object, set in the current operation interval.
     * @param PEAR::Date $oPlacementExpiryDate A Date object representing the end of the advertisement's
     *                                         parent placement.
     * @return integer The number of impressions the advertisement should deliver in the next
     *                 operation interval.
     */
    function _getAdImpressions($oAd, $totalRequiredAdImpressions, $oDate, $oPlacementExpiryDate)
    {
        // Check the parameters, and return 0 impressions if not valid
        if (!is_a($oAd, 'OA_Maintenance_Priority_Ad') || !is_numeric($totalRequiredAdImpressions) ||
            !is_a($oDate, 'Date') || !is_a($oPlacementExpiryDate, 'Date')) {
            return 0;
        }
        // Create a new delivery limitaion object for the advertisement's delivery limitaitons
        $oDeliveryLimitation =
            new OA_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
        if ($oDeliveryLimitation->deliveryBlocked($oDate) == true) {
            // The advertisement is not currently able to deliver, and so
            // no impressions should be allocated for this operation interval
            return 0;
        }
        // Get the cumulative associated zones forecasts for the previous week's
        // zone inventory forecasts, keyed by the operation interval ID
        $aCumulativeZoneForecast = $this->_getCumulativeZoneForecast($oAd->id);
        // Get the array representing the total run of the advertisement over the
        // life of the placement, based on which operation intervals the ad is
        // blocked/not blocked in
        $aAdvertLifeData = $oDeliveryLimitation->getAdvertisementLifeData(
            $oDate,
            $oPlacementExpiryDate,
            $aCumulativeZoneForecast
        );
        // Loop over the advertisement's life data, and sum the total (cumulative)
        // zone forecast impressions that will be available over the lifetime of
        // the the ad
        $totalLifetimeImpressions = 0;
        foreach ($aAdvertLifeData as $aWeekData) {
            foreach ($aWeekData as $aIntervalData) {
                if (!$aIntervalData['blocked'] && !is_null($aIntervalData['forecast_impressions'])) {
                    $totalLifetimeImpressions += $aIntervalData['forecast_impressions'];
                }
            }
        }
        // Are there impressions forecast?
        if ($totalLifetimeImpressions == 0) {
            return 0;
        }
        // Get the current operation interval ID
        $currentOperationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        // Scale the total required impressions for the ad over its lifetime
        // into the current operation interval forecast, relative to the total
        // zone-pattern based forecast for the remaining lifetime of the ad
        $scale = $aCumulativeZoneForecast[$currentOperationIntervalID] / $totalLifetimeImpressions;
        $impressions = $totalRequiredAdImpressions * $scale;
        return round($impressions);
    }

    /**
     * A private method to return the current cumulative zone forecast data for all zones
     * associated with a given advertisement. The returned array is keyed by operation interval
     * ID (i.e. from 0 [zero] to the maximum operation interval ID value, depending on the current
     * configuration value for the operation interval length). The zone forecast values used
     * in calculating the cumulative forecast are taken from the end of the current operation
     * interval to one week prior (i.e. the most recent week's worth of forecasts).
     *
     * @access private
     * @param integer $adId The advertisement ID.
     * @return mixed Array on success, false on failure. If an array, it is of the format:
     *                  array(
     *                      [operation_interval_id] => forecast_impressions,
     *                      [operation_interval_id] => forecast_impressions
     *                                  .
     *                                  .
     *                                  .
     *                  )
     */
    function _getCumulativeZoneForecast($adId)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (empty($adId) || !is_numeric($adId)) {
            OA::debug('- Invalid advertisement ID argument', PEAR_LOG_ERR);
            return false;
        }
        // Get all zones associated with the advertisement
        $aAdZones = $this->oDal->getAdZoneAssociationsByAds(array($adId));
        $aZones = @$aAdZones[$adId];
        // Initialise the results array with the number operation intervals in a week
        $aResults = array_fill(0, OA_OperationInterval::operationIntervalsPerWeek(), 0);
        // Get the forcast impressions for the previous week
        if (is_array($aZones) && !empty($aZones)) {
            foreach ($aZones as $aZone) {
                if (!is_array($this->aZoneForecasts[$aZone['zone_id']])) {
                    $this->aZoneForecasts[$aZone['zone_id']] =
                        $this->oDal->getPreviousWeekZoneForcastImpressions($aZone['zone_id']);
                }
                if (is_array($this->aZoneForecasts[$aZone['zone_id']]) &&
                    !empty($this->aZoneForecasts[$aZone['zone_id']])) {
                    foreach ($this->aZoneForecasts[$aZone['zone_id']] as $aValues) {
                        $aResults[$aValues['operation_interval_id']] +=
                            (int)$aValues['forecast_impressions'];
                    }
                }
            }
        }
        return $aResults;
    }

}

?>
