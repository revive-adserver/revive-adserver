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
 * The banner XML-RPC service enables XML-RPC communication with the banner object.
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes on the server.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the BaseBannerService class.
require_once MAX_PATH . '/www/api/v1/common/BaseBannerService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

// Require the BannerInfo class.
require_once MAX_PATH . '/lib/OA/Dll/Banner.php';

/**
 * The BannerXmlRpcService class extends the BaseBannerService class.
 *
 */
class BannerXmlRpcService extends BaseBannerService
{
    /**
     * The BannerXmlRpcService constructor calls the base service constructor to
     * initialise the service
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The addBanner method adds details for a new banner to the banner
     * object and returns either the banner ID or an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function addBanner($oParams)
    {
        $sessionId = null;
        $oBannerInfo = new OA_Dll_BannerInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue(
            $sessionId,
            $oParams,
            0,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getStructureScalarAndNotScalarFields(
                $oBannerInfo,
                $oParams,
                1,
                ['campaignId', 'bannerName', 'storageType', 'fileName',
                        'imageURL', 'htmlTemplate', 'width', 'height', 'weight',
                        'target', 'url', 'bannerText', 'status', 'adserver', 'transparent',
                        'capping', 'sessionCapping', 'block', 'comments'],
                ['aImage', 'aBackupImage'],
                $oResponseWithError
            )) {
            return $oResponseWithError;
        }

        if ($this->_oBannerServiceImp->addBanner($sessionId, $oBannerInfo)) {
            return XmlRpcUtils::integerTypeResponse($oBannerInfo->bannerId);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * The modifyBanner method changes the details for an existing banner
     * in the banner object or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function modifyBanner($oParams)
    {
        $sessionId = null;
        $oBannerInfo = new OA_Dll_BannerInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue(
            $sessionId,
            $oParams,
            0,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getStructureScalarAndNotScalarFields(
                $oBannerInfo,
                $oParams,
                1,
                ['bannerId', 'campaignId', 'bannerName', 'storageType', 'fileName',
                        'imageURL', 'htmlTemplate', 'width', 'height', 'weight',
                        'target', 'url', 'bannerText', 'status', 'adserver', 'transparent',
                        'capping', 'sessionCapping', 'block', 'comments'],
                ['aImage', 'aBackupImage'],
                $oResponseWithError
            )) {
            return $oResponseWithError;
        }

        if ($this->_oBannerServiceImp->modifyBanner($sessionId, $oBannerInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * The deleteBanner method either deletes an existing banner or
     * returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function deleteBanner($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$bannerId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->_oBannerServiceImp->deleteBanner($sessionId, $bannerId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * This method return targeting limitations for banner.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return generated result (array or error)
     */
    public function getBannerTargeting($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$bannerId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $aTargeting = null;
        if ($this->_oBannerServiceImp->getBannerTargeting(
            $sessionId,
            $bannerId,
            $aTargeting
        )) {
            return XmlRpcUtils::getArrayOfEntityResponse($aTargeting);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * This method sets targeting limitations for banner.
     * It overrides existing limitations.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return generated result (boolean or error)
     */
    public function setBannerTargeting($oParams)
    {
        $oResponseWithError = null;
        $aTargeting = [];
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$bannerId],
            [true, true],
            $oParams,
            $oResponseWithError
        ) ||
            !XmlRpcUtils::getArrayOfStructuresScalarFields(
                $aTargeting,
                'OA_Dll_TargetingInfo',
                $oParams,
                2,
                ['logical', 'type',
                    'comparison', 'data'],
                $oResponseWithError
            )) {
            return $oResponseWithError;
        }

        if ($this->_oBannerServiceImp->setBannerTargeting(
            $sessionId,
            $bannerId,
            $aTargeting
        )) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * The bannerDailyStatistics method returns daily statistics for a banner
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function bannerDailyStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$bannerId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oBannerServiceImp->getBannerDailyStatistics(
            $sessionId,
            $bannerId,
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
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }


