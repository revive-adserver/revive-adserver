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
require_once MAX_PATH . '/lib/max/Dal/Admin/Trackers.php';

/**
 * A class for testing the Entity Service class for the "trackers" table.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 */
class MAX_Dal_Admin_TrackersTest extends DalUnitTestCase
{

    var $dalTrackers;

    public function setUp()
    {
        $this->dalTrackers = OA_Dal::factoryDAL('trackers');
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
    }

    public function testGetLinkedCampaigns()
    {
        $trackerId = 5;
        $nonexistentTrackerId = 999;

        // Create a some campaigns
        $numLinkedCampaigns = 2;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $aCampaignIds = DataGenerator::generate($doCampaigns, $numLinkedCampaigns);

        // Create tracker links for them
        foreach ($aCampaignIds as $campaignId) {
            $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
            $doCampaignsTrackers->trackerid = $trackerId;
            $doCampaignsTrackers->campaignid = $campaignId;
            DataGenerator::generateOne($doCampaignsTrackers);
        }

        // Ad a campaign that is not linked.
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $aLinkedCampaigns = $this->dalTrackers->getLinkedCampaigns($trackerId);
        $this->assertEqual($numLinkedCampaigns, count($aLinkedCampaigns));

        foreach ($aLinkedCampaigns as $campaignId => $campaign) {
            $this->assertIsA($campaign, 'DataObjects_Campaigns', "Object not of type DataObjects_Campaigns");
        }

        // Check for nonexist
        $aLinkedCampaigns = $this->dalTrackers->getLinkedCampaigns($nonexistentTrackerId);
        $this->assertEmpty($aLinkedCampaigns);
    }

    public function testLinkCampaign()
    {
        // Setup
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->status = MAX_CONNECTION_STATUS_APPROVED;
        $trackerId = DataGenerator::generateOne($doTrackers);

        // Link em
        $result = $this->dalTrackers->linkCampaign($trackerId, $campaignId);
        $this->assertTrue($result);

        // Test already linked
        $result = $this->dalTrackers->linkCampaign($trackerId, $campaignId);
        $this->assertTrue($result);

        // Get the new link from the DB.
        $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaignsTrackers->trackerid = $trackerId;
        $doCampaignsTrackers->campaignid = $campaignId;
        $result = $doCampaignsTrackers->find(true);

        $this->assertEqual(1, $result);
        $this->assertEqual($campaignId, $doCampaignsTrackers->campaignid);
        $this->assertEqual($trackerId, $doCampaignsTrackers->trackerid);
        $this->assertEqual(MAX_CONNECTION_STATUS_APPROVED, $doCampaignsTrackers->status);

        // Link with custom status
        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->status = MAX_CONNECTION_STATUS_APPROVED;
        $trackerId = DataGenerator::generateOne($doTrackers);

        $result = $this->dalTrackers->linkCampaign($trackerId, $campaignId, MAX_CONNECTION_STATUS_PENDING);
        $this->assertTrue($result);
        $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaignsTrackers->trackerid = $trackerId;
        $doCampaignsTrackers->campaignid = $campaignId;
        $result = $doCampaignsTrackers->find(true);

        $this->assertEqual(1, $result);
        $this->assertEqual($campaignId, $doCampaignsTrackers->campaignid);
        $this->assertEqual($trackerId, $doCampaignsTrackers->trackerid);
        $this->assertEqual(MAX_CONNECTION_STATUS_PENDING, $doCampaignsTrackers->status);

        // Link invalid IDs
        $invalidId = 9999;

        $result = $this->dalTrackers->linkCampaign($trackerId, $invalidId);
        $this->assertFalse($result);

        $result = $this->dalTrackers->linkCampaign($invalidId, $campaignId);
        $this->assertFalse($result);

        $result = $this->dalTrackers->linkCampaign($invalidId, $invalidId);
        $this->assertFalse($result);
    }
}

?>
