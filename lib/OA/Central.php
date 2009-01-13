<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once MAX_PATH . '/lib/OA/XmlRpcClient.php';

/**
 * OA Central error codes
 *
 */
define('OA_CENTRAL_ERROR_ERROR_NOT_AUTHENTICATED', 801);
define('OA_CENTRAL_ERROR_CAPTCHA_FAILED', 802);
define('OA_CENTRAL_ERROR_WRONG_PARAMETERS', 803);
define('OA_CENTRAL_ERROR_USERNAME_DOES_NOT_MATCH_PLATFORM', 804);
define('OA_CENTRAL_ERROR_PLATFORM_DOES_NOT_EXIST', 805);
define('OA_CENTRAL_ERROR_SERVER_ERROR', 806);
define('OA_CENTRAL_ERROR_ERROR_NOT_AUTHORIZED', 807);
define('OA_CENTRAL_ERROR_XML_RPC_VERSION_NOT_SUPPORTED', 808);
define('OA_CENTRAL_ERROR_TRANSPORT_ERROR_CODE', 900);

/**
 * OA Central M2M error codes
 *
 */
define('OA_CENTRAL_ERROR_M2M_ACCOUNT_TYPE_NOT_ALLOWED', 821);
define('OA_CENTRAL_ERROR_M2M_PASSWORD_ALREADY_GENERATED', 822);
define('OA_CENTRAL_ERROR_M2M_PASSWORD_INVALID', 823);
define('OA_CENTRAL_ERROR_M2M_PASSWORD_EXPIRED', 824);
define('OA_CENTRAL_ERROR_M2M_CANNOT_CONNECT', 825);
define('OA_CENTRAL_ERROR_M2M_CANNOT_RECONNECT', 826);

/**
 * OA Central SSO error codes
 *
 */
define('OA_CENTRAL_ERROR_SSO_USER_NOT_EXISTS', 701);
define('OA_CENTRAL_ERROR_SSO_INVALID_PASSWORD', 702);
define('OA_CENTRAL_ERROR_SSO_EMAIL_EXISTS', 703);
define('OA_CENTRAL_ERROR_SSO_INVALID_VER_HASH', 704);
define('OA_CENTRAL_ERROR_SSO_EMAIL_ALREADY_VERIFIED', 705);

define('OA_CENTRAL_ERROR_XML_RPC_CONNECTION_ERROR', 800);


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
    static public function buildUrl($aConf, $pathVariable = 'path')
    {
        $port = '';
        if (!empty($aConf['port'])) {
            if (($aConf['protocol'] == 'http' && $aConf['port'] != 80) ||
                ($aConf['protocol'] == 'https' && $aConf['port'] != 443)) {
                $port = ':'.$aConf['port'];
            }
        } else {
            if ($aConf['protocol'] == 'http' && !empty($aConf['httpPort']) && $aConf['httpPort'] != 80) {
                $port = ':'.$aConf['httpPort'];
            } elseif ($aConf['protocol'] == 'https' && !empty($aConf['httpsPort']) && $aConf['httpsPort'] != 443) {
                $port = ':'.$aConf['httpsPort'];
            }
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
    static public function getXmlRpcClient($aConf, $pathVariable = 'path')
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
    private function canUseSSL()
    {
        return (bool)OA::getAvailableSSLExtensions();
    }
}