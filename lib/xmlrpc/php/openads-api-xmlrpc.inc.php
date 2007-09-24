<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id: openads-xmlrpc.inc.php 8911 2007-08-10 09:47:46Z andrew.hill@openads.org $
*/

if (!@include('XML/RPC.php')) {
    die('Error: cannot load the PEAR XML_RPC class');
}

require_once 'XmlRpcUtils.php';

/**
 * A library class to provide XML-RPC routines on the client-side - that is, on
 * a web server that needs to control Openads via the webservice API
 *
 * @package    Openads
 * @subpackage ExternalLibrary
 * @author     Chris Nutting <Chris.Nutting@openads.org>
 */

class OA_Api_Xmlrpc
{
    var $host;
    var $basepath;
    var $port;
    var $ssl;
    var $timeout;
    var $username;
    var $password;
    /**
     * The sessionId is set by the logon() method called during the constructor
     *
     * @var string The remote session ID to be used in all subsequent transactions
     */
    var $sessionId;
    /**
     * Purely for my own use, this parameter lets me pass debug querystring paramters into
     * the remote call to trigger my Zend debugger on the server-side
     *
     * This will be removed before release
     *
     * @var string The querystring parameters required to trigger my remote debugger
     *             or empty for no remote debugging
     */
    var $debug = '';

    /**
     * PHP5 style constructor
     *
     * @param string $host      The hostname to connect to
     * @param string $basepath  The base path to the XML-RPC services
     * @param string $username  The username to authenticate to the Webservice API
     * @param string $password  The password for the above user
     * @param int    $port      The port number, 0 to use standard ports
     * @param bool   $ssl       True to connect using an SSL connection
     * @param int    $timeout   The timeout to wait for the response
     */
    function __construct($host, $basepath, $username, $password, $port = 0, $ssl = false, $timeout = 15)
    {
        $this->host = $host;
        $this->basepath = $basepath;
        $this->port = $port;
        $this->ssl  = $ssl;
        $this->timeout = $timeout;
        $this->username = $username;
        $this->password = $password;
        $this->_logon();
    }

    /**
     * PHP4 style constructor
     *
     * @see OA_API_XmlRpc::__construct
     */
    function OA_Api_Xmlrpc($host, $basepath, $username, $password, $port = 0, $ssl = false, $timeout = 15)
    {
        $this->__construct($host, $basepath, $username, $password, $port, $ssl, $timeout);
    }

    /**
     * A private function to call private method send add add to parameter
     * data sessionId
     *
     * @param string $service The name of the remote service file
     * @param string $method  The name of the remote method to be called
     * @param mixed  $data    The data to be sent to the WebService
     * @return mixed Response from server or false on failure
     */
    function _sendWithSession($service, $method, $data = array())
    {
        return $this->_send($service, $method, array_merge(array($this->sessionId), $data));
    }

    /**
     * A private function to send a method call to a specified service
     *
     * @param string $service The name of the remote service file
     * @param string $method  The name of the remote method to be called
     * @param mixed  $data    The data to be sent to the WebService
     * @return mixed Response from server or false on failure
     */
    function _send($service, $method, $data)
    {
        $dataMessage = array();
        foreach ($data as $element) {
            if (is_object($element) && is_subclass_of($element, 'OA_Info')) {
                $dataMessage[] = XmlRpcUtils::getEntityWithNotNullFields($element);
            } else {
                $dataMessage[] = XML_RPC_encode($element);
            }
        }
        $message = new XML_RPC_Message($method, $dataMessage);

        $client = new XML_RPC_Client($this->basepath . '/' . $service . $this->debug, $this->host);

        // Send the XML-RPC message to the server
        $response = $client->send($message, $this->timeout, $this->ssl ? 'https' : 'http');

        // Check for error response
        if ($response && $response->faultCode() == 0) {
            $result = XML_RPC_decode($response->value());
        } else {
            die('XML-RPC error (' . $response->faultCode() . ') -> ' . $response->faultString() .
                '. In Method ' . $method . '().');
        }
        return $result;
    }

    /**
     * A private method to logon to the WebService
     *
     * @return boolean Was the remote logon() call successful?
     */
    function _logon()
    {
        $this->sessionId = $this->_send('LogonXmlRpcService.php', 'logon',
                                         array($this->username, $this->password));
        return true;
    }

    /**
     * A private method to logoff to the WebService
     *
     * @return boolean Was the remote logoff() call successful
     */
    function logoff()
    {
        return (bool) $this->_sendWithSession('LogonXmlRpcService.php', 'logoff');;
    }

