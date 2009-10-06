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
require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheManager.php';

/**
 * A class for testing the oxMarketDelivery functions
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_deliveryAdRender_oxMarketDelivery_oxMarketDeliveryTest extends UnitTestCase
{
    // pattern to check OX_marketProcess result and get OXM_ad parameters and src of second script
    var $pattern = '<script type="text/javascript">[[:space:]]OXM_ad = ({.*});[[:space:]]</script>[[:space:]]<script type="text/javascript" src="(.*)"></script>[[:space:]]<noscript>(.*)</noscript>';
        /* pattern for old call
        $pattern = '<script type="text/javascript">[[:space:]]OXM_(.*) = {"t":"(.*)","f":"(.*)"}[[:space:]]</script>[[:space:]]<script type="text/javascript" src="(.*)"></script>';
        */
        
    function setUp()
    {
        TestEnv::uninstallPluginPackage('openXMarket',false);
        TestEnv::installPluginPackage('openXMarket',false);
    }
    
    function tearDown()
    {
        DataGenerator::cleanUp();
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

        
        
        // set https to on
        $_SERVER['HTTPS'] = 'on';
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        
        // check if response matches to pattern
        $this->assertTrue(ereg($this->pattern, $result, $aResult));
        
        // check ereg result
        $this->assertEqual(4,count($aResult));
        $this->assertFalse(empty($aResult[1]));
        $this->assertFalse(empty($aResult[2]));
        $this->assertEqual($aResult[3], $adHtml);
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
        $this->assertTrue(ereg($this->pattern, $result, $aResult));
        
        // check ereg result
        $this->assertEqual(4,count($aResult));
        $this->assertEqual($aResult[1], $jsonOXM_ad);
        $this->assertFalse(empty($aResult[2]));
        $this->assertEqual($aResult[3], $adHtml);
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
        $this->assertTrue(ereg($this->pattern, $result, $aResult));
        // check ereg result
        $this->assertEqual(4,count($aResult));
        $this->assertEqual($aResult[1], $jsonOXM_ad);
        $this->assertEqual($aResult[2], $httpUrl);
        $this->assertEqual($aResult[3], $adHtml);

        // test adding url and referer if iFrame invocation
        $GLOBALS['loc'] = 'http://test.com/';
        $GLOBALS['referer'] = 'http://search.com/';
        $GLOBALS['_OA']['invocationType'] = 'frame';
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        
        // check if response matches to pattern
        $this->assertTrue(ereg($this->pattern, $result, $aResult));
        // check ereg result
        $this->assertEqual(4,count($aResult));
        $oOXM_ad = $oJson->decode($aResult[1]);
        $this->assertEqual($oOXM_ad->url, 'http://test.com/');
        $this->assertEqual($oOXM_ad->referer, 'http://search.com/');
        
        // unset referer
        unset($GLOBALS['referer']);
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        
        $this->assertTrue(ereg($this->pattern, $result, $aResult));
        // check ereg result
        $this->assertEqual(4,count($aResult));
        $oOXM_ad = $oJson->decode($aResult[1]);
        $aOXM_ad = get_object_vars($oOXM_ad);
        $this->assertEqual($aOXM_ad['url'], 'http://test.com/');
        $this->assertFalse(array_key_exists('referer',$aOXM_ad));
        
        // uset url
        unset($GLOBALS['loc']);
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        
        $this->assertTrue(ereg($this->pattern, $result, $aResult));
        // check ereg result
        $this->assertEqual(4,count($aResult));
        $oOXM_ad = $oJson->decode($aResult[1]);
        $aOXM_ad = get_object_vars($oOXM_ad);
        $this->assertFalse(array_key_exists('url',$aOXM_ad));
        $this->assertFalse(array_key_exists('referer',$aOXM_ad));
        
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
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);

        // check if response matches to pattern
        $this->assertTrue(ereg($this->pattern, $result, $aResult));

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
        
        // restore hooks
        $GLOBALS['_MAX']['CONF']['deliveryHooks']['addMarketParams'] = $addMarketParamsHooks;
    }
    
    function testOX_Dal_Delivery_getPlatformMarketInfo()
    {
        MAX_Dal_Delivery_Include();
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = false;
        
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
        $this->assertTrue(OX_Dal_Delivery_getPlatformMarketInfo(null, $admin_account_id)); 

        // Add admin_account_id to application_variable
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'admin_account_id';
        $doAppVar->value = $admin_account_id;
        DataGenerator::generateOne($doAppVar);
        
        // Get admin account from DB, check ext_market_assoc_data
        $this->assertTrue(OX_Dal_Delivery_getPlatformMarketInfo());
        // This will check only ext_market_assoc_data
        $this->assertTrue(OX_Dal_Delivery_getPlatformMarketInfo(null, $admin_account_id));
        // Check account not in ext_market_assoc_data
        $this->assertFalse(OX_Dal_Delivery_getPlatformMarketInfo(null, 2)); 
        
        // Set status to invalid
        $doAssocData = OA_DAL::factoryDO('ext_market_assoc_data');
        $doAssocData->get($admin_account_id);
        $doAssocData->status = 1;
        $doAssocData->update();
        
        $this->assertFalse(OX_Dal_Delivery_getPlatformMarketInfo());
        
        // delete admin association
        $doAssocData = OA_DAL::factoryDO('ext_market_assoc_data');
        $doAssocData->get($admin_account_id);
        $doAssocData->delete();
        
        // switch on multiple accounts mode
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = true;
        $status = 0;
        
        // Prepare test managers
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId1 = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId2 = DataGenerator::generateOne($doAgency);
        
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId1);
        $accountId1 = $doAgency->account_id;
       
        $doAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $doAssocData->status = $status;
        $doAssocData->account_id = $accountId1;
        DataGenerator::generateOne($doAssocData);
        
        // Test linked manager
        $this->assertTrue(OX_Dal_Delivery_getPlatformMarketInfo($agencyId1));
        // Test not linked manager
        $this->assertFalse(OX_Dal_Delivery_getPlatformMarketInfo($agencyId2));
        // Test no agency_id in multiple accounts mode
        $this->assertFalse(OX_Dal_Delivery_getPlatformMarketInfo());
    }
    
    
    function testOxMarketPostAdRenderHook()
    {
        // Store original hooks
        $oxMarketPostAdRenderHooks = null;
        if (isset($GLOBALS['_MAX']['CONF']['deliveryHooks']['oxMarketPostAdRender'])) {
            $oxMarketPostAdRenderHooks = $GLOBALS['_MAX']['CONF']['deliveryHooks']['oxMarketPostAdRender'];
        }
        
        // Set own hook
        $GLOBALS['_MAX']['CONF']['deliveryHooks']['oxMarketPostAdRender'] = 
            "deliveryAdRender:myTestPluginGroup:myMarketPostAdRenderPlugin";
        
        // declare test function for hook
        function Plugin_deliveryAdRender_myTestPluginGroup_myMarketPostAdRenderPlugin_Delivery_oxMarketPostAdRender(&$code, $aBanner, $aMarketInfo) 
        {
            $code .= '|TestPlugin|'.serialize($aBanner).'|'.serialize($aMarketInfo);
        }
        
        // Prepare test data
        $bannerCode = 'html banner';
        $aBanner = array( 'width' => 468, 'height' => 60 );
        
        $code = $bannerCode;
        // Test postAdRender hook as entry point
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdRender($code, $aBanner);
        $result = explode('|', $code);
        $this->assertEqual(4, count($result));
        $this->assertEqual($result[0], $bannerCode);
        $this->assertEqual($result[1], 'TestPlugin');
        $this->assertEqual(unserialize($result[2]), $aBanner);
        $this->assertEqual(unserialize($result[3]), false);
        
        // Prepare test data
        $output = array('html' => 'test html', 'banner_id' => '');
        $GLOBALS['_MAX']['considered_ads'][0] =
            array('zone_id' => 12,
                  'width'   => 23,
                  'height'  => 34,
                  'agency_id' => 45,
                  'publisher_id' => 56
            );
        $admin_account_id = 1;
        // Add admin_account_id to application_variable
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'admin_account_id';
        $doAppVar->value = $admin_account_id;
        DataGenerator::generateOne($doAppVar);
        // register market
        $doAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $doAssocData->status = $status;
        $doAssocData->account_id = $admin_account_id;
        DataGenerator::generateOne($doAssocData);
        // register website
        $doWebsitePref = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsitePref->affiliateid = 56;
        $website_id = 'website -0056-uuid-xxxx-xxxxxxxxxxxx';
        $doWebsitePref->website_id = $website_id;
        DataGenerator::generateOne($doWebsitePref);
        // register zone
        $doZonePref = OA_Dal::factoryDO('ext_market_zone_pref');
        $doZonePref->zoneid = 12;
        $doZonePref->is_enabled = true;
        DataGenerator::generateOne($doZonePref);
        
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdSelect($output);
        $result = explode('|', $output['html']);

        $this->assertEqual(4, count($result));
        $this->assertTrue(strstr($result[0], 'test html')!==false); // find orginal banner in market request 
        $this->assertEqual($result[1], 'TestPlugin');
        $aExpectedBanner = array (
            'width' => 23,
            'height' => 34,
            'agency_id' => 45,
            'affiliate_id' => 56,
            );
        $this->assertEqual(unserialize($result[2]), $aExpectedBanner);
        $aExpectedMarketInfo = array(
                'campaign' => array('floor_price' => 0),
                'website'  => array('website_id' => $website_id)
            );
        $this->assertEqual(unserialize($result[3]), $aExpectedMarketInfo);
        
        // restore hooks
        $GLOBALS['_MAX']['CONF']['deliveryHooks']['oxMarketPostAdRender'] = $oxMarketPostAdRenderHooks;
    }
    
    function testPostAdSelectHookImplementation()
    {
        $output = array('html' => 'default banner', 'banner_id' => '');
        $GLOBALS['_MAX']['considered_ads'][0] =
            array('zone_id' => 112,
                  'width'   => 123,
                  'height'  => 134,
                  'agency_id' => 145,
                  'publisher_id' => 156
            );
        $admin_account_id = 1;
        // Add admin_account_id to application_variable
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'admin_account_id';
        $doAppVar->value = $admin_account_id;
        DataGenerator::generateOne($doAppVar);
        // register market
        $doAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $doAssocData->status = $status;
        $doAssocData->account_id = $admin_account_id;
        DataGenerator::generateOne($doAssocData);
        // register website
        $doWebsitePref = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsitePref->affiliateid = 156;
        $website_id = 'website -156 -uuid-xxxx-xxxxxxxxxxxx';
        $doWebsitePref->website_id = $website_id;
        DataGenerator::generateOne($doWebsitePref);
        // register zone
        $doZonePref = OA_Dal::factoryDO('ext_market_zone_pref');
        $doZonePref->zoneid = 112;
        $doZonePref->is_enabled = true;
        DataGenerator::generateOne($doZonePref);
        
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdSelect($output);
        $this->assertEqual($output['banner_id'], '');
        // check if output html matches to market call pattern
        $this->assertTrue(ereg($this->pattern, $output['html'], $aResult));

        // check ereg result
        $this->assertEqual(4,count($aResult));
        $this->assertFalse(empty($aResult[1]));
        $this->assertFalse(empty($aResult[2]));
        $this->assertEqual($aResult[3], 'default banner');
        $jsonOXM_ad = $aResult[1];
        
        // Check OXM_ad json
        $oJson = new Services_JSON();
        $aOXM_ad = $oJson->decode($jsonOXM_ad);
        $this->assertEqual($aOXM_ad->website, $website_id);
        $this->assertEqual($aOXM_ad->floor, 0);
        $this->assertEqual($aOXM_ad->size, "123x134");
        $this->assertTrue(isset($aOXM_ad->beacon));
        $this->assertEqual($aOXM_ad->fallback,'default banner'); 
       
        // Check market url
        $aUrl = parse_url($aResult[2]);
        $this->assertEqual('http', $aUrl['scheme']);
        $this->assertEqual($GLOBALS['_MAX']['CONF']['oxMarketDelivery']['brokerHost'], $aUrl['host']);
        $this->assertEqual('/jstag', $aUrl['path']);
        $this->assertTrue(empty($aUrl['query']));
        
        
        // test wildcard zones
        $GLOBALS['_MAX']['considered_ads'][0]['width'] = -1;
        $output = array('html' => 'default banner', 'banner_id' => '');
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdSelect($output);
        $this->assertEqual($output['html'],'default banner');
        $GLOBALS['_MAX']['considered_ads'][0]['width'] = 123;
        
        // test not opted in zone
        $GLOBALS['_MAX']['considered_ads'][0]['zone_id'] = 1124;
        $output = array('html' => 'default banner', 'banner_id' => '');
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdSelect($output);
        $this->assertEqual($output['html'],'default banner');
        $GLOBALS['_MAX']['considered_ads'][0]['zone_id'] = 112;
        
        // test not opted in website
        $GLOBALS['_MAX']['considered_ads'][0]['publisher_id'] = 1156;
        $output = array('html' => 'default banner', 'banner_id' => '');
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdSelect($output);
        $this->assertEqual($output['html'],'default banner');
        $GLOBALS['_MAX']['considered_ads'][0]['publisher_id'] = 156;
        
    }

    function testPostAdRenderHookImplementation()
    {
        // prepare data
        $admin_account_id = 1;
        // Add admin_account_id to application_variable
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'admin_account_id';
        $doAppVar->value = $admin_account_id;
        DataGenerator::generateOne($doAppVar);
        // register market
        $doAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $doAssocData->status = $status;
        $doAssocData->account_id = $admin_account_id;
        DataGenerator::generateOne($doAssocData);
        // register website
        $doWebsitePref = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsitePref->affiliateid = 256;
        $website_id = 'website -256 -uuid-xxxx-xxxxxxxxxxxx';
        $doWebsitePref->website_id = $website_id;
        DataGenerator::generateOne($doWebsitePref);
        // optin campaign
        $doCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doCampaignPref->campaignid = 345;
        $doCampaignPref->is_enabled = true;
        $doCampaignPref->floor_price = 0.12;
        DataGenerator::generateOne($doCampaignPref);

        $banner = 'test banner';
        $aBanner = array(
            'width' => 123,
            'height' => 234,
            'campaignid' => 345,
            'affiliate_id' => 256,
        );
        $code = $banner;
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdRender($code, $aBanner);
        
        // check if output html matches to market call pattern
        $this->assertTrue(ereg($this->pattern, $code, $aResult));

        // check ereg result
        $this->assertEqual(4,count($aResult));
        $this->assertFalse(empty($aResult[1]));
        $this->assertFalse(empty($aResult[2]));
        $this->assertEqual($aResult[3], $banner);
        $jsonOXM_ad = $aResult[1];
        
        // Check OXM_ad json
        $oJson = new Services_JSON();
        $aOXM_ad = $oJson->decode($jsonOXM_ad);
        $this->assertEqual($aOXM_ad->website, $website_id);
        $this->assertEqual($aOXM_ad->floor, 0.12);
        $this->assertEqual($aOXM_ad->size, "123x234");
        $this->assertTrue(isset($aOXM_ad->beacon));
        $this->assertEqual($aOXM_ad->fallback, $banner); 
       
        // Check market url
        $aUrl = parse_url($aResult[2]);
        $this->assertEqual('http', $aUrl['scheme']);
        $this->assertEqual($GLOBALS['_MAX']['CONF']['oxMarketDelivery']['brokerHost'], $aUrl['host']);
        $this->assertEqual('/jstag', $aUrl['path']);
        $this->assertTrue(empty($aUrl['query']));

        // test not opted-in campaign 
        $aBanner['campaignid'] = 3451;
        $code = $banner;
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdRender($code, $aBanner);
        $this->assertEqual($code, $banner);
        $aBanner['campaignid'] = 345;
        
        // test unknown affiliate (e.g. direct select)
        unset($aBanner['affiliate_id']);
        $code = $banner;
        Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdRender($code, $aBanner);
        $this->assertEqual($code, $banner);
        $aBanner['affiliate_id'] = 256;
 
    }
    
    function test_OX_Dal_Delivery_getZoneMarketInfo()
    {
        MAX_Dal_Delivery_Include();
        $zoneId1 = 34;
        $zoneId2 = 35;
        // register zone
        $doZonePref = OA_Dal::factoryDO('ext_market_zone_pref');
        $doZonePref->zoneid = $zoneId1;
        $doZonePref->is_enabled = true;
        DataGenerator::generateOne($doZonePref);
        // unregistered zone
        $doZonePref = OA_Dal::factoryDO('ext_market_zone_pref');
        $doZonePref->zoneid = $zoneId2;
        $doZonePref->is_enabled = false;
        DataGenerator::generateOne($doZonePref);
        
        $enabled = array('is_enabled' => true);
        $disabled = array('is_enabled' => false);
        
        $this->assertEqual(OX_Dal_Delivery_getZoneMarketInfo(null), $disabled);
        $this->assertEqual(OX_Dal_Delivery_getZoneMarketInfo(33), $disabled);
        $this->assertEqual(OX_Dal_Delivery_getZoneMarketInfo($zoneId1), $enabled);
        $this->assertEqual(OX_Dal_Delivery_getZoneMarketInfo($zoneId2), $disabled);
    }
}

