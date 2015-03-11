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
 * The campaign XML-RPC service enables XML-RPC communication with the campaign object.
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the base class, BaseCampaignService.
require_once MAX_PATH . '/www/api/v2/common/BaseCampaignService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

// Require the CampaignInfo helper class.
require_once MAX_PATH . '/lib/OA/Dll/Campaign.php';


/**
 * The CampaignXmlRpcService class extends the BaseCampaignService class.
 *
 */
class CampaignXmlRpcService extends BaseCampaignService
{
    /**
     * The CampaignXmlRpcService constructor calls the base service constructor
     * to initialise the service.
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The addCampaign method adds details for a new campaign to the campaign
     * object and returns either the campaign ID or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function addCampaign(&$oParams)
    {
        $sessionId          = null;
        $oCampaignInfo      = new OA_Dll_CampaignInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oCampaignInfo, $oParams,
                1, array('advertiserId', 'campaignName', 'startDate', 'endDate',
                         'impressions', 'clicks', 'priority', 'weight',
                         'targetImpressions', 'targetClicks', 'targetConversions',
                         'revenue', 'revenueType',
                         'capping', 'sessionCapping', 'block', 'comments',
                         'viewWindow', 'clickWindow'),
                        $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oCampaignServiceImp->addCampaign($sessionId, $oCampaignInfo)) {
            return XmlRpcUtils::integerTypeResponse($oCampaignInfo->campaignId);
        } else {
            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * The modifyCampaign method changes the details for an existing campaign
     * or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function modifyCampaign(&$oParams)
    {
        $sessionId          = null;
        $oCampaignInfo      = new OA_Dll_CampaignInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oCampaignInfo, $oParams,
                1, array('advertiserId', 'campaignId', 'campaignName',
                        'startDate', 'endDate', 'impressions', 'clicks',
                        'priority', 'weight', 'targetImpressions', 'targetClicks',
                        'targetConversions', 'revenue', 'revenueType',
                        'capping', 'sessionCapping', 'block', 'comments',
                        'viewWindow', 'clickWindow'),
                        $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oCampaignServiceImp->modifyCampaign($sessionId, $oCampaignInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * The deleteCampaign method either deletes an existing campaign or
     * returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function deleteCampaign(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$campaignId),
            array(true, true), $oParams, $oResponseWithError )) {

            return $oResponseWithError;
        }

        if ($this->_oCampaignServiceImp->deleteCampaign($sessionId, $campaignId)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * The campaignDailyStatistics method returns daily statistics for a campaign
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function campaignDailyStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aData = null;
        if ($this->_oCampaignServiceImp->getCampaignDailyStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $localTZ, $aData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('day' => 'date',
                                                        'requests' => 'integer',
                                                        'impressions' => 'integer',
                                                        'clicks' => 'integer',
                                                        'revenue' => 'float',
                                                        ), $aData);
        } else {

            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * The campaignBannerStatistics method returns banner statistics for
     * a campaign for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function campaignBannerStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oCampaignServiceImp->getCampaignBannerStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('campaignId' => 'integer',
                                                        'campaignName' => 'string',
                                                        'bannerId' => 'integer',
                                                        'bannerName' => 'string',
                                                        'requests' => 'integer',
                                                        'impressions' => 'integer',
                                                        'clicks' => 'integer',
                                                        'revenue' => 'float',
                                                        ), $rsStatisticsData);
        } else {

            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * The campaignPublisherStatistics method returns publisher statistics for
     * a campaign for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function campaignPublisherStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oCampaignServiceImp->getCampaignPublisherStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('publisherId' => 'integer',
                                                        'publisherName' => 'string',
                                                        'requests' => 'integer',
                                                        'impressions' => 'integer',
                                                        'clicks' => 'integer',
                                                        'revenue' => 'float',
                                                        'conversions' => 'integer'
                                                        ), $rsStatisticsData);
        } else {

            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * The campaignZoneStatistics method returns zone statistics for
     * a campaign for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function campaignZoneStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oCampaignServiceImp->getCampaignZoneStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('publisherId' => 'integer',
                                                        'publisherName' => 'string',
                                                        'zoneId' => 'integer',
                                                        'zoneName' => 'string',
                                                        'requests' => 'integer',
                                                        'impressions' => 'integer',
                                                        'clicks' => 'integer',
                                                        'revenue' => 'float',
                                                        'conversions' => 'integer'
                                                        ), $rsStatisticsData);
        } else {

            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * The getCampaign method returns either information about a campaign or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getCampaign(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$campaignId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $oCampaign = null;
        if ($this->_oCampaignServiceImp->getCampaign($sessionId,
                $campaignId, $oCampaign)) {

            return XmlRpcUtils::getEntityResponse($oCampaign);
        } else {

            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * The getCampaignListByAdvertiserId method returns a list of campaigns
     * for an advertiser, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getCampaignListByAdvertiserId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$advertiserId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aCampaignList = null;
        if ($this->_oCampaignServiceImp->getCampaignListByAdvertiserId($sessionId,
                                            $advertiserId, $aCampaignList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aCampaignList);
        } else {

            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * Gets conversion statistics for
     * a campaign for a specified period, or returns an error message.
     *
     * @param XML_RPC_Message &$oParams
     * @return generated result (data or error)
     */
    public function campaignConversionStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oCampaignServiceImp->getCampaignConversionStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(
                array('campaignID' => 'integer',
                'trackerID' => 'integer',
                'bannerID' => 'integer',
                'conversionTime' => 'date',
                'conversionStatus' => 'integer',
                'userIp' => 'string',
                'action' => 'integer',
                'window' => 'integer',
                'variables' => 'struct'), $rsStatisticsData);
        } else {
            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }
}

?>
