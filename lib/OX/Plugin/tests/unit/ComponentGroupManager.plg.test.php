<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once LIB_PATH.'/Plugin/ComponentGroupManager.php';

/*class testFoo
{
    function testFoo($arg1, $arg2)
    {
        $this->arg1 = $arg1;
        $this->arg2 = $arg2;
    }
}*/

/**
 * A class for testing the OX_Plugin_ComponentGroupManager class.
 *
 * @package Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 * @subpackage TestSuite
 */
class Test_OX_Plugin_ComponentGroupManager extends UnitTestCase
{
    var $testpathData           = '/lib/OX/Plugin/tests/data/';
    var $testpathPackages       = '/lib/OX/Plugin/tests/data/plugins/etc/';
    var $testpathPluginsAdmin   = '/lib/OX/Plugin/tests/data/www/admin/plugins/';


    /**
     * The constructor method.
     */
    function Test_OX_Plugin_ComponentGroupManager()
    {
        $this->UnitTestCase();
    }

    function test_init()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->assertEqual($aConf['pluginPaths']['packages'],   $oManager->pathPackages);
        $this->assertEqual($aConf['pluginPaths']['extensions'], $oManager->pathExtensions);
        $this->assertEqual($aConf['pluginPaths']['admin'],      $oManager->pathPluginsAdmin);
        $this->assertEqual($aConf['pluginPaths']['var'] . 'DataObjects/',$oManager->pathDataObjects);
    }

    function test_instantiateClass()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $this->assertFalse($oManager->_instantiateClass(''));
        $this->assertFalse($oManager->_instantiateClass('foo'));
        $this->assertTrue($oManager->_instantiateClass('stdClass'));

        $classname = 'testFoo';
        eval('class testFoo { function testFoo() { $this->hello = "world"; } }');
        $oFoo = $oManager->_instantiateClass('testFoo',array('foo','bar'));
        $this->assertIsA($oFoo, 'testFoo');
        $this->assertEqual($oFoo->hello, 'world');

        /*$classname = 'testFoo';
        eval('class testFoo { function testFoo($arg1, $arg2) { $this->arg1 = $arg1; $this->arg2 = $arg2; } }');
        $oFoo = $oManager->_instantiateClass('testFoo',array('foo','bar'));
        $this->assertIsA($oFoo, 'testFoo');
        $this->assertEqual($oFoo->arg1, 'foo');
        $this->assertEqual($oFoo->arg2, 'bar');*/
    }

    function test_buildDependencyArray()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      'getFilePathToXMLInstall',
                                      'parseXML',
                                      'getComponentGroupVersion'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $aComponentGroup['foo'] = array(
                                'name'=>'foo',
                                'install'=>array('syscheck'=>array('depends'=>array())),
                                );
        $aComponentGroup['bar'] = array(
                                'name'=>'bar',
                                'install'=>array('syscheck'=>array('depends'=>array(0=>array('name'=>'foo','version'=>'1.0.0')))),
                                );
        $aComponentGroup['bar1'] = array(
                                'name'=>'bar1',
                                'install'=>array('syscheck'=>array('depends'=>array(0=>array('name'=>'foo','version'=>'1.0.0')))),
                                );
        $oManager->setReturnValueAt(0,'parseXML', $aComponentGroup['bar']);
        $oManager->setReturnValueAt(1,'parseXML', $aComponentGroup['foo']);
        $oManager->setReturnValueAt(2,'parseXML', $aComponentGroup['bar']);
        $oManager->setReturnValueAt(3,'parseXML', $aComponentGroup['foo']);
        $oManager->setReturnValueAt(4,'parseXML', $aComponentGroup['bar']);
        $oManager->setReturnValueAt(5,'parseXML', $aComponentGroup['bar1']);
        $oManager->expectCallCount('parseXML', 6);

        $fileBar = MAX_PATH.$this->testpathData.'bar.xml';
        $fileBar1= MAX_PATH.$this->testpathData.'bar1.xml';
        $fileFoo = MAX_PATH.$this->testpathData.'foo.xml';

        // Test 1 - missing xml file
        $aConf = array('bar'=>0);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = $aConf;
        $oManager->setReturnValueAt(0,'getFilePathToXMLInstall', '');
        $oManager->aErrors = array();
        $aResult = $oManager->_buildDependencyArray();
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult),0);
        $this->assertEqual(count($oManager->aErrors),1);

        // Test 2 - missing dependency : bar depends on foo but foo is not installed
        $aConf = array('bar'=>0);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = $aConf;

        $oManager->setReturnValueAt(1,'getFilePathToXMLInstall', $fileBar);
        $oManager->aErrors = array();
        $aResult = $oManager->_buildDependencyArray();
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult),2);
        $this->assertEqual(count($oManager->aErrors),1);

        $this->assertEqual($aResult['bar']['dependsOn']['foo'],OX_PLUGIN_DEPENDENCY_NOTFOUND);
        $this->assertEqual($aResult['foo']['isDependedOnBy'][0],'bar');

        // Test 3 - missing dependency : bar depends on foo but foo is the wrong version
        $aConf = array('foo'=>1,'bar'=>0);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = $aConf;

        $oManager->setReturnValueAt(0,'getComponentGroupVersion', '0.1.1-alpha');
        $oManager->setReturnValueAt(2,'getFilePathToXMLInstall', $fileBar);
        $oManager->setReturnValueAt(3,'getFilePathToXMLInstall', $fileFoo);
        $oManager->aErrors = array();
        $aResult = $oManager->_buildDependencyArray();
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult),2);
        $this->assertEqual(count($oManager->aErrors),1);

        $this->assertEqual($aResult['bar']['dependsOn']['foo'],OX_PLUGIN_DEPENDENCY_BADVERSION);
        $this->assertEqual($aResult['foo']['isDependedOnBy'][0],'bar');

        // Test 4 - dependencies ok
        $aConf = array('foo'=>1,'bar'=>0,'bar1'=>0);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = $aConf;

        $oManager->setReturnValueAt(1,'getComponentGroupVersion', '1.0.0');
        $oManager->setReturnValueAt(2,'getComponentGroupVersion', '1.0.0');
        $oManager->setReturnValueAt(4,'getFilePathToXMLInstall', $fileBar);
        $oManager->setReturnValueAt(5,'getFilePathToXMLInstall', $fileFoo);
        $oManager->setReturnValueAt(6,'getFilePathToXMLInstall', $fileBar1);
        $oManager->aErrors = array();
        $aResult = $oManager->_buildDependencyArray();
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult),3);
        $this->assertEqual(count($oManager->aErrors),0);

        $this->assertEqual($aResult['bar']['dependsOn']['foo'],'1.0.0');
        $this->assertEqual($aResult['foo']['isDependedOnBy'][0],'bar');

        $this->assertEqual($aResult['bar1']['dependsOn']['foo'],'1.0.0');
        $this->assertEqual($aResult['foo']['isDependedOnBy'][1],'bar1');


        $oManager->expectCallCount('getComponentGroupVersion',3);
        $oManager->expectCallCount('getFilePathToXMLInstall',7);

        $oManager->tally();
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo']);
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['bar']);
    }

    function test_saveDependencyArray()
    {
        Mock::generatePartial(
                                'OA_Cache',
                                $oMockCache = 'OA_Cache'.rand(),
                                array(
                                      'save'
                                     )
                             );
        $oCache = new $oMockCache($this);
        $oCache->setReturnValueAt(0,'save', false);
        $oCache->setReturnValueAt(1,'save', true);
        $oCache->expectCallCount('save',2);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getOA_Cache'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_getOA_Cache', $oCache);
        $oManager->expectCallCount('_getOA_Cache',2);

        $aTest = array('dependsOn'=>array('foo'=>array('bar'=>array('installed'=>1,'enabled'=>0))));
        $this->assertFalse($oManager->_saveDependencyArray($aTest));
        $this->assertTrue($oManager->_saveDependencyArray($aTest));

        $oCache->tally();
        $oManager->tally();
    }

    function test_loadDependencyArray()
    {
        Mock::generatePartial(
                                'OA_Cache',
                                $oMockCache = 'OA_Cache'.rand(),
                                array(
                                      'load'
                                      )
                             );
        $oCache = new $oMockCache($this);
        $aTest['isDependedOnBy'] = array('foo'=>array('bar'=>array('installed'=>true,'enabled'=>false)));
        $aTest['dependsOn'] = array('bar'=>array('foo'=>array('installed'=>true,'enabled'=>true)));
        $oCache->setReturnValueAt(0,'load', false);
        $oCache->setReturnValueAt(1,'load', $aTest);
        $oCache->expectCallCount('load',2);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getOA_Cache'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_getOA_Cache', $oCache);
        $oManager->expectCallCount('_getOA_Cache',2);

        $this->assertFalse($oManager->_loadDependencyArray($aTest));
        $aResult = $oManager->_loadDependencyArray();
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult),2);
        $this->assertEqual(count($aResult['dependsOn']),1);
        $this->assertEqual(count($aResult['isDependedOnBy']),1);
        $this->assertTrue(isset($aResult['isDependedOnBy']['foo']['bar']));
        $this->assertTrue(isset($aResult['dependsOn']['bar']['foo']));
        $this->assertEqual($aResult['isDependedOnBy']['foo']['bar']['installed'],true);
        $this->assertEqual($aResult['dependsOn']['bar']['foo']['installed'],true);
        $this->assertEqual($aResult['isDependedOnBy']['foo']['bar']['enabled'],false);
        $this->assertEqual($aResult['dependsOn']['bar']['foo']['enabled'],true);

        $oCache->tally();
        $oManager->tally();
    }

    function test_isEnabled()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo'] = 0;
        $this->assertFalse($oManager->isEnabled('foo'));
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo'] = 1;
        $this->assertTrue($oManager->isEnabled('foo'));
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo']);
    }

    function test_getPathToComponentGroup()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $path = $oManager->getPathToComponentGroup('testplugin');
        $confpath = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $this->assertEqual($path,MAX_PATH.$confpath.'testplugin/');
    }

    function test_getFilePathToMDB2Schema()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $path = $oManager->getFilePathToMDB2Schema('testplugin', 'testschema');
        $confpath = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $this->assertEqual($path,MAX_PATH.$confpath.'testplugin/etc/testschema.xml');
    }

    function test_getFilePathToXMLInstall()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $path = $oManager->getFilePathToXMLInstall('testplugin');
        $confpath = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $this->assertEqual($path,MAX_PATH.$confpath.'testplugin/testplugin.xml');
    }

    function test_checkFiles()
    {
        $aFiles[] = array('path'=>OX_PLUGIN_ADMINPATH.'/templates/','name'=>'testPlugin.html');
        $aFiles[] = array('path'=>OX_PLUGIN_ADMINPATH.'/images/','name'=>'testPlugin2.jpg');
        $aFiles[] = array('path'=>OX_PLUGIN_ADMINPATH.'/','name'=>'testPlugin-index.php');

        $aFiles[] = array('path'=>OX_PLUGIN_PLUGINPATH,'name'=>'testPluginPackage.readme.txt');

        $aFiles[] = array('path'=>OX_PLUGIN_GROUPPATH.'/','name'=>'processPreferences.php');
        $aFiles[] = array('path'=>OX_PLUGIN_GROUPPATH.'/etc/','name'=>'tables_testplugin.xml');
        $aFiles[] = array('path'=>OX_PLUGIN_GROUPPATH.'/etc/DataObjects/','name'=>'Testplugin_table.php');

        $name = 'testPlugin';
        $oManager = new OX_Plugin_ComponentGroupManager();

        $this->assertFalse($oManager->_checkFiles($name, $aFiles));

        $oManager->aErrors            = array();
        $oManager->pathPackages       = $this->testpathPackages;
        $oManager->pathPluginsAdmin   = $this->testpathPluginsAdmin;
        $this->assertTrue($oManager->_checkFiles($name, $aFiles));

        if ($oManager->countErrors())
        {
            foreach ($oManager->aErrors as $msg)
            {
                $this->assertTrue(false, $msg);
            }
        }
    }
    
    function test_checkNavigationCheckers()
    {
        $aFiles[] = array('path'=>OX_PLUGIN_ADMINPATH.'/navigation/','name'=>'testPluginChecker.php');
                
        $aCheckers = array();
        $name = 'testPlugin';
        
        $oManager = new OX_Plugin_ComponentGroupManager();
        $oManager->aErrors            = array();
        $oManager->pathPackages       = $this->testpathPackages;
        $oManager->pathPluginsAdmin   = $this->testpathPluginsAdmin;
        
        // No checkers return true
        $this->assertTrue($oManager->_checkNavigationCheckers($name, $aCheckers, $aFiles));
        
        // File not found
        $oManager->aErrors = array();
        $aCheckers         = array();
        $aCheckers[]       = array('class' => 'Plugins_Admin_TestPlugin_TestPluginChecker2', 'include' => 'testPluginChecker2.php');
        $this->assertFalse($oManager->_checkNavigationCheckers($name, $aCheckers, $aFiles));
        
        // Class not found
        $oManager->aErrors = array();
        $aCheckers         = array();
        $aCheckers[] = array('class' => 'Plugins_Admin_TestPlugin_TestPluginChecker2', 'include' => 'testPluginChecker.php');
        $this->assertFalse($oManager->_checkNavigationCheckers($name, $aCheckers, $aFiles));
                
        // Checker found
        $oManager->aErrors = array();
        $aCheckers         = array();
        $aCheckers[] = array('class' => 'Plugins_Admin_TestPlugin_TestPluginChecker', 'include' => 'testPluginChecker.php');
        $this->assertTrue($oManager->_checkNavigationCheckers($name, $aCheckers, $aFiles));

        if ($oManager->countErrors())
        {
            foreach ($oManager->aErrors as $msg)
            {
                $this->assertTrue(false, $msg);
            }
        }
    }

    function test_getVersionController()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $oVerControl = $oManager->_getVersionController();
        $this->assertIsA($oVerControl,'OA_Version_Controller');
        $this->assertIsA($oVerControl->oDbh, 'MDB2_Driver_Common');
    }

    function test_runScript()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $oManager->pathPackages = $this->testpathPackages;
        global $testScriptResult;
        $this->assertNull($testScriptResult);
        $this->assertTrue($oManager->_runScript('testPlugin', 'testScript.php'));
        $this->assertTrue($testScriptResult);
    }

    function test_runTasks_Pass()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      'task1',
                                      'task2'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValueAt(0,'task1', true, 'foo');
        $oManager->expectCallCount('task1',1);
        $oManager->setReturnValueAt(0,'task2', true, 'bar');
        $oManager->expectCallCount('task2',1);

        $aTaskList[] = array(
                            'method' =>'task1',
                            'params' => array('foo'),
                            );
        $aTaskList[] = array(
                            'method' =>'task2',
                            'params' => array('bar'),
                            );

        $this->assertTrue($oManager->_runTasks('testPlugin', $aTaskList));
        $oManager->tally();
    }

    function test_runTasks_Fail()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      'task1',
                                      'task2'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValueAt(0,'task1', false, 'foo');
        $oManager->expectCallCount('task1',1);
        $oManager->setReturnValueAt(0,'task2', true, 'bar');
        $oManager->expectCallCount('task2',0);

        $aTaskList[] = array(
                            'method' =>'task1',
                            'params' => array('foo'),
                            );
        $aTaskList[] = array(
                            'method' =>'task2',
                            'params' => array('bar'),
                            );

        $this->assertFalse($oManager->_runTasks('testPlugin', $aTaskList));
        $oManager->tally();

    }

    function test_runTasks_FailRollback()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      'task1',
                                      'task2',
                                      'untask1',
                                      'untask2'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValueAt(0,'task1', true, 'foo');
        $oManager->expectCallCount('task1',1);
        $oManager->setReturnValueAt(0,'task2', false, 'bar');
        $oManager->expectCallCount('task2',1);

        $oManager->setReturnValueAt(0,'untask1', true, 'foo');
        $oManager->expectCallCount('untask1',1);
        $oManager->setReturnValueAt(0,'untask2', true, 'bar');
        $oManager->expectCallCount('untask2',1);


        $aTaskList[] = array(
                            'method' =>'task1',
                            'params' => array('foo'),
                            );
        $aTaskList[] = array(
                            'method' =>'task2',
                            'params' => array('bar'),
                            );
        $aUndoList[] = array(
                            'method' =>'untask2',
                            'params' => array('bar'),
                            );
        $aUndoList[] = array(
                            'method' =>'untask1',
                            'params' => array('foo'),
                            );

        $this->assertFalse($oManager->_runTasks('testPlugin', $aTaskList, $aUndoList));
        $oManager->tally();

    }

    function test_runTasks_FailRollbackFail()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      'task1',
                                      'task2',
                                      'untask1',
                                      'untask2'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValueAt(0,'task1', true, 'foo');
        $oManager->expectCallCount('task1',1);
        $oManager->setReturnValueAt(0,'task2', false, 'bar');
        $oManager->expectCallCount('task2',1);

        $oManager->setReturnValueAt(0,'untask1', true, 'foo');
        $oManager->expectCallCount('untask1',0);
        $oManager->setReturnValueAt(0,'untask2', false, 'bar');
        $oManager->expectCallCount('untask2',1);


        $aTaskList[] = array(
                            'method' =>'task1',
                            'params' => array('foo'),
                            );
        $aTaskList[] = array(
                            'method' =>'task2',
                            'params' => array('bar'),
                            );
        $aUndoList[] = array(
                            'method' =>'untask2',
                            'params' => array('bar'),
                            );
        $aUndoList[] = array(
                            'method' =>'untask1',
                            'params' => array('foo'),
                            );

        $this->assertFalse($oManager->_runTasks('testPlugin', $aTaskList, $aUndoList));
        $oManager->tally();

    }

    function test_parseXML()
    {
        Mock::generatePartial(
                                'stdClass',
                                $oMockParser = 'stdClass'.rand(),
                                array(
                                      'setInputFile',
                                      'parse'
                                     )
                             );
        $oParser = new $oMockParser($this);
        $oParser->setReturnValue('setInputFile', true);
        $oParser->expectOnce('setInputFile');
        $oParser->setReturnValue('parse', true);
        $oParser->expectOnce('parse');
        $oParser->aPlugin = array(
                                  1=>'test1',
                                  2=>'test2',
                                 );

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_instantiateClass'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_instantiateClass', $oParser);
        $oManager->expectOnce('_instantiateClass');

        // Test 1 - missing xml file
        $this->assertFalse($oManager->parseXML('test.xml', ''));

        // Test 2 - success
        $fileFoo = MAX_PATH.$this->testpathData.'foo.xml';
        $result = $oManager->parseXML($fileFoo, '');
        $this->assertIsA($result,'array');
        $this->assertEqual(count($result),2);
        $this->assertEqual($result[1],'test1');
        $this->assertEqual($result[2],'test2');

        $oManager->tally();
        $oParser->tally();
    }

    function test_getComponentGroupSettingsArray()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();

        $GLOBALS['_MAX']['CONF']['test'] = array(
                                                  'foo'=>1,
                                                  'bar'=>0,
                                                 );
        $aComponentGroups = $oManager->getComponentGroupSettingsArray('test');
        $this->assertIsA($aComponentGroups,'array');
        $this->assertEqual(count($aComponentGroups),2);
        $this->assertEqual($aComponentGroups['foo'],1);
        $this->assertEqual($aComponentGroups['bar'],0);
        unset($GLOBALS['_MAX']['CONF']['test']);
        $aComponentGroups = $oManager->getComponentGroupSettingsArray('test');
        $this->assertIsA($aComponentGroups,'array');
        $this->assertEqual(count($aComponentGroups),0);
    }

    function test_getComponentGroupVersion()
    {
        Mock::generatePartial(
                                'stdClass',
                                $mockVerCtrl = 'stdClass'.rand(),
                                array(
                                      'getApplicationVersion'
                                     )
                             );
        $oVerCtrl = new $mockVerCtrl($this);
        $oVerCtrl->setReturnValueAt(0,'getApplicationVersion', '0.1','foo');
        $oVerCtrl->expectCallCount('getApplicationVersion',1);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getVersionController'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_getVersionController', $oVerCtrl);
        $oManager->expectOnce('_getVersionController');

        $result = $oManager->getComponentGroupVersion('foo');
        $this->assertEqual($result,'0.1');

        $oManager->tally();
        $oVerCtrl->tally();
    }

