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

if (!isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = '/test.php';
}

if (!isset($_SERVER['QUERY_STRING'])) {
    $_SERVER['QUERY_STRING'] = '';
}

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dll/User.php';

/**
 * A class for testing the Plugins_Authentication_Cas_Cas class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_Plugins_Authentication_oxAuthCAS_oxAuthCAS extends UnitTestCase
{
    /**
     * @var Plugins_Authentication_oxAuthCAS_oxAuthCAS
     */
    var $oPlugin;

    function Test_Plugins_Authentication_oxAuthCAS_oxAuthCAS()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        TestEnv::uninstallPluginPackage('openXAuthCAS');
        TestEnv::installPluginPackage('openXAuthCAS');
        $conf =& $GLOBALS['_MAX']['CONF'];
        $conf['authentication']['type'] = 'authentication:oxAuthCAS:oxAuthCAS';
        $this->oPlugin = OA_Auth::staticGetAuthPlugin();
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXAuthCAS');
        TestEnv::restoreConfig();
        DataGenerator::cleanUp();
    }

    function testSuppliedCredentials()
    {
        $ret = $this->oPlugin->suppliedCredentials();
        $this->assertFalse($ret);

        $_GET['ticket'] = 'boo';
        $ret = $this->oPlugin->suppliedCredentials();
        $this->assertTrue($ret);

    }

    function testStorePhpCasSession()
    {
        // store data
        $data = array('boo');
        $_SESSION[OA_CAS_PLUGIN_PHP_CAS] = $data;
        $this->oPlugin->storePhpCasSession();

        // now fetch stored data and test that it was saved
        phpAds_SessionDataFetch();
        global $session;
        $this->assertEqual($session[OA_CAS_PLUGIN_PHP_CAS], $data);

        // clean up
        unset($_SESSION[OA_CAS_PLUGIN_PHP_CAS]);
    }

    function testRestorePhpCasSession()
    {
        $data = array('boo');
        global $session;
        $session[OA_CAS_PLUGIN_PHP_CAS] = $data;
        $this->oPlugin->restorePhpCasSession();
        $this->assertEqual($_SESSION[OA_CAS_PLUGIN_PHP_CAS], $data);
    }

    function testGetUser()
    {
        $username = 'boo';
        $ssoUserId = 123;
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = $username;
        $doUsers->sso_user_id = $ssoUserId;
        DataGenerator::generateOne($doUsers);

        $ret = $this->oPlugin->getUserBySsoUserId($ssoUserId);
        $this->assertIsA($ret, 'DataObjects_Users');
        $this->assertEqual($ret->sso_user_id, $ssoUserId);

        $ret = $this->oPlugin->getUserBySsoUserId(-1);
        $this->assertNull($ret);
    }

    function testGetCentralCas()
    {
        $oCentral = &$this->oPlugin->getCentralCas();
        $this->assertIsA($oCentral, 'OA_Central_Cas');
        unset($oCentral->oCache);
        $this->assertNull($oCentral->oCache);

        $oCentral2 = &$this->oPlugin->getCentralCas();
        $this->assertNull($oCentral2->oCache);
    }

    function testdllValidation()
    {
        Mock::generatePartial(
            'OA_Dll_User',
            'PartialMockOA_Dll_User',
            array('raiseError')
        );

        $dllUserMock = new PartialMockOA_Dll_User();
        $dllUserMock->setReturnValue('raiseError', true);
        $dllUserMock->expectCallCount('raiseError', 5);

        $oUserInfo = new OA_Dll_UserInfo();

        // Test with username set
        $oUserInfo->username = 'foobar';
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test with password set
        unset($oUserInfo->username);
        $oUserInfo->password = 'pwd';
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test with nothing set
        unset($oUserInfo->password);
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test with email set
        $oUserInfo->emailAddress = 'test@example.com';
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));
        $this->assertTrue($oUserInfo->username);

        // Test edit with username set
        $oUserInfo = new OA_Dll_UserInfo();
        $oUserInfo->userId = 1;
        $oUserInfo->username = 'foobar';
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test edit with password set
        unset($oUserInfo->username);
        $oUserInfo->password = 'pwd';
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test edit with nothing set
        unset($oUserInfo->password);
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        $dllUserMock->tally();
    }
}

?>