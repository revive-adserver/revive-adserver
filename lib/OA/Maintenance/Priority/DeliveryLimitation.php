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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Factory.php';
require_once LIB_PATH . '/OperationInterval.php';

/**
 * A class for managing a group of delivery limitations associated with an
 * advertisement, with the goal of determining if (and if so, when) the
 * delivery limitation(s) "block" (as opposed to "filter") the advertisement.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 */
class OA_Maintenance_Priority_DeliveryLimitation
{

    /**
     * An array for storing all of the delivery limitations for the ad.
     *
     * @var array
     */
    var $aRules           = array();

    /**
     * An array for storing all of the delivery limitations for the ad
     * that related to blocking limitations.
     *
     * @var array
     */
    var $aOperationGroups = array();

    /**
     * An integer to store how many operation intervals in the remaining
     * campaign lifetime are blocked by delivery limitations. Set when
     * the getActiveAdOperationIntervals() method is called.
     *
     * @var integer
     */
    var $blockedOperationIntervalCount;

    /**
     * An array to store an array of the start/end dates of any operation
     * intervals found that are blocked. Indexed by the operation interval
     * start date in "YYYY-MM-DD HH:MM:SS" format. Set when
     * the getActiveAdOperationIntervals() method is called.
     *
     * @var array
     */
    var $aBlockedOperationIntervalDates;

    /**
     * An integer to store how many operation intervals exist in the
     * remaining campaign lifetime. Set when the
     * getActiveAdOperationIntervals() method is called.
     *
     * @var integer
     */
    var $remainingOperationIntervalCount;

    /**
     * Constructor method.
     *
     * @param array $aDeliveryLimitations An array or arrays, each containing the details of a
     *                                    delivery limitation associated with an ad. For example:
     *                                    array(
     *                                        [0] => array(
     *                                                   [ad_id]             => 1
     *                                                   [logical]           => and
     *                                                   [type]              => Time:Hour
     *                                                   [comparison]        => ==
     *                                                   [data]              => 1,7,18,23
     *                                                   [executionorder]    => 0
     *                                                ),
     *                                        [1] => array(
     *                                                   [ad_id]             => 1
     *                                                   [logical]           => and
     *                                                   [type]              => Time:Day
     *                                                   [comparison]        => !=
     *                                                   [data]              => '2005-06-32'
     *                                                   [executionorder]    => 1
     *                                                ),
     *                                          .
     *                                          .
     *                                          .
     *                                    )
     * @return OA_Maintenance_Priority_DeliveryLimitation
     */
    function __construct($aDeliveryLimitations)
    {
        // If there are delivery limitations...
        if (is_array($aDeliveryLimitations) && (!empty($aDeliveryLimitations))) {
            // Sort the array of limitations so that they are ordered by execution order
            $aSort = array();
            foreach ($aDeliveryLimitations as $key => $aDeliveryLimitation) {
                $aSort[$key] = $aDeliveryLimitation['executionorder'];
            }
            array_multisort($aSort, SORT_ASC, $aDeliveryLimitations);
            // For each delivery limitation, in execution order...
            $groupNumber = 0;
            foreach ($aDeliveryLimitations as $key => $aDeliveryLimitation) {
                // Instantiate an appropriate delivery limitation class for the limitation type
                $this->aRules[$key] = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
                // Is the logical grouping AND or OR?
                if (!is_a($this->aRules[$key], 'pear_error') && strtolower($this->aRules[$key]->logical) == 'or') {
                    // Start a new grouping for the next (set of) rule(s)
                    $groupNumber++;
                }
                // Store possible "blocking" delivery limitations classes ONLY in
                // the appropriately numbered operation group, for later testing
                if (is_a($this->aRules[$key], 'OA_Maintenance_Priority_DeliveryLimitation_Common')) {
                    $this->aOperationGroups[$groupNumber][] = $this->aRules[$key];
                }
            }
        }
    }

    /**
     * A private method that returns the number of different AND grouped
     * delivery limitations (i.e. operation groups) in the collection that
     * have at least one possible "blocking" delivery limitation in them.
     *
     * @access private
     * @return integer
     */
	function _getOperationGroupCount()
	{
	    return count($this->aOperationGroups);
	}

