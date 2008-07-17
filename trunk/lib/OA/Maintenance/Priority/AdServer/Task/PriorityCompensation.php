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
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OX/Maintenance/Priority/Zone.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * The minimum difference in the fraction of a zone's actual impressions that
 * an ad is given before priority compensation will be applied again -- that
 * is, if a priority compensation step doesn't change the ad's fraction of
 * impressions by more than this amount, then don't try to compensate any
 * further.
 */
define('ZONE_TRAFFIC_FRACTION_MINIMUM_DELTA', 0.1);

/**
 * The base factor, used when a zero factor found, and used as the
 * multiplication value when compensating under the case where no past
 * zone fraction can be found.
 */
define('BASE_FACTOR', 10);

/**
 * A class to carry out the task of compensating priority values, to ensure
 * delivery is as accurate as it can be, and to calculate the priority values
 * to be used for each advertisement in each zone.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 *
 * @TODO Remove code that emails details about problems with delivery - only in
 * place at present to assist with debugging...
 */
class OA_Maintenance_Priority_AdServer_Task_PriorityCompensation extends OA_Maintenance_Priority_AdServer_Task
{
    var $globalMessage;

    /**
     * The array of dates when the MPE last ran
     *
     * @var Array of Date strings relating to the last run info
     */
    var $aLastRun;

    /**
     * The main method of the class, that is run by the controlling
     * task runner class.
     */
    function run()
    {
        OA::debug('Running Maintenance Priority Engine: Priority Compensation', PEAR_LOG_DEBUG);
        // Record the start of this Priority Compensation run
        $oStartDate = new Date();
        // Prepare an array for the priority results
        $aPriorities = array();
        // Get the details of the last time Priority Compensation started running
        $aDates =
            $this->oDal->getMaintenancePriorityLastRunInfo(
                DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION,
                array('start_run', 'end_run')
            );
        if (!is_null($aDates)) {
            // Set the details of the last time Priority Compensation started running
            $this->aLastRun['start_run'] = new Date($aDates['start_run']);
            // Set the details of the current date/time
            $oServiceLocator =& OA_ServiceLocator::instance();
            $this->aLastRun['now'] =& $oServiceLocator->get('now');
        }
        // Get all zone/ad information
        $aZones =& $this->_buildClasses();
        // For every zone with ads linked to it...
        if (!empty($aZones)) {
            $this->globalMessage = '';
            foreach ($aZones as $oZone) {
                // Calculate the priorities based on the required impression
                // values and the past information about previous priorities
                $aPriorities[$oZone->id] = $this->learnedPriorities($oZone);
            }
            // Store the calculated priorities
            $this->oDal->updatePriorities($aPriorities);
            // Record the completion of the task in the database
            // Note that the $oUpdateTo parameter is "null", as this value is not
            // appropriate when recording Priority Compensation task runs - all that
            // matters is the start/end dates.
            OA::debug('- Recording completion of the Priority Compensation task', PEAR_LOG_DEBUG);
            $oEndDate = new Date();
            $this->oDal->setMaintenancePriorityLastRunInfo(
                $oStartDate,
                $oEndDate,
                null,
                DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION
            );
        }
    }

    /**
     * return a MAX_Entity_Ad object
     */
    function _getMaxEntityAdObject($id)
    {
        return new OA_Maintenance_Priority_Ad(array('ad_id' => $id));
    }

