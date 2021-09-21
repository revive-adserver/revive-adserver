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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPMCommon.php';

/**
 * A class to carry out the task of calculating eCPM Remnant (Low priority campaigns) probabilities.
 *
 * For more information on details of eCPM algorithm see the
 * ad selection algorithm (market maker).andrew.hill
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 */
class OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant extends OA_Maintenance_Priority_AdServer_Task_ECPMCommon
{
    /**
     * Helper arrays for storing additional variables
     * required in calculations.
     *
     * @var array
     */
    public $aAdsMinImpressions = [];
    public $aZonesMinImpressions = [];
    public $aCampaignsDeliveredImpressions = [];

    /**
     * How many operation intervals are left till the end of today
     *
     * @var integer
     */
    public $operationIntervalsTillTheEndOfToday;

    /**
     * Task Name
     *
     * @var string
     */
    public $taskName = 'ECPM for Remnant';

    /**
     * Executes the eCPM algorithm.
     * Calculations for each of the agencies are carried on in separate
     * loop so it should be relatively easy to scale this algorithm up
     * and run it on more than one machine.
     */
    public function runAlgorithm()
    {
        $aAgenciesIds = $this->oDal->getEcpmAgenciesIds();
        foreach ($aAgenciesIds as $agencyId) {
            $this->resetHelperProperties();
            $aCampaignsInfo = $this->oDal->getCampaignsInfoByAgencyId($agencyId);
            if (is_array($aCampaignsInfo) && !empty($aCampaignsInfo)) {
                $this->preloadZonesAvailableImpressionsForAgency($agencyId);
                $this->preloadCampaignsDeliveredImpressionsForAgency($agencyId);
                $this->preloadCampaignsDeliveriesForAgency($agencyId);
                $this->prepareCampaignsParameters($aCampaignsInfo);
                $this->oDal->updateEcpmPriorities($this->calculateDeliveryProbabilities($aCampaignsInfo));
                $this->oDal->updateCampaignsEcpms($this->aCampaignsEcpms);
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
        $aAdsZonesMinImpressions = $this->calculateAdsZonesMinimumRequiredImpressions($aCampaignsInfo);
        $aAdZonesProbabilities = [];
        foreach ($aCampaignsInfo as $campaignId => $aCampaign) {
            foreach ($aCampaign[self::IDX_ADS] as $adId => $aAd) {
                foreach ($aAd[self::IDX_ZONES] as $zoneId) {
                    if ($this->aZonesEcpmPowAlphaSums[$zoneId]) {
                        $p = $this->aAdsEcpmPowAlpha[$adId] / $this->aZonesEcpmPowAlphaSums[$zoneId];
                    } else {
                        // the ECPM should be always set, but in case its not, avoid division by zero
                        $p = 0;
                    }
                    $M = $this->getZoneAvailableImpressions($zoneId);
                    $minRequestedImpr = $aAdsZonesMinImpressions[$adId][$zoneId];
                    if ($this->aZonesMinImpressions[$zoneId] > $M) {
                        $aAdZonesProbabilities[$adId][$zoneId] =
                            $minRequestedImpr / $this->aZonesMinImpressions[$zoneId];
                    } else {
                        $aAdZonesProbabilities[$adId][$zoneId] =
                           $minRequestedImpr / $M
                           + (1 - $this->aZonesMinImpressions[$zoneId] / $M) * $p;
                    }
                }
            }
        }
        return $aAdZonesProbabilities;
    }

    /**
     * Calculates minimum number of impressions per ad
     * proportionally to its weight and to remaining number of impressions.
     *
     * This function also calculates the ECPM ^ ALPHA, both per each individual
     * campaign and sums of ECPM ^ ALPHA per each of zones. See "Ad Selection Algorithm"
     * paper for more info.
     *
     * This function can be divided into two functionaly separate functions
     * but that would require passing the campaignsInfo array twice so because
     * of the performance reasons both tasks are performed in signle pass.
     *
     * @param array $aCampaignsInfo  Contains all ecpm campaigns withing one agency with
     *                               all their ads and the zones they are linked to.
     *                               For a specific of the indexes withing this array see:
     *                               OA_Dal_Maintenance_Priority::getCampaignsInfoByAgencyId
     */
    public function prepareCampaignsParameters($aCampaignsInfo)
    {
        $campaignRemainingOperationIntervals = $this->getTodaysRemainingOperationIntervals();
        foreach ($aCampaignsInfo as $campaignId => $aCampaign) {
            $deliveredImpressions = $this->getCampaignDeliveredImpressions($campaignId);
            $this->aCampaignsEcpms[$campaignId] = $ecpm =
                $this->calculateCampaignEcpm($campaignId, $aCampaign);
            $campaignAdsWeightSum = 0;
            // Calculates ECPM ^ ALPHA and sums up ads weights
            foreach ($aCampaign[self::IDX_ADS] as $adId => $adInfo) {
                // calculate sum of all ads weights across a campaign
                $campaignAdsWeightSum += $adInfo[self::IDX_WEIGHT];
                $this->setAdEcpmPowAlpha($adId, $ecpm);
                $this->setZonesEcpmPowAlphaSums($adId, $adInfo[self::IDX_ZONES]);
            }
            // Calculates minimum number of required impressions for each ad
            // and scale it proportionally to the ad weight
            foreach ($aCampaign[self::IDX_ADS] as $adId => $adInfo) {
                $minImpressionsToDeliver = $aCampaign[self::IDX_MIN_IMPRESSIONS] - $deliveredImpressions;
                if ($minImpressionsToDeliver < 0) {
                    $minImpressionsToDeliver = 0;
                } else {
                    // number of impressions which should be delivered in this operation interval
                    $minImpressionsToDeliver = $minImpressionsToDeliver / $campaignRemainingOperationIntervals;
                }
                // scale the campaign min.impressions to each of ads proportionally
                // to the weights of the ad
                $this->setAdMinImpressions(
                    $adId,
                    $adInfo[self::IDX_WEIGHT],
                    $campaignAdsWeightSum,
                    $minImpressionsToDeliver
                );
            }
        }
    }

    /**
     * Calculates number of operation intervals which are left till
     * the end of today.
     *
     * @return integer  Number of remaining operation intervals
     */
    public function getTodaysRemainingOperationIntervals()
    {
        $beginningOfTomorrow = $this->getBeginningOfTomorrow();
        $campaignRemainingOperationIntervals =
        OX_OperationInterval::getIntervalsRemaining(
            $this->aOIDates['start'],
            $beginningOfTomorrow
        );
        return $campaignRemainingOperationIntervals;
    }

    /**
     * Returns (from the cache) number of impressions delivered
     * in given campaign today.
     *
     * @param integer $campaignId  Campaign ID
     * @return integer  Amount of impressions
     */
    public function getCampaignDeliveredImpressions($campaignId)
    {
        return isset($this->aCampaignsDeliveredImpressions[$campaignId]) ?
            $this->aCampaignsDeliveredImpressions[$campaignId] : 0;
    }

    /**
     * Calculate min volume (min impressions) required
     * by each of ads in proportion to the weight of each ad.
     *
     * @param integer $adId  Ad ID
     * @param integer $adWeight  Ad weight
     * @param integer $campaignAdsWeightSum  Sum of all ads weights withing the campaign
     * @param integer $campaignMinRequiredImpressions  Min. number of impressions in the campaign
     */
    public function setAdMinImpressions(
        $adId,
        $adWeight,
        $campaignAdsWeightSum,
        $campaignMinRequiredImpressions
    ) {
        $this->aAdsMinImpressions[$adId] = $campaignMinRequiredImpressions *
            $adWeight / $campaignAdsWeightSum;
    }

    /**
     * Calculates sum of ecpm^Alpha across a zone
     *
     * @param integer $adId  Ad ID
     * @param array $aZones Array of zones given ad is linked to
     */
    public function setZonesEcpmPowAlphaSums($adId, $aZones)
    {
        foreach ($aZones as $zoneId) {
            if (!isset($this->aZonesEcpmPowAlphaSums[$zoneId])) {
                $this->aZonesEcpmPowAlphaSums[$zoneId] = 0;
            }
            $this->aZonesEcpmPowAlphaSums[$zoneId]
                += $this->aAdsEcpmPowAlpha[$adId];
        }
    }

    /**
     * Calculates minimum volume of required impressions for each ad/zone pair.
     *
     * @param array $aCampaignsInfo  Contains all ecpm campaigns withing one agency with
     *                               all their ads and the zones they are linked to.
     *                               For a specific of the indexes withing this array see:
     *                               OA_Dal_Maintenance_Priority::getCampaignsInfoByAgencyId
     * @return array  Array of ads-zones and they corresponding minimum
     *                required impressions which needs to be delivered, format:
     *                array(
     *                  adid (integer) => array(
     *                      zoneid (integer) => min.impr. (integer),
     *                      ...
     *                  ), ...
     *                )
     */
    public function calculateAdsZonesMinimumRequiredImpressions($aCampaignsInfo)
    {
        $aAdsZonesMinImpressions = [];
        foreach ($aCampaignsInfo as $campaignId => $aCampaign) {
            foreach ($aCampaign[self::IDX_ADS] as $adId => $aAd) {
                $aAdsZonesMinImpressions[$adId] = $this->calculateAdZoneMinImpr(
                    $aCampaign[self::IDX_ADS][$adId][self::IDX_ZONES],
                    $this->aAdsMinImpressions[$adId]
                );
            }
        }
        return $aAdsZonesMinImpressions;
    }

    /**
     * For a given minimum volume (minimum impressions) of ad and its linked
     * zones calculates the minimum volume for each zone. The minimum volume
     * is calculated proportionally to the contract (available number of impressions)
     * of each zone.
     *
     * @param array $aZones  Array of zones ids linked to given ad
     * @param integer $adMinImpressions  Number of required volume (impr.) by ad
     * @return array  Array of minimum required impressions for given ad
     *                in each of the ads it is assigned to, format:
     *                array(
     *                  zoneid (integer) => min.impr. (integer)
     *                )
     */
    public function calculateAdZoneMinImpr($aZones, $adMinImpressions)
    {
        $aAdZonesMinImpressions = [];
        $adZonesContractsSum = $this->getAdZonesContractsSum($aZones);
        if ($adMinImpressions > $adZonesContractsSum) {
            // ad can't get more impressions than are available in all zones
            // it is assigned to
            $adMinImpressions = $adZonesContractsSum;
        }
        foreach ($aZones as $zoneId) {
            $zoneContract = $this->getZoneAvailableImpressions($zoneId);
            $aAdZonesMinImpressions[$zoneId] = $adMinImpressions
                * $zoneContract / $adZonesContractsSum;
            $this->addMinRequiredImprToZone($zoneId, $aAdZonesMinImpressions[$zoneId]);
        }
        return $aAdZonesMinImpressions;
    }

    /**
     * Keeps a track of all minimum volumes (min. impressions)
     * which were assigned to each of zones.
     *
     * @param integer $zoneId  Zone ID
     * @param integer $minImpr  Minimum number of required impressions
     */
    public function addMinRequiredImprToZone($zoneId, $minImpr)
    {
        if (!isset($this->aZonesMinImpressions[$zoneId])) {
            $this->aZonesMinImpressions[$zoneId] = 0;
        }
        $this->aZonesMinImpressions[$zoneId] += $minImpr;
    }

    /**
     * Returns the sum of contracts (available number of impressions)
     * in given zones. A zone contract is a number of forecasted impressions
     * in a given zone minus amount of impressions requested by high priority
     * campaigns.
     *
     * @param array $aZones  Array of zone IDs
     * @return integer  Sum of zones contracts
     */
    public function getAdZonesContractsSum($aZones)
    {
        $sum = 0;
        foreach ($aZones as $zoneId) {
            $sum += $this->getZoneAvailableImpressions($zoneId);
        }
        return $sum;
    }

    /**
     * Reads from database number of impressions which were delivered
     * today in each of the ecpm campaigns in a given agency.
     * The data is cached in the array for the later use.
     *
     * @param integer $agencyId  Agency ID
     */
    public function preloadCampaignsDeliveredImpressionsForAgency($agencyId)
    {
        $oDal = $this->_factoryDal('data_intermediate_ad');
        $today = $this->getBeginningOfToday();
        $aCampaignsImpressions = $oDal->getDeliveredEcpmCampainImpressionsByAgency($agencyId, $today);
        if ($aCampaignsImpressions) {
            $this->aCampaignsDeliveredImpressions = $aCampaignsImpressions;
        }
    }

    /**
     * Reads from database number of impressions, clicks and conversions which
     * were delivered during the campaign lifetime in each of the ecpm campaigns in a given agency.
     * The data is cached in the array for the later use.
     *
     * @param integer $agencyId  Agency ID
     */
    public function preloadCampaignsDeliveriesForAgency($agencyId)
    {
        $aCampaignsDeliveries = $this->oDal->getAgencyEcpmRemnantCampaignsDeliveriesToDate($agencyId);
        if ($aCampaignsDeliveries) {
            $this->aCampaignsDeliveries = $aCampaignsDeliveries;
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
        return $this->oDal->getZonesAllocationsForEcpmRemnantByAgency($agencyId);
    }

    /**
     * Returns the Pear Date containing the date/time of beginning
     * of today.
     *
     * @return PEAR_Date  Date of today at 00:00:00
     */
    public function getBeginningOfToday()
    {
        $today = new Date();
        $today->copy($this->getDateNow());
        $today->setHour('00');
        $today->setMinute('00');
        $today->setSecond('00');
        return $today;
    }

    /**
     * Returns the Pear Date containing the date/time of beginning
     * of tomorrow.
     *
     * @return PEAR_Date  Date of tomorrow at 00:00:00
     */
    public function getBeginningOfTomorrow()
    {
        $tomorrow = new Date();
        $tomorrow->copy($this->getDateNow());
        $tomorrow->addSeconds(24 * 3600);
        $tomorrow->setHour('00');
        $tomorrow->setMinute('00');
        $tomorrow->setSecond('00');
        return $tomorrow;
    }

    /**
     * Resets the helper arrays
     */
    public function resetHelperProperties()
    {
        parent::resetHelperProperties();
        $this->aZonesMinImpressions = [];
        $this->aAdsMinImpressions = [];
        $this->aCampaignsDeliveredImpressions = [];
    }
}
