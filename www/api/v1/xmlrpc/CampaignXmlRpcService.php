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
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * Campaign XMLRPC Service.
 *
 */

// Require the initialisation file
require_once '../../../../init.php';

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Base class BaseCampaignService
require_once MAX_PATH . '/www/api/v1/common/BaseCampaignService.php';

// XmlRpc utils
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

// Require CampaignInfo class
require_once MAX_PATH . '/lib/OA/Dll/Campaign.php';


class CampaignXmlRpcService extends BaseCampaignService
{
    function CampaignXmlRpcService()
    {
        $this->BaseCampaignService();
    }

    /**
     *  Add new Campaign.
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
                       'impressions', 'clicks', 'priority', 'weight'), 
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
     * Modifies an existing.
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
                        'priority', 'weight'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oCampaignServiceImp->modifyCampaign($sessionId, $oCampaignInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }

    /**
     * Delete existing Campaign.
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
     * Statistics broken down by day.
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
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oCampaignServiceImp->getCampaignDailyStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('day' => 'date',
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
     * Statistics broken down by Banner.
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
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oCampaignServiceImp->getCampaignBannerStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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
     * Statistics broken down by Publisher.
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
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oCampaignServiceImp->getCampaignPublisherStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('publisherId' => 'integer',
                                                        'publisherName' => 'string',
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
     * Statistics broken down by Zone.
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
                array(&$sessionId, &$campaignId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $rsStatisticsData = null;
        if ($this->_oCampaignServiceImp->getCampaignZoneStatistics($sessionId,
                $campaignId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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

            return XmlRpcUtils::generateError($this->_oCampaignServiceImp->getLastError());
        }
    }
}

$oCampaignXmlRpcService = new CampaignXmlRpcService();

$server = new XML_RPC_Server(
    array(
        'addCampaign' => array(
            'function'  => array($oCampaignXmlRpcService, 'addCampaign'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Add campaign'
        ),

        'modifyCampaign' => array(
            'function'  => array($oCampaignXmlRpcService, 'modifyCampaign'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Modify campaign information'
        ),

        'deleteCampaign' => array(
            'function'  => array($oCampaignXmlRpcService, 'deleteCampaign'),
            'signature' => array(
                array('int', 'string', 'int')
            ),
            'docstring' => 'Delete campaign'
        ),

        'campaignDailyStatistics' => array(
            'function'  => array($oCampaignXmlRpcService, 'campaignDailyStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate campaign Daily Statistics'
        ),

        'campaignBannerStatistics' => array(
            'function'  => array($oCampaignXmlRpcService, 'campaignBannerStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate campaign Banner Statistics'
        ),

        'campaignPublisherStatistics' => array(
            'function'  => array($oCampaignXmlRpcService, 'campaignPublisherStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate campaign Publisher Statistics'
        ),

        'campaignZoneStatistics' => array(
            'function'  => array($oCampaignXmlRpcService, 'campaignZoneStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate campaign Zone Statistics'
        ),

    ),
    1  // serviceNow
);


?>
