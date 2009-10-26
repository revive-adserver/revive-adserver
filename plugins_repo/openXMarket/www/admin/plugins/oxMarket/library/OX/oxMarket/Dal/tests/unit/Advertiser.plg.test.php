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


/**
 * A class for testing the Advertiser DAL library
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_AdvertiserTest extends UnitTestCase
{

    public function setUp()
    {
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
        // OX_oxMarket_Dal_Advertiser could be initialised from plugin directory during plugin installation
        if (!class_exists('OX_oxMarket_Dal_Advertiser')) {
            require_once dirname(__FILE__).'/../../Advertiser.php';
        }
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::uninstallPluginPackage('openXMarket', false);
    }
    
    public function testCreateMarketAdvertiser(){
        $oAdvertiserDal = new OX_oxMarket_Dal_Advertiser();
        $agencyid = 23;
        // create market advertiser
        $advertiserId = $oAdvertiserDal->createMarketAdvertiser($agencyid);
        $this->assertNotNull($advertiserId);
        // check advertiser
        $doAdvertiser = OA_Dal::staticGetDO('clients', $advertiserId);
        $this->assertEqual($doAdvertiser->agencyid, $agencyid);
        $this->assertEqual($doAdvertiser->clientname, 'OpenX Market Advertiser');
        $this->assertEqual($doAdvertiser->contact, 'OpenX Market Advertiser');
        $this->assertEqual($doAdvertiser->reportdeactivate, 'f');
        $this->assertEqual($doAdvertiser->type, DataObjects_Clients::ADVERTISER_TYPE_MARKET);
        $this->assertNotNull($doAdvertiser->account_id);
        // account should be created
        $accountId = $doAdvertiser->account_id;
        $doAccount = OA_Dal::staticGetDO('accounts', $accountId);
        $this->assertEqual($doAccount->account_type, OA_ACCOUNT_ADVERTISER);
        $this->assertEqual($doAccount->account_name, 'OpenX Market Advertiser');
        // check market campaign optin campaign 
        $doCampaign = OA_DAl::factoryDO('campaigns');
        $doCampaign->clientid = $advertiserId;
        $doCampaign->type = DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CAMPAIGN_OPTIN;
        $doCampaign->find();
        $this->assertTrue($doCampaign->fetch());
        $this->assertEqual($doCampaign->campaignname, 'OpenX Market ads served to opted in campaigns');
        $this->assertEqual($doCampaign->ecpm_enabled, 0);
        $this->assertNull($doCampaign->revenue_type);
        $this->assertEqual($doCampaign->priority, DataObjects_Campaigns::PRIORITY_MARKET_REMNANT);
        $campaignId = $doCampaign->campaignid;
        // only one campaign-optin campaign 
        $this->assertFalse($doCampaign->fetch());
        // is banner created for that campaign
        $doBanner = OA_Dal::factoryDO('banners');
        $doBanner->campaignid = $campaignId;
        $doBanner->find();
        $this->assertTrue($doBanner->fetch());
        $this->assertEqual($doBanner->width, -1);
        $this->assertEqual($doBanner->height, -1);
        $this->assertEqual($doBanner->contenttype, 'html');
        $this->assertEqual($doBanner->storagetype, 'html');
        $this->assertEqual($doBanner->ext_bannertype, DataObjects_Banners::BANNER_TYPE_MARKET);
        $this->assertEqual($doBanner->status, OA_ENTITY_STATUS_RUNNING);
        $this->assertEqual($doBanner->description, 'OpenX Market ads served to opted in campaigns');
        // only one banner under market campaign
        $this->assertFalse($doBanner->fetch());     
        
        // check market zone optin campaign 
        $doCampaign = OA_DAl::factoryDO('campaigns');
        $doCampaign->clientid = $advertiserId;
        $doCampaign->type = DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_ZONE_OPTIN;
        $doCampaign->find();
        $this->assertTrue($doCampaign->fetch());
        $this->assertEqual($doCampaign->campaignname, 'OpenX Market ads served to zones by default');
        $this->assertEqual($doCampaign->ecpm_enabled, 0);
        $this->assertNull($doCampaign->revenue_type);
        $this->assertEqual($doCampaign->priority, DataObjects_Campaigns::PRIORITY_MARKET_REMNANT);
        $campaignId = $doCampaign->campaignid;
        // only one campaign-optin campaign 
        $this->assertFalse($doCampaign->fetch());
        // is banner created for that campaign
        $doBanner = OA_Dal::factoryDO('banners');
        $doBanner->campaignid = $campaignId;
        $doBanner->find();
        $this->assertTrue($doBanner->fetch());
        $this->assertEqual($doBanner->width, -1);
        $this->assertEqual($doBanner->height, -1);
        $this->assertEqual($doBanner->contenttype, 'html');
        $this->assertEqual($doBanner->storagetype, 'html');
        $this->assertEqual($doBanner->ext_bannertype, DataObjects_Banners::BANNER_TYPE_MARKET);
        $this->assertEqual($doBanner->status, OA_ENTITY_STATUS_RUNNING);
        $this->assertEqual($doBanner->description, 'OpenX Market ads served to zones by default');
        // only one banner under market campaign
        $this->assertFalse($doBanner->fetch());

        // Count campaigns under market advertiser
        $doCampaigns = OA_DAl::factoryDO('campaigns');
        $doCampaigns->clientid = $advertiserId;
        $this->assertEqual($doCampaigns->count(),2);
        
        // Test: try to add another advertiser to manager
        $advertiserId2 = $oAdvertiserDal->createMarketAdvertiser($agencyid);
        $this->assertEqual($advertiserId2, $advertiserId);
        // Count campaigns under market advertiser
        $doCampaigns = OA_DAl::factoryDO('campaigns');
        $doCampaigns->clientid = $advertiserId2;
        $this->assertEqual($doCampaigns->count(),2);
        
        // Clean up
        $doAdvertiserAccount = OA_Dal::staticGetDO('accounts', $accountId);
        $doAdvertiserAccount->delete();
    }
    
    
    public function testGetMarketAdvertiser(){
        $oAdvertiserDal = new OX_oxMarket_Dal_Advertiser();
        $agencyid = 23;
        
        // not existing agency
        $this->assertNull($oAdvertiserDal->getMarketAdvertiser($agencyid));
        
        // agency with normal advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_DEFAULT;
        $clientId = DataGenerator::generateOne($doClients, true);      
        $agencyid = DataGenerator::getReferenceId('agency');
        $this->assertNull($oAdvertiserDal->getMarketAdvertiser($agencyid));
        
        // agency with market advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $clientId = DataGenerator::generateOne($doClients, true);      
        $agencyid = DataGenerator::getReferenceId('agency');
        
        $doClients =  $oAdvertiserDal->getMarketAdvertiser($agencyid);
        $this->assertEqual($doClients->clientid, $clientId);
        
    }
    
    public function testCreateMissingMarketAdvertisers()
    {
        $oAdvertiserDal = new OX_oxMarket_Dal_Advertiser();
        // Test method when no account is associated
        $oAdvertiserDal->createMissingMarketAdvertisers(true);
        $oAdvertiserDal->createMissingMarketAdvertisers(false);
        
        // Count market advertisers
        $doClients = OA_DAl::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $this->assertEqual($doClients->count(),0);
        
        // Create account and set publisher account association data
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->account_id = $adminAccountId;
        $doExtMarket->insert();
        
        $oAdvertiserDal->createMissingMarketAdvertisers(false);
        // Count market advertisers
        $doClients = OA_DAl::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $this->assertEqual($doClients->count(),0);
        
        // Create new managers
        $doAgency = OA_Dal::factoryDO('agency');
        $aAgencyId[1] = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $aAgencyId[2] = DataGenerator::generateOne($doAgency);
     
        $oAdvertiserDal->createMissingMarketAdvertisers(false);
        // Count market advertisers
        $doClients = OA_DAl::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $this->assertEqual($doClients->count(),2);
        
        // run again (should not add new advertisers)
        $oAdvertiserDal->createMissingMarketAdvertisers(false);
        // Count market advertisers
        $doClients = OA_DAl::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $this->assertEqual($doClients->count(),2);
      
        // add new manager
        $doAgency = OA_Dal::factoryDO('agency');
        $aAgencyId[3] = DataGenerator::generateOne($doAgency);

        // run again (should add 1 new advertisers)
        $oAdvertiserDal->createMissingMarketAdvertisers(false);
        // Count market advertisers
        $doClients = OA_DAl::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $this->assertEqual($doClients->count(),3);

        // Clear market advertisers
        $doAdvertiserAccount = OA_Dal::factoryDO('accounts');
        $doAdvertiserAccount->account_type = OA_ACCOUNT_ADVERTISER;
        $doAdvertiserAccount->delete();

        // clear admin account association
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->account_id = $adminAccountId;
        $doExtMarket->delete();
      
        // Test multiple account mode
        $oAdvertiserDal->createMissingMarketAdvertisers(true);
        // Count market advertisers
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $this->assertEqual($doClients->count(),0);
        
        // get accounts ids for agencies
        foreach ($aAgencyId as $i => $agencyid) {
            $doAgency = OA_Dal::staticGetDO('agency', $agencyid);
            $aAgencyAccountId[$i] = $doAgency->account_id;
        }
        // register 2 advertisers
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->account_id = $aAgencyAccountId[1];
        $doExtMarket->insert();
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->account_id = $aAgencyAccountId[2];
        $doExtMarket->insert();

        $oAdvertiserDal->createMissingMarketAdvertisers(true);
        // Count market advertisers
        $doClients = OA_DAl::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $this->assertEqual($doClients->count(),2);

        // add another one
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->account_id = $aAgencyAccountId[3];
        $doExtMarket->insert();
        
        $oAdvertiserDal->createMissingMarketAdvertisers(true);
        // Count market advertisers
        $doClients = OA_DAl::factoryDO('clients');
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $this->assertEqual($doClients->count(),3);

        // Clean up
        // clear market association
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->whereAdd('1=1');
        $doExtMarket->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // Clear market advertisers
        $doAdvertiserAccount = OA_Dal::factoryDO('accounts');
        $doAdvertiserAccount->account_type = OA_ACCOUNT_ADVERTISER;
        $doAdvertiserAccount->delete();
    }
    
    
    public function testCreateMarketAdvertiserByManagerAccountId()
    {
        Mock::generatePartial(
            'OX_oxMarket_Dal_Advertiser',
            'PartialMockOX_oxMarket_Dal_Advertiser',
            array('createMarketAdvertiser')
        );
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        $accountId = $doAgency->account_id;
        $marketAdvId = 12344321;
        
        $oAdvertiserDal = new PartialMockOX_oxMarket_Dal_Advertiser();
        $oAdvertiserDal->setReturnValue('createMarketAdvertiser', $marketAdvId);
        $oAdvertiserDal->expectOnce('createMarketAdvertiser', array($accountId));
        
        $result = $oAdvertiserDal->createMarketAdvertiserByManagerAccountId($accountId);
        $this->assertEqual($result, $marketAdvId);
    }
}
