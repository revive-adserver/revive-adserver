<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
$Id $
*/


require_once MAX_PATH.'/lib/OA/Upgrade/EnvironmentManager.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_OA_Environment_Manager extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Environment_Manager()
    {
        $this->UnitTestCase();
    }

    function test_getFilePermissionErrors()
    {
        $oEnvMgr = & $this->_getEnvMgrObj();
        $file = '/root';
        $oEnvMgr->aFilePermissions = array(
                                            $file
                                           );
        $aResult  = $oEnvMgr->getFilePermissionErrors();
        $this->assertTrue($aResult,"should have returned a permission error (unless {$file} is writable that is ;)");
    }

    function test_getPHPInfo()
    {
        $oEnvMgr = & $this->_getEnvMgrObj();
        $aResult = $oEnvMgr->getPHPInfo();
        $this->assertEqual($aResult['version'],phpversion(),'wrong PHP version');
    }

    function test_getFileIntegInfo()
    {
        $oEnvMgr = & $this->_getEnvMgrObj();
        $result = $oEnvMgr->getFileIntegInfo();
    }

    function test_getInfo()
    {
        $oEnvMgr = & $this->_getEnvMgrObj();
        $aResult = $oEnvMgr->getAllInfo();
        $this->assertIsA($aResult,'array','not an array');
    }

    function _getEnvMgrObj()
    {
        $oEnvMgr = new OA_Environment_Manager();
        return $oEnvMgr;
    }
}

?>