    /**
     * Call Statistics Method for Entity.
     *
     * @param string $serviceFileName
     * @param string $methodName
     * @param int $entityId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function _callStatisticsMethod($serviceFileName, $methodName, $entityId, $oStartDate = null, $oEndDate = null)
    {
        $dataArray = array((int) $entityId);
        if (is_object($oStartDate)) {
            $dataArray[] = XML_RPC_iso8601_encode($oStartDate->getDate(DATE_FORMAT_UNIXTIME));

            if (is_object($oEndDate)) {
                $dataArray[] = XML_RPC_iso8601_encode($oEndDate->getDate(DATE_FORMAT_UNIXTIME));
            }
        }

        $statisticsData = $this->_sendWithSession($serviceFileName,
                                                  $methodName, $dataArray);

        return $statisticsData;
    }

    /**
     * Add Agency.
     *
     * @param OA_Dll_AgencyInfo $oAgencyInfo
     * @return  method result
     */
    function addAgency(&$oAgencyInfo)
    {
        return (int) $this->_sendWithSession('AgencyXmlRpcService.php',
                                             'addAgency', array(&$oAgencyInfo));
    }

    /**
     * Modify Agency.
     *
     * @param OA_Dll_AgencyInfo $oAgencyInfo
     * @return  method result
     */
    function modifyAgency(&$oAgencyInfo)
    {
        return (bool) $this->_sendWithSession('AgencyXmlRpcService.php', 'modifyAgency',
                                              array(&$oAgencyInfo));
    }

    /**
     * Get Agency by id.
     *
     * @param int $agencyId
     * @return OA_Dll_AgencyInfo
     */
    function getAgency($agencyId)
    {
        $dataAgency = $this->_sendWithSession('AgencyXmlRpcService.php',
                                              'getAgency', array((int) $agencyId));
        $oAgencyInfo = new OA_Dll_AgencyInfo();
        $oAgencyInfo->readDataFromArray($dataAgency);

        return $oAgencyInfo;
    }

    /**
     * Get Agency List.
     *
     * @param int $agencyId
     * @return array  array OA_Dll_AgencyInfo objects
     */
    function getAgencyList()
    {
        $dataAgencyList = $this->_sendWithSession('AgencyXmlRpcService.php',
                                                  'getAgencyList');
        $returnData = array();
        foreach ($dataAgencyList as $dataAgency) {
            $oAgencyInfo = new OA_Dll_AgencyInfo();
            $oAgencyInfo->readDataFromArray($dataAgency);
            $returnData[] = $oAgencyInfo;
        }

        return $returnData;
    }

    /**
     * Delete Agency.
     *
     * @param int $agencyId
     * @return  method result
     */
    function deleteAgency($agencyId)
    {
        return (bool) $this->_sendWithSession('AgencyXmlRpcService.php',
                                              'deleteAgency', array((int) $agencyId));
    }

    /**
     * Agency daily statistics.
     *
     * @param int $agencyId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function agencyDailyStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        $statisticsData = $this->_callStatisticsMethod('AgencyXmlRpcService.php',
                                                       'agencyDailyStatistics',
                                                       $agencyId, $oStartDate, $oEndDate);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = date('Y-m-d',XML_RPC_iso8601_decode(
                                            $data['day']));
        }

        return $statisticsData;
    }

    /**
     * Agency Advertiser statistics.
     *
     * @param int $agencyId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function agencyAdvertiserStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyAdvertiserStatistics',
                                            $agencyId, $oStartDate, $oEndDate);
    }

    /**
     * Agency Campaign statistics.
     *
     * @param int $agencyId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function agencyCampaignStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyCampaignStatistics',
                                            $agencyId, $oStartDate, $oEndDate);
    }

    /**
     * Agency Banner statistics.
     *
     * @param int $agencyId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function agencyBannerStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyBannerStatistics',
                                            $agencyId, $oStartDate, $oEndDate);
    }

    /**
     * Agency Publisher statistics.
     *
     * @param int $agencyId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function agencyPublisherStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyPublisherStatistics',
                                            $agencyId, $oStartDate, $oEndDate);
    }

    /**
     * Agency Zone statistics.
     *
     * @param int $agencyId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function agencyZoneStatistics($agencyId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AgencyXmlRpcService.php', 'agencyZoneStatistics',
                                            $agencyId, $oStartDate, $oEndDate);
    }

    /**
     * Add Advertiser.
     *
     * @param OA_Dll_AdvertiserInfo $oAdvertiserInfo
     *
     * @return  method result
     */
    function addAdvertiser(&$oAdvertiserInfo)
    {
        return (int) $this->_sendWithSession('AdvertiserXmlRpcService.php',
                                             'addAdvertiser', array(&$oAdvertiserInfo));
    }

