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
 * datatype definitions, when using a MySQL database.
 *
 * Note that the associated info file needs to be kept up to date with this
 * file, so that the Openads_Dal class knows what functions to register
 * whenever creating a PEAR::MDB2 connection to the database.
 *
 * @package    OpenXDal
 */

/**
 * A callback function to map the MDB2 datatype "openads_bigint" into
 * the MySQL nativetype "BIGINT".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
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
                $declaration_options = ' AUTO_INCREMENT ' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'BIGINT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_char" into
 * the MySQL nativetype "CHAR".
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
            // Prepare and return the MySQL specific code needed to declare
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
            // suitable for inserting into MySQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'CHAR';
        }
}

/**
 * A callback function to map the MDB2 datatype "openads_decimal" into
 * the MySQL nativetype "DECIMAL".
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
            // Prepare and return the MySQL specific code needed to declare
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
                $declaration_options = ' AUTO_INCREMENT ' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "float" datatype
            return $db->datatype->_compareFloatDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "float" datatype
            return $db->datatype->quote($aParameters['value'], 'float');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'DECIMAL';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_date" into
 * the MySQL nativetype "DATE".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            // For DATETIME fields, if the column is NOT NULL, but the default value is empty,
            // do not include the default value
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] == '')) {
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
            // suitable for inserting into MySQL using the built in
            // "timestamp" datatype
            return $db->datatype->quote($aParameters['value'], 'timestamp');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'DATE';
        }
}

/**
 * A callback function to map the MDB2 datatype "openads_datetime" into
 * the MySQL nativetype "DATETIME".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            // For DATETIME fields, if the column is NOT NULL, but the default value is empty,
            // do not include the default value
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] == '')) {
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
            // suitable for inserting into MySQL using the built in
            // "timestamp" datatype
            return $db->datatype->quote($aParameters['value'], 'timestamp');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'DATETIME';
        }
}

/**
 * A callback function to map the MDB2 datatype "openads_double" into
 * the MySQL nativetype "DOUBLE".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
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
                $declaration_options = ' AUTO_INCREMENT ' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "float" datatype
            return $db->datatype->_compareFloatDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "float" datatype
            return $db->datatype->quote($aParameters['value'], 'float');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'DOUBLE';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_enum" into
 * the MySQL nativetype "ENUM".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && $aParameters['field']['length']) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            /**
             * @TODO Implement the change set array for this custom type!
             */
            return array();
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'ENUM';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_float" into
 * the MySQL nativetype "FLOAT".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
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
                $declaration_options = ' AUTO_INCREMENT ' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "float" datatype
            return $db->datatype->_compareFloatDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "float" datatype
            return $db->datatype->quote($aParameters['value'], 'float');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'FLOAT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_int" into
 * the MySQL nativetype "INT".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
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
                $declaration_options = ' AUTO_INCREMENT ' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'INT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_mediumint" into
 * the MySQL nativetype "MEDIUMINT".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
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
                $declaration_options = ' AUTO_INCREMENT ' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
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
 * A callback function to map the MDB2 datatype "openads_mediumtext" into
 * the MySQL nativetype "MEDIUMTEXT".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            // Strip out any "DEFAULT NULL" value from the options
            $declaration_options = preg_replace('/DEFAULT NULL /', '', $declaration_options);
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "text" datatype
            return $db->datatype->_compareTextDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'MEDIUMTEXT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_set" into
 * the MySQL nativetype "SET".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && $aParameters['field']['length']) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            /**
             * @TODO Implement the change set array for this custom type!
             */
            return array();
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'SET';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_smallint" into
 * the MySQL nativetype "SMALLINT".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
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
                $declaration_options = ' AUTO_INCREMENT ' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'SMALLINT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_text" into
 * the MySQL nativetype "TEXT".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
            }
            // Strip out any "DEFAULT NULL" value from the options
            $declaration_options = preg_replace('/DEFAULT NULL /', '', $declaration_options);
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "text" datatype
            return $db->datatype->_compareTextDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'TEXT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_timestamp" into
 * the MySQL nativetype "TIMESTAMP".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            // For DATETIME fields, if the column is NOT NULL, but the default value is empty,
            // do not include the default value
            if ($aParameters['field']['notnull'] && ($aParameters['field']['default'] == '')) {
                unset($aParameters['field']['default']);
            }
            // For DATETIME fields, CURRENT_TIMESTAMP is no good as a default value, as
            // MySQL 4.0 doesn't allow this - unset the default value, and MySQL will
            // automatically set the field to the current timestamp when inserting
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
            // suitable for inserting into MySQL using the built in
            // "timestamp" datatype
            return $db->datatype->quote($aParameters['value'], 'timestamp');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'TIMESTAMP';
        }
}

