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
require_once(LIB_PATH.'/Extension/admin.php');

class Test_OX_Extension_admin extends UnitTestCase
{

    function Test_OX_Extension_admin()
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