/*    function test_getPluginsArray()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array('getComponentGroupVersion')
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValueAt(0,'getComponentGroupVersion', '0.1', 'foo');
        $oManager->setReturnValueAt(1,'getComponentGroupVersion', '0.2', 'bar');
        $oManager->expectCallCount('getComponentGroupVersion',2);

        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = array('foo'=>1,'bar'=>0);
        $aComponentGroups = $oManager->getPluginsArray();
        $this->assertIsA($aComponentGroups,'array');
        $this->assertEqual(count($aComponentGroups),2);
        $this->assertEqual($aComponentGroups['foo']['enabled'],1);
        $this->assertEqual($aComponentGroups['foo']['version'],'0.1');
        $this->assertEqual($aComponentGroups['bar']['enabled'],0);
        $this->assertEqual($aComponentGroups['bar']['version'],'0.2');

        $oManager->tally();
    }*/

    function test_setPlugin()
    {
        Mock::generatePartial(
                                'OA_Admin_Settings',
                                $oMockConfig = 'OA_Admin_Settings'.rand(),
                                array(
                                      'settingChange',
                                      'writeConfigChange'
                                     )
                             );
        $oConfig = new $oMockConfig($this);
        $oConfig->setReturnValue('settingChange', true);
        $oConfig->expectOnce('settingChange');
        $oConfig->setReturnValue('writeConfigChange', true);
        $oConfig->expectOnce('writeConfigChange');

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_instantiateClass'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_instantiateClass', $oConfig);
        $oManager->expectOnce('_instantiateClass');

        $oManager->_setPlugin('test');
        $oManager->tally();
    }

    function test_enableComponentGroup()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_setPlugin'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValueAt(0,'_setPlugin', true);
        $oManager->setReturnValueAt(1,'_setPlugin', false);
        $oManager->expectCallCount('_setPlugin',2);

        $this->assertTrue($oManager->enableComponentGroup('test'));
        $this->assertFalse($oManager->enableComponentGroup('test'));
        $oManager->tally();
    }

    function test_disableComponentGroup()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_setPlugin'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValueAt(0,'_setPlugin', true);
        $oManager->setReturnValueAt(1,'_setPlugin', false);
        $oManager->expectCallCount('_setPlugin',2);

        $this->assertTrue($oManager->disableComponentGroup('test'));
        $this->assertFalse($oManager->disableComponentGroup('test'));
        $oManager->tally();
    }

    function test_getSchemaInfo()
    {
        Mock::generatePartial(
                                'stdClass',
                                $mockVerCtrl = 'stdClass'.rand(),
                                array(
                                      'getSchemaVersion'
                                     )
                             );
        $oVerCtrl = new $mockVerCtrl($this);
        $oVerCtrl->setReturnValueAt(0,'getSchemaVersion', '999','foo');
        $oVerCtrl->expectCallCount('getSchemaVersion',1);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getVersionController'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_getVersionController', $oVerCtrl);
        $oManager->expectOnce('_getVersionController');

        $this->assertEqual($oManager->getSchemaInfo('foo'),'999');
        $oVerCtrl->tally();
        $oManager->tally();

    }

    function test_getComponentGroupInfo()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      'getSchemaInfo',
                                      'parseXML'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->pathPackages      = $this->testpathPackages;
        $oManager->pathPluginsAdmin = $this->testpathPluginsAdmin;

        $aComponentGroup1 = array(
                        '1'=>'foo',
                        '2'=>'bar',
                        'install'=>array('schema'=>array('mdb2schema'=>'fooschema')),
                        );
        $oManager->setReturnValueAt(0,'parseXML', $aComponentGroup1);
        $oManager->setReturnValueAt(0,'getSchemaInfo', '999','foo');

        $aResult = $oManager->getComponentGroupInfo('testPlugin');
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult),9);
        $this->assertEqual($aResult[1],'foo');
        $this->assertEqual($aResult[2],'bar');
        $this->assertEqual($aResult['schema_name'],'fooschema');
        $this->assertEqual($aResult['schema_version'],'999');

        $aComponentGroup2 = array(
                        '1'=>'foo',
                        '2'=>'bar',
                        'install'=>array('conf'=>array('settings'=>array(array('visible' => 1,1,2)),'preferences'=>array(0,1,2))),
                        );
        $oManager->setReturnValueAt(1,'parseXML', $aComponentGroup2);
        $oManager->setReturnValueAt(1,'getSchemaInfo', false);

        $aResult = $oManager->getComponentGroupInfo('testPlugin');
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult),7);
        $this->assertEqual($aResult[1],'foo');
        $this->assertEqual($aResult[2],'bar');
        $this->assertNull($aResult['schema_name']);
        $this->assertNull($aResult['schema_version']);
        $this->assertTrue($aResult['settings']);
        $this->assertTrue($aResult['preferences']);

        $oManager->expectCallCount('parseXML', 2);
        $oManager->expectCallCount('getSchemaInfo',2);

        $oManager->tally();
    }

    function test_registerPluginVersion()
    {
        Mock::generatePartial(
                                'stdClass',
                                $mockVerCtrl = 'stdClass'.rand(),
                                array(
                                      'putApplicationVersion'
                                     )
                             );
        $oVerCtrl = new $mockVerCtrl($this);
        $oVerCtrl->setReturnValueAt(0,'putApplicationVersion', '0.1', array('0.1','test'));
        $oVerCtrl->setReturnValueAt(1,'putApplicationVersion', 0.1, array('0.1','test'));
        $oVerCtrl->expectCallCount('putApplicationVersion',2);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getVersionController'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_getVersionController', $oVerCtrl);
        $oManager->expectCallCount('_getVersionController',2);

        $this->assertTrue($oManager->_registerPluginVersion('test', '0.1'));
        $this->assertFalse($oManager->_registerPluginVersion('test', '0.1'));

        $oVerCtrl->tally();
        $oManager->tally();
    }

    function test_registerSchemaVersion()
    {
        Mock::generatePartial(
                                'stdClass',
                                $mockVerCtrl = 'stdClass'.rand(),
                                array(
                                      'putSchemaVersion'
                                     )
                             );
        $oVerCtrl = new $mockVerCtrl($this);
        $oVerCtrl->setReturnValueAt(0,'putSchemaVersion', '999', array('test','999'));
        $oVerCtrl->setReturnValueAt(1,'putSchemaVersion', true, array('test','999'));
        $oVerCtrl->expectCallCount('putSchemaVersion',2);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getVersionController'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_getVersionController', $oVerCtrl);
        $oManager->expectCallCount('_getVersionController',2);

        $this->assertTrue($oManager->_registerSchemaVersion('test', '999'));
        $this->assertFalse($oManager->_registerSchemaVersion('test', '999'));

        $oVerCtrl->tally();
        $oManager->tally();
    }

    function test_unregisterSchemaVersion()
    {
        Mock::generatePartial(
                                'stdClass',
                                $mockVerCtrl = 'stdClass'.rand(),
                                array(
                                      'removeVariable'
                                     )
                             );
        $oVerCtrl = new $mockVerCtrl($this);
        $oVerCtrl->setReturnValueAt(0,'removeVariable', true, 'test');
        $oVerCtrl->setReturnValueAt(0,'removeVariable', false, 'test');
        $oVerCtrl->expectCallCount('removeVariable',2);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getVersionController'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_getVersionController', $oVerCtrl);
        $oManager->expectCallCount('_getVersionController',2);

        $this->assertTrue($oManager->_unregisterSchemaVersion('test'));
        $this->assertFalse($oManager->_unregisterSchemaVersion('test'));

        $oVerCtrl->tally();
        $oManager->tally();
    }

    function test_unregisterPluginVersion()
    {
        Mock::generatePartial(
                                'stdClass',
                                $mockVerCtrl = 'stdClass'.rand(),
                                array(
                                      'removeVersion'
                                     )
                             );
        $oVerCtrl = new $mockVerCtrl($this);
        $oVerCtrl->setReturnValueAt(0,'removeVersion', true, 'test');
        $oVerCtrl->setReturnValueAt(1,'removeVersion', false, 'test');
        $oVerCtrl->expectCallCount('removeVersion',2);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getVersionController'
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_getVersionController', $oVerCtrl);
        $oManager->expectCallCount('_getVersionController',2);

        $this->assertTrue($oManager->_unregisterPluginVersion('test'));
        $this->assertFalse($oManager->_unregisterPluginVersion('test'));

        $oVerCtrl->tally();
        $oManager->tally();
    }

    function test_registerSettings()
    {
        Mock::generatePartial(
                                'OA_Admin_Settings',
                                $oMockConfig = 'OA_Admin_Settings'.rand(),
                                array(
                                      'settingChange',
                                      'writeConfigChange'
                                     )
                             );
        $oConfig = new $oMockConfig($this);
        $oConfig->setReturnValue('settingChange', true);
        $oConfig->expectCallCount('settingChange',4);
        $oConfig->setReturnValueAt(0,'writeConfigChange', true);
        $oConfig->setReturnValueAt(1,'writeConfigChange', false);
        $oConfig->expectCallCount('writeConfigChange',2);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_instantiateClass'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_instantiateClass', $oConfig);

        $aSettings[] = array(
                             'section'=>'foo',
                             'key'=>'foo1',
                             'data'=>'bar1',
                            );
        $aSettings[] = array(
                             'section'=>'foo',
                             'key'=>'foo2',
                             'data'=>'bar2',
                            );
        $this->assertTrue($oManager->_registerSettings('testPlugin',$aSettings));
        $this->assertFalse($oManager->_registerSettings('testPlugin',$aSettings));

        $oManager->expectCallCount('_instantiateClass',2);
        $oConfig->tally();
        $oManager->tally();
    }

    function test_unregisterSettings()
    {
        Mock::generatePartial(
                                'OA_Admin_Settings',
                                $oMockConfig = 'OA_Admin_Settings'.rand(),
                                array(
                                      'writeConfigChange'
                                     )
                             );
        $oConfig = new $oMockConfig($this);
        $oConfig->setReturnValueAt(0,'writeConfigChange', true);
        $oConfig->setReturnValueAt(1,'writeConfigChange', false);
        $oConfig->expectCallCount('writeConfigChange',2);
        $oConfig->aConf['pluginGroupComponents'] = array('test'=>1);
        $oConfig->aConf['test']    = array('key'=>'val');

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_instantiateClass'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_instantiateClass', $oConfig);
        $oManager->expectCallCount('_instantiateClass',2);

        $aSettings[] = array(
                             'section'=>'foo',
                             'key'=>'foo1',
                             'data'=>'bar1',
                            );
        $aSettings[] = array(
                             'section'=>'foo',
                             'key'=>'foo2',
                             'data'=>'bar2',
                            );
        $this->assertEqual(count($oConfig->aConf['pluginGroupComponents']),1);
        $this->assertEqual(count($oConfig->aConf['test']),1);
        $this->assertTrue($oManager->_unregisterSettings('test'));
        $this->assertEqual(count($oConfig->aConf['pluginGroupComponents']),0);
        $this->assertFalse(isset($oConfig->aConf['test']));
        $this->assertFalse($oManager->_unregisterSettings('test'));
        $oConfig->tally();
        $oManager->tally();
    }

    function test_checkSystemEnvironment()
    {
        Mock::generatePartial(
                                'OA_Environment_Manager',
                                $oMockEnvMgr = 'OA_Environment_Manager'.rand(),
                                array(
                                      'getPHPInfo',
                                      '_checkCriticalPHP',
                                     )
                             );
        $oEnvMgr = new $oMockEnvMgr($this);
        $oEnvMgr->setReturnValueAt(0,'getPHPInfo', array('version'=>'4.3.12'));
        $oEnvMgr->setReturnValueAt(1,'getPHPInfo', array('version'=>'4.3.10'));
        $oEnvMgr->setReturnValueAt(0,'_checkCriticalPHP', OA_ENV_ERROR_PHP_NOERROR);
        $oEnvMgr->setReturnValueAt(1,'_checkCriticalPHP', OA_ENV_ERROR_PHP_NOERROR+10);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_instantiateClass'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_instantiateClass', $oEnvMgr);

        $aPhp[] = array(
                        'name'=>'version',
                        'value'=>'4.3.11',
                       );
        $this->assertTrue($oManager->_checkSystemEnvironment('testPlugin',$aPhp));
        $this->assertFalse($oManager->_checkSystemEnvironment('testPlugin',$aPhp));

        $oManager->expectCallCount('_instantiateClass',2);
        $oEnvMgr->expectCallCount('getPHPInfo',2);
        $oEnvMgr->expectCallCount('_checkCriticalPHP',2);

        $oEnvMgr->tally();
        $oManager->tally();
    }

    function test_checkDatabaseEnvironment()
    {
        // make sure that there is a global database connection object
        $oDbh = OA_DB::singleton();
        $phptype = $oDbh->phptype;

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                     )
                             );
        $oManager = new $oMockManager($this);

        // Test 1 - plugin has no specific database requirements
        $aDbms = array();
        $this->assertTrue($oManager->_checkDatabaseEnvironment('testPlugin', $aDbms));

        // Test 2 - plugin does not support user database
        $aDbms[0] = array(
                         'name'=>$phptype,
                         'supported'=>0,
                         );
        $this->assertFalse($oManager->_checkDatabaseEnvironment('testPlugin', $aDbms));

        // Test 3 - plugin does support user database
        $aDbms[0] = array(
                         'name'=>$phptype,
                         'supported'=>1,
                         );
        $this->assertTrue($oManager->_checkDatabaseEnvironment('testPlugin', $aDbms));
    }

    function test_checkDependenciesForInstallOrEnable()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                        'getComponentGroupVersion',
                                     )
                             );
        $oManager = new $oMockManager($this);


        $oManager->setReturnValueAt(0,'getComponentGroupVersion', '0.1');
        $oManager->setReturnValueAt(0,'getComponentGroupVersion', '2.0');


        // Test 1 - fails because testPlugin depends on foo which is not installed
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo']);
        $aDepends[0] = array('name'=>'foo','version'=>'1.0','enabled'=>0);
        $this->assertFalse($oManager->_checkDependenciesForInstallOrEnable('testPlugin',$aDepends, false));

        // Test 2 - fails because testPlugin depends although foo which is installed it is an earlier version
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo'] = 0;
        $aDepends[0] = array('name'=>'foo','version'=>'1.0','enabled'=>0);
        $oManager->setReturnValueAt(0,'getComponentGroupVersion', '0.1');
        $this->assertFalse($oManager->_checkDependenciesForInstallOrEnable('testPlugin',$aDepends, false));

        // Test 3 - success
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo'] = 0;
        $aDepends[0] = array('name'=>'foo','version'=>'1.0','enabled'=>0);
        $oManager->setReturnValueAt(1,'getComponentGroupVersion', '1.0');
        $this->assertTrue($oManager->_checkDependenciesForInstallOrEnable('test',$aDepends, false));

        $oManager->expectCallCount('getComponentGroupVersion',2);
        $oManager->tally();
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo']);
    }


    function test_hasDependencies()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_loadDependencyArray'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $aDepends['foo']['isDependedOnBy'][0] = 'bar';
        $oManager->setReturnValue('_loadDependencyArray', $aDepends);

        // user wants to disable or uninstall plugin foo
        // foo needs to find out if other plugins rely on it being installed

        // Test 1 - no plugins are dependent on bar
        $this->assertFalse($oManager->_hasDependencies('bar'));

        // Test 2 - bar relies on foo being installed; bar is not installed
        $this->assertFalse($oManager->_hasDependencies('foo'));

        // Test 3 - bar relies on foo being installed; bar is actually installed
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['bar'] = 1;
        $this->assertTrue($oManager->_hasDependencies('foo', false));

        $oManager->expectCallCount('_loadDependencyArray',3);
        $oManager->tally();

        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['bar']);
    }

    /**
     * see integration test
     */
    /*function test_checkMenus()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $this->assertTrue($oManager->_checkMenus('test'));
    }*/

    function test_registerSchema()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_createTables',
                                      '_dropTables',
                                       '_registerSchemaVersion',
                                       '_putDataObjects',
                                      '_cacheDataObjects',
                                      '_verifyDataObjects'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_dropTables', true);

        // Test 1 - no tables to create
        $this->assertTrue($oManager->_registerSchema('test',array('mdb2schema'=>false)));

        // Test 2 - failure to create tables
        $oManager->setReturnValueAt(0,'_createTables', false);
        $this->assertFalse($oManager->_registerSchema('test',array('mdb2schema'=>true)));

        // Test 3 - success creating tables, schema registration fails
        $oManager->setReturnValueAt(1,'_createTables', true);
        $oManager->setReturnValueAt(0,'_registerSchemaVersion', false);
        $this->assertFalse($oManager->_registerSchema('test',array('mdb2schema'=>true)));

        // Test 4 - success creating tables, failed to copy dataobjects
        $oManager->setReturnValueAt(2,'_createTables', true);
        $oManager->setReturnValueAt(1,'_registerSchemaVersion', true);
        $oManager->setReturnValueAt(0,'_putDataObjects', false);
        $this->assertFalse($oManager->_registerSchema('test',array('mdb2schema'=>true)));

        // Test 5 - success copying dataobjects, failed to cache dataobjects
        $oManager->setReturnValueAt(3,'_createTables', true);
        $oManager->setReturnValueAt(2,'_registerSchemaVersion', true);
        $oManager->setReturnValueAt(1,'_putDataObjects', true);
        $oManager->setReturnValueAt(0,'_cacheDataObjects', false);
        $this->assertFalse($oManager->_registerSchema('test',array('mdb2schema'=>true)));

        // Test 6 - success caching dataobjects, failed to verify dataobjects
        $oManager->setReturnValueAt(4,'_createTables', true);
        $oManager->setReturnValueAt(3,'_registerSchemaVersion', true);
        $oManager->setReturnValueAt(2,'_putDataObjects', true);
        $oManager->setReturnValueAt(1,'_cacheDataObjects', true);
        $oManager->setReturnValueAt(0,'_verifyDataObjects', false);
        $this->assertFalse($oManager->_registerSchema('test',array('mdb2schema'=>true)));

        // Test 5 - success
        $oManager->setReturnValueAt(5,'_createTables', true);
        $oManager->setReturnValueAt(4,'_registerSchemaVersion', true);
        $oManager->setReturnValueAt(3,'_putDataObjects', true);
        $oManager->setReturnValueAt(2,'_cacheDataObjects', true);
        $oManager->setReturnValueAt(1,'_verifyDataObjects', true);
        $this->assertTrue($oManager->_registerSchema('test',array('mdb2schema'=>true)));

        $oManager->expectCallCount('_createTables',6);
        $oManager->expectCallCount('_dropTables',5);
        $oManager->expectCallCount('_registerSchemaVersion',5);
        $oManager->expectCallCount('_putDataObjects',4);
        $oManager->expectCallCount('_cacheDataObjects',3);
        $oManager->expectCallCount('_verifyDataObjects',2);

        $oManager->tally();
    }

    function test_unregisterSchema()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_dropTables',
                                      '_unregisterSchemaVersion',
                                     )
                             );
        $oManager = new $oMockManager($this);

        $this->assertTrue($oManager->_unregisterSchema('test',array('mdb2schema'=>false)));

        $oManager->setReturnValueAt(0,'_dropTables', false);
        $this->assertFalse($oManager->_unregisterSchema('test',array('mdb2schema'=>true)));

        $oManager->setReturnValueAt(1,'_dropTables', true);
        $oManager->setReturnValueAt(0,'_unregisterSchemaVersion', false);
        $this->assertFalse($oManager->_unregisterSchema('test',array('mdb2schema'=>true)));

        $oManager->setReturnValueAt(2,'_dropTables', true);
        $oManager->setReturnValueAt(1,'_unregisterSchemaVersion', true);
        $this->assertTrue($oManager->_unregisterSchema('test',array('mdb2schema'=>true)));

        $oManager->expectCallCount('_dropTables',3);
        $oManager->expectCallCount('_unregisterSchemaVersion',2);
        $oManager->tally();
    }

    function test_createTables()
    {
        Mock::generatePartial(
                                'OA_DB_Table',
                                $oMockTable = 'OA_DB_Table'.rand(),
                                array(
                                      'init',
                                      'createTable',
                                      'dropAllTables',
                                     )
                             );
        $oTable = new $oMockTable($this);
        $oTable->aDefinition = array(
                                     'name'    => 'testPlugin',
                                     'version' => 001,
                                     'tables'  => array('testplugin_table' => array()),
                                     );
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                        '_instantiateClass',
                                        '_dropTables',
                                        '_auditInit',
                                        '_auditSetKeys',
                                        '_auditStart',
                                     )
                             );
