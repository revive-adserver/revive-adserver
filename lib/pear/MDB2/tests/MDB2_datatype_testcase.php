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

class MDB2_Datatype_TestCase extends MDB2_TestCase
{
    //test table name (it is dynamically created/dropped)
    var $table = 'datatypetable';

    function setUp() {
        parent::setUp();
        $this->db->loadModule('Manager', null, true);
        $this->fields = array(
            'id' => array(
                'type'       => 'integer',
                'unsigned'   => true,
                'notnull'    => true,
                'default'    => 0,
            ),
            'textfield'      => array(
                'type'       => 'text',
                'length'     => 12,
            ),
            'booleanfield'   => array(
                'type'       => 'boolean',
            ),
            'decimalfield'   => array(
                'type'       => 'decimal',
            ),
            'floatfield'     => array(
                'type'       => 'float',
            ),
            'datefield'      => array(
                'type'       => 'date',
            ),
            'timefield'      => array(
                'type'       => 'time',
            ),
            'timestampfield' => array(
                'type'       => 'timestamp',
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

    /**
     * Get the types of each field given its name
     *
     * @param array $names list of field names
     * @return array $types list of matching field types
     */
    function getFieldTypes($names) {
        $types = array();
        foreach ($names as $name) {
            foreach ($this->fields as $fieldname => $field) {
                if ($name == $fieldname) {
                    $types[$name] = $field['type'];
                }
            }
        }
        return $types;
    }

    /**
     * Insert the values into the sample table
     *
     * @param array $values associative array (name => value)
     */
    function insertValues($values) {
        $types = $this->getFieldTypes(array_keys($values));

        $result = $this->db->exec('DELETE FROM '.$this->table);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error emptying table: '.$result->getMessage());
        }

        $query = sprintf('INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', array_keys($values)),
            implode(', ', array_fill(0, count($values), '?'))
        );
        $stmt = $this->db->prepare($query, array_values($types), MDB2_PREPARE_MANIP);
        if (PEAR::isError($stmt)) {
            $this->assertTrue(false, 'Error creating prepared query: '.$stmt->getMessage());
        }
        $result = $stmt->execute(array_values($values));
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error executing prepared query: '.$result->getMessage());
        }
        $stmt->free();
    }

    /**
     * Select the inserted row from the db and check the inserted values
     * @param array $values associative array (name => value) of inserted data
     */
    function selectAndCheck($values) {
        $types = $this->getFieldTypes(array_keys($values));

        $query = 'SELECT '. implode (', ', array_keys($values)). ' FROM '.$this->table;
        $result = $this->db->queryRow($query, $types, MDB2_FETCHMODE_ASSOC);
        foreach ($values as $name => $value) {
            $this->assertEquals($result[$name], $values[$name], 'Error in '.$types[$name].' value: incorrect conversion');
        }
    }

    /**
     * Test the TEXT datatype for incorrect conversions
     */
    function testTextDataType($emulate_prepared = false) {
        if ($emulate_prepared) {
            $this->db->setOption('emulate_prepared', true);
        }

        $data = array(
            'id'        => 1,
            'textfield' => 'test',
        );
        $this->insertValues($data);
        $this->selectAndCheck($data);

        if (!$emulate_prepared && !$this->db->getOption('emulate_prepared')) {
            $this->testTextDataType(true);
        } elseif($emulate_prepared) {
            $this->db->setOption('emulate_prepared', false);
        }
    }

    /**
     * Test the DECIMAL datatype for incorrect conversions
     */
    function testDecimalDataType($emulate_prepared = false) {
        if ($emulate_prepared) {
            $this->db->setOption('emulate_prepared', true);
        }

        $data = array(
            'id'           => 1,
            'decimalfield' => 10.35,
        );
        $this->insertValues($data);
        $this->selectAndCheck($data);

        $old_locale = setlocale(LC_NUMERIC, 0);
        if (OS_UNIX) {
            setlocale(LC_NUMERIC, 'de_DE@euro', 'de_DE', 'de', 'ge');
        } else {
            setlocale(LC_NUMERIC, 'de_DE@euro', 'de_DE', 'deu_deu');
        }

        $this->insertValues($data);
        $this->selectAndCheck($data);

        setlocale(LC_NUMERIC, $old_locale);

        $expected = 10.35;

        $actual = $this->db->quote($expected, 'decimal');
        $this->assertEquals($expected, $actual);

        $non_us = number_format($expected, 2, ',', '');
        $actual = $this->db->quote($non_us, 'decimal');
        $this->assertEquals($expected, $actual);

        $expected = 1000.35;

        $non_us = '1,000.35';
        $actual = $this->db->quote($non_us, 'decimal');
        $this->assertEquals($expected, $actual);

        $non_us = '1000,35';
        $actual = $this->db->quote($non_us, 'decimal');
        $this->assertEquals($expected, $actual);

        $non_us = '1.000,35';
        $actual = $this->db->quote($non_us, 'decimal');
        $this->assertEquals($expected, $actual);

        if (!$emulate_prepared && !$this->db->getOption('emulate_prepared')) {
            $this->testDecimalDataType(true);
        } elseif($emulate_prepared) {
            $this->db->setOption('emulate_prepared', false);
        }
    }

