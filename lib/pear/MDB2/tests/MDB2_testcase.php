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

class MDB2_TestCase extends PHPUnit_TestCase {
    //contains the dsn of the database we are testing
    var $dsn;
    //contains the options that should be used during testing
    var $options;
    //contains the name of the database we are testing
    var $database;
    //contains the MDB2 object of the db once we have connected
    var $db;
    // contains field names from the test table
    var $fields;
    // if the tables should be cleared in the setUp() and tearDown() methods
    var $clear_tables = true;

    function MDB2_TestCase($name) {
        $this->PHPUnit_TestCase($name);
    }

    function setUp() {
        $this->dsn = $GLOBALS['dsn'];
        $this->options  = $GLOBALS['options'];
        $this->database = $GLOBALS['database'];
        $this->db =& MDB2::factory($this->dsn, $this->options);
        $this->db->setDatabase($this->database);
        $this->db->expectError(MDB2_ERROR_UNSUPPORTED);
        $this->fields = array(
            'user_name' => 'text',
            'user_password' => 'text',
            'subscribed' => 'boolean',
            'user_id' => 'integer',
            'quota' => 'decimal',
            'weight' => 'float',
            'access_date' => 'date',
            'access_time' => 'time',
            'approved' => 'timestamp',
        );
        $this->clearTables();
    }

    function tearDown() {
        $this->clearTables();
        $this->db->popExpect();
        unset($this->dsn);
        if (!PEAR::isError($this->db)) {
            $this->db->disconnect();
        }
        unset($this->db);
    }

    function clearTables() {
        if (!$this->clear_tables) {
            return;
        }
        if ($this->tableExists('users'))
        {
            if (PEAR::isError($this->db->exec('DELETE FROM users'))) {
                $this->assertTrue(false, 'Error deleting from table users');
            }
        }
        if ($this->tableExists('files'))
        {
            if (PEAR::isError($this->db->exec('DELETE FROM files'))) {
                $this->assertTrue(false, 'Error deleting from table files');
            }
        }
    }

    function supported($feature) {
        if (!$this->db->supports($feature)) {
            $this->assertTrue(false, 'This database does not support '.$feature);
            return false;
        }
        return true;
    }

    function verifyFetchedValues(&$result, $rownum, $data) {
        $row = $result->fetchRow(MDB2_FETCHMODE_DEFAULT, $rownum);
        if (!is_array($row)) {
            $this->assertTrue(false, 'Error result row is not an array');
            return;
        }
        reset($row);
        foreach ($this->fields as $field => $type) {
            $value = current($row);
            if ($type == 'float') {
                $delta = 0.0000000001;
            } else {
                $delta = 0;
            }

            $this->assertEquals($value, $data[$field], "the value retrieved for field \"$field\" doesn't match what was stored into the rownum $rownum", $delta);
            next($row);
        }
    }

    function getSampleData($row = 1) {
        $data = array();
        $data['user_name']     = 'user_' . $row;
        $data['user_password'] = 'somepass';
        $data['subscribed']    = $row % 2 ? true : false;
        $data['user_id']       = $row;
        $data['quota']         = strval($row/100);
        $data['weight']        = sqrt($row);
        $data['access_date']   = MDB2_Date::mdbToday();
        $data['access_time']   = MDB2_Date::mdbTime();
        $data['approved']      = MDB2_Date::mdbNow();
        return $data;
    }

    function methodExists(&$class, $name) {
        if (is_object($class)
            && in_array(strtolower($name), array_map('strtolower', get_class_methods($class)))
        ) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name.' not implemented in '.get_class($class));
        return false;
    }

    function tableExists($table) {
        $this->db->loadModule('Manager', null, true);
        $tables = $this->db->manager->listTables();
        return in_array(strtolower($table), array_map('strtolower', $tables));
    }

    function verifyMDB2MappingResult($type, $result, $expected, $field='')
    {
        if (PEAR::isError($result))
        {
            $this->assertTrue(false, $result->getMessage().' : ** '.$k.' **');
        }
        else
        {
            $this->assertEquals($expected, $result, 'translation mismatch for mdb2type ** '.$type.' **'.print_r($field,true));
        }

    }


}

?>