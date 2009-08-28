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

require_once '../../../../init.php';
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';
require_once MAX_PATH . '/www/api/v2/common/BaseTrackerService.php';
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';
require_once MAX_PATH . '/lib/OA/Dll/Tracker.php';

/**
 * Description of TrackerXmlRpcService
 *
 * @author David Keen <david.keen@openx.org>
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

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oTrackerInfo, $oParams, 1,
                array('clientId', 'trackerName', 'description', 'status',
                    'type', 'linkCampaigns', 'variableMethod'),
                $oResponseWithError)) {

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
        $sessionId  = null;
        $oTrackerInfo = new OA_Dll_TrackerInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oTrackerInfo, $oParams, 1,
                array('trackerId', 'trackerName', 'description', 'status', 
                    'type', 'linkCampaigns', 'variableMethod'),
                $oResponseWithError)) {

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

        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$trackerId),
            array(true, true), $oParams, $oResponseWithError )) {

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
    function linkTrackerToCampaign($oParams)
    {
        $sessionId = null;
        $trackerId = null;
        $status = null;
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$trackerId, &$campaignId, &$status),
                array(true, true, true, false), $oParams, $oResponseWithError)) {
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
                array(&$sessionId, &$trackerId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        if ($this->oTrackerServiceImpl->getTracker($sessionId,
                $trackerId, $oTrackerInfo)) {

            return XmlRpcUtils::getEntityResponse($oTrackerInfo);
        } else {

            return XmlRpcUtils::generateError($this->oTrackerServiceImpl->getLastError());
        }
    }

}

?>
