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

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Trackers extends MAX_Dal_Common
{
    var $table = 'trackers';

    var $orderListName = array(
        'name' => 'trackername',
        'id'   => 'trackerid'
    );

    /**
     * Get all the campaigns linked to a given tracker.
     *
     * @param int $trackerId the ID of the tracker to fetch linked campaigns for.
     * @return array array of DataObjects_Campaigns objects:
     *               array(campaignId => campaignObject)
     */
    public function getLinkedCampaigns($trackerId)
    {
        $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaignsTrackers->trackerid = $trackerId;
        $doCampaignsTrackers->find();

        $aLinkedCampaigns = array();
        while ($doCampaignsTrackers->fetch()) {
            $oCampaign = OA_Dal::staticGetDO('campaigns', $doCampaignsTrackers->campaignid);
            if ($oCampaign) {
                $aLinkedCampaigns[$oCampaign->campaignid] = $oCampaign;
            }
        }
        return $aLinkedCampaigns;
    }

    /**
     * Links a campaign to the given tracker ID
     *
     * @param int $trackerId the ID of the tracker to link the campaign to.
     * @param int $campaignId the ID of the campaign to link to the tracker.
     * @param int $status optional connection status type, eg MAX_CONNECTION_STATUS_APPROVED. See constants.php.
     *                    if no status given, uses the tracker's default status.
     * @return boolean true on successful link, false on error.
     */
    public function linkCampaign($trackerId, $campaignId, $status = null)
    {
        // Check the ID's are valid.
        if (!$this->idExists('trackers', $trackerId) || !$this->idExists('campaigns', $campaignId)) {
            return false;
        }

        $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaignsTrackers->trackerid = $trackerId;
        $doCampaignsTrackers->campaignid = $campaignId;

        if ($doCampaignsTrackers->find()) {
            // Already linked.
            return true;
        }

        // Set the status
        if (!is_null($status)) {
            $doCampaignsTrackers->status = $status;
        } else {
            $oTracker = OA_Dal::staticGetDO('trackers', $trackerId);
            $doCampaignsTrackers->status = $oTracker->status;
        }

        if ($doCampaignsTrackers->insert()) {
            return true;
        } else {
            return false;
        }
    }

    private function idExists($tableName, $id)
    {
        $doObject = OA_Dal::factoryDO($tableName);
        if (empty($id) || !($object = $doObject->get($id))) {
            return false;
        } else {
            return true;
        }
    }
}

?>