    /**
     * Modify Advertiser.
     *
     * @param OA_Dll_AdvertiserInfo $oAdvertiserInfo
     *
     * @return  method result
     */
    function modifyAdvertiser(&$oAdvertiserInfo)
    {
        return (bool) $this->_sendWithSession('AdvertiserXmlRpcService.php',
                                              'modifyAdvertiser', array(&$oAdvertiserInfo));
    }

    /**
     * Get Advertiser by id.
     *
     * @param int $advertiserId
     *
     * @return OA_Dll_AdvertiserInfo
     */
    function getAdvertiser($advertiserId)
    {
        $dataAdvertiser = $this->_sendWithSession('AdvertiserXmlRpcService.php',
                                                  'getAdvertiser', array((int) $advertiserId));
        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->readDataFromArray($dataAdvertiser);

        return $oAdvertiserInfo;
    }

    /**
     * Get Advertiser List By Agency Id.
     *
     * @param int $agencyId
     *
     * @return array  array OA_Dll_AgencyInfo objects
     */
    function getAdvertiserListByAgencyId($agencyId)
    {
        $dataAdvertiserList = $this->_sendWithSession('AdvertiserXmlRpcService.php',
                                                      'getAdvertiserListByAgencyId', array((int) $agencyId));
        $returnData = array();
        foreach ($dataAdvertiserList as $dataAdvertiser) {
            $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
            $oAdvertiserInfo->readDataFromArray($dataAdvertiser);
            $returnData[] = $oAdvertiserInfo;
        }

        return $returnData;
    }

    /**
     * Delete Advertiser.
     *
     * @param int $advertiserId
     * @return  method result
     */
    function deleteAdvertiser($advertiserId)
    {
        return (bool) $this->_sendWithSession('AdvertiserXmlRpcService.php',
                                              'deleteAdvertiser', array((int) $advertiserId));
    }

    /**
     * Advertiser daily statistics.
     *
     * @param int $advertiserId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function advertiserDailyStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        $statisticsData = $this->_callStatisticsMethod('AdvertiserXmlRpcService.php',
                                                       'advertiserDailyStatistics',
                                                       $advertiserId, $oStartDate, $oEndDate);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = date('Y-m-d',XML_RPC_iso8601_decode(
                                            $data['day']));
        }

        return $statisticsData;
    }

    /**
     * Advertiser Campaign statistics.
     *
     * @param int $advertiserId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function advertiserCampaignStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AdvertiserXmlRpcService.php',
                                            'advertiserCampaignStatistics',
                                            $advertiserId, $oStartDate, $oEndDate);
    }

    /**
     * Advertiser Banner statistics.
     *
     * @param int $advertiserId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function advertiserBannerStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AdvertiserXmlRpcService.php',
                                            'advertiserBannerStatistics',
                                            $advertiserId, $oStartDate, $oEndDate);
    }

    /**
     * Advertiser Publisher statistics.
     *
     * @param int $advertiserId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function advertiserPublisherStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AdvertiserXmlRpcService.php',
                                            'advertiserPublisherStatistics',
                                            $advertiserId, $oStartDate, $oEndDate);
    }

    /**
     * Advertiser Zone statistics.
     *
     * @param int $advertiserId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function advertiserZoneStatistics($advertiserId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('AdvertiserXmlRpcService.php',
                                            'advertiserZoneStatistics',
                                            $advertiserId, $oStartDate, $oEndDate);
    }

    /**
     * Add Campaign.
     *
     * @param OA_Dll_CampaignInfo $oCampaignInfo
     *
     * @return  method result
     */
    function addCampaign(&$oCampaignInfo)
    {
        return (int) $this->_sendWithSession('CampaignXmlRpcService.php',
                                             'addCampaign', array(&$oCampaignInfo));
    }

    /**
     * Modify Campaign.
     *
     * @param OA_Dll_CampaignInfo $oCampaignInfo
     *
     * @return  method result
     */
    function modifyCampaign(&$oCampaignInfo)
    {
        return (bool) $this->_sendWithSession('CampaignXmlRpcService.php',
                                              'modifyCampaign', array(&$oCampaignInfo));
    }

