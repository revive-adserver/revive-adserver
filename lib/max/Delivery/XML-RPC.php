<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

$xmlRpcView_sig = array(array($xmlrpcString,
                              $xmlrpcString, $xmlrpcString, $xmlrpcString,
                              $xmlrpcBoolean, $xmlrpcString, $xmlrpcStruct));

$xmlRpcView_doc = 'When passed the "what", "target", "source", "withText", remote IP address and array ' .
                  'of cookies, returns the cookies to be set and the HTML code to display the appropriate ' . 
                  'advertisement.';
                  
/**
 * A function to handle XML-RPC advertisement view requests.
 *
 * @param XML_RPC_Value $params An XML_RPC_Value of type "array" containing the parameters. The
 *                              expected parameters in the array are (in order):
 *                              - An XML_RPC_Value of type "string" containing the "what" value;
 *                              - An XML_RPC_Value of type "string" containing the "target" value;
 *                              - An XML_RPC_Value of type "string" containing the "source" value;
 *                              - An XML_RPC_Value of type "boolean" containing the "withText" value;
 *                              - An XML_RPC_Value of type "string" containing the viewer's IP address; and
 *                              - An XML_RPC_Value of type "struct" containing the viewer's cookie values
 *                                (indexed by cookie name).
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
function xmlRpcView($params)
{
    $cookieCache =& $GLOBALS['_MAX']['COOKIE']['CACHE'];
    global $XML_RPC_erruser;
    global $XML_RPC_String, $XML_RPC_Struct, $XML_RPC_Array;
    // Check the parameters exist
    $numParams = $params->getNumParams();
    if ($numParams != 6) {
        // Return an error
        $errorCode = $XML_RPC_erruser + 2;
        $errorMsg  = 'Incorrect number of parameters';
        return new XML_RPC_Response(0, $errorCode, $errorMsg);
    }
    // Extract the what parameter
    $whatXmlRpcValue = $params->getParam(0);
    $what = $whatXmlRpcValue->scalarval();
    // Extract the target parameter
    $targetXmlRpcValue = $params->getParam(1);
    $target = $targetXmlRpcValue->scalarval();
    // Extract the source parameter
    $sourceXmlRpcValue = $params->getParam(2);
    $source = $sourceXmlRpcValue->scalarval();
    // Extract the withText parameter
    $withTextXmlRpcValue = $params->getParam(3);
    $withText = $withTextXmlRpcValue->scalarval();
    // Extract the remoteAddress parameter
    $remoteAddressXmlRpcValue = $params->getParam(4);
    $_SERVER['REMOTE_ADDR'] = $remoteAddressXmlRpcValue->scalarval();
    // Extract the tunnelled cookies
    $cookiesXmlRpcValue = $params->getParam(5);
    while (list($key, $value) = $cookiesXmlRpcValue->structeach()) {
        $_COOKIE[$key] = $value->scalarval();
    }
    // Find the ad display code
    $output = MAX_adSelect($what, $target, $source, $withText);
    if ($output['contenttype'] == 'swf') {
        $output['html'] = MAX_flashGetFlashObjectExternal() . $output['html'];
    }
    
    // Convert the output and cookies into XML_RPC_Values
    if (count($output) > 0) {
        foreach ($output as $key => $value) {
            $output[$key] = new XML_RPC_Value($value, $XML_RPC_String);
        }
        $outputValue = new XML_RPC_Value($output, $XML_RPC_Struct);
    }
    if (count($cookieCache) > 0) {
        $cookies = array();
        foreach ($cookieCache as $key => $value) {
            $cookie = array();
            foreach ($value as $ikey => $ivalue) {
                $cookie[$ikey] = new XML_RPC_Value($ivalue, $XML_RPC_String);
            }
            $cookies[$key] = new XML_RPC_Value($cookie, $XML_RPC_Array);
        }
        $cookieValue = new XML_RPC_Value($cookies, $XML_RPC_Array);
    }
    // Return the output and cookies
    $returnArray = array();
    if (count($output) > 0) {
        $returnArray[] = $outputValue;
    } else {
        // Nothing to display
        $returnArray[] = new XML_RPC_Value();
    }
    if (count($cookieCache) > 0) {
        $returnArray[] = $cookieValue;
    } else {
        // No cookies to set
        $returnArray[] = new XML_RPC_Value();
    }
    $return = new XML_RPC_Value($returnArray, $XML_RPC_Array);
    return new XML_RPC_Response($return);
}

?>
