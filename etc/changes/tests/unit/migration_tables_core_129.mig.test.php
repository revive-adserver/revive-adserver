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

require_once MAX_PATH . '/etc/changes/migration_tables_core_129.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #129.
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_tables_core_129Test extends MigrationTest
{
    function testMigrateData()
    {
        $this->initDatabase(129, array('config', 'preference'));

        $this->setupPanConfig();

        $migration = new Migration_129();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');

        $aValues = array('warn_limit_days' => 1);

        $migration->migrateData();
        $table = $this->oDbh->quoteIdentifier($this->getPrefix().'preference');
        $rsPreference = DBC::NewRecordSet("SELECT * from {$table}");

        $rsPreference->find();
        $this->assertTrue($rsPreference->fetch());
        $aDataPreference = $rsPreference->toArray();
        foreach($aValues as $column => $value) {
            $this->assertEqual($value, $aDataPreference[$column]);
        }

        $this->restorePanConfig();
    }
}