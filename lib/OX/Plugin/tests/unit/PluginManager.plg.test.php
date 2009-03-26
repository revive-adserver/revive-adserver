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

// Required files
require_once LIB_PATH.'/Plugin/PluginManager.php';
require_once(LIB_PATH.'/Extension.php');

class Test_OX_PluginManager extends UnitTestCase
{
    var $testpathData           = '/lib/OX/Plugin/tests/data/';
    var $testpathPackages       = '/lib/OX/Plugin/tests/data/plugins/etc/';
    var $testpathPluginsAdmin   = '/lib/OX/Plugin/tests/data/www/admin/plugins/';

    function Test_OX_PluginManager()
    {
        $this->UnitTestCase();
    }

    function test_matchPackageFilename()
    {
        $oManager = new OX_PluginManager();
        $name = 'testPlugin';

        $file   = 'testXPlugin.zip';
        $this->assertFalse($oManager->_matchPackageFilename($name, $file));

        $file   = 'testPlugin.zip';
        $aResult = $oManager->_matchPackageFilename($name, $file);
        $this->assertEqual($aResult['name'], 'testPlugin');
        $this->assertEqual($aResult['ext'], 'zip');
        $this->assertEqual($aResult['version'], '');

        $file   = 'testPlugin_0.0.1-beta-rc2.zip';
        $aResult = $oManager->_matchPackageFilename($name, $file);
        $this->assertEqual($aResult['name'], 'testPlugin');
        $this->assertEqual($aResult['ext'], 'zip');
        $this->assertEqual($aResult['version'], '0.0.1-beta-rc2');
    }

    function test_getPathToPackages()
    {
        $oManager = new OX_PluginManager();
        $path = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $this->assertEqual($oManager->getPathToPackages(), MAX_PATH.$path);
    }

    function test_Enabled()
    {
        $oManager = new OX_PluginManager();
        $GLOBALS['_MAX']['CONF']['plugins']['foo'] = 0;
        $this->assertFalse($oManager->isEnabled('foo'));
        $GLOBALS['_MAX']['CONF']['plugins']['foo'] = 1;
        $this->assertTrue($oManager->isEnabled('foo'));
        unset($GLOBALS['_MAX']['CONF']['plugins']['foo']);
    }

