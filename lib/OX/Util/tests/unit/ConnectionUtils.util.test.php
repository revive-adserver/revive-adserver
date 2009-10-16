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
$Id: mergeCopyTarget55229.tmp 42506 2009-09-02 09:33:27Z lukasz.wikierski $
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
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
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