    /**
     * A private method to construct the classes used in performing
     * priority compensation.
     *
     * @access private
     * @return mixed An array of Zone objects, each populated with the
     *               relevant Advert objects and data.
     */
    function &_buildClasses()
    {
        OA::debug('- Building zone and advert objects', PEAR_LOG_DEBUG);
        // Obtain the forecast impression inventory for each zone for the current OI
        $aZoneImpInvs =& $this->oDal->getAllZonesImpInv();
        // Create an array of all of the zones, indexed by zone ID
        $aZones = array();
        if (is_array($aZoneImpInvs) && !empty($aZoneImpInvs)) {
            foreach ($aZoneImpInvs as $aZoneImpInv) {
                // Create and store the Zone object
                $aZones[$aZoneImpInv['zone_id']] = new OX_Maintenance_Priority_Zone(array('zoneid' => $aZoneImpInv['zone_id']));
                // Record the zone's forecast impression inventory
                $aZones[$aZoneImpInv['zone_id']]->availableImpressions = $aZoneImpInv['forecast_impressions'];
                // Record the zone's previous operation interval actual impressions
                $aZones[$aZoneImpInv['zone_id']]->pastActualImpressions = $aZoneImpInv['actual_impressions'];
            }
        }
        // Obtain the ad/zone combinations where advertisements have had
        // impressions allocated to zones
        $aZoneImpAllocs =& $this->oDal->getAllZonesWithAllocInv();
        // Get a list of all active, high-priority ads where the delivery limitations have changed
        $aDeliveryLimitationChangedAds =& $this->oDal->getAllDeliveryLimitationChangedAds($this->aLastRun);
        // Add Advert objects to the zones
        if (is_array($aZoneImpAllocs) && !empty($aZoneImpAllocs))
        {
            foreach ($aZoneImpAllocs as $aZoneImpAlloc)
            {
                // Create a OA_Maintenance_Priority_Ad object
                $oAd = $this->_getMaxEntityAdObject($aZoneImpAlloc['ad_id']);

                // Assign the required impressions for this ad/zone
                $oAd->requiredImpressions = $aZoneImpAlloc['required_impressions'];
                // Assign the requested impressions for this ad/zone
                $oAd->requestedImpressions = $aZoneImpAlloc['requested_impressions'];
                // Mark the ad as to be delivered or not
                $oAd->toBeDelivered = $aZoneImpAlloc['to_be_delivered'];
                // Set a flag for any ads where the delivery limitations have changed
                if (isset($aDeliveryLimitationChangedAds[$aZoneImpAlloc['ad_id']]) &&
                    $aDeliveryLimitationChangedAds[$aZoneImpAlloc['ad_id']] != '0000-00-00 00:00:00') {
                    $oAd->deliveryLimitationChanged = true;
                }
                // Add the Advert object to the appropriate Zone object
                if (!empty($aZones[$aZoneImpAlloc['zone_id']])) {
                    $aZones[$aZoneImpAlloc['zone_id']]->addAdvert($oAd);
                } else {
                    $message  = '  - Attempted to link Ad ID ' . $oAd->id . ' ';
                    $message .= 'to non-existant Zone ID ' . $aZoneImpAlloc['zone_id'];
                    OA::debug($message, PEAR_LOG_WARNING);

                }
            }
        }
        // Get the details of the previous required/delivered ad impressions and
        // calculated priorities
        $aPastDetails =& $this->oDal->getPreviousAdDeliveryInfo($aZones);
        if (is_array($aPastDetails) && !empty($aPastDetails)) {
            foreach ($aPastDetails as $aAdPastDetails) {
                foreach ($aAdPastDetails as $aPastDetail) {
                    // Only insert the past details for ads that are still linked to the same zone
                    if (isset($aZones[$aPastDetail['zone_id']]->aAdverts[$aPastDetail['ad_id']])) {
                        if (!is_null($aPastDetail['required_impressions'])) {
                            $aZones[$aPastDetail['zone_id']]->aAdverts[$aPastDetail['ad_id']]->pastRequiredImpressions
                                = $aPastDetail['required_impressions'];
                        }
                        if (!is_null($aPastDetail['requested_impressions'])) {
                            $aZones[$aPastDetail['zone_id']]->aAdverts[$aPastDetail['ad_id']]->pastRequestedImpressions
                                = $aPastDetail['requested_impressions'];
                        }
                        if (!is_null($aPastDetail['to_be_delivered'])) {
                            $aZones[$aPastDetail['zone_id']]->aAdverts[$aPastDetail['ad_id']]->pastToBeDelivered
                                = $aPastDetail['to_be_delivered'];
                        }
                        if (!is_null($aPastDetail['impressions'])) {
                            $aZones[$aPastDetail['zone_id']]->aAdverts[$aPastDetail['ad_id']]->pastActualImpressions
                                = $aPastDetail['impressions'];
                        }
                        if (!is_null($aPastDetail['priority_factor'])) {
                            $aZones[$aPastDetail['zone_id']]->aAdverts[$aPastDetail['ad_id']]->pastAdZonePriorityFactor
                                = $aPastDetail['priority_factor'];
                        }
                        if (!is_null($aPastDetail['past_zone_traffic_fraction'])) {
                            $aZones[$aPastDetail['zone_id']]->aAdverts[$aPastDetail['ad_id']]->pastZoneTrafficFraction
                                = $aPastDetail['past_zone_traffic_fraction'];
                        }
                    }
                }
            }
        }
        return $aZones;
    }

