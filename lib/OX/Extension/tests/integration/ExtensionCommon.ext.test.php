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
require_once(LIB_PATH.'/Extension/ExtensionCommon.php');

class Test_OX_ExtensionCommon extends UnitTestCase
{

    function __construct()
    {

    }

    function setUp()
    {
    }

    function tearDown()
    {
    }

    function test_cacheComponentHooks()
    {
        $oExtension = new OX_Extension_Common();
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = '/lib/OX/Plugin/tests/data/plugins/etc/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'] = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
        $GLOBALS['_MAX']['CONF']['plugins'] = array('testPluginPackage'=>1);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = array('testPlugin'=>1);

        $this->_backupCacheFile('ComponentHooks_Plugins');

        $oExtension->cacheComponentHooks();

        $oCache = new OA_Cache('Plugins', 'ComponentHooks');
        $oCache->setFileNameProtection(false);
        $aHooks = $oCache->load(true);

        $this->assertIsA($aHooks, 'array');
        $this->assertEqual(count($aHooks),1);
        $this->assertTrue(isset($aHooks['duringTest']));
        $this->assertEqual(count($aHooks['duringTest']),1);
        $this->assertEqual($aHooks['duringTest'][0],'admin:testPlugin:testPlugin');

        $this->_restoreCacheFile('ComponentHooks_Plugins');

        TestEnv::restoreConfig();
    }

    function test_cachePreferenceOptions()
    {
        $oExtension = new OX_Extension_Common();
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = '/lib/OX/Extension/tests/data/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = array('testPlugin'=>1);

        $this->_backupCacheFile('PrefOptions_Plugins');

        $oExtension->cachePreferenceOptions();

        $oCache = new OA_Cache('Plugins', 'PrefOptions');
        $oCache->setFileNameProtection(false);
        $aPrefOptions = $oCache->load(true);

        $this->assertIsA($aPrefOptions, 'array');
        $this->assertEqual(count($aPrefOptions),1);
        $this->assertTrue(isset($aPrefOptions['testPlugin']));
        $this->assertTrue(isset($aPrefOptions['testPlugin']['value']));
        $this->assertTrue(isset($aPrefOptions['testPlugin']['name']));
        $this->assertTrue(isset($aPrefOptions['testPlugin']['perm']));
        $this->assertEqual($aPrefOptions['testPlugin']['name'],'testPlugin');
        $this->assertEqual($aPrefOptions['testPlugin']['text'],'Option Text');
        $this->assertEqual($aPrefOptions['testPlugin']['value'],'account-preferences-plugin.php?group=testPlugin');
        $this->assertEqual(count($aPrefOptions['testPlugin']['perm']),4);

        $this->_restoreCacheFile('PrefOptions_Plugins');

        TestEnv::restoreConfig();
    }

    function _backupCacheFile($name)
    {
        $filename = MAX_PATH.'/var/cache/cache_'.$name;
        if (file_exists($filename.'.bak'))
        {
            unlink($filename.'.bak');
        }
        if (file_exists($filename))
        {
            copy($filename, $filename.'.bak');
        }
    }

    function _restoreCacheFile($name)
    {
        $filename = MAX_PATH.'/var/cache/cache_'.$name;
        if (file_exists($filename))
        {
            copy($filename.'.bak', $filename);
        }
        if (file_exists($filename.'.bak'))
        {
            unlink($filename.'.bak');
        }
    }

}

?>