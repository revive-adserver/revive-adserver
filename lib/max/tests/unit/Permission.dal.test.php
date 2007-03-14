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

require_once MAX_PATH . '/lib/max/Permission.php';
require_once MAX_PATH . '/lib/max/tests/util/DataGenerator.php';


/**
 * A class for testing DAL Permission methods
 *
 * @package    Max
 * @subpackage TestSuite
 *
 */
class MAX_PermissionTest extends UnitTestCase
{
    
    /**
     * The constructor method.
     */
    function MAX_PermissionTest()
    {
        $this->UnitTestCase();
    }
    
    function setUp()
    {
        
    }
    
    function tearDown()
    {
        TestEnv::restoreEnv();
    }
    
    function testIsUsernameAllowed()
    {
        // Set up the preferences array
        $GLOBALS['pref'] = array();
        $GLOBALS['pref']['admin'] = 'admin';
        
        // If the names are the same then true
        $this->assertTrue(MAX_Permission::isUsernameAllowed('foo', 'foo'));
        
        // Don't let a user have the "admin" username
        $this->assertFalse(MAX_Permission::isUsernameAllowed('foo', 'admin'));
        
        // Check users as client, affiliate, agency
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->clientusername = 'bar';
        $clientId = DataGenerator::generateOne($doClients);
        
        $this->assertFalse(MAX_Permission::isUsernameAllowed('foo', 'bar'));
        
        $doAffiliates = MAX_DB::factoryDO('affiliates');
        $doAffiliates->username = 'baz';
        $affiliateId = DataGenerator::generateOne($doAffiliates);
        
        $this->assertFalse(MAX_Permission::isUsernameAllowed('foo', 'baz'));
        
        $doAgency = MAX_DB::factoryDO('agency');
        $doAgency->username = 'quux';
        $agencyId = DataGenerator::generateOne($doAgency);
        
        $this->assertFalse(MAX_Permission::isUsernameAllowed('foo', 'quux'));
        
        $this->assertTrue(MAX_Permission::isUsernameAllowed('foo', 'newname'));
        
    }
}
?>