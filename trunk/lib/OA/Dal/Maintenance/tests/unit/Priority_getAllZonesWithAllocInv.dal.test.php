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
 * A class for testing the getAllZonesWithAllocInv() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getAllZonesWithAllocInv extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getAllZonesWithAllocInv()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the getAllZonesWithAllocInv method.
     *
     * Requirements:
     * Test 1: Test with no data, and ensure no data returned.
     * Test 2: Test with sample data, and ensure the correct data is returned.
     *
     * updated in line with OA-120
     * method now returns records only where
     * the ad_id is active and
     * the ad_id belongs to a high priority active campaign
     *
     */
    function testGetAllZonesWithAllocInv()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Create the required temporary table for the tests
        $oTable = &OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');

        // set up the campaigns and banners
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->status    = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->priority  = '5';
        $campaignId1 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->status    = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->priority  = '-1';
        $campaignId2 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->expire    = '2000-01-01';
        $doCampaigns->status    = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->priority  = '5';
        $campaignId3 = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->status    = OA_ENTITY_STATUS_RUNNING;
        $doBanners->campaignid  = $campaignId1;
        $bannerId1t = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->status    = OA_ENTITY_STATUS_EXPIRED;
        $doBanners->campaignid  = $campaignId1;
        $bannerId1f = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->status    = OA_ENTITY_STATUS_RUNNING;
        $doBanners->campaignid  = $campaignId2;
        $bannerId2t = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->status    = OA_ENTITY_STATUS_EXPIRED;
        $doBanners->campaignid  = $campaignId2;
        $bannerId2f = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->status    = OA_ENTITY_STATUS_RUNNING;
        $doBanners->campaignid  = $campaignId3;
        $bannerId3t = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->status    = OA_ENTITY_STATUS_EXPIRED;
        $doBanners->campaignid  = $campaignId3;
        $bannerId3f = DataGenerator::generateOne($doBanners);

        // Test 1
        $result = &$oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 0);

        // Test 2
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId1t,
                    1,
                    2,
                    3
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId1t,
                    2,
                    4,
                    5
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId1t,
                    2,
                    6,
                    7
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId1f,
                    1,
                    2,
                    3
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId1f,
                    2,
                    4,
                    5
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId1f,
                    2,
                    6,
                    7
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId2t,
                    1,
                    2,
                    3
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId2f,
                    1,
                    2,
                    3
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId3t,
                    2,
                    4,
                    5
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    $bannerId3f,
                    2,
                    4,
                    5
                )";
        $rows = $oDbh->exec($query);

        $result = &$oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 3);

        // The last entries have the same zone_id and ad_id. The query used in
        // getAllZonesWithAllocInv doesn't guarantee any order, nor it's useful
        // to add the field to its ORDER BY clause. That's why we sort using PHP
        // by required_impressions
        usort($result, create_function('$a, $b', 'return $a["required_impressions"] - $b["required_impressions"];'));

        $this->assertEqual($result[0]['zone_id'], 1);
        $this->assertEqual($result[0]['ad_id'], $bannerId1t);
        $this->assertEqual($result[0]['required_impressions'], 2);
        $this->assertEqual($result[0]['requested_impressions'], 3);
        $this->assertEqual($result[1]['zone_id'], 2);
        $this->assertEqual($result[1]['ad_id'], $bannerId1t);
        $this->assertEqual($result[1]['required_impressions'], 4);
        $this->assertEqual($result[1]['requested_impressions'], 5);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['ad_id'], $bannerId1t);
        $this->assertEqual($result[2]['required_impressions'], 6);
        $this->assertEqual($result[2]['requested_impressions'], 7);

        TestEnv::restoreEnv();
    }

    /**
     * Method to test the getAllZonesWithAllocInv method.
     *
     * Requirements:
     * Test 1: Test with no data, and ensure no data returned.
     * Test 2: Test with sample data, and ensure the correct data is returned.
     */
    function DEPRECATED_testGetAllZonesWithAllocInv()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Create the required temporary table for the tests
        $oTable =& OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');

        $tableTmp = $oDbh->quoteIdentifier('tmp_ad_zone_impression',true);

        // Test 1
        $result =& $oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 0);

        // Test 2
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    1,
                    1,
                    2,
                    3
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    1,
                    2,
                    4,
                    5
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$tableTmp}
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    2,
                    2,
                    6,
                    7
                )";
        $rows = $oDbh->exec($query);
        $result =& $oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[0]['zone_id'], 1);
        $this->assertEqual($result[0]['ad_id'], 1);
        $this->assertEqual($result[0]['required_impressions'], 2);
        $this->assertEqual($result[0]['requested_impressions'], 3);
        $this->assertEqual($result[1]['zone_id'], 2);
        $this->assertEqual($result[1]['ad_id'], 1);
        $this->assertEqual($result[1]['required_impressions'], 4);
        $this->assertEqual($result[1]['requested_impressions'], 5);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['ad_id'], 2);
        $this->assertEqual($result[2]['required_impressions'], 6);
        $this->assertEqual($result[2]['requested_impressions'], 7);
        TestEnv::dropTempTables();
    }

}

?>
