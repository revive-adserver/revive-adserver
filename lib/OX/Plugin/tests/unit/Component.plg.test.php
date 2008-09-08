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
 * A class for testing the OX_Component class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class Test_OX_Component extends UnitTestCase {

    /**
     * The constructor method.
     *
     * @return Test_OX_Component
     */
    function Test_OX_Component()
    {
        $this->UnitTestCase();
    }

    function test_isGroupInstalled()
    {
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);
        $this->assertFalse(OX_Component::_isGroupInstalled('testPlugin'));

        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = '';
        $this->assertTrue(OX_Component::_isGroupInstalled('testPlugin'));
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);
    }

    function test_isGroupEnabled()
    {
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);
        $this->assertFalse(OX_Component::_isGroupEnabled('testPlugin'));

        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = '';
        $this->assertFalse(OX_Component::_isGroupEnabled('','testPlugin'));

        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = '0';
        $this->assertFalse(OX_Component::_isGroupEnabled('testPlugin'));


        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = '1';
        $this->assertTrue(OX_Component::_isGroupEnabled('testPlugin'));

        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);

    }

    function test_getComponentGroupsFromDirectory()
    {
        $directory = MAX_PATH.'/lib/OX/Plugin/tests/data/testExtensions/testExtension1/';
        $aGroups = OX_Component::_getComponentGroupsFromDirectory($directory);
        $this->assertEqual(count($aGroups),2);
        $this->assertEqual($aGroups[0],'testGroup1');
        $this->assertEqual($aGroups[1],'testGroup2');
    }

    function test_getComponentsFiles()
    {
        $directory = MAX_PATH.'/lib/OX/Plugin/tests/data/testExtensions/testExtension1/testGroup2/';
        $aMatches = array();
        $aFiles = OX_Component::_getComponentFilesFromDirectory($directory, true, $aMatches);
        $this->assertEqual(count($aFiles),3);
    }

    function test_getComponents()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] = '/lib/OX/Plugin/tests/data/testExtensions/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'] = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = array('testGroup1'=>1,'testGroup2'=>1,'testPlugin'=>1);

        $aComponents = OX_Component::getComponents('testExtension1','testGroup1',true);

        $this->assertTrue(isset($aComponents['testExtension1:testGroup1:testComponent1']));
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent1']->extension,'testExtension1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent1']->group, 'testGroup1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent1']->component, 'testComponent1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent1']->enabled, true);

        $this->assertTrue(isset($aComponents['testExtension1:testGroup1:testComponent2']));
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent2']->extension,'testExtension1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent2']->group, 'testGroup1');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent2']->component, 'testComponent2');
        $this->assertEqual($aComponents['testExtension1:testGroup1:testComponent2']->enabled, true);

        $aComponents = OX_Component::getComponents('admin','testPlugin',false);
        $this->assertTrue(isset($aComponents['admin:testPlugin:testPlugin']));
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->extension,'admin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->group, 'testPlugin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->component, 'testPlugin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->enabled, true);

        TestEnv::restoreConfig();

    }

    function test_getListOfRegisteredComponentsForHook()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = '/lib/OX/Plugin/tests/data/plugins/etc/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'] = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
        $GLOBALS['_MAX']['CONF']['plugins'] = array('testPluginPackage'=>1);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = array('testPlugin'=>1);

        require_once LIB_PATH.'/Extension/ExtensionCommon.php';
        //generate test cache
        $oExtension = new OX_Extension_Common();
        $oExtension->cacheComponentHooks();

        $aHooks = OX_Component::getListOfRegisteredComponentsForHook('duringTest');

        $this->assertIsA($aHooks, 'array');
        $this->assertEqual(count($aHooks),1);
        $this->assertEqual($aHooks[0],'admin:testPlugin:testPlugin');

        //re-cache the hooks
        $oExtension = new OX_Extension_Common();
        $oExtension->cacheComponentHooks();

        TestEnv::restoreConfig();

    }

    function Xtest_includeComponentFile()
    {
    }

    function Xtest_getComponentClassName()
    {
    }

    function Xtest_getComponentFilesFromDirectory()
    {
    }

    function Xtest_callStaticMethod()
    {
    }

    function Xtest_callOnComponents()
    {
    }

    function Xtest_callOnComponentsByHook()
    {
    }

    function Xtest_getComponentIdentifier()
    {
    }

    function Xtest_parseComponentIdentifier()
    {
    }

    function Xtest_getFallbackHandler()
    {
    }

    function Xtest_factory()
    {
    }

    function Xtest_factoryByComponentIdentifier()
    {
    }

}

?>
