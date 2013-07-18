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

/**
 * A class for testing the openXMarket
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfPlugins_openXMarket extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket',false);
        TestEnv::installPluginPackage('openXMarket',false);
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXMarket',false);
    }

    function test_oxMarketMaintenance_class()
    {
        $this->_assertClass('maintenanceStatisticsTask', 'oxMarketMaintenance', 'oxMarketMaintenance', array('addMaintenanceStatisticsTask'));
    }

    function _assertClass($extension, $group, $component, $aMethods)
    {
        $oComponent = &OX_Component::factory($extension, $group, $component);
        $sender = $group.'_'.$component;
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$component, $sender.' invalid class');
        $this->assertIsA($oComponent, 'Plugins_'.$extension, $sender.' invalid parent class');
        foreach ($aMethods as $method) {
            $this->assertTrue(method_exists($oComponent, $method), $sender.' missing method '.$method);
        }
    }
}

?>
