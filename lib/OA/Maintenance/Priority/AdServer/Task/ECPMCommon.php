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
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/OX/Util/Utils.php';

/**
 * A common eCPM class.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 */
abstract class OA_Maintenance_Priority_AdServer_Task_ECPMCommon extends OA_Maintenance_Priority_AdServer_Task
{
    /**
     * Default alpha parameter used to calculate the probabilities.
     */
    const ALPHA = 5.0;

    /**
     * If there is no data forecasted for a zone use this data as a default
     */
    const DEFAULT_ZONE_FORECAST = 100;

    /**
     * Indexes used for indexing arrays. More effective than using strings because less memory
     * will be used to store the data.
     * (For the debugging purposes its handy to change them to strings)
     */
    const IDX_ADS             = 1; // 'ads'
    const IDX_WEIGHT          = 2; // 'weight'
    const IDX_ZONES           = 3; // 'zones'
    const IDX_REVENUE         = 5; // 'revenue'
    const IDX_REVENUE_TYPE    = 6; // 'revenue_type'
    const IDX_ACTIVATE        = 7; // 'activate'
    const IDX_EXPIRE          = 8; // 'expire'
    const IDX_MIN_IMPRESSIONS = 9; // 'min_impressions'

    /**
     * Used to generate date (in string format) from the PEAR_Date
     */
    const DATE_FORMAT = '%Y-%m-%d %H:%M:%S';

    /**
     * Helper arrays for storing additional variables
     * required in calculations.
     *
     * @var array
     */
    public $aAdsEcpmPowAlpha = array();
    public $aZonesEcpmPowAlphaSums = array();
    public $aCampaignsEcpms = array();
    public $aCampaignsDeliveries = array();
    public $aZonesAvailableImpressions = null;

    /**
     * The array of dates when the MPE last ran
     * Array of Date strings relating to the last run info
     * (contains 'start_run' and 'now' indexes with the PEAR_Dates)
     *
     * @var array
     */
    var $aLastRun;

    /**
     * Contains both start and end dates of the operation interval in which
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
     * Task Name
     *
     * @var string
     */
    var $taskName = 'ECPM';

    abstract public function runAlgorithm();

    abstract public function getZonesAllocationByAgency($agencyId);

    /**
     * The main method of the class, that is run by the controlling
     * task runner class.
     */
    function run()
    {
        OA::debug('Running Maintenance Priority Engine: '.$this->taskName, PEAR_LOG_DEBUG);
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
        OA::debug('- Recording completion of the '.$this->taskName, PEAR_LOG_DEBUG);
        $oEndDate = new Date();
        $this->oDal->setMaintenancePriorityLastRunInfo(
            $oStartDate,
            $oEndDate,
            null,
            DAL_PRIORITY_UPDATE_ECPM
        );
    }

    /**
     * Calculates campaign eCPM based on the campaign history
     *
     * @param integer $campaignId  Campaign ID
     * @param array $aCampaign  Campaign information, see
     *                          OA_Dal_Maintenance_Priority::getCampaignsInfoByQuery
     *                          for info on its format
     * @return float  Calculated campaign eCPM
     */
    public function calculateCampaignEcpm($campaignId, $aCampaign)
    {
        return OX_Util_Utils::getEcpm(
            $aCampaign[self::IDX_REVENUE_TYPE],
            $aCampaign[self::IDX_REVENUE],
            $this->aCampaignsDeliveries[$campaignId]['sum_impressions'],
            $this->aCampaignsDeliveries[$campaignId]['sum_clicks'],
            $this->aCampaignsDeliveries[$campaignId]['sum_conversions'],
            $aCampaign[self::IDX_ACTIVATE],
            $aCampaign[self::IDX_EXPIRE]
        );
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
     * Calculates zones contracts for a given agency (for today).
     * A contract is a result of forecasting minus
     * requested impressions in a given zone by high priority
     * campaigns.
     *
     * @param integer $agencyId  Agency ID
     * @return bool true if the data was loaded during this call, false if the data was already cached
     */
    public function preloadZonesAvailableImpressionsForAgency($agencyId)
    {
        $dataJustFetched = false;
        // because the query is the same for all agencies, we run it only once
        if(is_null($this->aZonesAvailableImpressions)) {
            $startDateString = $this->aOIDates['start']->format(self::DATE_FORMAT);
            $endDateString = $this->aOIDates['end']->format(self::DATE_FORMAT);

            $this->aZonesAvailableImpressions = $this->oDal->getZonesForecasts( $startDateString, $endDateString);
            if (!$this->aZonesAvailableImpressions) {
                $this->aZonesAvailableImpressions = array();
            }
            $dataJustFetched = true;
        }
        $aZonesAllocations = $this->getZonesAllocationByAgency($agencyId);
        // Substract allocations from forecasts to get the number of available impressions
        // in each of the zone
        foreach ($aZonesAllocations as $zoneId => $zoneAllocation) {
            if (isset($this->aZonesAvailableImpressions[$zoneId]) && $zoneAllocation) {
                $this->aZonesAvailableImpressions[$zoneId] -= $zoneAllocation;
                if ($this->aZonesAvailableImpressions[$zoneId] < 0) {
                    $this->aZonesAvailableImpressions[$zoneId] = 0;
                }
            }
        }
        return $dataJustFetched;
    }

    /**
     * Returns zone available impressions (forecasting minus requested impressions)
     *
     * @param integer $zoneId  Zone ID
     * @return integer  Amount of available impressions (contract)
     */
    public function getZoneAvailableImpressions($zoneId)
    {
        return !empty($this->aZonesAvailableImpressions[$zoneId]) ?
            $this->aZonesAvailableImpressions[$zoneId] : self::DEFAULT_ZONE_FORECAST;
    }

    /**
     * Resets the helper arrays
     */
    public function resetHelperProperties()
    {
        $this->aAdsEcpmPowAlpha = array();
        $this->aZonesEcpmPowAlphaSums = array();
        $this->aZonesGuaranteeImpressionsSums = array();
        $this->aZonesAvailableImpressions = array();
        $this->aCampaignsEcpms = array();
        $this->aCampaignsDeliveries = array();
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
