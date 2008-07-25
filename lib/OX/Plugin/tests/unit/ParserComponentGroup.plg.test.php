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
// $Id$
*/

require_once MAX_PATH.'/lib/OA/Plugin/ParserComponentGroup.php';

/**
 * A class for testing the OX_ParserComponentGroup class.
 *
 * @package Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 * @subpackage TestSuite
 */
class Test_OX_ParserComponentGroup extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_ParserComponentGroup()
    {
        $this->UnitTestCase();
    }

    function test_ParseEmpty()
    {
        $file = MAX_PATH.'/lib/OA/Plugin/tests/data/testParseGroupEmpty.xml';
        $this->assertTrue(file_exists($file),'file not found '.$file);
        if (file_exists($file))
        {
            $oParser = new OX_ParserComponentGroup();
            $this->assertIsA($oParser,'OX_ParserComponentGroup');
            $result = $oParser->setInputFile($file);
            $this->assertFalse(PEAR::isError($result));
            $result = $oParser->parse();
            $this->assertFalse(PEAR::isError($result));
            $this->assertFalse(PEAR::isError($oParser->error));
            $this->assertTrue(is_array($oParser->aPlugin));

            $aPlugin = $oParser->aPlugin;

            $this->_assertStructure($aPlugin);

            $this->assertEqual(count($aPlugin['install']['conf']['settings']),0);
            $this->assertEqual(count($aPlugin['install']['conf']['preferences']),0);
            $this->assertEqual(count($aPlugin['install']['schema']),4);
            $this->assertEqual($aPlugin['install']['schema']['mdb2schema'],'');
            $this->assertEqual($aPlugin['install']['schema']['dboschema'],'');
            $this->assertEqual($aPlugin['install']['schema']['dbolinks'],'');
            $this->assertEqual(count($aPlugin['install']['schema']['dataobjects']),0);
        }
    }

    function test_ParsePartial()
    {
        $file = MAX_PATH.'/lib/OA/Plugin/tests/data/testParseGroupPartial.xml';
        $this->assertTrue(file_exists($file),'file not found '.$file);
        if (file_exists($file))
        {
            $oParser = new OX_ParserComponentGroup();
            $this->assertIsA($oParser,'OX_ParserComponentGroup');
            $result = $oParser->setInputFile($file);
            $this->assertFalse(PEAR::isError($result));
            $result = $oParser->parse();
            $this->assertFalse(PEAR::isError($result));
            $this->assertFalse(PEAR::isError($oParser->error));
            $this->assertTrue(is_array($oParser->aPlugin));

            $aPlugin = $oParser->aPlugin;

            $this->_assertStructure($aPlugin);

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]['insertafter'],'main-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]['index'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]['link'],'path_to_test_plugin/index.php');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]['value'],'Test Menu Index');

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]['addto'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]['index'],'test-menu-1');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]['link'],'path_to_test_plugin/page.php?action=1');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]['value'],'Test Page 1');

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]['addto'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]['index'],'test-menu-2');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]['link'],'path_to_test_plugin/page.php?action=2');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]['value'],'Test Page 2');

            $this->assertEqual(count($aPlugin['install']['conf']['settings']),0);
            $this->assertEqual(count($aPlugin['install']['conf']['preferences']),0);

            $this->assertEqual(count($aPlugin['install']['schema']),4);
            $this->assertEqual($aPlugin['install']['schema']['mdb2schema'],'');
            $this->assertEqual($aPlugin['install']['schema']['dboschema'],'');
            $this->assertEqual($aPlugin['install']['schema']['dbolinks'],'');
            $this->assertEqual(count($aPlugin['install']['schema']['dataobjects']),0);

        }
    }

    function test_ParseFull()
    {
        $file = MAX_PATH.'/lib/OA/Plugin/tests/data/testParseGroupFull.xml';
        $this->assertTrue(file_exists($file),'file not found '.$file);
        if (file_exists($file))
        {
            $oParser = new OX_ParserComponentGroup();
            $this->assertIsA($oParser,'OX_ParserComponentGroup');
            $result = $oParser->setInputFile($file);
            $this->assertFalse(PEAR::isError($result));
            $result = $oParser->parse();
            $this->assertFalse(PEAR::isError($result));
            $this->assertFalse(PEAR::isError($oParser->error));
            $this->assertTrue(is_array($oParser->aPlugin));

            $aPlugin = $oParser->aPlugin;

            $this->_assertStructure($aPlugin);
            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN]),3);

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]['insertafter'],'main-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]['index'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]['link'],'path_to_test_plugin/index.php');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][0]['value'],'Test Menu Index Admin');

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]['addto'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]['index'],'test-menu-1');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]['link'],'path_to_test_plugin/page.php?action=1');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][1]['value'],'Test Page 1 Admin');

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]['addto'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]['index'],'test-menu-2');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]['link'],'path_to_test_plugin/page.php?action=2');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADMIN][2]['value'],'Test Page 2 Admin');

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER]),2);

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][0]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][0]['insertafter'],'main-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][0]['index'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][0]['link'],'path_to_test_plugin/index.php');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][0]['value'],'Test Menu Index Manager');

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][1]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][1]['addto'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][1]['index'],'test-menu-1');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][1]['link'],'path_to_test_plugin/page.php?action=1');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_MANAGER][1]['value'],'Test Page 1 Manager');

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADVERTISER]),1);

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_ADVERTISER][0]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADVERTISER][0]['insertafter'],'main-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADVERTISER][0]['index'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADVERTISER][0]['link'],'path_to_test_plugin/index.php');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_ADVERTISER][0]['value'],'Test Menu Advertiser');


            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_TRAFFICKER]),1);

            $this->assertEqual(count($aPlugin['install']['navigation'][OA_ACCOUNT_TRAFFICKER][0]),4);
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_TRAFFICKER][0]['insertafter'],'main-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_TRAFFICKER][0]['index'],'test-menu');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_TRAFFICKER][0]['link'],'path_to_test_plugin/index.php');
            $this->assertEqual($aPlugin['install']['navigation'][OA_ACCOUNT_TRAFFICKER][0]['value'],'Test Menu Trafficker');

            $this->assertEqual(count($aPlugin['install']['conf']['settings']),3);

            $this->assertEqual($aPlugin['install']['conf']['settings'][0]['key'],'setting1');
            $this->assertEqual($aPlugin['install']['conf']['settings'][0]['value'],'setval1');
            $this->assertEqual($aPlugin['install']['conf']['settings'][0]['type'],'boolean');
            $this->assertEqual($aPlugin['install']['conf']['settings'][0]['label'],'Setting 1');
            $this->assertEqual($aPlugin['install']['conf']['settings'][0]['size'],'1');
            $this->assertEqual($aPlugin['install']['conf']['settings'][0]['required'],'1');
            $this->assertEqual($aPlugin['install']['conf']['settings'][0]['visible'],'1');

            $this->assertEqual($aPlugin['install']['conf']['settings'][1]['key'],'setting2');
            $this->assertEqual($aPlugin['install']['conf']['settings'][1]['value'],'setval2');
            $this->assertEqual($aPlugin['install']['conf']['settings'][1]['type'],'integer');
            $this->assertEqual($aPlugin['install']['conf']['settings'][1]['label'],'Setting 2');
            $this->assertEqual($aPlugin['install']['conf']['settings'][1]['size'],'2');
            $this->assertEqual($aPlugin['install']['conf']['settings'][1]['required'],'1');
            $this->assertEqual($aPlugin['install']['conf']['settings'][1]['visible'],'1');

            $this->assertEqual($aPlugin['install']['conf']['settings'][2]['key'],'setting3');
            $this->assertEqual($aPlugin['install']['conf']['settings'][2]['value'],'setval3');
            $this->assertEqual($aPlugin['install']['conf']['settings'][2]['type'],'text');
            $this->assertEqual($aPlugin['install']['conf']['settings'][2]['label'],'Setting 3');
            $this->assertEqual($aPlugin['install']['conf']['settings'][2]['size'],'3');
            $this->assertEqual($aPlugin['install']['conf']['settings'][2]['required'],'0');
            $this->assertEqual($aPlugin['install']['conf']['settings'][2]['visible'],'1');

            $this->assertEqual(count($aPlugin['install']['conf']['preferences']),2);

            $this->assertEqual($aPlugin['install']['conf']['preferences'][0]['name'],'preference1');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][0]['value'],'prefval1');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][0]['type'],'date');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][0]['label'],'Pref 1');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][0]['size'],'10');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][0]['required'],'1');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][0]['visible'],'1');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][0]['permission'],'MANAGER');

            $this->assertEqual($aPlugin['install']['conf']['preferences'][1]['name'],'preference2');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][1]['value'],'prefval2');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][1]['type'],'text');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][1]['label'],'Pref 2');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][1]['size'],'12');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][1]['required'],'0');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][1]['visible'],'0');
            $this->assertEqual($aPlugin['install']['conf']['preferences'][1]['permission'],'ADMIN');

            $this->assertEqual(count($aPlugin['install']['schema']),4);
            $this->assertEqual($aPlugin['install']['schema']['mdb2schema'],'tables_test');
            $this->assertEqual($aPlugin['install']['schema']['dboschema'],'db_schema');
            $this->assertEqual($aPlugin['install']['schema']['dbolinks'],'db_schema_links');
            $this->assertEqual(count($aPlugin['install']['schema']['dataobjects']),1);
            $this->assertEqual($aPlugin['install']['schema']['dataobjects'][0],'Testplugin_table.php');

            $this->assertEqual(count($aPlugin['install']['components']),2);
            $this->assertTrue(isset($aPlugin['install']['components']['testComponent']));
            $this->assertEqual($aPlugin['install']['components']['testComponent']['name'], 'testComponent');
            $this->assertTrue(isset($aPlugin['install']['components']['testComponent']['translations']));
            $this->assertEqual($aPlugin['install']['components']['testComponent']['translations'],'{MODULEPATH}/pathToTest/_lang/');
            
            $this->assertTrue(isset($aPlugin['install']['components']['testComponent2']));
            $this->assertEqual($aPlugin['install']['components']['testComponent2']['name'], 'testComponent2');
            $this->assertTrue(isset($aPlugin['install']['components']['testComponent2']['translations']));
            $this->assertEqual($aPlugin['install']['components']['testComponent2']['translations'],'{MODULEPATH}/pathToTest2/_lang/');


            $this->assertEqual(count($aPlugin['install']['components']['testComponent']['hooks']), 2);
            $this->assertEqual($aPlugin['install']['components']['testComponent']['hooks'][0],'testPreHook');
            $this->assertEqual($aPlugin['install']['components']['testComponent']['hooks'][1],'testPostHook');
        }
    }

    function _assertStructure($aPlugin)
    {
        $this->assertTrue(array_key_exists('install', $aPlugin),'array key not found [version]');

        $this->assertTrue(array_key_exists('navigation', $aPlugin['install']),'array key not found [install][navigation]');
        $this->assertTrue(array_key_exists(OA_ACCOUNT_ADMIN, $aPlugin['install']['navigation']),'array key not found [install][navigation][ADMIN]');
        $this->assertTrue(array_key_exists(OA_ACCOUNT_MANAGER, $aPlugin['install']['navigation']),'array key not found [install][navigation][MANAGER]');
        $this->assertTrue(array_key_exists(OA_ACCOUNT_ADVERTISER, $aPlugin['install']['navigation']),'array key not found [install][navigation][ADVERTISER]');
        $this->assertTrue(array_key_exists(OA_ACCOUNT_TRAFFICKER, $aPlugin['install']['navigation']),'array key not found [install][navigation][TRAFFICKER]');
        $this->assertTrue(array_key_exists('schema', $aPlugin['install']),'array key not found [install][schema]');
        $this->assertTrue(array_key_exists('settings', $aPlugin['install']['conf']),'array key not found [install][conf][settings]');
        $this->assertTrue(array_key_exists('preferences', $aPlugin['install']['conf']),'array key not found [install][conf][preferences]');
        $this->assertTrue(array_key_exists('mdb2schema', $aPlugin['install']['schema']),'array key not found [install][schema][mdb2schema]');
        $this->assertTrue(array_key_exists('dboschema', $aPlugin['install']['schema']),'array key not found [install][schema][dboschema]');
        $this->assertTrue(array_key_exists('dbolinks', $aPlugin['install']['schema']),'array key not found [install][schema][dbolinks]');
        $this->assertTrue(array_key_exists('dataobjects', $aPlugin['install']['schema']),'array key not found [install][schema][dataobjects]');
        $this->assertIsA($aPlugin['install']['schema']['dataobjects'],'array','array key is not an array [install][schema][dataobjects]');
        $this->assertTrue(array_key_exists('components', $aPlugin['install']),'array key not found [install][components]');
    }
}


?>