    /**
     * Test the FLOAT datatype for incorrect conversions
     */
    function testFloatDataType($emulate_prepared = false) {
        if ($emulate_prepared) {
            $this->db->setOption('emulate_prepared', true);
        }

        $data = array(
            'id'         => 1,
            'floatfield' => 10.35,
        );
        $this->insertValues($data);
        $this->selectAndCheck($data);

        $old_locale = setlocale(LC_NUMERIC, 0);
        if (OS_UNIX) {
            setlocale(LC_NUMERIC, 'de_DE@euro', 'de_DE', 'de', 'ge');
        } else {
            setlocale(LC_NUMERIC, 'de_DE@euro', 'de_DE', 'deu_deu');
        }


        $this->insertValues($data);
        $this->selectAndCheck($data);

        setlocale(LC_NUMERIC, $old_locale);

        $data['floatfield'] = '1.035e+1';
        $this->insertValues($data);
        $this->selectAndCheck($data);

        $data['floatfield'] = '1.035E+01';
        $this->insertValues($data);
        $this->selectAndCheck($data);

        $expected = '1.035E+01';
        $non_us = '1,035e+1';
        $actual = $this->db->quote($non_us, 'float');
        $this->assertEquals($expected, $actual);

        $expected = 10.35;

        $actual = $this->db->quote($expected, 'float');
        $this->assertEquals($expected, $actual);

        $non_us = number_format($expected, 2, ',', '');
        $actual = $this->db->quote($non_us, 'float');
        $this->assertEquals($expected, $actual);

        $expected = 1000.35;

        $non_us = '1,000.35';
        $actual = $this->db->quote($non_us, 'float');
        $this->assertEquals($expected, $actual);

        $non_us = '1000,35';
        $actual = $this->db->quote($non_us, 'float');
        $this->assertEquals($expected, $actual);

        $non_us = '1.000,35';
        $actual = $this->db->quote($non_us, 'float');
        $this->assertEquals($expected, $actual);

        if (!$emulate_prepared && !$this->db->getOption('emulate_prepared')) {
            $this->testFloatDataType(true);
        } elseif($emulate_prepared) {
            $this->db->setOption('emulate_prepared', false);
        }
    }

    /**
     * Test the BOOLEAN datatype for incorrect conversions
     */
    function testBooleanDataType($emulate_prepared = false) {
        if ($emulate_prepared) {
            $this->db->setOption('emulate_prepared', true);
        }

        $data = array(
            'id'          => 1,
            'booleanfield' => true,
        );
        $this->insertValues($data);
        $this->selectAndCheck($data);

        $data['booleanfield'] = false;
        $this->insertValues($data);
        $this->selectAndCheck($data);

        if (!$emulate_prepared && !$this->db->getOption('emulate_prepared')) {
            $this->testBooleanDataType(true);
        } elseif($emulate_prepared) {
            $this->db->setOption('emulate_prepared', false);
        }
    }

    /**
     * Test the DATE datatype for incorrect conversions
     */
    function testDateDataType($emulate_prepared = false) {
        if ($emulate_prepared) {
            $this->db->setOption('emulate_prepared', true);
        }

        $data = array(
            'id'        => 1,
            'datefield' => date('Y-m-d'),
        );
        $this->insertValues($data, 'date');
        $this->selectAndCheck($data);

        if (!$emulate_prepared && !$this->db->getOption('emulate_prepared')) {
            $this->testDateDataType(true);
        } elseif($emulate_prepared) {
            $this->db->setOption('emulate_prepared', false);
        }
    }

    /**
     * Test the TIME datatype for incorrect conversions
     */
    function testTimeDataType($emulate_prepared = false) {
        if ($emulate_prepared) {
            $this->db->setOption('emulate_prepared', true);
        }

        $data = array(
            'id'        => 1,
            'timefield' => date('H:i:s'),
        );
        $this->insertValues($data, 'time');
        $this->selectAndCheck($data);

        if (!$emulate_prepared && !$this->db->getOption('emulate_prepared')) {
            $this->testTimeDataType(true);
        } elseif($emulate_prepared) {
            $this->db->setOption('emulate_prepared', false);
        }
    }

