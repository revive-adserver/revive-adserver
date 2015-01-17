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
 * The advertiser XML-RPC service enables XML-RPC communication with the advertiser object.
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the base class, BaseAdvertiserService.
require_once MAX_PATH . '/www/api/v1/common/BaseAdvertiserService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

// Require the AdvertiserInfo helper class.
require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';

/**
 * The AdvertiserXmlRpcService class extends the BaseAdvertiserService class.
 *
 */
class AdvertiserXmlRpcService extends BaseAdvertiserService
{
    /**
     * The AdvertiserXmlRpcService constructor calls the base service constructor
     * to initialise the service.
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The addAdvertiser method adds details for a new advertiser to the advertiser
     * object and returns either the advertiser ID or an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function addAdvertiser($oParams)
    {
        $sessionId          = null;
        $oAdvertiserInfo    = new OA_Dll_AdvertiserInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oAdvertiserInfo, $oParams,
                1, array('agencyId', 'advertiserName', 'contactName',
                    'emailAddress', 'username', 'password', 'comments'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oAdvertiserServiceImp->addAdvertiser($sessionId, $oAdvertiserInfo)) {
            return XmlRpcUtils::integerTypeResponse($oAdvertiserInfo->advertiserId);
        } else {
            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * The modifyAdvertiser method changes the details for an existing advertiser
     * or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function modifyAdvertiser($oParams)
    {

        $sessionId          = null;
        $oAdvertiserInfo    = new OA_Dll_AdvertiserInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oAdvertiserInfo, $oParams,
                1, array('advertiserId', 'agencyId', 'advertiserName',
                    'contactName', 'emailAddress', 'username', 'password', 'comments'),
                $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oAdvertiserServiceImp->modifyAdvertiser($sessionId, $oAdvertiserInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }

    }

    /**
     * The deleteAdvertiser method either deletes an existing advertiser or
     * returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function deleteAdvertiser($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$advertiserId),
            array(true, true), $oParams, $oResponseWithError )) {

            return $oResponseWithError;
        }

        if ($this->_oAdvertiserServiceImp->deleteAdvertiser($sessionId, $advertiserId)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * The advertiserDailyStatistics method returns daily statistics for an advertiser
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserDailyStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$advertiserId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAdvertiserServiceImp->getAdvertiserDailyStatistics($sessionId,
                $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('day' => 'date',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * The advertiserCampaignStatistics method returns campaign statistics for
     * an advertiser for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserCampaignStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$advertiserId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAdvertiserServiceImp->getAdvertiserCampaignStatistics($sessionId,
                $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('campaignId' => 'integer',
                                                                'campaignName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * The advertiserBannerStatistics method returns banner statistics for an
     * advertiser for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserBannerStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$advertiserId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAdvertiserServiceImp->getAdvertiserBannerStatistics($sessionId,
                $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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

            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * The advertiserPublisherStatistics method returns the publisher statistics for
     * an advertiser for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserPublisherStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$advertiserId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAdvertiserServiceImp->getAdvertiserPublisherStatistics($sessionId,
                $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('publisherId' => 'integer',
                                                                'publisherName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);
        } else {

            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * The advertiserZoneStatistics method returns the zone statistics for an advertiser
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserZoneStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$advertiserId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAdvertiserServiceImp->getAdvertiserZoneStatistics($sessionId,
                $advertiserId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('publisherId' => 'integer',
                                                                'publisherName' => 'string',
                                                                'zoneId' => 'integer',
                                                                'zoneName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);
        } else {

            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * The getAdvertiser method returns either information about an advertiser or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    function getAdvertiser($oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$advertiserId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $oAdvertiser = null;
        if ($this->_oAdvertiserServiceImp->getAdvertiser($sessionId,
                $advertiserId, $oAdvertiser)) {

            return XmlRpcUtils::getEntityResponse($oAdvertiser);
        } else {

            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * The getAdvertiserListByAgencyId method returns a list of advertisers
     * for an agency, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    function getAdvertiserListByAgencyId($oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aAdvertiserList = null;
        if ($this->_oAdvertiserServiceImp->getAdvertiserListByAgencyId($sessionId,
                                            $agencyId, $aAdvertiserList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aAdvertiserList);
        } else {

            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

}

/**
 * Initialise the XML-RPC server including the available methods and their signatures.
 *
**/
$oAdvertiserXmlRpcService = new AdvertiserXmlRpcService();

$server = new XML_RPC_Server(
    array(
        'addAdvertiser' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'addAdvertiser'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Add advertiser'
        ),

        'modifyAdvertiser' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'modifyAdvertiser'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Modify advertiser information'
        ),

        'deleteAdvertiser' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'deleteAdvertiser'),
            'signature' => array(
                array('int', 'string', 'int')
            ),
            'docstring' => 'Delete advertiser'
        ),

        'advertiserDailyStatistics' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'advertiserDailyStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Advertiser Daily Statistics'
        ),

        'advertiserCampaignStatistics' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'advertiserCampaignStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Advertiser Campaign Statistics'
        ),

        'advertiserBannerStatistics' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'advertiserBannerStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Advertiser Banner Statistics'
        ),

        'advertiserPublisherStatistics' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'advertiserPublisherStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Advertiser Publisher Statistics'
        ),

        'advertiserZoneStatistics' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'advertiserZoneStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Advertiser Zone Statistics'
        ),

        'getAdvertiser' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'getAdvertiser'),
            'signature' => array(
                array('struct', 'string', 'int')
            ),
            'docstring' => 'Get Advertiser Information'
        ),

        'getAdvertiserListByAgencyId' => array(
            'function'  => array($oAdvertiserXmlRpcService, 'getAdvertiserListByAgencyId'),
            'signature' => array(
                array('array', 'string', 'int')
            ),
            'docstring' => 'Get Advertiser List By Agency Id'
        ),

    ),
    1  // serviceNow
);


?>
