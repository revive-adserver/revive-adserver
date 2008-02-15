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
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Placement.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Zone.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';

/**
 * A class to allocate the required impressions for each advertisement to
 * zones, and then set the requested impressions, which will be used to
 * calculate the priority values for each ad in each zone.
 *
 * If a zone does not have sufficient impressions available to accomodate
 * all of the required impressions allocated, then the required impressions
 * allocated to that zone will be scaled down to give the requested,
 * resulting in equal levels of under-delivery in that zone.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_AdServer_Task_AllocateZoneImpressions extends OA_Maintenance_Priority_AdServer_Task
{
    var $aAvailableForecastZoneImpressions;
    var $aOverSubscribedZones;
    var $aPlacements;
    var $aAdZoneAssociations;
    var $aAdZoneImpressionAllocations;

    /**
     * The constructor method.
     */
    function OA_Maintenance_Priority_AdServer_Task_AllocateZoneImpressions()
    {
        parent::OA_Maintenance_Priority_AdServer_Task();
        $this->table =& $this->_getMaxTablePriorityObj();
    }

    /**
     * The main method of the class, that is run by the controlling
     * task runner class.
     */
    function run()
    {
        OA::debug('Running Maintenance Priority Engine: Allocate Zone Impressions', PEAR_LOG_DEBUG);
        // Set the zone forecast information
        $this->_setZoneForecasts();
        // Set the placement information
        $this->_setPlacements();
        // Set the ad/zone linkage information
        $this->_setAdZoneAssociations();
        // Set the required impressions for each ad/zone pair
        $this->_allocateRequiredImpressions();
        // Determine if any zones are over-subscribed
        $this->_calculateOverSubscribedZoneInformation();
        // Set the requested impressions for each ad/zone pair
        $this->_allocateRequestedImpressions();
        // Save the ad/zone impression allocations to the database
        OA::setTempDebugPrefix('- ');
        $this->table->createTable('tmp_ad_zone_impression');
        $this->oDal->saveAllocatedImpressions($this->aAdZoneImpressionAllocations);
    }

    /**
     * A private method to set and store the number of (forecast) available
     * impressions in all of the zones in the system.
     *
     * @access private
     */
    function _setZoneForecasts()
    {
        // Set the total number of initially avaiable (forecast) zone impressions,
        // from the previously calculated values now stored in the database
        $this->aAvailableForecastZoneImpressions = $this->oDal->getZoneImpressionForecasts();
        // Subtract one impression from each zone forecast, so that the "blank" ad
        // is always allocated at least one impression
        if (!empty($this->aAvailableForecastZoneImpressions)) {
            foreach ($this->aAvailableForecastZoneImpressions as $zoneId => $availableImpressions) {
                $this->aAvailableForecastZoneImpressions[$zoneId]--;
            }
        }
        // Save the data on the available impressions for use in dealing with
        // over-subscribed zones
        $this->aOverSubscribedZones = array();
        if (!empty($this->aAvailableForecastZoneImpressions)) {
            foreach ($this->aAvailableForecastZoneImpressions as $zoneId => $availableImpressions) {
                $this->aOverSubscribedZones[$zoneId] = array(
                                                           'zoneId'               => $zoneId,
                                                           'availableImpressions' => $availableImpressions,
                                                           'desiredImpressions'   => 0
                                                       );
            }
        }
    }

    /**
     * A private method to set the placement information. Gets all of the active
     * placements in the system, sets the ads associated with the placements,
     * retrieves the number of impressions that have been allocated to each ad,
     * and finally orders the advertisements in each placement in order of
     * importance, from highest to lowest.
     *
     * @access private
     */
    function _setPlacements()
    {
        // Get all placements in the system
        $this->aPlacements = $this->_getAllPlacements();
        // Set the information required for each placement
        if (is_array($this->aPlacements) && !empty($this->aPlacements)) {
            foreach ($this->aPlacements as $placementKey => $oPlacement) {
                // Set the advertisements in the placement
                $this->aPlacements[$placementKey]->setAdverts();
                // Populate the ads with data from the
                // OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime
                // and OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsDaily
                // task jobs previously run
                $this->_setRequiredImpressions($this->aPlacements[$placementKey]->aAds);
            }
        }
    }

    /**
     * A private method to return an array of Placement objects, in the following
     * array order:
     *
     * - Placement priority from highest (user defined value > 1) to lowest (1).
     * - Within the same priority level, placements with expiry dates first.
     * - Within placements with expiry dates, placements with sooner expiry dates first.
     *
     * @access private
     * @return array An array of Placement objects, in the above order.
     *
     * @TODO It is no longer necessary for the Placements to be ordered as described
     *       above, so this ordering can be removed, if desired.
     */
    function _getAllPlacements()
    {
        $orderBys[] = array('priority','DESC');
        $orderBys[] = array('expire','ASC');
        $aPlacements = $this->oDal->getPlacements(array(), array(), array(), $orderBys);
        $aPlacementObjects = array();
        if (is_array($aPlacements) && !empty($aPlacements)) {
            foreach ($aPlacements as $aPlacementData) {
                $aPlacementObjects[] = new OA_Maintenance_Priority_Placement($aPlacementData);
            }
        }
        return $aPlacementObjects;
    }

    /**
     * A private method to get the required impressions for an array of
     * advertisements from the database, and the set these values in the array.
     *
     * @access private
     * @param array $aAds An array of {@link OA_Maintenance_Priority_Ad} objects,
     *                    passed by reference.
     */
    function _setRequiredImpressions(&$aAds)
    {
        $aAdvertIds = array();
        reset($aAds);
        while (list($key, $oAd) = each($aAds)) {
            $aAdvertIds[] = $oAd->id;
        }
        if (!empty($aAdvertIds)) {
            // Get the required impressions from the database
            $aRequiredImpressions = $this->oDal->getRequiredAdImpressions($aAdvertIds);
            // Set the required impressions into the array reference
            reset($aAds);
            while (list($key, $oAd) = each($aAds)) {
                if (isset($aRequiredImpressions[$oAd->id])) {
                    $aAds[$key]->requiredImpressions = $aRequiredImpressions[$oAd->id];
                } else {
                    $aAds[$key]->requiredImpressions = 0;
                }
            }
        }
    }

    /**
     * A private method to set the ad/zone associations that are present in
     * the system, for later reference.
     *
     * @access private
     */
    function _setAdZoneAssociations()
    {
        $this->aAdZoneAssociations = array();
        if (is_array($this->aPlacements) && !empty($this->aPlacements)) {
            foreach ($this->aPlacements as $k => $oPlacement) {
                if (is_array($oPlacement->aAds) && !empty($oPlacement->aAds)) {
                    $aAdvertIds = array();
                    reset($oPlacement->aAds);
                    while (list($key, $oAd) = each($oPlacement->aAds)) {
                        $aAdvertIds[] = $oAd->id;
                    }
                    $aResult = $this->oDal->getAdZoneAssociationsByAds($aAdvertIds);
                    if (is_array($aResult) && (count($aResult) > 0)) {
                        $this->aAdZoneAssociations[$oPlacement->id] = $aResult;
                    }
                }
            }
        }
    }

    /**
     * A private method to iterate over the placements, and allocate the required
     * impression of the advertisements in the placements between the zones the
     * advertisements are linked to, relative to the forecast zone impression
     * volumes. Results of allocation are stored in the$aAdZoneImpressionAllocations
     * array.
     */
    function _allocateRequiredImpressions()
    {
        // If placements exist
        if (!empty($this->aPlacements)) {
            // Iterate over all the placements
            foreach ($this->aPlacements as $placementKey => $oPlacement) {
                // If the placement has advertisements
                if (is_array($oPlacement->aAds) && !empty($oPlacement->aAds)) {
                    // Iterate over all the advertisements in the placement
                    reset($oPlacement->aAds);
                    while (list($advertKey, $oAd) = each($oPlacement->aAds)) {
                        // Allocate *all* impressions the ad requires to the Direct Selection zone,
                        // so that direct selection of HPC ads will be based on a system-wide
                        // weighting of the number of impressions each HPC ad requires
                        $this->aAdZoneImpressionAllocations[] = array(
                            'ad_id'                => $oAd->id,
                            'zone_id'              => 0,
                            'required_impressions' => $oAd->requiredImpressions,
                            'campaign_priority'    => $oPlacement->priority
                        );
                        // Set the ad/zone association information for the advertisement
                        if (!isset($this->aAdZoneAssociations[$oPlacement->id][$oPlacement->aAds[$advertKey]->id])) {
                            continue;
                        }
                        $oPlacement->aAds[$advertKey]->zones =
                            $this->aAdZoneAssociations[$oPlacement->id][$oPlacement->aAds[$advertKey]->id];
                        // If the advertisement is linked to at least one "real" zone
                        if (is_array($oPlacement->aAds[$advertKey]->zones) && !empty($oPlacement->aAds[$advertKey]->zones)) {
                            // Calculate the total volume of forecast zone impressions
                            // for all zones linked to the advertisement
                            $totalAvaiableImpressions = 0;
                            foreach ($oPlacement->aAds[$advertKey]->zones as $zoneKey => $zone) {
                                $oPlacement->aAds[$advertKey]->zones[$zoneKey]['availableImpressions'] =
                                    $this->aAvailableForecastZoneImpressions[$zone['zone_id']];
                                $totalAvaiableImpressions +=
                                    $oPlacement->aAds[$advertKey]->zones[$zoneKey]['availableImpressions'];
                            }
                            // Iterate over each of the zones the advertisement is linked to
                            foreach ($oPlacement->aAds[$advertKey]->zones as $zone) {
                                // If there are impressions available to the advertisement
                                if ($totalAvaiableImpressions > 0) {
                                    // Calculate the number of impressions to allocate to this zone
                                    $requiredImpressions = round($oAd->requiredImpressions *
                                        ($zone['availableImpressions'] / $totalAvaiableImpressions));
                                    // Record the ad's required impressions on the zone
                                    $this->aAdZoneImpressionAllocations[] = array(
                                        'ad_id'                => $oAd->id,
                                        'zone_id'              => $zone['zone_id'],
                                        'required_impressions' => $requiredImpressions,
                                        'campaign_priority'    => $oPlacement->priority
                                    );
                                    $this->aOverSubscribedZones[$zone['zone_id']]['desiredImpressions'] +=
                                        $requiredImpressions;
                                    if ($oPlacement->priority > 0) {
                                        if (empty($this->aOverSubscribedZones[$zone['zone_id']])) {
                                            $this->aOverSubscribedZones[$zone['zone_id']] = array();
                                        }
                                        if (empty($this->aOverSubscribedZones[$zone['zone_id']]['desiredImpressionsByCP'])) {
                                            $this->aOverSubscribedZones[$zone['zone_id']]['desiredImpressionsByCP'] = array();
                                        }
                                        $this->aOverSubscribedZones[$zone['zone_id']]['desiredImpressionsByCP'][$oPlacement->priority] +=
                                            $requiredImpressions;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * A private method to calcualte over-subscribed zone information. Sets the
     * 'oversubscribed' flag on zones in the array where the zone has been over-
     * subscribed, and calculates the scaling factor that needs to be used when
     * allocating the requested impressions to that zone.
     *
     * @access private
     */
    function _calculateOverSubscribedZoneInformation()
    {
        if (is_array($this->aOverSubscribedZones) && !empty($this->aOverSubscribedZones)) {
            $globalMessage = '';
            foreach ($this->aOverSubscribedZones as $zoneId => $aZoneInfo) {
                if ($aZoneInfo['desiredImpressions'] > $aZoneInfo['availableImpressions']) {
                    $message  = "- Found that Zone ID $zoneId was over-subscribed: Want ";
                    $message .= "{$aZoneInfo['desiredImpressions']} in {$aZoneInfo['availableImpressions']}";
                    $globalMessage .= $message . "\n";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    // The zone was over-subscribed, set the flag, and calculate
                    // the factor that is needed to be adjusted by
                    $this->aOverSubscribedZones[$zoneId]['oversubscribed'] = true;
                    // Calculate available impressions for each campaign priority
                    $total_impressions = 0;
                    $available_impressions = $aZoneInfo['availableImpressions'];
                    krsort($aZoneInfo['desiredImpressionsByCP']);
                    foreach ($aZoneInfo['desiredImpressionsByCP'] as $campaign_priority => $desired_impressions) {
                        // Cycle through decreasing camapaign priority
                        if ($desired_impressions > $available_impressions) {
                            if ($available_impressions <= 0) {
                                // No impressions available, ads are not meant to be delivered
                                $this->aOverSubscribedZones[$zoneId]['adjustmentFactorByCP'][$campaign_priority] = -1;
                            } else {
                                // Ads with this campaign priority aren't going to get enough impressions
                                $this->aOverSubscribedZones[$zoneId]['adjustmentFactorByCP'][$campaign_priority] =
                                    $available_impressions / $desired_impressions;
                                $total_impressions += $available_impressions;
                            }
                        } else {
                            // There are enough impressions for ads with this campaign priority
                            $this->aOverSubscribedZones[$zoneId]['adjustmentFactorByCP'][$campaign_priority] = 1;
                            $total_impressions += $desired_impressions;
                        }

                        $available_impressions -= $desired_impressions;
                        if ($available_impressions < 0) {
                            $available_impressions = 0;
                        }
                   }
                } else {
                    // Zone is not over-subscribed
                    $this->aOverSubscribedZones[$zoneId]['oversubscribed'] = false;
                }
            }
        }
    }

    /**
     * A private method to iterate over the placements, and allocate the required
     * ad/zone impression calculated earlier, sclaing where required to ensure that
     * the requested volume of ads in each zone does not exceed the zone impression
     * forecast. Results of allocation are stored in the $aAdZoneImpressionAllocations
     * array.
     */
    function _allocateRequestedImpressions()
    {
        if (is_array($this->aAdZoneImpressionAllocations) && !empty($this->aAdZoneImpressionAllocations)) {
            // Iterate over all of the previous ad/zone required impression allocations
            foreach ($this->aAdZoneImpressionAllocations as $key => $aRequiredAllocation) {
                // Mark as meant to be delivered
                $this->aAdZoneImpressionAllocations[$key]['to_be_delivered'] = true;
                // Is the required allocation in an over-subscribed zone?
                if (
                    isset($this->aOverSubscribedZones[$aRequiredAllocation['zone_id']]) &&
                    $this->aOverSubscribedZones[$aRequiredAllocation['zone_id']]['oversubscribed'] &&
                    $aRequiredAllocation['required_impressions']
                ) {
                    $adjustmentFactor = $this->aOverSubscribedZones[$aRequiredAllocation['zone_id']]['adjustmentFactorByCP'][$aRequiredAllocation['campaign_priority']];
                    if ($adjustmentFactor == -1) {
                        // Simply set the requested impressions as the required impressions
                        $this->aAdZoneImpressionAllocations[$key]['requested_impressions'] =
                            $aRequiredAllocation['required_impressions'];
                        // Mark as not meant to be delivered
                        $this->aAdZoneImpressionAllocations[$key]['to_be_delivered'] = false;
                    } else {
                        // Scale the requested impressions as required to calculated the
                        // required impressions
                        $this->aAdZoneImpressionAllocations[$key]['requested_impressions'] =
                            round($aRequiredAllocation['required_impressions'] * $adjustmentFactor);
                    }
                } else {
                    // Simply set the requested impressions as the required impressions
                    $this->aAdZoneImpressionAllocations[$key]['requested_impressions'] =
                        $aRequiredAllocation['required_impressions'];
                }
            }
        }
    }

}

?>
