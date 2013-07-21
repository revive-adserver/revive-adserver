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

/**
 * A file to store two arrays, defining what custom MDB2 datatype definitions
 * exist in the main custom datatype file.
 *
 * @package    OpenXDal
 * @author     Andrew Hill <andrew.hill@openx.org>
 */

/**
 * An array of MDB2 datatypes that have callback functions to convert
 * them into PostgreSQL nativetypes.
 */
$aDatatypes = array(
    'date'               => 'date',
    'timestamp'          => 'timestamp',
    'openads_bigint'     => 'openads_bigint',
    'openads_char'       => 'openads_char',
    'openads_decimal'    => 'openads_decimal',
    'openads_date'       => 'openads_date',
    'openads_datetime'   => 'openads_datetime',
    'openads_double'     => 'openads_double',
    'openads_enum'       => 'openads_enum',
    'openads_float'      => 'openads_float',
    'openads_int'        => 'openads_int',
    'openads_mediumint'  => 'openads_mediumint',
    'openads_mediumtext' => 'openads_mediumtext',
    'openads_set'        => 'openads_set',
    'openads_smallint'   => 'openads_smallint',
    'openads_text'       => 'openads_text',
    'openads_timestamp'  => 'openads_timestamp',
    'openads_tinyint'    => 'openads_tinyint',
    'openads_varchar'    => 'openads_varchar'
);

/**
 * An array of MySQL nativetypes that have callback functions to convert
 * them into MDB2 datatypes.
 */
$aNativetypes = array(
//    'bigint',
    'bpchar',
    'float4',
    'bool'
/*
    'decimal',
    'date',
    'datetime',
    'double',
    'enum',
    'int',
    'mediumint',
    'mediumtext',
    'set',
    'smallint',
    'text',
    'timestamp',
    'tinyint',
    'varchar'
*/
);

?>