    /**
     * A method to check if the group of delivery limitations will block delivery
     * for the ad, given a Date representing a time in an operation interval for
     * which delivery blocking is desired to be tested.
     *
     * @param PEAR::Date $oDate An PEAR::Date object, representing a date/time in
     *                          the operation interval to test.
     * @return bool True if delivery would be blocked by the group of delivery
     *              limitations, false otherwise (i.e. the ad CAN deliver).
     */
    function deliveryBlocked($oDate)
    {
        // Are there any possible blocking operation groups?
        if ($this->_getOperationGroupCount() == 0) {
            // There are no possible blocking operation groups, so the
            // advertisement is not blocked by these limitations
            return false;
        }
        $aFlags = array();
        // For each "operation group"...
        foreach ($this->aOperationGroups as $groupKey => $aOperationGroup) {
            // For each limitation in the group...
            foreach ($aOperationGroup as $oDeliveryLimitation) {
                if ($oDeliveryLimitation->deliveryBlocked($oDate)) {
                    // Delivery is blocked, set to "true" (one)
                    $aFlags[$groupKey][] = 1;
                } else {
                    // Delivery is not blocked, set to "false" (zero)
                    $aFlags[$groupKey][] = 0;
                }
            }
        }
        return $this->_deliveryBlocked($aFlags);
    }

