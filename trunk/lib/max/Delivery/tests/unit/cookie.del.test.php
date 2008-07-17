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
$Id: log.del.test.php 6456 2007-05-15 03:57:27Z aj@seagullproject.org $
*/

require_once MAX_PATH . '/lib/max/Delivery/cookie.php';

/**
 * A class for testing the cookie.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Chris Nutting <chris.nutting@openx.org>
 */
class Delivery_TestOfCookie extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Delivery_TestOfCookie()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the MAX_cookieAdd() function.
     *
     * This function does not output cookies, instead it sets a global cookie array or ads to it if it exists
     *
     */
    function test_MAX_cookieAdd()
    {
        //Unset the cookie cache array
        unset($GLOBALS['_MAX']['COOKIE']['CACHE']);
        // Set a test cookie
        MAX_cookieAdd('test', 'test');

        $this->assertIsA($GLOBALS['_MAX']['COOKIE']['CACHE']['test'], 'array');
        $this->assertEqual($GLOBALS['_MAX']['COOKIE']['CACHE']['test'][0], 'test');
        $this->assertEqual($GLOBALS['_MAX']['COOKIE']['CACHE']['test'][1], 0);

        unset($GLOBALS['_MAX']['COOKIE']['CACHE']);
        // Set a test cookie with an expiry time
        MAX_cookieAdd('test', 'test', 60);
        $this->assertIsA($GLOBALS['_MAX']['COOKIE']['CACHE']['test'], 'array');
        $this->assertEqual($GLOBALS['_MAX']['COOKIE']['CACHE']['test'][0], 'test');
        $this->assertEqual($GLOBALS['_MAX']['COOKIE']['CACHE']['test'][1], 60);
    }

    /**
     * This function shoud get the viewerID from the cookie value if present, otherwise it should
     * create a new viewerId
     *
     */
    function test_MAX_cookieGetUniqueViewerID()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];

        // Test that the value is pulled from the $_COOKIE array if set
        // With marketplace disabled, anything should be ok
        $conf['marketplace']['enabled'] = 0;
        $_COOKIE[$conf['var']['viewerId']] = 'TEST';
        $this->assertEqual(MAX_cookieGetUniqueViewerID(), 'TEST');

        // Test that the value is pulled from the $_COOKIE array if set
        // With marketplace enabled, only UUIDs are ok
        $conf['marketplace']['enabled'] = 1;
        $this->assertNull(MAX_cookieGetUniqueViewerID());
        $_COOKIE[$conf['var']['viewerId']] = 'deadf00d-dead-f00d-dead-f00ddeadf00d';
        $this->assertEqual(MAX_cookieGetUniqueViewerID(), 'deadf00d-dead-f00d-dead-f00ddeadf00d');

        // Test that the a value is not set if $create=false
        unset($_COOKIE[$conf['var']['viewerId']]);
        $this->assertFalse(MAX_cookieGetUniqueViewerID(false));

        // Test that a valid viewer ID is created if $create is not passed in
        unset($_COOKIE[$conf['var']['viewerId']]);
        $viewerId = MAX_cookieGetUniqueViewerID();
        $this->assertIsA($viewerId, 'string');
        $this->assertTrue(strlen($viewerId) == 32);

        // Test that a valid viewer ID is created if $create is set to true
        unset($_COOKIE[$conf['var']['viewerId']]);
        $viewerId = MAX_cookieGetUniqueViewerID(true);
        $this->assertIsA($viewerId, 'string');
        $this->assertTrue(strlen($viewerId) == 32);

    }

    /**
     * Test that the P3P headers are generated correctly
     *
     */
    function test_MAX_cookieSendP3PHeaders()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];

        // Test that nothing is set if the p3p policy setting is set to false
        $conf['p3p']['policies'] = false;
        unset($GLOBALS['_HEADERS']);
        MAX_cookieSendP3PHeaders();
        $this->assertNull($GLOBALS['_HEADERS']);

        // Test that the p3p header is set correctly if p3p policies is set
        $conf['p3p']['policies'] = true;
        $p3p = _generateP3PHeader();
        unset($GLOBALS['_HEADERS']);
        MAX_cookieSendP3PHeaders();
        $this->assertIsA($GLOBALS['_HEADERS'], 'array');
        $this->assertEqual($GLOBALS['_HEADERS'][0], "P3P: " . $p3p);

    }

    /**
     * Test that the P3P string to be put into the P3P header is generated correctly
     *
     */
    function test_generateP3PHeader()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];

        // Test that nothing is generated if $conf['p3p']['policies'] is false
        $conf['p3p']['policies'] = false;
        $this->assertEqual(_generateP3PHeader(), '');

        // Test that the compact policy header is generated correctly with a compact policy
        // and a policyLocation
        $conf['p3p']['policies'] = true;
        $conf['p3p']['compactPolicy'] = 'CUR ADM OUR NOR STA NID';
        $conf['p3p']['policyLocation'] = 'http://www.openx.org/policy.xml';
        $this->assertEqual(_generateP3PHeader(), ' policyref="' . $conf['p3p']['policyLocation'] .'",  CP="' . $conf['p3p']['compactPolicy'] . '"');

        // Test that the compact policy header is generated correctly with just a compact policy
        $conf['p3p']['policies'] = true;
        $conf['p3p']['compactPolicy'] = 'CUR ADM OUR NOR STA NID';
        $conf['p3p']['policyLocation'] = '';
        $this->assertEqual(_generateP3PHeader(), ' CP="' . $conf['p3p']['compactPolicy'] . '"');

        // Test that the compact policy header is generated correctly with just a policy location
        $conf['p3p']['policies'] = true;
        $conf['p3p']['compactPolicy'] = '';
        $conf['p3p']['policyLocation'] = 'http://www.openx.org/policy.xml';
        $this->assertEqual(_generateP3PHeader(), ' policyref="' . $conf['p3p']['policyLocation'] . '"');

        // Test that the compact policy header is not generated without either policy location or compact policy
        $conf['p3p']['policies'] = true;
        $conf['p3p']['compactPolicy'] = '';
        $conf['p3p']['policyLocation'] = '';
        $this->assertEqual(_generateP3PHeader(), '');
    }

    /**
     * This function should take a viewerID and set this in a cookie, and then send a header redirect
     * To self with the additional querystring parameter "ct=1" (cookieTest = 1) to indicate that a
     *
     */
    function test_MAX_cookieAddViewerIdAndRedirect() {
        $conf =& $GLOBALS['_MAX']['CONF'];
        // Disable the p3p policies because those are tested elsewhere and we need the redirect header to be [0]
        $conf['p3p']['policies'] = false;
        // Generate a clean viewerId
        unset($_COOKIE[$conf['var']['viewerId']]);
        $viewerId = MAX_cookieGetUniqueViewerID(true);

        // I know I've tested this elsewhere in the file, but sanity check that we have a valid viewerId
        $this->assertIsA($viewerId, 'string');
        $this->assertEqual(strlen($viewerId), 32);

        // Ensure that calling MAX_cookieSetViewerIdAndRedirect($viewerId) sets and flushes the viewerId cookie and redirects
        unset($GLOBALS['_HEADERS']);
        $_SERVER['SERVER_PORT'] = 80;
        $_SERVER['PHP_SELF'] = 'tests/index.php';
        $_SERVER['QUERY_STRING'] = 'test=1&toast=2';

        MAX_cookieSetViewerIdAndRedirect($viewerId);
        $this->assertEqual($_COOKIE[$conf['var']['viewerId']], $viewerId);
        // Ensure that the redirect header is set
        $this->assertIsA($GLOBALS['_HEADERS'][0], 'string');
        $this->assertTrue(preg_match('#^Location: http:\/\/.*'.$conf['var']['cookieTest'].'=1.*$#', $GLOBALS['_HEADERS'][0]));
    }

    function test_MAX_cookieFlush()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];

        // The cookieFluch function requires variables which are initialised in common.php
        MAX_commonInitVariables();
        // Test that a very long cookie is truncated to below the 2048 character limit.

        $_COOKIE[$conf['var']['blockAd']] = array();
        for ($i = 0; $i < 1000; $i++) {
            $_COOKIE[$conf['var']['blockAd']][$i] = time();
        }
        $_COOKIE['_' . $conf['var']['blockAd']][$i++] = time();
        MAX_cookieFlush();
        $this->assertTrue(strlen($_COOKIE[$conf['var']['blockAd']]) < 2048);
    }

    function test_getTimeThirtyDaysFromNow()
    {

    }

    function test_getTimeYearFromNow()
    {

    }

    function test_getTimeYearAgo()
    {

    }

    function test_MAX_cookieUnpackCapping()
    {

    }

    function test_isBlockCookie()
    {

    }

    function test_MAX_cookieGetCookielessViewerID()
    {

    }

    function test_MAX_Delivery_cookie_setCapping()
    {

    }
}
?>
