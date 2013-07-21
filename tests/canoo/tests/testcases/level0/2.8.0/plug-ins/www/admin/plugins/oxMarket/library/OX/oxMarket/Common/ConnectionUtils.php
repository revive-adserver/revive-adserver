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

require_once MAX_PATH . '/lib/OA.php';
require_once OX_MARKET_LIB_PATH . '/Zend/Http/Client/Adapter/Curl.php';
require_once MAX_PATH . '/lib/Zend/Http/Client.php';

class OX_oxMarket_Common_ConnectionUtils
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
