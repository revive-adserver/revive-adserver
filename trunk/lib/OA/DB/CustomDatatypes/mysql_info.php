<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

/**
 * A file to store two arrays, defining what custom MDB2 datatype definitions
 * exist in the main custom datatype file.
 *
 * @package    OpenXDal
 * @author     Andrew Hill <andrew.hill@openx.org>
 */

/**
 * An array of MDB2 datatypes that have callback functions to convert
 * them into MySQL nativetypes.
 */
$aDatatypes = array(
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
    'bigint',
    'char',
    'decimal',
    'date',
    'datetime',
    'double',
    'enum',
    'float',
    'int',
    'mediumint',
    'mediumtext',
    'set',
    'smallint',
    'text',
    'timestamp',
    'tinyint',
    'varchar'
);

?>