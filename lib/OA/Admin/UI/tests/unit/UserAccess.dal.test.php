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
    private $savedSecurity;
    private $accountId;

    public function setUp()
    {
        $this->savedSession = $GLOBALS['session'] ?? [];
        $this->savedCookies = $_COOKIE;
        $this->savedSecurity = $GLOBALS['_MAX']['CONF']['security'];
        $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = false;
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
        $GLOBALS['_MAX']['CONF']['security'] = $this->savedSecurity;
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
        foreach ([false, true] as $allowLinkingExistingUsers) {
            $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = $allowLinkingExistingUsers;
            $controller = $this->controller('new user');
            $controller->process();
            $this->assertEqual($controller->aErrors, [$GLOBALS['strInvalidUsername']]);
            $this->assertFalse(OA_Permission::userNameExists('new user'));
        }
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

    public function testExistingUserSafeguard()
    {
        $userId = DataGenerator::generateOne('users');
        $controller = $this->controller('existing-user', $userId);

        // Administrators can link users without enabling the bypass.
        $this->assertTrue($controller->canLinkExistingUser());
        $GLOBALS['session']['user']->aUser['is_admin'] = false;
        $GLOBALS['session']['user']->aAccount['account_type'] = OA_ACCOUNT_MANAGER;

        // Missing settings in older configurations must also preserve the safeguard.
        unset($GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers']);
        $this->assertFalse($controller->canLinkExistingUser());
        $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = false;
        $this->assertFalse($controller->canLinkExistingUser());

        // Being linked to another account in the same manager realm is insufficient.
        $doClients = OA_Dal::factoryDO('clients');
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->account_id = $this->accountId;
        $doAgency->find(true);
        $doClients->agencyid = $doAgency->agencyid;
        $clientId = DataGenerator::generateOne($doClients);
        $clientAccountId = OA_Dal::staticGetDO('clients', $clientId)->account_id;
        OA_Permission::setAccountAccess($clientAccountId, $userId);
        $this->assertFalse($controller->canLinkExistingUser());

        $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = true;
        $this->assertTrue($controller->canLinkExistingUser());

        foreach ([OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER] as $accountType) {
            $GLOBALS['session']['user']->aAccount['account_type'] = $accountType;
            $this->assertFalse($controller->canLinkExistingUser());
        }
        $GLOBALS['session']['user']->aAccount['account_type'] = OA_ACCOUNT_MANAGER;

        // Existing links can still be edited with the safeguard enabled.
        $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = false;
        OA_Permission::setAccountAccess($this->accountId, $userId);
        $this->assertTrue($controller->canLinkExistingUser());
    }

    public function testManagerCanLinkExistingUserWithBypass()
    {
        $GLOBALS['session']['user']->aUser['is_admin'] = false;
        $GLOBALS['session']['user']->aAccount['account_type'] = OA_ACCOUNT_MANAGER;
        $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = true;
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'existing-user';
        $doUsers->email_address = 'legacy@example.com';
        $doUsers->is_admin = 0;
        $userId = DataGenerator::generateOne($doUsers);
        $controller = $this->controller('existing-user', $userId);

        $this->assertFalse(OA_Permission::isUserLinkedToAccount($this->accountId, $userId));
        $redirected = false;
        try {
            $controller->process();
        } catch (UserAccessTestRedirect $e) {
            $redirected = true;
        }
        $this->assertTrue($redirected);
        $this->assertEqual($controller->aErrors, []);
        $this->assertTrue(OA_Permission::isUserLinkedToAccount($this->accountId, $userId));

        // The bypass must not skip verification of the submitted user identity.
        $controller->request['email_address'] = 'different@example.com';
        $controller->process();
        $this->assertEqual($controller->aErrors, ['Invalid user data provided']);
    }

    public function testAutocompleteBypassIsLimitedToManagersWithPermission()
    {
        $userId = DataGenerator::generateOne('users');
        $GLOBALS['session']['user']->aUser['user_id'] = $userId;
        $GLOBALS['session']['user']->aUser['is_admin'] = false;
        $GLOBALS['session']['user']->aAccount['account_id'] = $this->accountId;
        $GLOBALS['session']['user']->aAccount['account_type'] = OA_ACCOUNT_MANAGER;

        unset($GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers']);
        $this->assertFalse(OA_Admin_UI_UserAccess::canSearchAllUsers());
        $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = true;
        $this->assertFalse(OA_Admin_UI_UserAccess::canSearchAllUsers());

        OA_Permission::storeUserAccountsPermissions([OA_PERM_SUPER_ACCOUNT], $this->accountId, $userId);
        $this->assertTrue(OA_Admin_UI_UserAccess::canSearchAllUsers());
        $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = false;
        $this->assertFalse(OA_Admin_UI_UserAccess::canSearchAllUsers());

        foreach ([false, true] as $allowLinkingExistingUsers) {
            $GLOBALS['_MAX']['CONF']['security']['allowLinkingExistingUsers'] = $allowLinkingExistingUsers;
            foreach ([OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER] as $accountType) {
                $GLOBALS['session']['user']->aAccount['account_type'] = $accountType;
                $this->assertFalse(OA_Admin_UI_UserAccess::canSearchAllUsers());
            }
            $GLOBALS['session']['user']->aAccount['account_type'] = OA_ACCOUNT_ADMIN;
            $this->assertTrue(OA_Admin_UI_UserAccess::canSearchAllUsers());
        }
    }
}
