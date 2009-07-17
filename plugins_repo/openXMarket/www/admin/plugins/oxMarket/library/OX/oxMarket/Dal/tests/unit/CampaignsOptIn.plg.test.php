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

require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once dirname(__FILE__).'/../../CampaignsOptIn.php';

/**
 * A class for testing the CampaignOptIn DAL library
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfPDataObjects_Ext_market_web_stats extends UnitTestCase
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

    
    function testPerformOptIn(){

        $aObjectsIds = $this->_prepare_users();
        // Prepare logged user
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->get($aObjectsIds['managerUserID']);
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        $aCampaignsIds = $this->_prepare_campaigns($aObjectsIds);

        // Test - should add new market campaign pref
        $oDalCampaignsOptIn = new OX_oxMarket_Dal_CampaignsOptIn();
        $result = $oDalCampaignsOptIn->performOptIn('remnant', null, null, 0.12);
        $this->assertEqual(2, $result);

        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doMarketCampaignPref->orderBy('campaignid');
        $aResult = $doMarketCampaignPref->getAll();
        $this->assertEqual(count($aResult),2);
        $this->assertEqual($aResult[0]['campaignid'], $aCampaignsIds[1]);
        $this->assertTrue($aResult[0]['is_enabled']);
        $this->assertEqual($aResult[0]['floor_price'], 0.12);
        $this->assertEqual($aResult[1]['campaignid'], $aCampaignsIds[2]);
        $this->assertTrue($aResult[1]['is_enabled']);
        $this->assertEqual($aResult[1]['floor_price'], 0.12);

        // Test - should update market campaign pref
        $result = $oDalCampaignsOptIn->performOptIn('remnant', null, null, 0.11);
        $this->assertEqual(2, $result);
        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doMarketCampaignPref->orderBy('campaignid');
        $aResult = $doMarketCampaignPref->getAll();
        $this->assertEqual(count($aResult),2);
        $this->assertEqual($aResult[0]['campaignid'], $aCampaignsIds[1]);
        $this->assertTrue($aResult[0]['is_enabled']);
        $this->assertEqual($aResult[0]['floor_price'], 0.11);
        $this->assertEqual($aResult[1]['campaignid'], $aCampaignsIds[2]);
        $this->assertTrue($aResult[1]['is_enabled']);
        $this->assertEqual($aResult[1]['floor_price'], 0.11);

        // Test selected (update and insert)
        $toOptIn = array($aCampaignsIds[4], $aCampaignsIds[2]);
        $minCpms = array($aCampaignsIds[4] => 1.23, $aCampaignsIds[2] => 0.56);
        $result = $oDalCampaignsOptIn->performOptIn('selected', $minCpms, $toOptIn, null);
        $this->assertEqual(2, $result);

        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doMarketCampaignPref->orderBy('campaignid');
        $aResult = $doMarketCampaignPref->getAll();
        $this->assertEqual(count($aResult),3);
        $this->assertEqual($aResult[0]['campaignid'], $aCampaignsIds[1]);
        $this->assertTrue($aResult[0]['is_enabled']);
        $this->assertEqual($aResult[0]['floor_price'], 0.11);
        $this->assertEqual($aResult[1]['campaignid'], $aCampaignsIds[2]);
        $this->assertTrue($aResult[1]['is_enabled']);
        $this->assertEqual($aResult[1]['floor_price'], 0.56);
        $this->assertEqual($aResult[2]['campaignid'], $aCampaignsIds[4]);
        $this->assertTrue($aResult[2]['is_enabled']);
        $this->assertEqual($aResult[2]['floor_price'], 1.23);

        // Security test: try to change other manager campaign
        $toOptIn = array($aCampaignsIds[5]);
        $minCpms = array($aCampaignsIds[5] => 1.23);
        $result = $oDalCampaignsOptIn->performOptIn('selected', $minCpms, $toOptIn, null);
        $this->assertEqual(0, $result);

        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doMarketCampaignPref->orderBy('campaignid');
        $aResult = $doMarketCampaignPref->getAll();
        $this->assertEqual(count($aResult),3);

        // Empty array $toOptIn
        $toOptIn = array();
        $minCpms = array();
        $result = $oDalCampaignsOptIn->performOptIn('selected', $minCpms, $toOptIn, null);
        $this->assertEqual(0, $result);

        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doMarketCampaignPref->orderBy('campaignid');
        $aResult = $doMarketCampaignPref->getAll();
        $this->assertEqual(count($aResult),3);
    }


    function testInsertOrUpdateMarketCampaignPref()
    {
        $oDalCampaignsOptIn = new OX_oxMarket_Dal_CampaignsOptIn();
        $oDalCampaignsOptIn->insertOrUpdateMarketCampaignPref(3, 0.41);

        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doMarketCampaignPref->orderBy('campaignid');
        $aResult = $doMarketCampaignPref->getAll();
        $this->assertEqual(count($aResult),1);
        $this->assertEqual($aResult[0]['campaignid'], 3);
        $this->assertTrue($aResult[0]['is_enabled']);
        $this->assertEqual($aResult[0]['floor_price'], 0.41);

        $oDalCampaignsOptIn->insertOrUpdateMarketCampaignPref(3, 0.51);

        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doMarketCampaignPref->orderBy('campaignid');
        $aResult = $doMarketCampaignPref->getAll();
        $this->assertEqual(count($aResult),1);
        $this->assertEqual($aResult[0]['campaignid'], 3);
        $this->assertTrue($aResult[0]['is_enabled']);
        $this->assertEqual($aResult[0]['floor_price'], 0.51);
    }


    function testGetCampaigns()
    {
        $aObjectsIds = $this->_prepare_users();
        // Prepare logged user
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->get($aObjectsIds['managerUserID']);
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        $aCampaignsIds = $this->_prepare_campaigns($aObjectsIds);

        // Define formatCpm (required by getCampaigns)
        function formatCpm($cpm)
        {
            return number_format($cpm, 2, '.', '');
        }

        $oDalCampaignsOptIn = new OX_oxMarket_Dal_CampaignsOptIn();

        // Get remnant campaigns
        $aResult = $oDalCampaignsOptIn->getCampaigns(0.5, 'remnant');

        // Unfortunatelly all campaigns epcm are automatically set to 1.000 in tests
        $this->assertEqual(2, count($aResult));
        $this->assertEqual($aResult[$aCampaignsIds[1]]['campaignid'], $aCampaignsIds[1]);
        $this->assertEqual($aResult[$aCampaignsIds[1]]['campaignname'], 'campaign 1');
        $this->assertEqual($aResult[$aCampaignsIds[1]]['minCpm'], 1);
        $this->assertEqual($aResult[$aCampaignsIds[1]]['priority'], DataObjects_Campaigns::PRIORITY_REMNANT);
        $this->assertFalse($aResult[$aCampaignsIds[1]]['minCpmCalculated']); //REMNANT_CAMPAIGNS are not eCPM enabled
        $this->assertEqual($aResult[$aCampaignsIds[2]]['campaignid'], $aCampaignsIds[2]);
        $this->assertEqual($aResult[$aCampaignsIds[2]]['campaignname'], 'campaign 2');
        $this->assertEqual($aResult[$aCampaignsIds[2]]['minCpm'], 1);
        $this->assertTrue($aResult[$aCampaignsIds[2]]['minCpmCalculated']);

        // Get contract campaigns
        $aResult = $oDalCampaignsOptIn->getCampaigns(0.5, 'contract');
        $this->assertEqual(1, count($aResult));
        $this->assertEqual($aResult[$aCampaignsIds[4]]['campaignid'], $aCampaignsIds[4]);
        $this->assertEqual($aResult[$aCampaignsIds[4]]['campaignname'], 'campaign 4');
        $this->assertEqual($aResult[$aCampaignsIds[4]]['minCpm'], 1);
        $this->assertTrue($aResult[$aCampaignsIds[4]]['minCpmCalculated']);

        // Get all (remnant+contract) campaigns
        $aResult = $oDalCampaignsOptIn->getCampaigns(0.5, 'all');
        $this->assertEqual(3, count($aResult));
        $this->assertEqual($aResult[$aCampaignsIds[1]]['campaignid'], $aCampaignsIds[1]);
        $this->assertEqual($aResult[$aCampaignsIds[2]]['campaignid'], $aCampaignsIds[2]);
        $this->assertEqual($aResult[$aCampaignsIds[4]]['priority'], 7);
        $this->assertEqual($aResult[$aCampaignsIds[4]]['campaignid'], $aCampaignsIds[4]); 

        // Opt in two campaigns
        $toOptIn = array($aCampaignsIds[4], $aCampaignsIds[2]);
        $minCpms = array($aCampaignsIds[4] => 1.23, $aCampaignsIds[2] => 0.56);
        $result = $oDalCampaignsOptIn->performOptIn('selected', $minCpms, $toOptIn, null);

        // Get remnant campaigns
        $aResult = $oDalCampaignsOptIn->getCampaigns(2, 'remnant');
        $this->assertEqual(1, count($aResult));
        $this->assertEqual($aResult[$aCampaignsIds[1]]['campaignid'], $aCampaignsIds[1]);

        // Get contract campaigns
        $aResult = $oDalCampaignsOptIn->getCampaigns(0.5, 'contract');
        $this->assertEqual(0, count($aResult));

        // Get all (remnant+contract) campaigns
        $aResult = $oDalCampaignsOptIn->getCampaigns(2, 'all');
        $this->assertEqual(1, count($aResult));
        $this->assertEqual($aResult[$aCampaignsIds[1]]['campaignid'], $aCampaignsIds[1]);
    }


    function testNumberOfOptedCampaigns()
    {
        $aObjectsIds = $this->_prepare_users();
        // Prepare logged user
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->get($aObjectsIds['managerUserID']);
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        $aCampaignsIds = $this->_prepare_campaigns($aObjectsIds);

        $oDalCampaignsOptIn = new OX_oxMarket_Dal_CampaignsOptIn();

        // test empty 'remnant', 'contract', 'all' types
        $this->assertEqual(0, $oDalCampaignsOptIn->numberOfOptedCampaigns('remnant'));
        $this->assertEqual(0, $oDalCampaignsOptIn->numberOfOptedCampaigns('contract'));
        $this->assertEqual(0, $oDalCampaignsOptIn->numberOfOptedCampaigns('all'));

        // Opt 1 remnant and 1 contract campaign
        $toOptIn = array($aCampaignsIds[4], $aCampaignsIds[2]);
        $minCpms = array($aCampaignsIds[4] => 1.23, $aCampaignsIds[2] => 0.56);
        $result = $oDalCampaignsOptIn->performOptIn('selected', $minCpms, $toOptIn, null);

        // test 'remnant', 'contract', 'all' types once again
        $this->assertEqual(1, $oDalCampaignsOptIn->numberOfOptedCampaigns('remnant'));
        $this->assertEqual(1, $oDalCampaignsOptIn->numberOfOptedCampaigns('contract'));
        $this->assertEqual(2, $oDalCampaignsOptIn->numberOfOptedCampaigns('all'));
    }


    function testNumberOfRemnantCampaignsToOptIn()
    {
        $aObjectsIds = $this->_prepare_users();
        // Prepare logged user
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->get($aObjectsIds['managerUserID']);
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        $oDalCampaignsOptIn = new OX_oxMarket_Dal_CampaignsOptIn();

        // there is no campaign in database
        $this->assertEqual(0, $oDalCampaignsOptIn->numberOfRemnantCampaignsToOptIn());

        $aCampaignsIds = $this->_prepare_campaigns($aObjectsIds);

        // Two matching campaigns
        $this->assertEqual(2, $oDalCampaignsOptIn->numberOfRemnantCampaignsToOptIn());

        // Opt 1 remnant and 1 contract campaign
        $toOptIn = array($aCampaignsIds[4], $aCampaignsIds[2]);
        $minCpms = array($aCampaignsIds[4] => 1.23, $aCampaignsIds[2] => 0.56);
        $oDalCampaignsOptIn->performOptIn('selected', $minCpms, $toOptIn, null);

        // Result is independed from already opted in capmaigns
        $this->assertEqual(2, $oDalCampaignsOptIn->numberOfRemnantCampaignsToOptIn());
    }
    

    function _prepare_users()
    {
        $aObjectsIds = array();

        $doAgency = OA_Dal::factoryDO('agency');
        $aObjectsIds['agencyId'] = DataGenerator::generateOne($doAgency);

        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($aObjectsIds['agencyId']);
        $aObjectsIds['managerAccountId'] = $doAgency->account_id;

        // Create user linked to manager account
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $aObjectsIds['managerAccountId'];
        $doUsers->username = 'manager';
        $aObjectsIds['managerUserID'] = DataGenerator::generateOne($doUsers);

        $doAccountsUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccountsUserAssoc->account_id = $aObjectsIds['managerAccountId'];
        $doAccountsUserAssoc->user_id = $aObjectsIds['managerUserID'];
        DataGenerator::generateOne($doAccountsUserAssoc);

        $doClient = OA_Dal::factoryDO('clients');
        $doClient->agencyid = $aObjectsIds['agencyId'];
        $aObjectsIds['managerClientID'] = DataGenerator::generateOne($doClient);

        return $aObjectsIds;
    }
    

    function _prepare_campaigns($aObjectsIds)
    {
        $oDate = new Date();
        $oDate->setTZbyID('UTC');
        $dateY[0] = $oDate->format("%Y-%m-%d").' 23:59:59';
        $oDate->setYear($oDate->getYear()+1);
        $dateY[1] = $oDate->format("%Y-%m-%d").' 23:59:59';
        $oDate->setYear($oDate->getYear()-2);
        $dateY[-1] = $oDate->format("%Y-%m-%d").' 23:59:59';

        // Prepare some campaigns
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'campaign 1';
        $doCampaigns->expire_time = null;
        $doCampaigns->priority = DataObjects_Campaigns::PRIORITY_REMNANT;
        $doCampaigns->clientid = $aObjectsIds['managerClientID'];
        $aCampaignsIds[1] = DataGenerator::generateOne($doCampaigns);
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'campaign 2';
        $doCampaigns->expire_time = $dateY[1];
        $doCampaigns->priority = DataObjects_Campaigns::PRIORITY_ECPM;
        $doCampaigns->clientid = $aObjectsIds['managerClientID'];
        $aCampaignsIds[2] = DataGenerator::generateOne($doCampaigns);
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'campaign 3';
        $doCampaigns->expire_time = $dateY[-1];
        $doCampaigns->priority = DataObjects_Campaigns::PRIORITY_ECPM;
        $doCampaigns->clientid = $aObjectsIds['managerClientID'];
        $aCampaignsIds[3] = DataGenerator::generateOne($doCampaigns);
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'campaign 4';
        $doCampaigns->expire_time = $dateY[1];
        $doCampaigns->priority = 7;
        $doCampaigns->clientid = $aObjectsIds['managerClientID'];
        $doCampaigns->ecpm_enabled = true; //contract campaigns with priority 6-9 have this set to true
        
        $aCampaignsIds[4] = DataGenerator::generateOne($doCampaigns);
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'campaign 5';
        $doCampaigns->expire_time = $dateY[1];
        $doCampaigns->priority = DataObjects_Campaigns::PRIORITY_REMNANT;
        $doCampaigns->clientid = $doCampaigns->clientid = $aObjectsIds['managerClientID']-1;
        $aCampaignsIds[5] = DataGenerator::generateOne($doCampaigns);
        return $aCampaignsIds;
    }
}

?>
