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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OX/Maintenance/Priority/Campaign.php';
require_once MAX_PATH . '/lib/OX/Maintenance/Priority/Zone.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * An abstract class used to define common methods required to calculate the number
 * of required impressions for campaigns and their children ads.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Priority
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
     * A variable for storing a local instance of the
     * OA_DB_Table_Priority class.
     *
     * @var OA_DB_Table_Priority
     */
    var $oTable;

    /**
     * The TZ for the current campaign
     *
     * @var type Date_Timezone
     */
    var $currentTz;

    /**
     * The class constructor method.
     *
     * @return OA_Maintenance_Priority_Common_Task_GetRequiredAdImpressions
     */
    function __construct()
    {
        parent::__construct();
        $this->oTable =& $this->_getMaxTablePriorityObj();
        $this->currentTz = new Date_TimeZone('UTC');
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
        $aAllCampaigns = $this->_getValidCampaigns();
        if (is_array($aAllCampaigns) && (count($aAllCampaigns) > 0)) {
            foreach ($aAllCampaigns as $k => $oCampaign) {
                // Store the Tz for the current campaign
                $this->currentTz = $this->oDal->getTimezoneForCampaign($oCampaign->id);

                $this->getCampaignImpressionInventoryRequirement($aAllCampaigns[$k]);
                $aAllCampaigns[$k]->setAdverts();
            }
            $this->distributeCampaignImpressions($aAllCampaigns);
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
     * campaigns that meet the requirements of the child class.
     *
     * @abstract
     * @access private
     * @return array An array of {@link OX_Maintenance_Priority_Campaign} objects.
     */
    function _getValidCampaigns() {}

    /**
     * A private method that can be used by implementations of _getValidCampaigns()
     * in children classes to return an array of OX_Maintenance_Priority_Campaign objects.
     *
     * @access private
     * @param array $where An optional array of where statements to limit which placements
     *                     are returned from the database (see the
     *                     {@link MAX_Dal_Maintenance::getCampaigns()} class.)
     * @return array An array of {@link OX_Maintenance_Priority_Campaign} objects, appropriate to the
     *               $where given.
     */
    function _getAllCampaigns($where = array())
    {
        return $this->oDal->getCampaigns($where);
    }



    /**
     * A method to estimate the impressions required to fulfill a campaign's
     * impression, click, or conversion requirements.
     *
     * The $oCampaign parameter is passed by reference and will have
     * the calculated impression requirement added to it in the position
     * $oCampaign->requiredImpressions
     *
     * @param OX_Maintenance_Priority_Campaign $oCampaign A reference to the campaign.
     * @param string $type Ether "total" or "daily", depending on whether the
     *                     required impressions should be based on the campaign
     *                     lifetime totals, or the campaign daily totals.
     * @param boolean $ignorePast When true, the required impressions will
     *                            ignore any delivery that has occurred to
     *                            date, to the value returned will represent
     *                            the expected TOTAL lifetime or daily
     *                            impressions required.
     */
    function getCampaignImpressionInventoryRequirement($oCampaign, $type, $ignorePast = false)
    {
        OA::debug('  - Getting impression inventory requirements for campaign ID: ' . $oCampaign->id, PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!$ignorePast) {
            // Get campaign summary statistic totals
            if ($type == 'total') {
                $oCampaign->setSummaryStatisticsToDate();
            } else {
                $oTodayDate = new Date($this->_getDate());
                $oTodayDate->convertTZ($this->currentTz);
                $oCampaign->setSummaryStatisticsToday($oTodayDate->format('%Y-%m-%d'));
            }
        }
        // Calculate impressions required to fulfill click requirement
        if ($type == 'total') {
            $clickTarget = $oCampaign->clickTargetTotal;
        } else {
            $clickTarget = $oCampaign->clickTargetDaily;
        }
        $clickImpressions = $this->_getInventoryImpressionsRequired(
            $clickTarget,
            $aConf['priority']['defaultClickRatio'],
            $oCampaign->deliveredClicks,
            $oCampaign->deliveredImpressions);
        // Calculate impressions required to fulfill conversion requirement
        if ($type == 'total') {
            $conversionTarget = $oCampaign->conversionTargetTotal;
        } else {
            $conversionTarget = $oCampaign->conversionTargetDaily;
        }
        $conversionImpressions = $this->_getInventoryImpressionsRequired(
            $conversionTarget,
            $aConf['priority']['defaultConversionRatio'],
            $oCampaign->deliveredConversions,
            $oCampaign->deliveredImpressions);
        // Get impression requirement
        if ($type == 'total') {
            $impressionTarget = $oCampaign->impressionTargetTotal;
        } else {
            $impressionTarget = $oCampaign->impressionTargetDaily;
        }

        if ($impressionTarget > 0) {
            $impressions = $impressionTarget - $oCampaign->deliveredImpressions;
        } else {
            $impressions = 0;
        }
        // Choose smallest required impression
        $requiredImpressions = $this->_getSmallestNonZeroInteger(
            array(
                $clickImpressions,
                $conversionImpressions,
                $impressions
            )
        );

        // Apply globally defined level of intentional over-delivery from
        // $GLOBALS['_MAX']['CONF']['priority']['intentionalOverdelivery'] to
        // the calculated required impressions
        if (isset($GLOBALS['_MAX']['CONF']['priority']['intentionalOverdelivery'])
                && is_numeric($GLOBALS['_MAX']['CONF']['priority']['intentionalOverdelivery'])
                && $GLOBALS['_MAX']['CONF']['priority']['intentionalOverdelivery'] > 0) {
            // Convert the % into a usable number
            $scale = 1 + ($GLOBALS['_MAX']['CONF']['priority']['intentionalOverdelivery'] / 100);
            // Final check
            if ($scale > 1) {
                $requiredImpressions = $requiredImpressions * $scale;
            }
        }

        $oCampaign->requiredImpressions = $requiredImpressions;

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
     * @param integer $inventory Total campaign inventory to be achieved over lifetime/day.
     * @param integer $defaultRatio Click/conversion ratio used if historical data does not exist.
     * @param integer $inventoryToDate Total clicks/conversions achieved to date over lifetime/day.
     * @param integer $impressionsToDate Total impressions delivered to date over lifetime/day.
     * @return integer The number of impressions that are required.
     */
    function _getInventoryImpressionsRequired($inventory, $defaultRatio, $inventoryToDate = 0, $impressionsToDate = 0)
    {
        if ($inventoryToDate >= $inventory) {
            return 0;
        }
        $requiredImpressions = 0;
        if ($inventory > 0) {
            // If historical information exists
            if ($inventoryToDate > 0) {
                $inventoryPerImpression = ($inventoryToDate / $impressionsToDate);
            } else {
                $inventoryPerImpression = $defaultRatio;
            }
            $requiredImpressions = (int)($inventory - $inventoryToDate) / $inventoryPerImpression;
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
     * A method to distribute the calculated required campaign impressions between the campaign's
     * children advertisements. Impression allocation takes in to account ad weight, and the number
     * of operations intervals the ad will be active in given date/time delivery limitations, and
     * the pattern of available impressions for the zone(s) the advertisements are linked to.
     *
     * The calculated ad impressions are written to the temporary table tmp_ad_required_impression
     * for later analysis by the {@link OA_Maintenance_Priority_AdServer_Task_AllocateZoneImpressions}
     * class.
     *
     * @param array $aCampaigns An array of {@link OX_Maintenance_Priority_Campaign} objects which require
     *                          that their total required impressions be distributed between the
     *                          component advertisements.
     */
    function distributeCampaignImpressions($aCampaigns)
    {
        // Create an array for storing required ad impressions
        $aRequiredAdImpressions = array();
        // Get the current operation interval start/end dates
        $aCurrentOperationIntervalDates =
            OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->_getDate());
        // For each campaign
        foreach ($aCampaigns as $oCampaign) {
            OA::debug('  - Distributing impression inventory requirements for campaign ID: ' . $oCampaign->id, PEAR_LOG_DEBUG);
            $adsCount = count($oCampaign->aAds);
            OA::debug("    - Campaign has $adsCount ads.", PEAR_LOG_DEBUG);
            // Get date object to represent campaign expiration date
            if (
                   ($oCampaign->impressionTargetDaily > 0)
                   ||
                   ($oCampaign->clickTargetDaily > 0)
                   ||
                   ($oCampaign->conversionTargetDaily > 0)
               ) {
                // The campaign has a daily target to meet, so treat the
                // campaign as if it expires at the end of "today", regardless
                // of the existance of any activation or expiration dates that
                // may (or may not) be set for the campaign
                $oCampaignExpiryDate = new Date($this->_getDate());
                $oCampaignExpiryDate->convertTZ($this->currentTz);
                $oCampaignExpiryDate->setHour(23);
                $oCampaignExpiryDate->setMinute(59);
                $oCampaignExpiryDate->setSecond(59);
                $oCampaignExpiryDate->toUTC();
                // Unless the campaign has an expiry date and it happens before the end of today
                if (!empty($oCampaign->expireTime)) {
                    if ($oCampaignExpiryDate->after($this->_getDate($oCampaign->expireTime))) {
                        $oCampaignExpiryDate  = $this->_getDate($oCampaign->expireTime);
                    }
                }
            } else if (
                   !empty($oCampaign->expireTime)
                   &&
                   (
                       ($oCampaign->impressionTargetTotal > 0)
                       ||
                       ($oCampaign->clickTargetTotal > 0)
                       ||
                       ($oCampaign->conversionTargetTotal > 0)
                   )
               ) {
                // The campaign has an expiration date, and has some kind of
                // (total) inventory requirement, so treat the campaign as if
                // it expires at the expiration date/time
                $oCampaignExpiryDate = $this->_getDate($oCampaign->expireTime);
            } else {
                // Error! There should not be any other kind of high-priority
                // campaign in terms of activation/expiration dates and
                // either (total) inventory requirements or daily targets
                $message = "- Error calculating the end date for Campaign ID {$oCampaign->id}";
                OA::debug($message, PEAR_LOG_ERR);
                continue;
            }
            // Determine number of remaining operation intervals for campaign
            $message = "    - Calculating campaign remaining operation intervals.";
            OA::debug($message, PEAR_LOG_DEBUG);
            $campaignRemainingOperationIntervals =
                OX_OperationInterval::getIntervalsRemaining(
                    $aCurrentOperationIntervalDates['start'],
                    $oCampaignExpiryDate
                );
            // For all ads in the campaign, determine:
            // - If the ad is capable of delivery in the current operation
            //   interval, or not, based on if it is linked to any zones, and,
            //   if so:
            // - If the ad is capable of delivery in the current operation
            //   interval, or not, based on delivery limitation(s), and if so;
            // - The result of the weight of the ad multiplied by the
            //   number of operation intervals remaining in which the ad
            //   is capable of delivering
            $aAdZones                             = array();
            $aAdDeliveryLimitations               = array();
            $aAdBlockedForCurrentOI               = array();
            $aAdWeightRemainingOperationIntervals = array();
            $aInvalidAdIds                        = array();
            reset($oCampaign->aAds);
            while (list($key, $oAd) = each($oCampaign->aAds)) {
                // Only calculate values for active ads
                if ($oAd->active && ($oAd->weight > 0)) {
                    $message = "    - Calculating remaining operation intervals for ad ID: {$oAd->id}";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    // Get all zones associated with the ad
                    $aAdsZones = $this->oDal->getAdZoneAssociationsByAds(array($oAd->id));
                    $aAdZones[$oAd->id] = @$aAdsZones[$oAd->id];
                    if (is_null($aAdZones[$oAd->id])) {
                        $aInvalidAdIds[] = $oAd->id;
                        $message = "      - Ad ID {$oAd->id} has no linked zones, will skip...";
                        OA::debug($message, PEAR_LOG_ERR);
                        continue;
                    }
                    // Prepare a delivery limitation object for the ad
                    $aAdDeliveryLimitations[$oAd->id]  = new OA_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
                    // Is the ad blocked from delivering in the current operation interval?
                    $aAdBlockedForCurrentOI[$oAd->id] = $aAdDeliveryLimitations[$oAd->id]->deliveryBlocked($aCurrentOperationIntervalDates['start']);
                    // Determine how many operation intervals remain that the ad can deliver in
                    $adRemainingOperationIntervals =
                        $aAdDeliveryLimitations[$oAd->id]->getActiveAdOperationIntervals(
                            $campaignRemainingOperationIntervals,
                            $aCurrentOperationIntervalDates['start'],
                            $oCampaignExpiryDate
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
            // operation interval, determine how many of the campaign's required
            // impressions should be alloced as the ad's required impressions
            // For each advertisement
            reset($oCampaign->aAds);
            while (list($key, $oAd) = each($oCampaign->aAds)) {
                if (in_array($oAd->id, $aInvalidAdIds)) {
                    OA::debug('       - Skipping ad ID: ' . $oAd->id, PEAR_LOG_DEBUG);
                    continue;
                }
                OA::debug('     - Calculating required impressions for ad ID: ' . $oAd->id, PEAR_LOG_DEBUG);
                // Get impressions required
                $totalRequiredAdImpressions = 0;
                if ($oAd->active && $oAd->weight > 0 && $aAdBlockedForCurrentOI[$oAd->id] !== true) {
                    $totalRequiredAdImpressions = $oCampaign->requiredImpressions *
                        ($aAdWeightRemainingOperationIntervals[$oAd->id] / $sumAdWeightRemainingOperationIntervals);
                }
                if ($totalRequiredAdImpressions <= 0) {
                    OA::debug('       - No required impressions for ad ID: ' . $oAd->id, PEAR_LOG_DEBUG);
                    continue;
                }
                // Based on the average zone pattern of the zones the ad is
                // linked to, calculate how many of these impressions should
                // be delivered in the next operation interval
                OA::debug('       - Calculating next OI required impressions for ad ID: ' . $oAd->id, PEAR_LOG_DEBUG);
                $oAd->requiredImpressions = $this->_getAdImpressions(
                        $oAd,
                        $totalRequiredAdImpressions,
                        $aCurrentOperationIntervalDates['start'],
                        $oCampaignExpiryDate,
                        $aAdDeliveryLimitations[$oAd->id],
                        $aAdZones[$oAd->id]
                );
                $aRequiredAdImpressions[] = array(
                    'ad_id'                => $oAd->id,
                    'required_impressions' => $oAd->requiredImpressions
                );

            }
        }
        // Save the required impressions into the temporary database table
        OA::setTempDebugPrefix('- ');
        // Check if table exists
        if (!isset($GLOBALS['_OA']['DB_TABLES']['tmp_ad_required_impression'])) {
            if ($this->oTable->createTable('tmp_ad_required_impression', null, true) !== false) {
                // Remember that table was created
                $GLOBALS['_OA']['DB_TABLES']['tmp_ad_required_impression'] = true;
            }
        }
        $this->oDal->saveRequiredAdImpressions($aRequiredAdImpressions);
    }

    /**
     * A private method to calcuate the number of impressions an advertisement needs to deliver
     * in the next operation interval, based on the total number of impressions the ad needs to
     * deliver over the rest of the campaigns, the operaion intervals the ad will be active
     * in, and the average zone pattern of the zones the ad is linked to.
     *
     * @access private
     * @param OA_Maintenance_Priority_Ad $oAd An ad object, representing the advertisement.
     * @param integer $totalRequiredAdImpressions The total number of impressions the advertisement
     *                                            needs to deliver.
     * @param PEAR::Date $oDate A Date object, set in the current operation interval.
     * @param PEAR::Date $oCampaignExpiryDate A Date object representing the end of the advertisement's
     *                                        parent campaign.
     * @param OA_Maintenance_Priority_DeliveryLimitation $oDeliveryLimitation The delivery limitation
     *                                                                        object for the ad.
     * @param array $aAdZones An array of arrays, no particular index in the outer array, in the
     *                        inner arrays, each as an index "zone_id" containing one zone ID that
     *                        the ad is linked to.
     * @return integer The number of impressions the advertisement should deliver in the next
     *                 operation interval.
     */
    function _getAdImpressions($oAd, $totalRequiredAdImpressions, $oDate, $oCampaignExpiryDate, $oDeliveryLimitation, $aAdZones)
    {
        // Check the parameters, and return 0 impressions if not valid
        if (!is_a($oAd, 'OA_Maintenance_Priority_Ad') || !is_numeric($totalRequiredAdImpressions) ||
            !is_a($oDate, 'Date') || !is_a($oCampaignExpiryDate, 'Date') ||
            !is_a($oDeliveryLimitation, 'OA_Maintenance_Priority_DeliveryLimitation') ||
            !is_array($aAdZones) || empty($aAdZones)) {
            OA::debug('- Invalid parameters in _getAdImpressions, skipping...', PEAR_LOG_ERR);
            return 0;
        }

        // This part must be run using the agency timezone
        $oStart = new Date($oDate);
        $oStart->convertTZ($this->currentTz);
        $oEnd = new Date($oCampaignExpiryDate);
        $oEnd->convertTZ($this->currentTz);

        if ($oDeliveryLimitation->deliveryBlocked($oStart) == true) {
            // The advertisement is not currently able to deliver, and so
            // no impressions should be allocated for this operation interval
            return 0;
        }

        // Get the cumulative associated zones forecasts for the previous week's
        // zone inventory forecasts, keyed by the operation interval ID
        $aCumulativeZoneForecast = $this->_getCumulativeZoneForecast($oAd->id, $aAdZones);
        // Get the total number of zone impressions remaining in which this
        // ad is capable of delivering (taking into account any operation
        // intervals where the ad is blocked)
        $totalAdLifetimeZoneImpressionsRemaining =
            $oDeliveryLimitation->getAdLifetimeZoneImpressionsRemaining(
                $oStart,
                $oEnd,
                $aCumulativeZoneForecast
            );
        // Are there impressions forecast?
        if ($totalAdLifetimeZoneImpressionsRemaining == 0) {
            return 0;
        }
        // Get the current operation interval ID
        $currentOperationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        // Scale the total required impressions for the ad over its lifetime
        // into the current operation interval forecast, relative to the total
        // zone-pattern based forecast for the remaining lifetime of the ad
        $scale = $aCumulativeZoneForecast[$currentOperationIntervalID] / $totalAdLifetimeZoneImpressionsRemaining;
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
     * @param array $aAdZones An array of arrays, no particular index in the outer array, in the
     *                        inner arrays, each as an index "zone_id" containing one zone ID that
     *                        the ad is linked to.
     * @return mixed Array on success, false on failure. If an array, it is of the format:
     *                  array(
     *                      [operation_interval_id] => forecast_impressions,
     *                      [operation_interval_id] => forecast_impressions
     *                                  .
     *                                  .
     *                                  .
     *                  )
     */
    function _getCumulativeZoneForecast($adId, $aAdZones)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (empty($adId) || !is_numeric($adId)) {
            OA::debug('- Invalid advertisement ID argument', PEAR_LOG_ERR);
            return false;
        }
        if (!is_array($aAdZones)) {
            OA::debug('- Invalid zone array argument', PEAR_LOG_ERR);
            return false;
        }
        // Initialise the results array with the number operation intervals in a week
        $aResults = array_fill(0, OX_OperationInterval::operationIntervalsPerWeek(), 0);
        // Get the forcast impressions for the previous week
        if (!empty($aAdZones)) {
            foreach ($aAdZones as $aZone) {
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
