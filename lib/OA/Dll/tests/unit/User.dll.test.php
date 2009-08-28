<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/OA/Dll/Agency.php';
require_once MAX_PATH . '/lib/OA/Dll/AgencyInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/User.php';
require_once MAX_PATH . '/lib/OA/Dll/UserInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL User methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 */


class OA_Dll_UserTest extends DllUnitTestCase
{
    /**
     * @var int
     */
    var $accountId;

    /**
     * The constructor method.
     */
    function OA_Dll_UserTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Agency',
            'PartialMockOA_Dll_Agency_UserTest',
            array('checkPermissions')
        );
        Mock::generatePartial(
            'OA_Dll_User',
            'PartialMockOA_Dll_User',
            array('checkPermissions')
        );
    }

    function setUp()
    {
        $agencyId = DataGenerator::generateOne('agency');
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        $this->accountId = (int)$doAgency->account_id;
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * A method to test Add, Modify and Delete.
     */
    function testAddModifyDelete()
    {
        $dllUserPartialMock = new PartialMockOA_Dll_User($this);

        $dllUserPartialMock->setReturnValue('checkPermissions', true);
        $dllUserPartialMock->expectCallCount('checkPermissions', 6);


        $oUserInfo = new OA_DLL_UserInfo();
        $oUserInfo2 = new OA_Dll_UserInfo();

        $oUserInfo->contactName         = 'test User';
        $oUserInfo->emailAddress        = 'test@example.com';
        $oUserInfo->username            = 'foo-'.time();
        $oUserInfo->password            = 'fooPwd';
        $oUserInfo->defaultAccountId    = $this->accountId;

        $oUserInfo2->contactName        = 'test User 2';
        $oUserInfo2->emailAddress       = 'test2@example.com';
        $oUserInfo2->username           = $oUserInfo->username;
        $oUserInfo2->password           = 'fooPwd';
        $oUserInfo2->defaultAccountId   = $this->accountId;

        // Add
        $this->assertTrue($dllUserPartialMock->modify($oUserInfo),
                          $dllUserPartialMock->getLastError());

        // Modify
        $oUserInfo->contactName = 'modified User';

        $this->assertTrue($dllUserPartialMock->modify($oUserInfo),
                          $dllUserPartialMock->getLastError());

        // Add a user with the same username
        $this->assertTrue((!$dllUserPartialMock->modify($oUserInfo2) &&
                          $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_USERNAME_NOT_UNIQUE),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_USERNAME_NOT_UNIQUE));

        // Delete
        $this->assertTrue($dllUserPartialMock->delete($oUserInfo->userId),
            $dllUserPartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllUserPartialMock->modify($oUserInfo) &&
                          $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_UNKNOWN_USER_ID),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_UNKNOWN_USER_ID));

        // Delete not existing id
        $this->assertTrue((!$dllUserPartialMock->delete($oUserInfo->userId) &&
                           $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_UNKNOWN_USER_ID),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_UNKNOWN_USER_ID));

        $dllUserPartialMock->tally();
    }


    /**
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllUserPartialMock = new PartialMockOA_Dll_User($this);
        $dllAgencyPartialMock     = new PartialMockOA_Dll_Agency_UserTest($this);

        $dllAgencyPartialMock->setReturnValue('checkPermissions', true);
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 1);

        $dllUserPartialMock->setReturnValue('checkPermissions', true);
        $dllUserPartialMock->expectCallCount('checkPermissions', 7);

        $oAgencyInfo             = new OA_Dll_AgencyInfo();
        $oAgencyInfo->agencyName = 'agency name';
        $oAgencyInfo->password   = 'password';
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        $oUserInfo1                     = new OA_Dll_UserInfo();
        $oUserInfo1->contactName        = 'test name 1';
        $oUserInfo1->emailAddress       = 'name@domain.com';
        $oUserInfo1->username           = 'user1-'.time();
        $oUserInfo1->password           = 'pwd';
        $oUserInfo1->defaultAccountId   = $oAgencyInfo->accountId;

        $oUserInfo2                     = new OA_Dll_UserInfo();
        $oUserInfo2->contactName        = 'test name 2';
        $oUserInfo2->emailAddress       = 'name@domain.com';
        $oUserInfo2->username           = 'user2'.time();
        $oUserInfo2->password           = 'pwd';
        $oUserInfo2->defaultAccountId   = $oAgencyInfo->accountId;

        // Add
        $this->assertTrue($dllUserPartialMock->modify($oUserInfo1),
                          $dllUserPartialMock->getLastError());

        $this->assertTrue($dllUserPartialMock->modify($oUserInfo2),
                          $dllUserPartialMock->getLastError());

        $oUserInfo1Get = null;
        $oUserInfo2Get = null;
        // Get
        $this->assertTrue($dllUserPartialMock->getUser($oUserInfo1->userId,
                                                                   $oUserInfo1Get),
                          $dllUserPartialMock->getLastError());
        $this->assertTrue($dllUserPartialMock->getUser($oUserInfo2->userId,
                                                                   $oUserInfo2Get),
                          $dllUserPartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oUserInfo1, $oUserInfo1Get, 'contactName');
        $this->assertFieldEqual($oUserInfo1, $oUserInfo1Get, 'emailAddress');
        $this->assertFieldEqual($oUserInfo1, $oUserInfo1Get, 'username');
        $this->assertFieldEqual($oUserInfo1, $oUserInfo1Get, 'defaultAccountId');

        $this->assertFieldEqual($oUserInfo2, $oUserInfo2Get, 'contactName');
        $this->assertFieldEqual($oUserInfo2, $oUserInfo2Get, 'emailAddress');
        $this->assertFieldEqual($oUserInfo2, $oUserInfo2Get, 'username');
        $this->assertFieldEqual($oUserInfo2, $oUserInfo2Get, 'defaultAccountId');

        // Get List
        $aUserList = array();
        $this->assertTrue($dllUserPartialMock->getUserListByAccountId($oAgencyInfo->accountId,
                                                                                 $aUserList),
                          $dllUserPartialMock->getLastError());
        $this->assertEqual(count($aUserList) == 2,
                           '2 records should be returned');
        $oUserInfo1Get = $aUserList[0];
        $oUserInfo2Get = $aUserList[1];
        if ($oUserInfo1->userId == $oUserInfo2Get->userId) {
            $oUserInfo1Get = $aUserList[1];
            $oUserInfo2Get = $aUserList[0];
        }
        // Check field value from list
        $this->assertFieldEqual($oUserInfo1, $oUserInfo1Get, 'username');
        $this->assertFieldEqual($oUserInfo2, $oUserInfo2Get, 'username');


        // Delete
        $this->assertTrue($dllUserPartialMock->delete($oUserInfo1->userId),
            $dllUserPartialMock->getLastError());

        // Get not existing id
        $this->assertTrue((!$dllUserPartialMock->getUser($oUserInfo1->userId,
                                                                     $oUserInfo1Get) &&
                          $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_UNKNOWN_USER_ID),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_UNKNOWN_USER_ID));

        $dllAgencyPartialMock->tally();
        $dllUserPartialMock->tally();
    }

    function testUpdateUserEmailBySsoId()
    {
        $dllUserPartialMock = new PartialMockOA_Dll_User($this);

        $dllUserPartialMock->setReturnValue('checkPermissions', true);
        $dllUserPartialMock->expectCallCount('checkPermissions', 4);

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'sso1-'.time();
        $doUsers->sso_user_id = 1;
        $this->assertTrue($userId = DataGenerator::generateOne($doUsers));

        $this->assertFalse($dllUserPartialMock->updateUserEmailBySsoId(1001, 'email@example.com'));

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->user_id = $userId;
        $doUsers->sso_user_id = 1001;
        $doUsers->update();

        $this->assertTrue($dllUserPartialMock->updateUserEmailBySsoId(1001, 'email@example.com'),
                          $dllUserPartialMock->getLastError());

        // Test errors
        $this->assertTrue((!$dllUserPartialMock->updateSsoUserId(0, 'email@example.com') &&
                          $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_WRONG_PARAMS),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_WRONG_PARAMS));

        $this->assertTrue((!$dllUserPartialMock->updateSsoUserId(1, '') &&
                          $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_WRONG_PARAMS),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_WRONG_PARAMS));

        $dllUserPartialMock->tally();
    }

    function testUpdateSsoUserId()
    {
        $dllUserPartialMock = new PartialMockOA_Dll_User($this);

        $dllUserPartialMock->setReturnValue('checkPermissions', true);
        $dllUserPartialMock->expectCallCount('checkPermissions', 4);

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'sso1-'.time();
        $doUsers->sso_user_id = 0;
        $this->assertTrue($userId = DataGenerator::generateOne($doUsers));

        $this->assertFalse($dllUserPartialMock->updateSsoUserId(1001, 1002));

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->user_id = $userId;
        $doUsers->sso_user_id = 1001;
        $doUsers->update();

        $this->assertTrue($dllUserPartialMock->updateSsoUserId(1001, 1002),
                          $dllUserPartialMock->getLastError());

        // Test errors
        $this->assertTrue((!$dllUserPartialMock->updateSsoUserId(0, 1) &&
                          $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_WRONG_PARAMS),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_WRONG_PARAMS));

        $this->assertTrue((!$dllUserPartialMock->updateSsoUserId(1, 0) &&
                          $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_WRONG_PARAMS),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_WRONG_PARAMS));

        $dllUserPartialMock->tally();
    }

    function testLinkUser()
    {
        $dllUserPartialMock = new PartialMockOA_Dll_User($this);
        $dllUserPartialMock->setReturnValue('checkPermissions', true);

        // create user
        $userId = DataGenerator::generateOne('users');

        // Invalid advertiser account
        $this->assertTrue((!$dllUserPartialMock->linkUserToAdvertiserAccount($userId, 9999) &&
            $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_UNKNOWN_ACC_ID),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_UNKNOWN_ACC_ID));
        
        // Create advertiser
        $advertiserId = DataGenerator::generateOne('clients');
        $doAdvertiser = OA_Dal::staticGetDO('clients', $advertiserId);
        $advertiserAccountId = $doAdvertiser->account_id;
        $aAdvertiserPermissions = array(OA_PERM_SUPER_ACCOUNT, OA_PERM_BANNER_EDIT,
            OA_PERM_BANNER_DEACTIVATE, OA_PERM_BANNER_ACTIVATE, OA_PERM_USER_LOG_ACCESS);

        // Invalid user 
        $this->assertTrue((!$dllUserPartialMock->linkUserToAdvertiserAccount(9999, $advertiserAccountId) &&
            $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_UNKNOWN_USER_ID),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_UNKNOWN_USER_ID));
        
        // linkUserToAdvertiserAccount
        $this->assertTrue($dllUserPartialMock->linkUserToAdvertiserAccount(
            $userId, $advertiserAccountId, $aAdvertiserPermissions));

        // Check the link was made
        $this->assertLink($userId, $advertiserAccountId);

        // Check the correct permissions were added
        $this->assertPermissions($userId, $advertiserAccountId, $aAdvertiserPermissions);

        // Re-link should not give an error
        $this->assertTrue($dllUserPartialMock->linkUserToAdvertiserAccount(
            $userId, $advertiserAccountId, $aAdvertiserPermissions));

        // linkUserToTraffickerAccount
        $websiteId = DataGenerator::generateOne('affiliates');
        $doWebsite = OA_Dal::staticGetDO('affiliates', $websiteId);
        $traffickerAccountId = $doWebsite->account_id;
        $aTraffickerPermissions = array(OA_PERM_SUPER_ACCOUNT, OA_PERM_ZONE_EDIT,
            OA_PERM_ZONE_ADD, OA_PERM_ZONE_DELETE, OA_PERM_ZONE_LINK,
            OA_PERM_ZONE_INVOCATION, OA_PERM_USER_LOG_ACCESS);
        $this->assertTrue($dllUserPartialMock->linkUserToTraffickerAccount(
            $userId, $traffickerAccountId, $aTraffickerPermissions));

        $this->assertLink($userId, $traffickerAccountId);
        $this->assertPermissions($userId, $traffickerAccountId, $aTraffickerPermissions);

        // linkUserToManagerAccount
        $agencyId = DataGenerator::generateOne('agency');
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        $managerAccountId = $doAgency->account_id;
        $aManagerPermissions = array(OA_PERM_SUPER_ACCOUNT);
        $this->assertTrue($dllUserPartialMock->linkUserToManagerAccount(
            $userId, $managerAccountId, $aManagerPermissions));

        $this->assertLink($userId, $managerAccountId);
        $this->assertPermissions($userId, $traffickerAccountId, $aManagerPermissions);

        // Link to the wrong types of accounts
        $this->assertTrue((!$dllUserPartialMock->linkUserToAdvertiserAccount($userId, $managerAccountId) &&
            $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_ACCOUNT_TYPE_MISMATCH),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_ACCOUNT_TYPE_MISMATCH));

        $this->assertTrue((!$dllUserPartialMock->linkUserToTraffickerAccount($userId, $advertiserAccountId) &&
            $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_ACCOUNT_TYPE_MISMATCH),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_ACCOUNT_TYPE_MISMATCH));

        $this->assertTrue((!$dllUserPartialMock->linkUserToManagerAccount($userId, $advertiserAccountId) &&
            $dllUserPartialMock->getLastError() == OA_Dll_User::ERROR_ACCOUNT_TYPE_MISMATCH),
            $this->_getMethodShouldReturnError(OA_Dll_User::ERROR_ACCOUNT_TYPE_MISMATCH));
    }

    private function assertLink($userId, $accountId)
    {
        $doAua = OA_Dal::factoryDO('account_user_assoc');
        $doAua->account_id = $accountId;
        $doAua->user_id = $userId;

        $expectedRows = 1;
        $actualRows = $doAua->find();
        $this->assertEqual($expectedRows, $actualRows);
    }

    private function assertPermissions($userId, $accountId, $aPermissions)
    {
        foreach ($aPermissions as $permissionId) {
            $doAupa = OA_Dal::factoryDO('account_user_permission_assoc');
            $doAupa->account_id = $accountId;
            $doAupa->user_id = $userId;
            $doAupa->permission_id = $permissionId;
            $expectedRows = 1;
            $actualRows = $doAupa->find();
            $this->assertEqual($expectedRows, $actualRows);
        }
    }

}

?>
