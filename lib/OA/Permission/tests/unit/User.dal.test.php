<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Permission/User.php';
require_once MAX_PATH . '/lib/OA/Permission/tests/util/TestErrorHandler.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';


/**
 * A class for testing the OA_Permission_User
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Test_OA_Permission_User extends UnitTestCase
{

    var $agencyId;
    var $accountId;
    var $userId;
    
    /**
     * The constructor method.
     */
    function Test_OA_Permission_User()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->_prepareTestData();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }
    
    /**
     * Method to prepare user connected to manager account
     *
     */
    function _prepareTestData() {
        $doAgency  = OA_DAL::factoryDO('agency');
        $this->agencyId  = DataGenerator::generateOne($doAgency);
        $doAgency   = OA_Dal::staticGetDO('agency', $this->agencyId);
        $this->accountId = $doAgency->account_id;
        $doUsers  = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $this->accountId;
        $doUsers->username = 'user1';
        $this->userId = DataGenerator::generateOne($doUsers);
    }
    
    /**
     * A method to test the class constructor.
     */
    function testOA_Task_Runner()
    {
        // Test constructor for user with non-existing account       
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        
        $doUsers   = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = -1;
        $oPermUser = new OA_Permission_User($doUsers);

        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Could not find the specified account'
        );
        $oTestErrorHandler->reset();
        // Unset the error handler
        PEAR::popErrorHandling();
        
        // Test for user with existing account
        $doUsers   = OA_Dal::staticGetDO('users', $this->userId);
        $oPermUser = new OA_Permission_User($doUsers);
        
        $this->assertTrue(is_object($oPermUser));
        $this->assertTrue(is_a($oPermUser, 'OA_Permission_User'));
        
        
    }

    /**
     * A method to test loadAccountData method
     */
    function testLoadAccountData()
    {
        $doUsers   = OA_Dal::staticGetDO('users', $this->userId);
        $oPermUser = new OA_Permission_User($doUsers);
        
        // Test non existing account
        
        // Set the error handling class' handleErrors() method as
        // the error handler for PHP for this test.
        $oTestErrorHandler = new TestErrorHandler();
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
        
        $oPermUser->loadAccountData(-1);
                        
        $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
        $this->assertEqual(
            $oTestErrorHandler->aErrors[0]->message,
            'Could not find the specified account'
        );
        // Unset the error handler
        PEAR::popErrorHandling();
        
        // Test manager account
        $oPermUser->loadAccountData($this->accountId);
        $this->assertEqual($oPermUser->aAccount["account_id"], $this->accountId);
        $this->assertEqual($oPermUser->aAccount["account_type"], OA_ACCOUNT_MANAGER);
    }
    
    /**
     * A method to test _clearAccountData method
     */
    function test_clearAccountData()
    {
        $doUsers   = OA_Dal::staticGetDO('users', $this->userId);
        $oPermUser = new OA_Permission_User($doUsers);
        
        // Test if all values in aAccount array are empty after clearing
        $oPermUser->_clearAccountData();
        foreach( $oPermUser->aAccount as $value) {
            $this->assertTrue(empty($value));
        }
    }
    
    /**
     * A method to test _getEntityId method
     */
    function test_getEntityId()
    {
        $doUsers   = OA_Dal::staticGetDO('users', $this->userId);
        $oPermUser = new OA_Permission_User($doUsers);      
        
        // Test if agency Id is returned
        $result = $oPermUser->_getEntityId();
        $this->assertEqual($result, $this->agencyId);
        
        // Test non existing account 
        $oPermUser->aAccount['account_id'] = -1;
        $this->assertFalse($oPermUser->_getEntityId());        
    }
    
    /**
     * A method to test _getAgencyId method
     */
    function test_getAgencyId()
    {
        // Get Agency it for advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $this->agencyId;
        $clientId  = DataGenerator::generateOne($doClients);
        
        $doClients   = OA_Dal::staticGetDO('clients', $clientId);
        $accountId = $doClients->account_id;
        
        $doUsers  = OA_Dal::factoryDO('users');
        $doUsers->username = 'user2';
        $doUsers->default_account_id = $accountId;
        $userId = DataGenerator::generateOne($doUsers);
        
        $oPermUser = new OA_Permission_User($doUsers);
        
        $this->assertEqual($oPermUser->_getAgencyId(), $this->agencyId);
    }
    
    /**
     * A method to test _isAdmin method
     */
    function test_isAdmin()
    {
        $doUsers   = OA_Dal::staticGetDO('users', $this->userId);
        $oPermUser = new OA_Permission_User($doUsers);

        // Tests non admin user
        $this->assertFalse($oPermUser->_isAdmin());

        // Make this user admin now
        OA_Dal_ApplicationVariables::get('admin_account_id',$this->accountId);
        $doAUA  = OA_Dal::factoryDO('account_user_assoc');
        $doAUA->account_id = $this->accountId;
        $doAUA->user_id = $this->userId;
        DataGenerator::generateOne($doAUA);
        $this->assertTrue($oPermUser->_isAdmin());
    }    
    /**
     * A method to test _getEntityDO method
     */
    function test_getEntityDO()
    {
        // Tests manager account
        $doUsers   = OA_Dal::staticGetDO('users', $this->userId);
        $oPermUser = new OA_Permission_User($doUsers);
        
        $result = $oPermUser->_getEntityDO();
        $this->assertTrue(is_a($result, 'DataObjects_Agency'));
        
        // Tests advertiser account
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $this->agencyId;
        $clientId  = DataGenerator::generateOne($doClients);
        
        $doClients   = OA_Dal::staticGetDO('clients', $clientId);
        $accountId = $doClients->account_id;
        
        $doUsers  = OA_Dal::factoryDO('users');
        $doUsers->username = 'user2';
        $doUsers->default_account_id = $accountId;
        $userId = DataGenerator::generateOne($doUsers);
        
        $oPermUser = new OA_Permission_User($doUsers);
        $result = $oPermUser->_getEntityDO();
        $this->assertTrue(is_a($result, 'DataObjects_Clients'));
        
        // Test trafficer account
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $this->agencyId;
        $affiliateId  = DataGenerator::generateOne($doAffiliates);
        
        $doAffiliates   = OA_Dal::staticGetDO('affiliates', $affiliateId);
        $accountId = $doAffiliates->account_id;
        
        $doUsers  = OA_Dal::factoryDO('users');
        $doUsers->username = 'user3';
        $doUsers->default_account_id = $accountId;
        $userId = DataGenerator::generateOne($doUsers);
        
        $oPermUser = new OA_Permission_User($doUsers);
        $result = $oPermUser->_getEntityDO();
        $this->assertTrue(is_a($result, 'DataObjects_Affiliates'));
        
        // Tests when no account data
        $oPermUser->_clearAccountData();
        $result = $oPermUser->_getEntityDO();
        $this->assertNull($result);
    }
}

?>
