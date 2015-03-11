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

/**
 * A class for testing the Plugins_Authentication_Internal_Internal class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Test_Authentication extends UnitTestCase
{
    /**
     * @var Plugins_Authentication_Internal_Internal
     */
    var $oPlugin;

    function __construct()
    {
        parent::__construct();
    }

    function setUp()
    {
        $this->oPlugin =  OA_Auth::staticGetAuthPlugin();
    }

    function testSuppliedCredentials()
    {
        $ret = $this->oPlugin->suppliedCredentials();
        $this->assertFalse($ret);

        $_POST['username'] = 'boo';
        $_POST['password'] = 'foo';
        $ret = $this->oPlugin->suppliedCredentials();
        $this->assertTrue($ret);

    }

    function testAuthenticateUser()
    {
        $username = 'boo';
        $password = 'foo';

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = $username;
        $doUsers->password = md5($password);
        DataGenerator::generateOne($doUsers);

        $_POST['username'] = $username;
        $_POST['password'] = $password;
        $_COOKIE['sessionID'] = $_POST['oa_cookiecheck'] = 'baz';
        $ret = $this->oPlugin->authenticateUser();
        $this->assertIsA($ret, 'DataObjects_Users');
        $this->assertEqual($doUsers->username, $username);

        $_POST['password'] = $password.rand();
        $ret = $this->oPlugin->authenticateUser();
        $this->assertFalse($ret);
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
        $dllUserMock->expectCallCount('raiseError', 2);

        $oUserInfo = new OA_Dll_UserInfo();

        // Test with nothing set
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test with username set
        $oUserInfo->username = 'foobar';
        $this->assertFalse($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));

        // Test with username and password set
        $oUserInfo->password = 'pwd';
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));
        $this->assertEqual($oUserInfo->password, md5('pwd'));

        // Test edit
        $oUserInfo = new OA_Dll_UserInfo();
        $oUserInfo->userId = 1;
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));
        $this->assertNull($oUserInfo->password);

        // Test edit with new password
        $oUserInfo->password = 'pwd';
        $this->assertTrue($this->oPlugin->dllValidation($dllUserMock, $oUserInfo));
        $this->assertEqual($oUserInfo->password, md5('pwd'));

        $dllUserMock->tally();
    }
}

?>