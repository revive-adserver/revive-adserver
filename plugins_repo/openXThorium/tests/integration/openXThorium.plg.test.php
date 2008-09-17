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
 * A class for testing the Plugins_DeliveryLimitations_Client_Domain class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_openXThorium extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXThorium', false);
        TestEnv::installPluginPackage('openXThorium', false);
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXThorium', false);
        TestEnv::clearMenuCache();
    }

    function test_oxThorium()
    {
        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['plugins']['openXThorium']));
        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['oxThorium']));
        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['oxIndium']));

    }

    function test_admin_oxThorium()
    {
        // test the class implementation
        $oComponent = &OX_Component::factory('admin', 'oxThorium', 'oxThorium');
        // common extension methods
        $this->_assertClass($oComponent, 'admin', 'oxThorium', 'oxThorium');
        // plugin-specific methods
        $this->assertTrue(method_exists($oComponent, 'afterPricingFormSection'), $sender.' missing method _buildHtmlTemplate');
        $this->assertTrue(method_exists($oComponent, 'processForm'), $sender.' missing method exportData');

    }

    function _assertClass($oComponent, $extension, $group, $plugin)
    {
        $sender = $group.'_'.$plugin;
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$plugin, $sender.' invalid class');
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$plugin, $sender.' invalid parent class');
    }

}

?>
