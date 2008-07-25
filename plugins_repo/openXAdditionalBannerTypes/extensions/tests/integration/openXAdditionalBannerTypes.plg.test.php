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

/**
 * A class for testing the openXBannerTypes
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Chris Nutting <chris.nutting@openx.org>
 */
class Plugins_TestOfPlugins_openXAdditionalBannerTypes extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXAdditionalBannerTypes');
        TestEnv::installPluginPackage('openXAdditionalBannerTypes', 'openXAdditionalBannerTypes', '/plugins_repo/');
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
