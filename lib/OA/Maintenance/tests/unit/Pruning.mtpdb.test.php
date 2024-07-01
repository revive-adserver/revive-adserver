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

require_once MAX_PATH . '/lib/OA/Maintenance/Pruning.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/pear/Date/Span.php';

/**
 * A class for performing an integration test of the Maintenance Pruning functions
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_Priority extends UnitTestCase
{
    /**
     * A local instance of the database handler object.
     *
     * @var MDB2_Driver_Common
     */
    public $oDbh;

    /**
     * A method to be run before all tests.
     */
    public function setUp()
    {
        // Set up the database handler object
        $this->oDbh = OA_DB::singleton();

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $aIds = DataGenerator::generate($doCampaigns, 2);
        $this->idCampaign1 = $aIds[0];
        $this->idCampaign2 = $aIds[1];

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $this->idCampaign1;
        $this->idBanner1 = DataGenerator::generateOne($doBanners);
        $doBanners->campaignid = $this->idCampaign2;
        $this->idBanner2 = DataGenerator::generateOne($doBanners);
    }

    /**
     * A method to be run after all tests.
     */
    public function tearDown()
    {
        // Clean up the testing environment
        TestEnv::restoreEnv();
    }


    /**
     * Pruning can be performed where the entry is older than MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT minutes ago.
     *
     */
    public function testPruneDataSummaryAdZoneAssocOldData()
    {
        $oDate = new Date();
        $oServiceLocator = OA_ServiceLocator::instance();
        $oServiceLocator->register('now', clone $oDate);
        $oDal = new OA_Maintenance_Pruning();
        $doDSAZA = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDSAZA->interval_start = $oDate->getDate();

        // Test 1: table is empty : nothing to delete
        $this->assertEqual($this->_countRowsInDSAZA(), 0);
        $this->assertEqual(0, $oDal->_pruneDataSummaryAdZoneAssocOldData());

        // generate 4 records
        $aIds = DataGenerator::generate($doDSAZA, 4);
        $this->assertEqual($this->_countRowsInDSAZA(), 4);

        // Test 2: values are current, nothing to delete
        $this->assertEqual(0, $oDal->_pruneDataSummaryAdZoneAssocOldData());
        $this->assertEqual($this->_countRowsInDSAZA(), 4);

        // Test 3: one value is old: should delete 1
        $oDate->subtractSeconds(MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT * 60 + 100);
        $doDSAZA->data_summary_ad_zone_assoc_id = array_shift($aIds);
        $doDSAZA->find(true);
        $doDSAZA->interval_start = $oDate->getDate();
        $doDSAZA->update();

        $this->assertEqual(1, $oDal->_pruneDataSummaryAdZoneAssocOldData());
        $this->assertEqual($this->_countRowsInDSAZA(), 3);

        // Test 4: 66% of values are old, should use truncate + temp table
        foreach (array_splice($aIds, 0, 2) as $k => $id) {
            $doDSAZA->data_summary_ad_zone_assoc_id = $id;
            $doDSAZA->find(true);
            $doDSAZA->interval_start = $oDate->getDate();
            $doDSAZA->update();
        }

        // Force using temp table + truncate
        $this->assertEqual(2, $oDal->_pruneDataSummaryAdZoneAssocOldData(0));
        $this->assertEqual($this->_countRowsInDSAZA(), 1);

        // Test 4: all values are old, should delete all with
        foreach ($aIds as $k => $id) {
            $doDSAZA->data_summary_ad_zone_assoc_id = $id;
            $doDSAZA->find(true);
            $doDSAZA->interval_start = $oDate->getDate();
            $doDSAZA->update();
        }
        $this->assertEqual(1, $oDal->_pruneDataSummaryAdZoneAssocOldData());
        $this->assertEqual($this->_countRowsInDSAZA(), 0);
    }

    /**
     * Prune all entries where the ad_id is for a banner in a High Priority Campaign where:
    * The campaign does not have any booked lifetime target values AND the capaign has an end date AND the end date has been passed AND the campaign is not active.
     *
     */
    public function testpruneDataSummaryAdZoneAssocInactiveExpired()
    {
        $oToday = new Date();
        $oToday->setHour(23);
        $oToday->setMinute(59);
        $oToday->setSecond(59);
        $oExpire = new Date($oToday);
        $oExpire->subtractSpan(new Date_Span('10-0-0-0'));
        $today = $oToday->getDate(DATE_FORMAT_ISO);
        $expire = $oExpire->getDate(DATE_FORMAT_ISO);
        $oDal = new OA_Maintenance_Pruning();

        $doDSAZA = OA_Dal::factoryDO('data_summary_ad_zone_assoc');

        // generate 2 summary ad_zone records for an active campaign ad_id
        $doDSAZA->ad_id = $this->idBanner1;
        $aIds = DataGenerator::generate($doDSAZA, 2);

        // generate 7 summary ad_zone records for an inactive campaign ad_id
        $doDSAZA->ad_id = $this->idBanner2;
        $aIds = DataGenerator::generate($doDSAZA, 7);

        // make sure 9 rows in table
        $this->assertEqual($this->_countRowsInDSAZA(), 9);

        // ad_id 1 => campaignid 1 => active, high priority, not expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority = 5;
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->update();

        // ad_id 2 => campaignid 2 => not active, high priority, expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign2);
        $doCampaigns->priority = 5;
        $doCampaigns->status = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire_time = $expire;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 7 records were deleted
        $this->assertEqual($result, 7);
        // 2 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 2);

        // ad_id 1 => campaignid 1 => not active, override (low priority)
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority = -1;
        $doCampaigns->status = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire_time = $expire;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 0 records were deleted
        $this->assertEqual($result, 0);
        // 2 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 2);

        // ad_id 1 => campaignid 1 => not active, high priority, not expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority = 5;
        $doCampaigns->status = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire_time = OX_DATAOBJECT_NULL;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 0 records were deleted
        $this->assertEqual($result, 0);
        // 2 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 2);

        // ad_id 1 => campaignid 1 => not active, high priority, expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority = 5;
        $doCampaigns->status = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire_time = $expire;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 2 records were deleted
        $this->assertEqual($result, 2);
        // 0 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 0);

        // generate 2 summary ad_zone records for an active campaign that expires today
        $doDSAZA->ad_id = 1;
        $aIds = DataGenerator::generate($doDSAZA, 2);
        $this->assertEqual($this->_countRowsInDSAZA(), 2);

        // ad_id 1 => campaignid 1 => active, high priority, expires today
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority = 5;
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire_time = $today;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 0 records were deleted
        $this->assertEqual($result, 0);
        // 2 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 2);

        // ad_id 1 => campaignid 1 => active, high priority, expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority = 5;
        $doCampaigns->status = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire_time = $expire;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 2 records were deleted
        $this->assertEqual($result, 2);
        // 0 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 0);
    }

    /**
     * Prune all entries where the ad_id is for a banner in a High Priority Campaign where:
     * The campaign has a booked number of lifetime target impressions and/or clicks and/or conversions AND the campaign is not active AND at least one of the booked lifetime target values has been reached.
     *
     */
    public function testpruneDataSummaryAdZoneAssocTargetReached()
    {
        $oToday = new Date();
        $oExpire = new Date();
        $oExpire->subtractSeconds(999999);
        $today = $oToday->getDate();
        $expire = $oExpire->getDate();
        $oDal = new OA_Maintenance_Pruning();

        $doDSAZA = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDIA = OA_Dal::factoryDO('data_intermediate_ad');

        $aDIAs = DataGenerator::generate($doDIA, 4);

        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[0]);
        $doDIA->ad_id = $this->idBanner1;
        $doDIA->impressions = 1000;
        $doDIA->clicks = 0;
        $doDIA->conversions = 0;
        $doDIA->update();

        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[1]);
        $doDIA->ad_id = $this->idBanner1;
        $doDIA->impressions = 100;
        $doDIA->clicks = 0;
        $doDIA->conversions = 0;
        $doDIA->update();

        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[2]);
        $doDIA->ad_id = $this->idBanner1;
        $doDIA->impressions = 10;
        $doDIA->clicks = 0;
        $doDIA->conversions = 0;
        $doDIA->update();

        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[3]);
        $doDIA->ad_id = $this->idBanner1;
        $doDIA->impressions = 1;
        $doDIA->clicks = 0;
        $doDIA->conversions = 0;
        $doDIA->update();

        // generate 2 summary ad_zone records for an active campaign ad_id
        $doDSAZA->ad_id = $this->idBanner1;
        $aIds = DataGenerator::generate($doDSAZA, 2);

        // generate 7 summary ad_zone records for an inactive campaign ad_id
        $doDSAZA->ad_id = $this->idBanner2;
        $aIds = DataGenerator::generate($doDSAZA, 7);

        // make sure 9 rows in table
        $this->assertEqual($this->_countRowsInDSAZA(), 9);

        // ad_id 1 => campaignid 1 => active, high priority, not expired, target impressions not reached
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority = 5;
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 100000;
        $doCampaigns->clicks = 1000;
        $doCampaigns->conversions = 100;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveTargetReached(1);
        // 0 records were deleted
        $this->assertEqual($result, 0);
        // 0 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 9);

        // ad_id 1 => campaignid 1 => not active, high priority, not expired, target impressions reached
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority = 5;
        $doCampaigns->status = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views = 1111;
        $doCampaigns->clicks = 111;
        $doCampaigns->conversions = 11;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveTargetReached(1);
        // 1 record deleted
        $this->assertEqual($result, 1);
        // 8 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 8);

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveTargetReached(5);
        // 1 record was deleted
        $this->assertEqual($result, 1);
        // 7 records remain
        $this->assertEqual($this->_countRowsInDSAZA(), 7);
    }

    public function _countRowsInDSAZA()
    {
        $doDSAZA = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        return $doDSAZA->count('*');
    }
}
