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
 * Agency XMLRPC Service.
 *
 */

// Require the initialisation file
require_once '../../../../init.php';

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Base class BaseAgencyService
require_once MAX_PATH . '/www/api/v1/common/BaseAgencyService.php';

// XmlRpc utils
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

// Require AgencyInfo class
require_once MAX_PATH . '/lib/OA/Dll/Agency.php';

class AgencyXmlRpcService extends BaseAgencyService
{
    function AgencyXmlRpcService()
    {
        $this->BaseAgencyService();
    }

    /**
     *  Add new agency.
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
                'password'), $oResponseWithError)) {
            
            return $oResponseWithError;
        }

        if ($this->_oAgencyServiceImp->addAgency($sessionId, $oAgencyInfo)) {
            return XmlRpcUtils::integerTypeResponse($oAgencyInfo->agencyId);
        } else {
            return XmlRpcUtils::generateError($this->_oAgencyServiceImp->getLastError());
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
     * Delete existing Agency.
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
     * Statistics broken down by day.
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
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }
        
        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyDailyStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $rsStatisticsData)) {

            return XmlRpcUtils::arrayOfStructuresResponse(array('day' => 'date',
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
     * Statistics broken down by Advetiser.
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
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }
        
        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyAdvertiserStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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
     * Statistics broken down by Campaign.
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
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }
        
        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyCampaignStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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
     * Statistics broken down by Banner.
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
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }
        
        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyBannerStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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
     * Statistics broken down by Publisher.
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
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }
        
        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyPublisherStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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
     * Statistics broken down by Zone.
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
                array(&$sessionId, &$agencyId, &$oStartDate, &$oEndDate),
                array(true, true, false, false), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }
        
        $rsStatisticsData = null;
        if ($this->_oAgencyServiceImp->getAgencyZoneStatistics($sessionId,
                $agencyId, $oStartDate, $oEndDate, $rsStatisticsData)) {

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
}


$oAgencyXmlRpcService = new AgencyXmlRpcService();

$server = new XML_RPC_Server(
    array(
        'addAgency' => array(
            'function'  => array($oAgencyXmlRpcService, 'addAgency'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Add agency'
        ),

        'modifyAgency' => array(
            'function'  => array($oAgencyXmlRpcService, 'modifyAgency'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Modify agency information'
        ),

        'deleteAgency' => array(
            'function'  => array($oAgencyXmlRpcService, 'deleteAgency'),
            'signature' => array(
                array('int', 'string', 'int')
            ),
            'docstring' => 'Delete agency'
        ),

        'agencyDailyStatistics' => array(
            'function'  => array($oAgencyXmlRpcService, 'agencyDailyStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Agency Daily Statistics'
        ),

        'agencyAdvertiserStatistics' => array(
            'function'  => array($oAgencyXmlRpcService, 'agencyAdvertiserStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Agency Advertiser Statistics'
        ),

        'agencyCampaignStatistics' => array(
            'function'  => array($oAgencyXmlRpcService, 'agencyCampaignStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Agency Campaign Statistics'
        ),

        'agencyBannerStatistics' => array(
            'function'  => array($oAgencyXmlRpcService, 'agencyBannerStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Agency Banner Statistics'
        ),

        'agencyPublisherStatistics' => array(
            'function'  => array($oAgencyXmlRpcService, 'agencyPublisherStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Agency Publisher Statistics'
        ),

        'agencyZoneStatistics' => array(
            'function'  => array($oAgencyXmlRpcService, 'agencyZoneStatistics'),
            'signature' => array(
                array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
                array('array', 'string', 'int', 'dateTime.iso8601'),
                array('array', 'string', 'int')
            ),
            'docstring' => 'Generate Agency Zone Statistics'
        ),

    ),
    1  // serviceNow
);

?>
