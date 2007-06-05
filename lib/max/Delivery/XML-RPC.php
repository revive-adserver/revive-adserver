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

/**
 * @package    MaxDelivery
 * @subpackage XMLRPC
 * @author     Chris Nutting <chris@m3.net>
 */

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';

require_once 'XML/RPC/Server.php';

// Set a global variable to let the other functions know
// they are serving an XML-RPC request. Needed for capping
// on request
$GLOBALS['_OA']['invocationType'] = 'xml-rpc';

// Workaround for PHP bug #41293 (PHP-5.2.2)
if (empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
    $GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents('php://input');
}

/**
 * New Openads signature / docs
 *
 * @since 2.3.32-beta
 */
$xmlRpcView_OA =
    array(
        'sig' => array(
                    array(
                        $GLOBALS['XML_RPC_Struct'],  // Return value
                        $GLOBALS['XML_RPC_Struct'],  // Environment and cookies
                        $GLOBALS['XML_RPC_String'],  // What
                        $GLOBALS['XML_RPC_Int'],     // Campaignid
                        $GLOBALS['XML_RPC_String'],  // Target
                        $GLOBALS['XML_RPC_String'],  // Source
                        $GLOBALS['XML_RPC_Boolean'], // WithText
                        $GLOBALS['XML_RPC_Array']    // Context
                    )
                ),
        'doc' => 'When passed the "environment/cookies" struct, "what", "campaignid", "target", "source", ' .
                 '"withText", "context" returns the cookies to be set and the HTML code to display the ' .
                 'appropriate advertisement.'
    );

/**
 * MMM 0.3 / Openads 2.3 backwards compatible signature / docs
 */
$xmlRpcView_Max =
    array(
        'sig' => array(
                    array(
                        $GLOBALS['XML_RPC_String'],  // Return value
                        $GLOBALS['XML_RPC_String'],  // What
                        $GLOBALS['XML_RPC_String'],  // Target
                        $GLOBALS['XML_RPC_String'],  // Source
                        $GLOBALS['XML_RPC_Boolean'], // WithText
                        $GLOBALS['XML_RPC_String'],  // IP Address
                        $GLOBALS['XML_RPC_Struct']   // Cookies
                    ),
                    array(
                        $GLOBALS['XML_RPC_String'],  // Return value
                        $GLOBALS['XML_RPC_String'],  // What
                        $GLOBALS['XML_RPC_String'],  // Target
                        $GLOBALS['XML_RPC_String'],  // Source
                        $GLOBALS['XML_RPC_Boolean'], // WithText
                        $GLOBALS['XML_RPC_String'],  // IP Address
                        $GLOBALS['XML_RPC_Struct'],  // Cookies
                        $GLOBALS['XML_RPC_Array']    // Context - @since late 2.3
                    )
                ),
        'doc' => '2.3 backwards compatibility method - deprecated'
    );

/**
 * PAN / Openads 2.0 backwards compatible signature / docs
 */
$xmlRpcView_PAN =
    array(
        'sig' => array(
                    array(
                        $GLOBALS['XML_RPC_Struct'],  // Return value
                        $GLOBALS['XML_RPC_Struct'],  // Environment
                        $GLOBALS['XML_RPC_String'],  // What
                        $GLOBALS['XML_RPC_Int'],     // Campaignid
                        $GLOBALS['XML_RPC_String'],  // Target
                        $GLOBALS['XML_RPC_String'],  // Source
                        $GLOBALS['XML_RPC_Boolean']  // WithText
                    ),
                    array(
                        $GLOBALS['XML_RPC_Struct'],  // Return value
                        $GLOBALS['XML_RPC_Struct'],  // Environment
                        $GLOBALS['XML_RPC_String'],  // What
                        $GLOBALS['XML_RPC_Int'],     // Campaignid
                        $GLOBALS['XML_RPC_String'],  // Target
                        $GLOBALS['XML_RPC_String'],  // Source
                        $GLOBALS['XML_RPC_Boolean'], // WithText
                        $GLOBALS['XML_RPC_Array']    // Context
                    )
                ),
        'doc' => '2.0 Backwards compatibility method - deprecated'
    );


