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
 * A class for testing non standard DataObjects_Agency methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_AgencyTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_AgencyTest()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testInsert()
    {
        // Insert an agency
        // Include a username and password to also generate a linked user.
        $agencyName = 'Agency name';
        $agencyContact = 'Agency contact';
        $agencyContactEmail = 'agencycontact@example.com';
        $username = 'username';
        $password = 'password';

        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = $agencyName;
        $doAgency->contact = $agencyContact;
        $doAgency->email = $agencyContactEmail;
        $doAgency->username = $username;
        $doAgency->password = $password;

        $agencyId = $doAgency->insert();

        $doAgencyResult = OA_Dal::factoryDO('agency');
        $doAgencyResult->get($agencyId);

        $this->assertEqual($doAgencyResult->getRowCount(), 1);
        $this->assertEqual($agencyName, $doAgencyResult->name);
        $this->assertEqual($agencyContact, $doAgencyResult->contact);
        $this->assertEqual($agencyContactEmail, $doAgencyResult->email);
        
        $doAccountUserPermissionAssocResult = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccountUserPermissionAssocResult->find(true);
        
        $doUsersResult = OA_Dal::factoryDO('users');
        $doUsersResult->username = $username;
        $doUsersResult->find(true);
        
        $this->assertEqual(1, $doUsersResult->getRowCount());
        $this->assertEqual($password, $doUsersResult->password);
        
        $this->assertEqual(1, $doAccountUserPermissionAssocResult->getRowCount());
        $this->assertEqual($doAgencyResult->account_id, $doAccountUserPermissionAssocResult->account_id);
        $this->assertEqual($doUsersResult->user_id, $doAccountUserPermissionAssocResult->user_id);
        $this->assertEqual(OA_PERM_SUPER_ACCOUNT, $doAccountUserPermissionAssocResult->permission_id);
        $this->assertEqual(1, $doAccountUserPermissionAssocResult->is_allowed);
        
        DataGenerator::cleanUp(array('agency', 'account_user_permission_assoc'));
    }

    function testUpdate()
    {
        // Insert an agency
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId = $doAgency->insert();

        // Update the agency
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        $doAgency->name = 'bar';
        $doAgency->contact = 'baz';
        $doAgency->email = 'quux';
        $doAgency->update();

        $doAgencyResult = OA_Dal::staticGetDO('agency', $agencyId);

        $this->assertTrue($doAgencyResult->getRowCount(), 1);
        $this->assertEqual($doAgencyResult->name, 'bar');
        $this->assertEqual($doAgencyResult->contact, 'baz');
        $this->assertEqual($doAgencyResult->email, 'quux');

        DataGenerator::cleanUp(array('agency'));

    }

}
?>