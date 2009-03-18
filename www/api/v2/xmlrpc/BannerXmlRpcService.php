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

/**
 * @package    OpenX
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 * The banner XML-RPC service enables XML-RPC communication with the banner object.
 *
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes on the server.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the BaseBannerService class.
require_once MAX_PATH . '/www/api/v2/common/BaseBannerService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

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
    function BannerXmlRpcService()
    {
        $this->BaseBannerService();
    }

    /**
     * The addBanner method adds details for a new banner to the banner
     * object and returns either the banner ID or an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function addBanner(&$oParams)
    {
        $sessionId          = null;
        $oBannerInfo        = new OA_Dll_BannerInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarAndNotScalarFields($oBannerInfo, $oParams,
                1, array('campaignId', 'bannerName', 'storageType', 'fileName',
                        'imageURL', 'htmlTemplate', 'width', 'height', 'weight',
                        'target', 'url', 'bannerText', 'status', 'adserver', 'transparent',
                        'capping', 'sessionCapping', 'block', 'comments'),
                   array('aImage', 'aBackupImage'), $oResponseWithError)) {

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
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function modifyBanner(&$oParams)
    {
        $sessionId          = null;
        $oBannerInfo        = new OA_Dll_BannerInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarAndNotScalarFields($oBannerInfo, $oParams,
                1, array('bannerId', 'campaignId', 'bannerName', 'storageType', 'fileName',
                        'imageURL', 'htmlTemplate', 'width', 'height', 'weight',
                        'target', 'url', 'bannerText', 'status', 'adserver', 'transparent',
                        'capping', 'sessionCapping', 'block', 'comments'),
                   array('aImage', 'aBackupImage'), $oResponseWithError)) {

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
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function deleteBanner(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$bannerId),
            array(true, true), $oParams, $oResponseWithError )) {

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
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (array or error)
     */
    function getBannerTargeting(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$bannerId),
            array(true, true), $oParams, $oResponseWithError)) {

            return $oResponseWithError;
        }

        $aTargeting = null;
        if ($this->_oBannerServiceImp->getBannerTargeting($sessionId, 
            $bannerId, $aTargeting)) {

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
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (boolean or error)
     */
    function setBannerTargeting(&$oParams)
    {
        $oResponseWithError = null;
        $aTargeting = array();
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$bannerId),
            array(true, true), $oParams, $oResponseWithError) || 
            !XmlRpcUtils::getArrayOfStructuresScalarFields($aTargeting, 
                'OA_Dll_TargetingInfo', $oParams, 2, array('logical', 'type', 
                    'comparison', 'data'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oBannerServiceImp->setBannerTargeting($sessionId, 
            $bannerId, $aTargeting)) {

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
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function bannerDailyStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$bannerId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oBannerServiceImp->getBannerDailyStatistics($sessionId,
                $bannerId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('day' => 'date',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

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
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function bannerPublisherStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$bannerId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oBannerServiceImp->getBannerPublisherStatistics($sessionId,
                $bannerId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('publisherId' => 'integer',
                                                                'publisherName' => 'string',
                                                                'requests' => 'integer',
                                                                'impressions' => 'integer',
                                                                'clicks' => 'integer',
                                                                'revenue' => 'float',
                                                                ), $rsStatisticsData);

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
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function bannerZoneStatistics(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$bannerId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oBannerServiceImp->getBannerZoneStatistics($sessionId,
                $bannerId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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

            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * The getBanner method returns either information about a banner or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getBanner(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$bannerId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $oBanner = null;
        if ($this->_oBannerServiceImp->getBanner($sessionId,
                $bannerId, $oBanner)) {

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
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getBannerListByCampaignId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$campaignId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aBannerList = null;
        if ($this->_oBannerServiceImp->getBannerListByCampaignId($sessionId,
                                            $campaignId, $aBannerList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aBannerList);
        } else {

            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

}

?>
