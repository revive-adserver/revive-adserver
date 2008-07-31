<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/max/Delivery/log.php';
require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';

/**
 * A class for testing the log.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
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
     * A method to test the _viewersHostOkayToLog() function.
     */
    function test_viewersHostOkayToLog()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Save the $_SERVER so we don't affect other tests
        $serverSave = $_SERVER;

        // Set a fake, known IP address and host name
        $_SERVER['REMOTE_ADDR'] = '24.24.24.24';
        $_SERVER['REMOTE_HOST'] = '';
        // Disable reverse lookups
        $conf['logging']['reverseLookup'] = false;
        // Set no hosts to ignore
        $conf['logging']['ignoreHosts'] = '';
        // Test
        $this->assertTrue(_viewersHostOkayToLog());
        // Set different IP addresses to ignore
        $conf['logging']['ignoreHosts'] = '23.23.23.23,127.0.0.1';
        // Test
        $this->assertTrue(_viewersHostOkayToLog());
        // Set different and same IP addresses to ignore
        $conf['logging']['ignoreHosts'] = '23.23.23.23,24.24.24.24,127.0.0.1';
        // Test
        $this->assertFalse(_viewersHostOkayToLog());
        // Set a fake, known IP address and host name
        $_SERVER['REMOTE_ADDR'] = '24.24.24.24';
        $_SERVER['REMOTE_HOST'] = 'example.com';
        // Set different IP addresses to ignore
        $conf['logging']['ignoreHosts'] = '23.23.23.23,www.example.com,127.0.0.1';
        // Test
        $this->assertTrue(_viewersHostOkayToLog());
        // Set different and same IP addresses to ignore
        $conf['logging']['ignoreHosts'] = '23.23.23.23,example.com,127.0.0.1';
        // Test
        $this->assertFalse(_viewersHostOkayToLog());
        // Set a fake, known IP address and host name
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['REMOTE_HOST'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        // Enable revers lookups
        $conf['logging']['reverseLookup'] = true;
        // Set different IP addresses to ignore
        $conf['logging']['ignoreHosts'] = '23.23.23.23,example.com';
        // Test
        $this->assertTrue(_viewersHostOkayToLog());
        // Set a fake, known IP address and host name
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['REMOTE_HOST'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        // Set different and same IP addresses to ignore
        $conf['logging']['ignoreHosts'] = '23.23.23.23,' . gethostbyaddr($_SERVER['REMOTE_ADDR']);
        // Test
        $this->assertFalse(_viewersHostOkayToLog());

        // Reset the configuration
        TestEnv::restoreConfig();

        // Test the ignore/enforce User-Agent features
        $browserUserAgent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1) ';
        $botUserAgent = 'Yahoo! Slurp';

        // Nothing in either restriction list, should return true
        $conf['logging']['ignoreUserAgents']  = '';
        $conf['logging']['enforceUserAgents'] = '';

        // Empty user-agent
        $_SERVER['HTTP_USER_AGENT'] = '';
        $this->assertTrue(_viewersHostOkayToLog());
        // Valid user-agent:
        $_SERVER['HTTP_USER_AGENT'] = $browserUserAgent;
        $this->assertTrue(_viewersHostOkayToLog());
        // Bot
        $_SERVER['HTTP_USER_AGENT'] = $botUserAgent;
        $this->assertTrue(_viewersHostOkayToLog());

        // Enforce valid
        $conf['logging']['enforceUserAgents'] = $browserUserAgent;
        $conf['logging']['ignoreUserAgents']  = '';

        // Empty user-agent
        $_SERVER['HTTP_USER_AGENT'] = '';
        $this->assertFalse(_viewersHostOkayToLog());
        // Valid user-agent:
        $_SERVER['HTTP_USER_AGENT'] = $browserUserAgent;
        $this->assertTrue(_viewersHostOkayToLog());
        // Bot
        $_SERVER['HTTP_USER_AGENT'] = $botUserAgent;
        $this->assertFalse(_viewersHostOkayToLog());

        // Ignore bots
        $conf['logging']['enforceUserAgents'] = '';
        $conf['logging']['ignoreUserAgents']  = $botUserAgent;

        // Empty user-agent
        $_SERVER['HTTP_USER_AGENT'] = '';
        $this->assertTrue(_viewersHostOkayToLog());
        // Valid user-agent:
        $_SERVER['HTTP_USER_AGENT'] = $browserUserAgent;
        $this->assertTrue(_viewersHostOkayToLog());
        // Bot
        $_SERVER['HTTP_USER_AGENT'] = $botUserAgent;
        $this->assertFalse(_viewersHostOkayToLog());

        // Ignore bots
        $conf['logging']['enforceUserAgents'] = $browserUserAgent;
        $conf['logging']['ignoreUserAgents']  = $botUserAgent;

        // Empty user-agent
        $_SERVER['HTTP_USER_AGENT'] = '';
        $this->assertFalse(_viewersHostOkayToLog());
        // Valid user-agent:
        $_SERVER['HTTP_USER_AGENT'] = $browserUserAgent;
        $this->assertTrue(_viewersHostOkayToLog());
        // Bot
        $_SERVER['HTTP_USER_AGENT'] = $botUserAgent;
        $this->assertFalse(_viewersHostOkayToLog());

        // Check that valid and bot conf settings can be | delimited strings
        $conf['logging']['enforceUserAgents'] = 'BlackBerry|HotJava|' . $browserUserAgent . '|iCab';
        $conf['loggnig']['ignoreUserAgents']  = 'AdsBot-Google|ask+jeeves|' . $botUserAgent . '|YahooSeeker';

        // Empty user-agent
        $_SERVER['HTTP_USER_AGENT'] = '';
        $this->assertFalse(_viewersHostOkayToLog());
        // Valid user-agent:
        $_SERVER['HTTP_USER_AGENT'] = $browserUserAgent;
        $this->assertTrue(_viewersHostOkayToLog());
        // Bot
        $_SERVER['HTTP_USER_AGENT'] = $botUserAgent;
        $this->assertFalse(_viewersHostOkayToLog());

        // Reset the configuration
        TestEnv::restoreConfig();

        $_SERVER = $serverSave;
    }

    /**
     * A method to test the _prepareLogInfo() function.
     */
    function test_prepareLogInfo()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Prepare the test environment by setting the remove IP
        // address, removing the remote host name, referer,
        // user-agent, and channels
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        unset($_SERVER['REMOTE_HOST']);
        unset($_SERVER['HTTP_REFERER']);
        unset($_SERVER['HTTP_USER_AGENT']);
        unset($GLOBALS['_MAX']['CHANNELS']);

        // Set a non-SSL port
        $_SERVER['SERVER_PORT'] = 80;



        // Test 1: No geotargeting, no phpSniff and no page
        //         info logging
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = false;

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($zoneInfo as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 2: As for test one, BUT NOW WITH
        //         GEOTARGETING ENABLED, BUT NO
        //         GEO DATA AVAILABLE
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = true;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = false;

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($zoneInfo as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 3: As for test two, BUT NOW WITH
        //         GEO DATA AVAILABLE
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = true;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = false;

        // Set some geotargeting data
        $GLOBALS['_MAX']['CLIENT_GEO']['country_code']  = 'US';
        $GLOBALS['_MAX']['CLIENT_GEO']['country_name']  = 'United States';
        $GLOBALS['_MAX']['CLIENT_GEO']['region']        = 'VA';
        $GLOBALS['_MAX']['CLIENT_GEO']['city']          = 'Herndon';
        $GLOBALS['_MAX']['CLIENT_GEO']['postal_code']   = '20171';
        $GLOBALS['_MAX']['CLIENT_GEO']['latitude']      = '38.9252';
        $GLOBALS['_MAX']['CLIENT_GEO']['longitude']     = '-77.3928';
        $GLOBALS['_MAX']['CLIENT_GEO']['dma_code']      = '42';
        $GLOBALS['_MAX']['CLIENT_GEO']['area_code']     = '00';
        $GLOBALS['_MAX']['CLIENT_GEO']['organisation']  = 'Foo';
        $GLOBALS['_MAX']['CLIENT_GEO']['isp']           = 'Bar';
        $GLOBALS['_MAX']['CLIENT_GEO']['netspeed']      = 'Unknown';

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        $this->assertEqual($geotargeting['country_code'], 'US');
        $this->assertEqual($geotargeting['country_name'], 'United States');
        $this->assertEqual($geotargeting['region'],       'VA');
        $this->assertEqual($geotargeting['city'],         'Herndon');
        $this->assertEqual($geotargeting['postal_code'],  '20171');
        $this->assertEqual($geotargeting['latitude'],     '38.9252');
        $this->assertEqual($geotargeting['longitude'],    '-77.3928');
        $this->assertEqual($geotargeting['dma_code'],     '42');
        $this->assertEqual($geotargeting['area_code'],    '00');
        $this->assertEqual($geotargeting['organisation'], 'Foo');
        $this->assertEqual($geotargeting['isp'],          'Bar');
        $this->assertEqual($geotargeting['netspeed'],     'Unknown');
        foreach($zoneInfo as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 4: As for test one, BUT NOW WITH
        //         phpSniff ENABLED, BUT NO CLIENT
        //         DATA AVAILABLE
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = true;
        $conf['logging']['pageInfo']       = false;

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($zoneInfo as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 5: As for test four, BUT NOW WITH
        //         CLIENT DATA AVAILABLE
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = true;
        $conf['logging']['pageInfo']       = false;

        // Set some client data
        $GLOBALS['_MAX']['CLIENT']['os'] = '2k';
        $GLOBALS['_MAX']['CLIENT']['long_name'] = 'msie';
        $GLOBALS['_MAX']['CLIENT']['browser'] = 'ie';

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($zoneInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($userAgentInfo['os'], '2k');
        $this->assertEqual($userAgentInfo['long_name'], 'msie');
        $this->assertEqual($userAgentInfo['browser'], 'ie');
        $this->assertEqual($maxHttps, 0);



        // Test 6: As for test one, BUT NOW WITH
        //         pageInfo ENABLED, BUT NO LOC
        //         OR HTTP_REFERER DATA AVAILABLE
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = true;

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($zoneInfo as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 7: As for test six, BUT NOW WITH
        //         LOC DATA AVAILABLE
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = true;

        // Set a passed in referer location
        $_GET['loc'] = 'http://www.example.com/test.html';

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($zoneInfo['scheme'], 0);
        $this->assertEqual($zoneInfo['host'], 'www.example.com');
        $this->assertEqual($zoneInfo['path'], '/test.html');
        $this->assertNull($zoneInfo['query']);
        $this->assertNull($zoneInfo['channel_ids']);
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 8: As for test six, BUT NOW WITH
        //         HTTP_REFERER DATA AVAILABLE
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = true;

        // Unset the passed in referer location from before
        unset($_GET['loc']);

        // Set a normal referer location
        $_SERVER['HTTP_REFERER'] = 'https://example.com/test.php?foo=bar';

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($zoneInfo['scheme'], 1);
        $this->assertEqual($zoneInfo['host'], 'example.com');
        $this->assertEqual($zoneInfo['path'], '/test.php');
        $this->assertEqual($zoneInfo['query'], 'foo=bar');
        $this->assertNull($zoneInfo['channel_ids']);
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 9: As for test six, BUT NOW WITH
        //         LOC AND HTTP_REFERER DATA AVAILABLE
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = true;

        // Set a passed in referer location
        $_GET['loc'] = 'http://www.example.com/test.html';

        // Set a normal referer location
        $_SERVER['HTTP_REFERER'] = 'https://example.com/test.php?foo=bar';

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($zoneInfo['scheme'], 0);
        $this->assertEqual($zoneInfo['host'], 'www.example.com');
        $this->assertEqual($zoneInfo['path'], '/test.html');
        $this->assertNull($zoneInfo['query']);
        $this->assertNull($zoneInfo['channel_ids']);
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 10: As for test nine, BUT WITH CHANNEL
        //          ID VALUES SET
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = true;

        // Set an "array" of channel ids
        $GLOBALS['_MAX']['CHANNELS'] = '|1|2|3|';

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($zoneInfo['scheme'], 0);
        $this->assertEqual($zoneInfo['host'], 'www.example.com');
        $this->assertEqual($zoneInfo['path'], '/test.html');
        $this->assertNull($zoneInfo['query']);
        $this->assertEqual($zoneInfo['channel_ids'], '|1|2|3|');
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 0);



        // Test 11: As for test one, BUT WITH AN SSL
        //          SERVER PORT
        $conf['geotargeting']['type']      = null;
        $conf['geotargeting']['saveStats'] = false;
        $conf['logging']['sniff']          = false;
        $conf['logging']['pageInfo']       = false;

        // Set the server port
        $_SERVER['SERVER_PORT'] = $conf['openads']['sslPort'];

        // Ensure initialisation data preparation is done
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        MAX_remotehostSetClientInfo();
        MAX_remotehostSetGeoInfo();

        // Unset the result information variables
        unset($geotargeting);
        unset($zoneInfo);
        unset($userAgentInfo);
        $maxHttps = '';

        // Call _prepareLogInfo()
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();

        // Test the results
        $this->assertEqual($_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_ADDR']);
        foreach($geotargeting as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($zoneInfo as $check) {
            $this->assertTrue(empty($check));
        }
        foreach($userAgentInfo as $check) {
            $this->assertTrue(empty($check));
        }
        $this->assertEqual($maxHttps, 1);



        // Reset the configuration
        TestEnv::restoreConfig();
    }

    /**
     * A method to test the MAX_Delivery_log_getArrGetVariable() function.
     *
     * Requirements:
     * Test 1: Test with a bad config name, and ensure an empty array is returned.
     * Test 2: Test with no request value defined, and ensure an empty array is
     *         returned.
     * Test 3: Test with a request value defined, and ensure an array of that
     *         value is returned.
     * Test 4: Test with a "multiple item" request value defined, and ensure an
     *         array of the values is returned.
     */
    function test_MAX_Delivery_log_getArrGetVariable()
    {
        // Test 1
        $aReturn = MAX_Delivery_log_getArrGetVariable('foo');
        $this->assertTrue(is_array($aReturn));
        $this->assertTrue(empty($aReturn));

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['var']['blockAd'] = 'MAXBLOCK';
        unset($_GET['MAXBLOCK']);
        $aReturn = MAX_Delivery_log_getArrGetVariable('blockAd');
        $this->assertTrue(is_array($aReturn));
        $this->assertTrue(empty($aReturn));

        // Test 3
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['var']['blockAd'] = 'MAXBLOCK';
        $_GET['MAXBLOCK'] = 1;
        $aReturn = MAX_Delivery_log_getArrGetVariable('blockAd');
        $this->assertTrue(is_array($aReturn));
        $this->assertFalse(empty($aReturn));
        $this->assertEqual(count($aReturn), 1);
        $this->assertEqual($aReturn[0], 1);

        // Test 3
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['var']['blockAd'] = 'MAXBLOCK';
        $_GET['MAXBLOCK'] = 1 . $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'] . 5;
        $aReturn = MAX_Delivery_log_getArrGetVariable('blockAd');
        $this->assertTrue(is_array($aReturn));
        $this->assertFalse(empty($aReturn));
        $this->assertEqual(count($aReturn), 2);
        $this->assertEqual($aReturn[0], 1);
        $this->assertEqual($aReturn[1], 5);

        // Reset the configuration
        TestEnv::restoreConfig();
    }

    /**
     * A method to test the MAX_Delivery_log_ensureIntegerSet() function.
     *
     * Requirements:
     * Test 1: Test using something that is not an array, and ensure that
     *         array and value are set.
     * Test 2: Test with an array and nothing set, and ensure that value
     *         is set.
     * Test 3: Test with an array and integer set, and ensure nothing changed.
     * Test 4: Test with an array and string set, and ensure string converted.
     */
    function test_MAX_Delivery_log_ensureIntegerSet()
    {
        // Test 1
        $aArray = 'string';
        MAX_Delivery_log_ensureIntegerSet($aArray, 5);
        $this->assertTrue(is_array($aArray));
        $this->assertEqual(count($aArray), 1);
        $this->assertEqual($aArray[5], 0);

        // Test 2
        $aArray = array();
        MAX_Delivery_log_ensureIntegerSet($aArray, 5);
        $this->assertTrue(is_array($aArray));
        $this->assertEqual(count($aArray), 1);
        $this->assertEqual($aArray[5], 0);

        // Test 3
        $aArray = array();
        $aArray[5] = 10;
        MAX_Delivery_log_ensureIntegerSet($aArray, 5);
        $this->assertTrue(is_array($aArray));
        $this->assertEqual(count($aArray), 1);
        $this->assertEqual($aArray[5], 10);

        // Test 4
        $aArray = array();
        $aArray[5] = 'string';
        MAX_Delivery_log_ensureIntegerSet($aArray, 5);
        $this->assertTrue(is_array($aArray));
        $this->assertEqual(count($aArray), 1);
        $this->assertEqual($aArray[5], 0);
    }

}

?>
