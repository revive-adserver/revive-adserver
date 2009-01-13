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

require_once LIB_PATH.'/Plugin/PluginExport.php';

/**
 * A class for testing the Test_OX_PluginManager class.
 *
 * @package Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 * @subpackage TestSuite
 */
class Test_OX_PluginExport extends UnitTestCase
{
    var $testpathData         = '/lib/OX/Plugin/tests/data/';
    var $testpathPackages     = '/lib/OX/Plugin/tests/data/plugins/etc/';
    var $testpathPluginsAdmin = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
    var $testpathExtensions   = '/lib/OX/Plugin/tests/data/plugins/';
    var $testpathDataObjects  = '/var/';


    /**
     * The constructor method.
     */
    function Test_OX_PluginExport()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        TestEnv::clearMenuCache();
    }

    function test_backupTables()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['repo'] = $GLOBALS['_MAX']['CONF']['pluginPaths']['repo'].'|'.MAX_PATH.$this->testpathData.'plugins_repo/';
        $zipFile = $this->testpathData.'plugins_repo/'.'testPluginPackage_v3.zip';
        $plugin  = $this->testpathData.'plugins_repo/'.'testPluginPackage.zip';
        if (file_exists($zipFile) && (!unlink($zipFile)) )
        {
            $this->fail('error unlinking '.$zipFile);
            return false;
        }
        if (!copy(MAX_PATH.$zipFile,MAX_PATH.$plugin))
        {
            $this->fail('error copying '.$zipFile);
            return false;
        }
        if (!file_exists(MAX_PATH.$plugin))
        {
            $this->fail('file does not exist '.$plugin);
            return false;
        }
        TestEnv::installPluginPackage('testPluginPackage', false);
        $prefix  = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        $oExport    = new OX_PluginExport();
        $oExport->init('testPluginPackage');

        $aTables = OA_DB_Table::listOATablesCaseSensitive('testplugin_table');
        $this->assertEqual(count($aTables),1);
        $this->assertEqual($aTables[0],$prefix.'testplugin_table');

        $this->assertTrue($oExport->backupTables('testPluginPackage'));

        $aTables = OA_DB_Table::listOATablesCaseSensitive('testplugin_table');
        $this->assertEqual(count($aTables),2);
        $this->assertEqual($aTables[0],$prefix.'testplugin_table');
        $this->assertPattern('/'.$prefix.'testplugin_table_'.date('Ymd').'_[\d]{6}/',$aTables[1]);

        TestEnv::uninstallPluginPackage('testPluginPackage', false);
        TestEnv::restoreConfig();
        TestEnv::restoreEnv();
    }

    function test_makeDirectory()
    {

        $oExport    = new OX_PluginExport();
        $dir = MAX_PATH.'/var/tmp/export';
        @rmdir($dir);
        $this->assertFalse(file_exists($dir));
        $this->assertTrue($oExport->_makeDirectory($dir));
        $this->assertTrue(file_exists($dir));
        @rmdir($dir);

        $dir = MAX_PATH.'/var/tmp/export/test';
        @rmdir($dir);
        $this->assertFalse(file_exists($dir));
        $this->assertTrue($oExport->_makeDirectory($dir));
        $this->assertTrue(file_exists($dir));
        @rmdir($dir);
    }

    function test_compileContents_admin_with_schema()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages']     = $this->testpathPackages;
        $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions']   = $this->testpathExtensions;
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin']        = $this->testpathPluginsAdmin;

        $pathPackages     = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $pathExtensions   = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'];
        $pathAdmin        = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['admin'];

        $oExport    = new OX_PluginExport();
        $oExport->_compileContents('testPluginPackage');
        $this->assertIsA($oExport->aFileList,'array');
        $this->assertEqual(count($oExport->aFileList),18);
        $this->assertTrue(in_array($pathPackages.'testPluginPackage.xml', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPluginPackage.readme.txt', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/testPlugin.xml', $oExport->aFileList));
        // spare file - this should not be included
        $this->assertFalse(in_array($pathPackages.'testPlugin/etc/testScript.php', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc/postscript_testPlugin.php', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/processPreferences.php', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc/tables_testplugin.xml', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc/changes/schema_tables_testPlugin_001.xml', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc/DataObjects/db_schema.ini', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc/DataObjects/db_schema.links.ini', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc/DataObjects/Testplugin_table.php', $oExport->aFileList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin/testPlugin-index.php', $oExport->aFileList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin/testPlugin-common.php', $oExport->aFileList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin/testPlugin-page.php', $oExport->aFileList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin/images/testPlugin1.jpg', $oExport->aFileList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin/images/testPlugin2.jpg', $oExport->aFileList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin/templates/testPlugin.html', $oExport->aFileList));

        TestEnv::restoreConfig();
    }

    /*function test_compileDirectories_admin_with_schema()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages']     = $this->testpathPackages;
        $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions']   = $this->testpathExtensions;
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin']        = $this->testpathPluginsAdmin;

        $pathPackages     = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $pathExtensions   = $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'];
        $pathAdmin        = $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'];

        $oExport    = new OX_PluginExport();
        $oExport->_compileContents('testPluginPackage');
        $oExport->_compileDirectories('testPluginPackage');

        $this->assertIsA($oExport->aDirList,'array');
        $this->assertEqual(count($oExport->aDirList),10);
        $this->assertTrue(in_array(rtrim($pathPackages,'/'), $oExport->aDirList));
        $this->assertTrue(in_array(rtrim($pathExtensions,'/'), $oExport->aDirList));
        $this->assertTrue(in_array($pathPackages.'testDepends', $oExport->aDirList));
        $this->assertTrue(in_array($pathPackages.'testPlugin', $oExport->aDirList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc', $oExport->aDirList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc/changes', $oExport->aDirList));
        $this->assertTrue(in_array($pathPackages.'testPlugin/etc/DataObjects', $oExport->aDirList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin', $oExport->aDirList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin/templates', $oExport->aDirList));
        $this->assertTrue(in_array($pathAdmin.'testPlugin/images', $oExport->aDirList));

        TestEnv::restoreConfig();
    }*/

    function test_compileContents_extension_no_schema()
    {
        TestEnv::installPluginPackage('openXTests', false);

        $pathPackages     = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $pathExtensions   = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'];
        $pathAdmin        = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['admin'];

        $oExport    = new OX_PluginExport();
        $oExport->_compileContents('openXTests');
        $this->assertIsA($oExport->aFileList,'array');
        $this->assertEqual(count($oExport->aFileList),4);
        $this->assertTrue(in_array($pathPackages.'openXTests.xml', $oExport->aFileList));
        $this->assertTrue(in_array($pathPackages.'Dummy/Dummy.xml', $oExport->aFileList));
        $this->assertTrue(in_array($pathExtensions.'deliveryLimitations/Dummy/Dummy.class.php', $oExport->aFileList));
        $this->assertTrue(in_array($pathExtensions.'deliveryLimitations/Dummy/Dummy.delivery.php', $oExport->aFileList));

	    TestEnv::uninstallPluginPackage('openXTests', false);
	    TestEnv::restoreConfig();
    }

    /*function test_compileDirectories_extension_no_schema()
    {
        TestEnv::installPluginPackage('openXTests', false);

        $pathPackages     = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $pathExtensions   = $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'];
        $pathAdmin        = $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'];

        $oExport    = new OX_PluginExport();
        $oExport->_compileContents('openXTests');
        $oExport->_compileDirectories('openXTests');
        $this->assertIsA($oExport->aDirList,'array');
        $this->assertEqual(count($oExport->aDirList),4);
        $baseDir = MAX_PATH.'/var/tmp/openXTests';
        $this->assertTrue(in_array(rtrim($pathExtensions,'/'), $oExport->aDirList));
        $this->assertTrue(in_array(rtrim($pathPackages,'/'), $oExport->aDirList));
        $this->assertTrue(in_array($pathPackages.'Dummy', $oExport->aDirList));
        $this->assertTrue(in_array($pathExtensions.'deliveryLimitations/Dummy', $oExport->aDirList));

        TestEnv::uninstallPluginPackage('openXTests', false);
        TestEnv::restoreConfig();
    }*/


    function test_compressFiles()
    {
        $dirOut = MAX_PATH.'/var/';
        @unlink($dirOut.'test.zip');
        $oExport = new OX_PluginExport();
        $oExport->outputDir = $dirOut;
        $oExport->_addToFileList($this->testpathData.'bar.xml');
        $oExport->_addToFileList($this->testpathPackages.'testPluginPackage.xml');
        $this->assertTrue($oExport->_compressFiles('test'));
        $this->assertTrue(file_exists($dirOut.'test.zip'));

		$oZip = new PclZip($dirOut.'test.zip');
		$aContents = $oZip->listContent();
		$this->assertIsA($aContents,'array');
		$this->assertEqual(count($aContents),2);
		$this->assertEqual($aContents[0]['filename'],ltrim($this->testpathData,'/').'bar.xml');
		$this->assertEqual($aContents[0]['status'],'ok');
		$this->assertEqual($aContents[0]['stored_filename'],ltrim($this->testpathData,'/').'bar.xml');
		$this->assertEqual($aContents[1]['status'],'ok');
		$this->assertEqual($aContents[1]['filename'],ltrim($this->testpathPackages,'/').'testPluginPackage.xml');
		$this->assertEqual($aContents[1]['stored_filename'],ltrim($this->testpathPackages,'/').'testPluginPackage.xml');

        @unlink($dirOut.'test.zip');
    }

	function test_exportPlugin()
	{
        TestEnv::installPluginPackage('openXTests', false);

        $pathPackages     = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        $pathExtensions   = $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'];
        $pathAdmin        = $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'];

        $oExport    = new OX_PluginExport();
        $oExport->init('openXTests');
        $pathExport = $oExport->outputDir;
        @unlink($pathExport.'openXTests.zip');

        $this->assertTrue($oExport->exportPlugin('openXTests'));

        $baseDir = MAX_PATH.'/var/tmp/openXTests';

        $this->assertTrue(file_exists($pathExport.'openXTests.zip'));

		$oZip = new PclZip($pathExport.'openXTests.zip');
		$aContents = $oZip->listContent();
		$this->assertIsA($aContents,'array');
		$this->assertEqual(count($aContents),4);

		$this->assertEqual($aContents[0]['status'],'ok');
		$this->assertEqual($aContents[0]['filename'],ltrim($pathPackages,'/').'Dummy/Dummy.xml');
		$this->assertEqual($aContents[0]['stored_filename'],ltrim($pathPackages,'/').'Dummy/Dummy.xml');

		$this->assertEqual($aContents[1]['status'],'ok');
		$this->assertEqual($aContents[1]['filename'],ltrim($pathExtensions,'/').'deliveryLimitations/Dummy/Dummy.class.php');
		$this->assertEqual($aContents[1]['stored_filename'],ltrim($pathExtensions,'/').'deliveryLimitations/Dummy/Dummy.class.php');

		$this->assertEqual($aContents[2]['status'],'ok');
		$this->assertEqual($aContents[2]['filename'],ltrim($pathExtensions,'/').'deliveryLimitations/Dummy/Dummy.delivery.php');
		$this->assertEqual($aContents[2]['stored_filename'],ltrim($pathExtensions,'/').'deliveryLimitations/Dummy/Dummy.delivery.php');

		$this->assertEqual($aContents[3]['status'],'ok');
		$this->assertEqual($aContents[3]['filename'],ltrim($pathPackages,'/').'openXTests.xml');
		$this->assertEqual($aContents[3]['stored_filename'],ltrim($pathPackages,'/').'openXTests.xml');

		@unlink($pathExport.'openXTests.zip');

		$aContentsNew = $aContents;

		$oZip = new PclZip(MAX_PATH.'/plugins_repo/openXTests.zip');
		$aContentsOld = $oZip->listContent();
		foreach ($aContentsOld as $i => $aItemOld)
		{
		    if (!$aItem['folder'])
		    {
        		foreach ($aContentsNew as $n => $aItemNew)
        		{
                    if ( ($aItemOld['filename'] == $aItemNew['filename']) &&
                         ($aItemOld['stored_filename'] == $aItemNew['stored_filename']) &&
                         ($aItemOld['size'] == $aItemNew['size']) &&
                         ($aItemOld['crc'] == $aItemNew['crc'])
                       )
                    {
                        unset($aContentsOld[$i]);
                        unset($aContentsNew[$n]);
                        break;
                    }
        		}
		    }
		}
		$this->assertFalse(count($aContentsNew));
		$this->assertFalse(count($aContentsOld));

        TestEnv::uninstallPluginPackage('openXTests', false);
        TestEnv::restoreConfig();

	}

/*    function test_copyFiles()
    {
        $oExport = new OX_PluginExport();
        $oExport->baseDir = MAX_PATH.'/var/tmp';

        $dirData = MAX_PATH.'/var/tmp'.$this->testpathData;
        @rmdir($dirData);
        $this->assertFalse(file_exists($dirData));
        $this->assertTrue($oExport->_makeDirectory($oExport->baseDir.$this->testpathData));
        $this->assertTrue(file_exists($dirData));

        $dirPkgs = MAX_PATH.'/var/tmp'.$this->testpathPackages;
        @rmdir($dirPkgs);
        $this->assertFalse(file_exists($dirPkgs));
        $this->assertTrue($oExport->_makeDirectory($oExport->baseDir.$this->testpathPackages));
        $this->assertTrue(file_exists($dirPkgs));

        $oExport->aFileList[] = $this->testpathData.'bar.xml';
        $oExport->aFileList[] = $this->testpathPackages.'testPluginPackage.xml';
        $oExport->_copyFiles();

        $this->assertTrue(file_exists($dirData.'bar.xml'));
        $this->assertTrue(file_exists($dirPkgs.'testPluginPackage.xml'));

        @unlink($dirData.'bar.xml');
        @unlink($dirPkgs.'testPluginPackage.xml');
        @rmdir($dirData);
        @rmdir($dirPkgs);
    }

    function test_makeDirectories()
    {
        $baseDir = MAX_PATH.'/var/tmp/test';
        @rmdir($baseDir.'/test1/test2/test3');
        @rmdir($baseDir.'/test1/test2');
        @rmdir($baseDir.'/test1');
        @rmdir($baseDir.'/test2');
        $this->assertFalse(file_exists($baseDir.'/test1'));
        $this->assertFalse(file_exists($baseDir.'/test1/test2'));
        $this->assertFalse(file_exists($baseDir.'/test1/test2/test3'));
        $this->assertFalse(file_exists($baseDir.'/test2'));

        $oExport    = new OX_PluginExport();
        $oExport->baseDir = $baseDir;
        $oExport->aDirList[] = '/test1';
        $oExport->aDirList[] = '/test1/test2/test3';
        $oExport->aDirList[] = '/test2';
        $oExport->_makeDirectories();
        $this->assertTrue(file_exists($baseDir.'/test1'));
        $this->assertTrue(file_exists($baseDir.'/test1/test2/test3'));
        $this->assertTrue(file_exists($baseDir.'/test2'));
        @rmdir($baseDir.'/test1/test2/test3');
        @rmdir($baseDir.'/test1/test2');
        @rmdir($baseDir.'/test1');
        @rmdir($baseDir.'/test2');
    }
*/

}

?>
