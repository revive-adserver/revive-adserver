<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Accounts methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class DataObjects_AccoutnsTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_AccoutnsTest()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Test method _relinkOrDeleteUsers
     */
    function test_relinkOrDeleteUsers()
    {
        // Insert an agency
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId = DataGenerator::generateOne($doAgency);
        $managerAccountId = DataGenerator::getReferenceId('accounts');
        
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId);
        $managerAccountId = $doAgency->account_id;
        
        // Create admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        
        // Create user linked to admin account
        // Default account for this user is set to manager account
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $managerAccountId;
        $doUsers->username = 'admin';
        $adminUserID = DataGenerator::generateOne($doUsers);

        $doAccountsUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccountsUserAssoc->account_id = $adminAccountId;
        $doAccountsUserAssoc->user_id = $adminUserID;
        DataGenerator::generateOne($doAccountsUserAssoc);

        // Create manager user
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $managerAccountId;
        $doUsers->username = 'manager';
        $managerUserID = DataGenerator::generateOne($doUsers);

        // Now delete Agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agencyid = $agencyId;
        $doAgency->onDeleteCascade = false; // Disable cascade delete
        $doAgency->delete();
        
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->get($managerAccountId);
        // Relink / Delete users here
        $doAccounts->_relinkOrDeleteUsers(); 
        
        // Test: admin user exists, linked to admin account
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->user_id = $adminUserID;
        $doUsers->find();
        $this->assertTrue($doUsers->fetch());
        $this->assertEqual($doUsers->default_account_id, $adminAccountId);
        
        // Test: manager users is deleted
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->user_id = $managerUserID;
        $doUsers->find();
        $this->assertFalse($doUsers->fetch());
        
    }

}
?>