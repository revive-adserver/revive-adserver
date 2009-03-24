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
require_once dirname(__FILE__) . '/../../oxMarketDelivery.delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/adRender.php';
require_once MAX_PATH . '/lib/max/Dal/Delivery.php';
require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/JSON/JSON.php';

/**
 * A class for testing the oxMarketDelivery functions
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_deliveryAdRender_oxMarketDelivery_oxMarketDeliveryTest extends UnitTestCase
{
    function setUp()
    {
        TestEnv::uninstallPluginPackage('openXMarket',false);
        TestEnv::installPluginPackage('openXMarket',false);
    }
    
    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXMarket',false);
    }
    
    function testOX_marketProcess()
    {
        $serverHttps = (isset($_SERVER['HTTPS'])) ? $_SERVER['HTTPS'] : null;
        
        // Prepare test data
        $adHtml = 'test banner';
        $aAd = array( 'width' => 468, 'height' => 60 );
        $aCampaignMarketInfo = array();
        $website_id = 12;
        $aWebsiteMarketInfo = array('website_id' => $website_id);
        $GLOBALS['_MAX']['CONF']['oxMarketDelivery']['brokerHost'] = 'brokerHost.org';

        // pattern to check OX_marketProcess result and get OXM_ad parameters and src of second script
        $pattern = '<script type="text/javascript">[[:space:]]OXM_ad = ({.*})[[:space:]]</script>[[:space:]]'.
                   '<script type="text/javascript" src="(.*)"></script>';
        /* pattern for old call
        $pattern = '<script type="text/javascript">[[:space:]]OXM_(.*) = {"t":"(.*)","f":"(.*)"}[[:space:]]</script>[[:space:]]'.
                   '<script type="text/javascript" src="(.*)"></script>';
        */
        
        // set https to on
        $_SERVER['HTTPS'] = 'on';
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        
        // check if response matches to pattern
        $this->assertTrue(ereg($pattern, $result, $aResult));
        
        // check ereg result
        $this->assertEqual(3,count($aResult));
        $this->assertFalse(empty($aResult[1]));
        $this->assertFalse(empty($aResult[2]));
        $jsonOXM_ad = $aResult[1];
        
        // Check OXM_ad json
        $oJson = new Services_JSON();
        $aOXM_ad = $oJson->decode($jsonOXM_ad);
        $this->assertEqual($aOXM_ad->website, $website_id);
        $this->assertEqual($aOXM_ad->floor, 0);
        $this->assertEqual($aOXM_ad->size, "468x60");
        $this->assertTrue(isset($aOXM_ad->beacon));
        $this->assertEqual($aOXM_ad->fallback,$adHtml); 
       
        // Check market url
        $aUrl = parse_url($aResult[2]);
        $this->assertEqual('https', $aUrl['scheme']);
        $this->assertEqual('brokerHost.org', $aUrl['host']);
        $this->assertEqual('/jstag', $aUrl['path']);
        $this->assertTrue(empty($aUrl['query']));

        // set https to off
        $_SERVER['HTTPS'] = 'off';
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        // check if response matches to pattern
        $this->assertTrue(ereg($pattern, $result, $aResult));
        
        // check ereg result
        $this->assertEqual(3,count($aResult));
        $this->assertEqual($aResult[1], $jsonOXM_ad);
        $this->assertFalse(empty($aResult[2]));
        $httpUrl = $aResult[2];

        // Check market url
        $aUrl = parse_url($aResult[2]);
        $this->assertEqual('http', $aUrl['scheme']);
        $this->assertEqual('brokerHost.org', $aUrl['host']);
        $this->assertEqual('/jstag', $aUrl['path']);
        $this->assertTrue(empty($aUrl['query']));

        // unset https
        unset($_SERVER['HTTPS']);
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        
        // check if response matches to pattern
        $this->assertTrue(ereg($pattern, $result, $aResult));
        // check ereg result
        $this->assertEqual(3,count($aResult));
        $this->assertEqual($aResult[1], $jsonOXM_ad);
        $this->assertEqual($aResult[2], $httpUrl);

        // restore setting
        $_SERVER['HTTPS'] = $serverHttps;
    }
    
    function testAddMarketParamsHook()
    {
        // Store original hooks
        $addMarketParamsHooks = null;
        if (isset($GLOBALS['_MAX']['CONF']['deliveryHooks']['addMarketParams'])) {
            $addMarketParamsHooks = $GLOBALS['_MAX']['CONF']['deliveryHooks']['addMarketParams'];
        }
        
        // Set own hook
        $GLOBALS['_MAX']['CONF']['deliveryHooks']['addMarketParams'] = 
            "deliveryAdRender:myTestPluginGroup:myParamsPlugin";
        
        // declare test function for hook
        function Plugin_deliveryAdRender_myTestPluginGroup_myParamsPlugin_Delivery_addMarketParams(&$aParams) 
        {
            $aParams['myParam'] = '1234';
        }
        
        // Prepare test data
        $adHtml = 'test banner';
        $aAd = array( 'width' => 468, 'height' => 60 );
        $aCampaignMarketInfo = array();
        $website_id = 12;
        $aWebsiteMarketInfo = array('website_id' => $website_id);
        $GLOBALS['_MAX']['CONF']['oxMarketDelivery']['brokerHost'] = 'brokerHost.org';

        // pattern to check OX_marketProcess result and get OXM_ad parameters and src of second script
        $pattern = '<script type="text/javascript">[[:space:]]OXM_ad = ({.*})[[:space:]]</script>[[:space:]]'.
                   '<script type="text/javascript" src="(.*)"></script>';
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);

        // check if response matches to pattern
        $this->assertTrue(ereg($pattern, $result, $aResult));

        $jsonOXM_ad = $aResult[1];
        
        // Check OXM_ad json
        $oJson = new Services_JSON();
        $aOXM_ad = $oJson->decode($jsonOXM_ad);
        $this->assertEqual($aOXM_ad->website, $website_id);
        $this->assertEqual($aOXM_ad->floor, 0);
        $this->assertEqual($aOXM_ad->size, "468x60");
        $this->assertTrue(isset($aOXM_ad->beacon));
        $this->assertEqual($aOXM_ad->fallback,$adHtml);
        $this->assertEqual($aOXM_ad->myParam, 1234);
        
    }
    
    function testOX_Dal_Delivery_getPlatformMarketInfo()
    {
        MAX_Dal_Delivery_Include();
        
        // No admin_account_id in application_variable
        $this->assertFalse(OX_Dal_Delivery_getPlatformMarketInfo());

        // Add test assoc data
        $admin_account_id = 3;
        $status = 0;
        
        $doAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $doAssocData->status = $status;
        $doAssocData->account_id = $admin_account_id;
        DataGenerator::generateOne($doAssocData);
        
        // Still no admin_account_id in application_variable
        $this->assertFalse(OX_Dal_Delivery_getPlatformMarketInfo());
        // This will check only ext_market_assoc_data
        $this->assertTrue(OX_Dal_Delivery_getPlatformMarketInfo($admin_account_id)); 

        // Add admin_account_id to application_variable
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'admin_account_id';
        $doAppVar->value = $admin_account_id;
        DataGenerator::generateOne($doAppVar);
        
        // Get admin account from DB, check ext_market_assoc_data
        $this->assertTrue(OX_Dal_Delivery_getPlatformMarketInfo());
        // This will check only ext_market_assoc_data
        $this->assertTrue(OX_Dal_Delivery_getPlatformMarketInfo($admin_account_id));
        // Check account not in ext_market_assoc_data
        $this->assertFalse(OX_Dal_Delivery_getPlatformMarketInfo(2)); 
        
        // Set status to invalid
        $doAssocData = OA_DAL::factoryDO('ext_market_assoc_data');
        $doAssocData->get($admin_account_id);
        $doAssocData->status = 1;
        $doAssocData->update();
        
        $this->assertFalse(OX_Dal_Delivery_getPlatformMarketInfo());
    }
    
}

