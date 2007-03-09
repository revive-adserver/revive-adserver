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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Entity/Placement.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';
require_once 'Date.php';

/**
 * An abstract class used to define common methods required to calculate the number
 * of required impressions for placements and their children ads.
 *
 * @abstract
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressions extends MAX_Maintenance_Priority_AdServer_Task
{

    /**
     * For storing weekly zone impression forecasts, if zone
     * patterning is used, to save on database queries.
     *
     * @var array
     */
    var $aZoneForecasts;

    /**
     * A variable for storing a local instance of the
     * MAX_Table_Priority class.
     *
     * @var MAX_Table_Priority
     */
    var $oTable;

    /**
     * The class constructor method.
     *
     * @return MAX_Maintenance_Priority_Common_Task_GetRequiredAdImpressions
     */
    function MAX_Maintenance_Priority_Common_Task_GetRequiredAdImpressions()
    {
        parent::MAX_Maintenance_Priority_AdServer_Task();
        $this->aZoneForecasts = array();
        $this->oTable = &$this->_getMaxTablePriorityObj();
    }

    /**
     * The main method of the class, that is run by the controlling
     * task runner class.
     */
    function run()
    {
        MAX::debug('Starting to Get Required Ad Impressions.', PEAR_LOG_DEBUG);
        $conf = $GLOBALS['_MAX']['CONF'];
        $aAllPlacements = $this->_getValidPlacements();
        if (is_array($aAllPlacements) && (count($aAllPlacements) > 0)) {
            foreach ($aAllPlacements as $k => $oPlacement) {
                $this->getPlacementImpressionInventoryRequirement($aAllPlacements[$k]);
                $aAllPlacements[$k]->setAdverts();
            }
            if ($conf['priority']['useZonePatterning']) {
                $this->distributePlacementImpressionsByZonePattern($aAllPlacements);
            } else {
                $this->distributePlacementImpressions($aAllPlacements);
            }
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
        $oServiceLocator = &ServiceLocator::instance();
        $oDateNow = &$oServiceLocator->get('now');
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
     * @return array An array of {@link MAX_Entity_Placement} objects.
     */
    function _getValidPlacements() {}

    /**
     * A private method that can be used by implementations of _getValidPlacements()
     * in children classes to return an array of MAX_Entity_Placement objects.
     *
     * Essentially a convenience method to convert the results of the
     * {@link MAX_Dal_Maintenance_Priority::_getPlacements()} method from an array
     * of database records into an array of MAX_Entity_Placement objects.
     *
     * @access private
     * @param array $aFields An optional array of extra fields to select from the database
     *                       (see the {@link MAX_Dal_Maintenance_Priority::getPlacements()}
     *                       class.)
     * @param array $aWheres An optional array of where statements to limit which placements
     *                      are returned from the database (see the
     *                       {@link MAX_Dal_Maintenance::getPlacements()} class.)
     * @return array An array of {@link MAX_Entity_Placement} objects, appropriate to the
     *               $filter given.
     */
    function _getAllPlacements($aFields = array(), $aWheres = array())
    {
        $aPlacementObjects = array();
        $aPlacements = $this->oDal->getPlacements($aFields, $aWheres);
        if (is_array($aPlacements) && (count($aPlacements) > 0)) {
            foreach ($aPlacements as $aPlacement) {
                $aPlacementObjects[] = new MAX_Entity_Placement($aPlacement);
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
     * @param MAX_Entity_Placement $oPlacement A reference to the placement.
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
        $conf = $GLOBALS['_MAX']['CONF'];
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
            $conf['priority']['defaultClickRatio'],
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
            $conf['priority']['defaultConversionRatio'],
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
     * of operations intervals the ad will active in given date/time delivery constraints.
     *
     * The calculated ad impressions are written to the temporary table tmp_ad_required_impression
     * for later analysis by the {@link AllocateZoneImpressions} class.
     *
     * @param array $aPlacements An array of {@link MAX_Entity_Placement} objects which require
     *                           that their total required impressions be distributed between the
     *                           component advertisements.
     */
    function distributePlacementImpressions($aPlacements)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Create an array for storing required ad impressions
        $aRequiredAdImpressions = array();
        // Get the current operation interval start/end dates
        $aCurrentOperationIntervalDates =
            MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->_getDate());
        // For each placement
        foreach ($aPlacements as $oPlacement) {
            // Get date object to represent placement expiration date
            if ($oPlacement->expire == '0000-00-00' &&
                (($oPlacement->impressionTargetDaily > 0) ||
                 ($oPlacement->clickTargetDaily > 0) ||
                 ($oPlacement->conversionTargetDaily > 0))) {
                // The campaign has a daily target, bue no expiry date, so
                // treat this placement as if it ends at the end of today
                $oDate = &$this->_getDate();
                // Get the end of the day from this date
                $oPlacementExpiryDate = new Date($oDate->format('%Y-%m-%d') . ' 23:59:59');
            } else {
                $oPlacementExpiryDate = &$this->_getDate($oPlacement->expire);
                // Placement expires at end of expiry date, so add one day less one
                // second, so we have a date with time portion 23:59:59
                $oPlacementExpiryDate->addSeconds(SECONDS_PER_DAY - 1);
            }
            // Determine number of remaining operation intervals for placement
            $placementRemainingOperationIntervals =
                MAX_OperationInterval::getIntervalsRemaining(
                    $aCurrentOperationIntervalDates['start'],
                    $oPlacementExpiryDate
                );
            // Sum the weights of all (active) ads in placement
            $totalWeight = $this->_getPlacementAdWeightTotal($oPlacement);
            if (PEAR::isError($totalWeight, MAX_ERROR_INVALIDARGS)) {
                /**
                 * @TODO Ensure that this PEAR::Error is handled by calling code, or
                 *       raise an error instead of returning.
                 */
                return $totalWeight;
            }
            // Calculate number impressions per weight value of 1 (one)
            $totalImpressionsPerUnitWeight = $oPlacement->requiredImpressions / $totalWeight;
            // For each (active) advertisement
            reset($oPlacement->aAds);
            while (list($adId, $oAd) = each($oPlacement->aAds)) {
                // Get impressions required, based on the ad weight
                $requiredAdImpressions = 0;
                if ($oAd->active && ($oAd->weight > 0)) {
                    $requiredAdImpressions = $oAd->weight * $totalImpressionsPerUnitWeight;
                }
                if ($requiredAdImpressions > 0) {
                    $oDeliveryLimitation =
                        new MAX_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
                    if ($oDeliveryLimitation->deliveryBlocked($aCurrentOperationIntervalDates['start']) == false) {
                        // Find number of active operation intervals
                        $activeAdOpInts =
                            $oDeliveryLimitation->getActiveAdOperationIntervals(
                                $placementRemainingOperationIntervals,
                                $aCurrentOperationIntervalDates['start'],
                                $oPlacementExpiryDate
                            );
                        // Are there active intervals for the ad?
                        if ($activeAdOpInts > 0) {
                            // Divide number required impressions between active operation intervals
                            $oAd->requiredImpressions = round($requiredAdImpressions / $activeAdOpInts);
                            // Delivery Hack
                            if ($conf['maintenance']['deliveryHack']) {
                                $oServiceLocator = &ServiceLocator::instance();
                                $oDateNow = &$oServiceLocator->get('now');
                                $hour = $oDateNow->getHour();
                                $factor = 0.22;
                                switch ($hour) {
                                    case 8:
                                        $factor = 0.9;
                                        break;
                                    case 9:
                                        $factor = 1.43;
                                        break;
                                    case 10:
                                        $factor = 1.78;
                                        break;
                                    case 11:
                                        $factor = 1.86;
                                        break;
                                    case 12:
                                        $factor = 2.35;
                                        break;
                                    case 13:
                                        $factor = 2.2;
                                        break;
                                    case 14:
                                        $factor = 1.66;
                                        break;
                                    case 15:
                                        $factor = 1.84;
                                        break;
                                    case 16:
                                        $factor = 1.86;
                                        break;
                                    case 17:
                                        $factor = 1.87;
                                        break;
                                    case 18:
                                        $factor = 2.08;
                                        break;
                                    case 19:
                                        $factor = 2.05;
                                        break;
                                    case 20:
                                        $factor = 1.52;
                                        break;
                                    case 21:
                                        $factor = 1.43;
                                        break;
                                    case 22:
                                        $factor = 1.42;
                                        break;
                                    case 23:
                                        $factor = 0.86;
                                        break;
                                }
                                $oAd->requiredImpressions =
                                    round(($requiredAdImpressions / $activeAdOpInts) * $factor);
                            }

                            $aRequiredAdImpressions[] = array(
                                'ad_id'                => $oAd->id,
                                'required_impressions' => $oAd->requiredImpressions
                            );
                        }
                    }
                }
            }
        }
        // Save the required impressions into the temporary database table
        $this->oTable->createTable('tmp_ad_required_impression');
        $this->oDal->saveRequiredAdImpressions($aRequiredAdImpressions);
    }

    /**
     * A method to distribute the calculated required placement impressions between the placement's
     * children advertisements. Impression allocation takes in to account ad weight, and the number
     * of operations intervals the ad will be active in given date/time delivery limitations, and
     * the pattern of available impressions for the zone(s) the advertisements are linked to.
     *
     * The calculated ad impressions are written to the temporary table tmp_ad_required_impression
     * for later analysis by the {@link AllocateZoneImpressions} class.
     *
     * @param array $aPlacements An array of {@link MAX_Entity_Placement} objects which require
     *                           that their total required impressions be distributed between the
     *                           component advertisements.
     */
    function distributePlacementImpressionsByZonePattern($aPlacements)
    {
        // Create an array for storing required ad impressions
        $aRequiredAdImpressions = array();
        // Get the current operation interval start/end dates
        $aCurrentOperationIntervalDates =
            MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->_getDate());
        // For each placement
        foreach ($aPlacements as $oPlacement) {
            // Get date object to represent placement expiration date
            if ($oPlacement->expire == '0000-00-00' &&
                (($oPlacement->impressionTargetDaily > 0) ||
                 ($oPlacement->clickTargetDaily > 0) ||
                 ($oPlacement->conversionTargetDaily > 0))) {
                // The campaign has a daily target, bue no expiry date, so
                // treat this placement as if it ends at the end of today
                $oDate = &$this->_getDate();
                // Get the end of the day from this date
                $oPlacementExpiryDate = new Date($oDate->format('%Y-%m-%d') . ' 23:59:59');
            } else {
                $oPlacementExpiryDate = &$this->_getDate($oPlacement->expire);
                // Placement expires at end of expiry date, so add one day less one
                // second, so we have a date with time portion 23:59:59
                $oPlacementExpiryDate->addSeconds(SECONDS_PER_DAY - 1);
            }
            // Sum the weights of all ads in placement
            $totalWeight = $this->_getPlacementAdWeightTotal($oPlacement);
            if (PEAR::isError($totalWeight, MAX_ERROR_INVALIDARGS)) {
                /**
                 * @TODO Ensure that this PEAR::Error is handled by calling code, or
                 *       raise an error instead of returning.
                 */
                return $totalWeight;
            }
            // Calculate number impressions per weight value of 1 (one)
            $totalImpressionsPerUnitWeight = $oPlacement->requiredImpressions / $totalWeight;
            // For each advertisement
            reset($oPlacement->aAds);
            while (list($adId, $oAd) = each($oPlacement->aAds)) {
                // If the advertisement is active, and has a positive weight
                if ($oAd->active && ($oAd->weight > 0)) {
                    // Calculate the impressions the ad requires, based on the ad weight
                    $totalRequiredAdImpressions = $oAd->weight * $totalImpressionsPerUnitWeight;
                    if ($totalRequiredAdImpressions > 0) {
                        // Based on the average zone pattern of the zones the ad is
                        // linked to, calculate how many of these impressions should
                        // be delivered in the next operation interval
                        $oAd->requiredImpressions = $this->_getAdImpressionsByZonePattern(
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
        }
        // Save the required impressions into the temporary database table
        $this->oTable->createTable('tmp_ad_required_impression');
        $this->oDal->saveRequiredAdImpressions($aRequiredAdImpressions);
    }

    /**
     * A private method to sum all ad weight values of active advertisements for a
     * given placement. If no ads, or if the sum is zero, the default summation weight
     * is set to unity (1).
     *
     * @access private
     * @param MAX_Entity_Placement $oPlacement The placement.
     * @return integer The ad weight total.
     */
    function _getPlacementAdWeightTotal($oPlacement)
    {
        $weight = 0;
        if (is_a($oPlacement, 'MAX_Entity_Placement')) {
            reset($oPlacement->aAds);
            while (list($adId, $oAd) = each($oPlacement->aAds)) {
                if (is_a($oAd, 'MAX_Entity_Ad') && $oAd->active) {
                    $weight += ($oAd->weight > 0) ? $oAd->weight : 0;
                }
            }
            if ($weight === 0) {
                $weight = 1;
            }
            return $weight;
        }
        return PEAR::raiseError('Invalid Placement object argument', MAX_ERROR_INVALIDARGS);
    }

    /**
     * A private method to calcuate the number of impressions an advertisement needs to deliver
     * in the next operation interval, based on the total number of impressions the ad needs to
     * deliver over the rest of the placements, the operaion intervals the ad will be active
     * in, and the average zone pattern of the zones the ad is linked to.
     *
     * @access private
     * @param MAX_Entity_Ad $oAd An ad object, representing the advertisement.
     * @param integer $totalRequiredAdImpressions The total number of impressions the advertisement
     *                                            needs to deliver.
     * @param PEAR::Date $oDate A Date object, set in the current operation interval.
     * @param PEAR::Date $oPlacementExpiryDate A Date object representing the end of the advertisement's
     *                                         parent placement.
     * @return integer The number of impressions the advertisement should deliver in the next
     *                 operation interval.
     */
    function _getAdImpressionsByZonePattern($oAd, $totalRequiredAdImpressions, $oDate, $oPlacementExpiryDate)
    {
        // Check the parameters, and return 0 impressions if not valid
        if (!is_a($oAd, 'MAX_Entity_Ad') || !is_numeric($totalRequiredAdImpressions) ||
            !is_a($oDate, 'Date') || !is_a($oPlacementExpiryDate, 'Date')) {
            return 0;
        }
        // Create a new delivery limitaion object for the advertisement's delivery limitaitons
        $oDeliveryLimitation =
            new MAX_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
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
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
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
        $conf = $GLOBALS['_MAX']['CONF'];
        if (empty($adId) || !is_numeric($adId)) {
            MAX::debug("Invalid advertisement ID argument", PEAR_LOG_ERR);
            return false;
        }
        // Get all zones associated with the advertisement
        $aAdZones = $this->oDal->getAdZoneAssociationsByAds(array($adId));
        $aZones = @$aAdZones[$adId];
        // Initialise the results array with the number operation intervals in a week
        $aResults = array_fill(0, MAX_OperationInterval::operationIntervalsPerWeek(), 0);
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
