<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Manuel Lemos, Paul Cooper                    |
// | All rights reserved.                                                 |
// +----------------------------------------------------------------------+
// | MDB2 is a merge of PEAR DB and Metabases that provides a unified DB  |
// | API as well as database abstraction for PHP applications.            |
// | This LICENSE is in the BSD license style.                            |
// |                                                                      |
// | Redistribution and use in source and binary forms, with or without   |
// | modification, are permitted provided that the following conditions   |
// | are met:                                                             |
// |                                                                      |
// | Redistributions of source code must retain the above copyright       |
// | notice, this list of conditions and the following disclaimer.        |
// |                                                                      |
// | Redistributions in binary form must reproduce the above copyright    |
// | notice, this list of conditions and the following disclaimer in the  |
// | documentation and/or other materials provided with the distribution. |
// |                                                                      |
// | Neither the name of Manuel Lemos, Tomas V.V.Cox, Stig. S. Bakken,    |
// | Lukas Smith nor the names of his contributors may be used to endorse |
// | or promote products derived from this software without specific prior|
// | written permission.                                                  |
// |                                                                      |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    |
// | FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE      |
// | REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,          |
// | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, |
// | BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS|
// |  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED  |
// | AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT          |
// | LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY|
// | WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE          |
// | POSSIBILITY OF SUCH DAMAGE.                                          |
// +----------------------------------------------------------------------+
// | Author: Paul Cooper <pgc@ucecom.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id$

require_once 'MDB2/Schema.php';

class MDB2_Schema_TestCase extends PHPUnit_TestCase {
    //contains the dsn of the database we are testing
    var $dsn;
    //contains the options that should be used during testing
    var $options;
    //contains the name of the database we are testing
    var $database;
    //contains the MDB2_Schema object of the db once we have connected
    var $schema;
    //contains the name of the driver_test schema
    var $driver_input_file = 'driver_test.schema';
    //contains the name of the lob_test schema
    var $lob_input_file = 'lob_test.schema';
    //contains the name of the extension to use for backup schemas
    var $backup_extension = '.before';

    function MDB2_Schema_Test($name) {
        $this->PHPUnit_TestCase($name);
    }

