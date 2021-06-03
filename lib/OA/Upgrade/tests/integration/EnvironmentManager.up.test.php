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

require_once MAX_PATH.'/lib/OA/Upgrade/EnvironmentManager.php';

Language_Loader::load();

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_OA_Environment_Manager extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function test_getFilePermissionErrors()
    {
        $oEnvMgr = $this->_getEnvMgrObj();
        $file = '/root';
        $oEnvMgr->aFilePermissions = array(
                                            $file
                                           );
        $aResult  = $oEnvMgr->getFilePermissionErrors();
        $this->assertTrue($aResult,"should have returned a permission error (unless {$file} is writable that is ;)");
    }

    function test_getPHPInfo()
    {
        $oEnvMgr = $this->_getEnvMgrObj();
        $aResult = $oEnvMgr->getPHPInfo();
        $this->assertEqual($aResult['version'],phpversion(),'wrong PHP version');
    }

    function test_getFileIntegInfo()
    {
        $oEnvMgr = $this->_getEnvMgrObj();
        $result = $oEnvMgr->getFileIntegInfo();
    }

    function test_getInfo()
    {
        $oEnvMgr = $this->_getEnvMgrObj();
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
