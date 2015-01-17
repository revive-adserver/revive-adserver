<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
    function __construct()
    {
        parent::__construct();
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