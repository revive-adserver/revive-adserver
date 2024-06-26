<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/DB.php';

/**
 * A class for testing that the required custom MDB2 datatypes, MDB2 datatype
 * to nativetype mappings, and nativetype to MDB2 datatype mappings for
 * MySQL work as expected.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 */
class Test_OA_DB_CustomDatatypes_pgsql extends UnitTestCase
{
    public $db;

    public $customTypes = 17;

    public function __construct()
    {
        parent::__construct();
        $this->db = OA_DB::singleton();
        $this->db->loadModule('Datatype', null, true);
    }

    /**
     * A private method to test if it is okay to run these tests
     * or not.
     *
     * @access private
     * @return boolean True if the database in used is MySQL, false
     *                 otherwise.
     */
    public function _testOkayToRun()
    {
        if ($this->db->dsn['phptype'] == 'pgsql') {
            return true;
        }
        return false;
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_bigint" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_bigint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_bigint_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_bigint_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_bigint'],
            ],
            'openads_bigint_test3' => [
                'method' => 'convertResult',
                'params' => ['5  ', 'openads_bigint'],
            ],
            'openads_bigint_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_bigint', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_bigint_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_bigint', 'foo', [
                    'length' => 9,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_bigint_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_bigint'],
            ],
            'openads_bigint_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_bigint'],
            ],
        ];
        $aResultData = [
            'openads_bigint_test2' => 5,
            'openads_bigint_test3' => 5,
            'openads_bigint_test4' => '"foo" BIGINT DEFAULT NULL',
            'openads_bigint_test5' => '"foo" BIGINT DEFAULT 1 NOT NULL',
            'openads_bigint_test6' => 37,
            'openads_bigint_test7' => 'BIGINT',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_bigint'], 0);
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_char" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_char()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_char_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_char_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_char'],
            ],
            'openads_char_test3' => [
                'method' => 'convertResult',
                'params' => ['5 foo ', 'openads_char'],
            ],
            'openads_char_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_char', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_char_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_char', 'foo', [
                    'length' => 255,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_char_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_char'],
            ],
            'openads_char_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_char'],
            ],
        ];
        $aResultData = [
            'openads_char_test2' => '5',
            'openads_char_test3' => '5 foo',
            'openads_char_test4' => '"foo" CHAR DEFAULT NULL',
            'openads_char_test5' => '"foo" CHAR(255) DEFAULT 1 NOT NULL',
            'openads_char_test6' => "'37'",
            'openads_char_test7' => 'CHAR',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_char'], '');
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_decimal" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_decimal()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_decimal_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_decimal_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_decimal'],
            ],
            'openads_decimal_test3' => [
                'method' => 'convertResult',
                'params' => ['5  ', 'openads_decimal'],
            ],
            'openads_decimal_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_decimal', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_decimal_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_decimal', 'foo', [
                    'length' => 9,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_decimal_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_decimal'],
            ],
            'openads_decimal_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_decimal'],
            ],
        ];
        $aResultData = [
            'openads_decimal_test2' => 5,
            'openads_decimal_test3' => 5,
            'openads_decimal_test4' => '"foo" NUMERIC DEFAULT NULL',
            'openads_decimal_test5' => '"foo" NUMERIC(9) DEFAULT 1 NOT NULL',
            'openads_decimal_test6' => 37,
            'openads_decimal_test7' => 'NUMERIC',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_decimal'], 0);
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_date" datatype.
     *
     * @TODO Implement
     */
    public function testDatatypeToNativetypeMappings_openads_date() {}

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_datetime" datatype.
     *
     * @TODO Implement
     */
    public function testDatatypeToNativetypeMappings_openads_datetime() {}

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_double" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_double()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_double_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_double_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_double'],
            ],
            'openads_double_test3' => [
                'method' => 'convertResult',
                'params' => ['5  ', 'openads_double'],
            ],
            'openads_double_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_double', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_double_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_double', 'foo', [
                    'length' => 9,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_double_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_double'],
            ],
            'openads_double_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_double'],
            ],
        ];
        $aResultData = [
            'openads_double_test2' => 5,
            'openads_double_test3' => 5,
            'openads_double_test4' => '"foo" DOUBLE PRECISION DEFAULT NULL',
            'openads_double_test5' => '"foo" DOUBLE PRECISION DEFAULT 1 NOT NULL',
            'openads_double_test6' => 37,
            'openads_double_test7' => 'DOUBLE PRECISION',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_double'], 0);
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_enum" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_enum()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_enum_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_enum_test2' => [
                'method' => 'convertResult',
                'params' => ['t', 'openads_enum'],
            ],
            'openads_enum_test3' => [
                'method' => 'convertResult',
                'params' => ['t  ', 'openads_enum'],
            ],
            'openads_enum_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_enum', 'foo', [
                    'length' => "'t','f'",
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_enum_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_enum', 'foo', [
                    'length' => "'t','f'",
                    'default' => 'f',
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_enum_test6' => [
                'method' => 'quote',
                'params' => ['f', 'openads_enum'],
            ],
            'openads_enum_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_enum'],
            ],
        ];
        $aResultData = [
            'openads_enum_test2' => 't',
            'openads_enum_test3' => 't',
            'openads_enum_test4' => '"foo" BOOLEAN DEFAULT NULL',
            'openads_enum_test5' => '"foo" BOOLEAN DEFAULT \'f\' NOT NULL',
            'openads_enum_test6' => "'f'",
            'openads_enum_test7' => 'TEXT',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_enum'], '');
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_float" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_float()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_float_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_float_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_float'],
            ],
            'openads_float_test3' => [
                'method' => 'convertResult',
                'params' => ['5  ', 'openads_float'],
            ],
            'openads_float_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_float', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_float_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_float', 'foo', [
                    'length' => 9,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_float_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_float'],
            ],
            'openads_float_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_float'],
            ],
        ];
        $aResultData = [
            'openads_float_test2' => 5,
            'openads_float_test3' => 5,
            'openads_float_test4' => '"foo" REAL DEFAULT NULL',
            'openads_float_test5' => '"foo" REAL DEFAULT 1 NOT NULL',
            'openads_float_test6' => 37,
            'openads_float_test7' => 'REAL',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_float'], 0);
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_int" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_int()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_int_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_int_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_int'],
            ],
            'openads_int_test3' => [
                'method' => 'convertResult',
                'params' => ['5  ', 'openads_int'],
            ],
            'openads_int_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_int', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_int_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_int', 'foo', [
                    'length' => 9,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_int_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_int'],
            ],
            'openads_int_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_int'],
            ],
        ];
        $aResultData = [
            'openads_int_test2' => 5,
            'openads_int_test3' => 5,
            'openads_int_test4' => '"foo" INTEGER DEFAULT NULL',
            'openads_int_test5' => '"foo" INTEGER DEFAULT 1 NOT NULL',
            'openads_int_test6' => 37,
            'openads_int_test7' => 'INTEGER',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_int'], 0);
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_mediumint" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_mediumint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_mediumint_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_mediumint_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_mediumint'],
            ],
            'openads_mediumint_test3' => [
                'method' => 'convertResult',
                'params' => ['5  ', 'openads_mediumint'],
            ],
            'openads_mediumint_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_mediumint', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_mediumint_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_mediumint', 'foo', [
                    'length' => 9,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_mediumint_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_mediumint'],
            ],
            'openads_mediumint_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_mediumint'],
            ],
        ];
        $aResultData = [
            'openads_mediumint_test2' => 5,
            'openads_mediumint_test3' => 5,
            'openads_mediumint_test4' => '"foo" INTEGER DEFAULT NULL',
            'openads_mediumint_test5' => '"foo" INTEGER DEFAULT 1 NOT NULL',
            'openads_mediumint_test6' => 37,
            'openads_mediumint_test7' => 'INTEGER',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_mediumint'], 0);
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_mediumtext" datatype.
     *
     * @TODO Implement
     */
    public function testDatatypeToNativetypeMappings_openads_mediumtext() {}

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_set" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_set()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_set_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_set_test2' => [
                'method' => 'convertResult',
                'params' => ['t', 'openads_set'],
            ],
            'openads_set_test3' => [
                'method' => 'convertResult',
                'params' => ['t  ', 'openads_set'],
            ],
            'openads_set_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_set', 'foo', [
                    'length' => "'t','f'",
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_set_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_set', 'foo', [
                    'length' => "'t','f'",
                    'default' => 'f',
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_set_test6' => [
                'method' => 'quote',
                'params' => ['f', 'openads_set'],
            ],
            'openads_set_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_set'],
            ],
        ];
        $aResultData = [
            'openads_set_test2' => 't',
            'openads_set_test3' => 't',
            'openads_set_test4' => '"foo" TEXT DEFAULT NULL',
            'openads_set_test5' => '"foo" TEXT DEFAULT \'f\' NOT NULL',
            'openads_set_test6' => "'f'",
            'openads_set_test7' => 'TEXT',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_set'], '');
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_smallint" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_smallint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_smallint_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_smallint_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_smallint'],
            ],
            'openads_smallint_test3' => [
                'method' => 'convertResult',
                'params' => ['5  ', 'openads_smallint'],
            ],
            'openads_smallint_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_smallint', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_smallint_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_smallint', 'foo', [
                    'length' => 9,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_smallint_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_smallint'],
            ],
            'openads_smallint_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_smallint'],
            ],
        ];
        $aResultData = [
            'openads_smallint_test2' => 5,
            'openads_smallint_test3' => 5,
            'openads_smallint_test4' => '"foo" SMALLINT DEFAULT NULL',
            'openads_smallint_test5' => '"foo" SMALLINT DEFAULT 1 NOT NULL',
            'openads_smallint_test6' => 37,
            'openads_smallint_test7' => 'SMALLINT',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_smallint'], 0);
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_text" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_text()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_text_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_text_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_text'],
            ],
            'openads_text_test3' => [
                'method' => 'convertResult',
                'params' => ['5 foo ', 'openads_text'],
            ],
            'openads_text_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_text', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_text_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_text', 'foo', [
                    'length' => 255,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_text_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_text'],
            ],
            'openads_text_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_text'],
            ],
        ];
        $aResultData = [
            'openads_text_test2' => '5',
            'openads_text_test3' => '5 foo',
            'openads_text_test4' => '"foo" TEXT DEFAULT NULL',
            'openads_text_test5' => '"foo" TEXT(255) DEFAULT 1 NOT NULL',
            'openads_text_test6' => "'37'",
            'openads_text_test7' => 'TEXT',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_text'], '');
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_timestamp" datatype.
     *
     * @TODO Implement
     */
    public function testDatatypeToNativetypeMappings_openads_timestamp() {}

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_tinyint" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_tinyint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_tinyint_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_tinyint_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_tinyint'],
            ],
            'openads_tinyint_test3' => [
                'method' => 'convertResult',
                'params' => ['5  ', 'openads_tinyint'],
            ],
            'openads_tinyint_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_tinyint', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_tinyint_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_tinyint', 'foo', [
                    'length' => 9,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_tinyint_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_tinyint'],
            ],
            'openads_tinyint_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_tinyint'],
            ],
        ];
        $aResultData = [
            'openads_tinyint_test2' => 5,
            'openads_tinyint_test3' => 5,
            'openads_tinyint_test4' => '"foo" SMALLINT DEFAULT NULL',
            'openads_tinyint_test5' => '"foo" SMALLINT DEFAULT 1 NOT NULL',
            'openads_tinyint_test6' => 37,
            'openads_tinyint_test7' => 'SMALLINT',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_tinyint'], 0);
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_varchar" datatype.
     */
    public function testDatatypeToNativetypeMappings_openads_varchar()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'openads_varchar_test1' => [
                'method' => 'getValidTypes',
                'params' => null,
            ],
            'openads_varchar_test2' => [
                'method' => 'convertResult',
                'params' => [5, 'openads_varchar'],
            ],
            'openads_varchar_test3' => [
                'method' => 'convertResult',
                'params' => ['5 foo ', 'openads_varchar'],
            ],
            'openads_varchar_test4' => [
                'method' => 'getDeclaration',
                'params' => ['openads_varchar', 'foo', [
                    'length' => null,
                    'default' => null,
                    'notnull' => null,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_varchar_test5' => [
                'method' => 'getDeclaration',
                'params' => ['openads_varchar', 'foo', [
                    'length' => 255,
                    'default' => 1,
                    'notnull' => true,
                    'charset' => null,
                    'collation' => null,
                ]],
            ],
            'openads_varchar_test6' => [
                'method' => 'quote',
                'params' => [37, 'openads_varchar'],
            ],
            'openads_varchar_test7' => [
                'method' => 'mapPrepareDatatype',
                'params' => ['openads_varchar'],
            ],
        ];
        $aResultData = [
            'openads_varchar_test2' => '5',
            'openads_varchar_test3' => '5 foo',
            'openads_varchar_test4' => '"foo" VARCHAR DEFAULT NULL',
            'openads_varchar_test5' => '"foo" VARCHAR(255) DEFAULT 1 NOT NULL',
            'openads_varchar_test6' => "'37'",
            'openads_varchar_test7' => 'VARCHAR',
        ];
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func([$this->db->datatype, $aFields['method']]);
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_varchar'], '');
            } else {
                $result = call_user_func_array([$this->db->datatype, $aFields['method']], $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "bigint" nativetype.
     */
    public function testNativetypeToDatatypeMappings_bigint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'bigint_test1' => [
                'type' => 'bigint',
            ],
        ];
        $aResultData = [
            'bigint_test1' => [
                0 => ['integer'],
                1 => 8,
                2 => null,
                3 => null,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "char" nativetype.
     */
    public function testNativetypeToDatatypeMappings_char()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'char_test1' => [
                'type' => 'char',
            ],
            'char_test2' => [
                'type' => 'char',
                'length' => 5,
            ],
        ];
        $aResultData = [
            'char_test1' => [
                0 => ['text'],
                1 => null,
                2 => null,
                3 => true,
            ],
            'char_test2' => [
                0 => ['text'],
                1 => 5,
                2 => null,
                3 => true,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "decimal" nativetype.
     */
    public function testNativetypeToDatatypeMappings_decimal()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'decimal_test1' => [
                'type' => 'decimal',
            ],
            'decimal_test2' => [
                'type' => 'decimal',
                'length' => 5,
            ],
        ];
        $aResultData = [
            'decimal_test1' => [
                0 => ['decimal'],
                1 => null,
                2 => null,
                3 => null,
            ],
            'decimal_test2' => [
                0 => ['decimal'],
                1 => 5,
                2 => null,
                3 => null,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "date" nativetype.
     *
     * @TODO Implement
     */
    public function testNativetypeToDatatypeMappings_date() {}

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "datetime" nativetype.
     *
     * @TODO Implement
     */
    public function testNativetypeToDatatypeMappings_datetime() {}

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "double" nativetype.
     */
    public function testNativetypeToDatatypeMappings_double()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'double_test1' => [
                'type' => 'double',
            ],
        ];
        $aResultData = [
            'double_test1' => [
                0 => ['float'],
                1 => null,
                2 => null,
                3 => null,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "boolean" nativetype.
     */
    public function testNativetypeToDatatypeMappings_boolean()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'enum_test1' => [
                'type' => 'boolean',
            ],
        ];
        $aResultData = [
            'enum_test1' => [
                0 => ['boolean'],
                1 => null,
                2 => null,
                3 => null,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "float" nativetype.
     */
    public function testNativetypeToDatatypeMappings_float()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'float_test1' => [
                'type' => 'float',
            ],
        ];
        $aResultData = [
            'float_test1' => [
                0 => ['float'],
                1 => null,
                2 => null,
                3 => null,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "int" nativetype.
     */
    public function testNativetypeToDatatypeMappings_int()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'int_test1' => [
                'type' => 'int',
            ],
        ];
        $aResultData = [
            'int_test1' => [
                0 => ['integer'],
                1 => 4,
                2 => null,
                3 => null,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "mediumint" nativetype.
     */
    public function testNativetypeToDatatypeMappings_mediumint() {}

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "mediumtext" nativetype.
     *
     * @TODO Implement
     */
    public function testNativetypeToDatatypeMappings_mediumtext() {}

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "set" nativetype.
     */
    public function testNativetypeToDatatypeMappings_set() {}

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "smallint" nativetype.
     */
    public function testNativetypeToDatatypeMappings_smallint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'smallint_test1' => [
                'type' => 'smallint',
            ],
        ];
        $aResultData = [
            'smallint_test1' => [
                0 => ['integer', 'boolean'],
                1 => 2,
                2 => null,
                3 => null,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "text" nativetype.
     */
    public function testNativetypeToDatatypeMappings_text()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'text_test1' => [
                'type' => 'text',
            ],
        ];
        $aResultData = [
            'text_test1' => [
                0 => ['text', 'clob'],
                1 => null,
                2 => null,
                3 => false,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "timestamp" nativetype.
     *
     * @TODO Implement
     */
    public function testNativetypeToDatatypeMappings_timestamp() {}

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "tinyint" nativetype.
     */
    public function testNativetypeToDatatypeMappings_tinyint() {}

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "varchar" nativetype.
     */
    public function testNativetypeToDatatypeMappings_varchar()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = [
            'varchar_test1' => [
                'type' => 'varchar',
            ],
            'varchar_test2' => [
                'type' => 'varchar',
                'length' => 5,
            ],
        ];
        $aResultData = [
            'varchar_test1' => [
                0 => ['text'],
                1 => null,
                2 => null,
                3 => false,
            ],
            'varchar_test2' => [
                0 => ['text'],
                1 => 5,
                2 => null,
                3 => false,
            ],
        ];
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }
}