    /**
     * A method for scaling the advertisement and blank priorities in a zone
     * so that the sum of the priorities is unity.
     *
     * Note that the input values are normally simply the required number
     * of impressions for each advertisement, and the number of remaining
     * impressions in the zone.
     *
     * @param mixed $aParams A hash with with following indexes:
     *                 - "ads" An array (indexed by ad id) of hashes,
     *                         each hash containing the following
     *                         indexes/data:
     *                          - "ad_id"                 The ad ID.
     *                          - "zone_id"               The zone ID.
     *                          - "priority"              The ad/zone priority value.
     *                          - "requested_impressions" The number of impressions the priority
     *                                                    should result in.
     *                 - "blank" The blank priority for the zone.
     */
    function scalePriorities(&$aParams, $adjust = false)
    {
        // Find sum of values
        $total = 0;
        foreach ($aParams['ads'] as $ad) {
            $total += $ad['priority'];
        }
        $total += $aParams['blank'];
        // Ensure the total is > 0
        if ($total <= 0) {
            // Cannot scale, return original values
            return;
        }
        // If total is 1, no need to scale
        if ($total == 1) {
            return;
        }
        // Scale non-blank priorities
        foreach ($aParams['ads'] as $key => $ad) {
            $aParams['ads'][$key]['priority'] /= $total;
        }
        // Scale blank priority
        $aParams['blank'] /= $total;
    }

    /**
     * A method for creating an array of initial priority values.
     *
     * @param Zone $oZone A Zone object, containing the relevant zone
     *                    data and associated Adverts.
     * @return mixed A hash with with following indexes:
     *                 - "ads" An array (indexed by ad id) of hashes, each
     *                   hash containing the following indexes/data:
     *                          - "ad_id"                 The ad ID.
     *                          - "zone_id"               The zone ID.
     *                          - "priority"              The ad/zone priority value.
     *                          - "requested_impressions" The number of impressions the priority
     *                                                    should result in.
     *                 - "blank" The blank priority for the zone.
     */
    function initialPriorities($oZone)
    {
        $result = array('ads' => array());
        // Test available zone impressions > 0
        if ($oZone->availableImpressions <= 0) {
            // There are no zone impressions, so there cannot be any
            // priorities, so assign each ad a priority of zero, and
            // assign 1 as the initial blank priority
            foreach ($oZone->aAdverts as $oAdvert) {
                $result['ads'][$oAdvert->id] = array(
                    'ad_id'                 => $oAdvert->id,
                    'zone_id'               => $oZone->id,
                    'priority'              => 0,
                    'priority_factor'       => 1,
                    'required_impressions'  => $oAdvert->requiredImpressions,
                    'requested_impressions' => $oAdvert->requestedImpressions,
                    'to_be_delivered'       => $oAdvert->toBeDelivered,
                    'campaign_priority'     => $oAdvert->campaignPriority
                );
            }
            $result['blank'] = 1;
            return $result;
        }
        // For each advertisement in the zone, calculate the initial
        // priority as the number of requested impressions for each
        // advertisement divided by the total number of available
        // impressions in the zone. Increment a counter of the number
        // of allocated impressions as this is done.
        $usedImpressions = 0;
        foreach ($oZone->aAdverts as $oAdvert) {
            $result['ads'][$oAdvert->id] = array(
                'ad_id'                 => $oAdvert->id,
                'zone_id'               => $oZone->id,
                'priority'              => $oAdvert->requestedImpressions
                                           / $oZone->availableImpressions,
                'priority_factor'       => 1,
                'required_impressions'  => $oAdvert->requiredImpressions,
                'requested_impressions' => $oAdvert->requestedImpressions,
                'to_be_delivered'       => $oAdvert->toBeDelivered,
                'campaign_priority'     => $oAdvert->campaignPriority
            );
            $usedImpressions += $oAdvert->requestedImpressions;
        }
        // Were there more impressions allocated than exist?
        if ($usedImpressions >= $oZone->availableImpressions) {
            // Initial blank priority of zero
            $result['blank'] = 0;
        } else {
            // Initial blank priority of remaining impressions divided
            // by the total number of available impressions.
            $result['blank'] =
                ($oZone->availableImpressions - $usedImpressions)
                / $oZone->availableImpressions;
        }
        // Scale the priority values
        $this->scalePriorities($result);
        return $result;
    }

