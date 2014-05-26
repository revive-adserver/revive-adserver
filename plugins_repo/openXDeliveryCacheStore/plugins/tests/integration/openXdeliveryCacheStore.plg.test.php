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

    function test_oxCacheFile_class()
    {
        $oComponent = &OX_Component::factory('deliveryCacheStore', 'oxCacheFile', 'oxCacheFile');
        $this->_assertClass($oComponent,'deliveryCacheStore', 'oxCacheFile', 'oxCacheFile');
    }

    function test_oxMemcached_class()
    {
        if (extension_loaded('memcache')) {
            $oComponent = &OX_Component::factory('deliveryCacheStore', 'oxMemcached', 'oxMemcached');
            $this->_assertClass($oComponent, 'deliveryCacheStore', 'oxMemcached', 'oxMemcached');
        } else {
            $this->skip("memcache extension not available");
        }
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
