<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Manuel Lemos, Tomas V.V.Cox,                 |
// | Stig. S. Bakken, Lukas Smith                                         |
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
// | Author: Christian Dickmann <dickmann@php.net>                        |
// | Author: Igor Feghali <ifeghali@php.net>                              |
// +----------------------------------------------------------------------+
//
// $Id$
//

/**
 * Validates an XML schema file
 *
 * @package MDB2_Schema
 * @category Database
 * @access protected
 * @author Igor Feghali <ifeghali@php.net>
 */
class MDB2_Schema_Validate
{
    // {{{ properties

    var $fail_on_invalid_names = true;
    var $valid_types = array();
    var $force_defaults = true;

    // }}}
    // {{{ constructor

    function __construct($fail_on_invalid_names = true, $valid_types = array(), $force_defaults = true)
    {
        if (is_array($fail_on_invalid_names)) {
            $this->fail_on_invalid_names
                = array_intersect($fail_on_invalid_names, array_keys($GLOBALS['_MDB2_Schema_Reserved']));
        } elseif ($this->fail_on_invalid_names === true) {
            $this->fail_on_invalid_names = array_keys($GLOBALS['_MDB2_Schema_Reserved']);
        } else {
            $this->fail_on_invalid_names = array();
        }
        $this->valid_types = $valid_types;
        $this->force_defaults = $force_defaults;
    }

    function MDB2_Schema_Validate($fail_on_invalid_names = true, $valid_types = array(), $force_defaults = true)
    {
        $this->__construct($fail_on_invalid_names, $valid_types, $force_defaults);
    }

    // }}}
    // {{{ raiseError()

    function &raiseError($ecode, $msg = null)
    {
        $error =& MDB2_Schema::raiseError($ecode, null, null, $msg);
        return $error;
    }

    // }}}
    // {{{ isBoolean()

    /**
     * Verifies if a given value can be considered boolean. If yes, set value
     * to true or false according to its actual contents and return true. If
     * not, keep its contents untouched and return false.
     *
     * @param mixed  value to be checked
     *
     * @return bool
     *
     * @access public
     * @static
     */
    function isBoolean(&$value)
    {
        if (is_bool($value)) {
            return true;
        }
        if ($value === 0 || $value === 1) {
            $value = (bool)$value;
            return true;
        }
        if (!is_string($value)) {
            return false;
        }
        switch ($value) {
        case '0':
        case 'N':
        case 'n':
        case 'no':
        case 'false':
            $value = false;
            break;
        case '1':
        case 'Y':
        case 'y':
        case 'yes':
        case 'true':
            $value = true;
            break;
        default:
            return false;
        }
        return true;
    }

    // }}}
    // {{{ validateTable()