    /**
     * Get Campaign by id.
     *
     * @param int $campaignId
     *
     * @return OA_Dll_CampaignInfo
     */
    function getCampaign($campaignId)
    {
        $dataCampaign = $this->_sendWithSession('CampaignXmlRpcService.php',
                                                'getCampaign', array((int) $campaignId));
        $oCampaignInfo = new OA_Dll_CampaignInfo();
        $oCampaignInfo->readDataFromArray($dataCampaign);

        return $oCampaignInfo;
    }

    /**
     * Get Campaign List By Advertiser Id.
     *
     * @param int $campaignId
     * 
     * @return array  array OA_Dll_CampaignInfo objects
     */
    function getCampaignListByAdvertiserId($advertiserId)
    {
        $dataCampaignList = $this->_sendWithSession('CampaignXmlRpcService.php',
                                                    'getCampaignListByAdvertiserId', array((int) $advertiserId));
        $returnData = array();
        foreach ($dataCampaignList as $dataCampaign) {
            $oCampaignInfo = new OA_Dll_CampaignInfo();
            $oCampaignInfo->readDataFromArray($dataCampaign);
            $returnData[] = $oCampaignInfo;
        }
    }

    /**
     * Delete Campaign.
     *
     * @param int $campaignId
     * @return  method result
     */
    function deleteCampaign($campaignId)
    {
        return (bool) $this->_sendWithSession('CampaignXmlRpcService.php',
                                              'deleteCampaign', array((int) $campaignId));
    }

    /**
     * Campaign daily statistics.
     *
     * @param int $campaignId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function campaignDailyStatistics($campaignId, $oStartDate = null, $oEndDate = null)
    {
        $statisticsData = $this->_callStatisticsMethod('CampaignXmlRpcService.php',
                                                       'campaignDailyStatistics',
                                                       $campaignId, $oStartDate, $oEndDate);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = date('Y-m-d',XML_RPC_iso8601_decode(
                                            $data['day']));
        }

        return $statisticsData;
    }

    /**
     * Campaign Banner statistics.
     *
     * @param int $campaignId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function campaignBannerStatistics($campaignId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('CampaignXmlRpcService.php',
                                            'campaignBannerStatistics',
                                            $campaignId, $oStartDate, $oEndDate);
    }

    /**
     * Campaign Publisher statistics.
     *
     * @param int $campaignId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function campaignPublisherStatistics($campaignId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('CampaignXmlRpcService.php',
                                            'campaignPublisherStatistics',
                                            $campaignId, $oStartDate, $oEndDate);
    }

    /**
     * Campaign Zone statistics.
     *
     * @param int $campaignId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function campaignZoneStatistics($campaignId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('CampaignXmlRpcService.php',
                                            'campaignZoneStatistics',
                                            $campaignId, $oStartDate, $oEndDate);
    }

    /**
     * Add Banner.
     *
     * @param OA_Dll_BannerInfo $oBannerInfo
     * 
     * @return  method result
     */
    function addBanner(&$oBannerInfo)
    {
        return (int) $this->_sendWithSession('BannerXmlRpcService.php',
                                             'addBanner', array(&$oBannerInfo));
    }

    /**
     * Modify Banner.
     *
     * @param OA_Dll_BannerInfo $oBannerInfo
     * 
     * @return  method result
     */
    function modifyBanner(&$oBannerInfo)
    {
        return (bool) $this->_sendWithSession('BannerXmlRpcService.php',
                                              'modifyBanner', array(&$oBannerInfo));
    }

    /**
     * Get Banner by id.
     *
     * @param int $bannerId
     * 
     * @return OA_Dll_BannerInfo
     */
    function getBanner($bannerId)
    {
        $dataBanner = $this->_sendWithSession('BannerXmlRpcService.php',
                                                'getBanner', array((int) $bannerId));
        $oBannerInfo = new OA_Dll_BannerInfo();
        $oBannerInfo->readDataFromArray($dataBanner);

        return $oBannerInfo;
    }
    
    /**
     * Get Banner List By Campaign Id.
     *
     * @param int $banenrId
     * 
     * @return array  array OA_Dll_CampaignInfo objects
     */
    function getBannerListByCampaignId($campaignId)
    {
        $dataBannerList = $this->_sendWithSession('BannerXmlRpcService.php',
                                                  'getBannerListByCampaignId', array((int) $campaignId));
        $returnData = array();
        foreach ($dataBannerList as $dataBanner) {
            $oBannerInfo = new OA_Dll_BannerInfo();
            $oBannerInfo->readDataFromArray($dataBanner);
            $returnData[] = $oBannerInfo;
        }

        return $returnData;
    }

