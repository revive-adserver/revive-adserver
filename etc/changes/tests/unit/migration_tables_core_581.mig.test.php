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

require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

class Migration_tables_core_581Test extends MigrationTest
{
    public function testAddsSsoUserIdConstraint()
    {
        $this->assertTrue($this->initDatabase(580, ['banners', 'campaigns', 'users', 'zones']));

        $this->upgradeToVersion(581);

        $constraints = $this->oDbh->manager->listTableConstraints($this->getPrefix() . 'users');
        $this->assertTrue(in_array($this->getPrefix() . 'users_sso_user_id', $constraints));
    }
}
