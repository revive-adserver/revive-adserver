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

    /**
     * A method to test the MAX_Delivery_log_isClickBlocked() function.
     *
     * Requirements:
     * Test 1: Test with a 0 seconds click block looging window (block logging no active)
     *         and ensure that false is returned.
     * Test 2: Test with a click block looging window bigger than 0 seconds and an add
     *         not clicked yet, and ensure that false is returned.
     * Test 3: Test with a click block looging window bigger than 0 seconds and an add
     *         clicked that still in the click block logging window, and ensure that
     *         true is returned.
     * Test 4: Test with a click block looging window bigger than 0 seconds and an add
     *         clicked the same time ago that the click block logging window's lenght,
     *         and ensure that true is returned.
     * Test 5: Test with a click block looging window bigger than 0 seconds and an add
     *         clicked with the click block logging window expired, and ensure that
     *         false is returned.
     */
    function test_MAX_Delivery_log_isClickBlocked()
    {
        $timeNow = MAX_commonGetTimeNow();

        $add1ClickTime = MAX_commonCompressInt($timeNow - 60);
        $add3ClickTime = MAX_commonCompressInt($timeNow - 30);
        $add9ClickTime = MAX_commonCompressInt($timeNow - 15);

        $aBlockLoggingClick = array(
                                  1 => $add1ClickTime,
                                  3 => $add3ClickTime,
                                  9 => $add9ClickTime
                              );

        // Test 1
        $GLOBALS['conf']['logging']['blockAdClicksWindow'] = 0;
        $aReturn = MAX_Delivery_log_isClickBlocked(1, $aBlockLoggingClick);
        $this->assertTrue(!$aReturn);

        // Test 2
        $GLOBALS['conf']['logging']['blockAdClicksWindow'] = 30;
        $aReturn = MAX_Delivery_log_isClickBlocked(2, $aBlockLoggingClick);
        $this->assertTrue(!$aReturn);

        // Test 3
        $GLOBALS['conf']['logging']['blockAdClicksWindow'] = 30;
        $aReturn = MAX_Delivery_log_isClickBlocked(9, $aBlockLoggingClick);
        $this->assertTrue($aReturn);

        // Test 4
        $GLOBALS['conf']['logging']['blockAdClicksWindow'] = 30;
        $aReturn = MAX_Delivery_log_isClickBlocked(3, $aBlockLoggingClick);
        $this->assertTrue($aReturn);

        // Test 5
        $GLOBALS['conf']['logging']['blockAdClicksWindow'] = 30;
        $aReturn = MAX_Delivery_log_isClickBlocked(1, $aBlockLoggingClick);
        $this->assertTrue(!$aReturn);
    }

}

?>