    /**
     * The bannerPublisherStatistics method returns publisher statistics for a banner
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function bannerPublisherStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$bannerId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oBannerServiceImp->getBannerPublisherStatistics(
            $sessionId,
            $bannerId,
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
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * The bannerZoneStatistics method returns zone statistics for a banner
     * for a specified period, or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function bannerZoneStatistics($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$bannerId, &$oStartDate, &$oEndDate],
            [true, true, false, false],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oBannerServiceImp->getBannerZoneStatistics(
            $sessionId,
            $bannerId,
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
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * The getBanner method returns either information about a banner or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function getBanner($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$bannerId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $oBanner = null;
        if ($this->_oBannerServiceImp->getBanner(
            $sessionId,
            $bannerId,
            $oBanner
        )) {
            return XmlRpcUtils::getEntityResponse($oBanner);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * The getBannerListByCampaignId method returns a list of banners
     * for a campaign, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    public function getBannerListByCampaignId($oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
            [&$sessionId, &$campaignId],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        $aBannerList = null;
        if ($this->_oBannerServiceImp->getBannerListByCampaignId(
            $sessionId,
            $campaignId,
            $aBannerList
        )) {
            return XmlRpcUtils::getArrayOfEntityResponse($aBannerList);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }
}

/**
 * Initialise the XML-RPC server including the available methods and their signatures.
 *
**/
$oBannerInfoXmlRpcService = new BannerXmlRpcService();

$server = new XML_RPC_Server(
    [
        'addBanner' => [
            'function' => [$oBannerInfoXmlRpcService, 'addBanner'],
            'signature' => [
                ['int', 'string', 'struct']
            ],
            'docstring' => 'Add banner'
        ],

        'modifyBanner' => [
            'function' => [$oBannerInfoXmlRpcService, 'modifyBanner'],
            'signature' => [
                ['int', 'string', 'struct']
            ],
            'docstring' => 'Modify banner information'
        ],

        'deleteBanner' => [
            'function' => [$oBannerInfoXmlRpcService, 'deleteBanner'],
            'signature' => [
                ['int', 'string', 'int']
            ],
            'docstring' => 'Delete banner'
        ],

        'getBannerTargeting' => [
            'function' => [$oBannerInfoXmlRpcService, 'getBannerTargeting'],
            'signature' => [
                ['array', 'string', 'int']
            ],
            'docstring' => 'Get banner targeting limitations array'
        ],

        'setBannerTargeting' => [
            'function' => [$oBannerInfoXmlRpcService, 'setBannerTargeting'],
            'signature' => [
                ['boolean', 'string', 'int', 'array']
            ],
            'docstring' => 'Set banner targeting limitations array'
        ],

        'bannerDailyStatistics' => [
            'function' => [$oBannerInfoXmlRpcService, 'bannerDailyStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Banner Daily Statistics'
        ],

        'bannerPublisherStatistics' => [
            'function' => [$oBannerInfoXmlRpcService, 'bannerPublisherStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Banner Publisher Statistics'
        ],

        'bannerZoneStatistics' => [
            'function' => [$oBannerInfoXmlRpcService, 'bannerZoneStatistics'],
            'signature' => [
                ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
                ['array', 'string', 'int', 'dateTime.iso8601'],
                ['array', 'string', 'int']
            ],
            'docstring' => 'Generate Banner Zone Statistics'
        ],


        'getBanner' => [
            'function' => [$oBannerInfoXmlRpcService, 'getBanner'],
            'signature' => [
                ['struct', 'string', 'int']
            ],
            'docstring' => 'Get Banner Information'
        ],

        'getBannerListByCampaignId' => [
            'function' => [$oBannerInfoXmlRpcService, 'getBannerListByCampaignId'],
            'signature' => [
                ['array', 'string', 'int']
            ],
            'docstring' => 'Get Banner List By Campaign Id'
        ],

    ],
    1  // serviceNow
);
