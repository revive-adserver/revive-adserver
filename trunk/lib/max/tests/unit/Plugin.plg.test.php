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

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/plugins/Maintenance/Maintenance.php';

/**
 * A class for dealing with raised errors, so that they don't
 * show in the unit test interface. Should be used directly,
 * rather than as a mocked object, as using the mock object to
 * compare the errors doesn't work, due to the trackback data
 * stored in PEAR_Error objects.
 */
class TestErrorHandler {

    /**
     * A class variable for storing PEAR errors.
     *
     * @var array
     */
    var $aErrors;

    /**
     * A method to "handle" errors. It simply stores the errors
     * in the class variable, so that they can be inspected later.
     *
     * @param PEAR_Error $oError A PEAR_Error object.
     * @return void
     */
    function handleErrors($oError)
    {
        $this->aErrors[] = $oError;
    }

    /**
     * A method to reset the class.
     *
     * @return void
     */
    function reset()
    {
        $this->aErrors = array();
    }

}

/**
 * A fake maintenance plugin class for testing.
 *
 */
class Plugins_Maintenance_Fake_Fake extends Plugins_Maintenance
{

    function getHookType()
    {
        return MAINTENANCE_PLUGIN_POST;
    }

    function getHook()
    {
        return MSE_PLUGIN_HOOK_summariseIntermediateRequests;
    }

    function test() {}

    function testParams($foo, $bar, $baz) {}

}