    /**
     * A method for creating an array of learned priority values.
     *
     * @param Zone $oZone A Zone object, containing the relevant zone
     *                    data and associated Adverts.
     * @return mixed A hash with with following indexes:
     *                 - "ads" An array (indexed by ad id) of hashes, each
     *                   hash containing the following indexes/data:
     *                          - "ad_id"                       The ad ID.
     *                          - "zone_id"                     The zone ID.
     *                          - "priority"                    The ad/zone priority value.
     *                          - "requested_impressions"       The number of impressions the priority
     *                                                          should result in.
     *                          - "priority_factor"             The adjustment factor applied to the
     *                                                          ad's priority.
     *                          - "past_zone_traffic_fraction"  The fraction of the zone's impressions
     *                                                          given to the ad in the previous operation
     *                                                          interval.
     *                 - "blank" The blank priority for the zone.
     */
    function learnedPriorities($oZone)
    {
        // Calculate the priority values the normal way
        $result = $this->initialPriorities($oZone);
        // Adjust each ad's priority value based on past data
        foreach ($oZone->aAdverts as $oAdvert) {
            // Calculate the ad's priority adjustment factor
            list($factor, $limited, $fraction, $to_be_delivered) =
                $this->_getPriorityAdjustment($oAdvert,
                                              $oZone->pastActualImpressions,
                                              $oZone->id);
            // Store if the ad is meant to be delivered, or not
            $result['ads'][$oAdvert->id]['to_be_delivered'] = $to_be_delivered;
            // Store the ad's priority adjustment factor
            $result['ads'][$oAdvert->id]['priority_factor'] = $factor;
            // Store if the ad's priority adjustment factor was limited, or not
            $result['ads'][$oAdvert->id]['priority_factor_limited'] = $limited;
            // Store the fraction of the zone's impressions used by the ad in
            // the previous operation interval
            $result['ads'][$oAdvert->id]['past_zone_traffic_fraction'] = $fraction;
        }
        // Do not scale the priority values, scaling will be done during delivery
        return $result;
    }

