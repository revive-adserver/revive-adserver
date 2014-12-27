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
 * A file to store custom MDB2 datatype definitions, specifically their
 * callback functions to convert the types to native database statements, and
 * to store callback functions to convert native database types into MDB2
 * datatype definitions, when using a PostgreSQL database.
 *
 * Note that the associated info file needs to be kept up to date with this
 * file, so that the Openads_Dal class knows what functions to register
 * whenever creating a PEAR::MDB2 connection to the database.
 *
 * @package    OpenXDal
 */

/**
 * A callback function to map the MDB2 datatype "date" into
 * the PostgreSQL nativetype "DATE".
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
function datatype_date_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "timestamp" datatype
            return $db->datatype->convertResult($aParameters['value'], 'timestamp', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            // For DATETIME fields, if the column is NOT NULL, but the default value is empty,
            // do not include the default value and the NOT NULL clause
			// @todo better fix this!
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] == '')) {
                unset($aParameters['field']['default']);
				$aParameters['field']['notnull'] = false;
            }
            if (isset($aParameters['field']['default']) && ($aParameters['field']['default'] == '0000-00-00')) {
                unset($aParameters['field']['default']);
				$aParameters['field']['notnull'] = false;
            }
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "timestamp" datatype
            return $db->datatype->_compareTimestampDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'DATE';
    }
}

/**
 * A callback function to map the MDB2 datatype "timestamp" into
 * the PostgreSQL nativetype "TIMESTAMP".
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
function datatype_timestamp_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "timestamp" datatype
            return $db->datatype->convertResult($aParameters['value'], 'timestamp', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            // For DATETIME fields, if the column is NOT NULL, but the default value is empty,
            // do not include the default value and the NOT NULL clause
			// @todo better fix this!
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] == '')) {
                unset($aParameters['field']['default']);
				$aParameters['field']['notnull'] = false;
            }
            if (isset($aParameters['field']['default']) && ($aParameters['field']['default'] == '0000-00-00 00:00:00')) {
                unset($aParameters['field']['default']);
				$aParameters['field']['notnull'] = false;
            }
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "timestamp" datatype
            return $db->datatype->_compareTimestampDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'TIMESTAMP';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_bigint" into
 * the PostgreSQL nativetype "BIGINT".
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
function datatype_openads_bigint_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "integer" datatype
            return $db->datatype->convertResult($aParameters['value'], 'integer', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Replace the type
                $datatype = 'BIGSERIAL';
            }
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] === '')) {
                // Cannot declare NOT NULL DEFAULT NULL, so strip DEFAULT declaration
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Strip any DEFAULT values
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            unset($aParameters['previous']['unsigned']);
            unset($aParameters['current']['unsigned']);
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'BIGINT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_char" into
 * the PostgreSQL nativetype "CHAR".
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
function datatype_openads_char_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "text" datatype
            return $db->datatype->convertResult($aParameters['value'], 'text', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "text" datatype
            return $db->datatype->_compareTextDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'CHAR';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_decimal" into
 * the PostgreSQL nativetype "NUMERIC".
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
function datatype_openads_decimal_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "float" datatype
            return $db->datatype->convertResult($aParameters['value'], 'float', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            } else {
                // Is the length a comma separate list of numeric items?
                $aValues = explode(',', $aParameters['field']['length']);
                if (is_array($aValues) && (count($aValues) == 2) && is_numeric($aValues[0]) && is_numeric($aValues[1])) {
                    $value .= '(' . $aParameters['field']['length'] . ')';
                }
            }
            if (isset($aParameters['field']['unsigned']) && $aParameters['field']['unsigned']) {
                $value .= ' UNSIGNED';
            }
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] === '')) {
                // Cannot declare NOT NULL DEFAULT NULL, so strip DEFAULT declaration
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Strip any DEFAULT values and add AUTO_INCREMENT
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
                $declaration_options = ' AUTO_INCREMENT' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "float" datatype
            return $db->datatype->_compareFloatDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "float" datatype
            return $db->datatype->quote($aParameters['value'], 'float');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'NUMERIC';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_date" into
 * the PostgreSQL nativetype "DATE".
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
function datatype_openads_date_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "timestamp" datatype
            return $db->datatype->convertResult($aParameters['value'], 'timestamp', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            // For DATETIME fields, if the column is NOT NULL, but the default value is empty,
            // do not include the default value and the NOT NULL clause
			// @todo better fix this!
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] == '')) {
                unset($aParameters['field']['default']);
				$aParameters['field']['notnull'] = false;
            }
            if (isset($aParameters['field']['default']) && ($aParameters['field']['default'] == '0000-00-00')) {
                unset($aParameters['field']['default']);
				$aParameters['field']['notnull'] = false;
            }
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "timestamp" datatype
            return $db->datatype->_compareTimestampDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "timestamp" datatype
            return $db->datatype->quote($aParameters['value'], 'timestamp');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'DATE';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_datetime" into
 * the PostgreSQL nativetype "TIMESTAMP".
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
function datatype_openads_datetime_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "timestamp" datatype
            return $db->datatype->convertResult($aParameters['value'], 'timestamp', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            // For DATETIME fields, if the column is NOT NULL, but the default value is empty,
            // do not include the default value and the NOT NULL clause
			// @todo better fix this!
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] == '')) {
                unset($aParameters['field']['default']);
				$aParameters['field']['notnull'] = false;
            }
            if (isset($aParameters['field']['default']) && ($aParameters['field']['default'] == '0000-00-00 00:00:00')) {
                unset($aParameters['field']['default']);
				$aParameters['field']['notnull'] = false;
            }
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "timestamp" datatype
            return $db->datatype->_compareTimestampDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "timestamp" datatype
            return $db->datatype->quote($aParameters['value'], 'timestamp');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'TIMESTAMP';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_double" into
 * the PostgreSQL nativetype "DOUBLE PRECISION".
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
function datatype_openads_double_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "float" datatype
            return $db->datatype->convertResult($aParameters['value'], 'float', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['unsigned']) && $aParameters['field']['unsigned']) {
                $value .= ' UNSIGNED';
            }
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] === '')) {
                // Cannot declare NOT NULL DEFAULT NULL, so strip DEFAULT declaration
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Strip any DEFAULT values and add AUTO_INCREMENT
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
                $declaration_options = ' AUTO_INCREMENT' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "float" datatype
            $aParameters['current']['length'] = 8;
            return $db->datatype->_compareFloatDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "float" datatype
            return $db->datatype->quote($aParameters['value'], 'float');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'DOUBLE PRECISION';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_enum" into
 * the PostgreSQL nativetype "TEXT".
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
function datatype_openads_enum_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "text" datatype
            return $db->datatype->convertResult($aParameters['value'], 'text', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            if (isset($aParameters['field']['length']) && $aParameters['field']['length'] == "'t','f'") {
                $datatype = "BOOLEAN";
            }
            $value = $name . ' ' . $datatype;
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            /**
             * @TODO Implement the change set array for this custom type!
             */
            return array();
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'TEXT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_float" into
 * the PostgreSQL nativetype "REAL".
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
function datatype_openads_float_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "float" datatype
            return $db->datatype->convertResult($aParameters['value'], 'float', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['unsigned']) && $aParameters['field']['unsigned']) {
                $value .= ' UNSIGNED';
            }
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] === '')) {
                // Cannot declare NOT NULL DEFAULT NULL, so strip DEFAULT declaration
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Strip any DEFAULT values and add AUTO_INCREMENT
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
                $declaration_options = ' AUTO_INCREMENT' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "float" datatype
            $aParameters['current']['length'] = 4;
            return $db->datatype->_compareFloatDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "float" datatype
            return $db->datatype->quote($aParameters['value'], 'float');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'REAL';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_int" into
 * the PostgreSQL nativetype "INTEGER".
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
function datatype_openads_int_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "integer" datatype
            return $db->datatype->convertResult($aParameters['value'], 'integer', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Replace the type
                $datatype = 'SERIAL';
            }
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] === '')) {
                // Cannot declare NOT NULL DEFAULT NULL, so strip DEFAULT declaration
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Strip any DEFAULT values
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            unset($aParameters['previous']['unsigned']);
            unset($aParameters['current']['unsigned']);
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'INTEGER';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_mediumint" into
 * the PostgreSQL nativetype "INTEGER".
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
function datatype_openads_mediumint_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "integer" datatype
            return $db->datatype->convertResult($aParameters['value'], 'integer', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Replace the type
                $datatype = 'SERIAL';
            }
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] === '')) {
                // Cannot declare NOT NULL DEFAULT NULL, so strip DEFAULT declaration
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Strip any DEFAULT values
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            unset($aParameters['previous']['unsigned']);
            unset($aParameters['current']['unsigned']);
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'INTEGER';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_mediumtext" into
 * the PostgreSQL nativetype "TEXT".
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
function datatype_openads_mediumtext_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return null;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "text" datatype
            return $db->datatype->convertResult($aParameters['value'], 'text', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "text" datatype
            return $db->datatype->_compareTextDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'TEXT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_set" into
 * the PostgreSQL nativetype "TEXT".
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
function datatype_openads_set_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "text" datatype
            return $db->datatype->convertResult($aParameters['value'], 'text', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            /**
             * @TODO Implement the change set array for this custom type!
             */
            return array();
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'TEXT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_smallint" into
 * the PostgreSQL nativetype "SMALLINT".
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
function datatype_openads_smallint_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "integer" datatype
            return $db->datatype->convertResult($aParameters['value'], 'integer', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] === '')) {
                // Cannot declare NOT NULL DEFAULT NULL, so strip DEFAULT declaration
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Strip any DEFAULT values and add AUTO_INCREMENT
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
                $declaration_options = ' AUTO_INCREMENT' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            unset($aParameters['previous']['unsigned']);
            unset($aParameters['current']['unsigned']);
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'SMALLINT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_text" into
 * the PostgreSQL nativetype "TEXT".
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
function datatype_openads_text_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return null;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "text" datatype
            return $db->datatype->convertResult($aParameters['value'], 'text', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            // Strip out any "DEFAULT NULL" value from the options
            $declaration_options = preg_replace('/DEFAULT NULL NOT NULL/', "DEFAULT '' NOT NULL", $declaration_options);
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "text" datatype
            return $db->datatype->_compareTextDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'TEXT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_timestamp" into
 * the PostgreSQL nativetype "TIMESTAMP".
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
function datatype_openads_timestamp_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "timestamp" datatype
            return $db->datatype->convertResult($aParameters['value'], 'timestamp', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            // For DATETIME fields, if the column is NOT NULL, but the default value is empty,
            // do not include the default value
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] == '')) {
                unset($aParameters['field']['default']);
            }
            if (isset($aParameters['field']['default']) && ($aParameters['field']['default'] == '0000-00-00 00:00:00')) {
                unset($aParameters['field']['default']);
            }
            if (isset($aParameters['field']['default']) && ($aParameters['field']['default'] == 'CURRENT_TIMESTAMP')) {
                unset($aParameters['field']['default']);
            }
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "timestamp" datatype
            return $db->datatype->_compareTimestampDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "timestamp" datatype
            return $db->datatype->quote($aParameters['value'], 'timestamp');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'TIMESTAMP';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_tinyint" into
 * the PostgreSQL nativetype "SMALLINT".
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
function datatype_openads_tinyint_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return;
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "integer" datatype
            return $db->datatype->convertResult($aParameters['value'], 'integer', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] === '')) {
                // Cannot declare NOT NULL DEFAULT NULL, so strip DEFAULT declaration
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
            }
            if (isset($aParameters['field']['autoincrement']) && $aParameters['field']['autoincrement']) {
                // Strip any DEFAULT values and add AUTO_INCREMENT
                $declaration_options = preg_replace('/DEFAULT \w+/', '', $declaration_options);
                $declaration_options = ' AUTO_INCREMENT' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            unset($aParameters['previous']['unsigned']);
            unset($aParameters['current']['unsigned']);
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'SMALLINT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_varchar" into
 * the PostgreSQL nativetype "VARCHAR".
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
function datatype_openads_varchar_callback($db, $method, $aParameters)
{
    // Lowercase method names for PHP4/PHP5 compatibility
    $method = strtolower($method);
    switch($method) {
        case 'getvalidtypes':
            // Return the default value for this custom datatype
            return '';
        case 'convertresult':
            // Convert the nativetype value to a datatype value using the
            // built in "text" datatype
            return $db->datatype->convertResult($aParameters['value'], 'text', $aParameters['rtrim']);
        case 'getdeclaration':
            // Prepare and return the PostgreSQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "text" datatype
            return $db->datatype->_compareTextDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into PostgreSQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the PostgreSQL nativetype declaration for this custom datatype
            return 'VARCHAR';
    }
}

/**
 * A callback function to map the MySQL nativetype "CHAR" into
 * the extended MDB2 datatype "openads_char".
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
 *                       a custom type, always has one entry, "openads_char".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_bpchar_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_char';
    // Can the length of the CHAR field be found?
    if ($aFields['length'] == '-1' && !empty($aFields['atttypmod'])) {
        $length = $aFields['atttypmod'] - 4;
    }
    // No unsigned value needed
    $unsigned = null;
    // No fixed value needed
    $fixed = null;
    return array($aType, $length, $unsigned, $fixed);
}


function nativetype_bool_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_enum';
    $length = "'t','f'";
    // No unsigned value needed
    $unsigned = null;
    // No fixed value needed
    $fixed = null;
    return array($aType, $length, $unsigned, $fixed);
}

function nativetype_float4_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_float';
    $length = 4;
    // No unsigned value needed
    $unsigned = null;
    // No fixed value needed
    $fixed = null;
    return array($aType, $length, $unsigned, $fixed);
}
?>
