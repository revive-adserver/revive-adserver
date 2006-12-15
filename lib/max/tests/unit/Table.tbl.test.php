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
$Id: Table.tbl.test.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

/**
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Table.php';
require_once 'Date.php';

/**
 * A class for testing the MAX_Table class.
 */
class MAX_TestOfMaxTable extends UnitTestCase
{
    
    /**
     * The constructor method.
     */
    function MAX_TestOfMaxTable()
    {        
        $this->UnitTestCase();
        
        // Mock the MAX_DB class
        Mock::generate('MAX_DB');
        
        // Partially mock the MAX_Table class
        Mock::generatePartial('MAX_Table', 'PartialMockMAX_Table', array('_createMaxDb'));
    }
    
    /**
     * A method to test the constructor method.
     *
     * Requirements:
     * Test 1: Ensure the constructor correctly creates and registers
     *         a MAX_DB instance.
     */
    function testConstructor()
    {
        // Mock the MAX_DB class
        $dbh = &new MockMAX_DB($this);
        
        // Partially mock the MAX_Table class
        $oTable = &new PartialMockMAX_Table($this);
        $oTable->setReturnReference('_createMaxDb', $dbh);
        
        // Test 1
        $oTable->MAX_Table();
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDb = &$oServiceLocator->get('MAX_DB');
        $this->assertEqual(strtolower(get_class($oMaxDb)), 'mockmax_db');
    }
    
    /**
     * A method to test the init method.
     *
     * Requirements:
     * Test 1: Check that false is returned if the SQL file is null.
     * Test 2: Check that false is returned if the SQL file does not exist.
     * Test 3: Check that false is returned if the SQL file is invalid.
     * Test 4: Check that true is returned if the SQL file is valid.
     */
    function testInit()
    {
        // Mock the MAX_DB class
        $dbh = &new MockMAX_DB($this);
        
        // Partially mock the MAX_Table class
        $oTable = &new PartialMockMAX_Table($this);
        $oTable->setReturnReference('_createMaxDb', $dbh);
        $oTable->MAX_Table();
        
        // Test 1
        $return = $oTable->init(null);
        $this->assertFalse($return);
        
        // Test 2
        $errorReporting = error_reporting();
        error_reporting($errorReporting ^ E_WARNING);
        $return = $oTable->init(MAX_PATH . '/this_file_doesnt_exist.sql');
        error_reporting($errorReporting);
        $this->assertFalse($return);
        
        // Test 3
        $fp = fopen(MAX_PATH . '/var/test.sql', 'w');
        fwrite($fp, "asdf;");
        fclose($fp);
        $return = $oTable->init(MAX_PATH . '/var/test.sql');
        $this->assertFalse($return);
        
        // Test 4
        $fp = fopen(MAX_PATH . '/var/test.sql', 'w');
        fwrite($fp, "CREATE TABLE IF NOT EXISTS foo (");
        fwrite($fp, "  a INTEGER");
        fwrite($fp, ");");
        fclose($fp);
        $return = $oTable->init(MAX_PATH . '/var/test.sql');
        $this->assertTrue($return);
        
        unlink(MAX_PATH . '/var/test.sql');
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
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = false;
        $oTable = &new MAX_Table();
        $fp = fopen(MAX_PATH . '/var/test.sql', 'w');
        fwrite($fp, "CREATE TABLE IF NOT EXISTS foo (\n");
        fwrite($fp, "  a INTEGER\n");
        fwrite($fp, ");\n");
        fclose($fp);
        $oTable->init(MAX_PATH . '/var/test.sql');
        $oTable->createTable('foo');
        $tables = $dbh->getListOf('tables');
        $this->assertEqual($tables[0], 'foo');
        TestEnv::restoreEnv();
        
        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        $oTable = &new MAX_Table();
        $fp = fopen(MAX_PATH . '/var/test.sql', 'w');
        fwrite($fp, "-- SPLIT TABLE foo;\n");
        fwrite($fp, "CREATE TABLE IF NOT EXISTS foo (\n");
        fwrite($fp, "  a INTEGER\n");
        fwrite($fp, ");\n");
        fclose($fp);
        $oTable->init(MAX_PATH . '/var/test.sql');
        $oDate = new Date();
        $oTable->createTable('foo', $oDate);
        $tables = $dbh->getListOf('tables');
        $this->assertEqual($tables[0], 'foo_' . $oDate->format('%Y%m%d'));
        unlink(MAX_PATH . '/var/test.sql');
        TestEnv::restoreEnv();
    }
    