    /**
     * A private function for calculating how much an advert's priority
     * value needs to be adjusted.
     *
     * @access private
     * @param Advert $oAdvert An Advert object.
     * @param integer $zoneImpressions The total number of (actual) impressions in the
     *                                 zone (for which the ad's priority is being
     *                                 adjusted) in the previous operation interval.
     * @param integer $zoneId The zone's ID.
     * @return array An array containing:
     *                  - A double, being the ad's priority adjustment factor
     *                  - A boolean, true if the factor was limited in any way,
     *                               false otherwise.
     *                  - A double, being the fraction of the zone's impressions given
     *                    to the ad in the previous operation interval.
     *                  - A boolean, true if the ad is supposed to be delivered
     */
    function _getPriorityAdjustment($oAdvert, $zoneImpressions, $zoneId)
    {
        if (!empty($oAdvert->deliveryLimitationChanged) && $oAdvert->deliveryLimitationChanged == true) {
            // This ad has had it delivery limitations changed, so ignore history
            $message  = sprintf('    - Ad ID %5d in zone ID %5d ', $oAdvert->id, $zoneId);
            $message .= 'has had its delivery limitations changed - Using priority factor of 1';
            $this->globalMessage .= $message . "\n";
            return array(1, false, null, 1);
        }
        if (isset($oAdvert->toBeDelivered) && $oAdvert->toBeDelivered == false) {
            // This ad is not meant to be delivered, so ignore history
            $message  = sprintf('    - Ad ID %5d in zone ID %5d ', $oAdvert->id, $zoneId);
            $message .= 'is not meant to be delivered because of higher CP - Using priority factor of 1';
            $this->globalMessage .= $message . "\n";
            return array(1, false, null, 0);
        }
        if (!is_null($oAdvert->pastRequestedImpressions) && ($oAdvert->pastRequestedImpressions != 0) &&
            !is_null($oAdvert->pastActualImpressions) && ($oAdvert->pastActualImpressions != 0)) {
            // Calculate the fraction of the zone traffic that was seen
            // by the advertisement in the past interval
            if ($zoneImpressions > 0) {
                $fraction = $oAdvert->pastActualImpressions / $zoneImpressions;
            } else {
                unset($fraction);
            }
            // Is this fraction much different to the fraction before that,
            // given that a past fraction exists, and the ad has had priority
            // compensation priority adjustment factor applied before?
            if (!is_null($oAdvert->pastZoneTrafficFraction) &&
                !is_null($oAdvert->pastAdZonePriorityFactor) &&
                !is_null($fraction)) {
                $difference = abs($fraction - $oAdvert->pastZoneTrafficFraction);
                $differenceDelta = $difference / $fraction;
                if ($differenceDelta < ZONE_TRAFFIC_FRACTION_MINIMUM_DELTA) {
                    // Don't bother with additional priority compensation, assuming
                    // we want to adjust the priority in the same direction as
                    // before
                    list($factor, $limited) = $this->_calculateFactor($oAdvert->id,
                                                                      $zoneId,
                                                                      $oAdvert->pastAdZonePriorityFactor,
                                                                      $oAdvert->pastRequestedImpressions,
                                                                      $oAdvert->pastActualImpressions,
                                                                      false);
                    return array($factor, $limited, $fraction, 1);
                }
            }
            // Any previous priority compensation had an affect, do we want to
            // try even more priority adjustment?
            if (!is_null($oAdvert->pastAdZonePriorityFactor)) {
                list($factor, $limited) = $this->_calculateFactor($oAdvert->id,
                                                                  $zoneId,
                                                                  $oAdvert->pastAdZonePriorityFactor,
                                                                  $oAdvert->pastRequestedImpressions,
                                                                  $oAdvert->pastActualImpressions,
                                                                  true);
                return array($factor, $limited, $fraction, 1);
            }
            // We can't adjust the priority any more, or no previous adjustment,
            // so perform basic adjustment based on the past operation interval's
            // performance
            $factor = $oAdvert->pastRequestedImpressions / $oAdvert->pastActualImpressions;
            return array($factor, false, $fraction);
        } elseif (!is_null($oAdvert->pastRequestedImpressions) && ($oAdvert->pastRequestedImpressions != 0) &&
                  (is_null($oAdvert->pastActualImpressions) || ($oAdvert->pastActualImpressions == 0))) {
            // It is not possible to calculate the fraction of the zone traffic that
            // was seen by the advertisement in the past interval, as no impressions
            // were actually delivered, despite the fact that impressions were
            // required. As a result, bump the priority up by 10, unless it was not meant
            // to be delivered or the past ad zone priority factor is already >= mt_getrandmax().
            $message  = '    - Ad ID ' . $oAdvert->id . ' in zone ID ' . $zoneId . ' ';
            $message .= sprintf('had required impressions of %d', $oAdvert->pastRequestedImpressions);
            $message .= ', but no delivered impressions:';
            $this->globalMessage .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
            if ($oAdvert->pastToBeDelivered == 0) {
                $message = '      - CORRECT! Ad was not meant to be delivered!';
                $this->globalMessage .= $message . "\n";
                OA::debug($message, PEAR_LOG_DEBUG);
            } elseif (is_null($oAdvert->pastAdZonePriorityFactor)) {
                $message = '      - WARNING! Ad has a null past zone priority factor!';
                $this->globalMessage .= $message . "\n";
                OA::debug($message, PEAR_LOG_DEBUG);
            } else {
                if ($oAdvert->pastAdZonePriorityFactor != 0) {
                    $newFactor = $oAdvert->pastAdZonePriorityFactor * BASE_FACTOR;
                    if ($newFactor < MAX_RAND) {
                        // Update the ad zone priority factor
                        $message = '      - Using new priority factor of ';
                        $message .= sprintf('%.5f.', $newFactor);
                        $this->globalMessage .= $message . "\n";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        return array($newFactor, false, 0, 1);
                    } else {
                        // Use the past ad zone priority factor
                        $newFactor = $oAdvert->pastAdZonePriorityFactor;
                        $message = '      - Re-using priority factor of ';
                        $message .= sprintf('%.5f.', $newFactor);
                        $this->globalMessage .= $message . "\n";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        if ($newFactor > MAX_RAND) {
                            $newFactor = MAX_RAND / 2;
                            $message = '      - OMG!!! PONIES!!! The value above is > MAX_RAND! Using MAX_RAND / 2: ' .
                                       sprintf('%.5f.', $newFactor);
                            $this->globalMessage .= $message . "\n";
                            OA::debug($message, PEAR_LOG_DEBUG);
                        }
                        return array($newFactor, true, 0, 1);
                    }
                } else {
                    // Use a new base factor
                    $newFactor = BASE_FACTOR;
                    $message = '      - Found a zero priority factor, so using base factor of ';
                    $message .= sprintf('%.5f.', $newFactor);
                    $this->globalMessage .= $message . "\n";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    return array($newFactor, false, 0, 1);
                }
            }
        }
        // No past information, so use a factor of 1
        return array(1, false, null, 1);
    }

