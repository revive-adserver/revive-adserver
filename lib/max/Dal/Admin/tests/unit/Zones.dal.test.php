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
require_once MAX_PATH . '/lib/max/Dal/Admin/Zones.php';
require_once MAX_PATH . '/lib/max/tests/util/DataGenerator.php';

/**
 * A class for testing DAL Zones methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_ZonesTest extends UnitTestCase
{
    var $dalZones;
    
    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_ZonesTest()
    {
        $this->UnitTestCase();
    }
    
    function setUp()
    {
        $this->dalZones = MAX_DB::factoryDAL('zones');
    }
    
    function tearDown()
    {
        TestEnv::restoreEnv();
    }
    
    function testGetZoneByKeyword()
    {
        // Search for zones when none exist.
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $agencyId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $affiliateId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', null, $affiliateId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $affiliateId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId, $affiliateId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Add a zone (and parent objects)
        $doZones = MAX_DB::factoryDO('zones');
        $doZones->zonename = 'foo';
        $doZones->description = 'bar';
        $aZoneId[] = DataGenerator::generateOne($doZones, true);
        
        // Add another zone
        $doZones = MAX_DB::factoryDO('zones');
        $doZones->zonename = 'baz';
        $doZones->description = 'quux';
        $aZoneId[] = DataGenerator::generateOne($doZones, true);
        
        // Search for the zone by string
        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $rsZones = $this->dalZones->getZoneByKeyword('bar');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Restrict the search to agency ID
        $agencyId = 0;
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId);
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $expected = 1;
        $agencyId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Restrict the search to affiliate ID
        $affiliateId = 0;
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId, $affiliateId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $affiliateId = 1;
        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId, $affiliateId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Search for zone by zone ID
        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword(1);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
    }
    
}
?>