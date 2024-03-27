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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Users methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_UsersTest extends DalUnitTestCase
{
    public $userId;

    public function setUp()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->contact_name = 'foo';
        $doUsers->username = 'Foo';
        $oDate = new Date();
        $doUsers->date_created = $doUsers->formatDate($oDate);
        $this->userId = DataGenerator::generateOne($doUsers);
        $this->assertTrue($this->userId);
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Creates user and set
     *
     * @param DataObject $doUsers
     * @param integer $cUsers
     * @return array | integer  Array of users ids or one user id
     *                          if only one record was created
     */
    public function createUser($doUsers = null, $cUsers = 1)
    {
        static $userCounter = 0;
        if (!$doUsers) {
            $doUsers = OA_Dal::factoryDO('users');
        }
        $aUsersIds = [];
        for ($i = 1; $i <= $cUsers; $i++) {
            if (empty($doUsers->username)) {
                $doUsers->username = 'test' . ++$userCounter;
            }
            $aUsersIds[] = DataGenerator::generateOne($doUsers);
        }
        if ($cUsers == 1) {
            return $aUsersIds[0];
        }
        return $aUsersIds;
    }

    public function testInsert()
    {
        $doUsers = OA_Dal::staticGetDO('users', $this->userId);
        $this->assertEqual($doUsers->username, 'foo');
    }

    public function testUpdate()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->user_id = $this->userId;
        $doUsers->username = 'Bar';
        $this->assertTrue($doUsers->update());

        $doUsers = OA_Dal::staticGetDO('users', $this->userId);
        $this->assertEqual($doUsers->username, 'bar');
    }

    public function testUserExists()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $this->assertTrue($doUsers->userExists('foo'));
        $this->assertTrue($doUsers->userExists('Foo'));
        $this->assertTrue($doUsers->userExists('FOO'));
    }

    public function testLogDateLastLogIn()
    {
        $userId = DataGenerator::generateOne('users');
        $now = new Date();
        $doUsers = OA_Dal::staticGetDO('users', $userId);
        $doUsers->logDateLastLogIn($now);
        $doUsers = OA_Dal::staticGetDO('users', $userId);
        $nowFormatted = $doUsers->formatDate($now);
        $this->assertEqual($doUsers->date_last_login, $nowFormatted);
    }

    public function _checkIfPermissionsExists($permissionsToCheck, $aNewPermissions)
    {
        foreach ($permissionsToCheck as $accountId => $aPermissions) {
            foreach ($aPermissions as $permissionId) {
                $this->assertTrue(
                    isset($aNewPermissions[$accountId][$permissionId]),
                    'Permission id(' . $permissionId . ') in account id(' . $accountId . ') is not set'
                );
            }
        }
    }

    public function _setAccountsAndPermissions($userId, $accountPermissions)
    {
        foreach ($accountPermissions as $accountId => $aPermissions) {
            OA_Permission::setAccountAccess($accountId, $userId);
            OA_Permission::storeUserAccountsPermissions($aPermissions, $accountId, $userId);
        }
    }
}
