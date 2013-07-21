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

require_once dirname(__FILE__) . '/../../Controller/ConfirmAccount.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dll/User.php';

/**
 * A class for testing the Plugins_Authentication_Cas_Cas class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_ConfirmAccount extends UnitTestCase
{
    function Test_ConfirmAccount()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
    }

    function tearDown()
    {
    }

    function testCheckIfSsoUserExists()
    {
        // generate one users to ensure his ID is != 1
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'boo' . 1;
        DataGenerator::generate('users');

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'boo' . 2;
        $doUsers->sso_user_id = $ssoUserId = 123;
        $userId = DataGenerator::generateOne($doUsers);

        $ret = OA_Controller_SSO_ConfirmAccount::checkIfSsoUserExists($ssoUserId);
        $this->assertEqual($ret, $userId);

        $ret = OA_Controller_SSO_ConfirmAccount::checkIfSsoUserExists(12345);
        $this->assertFalse($ret);
    }
}

?>