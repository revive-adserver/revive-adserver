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

require_once '../../../../init.php';
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';
require_once MAX_PATH . '/www/api/v2/common/BaseTrackerService.php';
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';
require_once MAX_PATH . '/lib/OA/Dll/Tracker.php';

/**
 * Description of TrackerXmlRpcService
 */
class TrackerXmlRpcService extends BaseTrackerService
{
    /**
     * Adds a tracker.
     *
     * @param XML_RPC_Message &$oParams
     * @return generated result (data or error)
     */
    public function addTracker(&$oParams)
    {
        $sessionId = null;
        $oTrackerInfo = new OA_Dll_TrackerInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue(
            $sessionId,
            $oParams,
            0,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getStructureScalarFields(
                $oTrackerInfo,
                $oParams,
                1,
                ['clientId', 'trackerName', 'description', 'status',
                    'type', 'linkCampaigns', 'variableMethod'],
                $oResponseWithError
            )) {
            return $oResponseWithError;
        }

        if ($this->oTrackerServiceImpl->addTracker($sessionId, $oTrackerInfo)) {
            return XmlRpcUtils::integerTypeResponse($oTrackerInfo->trackerId);
        } else {
            return XmlRpcUtils::generateError($this->oTrackerServiceImpl->getLastError());
        }
    }

    /**
     * Changes the details for an existing tracker.
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function modifyTracker(&$oParams)
    {
        $sessionId = null;
        $oTrackerInfo = new OA_Dll_TrackerInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue(
            $sessionId,
            $oParams,
            0,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getStructureScalarFields(
                $oTrackerInfo,
                $oParams,
                1,
                ['trackerId', 'trackerName', 'description', 'status',
                    'type', 'linkCampaigns', 'variableMethod'],
                $oResponseWithError
            )) {
            return $oResponseWithError;
        }

        if ($this->oTrackerServiceImpl->modifyTracker($sessionId, $oTrackerInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->oTrackerServiceImpl->getLastError());
        }
    }

    /**
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function deleteTracker(&$oParams)
    {
        $sessionId = null;
        $trackerId = null;
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$trackerId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->oTrackerServiceImpl->deleteTracker($sessionId, $trackerId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->oTrackerServiceImpl->getLastError());
        }
    }

    /**
     *
     * @param XML_RPC_Message $oParams
     * @return generated result (data or error)
     */
    public function linkTrackerToCampaign($oParams)
    {
        $sessionId = null;
        $trackerId = null;
        $status = null;
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$trackerId, &$campaignId, &$status],
            [true, true, true, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->oTrackerServiceImpl->linkTrackerToCampaign($sessionId, $trackerId, $campaignId, $status)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->oTrackerServiceImpl->getLastError());
        }
    }

    public function getTracker(&$oParams)
    {
        $sessionId = null;
        $trackerId = null;
        $oTrackerInfo = new OA_Dll_TrackerInfo();
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$trackerId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->oTrackerServiceImpl->getTracker(
            $sessionId,
            $trackerId,
            $oTrackerInfo
        )) {
            return XmlRpcUtils::getEntityResponse($oTrackerInfo);
        } else {
            return XmlRpcUtils::generateError($this->oTrackerServiceImpl->getLastError());
        }
    }
}
