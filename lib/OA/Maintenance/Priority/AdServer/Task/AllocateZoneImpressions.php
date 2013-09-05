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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OX/Maintenance/Priority/Campaign.php';
require_once MAX_PATH . '/lib/OX/Maintenance/Priority/Zone.php';

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
    var $aCampaigns;
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
        // Set the campaign information
        $this->_setCampaigns();
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
        $this->aAvailableForecastZoneImpressions = $this->oDal->getZonesForecastsForAllZones();
        // Save the data on the available impressions for use in dealing with
        // over-subscribed zones
        $this->aOverSubscribedZones = array();
        if (!empty($this->aAvailableForecastZoneImpressions)) {
            foreach ($this->aAvailableForecastZoneImpressions as $zoneId => $availableImpressions) {
                // Is there a forecast?
                if (!$availableImpressions) {
                    // No forecast available. Use the minimum default forecast
                    // as number of impressions that can be allocated.
                    // This prevents contract campagigns to assign a large
                    // number of impressions to "inactive" zones, causing
                    // under-delivery
                    $this->aAvailableForecastZoneImpressions[$zoneId] = $this->oDal->getZoneForecastDefaultZoneImpressions();
                }
                $this->aOverSubscribedZones[$zoneId] = array(
                                                           'zoneId'               => $zoneId,
                                                           'availableImpressions' => $availableImpressions,
                                                           'desiredImpressions'   => 0
                                                       );
            }
        }
    }

    /**
     * A private method to set the campaign information. Gets all of the active
     * campaigns in the system, sets the ads associated with the campaigns,
     * retrieves the number of impressions that have been allocated to each ad,
     * and finally orders the advertisements in each campaign in order of
     * importance, from highest to lowest.
     *
     * @access private
     */
    function _setCampaigns()
    {
        // Get all campaigns in the system
        $this->aCampaigns = $this->_getAllCampaigns();
        // Set the information required for each campaign
        if (is_array($this->aCampaigns) && !empty($this->aCampaigns)) {
            foreach ($this->aCampaigns as $campaignKey => $oCampaign) {
                // Set the advertisements in the campaign
                $this->aCampaigns[$campaignKey]->setAdverts();
                // Populate the ads with data from the
                // OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime
                // and OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsDaily
                // task jobs previously run
                $this->_setRequiredImpressions($this->aCampaigns[$campaignKey]->aAds);
            }
        }
    }

    /**
     * A private method to return an array of OX_Maintenance_Priority_Campaign
     * objects
     *
     * @access private
     * @return array An array of OX_Maintenance_Priority_Campaign objects.
     */
    function _getAllCampaigns()
    {
        return $this->oDal->getCampaigns();
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
        if (is_array($this->aCampaigns) && !empty($this->aCampaigns)) {
            foreach ($this->aCampaigns as $k => $oCampaign) {
                if (is_array($oCampaign->aAds) && !empty($oCampaign->aAds)) {
                    $aAdvertIds = array();
                    reset($oCampaign->aAds);
                    while (list($key, $oAd) = each($oCampaign->aAds)) {
                        $aAdvertIds[] = $oAd->id;
                    }
                    $aResult = $this->oDal->getAdZoneAssociationsByAds($aAdvertIds);
                    if (is_array($aResult) && (count($aResult) > 0)) {
                        $this->aAdZoneAssociations[$oCampaign->id] = $aResult;
                    }
                }
            }
        }
    }

    /**
     * A private method to iterate over the campaigns, and allocate the required
     * impression of the advertisements in the campaigns between the zones the
     * advertisements are linked to, relative to the forecast zone impression
     * volumes. Results of allocation are stored in the$aAdZoneImpressionAllocations
     * array.
     */
    function _allocateRequiredImpressions()
    {
        // If campaigns exist
        if (!empty($this->aCampaigns)) {
            // Iterate over all the campaigns
            foreach ($this->aCampaigns as $campaignKey => $oCampaign) {
                // If the campaign has advertisements
                if (is_array($oCampaign->aAds) && !empty($oCampaign->aAds)) {
                    // Iterate over all the advertisements in the campaign
                    reset($oCampaign->aAds);
                    while (list($advertKey, $oAd) = each($oCampaign->aAds)) {
                        // Allocate *all* impressions the creative requires to the Direct Selection zone,
                        // so that direct selection of contract campaign creatives will be based on a
                        // system-wide weighting of the number of impressions each contract campaign
                        // creative requires
                        $this->aAdZoneImpressionAllocations[] = array(
                            'ad_id'                => $oAd->id,
                            'zone_id'              => 0,
                            'required_impressions' => $oAd->requiredImpressions,
                            'campaign_priority'    => $oCampaign->priority
                        );
                        // Set the creative/zone association information for the advertisement
                        if (!isset($this->aAdZoneAssociations[$oCampaign->id][$oCampaign->aAds[$advertKey]->id])) {
                            continue;
                        }
                        $oCampaign->aAds[$advertKey]->zones =
                            $this->aAdZoneAssociations[$oCampaign->id][$oCampaign->aAds[$advertKey]->id];
                        // If the creative is linked to at least one "real" zone
                        if (is_array($oCampaign->aAds[$advertKey]->zones) && !empty($oCampaign->aAds[$advertKey]->zones)) {
                            // Calculate the total volume of forecast zone impressions
                            // for all zones linked to the creative
                            $totalAvaiableImpressions = 0;
                            foreach ($oCampaign->aAds[$advertKey]->zones as $zoneKey => $zone) {
                                $oCampaign->aAds[$advertKey]->zones[$zoneKey]['availableImpressions'] =
                                    $this->aAvailableForecastZoneImpressions[$zone['zone_id']];
                                $totalAvaiableImpressions +=
                                    $oCampaign->aAds[$advertKey]->zones[$zoneKey]['availableImpressions'];
                            }
                            // Iterate over each of the zones the advertisement is linked to
                            foreach ($oCampaign->aAds[$advertKey]->zones as $zone) {
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
                                        'campaign_priority'    => $oCampaign->priority
                                    );
                                    $this->aOverSubscribedZones[$zone['zone_id']]['desiredImpressions'] +=
                                        $requiredImpressions;
                                    if ($oCampaign->priority > 0) {
                                        if (empty($this->aOverSubscribedZones[$zone['zone_id']])) {
                                            $this->aOverSubscribedZones[$zone['zone_id']] = array();
                                        }
                                        if (empty($this->aOverSubscribedZones[$zone['zone_id']]['desiredImpressionsByCP'])) {
                                            $this->aOverSubscribedZones[$zone['zone_id']]['desiredImpressionsByCP'] = array();
                                        }
                                        $this->aOverSubscribedZones[$zone['zone_id']]['desiredImpressionsByCP'][$oCampaign->priority] +=
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
                if (!$aZoneInfo['availableImpressions']) {
                    $message  = "- Found that Zone ID $zoneId is inactive: Using default forecast";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $aZoneInfo['availableImpressions'] = $this->oDal->getZoneForecastDefaultZoneImpressions();
                }
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
     * A private method to iterate over the campaigns, and allocate the required
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
