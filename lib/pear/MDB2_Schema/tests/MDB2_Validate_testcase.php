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

class MDB2_Validate_TestCase extends PHPUnit_TestCase {
    //contains the dsn of the database we are testing
    var $dsn;
    //contains the options that should be used during testing
    var $options;
    //contains the name of the database we are testing
    var $database;
    //contains the MDB2_Schema object of the db once we have connected
    var $schema;

    function MDB2_Validate_Test($name) {
        $this->PHPUnit_TestCase($name);
    }

    function setUp() {
        PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'catchErrorHandlerPEAR');
        $this->dsn = $GLOBALS['dsn'];
        $this->options = $GLOBALS['options'];
        $this->database = $GLOBALS['database'];
        $this->dsn['database'] = $this->database;
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

    function test_validateDataFieldValue()
    {
        $fail_on_invalid_names = array();
        $valid_types = $this->schema->options['valid_types'];
        $force_defaults = '';

        $validator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);

        /* text */
        $field_name = 'test';
        $field_value = 'abc';
        $field_def['type'] = 'text';
        $field_def['length'] = 1;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test text value: should have failed field with value exceeding length');

        $field_name = 'test';
        $field_value = 'abc';
        $field_def['type'] = 'text';
        $field_def['length'] = 4;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue($result, 'test text value: should have passed field with value less than length');

        /* clob */
        $field_name = 'test';
        $field_value = 'abc';
        $field_def['type'] = 'clob';
        $field_def['length'] = 1;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test clob value: should have failed field with value exceeding length');

        $field_name = 'test';
        $field_value = 'abc';
        $field_def['type'] = 'clob';
        $field_def['length'] = 4;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test clob value: should have passed field with value less than length');

        /* 'blob'*/
        $field_name = 'test';
        $field_value = '3a71EA4';  // packed length = 4
        $field_def['type'] = 'blob';
        $field_def['length'] = 1;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test blob value: should have failed field with value exceeding length');

        $field_name = 'test';
        $field_value = '3a71EA4';  // packed length = 4
        $field_def['type'] = 'blob';
        $field_def['length'] = 8;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test blob value: should have passed field with value less than length');

        /* 'integer'*/
        $field_name = 'test';
        $field_value = 'xxx';
        $field_def['type'] = 'integer';
        $field_def['unsigned'] = 0;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test integer value: should have failed field with non-integer value');

        $field_name = 'test';
        $field_value = '999';
        $field_def['type'] = 'integer';
        $field_def['unsigned'] = 0;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test integer value: should have passed field with valid integer value');

        $field_name = 'test';
        $field_value = '-999';
        $field_def['type'] = 'integer';
        $field_def['unsigned'] = 1;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test integer value: should have failed signed field with integer value < 0');

        $field_name = 'test';
        $field_value = '-999';
        $field_def['type'] = 'integer';
        $field_def['unsigned'] = 0;
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test integer value: should have passeed unsigned field with integer value < 0');

