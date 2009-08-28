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
