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

require_once MAX_PATH . '/lib/max/Dal/Entities.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * An entity class used to represent placements for the MPE.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 */
class OX_Maintenance_Priority_Campaign
{
    /**
     * The placement's ID.
     *
     * @var integer
     */
    public $id;

    /**
     * The placement's activation date/time, in ISO format
     *
     * @var string
     */
    public $activateTime;

    /**
     * The placement's expiration date/time, in ISO format
     *
     * @var string
     */
    public $expireTime;

    /**
     * The total placement lifetime booked impressions.
     *
     * @var integer
     */
    public $impressionTargetTotal;

    /**
     * The total placement lifetime booked clicks.
     *
     * @var integer
     */
    public $clickTargetTotal;

    /**
     * The total placement lifetime booked conversions.
     *
     * @var integer
     */
    public $conversionTargetTotal;

    /**
     * The placement daily booked impressions.
     *
     * @var integer
     */
    public $impressionTargetDaily;

    /**
     * The placement daily booked clicks.
     *
     * @var integer
     */
    public $clickTargetDaily;

    /**
     * The placement daily booked conversions.
     *
     * @var integer
     */
    public $conversionTargetDaily;

    /**
     * The placement's priority value (ie. -1 for override, 0 for low priority,
     * >= 1 for high-priority).
     *
     * @var integer
     */
    public $priority;

    /**
     * The number of times the placement has had an ad requested, either
     * to date, or today.
     *
     * @var integer
     */
    public $deliveredRequests;

    /**
     * The number of impressions ads in the placement have delivered, either
     * to date, or today.
     *
     * @var integer
     */
    public $deliveredImpressions;

    /**
     * The number of clicks ads in the placement have delivered, either
     * to date, or today.
     *
     * @var integer
     */
    public $deliveredClicks;

    /**
     * The number of conversions ads in the placement have delivered, either
     * to date, or today.
     *
     * @var integer
     */
    public $deliveredConversions;

    /**
     * The number of impressions the placement needs to deliver in order
     * to meets its delivery requirements. (Only ever set externally
     * to the class - there are no methods in the class to calculate this.)
     *
     * @var integer
     */
    public $requiredImpressions;

    /**
     * A local instance of the MAX_Dal_Entities class.
     *
     * @var MAX_Dal_Entities
     */
    public $oMaxDalEntities;

    /**
     * A local instance of the OA_Dal_Maintenance_Priority class.
     *
     * @var OA_Dal_Maintenance_Priority
     */
    public $oMaxDalMaintenancePriority;

    /**
     * An array, indexed by ad ID, of the placement's children
     * ads, as Ad objects.
     *
     * @var array
     */
    public $aAds = [];

    /**
     * An array that maps new parameter name keys to old parameter
     * name keys for the constructor method.
     *
     * @var array
     */
    public $aNewOldTypes = [
        'placement_id' => 'campaignid',
        'impression_target_total' => 'views',
        'click_target_total' => 'clicks',
        'conversion_target_total' => 'conversions',
        'impression_target_daily' => 'target_impression',
        'click_target_daily' => 'target_click',
        'conversion_target_daily' => 'target_conversion'
    ];

    /**
     * The class constructor method.
     *
     * @param array $aParams An associative array of values to be assigned to
     *                       the object. Valid array keys are:
     *      'campaignid' or 'placement_id'                   -> The placement ID. Required!
     *      'activate_time'                                  -> The activation date of the placement in
     *                                                          ISO format
     *      'expire_time'                                    -> The expiration date of the placement in
     *                                                          ISO format
     *      'views' or 'impression_target_total'             -> The placement lifetime impression target
     *      'clicks' or 'click_target_total'                 -> The placement lifetime click target
     *      'conversions' or 'conversion_target_total'       -> The placement lifetime conversion target
     *      'target_impression' or 'impression_target_daily' -> The dail impression target
     *      'target_click' or 'click_target_daily'           -> The daily click target
     *      'target_conversion' or 'conversion_target_daily' -> The daily conversion target
     *      'priority'                                       -> The placement priority
     */
    public function __construct($aParams)
    {
        // Convert "old" input value names to "new", if required
        foreach ($this->aNewOldTypes as $newName => $oldName) {
            if (!isset($aParams[$newName]) && isset($aParams[$oldName])) {
                $aParams[$newName] = $aParams[$oldName];
            }
        }
        // Test the input values
        $valid = true;
        if (!is_array($aParams)) {
            $valid = false;
        } else {
            if (count($aParams) < 0) {
                $valid = false;
            }
            if (!isset($aParams['placement_id']) || !is_numeric($aParams['placement_id'])) {
                $valid = false;
            }
        }
        if (!$valid) {
            $this->_abort();
            return;
        }

        // Store the required supplied values
        $this->id = (int)($aParams['placement_id'] ?? 0);

        // Store the optional required values
        $this->activateTime = isset($aParams['activate_time']) ? $aParams['activate_time'] : null;
        $this->expireTime = isset($aParams['expire_time']) ? $aParams['expire_time'] : null;
        $this->impressionTargetTotal = isset($aParams['impression_target_total']) ? (int)$aParams['impression_target_total'] : 0;
        $this->clickTargetTotal = isset($aParams['click_target_total']) ? (int)$aParams['click_target_total'] : 0;
        $this->conversionTargetTotal = isset($aParams['conversion_target_total']) ? (int)$aParams['conversion_target_total'] : 0;
        $this->impressionTargetDaily = isset($aParams['impression_target_daily']) ? (int)$aParams['impression_target_daily'] : 0;
        $this->clickTargetDaily = isset($aParams['click_target_daily']) ? (int)$aParams['click_target_daily'] : 0;
        $this->conversionTargetDaily = isset($aParams['conversion_target_daily']) ? (int)$aParams['conversion_target_daily'] : 0;
        $this->priority = isset($aParams['priority']) ? (int)$aParams['priority'] : 0;

        // Set the object's data access layer objects
        $this->oMaxDalEntities = $this->_getMAX_Dal_Entities();
        $this->oMaxDalMaintenancePriority = $this->_getOA_Dal_Maintenance_Priority();
    }