/**
 * A callback function to map the MDB2 datatype "openads_tinyint" into
 * the MySQL nativetype "TINYINT".
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
            // Prepare and return the MySQL specific code needed to declare
            // a column of this custom datatype
            $name = $db->quoteIdentifier($aParameters['name'], true);
            $datatype = $db->datatype->mapPrepareDatatype($aParameters['type']);
            $declaration_options = $db->datatype->_getDeclarationOptions($aParameters['field']);
            $value = $name . ' ' . $datatype;
            if (isset($aParameters['field']['length']) && is_numeric($aParameters['field']['length'])) {
                $value .= '(' . $aParameters['field']['length'] . ')';
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
                $declaration_options = ' AUTO_INCREMENT ' . $declaration_options;
            }
            $value .= $declaration_options;
            return $value;
        case 'comparedefinition':
            // Return the same array of changes that would be used for
            // the built in "integer" datatype
            return $db->datatype->_compareIntegerDefinition($aParameters['current'], $aParameters['previous']);
        case 'quote':
            // Convert the datatype value into a quoted nativetype value
            // suitable for inserting into MySQL using the built in
            // "integer" datatype
            return $db->datatype->quote($aParameters['value'], 'integer');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'TINYINT';
    }
}

/**
 * A callback function to map the MDB2 datatype "openads_varchar" into
 * the MySQL nativetype "VARCHAR".
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
            // Prepare and return the MySQL specific code needed to declare
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
            // suitable for inserting into MySQL using the built in
            // "text" datatype
            return $db->datatype->quote($aParameters['value'], 'text');
        case 'mappreparedatatype':
            // Return the MySQL nativetype declaration for this custom datatype
            return 'VARCHAR';
    }
}

/**
 * A callback function to map the MySQL nativetype "BIGINT" into
 * the extended MDB2 datatype "openads_bigint".
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
 *                       a custom type, always has one entry, "openads_bigint".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Set to "true" if UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_bigint_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_bigint';
    // Can the length of the BIGINT field be found?
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
function nativetype_char_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_char';
    // Can the length of the CHAR field be found?
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

/**
 * A callback function to map the MySQL nativetype "DECIMAL" into
 * the extended MDB2 datatype "openads_decimal".
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
 *                       a custom type, always has one entry, "openads_decimal".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Set to "true" if UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_decimal_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_decimal';
    // Can the length of the DECIMAL field be found?
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

/**
 * A callback function to map the MySQL nativetype "DATE" into
 * the extended MDB2 datatype "openads_date".
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
 *                       a custom type, always has one entry, "openads_date".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always fase in this case, as the type is not text.
 */
function nativetype_date_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_date';
    // No length value needed
    $length = null;
    // No unsigned value needed
    $unsigned = null;
    // No fixed value needed
    $fixed = null;
    return array($aType, $length, $unsigned, $fixed);
}

/**
 * A callback function to map the MySQL nativetype "DATETIME" into
 * the extended MDB2 datatype "openads_datetime".
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
 *                       a custom type, always has one entry, "openads_datetime".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always fase in this case, as the type is not text.
 */
function nativetype_datetime_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_datetime';
    // No length value needed
    $length = null;
    // No unsigned value needed
    $unsigned = null;
    // No fixed value needed
    $fixed = null;
    return array($aType, $length, $unsigned, $fixed);
}

