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
$Id: mergeCopyTarget55222.tmp 42386 2009-08-31 11:23:39Z lukasz.wikierski $
*/

require_once MAX_PATH . '/lib/OA.php';

/**
 * Hack
 * Unfortunately old market plugin have bundled Curl class, and if Curl class from core
 * gets loaded first, before marker plugin's copy, we get class redefinition error...
 */
@include_once MAX_PATH . '/www/admin/plugins/oxMarket/library/Zend/Http/Client/Adapter/Curl.php';
if (!class_exists('Zend_Http_Client_Adapter_Curl')) {
    require_once MAX_PATH . '/lib/Zend/Http/Client/Adapter/Curl.php';
}
require_once MAX_PATH . '/lib/Zend/Http/Client.php';

/**
 * A simple methods to get Zend Http Client (curl or openssl depending on php extensions),
 * check if php extensions allows to use ssl connection, 
 * and return lists of available SSL extensions
 *
 * @package    OpenX
 * @subpackage Util
 * @author     Lukasz Wikierski (lukasz.wikierski@openx.org)
 */
class OX_Util_ConnectionUtils 
{
    /**
     * Cached available SSL extensions array
     *
     * @var array
     */
    protected static $sslExtensions;
    
    /**
     * Get Zend_Http_Client with curl based adapter if 
     * there is no openssl extension and curl extension is loaded
     * Returns Zend_Http_Client with default adapter otherwise 
     * (so if there is a openssl extension, or non of ssl extension is loaded)
     *
     * @param bool $curlAllowAnyCertificate Should curl allow to connect using ssl without checking peer's certificate and host
     * @return Zend_Http_Client
     */
	static public function factoryGetZendHttpClient($curlAllowAnyCertificate = false)
	{
		$oZendHttpClient = new Zend_Http_Client();
		
		$aSslExtensions = self::getAvailableSSLExtensions();
		// get empty array if false
		$aSslExtensions = ($aSslExtensions) ? $aSslExtensions : array(); 
		$hasCurl    = in_array('curl', $aSslExtensions);
        $hasOpenssl = in_array('openssl', $aSslExtensions);
		if ($hasCurl && !$hasOpenssl) {
		    $oAdapter = new Zend_Http_Client_Adapter_Curl();
		    
		    $oAdapter->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);
		    // This CA file is also used in OA_XML_RPC_Client
		    $oAdapter->setCurlOption(CURLOPT_CAINFO, MAX_PATH . '/etc/curl-ca-bundle.crt');
		    if ($curlAllowAnyCertificate) {
                // Change curl option to turn off checking peer's host 
                $oAdapter->setCurlOption(CURLOPT_SSL_VERIFYHOST, false);
	        }
            
		    $oZendHttpClient->setAdapter($oAdapter);
		}
		
		return $oZendHttpClient;
	}
	
    /**
     * Check if SSL extensions (curl, openss) are available
     *
     * @return boolean
     */
    static public function isSSLAvailable() 
    {
        return (bool)self::getAvailableSSLExtensions();
    }
	
    /**
     * A method to detect the available SSL enabling extensions
     *
     * @return mixed An array of the available extensions, or false if none is present
     */
    static public function getAvailableSSLExtensions($forceReload = false)
    {
        if ($forceReload || !isset(self::$sslExtensions)) {
            self::$sslExtensions = OA::getAvailableSSLExtensions();
        }
        return self::$sslExtensions;   
    }
}

?>
