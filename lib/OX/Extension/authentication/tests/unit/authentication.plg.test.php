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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dll/User.php';

Language_Loader::load();


/**
 * A class for testing the Plugins_Authentication class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Test_Authentication extends UnitTestCase
{
    /**
     * @var Plugins_Authentication
     */
    public $oPlugin;

    public function __construct()
    {
        parent::__construct();
    }

    public function setUp()
    {
        $this->oPlugin = OA_Auth::staticGetAuthPlugin();
    }

    public function testSuppliedCredentials()
    {
        $ret = $this->oPlugin->suppliedCredentials();
        $this->assertFalse($ret);

        $_POST['username'] = 'boo';
        $_POST['password'] = 'foo';
        $ret = $this->oPlugin->suppliedCredentials();
        $this->assertTrue($ret);
    }

    public function testChangeEmail()
    {
        /** @var DataObjects_Users $doUsers */
        $doUsers = OA_Dal::factoryDO('users');

        $this->assertIsA($this->oPlugin->changeEmail($doUsers, 'invalid @ email'), 'PEAR_Error');
        $this->assertNotA($this->oPlugin->changeEmail($doUsers, 'valid@example.com'), 'PEAR_Error');
    }

    public function testAuthenticateUser()
    {
        $username = 'boo';
        $password = 'foo';

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = $username;
        $doUsers->password = \RV\Manager\PasswordManager::getPasswordHash($password);
        DataGenerator::generateOne($doUsers);

        $_POST['username'] = $username;
        $_POST['password'] = $password;
        $_COOKIE['sessionID'] = $_POST['oa_cookiecheck'] = 'baz';
        $ret = $this->oPlugin->authenticateUser();
        $this->assertIsA($ret, 'DataObjects_Users');
        $this->assertEqual($doUsers->username, $username);

        $_POST['password'] = $password . rand();
        $ret = $this->oPlugin->authenticateUser();
        $this->assertFalse($ret);
    }

    public function testdllValidation()
    {
        Mock::generatePartial(
            'OA_Dll_User',
            'PartialMockOA_Dll_User',
            ['raiseError'],
        );

        $dllUserMock = new PartialMockOA_Dll_User();
        $dllUserMock->setReturnValue('raiseError', true);
        $dllUserMock->expectCallCount('raiseError', 3);

        $oUserInfo = new OA_Dll_UserInfo();

        // Test with nothing set
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test with username set, no password: welcome email
        $oUserInfo->username = 'foobar';
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));
        $this->assertNull($oUserInfo->password);

        // Test with username and password too short
        $oUserInfo->password = 'pwd';
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test with username and password set
        $oUserInfo->password = 'pwdpwdpwdpwd';
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));
        $this->assertTrue(\RV\Manager\PasswordManager::verifyPassword('pwdpwdpwdpwd', $oUserInfo->password));

        // Test edit
        $oUserInfo = new OA_Dll_UserInfo();
        $oUserInfo->userId = 1;
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));
        $this->assertNull($oUserInfo->password);

        // Test edit with password too short
        $oUserInfo->password = 'pwd2';
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test edit with new password
        $oUserInfo->password = 'pwd2pwd2pwd2';
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));
        $this->assertTrue(\RV\Manager\PasswordManager::verifyPassword('pwd2pwd2pwd2', $oUserInfo->password));

        $dllUserMock->tally();
    }
}
