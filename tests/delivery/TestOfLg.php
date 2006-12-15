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
$Id: TestOfLg.php 5698 2006-10-12 16:16:22Z chris@m3.net $
*/

/**
 * A class for testing lg.php.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Scott Switzer <scott@switzer.org>
 * @TODO Incomplete.
 */
class Delivery_TestOfLg extends WebTestCase
{
    
    /**
     * The constructor method.
     */
    function Delivery_TestOfLg()
    {        
        $this->WebTestCase();
    }
    
    /**
     * Test Alg.php with different parameters.
     * @TODO:  Test that adlog inserts a row into the raw DB
     * @TODO:  Test that when viewing is turned off, a row is NOT inserted in the DB
     * @TODO:  Test that when proxy is turned on, that the proxy IP address environment variable is stored in the DB instead of the REMOTE_HOST IP address
     * @TODO:  Test that each value in the environmental variables get put into the DB correctly.
     * @TODO:  Test SSL vs. non-SSL
     */
    function test_Log()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // 1.  Test that any request gets an image
        $this->createBrowser();
        $adlogUrl = MAX_commonConstructDeliveryUrl($conf['file']['log']);
        $this->get($adlogUrl);
        $this->assertResponse(200);
        $this->assertHeader('Content-Type','image/gif');
        // 2.  Test that a capped ad gets incremented and logged
        $this->createBrowser();
        $this->setCookie("{$conf['var']['capAd']}[1]", '0');
                
        $adlogUrl .= "?{$conf['var']['adId']}=1";        
        $this->get($adlogUrl);
        $this->assertCookie("{$conf['var']['capAd']}[1]", '1');
        // 3.  Test that multiple requests increment multiple times
        $this->get($adlogUrl);
        $this->get($adlogUrl);
        $this->get($adlogUrl);
        $this->get($adlogUrl);
        $this->get($adlogUrl);
        $this->get($adlogUrl);
        $this->get($adlogUrl);
        $this->get($adlogUrl);
        $this->get($adlogUrl);
        $this->assertCookie("{$conf['var']['capAd']}[1]", '10');
        // 4.  Test that a browser restart does not delete the cookie
        $this->restart();
        $this->assertCookie("{$conf['var']['capAd']}[1]", '10');
        // 5.  Test that a cookie where capping is not set (but passed in) is set correctly
        $this->before();
        $this->get("$adlogUrl&{$conf['var']['capAd']}=3");
        $this->assertCookie("{$conf['var']['capAd']}[1]", '4');
        // 6.  Test that the sessionCapAd cookie is a temporary cookie
        $this->before();
        $this->setCookie("{$conf['var']['sessionCapAd']}[1]", '0');
        $this->get($adlogUrl);
        $this->assertCookie("{$conf['var']['sessionCapAd']}[1]", '1');
        $this->restartSession();
        $this->assertNoCookie("{$conf['var']['sessionCapAd']}[1]");
        // 7.  Test that a blocked ad works
        $this->before();
        $time = time() - 1;
        $this->setCookie("{$conf['var']['blockAd']}[1]", $time);
        $this->get($adlogUrl);
        $this->assertCookie("{$conf['var']['blockAd']}[1]");
        $time2 = $this->_browser->getCurrentCookieValue("{$conf['var']['blockAd']}[1]");
        $this->assertTrue($time2 > $time);
        $this->restartSession();
        $this->assertCookie("{$conf['var']['blockAd']}[1]");
        // 8.  Test that a session blocked ad works
        $this->before();
        $time = time() - 1;
        $this->setCookie("{$conf['var']['sessionBlockAd']}[1]", $time);
        $this->get($adlogUrl);
        $this->assertCookie("{$conf['var']['sessionBlockAd']}[1]");
        $time2 = $this->_browser->getCurrentCookieValue("{$conf['var']['sessionBlockAd']}[1]");
        $this->assertTrue($time2 > $time);
        $this->restartSession();
        $this->assertNoCookie("{$conf['var']['sessionBlockAd']}[1]");
        // 3.  Test that a blocked ad gets a cookie and logged
        // 4.  Test that an ad with no ad_id does not get logged
        // 6.  Test that all parameters get logged correctly.
    }
}

?>
