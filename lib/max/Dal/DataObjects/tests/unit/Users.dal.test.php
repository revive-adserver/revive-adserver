<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * A class for testing non standard DataObjects_Users methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_UsersTest extends DalUnitTestCase
{
    var $userId;

    /**
     * The constructor method.
     */
    function DataObjects_UsersTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->contact_name = 'foo';
        $doUsers->username = 'Foo';
        $this->userId = DataGenerator::generateOne($doUsers);
        $this->assertTrue($this->userId);
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testInsert()
    {
        $doUsers = OA_Dal::staticGetDO('users', $this->userId);
        $this->assertEqual($doUsers->username, 'foo');
    }

    function testUpdate()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->user_id = $this->userId;
        $doUsers->username = 'Bar';
        $this->assertTrue($doUsers->update());

        $doUsers = OA_Dal::staticGetDO('users', $this->userId);
        $this->assertEqual($doUsers->username, 'bar');
    }

    function testUserExists()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $this->assertTrue($doUsers->userExists('foo'));
        $this->assertTrue($doUsers->userExists('Foo'));
        $this->assertTrue($doUsers->userExists('FOO'));
    }

}
?>