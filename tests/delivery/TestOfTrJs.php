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
$Id: TestOfTrJs.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

/**
 * A class for testing alg.php.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @TODO add header tests when simpletest is updated to the new version (1.0RC2)
 */
class Delivery_TestOfTrJs extends Delivery_Test_Tracker
{
    
    /**
     * The constructor method.
     */
    function Delivery_TestOfTrJs()
    {        
        $this->WebTestCase();
    }
    
    
    /**
    * test_Log
    *
    * Test - 1: Test response for empty request
    * Test - 2: Test for header Content-type: "application/x-javascript"
    
    
    * Test - 3: Make sure response always ends with an image
    * Test - 4: Make sure response always ends with an image
    * 
    * @todo test - 1, add reference to delivery URL using globals
    * @todo test - 2, add reference to cookie name using globals name
    * @todo test - 3, implement once method has been implemented
    */
    function test_Log() {
        
        // 1.  Test empty request - should return document.write("");
        $this->createBrowser();
        $adlogUrl = "http://localhost/search/branches/ad_view_click_conversion/www/delivery/trjs.php";
        $this->get($adlogUrl);
        $this->assertResponse(200);
        
        $this->showHeaders();
    }
    
    
    /**
    * testImpressionLog
    *
    * Check data is being inserted as expected in to the DB
    * Test - 1: Test data write - data input is same as that in DB
    * Test - 2: Check that server_raw_tracker_impression_id is being incremented
    * 
    */
    function testImpressionLog() {
        $url = 'http://localhost/search/branches/ad_view_click_conversion/www/delivery/trjs.php?trackerId=1';
        parent::testImpressionLog($url);
    }
}

?>