/**
 * A function to handle XML-RPC advertisement view requests.
 *
 * @param XML_RPC_Message $params An XML_RPC_Message containing the parameters. The expected parameters
 *                              are (in order):
 *                              - An XML_RPC_Value of type "struct"  containing remote informations
 *                                which needs at least two members:
 *                                - remote_addr (string) and
 *                                - cookies     (struct);
 *                              - An XML_RPC_Value of type "string"  containing the "what" value;
 *                              - An XML_RPC_Value of type "int"     containing the "campaignid" value;
 *                              - An XML_RPC_Value of type "string"  containing the "target" value;
 *                              - An XML_RPC_Value of type "string"  containing the "source" value;
 *                              - An XML_RPC_Value of type "boolean" containing the "withText" value;
 *                              - An XML_RPC_Value of type "array"   containing the "context" value.
 * @return XML_RPC_Response The response. The XML_RPC_Value of the response can be one of
 *                          a number of different values:
 *                          - Error Code 21: wrong number of parameters.
 *                          - Error Code 22: remote_addr element missing from the remote info struct.
 *                          - Error Code 23: cookies element missing from the remote info struct.
 *                          - An XML_RPC_Value of type "struct" with the HTML details required
 *                            for displaying the advertisement stored as in XML_RPC_Value of
 *                            type "string" in the "html" index, and other elements returned by the
 *                            MAX_asSelect call. A special "cookies" element is either:
 *                            - An empty XML_RPC_Value if there are no cookies to be set, or
 *                            - An XML_RPC_Value of type "array", containing a number of XML_RPC_Values
 *                              of tpye "array", each with 3 items:
 *                              - An XML_RPC_Value of type "string" with the cookie name;
 *                              - An XML_RPC_Value of type "string" with the cookie value; and
 *                              - An XML_RPC_Value of type "string" with the cookie expiration time.
 */
function OA_Delivery_XmlRpc_View($params)
{
    global $XML_RPC_erruser;
    global $XML_RPC_String, $XML_RPC_Struct, $XML_RPC_Array;

    $cookieCache =& $GLOBALS['_MAX']['COOKIE']['CACHE'];

    // Check the parameters exist
    $numParams = $params->getNumParams();
    if ($numParams != 7) {
        // Return an error
        $errorCode = $XML_RPC_erruser + 21;
        $errorMsg  = 'Incorrect number of parameters';
        return new XML_RPC_Response(0, $errorCode, $errorMsg);
    }

    // Parse parameters
    for ($i = 0; $i < $numParams; $i++)
    {
        $p = $params->getParam($i);

        if ($i) {
            // Put the decoded value the view arg array
            $view_params[] = XML_RPC_decode($p);
        } else {
            // First parameter: environment information supplied be XML-RPC client
            $p = XML_RPC_decode($p);

            if (!isset($p['remote_addr'])) {
                // Return an error
                $errorCode = $XML_RPC_erruser + 22;
                $errorMsg  = "Missing 'remote_addr' member";
                return new XML_RPC_Response(0, $errorCode, $errorMsg);
            }
            if (!isset($p['cookies']) || !is_array($p['cookies'])) {
                // Return an error
                $errorCode = $XML_RPC_erruser + 23;
                $errorMsg  = "Missing 'cookies' member";
                return new XML_RPC_Response(0, $errorCode, $errorMsg);
            }

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

            // Extract environment vars to $_SERVER
            foreach ($aServerVars as $xmlName => $varName) {
                if (isset($p[$xmlName])) {
                    $_SERVER[$varName] = $p[$xmlName];
                }
            }

            // Extract cookie vars to $_COOKIE
            foreach ($p['cookies'] as $key => $value) {
                $_COOKIE[$key] = addslashes($value);
            }
        }
    }

    // Add $richMedia parameter
    $view_params[] = true;
    // Add $ct0 parameter
    $view_params[] = '';
    // Add $loc param
    $view_params[] =
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.
        getHostName().
        $_SERVER['REQUEST_URI'];
    // Add $referer parameter
    $view_params[] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    // Call MAX_adSelect with supplied parameters
    $output = call_user_func_array('MAX_adSelect', $view_params);

    // Prepare output as PHP array
    if (!is_array($output)) {
        $output = array();
    } elseif (isset($output['contenttype']) && $output['contenttype'] == 'swf') {
        $output['html'] = MAX_flashGetFlashObjectExternal() . $output['html'];
    }

    // Add cookie information
    $output['cookies'] = $cookieCache;

    // Return response
    return new XML_RPC_Response(XML_RPC_encode($output));
}

/**
 * A function to handle XML-RPC advertisement view requests. 2.3 version
 *
 * @deprecated
 *
 * @param XML_RPC_Message $params An XML_RPC_Message containing the parameters. The expected parameters
 *                              are (in order):
 *                              - An XML_RPC_Value of type "string" containing the "what" value;
 *                              - An XML_RPC_Value of type "string" containing the "target" value;
 *                              - An XML_RPC_Value of type "string" containing the "source" value;
 *                              - An XML_RPC_Value of type "boolean" containing the "withText" value;
 *                              - An XML_RPC_Value of type "string" containing the viewer's IP address; and
 *                              - An XML_RPC_Value of type "struct" containing the viewer's cookie values
 *                                (indexed by cookie name);
 *                              - An XML_RPC_Value of type "array" containing the "context" value.
 * @return XML_RPC_Response The response. The XML_RPC_Value of the response can be one of
 *                          a number of different values:
 *                          - Error Code 1: The $params variable was not an XML_RPC_Value of
 *                            type "array".
 *                          - Error Code 2: The $params XML_RPC_Value "array" did not have 6
 *                            elements.
 *                          - An XML_RPC_Value of type "array" containing:
 *                            - An XML_RPC_Value of type "struct" with the HTML details required
 *                              for displaying the advertisement stored as in XML_RPC_Value of
 *                              type "string" in the "html" index, or an empty XML_RPC_Value if
 *                              there is no advertisement to display; and
 *                            - An empty XML_RPC_Value if there are no cookies to be set, or an
 *                              XML_RPC_Value of type "array", containing a number of
 *                              XML_RPC_Values of tpye "array", each with 3 items:
 *                              - An XML_RPC_Value of type "string" with the cookie name;
 *                              - An XML_RPC_Value of type "string" with the cookie value; and
 *                              - An XML_RPC_Value of type "string" with the cookie expiration time.
 */
