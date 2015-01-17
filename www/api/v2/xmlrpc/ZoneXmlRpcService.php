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
 * @package    OpenX
 *
 * The zone XML-RPC service enables XML-RPC communication with the zone object.
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the base class, BaseZoneService.
require_once MAX_PATH . '/www/api/v2/common/BaseZoneService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

// Require the ZoneInfo helper class.
require_once MAX_PATH . '/lib/OA/Dll/Zone.php';

/**
 * The ZoneXmlRpcService class the BaseZoneService class.
 *
 */
class ZoneXmlRpcService extends BaseZoneService
{
    /**
     * The ZoneXmlRpcService constructor calls the base service constructor
     * to initialise the service.
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The addZone method adds details for a new zone to the zone
     * object and returns either the zone ID or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function addZone(&$oParams)
    {
        $sessionId          = null;
        $oZoneInfo          = new OA_Dll_ZoneInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oZoneInfo, $oParams,
                1, array('publisherId', 'zoneName', 'type', 'width', 'height', 'comments',
                    'capping', 'sessionCapping', 'block', 'append', 'prepend', 'chainedZoneId'),
                $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->addZone($sessionId, $oZoneInfo)) {
            return XmlRpcUtils::integerTypeResponse($oZoneInfo->zoneId);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }

    }

    /**
     * The modifyZone method changes the details for an existing zone
     * or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function modifyZone(&$oParams)
    {
        $sessionId          = null;
        $oZoneInfo          = new OA_Dll_ZoneInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oZoneInfo, $oParams,
                1, array('zoneId', 'publisherId', 'zoneName', 'type', 'width',
                  'height', 'comments', 'capping', 'sessionCapping', 'block', 'append', 'prepend', 'chainedZoneId'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->modifyZone($sessionId, $oZoneInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The deleteZone method either deletes an existing zone or
     * returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function deleteZone(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$zoneId),
            array(true, true), $oParams, $oResponseWithError )) {

            return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->deleteZone($sessionId, $zoneId)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The zoneDailyStatistics method returns daily statistics for a zone
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function zoneDailyStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oZoneServiceImp->getZoneDailyStatistics($sessionId,
                $zoneId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('day' => 'date',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The zoneAdvertiserStatistics method returns advertiser statistics for a zone
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function zoneAdvertiserStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aData = null;
        if ($this->_oZoneServiceImp->getZoneAdvertiserStatistics($sessionId,
                $zoneId, $oStartDate, $oEndDate, $localTZ, $aData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $aData);

        } else {

            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The zoneCampaignStatistics method returns campaign statistics for a zone
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function zoneCampaignStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oZoneServiceImp->getZoneCampaignStatistics($sessionId,
                $zoneId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'campaignId' => 'integer',
                                                                'campaignName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The zoneBannerStatistics method returns banner statistics for a zone
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function zoneBannerStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oZoneServiceImp->getZoneBannerStatistics($sessionId,
                $zoneId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'campaignId' => 'integer',
                                                                'campaignName' => 'string',
                                                                'bannerId' => 'integer',
                                                                'bannerName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The getZone method returns either information about a zone or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oZone
     *
     * @return generated result (data or error)
     */
    function getZone(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $oZone = null;
        if ($this->_oZoneServiceImp->getZone($sessionId,
                $zoneId, $oZone)) {

            return XmlRpcUtils::getEntityResponse($oZone);
        } else {

            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The getZoneListByPublisherId method returns a list of zones
     * for an publisher, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getZoneListByPublisherId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$publisherId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aZoneList = null;
        if ($this->_oZoneServiceImp->getZoneListByPublisherId($sessionId,
                                            $publisherId, $aZoneList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aZoneList);
        } else {

            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    function linkBanner($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$bannerId),
                array(true, true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->linkBanner($sessionId, $zoneId, $bannerId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    function linkCampaign($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$campaignId),
                array(true, true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->linkCampaign($sessionId, $zoneId, $campaignId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    function unlinkBanner($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$bannerId),
                array(true, true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->unlinkBanner($sessionId, $zoneId, $bannerId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    function unlinkCampaign($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$campaignId),
                array(true, true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->unlinkCampaign($sessionId, $zoneId, $campaignId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    function generateTags($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$zoneId, &$codeType, &$aParams),
                array(true, true, true, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->generateTags($sessionId, $zoneId, $codeType, $aParams, $generatedTag)) {
            return XmlRpcUtils::stringTypeResponse($generatedTag);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

}

?>