    /**
     * Delete Banner.
     *
     * @param int $bannerId
     * @return  method result
     */
    function deleteBanner($bannerId)
    {
        return (bool) $this->_sendWithSession('BannerXmlRpcService.php',
                                              'deleteBanner', array((int) $bannerId));
    }

    /**
     * Banner daily statistics.
     *
     * @param int $bannerId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function bannerDailyStatistics($bannerId, $oStartDate = null, $oEndDate = null)
    {
        $statisticsData = $this->_callStatisticsMethod('BannerXmlRpcService.php',
                                                       'bannerDailyStatistics',
                                                       $bannerId, $oStartDate, $oEndDate);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = date('Y-m-d',XML_RPC_iso8601_decode(
                                            $data['day']));
        }

        return $statisticsData;
    }

    /**
     * Banner Publisher statistics.
     *
     * @param int $bannerId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function bannerPublisherStatistics($bannerId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('BannerXmlRpcService.php',
                                            'bannerPublisherStatistics',
                                            $bannerId, $oStartDate, $oEndDate);

    }

    /**
     * Banner Zone statistics.
     *
     * @param int $bannerId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function bannerZoneStatistics($bannerId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('BannerXmlRpcService.php',
                                            'bannerZoneStatistics',
                                            $bannerId, $oStartDate, $oEndDate);

    }

    /**
     * Add Publisher.
     *
     * @param OA_Dll_PublisherInfo $oPublisherInfo
     * @return  method result
     */
    function addPublisher(&$oPublisherInfo)
    {
        return (int) $this->_sendWithSession('PublisherXmlRpcService.php',
                                             'addPublisher', array(&$oPublisherInfo));

        return $returnData;
    }

    /**
     * Modify Publisher.
     *
     * @param OA_Dll_PublisherInfo $oPublisherInfo
     * @return  method result
     */
    function modifyPublisher(&$oPublisherInfo)
    {
        return (bool) $this->_sendWithSession('PublisherXmlRpcService.php', 'modifyPublisher',
                                              array(&$oPublisherInfo));
    }

    /**
     * Get Publisher by id.
     *
     * @param int $publisherId
     * @return OA_Dll_PublisherInfo
     */
    function getPublisher($publisherId)
    {
        $dataPublisher = $this->_sendWithSession('PublisherXmlRpcService.php',
                                                 'getPublisher', array((int) $publisherid));
        $oPublisherInfo = new OA_Dll_PublisherInfo();
        $oPublisherInfo->readDataFromArray($dataPublisher);

        return $oPublisherInfo;
    }

    /**
     * Get Publisher List by Agency Id.
     *
     * @param int $agencyId
     * @return array  array OA_Dll_PublisherInfo objects
     */
    function getPublisherListByAgencyId($agencyId)
    {
        $dataPublisherList = $this->_sendWithSession('PublisherXmlRpcService.php',
                                                     'getPublisherListByAgencyId', array((int) $agencyId));
        $returnData = array();
        foreach ($dataPublisherList as $dataPublisher) {
            $oPublisherInfo = new OA_Dll_PublisherInfo();
            $oPublisherInfo->readDataFromArray($dataPublisher);
            $returnData[] = $oPublisherInfo;
        }

        return $returnData;
    }

    /**
     * Delete Publisher.
     *
     * @param int $publisherId
     * @return  method result
     */
    function deletePublisher($publisherId)
    {
        return (bool) $this->_sendWithSession('PublisherXmlRpcService.php',
                                              'deletePublisher', array((int) $publisherId));
    }

