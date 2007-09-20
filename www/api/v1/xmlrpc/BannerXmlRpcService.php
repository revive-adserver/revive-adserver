<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id:$
*/

/**
 * @package    Openads
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 * Banner XMLRPC Service.
 *
 */

// Require the initialisation file
require_once '../../../../init.php';

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Base class BaseBannerService
require_once MAX_PATH . '/www/api/v1/common/BaseBannerService.php';

// XmlRpc utils
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

// Require BannerInfo class
require_once MAX_PATH . '/lib/OA/Dll/Banner.php';

class BannerXmlRpcService extends BaseBannerService
{
    function BannerXmlRpcService()
    {
        $this->BaseBannerService();
    }

    /**
     *  Add new banner.
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
            !XmlRpcUtils::getStructureScalarFields($oBannerInfo, $oParams, 
                1, array('campaignId', 'bannerName', 'storageType', 'fileName', 
                        'imageURL', 'htmlTemplate', 'width', 'height', 'weight', 
                        'url'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oBannerServiceImp->addBanner($sessionId, $oBannerInfo)) {
            return XmlRpcUtils::integerTypeResponse($oBannerInfo->bannerId);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * Modifies an existing.
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
            !XmlRpcUtils::getStructureScalarFields($oBannerInfo, $oParams, 
                1, array('bannerId', 'campaignId', 'bannerName', 'storageType', 
                        'fileName', 'imageURL', 'htmlTemplate', 'width', 'height', 
                        'weight', 'url'), $oResponseWithError)) {

            return $oResponseWithError;
        }
        
        if ($this->_oBannerServiceImp->modifyBanner($sessionId, $oBannerInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oBannerServiceImp->getLastError());
        }
    }

    /**
     * Delete existing Banner.
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
     * Statistics broken down by day.
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
     * Statistics broken down by Publisher.
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
     * Statistics broken down by Zone.
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
}

$oBannerInfoXmlRpcService = new BannerXmlRpcService();

$server = new XML_RPC_Server(
    array(
        'addBanner' => array(
            'function'  => array($oBannerInfoXmlRpcService, 'addBanner'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Add banner'
        ),

        'modifyBanner' => array(
            'function'  => array($oBannerInfoXmlRpcService, 'modifyBanner'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Modify banner information'
        ),

        'deleteBanner' => array(
            'function'  => array($oBannerInfoXmlRpcService, 'deleteBanner'),
            'signature' => array(
                array('int', 'string', 'int')
            ),
            'docstring' => 'Delete banner'
        ),

        'bannerDailyStatistics' => array(
            'function'  => array($oBannerInfoXmlRpcService, 'bannerDailyStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Banner Daily Statistics'
        ),

        'bannerPublisherStatistics' => array(
            'function'  => array($oBannerInfoXmlRpcService, 'bannerPublisherStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Banner Publisher Statistics'
        ),

        'bannerZoneStatistics' => array(
            'function'  => array($oBannerInfoXmlRpcService, 'bannerZoneStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Banner Zone Statistics'
        ),

    ),
    1  // serviceNow
);


?>
