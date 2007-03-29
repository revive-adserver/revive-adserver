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


// Required files
//require_once MAX_DEV.'/lib/pear.inc.php';
//require_once 'MDB2.php';
//require_once 'MDB2/Schema.php';
//require_once 'Config.php';

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
    /**
     * The constructor method.
     */
    function Test_DB_Upgrade()
    {
        $this->UnitTestCase();
    }

    function test_constructor()
    {
        $oDB_Upgrade = & new OA_DB_Upgrade();
        $this->assertIsA($oDB_Upgrade, 'OA_DB_Upgrade', 'OA_DB_Upgrade not instantiated');
        $this->assertIsA($oDB_Upgrade->oSchema, 'MDB2_Schema', 'MDB2_Schema not instantiated');
        $this->assertIsA($oDB_Upgrade->oSchema->db, 'MDB2_Driver_Common', 'MDB2_Driver_Common not instantiated');
    }

    function test_sortIndexFields()
    {
        $fields = 'B_field1, E_field2, A_field3, D_field4, C_field5';
        $aFields = explode(',', $fields);
        $aResult = array('fields'=> array(
                                            $aFields[3]=>array('order'=>'4','sorting'=>'ascending'),
                                            $aFields[1]=>array('order'=>'2','sorting'=>'ascending'),
                                            $aFields[4]=>array('order'=>'5','sorting'=>'ascending'),
                                            $aFields[2]=>array('order'=>'3','sorting'=>'ascending'),
                                            $aFields[0]=>array('order'=>'1','sorting'=>'ascending'),
                                            )
                         );
        $oDB_Upgrade = new OA_DB_Upgrade();
        $aResult = $oDB_Upgrade->_sortIndexFields($aResult);
        $i = 0;
        foreach ($aResult['fields'] AS $field_name => $field_def)
        {
            $this->assertEqual($field_name,$aFields[$i],'field in wrong position');
            $i++;
        }
    }

    function test_createBackupAndRollback()
    {
        $oDB_Upgrade = & new OA_DB_Upgrade();
        $oDB_Upgrade->timing = 'constructive';
        $oDB_Upgrade->prefix = '';
        $oDB_Upgrade->versionFrom = 1;
        $oDB_Upgrade->aChanges['affected_tables']['constructive'] = array('table1');

        $this->_createTestTable($oDB_Upgrade->oSchema->db);

        $tbl_def_orig = $oDB_Upgrade->oSchema->getDefinitionFromDatabase(array('table1'));

        $this->assertTrue($oDB_Upgrade->_createBackup(),'_createBackup failed');
        $this->assertIsA($oDB_Upgrade->aRestoreTables, 'array', 'aRestoreTables not an array');
        $this->assertTrue(array_key_exists('table1', $oDB_Upgrade->aRestoreTables), 'table not found in aRestoreTables');
        $this->assertTrue(array_key_exists('bak', $oDB_Upgrade->aRestoreTables['table1']), 'backup table name not found for table table1');
        $this->assertTrue(array_key_exists('def', $oDB_Upgrade->aRestoreTables['table1']), 'definition array not found for table table1');

        $aDBTables = $this->_listTables($oDB_Upgrade);

        $table_bak = $oDB_Upgrade->aRestoreTables['table1']['bak'];
        $this->assertTrue(in_array($table_bak,$aDBTables), 'backup table not found in database');

        $tbl_def_bak = $oDB_Upgrade->oSchema->getDefinitionFromDatabase(array($table_bak));

        $tbl_def_orig = $tbl_def_orig['tables']['table1'];
        $tbl_def_bak  = $tbl_def_bak['tables'][$table_bak];

        foreach ($tbl_def_orig['fields'] AS $name=>$aType)
        {
            $this->assertTrue(array_key_exists($name, $tbl_def_bak['fields']), 'field missing from backup table');
        }

        $oDB_Upgrade->oSchema->db->manager->dropTable('table1');

        $aDBTables = $this->_listTables($oDB_Upgrade);
        $this->assertFalse(in_array('table1',$aDBTables), 'could not drop test table');

        $this->assertTrue($oDB_Upgrade->_rollback(), 'rollback failed');

        $aDBTables = $this->_listTables($oDB_Upgrade);
        $this->assertTrue(in_array('table1',$aDBTables), 'test table was not restored');

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

    function _createTestTable($oDbh)
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $conf['table']['split'] = false;
        $oTable = new OA_DB_Table();
        $oTable->init(MAX_PATH.'/www/devel/tests/unit/schema_test_1.xml');
        $oTable->createTable('table1');
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertTrue(in_array('table1', $aExistingTables), 'test table creation problem');

    }

    function _listTables($oDB_Upgrade)
    {
        $portability = $oDB_Upgrade->oSchema->db->getOption('portability');
        $oDB_Upgrade->oSchema->db->setOption('portability', MDB2_PORTABILITY_NONE);
        $aDBTables = $oDB_Upgrade->oSchema->db->manager->listTables();
        $oDB_Upgrade->oSchema->db->setOption('portability', $portability);
        return $aDBTables;
    }
}

?>