/**
 * A class for testing the MAX_Plugin class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class TestOfMAX_Plugin extends UnitTestCase {

    /**
     * The constructor method.
     *
     * @return TestOfMAX_Plugin
     */
    function TestOfMAX_Plugin() {
        $this->UnitTestCase();
    }

    /**
     * A method to test the factory() method.
     */
    function testFactory()
    {
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        // Test basic creation of a non-existant plugin fails
        $result = MAX_Plugin::factory('foo', 'bar');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Unable to include the file '.MAX_PATH.'/plugins/foo/bar/bar'.MAX_PLUGINS_EXTENSION.'.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Test plugin name creation of a non-existant plugin fails
        $result = MAX_Plugin::factory('foo', 'bar', 'baz');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Unable to include the file '.MAX_PATH.'/plugins/foo/bar/baz'.MAX_PLUGINS_EXTENSION.'.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Test correct creation of a plugin object
        $result = MAX_Plugin::factory('reports', 'standard', 'advertisingAnalysisReport');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 0);
        $this->assertTrue(is_a($result, 'Plugins_Reports_Standard_AdvertisingAnalysisReport'));
        $this->assertEqual($result->module, 'reports');
        $this->assertEqual($result->package, 'standard');
        $this->assertEqual($result->name, 'advertisingAnalysisReport');
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();
    }

    /**
     * A method to test the _includePluginFile() method.
     */
    function test_includePluginFile()
    {
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        // Test basic case where plugin file does not exist
        $result = MAX_Plugin::_includePluginFile('foo', 'bar');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Unable to include the file '.MAX_PATH.'/plugins/foo/bar/bar'.MAX_PLUGINS_EXTENSION.'.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Test plugin name case where plugin file does not exist
        $result = MAX_Plugin::_includePluginFile('foo', 'bar', 'baz');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Unable to include the file '.MAX_PATH.'/plugins/foo/bar/baz'.MAX_PLUGINS_EXTENSION.'.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        /**
         * @TODO Write a test for testing where the plugin file exists, but the plugin
         * file name is "wrong". This will probably require that the MAX_Plugin class
         * be changed from a static class to a normal class, so that the
         * _getPluginClassName() method can be mocked to return an invalid class name.
         */
        // Test correct inclusion of a plugin
        $result = MAX_Plugin::_includePluginFile('reports', 'standard', 'advertisingAnalysisReport');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 0);
        $this->assertTrue($result);
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();
    }

    /**
     * A method to test the _getPluginClassName() method.
     */
    function test_getPluginClassName()
    {
        // Test basic case
        $result = MAX_Plugin::_getPluginClassName('foo', 'bar');
        $this->assertEqual($result, 'Plugins_Foo_Bar_Bar');
        // Test plugin name case
        $result = MAX_Plugin::_getPluginClassName('foo', 'bar', 'baz');
        $this->assertEqual($result, 'Plugins_Foo_Bar_Baz');
    }

    /**
     * A method to test the getPlugins() method.
     */
    function testGetPlugins()
    {
        // Test on a non-existant plugin module
        $result = MAX_Plugin::getPlugins('foo');
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        // Test on a plugin module with plugins, but with a search depth
        // that doesn't reach down to the level where the plugins are stored
        $result = MAX_Plugin::getPlugins('reports', null, true, 0);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        // Test on a plugin module with plugins, but with a search depth
        // that does reach down to the level where the plugins are stored
        $result = MAX_Plugin::getPlugins('reports', null, true, 1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 5);
        $this->assertTrue(is_a($result['advertisingAnalysisReport'], 'Plugins_Reports_Standard_AdvertisingAnalysisReport'));
        $this->assertEqual($result['advertisingAnalysisReport']->module, 'reports');
        $this->assertEqual($result['advertisingAnalysisReport']->package, 'standard');
        $this->assertEqual($result['advertisingAnalysisReport']->name, 'advertisingAnalysisReport');
        // Test on a plugin module with plugins, but with a search depth
        // that does reach down to the level where the plugins are stored
        $result = MAX_Plugin::getPlugins('reports', null, false, 1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 5);
        $this->assertTrue(is_a($result['standard:advertisingAnalysisReport'], 'Plugins_Reports_Standard_AdvertisingAnalysisReport'));
        $this->assertEqual($result['standard:advertisingAnalysisReport']->module, 'reports');
        $this->assertEqual($result['standard:advertisingAnalysisReport']->package, 'standard');
        $this->assertEqual($result['standard:advertisingAnalysisReport']->name, 'advertisingAnalysisReport');
        // Test on a plugin module and package with plugins, but with a search
        // depth that does reach down to the level where the plugins are stored
        $result = MAX_Plugin::getPlugins('reports', 'standard', true, 0);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 4);
        $this->assertTrue(is_a($result['advertisingAnalysisReport'], 'Plugins_Reports_Standard_AdvertisingAnalysisReport'));
        $this->assertEqual($result['advertisingAnalysisReport']->module, 'reports');
        $this->assertEqual($result['advertisingAnalysisReport']->package, 'standard');
        $this->assertEqual($result['advertisingAnalysisReport']->name, 'advertisingAnalysisReport');
        // Test on a plugin module and package with plugins, but with a search
        // depth that does reach down to the level where the plugins are stored
        $result = MAX_Plugin::getPlugins('reports', 'standard', false, 0);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 4);
        $this->assertTrue(is_a($result['standard:advertisingAnalysisReport'], 'Plugins_Reports_Standard_AdvertisingAnalysisReport'));
        $this->assertEqual($result['standard:advertisingAnalysisReport']->module, 'reports');
        $this->assertEqual($result['standard:advertisingAnalysisReport']->package, 'standard');
        $this->assertEqual($result['standard:advertisingAnalysisReport']->name, 'advertisingAnalysisReport');
    }

    /**
     * A method to test the _getPluginsFiles() method.
     */
    function test_getPluginsFiles()
    {
        // Test on a non-existant plugin module
        $result = MAX_Plugin::_getPluginsFiles('foo');
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        // Test on a plugin module with plugins, but with a search depth
        // that doesn't reach down to the level where the plugins are stored
        $result = MAX_Plugin::_getPluginsFiles('reports', null, 0);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        // Test on a plugin module with plugins, but with a search depth
        // that does reach down to the level where the plugins are stored
        $result = MAX_Plugin::_getPluginsFiles('reports', null, 1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 5);
        // Test on a plugin module and package with plugins, but with a search
        // depth that does reach down to the level where the plugins are stored
        $result = MAX_Plugin::_getPluginsFiles('reports', 'standard', 0);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 4);
    }

    /**
     * A method to test the _getPluginsFilesFromDirectory() method.
     */
    function test_getPluginsFilesFromDirectory()
    {
        // Test on a non-existant directory
        $result = MAX_Plugin::_getPluginsFilesFromDirectory(MAX_PATH . '/thisDoesNotExist');
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        // Test on a directory with no plugins
        $result = MAX_Plugin::_getPluginsFilesFromDirectory(MAX_PATH . '/etc');
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        // Test on a directory with plugins, but with a search depth that doesn't
        // reach down to the level where the plugins are stored
        $result = MAX_Plugin::_getPluginsFilesFromDirectory(MAX_PATH . '/plugins/reports', 0);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        // Test on a directory with plugins, with a search depth that does
        // reach down to the level where the plugins are stored
        $result = MAX_Plugin::_getPluginsFilesFromDirectory(MAX_PATH . '/plugins/reports', 1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 5);
        $this->assertEqual(
            $result['standard:advertisingAnalysisReport'],
            MAX_PATH.'/plugins/reports/standard/advertisingAnalysisReport'.MAX_PLUGINS_EXTENSION
        );
    }

    /**
     * A method to test the callStaticMethod() method.
     */
    function testCallStaticMethod()
    {
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        // Test with a bad module/package
        $return = MAX_Plugin::callStaticMethod('foo', 'bar', null, 'foo');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Unable to include the file '.MAX_PATH.'/plugins/foo/bar/bar'.MAX_PLUGINS_EXTENSION.'.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        // Test with a bad method
        $return = MAX_Plugin::callStaticMethod('reports', 'standard', 'advertisingAnalysisReport', 'foo');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            "Method 'foo()' not defined in class 'Plugins_Reports_Standard_AdvertisingAnalysisReport'."
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();

        // Test with a real method, no parameters
        $return = MAX_Plugin::callStaticMethod('deliveryLimitations', 'Time', 'Date', 'isAllowed');
        $this->assertTrue($return);

        // Test with a real method, with parameters
        $return = MAX_Plugin::callStaticMethod('deliveryLimitations', 'Time', 'Date', 'isAllowed', array('channel-acl.php'));
        $this->assertFalse($return);
    }

    /**
     * A method to test the callOnPlugins() method.
     *
     * @TODO Deal with class name case changes.
     */
    function testCallOnPlugins()
    {
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        // Test with a non-array parameter for the plugins
        $aPlugins = 'bar';
        $result = MAX_Plugin::callOnPlugins($aPlugins, 'foo');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Bad argument: Not an array of plugins.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Test with an array of non-plugins
        $aPlugins = array('bar');
        $result = MAX_Plugin::callOnPlugins($aPlugins, 'foo');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Bad argument: Not an array of plugins.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Prepare an array of plugins
        $aPlugins = MAX_Plugin::getPlugins('reports', 'standard', true, 0);
        // Test with a bad method
        $result = MAX_Plugin::callOnPlugins($aPlugins, 'foo');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            "Method 'foo()' not defined in class 'Plugins_Reports_Standard_AdvertisingAnalysisReport'."
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();
        // Test with a real method, no parameters
        $result = MAX_Plugin::callOnPlugins($aPlugins, 'getDefaults');
        foreach ($aPlugins as $key => $oPlugin) {
            if (is_a($oPlugin, 'Plugins_Reports_Standard_LiveCampaignDeliveryReport')) {
                $this->assertTrue(is_array($result[$key]));
                $this->assertEqual(count($result[$key]), 2);
            } else {
                $this->assertTrue(is_array($result[$key]));
                $this->assertEqual(count($result[$key]), 3);
            }
        }
        // Test with a real method, with parameters
        $result = MAX_Plugin::callOnPlugins($aPlugins, 'useReportWriter', array('foo'));
        foreach ($aPlugins as $key => $oPlugin) {
            $this->assertNull($result[$key]);
        }
    }

    /**
     * A method to test the callOnPluginsByHook() method.
     *
     * @TODO Deal with class name case changes.
     */
    function testCallOnPluginsByHook()
    {
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        // Test with a non-array parameter for the plugins
        $aPlugins = 'bar';
        $result = MAX_Plugin::callOnPluginsByHook($aPlugins, 'foo', MAINTENANCE_PLUGIN_POST, MSE_PLUGIN_HOOK_summariseIntermediateRequests);
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Bad argument: Not an array of plugins.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Test with an array of non-plugins
        $aPlugins = array('bar');
        $result = MAX_Plugin::callOnPluginsByHook($aPlugins, 'foo', MAINTENANCE_PLUGIN_POST, MSE_PLUGIN_HOOK_summariseIntermediateRequests);
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Bad argument: Not an array of plugins.'
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();
        // Prepare an array of non-maintenance plugins
        $aPlugins = MAX_Plugin::getPlugins('reportWriter', 'output', true, 0);
        // Test with non-maintenance plugins
        $result = MAX_Plugin::callOnPluginsByHook($aPlugins, 'foo', MAINTENANCE_PLUGIN_POST, MSE_PLUGIN_HOOK_summariseIntermediateRequests);
        $this->assertTrue($result);
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        // Prepare an array of maintenance plugins
        $aPlugins = array(new Plugins_Maintenance_Fake_Fake());
        // Test with a bad method
        $result = MAX_Plugin::callOnPluginsByHook($aPlugins, 'foo', MAINTENANCE_PLUGIN_POST, MSE_PLUGIN_HOOK_summariseIntermediateRequests);
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        if (phpversion() < 5) {
            $error = "Method 'foo()' not defined in class 'plugins_maintenance_fake_fake'.";
        } else {
        	$error = "Method 'foo()' not defined in class 'Plugins_Maintenance_Fake_Fake'.";
        }
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            $error
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();
        // Test with a real method, no parameters
        $result = MAX_Plugin::callOnPluginsByHook($aPlugins, 'test', MAINTENANCE_PLUGIN_POST, MSE_PLUGIN_HOOK_summariseIntermediateRequests);
        $this->assertTrue($result);
        // Test with a real method, with parameters
        $result = MAX_Plugin::callOnPluginsByHook($aPlugins, 'testParams', MAINTENANCE_PLUGIN_POST, MSE_PLUGIN_HOOK_summariseIntermediateRequests, array('foo', 'bar', 'baz'));
        $this->assertTrue($result);
    }

    /**
     * A method to test the factoryPluginByModuleConfig() method.
     *
     * @TODO To be written.
     */
    function testFactoryPluginByModuleConfig()
    {

    }

    /**
     * A method to test the getConfig() method.
     *
     * @TODO To be written.
     */
    function testGetConfig()
    {

    }

    /**
     * A method to test the getConfigFileName() method.
     */
    function testGetConfigFileName()
    {
        // Test getting the default config file name by module
        $result = MAX_Plugin::getConfigFileName('foo', null, null, true, 'fake.host.name');
        $this->assertEqual($result, MAX_PATH.'/plugins/foo/fake.host.name.plugin.conf.php');
        // Test getting the default config file name by module and package
        $result = MAX_Plugin::getConfigFileName('foo', 'bar', null, true, 'fake.host.name');
        $this->assertEqual($result, MAX_PATH.'/plugins/foo/bar/fake.host.name.plugin.conf.php');
        // Test getting the default config file name by module, package and plugin
        $result = MAX_Plugin::getConfigFileName('foo', 'bar', 'baz', true, 'fake.host.name');
        $this->assertEqual($result, MAX_PATH.'/plugins/foo/bar/baz.fake.host.name.plugin.conf.php');
        // Test getting the real config file name by module
        $result = MAX_Plugin::getConfigFileName('foo', null, null, false, 'fake.host.name');
        $this->assertEqual($result, MAX_PATH.'/var/plugins/config/foo/fake.host.name.plugin.conf.php');
        // Test getting the real config file name by module and package
        $result = MAX_Plugin::getConfigFileName('foo', 'bar', null, false, 'fake.host.name');
        $this->assertEqual($result, MAX_PATH.'/var/plugins/config/foo/bar/fake.host.name.plugin.conf.php');
        // Test getting the real config file name by module, package and plugin
        $result = MAX_Plugin::getConfigFileName('foo', 'bar', 'baz', false, 'fake.host.name');
        $this->assertEqual($result, MAX_PATH.'/var/plugins/config/foo/bar/baz.fake.host.name.plugin.conf.php');
    }

    /**
     * A method to test the getConfigByFileName() method.
     */
    function testGetConfigByFileName()
    {
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        // Test a config file that does not exist
        $result = MAX_Plugin::getConfigByFileName('foo');
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            "Config file 'foo' does not exist."
        );
        $this->assertFalse($result);
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();
        // Test a config file that does exist
        $result = MAX_Plugin::getConfigByFileName(MAX_PATH . '/plugins/geotargeting/default.plugin.conf.php');
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result['type'], 'none');
        $this->assertFalse($result['saveStats']);
        // Test a config file that does exist, with sections
        $result = MAX_Plugin::getConfigByFileName(MAX_PATH . '/plugins/geotargeting/default.plugin.conf.php', true);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertTrue(is_array($result['geotargeting']));
        $this->assertEqual(count($result['geotargeting']), 2);
        $this->assertEqual($result['geotargeting']['type'], 'none');
        $this->assertFalse($result['geotargeting']['saveStats']);
    }

    /**
     * A method to test the copyDefaultConfig() method.
     *
     * @TODO To be written.
     */
    function testCopyDefaultConfig()
    {

    }

    /**
     * A method to test the writePluginConfig() method.
     *
     * @TODO To be written.
     */
    function testWritePluginConfig()
    {

    }

    /**
     * A method to test the _mkDirRecursive() method.
     */
    function test_mkDirRecursive()
    {
        // Try to create a folder
        $result = MAX_Plugin::_mkDirRecursive(MAX_PLUGINS_VAR . '/test');
        $this->assertTrue($result);
        // Remove the created directory
        $this->_delDir(MAX_PLUGINS_VAR . '/test');
    }

    /**
     * A method to test the prepareCacheOptions() method.
     */
    function testPrepareCacheOptions()
    {
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        // Test with directory that should be creatable
        $result = MAX_Plugin::prepareCacheOptions('Maintenance', 'Fake', MAX_PLUGINS_VAR . '/cache/test/');
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['cacheDir'], MAX_PLUGINS_VAR . '/cache/test/');
        $this->assertEqual($result['lifeTime'], 3600);
        $this->assertTrue($result['automaticSerialization']);
        // Remove the created directory
        $this->_delDir(MAX_PLUGINS_VAR . '/cache/test');
        // Re-test without a set cache directory, but a set cache time
        $result = MAX_Plugin::prepareCacheOptions('Maintenance', 'Fake', null, 500);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['cacheDir'], MAX_PLUGINS_VAR . '/cache/Maintenance/Fake/');
        $this->assertEqual($result['lifeTime'], 500);
        $this->assertTrue($result['automaticSerialization']);
        // Remove the created directory
        $this->_delDir(MAX_PLUGINS_VAR . '/cache/Maintenance');
    }

    /**
     * A method to test the saving, reading and clearing of cache data.
     */
    function testCacheMethods()
    {
        // Test reading when no data cached
        $result = MAX_Plugin::getCacheForPluginById('foo', 'Maintenance', 'Fake');
        $this->assertFalse($result);
        // Test a simple write and read
        $aData = array('foo', 'bar');
        $result = MAX_Plugin::saveCacheForPlugin($aData, 'foo', 'Maintenance', 'Fake');
        $this->assertTrue($result);
        $result = MAX_Plugin::getCacheForPluginById('foo', 'Maintenance', 'Fake');
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[0], 'foo');
        $this->assertEqual($result[1], 'bar');
        // Test a write and read when cache data has exipired, and the validity is tested
        $aOptions = MAX_Plugin::prepareCacheOptions('Maintenance', 'Fake', null, 0);
        $result = MAX_Plugin::saveCacheForPlugin($aData, 'foo', 'Maintenance', 'Fake', null, $aOptions);
        $this->assertTrue($result);
        $result = MAX_Plugin::getCacheForPluginById('foo', 'Maintenance', 'Fake', null, false, $aOptions);
        $this->assertFalse($result);
        // Re-test the read, not checking the validity
        $result = MAX_Plugin::getCacheForPluginById('foo', 'Maintenance', 'Fake', null, true, $aOptions);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[0], 'foo');
        $this->assertEqual($result[1], 'bar');
        // Clear the cache and re-test the read
        MAX_Plugin::cleanPluginCache('Maintenance', 'Fake');
        $result = MAX_Plugin::getCacheForPluginById('foo', 'Maintenance', 'Fake', null, true, $aOptions);
        $this->assertFalse($result);
        // Remove the created directory
        $this->_delDir(MAX_PLUGINS_VAR . '/cache/Maintenance');
    }

    /**
     * A private method of the test to delete entire directories.
     *
     * @param string $dirName The directory to delete.
     */
    function _delDir($dirName) {
       if (empty($dirName)) {
           return true;
       }
       if (file_exists($dirName)) {
           $dir = dir($dirName);
           while ($file = $dir->read()) {
               if ($file != '.' && $file != '..') {
                   if (is_dir($dirName.'/'.$file)) {
                       $this->_delDir($dirName.'/'.$file);
                   } else {
                       @unlink($dirName.'/'.$file) or die('File '.$dirName.'/'.$file.' couldn\'t be deleted, check permissions.');
                   }
               }
           }
           $dir->close();
           @rmdir($dirName) or die('Folder '.$dirName.' couldn\'t be deleted, check permissions.');
       } else {
           return false;
       }
       return true;
    }

}

?>
