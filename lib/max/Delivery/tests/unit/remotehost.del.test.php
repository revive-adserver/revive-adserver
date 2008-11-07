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
        $serverSave = $_SERVER;

        // This $_SERVER dump was provided by a user running HAProxy
        $sampleSERVER = array (
            'HTTP_HOST' => 'max.i12.de',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.8.1.5) Gecko/20070718 Fedora/2.0.0.5-1.fc7 Firefox/2.0.0.5',
            'HTTP_ACCEPT' => 'text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
            'HTTP_ACCEPT_LANGUAGE' => 'en-gb,en;q=0.5',
            'HTTP_ACCEPT_ENCODING' => 'gzip,deflate',
            'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'HTTP_KEEP_ALIVE' => '300',
            'HTTP_COOKIE' => 'phpAds_id=abcdef1234567890acdef1234567890a',
            'HTTP_CONNECTION' => 'close',
            'PATH' => '/usr/bin:/bin:/usr/sbin:/sbin',
            'SERVER_SIGNATURE' => '<address>Apache/2.0.59 (Unix) Server at max.i12.de Port 80</address>',
            'SERVER_SOFTWARE' => 'Apache/2.0.59 (Unix)',
            'SERVER_NAME' => 'dev.openx.org',
            'SERVER_ADDR' => '10.0.0.1',
            'SERVER_PORT' => '80',
            'REMOTE_ADDR' => '10.0.0.2',
            'DOCUMENT_ROOT' => '/var/www/html/live-openads',
            'SERVER_ADMIN' => 'bugs@openads.org',
            'SCRIPT_FILENAME' => '/var/www/html/live-openads/lib/max/Delivery/tests/unit/remotehost.del.test.php',
            'REMOTE_PORT' => '49083',
            'GEOIP_CONTINENT_CODE' => '--',
            'GEOIP_COUNTRY_CODE' => '--',
            'GEOIP_COUNTRY_NAME' => 'N/A',
            'GEOIP_DMA_CODE' => '0',
            'GEOIP_AREA_CODE' => '0',
            'GEOIP_LATITUDE' => '0.000000',
            'GEOIP_LONGITUDE' => '0.000000',
            'GEOIP_ISP' => 'Nildram',
            'GATEWAY_INTERFACE' => 'CGI/1.1',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => '',
            'REQUEST_URI' => '/lib/max/Delivery/tests/unit/remotehost.del.test.php',
            'SCRIPT_NAME' => '/lib/max/Delivery/tests/unit/remotehost.del.test.php',
            'PHP_SELF' => '/lib/max/Delivery/tests/unit/remotehost.del.test.php',
            'REQUEST_TIME' => time(),
        );
        // I am unsure if this is a bug in OpenX or HAProxy, but the above dump does not contain
        // either an HTTP_VIA/REMOTE_HOST header, therefore OpenX assumes this is not proxied
        // I am adding it to "fix" the test

        $GLOBALS['_MAX']['CONF']['logging']['proxyLookup'] = true;

        // Check if just HTTP_VIA in the above array:
        $_SERVER = $sampleSERVER;
        $_SERVER['HTTP_VIA'] = '194.85.1.1 (Squid/2.4.STABLE7)';
        $_SERVER['HTTP_FORWARDED_FOR'] = '124.124.124.124';

        $return = MAX_remotehostProxyLookup();
        $this->assertTrue($_SERVER['REMOTE_ADDR'] == $_SERVER['HTTP_FORWARDED_FOR']);

        // Test with 'HTTP_X_FORWARDED_FOR' instead of via
        $_SERVER = $sampleSERVER;
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '125.125.125.125';

        $return = MAX_remotehostProxyLookup();
        $this->assertTrue($_SERVER['REMOTE_ADDR'] == $_SERVER['HTTP_X_FORWARDED_FOR']);

        // Check that if neither are set, then the remotehost lookup entry is performed
        $_SERVER = $sampleSERVER;
        $_SERVER['REMOTE_HOST'] = 'my.proxy.com';
        $_SERVER['HTTP_CLIENT_IP'] = '126.126.126.126';

        $return = MAX_remotehostProxyLookup();
        $this->assertTrue($_SERVER['REMOTE_ADDR'] == $_SERVER['HTTP_CLIENT_IP']);

        $_SERVER = $serverSave;
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
