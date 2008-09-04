<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once(LIB_PATH.'/Extension/ExtensionCommon.php');

class Test_OX_ExtensionCommon extends UnitTestCase
{

    function Test_OX_ExtensionCommon()
    {

    }

    function setUp()
    {
        if (file_exists(MAX_PATH.'/var/cache/cache_PrefOptions_Plugin.bak'))
        {
            unlink(MAX_PATH.'/var/cache/cache_PrefOptions_Plugin.bak');
        }
        if (file_exists(MAX_PATH.'/var/cache/cache_PrefOptions_Plugin'))
        {
            copy(MAX_PATH.'/var/cache/cache_PrefOptions_Plugin', MAX_PATH.'/var/cache/cache_PrefOptions_Plugin.bak');
        }
    }

    function tearDown()
    {
        if (file_exists(MAX_PATH.'/var/cache/cache_PrefOptions_Plugin.bak'))
        {
            @unlink(MAX_PATH.'/var/cache/cache_PrefOptions_Plugin');
            copy(MAX_PATH.'/var/cache/cache_PrefOptions_Plugin.bak', MAX_PATH.'/var/cache/cache_PrefOptions_Plugin');
        }
    }

    function test_cacheComponentHooks()
    {
        $oExtension = new OX_Extension_Common();
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = '/lib/OX/Plugin/tests/data/plugins/etc/';
        $GLOBALS['_MAX']['CONF']['pluginPaths']['admin'] = '/lib/OX/Plugin/tests/data/www/admin/plugins/';
        $GLOBALS['_MAX']['CONF']['plugins'] = array('testPluginPackage'=>1);
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = array('testPlugin'=>1);

        $oExtension->cacheComponentHooks();

        $oCache = new OA_Cache('Plugins', 'ComponentHooks');
        $oCache->setFileNameProtection(false);
        $aHooks = $oCache->load(true);

        $this->assertIsA($aHooks, 'array');
        $this->assertEqual(count($aHooks),1);
        $this->assertTrue(isset($aHooks['afterStart']));
        $this->assertEqual(count($aHooks['afterStart']),1);
        $this->assertEqual($aHooks['afterStart'][0],'admin:testPlugin:testPlugin');

        /*$GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] = '/plugins/';
        $aComponents = OX_Component::getComponents('admin','testPlugin',true);
        $this->assertTrue(isset($aComponents['testPlugin']));
        $this->assertEqual($aComponents['testPlugin']->extension,'admin');
        $this->assertEqual($aComponents['testPlugin']->group, 'testPlugin');
        $this->assertEqual($aComponents['testPlugin']->component, 'testPlugin');
        $this->assertEqual($aComponents['testPlugin']->enabled, true);

        $aComponents = OX_Component::getComponents('admin','testPlugin',false);
        $this->assertTrue(isset($aComponents['admin:testPlugin:testPlugin']));
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->extension,'admin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->group, 'testPlugin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->component, 'testPlugin');
        $this->assertEqual($aComponents['admin:testPlugin:testPlugin']->enabled, true);*/

        TestEnv::restoreConfig();
    }

    function test_cachePreferenceOptions()
    {
        $oExtension = new OX_Extension_Common();
        $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] = '/lib/OX/Extension/tests/data/';
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents'] = array('testPlugin'=>1);

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

        TestEnv::restoreConfig();
    }


}

?>