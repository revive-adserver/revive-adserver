<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Lukas Smith, Lorenzo Alberton                |
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
// | Author: Lorenzo Alberton <l dot alberton at quipo dot it>            |
// +----------------------------------------------------------------------+
//
// $Id$

require_once 'MDB2_testcase.php';

class MDB2_Reverse_TestCase extends MDB2_TestCase
{
    //test table name (it is dynamically created/dropped)
    var $table       = 'testtable';
    var $fields      = array();
    var $indices     = array();
    var $constraints = array();

    function setUp() {
        parent::setUp();
        $this->db->loadModule('Reverse', null, true);
        $this->db->loadModule('Manager', null, true);

        //Table structure
        $this->fields = array(
            'id' => array(  //PK
                'type'     => 'integer',
                'unsigned' => 1,
                'notnull'  => 1,
                'default'  => 0,
                'length'  => 4,
            ),
            'id2' => array( //UNIQUE_MULTIFIELD(1/2)
                'type'     => 'integer',
                'unsigned' => 1,
                'notnull'  => 1,
                'default'  => 0,
            ),
            'id3' => array( //UNIQUE_MULTIFIELD(2/2)
                'type'     => 'integer',
                'unsigned' => 1,
                'notnull'  => 1,
                'default'  => 0,
            ),
            'id4' => array( //UNIQUE
                'type'     => 'integer',
                'unsigned' => 1,
                'notnull'  => 1,
                'default'  => 0,
            ),
            'somename' => array( //NORMAL INDEX
                'type'   => 'text',
                'length' => 12,
            ),
            'somedescription' => array( //INDEX_MULTIFIELD(1/2)
                'type'   => 'text',
                'length' => 12,
            ),
            'sex' => array( //INDEX_MULTIFIELD(2/2)
                'type' => 'text',
                'length' => 1,
                'default' => 'M',
            ),
        );

        if (!$this->tableExists($this->table)) {
            $this->db->manager->createTable($this->table, $this->fields);
        }
    }

    function tearDown() {
        if ($this->tableExists($this->table)) {
            $this->db->manager->dropTable($this->table);
        }
        $this->db->popExpect();
        unset($this->dsn);
        if (!PEAR::isError($this->db->manager)) {
            $this->db->disconnect();
        }
        unset($this->db);
    }

    function setUpIndices()
    {
        //Indices definition
        $this->indices = array(
            'sometestindex' => array(
                'fields' => array(
                    'somename' => array(
                        'sorting' => 'ascending',
                    ),
                ),
                'unique' => false,
            ),
            'multipletestindex' => array(
                'fields' => array(
                    'somedescription' => array(
                        'sorting' => 'ascending',
                    ),
                    'sex' => array(
                        'sorting' => 'ascending',
                    ),
                ),
            ),
        );
        foreach ($this->indices as $index_name => $index) {
            $result = $this->db->manager->createIndex($this->table, $index_name, $index);
            $this->assertFalse(PEAR::isError($result), 'Error creating index: '.$index_name);
            if (PEAR::isError($result)) {
                break;
            }
        }
        return PEAR::isError($result);
    }

    function setUpConstraints()
    {
        //Constraints definition
        $this->constraints = array(
            'pkfield' => array(
                'fields' => array(
                    'id' => array(
                        'sorting' => 'ascending',
                    ),
                ),
                'primary' => true,
            ),
            'multipleunique' => array(
                'fields' => array(
                    'id2' => array(
                        'sorting' => 'ascending',
                    ),
                    'id3' => array(
                        'sorting' => 'ascending',
                    ),
                ),
                'unique' => true,
            ),
            'singleunique' => array(
                'fields' => array(
                    'id4' => array(
                        'sorting' => 'ascending',
                    ),
                ),
                'unique' => true,
            ),
        );
        foreach ($this->constraints as $constraint_name => $constraint) {
            $result = $this->db->manager->createConstraint($this->table, $constraint_name, $constraint);
            $this->assertFalse(PEAR::isError($result), 'Error creating constraint: '.$constraint_name);
            if (PEAR::isError($result)) {
                break;
            }
        }
        return PEAR::isError($result);
    }

