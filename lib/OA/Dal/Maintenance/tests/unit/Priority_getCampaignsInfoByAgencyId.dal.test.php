<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id: Priority_getCampaigns.dal.test.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';

/**
 * A class for testing the getCampaignsInfoByAgencyId() method of
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Dal_Maintenance_Priority_getCampaignsInfoByAgencyId extends UnitTestCase
{
    public $aExpectedData = array();

    private $firsCampaignId;
    private $secondCampaignId;
    
    private $firsAdId;
    private $secondAdId;

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getCampaignsInfoByAgencyId()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getCampaignsInfoByAgencyId method.
     */
    function testGetCampaignsInfoByAgencyId()
    {
        list($agencyId1, $agencyId2) = $this->_generateAgencyCampaigns();

        $da = new OA_Dal_Maintenance_Priority();

        // Test 1 getCampaignsInfoByAgencyId method.
        $ret = $da->getCampaignsInfoByAgencyId($agencyId1);
        $this->checkTestResults($ret, $this->firsCampaignId, $this->firsAdId);

        // Test 2 getCampaignsInfoByAgencyId method.
        $ret = $da->getCampaignsInfoByAgencyId($agencyId2);
        $this->checkTestResults($ret, $this->secondCampaignId, $this->secondAdId);

        DataGenerator::cleanUp();
    }

    function checkTestResults($ret, $campaignId, $adId)
    {
        $this->assertTrue(is_array($ret));
        $aExpectedCampaign = $this->aExpectedData['campaigns'][$campaignId];
        $aExpectedAd = $this->aExpectedData['banners'][$adId];
        
        $idxAds = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_ADS;
        $idxZones = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_ZONES;
        $idxWeight = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_WEIGHT;
        $idxRevenue = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_REVENUE;
        $idxRevenueType = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_REVENUE_TYPE;
        $idxImpr = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_MIN_IMPRESSIONS;

        $aCampaign = $ret[$campaignId];
        $this->assertEqual($aExpectedCampaign['revenue'], $aCampaign[$idxRevenue]);
        $this->assertEqual($aExpectedCampaign['revenue_type'], $aCampaign[$idxRevenueType]);
        $this->assertTrue(isset($aCampaign[$idxAds][$adId]));
        $aAd = $aCampaign[$idxAds][$adId];
        $this->assertEqual($aExpectedAd['weight'], $aAd[$idxWeight]);
        $zoneId = array_shift($aAd[$idxZones]);
        $this->assertEqual($zoneId, $aExpectedAd['zone']);
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateAgencyCampaigns()
    {
        // Add agencies
        $agencyId1 = DataGenerator::generateOne('agency', true);
        $agencyId2 = DataGenerator::generateOne('agency', true);

        // Add clients
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId1;
        $clientId1 = DataGenerator::generateOne($doClients);
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId2;
        $clientId2 = DataGenerator::generateOne($doClients);

        // Add campaigns
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Test eCPM Campaign 1';
        $doCampaigns->revenue = 0.1;
        $doCampaigns->min_impressions = 100;
        $doCampaigns->priority = DataObjects_Campaigns::PRIORITY_ECPM;
        $doCampaigns->clientid = $clientId1;
        $idCampaign11 = DataGenerator::generateOne($doCampaigns);
        $this->firsCampaignId = $idCampaign11;
        $this->aExpectedData['campaigns'][$idCampaign11]['revenue'] = $doCampaigns->revenue;
        $this->aExpectedData['campaigns'][$idCampaign11]['revenue_type'] = $doCampaigns->revenue_type;
        $this->aExpectedData['campaigns'][$idCampaign11]['min_impressions'] =
            $doCampaigns->min_impressions;

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Test non eCPM Campaign 2';
        $doCampaigns->revenue = 0.2;
        $doCampaigns->min_impressions = 200;
        $doCampaigns->priority = 1;
        $doCampaigns->clientid = $clientId1;
        $idCampaign12 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Test eCPM Campaign 2';
        $doCampaigns->revenue = 0.5;
        $doCampaigns->min_impressions = 300;
        $doCampaigns->priority = DataObjects_Campaigns::PRIORITY_ECPM;
        $doCampaigns->clientid = $clientId2;
        $idCampaign2 = DataGenerator::generateOne($doCampaigns);
        $this->secondCampaignId = $idCampaign2;
        $this->aExpectedData['campaigns'][$idCampaign2]['revenue'] = $doCampaigns->revenue;
        $this->aExpectedData['campaigns'][$idCampaign2]['revenue_type'] = $doCampaigns->revenue_type;
        $this->aExpectedData['campaigns'][$idCampaign2]['min_impressions'] =
            $doCampaigns->min_impressions;

        // Add banners to campaign 11
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->weight = 1;
        $doBanners->campaignid = $idCampaign11;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $idBanner11_1 = DataGenerator::generateOne($doBanners);
        $this->firsAdId = $idBanner11_1;
        $this->aExpectedData['banners'][$idBanner11_1]['weight'] = $doBanners->weight;

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->weight = 2;
        $doBanners->campaignid = $idCampaign11;
        $doBanners->status = OA_ENTITY_STATUS_INACTIVE;
        $idBanner11_2 = DataGenerator::generateOne($doBanners);

        // Add banner to campaign 12
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->weight = 3;
        $doBanners->campaignid = $idCampaign12;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $idBanner12 = DataGenerator::generateOne($doBanners);

        // Add banner to campaign 2
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->weight = 4;
        $doBanners->campaignid = $idCampaign2;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $idBanner2 = DataGenerator::generateOne($doBanners);
        $this->secondAdId = $idBanner2;
        $this->aExpectedData['banners'][$idBanner2]['weight'] = $doBanners->weight;

        // Add zones
        $idZone1 = DataGenerator::generateOne('zones', true);
        $idZone2 = DataGenerator::generateOne('zones', true);

        // Connect zones with banners (ad_zone_assoc)
        $doAd_zone_assoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAd_zone_assoc->ad_id = $idBanner11_1;
        $doAd_zone_assoc->zone_id = $idZone1;
        DataGenerator::generateOne($doAd_zone_assoc);
        $this->aExpectedData['banners'][$idBanner11_1]['zone'] = $idZone1;

        $doAd_zone_assoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAd_zone_assoc->ad_id = $idBanner11_2;
        $doAd_zone_assoc->zone_id = $idZone1;
        DataGenerator::generateOne($doAd_zone_assoc);

        $doAd_zone_assoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAd_zone_assoc->ad_id = $idBanner12;
        $doAd_zone_assoc->zone_id = $idZone1;
        DataGenerator::generateOne($doAd_zone_assoc);

        $doAd_zone_assoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAd_zone_assoc->ad_id = $idBanner2;
        $doAd_zone_assoc->zone_id = $idZone2;
        DataGenerator::generateOne($doAd_zone_assoc);
        $this->aExpectedData['banners'][$idBanner2]['zone'] = $idZone2;

        return array($agencyId1, $agencyId2);
    }
}

?>