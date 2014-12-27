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
 *
 */

require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/TrackerInfo.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Trackers.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Variables.php';

class OA_Dll_Tracker extends OA_Dll
{
    const ERROR_UNKNOWN_TRACKER_ID = 'Unknown trackerId Error';
    const ERROR_UNKNOWN_CAMPAIGN_ID = 'Unknown campaignId Error';
    const ERROR_UPDATE_CODE = 'Error updating variable code';
    const ERROR_DELETE = 'Error deleting tracker';
    const ERROR_CAMPAIGN_ADVERTISER_MISMATCH = 'Campaign must be owned by same advertiser';

    /**
     * Performs data validation for a tracker. The method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @param OA_Dll_TrackerInfo &$oTrackerInfo
     *
     * @return boolean  Returns false if fields are not valid and true if valid.
     *
     */
    private function validate(&$oTrackerInfo)
    {
        if (isset($oTrackerInfo->trackerId)) {
            // When modifying a tracker, check correct field types are used and the trackerId exists.
            if (!$this->checkStructureRequiredIntegerField($oTrackerInfo, 'trackerId') ||
                !$this->checkIdExistence('trackers', $oTrackerInfo->trackerId) ||
                !$this->checkStructureNotRequiredStringField($oTrackerInfo, 'trackerName', 255)) {

                return false;
            }
        } else {
            // Adding a tracker.
            if (!$this->checkStructureRequiredIntegerField($oTrackerInfo, 'clientId') ||
                !$this->checkStructureRequiredStringField($oTrackerInfo, 'trackerName', 255)) {

                return false;
            }
        }

        if (!$this->checkStructureNotRequiredStringField($oTrackerInfo, 'description', 255) ||
            !$this->checkStructureNotRequiredIntegerField($oTrackerInfo, 'status') ||
            !$this->checkStructureNotRequiredIntegerField($oTrackerInfo, 'type') ||
            !$this->checkStructureNotRequiredBooleanField($oTrackerInfo, 'linkCampaigns') ||
            !$this->checkStructureNotRequiredStringField($oTrackerInfo, 'variableMethod')) {

            return false;
        }
        return true;
    }

    /**
     * This method modifies an existing tracker. Undefined fields do not changed
     * and defined fields with a NULL value also remain unchanged.
     *
     * @param OA_Dll_TrackerInfo &$oTrackerInfo <br />
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> trackerName, clientId<br />
     *          <b>Optional properties:</b> description, status, type, linkCampaigns, variableMethod<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> trackerId<br />
     *          <b>Optional properties:</b> trackerName, description, status, type, linkCampaigns, variableMethod<br />
     *
     * @return boolean  True if the operation was successful
     *
     */
    public function modify(&$oTrackerInfo)
    {
        if (!isset($oTrackerInfo->trackerId)) {
            // Add
            $oTrackerInfo->setDefaultForAdd();

            // Check permission for the advertiser.
            if (isset($oTrackerInfo->clientId)) {
                if (!$this->checkPermissions(
                        array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
                        'clients', $oTrackerInfo->clientId)) {
                    return false;
                }
            }
        } else {
            // Modify
            if (!$this->checkIdExistence('trackers', $oTrackerInfo->trackerId)) {
                $this->raiseError(self::ERROR_UNKNOWN_TRACKER_ID);
                return false;
            }
            if (!$this->checkPermissions(array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
                'trackers', $oTrackerInfo->trackerId)) {
                return false;
            }
        }

        if ($this->validate($oTrackerInfo)) {
            $aTrackerData = $oTrackerInfo->getDataObjectArray();
            $doTracker = OA_Dal::factoryDO('trackers');

            if (!isset($oTrackerInfo->trackerId)) {
                $doTracker->setFrom($aTrackerData);
                $oTrackerInfo->trackerId = $doTracker->insert();
            } else {
                $doTracker->get($oTrackerInfo->trackerId);
                $doTracker->setFrom($aTrackerData);
                $doTracker->update();

                // Update the variable code for the tracker's variables
                // if the variableMethod was set.
                if (!empty($oTrackerInfo->variableMethod)) {
                    $dalVariables = OA_Dal::factoryDAL('variables');
                    if (!$dalVariables->updateVariableCode($oTrackerInfo->trackerId, $oTrackerInfo->variableMethod)) {
                        $this->raiseError(self::ERROR_UPDATE_CODE);
                        return false;
                    }
                }
            }

            return true;

        } else {
            return false;
        }
    }

    /**
     * Deletes an existing tracker.
     *
     * @param integer $trackerId  The ID of the tracker to delete
     * @return boolean  True if the operation was successful
     */
    public function delete($trackerId)
    {
        if (!$this->checkIdExistence('trackers', $trackerId)) {
            return false;
        }

        if (!$this->checkPermissions(
            array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
            'trackers', $trackerId)) {

            return false;
        }

        $doTracker = OA_Dal::factoryDO('trackers');
        $doTracker->trackerid = $trackerId;
        $result = $doTracker->delete();

        if ($result) {
            return true;
        } else {
            $this->raiseError(self::ERROR_DELETE);
            return false;
        }
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
    public function linkTrackerToCampaign($trackerId, $campaignId, $status = null)
    {
        if (!$this->checkIdExistence('trackers', $trackerId)) {
            $this->raiseError(self::ERROR_UNKNOWN_TRACKER_ID);
            return false;
        }

        if (!$this->checkIdExistence('campaigns', $campaignId)) {
            $this->raiseError(self::ERROR_UNKNOWN_CAMPAIGN_ID);
            return false;
        }

        if (!$this->checkPermissions(array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
            'trackers', $oTrackerInfo->trackerId)) {
            return false;
        }

        if (!$this->checkSameAdvertiser($trackerId, $campaignId)) {
            $this->raiseError(self::ERROR_CAMPAIGN_ADVERTISER_MISMATCH);
            return false;
        }

        $dalTrackers = OA_Dal::factoryDAL('trackers');
        $aLinkedCampaigns = $dalTrackers->getLinkedCampaigns($trackerId);
        if (!isset($aLinkedCampaigns[$campaignId])) {
            $result = $dalTrackers->linkCampaign($trackerId, $campaignId, $status);

            if (PEAR::isError($result)) {
                $this->raiseError($result->getMessage());
                return false;
            }
            return true;
        } else {
            // Already linked
            return true;
        }
    }

    /**
     * Gets tracker info
     *
     * @param int $trackerId
     * @param OA_Dll_TrackerInfo $oTrackerInfo
     * @return boolean
     */
    public function getTracker($trackerId, &$oTrackerInfo)
    {
        if ($this->checkIdExistence('trackers', $trackerId)) {
            if (!$this->checkPermissions(null, 'trackers', $trackerId)) {
                return false;
            }
            $doTracker = OA_Dal::factoryDO('trackers');
            $doTracker->get($trackerId);
            $aTrackerData = $doTracker->toArray();

            $oTrackerInfo = new OA_Dll_TrackerInfo();

            $oTrackerInfo->setTrackerDataFromArray($aTrackerData);
            return true;

        } else {

            $this->raiseError(self::ERROR_UNKNOWN_TRACKER_ID);
            return false;
        }
    }

    public function checkSameAdvertiser($trackerId, $campaignId)
    {
        $doTracker = OA_Dal::staticGetDO('trackers', $trackerId);
        $doCampaign = OA_Dal::staticGetDO('campaigns', $campaignId);

        if ($doTracker && $doCampaign) {
            return $doTracker->clientid == $doCampaign->clientid;
        }

        return false;
    }
}

?>
