<?php

require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

class Migration_629Test extends MigrationTest
{
    public function testRemoveCategoryData()
    {
        $this->assertTrue($this->initDatabase(628, ['affiliates', 'affiliates_extra', 'zones', 'category', 'ad_category_assoc', 'ad_zone_assoc']));
        $db = $this->oDbh;
        $prefix = $this->getPrefix();
        $tables = [];
        foreach (['affiliates', 'affiliates_extra', 'zones', 'category', 'ad_category_assoc', 'ad_zone_assoc'] as $table) {
            $tables[$table] = $db->quoteIdentifier($prefix . $table, true);
        }
        $queries = [
            "INSERT INTO {$tables['affiliates']} (affiliateid, name, mnemonic, email, updated, oac_country_code, oac_language_id, oac_category_id) VALUES (1, 'Publisher', '', '', '2026-11-04 00:00:00', 'IT', 1, 1)",
            "INSERT INTO {$tables['affiliates_extra']} (affiliateid, category, city) VALUES (1, 'legacy', 'Rome')",
            "INSERT INTO {$tables['zones']} (zoneid, zonename, description, category, ad_selection, chain, prepend, append, updated, what, oac_category_id) VALUES (1, 'Zone', '', 'legacy', '', '', '', '', '2026-11-04 00:00:00', '', 1)",
            "INSERT INTO {$tables['category']} (category_id, name) VALUES (1, 'legacy')",
            "INSERT INTO {$tables['ad_category_assoc']} (category_id, ad_id) VALUES (1, 1)",
            "INSERT INTO {$tables['ad_zone_assoc']} (ad_id, zone_id, link_type) VALUES (1, 0, 0), (1, 1, 1), (2, 1, 2)",
        ];
        foreach ($queries as $query) {
            $this->assertFalse(PEAR::isError($db->exec($query)), $query);
        }

        $this->upgradeToVersion(629);
        $existing = $db->manager->listTables();
        $this->assertFalse(in_array($prefix . 'category', $existing));
        $this->assertFalse(in_array($prefix . 'ad_category_assoc', $existing));
        foreach (['affiliates' => ['oac_country_code', 'oac_language_id', 'oac_category_id'], 'affiliates_extra' => ['category'], 'zones' => ['oac_category_id', 'category']] as $table => $removed) {
            $fields = $db->manager->listTableFields($prefix . $table);
            foreach ($removed as $field) {
                $this->assertFalse(in_array($field, $fields), "{$table}.{$field} still exists");
            }
        }
        $this->assertEqual($db->queryOne("SELECT name FROM {$tables['affiliates']} WHERE affiliateid = 1"), 'Publisher');
        $this->assertEqual($db->queryOne("SELECT city FROM {$tables['affiliates_extra']} WHERE affiliateid = 1"), 'Rome');
        $this->assertEqual($db->queryOne("SELECT zonename FROM {$tables['zones']} WHERE zoneid = 1"), 'Zone');

        $upgrade = new OA_Upgrade();
        $upgrade->upgradePath = MAX_PATH . '/etc/changes/';
        $this->assertTrue($upgrade->runScript('postscript_openads_upgrade_6.1.0-beta-rc1.php'));
        $this->assertEqual($db->queryCol("SELECT link_type FROM {$tables['ad_zone_assoc']} ORDER BY link_type"), [0, 1]);
        $postscript = new RV_UpgradePostscript_6_1_0_beta_rc1();
        $this->assertTrue($postscript->execute([$upgrade]));
    }
}
