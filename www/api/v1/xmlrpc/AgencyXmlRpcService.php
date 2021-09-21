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
require_once MAX_PATH . '/www/api/v1/common/BaseAgencyService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The addAgency method adds details for a new agency to the agency
     * object and returns either the agency ID or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function addAgency($oParams)
    {
        $sessionId = null;
        $oAgencyInfo = new OA_Dll_AgencyInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue(
            $sessionId,
            $oParams,
            0,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getStructureScalarFields(
                $oAgencyInfo,
                $oParams,
                1,
                ['agencyName', 'contactName', 'emailAddress', 'username',
                'password', 'userEmail', 'language'],
                $oResponseWithError
            )) {
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function modifyAgency($oParams)
    {
        $sessionId = null;
        $oAgencyInfo = new OA_Dll_AgencyInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue(
            $sessionId,
            $oParams,
            0,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getStructureScalarFields(
                $oAgencyInfo,
                $oParams,
                1,
                ['agencyId', 'agencyName', 'contactName', 'emailAddress',
                     'username', 'password'],
                $oResponseWithError
            )) {
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function deleteAgency($oParams)
    {
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$agencyId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function agencyDailyStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$agencyId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyDailyStatistics(
            $sessionId,
            $agencyId,
            $oStartDate,
            $oEndDate,
            $rsStatisticsData
        )) {
            return XmlRpcUtils::arrayOfStructuresResponse(['day' => 'date',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ], $rsStatisticsData);
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function agencyAdvertiserStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$agencyId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyAdvertiserStatistics(
            $sessionId,
            $agencyId,
            $oStartDate,
            $oEndDate,
            $rsStatisticsData
        )) {
            return XmlRpcUtils::arrayOfStructuresResponse(['advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ], $rsStatisticsData);
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function agencyCampaignStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$agencyId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyCampaignStatistics(
            $sessionId,
            $agencyId,
            $oStartDate,
            $oEndDate,
            $rsStatisticsData
        )) {
            return XmlRpcUtils::arrayOfStructuresResponse(['advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'campaignId' => 'integer',
                                                                'campaignName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ], $rsStatisticsData);
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function agencyBannerStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$agencyId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyBannerStatistics(
            $sessionId,
            $agencyId,
            $oStartDate,
            $oEndDate,
            $rsStatisticsData
        )) {
            return XmlRpcUtils::arrayOfStructuresResponse(['advertiserId' => 'integer',
                                                                'advertiserName' => 'string',
                                                                'campaignId' => 'integer',
                                                                'campaignName' => 'string',
                                                                'bannerId' => 'integer',
                                                                'bannerName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ], $rsStatisticsData);
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function agencyPublisherStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$agencyId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyPublisherStatistics(
            $sessionId,
            $agencyId,
            $oStartDate,
            $oEndDate,
            $rsStatisticsData
        )) {
            return XmlRpcUtils::arrayOfStructuresResponse(['publisherId' => 'integer',
                                                                'publisherName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ], $rsStatisticsData);
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function agencyZoneStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$agencyId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyZoneStatistics(
            $sessionId,
            $agencyId,
            $oStartDate,
            $oEndDate,
            $rsStatisticsData
        )) {
            return XmlRpcUtils::arrayOfStructuresResponse(['publisherId' => 'integer',
                                                                'publisherName' => 'string',
                                                                'zoneId' => 'integer',
                                                                'zoneName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ], $rsStatisticsData);
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function getAgency($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$agencyId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $oAgency = null;
        if ($this->_oAgencyServiceImp->getAgency(
            $sessionId,
            $agencyId,
            $oAgency
        )) {
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function getAgencyList($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId],
            [true],
            $oParams,
            $oResponseWithError
        )) {
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

/**
 * Initialise the XML-RPC server including the available methods and their signatures.
 *
**/
$oAgencyXmlRpcService = new AgencyXmlRpcService();

$server = new XML_RPC_Server(
    [
        'addAgency' => [
            'function' => [$oAgencyXmlRpcService, 'addAgency'],
            'signature' => [
                ['int', 'string', 'struct']
            ],
            'docstring' => 'Add agency'
        ],

        'modifyAgency' => [
            'function' => [$oAgencyXmlRpcService, 'modifyAgency'],
            'signature' => [
                ['int', 'string', 'struct']
            ],
            'docstring' => 'Modify agency information'
        ],

        'deleteAgency' => [
            'function' => [$oAgencyXmlRpcService, 'deleteAgency'],
            'signature' => [
                ['int', 'string', 'int']
            ],
            'docstring' => 'Delete agency'
        ],

        'agencyDailyStatistics' => [
            'function' => [$oAgencyXmlRpcService, 'agencyDailyStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Agency Daily Statistics'
        ],

        'agencyAdvertiserStatistics' => [
            'function' => [$oAgencyXmlRpcService, 'agencyAdvertiserStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Agency Advertiser Statistics'
        ],

        'agencyCampaignStatistics' => [
            'function' => [$oAgencyXmlRpcService, 'agencyCampaignStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Agency Campaign Statistics'
        ],

        'agencyBannerStatistics' => [
            'function' => [$oAgencyXmlRpcService, 'agencyBannerStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Agency Banner Statistics'
        ],

        'agencyPublisherStatistics' => [
            'function' => [$oAgencyXmlRpcService, 'agencyPublisherStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Agency Publisher Statistics'
        ],

        'agencyZoneStatistics' => [
            'function' => [$oAgencyXmlRpcService, 'agencyZoneStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Agency Zone Statistics'
        ],

        'getAgency' => [
            'function' => [$oAgencyXmlRpcService, 'getAgency'],
            'signature' => [
                ['struct', 'string', 'int']
            ],
            'docstring' => 'Get Agency Information'
        ],

        'getAgencyList' => [
            'function' => [$oAgencyXmlRpcService, 'getAgencyList'],
            'signature' => [
                ['array', 'string']
            ],
            'docstring' => 'Get Agency List'
        ],

    ],
    1  // serviceNow
);
