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

require_once MAX_PATH . '/lib/xmlrpc/php/tests/integration/Common.api.php';

/**
 * A class for testing the User webservice API class
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Api_XmlRpc_User extends Test_OA_Api_XmlRpc
{
    /**
     * @var int
     */
    var $agencyId;

    /**
     * @var int
     */
    var $accountId;

    function Test_OA_Api_XmlRpc_User()
    {
        parent::Test_OA_Api_XmlRpc(false);
    }

    function setUp()
    {
		if (!$this->oApi) {
			return;
		}

		$oAgency = new OA_Dll_AgencyInfo();
		$oAgency->agencyName = 'test agency';
		$oAgency->password   = 'password';
		$agencyId = $this->oApi->addAgency($oAgency);

		$this->assertTrue($agencyId);

		$oAgency  = $this->oApi->getAgency($agencyId);

		$this->assertTrue($oAgency);
		$this->assertTrue($oAgency->accountId);

		$this->agencyId  = $oAgency->agencyId;
		$this->accountId = $oAgency->accountId;
    }

	function tearDown()
	{
		if (!$this->accountId) {
			return;
		}

		$this->assertTrue($this->oApi->deleteAgency($this->agencyId));
	}

	function _createUserInfo()
	{
	    static $i = 0;

		$oUser = new OA_Dll_UserInfo();
		$oUser->contactName      = 'test user '.++$i;
		$oUser->emailAddress     = 'test'.$i.'@example.com';
		$oUser->username         = 'foo_'.md5(uniqid('', true));
		$oUser->password         = uniqid('', true);
		$oUser->defaultAccountId = $this->accountId;
		$oUser->active           = 1;

		return $oUser;
	}

	function testAddModifyGetDelete()
	{
		if (!$this->accountId) {
			return;
		}

		$oUser = $this->_createUserInfo();
		$userId = $this->oApi->addUser($oUser);
		$this->assertTrue($userId);

		$oUser = new OA_Dll_UserInfo();
		$oUser->userId      = $userId;
		$oUser->emailAddress = 'modified@example.com';

		$this->assertTrue($this->oApi->modifyUser($oUser));

		$oUser = $this->oApi->getUser($userId);
		$this->assertIsA($oUser, 'OA_Dll_UserInfo');
		$this->assertEqual($oUser->emailAddress, 'modified@example.com');

		$this->assertTrue($this->oApi->deleteUser($userId));
	}

	function testGetUserListByAccountId()
	{
		if (!$this->accountId) {
			return;
		}

		$aUsers[0] = $this->_createUserInfo();
		$aUsers[0]->userId = $this->oApi->addUser($aUsers[0]);
		$this->assertTrue($aUsers[0]->userId);
		$aUsers[0]->password = null;

		$aUsers[1] = $this->_createUserInfo();
		$aUsers[1]->userId = $this->oApi->addUser($aUsers[1]);
		$this->assertTrue($aUsers[1]->userId);
		$aUsers[1]->password = null;

		$aUsers[2] = $this->_createUserInfo();
		$aUsers[2]->userId = $this->oApi->addUser($aUsers[2]);
		$this->assertTrue($aUsers[2]->userId);
		$aUsers[2]->password = null;

		$aUserList = $this->oApi->getUserListByAccountId($this->accountId);
		$this->assertEqual(count($aUserList), count($aUsers));

		uasort($aUsers, array($this, '_sortUserList'));
		uasort($aUserList, array($this, '_sortUserList'));

		$this->assertEqual($aUsers, $aUserList);

		foreach ($aUsers as $oUser) {
		    $this->assertTrue($this->oApi->deleteUser($oUser->userId));
		}
	}

    function testUpdateSsoUser()
    {
		if (!$this->accountId) {
			return;
		}

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'sso1-'.time();
        $doUsers->email = 'email@example'.time().'.com';
        $doUsers->sso_user_id = 123;
        $email = 'email@example.com';
        $this->assertTrue($userId = DataGenerator::generateOne($doUsers));

        $this->expectError();
        // Will trigger an Unknown ssoUserId error
        $this->assertFalse($this->oApi->updateSsoUserId(1001, 1002));

        $this->expectError();
        // Will trigger an Unknown ssoUserId error
        $this->assertFalse($this->oApi->updateUserEmailBySsoId(1001, $email));

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->user_id = $userId;
        $doUsers->sso_user_id = 1001;
        $doUsers->update();

        $this->assertTrue($this->oApi->updateSsoUserId(1001, 1002));
        $this->assertTrue($this->oApi->updateUserEmailBySsoId(1002, $email));
    }

    function testModifyWithSameUsername()
    {
		$oUser = $this->_createUserInfo();
		$oUser->userId = $this->oApi->addUser($oUser);
		$this->assertTrue($oUser->userId);

		$oUser->contactName = 'modified';
        $this->assertTrue($this->oApi->modifyUser($oUser));
    }

	function _sortUserList($a, $b)
	{
	    return $a->userId - $b->userId;
	}
}

?>