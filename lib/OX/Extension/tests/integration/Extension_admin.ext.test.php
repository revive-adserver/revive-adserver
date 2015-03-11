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
require_once(LIB_PATH.'/Extension/admin.php');

class Test_OX_Extension_admin extends UnitTestCase
{

    function __construct()
    {

    }

    function test_cacheMergedMenu()
    {
        Mock::generatePartial(
                                'OX_Plugin_ComponentGroupManager',
                                $oMockGroupManager = 'OX_Plugin_ComponentGroupManager'.rand(),
                                array(
                                      'mergeMenu',
                                     )
                             );
        $oGroupManager = new $oMockGroupManager($this);
        $oGroupManager->setReturnValue('mergeMenu', true);

        Mock::generatePartial(
                                'OX_Extension_admin',
                                $oMockExtensionManager = 'OX_Extension_admin'.rand(),
                                array(
                                      '_getMenuObjectForAccount',
                                      '_getGroupManagerObject',
                                     )
                             );
        $oMockExtensionManager = new $oMockExtensionManager($this);

        $oMenu = new OA_Admin_Menu('TEST');
        $oMenu->add(new OA_Admin_Menu_Section("test", 'test root', "test-root.php", false, ""));
        $oMockExtensionManager->setReturnValue('_getMenuObjectForAccount', $oMenu);
        $oMockExtensionManager->setReturnValue('_getGroupManagerObject', $oGroupManager);

        OA_Admin_Menu::_clearCache('TEST');

        $this->assertTrue($oMockExtensionManager->_cacheMergedMenu('TEST'));

        $oMenuCache = $oMenu->_loadFromCache('TEST');

        $this->assertTrue(is_a($oMenuCache, 'OA_Admin_Menu'));
        $this->assertEqual(count($oMenuCache->aAllSections),1);
        $this->assertTrue(array_key_exists('test',$oMenuCache->aAllSections));

        OA_Admin_Menu::_clearCache('TEST');

        TestEnv::restoreConfig();
    }
}

?>