<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id $
*/


require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_PATH.'/lib/OA/DB/Table.php';

require_once MAX_PATH.'/www/devel/lib/openads/DB_Upgrade.php';


/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_DB_Upgrade extends UnitTestCase
{

    var $path;

    /**
     * The constructor method.
     */
    function Test_DB_Upgrade()
    {
        $this->UnitTestCase();
    }

    function test_constructor()
    {
        $this->path = MAX_PATH.'/www/devel/tests/integration/';
        $oDB_Upgrade = & new OA_DB_Upgrade();
        $this->assertIsA($oDB_Upgrade, 'OA_DB_Upgrade', 'OA_DB_Upgrade not instantiated');
        $this->assertIsA($oDB_Upgrade->oSchema, 'MDB2_Schema', 'MDB2_Schema not instantiated');
        $this->assertIsA($oDB_Upgrade->oSchema->db, 'MDB2_Driver_Common', 'MDB2_Driver_Common not instantiated');
    }

    function test_BackupAndRollback()
    {
        $oDB_Upgrade = & new OA_DB_Upgrade();
        $oDB_Upgrade->timingStr = 'constructive';
        $oDB_Upgrade->timingInt = 0;
        $oDB_Upgrade->prefix = '';
        $oDB_Upgrade->versionFrom = 1;
        $oDB_Upgrade->aChanges['affected_tables']['constructive'] = array('table1');
        $this->_createTestTable($oDB_Upgrade->oSchema->db);
        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();
        $oDB_Upgrade->logFile = 'DB_Upgrade.dev.test.log';
        if (!in_array($oDB_Upgrade->prefix.$oDB_Upgrade->logTable, $oDB_Upgrade->aDBTables))
        {
            $this->assertTrue($oDB_Upgrade->_createAuditTable(),'failed to create database_action audit table');
        }

        $tbl_def_orig = $oDB_Upgrade->oSchema->getDefinitionFromDatabase(array('table1'));

        $this->assertTrue($oDB_Upgrade->_backup(),'_backup failed');
        $this->assertIsA($oDB_Upgrade->aRestoreTables, 'array', 'aRestoreTables not an array');
        $this->assertTrue(array_key_exists('table1', $oDB_Upgrade->aRestoreTables), 'table not found in aRestoreTables');
        $this->assertTrue(array_key_exists('bak', $oDB_Upgrade->aRestoreTables['table1']), 'backup table name not found for table table1');
        $this->assertTrue(array_key_exists('def', $oDB_Upgrade->aRestoreTables['table1']), 'definition array not found for table table1');

        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();

        $table_bak = $oDB_Upgrade->aRestoreTables['table1']['bak'];
        $this->assertTrue(in_array($table_bak, $oDB_Upgrade->aDBTables), 'backup table not found in database');

        $tbl_def_bak = $oDB_Upgrade->oSchema->getDefinitionFromDatabase(array($table_bak));

        $tbl_def_orig = $tbl_def_orig['tables']['table1'];
        $tbl_def_bak  = $tbl_def_bak['tables'][$table_bak];

        foreach ($tbl_def_orig['fields'] AS $name=>$aType)
        {
            $this->assertTrue(array_key_exists($name, $tbl_def_bak['fields']), 'field missing from backup table');
        }

        $oDB_Upgrade->oSchema->db->manager->dropTable('table1');

        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();
        $this->assertFalse(in_array('table1', $oDB_Upgrade->aDBTables), 'could not drop test table');

        $this->assertTrue($oDB_Upgrade->_rollback(), 'rollback failed');

        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();
        $this->assertTrue(in_array('table1',$oDB_Upgrade->aDBTables), 'test table was not restored');

        $tbl_def_rest = $oDB_Upgrade->oSchema->getDefinitionFromDatabase(array('table1'));
        $tbl_def_rest = $tbl_def_rest['tables']['table1'];

        // also test field definition properties?
        foreach ($tbl_def_orig['fields'] AS $field=>$aDef)
        {
            $this->assertTrue(array_key_exists($field, $tbl_def_rest['fields']), 'field missing from restored table');
        }

        // test field order?  (tho the field sort method is tested above so should be covered)
        foreach ($tbl_def_orig['indexes'] AS $index=>$aDef)
        {
            $this->assertTrue(array_key_exists($index, $tbl_def_rest['indexes']), 'index missing from restored table');
            if (array_key_exists('primary', $aDef))
            {
                $this->assertTrue(array_key_exists('primary', $tbl_def_rest['indexes'][$index]), 'primary flag missing from restored index');
            }
            if (array_key_exists('unique', $aDef))
            {
                $this->assertTrue(array_key_exists('unique', $tbl_def_rest['indexes'][$index]), 'unique flag missing from restored index');
            }
            foreach ($aDef['fields'] AS $field=>$aField)
            {
                $this->assertTrue(array_key_exists($field, $tbl_def_rest['indexes'][$index]['fields']), 'index field missing from restored table');
            }
        }
    }

    function test_verifyTasks()
    {
        $oDB_Upgrade = & new OA_DB_Upgrade();
        $oDB_Upgrade->timingStr = 'constructive';
        $oDB_Upgrade->timingInt = 0;
        $oDB_Upgrade->prefix = '';
        $oDB_Upgrade->versionFrom = 1;
        $oDB_Upgrade->aChanges['affected_tables']['constructive'] = array('table1');
        $this->_createTestTable($oDB_Upgrade->oSchema->db);
        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();
        $oDB_Upgrade->logFile = 'DB_Upgrade.dev.test.log';
        if (!in_array($oDB_Upgrade->prefix.$oDB_Upgrade->logTable, $oDB_Upgrade->aDBTables))
        {
            $this->assertTrue($oDB_Upgrade->_createAuditTable(),'failed to create database_action audit table');
        }


        $prev_definition                = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_1.xml');
        $oDB_Upgrade->aDefinitionNew    = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_2.xml');
        $changes_write                  = $oDB_Upgrade->oSchema->compareDefinitions($oDB_Upgrade->aDefinitionNew, $prev_definition);

        $changes_write['version']       = '2';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = MAX_PATH.'/var/changes_test_2.xml';
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($changes_write, $options);
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue($oDB_Upgrade->_verifyTasks(),'failed _verifyTasks');

        $oDB_Upgrade->aTaskList = array();
        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesAdd(),'failed _verifyTasksTablesAdd');
        $this->assertTrue(isset($oDB_Upgrade->aTaskList['tables']['add']),'failed creating task list: tables add');
        $this->assertEqual(count($oDB_Upgrade->aTaskList['tables']['add']),1, 'incorrect elements in task list: tables add');
        $this->assertEqual($oDB_Upgrade->aTaskList['tables']['add'][0]['name'], 'table2_new', 'wrong table name');
        $this->assertEqual(count($oDB_Upgrade->aTaskList['tables']['add'][0]['task']),2, 'incorrect number of add table tasks in task list');
        $this->assertTrue(isset($oDB_Upgrade->aTaskList['tables']['add'][0]['task']['a_text_field_new']),'a_text_field_new field not found in task add array');
        $this->assertTrue(isset($oDB_Upgrade->aTaskList['tables']['add'][0]['task']['b_id_field_new']),'b_id_field_new field not found in task add array');
        $this->assertEqual(count($oDB_Upgrade->aTaskList['tables']['add'][0]['indexes']),2, 'incorrect number of add table indexes in task list');
        $this->assertEqual($oDB_Upgrade->aTaskList['tables']['add'][0]['indexes'][0]['name'],'index1_new','index1_new not found in task index array');
        $this->assertEqual($oDB_Upgrade->aTaskList['tables']['add'][0]['indexes'][0]['table'],'table2_new','wrong table in task index array');
        $this->assertEqual($oDB_Upgrade->aTaskList['tables']['add'][0]['indexes'][1]['name'],'index2_new','index2_new not found in task index array');
        $this->assertEqual($oDB_Upgrade->aTaskList['tables']['add'][0]['indexes'][1]['table'],'table2_new','wrong table in task index array');

        $oDB_Upgrade->aTaskList = array();
        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesAlter(),'failed _verifyTasksTablesAlter');
        $this->assertTrue(isset($oDB_Upgrade->aTaskList['fields']['add']),'failed creating task list: fields add');
        $this->assertEqual(count($oDB_Upgrade->aTaskList['fields']['add']),1, 'incorrect elements in task list: fields add');
        $this->assertEqual($oDB_Upgrade->aTaskList['fields']['add'][0]['name'], 'table1', 'wrong table name');
        $this->assertEqual($oDB_Upgrade->aTaskList['fields']['add'][0]['field'], 'c_date_field_new', 'wrong field name');
        $this->assertEqual(count($oDB_Upgrade->aTaskList['fields']['add'][0]['task']),1, 'incorrect number of add fields tasks in task list');
        $this->assertTrue(isset($oDB_Upgrade->aTaskList['fields']['add'][0]['task']['add']['c_date_field_new']),'c_date_field_new field not found in task add array');

        $oDB_Upgrade->aTaskList = array();
        $this->assertTrue($oDB_Upgrade->_verifyTasks(),'failed _verifyTasks');

        //$oDB_Upgrade->_verifyTasks();

    }

    function _createTestTable($oDbh)
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $conf['table']['split'] = false;
        $oTable = new OA_DB_Table();
        $oTable->init($this->path.'schema_test_1.xml');
        $oTable->createTable('table1');
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertTrue(in_array('table1', $aExistingTables), '_createTestTable');
    }

}

?>
