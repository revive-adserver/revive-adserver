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

// Required files
require_once(LIB_PATH.'/Extension.php');

class Test_OX_Extension extends UnitTestCase
{

    function Test_OX_Extension()
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
     * a list of all known extensions
     *
     * @return unknown
     */
    function test_getAllExtensionsArray()
    {
        $oExtension = new OX_Extension();
        $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] = '/lib/OX/tests/data/plugins/';
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
        $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] = '/lib/OX/tests/data/plugins/';
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