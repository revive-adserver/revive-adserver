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

require_once MAX_PATH . '/lib/OA/Central.php';

/**
 * A class for testing the OA_Central class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_Central extends UnitTestCase
{
    function testBuildUrl()
    {
        $aConf = array(
            'protocol'  => 'http',
            'host'      => 'www.example.com',
            'path'      => '/foo',
            'httpPort'  => 80,
            'httpsPort' => 443,
        );

        $this->assertEqual('http://www.example.com/foo', OA_Central::buildUrl($aConf));

        $aConf['httpPort'] = 8080;
        $this->assertEqual('http://www.example.com:8080/foo', OA_Central::buildUrl($aConf));

        $aConf['protocol'] = 'https';
        $this->assertEqual('https://www.example.com/foo', OA_Central::buildUrl($aConf));

        $aConf['httpsPort'] = 4443;
        $this->assertEqual('https://www.example.com:4443/foo', OA_Central::buildUrl($aConf));

        $aConf['protocol'] = 'http';
        $aConf['port'] = 80;
        $this->assertEqual('http://www.example.com/foo', OA_Central::buildUrl($aConf));

        $aConf['protocol'] = 'https';
        $aConf['port'] = 443;
        $this->assertEqual('https://www.example.com/foo', OA_Central::buildUrl($aConf));

        $aConf['protocol'] = 'http';
        $aConf['port'] = 81;
        $this->assertEqual('http://www.example.com:81/foo', OA_Central::buildUrl($aConf));

        $aConf['path1'] = '/bar';
        $this->assertEqual('http://www.example.com:81/bar', OA_Central::buildUrl($aConf, 'path1'));
    }

    function testGetXmlRpcClient()
    {
        Mock::generatePartial(
            'OA_Central',
            'PartialMockOA_Central',
            array('canUseSSL')
        );

        $oCentral = new PartialMockOA_Central();
        $oCentral->setReturnValue('canUseSSL', true);

        $aConf = array(
            'protocol'  => 'https',
            'host'      => 'www.example.com',
            'path'      => '/foo',
            'httpPort'  => 80,
            'httpsPort' => 443,
        );

        $oClient = $oCentral->getXmlRpcClient($aConf);
        $this->assertTrue($oClient->protocol, 'ssl://');
        $this->assertTrue($oClient->port, 443);

        $oCentral->setReturnValue('canUseSSL', false);
        $oClient = $oCentral->getXmlRpcClient($aConf);
        $this->assertTrue($oClient->protocol, 'http://');
        $this->assertTrue($oClient->port, 80);
    }
}

?>
