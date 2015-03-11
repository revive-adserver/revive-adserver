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
 * The publisher XML-RPC service enables XML-RPC communication with the publisher object.
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the base class, BasePublisherService.
require_once MAX_PATH . '/www/api/v2/common/BasePublisherService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

// Require the PublisherInfo helper class.
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';


/**
 * The PublisherXmlRpcService class extends the BasePublisherService class.
 *
 */
class PublisherXmlRpcService extends BasePublisherService
{
    /**
     * The PublisherXmlRpcService constructor calls the base service constructor
     * to initialise the service.
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The addPublisher method adds details for a new publisher to the publisher
     * object and returns either the publisher ID or an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function addPublisher(&$oParams)
    {
        $sessionId          = null;
        $oPublisherInfo     = new OA_Dll_PublisherInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oPublisherInfo, $oParams,
                1, array('agencyId', 'publisherName', 'contactName',
                        'emailAddress', 'website', 'username', 'password', 'comments'),
                        $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oPublisherServiceImp->addPublisher($sessionId, $oPublisherInfo)) {
            return XmlRpcUtils::integerTypeResponse($oPublisherInfo->publisherId);
        } else {
            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The modifyPublisher method changes the details for an existing publisher
     * or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function modifyPublisher(&$oParams)
    {
        $sessionId          = null;
        $oPublisherInfo     = new OA_Dll_PublisherInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oPublisherInfo, $oParams,
                1, array('publisherId', 'agencyId', 'publisherName',
                        'contactName', 'emailAddress', 'website',
                        'username', 'password', 'comments'),
                        $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oPublisherServiceImp->modifyPublisher($sessionId, $oPublisherInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The deletePublisher method either deletes an existing publisher or
     * returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function deletePublisher(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$publisherId),
            array(true, true), $oParams, $oResponseWithError )) {

            return $oResponseWithError;
        }

        if ($this->_oPublisherServiceImp->deletePublisher($sessionId, $publisherId)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The publisherDailyStatistics method returns daily statistics for a publisher
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function publisherDailyStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$publisherId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aData = null;
        if ($this->_oPublisherServiceImp->getPublisherDailyStatistics($sessionId,
                $publisherId, $oStartDate, $oEndDate, $localTZ, $aData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('day' => 'date',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $aData);

        } else {

            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The publisherZoneStatistics method returns zone statistics for a publisher
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function publisherZoneStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$publisherId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oPublisherServiceImp->getPublisherZoneStatistics($sessionId,
                $publisherId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('zoneId' => 'integer',
                                                                'zoneName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The publisherAdvertiserStatistics method returns advertiser statistics for a publisher
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function publisherAdvertiserStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$publisherId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oPublisherServiceImp->getPublisherAdvertiserStatistics($sessionId,
                $publisherId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The publisherCampaignStatistics method returns campaign statistics for a publisher
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function publisherCampaignStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$publisherId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oPublisherServiceImp->getPublisherCampaignStatistics($sessionId,
                $publisherId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'campaignId' => 'integer',
                                                                'campaignName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                'conversions' => 'integer'
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The publisherBannerStatistics method returns banner statistics for a publisher
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function publisherBannerStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$publisherId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oPublisherServiceImp->getPublisherBannerStatistics($sessionId,
                $publisherId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

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
                                                                'conversions' => 'integer'
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The getPublisher method returns either information about a publisher or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getPublisher(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$publisherId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $oPublisher = null;
        if ($this->_oPublisherServiceImp->getPublisher($sessionId,
                $publisherId, $oPublisher)) {

            return XmlRpcUtils::getEntityResponse($oPublisher);
        } else {

            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

    /**
     * The getPublisherListByAgencyId method returns a list of publishers
     * for an agency, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getPublisherListByAgencyId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aPublisherList = null;
        if ($this->_oPublisherServiceImp->getPublisherListByAgencyId($sessionId,
                                            $agencyId, $aPublisherList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aPublisherList);
        } else {

            return XmlRpcUtils::generateError($this->_oPublisherServiceImp->getLastError());
        }
    }

}

?>
