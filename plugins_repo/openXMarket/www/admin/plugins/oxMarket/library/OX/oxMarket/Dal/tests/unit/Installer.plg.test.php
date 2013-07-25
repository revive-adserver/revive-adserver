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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OX/Dal/Market/MarketPluginTools.php';

/**
 * A class for testing the Installer DAL library
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_InstallerTest extends UnitTestCase
{
    public function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
        // include only if class isn't present after installation
        if (!class_exists('OX_oxMarket_Dal_Installer')) {
            require_once dirname(__FILE__).'/../../Installer.php';
        }
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::uninstallPluginPackage('openXMarket', false);
        OA_Dal_ApplicationVariables::delete('oxMarket_publisher_account_id');
        OA_Dal_ApplicationVariables::delete('oxMarket_api_key');
    }

    public function testIsRegistrationRequired()
    {
        $this->assertTrue(OX_oxMarket_Dal_Installer::isRegistrationRequired());

        // Create account and set publisher account association data
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->account_id = $adminAccountId;
        $doExtMarket->publisher_account_id = 'publisher_account_id';
        $doExtMarket->api_key = 'api_key';
        $doExtMarket->status =
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        $doExtMarket->insert();

        $this->assertFalse(OX_oxMarket_Dal_Installer::isRegistrationRequired());

        // Clear account association
        $doExtMarket->delete();
        OA_Dal_ApplicationVariables::delete('admin_account_id');
    }


}
