<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: Priority_getAllZonesWithAllocInv.dal.test.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getZonesAllocationsByAgency() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Dal_Maintenance_Priority_getZonesAllocationsByAgency extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getZonesAllocationsByAgency()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the getZonesAllocationsByAgency method.
     *
     * Requirements:
     * Test 1: Test with no data, and ensure no data returned.
     * Test 2: Test with sample data, and ensure the correct data is returned.
     */
    function testGetZonesAllocationsByAgency()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Create the required temporary table for the tests
        $oTable = &OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');
        
        // set up agencies, affiliates and zones
        $agencyId1 = DataGenerator::generateOne('agency', true);
        $agencyId2 = DataGenerator::generateOne('agency', true);

        // Add affiliates (websites)
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $agencyId1;
        $affiliateId1 = DataGenerator::generateOne($doAffiliates);
        
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $agencyId2;
        $affiliateId2 = DataGenerator::generateOne($doAffiliates);

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->description = 'Test zone';
        $doZones->affiliateid = $affiliateId1;
        $idZone1 = DataGenerator::generateOne($doZones);

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->description = 'Test zone';
        $doZones->affiliateid = $affiliateId2;
        $idZone2 = DataGenerator::generateOne($doZones);

        // Test 1
        $result = $oMaxDalMaintenance->getZonesAllocationsByAgency($agencyId1);
        $this->assertEqual(count($result), 0);

        // Test 2
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    to_be_delivered
                )
            VALUES
                (
                    1,
                    {$idZone2},
                    2,
                    3,
                    1
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    to_be_delivered
                )
            VALUES
                (
                    1,
                    {$idZone1},
                    4,
                    5,
                    1
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    to_be_delivered
                )
            VALUES
                (
                    2,
                    {$idZone1},
                    6,
                    7,
                    0
                )";
        $rows = $oDbh->exec($query);
        $aResult = $oMaxDalMaintenance->getZonesAllocationsByAgency($agencyId1);

        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[$idZone1], 4);

        TestEnv::restoreEnv();
    }
}

?>
