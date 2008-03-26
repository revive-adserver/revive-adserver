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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Factory.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';

/**
 * A class for managing a group of delivery limitations associated with an
 * advertisement, with the goal of determining if (and if so, when) the
 * delivery limitation(s) "block" (as opposed to "filter") the advertisement.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_DeliveryLimitation
{

    var $aRules           = array();
    var $aOperationGroups = array();

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
    function OA_Maintenance_Priority_DeliveryLimitation($aDeliveryLimitations)
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
                if (is_a($this->aRules[$key], 'OA_Maintenance_Priority_DeliveryLimitation_Date') ||
                    is_a($this->aRules[$key], 'OA_Maintenance_Priority_DeliveryLimitation_Hour') ||
                    is_a($this->aRules[$key], 'OA_Maintenance_Priority_DeliveryLimitation_Day')) {
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
     * for the ad, given an Date representing a time in an operation interval for
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
     * date to the end date of the placement, an advertisement will be blocked
     * from delivering in.
     *
     * @param PEAR::Date $oStartDate A Date object representing the start of the
     *                               current operation interval.
     * @param PEAR::Date $oEndDate A Date object representing the end date of the
     *                             placement the advertisement is in.
     * @return integer The number of operation intervals in which the advertisement
     *                 will be blocked from delivering in.
     */
    function getBlockedOperationIntervalCount($oStartDate, $oEndDate)
    {
        // Ensure the placement end date is at the END of the day
        $oPlacementEndDate = new Date();
        $oPlacementEndDate->copy($oEndDate);
        $oPlacementEndDate->setHour(23);
        $oPlacementEndDate->setMinute(59);
        $oPlacementEndDate->setSecond(59);
        // Copy the starting date to use in a loop
        $oLoopDate = new Date();
        $oLoopDate->copy($oStartDate);
        // Count the number of blocked operation intervals
        $blockedIntervals = 0;
        while (!$oLoopDate->after($oPlacementEndDate)) {
            if ($this->deliveryBlocked($oLoopDate)) {
                $blockedIntervals++;
            }
            $oLoopDate->addSeconds(OA_OperationInterval::secondsPerOperationInterval());
        }
        return $blockedIntervals;
    }

    /**
     * A method to determine how many of the remaining operation intervals
     * (based on the current date, and the placement end date) the advertisement
     * will be able to deliver in.
     *
     * @param integer $placementRemainingIntervals The number of remaining operation intervals
     *                                             until the placement expiration date.
     * @param PEAR::Date $oDate A Date object, set in the current operation interval.
     * @param PEAR::Date $oPlacementEndDate The end date of the placement.
     * @return integer The number of operation intervals in which the advertisement
     *                 will deliver.
     */
    function getActiveAdOperationIntervals($placementRemainingIntervals, $oDate, $oPlacementEndDate)
	{
	    $conf = $GLOBALS['_MAX']['CONF'];
        // Are delivery limitations activated in the configuration? If not, return
        // the complete count of remaining placement operation intervals
        if (!$conf['delivery']['acls']) {
            return $placementRemainingIntervals;
        }
        // Are there any possible blocking operation groups? If not, return the
        // complete count of remaining placement operation intervals
        if ($this->_getOperationGroupCount() == 0) {
            return $placementRemainingIntervals;
        }
        // Determine in how many of the remaining operation intervals the
        // advertisement will be blocked
        $blockedIntervals = $this->getBlockedOperationIntervalCount($oDate, $oPlacementEndDate);
        return ($placementRemainingIntervals - $blockedIntervals);
	}

	/**
	 * A method to obtain an array, representing the cumulative zone forecast impressions,
	 * for all the zones an advertisement is linked to, cloned out over the advertisement's
	 * entire remaining lifetime in the placement, with any blocked operation intervals so
	 * marked.
	 *
	 * @param PEAR::Date $oNowDate The current date.
	 * @param PEAR::Date $oEndDate The end date of the placement.
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
     * @return array An array representing an advertisements remaining lifetime. Consists
     *               of a sub array for each week (or partial week) in the ad's remaining
     *               lifetime, each containing another array, indexed by the operation
     *               interval in that week. This final array contains the cumulative zone
     *               impression forcast for that operation interval, as well as if the
     *               ad is blocked in that interval, or not. For example:
     *                  array(
     *                      0 => array(
     *                          80 => array(
     *                                    [forecast_impressions] => 57
     *                                    [blocked]              => false
     *                                ),
     *                          81 => array(
     *                                    [forecast_impressions] => 57
     *                                    [blocked]              => false
     *                                ),
     *                             .
     *                             .
     *                             .
     *                         160 => array(
     *                                    [forecast_impressions] => 88
     *                                    [blocked]              => false
     *                                )
     *                      ),
     *                      1 => array(
     *                           0 => array(
     *                                    [forecast_impressions] => 951
     *                                    [blocked]              => false
     *                                ),
     *                           1 => array(
     *                                    [forecast_impressions] => 12
     *                                    [blocked]              => false
     *                                ),
     *                             .
     *                             .
     *                             .
     *                         160 => array(
     *                                    [forecast_impressions] => 8
     *                                    [blocked]              => false
     *                                )
     *                      ),
     *                      2 => array(
     *                           0 => array(
     *                                    [forecast_impressions] => 951
     *                                    [blocked]              => true
     *                                ),
     *                           1 => array(
     *                                    [forecast_impressions] => 12
     *                                    [blocked]              => true
     *                                ),
     *                             .
     *                             .
     *                             .
     *                          40 => array(
     *                                    [forecast_impressions] => 19
     *                                    [blocked]              => true
     *                                )
     *                      )
     *                  )
     * In the above example, the ad will run for the remainder of this week,
     * all of next week, and some of the week after that. It starts at operation
     * interval ID 80 in this week, and ends in operation interval ID 40 in the
     * last week. (There are 160 operation intervals in a week in this example.)
     * For operation interval IDs 0, 1 and 40, in the last week of delivery, the
     * ad is blocked from showing.
     */
    function getAdvertisementLifeData($oNowDate, $oEndDate, $aCumulativeZoneForecast)
    {
        $aResult = array();
        if (!is_a($oNowDate, 'date') || !is_a($oEndDate, 'date') || !is_array($aCumulativeZoneForecast)) {
            return $aResult;
        }
        // Get the current operation interval ID and start/end dates
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNowDate);
        // Look at every operation interval between now and the end of the placement
        while ($aDates['start']->before($oEndDate)) {
            // Which week are we in?
            $operationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
            if (empty($aResult)) {
                $week = 0;
            } elseif ($operationIntervalID == 0) {
                $week++;
            }
            // Store the week/operation interval data
            $aResult[$week][$operationIntervalID] = array(
                'forecast_impressions' => $aCumulativeZoneForecast[$operationIntervalID],
                'blocked'              => $this->deliveryBlocked($aDates['start'])
            );
            // Go to the next operation interval
            $oParamDate = new Date();
            $oParamDate->copy($aDates['start']);
            $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($oParamDate);
        }
        return $aResult;
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
