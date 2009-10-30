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
 * A class for testing the Campaign DAL library
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_CampaignTest extends UnitTestCase
{

    public function setUp()
    {
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
        // OX_oxMarket_Dal_Advertiser could be initialised from plugin directory during plugin installation
        if (!class_exists('OX_oxMarket_Dal_Campaign')) {
            require_once dirname(__FILE__).'/../../Campaign.php';
        }
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::uninstallPluginPackage('openXMarket', false);
    }
    
    public function testSaveCampaign(){
        $oCampaignDAL = new OX_oxMarket_Dal_Campaign();
        $aBaseCampaign = array (
            'campaignname' => 'Market campaign',
            'clientid' => 1,
            'impressions' => -1,
            'priority' => 7,
            'weight' => 0,
            'target_impression' => 20000,
            'min_impressions' => 1,
            'activate_time' => '2009-09-28 23:00:00',
            'expire_time' => '2109-09-29 22:59:59',
        );
        
        // Test insert
        $aCampaign = $aBaseCampaign;
        $errors = $oCampaignDAL->saveCampaign($aCampaign);
        $this->assertNull($errors);
        $this->assertNotNull($aCampaign['campaignid']);
        
        $oCampaign = OA_Dal::staticGetDO('campaigns', $aCampaign['campaignid']);
        $this->assertEqual($oCampaign->campaignname, $aCampaign['campaignname']);
        $this->assertEqual($oCampaign->clientid, $aCampaign['clientid']);
        $this->assertEqual($oCampaign->views, $aCampaign['impressions']);
        $this->assertEqual($oCampaign->priority, $aCampaign['priority']);
        $this->assertEqual($oCampaign->weight, $aCampaign['weight']);
        $this->assertEqual($oCampaign->target_impression, $aCampaign['target_impression']);
        $this->assertEqual($oCampaign->min_impressions, $aCampaign['min_impressions']);
        $this->assertEqual($oCampaign->activate_time, $aCampaign['activate_time']);
        $this->assertEqual($oCampaign->expire_time, $aCampaign['expire_time']);
        $this->assertEqual($oCampaign->type, DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CONTRACT);
        $this->assertEqual($oCampaign->status, OA_ENTITY_STATUS_RUNNING);
        
        // is market banner set?
        $oBanners = OA_Dal::factoryDO('banners');
        $oBanners->campaignid = $aCampaign['campaignid'];
        $oBanners->find();
        $this->assertTrue($oBanners->fetch());
        $this->assertEqual($oBanners->width, -1);
        $this->assertEqual($oBanners->height, -1);
        $this->assertEqual($oBanners->contenttype, 'html');
        $this->assertEqual($oBanners->storagetype, 'html');
        $this->assertEqual($oBanners->ext_bannertype, DataObjects_Banners::BANNER_TYPE_MARKET);
        $this->assertEqual($oBanners->status, OA_ENTITY_STATUS_RUNNING);
        $this->assertEqual($oBanners->description, 'OpenX Market contract campaign ads');
        $this->assertFalse($oBanners->fetch());
        
        // is campaign opted-in?
        $doCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doCampaignPref->campaignid = $aCampaign['campaignid'];
        $doCampaignPref->find();
        $doCampaignPref->fetch();
        $this->assertEqual($doCampaignPref->is_enabled, 1);
        $this->assertEqual($doCampaignPref->floor_price, 0.0);
        
        // Test update
        $aCampaign['target_impression'] = 10000;
        $aCampaign['impressions'] = 20000;
        $aCampaign['priority'] = 4;
        
        $errors = $oCampaignDAL->saveCampaign($aCampaign);
        $this->assertNull($errors);
        $oCampaign = OA_Dal::staticGetDO('campaigns', $aCampaign['campaignid']);
        $this->assertEqual($oCampaign->campaignname, $aCampaign['campaignname']);
        $this->assertEqual($oCampaign->clientid, $aCampaign['clientid']);
        $this->assertEqual($oCampaign->views, $aCampaign['impressions']);
        $this->assertEqual($oCampaign->priority, $aCampaign['priority']);
        $this->assertEqual($oCampaign->weight, $aCampaign['weight']);
        $this->assertEqual($oCampaign->target_impression, $aCampaign['target_impression']);
        $this->assertEqual($oCampaign->min_impressions, $aCampaign['min_impressions']);
        $this->assertEqual($oCampaign->activate_time, $aCampaign['activate_time']);
        $this->assertEqual($oCampaign->expire_time, $aCampaign['expire_time']);
        $this->assertEqual($oCampaign->type, DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CONTRACT);
        $this->assertEqual($oCampaign->status, OA_ENTITY_STATUS_RUNNING);

        // is market banner set, is not doubled?
        $oBanners = OA_Dal::factoryDO('banners');
        $oBanners->campaignid = $aCampaign['campaignid'];
        $this->assertEqual($oBanners->count(),1);
    }
}