    /**
     * Test the TIMESTAMP datatype for incorrect conversions
     */
    function testTimestampDataType($emulate_prepared = false) {
        if ($emulate_prepared) {
            $this->db->setOption('emulate_prepared', true);
        }

        $data = array(
            'id'            => 1,
            'timestampfield' => date('Y-m-d H:i:s'),
        );
        $this->insertValues($data, 'timestamp');
        $this->selectAndCheck($data);

        if (!$emulate_prepared && !$this->db->getOption('emulate_prepared')) {
            $this->testTimestampDataType(true);
        } elseif($emulate_prepared) {
            $this->db->setOption('emulate_prepared', false);
        }
    }


    /**
     * Tests escaping of text values with special characters
     *
     */
    function testEscapeSequences() {
        $test_strings = array(
            "'",
            "\"",
            "\\",
            "%",
            "_",
            "''",
            "\"\"",
            "\\\\",
            "\\'\\'",
            "\\\"\\\""
        );

        $this->clearTables();
        foreach($test_strings as $key => $string) {
            $value = $this->db->quote($string, 'text');
            $query = "INSERT INTO users (user_name,user_id) VALUES ($value, $key)";
            $result = $this->db->exec($query);

            if (PEAR::isError($result)) {
                $this->assertTrue(false, 'Error executing insert query'.$result->getMessage());
            }

            $query = 'SELECT user_name FROM users WHERE user_id = '.$key;
            $value = $this->db->queryOne($query, 'text');

            if (PEAR::isError($value)) {
                $this->assertTrue(false, 'Error executing select query'.$value->getMessage());
            }

            $this->assertEquals($string, $value, "the value retrieved for field \"user_name\" doesn't match what was stored");
        }
    }

    /**
     * Tests escaping of text pattern strings with special characters
     *
     */
    function testPatternSequences() {
        $test_strings = array(
            "Foo",
            "FOO",
            "foo",
        );

        $this->clearTables();
        foreach($test_strings as $key => $string) {
            $value = $this->db->quote($string, 'text');
            $query = "INSERT INTO users (user_name,user_id) VALUES ($value, $key)";
            $result = $this->db->exec($query);
            if (PEAR::isError($result)) {
                $this->assertTrue(false, 'Error executing insert query'.$result->getMessage());
            }
        }

        $query = 'SELECT user_name FROM users WHERE '.$this->db->datatype->matchPattern(array('F', '%'), 'LIKE', 'user_name');
        $values = $this->db->queryCol($query, 'text');
        $this->assertTrue((count($values) == 2), "case sensitive search was expected to return 2 rows but returned: ".count($values));

        $query = 'SELECT user_name FROM users WHERE '.$this->db->datatype->matchPattern(array('foo'), 'ILIKE', 'user_name');
        $values = $this->db->queryCol($query, 'text');
        $this->assertTrue((count($values) == 3), "case insensitive search was expected to return 3 rows but returned: ".count($values));
    }

    /**
     * Tests escaping of text pattern strings with special characters
     *
     */
    function testEscapePatternSequences() {
        if (!$this->supported('pattern_escaping')) {
            return;
        }

        $test_strings = array(
            "%",
            "_",
            "%_",
            "_%",
            "%Foo%",
            "%Foo_",
            "Foo%123",
            "Foo_123",
            "_Foo%",
            "_Foo_",
            "%'",
            "_'",
            "'%",
            "'_",
            "'%'",
            "'_'",
        );

        $this->clearTables();
        foreach($test_strings as $key => $string) {
            $value = $this->db->quote($string, 'text');
            $query = "INSERT INTO users (user_name,user_id) VALUES ($value, $key)";
            $result = $this->db->exec($query);
            if (PEAR::isError($result)) {
                $this->assertTrue(false, 'Error executing insert query'.$result->getMessage());
            }

            $query = 'SELECT user_name FROM users WHERE user_name LIKE '.$this->db->quote($string, 'text', true, true);
            $value = $this->db->queryOne($query, 'text');
            if (PEAR::isError($value)) {
                $this->assertTrue(false, 'Error executing select query'.$value->getMessage());
            }

            $this->assertEquals($string, $value, "the value retrieved for field \"user_name\" doesn't match what was stored");
        }

        $this->db->loadModule('Datatype', null, true);
        $query = 'SELECT user_name FROM users WHERE user_name LIKE '.$this->db->datatype->matchPattern(array('Foo%', '_', '23'));
        $value = $this->db->queryOne($query, 'text');
        $this->assertEquals('Foo%123', $value, "the value retrieved for field \"user_name\" doesn't match what was stored");

        $query = 'SELECT user_name FROM users WHERE user_name LIKE '.$this->db->datatype->matchPattern(array(1 => '_', 'oo', '%'));
        $value = $this->db->queryOne($query, 'text');
        $this->assertEquals('Foo', substr($value, 0, 3), "the value retrieved for field \"user_name\" doesn't match what was stored");
    }
}

?>