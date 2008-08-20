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
 * A class for testing the openXDeliveryCacheStore
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfPlugins_openXDeliveryCacheStore extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXDeliveryCacheStore');
        TestEnv::installPluginPackage('openXDeliveryCacheStore');
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXDeliveryCacheStore');
    }

    function test_oxFile_class()
    {
        $oComponent = &OX_Component::factory('deliveryCacheStore', 'oxFile', 'oxFile');
        $this->_assertClass($oComponent,'deliveryCacheStore', 'oxFile', 'oxFile');
    }

    function test_oxMemcached_class()
    {
        $oComponent = &OX_Component::factory('deliveryCacheStore', 'oxMemcached', 'oxMemcached');
        $this->_assertClass($oComponent, 'deliveryCacheStore', 'oxMemcached', 'oxMemcached');
    }

    function _assertClass($oComponent, $extension, $group, $component)
    {
        $sender = $group.'_'.$component;
        $this->assertIsA($oComponent, 'Plugins_'.$extension.'_'.$group.'_'.$component, $sender.' invalid class');
        $this->assertIsA($oComponent, 'Plugins_'.$extension, $sender.' invalid parent class');
        $this->assertTrue(method_exists($oComponent, 'getName'), $sender.' missing method getName');
        $this->assertTrue(method_exists($oComponent, 'getStatus'), $sender.' missing method getStatus');
        $this->assertTrue(method_exists($oComponent, '_deleteCacheFile'), $sender.' missing method _deleteCacheFile');
        $this->assertTrue(method_exists($oComponent, '_deleteAll'), $sender.' missing method _deleteAll');
    }
}

?>