    /**
     * A private method to get an instance of the MAX_Dal_Entities class.
     *
     * @access private
     * @return MAX_Dal_Entities
     */
    public function &_getMAX_Dal_Entities()
    {
        $oServiceLocator = OA_ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('MAX_Dal_Entities');
        if (!$oDal) {
            $oDal = new MAX_Dal_Entities();
            $oServiceLocator->register('MAX_Dal_Entities', $oDal);
        }
        return $oDal;
    }

    /**
     * A private method to get an instance of the OA_Dal_Maintenance_Priority class.
     *
     * @access private
     * @return OA_Dal_Maintenance_Priority
     */
    public function &_getOA_Dal_Maintenance_Priority()
    {
        $oServiceLocator = OA_ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('OA_Dal_Maintenance_Priority');
        if (!$oDal) {
            $oDal = new OA_Dal_Maintenance_Priority();
            $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        }
        return $oDal;
    }

    /**
     * A method to set the placement's "aAds" array to contain the
     * (@link OA_Maintenance_Priority_Ad} objects for each ad in the placement,
     * from the data stored in the database.
     */
    public function setAdverts()
    {
        $aAds = $this->oMaxDalEntities->getAdsByCampaignId($this->id);
        if (is_array($aAds) && (count($aAds) > 0)) {
            reset($aAds);
            foreach ($aAds as $adId => $aAdDetails) {
                $this->aAds[$adId] = new OA_Maintenance_Priority_Ad($aAdDetails);
            }
        }
    }

    /**
     * A method to set details of the placement's delivery statistics
     * to date, from the data stored in the database.
     */
    public function setSummaryStatisticsToDate()
    {
        $aStats = $this->oMaxDalMaintenancePriority->getCampaignStats($this->id, false);
        $this->deliveredRequests = (int)($aStats['sum_requests'] ?? 0);
        $this->deliveredImpressions = (int)($aStats['sum_views'] ?? 0);
        $this->deliveredClicks = (int)($aStats['sum_clicks'] ?? 0);
        $this->deliveredConversions = (int)($aStats['sum_conversions'] ?? 0);
    }

    /**
     * A method to set details of the placement's delivery statistics
     * for "today" only, from the data stored in the database.
     *
     * @param string $today A string representing today's date in
     *                      "YYYY-MM-DD" format.
     */
    public function setSummaryStatisticsToday($today)
    {
        $aStats = $this->oMaxDalMaintenancePriority->getCampaignStats($this->id, true, $today);
        $this->deliveredRequests = (int)($aStats['sum_requests'] ?? 0);
        $this->deliveredImpressions = (int)($aStats['sum_views'] ?? 0);
        $this->deliveredClicks = (int)($aStats['sum_clicks'] ?? 0);
        $this->deliveredConversions = (int)($aStats['sum_conversions'] ?? 0);
    }

    /**
     * A private method to abort script execution when an attempt is made
     * to instantiate the entity with incorrect parameters.
     *
     * @access private
     */
    public function _abort()
    {
        $error = 'Unable to instantiate ' . __CLASS__ . ' object, aborting execution.';
        OA::debug($error, PEAR_LOG_EMERG);
        exit();
    }
}
