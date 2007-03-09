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

require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Clients.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/tests/util/DataGenerator.php';

/**
 * A class for testing DAL Clients methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_ClientsTest extends UnitTestCase
{
    var $dalClients;
    
    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_ClientsTest()
    {
        $this->UnitTestCase();
    }
    
    function setUp()
    {
        $this->dalClients = MAX_DB::factoryDAL('clients');
    }
    
    /**
     * Tests all advertisers are returned.
     *
     */
    function testGetAllAdvertisers()
    {
        // Insert advertisers
        $numClients = 2;
        $doClients = MAX_DB::factoryDO('clients');
        $aClientId = DataGenerator::generate($doClients, $numClients);
                
        // Call method
        $aClients = $this->dalClients->getAllAdvertisers('name', 'up');
        
        // Test same number of advertisers are returned.
        $this->assertEqual(count($aClients), $numClients);
    }
}

?>