    /**
     * Test tableInfo('table_name')
     */
    function testTableInfo()
    {
        if (!$this->methodExists($this->db->reverse, 'tableInfo')) {
            return;
        }

        $table_info = $this->db->reverse->tableInfo($this->table);
        if (PEAR::isError($table_info)) {
            $this->assertTrue(false, 'Error in tableInfo(): '.$table_info->getMessage());
        } else {
            $this->assertEquals(count($this->fields), count($table_info), 'The number of fields retrieved is different from the expected one');
            foreach ($table_info as $field_info) {
                $this->assertEquals($this->table, $field_info['table'], "the table name is not correct");
                if (!array_key_exists(strtolower($field_info['name']), $this->fields)) {
                    $this->assertTrue(false, 'Field names do not match ('.$field_info['name'].' is unknown)');
                }
                //expand test, for instance adding a check on types...
            }
        }

        if (!$this->supported('result_introspection')) {
            return;
        }

        $result = $this->db->query('SELECT * FROM '.$this->table);
        $table_info = $this->db->reverse->tableInfo($result);
        if (PEAR::isError($table_info)) {
            $this->assertTrue(false, 'Error in tableInfo(): '.$table_info->getMessage());
        } else {
            $this->assertEquals(count($this->fields), count($table_info), 'The number of fields retrieved is different from the expected one');
            foreach ($table_info as $field_info) {
                // Hack! Alas, the tableInfo() method above relys on the built in PHP function
                // pg_field_table() when the MDB2_Driver_pgsql is in use, but the built in did
                // not make it into PHP until 5.2.0. As a result, only want to test the table
                // info is set when NOT using the pgsql driver, or, the driver is in use, when
                // the PHP version is appropriate
                $checkTableInfo = true;
                if (is_a($this->db, "MDB2_Driver_pgsql")) {
                    if (version_compare(PHP_VERSION, "5.2.0", "<")) {
                        $checkTableInfo = false;
                    }
                }
                if ($checkTableInfo) {
                    $this->assertEquals($this->table, $field_info['table'], "the table name is not correct");
                } else {
                    $this->assertEquals('', $field_info['table'], "the table name is not correct");
                }
                if (!array_key_exists(strtolower($field_info['name']), $this->fields)) {
                    $this->assertTrue(false, 'Field names do not match ('.$field_info['name'].' is unknown)');
                }
                //expand test, for instance adding a check on types...
            }
        }
        $result->free();
    }

    /**
     * Test getTableFieldDefinition($table, $field_name)
     */
    function testGetTableFieldDefinition()
    {
        if (!$this->methodExists($this->db->reverse, 'getTableFieldDefinition')) {
            return;
        }

        //test integer not null
        $field_info = $this->db->reverse->getTableFieldDefinition($this->table, 'id');
        if (PEAR::isError($field_info)) {
            $this->assertTrue(false, 'Error in getTableFieldDefinition(): '.$field_info->getMessage());
        } else {
            $field_info = array_shift($field_info);
            $this->assertEquals($field_info['type'], 'integer', 'The field type is different from the expected one');
            $this->assertEquals($field_info['length'], 4, 'The field length is different from the expected one');
            $this->assertTrue($field_info['notnull'], 'The field can be null unlike it was expected');
            $this->assertEquals($field_info['default'], '0', 'The field default value is different from the expected one');
        }

        //test blob
        $field_info = $this->db->reverse->getTableFieldDefinition('files', 'picture');
        if (PEAR::isError($field_info)) {
            $this->assertTrue(false, 'Error in getTableFieldDefinition(): '.$field_info->getMessage());
        } else {
            $field_info = array_shift($field_info);
            $this->assertEquals($field_info['type'], 'blob', 'The field type is different from the expected one');
            $this->assertFalse($field_info['notnull'], 'The field cannot be null unlike it was expected');
        }

        //test varchar(100) not null
        $field_info = $this->db->reverse->getTableFieldDefinition('users', 'user_name');
        if (PEAR::isError($field_info)) {
            $this->assertTrue(false, 'Error in getTableFieldDefinition(): '.$field_info->getMessage());
        } else {
            $field_info = array_shift($field_info);
            $this->assertEquals($field_info['type'], 'text', 'The field type is different from the expected one');
            $this->assertEquals($field_info['length'], 12, 'The field length is different from the expected one');
            $this->assertFalse($field_info['notnull'], 'The field can be null unlike it was expected');
            $this->assertNull($field_info['default'], 'The field default value is different from the expected one');
            $this->assertFalse($field_info['fixed'], 'The field fixed value is different from the expected one');
        }

        //test decimal
        $field_info = $this->db->reverse->getTableFieldDefinition('users', 'quota');
        if (PEAR::isError($field_info)) {
            $this->assertTrue(false, 'Error in getTableFieldDefinition(): '.$field_info->getMessage());
        } else {
            $field_info = array_shift($field_info);
            $this->assertEquals($field_info['type'], 'decimal', 'The field type is different from the expected one');
        }
    }

