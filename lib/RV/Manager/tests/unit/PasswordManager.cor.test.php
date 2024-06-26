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

require_once MAX_PATH . '/lib/max/Dal/DataObjects/Users.php';


class Test_RV_Manager_PasswordManager extends UnitTestCase
{
    public function __construct($label = false)
    {
        parent::__construct($label);

        Mock::generatePartial(
            'DataObjects_Users',
            'PartialMockDataObjects_Users',
            ['update'],
        );
    }

    public function testPasswordHash()
    {
        // Bcrypt len is fixed
        $this->assertEqual(60, strlen(\RV\Manager\PasswordManager::getPasswordHash('foo')));
    }

    public function testVerifyPassword()
    {
        $this->assertFalse(\RV\Manager\PasswordManager::verifyPassword('foo', '$1a$10$OZe5LhPJaaKGlCZvR8sNteY.aWZXvrLbQRSguIOM1nsqUegaRfgx2'));
        $this->assertFalse(\RV\Manager\PasswordManager::verifyPassword('foo', '$2y$9$OZe5LhPJaaKGlCZvR8sNteY.aWZXvrLbQRSguIOM1nsqUegaRfgx2'));
        $this->assertFalse(\RV\Manager\PasswordManager::verifyPassword('foo', '$2y$10$OZe5LhPJaaKGlCZvR8sNteY.aWZXvrLbQRSguIOM1nsqUegaRfgx3'));
        $this->assertFalse(\RV\Manager\PasswordManager::verifyPassword('bar', '$2y$10$OZe5LhPJaaKGlCZvR8sNteY.aWZXvrLbQRSguIOM1nsqUegaRfgx2'));

        $this->assertTrue(\RV\Manager\PasswordManager::verifyPassword('foo', '$2y$10$OZe5LhPJaaKGlCZvR8sNteY.aWZXvrLbQRSguIOM1nsqUegaRfgx2'));
    }

    public function testNeedsRehash()
    {
        $doUser = new PartialMockDataObjects_Users($this);

        $doUser->password = \password_hash('foo', PASSWORD_BCRYPT);
        $this->assertFalse(\RV\Manager\PasswordManager::needsRehash($doUser));

        $doUser->password = \password_hash('foo', PASSWORD_BCRYPT, ['cost' => 4]);
        $this->assertTrue(\RV\Manager\PasswordManager::needsRehash($doUser));
    }

    public function testUpdateHash()
    {
        /** @var DataObjects_Users $doUser */
        $doUser = new PartialMockDataObjects_Users($this);
        $doUser->expectCallCount('update', 1);

        $doUser->password = \password_hash('foo', PASSWORD_BCRYPT, ['cost' => 4]);
        \RV\Manager\PasswordManager::updateHash($doUser, 'foo');

        $doUser->tally();
    }
}
