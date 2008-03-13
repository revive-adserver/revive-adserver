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


require_once MAX_PATH . '/lib/OA/Maintenance/Pruning.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/pear/Date/Span.php';

/**
 * A class for performing an integration test of the Maintenance Pruning functions
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class Test_Priority extends UnitTestCase
{
    /**
     * A local instance of the database handler object.
     *
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    /**
     * The constructor method.
     */
    function Test_Priority()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to be run before all tests.
     */
    function setUp()
    {
        // Set up the database handler object
        $this->oDbh =& OA_DB::singleton();

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $aIds = DataGenerator::generate($doCampaigns,2);
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
    function tearDown()
    {
        // Clean up the testing environment
        TestEnv::restoreEnv();
    }


    /**
     * Pruning can be performed where zone_id = 0 (i.e. for direct selection) and where the entry is older than MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT minutes ago.
     *
     */
    function testPruneDataSummaryAdZoneAssocOldData()
    {
        $oDate      = new Date();
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('now', $oDate);
        $oDal       =& new OA_Maintenance_Pruning();
        $doDSAZA    = OA_Dal::factoryDO('data_summary_ad_zone_assoc');

        // Test 1: table is empty : nothing to delete
        $this->assertEqual($this->_countRowsInDSAZA(),0);
        $this->assertFalse($oDal->_pruneDataSummaryAdZoneAssocOldData());

        // generate 4 records
        $aIds = DataGenerator::generate($doDSAZA,4);
        $this->assertEqual($this->_countRowsInDSAZA(),4);

        // Test 2: values are current, zone_id = 1 : nothing to delete
        $this->assertFalse($oDal->_pruneDataSummaryAdZoneAssocOldData());
        $this->assertEqual($this->_countRowsInDSAZA(),4);

        // Test 3: values are old, zone_id = 1 : should not delete anything
        foreach ($aIds as $k => $id)
        {
            $oDate->subtractSeconds((MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT+100));
            $doDSAZA->data_summary_ad_zone_assoc_id = $id;
            $doDSAZA->find(true);
            $doDSAZA->created = $oDate->getDate();
            $doDSAZA->zone_id = 1;
            $doDSAZA->update();
        }
        $this->assertFalse($oDal->_pruneDataSummaryAdZoneAssocOldData());
        $this->assertEqual($this->_countRowsInDSAZA(),4);

        // Test 4: values are old, zone_id = 0 : should delete 4 records
        foreach ($aIds as $k => $id)
        {
            $doDSAZA->data_summary_ad_zone_assoc_id = $id;
            $doDSAZA->find(true);
            $doDSAZA->zone_id = 0;
            $doDSAZA->update();
        }
        $this->assertTrue($oDal->_pruneDataSummaryAdZoneAssocOldData());
        $this->assertEqual($this->_countRowsInDSAZA(),0);
    }

    /**
     * Prune all entries where the ad_id is for a banner in a High Priority Campaign where:
    * The campaign does not have any booked lifetime target values AND the capaign has an end date AND the end date has been passed AND the campaign is not active.
     *
     */
    function testpruneDataSummaryAdZoneAssocInactiveExpired()
    {
        $oToday     = new Date();
        $oExpire    = new Date();
        $oExpire->subtractSeconds(999999);
        $today      = $oToday->getDate();
        $expire     = $oExpire->getDate();
        $oDal       =& new OA_Maintenance_Pruning();

        $doDSAZA    = OA_Dal::factoryDO('data_summary_ad_zone_assoc');

        // generate 2 summary ad_zone records for an active campaign ad_id
        $doDSAZA->ad_id = $this->idBanner1;
        $aIds = DataGenerator::generate($doDSAZA,2);

        // generate 7 summary ad_zone records for an inactive campaign ad_id
        $doDSAZA->ad_id = $this->idBanner2;
        $aIds = DataGenerator::generate($doDSAZA,7);

        // make sure 9 rows in table
        $this->assertEqual($this->_countRowsInDSAZA(),9);

        // ad_id 1 => campaignid 1 => active, high priority, not expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority          = 5;
        $doCampaigns->status            = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 0;
        $doCampaigns->clicks            = 0;
        $doCampaigns->conversions       = 0;
        $doCampaigns->expire            = OA_Dal::noDateString();
        $doCampaigns->update();

        // ad_id 2 => campaignid 2 => not active, high priority, expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign2);
        $doCampaigns->priority          = 5;
        $doCampaigns->status            = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 0;
        $doCampaigns->clicks            = 0;
        $doCampaigns->conversions       = 0;
        $doCampaigns->expire            = $expire;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 7 records were deleted
        $this->assertEqual($result,7);
        // 2 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),2);

        // ad_id 1 => campaignid 1 => not active, exclusive (low priority)
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority          = -1;
        $doCampaigns->status            = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 0;
        $doCampaigns->clicks            = 0;
        $doCampaigns->conversions       = 0;
        $doCampaigns->expire            = $expire;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 0 records were deleted
        $this->assertEqual($result,0);
        // 2 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),2);

        // ad_id 1 => campaignid 1 => not active, high priority, not expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority          = 5;
        $doCampaigns->status            = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 0;
        $doCampaigns->clicks            = 0;
        $doCampaigns->conversions       = 0;
        $doCampaigns->expire            = OA_Dal::noDateString();
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 0 records were deleted
        $this->assertEqual($result,0);
        // 2 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),2);

        // ad_id 1 => campaignid 1 => not active, high priority, expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority          = 5;
        $doCampaigns->status            = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 0;
        $doCampaigns->clicks            = 0;
        $doCampaigns->conversions       = 0;
        $doCampaigns->expire            = $expire;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 2 records were deleted
        $this->assertEqual($result,2);
        // 0 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),0);

        // generate 2 summary ad_zone records for an active campaign that expires today
        $doDSAZA->ad_id = 1;
        $aIds = DataGenerator::generate($doDSAZA,2);
        $this->assertEqual($this->_countRowsInDSAZA(),2);

        // ad_id 1 => campaignid 1 => active, high priority, expires today
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority          = 5;
        $doCampaigns->status            = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 0;
        $doCampaigns->clicks            = 0;
        $doCampaigns->conversions       = 0;
        $doCampaigns->expire            = $today;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 0 records were deleted
        $this->assertEqual($result,0);
        // 2 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),2);

        // ad_id 1 => campaignid 1 => active, high priority, expired
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority          = 5;
        $doCampaigns->status            = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 0;
        $doCampaigns->clicks            = 0;
        $doCampaigns->conversions       = 0;
        $doCampaigns->expire            = $expire;
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveExpired();
        // 2 records were deleted
        $this->assertEqual($result,2);
        // 0 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),0);
    }

    /**
     * Prune all entries where the ad_id is for a banner in a High Priority Campaign where:
     * The campaign has a booked number of lifetime target impressions and/or clicks and/or conversions AND the campaign is not active AND at least one of the booked lifetime target values has been reached.
     *
     */
    function testpruneDataSummaryAdZoneAssocTargetReached()
    {
        $oToday     = new Date();
        $oExpire    = new Date();
        $oExpire->subtractSeconds(999999);
        $today      = $oToday->getDate();
        $expire     = $oExpire->getDate();
        $oDal       =& new OA_Maintenance_Pruning();

        $doDSAZA    = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDIA      = OA_Dal::factoryDO('data_intermediate_ad');

        $aDIAs = DataGenerator::generate($doDIA,4);

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
        $aIds = DataGenerator::generate($doDSAZA,2);

        // generate 7 summary ad_zone records for an inactive campaign ad_id
        $doDSAZA->ad_id = $this->idBanner2;
        $aIds = DataGenerator::generate($doDSAZA,7);

        // make sure 9 rows in table
        $this->assertEqual($this->_countRowsInDSAZA(),9);

        // ad_id 1 => campaignid 1 => active, high priority, not expired, target impressions not reached
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority          = 5;
        $doCampaigns->status            = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 100000;
        $doCampaigns->clicks            = 1000;
        $doCampaigns->conversions       = 100;
        $doCampaigns->expire            = OA_Dal::noDateString();
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveTargetReached(1);
        // 0 records were deleted
        $this->assertEqual($result,0);
        // 0 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),9);

        // ad_id 1 => campaignid 1 => not active, high priority, not expired, target impressions reached
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $this->idCampaign1);
        $doCampaigns->priority          = 5;
        $doCampaigns->status            = OA_ENTITY_STATUS_EXPIRED;
        $doCampaigns->target_impression = 0;
        $doCampaigns->target_click      = 0;
        $doCampaigns->target_conversion = 0;
        $doCampaigns->views             = 1111;
        $doCampaigns->clicks            = 111;
        $doCampaigns->conversions       = 11;
        $doCampaigns->expire            = OA_Dal::noDateString();
        $doCampaigns->update();

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveTargetReached(1);
        // 1 record deleted
        $this->assertEqual($result,1);
        // 8 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),8);

        $result = $oDal->_pruneDataSummaryAdZoneAssocInactiveTargetReached(5);
        // 1 record was deleted
        $this->assertEqual($result,1);
        // 7 records remain
        $this->assertEqual($this->_countRowsInDSAZA(),7);
    }

    function _countRowsInDSAZA()
    {
        $doDSAZA = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        return $doDSAZA->count('*');
    }
}

?>
