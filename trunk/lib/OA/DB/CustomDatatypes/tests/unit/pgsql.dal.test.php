<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
$Id$
*/

require_once MAX_PATH . '/lib/OA/DB.php';

/**
 * A class for testing that the required custom MDB2 datatypes, MDB2 datatype
 * to nativetype mappings, and nativetype to MDB2 datatype mappings for
 * MySQL work as expected.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_DB_CustomDatatypes_pgsql extends UnitTestCase
{

    var $db;

    var $customTypes = 17;

    /**
     * The constructor method.
     */
    function Test_OA_DB_CustomDatatypes_pgsql()
    {
        $this->UnitTestCase();
        $this->db =& OA_DB::singleton();
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
    function _testOkayToRun()
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
    function testDatatypeToNativetypeMappings_openads_bigint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_bigint_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_bigint_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_bigint')
            ),
            'openads_bigint_test3' => array(
                'method' => 'convertResult',
                'params' => array('5  ', 'openads_bigint')
            ),
            'openads_bigint_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_bigint', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_bigint_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_bigint', 'foo', array(
                    'length'    => 9,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_bigint_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_bigint')
            ),
            'openads_bigint_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_bigint')
            )
        );
        $aResultData = array(
            'openads_bigint_test2' => 5,
            'openads_bigint_test3' => 5,
            'openads_bigint_test4' => '"foo" BIGINT DEFAULT NULL',
            'openads_bigint_test5' => '"foo" BIGINT DEFAULT 1 NOT NULL',
            'openads_bigint_test6' => 37,
            'openads_bigint_test7' => 'BIGINT'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_bigint'], 0);
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_char" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_char()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_char_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_char_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_char')
            ),
            'openads_char_test3' => array(
                'method' => 'convertResult',
                'params' => array('5 foo ', 'openads_char')
            ),
            'openads_char_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_char', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_char_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_char', 'foo', array(
                    'length'    => 255,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_char_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_char')
            ),
            'openads_char_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_char')
            )
        );
        $aResultData = array(
            'openads_char_test2' => '5',
            'openads_char_test3' => '5 foo',
            'openads_char_test4' => '"foo" CHAR DEFAULT NULL',
            'openads_char_test5' => '"foo" CHAR(255) DEFAULT 1 NOT NULL',
            'openads_char_test6' => "'37'",
            'openads_char_test7' => 'CHAR'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_char'], '');
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_decimal" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_decimal()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_decimal_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_decimal_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_decimal')
            ),
            'openads_decimal_test3' => array(
                'method' => 'convertResult',
                'params' => array('5  ', 'openads_decimal')
            ),
            'openads_decimal_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_decimal', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_decimal_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_decimal', 'foo', array(
                    'length'    => 9,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_decimal_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_decimal')
            ),
            'openads_decimal_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_decimal')
            )
        );
        $aResultData = array(
            'openads_decimal_test2' => 5,
            'openads_decimal_test3' => 5,
            'openads_decimal_test4' => '"foo" NUMERIC DEFAULT NULL',
            'openads_decimal_test5' => '"foo" NUMERIC(9) DEFAULT 1 NOT NULL',
            'openads_decimal_test6' => 37,
            'openads_decimal_test7' => 'NUMERIC'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_decimal'], 0);
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
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
    function testDatatypeToNativetypeMappings_openads_date()
    {
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_datetime" datatype.
     *
     * @TODO Implement
     */
    function testDatatypeToNativetypeMappings_openads_datetime()
    {
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_double" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_double()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_double_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_double_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_double')
            ),
            'openads_double_test3' => array(
                'method' => 'convertResult',
                'params' => array('5  ', 'openads_double')
            ),
            'openads_double_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_double', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_double_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_double', 'foo', array(
                    'length'    => 9,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_double_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_double')
            ),
            'openads_double_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_double')
            )
        );
        $aResultData = array(
            'openads_double_test2' => 5,
            'openads_double_test3' => 5,
            'openads_double_test4' => '"foo" DOUBLE PRECISION DEFAULT NULL',
            'openads_double_test5' => '"foo" DOUBLE PRECISION DEFAULT 1 NOT NULL',
            'openads_double_test6' => 37,
            'openads_double_test7' => 'DOUBLE PRECISION'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_double'], 0);
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_enum" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_enum()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_enum_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_enum_test2' => array(
                'method' => 'convertResult',
                'params' => array('t', 'openads_enum')
            ),
            'openads_enum_test3' => array(
                'method' => 'convertResult',
                'params' => array('t  ', 'openads_enum')
            ),
            'openads_enum_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_enum', 'foo', array(
                    'length'  => "'t','f'",
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_enum_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_enum', 'foo', array(
                    'length'  => "'t','f'",
                    'default' => 'f',
                    'notnull' => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_enum_test6' => array(
                'method' => 'quote',
                'params' => array('f', 'openads_enum')
            ),
            'openads_enum_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_enum')
            )
        );
        $aResultData = array(
            'openads_enum_test2' => 't',
            'openads_enum_test3' => 't',
            'openads_enum_test4' => '"foo" BOOLEAN DEFAULT NULL',
            'openads_enum_test5' => '"foo" BOOLEAN DEFAULT \'f\' NOT NULL',
            'openads_enum_test6' => "'f'",
            'openads_enum_test7' => 'TEXT'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_enum'], '');
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_float" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_float()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_float_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_float_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_float')
            ),
            'openads_float_test3' => array(
                'method' => 'convertResult',
                'params' => array('5  ', 'openads_float')
            ),
            'openads_float_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_float', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_float_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_float', 'foo', array(
                    'length'    => 9,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_float_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_float')
            ),
            'openads_float_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_float')
            )
        );
        $aResultData = array(
            'openads_float_test2' => 5,
            'openads_float_test3' => 5,
            'openads_float_test4' => '"foo" REAL DEFAULT NULL',
            'openads_float_test5' => '"foo" REAL DEFAULT 1 NOT NULL',
            'openads_float_test6' => 37,
            'openads_float_test7' => 'REAL'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_float'], 0);
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_int" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_int()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_int_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_int_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_int')
            ),
            'openads_int_test3' => array(
                'method' => 'convertResult',
                'params' => array('5  ', 'openads_int')
            ),
            'openads_int_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_int', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_int_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_int', 'foo', array(
                    'length'    => 9,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_int_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_int')
            ),
            'openads_int_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_int')
            )
        );
        $aResultData = array(
            'openads_int_test2' => 5,
            'openads_int_test3' => 5,
            'openads_int_test4' => '"foo" INTEGER DEFAULT NULL',
            'openads_int_test5' => '"foo" INTEGER DEFAULT 1 NOT NULL',
            'openads_int_test6' => 37,
            'openads_int_test7' => 'INTEGER'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_int'], 0);
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_mediumint" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_mediumint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_mediumint_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_mediumint_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_mediumint')
            ),
            'openads_mediumint_test3' => array(
                'method' => 'convertResult',
                'params' => array('5  ', 'openads_mediumint')
            ),
            'openads_mediumint_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_mediumint', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_mediumint_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_mediumint', 'foo', array(
                    'length'    => 9,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_mediumint_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_mediumint')
            ),
            'openads_mediumint_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_mediumint')
            )
        );
        $aResultData = array(
            'openads_mediumint_test2' => 5,
            'openads_mediumint_test3' => 5,
            'openads_mediumint_test4' => '"foo" INTEGER DEFAULT NULL',
            'openads_mediumint_test5' => '"foo" INTEGER DEFAULT 1 NOT NULL',
            'openads_mediumint_test6' => 37,
            'openads_mediumint_test7' => 'INTEGER'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_mediumint'], 0);
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
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
    function testDatatypeToNativetypeMappings_openads_mediumtext()
    {
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_set" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_set()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_set_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_set_test2' => array(
                'method' => 'convertResult',
                'params' => array('t', 'openads_set')
            ),
            'openads_set_test3' => array(
                'method' => 'convertResult',
                'params' => array('t  ', 'openads_set')
            ),
            'openads_set_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_set', 'foo', array(
                    'length'  => "'t','f'",
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_set_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_set', 'foo', array(
                    'length'  => "'t','f'",
                    'default' => 'f',
                    'notnull' => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_set_test6' => array(
                'method' => 'quote',
                'params' => array('f', 'openads_set')
            ),
            'openads_set_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_set')
            )
        );
        $aResultData = array(
            'openads_set_test2' => 't',
            'openads_set_test3' => 't',
            'openads_set_test4' => '"foo" TEXT DEFAULT NULL',
            'openads_set_test5' => '"foo" TEXT DEFAULT \'f\' NOT NULL',
            'openads_set_test6' => "'f'",
            'openads_set_test7' => 'TEXT'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_set'], '');
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_smallint" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_smallint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_smallint_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_smallint_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_smallint')
            ),
            'openads_smallint_test3' => array(
                'method' => 'convertResult',
                'params' => array('5  ', 'openads_smallint')
            ),
            'openads_smallint_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_smallint', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_smallint_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_smallint', 'foo', array(
                    'length'    => 9,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_smallint_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_smallint')
            ),
            'openads_smallint_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_smallint')
            )
        );
        $aResultData = array(
            'openads_smallint_test2' => 5,
            'openads_smallint_test3' => 5,
            'openads_smallint_test4' => '"foo" SMALLINT DEFAULT NULL',
            'openads_smallint_test5' => '"foo" SMALLINT DEFAULT 1 NOT NULL',
            'openads_smallint_test6' => 37,
            'openads_smallint_test7' => 'SMALLINT'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_smallint'], 0);
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_text" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_text()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_text_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_text_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_text')
            ),
            'openads_text_test3' => array(
                'method' => 'convertResult',
                'params' => array('5 foo ', 'openads_text')
            ),
            'openads_text_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_text', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_text_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_text', 'foo', array(
                    'length'    => 255,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_text_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_text')
            ),
            'openads_text_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_text')
            )
        );
        $aResultData = array(
            'openads_text_test2' => '5',
            'openads_text_test3' => '5 foo',
            'openads_text_test4' => '"foo" TEXT DEFAULT NULL',
            'openads_text_test5' => '"foo" TEXT(255) DEFAULT 1 NOT NULL',
            'openads_text_test6' => "'37'",
            'openads_text_test7' => 'TEXT'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_text'], '');
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
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
    function testDatatypeToNativetypeMappings_openads_timestamp()
    {
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_tinyint" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_tinyint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_tinyint_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_tinyint_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_tinyint')
            ),
            'openads_tinyint_test3' => array(
                'method' => 'convertResult',
                'params' => array('5  ', 'openads_tinyint')
            ),
            'openads_tinyint_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_tinyint', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_tinyint_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_tinyint', 'foo', array(
                    'length'    => 9,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_tinyint_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_tinyint')
            ),
            'openads_tinyint_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_tinyint')
            )
        );
        $aResultData = array(
            'openads_tinyint_test2' => 5,
            'openads_tinyint_test3' => 5,
            'openads_tinyint_test4' => '"foo" SMALLINT DEFAULT NULL',
            'openads_tinyint_test5' => '"foo" SMALLINT DEFAULT 1 NOT NULL',
            'openads_tinyint_test6' => 37,
            'openads_tinyint_test7' => 'SMALLINT'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_tinyint'], 0);
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_varchar" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_varchar()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'openads_varchar_test1' => array(
                'method' => 'getValidTypes',
                'params' => null
            ),
            'openads_varchar_test2' => array(
                'method' => 'convertResult',
                'params' => array(5, 'openads_varchar')
            ),
            'openads_varchar_test3' => array(
                'method' => 'convertResult',
                'params' => array('5 foo ', 'openads_varchar')
            ),
            'openads_varchar_test4' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_varchar', 'foo', array(
                    'length'    => null,
                    'default'   => null,
                    'notnull'   => null,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_varchar_test5' => array(
                'method' => 'getDeclaration',
                'params' => array('openads_varchar', 'foo', array(
                    'length'    => 255,
                    'default'   => 1,
                    'notnull'   => true,
                    'charset'   => null,
                    'collation' => null
                ))
            ),
            'openads_varchar_test6' => array(
                'method' => 'quote',
                'params' => array(37, 'openads_varchar')
            ),
            'openads_varchar_test7' => array(
                'method' => 'mapPrepareDatatype',
                'params' => array('openads_varchar')
            )
        );
        $aResultData = array(
            'openads_varchar_test2' => '5',
            'openads_varchar_test3' => '5 foo',
            'openads_varchar_test4' => '"foo" VARCHAR DEFAULT NULL',
            'openads_varchar_test5' => '"foo" VARCHAR(255) DEFAULT 1 NOT NULL',
            'openads_varchar_test6' => "'37'",
            'openads_varchar_test7' => 'VARCHAR'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_varchar'], '');
            } else {
                $result = call_user_func_array(array($this->db->datatype, $aFields['method']), $aFields['params']);
                $this->assertEqual($result, $aResultData[$testKey]);
            }
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "bigint" nativetype.
     */
    function testNativetypeToDatatypeMappings_bigint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'bigint_test1' => array(
                'type'    => 'bigint'
            )
        );
        $aResultData = array(
            'bigint_test1' => array(
                0 => array('integer'),
                1 => 8,
                2 => null,
                3 => null
            )
        );
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "char" nativetype.
     */
    function testNativetypeToDatatypeMappings_char()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'char_test1' => array(
                'type'    => 'char'
            ),
            'char_test2' => array(
                'type'    => 'char',
                'length'  => 5
            )
        );
        $aResultData = array(
            'char_test1' => array(
                0 => array('text'),
                1 => null,
                2 => null,
                3 => true
            ),
            'char_test2' => array(
                0 => array('text'),
                1 => 5,
                2 => null,
                3 => true
            )
        );
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "decimal" nativetype.
     */
    function testNativetypeToDatatypeMappings_decimal()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'decimal_test1' => array(
                'type'    => 'decimal'
            ),
            'decimal_test2' => array(
                'type'    => 'decimal',
                'length'  => 5
            )
        );
        $aResultData = array(
            'decimal_test1' => array(
                0 => array('decimal'),
                1 => null,
                2 => null,
                3 => null
            ),
            'decimal_test2' => array(
                0 => array('decimal'),
                1 => 5,
                2 => null,
                3 => null
            )
        );
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
    function testNativetypeToDatatypeMappings_date()
    {
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "datetime" nativetype.
     *
     * @TODO Implement
     */
    function testNativetypeToDatatypeMappings_datetime()
    {
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "double" nativetype.
     */
    function testNativetypeToDatatypeMappings_double()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'double_test1' => array(
                'type'    => 'double'
            )
        );
        $aResultData = array(
            'double_test1' => array(
                0 => array('float'),
                1 => null,
                2 => null,
                3 => null
            )
        );
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "boolean" nativetype.
     */
    function testNativetypeToDatatypeMappings_boolean()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'enum_test1' => array(
                'type'    => 'boolean'
            )
        );
        $aResultData = array(
            'enum_test1' => array(
                0 => array('boolean'),
                1 => null,
                2 => null,
                3 => null
            )
        );
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "float" nativetype.
     */
    function testNativetypeToDatatypeMappings_float()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'float_test1' => array(
                'type'    => 'float'
            )
        );
        $aResultData = array(
            'float_test1' => array(
                0 => array('float'),
                1 => null,
                2 => null,
                3 => null
            )
        );
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "int" nativetype.
     */
    function testNativetypeToDatatypeMappings_int()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'int_test1' => array(
                'type'    => 'int'
            )
        );
        $aResultData = array(
            'int_test1' => array(
                0 => array('integer'),
                1 => 4,
                2 => null,
                3 => null
            )
        );
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "mediumint" nativetype.
     */
    function testNativetypeToDatatypeMappings_mediumint()
    {
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "mediumtext" nativetype.
     *
     * @TODO Implement
     */
    function testNativetypeToDatatypeMappings_mediumtext()
    {
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "set" nativetype.
     */
    function testNativetypeToDatatypeMappings_set()
    {
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "smallint" nativetype.
     */
    function testNativetypeToDatatypeMappings_smallint()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'smallint_test1' => array(
                'type'    => 'smallint'
            )
        );
        $aResultData = array(
            'smallint_test1' => array(
                0 => array('integer', 'boolean'),
                1 => 2,
                2 => null,
                3 => null
            )
        );
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "text" nativetype.
     */
    function testNativetypeToDatatypeMappings_text()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'text_test1' => array(
                'type'    => 'text'
            )
        );
        $aResultData = array(
            'text_test1' => array(
                0 => array('text', 'clob'),
                1 => null,
                2 => null,
                3 => false
            )
        );
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
    function testNativetypeToDatatypeMappings_timestamp()
    {
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "tinyint" nativetype.
     */
    function testNativetypeToDatatypeMappings_tinyint()
    {
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected for the "varchar" nativetype.
     */
    function testNativetypeToDatatypeMappings_varchar()
    {
        if (!$this->_testOkayToRun()) {
            return;
        }
        $aTestData = array(
            'varchar_test1' => array(
                'type'    => 'varchar'
            ),
            'varchar_test2' => array(
                'type'    => 'varchar',
                'length'  => 5
            )
        );
        $aResultData = array(
            'varchar_test1' => array(
                0 => array('text'),
                1 => null,
                2 => null,
                3 => false
            ),
            'varchar_test2' => array(
                0 => array('text'),
                1 => 5,
                2 => null,
                3 => false
            )
        );
        foreach ($aTestData as $testKey => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$testKey]);
        }
    }

}

?>