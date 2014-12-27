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

require_once MAX_PATH . '/lib/OX/Util/ConnectionUtils.php';

class OX_Util_ConnectionUtilsMockup
    extends OX_Util_ConnectionUtils
{
    // method to set avaliable extension (for test purposes)
    public static function setAvailableSSLExtensions($aExtensions) {
        OX_Util_ConnectionUtils::$sslExtensions = $aExtensions;
    }
}

/**
 * A class for testing the ConnectionUtils
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class OX_Util_ConnectionUtilsTest extends UnitTestCase
{

    function testFactoryGetZendHttpClient()
    {
        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(array('curl'));
        try {
            $oZendHttpClient = OX_Util_ConnectionUtilsMockup::factoryGetZendHttpClient();
            $this->assertIsA($oZendHttpClient, 'Zend_Http_Client');
            // check if Zend_Http_Client contains Zend_Http_Client_Adapter_Curl
            $exportZendHttpClient = var_export($oZendHttpClient, true);
            $this->assertTrue(strpos($exportZendHttpClient, 'Zend_Http_Client_Adapter_Curl::__set_state'));
        } catch (Zend_Http_Client_Adapter_Exception $e) {
            // in case if cUrl isn't loaded
            $this->assertEqual($e->getMessage(), 'cURL extension has to be loaded to use this Zend_Http_Client adapter.');
        }

        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(array());
        $oZendHttpClient = OX_Util_ConnectionUtilsMockup::factoryGetZendHttpClient();
        $this->assertIsA($oZendHttpClient, 'Zend_Http_Client');
        // check if Zend_Http_Client doesn't contain Zend_Http_Client_Adapter_Curl
        $exportZendHttpClient = var_export($oZendHttpClient, true);
        $this->assertFalse(strpos($exportZendHttpClient, 'Zend_Http_Client_Adapter_Curl::__set_state'));
        $this->assertTrue(strpos($exportZendHttpClient, "'adapter' => 'Zend_Http_Client_Adapter_Socket'"));

        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(array('openssl', 'curl'));
        $oZendHttpClient = OX_Util_ConnectionUtilsMockup::factoryGetZendHttpClient();
        $this->assertIsA($oZendHttpClient, 'Zend_Http_Client');
        // check if Zend_Http_Client doesn't contain Zend_Http_Client_Adapter_Curl
        $exportZendHttpClient = var_export($oZendHttpClient, true);
        $this->assertFalse(strpos($exportZendHttpClient, 'Zend_Http_Client_Adapter_Curl::__set_state'));
        $this->assertTrue(strpos($exportZendHttpClient, "'adapter' => 'Zend_Http_Client_Adapter_Socket'"));

        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(false);
        $oZendHttpClient = OX_Util_ConnectionUtilsMockup::factoryGetZendHttpClient();
        $this->assertIsA($oZendHttpClient, 'Zend_Http_Client');
        // check if Zend_Http_Client doesn't contain Zend_Http_Client_Adapter_Curl
        $exportZendHttpClient = var_export($oZendHttpClient, true);
        $this->assertFalse(strpos($exportZendHttpClient, 'Zend_Http_Client_Adapter_Curl::__set_state'));
        $this->assertTrue(strpos($exportZendHttpClient, "'adapter' => 'Zend_Http_Client_Adapter_Socket'"));
    }

    function testIsSSLAvailable()
    {
        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(array('curl'));
        $this->assertTrue(OX_Util_ConnectionUtilsMockup::isSSLAvailable());
        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(array('openssl'));
        $this->assertTrue(OX_Util_ConnectionUtilsMockup::isSSLAvailable());
        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(array());
        $this->assertFalse(OX_Util_ConnectionUtilsMockup::isSSLAvailable());
        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(false);
        $this->assertFalse(OX_Util_ConnectionUtilsMockup::isSSLAvailable());
        OX_Util_ConnectionUtilsMockup::setAvailableSSLExtensions(array('openssl', 'curl'));
        $this->assertTrue(OX_Util_ConnectionUtilsMockup::isSSLAvailable());

    }
}

?>
