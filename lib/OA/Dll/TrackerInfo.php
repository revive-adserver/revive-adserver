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

/**
 * @package    OpenXDll
 * @author     David Keen <david.keen@openx.org>
 *
 */

require_once MAX_PATH . '/lib/OA/Info.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Trackers.php';

class OA_Dll_TrackerInfo extends OA_Info
{
    

    // Required fields
    public $trackerId;
    public $clientId;
    public $trackerName;

    // Optional fields
    public $description;
    public $status;
    public $type;
    public $linkCampaigns;
    public $variableMethod;

    /**
     * This method sets default values for optional fields when adding a new tracker.
     *
     */
    public function setDefaultForAdd() 
    {
        if (empty($this->description)) {
            $this->description = '';
        }

        $pref = $GLOBALS['_MAX']['PREF'];

        if (empty($this->status)) {
            $this->status = isset($pref['tracker_default_status']) ? (int) $pref['tracker_default_status'] : MAX_CONNECTION_STATUS_APPROVED;
        }
        
        if (empty($this->type)) {
            $this->type = isset($pref['tracker_default_type']) ? (int) $pref['tracker_default_type'] : MAX_CONNECTION_TYPE_SALE;
        }

        if (empty($this->linkCampaigns)) {
            $this->linkCampaigns = $pref['tracker_link_campaigns'] == true ? true : false;
        }

        if (empty($this->variableMethod)) {
            $this->variableMethod = DataObjects_Trackers::TRACKER_VARIABLE_METHOD_DEFAULT;
        }
    }

    public function getFieldsTypes()
    {
        return array(
            'trackerId' => 'integer',
            'clientId' => 'integer',
            'trackerName' => 'string',
            'description' => 'string',
            'status' => 'integer',
            'type' => 'integer',
            'linkCampaigns' => 'boolean',
            'variableMethod' => 'string'
        );
    }

    /**
     * Returns an array suitable for updating a dataobject.
     *
     * @return array array of values to set on a dataobject.
     */
    public function getDataObjectArray()
    {
        $aTrackerData = (array) $this;
        $aTrackerData['trackerid'] = $aTrackerData['trackerId'];
        $aTrackerData['trackername'] = $aTrackerData['trackerName'];
        $aTrackerData['clientid'] = $aTrackerData['clientId'];

        // Convert from boolean.
        $aTrackerData['linkcampaigns'] = ($aTrackerData['linkCampaigns'] ? 1 : 0);
        $aTrackerData['variablemethod'] = $aTrackerData['variableMethod'];

        return $aTrackerData;
    }

    /**
     * Sets the TrackerInfo object from a dataObject array.
     *
     * @param array $aTrackerData array of values to set on TrackerInfo object.
     */
    public function setTrackerDataFromArray($aTrackerData)
    {
        // Transalate any field names to object variables
        // eg, $aTrackerData['objectVarName'] = $aTrackerData['tableColumnName']
        $aTrackerData['trackerId'] = $aTrackerData['trackerid'];
        $aTrackerData['trackerName'] = $aTrackerData['trackername'];
        $aTrackerData['clientId'] = $aTrackerData['clientid'];

        // Convert to boolean
        $aTrackerData['linkCampaigns'] = ($aTrackerData['linkcampaigns'] == 1 ? true : false);
        $aTrackerData['variableMethod'] = $aTrackerData['variablemethod'];

        $this->readDataFromArray($aTrackerData);
    }

}

?>
