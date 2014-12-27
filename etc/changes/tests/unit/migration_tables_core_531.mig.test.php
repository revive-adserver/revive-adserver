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

require_once MAX_PATH . '/etc/changes/migration_tables_core_531.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #531.
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_531Test extends MigrationTest
{
    function testMigrateInstanceId()
    {
        $this->initDatabase(530, array('preference', 'application_variable'));

        $tablePref   = $this->oDbh->quoteIdentifier($this->getPrefix().'preference', true);
        $tableAppVar = $this->oDbh->quoteIdentifier($this->getPrefix().'application_variable', true);

        $migration = new Migration_531();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');
        $migration->migrateInstanceId();

        $query = "SELECT value FROM {$tableAppVar} WHERE name='platform_hash'";
        $result = $this->oDbh->queryOne($query);
        $this->assertNotNull($result);

        $query = "DROP TABLE {$tableAppVar}";
        $result = $this->oDbh->exec($query);
        $query = "DROP TABLE {$tablePref}";
        $result = $this->oDbh->exec($query);

        $this->initDatabase(530, array('preference', 'application_variable'));

        $query = "INSERT INTO {$tablePref} (agencyid, instance_id) VALUES (0, 'foo')";
        $result = $this->oDbh->exec($query);
        $this->assertTrue($result);

        $migration = new Migration_531();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');
        $migration->migrateInstanceId();

        $query = "SELECT value FROM {$tableAppVar} WHERE name='platform_hash'";
        $result = $this->oDbh->queryOne($query);
        $this->assertEqual($result, 'foo');
    }
}