    /**
     * Test getTableIndexDefinition($table, $index_name)
     */
    function testGetTableIndexDefinition()
    {
        if (!$this->methodExists($this->db->reverse, 'getTableIndexDefinition')) {
            return;
        }

        $this->setUpIndices();

        //test index names
        foreach ($this->indices as $index_name => $index) {
            $index_info = $this->db->reverse->getTableIndexDefinition($this->table, $index_name);
            if (PEAR::isError($index_info)) {
                $this->assertFalse(true, 'Error getting table index definition');
            } else {
                $field_names = array_keys($index['fields']);
                $this->assertEquals($field_names, array_keys($index_info['fields']), 'Error listing index fields');
            }
        }

        //test INDEX
        $index_name = 'sometestindex';
        $index_info = $this->db->reverse->getTableIndexDefinition($this->table, $index_name);
        if (PEAR::isError($index_info)) {
            $this->assertTrue(false, 'Error in getTableIndexDefinition(): '.$index_info->getMessage());
        } else {
            $this->assertEquals(1, count($index_info['fields']), 'The INDEX is not on one field unlike it was expected');
            $expected_fields = array_keys($this->indices[$index_name]['fields']);
            $actual_fields = array_keys($index_info['fields']);
            $this->assertEquals($expected_fields, $actual_fields, 'The INDEX field names don\'t match');
        }

        //test INDEX on MULTIPLE FIELDS
        $index_name = 'multipletestindex';
        $index_info = $this->db->reverse->getTableIndexDefinition($this->table, $index_name);
        if (PEAR::isError($index_info)) {
            $this->assertTrue(false, 'Error in getTableIndexDefinition(): '.$index_info->getMessage());
        } else {
            $this->assertEquals(2, count($index_info['fields']), 'The INDEX is not on two fields unlike it was expected');
            $expected_fields = array_keys($this->indices[$index_name]['fields']);
            $actual_fields = array_keys($index_info['fields']);
            $this->assertEquals($expected_fields, $actual_fields, 'The INDEX field names don\'t match');
        }

        if (!$this->setUpConstraints()) {
            return;
        }
        //constraints should NOT be listed
        foreach (array_keys($this->constraints) as $constraint_name) {
            $this->db->expectError(MDB2_ERROR_NOT_FOUND);
            $result = $this->db->reverse->getTableIndexDefinition($this->table, $constraint_name);
            $this->assertTrue(PEAR::isError($result), 'Error listing index definition, this is a CONSTRAINT');
        }
    }

