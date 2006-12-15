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
$Id: TestOfTrVar.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

/**
 * A class for testing alg.php.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @TODO add header tests when simpletest is updated to the new version (1.0RC2)
 */
 
include_once('Delivery_Test_Tracker.php');

class Delivery_TestOfTrVar extends Delivery_Test_Tracker
{
    
    /**
     * The constructor method.
     */
    function Delivery_TestOfTrVar()
    {        
        $this->WebTestCase();
    }
    
    
    /**
    * test_Log
    *
    * Test - 1: Test an empty request should result in the expected output
    * Test - 3: Test response header has a type image for no input
    */
    function test_output() {
        
        // Test 1
        $this->createBrowser();
        $adlogUrl = "http://localhost/search/branches/ad_view_click_conversion/www/delivery/trvar.php";
        $this->get($adlogUrl);
        $this->assertResponse(200);
        
        
        // 2. Check last request set a coookie
        // $this->assertCookie($conf['var']['viewerId']);
        // $this->assertCookie('viewerId');
        
        // 3. Test reponse header - is an image
        //$this->assertHeader('Content-Type','image/gif');
    }
    
    
    function testImpressionLog() {
        $url = 'http://localhost/search/branches/ad_view_click_conversion/www/delivery/tr.php?trackerId=1';
        parent::testImpressionLog($url);
    }
}

?>