    /**
     * A private function for calculating the prioritisation adjustment factor
     * to use.
     *
     * @param integer $adId The ad's ID.
     * @param integer $zoneId The zone's ID.
     * @param double $oldFactor  The previous priority adjustment factor
     * @param integer $required  The number of impressions required in the past interval.
     * @param integer $delivered The number of impressions delivered in the past interval.
     * @param boolean $useNew    True if new new factor should be used when valid, false
     *                           to use the previous factor when valid. A new base factor
     *                           is used regardless in the case that either the new factor
     *                           or the previous factor are not valid.
     * @return array An array containing:
     *                  - A double, being the priority adjustment factor to use.
     *                  - A boolean, true if the factor was limited in any way,
     *                               false otherwise.
     */
    function _calculateFactor($adId, $zoneId, $oldFactor, $required, $delivered, $useNew)
    {
        // If no impressions were delivered last interval, can't adjust priority
        if ($delivered == 0) {
            return array(1, false);
        }
        // Calculate the base priority adjustment factor, on the basis of the
        // past interval's performance
        $baseFactor = $required / $delivered;
        // If the base factor is unity, then the factor from the last interval
        // was exactly, right, so don't bother calculating the factor again
        if ($baseFactor == 1) {
            return array($oldFactor, false);
        }
        // By default, the new factor will not be limited
        $limited = false;
        // Calculate the full priority adjustment factor, on the basis of the
        // product of the past factor and the new base factor
        $fullFactor = $oldFactor * $baseFactor;
        // Is the full factor able to be used?
        if (is_infinite($fullFactor) || is_nan($fullFactor)) {
            // Unable to calculate the full factor, so just use the
            // factor from the previous interval as the new factor
            $newFactor = $oldFactor;
            $message  = sprintf('  * Ad ID %5d in zone ID %5d ', $adId, $zoneId);
            $message .= 'had a calculated factor outside of limits of supported numbers, using old value of';
            $message .= sprintf('%23.5f.', $newFactor);
            $this->globalMessage .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
        } elseif ($fullFactor > MAX_RAND) {
            // The full factor is greater than the limit set by the value of mt_getrandmax(),
            // so don't use the full factor - instead, use a value half way between the old
            // factor value, and the upper limit of compensation
            $delta = abs(MAX_RAND - $oldFactor) / 2;
            $newFactor = $oldFactor + $delta;
            $limited = true;
            $message  = sprintf('  * Ad ID %5d in zone ID %5d ', $adId, $zoneId);
            $message .= 'had a calculated factor > mt_getrandmax() limits, using new value of';
            $message .= sprintf('%42.5f.', $newFactor);
            $this->globalMessage .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
            if ($newFactor > MAX_RAND) {
                $newFactor = MAX_RAND / 2;
                $message = '    OMG!!! PONIES!!! The value above is > MAX_RAND! Using MAX_RAND / 2:' .
                           sprintf('%70.5f.', $newFactor);
                $this->globalMessage .= $message . "\n";
                OA::debug($message, PEAR_LOG_DEBUG);
            }
        } elseif ($fullFactor < MAX_RAND_INV) {
            // The full factor is less than the limit set by the value of mt_getrandmax(),
            // so don't use the full factor - instead, use a value half way between the old
            // factor value, and the lower limit of compensation
            $delta = abs($oldFactor - MAX_RAND_INV) / 2;
            $newFactor = $oldFactor - $delta;
            $limited = true;
            $message  = sprintf('  * Ad ID %5d in zone ID %5d ', $adId, $zoneId);
            $message .= 'had a calculated factor < mt_getrandmax() limits, using new value of';
            $message .= sprintf('%42.5f.', $newFactor);
            $this->globalMessage .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
        } else {
            // Use the full factor as the new factor
            $newFactor = $fullFactor;
        }
        if ((($baseFactor > 1) && ($newFactor > 1)) ||
            (($baseFactor < 1) && ($newFactor < 1))) {
            // The new factor is correcting the same direction as
            // the base factor, so use the new factor if requested,
            // or the old factor if not
            if ($useNew) {
                return array($newFactor, $limited);
            } else {
                return array($oldFactor, false);
            }
        } else {
            // The new factor is correcting the opposite direction
            // to the base factor, so use the new factor if
            // requested, but the new base factor if not
            if ($useNew) {
                return array($newFactor, $limited);
            } else {
                return array($baseFactor, false);
            }
        }
    }

}

?>
