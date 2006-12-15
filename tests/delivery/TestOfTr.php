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
 * A class for testing alg.php.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @TODO add header tests when simpletest is updated to the new version (1.0RC2)
 */
 
include_once('Delivery_Test_Tracker.php');

class Delivery_TestOfTr extends Delivery_Test_Tracker
{
    
    /**
     * The constructor method.
     */
    function Delivery_TestOfTr()
    {        
        $this->WebTestCase();
    }
    
    
    /**
    * test_Log
    *
    * Test - 1: Test response is 200 (OK) status
    * Test - 2: Make sure cookie is being set
    * Test - 3: Make sure response always ends with an image
    * Test - 4: Make sure response always ends with an image
    * 
    * @todo test - 1, add reference to delivery URL using globals
    * @todo test - 2, add reference to cookie name using globals name
    * @todo test - 3, implement once method has been implemented
    */
    function test_Log() {
        
        // 1.  Test that an empty request to tr.php returns a 1px GIF
        $this->createBrowser();
        // $adlogUrl = {$conf['file']['log']};
        $adlogUrl = "http://localhost/search/branches/ad_view_click_conversion/www/delivery/tr.php";
        $this->get($adlogUrl);
        $this->assertResponse(200);
        
        
        // 2. Check last request set a coookie
        // $this->assertCookie($conf['var']['viewerId']);
        $this->assertCookie('viewerId');
        
        // 3. Test reponse header - is an image
        //$this->assertHeader('Content-Type','image/gif');
    }
    
    
    function testImpressionLog() {
        $url = 'http://localhost/search/branches/ad_view_click_conversion/www/delivery/tr.php?trackerId=1';
        parent::testImpressionLog($url);
    }
    
    /**
    * test_data_log
    *
    * Check data is being inserted as expected in to the DB
    * Test - 1: Test data write - data input is same as that in DB
    * Test - 2: Check that server_raw_tracker_impression_id is being incremented
    * 
    */
    function test_log_tracker_vars() {
        $trackerId = 1;
        
/*
    Check for default data that should be loaded in DB by default
    
*/  
        $basketTotal = 110.79;
        $userId = 5;
        $sessionId = 'HSONEY569IHLNSMIC43RSNEOK672HD8D';
        
        $var[1] = array('name' => 'basketTotal', 'value' => $basketTotal);
        $var[2] = array('name' => 'userId', 'value' => $userId);
        $var[3] = array('name' => 'sessionId', 'value' => $sessionId);
        
        // 1.  Test variable data is bing written to the DB
        $this->createBrowser();
        $adlogUrl = "http://localhost/search/branches/ad_view_click_conversion/www/delivery/tr.php?trackerId={$trackerId}&basketTotal={$basketTotal}&userId={$userId}&sessionId={$sessionId}";
        
        $this->get($adlogUrl);
        
        require_once '../../../init-delivery.php';
    
        $conf = $GLOBALS['_SGL']['CONF'];
    
        require_once SGL_LIB_DIR . '/max/Dal/delivery/common.php';
        require_once(SGL_LIB_DIR . '/max/Dal/delivery/' . strtolower($conf['db']['type']) . '.php');
        
        // Get last 3 param INSERTS
        $sql = 'SELECT *
        FROM data_raw_tracker_variable_value
        ORDER BY data_raw_tracker_variable_value_id DESC 
        LIMIT 3';
        
        if ($dbLink = connect()) {
            $result = query($sql, $dbLink);
            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                // hold to check later
                $server_raw_tracker_impression_id = $row['server_raw_tracker_impression_id'];
                $this->assertTrue($var[$row['tracker_variable_id']]['value'] = $row['value'], 'DB recorded variable ' . $var[$row['tracker_variable_id']]['name'] . 'is not same as expected.');
            }
        }
        else {
            $this->assertFalse(true, 'DB connection could not be made');
        }
        
        // Test - 2: Check that server_raw_tracker_impression_id is being incremented
        $this->createBrowser();
        $adlogUrl = "http://localhost/search/branches/ad_view_click_conversion/www/delivery/tr.php?trackerId={$trackerId}&basketTotal={$basketTotal}&userId={$userId}&sessionId={$sessionId}";
        $this->get($adlogUrl);
        
        // Get last 3 param INSERTS
        $sql = 'SELECT *
        FROM data_raw_tracker_variable_value
        ORDER BY data_raw_tracker_variable_value_id DESC 
        LIMIT 3';
        
        if ($dbLink = connect()) {
            $result = query($sql, $dbLink);
            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                // hold to check later
                $server_raw_tracker_impression_id_new = $row['server_raw_tracker_impression_id'];
            }
        }
        else {
            $this->assertFalse(true, 'DB connection could not be made');
        }
        
        // check that server_raw_tracker_impression_id is one more than last insert
        $this->assertTrue((($server_raw_tracker_impression_id + 1) == ($server_raw_tracker_impression_id_new)));
    }
}

?>