    function setUp() {
        PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'catchErrorHandlerPEAR');
        $this->dsn = $GLOBALS['dsn'];
        $this->options = $GLOBALS['options'];
        $this->database = $GLOBALS['database'];
        $this->dsn['database'] = $this->database;
        $backup_file = SCHEMA_PATH.$this->driver_input_file.$this->backup_extension;
        if (file_exists($backup_file)) {
            unlink($backup_file);
        }
        $backup_file = SCHEMA_PATH.$this->lob_input_file.$this->backup_extension;
        if (file_exists($backup_file)) {
            unlink($backup_file);
        }
        $this->schema =& MDB2_Schema::factory($this->dsn, $this->options);
        if (PEAR::isError($this->schema)) {
            $this->assertTrue(false, 'Could not connect to manager in setUp');
            exit;
        }
    }

    function tearDown() {
        unset($this->dsn);
        if (!PEAR::isError($this->schema)) {
            $this->schema->disconnect();
        }
        unset($this->schema);
    }

    function methodExists($class, $name) {
        if (is_object($class)
            && array_key_exists(strtolower($name), array_change_key_case(array_flip(get_class_methods($class)), CASE_LOWER))
        ) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name.' not implemented in '.get_class($class));
        return false;
    }

    function testCreateDatabase() {
        if (!$this->methodExists($this->schema->db->manager, 'dropDatabase')) {
            return;
        }
        $this->schema->db->expectError('*');
        $result = $this->schema->db->manager->dropDatabase($this->database);
        $this->schema->db->popExpect();
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Database dropping failed: please manually delete the database if needed');
        }
        if (!$this->methodExists($this->schema, 'updateDatabase')) {
            return;
        }
        $result = $this->schema->updateDatabase(
            SCHEMA_PATH.$this->driver_input_file,
            false,
            array('create' => '1', 'name' => $this->database)
        );
        if (PEAR::isError($result)) {
            $result = $this->schema->updateDatabase(
                SCHEMA_PATH.$this->driver_input_file,
                false,
                array('create' => '0', 'name' => $this->database)
            );
        }
        if (!PEAR::isError($result)) {
            $result = $this->schema->updateDatabase(
                SCHEMA_PATH.$this->lob_input_file,
                false,
                array('create' => '0', 'name' => $this->database)
            );
        }
        $this->assertFalse(PEAR::isError($result), 'Error creating database');
    }

    function testUpdateDatabase() {
        if (!$this->methodExists($this->schema, 'updateDatabase')) {
            return;
        }
        $result = is_writable(SCHEMA_PATH);
        if ($result)
        {
            $schema_file = SCHEMA_PATH.$this->driver_input_file;
            $backup_file = $schema_file.$this->backup_extension;
            if (!file_exists($backup_file)) {
                copy($schema_file, $backup_file);
            }
            $result = $this->schema->updateDatabase(
                $schema_file,
                $backup_file,
                array('create' =>'0', 'name' =>$this->database)
            );
            if (!PEAR::isError($result)) {
                $schema_file = SCHEMA_PATH.$this->lob_input_file;
                $backup_file = $schema_file.$this->backup_extension;
                if (!file_exists($backup_file)) {
                    copy($schema_file, $backup_file);
                }
                $result = $this->schema->updateDatabase(
                    $schema_file,
                    $backup_file,
                    array('create' =>'0', 'name' => $this->database)
                );
            }
            $this->assertFalse(PEAR::isError($result), 'Error updating database');
        }
        $this->assertTrue($result, 'Error: path is not writeable '.SCHEMA_PATH);
    }

    function test_CompareDefinitions()
    {
        if (!$this->methodExists($this->schema, 'compareDefinitions')) {
            return;
        }
        $schema_1 = SCHEMA_PATH.$this->driver_input_file;
        $schema_2 = SCHEMA_PATH.$this->driver_input_file.'2';

        $parse_prev = $this->schema->parseDatabaseDefinitionFile($schema_1, array('create' =>'0', 'name' =>$this->database));

        if (!PEAR::isError($parse_prev))
        {
            $parse_curr = $this->schema->parseDatabaseDefinitionFile($schema_2, array('create' =>'0', 'name' =>$this->database));

            if (!PEAR::isError($parse_curr))
            {
                $changes = $this->schema->compareDefinitions($parse_curr, $parse_prev);

                if (!PEAR::isError($changes))
                {
                    $this->assertTrue($changes['tables']['change']['users']['add'], 'Error in changeset result');
                    $this->assertTrue($changes['tables']['change']['users']['rename'], 'Error in changeset result');
                    $this->assertTrue($changes['tables']['change']['users']['remove'], 'Error in changeset result');
                    $this->assertTrue($changes['tables']['change']['users']['remove']['weight'], 'Error in changeset result');

                    $this->assertTrue($changes['tables']['change']['users']['add']['user_email'], 'Error in changeset result');
                    $this->assertEquals('text', $changes['tables']['change']['users']['add']['user_email']['type'], 'Error in changeset result');
                    $this->assertNull($changes['tables']['change']['users']['add']['user_email']['default'], 'Error in changeset result');
                    $this->assertFalse($changes['tables']['change']['users']['add']['user_email']['notnull'], 'Error in changeset result');
                    $this->assertEquals('user_email',$changes['tables']['change']['users']['add']['user_email']['was'], 'Error in changeset result');

                    $this->assertEquals('quota_total',$changes['tables']['change']['users']['rename']['quota']['name'], 'Error in changeset result');
                    $this->assertEquals(0,$changes['tables']['change']['users']['rename']['quota']['definition']['default'], 'Error in changeset result');
                    $this->assertEquals('decimal',$changes['tables']['change']['users']['rename']['quota']['definition']['type'], 'Error in changeset result');
                    $this->assertFalse($changes['tables']['change']['users']['rename']['quota']['definition']['notnull'], 'Error in changeset result');
                    $this->assertEquals('quota',$changes['tables']['change']['users']['rename']['quota']['definition']['was'], 'Error in changeset result');

                }
                else
                {
                    $this->assertTrue(false, 'Error comparing definitions : '.$changes->getMessage());
                }
            }
            else
            {
                $this->assertTrue(false, 'Error parsing schema_2 : '.$schema_2->getMessage());
            }
        }
        else
        {
            $this->assertTrue(false, 'Error parsing schema_1 : '.$schema_1->getMessage());
        }
    }

    function test_getDefinitionFromDatabase()
    {
        if (!$this->methodExists($this->schema, 'getDefinitionFromDatabase')) {
            return;
        }
        $def    = $this->schema->getDefinitionFromDatabase();
        if (!PEAR::isError($def))
        {
            $this->assertEquals('driver_test', $def['name'], 'Error in definition result');
            $this->assertTrue($def['create'], 'Error in definition result');
            $this->assertFalse($def['overwrite'], 'Error in definition result');
            $this->assertFalse($def['sequences'], 'Error in definition result');
            $this->assertTrue($def['tables'], 'Error in definition result');
            $this->assertTrue($def['tables']['users']['fields'], 'Error in definition result');
            $this->assertTrue($def['tables']['users']['indexes'], 'Error in definition result');
        }
        else
        {
            $this->assertTrue(false, 'Error retrieving database definition : '.$def->getMessage());
        }
    }

    function test_SchemaUpdate()
    {

        $def1 = array(
                        'name' => 'driver_test',
                        'create' => true,
                        'overwrite' => false,
                        'tables' => array(),
                        'sequences' => array(),
                     );
        $def1['tables'] = array( 'test' => array());
        $def1['tables']['test']['fields']['id'] = array (   'notnull' => 1,
                                                            'length' => 4,
                                                            'unsigned' => 0,
                                                            'default' => 0,
                                                            'type' => 'integer'
                                                        );
        $def1['tables']['test']['indexes'] =  array ( 'id_index' => array ('unique' => 1,
                                                                           'fields' =>  array ( 'id' =>
array ( 'sorting' => 'ascending' ) ) ) );

        // clean up before starting
        $this->_dropDatabase('driver_test');

        if (file_exists(SCHEMA_PATH.'mdb2test_1.schema')) {
            unlink(SCHEMA_PATH.'mdb2test_1.schema');
        }
        if (file_exists(SCHEMA_PATH.'mdb2test_2.schema')) {
            unlink(SCHEMA_PATH.'mdb2test_2.schema');
        }

        // create a database
        // parse database
        // dump definition
        $schema_1 = $this->_createAndDump($def1, 'mdb2test_1.schema', true);

        // change database
        // parse database
        // dump definition
        $def2 = $def1;
        $def2['tables']['test']['fields']['name'] = array ( 'notnull' => 1,
                                                            'length' => 64,
                                                            'default' => '',
                                                            'type' => 'text'
                                                        );
        $schema_2 = $this->_createAndDump($def2, 'mdb2test_2.schema', true);

        // compare definitions
        $this->assertTrue($schema_1 && $schema_2, 'definition file errors, unable to parse');

        $parse_prev = $this->schema->parseDatabaseDefinitionFile($schema_1, array());
        if (!PEAR::isError($parse_prev))
        {
            $parse_curr = $this->schema->parseDatabaseDefinitionFile($schema_2, array());
            if (!PEAR::isError($parse_curr))
            {
                $changes = $this->schema->compareDefinitions($parse_curr, $parse_prev);

                // recreate the old database
                $result = $this->schema->createDatabase( $parse_prev );
                if (PEAR::isError($result))
                {
                    $this->assertTrue(false, 'Database creation failed: '.$result->getMessage());
                    return false;
                }

                $this->assertTrue($this->schema->verifyAlterDatabase($changes),'error verifying alterations');
                // alterDatabase runs verifyAlterDatabase anyway
                $result = $this->schema->alterDatabase( $parse_prev, $parse_curr, $changes );
                if (PEAR::isError($result))
                {
                    $this->assertTrue(false, 'Database alteration failed: '.$result->getMessage());
                    return false;
                }
            }
        }
        if (file_exists(SCHEMA_PATH.'mdb2test_1.schema')) {
            unlink(SCHEMA_PATH.'mdb2test_1.schema');
        }
        if (file_exists(SCHEMA_PATH.'mdb2test_2.schema')) {
            unlink(SCHEMA_PATH.'mdb2test_2.schema');
        }
    }

    function _createAndDump( $def, $filename, $drop=false )
    {
        $result = $this->schema->createDatabase( $def );

        if (PEAR::isError($result))
        {
            $this->assertTrue(false, 'Database creation failed: '.$result->getMessage());
            return false;
        }
        $this->schema->db->database_name = $def['name'];
        $def = $this->schema->getDefinitionFromDatabase();

        if (PEAR::isError($def))
        {
            $this->assertTrue(false, 'Database definition retrieval failed: '.$def->getMessage());
            return false;
        }
        $dumpfile = SCHEMA_PATH.$filename;
        $options = array (  'output_mode'   =>    'file',
                            'output'        =>    $dumpfile,
                            'end_of_line'   =>    "\n"
                          );

        $result = $this->schema->dumpDatabase($def, $options, MDB2_SCHEMA_DUMP_STRUCTURE, false);

        if (PEAR::isError($result))
        {
            $this->assertTrue(false, 'Definition dump failed: '.$result->getMessage());
            return false;
        }

        if (file_exists($dumpfile))
        {
            if ($drop)
            {
                if ($this->_dropDatabase($this->schema->db->database_name))
                {
                    $this->database = '';
                }
            }
            return $dumpfile;
        }
        return false;
    }

    function _dropDatabase($name)
    {
        $this->schema->db->expectError('*');
        $result = $this->schema->db->manager->dropDatabase($name);
        $this->schema->db->popExpect();
        if (PEAR::isError($result))
        {
            $this->assertTrue(false, 'Database dropping failed: please manually delete the database '.$this->database);
            return false;
        }
        return true;
    }
}

?>