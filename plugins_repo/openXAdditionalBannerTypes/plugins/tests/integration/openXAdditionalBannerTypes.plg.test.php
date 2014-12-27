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
 * A class for testing the openXBannerTypes
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_openXAdditionalBannerTypes extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXAdditionalBannerTypes');
        TestEnv::installPluginPackage('openXAdditionalBannerTypes');
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXAdditionalBannerTypes');
    }

    function test_adsense_class()
    {
        $oComponent = &OX_Component::factory('bannerTypeHtml', 'openXHtmlAdsense', 'adsense');
        $this->_assertClass($oComponent, 'bannerTypeHtml', 'openXHtmlAdsense', 'adsense');
        $this->assertTrue(method_exists($oComponent, 'buildHtmlTemplate'), $sender.' missing method buildHtmlTemplate');
    }

    function _assertClass($oComponent, $extension, $group, $plugin)
    {
        $sender = $group.'_'.$plugin;
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$plugin, $sender.' invalid class');
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$plugin, $sender.' invalid parent class');
        $this->assertTrue(method_exists($oComponent, 'getStorageType'), $sender.' missing method getStorageType');
        $this->assertTrue(method_exists($oComponent, 'getContentType'), $sender.' missing method getContentType');
        $this->assertTrue(method_exists($oComponent, 'getOptionDescription'), $sender.' missing method getOptionDescription');
        $this->assertTrue(method_exists($oComponent, 'buildForm'), $sender.' missing method buildForm');
        $this->assertTrue(method_exists($oComponent, 'validateForm'), $sender.' missing method validateForm');
        $this->assertTrue(method_exists($oComponent, 'preprocessForm'), $sender.' missing method processForm');
        $this->assertTrue(method_exists($oComponent, 'processForm'), $sender.' missing method processForm');
    }
}

?>
