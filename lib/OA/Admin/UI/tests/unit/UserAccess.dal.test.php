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

require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Permission/SystemUser.php';

class UserAccessTestRedirect extends Exception {}

class UserAccessTestController extends OA_Admin_UI_UserAccess
{
    public function display() {}

    public function getRedirectUrl()
    {
        // Stop before the redirect exits the test runner, after changes have been saved.
        throw new UserAccessTestRedirect();
    }
}

class Test_OA_Admin_UI_UserAccess extends UnitTestCase
{
    private $savedSession;
    private $savedCookies;
    private $accountId;

    public function setUp()
    {
        $this->savedSession = $GLOBALS['session'] ?? [];
        $this->savedCookies = $_COOKIE;
        phpAds_SessionGetToken();
        $GLOBALS['session']['user'] = new OA_Permission_SystemUser('test-admin');
        $GLOBALS['session']['user']->aUser['is_admin'] = true;
        $agencyId = DataGenerator::generateOne('agency');
        $this->accountId = OA_Dal::staticGetDO('agency', $agencyId)->account_id;
        Language_Loader::load();
    }

    public function tearDown()
    {
        $GLOBALS['session'] = $this->savedSession;
        $_COOKIE = $this->savedCookies;
        DataGenerator::cleanUp();
    }

    private function controller($username, $userId = null)
    {
        $controller = new UserAccessTestController();
        $controller->accountId = $this->accountId;
        $controller->userid = $userId;
        $controller->oPlugin = clone OA_Auth::staticGetAuthPlugin();
        $controller->oPlugin->aValidationErrors = [];
        $controller->request = [
            'submit' => true,
            'userid' => $userId,
            'login' => $username,
            'email_address' => 'legacy@example.com',
            'token' => phpAds_SessionGetToken(),
        ];
        return $controller;
    }

    public function testLinkAndUpdateLegacyUser()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'legacy user';
        $doUsers->email_address = 'legacy@example.com';
        $doUsers->is_admin = 0;
        $userId = DataGenerator::generateOne($doUsers);

        $controller = $this->controller('legacy user');
        $matchedId = $controller->oPlugin->getMatchingUserId('', 'legacy user');
        $this->assertEqual($matchedId, $userId);
        $controller->userid = $controller->request['userid'] = $matchedId;
        $controller->aAllowedPermissions = [OA_PERM_SUPER_ACCOUNT => 'Super account'];

        // Both linking and subsequent permission updates must accept the old username.
        foreach ([[], [OA_PERM_SUPER_ACCOUNT]] as $permissions) {
            $controller->aPermissions = $permissions;
            $redirected = false;
            try {
                $controller->process();
            } catch (UserAccessTestRedirect $e) {
                $redirected = true;
            }
            $this->assertTrue($redirected);
            $this->assertEqual($controller->aErrors, []);
            $this->assertTrue(OA_Permission::isUserLinkedToAccount($this->accountId, $userId));
            $storedPermissions = OA_Permission::getAccountUsersPermissions($userId, $this->accountId);
            $this->assertEqual(!empty($storedPermissions[OA_PERM_SUPER_ACCOUNT]), !empty($permissions));
        }
    }

    public function testRejectNewUserWithSpace()
    {
        $controller = $this->controller('new user');
        $controller->process();
        $this->assertEqual($controller->aErrors, [$GLOBALS['strInvalidUsername']]);
        $this->assertFalse(OA_Permission::userNameExists('new user'));
    }

    public function testRejectMismatchedExistingUserData()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'legacy user';
        $doUsers->email_address = 'legacy@example.com';
        $doUsers->is_admin = 0;
        $userId = DataGenerator::generateOne($doUsers);

        $controller = $this->controller('different user', $userId);
        $controller->process();
        $this->assertEqual($controller->aErrors, ['Invalid user data provided']);
        $this->assertFalse(OA_Permission::isUserLinkedToAccount($this->accountId, $userId));
    }
}
