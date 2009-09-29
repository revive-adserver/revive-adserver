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
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_Upgrade.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the upgrade package for market plugin 1.2.0-rc1
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */

class oxMarket_UpgradePostscript_1_2_0_RC1Test extends UnitTestCase
{
    
    function testExecute()
    {
        // Install market plugin
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
        
        // Prepare upgrade objects
        Mock::generatePartial(
            'OA_UpgradeLogger',
            $mockLogger = 'OA_UpgradeLogger'.rand(),
            array('logOnly', 'logError', 'log')
        );

        $oLogger = new $mockLogger($this);
        $oLogger->setReturnValue('logOnly', true);
        $oLogger->setReturnValue('logError', true);
        $oLogger->setReturnValue('log', true);

        
        $oDBUpgrader = new OA_DB_Upgrade($oLogger); 
        
        require_once dirname(__FILE__) . '/../../postscript_oxMarket_upgrade_1.2.0-RC1.php';
        $this->assertEqual($className, 'oxMarket_UpgradePostscript_1_2_0_RC1');
        $oUPckg = new oxMarket_UpgradePostscript_1_2_0_RC1();
        $this->assertTrue($oUPckg->execute(array($oDBUpgrader)));
        
        // Add some websites
        
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $affiliateId[1] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $affiliateId[2] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $affiliateId[3] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $affiliateId[4] = DataGenerator::generateOne($doAffiliate);
        
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->is_url_synchronized = 't';
        $doWebsite->affiliateid = $affiliateId[1];
        $webPrefId[1] = DataGenerator::generateOne($doWebsite);
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->is_url_synchronized = 't';
        $doWebsite->affiliateid = $affiliateId[2];
        $webPrefId[1] = DataGenerator::generateOne($doWebsite);
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->is_url_synchronized = 'f';
        $doWebsite->affiliateid = $affiliateId[3];
        $webPrefId[1] = DataGenerator::generateOne($doWebsite);
        
        $this->assertTrue($oUPckg->execute(array($oDBUpgrader)));
        
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $result = $doWebsite->getAll();
        $expected = array (
            array ( "affiliateid" => $affiliateId[1], "website_id" => "", "is_url_synchronized" => "f"),
            array ( "affiliateid" => $affiliateId[2], "website_id" => "", "is_url_synchronized" => "f"),
            array ( "affiliateid" => $affiliateId[3], "website_id" => "", "is_url_synchronized" => "f"));
        $this->assertEqual($result, $expected);
        
        // clean up
        TestEnv::uninstallPluginPackage('openXMarket', false);
    }
}