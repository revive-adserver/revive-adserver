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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_Upgrade.php';
require_once(MAX_PATH . '/lib/OA/Upgrade/DB_UpgradeAuditor.php');


/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_DB_Upgrade extends UnitTestCase
{
    public function test_prepPreScript()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $this->assertTrue($oDB_Upgrade->prepPreScript(MAX_PATH . '/lib/OA/Upgrade/tests/data/prescript_tables_core_2.php'));
        $this->assertIsA($oDB_Upgrade->oPreScript, 'prescript_tables_core_2', 'prescript class instance error');
    }

    public function test_runPreScript()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $this->assertTrue($oDB_Upgrade->prepPreScript(MAX_PATH . '/lib/OA/Upgrade/tests/data/prescript_tables_core_2.php'));
        $oDB_Upgrade->_setTiming('', DB_UPGRADE_TIMING_CONSTRUCTIVE_DEFAULT);
        $this->assertEqual($oDB_Upgrade->timingStr, 'constructive');
        $this->assertEqual($oDB_Upgrade->runPreScript(['sent prescript_tables_core_2']), 'returned constructive prescript_tables_core_2', 'prescript execution error');
        $oDB_Upgrade->_setTiming('', DB_UPGRADE_TIMING_DESTRUCTIVE_DEFAULT);
        $this->assertEqual($oDB_Upgrade->timingStr, 'destructive');
        $this->assertEqual($oDB_Upgrade->runPreScript(['sent prescript_tables_core_2']), 'returned destructive prescript_tables_core_2', 'prescript execution error');
    }

    public function test_prepPostScript()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $this->assertTrue($oDB_Upgrade->prepPostScript(MAX_PATH . '/lib/OA/Upgrade/tests/data/postscript_tables_core_2.php'));
        $this->assertIsA($oDB_Upgrade->oPostScript, 'postscript_tables_core_2', 'postscript class instance error');
    }

    public function test_runPostScript()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $this->assertTrue($oDB_Upgrade->prepPostScript(MAX_PATH . '/lib/OA/Upgrade/tests/data/postscript_tables_core_2.php'));
        $oDB_Upgrade->_setTiming('', DB_UPGRADE_TIMING_CONSTRUCTIVE_DEFAULT);
        $this->assertEqual($oDB_Upgrade->timingStr, 'constructive');
        $this->assertEqual($oDB_Upgrade->runPostScript(['sent postscript_tables_core_2']), 'returned constructive postscript_tables_core_2', 'postscript execution error');
        $oDB_Upgrade->_setTiming('', DB_UPGRADE_TIMING_DESTRUCTIVE_DEFAULT);
        $this->assertEqual($oDB_Upgrade->timingStr, 'destructive');
        $this->assertEqual($oDB_Upgrade->runPostScript(['sent postscript_tables_core_2']), 'returned destructive postscript_tables_core_2', 'ppstscript execution error');
    }

    /**
     * a problem with mdb2_schema is that field definitions are held in arrays that are not ordered
     * this is a problem when it comes to creating a multi-key index that must be ordered properly
     * mdb2_schema will be patched to define an 'order' key for an index field definition
     * this method sorts the fields into the right order
     *
     */
    public function test_sortIndexFields()
    {
        $fields = 'B_field1, E_field2, A_field3, D_field4, C_field5';
        $aFields = explode(',', $fields);
        $aResult = ['fields' => [
            $aFields[3] => ['order' => '4', 'sorting' => 'ascending'],
            $aFields[1] => ['order' => '2', 'sorting' => 'ascending'],
            $aFields[4] => ['order' => '5', 'sorting' => 'ascending'],
            $aFields[2] => ['order' => '3', 'sorting' => 'ascending'],
            $aFields[0] => ['order' => '1', 'sorting' => 'ascending'],
        ],
        ];
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $aResult = $oDB_Upgrade->_sortIndexFields($aResult);
        $i = 0;
        foreach ($aResult['fields'] as $field_name => $field_def) {
            $this->assertEqual($field_name, $aFields[$i], 'field in wrong position');
            $i++;
        }
    }

    public function test_getPreviousTablename()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $oDB_Upgrade->aChanges = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile(MAX_PATH . '/lib/OA/Upgrade/tests/data/changes_test_rename.xml');
        $this->assertEqual($oDB_Upgrade->_getPreviousTablename('table1_renamed'), 'table1', 'wrong previous table name');
    }

    public function test_getPreviousFieldname()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $oDB_Upgrade->aChanges = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile(MAX_PATH . '/lib/OA/Upgrade/tests/data/changes_test_rename.xml');
        $this->assertEqual($oDB_Upgrade->_getPreviousFieldname('table1', 'b_id_field_renamed'), 'b_id_field', 'wrong previous field name');
    }

    public function _newDBUpgradeObject($timing = 'constructive')
    {
        $oDB_Upgrade = new OA_DB_Upgrade();
        $oDB_Upgrade->initMDB2Schema();
        $oDB_Upgrade->timingStr = $timing;
        $oDB_Upgrade->timingInt = ($timing ? 0 : 1);
        $oDB_Upgrade->schema = 'tables_core';
        $oDB_Upgrade->prefix = '';
        $oDB_Upgrade->versionFrom = 1;
        $oDB_Upgrade->versionTo = 2;
        $oDB_Upgrade->logFile = MAX_PATH . "/var/DB_Upgrade.test.log";
        return $oDB_Upgrade;
    }

    public function test_prepRollbackByAuditId()
    {
        Mock::generatePartial(
            'OA_DB_Upgrade',
            $mockDBUpgrade = 'OA_DB_Upgrade' . rand(),
            ['_listTables'],
        );
        $oDB_Upgrade = new $mockDBUpgrade($this);

        $oDB_Upgrade->initMDB2Schema();
        $oDB_Upgrade->timingStr = '';
        $oDB_Upgrade->timingInt = 0;
        $oDB_Upgrade->schema = 'tables_core';
        $oDB_Upgrade->prefix = '';
        $oDB_Upgrade->versionFrom = 1;
        $oDB_Upgrade->versionTo = 2;
        $oDB_Upgrade->logFile = MAX_PATH . "/var/DB_Upgrade.test.log";

        $aDBTables = [0 => $oDB_Upgrade->prefix . 'z_table1_bak1',
            1 => $oDB_Upgrade->prefix . 'z_table1_bak2',
            2 => $oDB_Upgrade->prefix . 'z_table1_bak3',
            3 => $oDB_Upgrade->prefix . 'table2',
            4 => $oDB_Upgrade->prefix . 'table3',
        ];
        $oDB_Upgrade->setReturnValue('_listTables', $aDBTables);
        $oDB_Upgrade->expectOnce('_listTables');

        Mock::generatePartial(
            'OA_DB_UpgradeAuditor',
            $mockAuditor = 'OA_DB_UpgradeAuditor' . rand(),
            ['queryAuditBackupTablesByUpgradeId',
                'queryAuditAddedTablesByUpgradeId',
                'queryAuditUpgradeStartedByUpgradeId',
            ],
        );
        $oDB_Upgrade->oAuditor = new $mockAuditor($this);

        $aBackups = [
            0 => [
                'database_action_id' => 1,
                'upgrade_action_id' => 1,
                'schema_name' => 'tables_core',
                'version' => '900',
                'timing' => 0,
                'tablename' => 'table1',
                'tablename_backup' => 'z_table1_bak1',
                'table_backup_schema' => '',
            ],
            1 => [
                'database_action_id' => 2,
                'upgrade_action_id' => 1,
                'schema_name' => 'tables_core',
                'version' => '900',
                'timing' => 1,
                'tablename' => 'table1',
                'tablename_backup' => 'z_table1_bak2',
                'table_backup_schema' => '',
            ],
            2 => [
                'database_action_id' => 3,
                'upgrade_action_id' => 1,
                'schema_name' => 'tables_core',
                'version' => '901',
                'timing' => 0,
                'tablename' => 'table1',
                'tablename_backup' => 'z_table1_bak3',
                'table_backup_schema' => '',
            ],
        ];
        $oDB_Upgrade->oAuditor->setReturnValue('queryAuditBackupTablesByUpgradeId', $aBackups);
        $oDB_Upgrade->oAuditor->expectOnce('queryAuditBackupTablesByUpgradeId');

        $aAdded = [
            0 => [
                'database_action_id' => 10,
                'upgrade_action_id' => 1,
                'schema_name' => 'tables_core',
                'version' => '910',
                'timing' => 0,
                'tablename' => 'table2',
                'tablename_backup' => '',
                'table_backup_schema' => '',
            ],
            1 => [
                'database_action_id' => 11,
                'upgrade_action_id' => 1,
                'schema_name' => 'tables_core',
                'version' => '910',
                'timing' => 0,
                'tablename' => 'table3',
                'tablename_backup' => '',
                'table_backup_schema' => '',
            ],
        ];

        $oDB_Upgrade->oAuditor->setReturnValue('queryAuditAddedTablesByUpgradeId', $aAdded);
        $oDB_Upgrade->oAuditor->expectOnce('queryAuditAddedTablesByUpgradeId');

        $aSchemaInfo = [0 => ['schema_name' => 'test_schema',
            'info2' => 999,
        ],
        ];
        $oDB_Upgrade->oAuditor->setReturnValue('queryAuditUpgradeStartedByUpgradeId', $aSchemaInfo);
        $oDB_Upgrade->oAuditor->expectOnce('queryAuditUpgradeStartedByUpgradeId');

        $version = $schema = null;

        $this->assertTrue($oDB_Upgrade->prepRollbackByAuditId(1, $version, $schema));

        $this->assertEqual($version, $aSchemaInfo[0]['info2'], 'wrong schema version returned');
        $this->assertEqual($schema, $aSchemaInfo[0]['schema_name'], 'wrong schema version returned');

        $this->assertEqual(count($oDB_Upgrade->aRestoreTables), '1', 'wrong count tables restore array');
        $this->assertTrue(isset($oDB_Upgrade->aRestoreTables['tables_core']), 'schema not found in restore array');
        $this->assertTrue(isset($oDB_Upgrade->aRestoreTables['tables_core']['900']), 'version not found in restore array');
        $this->assertTrue(isset($oDB_Upgrade->aRestoreTables['tables_core']['900']['table1']), 'table not found in restore array');
        $this->assertTrue(isset($oDB_Upgrade->aRestoreTables['tables_core']['900']['table1'][0]), 'timing not found in restore array');
        $aDiff = array_diff_assoc($oDB_Upgrade->aRestoreTables['tables_core']['900']['table1'][0], $aBackups[0]);
        $this->assertEqual(count($aDiff), 0, 'array mismatch');
        $this->assertTrue(isset($oDB_Upgrade->aRestoreTables['tables_core']['900']['table1'][1]), 'timing not found in restore array');
        $aDiff = array_diff_assoc($oDB_Upgrade->aRestoreTables['tables_core']['900']['table1'][1], $aBackups[1]);
        $this->assertEqual(count($aDiff), 0, 'array mismatch');
        $this->assertTrue(isset($oDB_Upgrade->aRestoreTables['tables_core']['901']), 'version not found in restore array');
        $this->assertTrue(isset($oDB_Upgrade->aRestoreTables['tables_core']['901']['table1']), 'table not found in restore array');
        $this->assertTrue(isset($oDB_Upgrade->aRestoreTables['tables_core']['901']['table1'][0]), 'timing not found in restore array');
        $aDiff = array_diff_assoc($oDB_Upgrade->aRestoreTables['tables_core']['901']['table1'][0], $aBackups[2]);
        $this->assertEqual(count($aDiff), 0, 'array mismatch');

        $this->assertEqual(count($oDB_Upgrade->aAddedTables), '1', 'wrong count tables added array');
        $this->assertTrue(isset($oDB_Upgrade->aAddedTables['tables_core']), 'schema not found in added array');
        $this->assertTrue(isset($oDB_Upgrade->aAddedTables['tables_core']['910']), 'version not found in added array');
        $this->assertTrue(isset($oDB_Upgrade->aAddedTables['tables_core']['910']['table2']), 'table not found in added array');
        $aDiff = array_diff_assoc($oDB_Upgrade->aAddedTables['tables_core']['910']['table2'], $aAdded[0]);
        $this->assertEqual(count($aDiff), 0, 'array mismatch');
        $aDiff = array_diff_assoc($oDB_Upgrade->aAddedTables['tables_core']['910']['table3'], $aAdded[1]);
        $this->assertEqual(count($aDiff), 0, 'array mismatch');

        $oDB_Upgrade->tally();
        $oDB_Upgrade->oAuditor->tally();
    }


    public function testCheckPotentialUpgradeProblems()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();

        $oDB_Upgrade->aMessages = [];
        $this->assertTrue($oDB_Upgrade->checkPotentialUpgradeProblems());
        $this->assertEqual(count($oDB_Upgrade->aMessages), 0);

        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        $oDB_Upgrade->aMessages = [];
        $oDB_Upgrade->oSchema->db->exec("INSERT INTO {$prefix}campaigns (revenue_type, views, clicks, conversions) VALUES (" . MAX_FINANCE_CPM . ", 1, -1, -1)");
        $this->assertTrue($oDB_Upgrade->checkPotentialUpgradeProblems());
        $this->assertEqual(count($oDB_Upgrade->aMessages), 0);

        $oDB_Upgrade->aMessages = [];
        $oDB_Upgrade->oSchema->db->exec("INSERT INTO {$prefix}campaigns (revenue_type, views, clicks, conversions) VALUES (" . MAX_FINANCE_CPM . ", -1, 1, -1)");
        $this->assertTrue($oDB_Upgrade->checkPotentialUpgradeProblems());
        $this->assertEqual(count($oDB_Upgrade->aMessages), 2); // Warning + 1 detail row

        $oDB_Upgrade->aMessages = [];
        $oDB_Upgrade->oSchema->db->exec("INSERT INTO {$prefix}campaigns (revenue_type, views, clicks, conversions) VALUES (" . MAX_FINANCE_CPM . ", -1, -1, 1)");
        $this->assertTrue($oDB_Upgrade->checkPotentialUpgradeProblems());
        $this->assertEqual(count($oDB_Upgrade->aMessages), 3); // Warning + 2 detail rows

        $oDB_Upgrade->aMessages = [];
        $oDB_Upgrade->oSchema->db->exec("INSERT INTO {$prefix}campaigns (revenue_type, views, clicks, conversions) VALUES (" . MAX_FINANCE_CPC . ", 1, 1, -1)");
        $this->assertTrue($oDB_Upgrade->checkPotentialUpgradeProblems());
        $this->assertEqual(count($oDB_Upgrade->aMessages), 3); // Warning + 2 detail rows

        $oDB_Upgrade->aMessages = [];
        $oDB_Upgrade->oSchema->db->exec("INSERT INTO {$prefix}campaigns (revenue_type, views, clicks, conversions) VALUES (" . MAX_FINANCE_CPC . ", -1, -1, 1)");
        $this->assertTrue($oDB_Upgrade->checkPotentialUpgradeProblems());
        $this->assertEqual(count($oDB_Upgrade->aMessages), 4); // Warning + 3 detail rows

        $oDB_Upgrade->aMessages = [];
        $oDB_Upgrade->oSchema->db->exec("INSERT INTO {$prefix}campaigns (revenue_type, views, clicks, conversions) VALUES (" . MAX_FINANCE_CPA . ", 1, 1, 1)");
        $this->assertTrue($oDB_Upgrade->checkPotentialUpgradeProblems());
        $this->assertEqual(count($oDB_Upgrade->aMessages), 4); // Warning + 3 detail rows

        $oDB_Upgrade->oSchema->db->exec("DELETE FROM {$prefix}campaigns");
    }
}