;
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_instantiateClass', $oTable);
/*        $oManager->setReturnValue('_auditSetKeys', true);
        $oManager->setReturnValue('_auditStart', true);*/
        $oManager->setReturnValue('_dropTables', true);

        // Test 1 - initialise schema fails
        $oTable->setReturnValueAt(0,'init', false);
        $this->assertFalse($oManager->_createTables('test',$aSchema));

        // Test 2 - table creation fails
        $oTable->setReturnValueAt(1,'init', true);
        $oTable->setReturnValueAt(0,'createTable', false);
        $oManager->setReturnValueAt(0,'_dropTables', true);
        $this->assertFalse($oManager->_createTables('test',$aSchema));

        // Test 3 - success
        $oTable->setReturnValueAt(2,'init', true);
        $oTable->setReturnValueAt(1,'createTable', true);
        $this->assertTrue($oManager->_createTables('test',$aSchema));

        $oTable->expectCallCount('init',3);
        $oTable->expectCallCount('createTable',2);

        $oManager->expectCallCount('_instantiateClass',3);
        $oManager->expectCallCount('_dropTables',1);
        //$oManager->expectCallCount('_auditDatabaseAction',4);

        $oTable->tally();
        $oManager->tally();
    }

    function test_dropTables()
    {
        Mock::generatePartial(
                                'OA_DB_Table',
                                $oMockTable = 'OA_DB_Table'.rand(),
                                array(
                                      'init',
                                      'dropTable',
                                     )
                             );
        $oTable = new $oMockTable($this);
        $oTable->aDefinition = array(
                                     'name'    => 'testPlugin',
                                     'version' => 001,
                                     'tables'  => array('testplugin_table' => array())
                                     );
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                        '_instantiateClass',
                                        '_auditInit',
                                        '_auditSetKeys',
                                        '_auditStart',
                                        '_tableExists',
                                     )
                             );
