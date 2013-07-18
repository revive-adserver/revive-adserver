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