    /**
     * A method to test the create all tables method.
     *
     * Requirements:
     * Test 1: Test that a table can be created.
     * Test 2: Test that multiple tables can be created.
     * Test 3: Test that a split table can be created.
     * Test 4: Test that multiple split tables can be created.
     */
    function testCreateAllTables()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = false;
        $oTable = &new MAX_Table();
        $fp = fopen(MAX_PATH . '/var/test.sql', 'w');
        fwrite($fp, "-- SPLIT TABLE foo;\n");
        fwrite($fp, "CREATE TABLE IF NOT EXISTS foo (\n");
        fwrite($fp, "  a INTEGER\n");
        fwrite($fp, ");\n");
        fclose($fp);
        $oTable->init(MAX_PATH . '/var/test.sql');
        $oTable->createTable('foo');
        $tables = $dbh->getListOf('tables');
        $this->assertEqual($tables[0], 'foo');
        TestEnv::restoreEnv();
        
        // Test 2
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = false;
        $oTable = &new MAX_Table();
        $fp = fopen(MAX_PATH . '/var/test.sql', 'w');
        fwrite($fp, "-- SPLIT TABLE foo;\n");
        fwrite($fp, "CREATE TABLE IF NOT EXISTS foo (\n");
        fwrite($fp, "  a INTEGER\n");
        fwrite($fp, ");\n");
        fwrite($fp, "-- SPLIT TABLE bar;\n");
        fwrite($fp, "CREATE TABLE IF NOT EXISTS bar (\n");
        fwrite($fp, "  a INTEGER\n");
        fwrite($fp, ");\n");
        fclose($fp);
        $oTable->init(MAX_PATH . '/var/test.sql');
        $oTable->createAllTables();
        $tables = $dbh->getListOf('tables');
        $this->assertEqual($tables[0], 'bar');
        $this->assertEqual($tables[1], 'foo');
        unlink(MAX_PATH . '/var/test.sql');
        TestEnv::restoreEnv();
        
        // Test 3
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        $oTable = &new MAX_Table();
        $fp = fopen(MAX_PATH . '/var/test.sql', 'w');
        fwrite($fp, "-- SPLIT TABLE foo;\n");
        fwrite($fp, "CREATE TABLE IF NOT EXISTS foo (\n");
        fwrite($fp, "  a INTEGER\n");
        fwrite($fp, ");\n");
        fclose($fp);
        $oTable->init(MAX_PATH . '/var/test.sql');
        $oDate = new Date();
        $oTable->createTable('foo', $oDate);
        $tables = $dbh->getListOf('tables');
        $this->assertEqual($tables[0], 'foo_' . $oDate->format('%Y%m%d'));
        TestEnv::restoreEnv();
        
        // Test 4
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        $oTable = &new MAX_Table();
        $fp = fopen(MAX_PATH . '/var/test.sql', 'w');
        fwrite($fp, "-- SPLIT TABLE foo;\n");
        fwrite($fp, "CREATE TABLE IF NOT EXISTS foo (\n");
        fwrite($fp, "  a INTEGER\n");
        fwrite($fp, ");\n");
        fwrite($fp, "-- SPLIT TABLE bar;\n");
        fwrite($fp, "CREATE TABLE IF NOT EXISTS bar (\n");
        fwrite($fp, "  a INTEGER\n");
        fwrite($fp, ");\n");
        fclose($fp);
        $oTable->init(MAX_PATH . '/var/test.sql');
        $oDate = new Date();
        $oTable->createAllTables($oDate);
        $tables = $dbh->getListOf('tables');
        $this->assertEqual($tables[0], 'bar_' . $oDate->format('%Y%m%d'));
        $this->assertEqual($tables[1], 'foo_' . $oDate->format('%Y%m%d'));
        unlink(MAX_PATH . '/var/test.sql');
        TestEnv::restoreEnv();
    }
    
    /**
     * A method to test the drop table method.
     *
     * Requirements:
     * Test 1: Test that a table can be dropped.
     */
    function testDropTable()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oTable = &new MAX_Table();
        $query = "CREATE TABLE foo ( a INTEGER )";
        $dbh->query($query);
        $tables = $dbh->getListOf('tables');
        $this->assertEqual($tables[0], 'foo');
        $oTable->dropTable('foo');
        $tables = $dbh->getListOf('tables');
        $this->assertEqual(count($tables), 0);
        TestEnv::restoreEnv();
    }
    
    /**
     * A method to test the drop temporary table method.
     *
     * Requirements:
     * Test 1: Test that a temporary table can be dropped.
     */
    function testDropTempTable()
    {
        // Test 1
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oTable = &new MAX_Table();
        $query = "CREATE TEMPORARY TABLE foo ( a INTEGER )";
        $dbh->query($query);
        // Test table exists with an insert
        $query = "INSERT INTO foo (a) VALUES (37)";
        $result = $dbh->query($query);
        $this->assertTrue($result);
        $oTable->dropTempTable('foo');
        // Test table does not exist with an insert
        $query = "INSERT INTO foo (a) VALUES (37)";
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertEqual(strtolower(get_class($result)), 'db_error');
        TestEnv::restoreEnv();
    }
}

?>
