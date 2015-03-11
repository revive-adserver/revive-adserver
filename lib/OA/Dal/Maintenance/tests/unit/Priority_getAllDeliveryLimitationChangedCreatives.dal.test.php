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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getAllDeliveryLimitationChangedCreatives() method of
 * the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority_getAllDeliveryLimitationChangedCreatives extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }


    /**
     * Method to test the getAllDeliveryLimitationChangedCreatives method.
     *
     * Requirements:
     * Test 0: Test with bad input data, and ensure the method survives.
     * Test 1: Test with no data, and ensure no data are returned.
     * Test 2: Test with an active ad that has not had any delivery limitation changes,
     *         and ensure that no data are returned: DEPRECATED TEST, PostgreSQL DOES
     *         NOT PERMIT THE acls_update FIELD TO HAVE A NULL ENTRY.
     * Test 3: Test with an active ad that has had a delivery limitation change in the
     *         last OI, before the last Priority Compensation run, and ensure that no
     *         data are returned.
     * Test 4: Test with an active ad that has had a delivery limitation change in the
     *         last OI, after the last Priority Compensation run, and ensure that the
     *         correct data are returned.
     * Test 5: Test with an active ad that has had a delivery limitation change in the
     *         current OI, and ensure that the correct data are returned.
     * Test 6: Repeat test 3, but with an inactive ad.
     * Test 7: Repeat test 4, but with an inactive ad.
     * Test 8: Repeat test 5, but with an inactive ad.
     * Test 9: Test with a mixture of ads, and ensure the correct data are returned.
     */
    function testGetAllDeliveryLimitationChangedCreatives()
    {
        TestEnv::restoreEnv('dropTmpTables');

        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        $oDateNow = new Date('2006-10-04 12:07:01');
        $oDateLastPC = new Date('2006-10-04 11:14:53');
        $aLastRun = array(
            'start_run' => $oDateLastPC,
            'now'       => $oDateNow
        );

        // Test 0
        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives(array());
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 1
        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 3
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->priority = 1;
        $doCampaigns->status  = OA_ENTITY_STATUS_RUNNING;
        $idCampaign = DataGenerator::generateOne($doCampaigns, true);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 11:10:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        DataGenerator::cleanUp();

        // Test 4
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->priority = 1;
        $doCampaigns->status  = OA_ENTITY_STATUS_RUNNING;
        $idCampaign = DataGenerator::generateOne($doCampaigns, true);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 11:15:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[$idBanner], '2006-10-04 11:15:00');
        DataGenerator::cleanUp();

        // Test 5
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->priority = 1;
        $doCampaigns->status  = OA_ENTITY_STATUS_RUNNING;
        $idCampaign = DataGenerator::generateOne($doCampaigns, true);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 12:15:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[$idBanner], '2006-10-04 12:15:00');
        DataGenerator::cleanUp();

        // Test 6
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->priority = 1;
        $doCampaigns->status  = OA_ENTITY_STATUS_RUNNING;
        $idCampaign = DataGenerator::generateOne($doCampaigns, true);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 11:10:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        DataGenerator::cleanUp();

        // Test 7
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->priority = 1;
        $doCampaigns->activate_time = '2020-01-01 00:00:00';
        $doCampaigns->status  = OA_ENTITY_STATUS_AWAITING;
        $idCampaign = DataGenerator::generateOne($doCampaigns, true);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 11:15:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        DataGenerator::cleanUp();

        // Test 8
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->priority = 1;
        $doCampaigns->activate_time = '2020-01-01 00:00:00';
        $doCampaigns->status  = OA_ENTITY_STATUS_AWAITING;
        $idCampaign = DataGenerator::generateOne($doCampaigns, true);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_AWAITING;
        $doBanners->acls_updated = '2006-10-04 12:15:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        DataGenerator::cleanUp();

        // Test 9
        $doCampaigns = OA_Dal::factoryDO('campaigns');

        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->priority = 1;
        $doCampaigns->status  = OA_ENTITY_STATUS_RUNNING;
        $aIdCampaignsActive = DataGenerator::generate($doCampaigns, 2, true);
        $doCampaigns->activate_time = '2020-01-01 00:00:00';
        $doCampaigns->status  = OA_ENTITY_STATUS_AWAITING;
        $idCampaignInactive = DataGenerator::generateOne($doCampaigns, true);

        $doBanners = OA_Dal::factoryDO('banners');

        $doBanners->campaignid=$aIdCampaignsActive[0];
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 11:30:00';
        $idBanner1 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$aIdCampaignsActive[0];
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 10:15:00';
        $idBanner2 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$aIdCampaignsActive[1];
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_AWAITING;
        $doBanners->acls_updated = '2006-10-04 12:06:00';
        $idBanner3 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$aIdCampaignsActive[1];
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 12:15:00';
        $idBanner4 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$idCampaignInactive;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 12:05:00';
        $idBanner5 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$idCampaignInactive;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->status  = OA_ENTITY_STATUS_RUNNING;
        $doBanners->acls_updated = '2006-10-04 12:01:00';
        $idBanner5 = DataGenerator::generateOne($doBanners);

        $aResult =& $oMaxDalMaintenance->getAllDeliveryLimitationChangedCreatives($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[$idBanner1], '2006-10-04 11:30:00');
        $this->assertEqual($aResult[$idBanner4], '2006-10-04 12:15:00');
        DataGenerator::cleanUp();
    }

}

?>