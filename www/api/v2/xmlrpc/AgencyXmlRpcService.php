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
 * The agency XML-RPC service enables XML-RPC communication with the agency object.
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes on the server.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the base class, BaseAgencyService.
require_once MAX_PATH . '/www/api/v2/common/BaseAgencyService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

// Require the AgencyInfo helper class.
require_once MAX_PATH . '/lib/OA/Dll/Agency.php';

/**
 * The AgencyXmlRpcService class extends the BaseAgencyService class.
 *
 */
class AgencyXmlRpcService extends BaseAgencyService
{
    /**
     * The AgencyXmlRpcService constructor calls the base service constructor to
     * initialise the service
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The addAgency method adds details for a new agency to the agency
     * object and returns either the agency ID or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function addAgency(&$oParams)
    {
        $sessionId          = null;
        $oAgencyInfo        = new OA_Dll_AgencyInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oAgencyInfo, $oParams, 1,
                array('agencyName', 'contactName', 'emailAddress', 'username',
                'password', 'userEmail', 'language'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oAgencyServiceImp->addAgency($sessionId, $oAgencyInfo)) {
            return XmlRpcUtils::integerTypeResponse($oAgencyInfo->agencyId);
        } else {
            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The modifyAgency method either changes the details for an existing agency
     * or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function modifyAgency(&$oParams)
    {
        $sessionId          = null;
        $oAgencyInfo        = new OA_Dll_AgencyInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oAgencyInfo, $oParams, 1,
                 array('agencyId', 'agencyName', 'contactName', 'emailAddress',
                     'username', 'password'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oAgencyServiceImp->modifyAgency($sessionId, $oAgencyInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The deleteAgency method either deletes an existing agency from the
     * agency object or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function deleteAgency(&$oParams)
    {
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$agencyId),
            array(true, true), $oParams, $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oAgencyServiceImp->deleteAgency($sessionId, $agencyId)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The agencyDailyStatistics method returns either the daily statistics for an agency
     * for a specified period or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function agencyDailyStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aData = null;
        if ($this->_oAgencyServiceImp->getAgencyDailyStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $localTZ, $aData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('day' => 'date',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $aData);

        } else {

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The agencyAdvertiserStatistics method returns either the advertiser statistics for
     * an agency for a specified period or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function agencyAdvertiserStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyAdvertiserStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The agencyCampaignStatistics method returns either the campaign statistics for
     * an agency for a specified period or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function agencyCampaignStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyCampaignStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

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

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The agencyBannerStatistics method returns banner statistics for
     * an agency for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function agencyBannerStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyBannerStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

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

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The agencyPublisherStatistics method returns either the publisher statistics for
     * an agency for a specified period or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function agencyPublisherStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyPublisherStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('publisherId' => 'integer',
                                                                'publisherName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

        } else {

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The agencyZoneStatistics method returns either the zone statistics for
     * an agency for a specified period or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function agencyZoneStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate, &$localTZ),
                array(true, true, false, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyZoneStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $localTZ, $rsStatisticsData)) {

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

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The getAgency method returns either information about an agency or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getAgency(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $oAgency = null;
        if ($this->_oAgencyServiceImp->getAgency($sessionId,
                $agencyId, $oAgency)) {

            return XmlRpcUtils::getEntityResponse($oAgency);
        } else {

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }

    /**
     * The getAgencyList method returns either a list of agencies
     * or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getAgencyList(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId),
                array(true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aAgencyList = null;
        if ($this->_oAgencyServiceImp->getAgencyList($sessionId, $aAgencyList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aAgencyList);
        } else {

            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
        }
    }


}

?>
