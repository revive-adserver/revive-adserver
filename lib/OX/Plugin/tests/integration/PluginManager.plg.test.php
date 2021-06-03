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

require_once LIB_PATH.'/Plugin/PluginManager.php';

/**
 * A class for testing the Test_OX_PluginManager class.
 *
 * @package Plugins
 * @subpackage TestSuite
 */
class Test_OX_PluginManager extends UnitTestCase
{
    var $testpathData         = '/lib/OX/Plugin/tests/data/';
    var $testpathPackages     = '/lib/OX/Plugin/tests/data/plugins/etc/';
    var $testpathPluginsAdmin = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
    var $testpathPlugins      = '/lib/OX/Plugin/tests/data/plugins/';
    var $testpathDataObjects  = '/var/';


    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function setUp()
    {
        // try to clean up in case of previous failure
        $oPkgMgr = new OX_PluginManager();
        $oPkgMgr->uninstallPackage('testPluginPackage');
        unset($GLOBALS['_MAX']['CONF']['plugins']['testPluginPackage']);
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);

    }

    function tearDown()
    {
        TestEnv::clearMenuCache();
    }

    function test_checkPackageContents()
    {
        $oPackageManager                    = new OX_PluginManager();

        /*
        define('OX_PLUGIN_ERROR_PACKAGE_DEFINITION_NOT_FOUND'   ,   -1);
        define('OX_PLUGIN_ERROR_PACKAGE_EXTRACT_FAILED'         ,   -2);
        define('OX_PLUGIN_ERROR_PACKAGE_PARSE_FAILED'           ,   -3);
        define('OX_PLUGIN_ERROR_PACKAGE_VERSION_NOT_FOUND'      ,   -4);
        define('OX_PLUGIN_ERROR_PLUGIN_DEFINITION_MISSING'      ,   -5);
        define('OX_PLUGIN_ERROR_PACKAGE_CONTENTS_MISMATCH'      ,   -6);
        define('OX_PLUGIN_ERROR_PLUGIN_EXTRACT_FAILED'          ,   -7);
        define('OX_PLUGIN_ERROR_PLUGIN_PARSE_FAILED'            ,   -8);
        define('OX_PLUGIN_ERROR_FILE_COUNT_MISMATCH'            ,   -9);
        define('OX_PLUGIN_ERROR_ILLEGAL_FILE'                   ,   -10);
        define('OX_PLUGIN_ERROR_PLUGIN_DECLARATION_MISMATCH'    ,   -11);
        */

        $result = $oPackageManager->_checkPackageContents('testPluginPackage.xml', MAX_PATH.$this->testpathData.'zipBad_FileIllegal/testPluginPackage.zip');
        $this->assertFalse($result);
        $this->assertEqual($oPackageManager->errcode, OX_PLUGIN_ERROR_ILLEGAL_FILE);

        $result = $oPackageManager->_checkPackageContents('testPluginPackage.xml', MAX_PATH.$this->testpathData.'zipBad_FileExtra/testPluginPackage.zip');
        $this->assertFalse($result);
        $this->assertEqual($oPackageManager->errcode, OX_PLUGIN_ERROR_FILE_COUNT_MISMATCH);

        $result = $oPackageManager->_checkPackageContents('testPluginPackage.xml', MAX_PATH.$this->testpathData.'zipBad_FileMisnamed/testPluginPackage.zip');
        $this->assertFalse($result);
        $this->assertEqual($oPackageManager->errcode, OX_PLUGIN_ERROR_PLUGIN_DECLARATION_MISMATCH);

        $GLOBALS['_MAX']['CONF']['plugins']['testPluginPackage'] = 1;
        $result = $oPackageManager->_checkPackageContents('testPluginPackage.xml', MAX_PATH.$this->testpathData.'zipGood/testPluginPackage.zip');
        $this->assertFalse($result);
        $this->assertEqual($oPackageManager->errcode, OX_PLUGIN_ERROR_PACKAGE_NAME_EXISTS);

        unset($GLOBALS['_MAX']['CONF']['plugins']['testPluginPackage']);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin'] = 1;
        $result = $oPackageManager->_checkPackageContents('testPluginPackage.xml', MAX_PATH.$this->testpathData.'zipGood/testPluginPackage.zip');
        $this->assertFalse($result);
        $this->assertEqual($oPackageManager->errcode, OX_PLUGIN_ERROR_PLUGIN_NAME_EXISTS);

        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']);
        $result = $oPackageManager->_checkPackageContents('testPluginPackage.xml', MAX_PATH.$this->testpathData.'zipGood/testPluginPackage.zip');
        $this->assertTrue($result);
        $this->assertEqual(count($oPackageManager->aParse),2);
        $this->assertTrue(isset($oPackageManager->aParse['package']));
        $this->assertTrue(isset($oPackageManager->aParse['plugins']));
        $this->assertEqual(count($oPackageManager->aParse['plugins']),1);
        $this->assertEqual($oPackageManager->errcode, OX_PLUGIN_ERROR_PACKAGE_OK);

        $result = $oPackageManager->_checkPackageContents('testPluginPackage.xml', MAX_PATH.$this->testpathData.'zipGoodTrans/testPluginPackage.zip');
        $this->assertTrue($result);
        $this->assertEqual(count($oPackageManager->aParse),2);
        $this->assertTrue(isset($oPackageManager->aParse['package']));
        $this->assertTrue(isset($oPackageManager->aParse['plugins']));
        $this->assertEqual(count($oPackageManager->aParse['plugins']),1);
        $this->assertEqual($oPackageManager->errcode, OX_PLUGIN_ERROR_PACKAGE_OK);
    }

    function test_decompressFile()
    {
        @unlink(MAX_PATH.'/var/ziptest/foo.xml');
        @unlink(MAX_PATH.'/var/ziptest/etc/bar.xml');
        @rmdir(MAX_PATH.'/var/ziptest/etc');
        @rmdir(MAX_PATH.'/var/ziptest');

        $oPackageManager                    = new OX_PluginManager();
        $oPackageManager->pathPackages      = $this->testpathPackages;

        $wrongPath = DIRECTORY_SEPARATOR == '/' ? '/foo' : 'ABC:\Foo';

        // Test fails as root
        if (function_exists('posix_getuid') && 0 !== posix_getuid()) {
            $oPackageManager->aErrors = array();
            $this->assertFalse($oPackageManager->_decompressFile(MAX_PATH.$this->testpathData.'ziptest.zip', $wrongPath));
            $this->assertEqual(count($oPackageManager->aErrors),3);
        }

        $oPackageManager->aErrors = array();
        $this->assertEqual(count($oPackageManager->_decompressFile(MAX_PATH.$this->testpathData.'ziptest.zip', MAX_PATH.'/var/')),3);
        $this->assertEqual(count($oPackageManager->aErrors),0);
        $this->assertTrue(file_exists(MAX_PATH.'/var/ziptest/foo.xml'));
        $this->assertTrue(file_exists(MAX_PATH.'/var/ziptest/etc/bar.xml'));

        @unlink(MAX_PATH.'/var/ziptest/foo.xml');
        @unlink(MAX_PATH.'/var/ziptest/etc/bar.xml');
        @rmdir(MAX_PATH.'/var/ziptest/etc');
        @rmdir(MAX_PATH.'/var/ziptest');
    }

    function test_installPackage()
    {
        $oPkgMgr = new OX_PluginManager();
        $file = MAX_PATH.$this->testpathData.'zipInstallTest/testPluginPackage.zip';

        $oPkgMgr->clearErrors();

        //install
        $this->assertTrue($oPkgMgr->installPackage(array('tmp_name'=>$file, 'name'=>'testPluginPackage.zip')));
        if (count($oPkgMgr->aErrors))
        {
            foreach ($oPkgMgr->aErrors AS $error)
            {
                $this->fail($error);
            }
        }
        $path = MAX_PATH.$oPkgMgr->pathPluginsAdmin.'testPlugin/';
        $this->assertTrue(file_exists($path.'templates/testPlugin.html'));
        $this->assertTrue(file_exists($path.'images/testPlugin1.jpg'));
        $this->assertTrue(file_exists($path.'images/testPlugin2.jpg'));
        $this->assertTrue(file_exists($path.'testPlugin-common.php'));
        $this->assertTrue(file_exists($path.'testPlugin-index.php'));
        $this->assertTrue(file_exists($path.'testPlugin-page.php'));

        $path = MAX_PATH.$oPkgMgr->pathPlugins.'etc/testPlugin/_lang/';
        $this->assertTrue(file_exists($path.'it.mo'));
        $this->assertTrue(file_exists($path.'po/it.po'));

        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['plugins']['testPluginPackage']));
        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']));

        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['testPlugin']));
        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['testPlugin']['setting1']));
        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['testPlugin']['setting2']));
        $this->assertTrue(isset($GLOBALS['_MAX']['CONF']['testPlugin']['setting3']));

        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'tables_testplugin';
        $doAppVar->find(true);
        $this->assertEqual($doAppVar->value,'001');
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'testPlugin_version';
        $doAppVar->find(true);
        $this->assertEqual($doAppVar->value,'0.0.1');

        $doPrefs = OA_Dal::factoryDO('preferences');
        $doPrefs->preference_name = 'testPlugin_preference1';
        $doPrefs->find(true);
        $this->assertEqual($doPrefs->account_type,OA_ACCOUNT_MANAGER);
        $doPrefs = OA_Dal::factoryDO('preferences');
        $doPrefs->preference_name = 'testPlugin_preference2';
        $doPrefs->find(true);
        $this->assertEqual($doPrefs->account_type,OA_ACCOUNT_ADMIN);

        $aTables = OA_DB_Table::listOATablesCaseSensitive('testPlugin_table');
        $this->assertIsA($aTables,'array');
        $doTestPluginTable = OA_Dal::factoryDO('testPlugin_table');
        $this->assertIsA($doTestPluginTable,'DataObjects_Testplugin_table');
        $this->assertEqual($id = $doTestPluginTable->insert(),1);
        $this->assertTrue($doTestPluginTable->delete());

        // try reinstalling
        $this->assertFalse($oPkgMgr->installPackage(array('tmp_name'=>$file, 'name'=>'testPluginPackage.zip')));
        $this->assertEqual($oPkgMgr->aErrors[0], "Plugin with this name is already installed testPluginPackage");

        //uninstall
        $oPkgMgr->clearErrors();
        $this->assertTrue($oPkgMgr->uninstallPackage('testPluginPackage'));
        if (count($oPkgMgr->aErrors))
        {
            foreach ($oPkgMgr->aErrors AS $error)
            {
                $this->fail($error);
            }
        }
        $path = MAX_PATH.$oPkgMgr->pathPluginsAdmin.'testPlugin/';
        $this->assertFalse(file_exists($path.'templates/testPlugin.html'));
        $this->assertFalse(file_exists($path.'images/testPlugin1.jpg'));
        $this->assertFalse(file_exists($path.'images/testPlugin2.jpg'));
        $this->assertFalse(file_exists($path.'testPlugin-common.php'));
        $this->assertFalse(file_exists($path.'testPlugin-index.php'));
        $this->assertFalse(file_exists($path.'testPlugin-page.php'));

        $this->assertFalse(isset($GLOBALS['_MAX']['CONF']['plugins']['testPluginPackage']));
        $this->assertFalse(isset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin']));

        $this->assertFalse(isset($GLOBALS['_MAX']['CONF']['testPlugin']));
        $this->assertFalse(isset($GLOBALS['_MAX']['CONF']['testPlugin']['setting1']));
        $this->assertFalse(isset($GLOBALS['_MAX']['CONF']['testPlugin']['setting2']));
        $this->assertFalse(isset($GLOBALS['_MAX']['CONF']['testPlugin']['setting3']));

        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'tables_testplugin';
        $doAppVar->find(true);
        $this->assertNull($doAppVar->value, 'Expected null got '.$doAppVar->value);
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'testPlugin_version';
        $doAppVar->find(true);
        $this->assertNull($doAppVar->value, 'Expected null got '.$doAppVar->value);

        $doPrefs = OA_Dal::factoryDO('preferences');
        $doPrefs->preference_name = 'testPlugin_preference1';
        $doPrefs->find(true);
        $this->assertNull($doPrefs->account_type, 'Expected null got '.$doPrefs->account_type);
        $doPrefs = OA_Dal::factoryDO('preferences');
        $doPrefs->preference_name = 'testPlugin_preference2';
        $doPrefs->find(true);
        $this->assertNull($doPrefs->account_type, 'Expected null got '.$doPrefs->account_type);

        $aTables = OA_DB_Table::listOATablesCaseSensitive('testplugin_table');
        $this->assertEqual(count($aTables),0);

        TestEnv::restoreConfig();
    }

    function test_getPackageDiagnostics()
    {
        $oPkgMgr = new OX_PluginManager();
        $file = MAX_PATH.$this->testpathData.'zipDiagnosticTest/testPluginPackage.zip';

        unset($GLOBALS['_MAX']['CONF']['plugins']['testPluginPackage']);
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['testPlugin001']);

        //install
        $this->assertTrue($oPkgMgr->installPackage(array('tmp_name'=>$file, 'name'=>'testPluginPackage.zip')));
        if (!empty($oPkgMgr->aErrors))
        {
            foreach ($oPkgMgr->aErrors AS $error)
            {
                $this->fail($error);
            }
        }

        $aResultGood = $oPkgMgr->getPackageDiagnostics('testPluginPackage');

        $this->assertFalse($aResultGood['plugin']['error']);

        unlink(MAX_PATH.$oPkgMgr->pathPluginsAdmin.'testPlugin001/'.'testPlugin-common.php');

        $oPkgMgr->_unregisterSettings('testPlugin001', false);

        unset($GLOBALS['_MAX']['CONF']['testPlugin001']);
        unset($GLOBALS['_MAX']['CONF']['testPlugin001']['setting1']);

        $oPkgMgr->_unregisterPluginVersion('testPlugin001');
        $oPkgMgr->_unregisterSchemaVersion('testPlugin001');

        $oPkgMgr->_unregisterPreferences('testPlugin001',$aResultGood['groups'][1]['install']['conf']['preferences']);

        $oPkgMgr->_dropTables('testPlugin', $aResultGood['groups'][1]['install']['schema']);

        $aResultBad = $oPkgMgr->getPackageDiagnostics('testPluginPackage');

        $this->assertTrue($aResultBad['groups'][1]['error']);

        //uninstall
        $this->assertTrue($oPkgMgr->uninstallPackage('testPluginPackage'));
        TestEnv::restoreConfig();
    }
}

?>
