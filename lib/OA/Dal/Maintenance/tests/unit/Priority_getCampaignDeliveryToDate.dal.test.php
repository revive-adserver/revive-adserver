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
$Id$
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getCampaignDeliveryToDate() method of the non-DB
 * specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getCampaignDeliveryToDate extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getCampaignDeliveryToDate()
    {
        $this->UnitTestCase();
    }


    /**
     * Method to test the getCampaignDeliveryToDate method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     *
     * @TODO Incomplete test!
     */
    function testGetCampaignDeliveryToDate()
    {
        /**
         * @TODO Locate where clean up doesn't happen before this test, and fix!
         */
        TestEnv::restoreEnv();

        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        $oNow = new Date();

        // Test 1
        $result = $oMaxDalMaintenance->getCampaignDeliveryToDate(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->activate_time = '2005-06-23 00:00:00';
        $doCampaigns->expire_time = '2005-06-25 23:59:59';
        $doCampaigns->priority = '1';
        $doCampaigns->active = 1;
        $doCampaigns->views = 100;
        $doCampaigns->clicks = 200;
        $doCampaigns->conversions = 300;
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idCampaign = DataGenerator::generateOne($doCampaigns, true);

        $doBanners   = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $idCampaign;
        $doBanners->active = 1;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
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

        $result = $oMaxDalMaintenance->getCampaignDeliveryToDate(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[0]['placement_id'], 1);
        $this->assertEqual($result[0]['sum_requests'], 1000);
        $this->assertEqual($result[0]['sum_views'], 950);
        $this->assertEqual($result[0]['sum_clicks'], 50);
        $this->assertEqual($result[0]['sum_conversions'], 10);

        // Test 3
        DataGenerator::cleanUp();
    }

}

?>