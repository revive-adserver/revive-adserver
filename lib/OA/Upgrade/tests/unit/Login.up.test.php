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

require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Login.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

class Test_OA_Upgrade_Login extends UnitTestCase
{
    private array $originalSession;
    private array $originalCookies;
    private $originalAdminAccountId;
    private int $adminAccountId;
    private int $userId;

    public function setUp()
    {
        $this->originalSession = $GLOBALS['session'] ?? [];
        $this->originalCookies = $_COOKIE;
        $this->originalAdminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');
        $account = OA_Dal::factoryDO('accounts');
        $account->account_type = OA_ACCOUNT_ADMIN;
        $this->adminAccountId = DataGenerator::generateOne($account);
        OA_Dal_ApplicationVariables::set('admin_account_id', $this->adminAccountId);
        // An unrelated administrator must never be selected as a fallback.
        $this->createUser('other-admin');
        $this->userId = $this->createUser('migrated-admin');
        phpAds_clearSession();
        $_COOKIE['sessionID'] = bin2hex(random_bytes(16));
        $GLOBALS['session']['installer-state'] = ['database' => true];
        $GLOBALS['session'][OA_Upgrade_Login::SESSION_PASSWORD_HASH] = \RV\Manager\PasswordManager::getPasswordHash('legacy-password');
    }

    public function tearDown()
    {
        DataGenerator::cleanUp(['session']);
        if ($this->originalAdminAccountId === null) {
            OA_Dal_ApplicationVariables::delete('admin_account_id');
        } else {
            OA_Dal_ApplicationVariables::set('admin_account_id', $this->originalAdminAccountId);
        }
        $GLOBALS['session'] = $this->originalSession;
        $_COOKIE = $this->originalCookies;
    }

    private function createUser(string $username): int
    {
        $user = OA_Dal::factoryDO('users');
        $user->username = $username;
        $user->default_account_id = $this->adminAccountId;
        $user->password = md5('legacy-password');
        $userId = DataGenerator::generateOne($user);
        $association = OA_Dal::factoryDO('account_user_assoc');
        $association->user_id = $userId;
        $association->account_id = $this->adminAccountId;
        DataGenerator::generateOne($association);
        return $userId;
    }

    private function legacySession(string $username = 'migrated-admin'): void
    {
        $user = OA_Dal::factoryDO('users');
        $user->user_id = -1;
        $user->username = $username;
        $GLOBALS['session']['user'] = OA_Auth::getSessionData($user, true)['user'];
        $GLOBALS['session']['user']->aAccount['account_type'] = OA_ACCOUNT_ADMIN;
    }

    public function testUpgradesLegacySessionAndRestoresItWithNormalPermissionChecks()
    {
        $this->legacySession();
        phpAds_SessionDataStore();
        $oldId = $_COOKIE['sessionID'];

        $this->assertTrue(OA_Upgrade_Login::upgradeSession());
        $this->assertNotEqual($_COOKIE['sessionID'], $oldId);
        $this->assertFalse(OA_Dal::staticGetDO('session', $oldId));

        // Fetch without the installer exemption, as the AJAX job endpoints do.
        $this->assertFalse(defined('phpAds_installing'));
        phpAds_clearSession();
        phpAds_SessionDataFetch();
        $this->assertTrue(OA_Auth::isLoggedIn());
        $this->assertEqual(OA_Permission::getUserId(), $this->userId);
        $this->assertTrue(OA_Permission::isUserLinkedToAdmin());
        $this->assertEqual($GLOBALS['session']['installer-state'], ['database' => true]);
        $this->assertFalse(isset($GLOBALS['session'][OA_Upgrade_Login::SESSION_PASSWORD_HASH]));
        $record = OA_Dal::staticGetDO('session', $_COOKIE['sessionID']);
        $this->assertEqual($record->user_id, $this->userId);
        $user = OA_Dal::staticGetDO('users', $this->userId);
        $this->assertTrue(\RV\Manager\PasswordManager::verifyPassword('legacy-password', $user->password));
        $otherUser = OA_Dal::staticGetDO('users', 'username', 'other-admin');
        $this->assertEqual($otherUser->password, md5('legacy-password'));
        $plugin = new Plugins_Authentication();
        $authenticated = $plugin->checkPassword('migrated-admin', 'legacy-password', false);
        $this->assertIsA($authenticated, DataObjects_Users::class);
        $this->assertTrue($authenticated && !$authenticated->isResetRequired());
    }

    public function testRefreshesExistingUserFromDatabase()
    {
        $user = OA_Dal::staticGetDO('users', $this->userId);
        $GLOBALS['session']['user'] = OA_Auth::getSessionData($user)['user'];
        $GLOBALS['session']['user']->aUser['username'] = 'stale-username';
        $this->assertTrue(OA_Upgrade_Login::upgradeSession());
        $this->assertEqual(OA_Permission::getUserId(), $this->userId);
        $this->assertEqual($GLOBALS['session']['user']->aUser['username'], 'migrated-admin');
    }

    public function testFindsLowercaseUsernameCreatedByUserMigration()
    {
        $this->legacySession('Migrated-Admin');
        $this->assertTrue(OA_Upgrade_Login::upgradeSession());
        $this->assertEqual(OA_Permission::getUserId(), $this->userId);
    }

    public function testPreservesModernHashWhenNoPasswordUpgradeIsPending()
    {
        $passwordHash = $GLOBALS['session'][OA_Upgrade_Login::SESSION_PASSWORD_HASH];
        unset($GLOBALS['session'][OA_Upgrade_Login::SESSION_PASSWORD_HASH]);
        $user = OA_Dal::staticGetDO('users', $this->userId);
        $user->password = $passwordHash;
        $user->update();
        $GLOBALS['session']['user'] = OA_Auth::getSessionData($user)['user'];

        $this->assertTrue(OA_Upgrade_Login::upgradeSession());
        $user = OA_Dal::staticGetDO('users', $this->userId);
        $this->assertEqual($user->password, $passwordHash);
    }

    public function testDoesNotFallBackToAnotherAdministrator()
    {
        foreach (['missing-admin', ''] as $username) {
            $this->legacySession($username);
            $oldId = $_COOKIE['sessionID'];
            $this->assertFalse(OA_Upgrade_Login::upgradeSession());
            $this->assertEqual($_COOKIE['sessionID'], $oldId);
            $this->assertEqual(OA_Permission::getUserId(), -1);
        }
    }

    public function testRejectsUserWithoutAdministratorAssociation()
    {
        $this->legacySession();
        $association = OA_Dal::factoryDO('account_user_assoc');
        $association->user_id = $this->userId;
        $association->delete();
        $this->assertFalse(OA_Upgrade_Login::upgradeSession());
        $this->assertEqual(OA_Permission::getUserId(), -1);
        $user = OA_Dal::staticGetDO('users', $this->userId);
        $this->assertEqual($user->password, md5('legacy-password'));
    }

    public function testRequiresAuthenticatedUiSession()
    {
        $this->assertFalse(OA_Upgrade_Login::upgradeSession());
        $user = OA_Dal::staticGetDO('users', $this->userId);
        $GLOBALS['session']['user'] = OA_Auth::getSessionData($user, false, \RV\Auth\AuthContext::API)['user'];
        $this->assertFalse(OA_Upgrade_Login::upgradeSession());
        $this->assertEqual($GLOBALS['session']['user']->context, \RV\Auth\AuthContext::API);
    }
}
