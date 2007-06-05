<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
$Id$
*/

if (!@include('XML/RPC.php')) {
    die("Error: cannot load the PEAR XML_RPC class");
}

/**
 * A library class to provide XML-RPC routines on the client-side - that is, on
 * a web server that needs to display ads in its pages, but where Openads is NOT
 * installed on that server -- it's installed on a remote server.
 *
 * For use with Openads PHP-based XML-RPC invocation tags.
 *
 * @package    Openads
 * @subpackage ExternalLibrary
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class OA_XmlRpc
{
    var $host;
    var $path;
    var $ssl;
    var $timeout;

    var $debug = false;

    /**
     * PHP5 style constructor
     *
     * @param string $host    The hostname to connect to
     * @param string $path    The path to the axmlrpc.php file
     * @param int    $port    The port number, 0 to use standard ports
     * @param bool   $ssl     True to connect using an SSL connection
     * @param int    $timeout The timeout to wait for the response
     */
    function __construct($host, $path, $port = 0, $ssl = false, $timeout = 15)
    {
        $this->host = $host;
        $this->path = $path;
        $this->ssl  = $ssl;
        $this->timeout = $timeout;
    }

    /**
     * PHP4 style constructor
     *
     * @see OA_XmlRpc::__construct
     */
    function OA_XmlRpc($host, $path, $port = 0, $ssl = false, $timeout = 15)
    {
        $this->__construct($host, $path, $port, $ssl, $timeout);
    }

    /**
     * This method retrieves a banner from a remote Openads installation using XML-RPC
     *
     * @param string $what       The "what" parameter, see docs for more info
     * @param int    $campaignid The campaign id to fetch banners from, 0 means any campaign
     * @param string $target     The HTML <a href> target
     * @param string $source     The "source" parameter, see docs for more info
     * @param bool   $withText   Wheter or not to show the text under a banner
     * @param array  $context    The "context" parameter, see docs for more info
     *
     * @return array
     */
    function view($what = '', $campaignid = 0, $target = '', $source = '', $withText = false, $context = array())
    {
        global $XML_RPC_String, $XML_RPC_Boolean;
        global $XML_RPC_Array, $XML_RPC_Struct;
        global $XML_RPC_Int;

        // Prepare variables
        $aServerVars = array(
            'remote_addr'       => 'REMOTE_ADDR',
            'remote_host'       => 'REMOTE_HOST',

            // Headers used for ACLs
            'request_uri'       => 'REQUEST_URI',
            'https'             => 'HTTPS',
            'server_name'       => 'SERVER_NAME',
            'http_host'         => 'HTTP_HOST',
            'accept_language'   => 'HTTP_ACCEPT_LANGUAGE',
            'referer'           => 'HTTP_REFERER',
            'user_agent'        => 'HTTP_USER_AGENT',

            // Headers used for proxy lookup
            'via'               => 'HTTP_VIA',
            'forwarded'         => 'HTTP_FORWARDED',
            'forwarded_for'     => 'HTTP_FORWARDED_FOR',
            'x_forwarded'       => 'HTTP_X_FORWARDED',
            'x_forwarded_for'   => 'HTTP_X_FORWARDED_FOR',
            'client_ip'         => 'HTTP_CLIENT_IP'
        );

        // Create environment array
        $aRemoteInfo = array();
        foreach ($aServerVars as $xmlVar => $varName) {
            if (isset($_SERVER[$varName])) {
                $aRemoteInfo[$xmlVar] = $_SERVER[$varName];
            }
        }

        // Add cookies
        $aRemoteInfo['cookies'] = $_COOKIE;

        // Encode context
        $xmlContext = array();
        foreach ($context as $contexValue) {
            $xmlContext[] = XML_RPC_encode($contextValue);
        }

        // Create the XML-RPC message
        $message = new XML_RPC_Message('openads.view', array(
            XML_RPC_encode($aRemoteInfo),
            new XML_RPC_Value($what,       $XML_RPC_String),
            new XML_RPC_Value($campaignid, $XML_RPC_Int),
            new XML_RPC_Value($target,     $XML_RPC_String),
            new XML_RPC_Value($source,     $XML_RPC_String),
            new XML_RPC_Value($withText,   $XML_RPC_Boolean),
            new XML_RPC_Value($context,    $XML_RPC_Array)
        ));

        // Create an XML-RPC client to talk to the XML-RPC server
        $client = new XML_RPC_Client($this->path, $this->host, $this->port);

        // Send the XML-RPC message to the server
        $response = $client->send($message, $this->timeout, $this->ssl ? 'https' : 'http');

        // Was the response OK?
        if ($response && $response->faultCode() == 0) {
            $response = XML_RPC_decode($response->value());

            if (isset($response['cookies']) && is_array($response['cookies'])) {
                foreach ($response['cookies'] as $cookieName => $cookieValue) {
                    setcookie($cookieName, $cookieValue[0], $cookieValue[1]);
                }
            }

            unset($response['cookies']);

            return $response;
        }

        return array(
            'html'       => '',
            'bannerid'   => 0,
            'campaignid' => 0
        );
    }
}

?>