<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

/**
 * A class for testing the openXMarket DataObjects
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
    
    function testGetWebsiteStatsByAgencyId(){
        $aObjectsIds = &$this->_prepare_users();
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->get($aObjectsIds['adminUserID']);
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $oUser->aAccount['account_type'] = 'ADMIN';
        $session['user'] = $oUser;
        
        $aOption = array(
            'orderdirection'    => 'down',
            'listorder'         => 'name',
            'period_preset'     => null,
            'period_start'      => null,
            'period_end'        => null
        );
        
        // Test empty data
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aResult = $doWebStats->getWebsiteStatsByAgencyId($aOption);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        // Add data
        $this->_add_stats($aObjectsIds['websiteUuid']);
        
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aResult = $doWebStats->getWebsiteStatsByAgencyId($aOption);
        $aStoreResult = $aResult;
        $this->assertEqual(count($aResult),1);
        
        $this->assertEqual($aResult[0]['id'], $aObjectsIds['affiliateId']);
        $this->assertEqual($aResult[0]['name'],'website');
        $this->assertEqual($aResult[0]['impressions'],10+20+20);
        $this->assertEqual($aResult[0]['revenue'],1+30+3);
        $this->assertEqual(round($aResult[0]['ecpm'],2),round((1+30+3)*1000/(10+20+20),2));
        
        // Test for 2008-12-22
        $aOption = array(
            'orderdirection'    => 'down',
            'listorder'         => 'name',
            'period_preset'     => null,
            'period_start'      => '2008-12-22',
            'period_end'        => '2008-12-22'
        );
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aResult = $doWebStats->getWebsiteStatsByAgencyId($aOption);
        $this->assertEqual(count($aResult),1);
        
        $this->assertEqual($aResult[0]['impressions'],20);
        $this->assertEqual($aResult[0]['revenue'],30);
        
        // Switch user to MANAGER
        $oUser->aAccount['account_type'] = 'MANAGER';
        $session['user'] = $oUser;
        
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aOption = array(
            'orderdirection'    => 'down',
            'listorder'         => 'name',
            'period_preset'     => null,
            'period_start'      => null,
            'period_end'        => null
        );
        $aResult = $doWebStats->getWebsiteStatsByAgencyId($aOption);
        $this->assertEqual($aResult,$aStoreResult);
        
    }
    
    function testGetSizeStatsByAffiliateId(){
        $aObjectsIds = &$this->_prepare_users();
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->get($aObjectsIds['adminUserID']);
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $oUser->aAccount['account_type'] = 'MANAGER';
        $session['user'] = $oUser;
        
        $aOption = array(
            'orderdirection'    => 'down',
            'listorder'         => 'name',
            'period_preset'     => null,
            'period_start'      => null,
            'period_end'        => null
        );
        
        // Test empty data
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aResult = $doWebStats->getSizeStatsByAffiliateId($aOption);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        // Add data
        $this->_add_stats($aObjectsIds['websiteUuid']);
        
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aOption['affiliateid'] = $aObjectsIds['affiliateId'];
        $aResult = $doWebStats->getSizeStatsByAffiliateId($aOption);
        $this->assertEqual(count($aResult),2);
        
        $this->assertEqual($aResult[0]['name'],'120x120');
        $this->assertEqual($aResult[0]['width'],120);
        $this->assertEqual($aResult[0]['height'],120);
        $this->assertEqual($aResult[0]['impressions'],30);
        $this->assertEqual($aResult[0]['revenue'],31);
        $this->assertEqual(round($aResult[0]['ecpm'],2),round(31*1000/30,2));
        $this->assertEqual($aResult[1]['name'],'120x60');
        $this->assertEqual($aResult[1]['width'],120);
        $this->assertEqual($aResult[1]['height'],60);
        $this->assertEqual($aResult[1]['impressions'],20);
        $this->assertEqual($aResult[1]['revenue'],3);
        $this->assertEqual(round($aResult[1]['ecpm'],2),round(3*1000/20,2));
        
        // Test for 2008-12-22
        $aOption = array(
            'affiliateid'       => $aObjectsIds['affiliateId'],
            'orderdirection'    => 'down',
            'listorder'         => 'name',
            'period_preset'     => null,
            'period_start'      => '2008-12-22',
            'period_end'        => '2008-12-22'
        );
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aResult = $doWebStats->getSizeStatsByAffiliateId($aOption);
        $this->assertEqual(count($aResult),1);
        
        $this->assertEqual($aResult[0]['impressions'],20);
        $this->assertEqual($aResult[0]['revenue'],30);
    }

    function testGetSizeStatsForAffiliates(){
        $aObjectsIds = &$this->_prepare_users();
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->get($aObjectsIds['adminUserID']);
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $oUser->aAccount['account_type'] = 'MANAGER';
        $session['user'] = $oUser;
        
        $aOption = array(
            'aAffiliateids'     => array(),
            'orderdirection'    => 'down',
            'listorder'         => 'name',
            'period_preset'     => null,
            'period_start'      => null,
            'period_end'        => null
        );
        
        // Test empty data
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aResult = $doWebStats->getSizeStatsForAffiliates($aOption);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        // Add data
        $this->_add_stats($aObjectsIds['websiteUuid']);
        
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aResult = $doWebStats->getSizeStatsForAffiliates($aOption);
        $this->assertEqual(count($aResult),1);
        
        $this->assertEqual(count($aResult[$aObjectsIds['affiliateId']]),2);
        $aRows = $aResult[$aObjectsIds['affiliateId']];
        
        $this->assertEqual($aRows[0]['id'],$aObjectsIds['affiliateId']);
        $this->assertEqual($aRows[0]['name'],'120x120');
        $this->assertEqual($aRows[0]['width'],120);
        $this->assertEqual($aRows[0]['height'],120);
        $this->assertEqual($aRows[0]['impressions'],30);
        $this->assertEqual($aRows[0]['revenue'],31);
        $this->assertEqual(round($aRows[0]['ecpm'],2),round(31*1000/30,2));
        $this->assertEqual($aRows[1]['id'],$aObjectsIds['affiliateId']);
        $this->assertEqual($aRows[1]['name'],'120x60');
        $this->assertEqual($aRows[1]['width'],120);
        $this->assertEqual($aRows[1]['height'],60);
        $this->assertEqual($aRows[1]['impressions'],20);
        $this->assertEqual($aRows[1]['revenue'],3);
        $this->assertEqual(round($aRows[1]['ecpm'],2),round(3*1000/20,2));
        
        // Test for 2008-12-22
        $aOption = array(
            'aAffiliateids'     => array(),
            'orderdirection'    => 'down',
            'listorder'         => 'name',
            'period_preset'     => null,
            'period_start'      => '2008-12-22',
            'period_end'        => '2008-12-22'
        );
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $aResult = $doWebStats->getSizeStatsForAffiliates($aOption);
        
        $this->assertEqual(count($aResult),1);
        
        $this->assertEqual(count($aResult[$aObjectsIds['affiliateId']]),1);
        $aRows = $aResult[$aObjectsIds['affiliateId']];
        
        $this->assertEqual($aRows[0]['id'],$aObjectsIds['affiliateId']);
        $this->assertEqual($aRows[0]['impressions'],20);
        $this->assertEqual($aRows[0]['revenue'],30);
    }
    
    function _prepare_users()
    {
        $aObjectsIds = array();
        
        $doAgency = OA_Dal::factoryDO('agency');
        $aObjectsIds['agencyId'] = DataGenerator::generateOne($doAgency);
        
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($aObjectsIds['agencyId']);
        $aObjectsIds['managerAccountId'] = $doAgency->account_id;
        
        // Create admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $aObjectsIds['adminAccountId'] = DataGenerator::generateOne($doAccounts);
        
        // Create user linked to admin account
        // Default account for this user is set to manager account
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $aObjectsIds['managerAccountId'];
        $doUsers->username = 'admin';
        $aObjectsIds['adminUserID'] = DataGenerator::generateOne($doUsers);

        $doAccountsUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccountsUserAssoc->account_id = $aObjectsIds['managerAccountId'];
        $doAccountsUserAssoc->user_id = $aObjectsIds['adminUserID'];
        DataGenerator::generateOne($doAccountsUserAssoc);
        
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $aObjectsIds['agencyId'];
        $doAffiliate->name     = 'website';
        $aObjectsIds['affiliateId'] = DataGenerator::generateOne($doAffiliate);
        
        $aObjectsIds['websiteUuid'] = 'uuid1string';        
        $doWebsitePref = OA_Dal::factoryDO('Ext_market_website_pref');
        $doWebsitePref->affiliateid = $aObjectsIds['affiliateId'];
        $doWebsitePref->website_id  = $aObjectsIds['websiteUuid'];
        DataGenerator::generateOne($doWebsitePref);

        return $aObjectsIds;
    }
       
    function _add_stats($website_uuid){
        // Add stats with some sample data
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $doWebStats->p_website_id = $website_uuid;
        $doWebStats->impressions = 10;
        $doWebStats->date_time   = '2008-12-12 14:00:00';
        $doWebStats->revenue     = 1;
        $doWebStats->width       = 120;
        $doWebStats->height      = 120;
        DataGenerator::generateOne($doWebStats);

        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $doWebStats->p_website_id = $website_uuid;
        $doWebStats->impressions = 20;
        $doWebStats->date_time   = '2008-12-22 14:00:00';
        $doWebStats->revenue     = 30;
        $doWebStats->width       = 120;
        $doWebStats->height      = 120;
        DataGenerator::generateOne($doWebStats);
        
        $doWebStats = OA_Dal::factoryDO('ext_market_web_stats');
        $doWebStats->p_website_id = $website_uuid;
        $doWebStats->impressions = 20;
        $doWebStats->date_time   = '2008-12-12 14:00:00';
        $doWebStats->revenue     = 3;
        $doWebStats->width       = 120;
        $doWebStats->height      = 60;
        DataGenerator::generateOne($doWebStats);
    }
}

?>
