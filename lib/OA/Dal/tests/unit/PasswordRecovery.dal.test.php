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

require_once MAX_PATH . '/lib/OA/Dal/PasswordRecovery.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

use RV\Manager\PasswordManager;

/**
 * A class for testing the OA_Dal_ApplicationVariables class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_PasswordRecovery extends UnitTestCase
{
    public function testGetUserFromRecoveryId()
    {
        $oPasswordRecovery = new OA_Dal_PasswordRecovery();

        /** @var DataObjects_Users $doUsers */
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'user_old';
        $doUsers->password = md5('foo');
        $userIdOld = DataGenerator::generateOne($doUsers);

        /** @var DataObjects_Users $doUsers */
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'user_new';
        $doUsers->password = PasswordManager::getPasswordHash('foo');
        $userIdNew = DataGenerator::generateOne($doUsers);

        $this->assertNull($oPasswordRecovery->getUserFromRecoveryId(''));

        /** @var DataObjects_Password_recovery $doPwdRecoveryOld */
        $doPwdRecoveryOld = OA_Dal::factoryDO('password_recovery');
        $doPwdRecoveryOld->user_type = 'user';
        $doPwdRecoveryOld->user_id = $userIdOld;
        $doPwdRecoveryOld->recovery_id = 'foo';
        $doPwdRecoveryOld->updated = (new \DateTimeImmutable('-8 days', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        $doPwdRecoveryOld->insert();

        /** @var DataObjects_Password_recovery $doPwdRecoveryNew */
        $doPwdRecoveryNew = OA_Dal::factoryDO('password_recovery');
        $doPwdRecoveryNew->user_type = 'user';
        $doPwdRecoveryNew->user_id = $userIdNew;
        $doPwdRecoveryNew->recovery_id = 'bar';
        $doPwdRecoveryNew->updated = (new \DateTimeImmutable('-5 hours', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        $doPwdRecoveryNew->insert();

        $this->assertNull($oPasswordRecovery->getUserFromRecoveryId('foo'));
        $this->assertNull($oPasswordRecovery->getUserFromRecoveryId('bar'));

        $doPwdRecoveryOld->updated = (new \DateTimeImmutable('-6 days', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        $doPwdRecoveryOld->update();

        $doUsers = $oPasswordRecovery->getUserFromRecoveryId('foo');

        $this->assertIsA($doUsers, DataObjects_Users::class);
        $this->assertEqual($doUsers->user_id, $userIdOld);

        $doPwdRecoveryNew->updated = (new \DateTimeImmutable('-3 hours', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        $doPwdRecoveryNew->update();

        $doUsers = $oPasswordRecovery->getUserFromRecoveryId('bar');

        $this->assertIsA($doUsers, DataObjects_Users::class);
        $this->assertEqual($doUsers->user_id, $userIdNew);
    }
}
