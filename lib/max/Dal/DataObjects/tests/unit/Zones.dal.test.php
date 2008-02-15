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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Zones methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_ZonesTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_ZonesTest()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        DataGenerator::cleanUp(array('zones'));
    }

    function testDuplicate()
    {
        // Insert a zone with some default data.
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename = 'foo';
        $doZones->zonetype = 3;
        $doZones->width = 5;
        $doZones->height = 10;
        $doZones->forceappend = 'f';
        $zoneId = DataGenerator::generateOne($doZones);

        // Duplicate it
        $doZones = OA_Dal::staticGetDO('zones', $zoneId);
        $newZoneId = $doZones->duplicate();
        $this->assertNotEmpty($newZoneId);

        $doNewZone = OA_Dal::staticGetDO('zones', $newZoneId);
        $doZones = OA_Dal::staticGetDO('zones', $zoneId);

        // assert they are not equal (but without comparing primary key)
        $this->assertNotEqualDataObjects($this->stripKeys($doZones), $this->stripKeys($doNewZone));

        // Assert the only difference is their description
        $doZones->zonename = $doNewZone->zonename = null;
        $this->assertEqualDataObjects($this->stripKeys($doZones), $this->stripKeys($doNewZone));
    }

    function testDelete()
    {
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->append = '';
        $doZones->chain = '';
        DataGenerator::generate($doZones, $numZones1 = 2); // add few reduntant zones

        // Add our testing zone
        $zoneId = DataGenerator::generateOne('zones');

        // add appending zones
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->appendtype = phpAds_ZoneAppendZone;
        $doZones->append = 'zone:'.$zoneId;
        $doZones->chain = '';
        $aZoneIdAppends = DataGenerator::generate($doZones, $numZonesAppened = 3);

        // add chained zones
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->append = '';
        $doZones->chain = 'zone:'.$zoneId;
        $aZoneIdChained = DataGenerator::generate($doZones, $numZonesChained = 3);

        $doZones = OA_Dal::staticGetDO('zones', $zoneId);
        $ret = $doZones->delete(); // delete
        $this->assertTrue($ret);

        $numAllZones = $numZones1 + $numZonesAppened + $numZonesChained;

        // check appended zones were cleaned up
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->append = '';
        //$doZones->whereAdd("append = ''");
        // $countWhat = true
        $this->assertEqual($doZones->count(), $numAllZones);

        // check chained zones were cleaned up
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->chain = '';
        $this->assertEqual($doZones->count(), $numAllZones);
    }
}
?>