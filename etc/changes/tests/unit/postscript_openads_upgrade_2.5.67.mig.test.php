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
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.5.67.php';

/**
 * A class for testing non standard DataObjects_Users methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class Migration_postscript_2_5_67_UsersTest extends MigrationTest
{
    function setUp()
    {
        parent::setUp();
        $this->initDatabase(581, array('audit', 'campaigns', 'users', 'trackers'));
    }

    function testUpdate()
    {
        // prepare data
        $doUsers = OA_Dal::factoryDO('users');
        $doAudit = OA_Dal::factoryDO('audit');
        $doAudit->context = $doUsers->_getContext();
        DataGenerator::generate($doAudit, $cUsers = 3);

        $doTrackers = OA_Dal::factoryDO('trackers');
        $doAudit = OA_Dal::factoryDO('audit');
        $contextTrackers = $doAudit->context = $doTrackers->_getContext();
        DataGenerator::generate($doAudit, $cTrackers = 2);

        // run the upgrade
        Mock::generatePartial(
            'OA_UpgradePostscript_2_5_67',
            $mockName = 'OA_UpgradePostscript_2_5_67_'.rand(),
            array('logOnly','logError')
        );
        $doMockPostUpgrade = new $mockName($this);
        $doMockPostUpgrade->updateAuditContext();

        // test results
        $doAudit = OA_Dal::factoryDO('audit');
        $doAudit->context = $doUsers->getTableWithoutPrefix();
        $this->assertEqual($doAudit->count(), $cUsers);

        $doAudit = OA_Dal::factoryDO('audit');
        $doAudit->context = $doTrackers->getTableWithoutPrefix();
        $this->assertEqual($doAudit->count(), $cTrackers);
    }

}
?>