;
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_instantiateClass', $oTable);
        //$oManager->setReturnValue('_auditDatabaseAction', true);

        // Test 1 - initialise schema fails
        $oTable->setReturnValueAt(0,'init', false);

        $this->assertFalse($oManager->_dropTables('test',$aSchema));

        // Test 2 - table drop fails and table still exists
        $oTable->setReturnValueAt(1,'init', true);
        $oTable->setReturnValueAt(0,'dropTable', false);
        $oManager->setReturnValueAt(0,'_tableExists', true);

        $this->assertFalse($oManager->_dropTables('test',$aSchema));

        // Test 3 - table drop fails because table did not exist, so thats ok :)
        $oTable->setReturnValueAt(2,'init', true);
        $oTable->setReturnValueAt(1,'dropTable', false);
        $oManager->setReturnValueAt(1,'_tableExists', false);

        $this->assertTrue($oManager->_dropTables('test',$aSchema));

        // Test 3 - success
        $oTable->setReturnValueAt(3,'init', true);
        $oTable->setReturnValueAt(2,'dropTable', true);

        $this->assertTrue($oManager->_dropTables('test',$aSchema));

        $oTable->expectCallCount('init',4);
        $oTable->expectCallCount('dropTable',3);
        $oManager->expectCallCount('_tableExists',2);
        //$oManager->expectCallCount('_auditDatabaseAction',6);
        $oManager->expectCallCount('_instantiateClass',4);

        $oTable->tally();
        $oManager->tally();
    }

    function test_auditInit()
    {
        Mock::generatePartial(
                                'OA_UpgradeAuditor',
                                $oMockAuditor = 'OA_UpgradeAuditor'.rand(),
                                array(
                                        'init',
                                     )
                             );
        $oAuditor = new $oMockAuditor($this);
        $oAuditor->setReturnValue('init', true);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                        '_instantiateClass',
                                     )
                             );
