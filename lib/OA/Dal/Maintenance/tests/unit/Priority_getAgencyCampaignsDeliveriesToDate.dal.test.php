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
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Dal_Maintenance_Priority_getAgencyCampaignsDeliveriesToDate extends UnitTestCase
{
    public $idCampaign2;

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getAgencyCampaignsDeliveriesToDate()
    {
        $this->UnitTestCase();
    }


    /**
     * Method to test the getAgencyCampaignsDeliveriesToDate method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     */
    function testGetAgencyEcpmRemnantCampaignsDeliveriesToDate()
    {
        TestEnv::restoreEnv();

        $priority = DataObjects_Campaigns::PRIORITY_ECPM;
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
        list($agencyId1, $agencyId2) = $this->_commonTest($oMaxDalMaintenance, $priority);

        // Check that there are no results for agency 1 (when checking ecpm deliveries)
        $result = $oMaxDalMaintenance->getAgencyEcpmRemnantCampaignsDeliveriesToDate($agencyId1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Check that results for agency 2 are the same (when checking ecpm deliveries)
        $result = $oMaxDalMaintenance->getAgencyEcpmRemnantCampaignsDeliveriesToDate($agencyId2);
        $this->_testResult($result);
        DataGenerator::cleanUp();
    }

    /**
     * Method to test the getAgencyEcpmContractCampaignsDeliveriesToDate method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     */
    function testGetAgencyEcpmContractCampaignsDeliveriesToDate()
    {
        $priority = 7;
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
        list($agencyId1, $agencyId2) = $this->_commonTest($oMaxDalMaintenance, $priority);

        // Check that there are no results for agency 1 (when checking ecpm deliveries)
        $result = $oMaxDalMaintenance->getAgencyEcpmContractCampaignsDeliveriesToDate($agencyId1, $priority);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Check that results for agency 2 are the same (when checking ecpm deliveries)
        $result = $oMaxDalMaintenance->getAgencyEcpmContractCampaignsDeliveriesToDate($agencyId2, $priority);
        $this->_testResult($result);
        DataGenerator::cleanUp();
    }

    public function _testResult($result)
    {
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        foreach ($result as $id => $data) {
            $this->assertEqual($this->idCampaign2, $id);
        }
        $this->assertEqual($result[$this->idCampaign2]['sum_impressions'], 475);
        $this->assertEqual($result[$this->idCampaign2]['sum_clicks'], 25);
        $this->assertEqual($result[$this->idCampaign2]['sum_conversions'], 5);
    }

    public function _commonTest($oMaxDalMaintenance, $priority)
    {
        $oNow = new Date();


        $doClients = OA_Dal::factoryDO('clients');
        $idClient = DataGenerator::generateOne($doClients, true);
        $agencyId1 = DataGenerator::getReferenceId('agency');

        // Test 1
        $result = $oMaxDalMaintenance->getAgencyCampaignsDeliveriesToDate($agencyId1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->clientid = $idClient;
        $oYesterday = new Date();
        $oYesterday->subtractSeconds(86400);
        $oTomorrow = new Date();
        $oTomorrow->addSeconds(86400);
        $doCampaigns->activate_time = $oYesterday->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->expire_time = $oTomorrow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->priority = '1';
        $doCampaigns->active = 1;
        $doCampaigns->views = 100;
        $doCampaigns->clicks = 200;
        $doCampaigns->conversions = 300;
        $doCampaigns->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $idCampaign;
        $doBanners->active = 1;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idBanner = DataGenerator::generateOne($doBanners);

        $doInterAd = OA_Dal::factoryDO('data_intermediate_ad');
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
        $doInterAd->date_time = '2005-06-24 10:00:00';
        $doInterAd->interval_end = '2005-06-24 10:59:59';
        $doInterAd->hour = 10;
        $idInterAd = DataGenerator::generateOne($doInterAd);

        $doInterAd->interval_start = '2005-06-24 11:00:00';
        $doInterAd->date_time = '2005-06-24 11:00:00';
        $doInterAd->interval_end = '2005-06-24 11:59:59';
        $doInterAd->hour = 11;
        $idInterAd = DataGenerator::generateOne($doInterAd);

        $result = $oMaxDalMaintenance->getAgencyCampaignsDeliveriesToDate($agencyId1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        foreach ($result as $id => $data) {
            $this->assertEqual($idCampaign, $id);
        }
        $this->assertEqual($result[$idCampaign]['sum_impressions'], 950);
        $this->assertEqual($result[$idCampaign]['sum_clicks'], 50);
        $this->assertEqual($result[$idCampaign]['sum_conversions'], 10);

        // Test 3
        $doClients = OA_Dal::factoryDO('clients');
        $idClient2 = DataGenerator::generateOne($doClients, true);
        $agencyId2 = DataGenerator::getReferenceId('agency');

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $idClient2;
        $doCampaigns->priority = $priority;
        $doCampaigns->ecpm_enabled = 1;
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->revenue_type = MAX_FINANCE_CPC;
        $this->idCampaign2 = DataGenerator::generateOne($doCampaigns);

        $doBanners   = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $this->idCampaign2;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $idBanner2 = DataGenerator::generateOne($doBanners);

        $doInterAd->ad_id = $idBanner2;
        $idInterAd = DataGenerator::generateOne($doInterAd);

        // Check that results for agency 1 are still the same
        $result = $oMaxDalMaintenance->getAgencyCampaignsDeliveriesToDate($agencyId1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        foreach ($result as $id => $data) {
            $this->assertEqual($idCampaign, $id);
        }
        $this->assertEqual($result[$idCampaign]['sum_impressions'], 950);
        $this->assertEqual($result[$idCampaign]['sum_clicks'], 50);
        $this->assertEqual($result[$idCampaign]['sum_conversions'], 10);

        // Check results for agency 2
        $result = $oMaxDalMaintenance->getAgencyCampaignsDeliveriesToDate($agencyId2);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        foreach ($result as $id => $data) {
            $this->assertEqual($this->idCampaign2, $id);
        }
        $this->assertEqual($result[$this->idCampaign2]['sum_impressions'], 475);
        $this->assertEqual($result[$this->idCampaign2]['sum_clicks'], 25);
        $this->assertEqual($result[$this->idCampaign2]['sum_conversions'], 5);

        return array($agencyId1, $agencyId2);
    }

}

?>