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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OA/Dll.php';

/**
 * An entity class used to represent ads for the MPE.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 */
class OA_Maintenance_Priority_Ad
{
    /**
     * The ad's ID.
     *
     * @var integer
     */
    public $id;

    /**
     * The ad's activity status (active, or not active).
     *
     * @var boolean
     */
    public $active;

    /**
     * The ad's type (eg. 'sql').
     *
     * @var string
     */
    public $type;

    /**
     * The ad's weight.
     *
     * @var integer
     */
    public $weight;

    public $requiredImpressions;
    public $requestedImpressions;
    public $toBeDelivered;

    public $zones = [];

    public $pastRequiredImpressions;
    public $pastRequestedImpressions;
    public $pastActualImpressions;
    public $pastAdZonePriorityFactor;
    public $pastZoneTrafficFraction;
    public $pastToBeDelivered;
    public $campaignPriority;

    /**
     * A local instance of the OA_Dal_Maintenance_Priority class.
     *
     * @var OA_Dal_Maintenance_Priority
     */
    public $oMaxDalMaintenancePriority;

    /**
     * The class constructor method.
     *
     * @param array $aParams An associative array of values to be assigned to
     *                       the object. The object can be created either with
     *                       ONLY the ad ID as a parameter, otherwise ALL
     *                       parameters must be set. Valid array keys are:
     *      'ad_id'  -> The ad ID. Required!
     *      'active' -> If the ad is active or not ('t', 'f', true or false).
     *      'type'   -> The ad type (eg. 'sql').
     *      'weight' -> The ad weight.
     */
    public function __construct($aParams)
    {
        // Test the input values
        $valid = true;
        if (!is_array($aParams)) {
            $valid = false;
        } else {
            if (!(count($aParams) == 1 || count($aParams) == 4)) {
                $valid = false;
            }
            if (isset($aParams['ad_id']) && is_numeric($aParams['ad_id'])) {
                $aParams['ad_id'] = (int)$aParams['ad_id'];
            } else {
                $valid = false;
            }
            if (count($aParams) == 4) {
                if (isset($aParams['status'])) {
                    if ($aParams['status'] == OA_ENTITY_STATUS_RUNNING) {
                        $aParams['active'] = true;
                    } else {
                        $aParams['active'] = false;
                    }
                }
                if (is_numeric($aParams['weight'])) {
                    $aParams['weight'] = (int)$aParams['weight'];
                } else {
                    $valid = false;
                }
                if (is_null($aParams['type'])) {
                    $valid = false;
                }
            }
        }
        if (!$valid) {
            $this->_abort();
            return;
        }
        // Store the required supplied values
        $this->id = $aParams['ad_id'];
        $this->active = isset($aParams['active']) ? $aParams['active'] : null;
        $this->type = isset($aParams['type']) ? $aParams['type'] : null;
        $this->weight = isset($aParams['weight']) ? $aParams['weight'] : null;
        // Set the object's data access layer objects
        $this->oMaxDalMaintenancePriority = $this->_getOA_Dal_Maintenance_Priority();
    }

    /**
     * A private method to get an instance of the OA_Dal_Maintenance_Priority class.
     *
     * @access private
     * @return OA_Dal_Maintenance_Priority
     */
    public function _getOA_Dal_Maintenance_Priority()
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
     * A method to get the delivery limitations of an advertisement
     * object from the database, and return them as an array.
     *
     * @return array An array of arrays, each representing a delivery
     *               limitation, for example:
     *               array(
     *                   [ad_id]             => 1
     *                   [logical]           => and
     *                   [type]              => Time:Hour
     *                   [comparison]        => ==
     *                   [data]              => 1,7,18,23
     *                   [executionorder]    => 1
     *               )
     */
    public function getDeliveryLimitations()
    {
        return $this->oMaxDalMaintenancePriority->getAllDeliveryLimitationsByTypeId($this->id, 'ad');
    }

    /**
     * A private method to abort script execution when an attempt is made
     * to instantiate the entity with incorrect parameters.
     *
     * @access private
     */
    protected function _abort()
    {
        $error = 'Unable to instantiate ' . __CLASS__ . ' object, aborting execution.';
        OA::debug($error, PEAR_LOG_EMERG);
        exit();
    }
}
