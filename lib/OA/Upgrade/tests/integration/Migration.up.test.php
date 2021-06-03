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

require_once MAX_PATH.'/lib/OA/Upgrade/Migration.php';


/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_Migration extends UnitTestCase
{

    var $path;

    var $aChangesVars;
    var $aOptions;

    var $aDefinition;
    var $oDbh;
    var $oTable;

    var $test_schema_file;

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function setUp()
    {
        $this->oDbh = OA_DB::singleton(OA_DB::getDsn());
        $this->oTable = new OA_DB_Table();
        $this->oTable->init(MAX_PATH.'/lib/OA/Upgrade/tests/data/migration_test_1.xml');
        $this->aDefinition = $this->oTable->aDefinition;
    }

    function test_replaceColumns()
    {
        $this->_createTestTables();
        $this->_insertTestData(array(1=>'1st text field'));
        $this->_insertTestData(array(2=>'2nd text field'));
        $this->_insertTestData(array(3=>'3rd text field'));
        $oMigration = new Migration();
        $oMigration->init($this->oDbh, MAX_PATH . "/var/DB_Upgrade.test.log");
        $oMigration->aDefinition = $this->aDefinition;
        $toTable    = 'table1';
        $toField    = 'a_text_field_new';
        $fromTable  = 'table1';
        $fromField  = 'a_text_field';
        $oMigration->updateColumn($fromTable, $fromField, $toTable, $toField);
        $this->assertEqual(count($oMigration->aErrors),0);
        $this->assertEqual($oMigration->affectedRows, 3, 'wrong number of rows inserted');
        $this->_dropTestTables();
    }

    function test_afterAddField()
    {
        $this->_createTestTables();
        $this->_insertTestData(array(1=>'1st text field'));
        $this->_insertTestData(array(2=>'2nd text field'));
        $this->_insertTestData(array(3=>'3rd text field'));
        $oMigration = new Migration();
        $oMigration->init($this->oDbh, MAX_PATH . "/var/DB_Upgrade.test.log");
        $oMigration->aDefinition = $this->aDefinition;
        $oMigration->aObjectMap['table1']['a_text_field_new'] = array('fromTable'=>'table1', 'fromField'=>'a_text_field');
        $oMigration->afterAddField('table1', 'a_text_field_new');
        $this->assertEqual(count($oMigration->aErrors),0);
        $this->assertEqual($oMigration->affectedRows, 3, 'wrong number of rows inserted');
        $this->_dropTestTables();
    }

//    function test_insertColumnData()
//    {
//        $this->_createTestTables();
//        $this->_insertTestData(array(1=>'first text field'));
//        $oMigration = new Migration();
//        $oMigration->init($this->oDbh);
//        $oMigration->insertColumnData('table1', 'b_id_field', 'table2', 'b_id_field2');
//        $this->assertEqual($oMigration->affectedRows, 1, 'wrong number of rows inserted');
//        $this->_dropTestTables();
//    }
//
//    function test_copyTableData()
//    {
//        $this->_createTestTables();
//        $this->_insertTestData(array(1=>'1st text field'));
//        $this->_insertTestData(array(2=>'2nd text field'));
//        $this->_insertTestData(array(3=>'3rd text field'));
//        $oMigration = new Migration();
//        $oMigration->init($this->oDbh);
//        $oMigration->copyTableData('table1', 'table2');
//        $this->assertEqual($oMigration->affectedRows, 3, 'wrong number of rows inserted');
//        $this->_dropTestTables();
//    }

    /**
     * internal function to set up some test tables
     *
     * @param mdb2 connection $oDbh
     */
    function _createTestTables()
    {
        $this->_dropTestTables();
        $conf =& $GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $this->assertTrue($this->oTable->createTable('table1'),'error creating test table1');
        $this->assertTrue($this->oTable->createTable('table2'),'error creating test table2');
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertTrue(in_array('table1', $aExistingTables), '_createTestTables');
        $this->assertTrue(in_array('table2', $aExistingTables), '_createTestTables');
    }

    function _insertTestData($aData)
    {
        $aDef = $this->aDefinition['tables']['table1']['fields'];
        $aDef['b_id_field']['key'] = true;
        $expect = count($aData);
        foreach ($aData as $k=>$v)
        {
            $aDef['b_id_field']['value'] = $k;
            $aDef['a_text_field']['value'] = $v;
            $this->assertEqual($this->oDbh->replace('table1', $aDef),1,'error inserting test data');
        }
    }

    function _dropTestTables()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        if (in_array('table1', $aExistingTables))
        {
            $this->assertTrue($this->oTable->dropTable('table1'),'error dropping test table1');
        }
        if (in_array('table2', $aExistingTables))
        {
            $this->assertTrue($this->oTable->dropTable('table2'),'error dropping test table2');
        }
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertFalse(in_array('table1', $aExistingTables), '_dropTestTables');
        $this->assertFalse(in_array('table2', $aExistingTables), '_dropTestTables');
    }
}

?>
