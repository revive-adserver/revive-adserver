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
require_once MAX_PATH . '/www/api/v1/common/BaseZoneService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The addZone method adds details for a new zone to the zone
     * object and returns either the zone ID or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function addZone($oParams)
    {
        $sessionId = null;
        $oZoneInfo = new OA_Dll_ZoneInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue(
            $sessionId,
            $oParams,
            0,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getStructureScalarFields(
                $oZoneInfo,
                $oParams,
                1,
                ['publisherId', 'zoneName', 'type', 'width', 'height', 'comments',
                    'capping', 'sessionCapping', 'block'],
                $oResponseWithError
            )) {
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function modifyZone($oParams)
    {
        $sessionId = null;
        $oZoneInfo = new OA_Dll_ZoneInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue(
            $sessionId,
            $oParams,
            0,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getStructureScalarFields(
                $oZoneInfo,
                $oParams,
                1,
                ['zoneId', 'publisherId', 'zoneName', 'type', 'width',
                  'height', 'comments', 'capping', 'sessionCapping', 'block'],
                $oResponseWithError
            )) {
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function deleteZone($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function zoneDailyStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oZoneServiceImp->getZoneDailyStatistics(
            $sessionId,
            $zoneId,
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
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The zoneAdvertiserStatistics method returns advertiser statistics for a zone
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function zoneAdvertiserStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oZoneServiceImp->getZoneAdvertiserStatistics(
            $sessionId,
            $zoneId,
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
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The zoneCampaignStatistics method returns campaign statistics for a zone
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function zoneCampaignStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oZoneServiceImp->getZoneCampaignStatistics(
            $sessionId,
            $zoneId,
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
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    /**
     * The zoneBannerStatistics method returns banner statistics for a zone
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function zoneBannerStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oZoneServiceImp->getZoneBannerStatistics(
            $sessionId,
            $zoneId,
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
    public function getZone($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $oZone = null;
        if ($this->_oZoneServiceImp->getZone(
            $sessionId,
            $zoneId,
            $oZone
        )) {
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function getZoneListByPublisherId($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$publisherId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $aZoneList = null;
        if ($this->_oZoneServiceImp->getZoneListByPublisherId(
            $sessionId,
            $publisherId,
            $aZoneList
        )) {
            return XmlRpcUtils::getArrayOfEntityResponse($aZoneList);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    public function linkBanner($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$bannerId],
            [true, true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->linkBanner($sessionId, $zoneId, $bannerId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    public function linkCampaign($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$campaignId],
            [true, true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->linkCampaign($sessionId, $zoneId, $campaignId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    public function unlinkBanner($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$bannerId],
            [true, true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->unlinkBanner($sessionId, $zoneId, $bannerId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    public function unlinkCampaign($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$campaignId],
            [true, true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->unlinkCampaign($sessionId, $zoneId, $campaignId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }

    public function generateTags($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$zoneId, &$codeType, &$aParams],
            [true, true, true, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->_oZoneServiceImp->generateTags($sessionId, $zoneId, $codeType, $aParams, $generatedTag)) {
            return XmlRpcUtils::stringTypeResponse($generatedTag);
        } else {
            return XmlRpcUtils::generateError($this->_oZoneServiceImp->getLastError());
        }
    }
}

/**
 * Initialise the XML-RPC server including the available methods and their signatures.
 *
**/
$oZoneXmlRpcService = new ZoneXmlRpcService();

$server = new XML_RPC_Server(
    [
        'addZone' => [
            'function' => [$oZoneXmlRpcService, 'addZone'],
            'signature' => [
                ['int', 'string', 'struct']
            ],
            'docstring' => 'Add zone'
        ],

        'modifyZone' => [
            'function' => [$oZoneXmlRpcService, 'modifyZone'],
            'signature' => [
                ['int', 'string', 'struct']
            ],
            'docstring' => 'Modify zone information'
        ],

        'deleteZone' => [
            'function' => [$oZoneXmlRpcService, 'deleteZone'],
            'signature' => [
                ['int', 'string', 'int']
            ],
            'docstring' => 'Delete zone'
        ],

        'zoneDailyStatistics' => [
            'function' => [$oZoneXmlRpcService, 'zoneDailyStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Zone Daily Statistics'
        ],

        'zoneAdvertiserStatistics' => [
            'function' => [$oZoneXmlRpcService, 'zoneAdvertiserStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Zone Advertiser Statistics'
        ],

        'zoneCampaignStatistics' => [
            'function' => [$oZoneXmlRpcService, 'zoneCampaignStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Zone Campaign Statistics'
        ],

        'zoneBannerStatistics' => [
            'function' => [$oZoneXmlRpcService, 'zoneBannerStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Zone Banner Statistics'
        ],

        'getZone' => [
            'function' => [$oZoneXmlRpcService, 'getZone'],
            'signature' => [
                ['struct', 'string', 'int']
            ],
            'docstring' => 'Get Zone Information'
        ],

        'getZoneListByPublisherId' => [
            'function' => [$oZoneXmlRpcService, 'getZoneListByPublisherId'],
            'signature' => [
                ['array', 'string', 'int']
            ],
            'docstring' => 'Get Zone List By Publisher Id'
        ],

        'linkBanner' => [
            'function' => [$oZoneXmlRpcService, 'linkBanner'],
            'signature' => [
                ['int', 'string', 'int', 'int']
            ],
            'docstring' => 'Link a banner to a zone'
        ],

        'linkCampaign' => [
            'function' => [$oZoneXmlRpcService, 'linkCampaign'],
            'signature' => [
                ['int', 'string', 'int', 'int']
            ],
            'docstring' => 'Link a campaign to a zone'
        ],

        'unlinkBanner' => [
            'function' => [$oZoneXmlRpcService, 'unlinkBanner'],
            'signature' => [
                ['int', 'string', 'int', 'int']
            ],
            'docstring' => 'Unlink a banner to from zone'
        ],

        'unlinkCampaign' => [
            'function' => [$oZoneXmlRpcService, 'unlinkCampaign'],
            'signature' => [
                ['int', 'string', 'int', 'int']
            ],
            'docstring' => 'Unlink a campaign from a zone'
        ],

        'generateTags' => [
            'function' => [$oZoneXmlRpcService, 'generateTags'],
            'signature' => [
                ['string', 'string', 'int', 'string', 'struct'],
                ['string', 'string', 'int', 'string', 'array']
            ],
            'docstring' => 'Unlink a campaign from a zone'
        ],

    ],
    1  // serviceNow
);
