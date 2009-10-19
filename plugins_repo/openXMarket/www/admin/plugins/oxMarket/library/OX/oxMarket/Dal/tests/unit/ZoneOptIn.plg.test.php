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
$Id: mergeCopyTarget277.tmp 44463 2009-10-08 14:48:24Z lukasz.wikierski $
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the ZoneOptIn DAL library
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfOX_oxMarket_Dal_ZoneOptIn extends UnitTestCase
{
    public function setUp()
    {
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
        // OX_oxMarket_Dal_ZoneOptIn is initialised from plugin directory during plugin installation
        if (!class_exists('OX_oxMarket_Dal_ZoneOptIn')) {
            require_once dirname(__FILE__).'/../../ZoneOptIn.php';
        }
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::uninstallPluginPackage('openXMarket', false);
    }

    
    public function testUpdateZoneOptInStatus()
    {
        $entitiesIds = $this->_prepareDatabase();
        $zoneOptInDal = new OX_oxMarket_Dal_ZoneOptIn();
        
        // optin zone
        $res = $zoneOptInDal->updateZoneOptInStatus($entitiesIds['zoneId'], true);
        $this->assertTrue($res);
        
        $doPlZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $doPlZoneAssoc->zone_id = $zoneId;
        $doPlZoneAssoc->campaignid = $oCampaign->campaignid;
        $this->assertEqual($doPlZoneAssoc->count(),1);
        
        // optin again
        $res = $zoneOptInDal->updateZoneOptInStatus($entitiesIds['zoneId'], true);
        $this->assertTrue($res);
        
        $doPlZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $doPlZoneAssoc->zone_id = $zoneId;
        $doPlZoneAssoc->campaignid = $oCampaign->campaignid;
        $this->assertEqual($doPlZoneAssoc->count(),1);
        
        // optout zone
        $res = $zoneOptInDal->updateZoneOptInStatus($entitiesIds['zoneId'], false);
        $this->assertTrue($res);
        
        $doPlZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $doPlZoneAssoc->zone_id = $zoneId;
        $doPlZoneAssoc->campaignid = $oCampaign->campaignid;
        $this->assertEqual($doPlZoneAssoc->count(),0);
        
        // opt-out again
        $res = $zoneOptInDal->updateZoneOptInStatus($entitiesIds['zoneId'], false);
        $this->assertTrue($res);
        
        // invalid zone id
        $res = $zoneOptInDal->updateZoneOptInStatus($entitiesIds['zoneId']-1, false);
        $this->assertFalse($res);
    }
    
    
    public function testIsOptedIn()
    {
        $entitiesIds = $this->_prepareDatabase();
        $zoneOptInDal = new OX_oxMarket_Dal_ZoneOptIn();
        $dalZones = OA_Dal::factoryDAL('zones');
        
        $this->assertFalse($zoneOptInDal->isOptedIn($entitiesIds['zoneId']));

        $dalZones->linkZonesToCampaign(array($entitiesIds['zoneId']), 
                                       $entitiesIds['campaignId']);
                                       
        $this->assertTrue($zoneOptInDal->isOptedIn($entitiesIds['zoneId']));
        $this->assertFalse($zoneOptInDal->isOptedIn($entitiesIds['zoneId']-1));
        
        $dalZones->unlinkZonesFromCampaign(array($entitiesIds['zoneId']), 
                                       $entitiesIds['campaignId']);
        
        $this->assertFalse($zoneOptInDal->isOptedIn($entitiesIds['zoneId']));
    }
    
    
    /**
     * Prepare agency with websites, zones and creates market advertiser and default campaign
     *
     * @return array
     */
    private function _prepareDatabase()
    {
        $result = array();
        // Create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Ad Network Manager';
        $result['agencyId'] = DataGenerator::generateOne($doAgency);
        
        // Generate websites and zones
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $result['agencyId'];
        $result['affiliateId'] = DataGenerator::generateOne($doAffiliate);
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $result['affiliateId'];
        $doZones->width = 468;
        $doZones->height = 60;
        $result['zoneId'] = DataGenerator::generateOne($doZones);
        // Generate market advertisers and campaigns
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $result['agencyId'];
        $doClients->clientname = 'OpenX Market'; // TODO: create proper system market agency
        $result['clientId'] = DataGenerator::generateOne($doClients);
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $result['clientId'];
        $doCampaigns->campaignname = 'OpenX Market - Default Campaign';  // TODO: create proper system market campaign
        $result['campaignId'] = DataGenerator::generateOne($doCampaigns);
        
        return $result;
    }
    
}
