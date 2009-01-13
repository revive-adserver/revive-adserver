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

require_once MAX_PATH . '/lib/OA/Central.php';

/**
 * A class for testing the OA_Sync class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
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
