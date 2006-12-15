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
$Id: Delivery_Test_Tracker.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

/**
 * Parent class for testing tracker related scripts
 * should be extended.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @TODO add header tests when simpletest is updated to the new version (1.0RC2)
 */
class Delivery_Test_Tracker extends WebTestCase
{
    
    /**
     * The constructor method.
     */
    function Delivery_Test_Tracker()
    {        
        $this->WebTestCase();
    }
    
    /* */
    function testImpressionLog($url) {
        // Get last impression id
        $sql = 'SELECT server_raw_tracker_impression_id
                FROM data_raw_tracker_impression
                ORDER BY server_raw_tracker_impression_id DESC
                LIMIT 1';
        
        if ($dbLink = connect()) {
            $result = query($sql, $dbLink);
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $impression1 = $row['server_raw_tracker_impression_id'];
        }
        else {
            $this->assertFalse(true, 'DB connection could not be made');
        }
        
        $this->createBrowser();
        $this->get($url);
        
        // lookup new impressionId
        $sql = 'SELECT server_raw_tracker_impression_id
                FROM data_raw_tracker_impression
                ORDER BY server_raw_tracker_impression_id DESC
                LIMIT 1';
        
        if ($dbLink = connect()) {
            $result = query($sql, $dbLink);
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $impression2 = $row['server_raw_tracker_impression_id'];
        }
        else {
            $this->assertFalse(true, 'DB connection could not be made');
        }
        
        // check that impressionId has been incremented for given URL
        $this->assertTrue(($impression1 + 1) == ($impression2));
    }
}

?>
