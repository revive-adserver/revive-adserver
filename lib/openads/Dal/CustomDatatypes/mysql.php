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
 * An array of MDB2 datatypes that have callback functions to convert
 * them into MySQL nativetypes.
 */
$aDatatypes = array(
    'openads_mediumint' => 'openads_mediumint'
);

/**
 * An array of MySQL nativetypes that have callback functions to convert
 * them into MDB2 datatypes.
 */
$aNativetypes = array(
    'mediumint'
);

/**
 * A callback function to map the MDB2 datatype "openads_mediumint" into
 * the MySQL nativetype "MEDIUMINT".
 *
 * @param MDB2   $db         The MDB2 database reource object.
 * @param string $method     The name of the MDB2_Driver_Datatype_Common method
 *                           the callback function was called from. One of
 *                           "getValidTypes", "convertResult", "getDeclaration",
 *                           "quote" and "mapPrepareDatatype". See
 *                           {@link MDB2_Driver_Datatype_Common} for the details
 *                           of what each method does.
 * @param array $aParameters An array of parameters, being the parameters that
 *                           were passed to the method calling the callback
 *                           function.
 * @return mixed Returns the appropriate value depending on the method that
 *               called the function. See {@link MDB2_Driver_Datatype_Common}
 *               for details of the expected return values of the five possible
 *               calling methods.
 */
function datatype_openads_mediumint_callback(&$db, $method, $aParameters)
{
    // Ensure the datatype module is loaded
    if (is_null($db->datatype)) {
        $db->loadModule('Datatype', null, true);
    }
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return 0;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "integer" datatype
            return $db->datatype->convertResult($aParameters['value'], 'integer', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (is_int($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'MEDIUMINT';
    }
}

/**
 * A callback function to map the MySQL nativetype "MEDIUMINT" into
 * the extended MDB2 datatype "openads_mediumint".
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
 *                       a custom type, always has one entry, "openads_mediumint".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => The boolean value "true" if the nativetype is defined as
 *                       UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_mediumint_callback(&$db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_mediumint';
    // Can the length of the MEDIUMINT field be found?
    $length = null;
    $start = strpos($aFields['type'], '(');
    $end = strpos($aFields['type'], ')');
    if ($start && $end) {
        $start++;
        $chars = $end - $start;
        $length = substr($aFields['type'], $start, $chars);
    }
    // Is the nativetype unsigned?
    $unsigned = null;
    if (strpos(strtolower($aFields['type']), 'unsigned') !== false) {
        $unsigned = true;
    }
    // No fixed value needed
    $fixed = null;
    return array($aType, $length, $unsigned, $fixed);
}

?>