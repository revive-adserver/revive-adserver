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
    die("Error: cannot load the PEAR XML_RPC class");
}

/**
 * A library class to provide XML-RPC routines on the client-side - that is, on
 * a web server that needs to control Openads via the webservice API
 *
 * @package    Openads
 * @subpackage ExternalLibrary
 * @author     Chris Nutting <Chris.Nutting@openads.org>
 *
 * @todo       This is a very initial draft built mainly for testing but will be useful
 *             to developers who want to access the WebService
 *
 * @example The following code will include and make use of one of these helper methods
 *
 * <?php
 *     require_once('lib/xmlrpc/php/openads-api-xmlrpc.inc.php');
 *     $client = new OA_Api_Xmlrpc('host', '/api/v1/xmlrpc', 'username', 'password');
 *     $return = $client->addCampaign(16, 'Campaign name');
 * ?>
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
     * A private function to send a method call to a specified service
     *
     * @param string $service The name of the remote service file
     * @param string $method  The name of the remote method to be called
     * @param mixed  $data    The data to be sent to the WebService
     * @return mixed Response from server or false on failure
     */
    function _send($service, $method, $data = array())
    {
        $message = new XML_RPC_Message($method, array(
            XML_RPC_encode($this->sessionId),
            XML_RPC_encode($data)
        ));

        $client = new XML_RPC_Client($this->basepath . '/' . $service . $this->debug, $this->host);

        // Send the XML-RPC message to the server
        $response = $client->send($message, $this->timeout, $this->ssl ? 'https' : 'http');

        // Check for error response
        if ($response && $response->faultCode() == 0) {
            $response = XML_RPC_decode($response->value());
        } else {
            echo "XML-RPC error (" . $response->faultCode() . ") -> " . $response->faultString();
            return false;
        }
        return $response;
    }

    /**
     * A private method to logon to the WebService
     *
     * @return boolean Was the remote logon() call successful?
     */
    function _logon()
    {
        $message = new XML_RPC_Message('logon', array(XML_RPC_encode($this->username), XML_RPC_encode($this->password)));
        $client = new XML_RPC_Client($this->basepath . '/LogonXmlRpcService.php' . $this->debug, $this->host);
        $response = $client->send($message, $this->timeout, $this->ssl ? 'https' : 'http');

        if ($response && $response->faultCode() == 0) {
            $response = XML_RPC_decode($response->value());
        } else {
            return false;
        }
        $this->sessionId = $response;
        return true;
    }

    function addAdvertiser($agencyId, $advertiserName, $contactName = null, $emailAddress = null, $username = null, $password = null)
    {
        // Setup data with required fields
        $data = array(
            'agencyId' => 0,
            'advertiserName' => $advertiserName,
        );

        // Add optional parameters to the data array
        if (!is_null($contactName))  { $data['contactName']   = $contactName; }
        if (!is_null($emailAddress)) { $data['emailAddress'] = $emailAddress; }
        if (!is_null($username))     { $data['username']     = $username; }
        if (!is_null($password))     { $data['password']     = $password; }

        $message = new XML_RPC_Message('addAdvertiser', array(
            XML_RPC_encode()
            )
        );
        // Send the request
        return $this->_send('AdvertiserXmlRpcService.php', 'addAdvertiser', $data);
    }

    function modifyAdvertiser($advertiserId, $agencyId = null, $advertiserName = null, $contactName = null, $emailAddress = null, $username = null, $password = null)
    {
        // Setup data with required fields
        $data = array(
            'advertiserId' => $advertiserId,
        );

        // Add optional parameters to the data array
        if (!is_null($agencyId))       { $data['agencyId']       = $agencyId; }
        if (!is_null($advertiserName)) { $data['advertiserName'] = $advertiserName; }
        if (!is_null($contactName))    { $data['contactName']    = $contactName; }
        if (!is_null($emailAddress))   { $data['emailAddress']   = $emailAddress; }
        if (!is_null($username))       { $data['username']       = $username; }
        if (!is_null($password))       { $data['password']       = $password; }

        return $this->_send('AdvertiserXmlRpcService.php', 'modifyAdvertiser', $data);
    }

    function deleteAdvertiser($advertiserId)
    {
        return $this->_send('AdvertiserXmlRpcService.php', 'deleteAdvertiser', $advertiserId);
    }

    function addAgency($agencyName, $contactName = null, $emailAddress = null, $username = null, $password = null)
    {
        $data = array(
            'agencyName' => $agencyName,
        );
        if (!is_null($contactName))  { $data['contactName']  = $contactName; }
        if (!is_null($emailAddress)) { $data['emailAddress'] = $emailAddress; }
        if (!is_null($username))     { $data['username']     = $username; }
        if (!is_null($password))     { $data['password']     = $password; }

        return $this->_send('AgencyXmlRpcService.php', 'addAgency', $data);
    }

    function modifyAgency($agencyId, $agencyName = null, $contactName = null, $emailAddress = null, $username = null, $password = null)
    {
        $data = array(
            'agencyId' => $agencyId,
        );

        if (!is_null($agencyName))   { $data['agencyName']   = $agencyName; }
        if (!is_null($contactName))  { $data['contactName']  = $contactName; }
        if (!is_null($emailAddress)) { $data['emailAddress'] = $emailAddress; }
        if (!is_null($username))     { $data['username']     = $username; }
        if (!is_null($password))     { $data['password']     = $password; }

        return $this->_send('AgencyXmlRpcService.php', 'modifyAgency', $data);
    }

    function deleteAgency($agencyId)
    {
        return $this->_send('AgencyXmlRpcService.php', 'deleteAgency', $agencyId);
    }

    function addCampaign($advertiserId, $campaignName = null, $startDate = null, $endDate = null, $impressions = null, $clicks = null, $weight = null)
    {
        $data = array(
            'advertiserId' => $advertiserId
        );
        if (!is_null($campaignName)){ $data['campaignName'] = $campaignName; }
        if (!is_null($startDate))   { $data['startDate'] = $startDate; }
        if (!is_null($endDate))     { $data['endDate'] = $endDate; }
        if (!is_null($impressions)) { $data['impressions'] = $impressions; }
        if (!is_null($clicks))      { $data['clicks'] = $clicks; }
        if (!is_null($weight))      { $data['weight'] = $weight; }

        return $this->_send('CampaignXmlRpcService.php', 'addCampaign', $data);
    }

    function modifyCampaign($campaignId, $advertiserId = null, $campaignName = null, $startDate = null, $endDate = null, $impressions = null, $clicks = null, $weight = null)
    {
        $data = array(
            'campaignId' => $campaignId,
        );
        if (!is_null($advertiserId)){ $data['advertiserId'] = $advertiserId; }
        if (!is_null($campaignName)){ $data['campaignName'] = $campaignName; }
        if (!is_null($startDate))   { $data['startDate'] = $startDate; }
        if (!is_null($endDate))     { $data['endDate'] = $endDate; }
        if (!is_null($impressions)) { $data['impressions'] = $impressions; }
        if (!is_null($clicks))      { $data['clicks'] = $clicks; }
        if (!is_null($weight))      { $data['weight'] = $weight; }

        return $this->_send('CampaignXmlRpcService.php', 'addCampaign', $data);
    }

    function deleteCampaign()
    {

    }
}

?>