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
 * Advertiser XMLRPC Service.
 *
 */

// Require the initialisation file
require_once '../../../../init.php';

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Base class BaseAdvertiserService
require_once MAX_PATH . '/www/api/v1/common/BaseAdvertiserService.php';

// XmlRpc utils
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

// Require AdvertiserInfo class
require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';

class AdvertiserXmlRpcService extends BaseAdvertiserService
{
    function AdvertiserXmlRpcService()
    {
        $this->BaseAdvertiserService();
    }

    /**
     *  Add new advertiser.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function addAdvertiser(&$oParams)
    {
        $sessionId          = null;
        $oAdvertiserInfo    = new OA_Dll_AdvertiserInfo();
        $oResponseWithError = null;
        
        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0, 
                $oResponseWithError) || 
            !XmlRpcUtils::getStructureScalarFields($oAdvertiserInfo, $oParams, 
                1, array('agencyId', 'advertiserName', 'contactName', 
                    'emailAddress', 'username', 'password'), $oResponseWithError)) {

            return $oResponseWithError;
        }
        
        if ($this->_oAdvertiserServiceImp->addAdvertiser($sessionId, $oAdvertiserInfo)) {
            return XmlRpcUtils::integerTypeResponse($oAdvertiserInfo->advertiserId);
        } else {
            return XmlRpcUtils::generateError($this->_oAdvertiserServiceImp->getLastError());
        }
    }

    /**
     * Modifies an existing.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function modifyAdvertiser(&$oParams)
    {
        
        $sessionId          = null;
        $oAdvertiserInfo    = new OA_Dll_AdvertiserInfo();
        $oResponseWithError = null;
        
        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0, 
                $oResponseWithError) || 
            !XmlRpcUtils::getStructureScalarFields($oAdvertiserInfo, $oParams, 
                1, array('advertiserId', 'agencyId', 'advertiserName', 
                    'contactName', 'emailAddress', 'username', 'password'), 
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
     * Delete existing Advertiser.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function deleteAdvertiser(&$oParams)
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
     * Statistics broken down by day.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserDailyStatistics(&$oParams)
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
     * Statistics broken down by Campaign.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserCampaignStatistics(&$oParams)
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
     * Statistics broken down by Banner.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserBannerStatistics(&$oParams)
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
     * Statistics broken down by Publisher.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserPublisherStatistics(&$oParams)
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
     * Statistics broken down by Zone.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function advertiserZoneStatistics(&$oParams)
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
}

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

    ),
    1  // serviceNow
);


?>
