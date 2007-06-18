<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Manuel Lemos, Paul Cooper, Lorenzo Alberton  |
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
// | Authors: Paul Cooper <pgc@ucecom.com>                                |
// |          Lorenzo Alberton <l dot alberton at quipo dot it>           |
// +----------------------------------------------------------------------+
//
// $Id$

require_once 'MDB2_testcase.php';

class MDB2_Manager_TestCase extends MDB2_TestCase {
    //test table name (it is dynamically created/dropped)
    var $table = 'newtable';

    function setUp() {
        parent::setUp();
        $this->db->loadModule('Manager', null, true);
        $this->fields = array(
            'id' => array(
                'type'     => 'integer',
                'unsigned' => true,
                'notnull'  => true,
                'default'  => 0,
            ),
            'somename' => array(
                'type'     => 'text',
                'length'   => 12,
            ),
            'somedescription'  => array(
                'type'     => 'text',
                'length'   => 12,
            ),
            'sex' => array(
                'type'     => 'text',
                'length'   => 1,
                'default'  => 'M',
            ),
        );
        //$this->db->setOption('default_table_type', 'INNODB');
        if (!$this->tableExists($this->table))
        {
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

    /**
     * Create a sample table, test the new fields, and drop it.
     */
    function testCreateTable() {
        if (!$this->methodExists($this->db->manager, 'createTable')) {
            return;
        }
        if ($this->tableExists($this->table)) {
            $this->db->manager->dropTable($this->table);
        }

        $result = $this->db->manager->createTable($this->table, $this->fields);
        $this->assertFalse(PEAR::isError($result), 'Error creating table');
    }

    /**
     * Create a sample table, test the new fields, and drop it.
     */
    function testCreateAutoIncrementTable() {
        if (!$this->methodExists($this->db->manager, 'createTable')) {
            return;
        }
        if ($this->tableExists($this->table)) {
            $this->db->manager->dropTable($this->table);
        }

        $fields = $this->fields;
        $fields['id']['autoincrement'] = true;
        $result = $this->db->manager->createTable($this->table, $fields);
        $this->assertFalse(PEAR::isError($result), 'Error creating table');
        $query = 'INSERT INTO '.$this->table;
        $query.= ' (somename, somedescription)';
        $query.= ' VALUES (:somename, :somedescription)';
        $stmt =& $this->db->prepare($query, array('text', 'text'), MDB2_PREPARE_MANIP);
        if (PEAR::isError($stmt)) {
            $this->assertTrue(true, 'Preparing insert');
            return;
        }
        $values = array(
            'somename' => 'foo',
            'somedescription' => 'bar',
        );
        $rows = 5;
        for ($i =0; $i < $rows; ++$i) {
            $result = $stmt->execute($values);
            if (PEAR::isError($result)) {
                $this->assertFalse(true, 'Error executing autoincrementing insert number: '.$i);
                return;
            }
        }
        $stmt->free();
        $query = 'SELECT id FROM '.$this->table;
        $data = $this->db->queryCol($query);
        if (PEAR::isError($data)) {
            $this->assertTrue(true, 'Error executing select');
            return;
        }
        for ($i =0; $i < $rows; ++$i) {
            if (!isset($data[$i])) {
                $this->assertTrue(true, 'Error in data returned by select');
                return;
            }
            if ($data[$i] === ($i+1)) {
                $this->assertTrue(true, 'Error executing autoincrementing insert');
                return;
            }
        }
    }

    /**
     *
     */
    function testListTableFields() {
        if (!$this->methodExists($this->db->manager, 'listTableFields')) {
            return;
        }
        $this->assertEquals(
            array_keys($this->fields),
            $this->db->manager->listTableFields($this->table),
            'Error creating table: incorrect fields'
        );
    }

    /**
     *
     */
    function testCreateIndex() {
        if (!$this->methodExists($this->db->manager, 'createIndex')) {
            return;
        }
        $index = array(
            'fields' => array(
                'somename' => array(
                    'sorting' => 'ascending',
                ),
            ),
        );
        $name = 'simpleindex';
        $result = $this->db->manager->createIndex($this->table, $name, $index);
        $this->assertFalse(PEAR::isError($result), 'Error creating index');
    }

    /**
     *
     */
    function testDropIndex() {
        if (!$this->methodExists($this->db->manager, 'dropIndex')) {
            return;
        }
        $index = array(
            'fields' => array(
                'somename' => array(
                    'sorting' => 'ascending',
                ),
            ),
        );
        $name = 'simpleindex';
        $result = $this->db->manager->createIndex($this->table, $name, $index);
        if (PEAR::isError($result)) {
            $this->assertFalse(true, 'Error creating index');
        } else {
            $result = $this->db->manager->dropIndex($this->table, $name);
            $this->assertFalse(PEAR::isError($result), 'Error dropping index');
            $indices = $this->db->manager->listTableIndexes($this->table);
            $this->assertFalse(PEAR::isError($indices), 'Error listing indices');
            $this->assertFalse(in_array($name, $indices), 'Error dropping index');
        }
    }

    /**
     *
     */
    function testListIndexes() {
        if (!$this->methodExists($this->db->manager, 'listTableIndexes')) {
            return;
        }
        $index = array(
            'fields' => array(
                'somename' => array(
                    'sorting' => 'ascending',
                ),
            ),
        );
        $name = 'simpleindex';
        $result = $this->db->manager->createIndex($this->table, $name, $index);
        if (PEAR::isError($result)) {
            $this->assertFalse(true, 'Error creating index');
        } else {
            $indices = $this->db->manager->listTableIndexes($this->table);
            $this->assertFalse(PEAR::isError($indices), 'Error listing indices');
            $this->assertTrue(in_array($name, $indices), 'Error listing indices');
        }
    }

    /**
     *
     */
    function testCreatePrimaryKey() {
        if (!$this->methodExists($this->db->manager, 'createConstraint')) {
            return;
        }
        $index = array(
            'fields' => array(
                'id' => array(
                    'sorting' => 'ascending',
                ),
            ),
            'primary' => true,
        );
        $name = 'pkindex';
        $result = $this->db->manager->createConstraint($this->table, $name, $index);
        $this->assertFalse(PEAR::isError($result), 'Error creating primary index');
    }

    /**
     *
     */
    function testCreateUniqueConstraint() {
        if (!$this->methodExists($this->db->manager, 'createConstraint')) {
            return;
        }
        $index = array(
            'fields' => array(
                'somename' => array(
                    'sorting' => 'ascending',
                ),
            ),
            'unique' => true,
        );
        $name = 'uniqueindex';
        $result = $this->db->manager->createConstraint($this->table, $name, $index);
        $this->assertFalse(PEAR::isError($result), 'Error creating unique index');
    }

    /**
     *
     */
    function testDropPrimaryKey() {
        if (!$this->methodExists($this->db->manager, 'dropConstraint')) {
            return;
        }
        $index = array(
            'fields' => array(
                'id' => array(
                    'sorting' => 'ascending',
                ),
            ),
            'primary' => true,
        );
        $name = 'pkindex';
        $result = $this->db->manager->createConstraint($this->table, $name, $index);
        if (PEAR::isError($result)) {
            $this->assertFalse(true, 'Error creating primary index');
        } else {
            $result = $this->db->manager->dropConstraint($this->table, $name, true);
            $this->assertFalse(PEAR::isError($result), 'Error dropping primary key index');
        }
    }

    /**
     *
     */
    function testListConstraints() {
        if (!$this->methodExists($this->db->manager, 'listTableConstraints')) {
            return;
        }
        $index = array(
            'fields' => array(
                'id' => array(
                    'sorting' => 'ascending',
                ),
            ),
            'unique' => true,
        );
        $name = 'uniqueindex';
        $result = $this->db->manager->createConstraint($this->table, $name, $index);
        if (PEAR::isError($result)) {
            $this->assertFalse(true, 'Error creating unique index');
        } else {
            $constraints = $this->db->manager->listTableConstraints($this->table);
            $this->assertFalse(PEAR::isError($constraints), 'Error listing constraints');
            $this->assertTrue(in_array($name, $constraints), 'Error listing unique key index');
        }
    }

    /**
     *
     */
    function testListTables() {
        if (!$this->methodExists($this->db->manager, 'listTables')) {
            return;
        }
        $this->assertTrue($this->tableExists($this->table), 'Error listing tables');
    }

    /**
     *
     */
    function testAlterTable() {
        if (!$this->methodExists($this->db->manager, 'alterTable')) {
            return;
        }
        $newer = 'newertable';
        if ($this->tableExists($newer)) {
            $this->db->manager->dropTable($newer);
        }
        $changes = array(
            'add' => array(
                'quota' => array(
                    'type' => 'integer',
                    'unsigned' => 1,
                ),
                'note' => array(
                    'type' => 'text',
                    'length' => '20',
                ),
            ),
            'rename' => array(
                'sex' => array(
                    'name' => 'gender',
                    'definition' => array(
                        'type' => 'text',
                        'length' => 1,
                        'default' => 'M',
                    ),
                ),
            ),
            'change' => array(
                'id' => array(
                    'unsigned' => false,
                    'definition' => array(
                        'type'     => 'integer',
                        'notnull'  => false,
                        'default'  => 0,
                    ),
                ),
                'somename' => array(
                    'length' => '20',
                    'definition' => array(
                        'type' => 'text',
                        'length' => 20,
                    ),
                )
            ),
            'remove' => array(
                'somedescription' => array(),
            ),
            'name' => $newer,
        );

        $this->db->expectError(MDB2_ERROR_CANNOT_ALTER);
        $result = $this->db->manager->alterTable($this->table, $changes, true);
        $this->db->popExpect();
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Cannot alter table');
        } else {
            $result = $this->db->manager->alterTable($this->table, $changes, false);
            if (PEAR::isError($result)) {
                $this->assertTrue(true, 'Error altering table');
            } else {
                $this->db->manager->dropTable($newer);
            }
        }
    }

    /**
     *
     */
    function testAlterTable2() {
        if (!$this->methodExists($this->db->manager, 'alterTable')) {
            return;
        }
        $newer = 'newertable2';
        if ($this->tableExists($newer)) {
            $this->db->manager->dropTable($newer);
        }
        $changes_all = array(
            'add' => array(
                'quota' => array(
                    'type' => 'integer',
                    'unsigned' => 1,
                ),
            ),
            'rename' => array(
                'sex' => array(
                    'name' => 'gender',
                    'definition' => array(
                        'type' => 'text',
                        'length' => 1,
                        'default' => 'M',
                    ),
                ),
            ),
            'change' => array(
                'somename' => array(
                    'length' => '20',
                    'definition' => array(
                        'type' => 'text',
                        'length' => 20,
                    ),
                )
            ),
            'remove' => array(
                'somedescription' => array(),
            ),
            'name' => $newer,
        );

        foreach ($changes_all as $type => $change) {
            $changes = array($type => $change);
            $this->db->expectError(MDB2_ERROR_CANNOT_ALTER);
            $result = $this->db->manager->alterTable($this->table, $changes, true);
            $this->db->popExpect();
            if (PEAR::isError($result)) {
                $this->assertTrue(false, 'Cannot alter table: '.$type);
            } else {
                $result = $this->db->manager->alterTable($this->table, $changes, false);
                if (PEAR::isError($result)) {
                    $this->assertTrue(true, 'Error altering table: '.$type);
                } else {
                    switch ($type) {
                    case 'add':
                        $altered_table_fields = $this->db->manager->listTableFields($this->table);
                        foreach ($change as $newfield => $dummy) {
                            $this->assertTrue(in_array($newfield, $altered_table_fields), 'Error: new field "'.$newfield.'" not added');
                        }
                        break;
                    case 'rename':
                        $altered_table_fields = $this->db->manager->listTableFields($this->table);
                        foreach ($change as $oldfield => $newfield) {
                            $this->assertFalse(in_array($oldfield, $altered_table_fields), 'Error: field "'.$oldfield.'" not renamed');
                            $this->assertTrue(in_array($newfield['name'], $altered_table_fields), 'Error: field "'.$oldfield.'" not renamed correctly');
                        }
                        break;
                    case 'change':
                        break;
                    case 'remove':
                        $altered_table_fields = $this->db->manager->listTableFields($this->table);
                        foreach ($change as $newfield => $dummy) {
                            $this->assertFalse(in_array($newfield, $altered_table_fields), 'Error: field "'.$newfield.'" not removed');
                        }
                        break;
                    case 'name':
                        if ($this->tableExists($newer)) {
                            $this->db->manager->dropTable($newer);
                        } else {
                            $this->assertTrue(true, 'Error: table "'.$this->table.'" not renamed');
                        }
                        break;
                    }
                }
            }
        }
    }

    /**
     *
     */
    function testDropTable() {
        if (!$this->methodExists($this->db->manager, 'dropTable')) {
            return;
        }
        $result = $this->db->manager->dropTable($this->table);
        $this->assertFalse(PEAR::isError($result), 'Error dropping table');
    }

    /**
     *
     */
    function testListTablesNoTable() {
        if (!$this->methodExists($this->db->manager, 'listTables')) {
            return;
        }
        $result = $this->db->manager->dropTable($this->table);
        $this->assertFalse($this->tableExists($this->table), 'Error listing tables');
    }

    /**
     *
     */
    function testSequences() {
        if (!$this->methodExists($this->db->manager, 'createSequence')) {
            return;
        }
        $seq_name = 'testsequence';
        $result = $this->db->manager->createSequence($seq_name);
        $this->assertFalse(PEAR::isError($result), 'Error creating a sequence');
        $this->assertTrue(in_array($seq_name, $this->db->manager->listSequences()), 'Error listing sequences');
        $result = $this->db->manager->dropSequence($seq_name);
        $this->assertFalse(PEAR::isError($result), 'Error dropping a sequence');
        $this->assertFalse(in_array($seq_name, $this->db->manager->listSequences()), 'Error listing sequences');
    }

    function testGetTableStatus()
    {
        if (!$this->methodExists($this->db->manager, 'getTableStatus')) {
            return;
        }
        $result = $this->db->manager->getTableStatus($this->table);
        $this->assertTrue(is_array($result), 'table status did not return array');
        $this->assertEquals(1,count($result), 'wrong table status array count');
        $this->assertEquals($result[0]['auto_increment'],null, 'wrong auto_increment status value');
        $this->assertEquals($result[0]['data_length'],0, 'wrong data_length status value');
        $this->assertEquals($result[0]['rows'],0, 'wrong rows status value');
    }
}
?>