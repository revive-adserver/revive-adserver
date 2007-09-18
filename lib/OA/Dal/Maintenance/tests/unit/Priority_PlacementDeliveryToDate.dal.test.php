<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Entity/Ad.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once 'DB/QueryTool.php';

// pgsql execution time before refactor: 56.745s
// pgsql execution time after refactor: 22.774s

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority_PlacementDeliveryToDate extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_PlacementDeliveryToDate()
    {
        $this->UnitTestCase();
    }


    /**
     * Method to test the getPlacementDeliveryToDate method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     *
     * @TODO Incomplete test!
     */
    function testGetPlacementDeliveryToDate()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        $oNow = new Date();

        // Test 1
        $result = $oMaxDalMaintenance->getPlacementDeliveryToDate(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->activate = '2005-06-23';
        $doCampaigns->expire = '2005-06-25';
        $doCampaigns->priority = '1';
        $doCampaigns->active = 't';
        $doCampaigns->views = 100;
        $doCampaigns->clicks = 200;
        $doCampaigns->conversions = 300;
        $doCampaigns->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        $doBanners   = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $idCampaign;
        $doBanners->active = 't';
        $doBanners->acls_updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idBanner = DataGenerator::generateOne($doBanners);

        $doInterAd   = OA_Dal::factoryDO('data_intermediate_ad');
        $doInterAd->operation_interval = 60;
        $doInterAd->operation_interval_id = 0;
        $doInterAd->ad_id = $idBanner;
        $doInterAd->day = '2005-06-24';
        $doInterAd->creative_id = 0;
        $doInterAd->zone_id = 1;
        $doInterAd->requests = 500;
        $doInterAd->impressions = 475;
        $doInterAd->clicks = 25;
        $doInterAd->conversions = 5;
        $doInterAd->updated = $oNow->format('%Y-%m-%d %H:%M:%S');

        $doInterAd->interval_start = '2005-06-24 10:00:00';
        $doInterAd->interval_end = '2005-06-24 10:59:59';
        $doInterAd->hour = 10;
        $idInterAd = DataGenerator::generateOne($doInterAd);

        $doInterAd->interval_start = '2005-06-24 11:00:00';
        $doInterAd->interval_end = '2005-06-24 11:59:59';
        $doInterAd->hour = 11;
        $idInterAd = DataGenerator::generateOne($doInterAd);

        $result = $oMaxDalMaintenance->getPlacementDeliveryToDate(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[0]['placement_id'], 1);
        $this->assertEqual($result[0]['sum_requests'], 1000);
        $this->assertEqual($result[0]['sum_views'], 950);
        $this->assertEqual($result[0]['sum_clicks'], 50);
        $this->assertEqual($result[0]['sum_conversions'], 10);

        /*
        // Test 3
        $oStartDate = new Date('2005-06-21 14:00:01');
        $oEndDate   = new Date('2005-06-21 14:01:01');
        $oUpdatedTo = new Date('2005-06-21 14:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:01');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 16:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        */
        DataGenerator::cleanUp();
    }

    /**
     * Method to test the getPlacementDeliveryToDate method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     *
     * @TODO Incomplete test!
     */
    function OLD_testGetPlacementDeliveryToDate()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        $oNow = new Date();

        // Test 1
        $result = $oMaxDalMaintenance->getPlacementDeliveryToDate(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Test 2
        $today = '2005-06-24';
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['campaigns'],true)."
                (
                    campaignid,
                    activate,
                    expire,
                    priority,
                    active,
                    views,
                    clicks,
                    conversions,
                    updated
                )
            VALUES
                (
                    1,
                    '2005-06-23',
                    '2005-06-25',
                    1,
                    't',
                    100,
                    200,
                    300,
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['banners'],true)."
                (
                    campaignid,
                    bannerid,
                    htmltemplate,
                    htmlcache,
                    url,
                    bannertext,
                    compiledlimitation,
                    append,
                    updated,
                    acls_updated
                )
            VALUES
                (
                    1,
                    1,
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_intermediate_ad'],true)."
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    updated
                )
            VALUES
                (
                    60,
                    0,
                    '2005-06-24 10:00:00',
                    '2005-06-24 10:59:59',
                    '2005-06-24',
                    10,
                    1,
                    0,
                    1,
                    500,
                    475,
                    25,
                    5,
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_intermediate_ad'],true)."
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    updated
                )
            VALUES
                (
                    60,
                    0,
                    '2005-06-24 11:00:00',
                    '2005-06-24 11:59:59',
                    '2005-06-24',
                    11,
                    1,
                    0,
                    1,
                    500,
                    475,
                    25,
                    5,
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $result = $oMaxDalMaintenance->getPlacementDeliveryToDate(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[0]['placement_id'], 1);
        $this->assertEqual($result[0]['sum_requests'], 1000);
        $this->assertEqual($result[0]['sum_views'], 950);
        $this->assertEqual($result[0]['sum_clicks'], 50);
        $this->assertEqual($result[0]['sum_conversions'], 10);
        /*

        // Test 3
        $oStartDate = new Date('2005-06-21 14:00:01');
        $oEndDate   = new Date('2005-06-21 14:01:01');
        $oUpdatedTo = new Date('2005-06-21 14:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:01');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 16:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        */

        TestEnv::restoreEnv();
    }


}

?>