    /* Definition */
    /**
     * Checks whether the definition of a parsed table is valid. Modify table
     * definition when necessary.
     *
     * @param array  multi dimensional array that contains the
     *                tables of current database.
     * @param array  multi dimensional array that contains the
     *                structure and optional data of the table.
     * @param string  name of the parsed table
     *
     * @return bool|error object
     *
     * @access public
     */
    function validateTable($tables, &$table, $table_name)
    {
        /* Have we got a name? */
        if (!$table_name) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'a table has to have a name');
        }

        /* Table name duplicated? */
        if (is_array($tables) && isset($tables[$table_name])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'table "'.$table_name.'" already exists');
        }

        /* Table name reserved? */
        if (is_array($this->fail_on_invalid_names)) {
            $name = strtoupper($table_name);
            foreach ($this->fail_on_invalid_names as $rdbms) {
                if (in_array($name, $GLOBALS['_MDB2_Schema_Reserved'][$rdbms])) {
                    return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                        'table name "'.$table_name.'" is a reserved word in: '.$rdbms);
                }
            }
        }

        /* Was */
        if (empty($table['was'])) {
            $table['was'] = $table_name;
        }

        /* Have we got fields? */
        if (empty($table['fields']) || !is_array($table['fields'])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'tables need one or more fields');
        }

        /* Autoincrement */
        $autoinc = $primary = false;
        $autoinc_field = '';
        foreach ($table['fields'] as $field_name => $field) {
            if (!empty($field['autoincrement'])) {
                $autoinc_field = $field_name;
                if ($primary) {
                    return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                        'there was already an autoincrement field in "'.$table_name.'" before "'.$field_name.'"');
                }
                $autoinc = $primary = true;
            }
        }

        /*
         * Checking Indexes
         * this have to be done here as we can't
         * guarantee that all table fields were already
         * defined in the moment we are parssing indexes
         */
        if (!empty($table['indexes']) && is_array($table['indexes'])) {
            foreach ($table['indexes'] as $name => $index) {
                $skip_index = false;
                if (!empty($index['primary'])) {
                    if (array_key_exists($autoinc_field, $index['fields']))
                    {
                        $skip_index = false;
                    }
                    /*
                     * Lets see if we should skip this index since there is
                     * already an auto increment on this field this implying
                     * a primary key index.
                     */
                    else if ($autoinc && count($index['fields']) == '1') {
                        $skip_index = true;
                    } elseif ($primary) {
                        return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                            'there was already an primary index or autoincrement field in "'.$table_name.'" before "'.$name.'"');
                    } else {
                        $primary = true;
                    }
                }

                if (!$skip_index && is_array($index['fields'])) {
                    foreach ($index['fields'] as $field_name => $field) {
                        if (!isset($table['fields'][$field_name])) {
                            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                                'index field "'.$field_name.'" does not exist');
                        }
                        if (!empty($index['primary'])
                            && !$table['fields'][$field_name]['notnull']
                        ) {
                            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                                'all primary key fields must be defined notnull in "'.$table_name.'"');
                        }
                    }
                } else {
                    unset($table['indexes'][$name]);
                }
            }
        }
        return true;
    }

    // }}}
    // {{{ validateField()

    /**
     * Checks whether the definition of a parsed field is valid. Modify field
     * definition when necessary.
     *
     * @param array  multi dimensional array that contains the
     *                fields of current table.
     * @param array  multi dimensional array that contains the
     *                structure of the parsed field.
     * @param string  name of the parsed field
     *
     * @return bool|error object
     *
     * @access public
     */
    function validateField($fields, &$field, $field_name)
    {
        /* Have we got a name? */
        if (!$field_name) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field name missing');
        }

        /* Field name duplicated? */
        if (is_array($fields) && isset($fields[$field_name])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field "'.$field_name.'" already exists');
        }

        /* Field name reserverd? */
        if (is_array($this->fail_on_invalid_names)) {
            $name = strtoupper($field_name);
            foreach ($this->fail_on_invalid_names as $rdbms) {
                if (in_array($name, $GLOBALS['_MDB2_Schema_Reserved'][$rdbms])) {
                    return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                        'field name "'.$field_name.'" is a reserved word in: '.$rdbms);
                }
            }
        }

        /* Type check */
        if (empty($field['type'])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'no field type specified');
        }
        if (!empty($this->valid_types) && !array_key_exists($field['type'], $this->valid_types)) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'no valid field type ("'.$field['type'].'") specified');
        }

        /* Unsigned */
        if (array_key_exists('unsigned', $field) && !$this->isBoolean($field['unsigned'])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'unsigned has to be a boolean value');
        }

        /* Fixed */
        if (array_key_exists('fixed', $field) && !$this->isBoolean($field['fixed'])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'fixed has to be a boolean value');
        }

        /* Length */

        /**
         * @TODO Temporarily remove length checking...
         */
        //if (array_key_exists('length', $field) && $field['length'] <= 0) {
        //    return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
        //        'length has to be an integer greater 0');
        //}

        /* Was */
        if (empty($field['was'])) {
            $field['was'] = $field_name;
        }

        /* Notnull */
        if (empty($field['notnull'])) {
            $field['notnull'] = false;
        }
        if (!$this->isBoolean($field['notnull'])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field "notnull" has to be a boolean value');
        }

        /* Default */
        if ($this->force_defaults
            && !array_key_exists('default', $field)
            && $field['type'] != 'clob' && $field['type'] != 'blob'
        ) {
            $field['default'] = $this->valid_types[$field['type']];
        }
        if (array_key_exists('default', $field)) {
            if ($field['type'] == 'clob' || $field['type'] == 'blob') {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field['type'].'"-fields are not allowed to have a default value');
            }
            if ($field['default'] === '' && !$field['notnull']) {
                $field['default'] = null;
            }
        }
        if (isset($field['default'])
            && PEAR::isError($result = $this->validateDataFieldValue($field, $field['default'], $field_name))
        ) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'default value of "'.$field_name.'" is incorrect: '.$result->getUserinfo());
        }

        /* Autoincrement */
        if (!empty($field['autoincrement'])) {
            if (!$field['notnull']) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    'all autoincrement fields must be defined notnull');
            }

            if (empty($field['default'])) {
                $field['default'] = '0';
            } elseif ($field['default'] !== '0' && $field['default'] !== 0) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    'all autoincrement fields must be defined default "0"');
            }
        }
        return true;
    }

    // }}}
    // {{{ validateIndex()

    /**
     * Checks whether a parsed index is valid. Modify index definition when
     * necessary.
     *
     * @param array  multi dimensional array that contains the
     *                indexes of current table.
     * @param array  multi dimensional array that contains the
     *                structure of the parsed index.
     * @param string  name of the parsed index
     *
     * @return bool|error object
     *
     * @access public
     */
    function validateIndex($table_indexes, &$index, $index_name)
    {
        if (!$index_name) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'an index has to have a name');
        }
        if (is_array($table_indexes) && isset($table_indexes[$index_name])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'index "'.$index_name.'" already exists');
        }
        if (array_key_exists('unique', $index) && !$this->isBoolean($index['unique'])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field "unique" has to be a boolean value');
        }
        if (array_key_exists('primary', $index) && !$this->isBoolean($index['primary'])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field "primary" has to be a boolean value');
        }

        if (empty($index['was'])) {
            $index['was'] = $index_name;
        }
        return true;
    }

    // }}}
    // {{{ validateIndexField()

    /**
     * Checks whether a parsed index-field is valid. Modify its definition when
     * necessary.
     *
     * @param array  multi dimensional array that contains the
     *                fields of current index.
     * @param array  multi dimensional array that contains the
     *                structure of the parsed index-field.
     * @param string  name of the parsed index-field
     *
     * @return bool|error object
     *
     * @access public
     */
    function validateIndexField($index_fields, &$field, $field_name)
    {
        if (is_array($index_fields) && isset($index_fields[$field_name])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'index field "'.$field_name.'" already exists');
        }
        if (!$field_name) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'the index-field-name is required');
        }
        if (empty($field['sorting'])) {
            $field['sorting'] = 'ascending';
        } elseif($field['sorting'] !== 'ascending' && $field['sorting'] !== 'descending') {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'sorting type unknown');
        }
        return true;
    }

    // }}}
    // {{{ validateSequence()

    /**
     * Checks whether the definition of a parsed sequence is valid. Modify
     * sequence definition when necessary.
     *
     * @param array  multi dimensional array that contains the
     *                sequences of current database.
     * @param array  multi dimensional array that contains the
     *                structure of the parsed sequence.
     * @param string  name of the parsed sequence
     *
     * @return bool|error object
     *
     * @access public
     */
    function validateSequence($sequences, &$sequence, $sequence_name)
    {
        if (!$sequence_name) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'a sequence has to have a name');
        }

        if (is_array($sequences) && isset($sequences[$sequence_name])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'sequence "'.$sequence_name.'" already exists');
        }

        if (is_array($this->fail_on_invalid_names)) {
            $name = strtoupper($sequence_name);
            foreach ($this->fail_on_invalid_names as $rdbms) {
                if (in_array($name, $GLOBALS['_MDB2_Schema_Reserved'][$rdbms])) {
                    return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                        'sequence name "'.$sequence_name.'" is a reserved word in: '.$rdbms);
                }
            }
        }

        if (empty($sequence['was'])) {
            $sequence['was'] = $sequence_name;
        }

        if (!empty($sequence['on'])
            && (empty($sequence['on']['table']) || empty($sequence['on']['field']))
        ) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'sequence "'.$sequence_name.'" on a table was not properly defined');
        }
        return true;
    }

    // }}}
    // {{{ validateDatabase()

    /**
     * Checks whether a parsed database is valid. Modify its structure and
     * data when necessary.
     *
     * @param array  multi dimensional array that contains the
     *                structure and optional data of the database.
     *
     * @return bool|error object
     *
     * @access public
     */
    function validateDatabase(&$database)
    {
        /* Have we got a name? */
        if (!is_array($database) || !isset($database['name']) || !$database['name']) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'a database has to have a name');
        }

        /* Database name reserved? */
        if (is_array($this->fail_on_invalid_names)) {
            $name = strtoupper($database['name']);
            foreach ($this->fail_on_invalid_names as $rdbms) {
                if (in_array($name, $GLOBALS['_MDB2_Schema_Reserved'][$rdbms])) {
                    return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                        'database name "'.$database['name'].'" is a reserved word in: '.$rdbms);
                }
            }
        }

        /* Create */
        if (isset($database['create'])
            && !$this->isBoolean($database['create'])
        ) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field "create" has to be a boolean value');
        }

        /* Overwrite */
        if (isset($database['overwrite'])
            && !$this->isBoolean($database['overwrite'])
        ) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field "overwrite" has to be a boolean value');
        }

        /*
         * This have to be done here as we can't guarantee that all tables
         * were already defined in the moment we are parsing indexes
         */
        if (isset($database['sequences'])) {
            foreach ($database['sequences'] as $seq_name => $seq) {
                if (!empty($seq['on'])
                    && empty($database['tables'][$seq['on']['table']]['fields'][$seq['on']['field']])
                ) {
                    return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                        'sequence "'.$seq_name.'" was assigned on unexisting field/table');
                }
            }
        }
        return true;
    }

    // }}}
    // {{{ validateDataField()

    /* Data Manipulation */
    /**
     * Checks whether a parsed DML-field is valid. Modify its structure when
     * necessary. This is called when validating INSERT and
     * UPDATE.
     *
     * @param array  multi dimensional array that contains the
     *                definition for current table's fields.
     * @param array  multi dimensional array that contains the
     *                parsed fields of the current DML instruction.
     * @param string  name of the parsed insert-field
     * @param string  value to fill the parsed insert-field
     *
     * @return bool|error object
     *
     * @access public
     */
    function validateDataField($table_fields, $instruction_fields, $field_name, $value)
    {
        if (!$field_name) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field-name has to be specified');
        }
        if (is_array($instruction_fields) && isset($instruction_fields[$field_name])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'field "'.$field_name.'" already filled');
        }
        if (is_array($table_fields) && !isset($table_fields[$field_name])) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                '"'.$field_name.'" is not defined');
        }
        if ($value !== ''
            && PEAR::isError($result = $this->validateDataFieldValue($table_fields[$field_name], $value, $field_name))
        ) {
            return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                'value of "'.$field_name.'" is incorrect: '.$result->getUserinfo());
        }
        return true;
    }

    // }}}
    // {{{ validateDataFieldValue()

    /**
     * Checks whether a given value is compatible with a table field. This is
     * done when parsing a field for a INSERT or UPDATE instruction.
     *
     * @param array  multi dimensional array that contains the
     *                definition for current table's fields.
     * @param string  value to fill the parsed field
     * @param string  name of the parsed field
     *
     * @return bool|error object
     *
     * @access public
     * @see MDB2_Schema_Validate::validateInsertField()
     */
    function validateDataFieldValue($field_def, &$field_value, $field_name)
    {
        switch ($field_def['type']) {
        case 'text':
        case 'clob':
            if (!empty($field_def['length']) && strlen($field_value) > $field_def['length']) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" is larger than "'.$field_def['length'].'"');
            }
            break;
        case 'blob':
            $field_value = pack('H*', $field_value);
            if (!empty($field_def['length']) && strlen($field_value) > $field_def['length']) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" is larger than "'.$field_def['type'].'"');
            }
            break;
        case 'integer':
            if ($field_value != ((int)$field_value)) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" is not of type "'.$field_def['type'].'"');
            }
            $field_value = (int)$field_value;
            if (!empty($field_def['unsigned']) && $field_def['unsigned'] && $field_value < 0) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" signed instead of unsigned');
            }
            break;
        case 'boolean':
            if (!$this->isBoolean($field_value)) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" is not of type "'.$field_def['type'].'"');
            }
            break;
        case 'date':
            if (!preg_match('/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $field_value)
                && $field_value !== 'CURRENT_DATE' && strtolower($field_value) !== 'now()'
            ) {


                /**
                 * @TODO Remove this !GROSS HACK! as soon as the OpenX schema has been
                 *       refactored so that all dates have default values.
                 */
                if ($field_value === '') {
                    break;
                }


                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" is not of type "'.$field_def['type'].'"');
            }
            break;
        case 'timestamp':
            if (!preg_match('/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $field_value)
                && $field_value !== 'CURRENT_TIMESTAMP' && strtolower($field_value) !== 'now()'
            ) {


                /**
                 * @TODO Remove this !GROSS HACK! as soon as the OpenX schema has been
                 *       refactored so that all timestamps have default values.
                 */
                if ($field_value === '') {
                    break;
                }


                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" is not of type "'.$field_def['type'].'"');
            }
            break;
        case 'time':
            if (!preg_match("/([0-9]{2}):([0-9]{2}):([0-9]{2})/", $field_value)
                && $field_value !== 'CURRENT_TIME'
            ) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" is not of type "'.$field_def['type'].'"');
            }
            break;
        case 'float':
        case 'double':
            if ($field_value != (double)$field_value) {
                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE,
                    '"'.$field_value.'" is not of type "'.$field_def['type'].'"');
            }
            $field_value = (double)$field_value;
            break;
        }
        return true;
    }
}

?>
