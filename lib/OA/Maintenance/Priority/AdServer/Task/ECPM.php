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
$Id: PriorityCompensation.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class to carry out the task of calculating eCPM probabilities.
 * 
 * For more information on details of eCPM algorithm see the
 * ad selection algorithm (market maker).
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class OA_Maintenance_Priority_AdServer_Task_ECPM extends OA_Maintenance_Priority_AdServer_Task
{
    /**
     * Default alpha parameter used to calculate the probabilities.
     */
    const ALPHA = 5.0;

    /**
     * If there is no data forecasted for a zone (which shouldn't happen but
     * theoretically is possible, use this data as a default)
     */
    const DEFAULT_ZONE_FORECAST = 100;

    /**
     * Indexes used for indexing arrays. More effective than using strings because less memory
     * will be used to store the data.
     * (For the debugging purposes its handy to change them to string)
     */
    const IDX_ADS             = 1; // 'ads'
    const IDX_WEIGHT          = 2; // 'weight'
    const IDX_ZONES           = 3; // 'zones'
    const IDX_ECPM            = 4; // 'ecpm'
    const IDX_MIN_IMPRESSIONS = 5; // 'impr'

    /**
     * Used to generate date in string format from the PEAR_Date
     */
    const DATE_FORMAT = '%Y-%m-%d %H:%M:%S';

    /**
     * Helper arrays for storing the additional variables
     * required in calculations.
     *
     * @var array
     */
    public $aAdsMinImpressions = array();
    public $aZonesMinImpressions = array();
    public $aAdsEcpmPowAlpha = array();
    public $aZonesEcpmPowAlphaSums = array();
    public $aZonesContracts = array();
    public $aCampaignsDeliveredImpressions = array();
    public $aZonesSumProbability = array();

    /**
     * How many operation intervals are left till the end of today
     * 
     * @var integer
     */
    public $operationIntervalsTillTheEndOfToday;

    /**
     * The array of dates when the MPE last ran
     * Array of Date strings relating to the last run info 
     * (contains 'start_run' and 'now' indexes with the PEAR_Dates)
     *
     * @var array
     */
    var $aLastRun;

    /**
     * Contains both start and end date of the operation interval in which
     * the MPE is being executing. (contains indexes 'start' and 'end' with
     * PEAR_Dates)
     *
     * @var array
     */
    var $aOIDates;

    /**
     * A date representing "now", ie. the current date/time.
     *
     * @var PEAR::Date
     */
    var $oDateNow;

    /**
     * The main method of the class, that is run by the controlling
     * task runner class.
     */
    function run()
    {
        OA::debug('Running Maintenance Priority Engine: ECPM', PEAR_LOG_DEBUG);
        // Record the start of this ECPM run
        $oStartDate = new Date();
        // Get the details of the last time Priority Compensation started running
        $aDates =
            $this->oDal->getMaintenancePriorityLastRunInfo(
                DAL_PRIORITY_UPDATE_ECPM,
                array('start_run', 'end_run')
            );
        if (!is_null($aDates)) {
            // Set the details of the last time Priority Compensation started running
            $this->aLastRun['start_run'] = new Date($aDates['start_run']);
            // Set the details of the current date/time
            $oServiceLocator =& OA_ServiceLocator::instance();
            $this->aLastRun['now'] =& $oServiceLocator->get('now');
        }
        $this->oDateNow = $this->getDateNow();
        $this->aOIDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->oDateNow);

        $this->runAlgorithm();

        // Record the completion of the task in the database
        // Note that the $oUpdateTo parameter is "null", as this value is not
        // appropriate when recording Priority Compensation task runs - all that
        // matters is the start/end dates.
        OA::debug('- Recording completion of the ECPM task', PEAR_LOG_DEBUG);
        $oEndDate = new Date();
        $this->oDal->setMaintenancePriorityLastRunInfo(
            $oStartDate,
            $oEndDate,
            null,
            DAL_PRIORITY_UPDATE_ECPM
        );
    }

    /**
     * Executes the eCPM algorithm. For each agency calculates the probabilities.
     * Calculations for each of the agencies are carried on in separate
     * loops so it should be relatively easy to scale this algorithm up
     * and sums the data for different agencies using different machines.
     */
    public function runAlgorithm()
    {
        $aAgenciesIds = $this->oDal->getEcpmAgenciesIds();
        foreach($aAgenciesIds as $agencyId) {
            $this->resetHelperProperties();
            $aCampaignsInfo = $this->oDal->getCampaignsInfoByAgencyId($agencyId);
            if (is_array($aCampaignsInfo) && !empty($aCampaignsInfo)) {
                $this->preloadZonesContractsForAgency($agencyId);
                $this->preloadCampaignsDeliveredImpressionsForAgency($agencyId);
                $this->prepareCampaignsParameters($aCampaignsInfo);
                $this->oDal->updateEcpmPriorities($this->calculateDeliveryProbabilities($aCampaignsInfo));
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
        $aAdZonesProbabilities = array();
        foreach($aCampaignsInfo as $campaignId => $aCampaign) {
            foreach($aCampaign[self::IDX_ADS] as $adId => $aAd) {
                foreach($aAd[self::IDX_ZONES] as $zoneId) {
                    if ($this->aZonesEcpmPowAlphaSums[$zoneId]) {
                        $p = $this->aAdsEcpmPowAlpha[$adId] / $this->aZonesEcpmPowAlphaSums[$zoneId];
                    } else {
                        // the ECPM should be always set, but in case its not, avoid division by zero
                        $p = 0;
                    }
                    $M = $this->getZoneContract($zoneId);
                    $minRequestedImpr = $aAdsZonesMinImpressions[$adId][$zoneId];
                    if ($minRequestedImpr > $M) {
                        // make sure estimated number of impressions is always bigger
                        // than requested minimum
                        $minRequestedImpr = $M;
                    }
                    if ($this->aZonesMinImpressions[$zoneID] > $M) {
                        $aAdZonesProbabilities[$adId][$zoneId] =
                            $minRequestedImpr / $aZonexMinImpressions[$zoneID];
                    } else {
                       $aAdZonesProbabilities[$adId][$zoneId] =
                           $minRequestedImpr / $M
                           + (1 - $this->aZonesMinImpressions[$zoneId] / $M) * $p;
                    }
                    $this->sumUpZoneProbability($zoneId, $aAdZonesProbabilities[$adId][$zoneId]);
                }
            }
        }
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
                $aAdZonesProbabilities[$adId][$zoneId] = $p / $this->aZonesSumProbability[$zoneId];
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
     * This function can be divided into two functionaly separate functions
     * but that would require passing the campaignsInfo array twice so from
     * the performance reasons both tasks are performed in signle pass.
     *
     * @param array $aCampaignsInfo  Contains all ecpm campaigns withing one agency with
     *                               all their ads and the zones they are linked to.
     *                               For a specific of the indexes withing this array see:
     *                               OA_Dal_Maintenance_Priority::getCampaignsInfoByAgencyId
     */
    function prepareCampaignsParameters($aCampaignsInfo)
    {
        $campaignRemainingOperationIntervals = $this->getTodaysRemainingOperationIntervals();
        foreach($aCampaignsInfo as $campaignId => $aCampaign) {
            $deliveredImpressions = $this->getCampaignDeliveredImpressions($campaignId);
            $campaignAdsWeightSum = 0;
            // Calculates ECPM ^ ALPHA and sums of ads weights
            foreach($aCampaign[self::IDX_ADS] as $adId => $adInfo) {
                // calculate sum of all ads weights across a campaign
                $campaignAdsWeightSum += $adInfo[self::IDX_WEIGHT];
                
                $this->setAdEcpmPowAlpha($adId, $aCampaign[self::IDX_ECPM]);
                $this->setZonesEcpmPowAlphaSums($adId, $adInfo[self::IDX_ZONES]);
            }
            // Calculates minimum number of required impressions for each ad
            // and scale it proportionally to the ad weight
            foreach($aCampaign[self::IDX_ADS] as $adId => $adInfo) {
                $minImpressionsToDeliver = $aCampaign[self::IDX_MIN_IMPRESSIONS] - $deliveredImpressions;
                if ($minImpressionsToDeliver < 0) {
                    $minImpressionsToDeliver = 0;
                } else {
                    // number of impressions which should be delivered in this operation interval
                    $minImpressionsToDeliver = $minImpressionsToDeliver / $campaignRemainingOperationIntervals;
                }
                // scale the campaign min.impressions to each of ads proportionally
                // to the weights of the ad
                $this->setAdMinImpressions($adId, $adInfo[self::IDX_WEIGHT],
                    $campaignAdsWeightSum, $minImpressionsToDeliver
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
    public function setAdMinImpressions($adId, $adWeight,
        $campaignAdsWeightSum, $campaignMinRequiredImpressions)
    {
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
        foreach($aZones as $zoneId) {
            if (!isset($this->aZonesEcpmPowAlphaSums[$zoneId])) {
                $this->aZonesEcpmPowAlphaSums[$zoneId] = 0;
            }
            $this->aZonesEcpmPowAlphaSums[$zoneId]
                += $this->aAdsEcpmPowAlpha[$adId];
        }
    }

    /**
     * Calculates parameter ecpm^Alpha (see ad selection algorithm papaer)
     *
     * @param integer $adId  Ad ID
     * @param float $campaignEcpm  Campaign eCPM
     */
    public function setAdEcpmPowAlpha($adId, $campaignEcpm)
    {
        $this->aAdsEcpmPowAlpha[$adId] = pow($campaignEcpm, self::ALPHA);
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
        $aAdsZonesMinImpressions = array();
        foreach($aCampaignsInfo as $campaignId => $aCampaign) {
            foreach($aCampaign[self::IDX_ADS] as $adId => $aAd) {
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
        $aAdZonesMinImpressions = array();
        $adZonesContractsSum = $this->getAdZonesContractsSum($aZones);
        if ($adMinImpressions > $adZonesContractsSum) {
            // ad can't get more impressions than are available in all zones
            // it is assigned to
            $adMinImpressions = $adZonesContractsSum;
        }
        foreach($aZones as $zoneId) {
            $zoneContract = $this->getZoneContract($zoneId);
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
        foreach($aZones as $zoneId) {
            $sum += $this->getZoneContract($zoneId);
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
     * Calculates zones contracts for a given agency (for today).
     * A contract is a result of forecasting (ZIF) minus
     * requested impressions in a given zone by high priority
     * campaigns.
     *
     * @param integer $agencyId  Agency ID
     */
    public function preloadZonesContractsForAgency($agencyId)
    {
        $startDateString = $this->aOIDates['start']->format(self::DATE_FORMAT);
        $endDateString = $this->aOIDates['end']->format(self::DATE_FORMAT);

        $this->aZonesContracts = $this->oDal->getZonesForecastsByAgency($agencyId,
            $startDateString, $endDateString);
        if (!$this->aZonesContracts) {
            $this->aZonesContracts = array();
        }
        $aZonesAllocations = $this->oDal->getZonesAllocationsByAgency($agencyId);
        // Substract allocations from forecasts to get the number of available impressions
        // in each of the zoned under agency
        foreach ($aZonesAllocations as $zoneId => $zoneAllocation) {
            if (isset($this->aZonesContracts[$zoneId]) && $zoneAllocation) {
                $this->aZonesContracts[$zoneId] -= $zoneAllocation;
                if ($this->aZonesContracts[$zoneId] < 0) {
                    $this->aZonesContracts[$zoneId] = 0;
                }
            }
        }
    }

    /**
     * Returns zone contract (forecasting minus requested impressions)
     *
     * @param integer $zoneId  Zone ID
     * @return integer  Amount of available impressions (contract)
     */
    public function getZoneContract($zoneId)
    {
        return isset($this->aZonesContracts[$zoneId]) ?
            $this->aZonesContracts[$zoneId] : self::DEFAULT_ZONE_FORECAST;
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
        $this->aZonesMinImpressions = array();
        $this->aAdsEcpmPowAlpha = array();
        $this->aAdsMinImpressions = array();
        $this->aZonesEcpmPowAlphaSums = array();
        $this->aZonesContracts = array();
        $this->aCampaignsDeliveredImpressions = array();
        $this->aZonesSumProbability = array();
    }

    /**
     * Get the current "now" time from the OA_ServiceLocator,
     * or create it if not set yet
     */
    function getDateNow()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDateNow =& $oServiceLocator->get('now');
        if (!$oDateNow) {
            $oDateNow = new Date();
            $oServiceLocator->register('now', $oDateNow);
        }
        return $oDateNow;
    }

    /**
     * Factory and returns Dal object for a given table
     *
     * @param string $tableName  Dal name (table name)
     * @return object  Dal object
     */
    function _factoryDal($tableName)
    {
        return OA_Dal::factoryDal($tableName);
    }
}

?>
