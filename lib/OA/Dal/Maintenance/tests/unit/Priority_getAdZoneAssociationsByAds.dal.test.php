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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getAdZoneAssociationsByAds() method of the non-DB
 * specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getAdZoneAssociationsByAds extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getAdZoneAssociationsByAds()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getAdZoneAssociationsByAds method.
     *
     * Test 1: Test with bad input, and ensure that an empty array is retuend.
     * Test 2: Test with no data, and ensure that an empty array is returned.
     * Test 3: Test with one ad/zone link, and ensure the correct data is returned.
     * Test 4: Test with a more complex set of data.
     */
    function testGetAdZoneAssociationsByAds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();

        // Test 1
        $result = $oDal->getAdZoneAssociationsByAds(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Test 2
        $aAdIds = array(1);
        $result = $oDal->getAdZoneAssociationsByAds($aAdIds);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Test 3
        $doZones = OA_Dal::factoryDO('zones');
        $zoneId = DataGenerator::generateOne($doZones, true);

        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = 1;
        $doAdZone->zone_id = $zoneId;
        $doAdZone->link_type = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $aAdIds = array(1);
        $result = $oDal->getAdZoneAssociationsByAds($aAdIds);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertTrue(is_array($result[1]));
        $this->assertEqual(count($result[1]), 1);
        $this->assertTrue(is_array($result[1][0]));
        $this->assertEqual(count($result[1][0]), 1);
        $this->assertTrue(isset($result[1][0]['zone_id']));
        $this->assertEqual($result[1][0]['zone_id'], 1);
        DataGenerator::cleanUp();

        // Test 4
        $zoneId1 = DataGenerator::generateOne($doZones, true);
        $doAdZone->ad_id = 1;
        $doAdZone->zone_id = $zoneId1;
        $doAdZone->link_type = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $zoneId2 = DataGenerator::generateOne($doZones, true);
        $doAdZone->ad_id = 1;
        $doAdZone->zone_id = $zoneId2;
        $doAdZone->link_type = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $zoneId3 = DataGenerator::generateOne($doZones, true);
        $doAdZone->ad_id = 1;
        $doAdZone->zone_id = $zoneId3;
        $doAdZone->link_type = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $doAdZone->ad_id = 2;
        $doAdZone->zone_id = $zoneId2;
        $doAdZone->link_type = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $doAdZone->ad_id = 2;
        $doAdZone->zone_id = $zoneId3;
        $doAdZone->link_type = 0;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $zoneId = DataGenerator::generateOne($doZones, true);
        $doAdZone->ad_id = 3;
        $doAdZone->zone_id = $zoneId1;
        $doAdZone->link_type = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $zoneId4 = DataGenerator::generateOne($doZones, true);
        $zoneId = DataGenerator::generateOne($doZones, true);
        $doAdZone->ad_id = 3;
        $doAdZone->zone_id = $zoneId4;
        $doAdZone->link_type = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $aAdIds = array(1, 2, 3);
        $result = $oDal->getAdZoneAssociationsByAds($aAdIds);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 3);
        $this->assertTrue(is_array($result[1]));
        $this->assertEqual(count($result[1]), 3);
        $this->assertTrue(is_array($result[1][0]));
        $this->assertEqual(count($result[1][0]), 1);
        $this->assertTrue(isset($result[1][0]['zone_id']));
        $this->assertEqual($result[1][0]['zone_id'], $zoneId1);
        $this->assertTrue(is_array($result[1][1]));
        $this->assertEqual(count($result[1][1]), 1);
        $this->assertTrue(isset($result[1][1]['zone_id']));
        $this->assertEqual($result[1][1]['zone_id'], $zoneId2);
        $this->assertTrue(is_array($result[1][2]));
        $this->assertEqual(count($result[1][2]), 1);
        $this->assertTrue(isset($result[1][2]['zone_id']));
        $this->assertEqual($result[1][2]['zone_id'], $zoneId3);
        $this->assertTrue(is_array($result[2]));
        $this->assertEqual(count($result[2]), 1);
        $this->assertTrue(is_array($result[2][0]));
        $this->assertEqual(count($result[2][0]), 1);
        $this->assertTrue(isset($result[2][0]['zone_id']));
        $this->assertEqual($result[2][0]['zone_id'], $zoneId2);
        $this->assertTrue(is_array($result[3]));
        $this->assertEqual(count($result[3]), 2);
        $this->assertTrue(is_array($result[3][0]));
        $this->assertEqual(count($result[3][0]), 1);
        $this->assertTrue(isset($result[3][0]['zone_id']));
        $this->assertEqual($result[3][0]['zone_id'], $zoneId1);
        $this->assertTrue(is_array($result[3][1]));
        $this->assertEqual(count($result[3][1]), 1);
        $this->assertTrue(isset($result[3][1]['zone_id']));
        $this->assertEqual($result[3][1]['zone_id'], $zoneId4);
        DataGenerator::cleanUp();
    }

}

?>