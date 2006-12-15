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

/**
 * A class for testing ck.php.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Scott Switzer <scott@switzer.org>
 * @TODO Incomplete.
 */
class Delivery_TestOfCk extends WebTestCase
{
    
    /**
     * The constructor method.
     */
    function Delivery_TestOfCk()
    {        
        $this->WebTestCase();
    }
    
    /**
     * Test ck.php with different parameters.
     * @todo Finish tests.
     */
    function test_Click()
    {
        /*
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->createBrowser();
        $urlPrefix = MAX_commonConstructDeliveryUrl($conf['file']['click']) . '?';
        $dest = urlencode('http://www.m3.net/test.php?this=that&joe=mary');
        // Reg/&/dest/novars/GET/normal
        $url = $urlPrefix . 'bannerid=123&zoneid=456&dest=' . $dest;
        $this->get($url);
        $this->assertHeader('Location', $dest);
        $this->before();
        // $this->get
        $url = $urlPrefix . 'bannerid=123&zoneid=456&maxdest=' . $dest;
        $this->get($url);
        $this->assertHeader('Location', $dest);
        $this->before();
        $cookie['bannerid'] = 123;
    	$cookie['zoneid'] = 456;
        $cookie['maxdest'] = $dest;
        $n = 'a34455';
        setcookie($conf['var']['vars'] . "[$n]", serialize($cookie), 0);
        $this->get($urlPrefix . "n=$n");
        $this->assertHeader('Location', $dest);
        */
        
        // $this->get($urlPrefix . 'maxparams=2__bannerid=123__zoneid=456__dest=' . $dest);
        // $this->assertHeader('Location', $dest);
        // $this->before();
        
        // Test each URL
        // reg params vs. maxparams vs. cookie params vs. combination
        // & vs. &amp;
        // dest vs. MAXDEST vs. no dest vs. default dest
        // additional GET vars, additional POST vars, no vars
        // GET vs. POST
        // urlencode vs. normal
        // getClickUrl for all banners on system
        // double-urlencoded data
        // log=no
        
        // 1.  acl.php?bannerid=1&zoneid=2&MAXDEST=http://www.m3.net => http://www.m3.net
        // 2.  acl.php?bannerid=1&amp;zoneid=2&amp;MAXDEST=http://www.m3.net?joe=1&amp;bob=2 => http://www.m3.net
        // 3.  acl.php?bannerid=1&zoneid=2&dest=http://www.m3.net => http://www.m3.net
        // 3.  acl.php?maxparams=2__bannerid=1__zoneid=2__dest=http://www.m3.net => http://www.m3.net
    }
}

?>