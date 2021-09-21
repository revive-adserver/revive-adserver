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

require_once MAX_PATH . '/lib/OA/XmlRpcClient.php';


/**
 * The base class which contains utility methods for OAC services
 *
 */
class OA_Central
{
    /**
     * A method to build the URLs from config variables
     *
     * If $aConf['port'] is checked first, otherwise the method will
     * use $aConf['httpPort'] or $aConf['httpsPort'] depending on the
     * value of $aConf['protocol']
     *
     * @param array $aConf
     * @param string $pathVariable
     * @return string
     * @static
     */
    public static function buildUrl($aConf, $pathVariable = 'path')
    {
        $port = '';
        if (!empty($aConf['port'])) {
            if (($aConf['protocol'] == 'http' && $aConf['port'] != 80) ||
                ($aConf['protocol'] == 'https' && $aConf['port'] != 443)) {
                $port = ':' . $aConf['port'];
            }
        } elseif ($aConf['protocol'] == 'http' && !empty($aConf['httpPort']) && $aConf['httpPort'] != 80) {
            $port = ':' . $aConf['httpPort'];
        } elseif ($aConf['protocol'] == 'https' && !empty($aConf['httpsPort']) && $aConf['httpsPort'] != 443) {
            $port = ':' . $aConf['httpsPort'];
        }

        return "{$aConf['protocol']}://{$aConf['host']}{$port}{$aConf[$pathVariable]}";
    }

    /**
     * A method to get an XML-RPC Client object from config variables
     *
     * @param array $aConf
     * @param string $pathVariable
     * @return OA_XML_RPC_Client
     * @static
     */
    public static function getXmlRpcClient($aConf, $pathVariable = 'path')
    {
        // Set default protocol and port
        if ($aConf['protocol'] == 'https') {
            // Can the XML-RPC client talk to the OpenX server via SSL?
            if (!self::canUseSSL()) {
                // No, so fall back to using plain HTTP for the connection
                $protocol = 'http';
                $port = $aConf['httpPort'];
            } else {
                // Yes, use SSL
                $protocol = 'https';
                $port = $aConf['httpsPort'];
            }
        } else {
            // Plain HTTP preferred in the configuration
            $protocol = 'http';
            $port = $aConf['httpPort'];
        }

        return new OA_XML_RPC_Client(
            $aConf[$pathVariable],
            "{$protocol}://{$aConf['host']}",
            $port
        );
    }

    /**
     * This should be a private static method, but the current test implementation
     * doesn't allow it to be declared as static
     *
     * @return boolean
     * @static
     */
    private static function canUseSSL()
    {
        return (bool)OA::getAvailableSSLExtensions();
    }
}
