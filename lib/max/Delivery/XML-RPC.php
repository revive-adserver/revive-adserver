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
 * @package    MaxDelivery
 * @subpackage XMLRPC
 */

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';

require_once MAX_PATH . '/lib/OX.php';
require_once 'XML/RPC/Server.php';

// Set a global variable to let the other functions know
// they are serving an XML-RPC request. Needed for capping
// on request
$GLOBALS['_OA']['invocationType'] = 'xmlrpc';

// Workaround for PHP bug #41293 (PHP-5.2.2)
if (empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
    $GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents('php://input');
}

// Set automatic Base64 encoding in XML-RPC response
XML_RPC_Client::setAutoBase64(true);

/**
 * New OpenX signature / docs
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
 * New OpenX signature / docs for SPC XML-RPC method
 *
 * @since 2.5.2-dev
 */
$xmlRpcSPC_OA =
    array(
        'sig' => array(
                    array(
                        $GLOBALS['XML_RPC_Struct'],  // Return value
                        $GLOBALS['XML_RPC_Struct'],  // Environment and cookies
                        $GLOBALS['XML_RPC_String'],  // What
                        $GLOBALS['XML_RPC_String'],  // Target
                        $GLOBALS['XML_RPC_String'],  // Source
                        $GLOBALS['XML_RPC_Boolean'], // WithText
                        $GLOBALS['XML_RPC_Boolean'], // Block
                        $GLOBALS['XML_RPC_Boolean'], // Block Campaign
                    )
                ),
        'doc' => 'When passed the "environment/cookies" struct, "what", "target", "source", ' .
                 '"withtext", "block" and "blockcampaign" returns the cookies to be set and an array of HTML code to display the ' .
                 'selected advertisements.'
    );

