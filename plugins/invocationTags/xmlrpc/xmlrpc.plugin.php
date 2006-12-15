<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: xmlrpc.plugin.php 6108 2006-11-24 11:34:58Z andrew@m3.net $
*/

/**
 * @package    MaxPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 * @author     Andrew Hill <andrew@m3.net>
 *
 */

require_once MAX_PATH . '/plugins/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_xmlrpc_xmlrpc extends Plugins_InvocationTags
{

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('XML-RPC Tag', $this->module, $this->package);
    }

    /**
     * Return preference code
     *
     * @return string
     */
    function getPreferenceCode()
    {
        return 'allow_invocation_xmlrpc';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra)
    {
        $isAllowed = parent::isAllowed($extra);
        return $isAllowed;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    function getOptionsList()
    {
        $options = array (
            'spacer'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'what'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'campaignid'    => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'withtext'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'hostlanguage'  => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'xmlrpcproto'   => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'xmlrpctimeout' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        );

        return $options;
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    function generateInvocationCode()
    {
        parent::prepareCommonInvocationData();

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;
        $buffer = $mi->buffer;

        if (!isset($mi->clientid) || $mi->clientid == '') {
            $mi->clientid = 0;
        }
        if (!isset($mi->campaignid) || $mi->campaignid == '') {
            $mi->campaignid = 0;
        }
        if ($mi->xmlrpcproto) {
            $mi->params = parse_url(MAX_commonConstructSecureDeliveryUrl($conf['file']['xmlrpc']));
        } else {
            $mi->params = parse_url(MAX_commonConstructDeliveryUrl($conf['file']['xmlrpc']));
        }
        if (!$mi->xmlrpctimeout) {
            $mi->timeout = 15;
        } else {
            $mi->timeout = $mi->xmlrpctimeout;
        }
        switch($mi->hostlanguage) {
            case 'php':
            default:
                if (!isset($mi->what) or ($mi->what == "")) {
                    // Need to generate the waht variable here
                    if (isset($mi->zoneid) and ($mi->zoneid != "")) {
                        $mi->what = "zone:" . $mi->zoneid;
                    } elseif (isset($mi->campaignid) and ($mi->campaignid != "")) {
                        $mi->what = "campaignid:" . $mi->campaignid;
                    } elseif (isset($mi->bannerid) and ($mi->bannerid != "")) {
                        $mi->what = "bannerid:" . $mi->bannerid;
                    }
                }
                $buffer .= "<"."?php\n /*";
                $buffer .= MAX_Plugin_Translation::translate('Comment', $this->module, $this->package) . "\n\n";
                $buffer .= '    ini_set(\'include_path\', \'/usr/local/lib/php\');' . "\n";
                $buffer .= '    require_once \'XML/RPC.php\';' . "\n\n";
                $buffer .= '    global $XML_RPC_String, $XML_RPC_Boolean;' . "\n";
                $buffer .= '    global $XML_RPC_Array, $XML_RPC_Struct;' . "\n\n";
                $buffer .= '    // Create an XML-RPC client to talk to the XML-RPC server' . "\n";
                $buffer .= '    $client = new XML_RPC_Client(\'' . $mi->params['path'] . '\', \'' . $mi->params['host'] . '\'';
                if (isset($mi->params['port'])) {
                    $buffer .= ', \'' . $mi->params['port'] . '\'';
                }
                $buffer .= ');' . "\n\n";
                $buffer .= '    // A function to serialise cookie data' . "\n";
                $buffer .= '    function serialiseCookies($cookies = array())' . "\n";
                $buffer .= '    {' . "\n";
                $buffer .= '        global $XML_RPC_Struct;' . "\n";
                $buffer .= '        $array = array();' . "\n";
                $buffer .= '        foreach ($cookies as $key => $value) {' . "\n";
                $buffer .= '            if (is_array($value)) {' . "\n";
                $buffer .= '                $innerArray = serialiseCookies($value);' . "\n";
                $buffer .= '                $array[$key] = new XML_RPC_Value($innerArray, $XML_RPC_Struct);' . "\n";
                $buffer .= '            } else {' . "\n";
                $buffer .= '                $array[$key] = new XML_RPC_Value($value);' . "\n";
                $buffer .= '            }' . "\n";
                $buffer .= '        }' . "\n";
                $buffer .= '        return $array;' . "\n";
                $buffer .= '    }' . "\n\n";
                $buffer .= '    // Create the XML-RPC message' . "\n";
                $buffer .= '    $message = new XML_RPC_Message(\'max.view\', array());' . "\n\n";
                $buffer .= '    // Package the cookies into an array as XML_RPC_Values' . "\n";
                $buffer .= '    $cookiesStruct = serialiseCookies($_COOKIE);' . "\n";
                $buffer .= '    // Add the parameters to the message' . "\n";
                $buffer .= '    $message->addParam(new XML_RPC_Value(\'' . $mi->what . '\', $XML_RPC_String));' . "\n";
                $buffer .= '    $message->addParam(new XML_RPC_Value(\'' . $mi->target . '\', $XML_RPC_String));' . "\n";
                $buffer .= '    $message->addParam(new XML_RPC_Value(\'' . $mi->source . '\', $XML_RPC_String));' . "\n";
                $buffer .= '    $message->addParam(new XML_RPC_Value(\'' . $mi->withtext . '\', $XML_RPC_Boolean));' . "\n";
                $buffer .= '    $message->addParam(new XML_RPC_Value($_SERVER[\'REMOTE_ADDR\'], $XML_RPC_String));' . "\n";
                $buffer .= '    $message->addParam(new XML_RPC_Value($cookiesStruct, $XML_RPC_Struct));' . "\n\n";
                $buffer .= '    // Send the XML-RPC message to the server' . "\n";
                if ($mi->xmlrpcproto) {
                    $buffer .= '    $response = $client->send($message, ' . $mi->timeout . ', \'https\');' . "\n\n";
                } else {
                    $buffer .= '    $response = $client->send($message, ' . $mi->timeout . ', \'http\');' . "\n\n";
                }
                $buffer .= '    // Was a response received?' . "\n";
                $buffer .= '    if (!$response) {' . "\n";
                $buffer .= '        echo \'Error: No XML-RPC response\';' . "\n";
                $buffer .= '    }' . "\n\n";
                $buffer .= '    // Was a response an error?' . "\n";
                $buffer .= '    if ($response->faultCode() != 0) {' . "\n";
                $buffer .= '        echo \'Error: \' . $response->faultString();' . "\n";
                $buffer .= '    } else {' . "\n";
                $buffer .= '        // Ensure the response is an array' . "\n";
                $buffer .= '        $value = $response->value();' . "\n";
                $buffer .= '        if ($value->kindOf() != $XML_RPC_Array) {' . "\n";
                $buffer .= '            echo \'Error: Unexpected response value\';' . "\n";
                $buffer .= '        }' . "\n";
                $buffer .= '        // Store any cookies sent in the response' . "\n";
                $buffer .= '        $cookies = $value->arraymem(1);' . "\n";
                $buffer .= '        if ($cookies->kindOf() == $XML_RPC_Array) {' . "\n";
                $buffer .= '            $numCookies = $cookies->arraysize();' . "\n";
                $buffer .= '            // For each cookie...' . "\n";
                $buffer .= '            for ($counter = 0; $counter < $numCookies; $counter++) {' . "\n";
                $buffer .= '                $cookie = $cookies->arraymem($counter);' . "\n";
                $buffer .= '                if (($cookie->kindOf() == $XML_RPC_Array) && ($cookie->arraysize() == 3)) {' . "\n";
                $buffer .= '                    $cookieName  = $cookie->arraymem(0);' . "\n";
                $buffer .= '                    $cookieValue = $cookie->arraymem(1);' . "\n";
                $buffer .= '                    $cookieTime  = $cookie->arraymem(2);' . "\n";
                $buffer .= '                    setcookie($cookieName->scalarval(), $cookieValue->scalarval(), $cookieTime->scalarval());' . "\n";
                $buffer .= '                }' . "\n";
                $buffer .= '            }' . "\n";
                $buffer .= '        }' . "\n";
                $buffer .= '        // Store the ad in the ad array' . "\n";
                $buffer .= '        $advertisement = $value->arraymem(0);' . "\n";
                $buffer .= '        if ($advertisement->kindOf() == $XML_RPC_Struct) {' . "\n";
                $buffer .= '            $htmlValue = $advertisement->structmem(\'html\');' . "\n";
                $buffer .= '            $adArray[] = $htmlValue->scalarval();' . "\n";
                $buffer .= '        }' . "\n";
                $buffer .= '        // Example display code - remove before use' . "\n";
                $buffer .= '        if (isset($adArray)) {' . "\n";
                $buffer .= '            foreach ($adArray as $value) {' . "\n";
                $buffer .= '                echo $value;' . "\n";
                $buffer .= '            }' . "\n";
                $buffer .= '        }' . "\n";
                $buffer .= '    }' . "\n\n";
                $buffer .= "?".">\n";
                break;
        }

        return $buffer;
    }

}

?>