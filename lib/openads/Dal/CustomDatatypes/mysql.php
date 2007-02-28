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

/**
 * A file to store custom MDB2 datatype definitions, including their
 * callback functions to convert the types to native database statements, and
 * to store callback functions to convert native database types into MDB2
 * datatype definitions, when using a MySQL database.
 *
 * @package    OpenadsDal
 * @author     Andrew Hill <andrew.hill@openads.org>
 */

/**
 * An array of MySQL nativetypes that have callback functions to convert
 * them into MDB2 types.
 */
$aNativetypes = array(
    'boolean',
    'varchar'
);

/**
 * A callback function to map the MySQL native type "boolean" into
 * the standard MDB2 datatype "UNSIGNED TINYINT(1)".
 *
 * @param MDB2 $db The MDB2 database reource object.
 * @param array $aFields The standard array of fields produced
 *                       by MDB2 for a native database column, being:
 *                          "default"   The default value of the column
 *                          "extra"     ???
 *                          "key"       ???
 *                          "name"      The name of the column
 *                          "null"      Is NULL permitted for the column
 *                          "type"      The column type
 *
 * @TODO Should this function actually look at the values???
 */
function nativetype_boolean_callback(&$db, $aFields)
{
    $type = array();
    $type[] = 'tinyint';
    $length = 1;
    $unsigned = false;
    $fixed = null;
    return array($type, $length, $unsigned, $fixed);
}

?>