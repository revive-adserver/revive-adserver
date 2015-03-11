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

// Required files
require_once(LIB_PATH.'/Extension.php');

class Test_OX_Extension extends UnitTestCase
{

    function __construct()
    {

    }

    function test_runTasksForEvent()
    {
        $oExtension = new OX_Extension();

        // Test 1 : non-existant extension
        $oExtension->aExtensions = array('foo');
        $this->assertTrue($oExtension->runTasksForEvent('TestEvent'));

        // Test 2 : non-existant extension task file
        $oExtension->aExtensions = array('foo');
        $GLOBALS['_MAX']['CONF']['pluginPaths']['foo'] = '/lib/OX/tests/data/plugins/test/';
        $this->assertTrue($oExtension->runTasksForEvent('TestEvent'));

        // Test 3 : non-existant extension task class
        $oExtension->aExtensions = array('test1');
        $GLOBALS['_MAX']['CONF']['pluginPaths']['test'] = '/lib/OX/tests/data/plugins/test1/';
        $this->assertTrue($oExtension->runTasksForEvent('TestEvent'));

        // Test 4 : non-existant extension task method
        $oExtension->aExtensions = array('test');
        $GLOBALS['_MAX']['CONF']['pluginPaths']['test'] = '/lib/OX/tests/data/plugins/test/';
        $this->assertTrue($oExtension->runTasksForEvent('TestEventOther'));

        // Test 4 : handler exists
        $oExtension->aExtensions = array('test');
        $GLOBALS['_MAX']['CONF']['pluginPaths']['test'] = '/lib/OX/tests/data/plugins/test/';
        $this->assertEqual($oExtension->runTasksForEvent('TestEvent'),'Test Task OK');

        TestEnv::restoreConfig();
    }

    /**
     * a list of all known plugins
     *
     * @return unknown
     */
    function test_getAllExtensionsArray()
    {
        $oExtension = new OX_Extension();
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/tests/data/plugins/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = '/lib/OX/tests/data/plugins/etc/';

        $aResult = $oExtension->getAllExtensionsArray();

        $this->assertEqual(count($aResult),3);
        sort($aResult);
        $this->assertEqual($aResult[0],'admin');
        $this->assertEqual($aResult[1],'test');
        $this->assertEqual($aResult[2],'test1');

        TestEnv::restoreConfig();
    }

    function test_setAllExtensions()
    {
        $oExtension = new OX_Extension();
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = '/lib/OX/tests/data/plugins/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = '/lib/OX/tests/data/plugins/etc/';

        $oExtension->setAllExtensions();

        $aResult = $oExtension->aExtensions;

        $this->assertEqual(count($aResult),3);
        sort($aResult);
        $this->assertEqual($aResult[0],'admin');
        $this->assertEqual($aResult[1],'test');
        $this->assertEqual($aResult[2],'test1');

        TestEnv::restoreConfig();
    }
}

?>