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

//    function test_getPANInfo()
//    {
//        $oEnvMgr    = & $this->_getEnvMgrObj();
//        $fileTo     = MAX_PATH.'/var/config.inc.php';
//        $fileFrom   = MAX_PATH.'/lib/OA/Upgrade/tests/integration/pan.config.inc.php';
//
//        if (file_exists($fileTo))
//        {
//            unlink($fileTo);
//        }
//        $this->assertTrue(file_exists($fileFrom),'pan test config does not exist');
//        $this->assertTrue(copy($fileFrom, $fileTo),'failed to copy pan test config file');
//        $this->assertTrue(file_exists($fileTo),'pan test config does not exist');
//        $aResult  = $oEnvMgr->getPANInfo();
//        unlink($fileTo);
//        $this->assertEqual($aResult['dbhost'],'pan_host','');
//        $this->assertEqual($aResult['dbport'],'9999','');
//        $this->assertEqual($aResult['dbuser'],'pan_user','');
//        $this->assertEqual($aResult['dbpassword'],'pan_password','');
//        $this->assertEqual($aResult['dbname'],'pan_database','');
//        $this->assertEqual($aResult['table_type'],'PANENGINE','');
//        $this->assertEqual($aResult['table_prefix'],'panprefix_','');
//    }

//    function test_getDBInfo()
//    {
//        $oEnvMgr = & $this->_getEnvMgrObj();
//        $aResult = $oEnvMgr->getDBInfo();
//        $confdb = $GLOBALS['_MAX']['CONF']['database'];
//        $conftbl = $GLOBALS['_MAX']['CONF']['table'];
//        $this->assertEqual($aResult['type'],$confdb['type'],'');
//        $this->assertEqual($aResult['port'],$confdb['port'],'');
//        $this->assertEqual($aResult['username'],$confdb['username'],'');
//        $this->assertEqual($aResult['password'],$confdb['password'],'');
//        $this->assertEqual($aResult['name'],$confdb['name'],'');
//        $this->assertEqual($aResult['table']['type'],$conftbl['type'],'');
//        $this->assertEqual($aResult['table']['prefix'],$conftbl['prefix'],'');
//    }
//
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
        $oEnvMgr->init();
        return $oEnvMgr;
    }
}

?>
