<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/openads/Dal.php';

/**
 * A class for testing that the required custom MDB2 datatypes, MDB2 datatype
 * to nativetype mappings, and nativetype to MDB2 datatype mappings work as
 * expected.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_Openads_Dal_CustomDatatypes_mysql extends UnitTestCase
{

    var $db;

    var $customTypes = 3;

    /**
     * The constructor method.
     */
    function Test_Openads_Dal_CustomDatatypes_mysql()
    {
        $this->UnitTestCase();
        $this->db = Openads_Dal::singleton();
        $this->db->loadModule('Datatype', null, true);
    }

    /**
     * A method to test that the MDB2 datatype to database nativetype
     * mappings work as expected for the "openads_enum" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_enum()
    {
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
            'openads_enum_test4' => 'foo ENUM(\'t\',\'f\') DEFAULT NULL',
            'openads_enum_test5' => 'foo ENUM(\'t\',\'f\') DEFAULT \'f\' NOT NULL',
            'openads_enum_test6' => "'f'",
            'openads_enum_test7' => 'ENUM'
        );
        foreach ($aTestData as $testKey => $aFields) {
            if ($aFields['method'] == 'getValidTypes') {
                $result = call_user_func(array($this->db->datatype, $aFields['method']));
                $this->assertEqual(count($result), 10 + $this->customTypes);
                $this->assertEqual($result['openads_enum'], 'f');
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
            'openads_mediumint_test4' => 'foo MEDIUMINT DEFAULT NULL',
            'openads_mediumint_test5' => 'foo MEDIUMINT(9) DEFAULT 1 NOT NULL',
            'openads_mediumint_test6' => 37,
            'openads_mediumint_test7' => 'MEDIUMINT'
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
     * mappings work as expected for the "openads_varchar" datatype.
     */
    function testDatatypeToNativetypeMappings_openads_varchar()
    {
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
            'openads_varchar_test4' => 'foo VARCHAR DEFAULT NULL',
            'openads_varchar_test5' => 'foo VARCHAR(255) DEFAULT 1 NOT NULL',
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
     * mappings work as expected for the "enum" nativetype.
     */
    function testNativetypeToDatatypeMappings_enum()
    {
        $aTestData = array(
            'enum_test1' => array(
                'type'    => 'enum'
            ),
            'enum_test2' => array(
                'type'    => 'enum(\'t\')'
            )
        );
        $aResultData = array(
            'enum_test1' => array(
                0 => array('openads_enum'),
                1 => null,
                2 => null,
                3 => null
            ),
            'enum_test2' => array(
                0 => array('openads_enum'),
                1 => "'t'",
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
        $aTestData = array(
            'mediumint_test1' => array(
                'type'    => 'mediumint'
            ),
            'mediumint_test2' => array(
                'type'    => 'mediumint(5)'
            ),
            'mediumint_test3' => array(
                'type'    => 'mediumint unsigned'
            ),
            'mediumint_test4' => array(
                'type'    => 'mediumint(6) unsigned'
            )
        );
        $aResultData = array(
            'mediumint_test1' => array(
                0 => array('openads_mediumint'),
                1 => null,
                2 => null,
                3 => null
            ),
            'mediumint_test2' => array(
                0 => array('openads_mediumint'),
                1 => 5,
                2 => null,
                3 => null
            ),
            'mediumint_test3' => array(
                0 => array('openads_mediumint'),
                1 => null,
                2 => true,
                3 => null
            ),
            'mediumint_test4' => array(
                0 => array('openads_mediumint'),
                1 => 6,
                2 => true,
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
     * mappings work as expected for the "varchar" nativetype.
     */
    function testNativetypeToDatatypeMappings_varchar()
    {
        $aTestData = array(
            'varchar_test1' => array(
                'type'    => 'varchar'
            ),
            'varchar_test2' => array(
                'type'    => 'varchar(5)'
            )
        );
        $aResultData = array(
            'varchar_test1' => array(
                0 => array('openads_varchar'),
                1 => null,
                2 => null,
                3 => false
            ),
            'varchar_test2' => array(
                0 => array('openads_varchar'),
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