function OA_Delivery_XmlRpc_View_Max($params)
{
    global $XML_RPC_erruser;
    global $XML_RPC_String, $XML_RPC_Struct, $XML_RPC_Array, $XML_RPC_Int;
    // Check the parameters exist
    $numParams = $params->getNumParams();
    if ($numParams < 6) {
        // Return an error
        $errorCode = $XML_RPC_erruser + 2;
        $errorMsg  = 'Incorrect number of parameters';
        return new XML_RPC_Response(0, $errorCode, $errorMsg);
    }
    // Extract the what parameter
    $whatXmlRpcValue = $params->getParam(0);
    // Extract the target parameter
    $targetXmlRpcValue = $params->getParam(1);
    // Extract the source parameter
    $sourceXmlRpcValue = $params->getParam(2);
    // Extract the withText parameter
    $withTextXmlRpcValue = $params->getParam(3);
    // Extract the remoteAddress parameter
    $remoteAddressXmlRpcValue = $params->getParam(4);
    // Extract the tunnelled cookies
    $cookiesXmlRpcValue = $params->getParam(5);
    // Extract the context parameter, if any
    if ($numParams >= 7) {
        $contextXmlRpcValue = $params->getParam(6);
    } else {
        $contextXmlRpcValue = new XML_RPC_Value(array(), $XML_RPC_Array);
    }
    // Generate 0 campaignid parameter
    $campaignidXmlRpcValue = new XML_RPC_Value(0, $XML_RPC_Int);

    // Create environment array
    $remoteInfoXmlRpcValue = new XML_RPC_Value(
        array(
            'remote_addr'   => $remoteAddressXmlRpcValue,
            'cookies'       => $cookiesXmlRpcValue
        ),
        $XML_RPC_Struct
    );

    // Recreate XML-RPC message
    $msg = new XML_RPC_Message('openads.view', array(
        $remoteInfoXmlRpcValue,
        $whatXmlRpcValue,
        $campaignidXmlRpcValue,
        $targetXmlRpcValue,
        $sourceXmlRpcValue,
        $withTextXmlRpcValue,
        $contextXmlRpcValue
    ));

    // Relay call to openads.view
    $xmlResponse = OA_Delivery_XmlRpc_View($msg);

    // Check for errors
    if ($xmlResponse->isError()) {
        // Return error
        return $xmlResponse;
    }

    // Change the response
    $output  = XML_RPC_decode($xmlResponse->value());
    $cookies = $output['cookies'];
    unset($output['cookies']);

    // Return XML-RPC response
    return new XML_RPC_Response(
        new XML_RPC_Value(array(
                XML_RPC_encode($output),
                XML_RPC_encode($cookies)
            ),
            $XML_RPC_Array
        )
    );
}


/**
 * A function to handle XML-RPC advertisement view requests. 2.0 version
 *
 * @deprecated
 *
 * @param XML_RPC_Message $params
 * @return XML_RPC_Response
 */
function OA_Delivery_XmlRpc_View_PAN($params)
{
    // Extract the remote_info parameter
    $remoteInfoXmlRpcValue = $params->getParam(0);
    $remote_info = XML_RPC_Decode($params->getParam(0));

    // Add empty cookies array
    $remote_info['cookies'] = array();

    // Create environment array
    $remoteInfoXmlRpcValue = XML_RPC_encode($remote_info);

    // Extract the context param
    if ($params->getNumParams() > 6) {
        $contextXmlRpcValue = $params->getParam(6);
    } else {
        $contextXmlRpcValue = new XML_RPC_Value(array(), $XML_RPC_Array);
    }

    // Recreate XML-RPC message
    $msg = new XML_RPC_Message('phpAds.view', array(
        $remoteInfoXmlRpcValue,
        $params->getParam(1),
        $params->getParam(2),
        $params->getParam(3),
        $params->getParam(4),
        $params->getParam(5),
        $contextXmlRpcValue
    ));

    // Relay call to openads.view
    $xmlResponse = OA_Delivery_XmlRpc_View($msg);

    // Check for errors as-is
    return $xmlResponse;
}

?>
