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
$Id$
*/

require_once MAX_PATH . '/lib/max/Delivery/log.php';
require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';

/**
 * A class for testing the log.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 *
 * @TODO Incomplete - needs DAL sorted out, so that simple creation/dropping
 *       of tables in the test database can be achieved.
 */
class Delivery_TestOfLog extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Delivery_TestOfLog()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the _viewersHostOkayToLog function.
     */
    function test_viewersHostOkayToLog()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];
        // Set a fake, known IP address and host name
        $_SERVER['REMOTE_ADDR'] = '24.24.24.24';
        $_SERVER['REMOTE_HOST'] = '';
        // Disable reverse lookups
        $conf['logging']['reverseLookup'] = false;
        // Set no hosts to ignore
        $conf['ignoreHosts'] = array();
        // Test
        $this->assertTrue(_viewersHostOkayToLog());
        // Set different IP addresses to ignore
        $conf['ignoreHosts'] = array('23.23.23.23', '127.0.0.1');
        // Test
        $this->assertTrue(_viewersHostOkayToLog());
        // Set different and same IP addresses to ignore
        $conf['ignoreHosts'] = array('23.23.23.23', '24.24.24.24', '127.0.0.1');
        // Test
        $this->assertFalse(_viewersHostOkayToLog());
        // Set a fake, known IP address and host name
        $_SERVER['REMOTE_ADDR'] = '24.24.24.24';
        $_SERVER['REMOTE_HOST'] = 'example.com';
        // Set different IP addresses to ignore
        $conf['ignoreHosts'] = array('23.23.23.23', 'www.example.com', '127.0.0.1');
        // Test
        $this->assertTrue(_viewersHostOkayToLog());
        // Set different and same IP addresses to ignore
        $conf['ignoreHosts'] = array('23.23.23.23', 'example.com', '127.0.0.1');
        // Test
        $this->assertFalse(_viewersHostOkayToLog());
        // Set a fake, known IP address and host name
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['REMOTE_HOST'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        // Enable revers lookups
        $conf['logging']['reverseLookup'] = true;
        // Set different IP addresses to ignore
        $conf['ignoreHosts'] = array('23.23.23.23', 'example.com');
        // Test
        $this->assertTrue(_viewersHostOkayToLog());
        // Set a fake, known IP address and host name
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['REMOTE_HOST'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        // Set different and same IP addresses to ignore
        $conf['ignoreHosts'] = array('23.23.23.23', gethostbyaddr($_SERVER['REMOTE_ADDR']));
        // Test
        $this->assertFalse(_viewersHostOkayToLog());
    }

    /**
     * Test the _prepareLogInfo function.
     */
    function test_prepareLogInfo()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];
        // Disable reverse lookups
        $conf['logging']['reverseLookup'] = false;
        // Disable geotargeting
        $conf['geotargeting']['type'] = false;
        // Disable sniffing
        $conf['logging']['sniff'] = false;
        // Set the remote IP address
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        // Unset the remote host name
        unset($_SERVER['REMOTE_HOST']);
        // Unset the HTTP referer
        unset($_SERVER['HTTP_REFERER']);
        // Unset the user agent
        unset($_SERVER['HTTP_USER_AGENT']);
        // Set a non-SSL port
        $_SERVER['SERVER_PORT'] = 80;
        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();
        // Test
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        $this->assertEqual(count($geotargeting), 0);
        $this->assertEqual(count($zoneInfo), 0);
        $this->assertEqual(count($userAgentInfo), 0);
        $this->assertEqual($maxHttps, 0);
        // Enable reverse lookups
        $conf['logging']['reverseLookup'] = true;
        // Unset the remote host name
        unset($_SERVER['REMOTE_HOST']);
        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();
        // Test
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $this->assertEqual($_SERVER['REMOTE_HOST'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->assertEqual(count($geotargeting), 0);
        $this->assertEqual(count($zoneInfo), 0);
        $this->assertEqual(count($userAgentInfo), 0);
        $this->assertEqual($maxHttps, 0);
        // Enable geotargeting
        $conf['geotargeting']['saveStats'] = 'true';
        // Set some fake geotargeting info
        $GLOBALS['_MAX']['CLIENT_GEO']['country_code'] = 'US';
        $GLOBALS['_MAX']['CLIENT_GEO']['country_name'] = 'United States';
        $GLOBALS['_MAX']['CLIENT_GEO']['region'] = 'VA';
        $GLOBALS['_MAX']['CLIENT_GEO']['city'] = 'Herndon';
        $GLOBALS['_MAX']['CLIENT_GEO']['postal_code'] = '20171';
        $GLOBALS['_MAX']['CLIENT_GEO']['latitude'] = '38.9252';
        $GLOBALS['_MAX']['CLIENT_GEO']['longitude'] = '-77.3928';
        $GLOBALS['_MAX']['CLIENT_GEO']['dma_code'] = '42';
        $GLOBALS['_MAX']['CLIENT_GEO']['area_code'] = '00';
        $GLOBALS['_MAX']['CLIENT_GEO']['organisation'] = 'Foo';
        $GLOBALS['_MAX']['CLIENT_GEO']['isp'] = 'Bar';
        $GLOBALS['_MAX']['CLIENT_GEO']['netspeed'] = 'Unknown';
        // Test
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $this->assertEqual($_SERVER['REMOTE_HOST'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->assertEqual($geotargeting['country_code'], 'US');
        $this->assertEqual($geotargeting['country_name'], 'United States');
        $this->assertEqual($geotargeting['region'], 'VA');
        $this->assertEqual($geotargeting['city'], 'Herndon');
        $this->assertEqual($geotargeting['postal_code'], '20171');
        $this->assertEqual($geotargeting['latitude'], '38.9252');
        $this->assertEqual($geotargeting['longitude'], '-77.3928');
        $this->assertEqual($geotargeting['dma_code'], '42');
        $this->assertEqual($geotargeting['area_code'], '00');
        $this->assertEqual($geotargeting['organisation'], 'Foo');
        $this->assertEqual($geotargeting['isp'], 'Bar');
        $this->assertEqual($geotargeting['netspeed'], 'Unknown');
        $this->assertEqual(count($zoneInfo), 0);
        $this->assertEqual(count($userAgentInfo), 0);
        $this->assertEqual($maxHttps, 0);
        // Set a passed in referer location
        $_GET['loc'] = 'http://www.example.com/test.html';
        // Test
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $this->assertEqual($_SERVER['REMOTE_HOST'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->assertEqual($geotargeting['country_code'], 'US');
        $this->assertEqual($geotargeting['country_name'], 'United States');
        $this->assertEqual($geotargeting['region'], 'VA');
        $this->assertEqual($geotargeting['city'], 'Herndon');
        $this->assertEqual($geotargeting['postal_code'], '20171');
        $this->assertEqual($geotargeting['latitude'], '38.9252');
        $this->assertEqual($geotargeting['longitude'], '-77.3928');
        $this->assertEqual($geotargeting['dma_code'], '42');
        $this->assertEqual($geotargeting['area_code'], '00');
        $this->assertEqual($geotargeting['organisation'], 'Foo');
        $this->assertEqual($geotargeting['isp'], 'Bar');
        $this->assertEqual($geotargeting['netspeed'], 'Unknown');
        $this->assertEqual($zoneInfo['scheme'], 0);
        $this->assertEqual($zoneInfo['host'], 'www.example.com');
        $this->assertEqual($zoneInfo['path'], '/test.html');
        $this->assertNull($zoneInfo['query']);
        $this->assertEqual(count($userAgentInfo), 0);
        $this->assertEqual($maxHttps, 0);
        // Set a passed in referer location
        $_GET['loc'] = 'http://www.example.com/test.html';
        // Test
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $this->assertEqual($_SERVER['REMOTE_HOST'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->assertEqual($geotargeting['country_code'], 'US');
        $this->assertEqual($geotargeting['country_name'], 'United States');
        $this->assertEqual($geotargeting['region'], 'VA');
        $this->assertEqual($geotargeting['city'], 'Herndon');
        $this->assertEqual($geotargeting['postal_code'], '20171');
        $this->assertEqual($geotargeting['latitude'], '38.9252');
        $this->assertEqual($geotargeting['longitude'], '-77.3928');
        $this->assertEqual($geotargeting['dma_code'], '42');
        $this->assertEqual($geotargeting['area_code'], '00');
        $this->assertEqual($geotargeting['organisation'], 'Foo');
        $this->assertEqual($geotargeting['isp'], 'Bar');
        $this->assertEqual($geotargeting['netspeed'], 'Unknown');
        $this->assertEqual($zoneInfo['scheme'], 0);
        $this->assertEqual($zoneInfo['host'], 'www.example.com');
        $this->assertEqual($zoneInfo['path'], '/test.html');
        $this->assertNull($zoneInfo['query']);
        $this->assertEqual(count($userAgentInfo), 0);
        $this->assertEqual($maxHttps, 0);
        // Test
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        unset($_GET['loc']);
        $maxHttps = '';
        
        // Set a normal referer
        $_SERVER['HTTP_REFERER'] = 'https://example.com/test.php?foo=bar';
        
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $this->assertEqual($_SERVER['REMOTE_HOST'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->assertEqual($geotargeting['country_code'], 'US');
        $this->assertEqual($geotargeting['country_name'], 'United States');
        $this->assertEqual($geotargeting['region'], 'VA');
        $this->assertEqual($geotargeting['city'], 'Herndon');
        $this->assertEqual($geotargeting['postal_code'], '20171');
        $this->assertEqual($geotargeting['latitude'], '38.9252');
        $this->assertEqual($geotargeting['longitude'], '-77.3928');
        $this->assertEqual($geotargeting['dma_code'], '42');
        $this->assertEqual($geotargeting['area_code'], '00');
        $this->assertEqual($geotargeting['organisation'], 'Foo');
        $this->assertEqual($geotargeting['isp'], 'Bar');
        $this->assertEqual($geotargeting['netspeed'], 'Unknown');
        $this->assertEqual($zoneInfo['scheme'], 1);
        $this->assertEqual($zoneInfo['host'], 'example.com');
        $this->assertEqual($zoneInfo['path'], '/test.php');
        $this->assertEqual($zoneInfo['query'], 'foo=bar');
        $this->assertEqual(count($userAgentInfo), 0);
        $this->assertEqual($maxHttps, 0);
        // Enable sniffing
        $conf['logging']['sniff'] = true;
        // Set the client parameters...
        $GLOBALS['_MAX']['CLIENT']['os'] = '2k';
        $GLOBALS['_MAX']['CLIENT']['long_name'] = 'msie';
        $GLOBALS['_MAX']['CLIENT']['browser'] = 'ie';
        // Test
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $this->assertEqual($_SERVER['REMOTE_HOST'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->assertEqual($geotargeting['country_code'], 'US');
        $this->assertEqual($geotargeting['country_name'], 'United States');
        $this->assertEqual($geotargeting['region'], 'VA');
        $this->assertEqual($geotargeting['city'], 'Herndon');
        $this->assertEqual($geotargeting['postal_code'], '20171');
        $this->assertEqual($geotargeting['latitude'], '38.9252');
        $this->assertEqual($geotargeting['longitude'], '-77.3928');
        $this->assertEqual($geotargeting['dma_code'], '42');
        $this->assertEqual($geotargeting['area_code'], '00');
        $this->assertEqual($geotargeting['organisation'], 'Foo');
        $this->assertEqual($geotargeting['isp'], 'Bar');
        $this->assertEqual($geotargeting['netspeed'], 'Unknown');
        $this->assertEqual($zoneInfo['scheme'], 1);
        $this->assertEqual($zoneInfo['host'], 'example.com');
        $this->assertEqual($zoneInfo['path'], '/test.php');
        $this->assertEqual($zoneInfo['query'], 'foo=bar');
        $this->assertEqual($userAgentInfo['os'], '2k');
        $this->assertEqual($userAgentInfo['long_name'], 'msie');
        $this->assertEqual($userAgentInfo['browser'], 'ie');
        $this->assertEqual($maxHttps, 0);
        // Set the request to be "HTTPS"
        $_SERVER['SERVER_PORT'] = $conf['max']['sslPort'];
        // Test
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $this->assertEqual($_SERVER['REMOTE_HOST'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->assertEqual($geotargeting['country_code'], 'US');
        $this->assertEqual($geotargeting['country_name'], 'United States');
        $this->assertEqual($geotargeting['region'], 'VA');
        $this->assertEqual($geotargeting['city'], 'Herndon');
        $this->assertEqual($geotargeting['postal_code'], '20171');
        $this->assertEqual($geotargeting['latitude'], '38.9252');
        $this->assertEqual($geotargeting['longitude'], '-77.3928');
        $this->assertEqual($geotargeting['dma_code'], '42');
        $this->assertEqual($geotargeting['area_code'], '00');
        $this->assertEqual($geotargeting['organisation'], 'Foo');
        $this->assertEqual($geotargeting['isp'], 'Bar');
        $this->assertEqual($geotargeting['netspeed'], 'Unknown');
        $this->assertEqual($zoneInfo['scheme'], 1);
        $this->assertEqual($zoneInfo['host'], 'example.com');
        $this->assertEqual($zoneInfo['path'], '/test.php');
        $this->assertEqual($zoneInfo['query'], 'foo=bar');
        $this->assertEqual($userAgentInfo['os'], '2k');
        $this->assertEqual($userAgentInfo['long_name'], 'msie');
        $this->assertEqual($userAgentInfo['browser'], 'ie');
        $this->assertEqual($maxHttps, 1);
    }

    /**
     * Test the _insertRawData function.
     */
    function test_insertRawData()
    {

    }

    /**
     * Test the MAX_logAdRequest function.
     */
    function testMAX_logAdRequest()
    {

    }

    /**
     * Test the MAX_logAdImpression function.
     */
    function testMAX_logAdImpression()
    {

    }

    /**
     * Test the MAX_logAdClick function.
     */
    function testMAX_logAdClick()
    {

    }

    /**
     * Test the MAX_logTrackerImpression function.
     */
    function testMAX_logTrackerImpression()
    {

    }

    /**
     * Test the MAX_logVariableValues function.
     */
    function testMAX_logVariableValues()
    {

    }

    /**
     * Test the MAX_logTrackerClick function.
     */
    function testMAX_logTrackerClick()
    {

    }

    /**
     * Test the MAX_logBenchmark function.
     */
    function testMAX_logBenchmark()
    {

    }

}

?>