/**
 * MMM 0.3 / OpenX 2.3 backwards compatible signature / docs
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
 * PAN / OpenX 2.0 backwards compatible signature / docs
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

        // Bump the params array to account for the inserted $charset parameter
        if ($i == 6) { $view_params[] = ''; }

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
                $_COOKIE[$key] = MAX_commonAddslashesRecursive($value);
            }
            MAX_remotehostSetInfo(true);
            OX_Delivery_Common_hook('postInit');
            MAX_cookieUnpackCapping();
        }
    }

    // Add $richMedia parameter
    $view_params[] = true;
    // Add $ct0 parameter
    $view_params[] = '';
    // Add $loc param
    $view_params[] =
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.
        OX_getHostName().
        $_SERVER['REQUEST_URI'];
    // Add $referer parameter
    $view_params[] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    // Mimic the behaviour of MAX_commonInitVariables()
    //
    // MAX_adSelect signature is:
    // $what, $campaignid = '', $target = '', $source = '', $withtext = 0, $charset = '', $context = array(), $richmedia = true, $ct0 = '', $loc = '', $referer = ''
    $escape = array(
        'addslashes',
        'intval',
        'addslashes',
        'addslashes',
        'intval',
        'addslashes',
        'MAX_commonAddslashesRecursive',
        'intval',
        'addslashes',
        'addslashes',
        '', // referer doesn't need escaping
    );
    foreach ($escape as $key => $callback) {
        if (is_callable($callback)) {
            $view_params[$key] = $callback($view_params[$key]);
        }
    }

    // Call MAX_adSelect with supplied parameters
    $output = call_user_func_array('MAX_adSelect', $view_params);

    // Prepare output as PHP array
    if (!is_array($output)) {
        $output = array();
    } elseif (isset($output['contenttype']) && $output['contenttype'] == 'swf') {
        $output['html'] = MAX_flashGetFlashObjectExternal() . $output['html'];
    }

    MAX_cookieFlush();

    // Add cookie information
    $output['cookies'] = $GLOBALS['_OA']['COOKIE']['XMLRPC_CACHE'];

    // Return response
    return new XML_RPC_Response(XML_RPC_encode($output));
}

/**
 * A function to handle XML-RPC advertisement SPC requests.
 *
 * @param XML_RPC_Message $params An XML_RPC_Message containing the parameters. The expected parameters
 *                              are (in order):
 *                              - An XML_RPC_Value of type "struct"  containing remote informations
 *                                which needs at least two members:
 *                                - remote_addr (string) and
 *                                - cookies     (struct);
 *                              - An XML_RPC_Value of type "string"  containing the "what" value;
 *                              - An XML_RPC_Value of type "string"  containing the "target" value;
 *                              - An XML_RPC_Value of type "string"  containing the "source" value;
 *                              - An XML_RPC_Value of type "boolean" containing the "withtext" value;
 *                              - An XML_RPC_Value of type "boolean" containing the "block" value;
 *                              - An XML_RPC_Value of type "boolean" containing the "blockcampaign" value;
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
function OA_Delivery_XmlRpc_SPC($params)
{
    global $XML_RPC_erruser;
    global $XML_RPC_String, $XML_RPC_Struct, $XML_RPC_Array;

    // Check the parameters exist
    $numParams = $params->getNumParams();
    if ($numParams != 7) {
        // Return an error
        $errorCode = $XML_RPC_erruser + 21;
        $errorMsg  = 'Incorrect number of parameters';
        return new XML_RPC_Response(0, $errorCode, $errorMsg);
    }

    // Set the XML values into their correct variables to make life easier
    $vars = array(
        1 => 'what',
        2 => 'target',
        3 => 'source',
        4 => 'withtext',
        5 => 'block',
        6 => 'blockcampaign',
    );
    // Parse parameters
    for ($i = 0; $i < $numParams; $i++)
    {
        $p = $params->getParam($i);

        if ($i) {
            // Put the decoded value the view arg array
            ${$vars[$i]} = XML_RPC_decode($p);
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
                $_COOKIE[$key] = MAX_commonAddslashesRecursive($value);
            }

            MAX_remotehostSetInfo(true);
            OX_Delivery_Common_hook('postInit');
            MAX_cookieUnpackCapping();
        }
    }

    // Add defaults for not-applicable values
    $richmedia = true;
    $ct0 = '';
    $context = array();
    // Make loc and referer global to ensure that the delivery limitations work correctly
    global $loc, $referer;
    $loc =
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.
        OX_getHostName().
        $_SERVER['REQUEST_URI'];
    // Add $referer parameter
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    // If the what parameter is an int, it is the affiliateid, otherwise it's a serialized array of name=zone pairs
    // This convention is inline with the parameters passed into local-mode SPC
    if (is_numeric($what)) {
        $zones = OA_cacheGetPublisherZones($what);
        $nz = false;
    } else {
        $zones = unserialize($what);
        $nz = true;
    }

    $spc_output = array();
    foreach ($zones as $zone => $data) {
        if (empty($zone)) continue;
        // nz is set when "named zones" are being used, this allows a zone to be selected more than once
        if ($nz) {
            $varname = $zone;
            $zoneid = $data;
        } else {
            $varname = $zoneid = $zone;
        }

        // Clear deiveryData between iterations
        unset($GLOBALS['_MAX']['deliveryData']);

        // Get the banner
        $output = MAX_adSelect('zone:'.$zoneid, '', $target, $source, $withtext, '', $context, $richmedia, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);

        $spc_output[$varname] = $output;

        // Block this banner for next invocation
        if (!empty($block) && !empty($output['bannerid'])) {
            $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
        }
        // Block this campaign for next invocation
        if (!empty($blockcampaign) && !empty($output['campaignid'])) {
            $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
        }
        // Pass the context array back to the next call, have to iterate over elements to prevent duplication
        if (!empty($output['context'])) {
            foreach ($output['context'] as $id => $contextArray) {
                if (!in_array($contextArray, $context)) {
                    $context[] = $contextArray;
                }
            }
        }
    }
    return new XML_RPC_Response(XML_RPC_encode($spc_output));
    // Now we have all the parameters we need to select the ad

    // Call MAX_adSelect with supplied parameters
    $output = call_user_func_array('MAX_adSelect', $view_params);

    // Prepare output as PHP array
    if (!is_array($output)) {
        $output = array();
    } elseif (isset($output['contenttype']) && $output['contenttype'] == 'swf') {
        $output['html'] = MAX_flashGetFlashObjectExternal() . $output['html'];
    }

    MAX_cookieFlush();

    // Add cookie information
    $output['cookies'] = $GLOBALS['_OA']['COOKIE']['XMLRPC_CACHE'];

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
    if (XML_RPC_Base::isError($xmlResponse)) {
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
