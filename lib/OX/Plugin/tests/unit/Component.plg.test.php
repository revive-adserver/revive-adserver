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
 * A class for dealing with raised errors, so that they don't
 * show in the unit test interface. Should be used directly,
 * rather than as a mocked object, as using the mock object to
 * compare the errors doesn't work, due to the trackback data
 * stored in PEAR_Error objects.
 */
class TestErrorHandler
{
    /**
     * A class variable for storing PEAR errors.
     *
     * @var array
     */
    public $aErrors;

    /**
     * A method to "handle" errors. It simply stores the errors
     * in the class variable, so that they can be inspected later.
     *
     * @param PEAR_Error $oError A PEAR_Error object.
     * @return void
     */
    public function handleErrors($oError)
    {
        $this->aErrors[] = $oError;
    }

    /**
     * A method to reset the class.
     *
     * @return void
     */
    public function reset()
    {
        $this->aErrors = [];
    }
}

/**
 * A class for testing the OX_Component class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Test_OX_Component extends UnitTestCase
{
    /**
     * The constructor method.
     *
     * @return Test_OX_Component
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function test_isGroupInstalled()
    {
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);
        $this->assertFalse(OX_Component::_isGroupInstalled('testPlugin'));

        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = '';
        $this->assertTrue(OX_Component::_isGroupInstalled('testPlugin'));
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);
    }

    public function test_isGroupEnabled()
    {
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);
        $this->assertFalse(OX_Component::_isGroupEnabled('testPlugin'));

        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = '';
        $this->assertFalse(OX_Component::_isGroupEnabled('', 'testPlugin'));

        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = '0';
        $this->assertFalse(OX_Component::_isGroupEnabled('testPlugin'));


        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = '1';
        $this->assertTrue(OX_Component::_isGroupEnabled('testPlugin'));

        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);
    }

    public function test_getComponentGroupsFromDirectory()
    {
        $directory = MAX_PATH . '/lib/OX/Plugin/tests/data/testExtensions/testExtension1/';
        $aGroups = OX_Component::_getComponentGroupsFromDirectory($directory);
        $this->assertEqual(count($aGroups), 2);
        $this->assertEqual($aGroups[0], 'testGroup1');
        $this->assertEqual($aGroups[1], 'testGroup2');
    }

    public function test_getComponentsFiles()
    {
        $directory = MAX_PATH . '/lib/OX/Plugin/tests/data/testExtensions/testExtension1/testGroup2/';
        $aMatches = [];
        $aFiles = OX_Component::_getComponentFilesFromDirectory($directory, true, $aMatches);
        $this->assertEqual(count($aFiles), 3);
    }

    public function test_includeComponentFile()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/Plugin/tests/data/testExtensions/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = ['testGroup1' => 1, 'testGroup2' => 1];
        $this->assertFalse(class_exists('Plugins_TestExtension1_TestGroup1_TestComponent1'));
        $this->assertTrue(OX_Component::_includeComponentFile('testExtension1', 'testGroup1', 'testComponent1'));
        $this->assertTrue(class_exists('Plugins_TestExtension1_TestGroup1_TestComponent1'));
    }

    public function test_getComponentClassName()
    {
        $this->assertEqual(OX_Component::_getComponentClassName('testExtension1', 'testGroup1', 'testComponent1'), 'Plugins_TestExtension1_TestGroup1_TestComponent1');
    }

    public function test_getComponentFilesFromDirectory()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/Plugin/tests/data/testExtensions/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = ['testGroup1' => 1, 'testGroup2' => 1];

        $extension = 'testExtension1';
        $group = 'testGroup1';
        $recursive = 0;
        $aResult = OX_Component::_getComponentsFiles($extension, $group, $recursive);
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(isset($aResult['testGroup1']));
        $this->assertEqual(count($aResult['testGroup1']), 2);
        $this->assertEqual($aResult['testGroup1'][0], 'testComponent1.class.php');
        $this->assertEqual($aResult['testGroup1'][1], 'testComponent2.class.php');

        $extension = 'testExtension1';
        $group = 'testGroup1';
        $recursive = 1;
        $aResult = OX_Component::_getComponentsFiles($extension, $group, $recursive);
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(isset($aResult['testGroup1']));
        $this->assertEqual(count($aResult['testGroup1']), 2);
        $this->assertEqual($aResult['testGroup1'][0], 'testComponent1.class.php');
        $this->assertEqual($aResult['testGroup1'][1], 'testComponent2.class.php');

        $extension = 'testExtension1';
        $group = 'testGroup2';
        $recursive = 0;
        $aResult = OX_Component::_getComponentsFiles($extension, $group, $recursive);
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(isset($aResult['testGroup2']));
        $this->assertEqual(count($aResult['testGroup2']), 2);
        $this->assertEqual($aResult['testGroup2'][0], 'testComponent1.class.php');
        $this->assertEqual($aResult['testGroup2'][1], 'testComponent2.class.php');

        $extension = 'testExtension1';
        $group = 'testGroup2';
        $recursive = 1;
        $aResult = OX_Component::_getComponentsFiles($extension, $group, $recursive);
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(isset($aResult['testGroup2']));
        $this->assertEqual(count($aResult['testGroup2']), 3);
        $this->assertEqual($aResult['testGroup2'][0], 'testComponent1.class.php');
        $this->assertEqual($aResult['testGroup2'][1], 'testComponent2.class.php');
        $this->assertEqual($aResult['testGroup2'][2], 'testComponent3.class.php');
    }

    public function test_getComponents()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/Plugin/tests/data/testExtensions/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'] = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = ['testGroup1' => 1, 'testGroup2' => 1, 'testPlugin' => 1];

        $aComponents = OX_Component::getComponents('testExtension1', 'testGroup1', true);

        $this->assertTrue(isset($aComponents['testExtension1:testGroup1:testComponent1']));
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent1']->extension, 'testExtension1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent1']->group, 'testGroup1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent1']->component, 'testComponent1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent1']->enabled, true);

        $this->assertTrue(isset($aComponents['testExtension1:testGroup1:testComponent2']));
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent2']->extension, 'testExtension1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent2']->group, 'testGroup1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent2']->component, 'testComponent2');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent2']->enabled, true);

        $aComponents = OX_Component::getComponents('admin', 'testPlugin', false);
        $this->assertTrue(isset($aComponents['admin:testPlugin:testPlugin']));
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->extension, 'admin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->group, 'testPlugin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->component, 'testPlugin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->enabled, true);

        TestEnv::restoreConfig();
    }

    public function test_getListOfRegisteredComponentsForHook()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = '/lib/OX/Plugin/tests/data/plugins/etc/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'] = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
        $GLOBALS['_MAX']['CONF']['plugins'] = ['testPluginPackage' => 1];
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = ['testPlugin' => 1];

        require_once LIB_PATH . '/Extension/ExtensionCommon.php';
        //generate test cache
        $oExtension = new OX_Extension_Common();
        $oExtension->cacheComponentHooks();

        $aHooks = OX_Component::getListOfRegisteredComponentsForHook('duringTest');

        $this->assertIsA($aHooks, 'array');
        $this->assertEqual(count($aHooks), 1);
        $this->assertEqual($aHooks[0], 'admin:testPlugin:testPlugin');

        //remove cache
        unset($GLOBALS['_MAX']['ComponentHooks']);
        $oCache = new OA_Cache('Plugins', 'ComponentHooks');
        $oCache->setFileNameProtection(false);
        $oCache->clear();

        //should auto regenerate cache
        $aHooks = OX_Component::getListOfRegisteredComponentsForHook('duringTest');
        $this->assertIsA($aHooks, 'array');
        $this->assertEqual(count($aHooks), 1);
        $this->assertEqual($aHooks[0], 'admin:testPlugin:testPlugin');

        //cache file should be regenerated
        $aAllHooks = $oCache->load();
        $this->assertEqual($aHooks, $aAllHooks['duringTest']);

        TestEnv::restoreConfig();
        $oCache->clear();
    }

    public function test_factory()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/Plugin/tests/data/testExtensions/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = ['testGroup1' => 1, 'testGroup2' => 0];

        $oComponent = OX_Component::factory('testExtension1', 'testGroup1', 'testComponent1');
        $this->assertIsA($oComponent, 'Plugins_TestExtension1_TestGroup1_TestComponent1');
        $this->assertTrue($oComponent->enabled);
        $this->assertEqual($oComponent->extension, 'testExtension1');
        $this->assertEqual($oComponent->group, 'testGroup1');
        $this->assertEqual($oComponent->component, 'testComponent1');

        $oComponent = OX_Component::factory('testExtension1', 'testGroup2', 'testComponent1');
        $this->assertIsA($oComponent, 'Plugins_TestExtension1_TestGroup2_TestComponent1');
        $this->assertFalse($oComponent->enabled);
        $this->assertEqual($oComponent->extension, 'testExtension1');
        $this->assertEqual($oComponent->group, 'testGroup2');
        $this->assertEqual($oComponent->component, 'testComponent1');
    }

    public function test_getComponentIdentifier()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/Plugin/tests/data/testExtensions/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = ['testGroup1' => 1, 'testGroup2' => 0];
        $oComponent = OX_Component::factory('testExtension1', 'testGroup1', 'testComponent1');
        $this->assertEqual(
            $oComponent->getComponentIdentifier('testExtension1', 'testGroup1', 'testComponent1'),
            'testExtension1:testGroup1:testComponent1',
        );
    }

    public function test_parseComponentIdentifier()
    {
        $aComponent = OX_Component::parseComponentIdentifier('testExtension1:testGroup1:testComponent1');
        $this->assertIsA($aComponent, 'array');
        $this->assertEqual(count($aComponent), 3);
        $this->assertEqual($aComponent['0'], 'testExtension1');
        $this->assertEqual($aComponent['1'], 'testGroup1');
        $this->assertEqual($aComponent['2'], 'testComponent1');
    }

    public function test_factoryByComponentIdentifier()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/Plugin/tests/data/testExtensions/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = ['testGroup1' => 1, 'testGroup2' => 0];

        $oComponent = OX_Component::factoryByComponentIdentifier('testExtension1:testGroup1:testComponent1');
        $this->assertIsA($oComponent, 'Plugins_TestExtension1_TestGroup1_TestComponent1');
        $this->assertTrue($oComponent->enabled);
        $this->assertEqual($oComponent->extension, 'testExtension1');
        $this->assertEqual($oComponent->group, 'testGroup1');
        $this->assertEqual($oComponent->component, 'testComponent1');

        $oComponent = OX_Component::factoryByComponentIdentifier('testExtension1:testGroup2:testComponent1');
        $this->assertIsA($oComponent, 'Plugins_TestExtension1_TestGroup2_TestComponent1');
        $this->assertFalse($oComponent->enabled);
        $this->assertEqual($oComponent->extension, 'testExtension1');
        $this->assertEqual($oComponent->group, 'testGroup2');
        $this->assertEqual($oComponent->component, 'testComponent1');
    }

    public function test_callStaticMethod()
    {
        $this->assertEqual(OX_Component::callStaticMethod('testExtension1', 'testGroup1', 'testComponent1', 'staticMethod'), 'staticMethodResult1');

        $this->assertEqual(OX_Component::callStaticMethod('testExtension1', 'testGroup1', 'testComponent1', 'staticMethodWithParams', 'foo'), 'staticMethodWithParams1=foo');
    }

    public function test_callOnComponents()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/Plugin/tests/data/testExtensions/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'] = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = ['testGroup1' => 1, 'testGroup2' => 1];

        $aComponents[] = OX_Component::factoryByComponentIdentifier('testExtension1:testGroup1:testComponent1');
        $aComponents[] = OX_Component::factoryByComponentIdentifier('testExtension1:testGroup2:testComponent1');

        $aResult = OX_Component::callOnComponents($aComponents, 'staticMethod');
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['0'], 'staticMethodResult1');
        $this->assertEqual($aResult['1'], 'staticMethodResult2');

        $aResult = OX_Component::callOnComponents($aComponents, 'staticMethodWithParams', ['foo']);
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['0'], 'staticMethodWithParams1=foo');
        $this->assertEqual($aResult['1'], 'staticMethodWithParams2=foo');
    }

    public function test_getFallbackHandler()
    {
        $this->assertFalse(class_exists('Plugins_tests'));
        $oHandler = OX_Component::getFallbackHandler('tests');
        $this->assertIsA($oHandler, 'Plugins_tests');
        $this->assertFalse($oHandler->enabled);
        $this->assertEqual($oHandler->extension, 'tests');
    }
}