    /**
     * Test testGetTableConstraintDefinition($table, $constraint_name)
     */
    function testGetTableConstraintDefinition()
    {
        if (!$this->methodExists($this->db->reverse, 'getTableConstraintDefinition')) {
            return;
        }

        if (!$this->setUpConstraints()) {
            return;
        }

        //test constraint names
        foreach ($this->constraints as $constraint_name => $constraint) {
            $this->db->expectError(MDB2_ERROR_NOT_FOUND);
            $result = $this->db->reverse->getTableConstraintDefinition($this->table, $constraint_name);
            $this->db->popExpect();
            if (PEAR::isError($result) && isset($constraint['primary']) && $constraint['primary']) {
                echo 'Error reading primary constraint, trying with name "primary" instead .. ';
                $constraint_name = 'primary';
                $result = $this->db->reverse->getTableConstraintDefinition($this->table, $constraint_name);
            }
            if (PEAR::isError($result)) {
                $this->assertFalse(true, 'Error getting table constraint definition');
            } else {
                $constraint_names = array_keys($constraint['fields']);
                $this->assertEquals($constraint_names, array_keys($result['fields']), 'Error listing constraint fields');
            }
        }

        $this->setUpIndices();
        //indices should NOT be listed
        foreach (array_keys($this->indices) as $index_name) {
            $this->db->expectError(MDB2_ERROR_NOT_FOUND);
            $result = $this->db->reverse->getTableConstraintDefinition($this->table, $index_name);
            $this->db->popExpect();
            $this->assertTrue(PEAR::isError($result), 'Error listing constraint definition, this is a normal INDEX');
        }

        //test PK
        $this->db->expectError(MDB2_ERROR_NOT_FOUND);
        $constraint_info = $this->db->reverse->getTableConstraintDefinition($this->table, 'pkfield');
        $this->db->popExpect();
        if (PEAR::isError($constraint_info)) {
            echo 'Error reading primary constraint, trying with name "primary" instead .. ';
            $constraint_info = $this->db->reverse->getTableConstraintDefinition($this->table, 'primary');
        }
        if (PEAR::isError($constraint_info)) {
            $this->assertTrue(false, 'Error in getTableConstraintDefinition(): '.$constraint_info->getMessage());
        } else {
            $this->assertTrue($constraint_info['primary'], 'The field is not a PK unlike it was expected');
        }

        //test UNIQUE
        $constraint_name = 'singleunique';
        $constraint_info = $this->db->reverse->getTableConstraintDefinition($this->table, $constraint_name);
        if (PEAR::isError($constraint_info)) {
            $this->assertTrue(false, 'Error in getTableConstraintDefinition(): '.$constraint_info->getMessage());
        } else {
            $this->assertTrue($constraint_info['unique'], 'The field is not a PK unlike it was expected');
            $this->assertTrue(empty($constraint_info['primary']), 'The field is a PK unlike it was expected');
            $this->assertEquals(1, count($constraint_info['fields']), 'The UNIQUE INDEX is not on one field unlike it was expected');
            $expected_fields = array_keys($this->constraints[$constraint_name]['fields']);
            $actual_fields = array_keys($constraint_info['fields']);
            $this->assertEquals($expected_fields, $actual_fields, 'The UNIQUE INDEX field names don\'t match');
        }

        //test UNIQUE on MULTIPLE FIELDS
        $constraint_name = 'multipleunique';
        $constraint_info = $this->db->reverse->getTableConstraintDefinition($this->table, $constraint_name);
        if (PEAR::isError($constraint_info)) {
            $this->assertTrue(false, 'Error in getTableConstraintDefinition(): '.$constraint_info->getMessage());
        } else {
            $this->assertTrue($constraint_info['unique'], 'The field is not a PK unlike it was expected');
            $this->assertTrue(empty($constraint_info['primary']), 'The field is a PK unlike it was expected');
            $this->assertEquals(2, count($constraint_info['fields']), 'The UNIQUE INDEX is not on two fields unlike it was expected');
            $expected_fields = array_keys($this->constraints[$constraint_name]['fields']);
            $actual_fields = array_keys($constraint_info['fields']);
            $this->assertEquals($expected_fields, $actual_fields, 'The UNIQUE INDEX field names don\'t match');
        }
    }

    /**
     * Test getSequenceDefinition($sequence)
     */
    function testGetSequenceDefinition() {
        //setup
        $this->db->loadModule('Manager', null, true);
        $sequence = 'test_sequence';
        $sequences = $this->db->manager->listSequences();
        if (!in_array($sequence, $sequences)) {
            $result = $this->db->manager->createSequence($sequence);
            $this->assertFalse(PEAR::isError($result), 'Error creating a sequence');
        }

        //test
        $start = $this->db->nextId($sequence);
        $def = $this->db->reverse->getSequenceDefinition($sequence);
        $this->assertEquals($start+1, $def['start'], 'Error getting sequence definition');

        //cleanup
        $result = $this->db->manager->dropSequence($sequence);
        $this->assertFalse(PEAR::isError($result), 'Error dropping a sequence');
    }
}
?>