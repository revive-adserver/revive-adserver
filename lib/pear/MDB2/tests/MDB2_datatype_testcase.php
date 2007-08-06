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

/**
 * A test callback function to be used in the test class below for
 * ensuring that custom datatype callback features are handled
 * correctly.
 *
 * @param MDB2   $db         The MDB2 database reource object.
 * @param string $method     The name of the MDB2_Driver_Datatype_Common method
 *                           the callback function was called from. One of
 *                           "getValidTypes", "convertResult", "getDeclaration",
 *                           "compareDefinition", "quote" and "mapPrepareDatatype".
 *                           See {@link MDB2_Driver_Datatype_Common} for the
 *                           details of what each method does.
 * @param array $aParameters An array of parameters, being the parameters that
 *                           were passed to the method calling the callback
 *                           function.
 * @return mixed Returns the appropriate value depending on the method that
 *               called the function. See {@link MDB2_Driver_Datatype_Common}
 *               for details of the expected return values of the five possible
 *               calling methods.
 */
function datatype_test_callback(&$db, $method, $aParameters)
{
    // Ensure the datatype module is loaded
    if (is_null($db->datatype)) {
        $db->loadModule('Datatype', null, true);
    }
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        // For all cases, return a string that identifies that the
        // callback method was able to call to the appropriate point
        case 'getvalidtypes':
            return 'datatype_test_callback::getvalidtypes';
        case 'convertresult':
            return 'datatype_test_callback::convertresult';
        case 'getdeclaration':
            return 'datatype_test_callback::getdeclaration';
        case 'comparedefinition':
            return 'datatype_test_callback::comparedefinition';
        case 'quote':
            return 'datatype_test_callback::quote';
        case 'mappreparedatatype':
            return 'datatype_test_callback::mappreparedatatype';
    }
}

/**
 * A test callback function to be used in the test class below for
 * ensuring that custom nativetype to datatype mapping is handled
 * correctly.
 *
 * @param MDB2 $db       The MDB2 database reource object.
 * @param array $aFields The standard array of fields produced from the
 *                       MySQL command "SHOW COLUMNS". See
 *                       {@link http://dev.mysql.com/doc/refman/5.0/en/describe.html}
 *                       for more details on the format of the fields.
 *                          "type"      The nativetype column type
 *                          "null"      "YES" or "NO"
 *                          "key"       "PRI", "UNI", "MUL", or null
 *                          "default"   The default value of the column
 *                          "extra"     "auto_increment", or null
 * @return array Returns an array of the following items:
 *                  0 => An array of possible MDB2 datatypes. As this is
 *                       a custom type, always has one entry, "test".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as this custom test
 *                       type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as this custom test
 *                       type is not textual.
 */
function nativetype_test_callback(&$db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'test';
    // Can the length of the field be found?
    $length = null;
    $start = strpos($aFields['type'], '(');
    $end = strpos($aFields['type'], ')');
    if ($start && $end) {
        $start++;
        $chars = $end - $start;
        $length = substr($aFields['type'], $start, $chars);
    }
    // No unsigned value needed
    $unsigned = null;
    // No fixed value needed
    $fixed = null;
    return array($aType, $length, $unsigned, $fixed);
}

class MDB2_Datatype_TestCase extends MDB2_TestCase
{
    // Test table name (it is dynamically created/dropped)
    var $table = 'datatypetable';

    /**
     * The setup method to prepare the testing environment.
     */
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

    /**
     * The teardown method to clean up the testing environment.
     */
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

    /**
     * A method to test that the MDB2_Driver_Datatype_Common::getValidTypes()
     * method returns the correct data array.
     */
    function testGetValidTypes()
    {
        // Test with just the default MDB2 datatypes.
        $aExpected = $this->db->datatype->valid_default_values;
        $aResult = $this->db->datatype->getValidTypes();
        $this->assertEquals($aExpected, $aResult, 'getValidTypes');

        // Test with a custom datatype
        $this->db->setOption('datatype_map', array('test' => 'test'));
        $this->db->setOption('datatype_map_callback', array('test' => 'datatype_test_callback'));
        $aExpected = array_merge(
            $this->db->datatype->valid_default_values,
            array('test' => 'datatype_test_callback::getvalidtypes')
        );
        $aResult = $this->db->datatype->getValidTypes();
        $this->assertEquals($aExpected, $aResult, 'getValidTypes');
        unset($this->db->options['datatype_map']);
        unset($this->db->options['datatype_map_callback']);

    }

    /**
     * A method to test that the MDB2_Driver_Datatype_Common::convertResult()
     * method returns correctly converted column data.
     */
    function testConvertResult()
    {
        // Test with an MDB2 datatype, eg. "text"
        $value = 'text';
        $type = 'text';
        $result = $this->db->datatype->convertResult($value, $type);
        $this->assertEquals($value, $result, 'convertResult');

        // Test with a custom datatype
        $this->db->setOption('datatype_map', array('test' => 'test'));
        $this->db->setOption('datatype_map_callback', array('test' => 'datatype_test_callback'));
        $value = 'text';
        $type = 'test';
        $result = $this->db->datatype->convertResult($value, $type);
        $this->assertEquals('datatype_test_callback::convertresult', $result, 'mapPrepareDatatype');
        unset($this->db->options['datatype_map']);
        unset($this->db->options['datatype_map_callback']);
    }

