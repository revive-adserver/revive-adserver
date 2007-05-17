<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';

/**
 * A class for testing the remoteshost.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class test_DeliveryRemotehost extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function test_DeliveryRemotehost()
    {
        $this->UnitTestCase();
    }


    /**
     * @todo future test case
     * A function to convert the $_SERVER['REMOTE_ADDR'] global variable
     * from the current value to the real remote viewer's value, should
     * that viewer be coming via an HTTP proxy.
     *
     * Only performs this conversion if the option to do so is set in the
     * configuration file.
     */
    function test_MAX_remotehostProxyLookup()
    {
        $return = MAX_remotehostProxyLookup();
        $this->assertTrue(true);
    }

    /**
     * @todo future test case
     * A function to perform a reverse lookup of the hostname from the IP address,
     * and store the result in the $_SERVER['REMOTE_HOST'] global variable.
     *
     * Only performs the reverse lookup if the option is set in the configuration,
     * and if the host name is not already present. If the the host name is not
     * present and the option to perform the lookup is not set, then the host name
     * is set to the remote IP address instead.
     */
    function test_MAX_remotehostReverseLookup()
    {
        $return = MAX_remotehostReverseLookup();
        $this->assertTrue(true);
    }

    /**
     *@todo test case for different user agents
     *
     * A function to set the viewer's useragent information in the
     * $GLOBALS['_MAX']['CLIENT'] global variable, if the option to use
     * phpSniff to extract useragent information is set in the
     * configuration file.
     */
    function test_MAX_remotehostSetClientInfo()
    {
        $GLOBALS['_MAX']['CONF']['logging']['sniff'] = true;
        $http_user_agent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.8)' .
                           ' Gecko/20061109 CentOS/1.5.0.8-0.1.el4.centos4 Firefox/1.5.0.8 pango-text';
        $_SERVER['HTTP_USER_AGENT'] = $http_user_agent;
        MAX_remotehostSetClientInfo();
        $this->assertIsA($GLOBALS['_MAX']['CLIENT'], 'array');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['browser'], 'fx');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['cookies'], 'Unknown');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['gecko'], '20061109');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['gecko_ver'], '1.8.0.8');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['javascript'], '1.5');
        // Not testing the language result from phpSniff, as always seems to
        // add en-us when testing via the web browser...
        // $this->assertEqual($GLOBALS['_MAX']['CLIENT']['language'], 'en-us,en');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['long_name'], 'firefox');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['maj_ver'], '1');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['min_ver'], '.5.0.8');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['os'], 'linux');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['platform'], '*nix');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['ss_cookies'], 'Unknown');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['st_cookies'], 'Unknown');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['ua'], strtolower($http_user_agent));
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['version'], '1.5.0.8');
    }

    /**
     * @todo concerns a plugin
     *
     * A function to set the viewer's geotargeting information in the
     * $GLOBALS['_MAX']['CLIENT_GEO'] global variable, if a plugin for
     * geotargeting information is configured.
     *
     * @todo This is a workaround to avoid having to include the entire plugin architecure
     *       just to be able to load the config information. The plugin system should be
     *       refactored to allow the Delivery Engine to load the information independently
     */
    function test_MAX_remotehostSetGeoInfo()
    {
        $return = MAX_remotehostSetGeoInfo();
        $this->assertTrue(true);
    }

    /**
     * A function to determine if a given IP address is in a private network or
     * not.
     *
     * @param string $ip The IP address to check.
     * @return boolean Returns true if the IP address is in a private network,
     *                 false otherwise.
     */
    function test_MAX_remotehostPrivateAddress()
    {
        $return = MAX_remotehostPrivateAddress('127.0.0.1');
        $this->assertTrue($return);
        $return = MAX_remotehostPrivateAddress('235.0.0.66');
        $this->assertFalse($return);
    }
}

?>