/**
 * A callback function to map the MySQL nativetype "DOUBLE" into
 * the extended MDB2 datatype "openads_double".
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
 *                       a custom type, always has one entry, "openads_double".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Set to "true" if UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_double_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_double';
    // Can the length of the DOUBLE field be found?
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

/**
 * A callback function to map the MySQL nativetype "ENUM" into
 * the extended MDB2 datatype "openads_enum".
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
 *                       a custom type, always has one entry, "openads_enum".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null. In this case, the length is a fake
 *                       length, containing the enum values.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_enum_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_enum';
    // Can the length (ie. enum values) ENUM field be found?
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

/**
 * A callback function to map the MySQL nativetype "FLOAT" into
 * the extended MDB2 datatype "openads_float".
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
 *                       a custom type, always has one entry, "openads_float".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Set to "true" if UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_float_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_float';
    // Can the length of the FLOAT field be found?
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

/**
 * A callback function to map the MySQL nativetype "INT" into
 * the extended MDB2 datatype "openads_int".
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
 *                       a custom type, always has one entry, "openads_int".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Set to "true" if UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_int_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_int';
    // Can the length of the INT field be found?
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
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Set to "true" if UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_mediumint_callback($db, $aFields)
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

/**
 * A callback function to map the MySQL nativetype "MEDIUMTEXT" into
 * the extended MDB2 datatype "openads_mediumtext".
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
 *                       a custom type, always has one entry, "openads_text".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always false in this case, as mediumtext is not
 *                       of fixed length.
 */
function nativetype_mediumtext_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_mediumtext';
    // Can the length of the MEDIUMTEXT field be found?
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
    // Set fixed to false
    $fixed = false;
    return array($aType, $length, $unsigned, $fixed);
}

/**
 * A callback function to map the MySQL nativetype "SET" into
 * the extended MDB2 datatype "openads_set".
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
 *                       a custom type, always has one entry, "openads_enum".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null. In this case, the length is a fake
 *                       length, containing the enum values.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_set_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_set';
    // Can the length (ie. set values) SET field be found?
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


/**
 * A callback function to map the MySQL nativetype "SMALLINT" into
 * the extended MDB2 datatype "openads_smallint".
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
 *                       a custom type, always has one entry, "openads_smallint".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Set to "true" if UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_smallint_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_smallint';
    // Can the length of the SMALLINT field be found?
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

/**
 * A callback function to map the MySQL nativetype "TEXT" into
 * the extended MDB2 datatype "openads_text".
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
 *                       a custom type, always has one entry, "openads_text".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always false in this case, as text is not
 *                       of fixed length.
 */
function nativetype_text_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_text';
    // Can the length of the TEXT field be found?
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
    // Set fixed to false
    $fixed = false;
    return array($aType, $length, $unsigned, $fixed);
}

/**
 * A callback function to map the MySQL nativetype "TIMESTAMP" into
 * the extended MDB2 datatype "openads_timestamp".
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
 *                       a custom type, always has one entry, "openads_timestamp".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_timestamp_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_timestamp';
    // No length value needed
    $length = null;
    // No unsigned value needed
    $unsigned = null;
    // No fixed value needed
    $fixed = null;
    return array($aType, $length, $unsigned, $fixed);
}

/**
 * A callback function to map the MySQL nativetype "TINYINT" into
 * the extended MDB2 datatype "openads_tinyint".
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
 *                       a custom type, always has one entry, "openads_tinyint".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Set to "true" if UNSIGNED, null otherwise.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always null in this case, as the type is not text.
 */
function nativetype_tinyint_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_tinyint';
    // Can the length of the TINYINT field be found?
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

/**
 * A callback function to map the MySQL nativetype "VARCHAR" into
 * the extended MDB2 datatype "openads_varchar".
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
 *                       a custom type, always has one entry, "openads_varchar".
 *                  1 => The length of the type, if defined by the nativetype,
 *                       otherwise null.
 *                  2 => A boolean value indicating the "unsigned" nature of numeric
 *                       fields. Always null in this case, as the type is not numeric.
 *                  3 => A boolean value indicating the "fixed" nature of text
 *                       fields. Always false in this case, as varchar is not
 *                       of fixed length.
 */
function nativetype_varchar_callback($db, $aFields)
{
    // Prepare the type array
    $aType = array();
    $aType[] = 'openads_varchar';
    // Can the length of the VARCHAR field be found?
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
    // Set fixed to false
    $fixed = false;
    return array($aType, $length, $unsigned, $fixed);
}

?>