    /**
     * A method to test that the MDB2_Driver_Datatype_Common::getDeclaration()
     * method returns correctly formatted SQL for declaring columns.
     */
    function testGetDeclaration()
    {
        // Test with an MDB2 datatype, eg. "integer"
        $name = 'column';
        $type = 'integer';
        $field = array('type' => 'integer');
        $result = $this->db->datatype->getDeclaration($type, $name, $field);
        $this->assertEquals('column INT DEFAULT NULL', $result, 'getDeclaration');

        // Test with a custom datatype
        $this->db->setOption('datatype_map', array('test' => 'test'));
        $this->db->setOption('datatype_map_callback', array('test' => 'datatype_test_callback'));
        $name = 'column';
        $type = 'test';
        $field = array('type' => 'test');
        $result = $this->db->datatype->getDeclaration($type, $name, $field);
        $this->assertEquals('datatype_test_callback::getdeclaration', $result, 'getDeclaration');
        unset($this->db->options['datatype_map']);
        unset($this->db->options['datatype_map_callback']);
    }

    /**
     * A method to test that the MDB2_Driver_Datatype_Common::compareDefinition()
     * method
     */
    function testCompareDefinition()
    {
        // Test with an MDB2 datatype, eg. "text"
        $aPrevious = array(
            'type'   => 'text',
            'length' => 4
        );
        $aCurrent = array(
            'type'   => 'text',
            'length' => 5
        );
        $aResult = $this->db->datatype->compareDefinition($aCurrent, $aPrevious);
        $this->assertTrue(is_array($aResult), 'compareDefinition');
        $this->assertEquals(1, count($aResult), 'compareDefinition');
        $this->assertTrue($aResult['length'], 'compareDefinition');

        // Test with a custom datatype
        $this->db->setOption('datatype_map', array('test' => 'test'));
        $this->db->setOption('datatype_map_callback', array('test' => 'datatype_test_callback'));
        $aPrevious = array(
            'type'   => 'test'
        );
        $aCurrent = array(
            'type'   => 'test'
        );
        $result = $this->db->datatype->compareDefinition($aCurrent, $aPrevious);
        $this->assertEquals('datatype_test_callback::comparedefinition', $result, 'compareDefinition');
        unset($this->db->options['datatype_map']);
        unset($this->db->options['datatype_map_callback']);
    }

    /**
     * A method to test that the MDB2_Driver_Datatype_Common::quote()
     * method returns correctly quoted column data.
     */
    function testQuote()
    {
        // Test with an MDB2 datatype, eg. "text"
        $value = 'text';
        $type = 'text';
        $result = $this->db->datatype->quote($value, $type);
        $this->assertEquals("'$value'", $result, 'quote');

        // Test with a custom datatype
        $this->db->setOption('datatype_map', array('test' => 'test'));
        $this->db->setOption('datatype_map_callback', array('test' => 'datatype_test_callback'));
        $value = 'text';
        $type = 'test';
        $result = $this->db->datatype->quote($value, $type);
        $this->assertEquals('datatype_test_callback::quote', $result, 'quote');
        unset($this->db->options['datatype_map']);
        unset($this->db->options['datatype_map_callback']);
    }

    /**
     * A method to test that the MDB2_Driver_Datatype_Common::mapPrepareDatatype()
     * method returns the correct data type.
     */
    function testMapPrepareDatatype()
    {
        // Test with an MDB2 datatype, eg. "text"
        $type = 'text';
        $result = $this->db->datatype->mapPrepareDatatype($type);
        $this->assertEquals($type, $result, 'mapPrepareDatatype');

        // Test with a custom datatype
        $this->db->setOption('datatype_map', array('test' => 'test'));
        $this->db->setOption('datatype_map_callback', array('test' => 'datatype_test_callback'));
        $type = 'test';
        $result = $this->db->datatype->mapPrepareDatatype($type);
        $this->assertEquals('datatype_test_callback::mappreparedatatype', $result, 'mapPrepareDatatype');
        unset($this->db->options['datatype_map']);
        unset($this->db->options['datatype_map_callback']);
    }

    /**
     * A method to test that the MDB2_Driver_Datatype_Common::mapNativeDatatype()
     * method returns the correct MDB2 datatype from a given nativetype.
     */
    function testMapNativeDatatype()
    {
        // Test with an common nativetype, eg. "text"
        $field = array(
            'type'   => 'int',
            'length' => 8
        );
        $result = $this->db->datatype->mapNativeDatatype($field);
        $this->assertTrue(is_array($result), 'mapNativeDatatype');
        $this->assertEquals(count($result), 4, 'mapNativeDatatype');
        $this->assertEquals($result[0][0], 'integer', 'mapNativeDatatype');
        $this->assertEquals($result[1], 4, 'mapNativeDatatype');

        // Test with a custom nativetype mapping
        $this->db->setOption('nativetype_map_callback', array('test' => 'nativetype_test_callback'));
        $field = array(
            'type'   => 'test'
        );
        $result = $this->db->datatype->mapNativeDatatype($field);
        $this->assertTrue(is_array($result), 'mapNativeDatatype');
        $this->assertEquals(count($result), 4, 'mapNativeDatatype');
        $this->assertEquals($result[0][0], 'test', 'mapNativeDatatype');
        $this->assertNull($result[1], 'mapNativeDatatype');
        $this->assertNull($result[2], 'mapNativeDatatype');
        $this->assertNull($result[3], 'mapNativeDatatype');
        $field = array(
            'type'   => 'test(10)'
        );
        $result = $this->db->datatype->mapNativeDatatype($field);
        $this->assertTrue(is_array($result), 'mapNativeDatatype');
        $this->assertEquals(count($result), 4, 'mapNativeDatatype');
        $this->assertEquals($result[0][0], 'test', 'mapNativeDatatype');
        $this->assertEquals($result[1], 10, 'mapNativeDatatype');
        $this->assertNull($result[2], 'mapNativeDatatype');
        $this->assertNull($result[3], 'mapNativeDatatype');
        unset($this->db->options['nativetype_map_callback']);
    }

}

?>