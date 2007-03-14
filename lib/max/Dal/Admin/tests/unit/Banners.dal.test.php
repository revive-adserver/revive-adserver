<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing DAL Banners methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_BannersTest extends DalUnitTestCase
{
    var $dalBanners;
    
    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_BannersTest()
    {
        $this->UnitTestCase();
    }
    
    function setUp()
    {
        $this->dalBanners = MAX_DB::factoryDAL('banners');
    }
    
    function tearDown()
    {
        DataGenerator::cleanUp();
    }
    
    function testGetAllBanners()
    {
        // Insert banners
        $numBanners = 2;
        $doBanners = MAX_DB::factoryDO('banners');
        $aBannerId = DataGenerator::generate($doBanners, $numBanners);
                
        // Call method
        $aBanners = $this->dalBanners->getAllBanners('name', 'up');
        
        // Test same number of banners are returned.
        $this->assertEqual(count($aBanners), $numBanners);
    }
    
    function testCountActiveBanners()
    {
        // Insert an active campaign
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->active = 't';
        $activeCampaignId = DataGenerator::generateOne($doCampaigns);
        
        // Insert an active banner
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->active = 't';
        $doBanners->campaignid = $activeCampaignId;
        $activeBannerId = DataGenerator::generateOne($doBanners);
        
        // Insert an inactive banner
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->active = 'f';
        $doBanners->campaignid = $activeCampaignId;
        $inactiveBannerId = DataGenerator::generateOne($doBanners);
        
        // Count the active banners
        $expected = 1;
        $activeCount = $this->dalBanners->countActiveBanners();        
        $this->assertEqual($activeCount, $expected);
    }
    
    function testCountActiveBannersUnderAgency()
    {
        $agencyId = 1;
        
        // Insert an advertiser under this agency.
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->agencyid = $agencyId;
        $agencyClientId = DataGenerator::generateOne($doClients);
        
        // Insert an active campaign with this client
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->active = 't';
        $doCampaigns->clientid = $agencyClientId;
        $agencyCampaignIdActive = DataGenerator::generateOne($doCampaigns);
        
        // Insert an active banner in this campaign
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->active = 't';
        $doBanners->campaignid = $agencyCampaignIdActive;
        $agencyBannerIdActive = DataGenerator::generateOne($doBanners);
        
        // Insert an inactive banner in this campaign
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->active = 'f';
        $doBanners->campaignid = $agencyCampaignIdActive;
        $agencyBannerIdInactive = DataGenerator::generateOne($doBanners);
        
        // Insert an advertiser under no agency.
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->agencyid = 0;
        $noAgencyClientId = DataGenerator::generateOne($doClients);
        
         // Insert an active campaign with this client
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->active = 't';
        $doCampaigns->clientid = $noAgencyClientId;
        $noAgencyCampaignIdActive = DataGenerator::generateOne($doCampaigns);
        
        // Insert an active banner in this campaign
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->active = 't';
        $doBanners->campaignid = $noAgencyCampaignIdActive;
        $noAgencyBannerIdActive = DataGenerator::generateOne($doBanners);
                
        // Count the active banners
        $expected = 1;
        $activeCount = $this->dalBanners->countActiveBannersUnderAgency($agencyId);

        $this->assertEqual($activeCount, $expected);
    }
    
    function testGetBannerByKeyword()
    {
        // Search for banners when none exist
        $expected = 0;
        $rsBanners = $this->dalBanners->getBannerByKeyword('foo');
        $rsBanners->find();
        $actual = $rsBanners->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $agencyId = 1;
        $rsBanners = $this->dalBanners->getBannerByKeyword('foo', $agencyId);
        $rsBanners->find();
        $actual = $rsBanners->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Insert a banner (and it's parent campaign/client)
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->description = 'foo';
        $doBanners->alt = 'bar';
        $doBanners->campaignid = $campaignId;
        $bannerId = DataGenerator::generateOne($doBanners, true);
        
        // Search for banner by description
        $expected = 1;
        $rsBanners = $this->dalBanners->getBannerByKeyword('foo');
        $rsBanners->find();
        $actual = $rsBanners->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Search for banner by alt
        $expected = 1;
        $rsBanners = $this->dalBanners->getBannerByKeyword('bar');
        $rsBanners->find();
        $actual = $rsBanners->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Restrict to agency ID (client was created with default agency ID of 1)
        $expected = 1;
        $rsBanners = $this->dalBanners->getBannerByKeyword('bar', $agencyId);
        $rsBanners->find();
        $actual = $rsBanners->getRowCount();
        $this->assertEqual($actual, $expected);
    }
}

?>