;
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_instantiateClass', $oAuditor);
        $oManager->expectCallCount('_instantiateClass',1);

        $oManager->_auditInit();
        $this->assertIsA($oManager->oAuditor, get_class($oAuditor));

        $oManager->_auditInit();

        $oAuditor->expectCallCount('init',1);

        $oAuditor->tally();
        $oManager->tally();
    }

    function test_checkDatabase()
    {
        /**
         * NOT YET IMPLEMENTED
         *
         * method is a demo utility only
         */
    }

    function test_canUpgradeComponentGroup()
    {
        Mock::generatePartial(
                                'OX_Plugin_UpgradeComponentGroup',
                                $oMockUpgrade = 'OX_Plugin_UpgradeComponentGroup'.rand(),
                                array(
                                      'canUpgrade'
                                     )
                             );
        $oUpgrade = new $oMockUpgrade($this);
        $oUpgrade->expectCallCount('canUpgrade', 5);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getOX_Plugin_UpgradeComponentGroup',
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_getOX_Plugin_UpgradeComponentGroup', $oUpgrade);

        $aComponentGroup = array('name'=>'foo',
                         'version'=>'1.0.0',
                        );

        // Test 1 - can upgrade
        $oUpgrade->existing_installation_status = OA_STATUS_PLUGIN_CAN_UPGRADE;
        $this->assertTrue($oManager->_canUpgradeComponentGroup($aComponentGroup));
        $this->assertEqual($aComponentGroup['status'], OA_STATUS_PLUGIN_CAN_UPGRADE);

        // Test 2 - current version, returns true as it is not technically a potential failure to upgrade
        $oUpgrade->existing_installation_status = OA_STATUS_PLUGIN_CURRENT_VERSION;
        $this->assertTrue($oManager->_canUpgradeComponentGroup($aComponentGroup));
        $this->assertEqual($aComponentGroup['status'], OA_STATUS_PLUGIN_CURRENT_VERSION);

        // Test 3 - not installed, returns true as it is not technically a potential failure to upgrade
        $oUpgrade->existing_installation_status = OA_STATUS_PLUGIN_NOT_INSTALLED;
        $this->assertTrue($oManager->_canUpgradeComponentGroup($aComponentGroup));
        $this->assertEqual($aComponentGroup['status'], OA_STATUS_PLUGIN_NOT_INSTALLED);

        // Test 4 - bad version (version lower than current or current version not obtained)
        $oUpgrade->existing_installation_status = OA_STATUS_PLUGIN_VERSION_FAILED;
        $this->assertFalse($oManager->_canUpgradeComponentGroup($aComponentGroup));
        $this->assertEqual($aComponentGroup['status'], OA_STATUS_PLUGIN_VERSION_FAILED);

        // Test 5 - database integrity check failed
        $oUpgrade->existing_installation_status = OA_STATUS_PLUGIN_DBINTEG_FAILED;
        $this->assertFalse($oManager->_canUpgradeComponentGroup($aComponentGroup));
        $this->assertEqual($aComponentGroup['status'], OA_STATUS_PLUGIN_DBINTEG_FAILED);
    }

    function test_upgradeComponentGroup()
    {
        Mock::generatePartial(
                                'OX_Plugin_UpgradeComponentGroup',
                                $oMockUpgrade = 'OX_Plugin_UpgradeComponentGroup'.rand(),
                                array(
                                      'canUpgrade',
                                      'upgrade',
                                     )
                             );
        $oUpgrade = new $oMockUpgrade($this);
        $oUpgrade->setReturnValue('canUpgrade', true);
        $oUpgrade->setReturnValueAt(0,'upgrade', false);
        $oUpgrade->setReturnValueAt(1,'upgrade', true);
        $oUpgrade->expectCallCount('upgrade', 2);

        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      '_getOX_Plugin_UpgradeComponentGroup',
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_getOX_Plugin_UpgradeComponentGroup', $oUpgrade);

        $aComponentGroup = array('name'=>'foo',
                         'version'=>'1.0.0',
                        );

        $this->assertEqual($oManager->upgradeComponentGroup($aComponentGroup), UPGRADE_ACTION_UPGRADE_FAILED);

        $this->assertEqual($oManager->upgradeComponentGroup($aComponentGroup), UPGRADE_ACTION_UPGRADE_SUCCEEDED);

    }

}

?>