        /* 'boolean'*/
        $field_name = 'test';
        $field_value = 't';
        $field_def['type'] = 'boolean';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test boolean value: should have passed field with value \'t\'');

        $field_name = 'test';
        $field_value = 'f';
        $field_def['type'] = 'boolean';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test boolean value: should have passed field with value \'f\'');

        /* 'date'*/
        $field_name = 'test';
        $field_value = 'CURRENT_DATE';
        $field_def['type'] = 'date';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test date value: should have passed field with value CURRENT_DATE');

        $field_name = 'test';
        $field_value = '01-01-2001';
        $field_def['type'] = 'date';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test date value: should have failed field with invalid date value: 01-01-2001');

        $field_name = 'test';
        $field_value = '2001-01-01';
        $field_def['type'] = 'date';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test date value: should have passed field with valid date value: 2001-01-01');

        $field_name = 'test';
        $field_value = '2001-01-41';
        $field_def['type'] = 'date';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test date value: should have passed field with valid date value: 2001-01-41');

        /* 'timestamp'*/
        $field_name = 'test';
        $field_value = 'CURRENT_TIME';
        $field_def['type'] = 'timestamp';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test timestamp value: should have passed field with value: CURRENT_TIME');

        $field_name = 'test';
        $field_value = '01-01-2001 01:01:01';
        $field_def['type'] = 'timestamp';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test timestamp value: should have failed field with invalid timestamp value: 01-01-2001 01:01:01');

        $field_name = 'test';
        $field_value = '01-01-2001 01:69:01';
        $field_def['type'] = 'timestamp';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test timestamp value: should have failed field with invalid timestamp value: 01-01-2001 01:69:01');

        $field_name = 'test';
        $field_value = '01-13-2001 01:01:01';
        $field_def['type'] = 'timestamp';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test timestamp value: should have failed field with invalid timestamp value: 01-13-2001 01:01:01');

        $field_name = 'test';
        $field_value = '2001-01-01 01:01:01';
        $field_def['type'] = 'timestamp';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test timestamp value: should have passed field with valid timestamp value: 2001-01-01 01:01:01');

        /* 'time'*/
        $field_name = 'test';
        $field_value = 'CURRENT_TIME';
        $field_def['type'] = 'time';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test time value: should have passed field with value: CURRENT_TIME');

        $field_name = 'test';
        $field_value = '01:01:71';
        $field_def['type'] = 'time';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test time value: should have failed field with invalid time value: 01:01:71');

        $field_name = 'test';
        $field_value = '01:69:01';
        $field_def['type'] = 'time';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test time value: should have failed field with invalid time value: 01:69:01');

        $field_name = 'test';
        $field_value = '33:01:01';
        $field_def['type'] = 'time';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test time value: should have failed field with invalid time value: 33:01:01');

        $field_name = 'test';
        $field_value = '01:01:01';
        $field_def['type'] = 'time';
        $result = $validator->validateDataFieldValue($field_def, $field_value, $field_name);
        $this->assertTrue(!PEAR::isError($result), 'test time value: should have passed field with valid time value: 2001-01-01 01:01:01');
    }

    function test_Reserved()
    {
        $this->checkReserved(true);
    }

    function checkReserved($assert)
    {
        $ok = isset($GLOBALS['_MDB2_Schema_Reserved']);
        if ($ok)
        {
            $ok =isset($GLOBALS['_MDB2_Schema_Reserved'][$this->dsn['phptype']]);
            if ($assert)
            {
                $this->asserttrue($ok, 'Reserved words global var not set for '.$this->dsn['phptype']);
            }
            if ($ok)
            {
                if ($assert)
                {
                    $this->assertTrue(count($GLOBALS['_MDB2_Schema_Reserved'][$this->dsn['phptype']])>0,'No reserver words in global array for '.$this->dsn['phptype']);
                }
                return true;

            }
        }
        if ($assert)
        {
            $this->assertTrue($ok, 'Reserved words global var not set');
        }
        return false;
    }

    function test_validateField()
    {
        $fail_on_invalid_names = array();
        $valid_types = $this->schema->options['valid_types'];
        $force_defaults = '';

        $validator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);

        /* Have we got a name? */
        $field_name = '';
        $field = array();
        $existing_fields = array();
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test field name: should have failed field with no name');

        /* Field name duplicated? */
        $field_name = 'test';
        $field = array();
        $existing_fields = array($field_name);
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test duplicate: should have failed field with duplicate name');
        /* Field name reserverd? */
        if ($this->checkReserved(false))
        {
            $validator->fail_on_invalid_names = array('mysql'=>array(), 'postgres'=>array());
            $field_name = 'column';
            $field = array();
            $existing_fields = array();
            $result = $validator->validateField($existing_fields, $field, $field_name);
            $this->assertTrue(PEAR::isError($result), 'test reserved: should have failed field with reserved name');

            $validator->fail_on_invalid_names = array('mysql'=>array('BLAH'), 'postgres'=>array());
            $field_name = 'blah';
            $field = array();
            $existing_fields = array();
            $result = $validator->validateField($existing_fields, $field, $field_name);
            $this->assertTrue(PEAR::isError($result), 'test reserved: should have failed field with reserved name');
            $validator->fail_on_invalid_names = array();
        }
        else
        {
            $this->assertTrue(false, 'cannot test fail_on_invalid_names owing to no reserved words loaded');
        }

        /* Type check */
        $field_name = 'test';
        $field = array();
        $existing_fields = array();
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test field type: should have failed field with no type');
        $field_name = 'test';
        $field = array();
        $field['type']='blah';
        $existing_fields = array();
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test field type: should have failed field with invalid type');

        /* Unsigned */
        $field_name = 'test';
        $field = array();
        $field['type'] = 'int';
        $field['unsigned'] = '';
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test unsigned: should have failed non-boolean unsigned field');

        /* Fixed */
        $field_name = 'test';
        $field = array();
        $field['type'] = 'text';
        $field['fixed'] = '';
        $existing_fields = array();
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test fixed: should have failed non-boolean fixed field');

        /* Length */
        $field_name = 'test';
        $field = array();
        $field['type'] = 'text';
        $field['length'] = '-1';
        $existing_fields = array();
        /**
         * @TODO Temporarily remove length checking...
         * see MDB2/Schema/Validate.php::validateField();
         */
        //$result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test length: should have failed length field < 0');

        /* Was */
        $field_name = 'test';
        $field = array();
        $field['type'] = 'text';
        $field['was'] = 'oldfield';
        $existing_fields = array();
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertEquals('oldfield',$field['was'], 'test was: field[\'was\'] changed by validator');

        $field_name = 'test';
        $field = array();
        $field['type'] = 'text';
        $field['was'] = '';
        $existing_fields = array();
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertEquals('test',$field['was'], 'test was: field[\'was\'] not assigned by validator');

        /* Notnull */
        $field_name = 'test';
        $field = array();
        $field['type'] = 'text';
        $field['notnull'] = '';
        $existing_fields = array();
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertFalse($field['notnull'], 'test notnull: should have assigned boolean to empty notnull field');

        $field_name = 'test';
        $field = array();
        $field['type'] = 'text';
        $field['notnull'] = 'xxx';
        $existing_fields = array();
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test notnull: should have failed notnull field with non-boolean value');

        /* Default */
        $field_name = 'test';
        $field = array();
        $field['type'] = 'text';
        $field['notnull'] = true;
        $existing_fields = array();
        $validator->force_defaults = true;
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertEquals($field['default'], $validator->valid_types['text'], 'test default notnull: validator assigned incorrect default notnull value');

        $field_name = 'test';
        $field = array();
        $field['type'] = 'text';
        $field['notnull'] = false;
        $existing_fields = array();
        $validator->force_defaults = true;
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertNull($field['default'], 'test default notnull: validator assigned incorrect default null value');

        $field_name = 'test';
        $field = array();
        $field['type'] = 'blob';
        $field['notnull'] = false;
        $field['default'] = 'xxx';
        $existing_fields = array();
        $validator->force_defaults = true;
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test default blob: validator should have failed on blob with default value');

        $field_name = 'test';
        $field = array();
        $field['type'] = 'date';
        $field['notnull'] = true;
        $field['default'] = 'xxx';
        $existing_fields = array();
        $validator->force_defaults = true;
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test valid default value: validator should have failed on incorrect default value for type');

        /* Autoincrement */
        $field_name = 'test';
        $field = array();
        $field['type'] = 'integer';
        $field['notnull'] = false;
        $field['autoincrement'] = '1';
        $existing_fields = array();
        $validator->force_defaults = true;
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertTrue(PEAR::isError($result), 'test autoincrement default: validator should have failed on invalid notnull for an autoincrement field');

        $field_name = 'test';
        $field = array();
        $field['type'] = 'integer';
        $field['notnull'] = true;
        $field['autoincrement'] = '1';
        $field['default'] = 'xxx';
        $existing_fields = array();
        $validator->force_defaults = false;
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertEquals(0, $field['default'], 'test autoincrement default: validator should have assigned  default value of 0 for an invalid autoincrement field default');

        $field_name = 'test';
        $field = array();
        $field['type'] = 'integer';
        $field['notnull'] = true;
        $field['autoincrement'] = '1';
        $field['default'] = '';
        $existing_fields = array();
        $validator->force_defaults = true;
        $result = $validator->validateField($existing_fields, $field, $field_name);
        $this->assertEquals(0, $field['default'], 'test autoincrement default: validator should have assigned  default value of 0 for an empty autoincrement field default');
    }

    function test_validateTable()
    {
        $fail_on_invalid_names = array();
        $valid_types = $this->schema->options['valid_types'];
        $force_defaults = '';

        $validator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);

        /* Have we got a name? */
        $tables = array();
        $table_name = '';
        $table = '';
        $result = $validator->validateTable($tables, $table, $table_name);
        $this->assertTrue(PEAR::isError($result), 'test validateTable: validator should have failed with no table name');

        /* Table name duplicated? */
        $tables = array('test'=>array());
        $table_name = 'test';
        $table = array();
        $result = $validator->validateTable($tables, $table, $table_name);
        $this->assertTrue(PEAR::isError($result), 'test validateTable: validator should have failed with duplicate table name');

        /* Table name reserved? */
        if ($this->checkReserved(false))
        {
            $validator->fail_on_invalid_names = array('mysql'=>array(), 'postgres'=>array());
            $tables = array();
            $table_name = 'column';
            $table = array();
            $result = $validator->validateTable($tables, $table, $table_name);
            $this->assertTrue(PEAR::isError($result), 'test validateTable reserved: should have failed table with reserved name');

            $validator->fail_on_invalid_names = array('mysql'=>array('BLAH'), 'postgres'=>array());
            $tables = array();
            $table_name = 'blah';
            $table = array();
            $result = $validator->validateTable($tables, $table, $table_name);
            $this->assertTrue(PEAR::isError($result), 'test validateTable reserved: should have failed table with reserved name');
            $validator->fail_on_invalid_names = array();
        }
        else
        {
            $this->assertTrue(false, 'cannot test validate table for reserved name owing to no reserved words loaded');
        }

        /* Was */
        $tables = array();
        $table_name = 'blah';
        $table = array();
        $table['was'] = 'oldtable';
        $result = $validator->validateTable($tables, $table, $table_name);
        $this->assertEquals('oldtable',$table['was'], 'test was: table[\'was\'] changed by validator');

        /* Autoincrement */
        // really should test this

        /* Checking Indexes */
        // and this
    }

    function test_validateIndex()
    {
        $fail_on_invalid_names = array();
        $valid_types = $this->schema->options['valid_types'];
        $force_defaults = '';

        $validator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);

        /* Have we got a name? */
        $table_indexes = array();
        $index_name = '';
        $index = '';
        $result =  $validator->validateIndex($table_indexes, $index, $index_name);
        $this->assertTrue(PEAR::isError($result), 'test validateIndex: validator should have failed with no index name');

        /* Index name duplicated? */
        $table_indexes = array('test'=>array());
        $index_name = 'test';
        $index = array();
        $result =  $validator->validateIndex($table_indexes, $index, $index_name);
        $this->assertTrue(PEAR::isError($result), 'test validateIndex: validator should have failed with duplicate index name');
        /* unique should have a boolean value*/
        $table_indexes = array();
        $index_name = 'test';
        $index = array();
        $index['unique'] = '9';
        $result =  $validator->validateIndex($table_indexes, $index, $index_name);
        $this->assertTrue(PEAR::isError($result), 'test validateIndex: validator should have failed with non-boolean [unique] value');

        $table_indexes = array();
        $index_name = 'test';
        $index = array();
        $index['unique'] = 'true';
        $result =  $validator->validateIndex($table_indexes, $index, $index_name);
        $this->assertTrue(!PEAR::isError($result), 'test validateIndex: validator should have passed with boolean [unique] value');

        /* primary should have a boolean value*/
        $table_indexes = array();
        $index_name = 'test';
        $index = array();
        $index['primary'] = '9';
        $result =  $validator->validateIndex($table_indexes, $index, $index_name);
        $this->assertTrue(PEAR::isError($result), 'test validateIndex: validator should have failed with non-boolean [primary] value');

        $table_indexes = array();
        $index_name = 'test';
        $index = array();
        $index['primary'] = 'true';
        $result =  $validator->validateIndex($table_indexes, $index, $index_name);
        $this->assertTrue(!PEAR::isError($result), 'test validateIndex: validator should have passed with boolean [primary] value');

        /* Was */
        $table_indexes = array();
        $index_name = 'test';
        $index = array();
        $index['was'] = 'oldindex';
        $result =  $validator->validateIndex($table_indexes, $index, $index_name);
        $this->assertEquals('oldindex',$index['was'], 'test was: index[\'was\'] changed by validator');

        /* Validator does not check for reserved words in index names*/

    }

}

?>