    /**
     * A method to calculate the number of operation intervals, from a given
     * date to the end date of the campaign, an advertisement will be blocked
     * from delivering in.
     *
     * @param PEAR::Date $oStartDate A Date object representing the start of the
     *                               current operation interval.
     * @param PEAR::Date $oEndDate A Date object representing the end date of the
     *                             campaign the advertisement is in.
     * @return integer The number of operation intervals in which the advertisement
     *                 will be blocked from delivering in.
     */
    function getBlockedOperationIntervalCount($oStartDate, $oEndDate)
    {
        // Ensure the campaign end date is at the END of the day
        $oCampaignEndDate = new Date();
        $oCampaignEndDate->copy($oEndDate);
        $oCampaignEndDate->setHour(23);
        $oCampaignEndDate->setMinute(59);
        $oCampaignEndDate->setSecond(59);
        // Copy the starting date to use in a loop
        $oLoopDate = new Date();
        $oLoopDate->copy($oStartDate);
        // Count the number of blocked operation intervals
        $blockedIntervals = 0;
        while (!$oLoopDate->after($oCampaignEndDate)) {
            if ($this->deliveryBlocked($oLoopDate)) {
                // Update the count of blocked intervals, but
                // also store the start/end dates of the blocked
                // interval for later use
                $blockedIntervals++;
                $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oLoopDate);
                $this->aBlockedOperationIntervalDates[$aDates['start']->format('%Y-%m-%d %H:%M:%S')] = $aDates;
            }
            $oLoopDate->addSeconds(OX_OperationInterval::secondsPerOperationInterval());
        }
        return $blockedIntervals;
    }

    /**
     * A method to determine how many of the remaining operation intervals
     * (based on the current date, and the campaign end date) the advertisement
     * will be able to deliver in.
     *
     * @param integer $campaignRemainingIntervals The number of remaining operation intervals
     *                                            until the campaign expiration date.
     * @param PEAR::Date $oDate A Date object, set in the current operation interval.
     * @param PEAR::Date $oCampaignEndDate The end date of the campaign.
     * @return integer The number of operation intervals in which the advertisement
     *                 will deliver.
     */
    function getActiveAdOperationIntervals($campaignRemainingIntervals, $oDate, $oCampaignEndDate)
	{
	    $aConf = $GLOBALS['_MAX']['CONF'];
	    $this->remainingOperationIntervalCount = $campaignRemainingIntervals;
        // Are delivery limitations activated in the configuration? If not, return
        // the complete count of remaining campaign operation intervals
        if (!$aConf['delivery']['acls']) {
            $this->blockedOperationIntervalCount = 0;
            return $campaignRemainingIntervals;
        }
        // Are there any possible blocking operation groups? If not, return the
        // complete count of remaining campaign operation intervals
        if ($this->_getOperationGroupCount() == 0) {
            $this->blockedOperationIntervalCount = 0;
            return $campaignRemainingIntervals;
        }
        // Determine in how many of the remaining operation intervals the
        // advertisement will be blocked
        $blockedIntervals = $this->getBlockedOperationIntervalCount($oDate, $oCampaignEndDate);
        $this->blockedOperationIntervalCount = $blockedIntervals;
        return ($campaignRemainingIntervals - $blockedIntervals);
	}

	/**
	 * A method to obtain the sum of the zone forecast impression value, for all the zones
	 * an advertisement is linked to, cloned out over the advertisement's entire remaining
	 * lifetime in the campaign, with any blocked operation intervals removed.
	 *
	 * Requires that the getActiveAdOperationIntervals() method have previously been
	 * called to function correctly.
	 *
	 * @param PEAR::Date $oNowDate The current date.
	 * @param PEAR::Date $oEndDate The end date of the campaign. Note that if the end
	 *                             date supplied is not at the end of a day, it will be
	 *                             converted to be treated as such.
	 * @param array $aCumulativeZoneForecast The cumulative forecast impressions, indexed
	 *                                       by operation interval ID, of all the zones the
	 *                                       advertisement is linked to.
     *                  array(
     *                      [operation_interval_id] => forecast_impressions,
     *                      [operation_interval_id] => forecast_impressions
     *                                  .
     *                                  .
     *                                  .
     *                  )
     * @return integer The ad's total remaining zone impression forecast for all zone for
     *                 the remaining life of the ad.
     */
    function getAdLifetimeZoneImpressionsRemaining($oNowDate, $oEndDate, $aCumulativeZoneForecast)
    {
        $totalAdLifetimeZoneImpressionsRemaining = 0;

        // Test the parameters, if invalid, return zero
        if (!is_a($oNowDate, 'date') || !is_a($oEndDate, 'date') || !is_array($aCumulativeZoneForecast) ||
            (count($aCumulativeZoneForecast) != OX_OperationInterval::operationIntervalsPerWeek())) {
            OA::debug('  - Invalid parameters to getAdLifetimeZoneImpressionsRemaining, returning 0', PEAR_LOG_ERR);
            return $totalAdLifetimeZoneImpressionsRemaining;
        }

        // Ensure that the end of campaign date is at the end of the day
        $oEndDateCopy = new Date($oEndDate);
        $oEndDateCopy->setHour(23);
        $oEndDateCopy->setMinute(59);
        $oEndDateCopy->setSecond(59);

        // Ensure that the $aCumulativeZoneForecast array is sorted by key, so that it can
        // be accessed by array_slice, regardless of the order that the forecast data was added
        // to the array
        ksort($aCumulativeZoneForecast);

        // Step 1: Calculate the sum of the forecast values from "now" until the end of "today"
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNowDate);
        $oEndOfToday = new Date($aDates['start']);
        $oEndOfToday->setTZ($oEndDate->tz);
        $oEndOfToday->setHour(23);
        $oEndOfToday->setMinute(59);
        $oEndOfToday->setSecond(59);
        $oStart = $aDates['start'];
        while ($oStart->before($oEndOfToday)) {
            // Find the Operation Interval ID for this Operation Interval
            $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oStart);
            // As iteration over every OI is required anyway, test to see if
            // the ad is blocked in this OI; if not, add the forecast values to the
            // running total
            if (empty($this->aBlockedOperationIntervalDates[$oStart->format('%Y-%m-%d %H:%M:%S')])) {
                $totalAdLifetimeZoneImpressionsRemaining += $aCumulativeZoneForecast[$operationIntervalID];
            }
            // Go to the next operation interval in "today"
            $oStart = OX_OperationInterval::addOperationIntervalTimeSpan($oStart);
        }

        // Step 2: Calculate how many times each day of the week occurs between the end of
        //         "today" (i.e. starting "tomorrow morning") and the last day the ad can run
        $aDays = array();
        $oStartOfTomorrow = new Date($oEndOfToday);
        $oStartOfTomorrow->addSeconds(1);
        $oTempDate = new Date();
        $oTempDate->copy($oStartOfTomorrow);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oTempDate);
        while ($aDates['start']->before($oEndDateCopy)) {
            // Increase the count for this day of the week
            $aDays[$aDates['start']->getDayOfWeek()]++;
            // Go to the next day
            $oTempDate->addSeconds(SECONDS_PER_DAY);
            $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oTempDate);
        }

        // Step 3: For every possible day of the week (assuming that day of the week is in the
        //         ad's remaining lifetime), calculate the sum of the forecast values for every
        //         operation interval in that day
        if (!empty($aDays)) {
            $operationIntervalsPerDay = OX_OperationInterval::operationIntervalsPerDay();
            $oTempDate = new Date($oStartOfTomorrow);
            $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oTempDate);
            for ($counter = 0; $counter < 7; $counter++) {
                // Are there any instances of this day in the campaign?
                if ($aDays[$oTempDate->getDayOfWeek()] > 0) {
                    // Calculate the sum of the zone forecasts for this day of week
                    $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oTempDate);
                    $dayStartOperationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
                    $aDayCumulativeZoneForecast = array_slice($aCumulativeZoneForecast, $dayStartOperationIntervalId, $operationIntervalsPerDay);
                    $forecastSum = array_sum($aDayCumulativeZoneForecast);
                    // Multiply this day's forecast sum value by the number of times this
                    // day of week appears in the remainder of the campaign and add the
                    // value to the running total
                    $totalAdLifetimeZoneImpressionsRemaining += $forecastSum * $aDays[$oTempDate->getDayOfWeek()];
                }
                // Go to the next day
                $oTempDate->addSeconds(SECONDS_PER_DAY);
            }
        }

        // Step 4: Subtract any blocked interval values
        if ($this->blockedOperationIntervalCount > 0) {
            OA::debug("      - Subtracting {$this->blockedOperationIntervalCount} blocked intervals", PEAR_LOG_DEBUG);
            foreach ($this->aBlockedOperationIntervalDates as $aDates) {
                if ($aDates['start']->after($oEndOfToday)) {
                    $blockedOperationInvervalID = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
                    $totalAdLifetimeZoneImpressionsRemaining -= $aCumulativeZoneForecast[$blockedOperationInvervalID];
                }
            }
        }

        // Return the calculated value
        return $totalAdLifetimeZoneImpressionsRemaining;
    }

    /**
     * A private method to calcuate if a set of OR grouped operation groups
     * (where within each operation group, the delivery limitations are AND
     * grouped), blocks delivery overall, or not.
     *
     * @access private
     * @param array $aFlags An array of arrays. Each outer array represents
     *                      an operation group, while the inner arrays
     *                      represent the blocking status of each delivery
     *                      limitation in that operation group (where 1 is
     *                      true [i.e. blocked], and 0 is false [i.e. not
     *                      blocked]). For example:
     *                      array(
     *                          [0] => array(
     *                                     [0] => 0,
     *                                     [1] => 0,
     *                                     [2] => 0
     *                                 ),
     *                          [1] => array(
     *                                     [0] => 1,
     *                                     [1] => 0,
     *                                 )
     *                      )
     * @return boolean True if the limitation flags result in the advertisement
     *                 being blocked, false if the advertisement is not blocked.
     *
     * For the example parameter shown above, the first operation group has
     * three limitations, all of which do NOT block, therefore the operation
     * group does NOT block. The second operation group has two limitations,
     * one of which DOES block, therefore the operation group DOES block.
     * The OR result of one group that does block and one group that does
     * not block is that the overal limitations do NOT block, and so false
     * would be returned.
     */
    function _deliveryBlocked($aFlags)
    {
        if (!is_array($aFlags) || empty($aFlags)) {
            // No parameters passed in, so assume that it does not block
            return false;
        }
        $aOperationGroupResults = array();
        foreach ($aFlags as $groupKey => $aOperationGroup) {
            // The default value of an operation group is to NOT block,
            // as this is what other limitation types (or no blocking
            // limitation types) do
            $aOperationGroupResults[$groupKey] = 0;
            foreach ($aOperationGroup as $limitation) {
                // Bitwise OR the limitations (as the limitations
                // inverse of normal, where they are ANDed)
                $aOperationGroupResults[$groupKey] |= $limitation;
            }
        }
        // Finally, bitwise AND the results of the operation groups
        // (as these are the inverse of normal, where they are ORed)
        foreach ($aOperationGroupResults as $groupLimitation) {
            if (is_null($result)) {
                $result = $groupLimitation;
            } else {
                $result &= $groupLimitation;
            }
        }
        // Return the result
        if ($result == 1) {
            return true;
        }
        return false;
    }

}

?>
