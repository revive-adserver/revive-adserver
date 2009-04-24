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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPMCommon.php';

/**
 * A class to carry out the task of calculating eCPM probabilities
 * within High Priority Campaigns.
 * 
 * For more information on details of eCPM algorithm see the
 * ad prioritisation algorithm.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class OA_Maintenance_Priority_AdServer_Task_ECPMforContract extends OA_Maintenance_Priority_AdServer_Task_ECPMCommon
{
    /**
     * Minimum percent of delivered impressions (guaranteed)
     */
    const MU_1 = 0.1;

    /**
     * Maximum percent of delivered impressions
     */
    const MU_2 = 1.0;

    /**
     * Helper arrays for storing additional variables
     * required in calculations.
     *
     * @var array
     */
    public $aZonesGuaranteedImpressionsSums = array(); // called b_ij in algorithm
    public $aZonesRequiredImpressionsSums = array(); // called b_ij in algorithm
    public $aCampaignsDeliveries = array();
    public $aZonesAdsRequiredImpressions = array();
    public $aZonesSumProbability = array();

    /**
     * Task Name
     *
     * @var string
     */
    var $taskName = 'ECPM for HPC';

    /**
     * Executes the eCPM algorithm.
     * Calculations for each of the agencies are carried on in separate
     * loop so it should be relatively easy to scale this algorithm up
     * and run it on more than one machine.
     */
    public function runAlgorithm()
    {
        $aAgenciesIds = $this->oDal->getEcpmContractAgenciesIds();
        foreach($aAgenciesIds as $agencyId) {
            $this->resetHelperProperties();
            $this->preloadZonesAvailableImpressionsForAgency($agencyId);
            for ($priority = DataObjects_Campaigns::PRIORITY_ECPM_TO;
                $priority >= DataObjects_Campaigns::PRIORITY_ECPM_FROM; $priority--)
            {
                $aCampaignsInfo = $this->oDal->getCampaignsInfoByAgencyIdAndPriority($agencyId, $priority);
                if (is_array($aCampaignsInfo) && !empty($aCampaignsInfo)) {
                    $this->preloadCampaignsDeliveriesForAgency($agencyId, $priority);
                    $this->prepareCampaignsParameters($aCampaignsInfo);
                    $this->oDal->updateEcpmPriorities($this->calculateDeliveryProbabilities($aCampaignsInfo));
                    $this->oDal->updateCampaignsEcpms($this->aCampaignsEcpms);
                }
            }
        }
    }

    /**
     * This method is executed after all required volumes and precalculated.
     * For each of the ad/zone pairs in all campaigns which are belonging to one
     * agency sums of ecpm^ALPHA and a estimated number of available impressions
     * in each of the zones (zones contracts). In the end calculates the probabilities
     * for each ad/zone pair.
     *
     * @param array $aCampaignsInfo  Contains all ecpm campaigns withing one agency with
     *                               all their ads and the zones they are linked to.
     *                               For a specific of the indexes withing this array see:
     *                               OA_Dal_Maintenance_Priority::getCampaignsInfoByAgencyId
     * @return array  Array ads, zones and their correspondeing probabilities
     *                Format: array(
     *                          adid (integer) => array(
     *                            zoneid (integer) => probability (float),
     *                            ...
     *                          ),
     *                          ...
     *                        )
     */
    public function calculateDeliveryProbabilities($aCampaignsInfo)
    {
        $aAdZonesProbabilities = array();
        $aAdZonesUsedImpressions = array();
        foreach($aCampaignsInfo as $campaignId => $aCampaign) {
            foreach($aCampaign[self::IDX_ADS] as $adId => $aAd) {
                foreach($aAd[self::IDX_ZONES] as $zoneId) {
                    $G = $this->getZoneAdGoal($zoneId, $adId);
                    // M - forecasted inventory for zone
                    $M = $this->getZoneAvailableImpressions($zoneId);
                    // N - sum of all banner requests for the zone
                    $N = $this->aZonesRequiredImpressionsSums[$zoneId];
                    if ($N < $M) {
                        // Do nothing, the existing probability previously generated by
                        // MPE will be used for undersubscribed zones.
                        // Alternatively we can use here in the future the following:
                        // $aAdZonesProbabilities[$adId][$zoneId] = $G / $M;
                    } else {
                        // Calculate eCPM based probability (if zone is oversubscribed)
                        $a = self::MU_1 * $G;
                        $b = self::MU_2 * $G;
                        if ($this->aZonesEcpmPowAlphaSums[$zoneId]) {
                            $p = $b * $this->aAdsEcpmPowAlpha[$adId] / $this->aZonesEcpmPowAlphaSums[$zoneId];
                        } else {
                            // avoid division by zero
                            $p = 0.0;
                        }
                        $zoneGuaranteedImpresssions = $this->aZonesGuaranteedImpressionsSums[$zoneId];
                        if ($zoneGuaranteedImpresssions > $M) {
                            $zoneGuaranteedImpresssions = $M;
                        }
                        if ($a > $M) {
                            $a = $M;
                        }
                        $aAdZonesProbabilities[$adId][$zoneId] = $a / $M + (1 - $zoneGuaranteedImpresssions / $M) * $p;
                        $this->sumUpZoneProbability($zoneId, $aAdZonesProbabilities[$adId][$zoneId]);
                    }
                    $aAdZonesUsedImpressions[$adId][$zoneId] = $G;
                }
            }
        }
        $this->decreaseZoneAvailableImpressions($aAdZonesUsedImpressions);
        return $this->normalizeProbabilities($aAdZonesProbabilities);
    }

    /**
     * Its possible (in cases when the minimum required impressions is close to
     * impressions forecasted per zone) that an ad-zone probability
     * may be bigger than one. The calculated probabilities are normalized
     * to ensure that their sum is always equal to 1.
     *
     * @param array $aAdZonesProbabilities  Ad-zone probabilities, format:
     *                                      adid (integer) => array(
     *                                        zoneid (integer) => probability (float)
     *                                      ),...
     * @return array Normalized ad-zone probabilisites, same format as in $aAdZonesProbabilities
     */
    public function normalizeProbabilities($aAdZonesProbabilities)
    {
        foreach($aAdZonesProbabilities as $adId => $aZone) {
            foreach($aZone as $zoneId => $p) {
                if ($this->aZonesSumProbability[$zoneId]) {
                    $aAdZonesProbabilities[$adId][$zoneId] = $p / $this->aZonesSumProbability[$zoneId];
                }
            }
        }
        return $aAdZonesProbabilities;
    }

    /**
     * Calculates sums of probabilities of all ads linked to a given zone.
     * This number is later used to normalize the probabilities across a zone.
     *
     * @param integer $zoneId  Zone ID
     * @param float $p Probability (may be bigger than 1.0)
     */
    public function sumUpZoneProbability($zoneId, $p)
    {
        if (!isset($this->aZonesSumProbability[$zoneId])) {
            $this->aZonesSumProbability[$zoneId] = $p;
        } else {
            $this->aZonesSumProbability[$zoneId] += $p;
        }
    }

    /**
     * Calculates minimum number of impressions per ad
     * proportionally to its weight and to remaining number of impressions.
     *
     * This function also calculates the ECPM ^ ALPHA, both per each individual
     * campaign and sums of ECPM ^ ALPHA per each of zones. See "Ad Selection Algorithm"
     * paper for more info.
     *
     * @param array $aCampaignsInfo  Contains all ecpm campaigns withing one agency with
     *                               all their ads and the zones they are linked to.
     *                               For a specific of the indexes withing this array see:
     *                               OA_Dal_Maintenance_Priority::getCampaignsInfoByAgencyId
     */
    function prepareCampaignsParameters($aCampaignsInfo)
    {
        $aCampaignAdsIds = array();
        foreach($aCampaignsInfo as $campaignId => $aCampaign) {
            $this->aCampaignsEcpms[$campaignId] = $ecpm =
                $this->calculateCampaignEcpm($campaignId, $aCampaign);
            // Calculates ECPM ^ ALPHA
            foreach($aCampaign[self::IDX_ADS] as $adId => $adInfo) {
                $this->setAdEcpmPowAlpha($adId, $ecpm);
                $aCampaignAdsIds[$adId] = $adId;
            }
        }
        $this->preloadAdsZonesGoals($aCampaignAdsIds);
        foreach($aCampaignsInfo as $campaignId => $aCampaign) {
            foreach($aCampaign[self::IDX_ADS] as $adId => $adInfo) {
                $this->calculateZonesParameters($adId, $adInfo[self::IDX_ZONES]);
            }
        }
    }

    /**
     * Reads from database number of impressions, clicks and conversions which
     * were delivered during the campaign lifetime in each of the ecpm campaigns in a given agency.
     * The data is cached in the array for the later use.
     *
     * @param integer $agencyId  Agency ID
     */
    public function preloadCampaignsDeliveriesForAgency($agencyId, $priority)
    {
        $aCampaignsDeliveries = $this->oDal->getAgencyEcpmContractCampaignsDeliveriesToDate($agencyId, $priority);
        if ($aCampaignsDeliveries) {
            $this->aCampaignsDeliveries = $aCampaignsDeliveries;
        }
    }

    /**
     * Preload ad-zone required impressions as calculated by previous
     * maintenance tasks.
     *
     * @param array $aAdsIds  Array containing ads IDs
     */
    public function preloadAdsZonesGoals($aAdsIds)
    {
        $this->aZonesAdsRequiredImpressions = $this->oDal->getRequiredAdZoneImpressions($aAdsIds);
    }

    /**
     * Returns number of impressions requested in given ad-zone
     *
     * @param integer $zoneId  Zone ID
     * @param integer $adId  Ad ID
     * @return integer  Number of impressions requested in ad-zone
     */
    public function getZoneAdGoal($zoneId, $adId)
    {
        return isset($this->aZonesAdsRequiredImpressions[$zoneId][$adId]) ?
            $this->aZonesAdsRequiredImpressions[$zoneId][$adId] : 0;
    }

    /**
     * Calculates sum of ecpm^Alpha across a zone
     *
     * @param integer $adId  Ad ID
     * @param array $aZones Array of zones the ad is linked to
     */
    public function calculateZonesParameters($adId, $aZones)
    {
        foreach($aZones as $zoneId) {
            if (!isset($this->aZonesEcpmPowAlphaSums[$zoneId])) {
                $this->aZonesEcpmPowAlphaSums[$zoneId] = 0.0;
            }
            if (!isset($this->aZonesGuaranteedImpressionsSums[$zoneId])) {
                $this->aZonesGuaranteedImpressionsSums[$zoneId] = 0.0;
            }
            if (!isset($this->aZonesRequiredImpressionsSums[$zoneId])) {
                $this->aZonesRequiredImpressionsSums[$zoneId] = 0.0;
            }
            $adZoneGoal = $this->getZoneAdGoal($zoneId, $adId);
            $this->aZonesEcpmPowAlphaSums[$zoneId]
                += self::MU_2 * $adZoneGoal * $this->aAdsEcpmPowAlpha[$adId];
            $this->aZonesGuaranteedImpressionsSums[$zoneId]
                += self::MU_1 * $adZoneGoal;
            $this->aZonesRequiredImpressionsSums[$zoneId] += $adZoneGoal;
        }
    }

    /**
     * Get number of allocated impressions in each zone in given agency
     *
     * @param integer $agencyId  Agency ID
     * @return array  Zone allocated impressions (indexed by zone ID)
     */
    public function getZonesAllocationByAgency($agencyId)
    {
        return $this->oDal->getZonesAllocationsByAgencyAndCampaignPriority($agencyId,
            DataObjects_Campaigns::PRIORITY_ECPM_TO);
    }

    /**
     * Decrease the number of impressions available in the zone
     * by the given amount.
     *
     * @param integer $aAdZonesUsedImpressions Array indexed with ad id and zone id
     *                                         which contains the ad-zone goals
     */
    public function decreaseZoneAvailableImpressions($aAdZonesUsedImpressions)
    {
        foreach ($aAdZonesUsedImpressions as $adId => $aZones) {
            foreach ($aZones as $zoneId => $adZoneGoal) {
                if (isset($this->aZonesAvailableImpressions[$zoneId])) {
                    $this->aZonesAvailableImpressions[$zoneId] -= $impressions;
                    if ($this->aZonesAvailableImpressions[$zoneId] < 0) {
                        $this->aZonesAvailableImpressions[$zoneId] = 0;
                    }
                }
            }
        }
    }

    /**
     * Resets the helper arrays
     */
    public function resetHelperProperties()
    {
        parent::resetHelperProperties();
        $this->aZonesGuaranteedImpressionsSums = array();
        $this->aCampaignsDeliveries = array();
        $this->aZonesAdsRequiredImpressions = array();
        $this->aZonesRequiredImpressionsSums = array();
        $this->aZonesSumProbability = array();
    }
}

?>
