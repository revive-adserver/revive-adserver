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
class Plugins_TestOfPlugins_openXBannerTypes extends UnitTestCase
{
    function setUp()
    {
        TestEnv::uninstallPluginPackage('openXBannerTypes');
        TestEnv::installPluginPackage('openXBannerTypes');
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXBannerTypes');
    }

    function test_genericText_class()
    {
        $oComponent = &OX_Component::factory('bannerTypeText', 'oxText', 'genericText');
        $this->_assertClass($oComponent,'bannerTypeText', 'oxText', 'genericText');
    }

    function test_genericHtml_class()
    {
        $oComponent = &OX_Component::factory('bannerTypeHtml', 'oxHtml', 'genericHtml');
        $this->_assertClass($oComponent, 'bannerTypeHtml', 'oxHtml', 'genericHtml');
        $this->assertTrue(method_exists($oComponent, 'buildHtmlTemplate'), $sender.' missing method buildHtmlTemplate');
    }

    function _assertClass($oComponent, $extension, $group, $component)
    {
        $sender = $group.'_'.$component;
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$component, $sender.' invalid class');
        $this->assertIsA($oComponent, 'Plugins_'.$extension, $sender.' invalid parent class');
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
