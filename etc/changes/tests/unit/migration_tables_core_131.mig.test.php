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

class Migration_tables_core_131Test extends MigrationTest
{
    public function testAddsMissingIndexes()
    {
        $this->assertTrue($this->initDatabase(130, ['affiliates', 'banners', 'clients', 'zones']));

        $this->upgradeToVersion(131);

        foreach (['affiliates' => 'agencyid', 'banners' => 'campaignid', 'clients' => 'agencyid', 'zones' => 'affiliateid'] as $table => $field) {
            $indexes = $this->oDbh->manager->listTableIndexes($this->getPrefix() . $table);
            $this->assertTrue(in_array($this->getPrefix() . $table . '_' . $field, $indexes), "Missing index on {$table}.{$field}");
        }
    }
}