    /**
     * Publisher daily statistics.
     *
     * @param int $publisherId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function publisherDailyStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        $statisticsData = $this->_callStatisticsMethod('PublisherXmlRpcService.php',
                                                       'publisherDailyStatistics',
                                                       $publisherId, $oStartDate, $oEndDate);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = date('Y-m-d',XML_RPC_iso8601_decode(
                                            $data['day']));
        }

        return $statisticsData;
    }

    /**
     * Publisher Zone statistics.
     *
     * @param int $publisherId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function publisherZoneStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('PublisherXmlRpcService.php',
                                            'publisherZoneStatistics',
                                            $publisherId, $oStartDate, $oEndDate);
    }

    /**
     * Publisher Advertiser statistics.
     *
     * @param int $publisherId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function publisherAdvertiserStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('PublisherXmlRpcService.php',
                                            'publisherAdvertiserStatistics',
                                            $publisherId, $oStartDate, $oEndDate);
    }

    /**
     * Publisher Campaign statistics.
     *
     * @param int $publisherId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function publisherCampaignStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('PublisherXmlRpcService.php',
                                            'publisherCampaignStatistics',
                                            $publisherId, $oStartDate, $oEndDate);
    }

    /**
     * Publisher Banner statistics.
     *
     * @param int $publisherId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function publisherBannerStatistics($publisherId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('PublisherXmlRpcService.php',
                                            'publisherBannerStatistics',
                                            $publisherId, $oStartDate, $oEndDate);
    }

    /**
     * Add Zone.
     *
     * @param OA_Dll_ZoneInfo $oZoneInfo
     * @return  method result
     */
    function addZone(&$oZoneInfo)
    {
        return (int) $this->_sendWithSession('ZoneXmlRpcService.php',
                                             'addZone', array(&$oZoneInfo));
    }

    /**
     * Modify Zone.
     *
     * @param OA_Dll_ZoneInfo $oZoneInfo
     * @return  method result
     */
    function modifyZone(&$oZoneInfo)
    {
        return (bool) $this->_sendWithSession('ZoneXmlRpcService.php', 'modifyZone',
                                              array(&$oZoneInfo));
    }

    /**
     * Get Zone by id.
     *
     * @param int $zoneId
     * @return OA_Dll_ZoneInfo
     */
    function getZone($zoneId)
    {
        $dataZone = $this->_sendWithSession('ZoneXmlRpcService.php',
                                                 'getZone', array((int) $zoneid));
        $oZoneInfo = new OA_Dll_ZoneInfo();
        $oZoneInfo->readDataFromArray($dataZone);

        return $oZoneInfo;
    }

    /**
     * Get Zone List by Publisher Id.
     *
     * @param int $publisherId
     * @return array  array OA_Dll_ZoneInfo objects
     */
    function getZoneListByPublisherId($publisherId)
    {
        $dataZoneList = $this->_sendWithSession('ZoneXmlRpcService.php',
                                                'getZoneListByPublisherId', array((int) $publisherId));
        $returnData = array();
        foreach ($dataZoneList as $dataZone) {
            $oZoneInfo = new OA_Dll_ZoneInfo();
            $oZoneInfo->readDataFromArray($dataZone);
            $returnData[] = $oZoneInfo;
        }

        return $returnData;
    }

    /**
     * Delete Zone.
     *
     * @param int $zoneId
     * @return  method result
     */
    function deleteZone($zoneId)
    {
        return (bool) $this->_sendWithSession('ZoneXmlRpcService.php',
                                              'deleteZone', array((int) $zoneId));
    }

    /**
     * Zone daily statistics.
     *
     * @param int $zoneId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function zoneDailyStatistics($zoneId, $oStartDate = null, $oEndDate = null)
    {
        $statisticsData = $this->_callStatisticsMethod('ZoneXmlRpcService.php',
                                                       'zoneDailyStatistics',
                                                       $zoneId, $oStartDate, $oEndDate);

        foreach ($statisticsData as $key => $data) {
            $statisticsData[$key]['day'] = date('Y-m-d',XML_RPC_iso8601_decode(
                                            $data['day']));
        }

        return $statisticsData;
    }

    /**
     * Zone Advertiser statistics.
     *
     * @param int $zoneId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function zoneAdvertiserStatistics($zoneId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('ZoneXmlRpcService.php',
                                            'zoneAdvertiserStatistics',
                                            $zoneId, $oStartDate, $oEndDate);
    }

    /**
     * Zone Campaign statistics.
     *
     * @param int $zoneId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function zoneCampaignStatistics($zoneId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('ZoneXmlRpcService.php',
                                            'zoneCampaignStatistics',
                                            $zoneId, $oStartDate, $oEndDate);
    }

    /**
     * Zone Publisher statistics.
     *
     * @param int $zoneId
     * @param Pear::Date $oStartDate
     * @param Pear::Date $oEndDate
     * @return array  result data
     */
    function zoneBannerStatistics($zoneId, $oStartDate = null, $oEndDate = null)
    {
        return $this->_callStatisticsMethod('ZoneXmlRpcService.php',
                                            'zoneBannerStatistics',
                                            $zoneId, $oStartDate, $oEndDate);
    }


}

?>