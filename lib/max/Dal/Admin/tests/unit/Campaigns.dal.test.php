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

require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Campaigns.php';
require_once MAX_PATH . '/lib/max/tests/util/DataGenerator.php';

/**
 * A class for testing DAL Campaigns methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_CampaignsTest extends UnitTestCase
{
    var $dalCampaigns;
    
    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_CampaignsTest()
    {
        $this->UnitTestCase();
    }
    
    function setUp()
    {
        $this->dalCampaigns = MAX_DB::factoryDAL('campaigns');
    }
    
    function tearDown()
    {
        TestEnv::restoreEnv();
    }
    
    /**
     * Tests all campaigns are returned.
     *
     */
    function testGetAllCampaigns()
    {
        // Insert campaigns
        $numCampaigns = 2;
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $aCampaignId = DataGenerator::generate($doCampaigns, $numCampaigns);
                
        // Call method
        $aCampaigns = $this->dalCampaigns->getAllCampaigns('name', 'up');
        
        // Test same number of campaigns are returned.
        $this->assertEqual(count($aCampaigns), $numCampaigns);
    }
    
    
    function testCountActiveCampaigns()
    {
        // Insert an active campaign
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->active = 't';
        $activeId = DataGenerator::generateOne($doCampaigns);
        
        // Insert an inactive campaign
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->active = 'f';
        $inactiveId = DataGenerator::generateOne($doCampaigns);
        
        // Count the active campaigns
        $activeCount = $this->dalCampaigns->countActiveCampaigns();
        
        $expected = 1;
        $this->assertEqual($activeCount, $expected);
    }
    
    function testCountActiveCampaignsUnderAgency()
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
        
        // Insert an inactive campaign with this client
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->active = 'f';
        $doCampaigns->clientid = $agencyClientId;
        $agencyCampaignInactiveId = DataGenerator::generateOne($doCampaigns);
        
        // Insert an advertiser under no agency.
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->agencyid = 0;
        $noAgencyClientId = DataGenerator::generateOne($doClients);
        
         // Insert an active campaign with this client
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->active = 't';
        $doCampaigns->clientid = $noAgencyClientId;
        $noAgencyCampaignIdActive = DataGenerator::generateOne($doCampaigns);
                
        // Count the active campaigns
        $expected = 1;
        $activeCount = $this->dalCampaigns->countActiveCampaignsUnderAgency($agencyId);

        $this->assertEqual($activeCount, $expected);
    }
    
    function testGetCampaignAndClientByKeyword()
    {
        // Search for campaigns when none exist.
        $expected = 0;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('foo');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $agencyId = 1;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('foo', $agencyId);
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Create a campaign
        $doCampaign = MAX_DB::factoryDO('campaigns');
        $doCampaign->campaignname = 'foo';
        DataGenerator::generateOne($doCampaign, true);
        
        // Search for the campaign
        $expected = 0;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('bar');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);
        
        $expected = 1;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('foo');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);
        
        // Restrict the search to agency (defaults to 1)
        $agencyId = 1;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('foo', $agencyId);
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);
    }
}