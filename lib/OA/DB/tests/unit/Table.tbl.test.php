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
$Id$
*/

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once 'Date.php';

/**
 * A class for testing the OA_DB_Table class.
 *
 * @package    OpenadsDB
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_DB_Table extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_DB_Table()
    {
        $this->UnitTestCase();

        // Mock the OA_DB class
        Mock::generate('OA_DB');

        // Partially mock the OA_DB_Table class
        Mock::generatePartial(
            'OA_DB_Table',
            'PartialMockOA_DB_Table',
            array('_getDbConnection')
        );
    }

    /**
     * A private method to write out a test database schema in XML.
     *
     * @access private
     */
    function _writeTestDatabaseSchema()
    {
        $fp = fopen(MAX_PATH . '/var/test.xml', 'w');
        fwrite($fp, '<?xml version="1.0" encoding="ISO-8859-1" ?>');
        fwrite($fp, '<database>');
        fwrite($fp, ' <name>test_db</name>');
        fwrite($fp, ' <create>true</create>');
        fwrite($fp, ' <overwrite>false</overwrite>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>test_table</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_column</name>');
        fwrite($fp, '    <type>integer</type>');
        fwrite($fp, '    <length>4</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '   </field>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, '</database>');
        fclose($fp);
    }
    /**
     * A private method to write out a bigger test database schema in XML.
     *
     * @access private
     */
    function _writeBigTestDatabaseSchema()
    {
        $fp = fopen(MAX_PATH . '/var/test.xml', 'w');
        fwrite($fp, '<?xml version="1.0" encoding="ISO-8859-1" ?>');
        fwrite($fp, '<database>');
        fwrite($fp, ' <name>test_db</name>');
        fwrite($fp, ' <create>true</create>');
        fwrite($fp, ' <overwrite>false</overwrite>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>test_table</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_column</name>');
        fwrite($fp, '    <type>integer</type>');
        fwrite($fp, '    <length>4</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '   </field>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, ' <table>');
        fwrite($fp, '  <name>the_second_table</name>');
        fwrite($fp, '  <declaration>');
        fwrite($fp, '   <field>');
        fwrite($fp, '    <name>test_column</name>');
        fwrite($fp, '    <type>integer</type>');
        fwrite($fp, '    <length>4</length>');
        fwrite($fp, '    <notnull>true</notnull>');
        fwrite($fp, '   </field>');
        fwrite($fp, '  </declaration>');
        fwrite($fp, ' </table>');
        fwrite($fp, '</database>');
        fclose($fp);
    }

    /**
     * A method to test the constructor method.
     *
     * Requirements:
     * Test 1: Ensure the constructor correctly creates and registers
     *         an OA_DB object.
     */
    function testConstructor()
    {
        // Mock the OA_DB class
        $oDbh = new MockOA_DB($this);

        // Partially mock the OA_DB_Table class
        $oTable = new PartialMockOA_DB_Table($this);
        $oTable->setReturnReference('_getDbConnection', $oDbh);

        // Test 1
        $oTable->OA_DB_Table();
        $this->assertEqual(strtolower(get_class($oTable)), strtolower('PartialMockOA_DB_Table'));
        $oDbhReturn = $oTable->_getDbConnection();
        $this->assertIdentical($oDbh, $oDbhReturn);
    }

    /**
     * A method to test the init method.
     *
     * Requirements:
     * Test 1: Check that false is returned if the XML file is null.
     * Test 2: Check that false is returned if the XML file does not exist.
     * Test 3: Check that false is returned if the XML file is invalid.
     * Test 4: Check that true is returned if the XML file is valid.
     */
    function testInit()
    {
        $oTable = new OA_DB_Table();

        // Test 1
        $return = $oTable->init(null);
        $this->assertFalse($return);

        // Test 2
        $errorReporting = error_reporting();
        error_reporting($errorReporting ^ E_WARNING);
        $return = $oTable->init(MAX_PATH . '/this_file_doesnt_exist.xml');
        error_reporting($errorReporting);
        $this->assertFalse($return);

        // Test 3
        $fp = fopen(MAX_PATH . '/var/test.xml', 'w');
        fwrite($fp, "asdf;");
        fclose($fp);
        PEAR::pushErrorHandling(null);
        $return = $oTable->init(MAX_PATH . '/var/test.xml');
        PEAR::popErrorHandling();
        $this->assertFalse($return);

        // Test 4
        $this->_writeTestDatabaseSchema();
        $return = $oTable->init(MAX_PATH . '/var/test.xml');
        $this->assertTrue($return);

        unlink(MAX_PATH . '/var/test.xml');
    }

    /**
     * A method to test the create table method.
     *
     * Requirements:
     * Test 1: Test that a table can be created.
     * Test 2: Test that a split table can be created.
     */
    function testCreateTable()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['prefix'] = '';
        $conf['table']['split'] = false;
        $oTable = new OA_DB_Table();
        $this->_writeTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oTable->createTable('test_table');
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertEqual($aExistingTables[0], 'test_table');
        TestEnv::restoreEnv();

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $conf['table']['split'] = true;
        $conf['splitTables']['test_table'] = true;
        $oDbh = &OA_DB::singleton();
        $oTable = new OA_DB_Table();
        $this->_writeTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oDate = new Date();
        $oTable->createTable('test_table', $oDate);
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertEqual($aExistingTables[0], 'test_table_' . $oDate->format('%Y%m%d'));
        unlink(MAX_PATH . '/var/test.xml');
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the create all tables method.
     *
     * Requirements:
     * Test 1: Test that a table can be created.
     * Test 2: Test that multiple tables can be created.
     */
    function testCreateAllTables()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['prefix'] = '';
        $conf['table']['split'] = false;
        $oTable = new OA_DB_Table();
        $this->_writeTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oTable->createAllTables();
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertEqual($aExistingTables[0], 'test_table');
        TestEnv::restoreEnv();

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['prefix'] = '';
        $conf['table']['split'] = true;
        $conf['splitTables']['test_table'] = true;
        $oTable = new OA_DB_Table();
        $this->_writeBigTestDatabaseSchema();
        $oTable->init(MAX_PATH . '/var/test.xml');
        $oDate = new Date();
        $oTable->createAllTables($oDate);
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertEqual($aExistingTables[0], 'test_table_' . $oDate->format('%Y%m%d'));
        $this->assertEqual($aExistingTables[1], 'the_second_table');
        unlink(MAX_PATH . '/var/test.xml');
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the create required tables method.
     *
     * Requirements:
     * Test 1: Test with the Openads_Table_Core class, using
     *         the banners table.
     */
    function testCreateRequriedTables()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = '';
        $oDbh = &OA_DB::singleton();
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->createRequiredTables('banners');
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertEqual($aExistingTables[0], 'agency');
        $this->assertEqual($aExistingTables[1], 'banners');
        $this->assertEqual($aExistingTables[2], 'campaigns');
        $this->assertEqual($aExistingTables[3], 'clients');
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the drop table method.
     *
     * Requirements:
     * Test 1: Test that a table can be dropped.
     * Test 2: Test that a temporary table can be dropped.
     */
    function testDropTable()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oTable = new OA_DB_Table();
        $query = "CREATE TABLE foo ( a INTEGER )";
        $oDbh->query($query);
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertEqual($aExistingTables[0], 'foo');
        $oTable->dropTable('foo');
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertEqual(count($aExistingTables), 0);
        TestEnv::restoreEnv();

        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oTable = new OA_DB_Table();
        $query = "CREATE TEMPORARY TABLE foo ( a INTEGER )";
        $oDbh->query($query);
        // Test table exists with an insert
        $query = "INSERT INTO foo (a) VALUES (37)";
        $result = $oDbh->query($query);
        $this->assertTrue($result);
        $oTable->dropTable('foo');
        // Test table does not exist with an insert
        $query = "INSERT INTO foo (a) VALUES (37)";
        PEAR::pushErrorHandling(null);
        $result = $oDbh->query($query);
        PEAR::popErrorHandling();
        $this->assertEqual(strtolower(get_class($result)), 'mdb2_error');
        TestEnv::restoreEnv();
    }

}

?>
