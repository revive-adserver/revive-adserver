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

require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the openXMarket DataObjects
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfPDataObjects_Ext_market_website_pref extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::uninstallPluginPackage('openXMarket', false);
    }

    
    function testGetRegisteredWebsitesIds(){
        $plgManager = new OX_PluginManager();
        $info = $plgManager->getPackageInfo('openXMarket');
        
        // Prepare managers and websites
        
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId[1] = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId[2] = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId[1]);
        $accountId1 = $doAgency->account_id;
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId[2]);
        $accountId2 = $doAgency->account_id;

        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $agencyId[1];
        $affiliateId[1] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $agencyId[2];
        $affiliateId[2] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $agencyId[1];
        $affiliateId[3] = DataGenerator::generateOne($doAffiliate);
        
        // Test getRegisteredWebsitesIds without data in ext_market_website_pref
        
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $aResult = $doWebsite->getRegisteredWebsitesIds(null);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $aResult = $doWebsite->getRegisteredWebsitesIds($accountId1);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $aResult = $doWebsite->getRegisteredWebsitesIds($accountId2);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        // Prepare data
        
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->affiliateid = $affiliateId[1];
        $doWebsite->website_id = 'my-uuid1';
        DataGenerator::generateOne($doWebsite);
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->affiliateid = $affiliateId[2];
        $doWebsite->website_id = 'my-uuid2';
        DataGenerator::generateOne($doWebsite);
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->affiliateid = $affiliateId[3];
        $doWebsite->website_id = 'my-uuid3';
        DataGenerator::generateOne($doWebsite);

        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $aResult = $doWebsite->getRegisteredWebsitesIds(null);
        $expected = array('my-uuid1', 'my-uuid2', 'my-uuid3');
        sort($aResult);
        $this->assertEqual($expected, $aResult);
        
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $aResult = $doWebsite->getRegisteredWebsitesIds($accountId1);
        $expected = array('my-uuid1', 'my-uuid3');
        sort($aResult);
        $this->assertEqual($expected, $aResult);
        
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $aResult = $doWebsite->getRegisteredWebsitesIds($accountId2);
        $expected = array('my-uuid2');
        sort($aResult);
        $this->assertEqual($expected, $aResult);
        
        // test int value as input
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $aResult = $doWebsite->getRegisteredWebsitesIds((int)$accountId2);
        $expected = array('my-uuid2');
        sort($aResult);
        $this->assertEqual($expected, $aResult);
    }

}

?>
