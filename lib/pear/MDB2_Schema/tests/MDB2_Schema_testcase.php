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
        $this->dsn = $GLOBALS['dsn'];
        $this->options = $GLOBALS['options'];
        $this->database = $GLOBALS['database'];
        $backup_file = $this->driver_input_file.$this->backup_extension;
        if (file_exists($backup_file)) {
            unlink($backup_file);
        }
        $backup_file = $this->lob_input_file.$this->backup_extension;
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

    function methodExists(&$class, $name) {
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
            $this->driver_input_file,
            false,
            array('create' => '1', 'name' => $this->database)
        );
        if (PEAR::isError($result)) {
            $result = $this->schema->updateDatabase(
                $this->driver_input_file,
                false,
                array('create' => '0', 'name' => $this->database)
            );
        }
        if (!PEAR::isError($result)) {
            $result = $this->schema->updateDatabase(
                $this->lob_input_file,
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
        $backup_file = $this->driver_input_file.$this->backup_extension;
        if (!file_exists($backup_file)) {
            copy($this->driver_input_file, $backup_file);
        }
        $result = $this->schema->updateDatabase(
            $this->driver_input_file,
            $backup_file,
            array('create' =>'0', 'name' =>$this->database)
        );
        if (!PEAR::isError($result)) {
            $backup_file = $this->lob_input_file.$this->backup_extension;
            if (!file_exists($backup_file)) {
                copy($this->lob_input_file, $backup_file);
            }
            $result = $this->schema->updateDatabase(
                $this->lob_input_file,
                $backup_file,
                array('create' =>'0', 'name' => $this->database)
            );
        }
        $this->assertFalse(PEAR::isError($result), 'Error updating database');
    }
}

?>