    function test_unpackPlugin()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      '_unpack',
                                     )
                             );
        $oManager = new $oMockManager($this);

        // Test 1 - package file not found
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testNonExistantPackage.xml',
                       'name'=>'testParsePluginFull.xml'
                      );
        $this->assertFalse($oManager->unpackPlugin($aFile));

        // Test 2 - package unpack error
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testParsePluginFull.xml',
                       'name'=>'testParsePluginFull.xml'
                      );
        $oManager->setReturnValueAt(0,'_unpack', false);
        $this->assertFalse($oManager->unpackPlugin($aFile));

        // Test 3 - package unpacked ok
        $oManager->setReturnValueAt(1,'_unpack', true);
        $this->assertTrue($oManager->unpackPlugin($aFile));

        $oManager->expectCallCount('_unpack', 2);
    }

    /**
     * @todo write test for test_installPackageCodeOnly
     *
     */
    function test_installPackageCodeOnly()
    {

    }

    function test_unpack()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      '_checkPackageContents',
                                      '_decompressFile',
                                     )
                             );
        $oManager = new $oMockManager($this);

        // Test 1 - failed security check
        $oManager->setReturnValueAt(0,'_checkPackageContents', false);
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testBadZipFile.zip',
                       'name'=>'testBadZipFile.zip'
                      );
        $this->assertFalse($oManager->_unpack($aFile));

        // Test 2 - failed to decompress zip file
        $oManager->setReturnValueAt(1,'_checkPackageContents', true);
        $oManager->setReturnValueAt(0,'_decompressFile', false);
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testBadZipFile.zip',
                       'name'=>'testBadZipFile.zip'
                      );
        $this->assertFalse($oManager->_unpack($aFile));

        // Test 3 - decompressed zip file success
        $oManager->setReturnValueAt(2,'_checkPackageContents', true);
        $oManager->setReturnValueAt(1,'_decompressFile', true);
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testGoodZipFile.zip',
                       'name'=>'testGoodZipFile.zip'
                      );
        $this->assertEqual($oManager->_unpack($aFile),'testGoodZipFile');

        // Test 4 - no extension
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testUnkownFormat',
                       'name'=>'testUnkownFormat'
                      );
        $this->assertFalse($oManager->_unpack($aFile));

        // Test 5 - unknown file format
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testUnkownFormat.abc',
                       'name'=>'testUnkownFormat.abc'
                      );
        $this->assertFalse($oManager->_unpack($aFile));

        // Test 6 - xml file format
        /*$aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testXMLFile.xml',
                       'name'=>'testXMLFile.xml'
                      );
        $this->assertEqual($oManager->_unpack($aFile),'testXMLFile');*/


        $oManager->expectCallCount('_checkPackageContents', 3);
        $oManager->expectCallCount('_decompressFile', 2);
        $oManager->tally();

    }

    function test_installPackage()
    {
        Mock::generatePartial(
                                'OX_Extension',
                                $oMockExtension = 'OX_Extension'.rand(),
                                array(
                                      '_instantiateClass',
                                      'runTasksPluginPostInstallation',
                                      'runTasksPluginPreInstallation',
                                     )
                             );
        $oExtension = new $oMockExtension($this);

        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      '_instantiateClass',
                                      'unpackPlugin',
                                      '_installComponentGroups',
                                      '_registerPackage',
                                      '_uninstallComponentGroups',
                                      '_auditInit',
                                      '_auditSetKeys',
                                      '_auditStart',
                                      '_auditUpdate',
                                      '_auditSetID',
                                      'enablePackage',
                                     )
                             );
        $oManager = new $oMockManager($this);

        $oManager->setReturnValue('_auditStart', true);
        $oManager->setReturnValue('_uninstallComponentGroups', true);

        $oManager->setReturnValue('_instantiateClass', $oExtension);
        $oManager->expectCallCount('_instantiateClass',1);

        $oManager->setReturnValue('enablePackage', true);
        $oManager->expectCallCount('enablePackage', 2);

        // Test 1 - package unpack error
        $oManager->setReturnValueAt(0,'unpackPlugin', false);

        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testParsePluginFull.xml',
                       'name'=>'testParsePluginFull.xml'
                      );
        $this->assertFalse($oManager->installPackage($aFile));

        // Test 2 - plugin installation error
        $oManager->setReturnValueAt(1,'unpackPlugin', true);
        $oManager->setReturnValueAt(0,'_installComponentGroups', false);

        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testParsePluginFull.xml',
                       'name'=>'testParsePluginFull.xml'
                       );
        $this->assertFalse($oManager->installPackage($aFile));

        // Test 3 - register settings error
        $oManager->setReturnValueAt(2,'unpackPlugin', true);
        $oManager->setReturnValueAt(1,'_installComponentGroups', true);
        $oManager->setReturnValueAt(0,'_registerPackage', false);

        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testParsePluginFull.xml',
                       'name'=>'testParsePluginFull.xml'
                       );
        $this->assertFalse($oManager->installPackage($aFile));

        // Test 4 - success
        $oManager->setReturnValueAt(3,'unpackPlugin', true);
        $oManager->setReturnValueAt(2,'_installComponentGroups', true);
        $oManager->setReturnValueAt(1,'_registerPackage', true);

        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testParsePluginFull.xml',
                       'name'=>'testParsePluginFull.xml'
                       );
        // Disable auto-enable for this one (brings enablePackage call count down to 2
        $GLOBALS['_MAX']['CONF']['pluginSettings']['enableOnInstall'] = false;
        $this->assertTrue($oManager->installPackage($aFile));

        $oManager->expectCallCount('unpackPlugin', 4);
        $oManager->expectCallCount('_installComponentGroups',3);
        $oManager->expectCallCount('_registerPackage',2);

        $oManager->tally();
        TestEnv::restoreConfig();
    }

    function test_uninstallPackage()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                        '_parsePackage',
                                        '_parseComponentGroups',
                                        '_hasDependencies',
                                        '_uninstallComponentGroups',
                                        'disablePackage',
                                        '_unregisterPackage',
                                        '_removeFiles',
                                        '_auditInit',
                                        '_auditSetKeys',
                                        '_auditStart',
                                        '_auditUpdate',
                                        '_auditSetID',
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_auditStart', true);
        $oManager->aParse['package'] = array('name'=>'foo');
        $oManager->aParse['plugins'][0] = array('name'=>'bar');

        // Test 1 - package file parse error
        $oManager->setReturnValueAt(0,'_parsePackage', false);

        $this->assertFalse($oManager->uninstallPackage('test'));

        // Test 2 - plugin file parse error
        $oManager->setReturnValueAt(1,'_parsePackage', true);
        $oManager->setReturnValueAt(0,'_parseComponentGroups', false);

        $this->assertFalse($oManager->uninstallPackage('test'));

        // Test 3 - plugin dependency error
        $oManager->setReturnValueAt(2,'_parsePackage', true);
        $oManager->setReturnValueAt(1,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(0,'_hasDependencies', true);

        $this->assertFalse($oManager->uninstallPackage('test'));

        // Test 4 - plugin uninstallation error
        $oManager->setReturnValueAt(3,'_parsePackage', true);
        $oManager->setReturnValueAt(2,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(1,'_hasDependencies', false);
        $oManager->setReturnValueAt(0,'_uninstallComponentGroups', false);

        $this->assertFalse($oManager->uninstallPackage('test'));

        // Test 5 - package/plugin settings remove error
        $oManager->setReturnValueAt(4,'_parsePackage', true);
        $oManager->setReturnValueAt(3,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(2,'_hasDependencies', false);
        $oManager->setReturnValueAt(1,'_uninstallComponentGroups', true);
        $oManager->setReturnValueAt(0,'_unregisterPackage', false);

        $this->assertFalse($oManager->uninstallPackage('test'));

        // Test 6 - success
        $oManager->setReturnValueAt(5,'_parsePackage', true);
        $oManager->setReturnValueAt(4,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(3,'_hasDependencies', false);
        $oManager->setReturnValueAt(2,'_uninstallComponentGroups', true);
        $oManager->setReturnValueAt(1,'_unregisterPackage', true);
        $oManager->setReturnValueAt(0,'_removeFiles', true);

        $this->assertTrue($oManager->uninstallPackage('test'));

        $oManager->expectCallCount('_parsePackage',6);
        $oManager->expectCallCount('_parseComponentGroups',5);
        $oManager->expectCallCount('_hasDependencies',4);
        $oManager->expectCallCount('_uninstallComponentGroups',3);
        $oManager->expectCallCount('disablePackage',3);
        $oManager->expectCallCount('_unregisterPackage',2);
        $oManager->expectCallCount('_removeFiles',1);

        $oManager->tally();
    }

    function test_enablePackage()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      '_parsePackage',
                                      '_parseComponentGroups',
                                      '_runExtensionTasks',
                                      'enableComponentGroup',
                                      '_setPackage',
                                      'disablePackage'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_parseComponentGroups', true);
        $oManager->aParse['package']['name']     = 'test';
        $oManager->aParse['package']['install']['contents'] = array(0=>'test1',1=>'test2');

        // Test 1 - plugin file parse error
        $oManager->setReturnValueAt(0,'_parsePackage', false);
        $this->assertFalse($oManager->enablePackage('test', true));

        // Test 2 - first plugin installation error
        $oManager->setReturnValueAt(1,'_parsePackage', true);
        $oManager->setReturnValueAt(0,'enableComponentGroup', false);
        $this->assertFalse($oManager->enablePackage('test', true));

        // Test 3 - second plugin installation error
        $oManager->setReturnValueAt(2,'_parsePackage', true);
        $oManager->setReturnValueAt(1,'enableComponentGroup', true);
        $oManager->setReturnValueAt(2,'enableComponentGroup', false);
        $this->assertFalse($oManager->enablePackage('test', true));

        // Test 4 - write settings error
        $oManager->setReturnValueAt(3,'_parsePackage', true);
        $oManager->setReturnValueAt(3,'enableComponentGroup', true);
        $oManager->setReturnValueAt(4,'enableComponentGroup', true);
        $oManager->setReturnValueAt(0,'_setPackage', false);
        $this->assertFalse($oManager->enablePackage('test', true));

        // Test 5 - success
        $oManager->setReturnValueAt(4,'_parsePackage', true);
        $oManager->setReturnValueAt(5,'enableComponentGroup', true);
        $oManager->setReturnValueAt(6,'enableComponentGroup', true);
        $oManager->setReturnValueAt(1,'_setPackage', true);
        $this->assertTrue($oManager->enablePackage('test', true));

        $oManager->expectCallCount('_parsePackage',5);
        $oManager->expectCallCount('enableComponentGroup',7);
        $oManager->expectCallCount('_setPackage',2);

        $oManager->expectCallCount('disablePackage',3);

        $oManager->tally();
    }

    function test_disablePackage()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      '_parsePackage',
                                      'disableComponentGroup',
                                      '_parseComponentGroups',
                                      '_runExtensionTasks',
                                      '_setPackage'
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_parseComponentGroups', true);
        $oManager->aParse['package']['name']     = 'test';
        $oManager->aParse['package']['install']['contents'] = array(0=>'test1',1=>'test2');

        // Test 1 - plugin file parse error
        $oManager->setReturnValueAt(0,'_parsePackage', false);
        $this->assertFalse($oManager->disablePackage('test'));

        // Test 2 - first plugin installation error
        $oManager->setReturnValueAt(1,'_parsePackage', true);
        $oManager->setReturnValueAt(0,'disableComponentGroup', false);

        $this->assertFalse($oManager->disablePackage('test'));

        // Test 3 - second plugin installation error
        $oManager->setReturnValueAt(2,'_parsePackage', true);
        $oManager->setReturnValueAt(1,'disableComponentGroup', true);
        $oManager->setReturnValueAt(2,'disableComponentGroup', false);

        $this->assertFalse($oManager->disablePackage('test'));

        // Test 4 - write settings error
        $oManager->setReturnValueAt(3,'_parsePackage', true);
        $oManager->setReturnValueAt(3,'disableComponentGroup', true);
        $oManager->setReturnValueAt(4,'disableComponentGroup', true);
        $oManager->setReturnValueAt(0,'_setPackage', false);

        $this->assertFalse($oManager->disablePackage('test'));

        // Test 5 - success
        $oManager->setReturnValueAt(4,'_parsePackage', true);
        $oManager->setReturnValueAt(5,'disableComponentGroup', true);
        $oManager->setReturnValueAt(6,'disableComponentGroup', true);
        $oManager->setReturnValueAt(1,'_setPackage', true);

        $this->assertTrue($oManager->disablePackage('test'));

        $oManager->expectCallCount('_parsePackage',5);
        $oManager->expectCallCount('disableComponentGroup',7);
        $oManager->expectCallCount('_setPackage',2);

        $oManager->tally();
    }

    function test_parseComponentGroups()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      'getFilePathToXMLInstall',
                                      'parseXML'
                                     )
                             );
        $oManager = new $oMockManager($this);

        // Test 1 - no plugins to parse
        $aContents = array();
        $this->assertFalse($oManager->_parseComponentGroups($aContents));

        // Test 2 - plugin file does not exist error
        $aContents[]['name'] = 'testDepends';
        $oManager->setReturnValueAt(0,'getFilePathToXMLInstall', MAX_PATH.$this->testpathPackages.'testDepends/foo.xml');

        $this->assertFalse($oManager->_parseComponentGroups($aContents));

        // Test 3 - first plugin parse error
        $aContents = array();
        $aContents[]['name'] = 'testDepends';
        $oManager->setReturnValueAt(1,'getFilePathToXMLInstall', MAX_PATH.$this->testpathPackages.'testDepends/testDepends.xml');
        $oManager->setReturnValueAt(0,'parseXML', false);

        $this->assertFalse($oManager->_parseComponentGroups($aContents));

        // Test 4 - second plugin parse error
        $aContents = array();
        $aContents[]['name'] = 'testPlugin';
        $aContents[]['name'] = 'testDepends';
        $oManager->setReturnValueAt(2,'getFilePathToXMLInstall', MAX_PATH.$this->testpathPackages.'testPlugin/testPlugin.xml');
        $oManager->setReturnValueAt(3,'getFilePathToXMLInstall', MAX_PATH.$this->testpathPackages.'testDepends/testDepends.xml');
        $oManager->setReturnValueAt(1,'parseXML', true);
        $oManager->setReturnValueAt(2,'parseXML', false);

        $this->assertFalse($oManager->_parseComponentGroups($aContents));

        // Test 5 - success
        $aContents = array();
        $aContents[]['name'] = 'testPlugin';
        $aContents[]['name'] = 'testDepends';
        $oManager->setReturnValueAt(4,'getFilePathToXMLInstall', MAX_PATH.$this->testpathPackages.'testPlugin/testPlugin.xml');
        $oManager->setReturnValueAt(5,'getFilePathToXMLInstall', MAX_PATH.$this->testpathPackages.'testDepends/testDepends.xml');
        $oManager->setReturnValueAt(3,'parseXML', array('name'=>'testPlugin'));
        $oManager->setReturnValueAt(4,'parseXML', array('name'=>'testDepends'));

        $result = $oManager->_parseComponentGroups($aContents);
        $this->assertTrue($result);
        $this->assertEqual(count($oManager->aParse['plugins']),2);
        $this->assertEqual($oManager->aParse['plugins'][0]['name'],'testPlugin');
        $this->assertEqual($oManager->aParse['plugins'][1]['name'],'testDepends');

        $oManager->expectCallCount('getFilePathToXMLInstall',6);
        $oManager->expectCallCount('parseXML',5);

        $oManager->tally();
    }

    function test_installComponentGroups()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      'installComponentGroup',
                                      '_auditInit',
                                      '_auditSetKeys',
                                      '_auditStart',
                                      '_auditUpdate',
                                      '_auditSetID',
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_auditStart', true);

        // Test 1 - no plugins to install
        $aPlugins = array();
        $this->assertFalse($oManager->_installComponentGroups($aPlugins));

        // Test 2 - first plugin install error
        $aPlugins = array();
        $aPlugins[]['name'] = 'testPlugin';
        $aPlugins[]['name'] = 'testDepends';
        $oManager->setReturnValueAt(0,'installComponentGroup', false);

        $this->assertFalse($oManager->_installComponentGroups($aPlugins));

        // Test 3 - second plugin install error
        $oManager->setReturnValueAt(1,'installComponentGroup', true);
        $oManager->setReturnValueAt(2,'installComponentGroup', false);

        $this->assertFalse($oManager->_installComponentGroups($aPlugins));

        // Test 4 - success
        $oManager->setReturnValueAt(3,'installComponentGroup', true);
        $oManager->setReturnValueAt(4,'installComponentGroup', true);

        $this->assertTrue($oManager->_installComponentGroups($aPlugins));

        $oManager->expectCallCount('installComponentGroup', 5);

        $oManager->tally();
    }

    function test_uninstallComponentGroups()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      'uninstallComponentGroup',
                                      '_auditInit',
                                      '_auditSetKeys',
                                      '_auditStart',
                                      '_auditUpdate',
                                      '_auditSetID',
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_auditStart', true);


        // Test 1 - no plugins to uninstall
        $aPlugins = array();
        $this->assertFalse($oManager->_uninstallComponentGroups($aPlugins));

        // Test 2 - first plugin uninstall error
        $aPlugins = array();
        $aPlugins[]['name'] = 'testPlugin';
        $aPlugins[]['name'] = 'testDepends';
        $oManager->setReturnValueAt(0,'uninstallComponentGroup', false);

        $this->assertFalse($oManager->_uninstallComponentGroups($aPlugins));

        // Test 3 - second plugin uninstall error
        $oManager->setReturnValueAt(1,'uninstallComponentGroup', true);
        $oManager->setReturnValueAt(2,'uninstallComponentGroup', false);

        $this->assertFalse($oManager->_uninstallComponentGroups($aPlugins));

        // Test 4 - success
        $oManager->setReturnValueAt(3,'uninstallComponentGroup', true);
        $oManager->setReturnValueAt(4,'uninstallComponentGroup', true);

        $this->assertTrue($oManager->_uninstallComponentGroups($aPlugins));

        $oManager->expectCallCount('uninstallComponentGroup', 5);

        $oManager->tally();
    }

    function test_setPackage()
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
        $oConfig->expectCallCount('settingChange',2);
        $oConfig->setReturnValueAt(0,'writeConfigChange', true);
        $oConfig->setReturnValueAt(1,'writeConfigChange', false);
        $oConfig->expectCallCount('writeConfigChange',2);

        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array('_instantiateClass')
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_instantiateClass', $oConfig);
        $oManager->expectCallCount('_instantiateClass',2);

        $this->assertTrue($oManager->_setPackage('test', 0));
        $this->assertFalse($oManager->_setPackage('test', 1));
        $oConfig->tally();
        $oManager->tally();
    }

    function test_parsePackage()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array('getPathToPackages', 'parseXML')
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('getPathToPackages', MAX_PATH.$this->testpathPackages.'testPlugin/');
        // Test 1 - file not found
        $this->assertFalse($oManager->_parsePackage('foo'));

        // Test 2 - package parse error
        $oManager->setReturnValueAt(0,'parseXML', false);

        $this->assertFalse($oManager->_parsePackage('testPlugin'));

        // Test 3 - success
        $aPackage['install']['contents'] = array(0=>'foo',1=>'bar');
        $oManager->setReturnValueAt(1,'parseXML', $aPackage);

        $result = $oManager->_parsePackage('testPlugin');
        $this->assertTrue($result,'array');
        $this->assertTrue(isset($oManager->aParse['package']['install']['contents']));
        $this->assertEqual(count($oManager->aParse['package']['install']['contents']),2);
        $this->assertEqual($oManager->aParse['package']['install']['contents'][0],'foo');
        $this->assertEqual($oManager->aParse['package']['install']['contents'][1],'bar');

        $oManager->expectCallCount('parseXML', 2);

        $oManager->tally();
    }

    function test_registerPackage()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array('disablePackage')
                             );
        $oManager = new $oMockManager($this);

        // Test 1 - fail
        $oManager->setReturnValueAt(0,'disablePackage', false);
        $this->assertFalse($oManager->_registerPackage('foo'));

        // Test 2 - success
        $oManager->setReturnValueAt(1,'disablePackage', true);
        $result = $oManager->_registerPackage('foo');

        $oManager->expectCallCount('disablePackage', 2);

        $oManager->tally();
    }

    function _unregisterPackage($name)
    {
        Mock::generatePartial(
                                'OA_Admin_Settings',
                                $oMockConfig = 'OA_Admin_Settings'.rand(),
                                array('writeConfigChange')
                             );
        $oConfig = new $oMockConfig($this);
        $oConfig->setReturnValueAt(0,'writeConfigChange', true);
        $oConfig->setReturnValueAt(1,'writeConfigChange', false);
        $oConfig->expectCallCount('writeConfigChange',2);

        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array('_instantiateClass')
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_instantiateClass', $oConfig);
        $oManager->expectCallCount('_instantiateClass',2);

        $this->assertTrue($oManager->_setPackage('test', 0));
        $this->assertFalse($oManager->_setPackage('test', 1));
        $oConfig->tally();
        $oManager->tally();
    }

    function test_getPackagesList()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array('getPackageInfo')
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValueAt(0,'getPackageInfo', array('stuff'=>'foo'));
        $oManager->setReturnValueAt(1,'getPackageInfo', array('stuff'=>'bar'));
        $oManager->expectCallCount('getPackageInfo',2);

        $GLOBALS['_MAX']['CONF']['plugins'] = array('foo' => 1,'bar' => 0);

        $result = $oManager->getPackagesList();
        $this->assertIsA($result,'array');
        $this->assertEqual(count($result),2);
        $this->assertEqual($result['foo']['enabled'],1);
        $this->assertEqual($result['bar']['enabled'],0);
        $this->assertEqual($result['foo']['stuff'],'foo');
        $this->assertEqual($result['bar']['stuff'],'bar');

        $oManager->tally();
    }

    function test_getPackageInfo()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                        '_parsePackage',
                                        'disablePackage',
                                        'getComponentGroupInfo',
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->__construct();
        $oManager->pathPackages = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];

        // Test 1 - parse failure
        $oManager->setReturnValueAt(0,'_parsePackage', false);
        $oManager->setReturnValueAt(0,'disablePackage', true);
        $this->assertFalse($oManager->getPackageInfo('test'));

        // Test 2 -
        $oManager->aParse['package']['name'] = 'test';
        $oManager->aParse['package']['install']['files'] = array(0=>array('name'=>'test.readme.txt','path'=>'{PATHPLUGINS}'),
                                                                 1=>array('name'=>'test.uninstall.txt','path'=>'{PATHPLUGINS}'));
        $oManager->aParse['package']['install']['contents'] = array(0=>array('name'=>'foo'), 1=>array('name'=>'bar'));
        $aFoo = array('name'=>'foo','version'=>'1','enabled'=>1,'installed'=>1,'package'=>'test');
        $aBar = array('name'=>'bar','version'=>'2','enabled'=>0,'installed'=>1,'package'=>'test');
        $oManager->setReturnValueAt(1,'_parsePackage', true);
        $oManager->setReturnValueAt(0,'getComponentGroupInfo', $aFoo);
        $oManager->setReturnValueAt(1,'getComponentGroupInfo', $aBar);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['foo'] = 1;
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['bar'] = 0;

        $result = $oManager->getPackageInfo('test');

        $this->assertIsA($result,'array');
        $this->assertEqual(count($result),5);
        $this->assertEqual($result['name'],'test');

        $this->assertEqual($result['contents'][0]['name'],'foo');
        $this->assertTrue($result['contents'][0]['enabled'],'enabled');
        $this->assertTrue($result['contents'][0]['installed'],'installed');
        $this->assertEqual($result['contents'][0]['package'],'test');
        $this->assertEqual($result['contents'][0]['version'],'1');

        $this->assertEqual($result['contents'][1]['name'],'bar');
        $this->assertFalse($result['contents'][1]['enabled']);
        $this->assertTrue($result['contents'][1]['installed']);
        $this->assertEqual($result['contents'][1]['package'],'test');
        $this->assertEqual($result['contents'][1]['version'],'2');

        $this->assertEqual($result['readme'],MAX_PATH.$oManager->pathPackages.'test.readme.txt');
        $this->assertEqual($result['uninstallReadme'],MAX_PATH.$oManager->pathPackages.'test.uninstall.txt');


        $oManager->expectCallCount('disablePackage',1);
        $oManager->expectCallCount('_parsePackage',2);
        $oManager->expectCallCount('getComponentGroupInfo',2);

        $oManager->tally();
    }

    function test_canUpgradeComponentGroups()
    {
        Mock::generatePartial(
                                'OX_Plugin_UpgradeComponentGroup',
                                $oMockUpgrade = 'OX_Plugin_UpgradeComponentGroup'.rand(),
                                array(
                                      'canUpgrade',
                                      'getErrors',
                                      'getMessages',
                                     )
                             );
        $oUpgrade = new $oMockUpgrade($this);
        $oUpgrade->setReturnValue('canUpgrade', true);
        $oUpgrade->setReturnValue('getErrors', array());
        $oUpgrade->setReturnValue('getMessages', array());

        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      '_getOX_Plugin_UpgradeComponentGroup',
                                      '_canUpgradeComponentGroup',
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_getOX_Plugin_UpgradeComponentGroup', $oUpgrade);

        // Test 1 - fail (no plugin definitions provided)
        $aPluginsNew    = array();
        $aPluginsOld    = array();
        $this->assertFalse($oManager->_canUpgradeComponentGroups($aPluginsNew, $aPluginsOld));

        // Test 2 - fail
        $aPluginsOld[0] = array('name'=>'foo',
                               );
        $aPluginsNew[0] = array('name'=>'foo',
                               );
        $oManager->setReturnValueAt(0,'_canUpgradeComponentGroup', false);
        $this->assertFalse($oManager->_canUpgradeComponentGroups($aPluginsNew, $aPluginsOld));

        // Test 3 - success
        $aPluginsOld[0] = array('name'=>'foo',
                               );
        $aPluginsNew[0] = array('name'=>'foo',
                               );
        $oManager->setReturnValueAt(1,'_canUpgradeComponentGroup', true);
        $this->assertTrue($oManager->_canUpgradeComponentGroups($aPluginsNew, $aPluginsOld));
        $this->assertEqual(count($aPluginsOld),0);

        // Test 3 - success but and old plugin needs deletion
        // the array of old plugins should be reduced to those which require deletion only
        $aPluginsOld[0] = array('name'=>'foo',
                               );
        $aPluginsOld[1] = array('name'=>'bar',
                               );
        $aPluginsNew[0] = array('name'=>'foo',
                               );
        $oManager->setReturnValueAt(2,'_canUpgradeComponentGroup', true);
        $this->assertTrue($oManager->_canUpgradeComponentGroups($aPluginsNew, $aPluginsOld));
        $this->assertEqual(count($aPluginsOld),1);
        $this->assertEqual($aPluginsOld[1]['name'],'bar');

        $oManager->expectCallCount('_canUpgradeComponentGroup', 3);

        $oManager->tally();
    }


    function test_upgradeComponentGroups()
    {
        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      '_instantiateClass',
                                      '_canUpgradeComponentGroups',
                                      'upgradeComponentGroup',
                                      '_logMessage',
                                      '_logError',
                                      '_cacheDependencies',
                                      '_installComponentGroups',
                                      '_uninstallComponentGroups',
                                     )
                             );
        $oManager = new $oMockManager($this);
        $oManager->setReturnValue('_canUpgradeComponentGroups', true);

        // Test 1 - upgrade failed
        $aPluginsNew[0] = array('name'=>'foo',
                                'status'=>OA_STATUS_PLUGIN_CAN_UPGRADE,
                               );
        $oManager->setReturnValueAt(0,'upgradeComponentGroup', false);
        $this->assertFalse($oManager->_upgradeComponentGroups($aPluginsNew, $aPluginsOld));

        // Test 2 - upgrade succeeded
        $aPluginsNew[0] = array('name'=>'foo',
                                'status'=>OA_STATUS_PLUGIN_CAN_UPGRADE,
                               );
        $oManager->setReturnValueAt(1,'upgradeComponentGroup', true);
        $this->assertTrue($oManager->_upgradeComponentGroups($aPluginsNew, $aPluginsOld));

        // Test 3 - a plugin requires installation but fails
        $aPluginsNew[0] = array('name'=>'foo',
                                'status'=>OA_STATUS_PLUGIN_NOT_INSTALLED,
                               );
        $oManager->setReturnValueAt(0,'_installComponentGroups', false);
        $this->assertFalse($oManager->_upgradeComponentGroups($aPluginsNew, $aPluginsOld));

        // Test 4 - a plugin requires installation and succeeds
        $aPluginsNew[0] = array('name'=>'foo',
                                'status'=>OA_STATUS_PLUGIN_NOT_INSTALLED,
                               );
        $oManager->setReturnValueAt(1,'_installComponentGroups', true);
        $this->assertTrue($oManager->_upgradeComponentGroups($aPluginsNew, $aPluginsOld));

        // Test 5 - an old plugin needs deletion and fails
        $aPluginsNew = array();
        $aPluginsOld[0] = array('name'=>'bar',
                               );
        $oManager->setReturnValueAt(0,'_uninstallComponentGroups', false);
        $this->assertFalse($oManager->_upgradeComponentGroups($aPluginsNew, $aPluginsOld));

        // Test 6 - an old plugin needs deletion and succeeds
        $aPluginsNew = array();
        $aPluginsOld[0] = array('name'=>'bar',
                               );
        $oManager->setReturnValueAt(1,'_uninstallComponentGroups', true);
        $this->assertTrue($oManager->_upgradeComponentGroups($aPluginsNew, $aPluginsOld));


        $oManager->expectCallCount('upgradeComponentGroup', 2);
        $oManager->expectCallCount('_installComponentGroups', 2);
        $oManager->expectCallCount('_uninstallComponentGroups', 2);

        $oManager->tally();
    }

    /*function test_upgradePackage()
    {
        Mock::generatePartial(
                                'OX_Plugin_UpgradeComponentGroup',
                                $oMockUpgrade = 'OX_Plugin_UpgradeComponentGroup'.rand(),
                                array(
                                      'canUpgrade',
                                      'getErrors',
                                      'getMessages',
                                     )
                             );
        $oUpgrade = new $oMockUpgrade($this);
        $oUpgrade->setReturnValue('canUpgrade', true);
        $oUpgrade->setReturnValue('getErrors', array());
        $oUpgrade->setReturnValue('getMessages', array());

        Mock::generatePartial(
                                'OX_PluginManager',
                                $oMockManager = 'OX_PluginManager'.rand(),
                                array(
                                      '_matchPackageFilename',
                                      '_logMessage',
                                      '_logError',
                                      '_auditInit',
                                      '_auditSetKeys',
                                      '_auditStart',
                                      '_auditUpdate',
                                      '_auditSetID',
                                      '_parsePackage',
                                      '_parseComponentGroups',
                                      'unpackPlugin',
                                      'disablePackage',
                                      '_canUpgradeComponentGroups',
                                      '_upgradeComponentGroups',
                                      '_getParsedPackage',
                                      '_getParsedPlugins',
                                     )
                             );

        $oManager = new $oMockManager($this);
        $oManager->oUpgrader = $oUpgrade;

        $oManager->setReturnValue('_auditStart', true);
        $oManager->setReturnValue('_getParsedPlugins', array(0=>array('name'=>'foo')));

        // Test 1 - package file not found
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testNonExistantPackage.xml',
                       'name'=>'testParsePluginFull.xml'
                      );
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));
        $oManager->expectCallCount('_matchPackageFilename', 0);
        $oManager->expectCallCount('_parsePackage', 0);
        $oManager->expectCallCount('_parseComponentGroups', 0);
        //$oManager->expectCallCount('_getParsedPackage', 0);
        $oManager->expectCallCount('unpackPlugin', 0);
        $oManager->expectCallCount('_canUpgradeComponentGroups', 0);
        $oManager->expectCallCount('_upgradeComponentGroups', 0);
        $oManager->tally();

        // Test 2 - package name mismatch
        $aFile = array('tmp_name'=>MAX_PATH.$this->testpathData.'testParsePluginFull.xml',
                       'name'=>'testParsePluginFull.xml'
                       );
        $oManager->setReturnValueAt(0,'_matchPackageFilename', false);
        $this->assertFalse($oManager->upgradePackage($aFile, 'foo'));

        $oManager->expectCallCount('_matchPackageFilename', 1);
        $oManager->expectCallCount('_parsePackage', 0);
        $oManager->expectCallCount('_parseComponentGroups', 0);
        //$oManager->expectCallCount('_getParsedPackage', 0);
        $oManager->expectCallCount('unpackPlugin', 0);
        $oManager->expectCallCount('_canUpgradeComponentGroups', 0);
        $oManager->expectCallCount('_upgradeComponentGroups', 0);
        $oManager->tally();

        // Test 3 - package names match but current package parse errors
        $oManager->setReturnValueAt(1,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(0,'_parsePackage', false);
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 2);
        $oManager->expectCallCount('_parsePackage', 1);
        $oManager->tally();

        // Test 4 - current plugins parse errors
        $oManager->setReturnValueAt(2,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(1,'_parsePackage', true);
        $oManager->setReturnValueAt(0,'_parseComponentGroups', false);
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 3);
        $oManager->expectCallCount('_parsePackage', 2);
        $oManager->expectCallCount('_parseComponentGroups', 1);
        $oManager->tally();

        // Test 5 - package unpack error
        $oManager->setReturnValueAt(3,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(2,'_parsePackage', true);
        $oManager->setReturnValueAt(1,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(0,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'1.0.0'));
        $oManager->setReturnValueAt(0,'unpackPlugin', false);
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 4);
        $oManager->expectCallCount('_parsePackage', 3);
        $oManager->expectCallCount('_parseComponentGroups', 2);
        //$oManager->expectCallCount('_getParsedPackage', 1);
        $oManager->expectCallCount('unpackPlugin', 1);
        $oManager->tally();

        // Test 6 - wrong upgrade package (name doesn't match current package)
        $oManager->setReturnValueAt(4,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(3,'_parsePackage', true);
        $oManager->setReturnValueAt(2,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(1,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'1.0.0'));
        $oManager->setReturnValueAt(1,'unpackPlugin', true);
        $oManager->setReturnValueAt(2,'_getParsedPackage', array('name'=>'bar'));
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 5);
        $oManager->expectCallCount('_parsePackage', 4);
        $oManager->expectCallCount('_parseComponentGroups', 3);
        //$oManager->expectCallCount('_getParsedPackage', 3);
        $oManager->expectCallCount('unpackPlugin', 2);
        $oManager->tally();

        // Test 7 - wrong upgrade package (version is less than version of installed package)
        $oManager->setReturnValueAt(5,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(4,'_parsePackage', true);
        $oManager->setReturnValueAt(3,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(3,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'1.0.0'));
        $oManager->setReturnValueAt(4,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'0.0.9-beta'));
        $oManager->setReturnValueAt(2,'unpackPlugin', true);
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 6);
        $oManager->expectCallCount('_parsePackage', 5);
        $oManager->expectCallCount('_parseComponentGroups', 4);
        //$oManager->expectCallCount('_getParsedPackage', 5);
        $oManager->expectCallCount('unpackPlugin', 3);
        $oManager->tally();

        // Test 8 - wrong upgrade package (version is equal to that of installed package)
        $oManager->setReturnValueAt(6,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(5,'_parsePackage', true);
        $oManager->setReturnValueAt(4,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(5,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'1.0.0'));
        $oManager->setReturnValueAt(6,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'1.0.0'));
        $oManager->setReturnValueAt(3,'unpackPlugin', true);
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 7);
        $oManager->expectCallCount('_parsePackage', 6);
        $oManager->expectCallCount('_parseComponentGroups', 5);
        //$oManager->expectCallCount('_getParsedPackage', 7);
        $oManager->expectCallCount('unpackPlugin', 4);
        $oManager->tally();

        // Test 9 - one or more plugins cannot be upgraded
        $oManager->setReturnValueAt(7,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(6,'_parsePackage', true);
        $oManager->setReturnValueAt(5,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(7,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'1.0.0'));
        $oManager->setReturnValueAt(8,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'2.0.0'));
        $oManager->setReturnValueAt(4,'unpackPlugin', true);
        $oManager->setReturnValueAt(0,'_canUpgradeComponentGroups', false);
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 8);
        $oManager->expectCallCount('_parsePackage', 7);
        $oManager->expectCallCount('_parseComponentGroups', 6);
        //$oManager->expectCallCount('_getParsedPackage', 9);
        $oManager->expectCallCount('unpackPlugin', 5);
        //$oManager->expectCallCount('_canUpgradeComponentGroups', 1);
        $oManager->tally();

        // Test 10 - one or more plugins fails upgrade
        $oManager->setReturnValueAt(8 ,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(7 ,'_parsePackage', true);
        $oManager->setReturnValueAt(6 ,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(9 ,'_getParsedPackage' , array('name'=>'testParsePlugin','version'=>'1.0.0'));
        $oManager->setReturnValueAt(10,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'2.0.0'));
        $oManager->setReturnValueAt(5 ,'unpackPlugin', true);
        $oManager->setReturnValueAt(1 ,'_canUpgradeComponentGroups', true);
        $oManager->setReturnValueAt(0 ,'_upgradeComponentGroups', false);
        $this->assertFalse($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 9);
        $oManager->expectCallCount('_parsePackage', 8);
        $oManager->expectCallCount('_parseComponentGroups', 7);
        //$oManager->expectCallCount('_getParsedPackage', 11);
        $oManager->expectCallCount('unpackPlugin', 6);
        //$oManager->expectCallCount('_canUpgradeComponentGroups', 2);
        //$oManager->expectCallCount('_upgradeComponentGroups', 1);
        $oManager->tally();

        // Test 11 - success
        $oManager->setReturnValueAt(9 ,'_matchPackageFilename', true);
        $oManager->setReturnValueAt(8 ,'_parsePackage', true);
        $oManager->setReturnValueAt(7 ,'_parseComponentGroups', true);
        $oManager->setReturnValueAt(11,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'1.0.0'));
        $oManager->setReturnValueAt(12,'_getParsedPackage', array('name'=>'testParsePlugin','version'=>'2.0.0'));
        $oManager->setReturnValueAt(6 ,'unpackPlugin', true);
        $oManager->setReturnValueAt(2 ,'_canUpgradeComponentGroups', true);
        $oManager->setReturnValueAt(1 ,'_upgradeComponentGroups', true);
        $this->assertTrue($oManager->upgradePackage($aFile, 'testParsePlugin'));

        $oManager->expectCallCount('_matchPackageFilename', 10);
        $oManager->expectCallCount('_parsePackage', 9);
        $oManager->expectCallCount('_parseComponentGroups', 8);
        $oManager->expectCallCount('_getParsedPackage', 13);
        $oManager->expectCallCount('unpackPlugin', 7);
        $oManager->expectCallCount('_canUpgradeComponentGroups', 3);
        $oManager->expectCallCount('_upgradeComponentGroups', 2);
        $oManager->tally();
    }*/
}

?>
