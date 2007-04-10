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

    var $aChangesVars;
    var $aOptions;

    /**
     * The constructor method.
     */
    function Test_DB_Upgrade()
    {
        $this->UnitTestCase();

        $this->aChangesVars['version']       = '2';
        $this->aChangesVars['name']          = 'changes_test';
        $this->aChangesVars['comments']      = '';
        $this->aOptions['split']             = true;
        $this->aOptions['output']            = MAX_PATH.'/var/changes_test.xml';
        $this->aOptions['xsl_file']          = "";
        $this->aOptions['output_mode']       = 'file';
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
        $oDB_Upgrade = $this->_newDBUpgradeObject(array('table1'));

        $aTbl_def_orig = $oDB_Upgrade->oSchema->getDefinitionFromDatabase(array('table1'));

        $this->assertTrue($oDB_Upgrade->_backup(),'_backup failed');
        $this->assertIsA($oDB_Upgrade->aRestoreTables, 'array', 'aRestoreTables not an array');
        $this->assertTrue(array_key_exists('table1', $oDB_Upgrade->aRestoreTables), 'table not found in aRestoreTables');
        $this->assertTrue(array_key_exists('bak', $oDB_Upgrade->aRestoreTables['table1']), 'backup table name not found for table table1');
        $this->assertTrue(array_key_exists('def', $oDB_Upgrade->aRestoreTables['table1']), 'definition array not found for table table1');

        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();

        $table_bak = $oDB_Upgrade->aRestoreTables['table1']['bak'];
        $this->assertTrue(in_array($table_bak, $oDB_Upgrade->aDBTables), 'backup table not found in database');

        $aTbl_def_bak = $oDB_Upgrade->oSchema->getDefinitionFromDatabase(array($table_bak));

        $aTbl_def_orig = $aTbl_def_orig['tables']['table1'];
        $aTbl_def_bak  = $aTbl_def_bak['tables'][$table_bak];

        foreach ($aTbl_def_orig['fields'] AS $name=>$aType)
        {
            $this->assertTrue(array_key_exists($name, $aTbl_def_bak['fields']), 'field missing from backup table');
        }

        $oDB_Upgrade->oSchema->db->manager->dropTable('table1');

        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();
        $this->assertFalse(in_array('table1', $oDB_Upgrade->aDBTables), 'could not drop test table');

        $this->assertTrue($oDB_Upgrade->_rollback(), 'rollback failed');

        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();
        $this->assertTrue(in_array('table1',$oDB_Upgrade->aDBTables), 'test table was not restored');

        $aTbl_def_rest = $oDB_Upgrade->oSchema->getDefinitionFromDatabase(array('table1'));
        $aTbl_def_rest = $aTbl_def_rest['tables']['table1'];

        // also test field definition properties?
        foreach ($aTbl_def_orig['fields'] AS $field=>$aDef)
        {
            $this->assertTrue(array_key_exists($field, $aTbl_def_rest['fields']), 'field missing from restored table');
        }

        // test field order?  (tho the field sort method is tested above so should be covered)
        foreach ($aTbl_def_orig['indexes'] AS $index=>$aDef)
        {
            $this->assertTrue(array_key_exists($index, $aTbl_def_rest['indexes']), 'index missing from restored table');
            if (array_key_exists('primary', $aDef))
            {
                $this->assertTrue(array_key_exists('primary', $aTbl_def_rest['indexes'][$index]), 'primary flag missing from restored index');
            }
            if (array_key_exists('unique', $aDef))
            {
                $this->assertTrue(array_key_exists('unique', $aTbl_def_rest['indexes'][$index]), 'unique flag missing from restored index');
            }
            foreach ($aDef['fields'] AS $field=>$aField)
            {
                $this->assertTrue(array_key_exists($field, $aTbl_def_rest['indexes'][$index]['fields']), 'index field missing from restored table');
            }
        }
    }

    function test_verifyTasksTablesAdd()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject(array('table1'));

        $aPrev_definition                = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_original.xml');
        $oDB_Upgrade->aDefinitionNew    = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_tableAdd.xml');
        $aChanges_write                  = $oDB_Upgrade->oSchema->compareDefinitions($oDB_Upgrade->aDefinitionNew, $aPrev_definition);

        $this->aOptions['output']       = MAX_PATH.'/var/changes_test_tableAdd.xml';
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($aChanges_write, $this->aOptions);
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesAdd(),'failed _verifyTasksTablesAdd');
        $aTaskList = $oDB_Upgrade->aTaskList;
        $this->assertTrue(isset($aTaskList['tables']['add']),'failed creating task list: tables add');
        $this->assertEqual(count($aTaskList['tables']['add']),1, 'incorrect elements in task list: tables add');
        $this->assertEqual($aTaskList['tables']['add'][0]['name'], 'table_new', 'wrong table name');
        $this->assertEqual(count($aTaskList['tables']['add'][0]['cargo']),2, 'incorrect number of add table tasks in task list');
        $this->assertTrue(isset($aTaskList['tables']['add'][0]['cargo']['a_text_field_new']),'a_text_field_new field not found in task add array');
        $this->assertTrue(isset($aTaskList['tables']['add'][0]['cargo']['b_id_field_new']),'b_id_field_new field not found in task add array');
        $this->assertEqual(count($aTaskList['tables']['add'][0]['indexes']),2, 'incorrect number of add table indexes in task list');
        $this->assertEqual($aTaskList['tables']['add'][0]['indexes'][0]['name'],'index1_new','index1_new not found in task index array');
        $this->assertEqual($aTaskList['tables']['add'][0]['indexes'][0]['table'],'table_new','wrong table in task index array');
        $this->assertEqual($aTaskList['tables']['add'][0]['indexes'][1]['name'],'index2_new','index2_new not found in task index array');
        $this->assertEqual($aTaskList['tables']['add'][0]['indexes'][1]['table'],'table_new','wrong table in task index array');

    }

    function test_verifyTasksTablesRemove()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject(array('table1'),'destructive');

        $aPrev_definition                = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_original.xml');
        $oDB_Upgrade->aDefinitionNew    = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_tableRemove.xml');
        $aChanges_write                  = $oDB_Upgrade->oSchema->compareDefinitions($oDB_Upgrade->aDefinitionNew, $aPrev_definition);

        $this->aOptions['output']       = MAX_PATH.'/var/changes_test_tableRemove.xml';
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($aChanges_write, $this->aOptions);
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        $oDB_Upgrade->aTaskList = $aTaskList;
        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesRemove(),'failed _verifyTasksTablesRemove');
        $aTaskList = $oDB_Upgrade->aTaskList;
        $this->assertTrue(isset($aTaskList['tables']['remove']),'failed creating task list: tables remove');
        $this->assertEqual(count($aTaskList['tables']['remove']),1, 'incorrect elements in task list: tables remove');
        $this->assertEqual($aTaskList['tables']['remove'][0]['name'], 'table2', 'wrong table name');
    }

    function test_verifyTasksTablesRename()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject(array('table1'));

        $aPrev_definition                = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_original.xml');
        $oDB_Upgrade->aDefinitionNew    = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_tableRename.xml');
        $aChanges_write                  = $oDB_Upgrade->oSchema->compareDefinitions($oDB_Upgrade->aDefinitionNew, $aPrev_definition);

        $this->aOptions['output']       = MAX_PATH.'/var/changes_test_tableRename.xml';
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($aChanges_write, $this->aOptions);
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        // this bit copies work done by oSchema that modifies changeset array for renaming tables
        $table_name = 'table1_rename';
        $table_name_was = 'table1';
        if (isset($oDB_Upgrade->aChanges['constructive']['tables']['add'][$table_name]))
        {
            unset($oDB_Upgrade->aChanges['constructive']['tables']['add'][$table_name]);
            if (empty($oDB_Upgrade->aChanges['constructive']['tables']['add']))
            {
                unset($oDB_Upgrade->aChanges['constructive']['tables']['add']);
            }
            $oDB_Upgrade->aChanges['constructive']['tables']['rename'][$table_name]['was'] = $table_name_was;
            if (isset($oDB_Upgrade->aChanges['destructive']['tables']['remove'][$table_name_was]))
            {
                unset($oDB_Upgrade->aChanges['destructive']['tables']['remove'][$table_name_was]);
                if (empty($oDB_Upgrade->aChanges['destructive']['tables']['remove']))
                {
                    unset($oDB_Upgrade->aChanges['destructive']['tables']['remove']);
                }
            }
        }

        $this->aOptions['split']        = false; // this is a rewrite of a previously split changeset, don't split it again
        $this->aOptions['rewrite']      = true; // this is a rewrite of a previously split changeset, don't split it again
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($oDB_Upgrade->aChanges, $this->aOptions);
        $this->aOptions['rewrite']      = false; // reset this var
        $this->aOptions['split']        = true; // reset this var
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        $oDB_Upgrade->aTaskList         = $aTaskList;
        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesRename(),'failed test_verifyTasksTablesRename');
        $aTaskList = $oDB_Upgrade->aTaskList;
        $this->assertTrue(isset($aTaskList['tables']['rename']),'failed creating task list: tables rename');
        $this->assertEqual(count($aTaskList['tables']['rename']),1, 'incorrect elements in task list: tables rename');
        $this->assertEqual($aTaskList['tables']['rename'][0]['name'], 'table1_rename', 'wrong new table name');
        $this->assertEqual($aTaskList['tables']['rename'][0]['cargo']['was'], 'table1', 'wrong old table name');
    }

    function test_verifyTasksTablesAlter()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject(array('table1'));

        $aPrev_definition                = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_original.xml');

        // Test 1 : add field
        $oDB_Upgrade->aDefinitionNew    = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_tableAlter1.xml');
        $aChanges_write                  = $oDB_Upgrade->oSchema->compareDefinitions($oDB_Upgrade->aDefinitionNew, $aPrev_definition);
        $this->aOptions['output']       = MAX_PATH.'/var/changes_test_tableAlter1.xml';
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($aChanges_write, $this->aOptions);
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        $oDB_Upgrade->aTaskList = array();
        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesAlter(),'failed _verifyTasksTablesAlter: add field');
        $aTaskList = $oDB_Upgrade->aTaskList;
        $this->assertTrue(isset($aTaskList['fields']['add']),'failed creating task list: fields add');
        $this->assertEqual(count($aTaskList['fields']['add']),1, 'incorrect elements in task list: fields add');
        $this->assertEqual($aTaskList['fields']['add'][0]['name'], 'table1', 'wrong table name');
        $this->assertEqual($aTaskList['fields']['add'][0]['field'], 'c_date_field_new', 'wrong field name');
        $this->assertEqual(count($aTaskList['fields']['add'][0]['cargo']),1, 'incorrect number of add fields tasks in task list');
        $this->assertTrue(isset($aTaskList['fields']['add'][0]['cargo']['add']['c_date_field_new']),'c_date_field_new field not found in task add array');

        // Test 2 : change field
        $oDB_Upgrade->aDefinitionNew    = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_tableAlter2.xml');
        $aChanges_write                 = $oDB_Upgrade->oSchema->compareDefinitions($oDB_Upgrade->aDefinitionNew, $aPrev_definition);
        $this->aOptions['output']       = MAX_PATH.'/var/changes_test_tableAlter2.xml';
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($aChanges_write, $this->aOptions);
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        $oDB_Upgrade->aTaskList = array();
        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesAlter(),'failed _verifyTasksTablesAlter: change field');
        $aTaskList = $oDB_Upgrade->aTaskList;
        $this->assertTrue(isset($aTaskList['fields']['change']),'failed creating task list: fields change');
        $this->assertEqual(count($aTaskList['fields']['change']),1, 'incorrect elements in task list: fields change');
        $this->assertEqual($aTaskList['fields']['change'][0]['name'], 'table1', 'wrong table name');
        $this->assertEqual($aTaskList['fields']['change'][0]['field'], 'b_id_field', 'wrong field name');
        $this->assertEqual(count($aTaskList['fields']['change'][0]['cargo']),1, 'incorrect number of change fields tasks in task list');
        $this->assertTrue(isset($aTaskList['fields']['change'][0]['cargo']['change']['b_id_field']),'b_id_field field not found in task change array');
        $this->assertTrue($aTaskList['fields']['change'][0]['cargo']['change']['b_id_field']['autoincrement'],'b_id_field autoincrement property not set in task change array');
        $this->assertEqual($aTaskList['fields']['change'][0]['cargo']['change']['b_id_field']['length'],11,'b_id_field length property not set in task change array');

        // Test 4 : rename field
        $oDB_Upgrade->aDefinitionNew    = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_tableAlter4.xml');
        $aChanges_write                  = $oDB_Upgrade->oSchema->compareDefinitions($oDB_Upgrade->aDefinitionNew, $aPrev_definition);
        $this->aOptions['output']       = MAX_PATH.'/var/changes_test_tableAlter4.xml';
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($aChanges_write, $this->aOptions);
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        // this bit copies work done by oSchema that modifies changeset array for renaming fields
        $table_name = 'table1';
        $field_name = 'b_id_field_renamed';
        $field_name_was = 'b_id_field';
        $oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]['rename']['fields'][$field_name]['was'] = $field_name_was;
        if (isset($oDB_Upgrade->aChanges['destructive']['tables']['change'][$table_name]['remove'][$field_name_was]))
        {
            unset($oDB_Upgrade->aChanges['destructive']['tables']['change'][$table_name]['remove'][$field_name_was]);
            if (empty($oDB_Upgrade->aChanges['destructive']['tables']['change'][$table_name]['remove']))
            {
                unset($oDB_Upgrade->aChanges['destructive']['tables']['change'][$table_name]['remove']);
            }
            if (empty($oDB_Upgrade->aChanges['destructive']['tables']['change'][$table_name]))
            {
                unset($oDB_Upgrade->aChanges['destructive']['tables']['change'][$table_name]);
            }
            if (empty($oDB_Upgrade->aChanges['destructive']['tables']['change']))
            {
                unset($oDB_Upgrade->aChanges['destructive']['tables']['change']);
            }
        }
        if (isset($oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]['add']['fields'][$field_name]))
        {
            unset($oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]['add']['fields'][$field_name]);
            if (empty($oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]['add']['fields']))
            {
                unset($oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]['add']['fields']);
            }
            if (empty($oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]['add']))
            {
                unset($oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]['add']);
            }
            if (empty($oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]))
            {
                unset($oDB_Upgrade->aChanges['constructive']['tables']['change'][$table_name]);
            }
            if (empty($oDB_Upgrade->aChanges['constructive']['tables']['change']))
            {
                unset($oDB_Upgrade->aChanges['constructive']['tables']['change']);
            }
        }
        $this->aOptions['split']        = false; // this is a rewrite of a previously split changeset, don't split it again
        $this->aOptions['rewrite']      = true; // this is a rewrite of a previously split changeset, don't split it again
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($oDB_Upgrade->aChanges, $this->aOptions);
        $this->aOptions['rewrite']      = false; // reset this var
        $this->aOptions['split']        = true; // reset this var
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        $oDB_Upgrade->aTaskList = array();
        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesAlter(),'failed _verifyTasksTablesAlter: rename field');
        $aTaskList = $oDB_Upgrade->aTaskList;
        $this->assertTrue(isset($aTaskList['fields']['rename']),'failed creating task list: fields rename');
        $this->assertEqual(count($aTaskList['fields']['rename']),1, 'incorrect elements in task list: fields rename');
        $this->assertEqual($aTaskList['fields']['rename'][0]['name'], 'table1', 'wrong table name');
        $this->assertEqual($aTaskList['fields']['rename'][0]['field'], 'b_id_field', 'wrong field name');
        $this->assertEqual(count($aTaskList['fields']['rename'][0]['cargo']['rename']),1, 'incorrect number of rename fields tasks in task list');
        $this->assertTrue(isset($aTaskList['fields']['rename'][0]['cargo']['rename']['b_id_field']),'b_id_field field not found in task change array');
        $this->assertEqual($aTaskList['fields']['rename'][0]['cargo']['rename']['b_id_field']['name'],'b_id_field_renamed','b_id_field wrong value in task change array');

        // Test 3 : remove field
        $oDB_Upgrade = $this->_newDBUpgradeObject(array('table1'), 'destructive');
        $oDB_Upgrade->aDefinitionNew    = $oDB_Upgrade->oSchema->parseDatabaseDefinitionFile($this->path.'schema_test_tableAlter3.xml');
        $aChanges_write                 = $oDB_Upgrade->oSchema->compareDefinitions($oDB_Upgrade->aDefinitionNew, $aPrev_definition);
        $this->aOptions['output']       = MAX_PATH.'/var/changes_test_tableAlter3.xml';
        $result                         = $oDB_Upgrade->oSchema->dumpChangeset($aChanges_write, $this->aOptions);
        $oDB_Upgrade->aChanges          = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile($this->aOptions['output']);

        $oDB_Upgrade->aTaskList = array();
        $this->assertTrue($oDB_Upgrade->_verifyTasksTablesAlter(),'failed _verifyTasksTablesAlter: remove field');
        $aTaskList = $oDB_Upgrade->aTaskList;
        $this->assertTrue(isset($aTaskList['fields']['remove']),'failed creating task list: fields remove');
        $this->assertEqual(count($aTaskList['fields']['remove']),1, 'incorrect elements in task list: fields remove');
        $this->assertEqual($aTaskList['fields']['remove'][0]['name'], 'table1', 'wrong table name');
        $this->assertEqual($aTaskList['fields']['remove'][0]['field'], 'a_text_field', 'wrong field name');
        $this->assertEqual(count($aTaskList['fields']['remove'][0]['cargo']['remove']),1, 'incorrect number of remove fields tasks in task list');
        $this->assertTrue(isset($aTaskList['fields']['remove'][0]['cargo']['remove']['a_text_field']),'a_text_field field not found in task change array');

    }

    function _createTestTables($oDbh)
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $conf['table']['split'] = false;
        $oTable = new OA_DB_Table();
        $oTable->init($this->path.'schema_test_original.xml');
        $oTable->createTable('table1');
        $oTable->createTable('table2');
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertTrue(in_array('table1', $aExistingTables), '_createTestTables');
        $this->assertTrue(in_array('table2', $aExistingTables), '_createTestTables');
    }

    function _newDBUpgradeObject($affected_tables=array(), $timing='constructive')
    {
        $oDB_Upgrade = & new OA_DB_Upgrade();
        $oDB_Upgrade->timingStr = $timing;
        $oDB_Upgrade->timingInt = ($timing ? 0 : 1);
        $oDB_Upgrade->prefix = '';
        $oDB_Upgrade->versionFrom = 1;
        $oDB_Upgrade->aChanges['affected_tables']['constructive'] = array('table1');
        $this->_createTestTables($oDB_Upgrade->oSchema->db);
        $oDB_Upgrade->aDBTables = $oDB_Upgrade->_listTables();
        $oDB_Upgrade->logFile = 'DB_Upgrade.dev.test.log';
        if (!in_array($oDB_Upgrade->prefix.$oDB_Upgrade->logTable, $oDB_Upgrade->aDBTables))
        {
            $this->assertTrue($oDB_Upgrade->_createAuditTable(),'failed to create database_action audit table');
        }
        return $oDB_Upgrade;
    }

}

?>
