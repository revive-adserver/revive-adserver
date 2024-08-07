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
// | Author: Lukas Smith <smith@pooteeweet.org>                           |
// +----------------------------------------------------------------------+

require_once 'MDB2.php';

define('MDB2_SCHEMA_DUMP_ALL',          0);
define('MDB2_SCHEMA_DUMP_STRUCTURE',    1);
define('MDB2_SCHEMA_DUMP_CONTENT',      2);

/**
 * If you add an error code here, make sure you also add a textual
 * version of it in MDB2_Schema::errorMessage().
 */

define('MDB2_SCHEMA_ERROR',                                         -1);
define('MDB2_SCHEMA_ERROR_PARSE',                                   -2);
define('MDB2_SCHEMA_ERROR_VALIDATE',                                -3);
define('MDB2_SCHEMA_ERROR_UNSUPPORTED',                             -4);    // Driver does not support this function
define('MDB2_SCHEMA_ERROR_INVALID',                                 -5);    // Invalid attribute value
define('MDB2_SCHEMA_ERROR_WRITER',                                  -6);

/**
 * The database manager is a class that provides a set of database
 * management services like installing, altering and dumping the data
 * structures of databases.
 *
 * @package MDB2_Schema
 * @category Database
 * @author  Lukas Smith <smith@pooteeweet.org>
 */
class MDB2_Schema extends PEAR
{
    // {{{ properties

    var $db;

    var $warnings = array();

    var $options = array(
        'fail_on_invalid_names' => true,
        'dtd_file' => false,
        'valid_types' => array(),
        'force_defaults' => true,
        'parser' => 'MDB2_Schema_Parser',
        'writer' => 'MDB2_Schema_Writer',
    );

    // }}}
    // {{{ apiVersion()

    /**
     * Return the MDB2 API version
     *
     * @return string  the MDB2 API version number
     * @access public
     */
    function apiVersion()
    {
        return '0.4.3';
    }

    // }}}
    // {{{ arrayMergeClobber()

    /**
     * Clobbers two arrays together
     *
     * @param  array        array that should be clobbered
     * @param  array        array that should be clobbered
     * @return array|false  array on success and false on error
     *
     * @access public
     * @author kc@hireability.com
     */
    function arrayMergeClobber($a1, $a2)
    {
        if (!is_array($a1) || !is_array($a2)) {
            return false;
        }
        foreach ($a2 as $key => $val) {
            if (is_array($val) && array_key_exists($key, $a1) && is_array($a1[$key])) {
                $a1[$key] = MDB2_Schema::arrayMergeClobber($a1[$key], $val);
            } else {
                $a1[$key] = $val;
            }
        }
        return $a1;
    }

    // }}}
    // {{{ resetWarnings()

    /**
     * reset the warning array
     *
     * @access public
     */
    function resetWarnings()
    {
        $this->warnings = array();
    }

    // }}}
    // {{{ getWarnings()

    /**
     * Get all warnings in reverse order
     *
     * This means that the last warning is the first element in the array
     *
     * @return array with warnings
     * @access public
     * @see resetWarnings()
     */
    function getWarnings()
    {
        return array_reverse($this->warnings);
    }

    // }}}
    // {{{ setOption()

    /**
     * Sets the option for the db class
     *
     * @param string option name
     * @param mixed value for the option
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function setOption($option, $value)
    {
        if (isset($this->options[$option])) {
            if (is_null($value)) {
                return $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                    'may not set an option to value null');
            }
            $this->options[$option] = $value;
            return MDB2_OK;
        }
        return $this->customRaiseError(MDB2_SCHEMA_ERROR_UNSUPPORTED, null, null,
            "unknown option $option");
    }

    // }}}
    // {{{ getOption()

    /**
     * returns the value of an option
     *
     * @param string option name
     * @return mixed the option value or error object
     * @access public
     */
    function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }
        return $this->customRaiseError(MDB2_SCHEMA_ERROR_UNSUPPORTED,
            null, null, "unknown option $option");
    }

    // }}}
    // {{{ factory()

    /**
     * Create a new MDB2 object for the specified database type
     * type
     *
     * @param string|array|MDB2_Driver_Common   'data source name', see the
     *              @see MDB2::parseDSN method for a description of the dsn format.
     *              Can also be specified as an array of the
     *              format returned by @see MDB2::parseDSN.
     *              Finally you can also pass an existing db object to be used.
     * @param array An associative array of option names and their values.
     * @return self|MDB2_Error MDB2_OK or error object
     * @access public
     * @see     MDB2::parseDSN
     */
    public static function factory($db, $options = array())
    {
        $obj = new MDB2_Schema();
        $err = $obj->connect($db, $options);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $obj;
    }

    // }}}
    // {{{ connect()

    /**
     * Create a new MDB2 connection object and connect to the specified
     * database
     *
     * @param string|array|MDB2_Driver_Common   'data source name', see the
     *              @see MDB2::parseDSN method for a description of the dsn format.
     *              Can also be specified as an array of the
     *              format returned by @see MDB2::parseDSN.
     *              Finally you can also pass an existing db object to be used.
     * @param array An associative array of option names and their values.
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     * @see    MDB2::parseDSN
     */
    function connect(&$db, $options = array())
    {
        $db_options = array();
        if (is_array($options)) {
            foreach ($options as $option => $value) {
                if (array_key_exists($option, $this->options)) {
                    $err = $this->setOption($option, $value);
                    if (PEAR::isError($err)) {
                        return $err;
                    }
                } else {
                    $db_options[$option] = $value;
                }
            }
        }
        $this->disconnect();
        if (!MDB2::isConnection($db)) {
            $db =& MDB2::factory($db, $db_options);
        }
        if (PEAR::isError($db)) {
            return $db;
        }

        $this->db =& $db;
        $this->db->loadModule('Datatype');
        $this->db->loadModule('Manager');
        $this->db->loadModule('Reverse');
        $this->db->loadModule('Function');
        if (empty($this->options['valid_types'])) {
            $this->options['valid_types'] = $this->db->datatype->getValidTypes();
        }

        return MDB2_OK;
    }

    // }}}
    // {{{ disconnect()

    /**
     * Log out and disconnect from the database.
     *
     * @access public
     */
    function disconnect()
    {
        if (MDB2::isConnection($this->db)) {
            $this->db->disconnect();
            unset($this->db);
        }
    }

    // }}}
    // {{{ parseDatabaseDefinition()

    /**
     * Parse a database definition from a file or an array
     *
     * @param string|array the database schema array or file name
     * @param bool if non readable files should be skipped
     * @param array associative array that the defines the text string values
     *              that are meant to be used to replace the variables that are
     *              used in the schema description.
     * @param bool make function fail on invalid names
     * @param array database structure definition
     * @access public
     */
    function parseDatabaseDefinition($schema, $skip_unreadable = false, $variables = array(),
        $fail_on_invalid_names = true, $structure = false)
    {
        $database_definition = false;
        if (is_string($schema)) {
            // if $schema is not readable then we just skip it
            // and simply copy the $current_schema file to that file name
            if (is_readable($schema)) {
                $database_definition = $this->parseDatabaseDefinitionFile(
                    $schema, $variables, $fail_on_invalid_names, $structure
                );
            }
        } elseif (is_array($schema)) {
            $database_definition = $schema;
        }
        if (!$database_definition && !$skip_unreadable) {
            $database_definition = $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                'invalid data type of schema or unreadable data source');
        }
        return $database_definition;
    }

    // }}}
    // {{{ parseDatabaseDefinitionFile()

    /**
     * Parse a database definition file by creating a schema format
     * parser object and passing the file contents as parser input data stream.
     *
     * @param string the database schema file.
     * @param array associative array that the defines the text string values
     *              that are meant to be used to replace the variables that are
     *              used in the schema description.
     * @param bool make function fail on invalid names
     * @param array database structure definition
     * @access public
     */
    function parseDatabaseDefinitionFile($input_file, $variables = array(),
        $fail_on_invalid_names = true, $structure = false)
    {
        $dtd_file = $this->options['dtd_file'];
        if ($dtd_file) {
            require_once 'XML/DTD/XmlValidator.php';
            $dtd = new XML_DTD_XmlValidator;
            if (!$dtd->isValid($dtd_file, $input_file)) {
                return $this->customRaiseError(MDB2_SCHEMA_ERROR_PARSE, null, null, $dtd->getMessage());
            }
        }

        $class_name = $this->options['parser'];
        $result = MDB2::loadClass($class_name, $this->db->getOption('debug'));
        if (PEAR::isError($result)) {
            return $result;
        }

        $parser = new $class_name($variables, $fail_on_invalid_names, $structure, $this->options['valid_types'], $this->options['force_defaults']);
        $result = $parser->setInputFile($input_file);
        if (PEAR::isError($result)) {
            return $result;
        }

        $result = $parser->parse();
        if (PEAR::isError($result)) {
            return $result;
        }
        if (PEAR::isError($parser->error)) {
            return $parser->error;
        }

        return $parser->database_definition;
    }

    // }}}
    // {{{ parseDatabaseFileHeader()

    /**
     * Parse a database definition file by creating a schema format
     * parser object and passing the file contents as parser input data stream.
     *
     * @param string the database schema file.
     * @param array associative array that the defines the text string values
     *              that are meant to be used to replace the variables that are
     *              used in the schema description.
     * @access public
     */
    function parseDatabaseFileHeader($input_file, $variables = array())
    {
        $class_name = $this->options['parser'];
        $result = MDB2::loadClass($class_name, $this->db->getOption('debug'));
        if (PEAR::isError($result)) {
            return $result;
        }
        $variables['header_only'] = true;
        $parser = new $class_name($variables);
        $parser->validate = false;
        $result = $parser->setInputFile($input_file);
        if (PEAR::isError($result))
        {
            return $result;
        }
        $result = $parser->parse();
        if (PEAR::isError($result)) {
            return $result;
        }
        if (PEAR::isError($parser->error)) {
            return $parser->error;
        }

        return $parser->database_definition;
    }

    // }}}
    // {{{ parseDatabaseDefinitionFile()

    /**
     * Parse a database definition file by creating a schema format
     * parser object and passing the file contents as parser input data stream.
     *
     * @param string the database schema file.
     * @param array associative array that the defines the text string values
     *              that are meant to be used to replace the variables that are
     *              used in the schema description.
     * @param bool make function fail on invalid names
     * @param array database structure definition
     * @access public
     */
    function parseDatabaseContentFile($input_file, $variables = array(),
        $fail_on_invalid_names = true, $structure = false, $database_definition)
    {
        $dtd_file = $this->options['dtd_file'];
        if ($dtd_file) {
            require_once 'XML/DTD/XmlValidator.php';
            $dtd = new XML_DTD_XmlValidator;
            if (!$dtd->isValid($dtd_file, $input_file)) {
                return $this->customRaiseError(MDB2_SCHEMA_ERROR_PARSE, null, null, $dtd->getMessage());
            }
        }

        $class_name = $this->options['parser'];
        $result = MDB2::loadClass($class_name, $this->db->getOption('debug'));
        if (PEAR::isError($result)) {
            return $result;
        }

        $parser = new $class_name($variables, $fail_on_invalid_names, $structure, $this->options['valid_types'], $this->options['force_defaults']);
        // structure has already been parsed
        $parser->database_definition = $database_definition;
        // don't validate database structure
        $parser->validate = false;
        $result = $parser->setInputFile($input_file);
        if (PEAR::isError($result)) {
            return $result;
        }

        $result = $parser->parse();
        if (PEAR::isError($result)) {
            return $result;
        }
        if (PEAR::isError($parser->error)) {
            return $parser->error;
        }

        return $parser->database_definition;
    }

    // }}}
    // {{{ getDefinitionFromDatabase()

    /**
     * Attempt to reverse engineer a schema structure from an existing MDB2
     * This method can be used if no xml schema file exists yet.
     * The resulting xml schema file may need some manual adjustments.
     *
     * @return array|MDB2_Error array with definition or error object
     * @access public
     */
    // OPENADS: @param array $tables - pass in an array of tables
    function getDefinitionFromDatabase($tables='')
    {
        $database = $this->db->database_name;
        if (empty($database)) {
            return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                'it was not specified a valid database name');
        }

        $database_definition = array(
            'name' => $database,
            'create' => true,
            'overwrite' => false,
            'tables' => array(),
            'sequences' => array(),
        );
        // OPENADS: only get table list if tables param is not sent
        if (!$tables)
        {
            $tables = $this->db->manager->listTables();
        }
        if (PEAR::isError($tables)) {
            return $tables;
        }

        foreach ($tables as $table_name) {
            $fields = $this->db->manager->listTableFields($table_name);
            if (PEAR::isError($fields)) {
                return $fields;
            }

            $database_definition['tables'][$table_name] = array('fields' => array());
            $table_definition =& $database_definition['tables'][$table_name];
            foreach ($fields as $field_name) {
                $definition = $this->db->reverse->getTableFieldDefinition($table_name, $field_name);
                if (PEAR::isError($definition)) {
                    return $definition;
                }

                if (!empty($definition[0]['autoincrement'])) {
                    $definition[0]['default'] = 0;
                }
                $table_definition['fields'][$field_name] = $definition[0];
                $field_choices = count($definition);
                if ($field_choices > 1) {
                    $warning = "There are $field_choices type choices in the table $table_name field $field_name (#1 is the default): ";
                    $field_choice_cnt = 1;
                    $table_definition['fields'][$field_name]['choices'] = array();
                    foreach ($definition as $field_choice) {
                        $table_definition['fields'][$field_name]['choices'][] = $field_choice;
                        $warning.= 'choice #'.($field_choice_cnt).': '.serialize($field_choice);
                        $field_choice_cnt++;
                    }
                    $this->warnings[] = $warning;
                }
            }
            $index_definitions = array();
            $indexes = $this->db->manager->listTableIndexes($table_name);
            if (PEAR::isError($indexes)) {
                return $indexes;
            }

            if (is_array($indexes) && empty($table_definition['indexes'])) {
                foreach ($indexes as $index_name) {
                    $this->db->expectError(MDB2_ERROR_NOT_FOUND);
                    $definition = $this->db->reverse->getTableIndexDefinition($table_name, $index_name);
                    $this->db->popExpect();
                    if (PEAR::isError($definition)) {
                        if (PEAR::isError($definition, MDB2_ERROR_NOT_FOUND)) {
                            continue;
                        }
                        return $definition;
                    }
                   $index_definitions[$index_name] = $definition;
                }
            }

            $constraints = $this->db->manager->listTableConstraints($table_name);
            if (PEAR::isError($constraints)) {
                return $constraints;
            }

            if (is_array($constraints) && empty($table_definition['indexes'])) {
                foreach ($constraints as $index_name) {
                    $this->db->expectError(MDB2_ERROR_NOT_FOUND);
                    $definition = $this->db->reverse->getTableConstraintDefinition($table_name, $index_name);
                    $this->db->popExpect();
                    if (PEAR::isError($definition)) {
                        if (PEAR::isError($definition, MDB2_ERROR_NOT_FOUND)) {
                            continue;
                        }
                        return $definition;
                    }
                    $index_definitions[$index_name] = $definition;
                }
            }
            if (!empty($index_definitions)) {
                $table_definition['indexes'] = $index_definitions;
            }
        }

        $sequences = $this->db->manager->listSequences();
        if (PEAR::isError($sequences)) {
            return $sequences;
        }

        if (is_array($sequences)) {
            foreach ($sequences as $sequence_name) {
                $definition = $this->db->reverse->getSequenceDefinition($sequence_name);
                if (PEAR::isError($definition)) {
                    return $definition;
                }
                if (isset($database_definition['tables'][$sequence_name])
                    && isset($database_definition['tables'][$sequence_name]['indexes'])
                ) {
                    foreach ($database_definition['tables'][$sequence_name]['indexes'] as $index) {
                        if (isset($index['primary']) && $index['primary']
                            && count($index['fields']) === 1
                        ) {
                            $definition['on'] = array(
                                'table' => $sequence_name,
                                'field' => key($index['fields']),
                            );
                            break;
                        }
                    }
                }
                $database_definition['sequences'][$sequence_name] = $definition;
            }
        }
        return $database_definition;
    }

    // }}}
    // {{{ createTableIndexes()

    /**
     * A method to create indexes for an existing table
     *
     * @param string  Name of the table
     * @param array   An array of indexes to be created
     * @param boolean If the table/index should be overwritten if it already exists
     * @return mixed  MDB2_Error if there is an error creating an index, MDB2_OK otherwise
     * @access public
     */
    function createTableIndexes($table_name, $indexes, $overwrite = false)
    {
        if (!$this->db->supports('indexes')) {
            $this->db->debug('Indexes are not supported', __FUNCTION__);
            return MDB2_OK;
        }

        $errorcodes = array(MDB2_ERROR_UNSUPPORTED, MDB2_ERROR_NOT_CAPABLE);
        foreach ($indexes as $index_name => $index) {
            // Does the index already exist, and if so, should it be overwritten?
            $create_index = true;
            $this->db->expectError($errorcodes);
            if (!empty($index['primary']) || !empty($index['unique'])) {
                $current_indexes = $this->db->manager->listTableConstraints($table_name);
            } else {
                $current_indexes = $this->db->manager->listTableIndexes($table_name);
            }
            $this->db->popExpect();
            if (PEAR::isError($current_indexes)) {
                if (!MDB2::isError($current_indexes, $errorcodes)) {
                    return $current_indexes;
                }
            } elseif (is_array($current_indexes) && in_array($index_name, $current_indexes)) {
                if (!$overwrite) {
                    $this->db->debug('Index already exists: '.$index_name, __FUNCTION__);
                    $create_index = false;
                } else {
                    $this->db->debug('Preparing to overwrite index: '.$index_name, __FUNCTION__);
                    if (!empty($index['primary']) || !empty($index['unique'])) {
                        $result = $this->db->manager->dropConstraint($table_name, $index_name);
                    } else {
                        $result = $this->db->manager->dropIndex($table_name, $index_name);
                    }
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                }
            }
            // Check if primary is being used and if it's supported
            if (!empty($index['primary']) && !$this->db->supports('primary_key')) {
                 // Primary not supported so we fallback to UNIQUE and making the field NOT NULL
                unset($index['primary']);
                $index['unique'] = true;
                $changes = array();
                foreach ($index['fields'] as $field => $empty) {
                    $field_info = $this->db->reverse->getTableFieldDefinition($table_name, $field);
                    if (PEAR::isError($field_info)) {
                        return $field_info;
                    }
                    if (!$field_info[0]['notnull']) {
                        $changes['change'][$field] = $field_info[0];
                        $changes['change'][$field]['notnull'] = true;
                    }
                }
                if (!empty($changes)) {
                    $this->db->manager->alterTable($table_name, $changes, false);
                }
            }
            // Should the index be created?
            if ($create_index) {
                if (!empty($index['primary']) || !empty($index['unique'])) {
                    $result = $this->db->manager->createConstraint($table_name, $index_name, $index);
                } else {
                    $result = $this->db->manager->createIndex($table_name, $index_name, $index);
                }
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }
        return MDB2_OK;
    }

    // }}}
    // {{{ createTable()

    /**
     * Create a table and inititialize the table if data is available
     *
     * @param string name of the table to be created
     * @param array  multi dimensional array that contains the
     *               structure and optional data of the table
     * @param bool   if the table/index should be overwritten if it already exists
     * @param array  an array of options to be passed to the database specific driver
     *               version of MDB2_Driver_Manager_Common::createTable().
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function createTable($table_name, $table, $overwrite = false, $options = array())
    {
        $create = true;
        $errorcodes = array(MDB2_ERROR_UNSUPPORTED, MDB2_ERROR_NOT_CAPABLE);
        $this->db->expectError($errorcodes);
        $tables = $this->db->manager->listTables();
        $this->db->popExpect();
        if (PEAR::isError($tables)) {
            if (!MDB2::isError($tables, $errorcodes)) {
                return $tables;
            }
        } elseif (is_array($tables) && in_array($table_name, $tables)) {
            if (!$overwrite) {
                $create = false;
                $this->db->debug('Table already exists: '.$table_name, __FUNCTION__);
            } else {
                $result = $this->db->manager->dropTable($table_name);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $this->db->debug('Overwritting table: '.$table_name, __FUNCTION__);
            }
        }

        if ($create) {
            $result = $this->db->manager->createTable($table_name, $table['fields'], $options);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        if (!empty($table['initialization']) && is_array($table['initialization'])) {
            $result = $this->initializeTable($table_name, $table);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        if (!empty($table['indexes']) && is_array($table['indexes'])) {
            $result = $this->createTableIndexes($table_name, $table['indexes'], $overwrite);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        return MDB2_OK;
    }

    // }}}
    // {{{ initializeTable()

    /**
     * Inititialize the table with data
     *
     * @param string name of the table
     * @param array  multi dimensional array that contains the
     *               structure and optional data of the table
     * @param boolean insert autoincrement values?
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function initializeTable($table_name, $table, $include_autoincrement=true)
    {
        $query_insert = 'INSERT INTO %s (%s) VALUES (%s)';
        $query_update = 'UPDATE %s SET %s %s';
        $query_delete = 'DELETE FROM %s %s';

        $table_name = $this->db->quoteIdentifier($table_name, true);

        $aResult['result']  = MDB2_OK;
        $aResult['count']   = 0;
        $aResult['errors']  = array();
        $aResult['aIds'][0] = 0;
        foreach ($table['initialization'] as $instruction) {
            $query = '';
            switch ($instruction['type']) {
            case 'insert':
                $data = $this->getInstructionFields($instruction, $table['fields'], $include_autoincrement);
                if (!empty($data)) {
                    $aResult['aIds'][] = $data['id'] ?? null;
                    unset($data['id']);
                    $fields = implode(', ', array_keys($data));
                    $values = implode(', ', array_values($data));

                    $query = sprintf($query_insert, $table_name, $fields, $values);
                }
                break;
            case 'update':
                $data = $this->getInstructionFields($instruction, $table['fields']);
                $where = $this->getInstructionWhere($instruction, $table['fields']);
                if (!empty($data)) {
                    array_walk($data, array($this, 'buildFieldValue'));
                    $fields_values = implode(', ', $data);

                    $query = sprintf($query_update, $table_name, $fields_values, $where);
                }
                break;
            case 'delete':
                $where = $this->getInstructionWhere($instruction, $table['fields']);
                $query = sprintf($query_delete, $table_name, $where);
                break;
            default:
                return false;
            }
            if ($query) {
                $result = $this->db->exec($query);
                if (PEAR::isError($result)) {
                    $aResult['errors'][] = $result->getUserInfo();
                    $aResult['result'] = MDB2_ERROR;
                }
                if ($result)
                {
                    $aResult['count']++;
                }
            }
        }
        return $aResult;
    }

    // }}}
    // {{{ buildFieldValue()

    /**
     * Appends the contents of second argument + '=' to the beginning of first
     * argument.
     *
     * Used with array_walk() in initializeTable() for UPDATEs.
     *
     * @param string  value of array's element
     * @param string  key of array's element
     *
     * @return void
     *
     * @access public
     * @see MDB2_Schema::initializeTable()
     */
    function buildFieldValue(&$element, $key)
    {
       $element = $key."=$element";
    }

    // }}}
    // {{{ getExpression()

    /**
     * Generates a string that represents a value that would be associated
     * with a column in a DML instruction.
     *
     * @param array  multi dimensional array that represents the parsed field
     *                of a DML instruction.
     * @param array  multi dimensional array that contains the
     *                definition for current table's fields.
     * @param string  type of given field
     *
     * @return string
     *
     * @access public
     * @see MDB2_Schema::getInstructionFields(), MDB2_Schema::getInstructionWhere()
     */
    function getExpression($element, $fields_definition = array(), $type = null)
    {
        $str = '';
        switch ($element['type']) {
            case 'null':
                $str.= 'NULL';
            break;
            case 'value':
                $str.= $this->db->quote($element['data'], $type);
            break;
            case 'column':
                $str.= $this->db->quoteIdentifier($element['data'], true);
            break;
            case 'function':
                $arguments = array();
                if (!empty($element['data']['arguments'])
                    && is_array($element['data']['arguments'])
                ) {
                    foreach ($element['data']['arguments'] as $v) {
                        $arguments[] = $this->getExpression($v, $fields_definition);
                    }
                }
                if (method_exists($this->db->function, $element['data']['name'])) {
                    $str.= call_user_func_array(
                        array(&$this->db->function, $element['data']['name']),
                        $arguments
                    );
                } else {
                    $str.= $element['data']['name'].'(';
                    $str.= implode(', ', $arguments);
                    $str.= ')';
                }
            break;
            case 'expression':
                $type0 = $type1 = null;
                if ($element['data']['operants'][0]['type'] == 'column'
                    && array_key_exists($element['data']['operants'][0]['data'], $fields_definition)
                ) {
                    $type0 = $fields_definition[$element['data']['operants'][0]['data']]['type'];
                }
                if ($element['data']['operants'][1]['type'] == 'column'
                    && array_key_exists($element['data']['operants'][1]['data'], $fields_definition)
                ) {
                    $type1 = $fields_definition[$element['data']['operants'][1]['data']]['type'];
                }
                $str.= '(';
                $str.= $this->getExpression($element['data']['operants'][0], $fields_definition, $type1);
                $str.= $this->getOperator($element['data']['operator']);
                $str.= $this->getExpression($element['data']['operants'][1], $fields_definition, $type0);
                $str.= ')';
            break;
        }
        return $str;
    }

    // }}}
    // {{{ getOperator()

    /**
     * Returns the matching SQL operator
     *
     * @param string parsed descriptive operator
     *
     * @return string matching SQL operator
     *
     * @access public
     * @static
     * @see MDB2_Schema::getExpression()
     */
    function getOperator($op)
    {
        switch ($op) {
        case 'PLUS':
            return ' + ';
        case 'MINUS':
            return ' - ';
        case 'TIMES':
            return ' * ';
        case 'DIVIDED':
            return ' / ';
        case 'EQUAL':
            return ' = ';
        case 'NOT EQUAL':
            return ' != ';
        case 'LESS THAN':
            return ' < ';
        case 'GREATER THAN':
            return ' > ';
        case 'LESS THAN OR EQUAL':
            return ' <= ';
        case 'GREATER THAN OR EQUAL':
            return ' >= ';
        default:
            return ' '.$op.' ';
        }
    }

    // }}}
    // {{{ getInstructionFields()

    /**
     * Walks the parsed DML instruction array, field by field,
     * storing them and their processed values inside a new array.
     *
     * @param array  multi dimensional array that contains the parsed
     *                DML instruction to be processed.
     * @param array  multi dimensional array that contains the
     *                definition for current table's fields.
     * @param boolean return autoincremnet field definitions in result?
     *
     * @return array  array of strings in the form 'field_name' => 'value'
     *
     * @access public
     * @static
     * @see MDB2_Schema::initializeTable()
     */
    function getInstructionFields($instruction, $fields_definition = array(), $include_autoincrement=true)
    {
        $fields = array();
        if (!empty($instruction['data']['field']) && is_array($instruction['data']['field'])) {
            foreach ($instruction['data']['field'] as $field) {
                if (isset($fields_definition[$field['name']]['autoincrement']))
                {
                    if (!$include_autoincrement)
                    {
                        continue;
                    }
                    $fields['id'] = $field['group']['data'];
                }
                $fields[$field['name']] = $this->getExpression($field['group'], $fields_definition);
            }
        }
        return $fields;
    }

    // }}}
    // {{{ getInstructionWhere()

    /**
     * Translates the parsed WHERE expression of a DML instruction
     * (array structure) to a SQL WHERE clause (string).
     *
     * @param array  multi dimensional array that contains the
     *                structure of the current DML instruction.
     * @param array  multi dimensional array that contains the
     *                definition for current table's fields.
     *
     * @return string SQL WHERE clause
     *
     * @access public
     * @static
     * @see MDB2_Schema::initializeTable()
     */
    function getInstructionWhere($instruction, $fields_definition = array())
    {
        $where = '';
        if (!empty($instruction['data']['where'])) {
            $where = 'WHERE '.$this->getExpression($instruction['data']['where'], $fields_definition);
        }
        return $where;
    }

    // }}}
    // {{{ createSequence()

    /**
     * Create a sequence
     *
     * @param string name of the sequence to be created
     * @param array  multi dimensional array that contains the
     *               structure and optional data of the table
     * @param bool  if the sequence should be overwritten if it already exists
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function createSequence($sequence_name, $sequence, $overwrite = false)
    {
        if (!$this->db->supports('sequences')) {
            $this->db->debug('Sequences are not supported', __FUNCTION__);
            return MDB2_OK;
        }

        $errorcodes = array(MDB2_ERROR_UNSUPPORTED, MDB2_ERROR_NOT_CAPABLE);
        $this->db->expectError($errorcodes);
        $sequences = $this->db->manager->listSequences();
        $this->db->popExpect();
        if (PEAR::isError($sequences)) {
            if (!MDB2::isError($sequences, $errorcodes)) {
                return $sequences;
            }
        } elseif (is_array($sequence) && in_array($sequence_name, $sequences)) {
            if (!$overwrite) {
                $this->db->debug('Sequence already exists: '.$sequence_name, __FUNCTION__);
                return MDB2_OK;
            }

            $result = $this->db->manager->dropSequence($sequence_name);
            if (PEAR::isError($result)) {
                return $result;
            }
            $this->db->debug('Overwritting sequence: '.$sequence_name, __FUNCTION__);
        }

        $start = 1;
        $field = '';
        if (!empty($sequence['on'])) {
            $table = $sequence['on']['table'];
            $field = $sequence['on']['field'];

            $errorcodes = array(MDB2_ERROR_UNSUPPORTED, MDB2_ERROR_NOT_CAPABLE);
            $this->db->expectError($errorcodes);
            $tables = $this->db->manager->listTables();
            $this->db->popExpect();
            if (PEAR::isError($tables) && !MDB2::isError($tables, $errorcodes)) {
                 return $tables;
            }

            if (!PEAR::isError($tables) && is_array($tables) && in_array($table, $tables)) {
                if ($this->db->supports('summary_functions')) {
                    $query = "SELECT MAX($field) FROM ".$this->quoteIdentifier($table, true);
                } else {
                    $query = "SELECT $field FROM ".$this->quoteIdentifier($table, true)." ORDER BY $field DESC";
                }
                $start = $this->db->queryOne($query, 'integer');
                if (PEAR::isError($start)) {
                    return $start;
                }
                ++$start;
            } else {
                $this->warnings[] = 'Could not sync sequence: '.$sequence_name;
            }
        } elseif (!empty($sequence['start']) && is_numeric($sequence['start'])) {
            $start = $sequence['start'];
            $table = '';
        }

        $result = $this->db->manager->createSequence($sequence_name, $start);
        if (PEAR::isError($result)) {
            return $result;
        }

        return MDB2_OK;
    }

    // }}}
    // {{{ createDatabase()

    /**
     * Create a database space within which may be created database objects
     * like tables, indexes and sequences. The implementation of this function
     * is highly DBMS specific and may require special permissions to run
     * successfully. Consult the documentation or the DBMS drivers that you
     * use to be aware of eventual configuration requirements.
     *
     * @param array multi dimensional array that contains the current definition
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function createDatabase($database_definition)
    {
        if (!isset($database_definition['name']) || !$database_definition['name']) {
            return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                'no valid database name specified');
        }
        $create = (isset($database_definition['create']) && $database_definition['create']);
        $overwrite = (isset($database_definition['overwrite']) && $database_definition['overwrite']);
        if ($create) {
            $errorcodes = array(MDB2_ERROR_UNSUPPORTED, MDB2_ERROR_NOT_CAPABLE);
            $this->db->expectError($errorcodes);

            /**
             *
             * We need to clean up database name before any query to prevent
             * database driver from using a inexistent database
             *
             */
            $this->db->setDatabase("");
            $databases = $this->db->manager->listDatabases();

            // Lower / Upper case the db name if the portability deems so.
            if ($this->db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
                $func = $this->db->options['field_case'] == CASE_LOWER ? 'strtolower' : 'strtoupper';
                $db_name = $func($database_definition['name']);
            }

            $this->db->popExpect();
            if (PEAR::isError($databases)) {
                if (!MDB2::isError($databases, $errorcodes)) {
                    return $databases;
                }
            } elseif (is_array($databases) && isset($db_name) && in_array($db_name, $databases)) {
                if (!$overwrite) {
                    $this->db->debug('Database already exists: ' . $database_definition['name'], __FUNCTION__);
                    $create = false;
                } else {
                    $result = $this->db->manager->dropDatabase($database_definition['name']);
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                    $this->db->debug('Overwritting database: '.$database_definition['name'], __FUNCTION__);
                }
            }
            if ($create) {
                $this->db->expectError(MDB2_ERROR_ALREADY_EXISTS);
                $result = $this->db->manager->createDatabase($database_definition['name']);
                $this->db->popExpect();
                if (PEAR::isError($result) && !MDB2::isError($result, MDB2_ERROR_ALREADY_EXISTS)) {
                    return $result;
                }
            }
        }
        $previous_database_name = $this->db->setDatabase($database_definition['name']);
        if (($support_transactions = $this->db->supports('transactions'))
            && PEAR::isError($result = $this->db->beginNestedTransaction())
        ) {
            return $result;
        }

        $created_objects = 0;
        if (isset($database_definition['tables'])
            && is_array($database_definition['tables'])
        ) {
            foreach ($database_definition['tables'] as $table_name => $table) {
                $result = $this->createTable($table_name, $table, $overwrite);
                if (PEAR::isError($result)) {
                    break;
                }
                $created_objects++;
            }
        }
        if (!PEAR::isError($result)
            && isset($database_definition['sequences'])
            && is_array($database_definition['sequences'])
        ) {
            foreach ($database_definition['sequences'] as $sequence_name => $sequence) {
                $result = $this->createSequence($sequence_name, $sequence, false, $overwrite);

                if (PEAR::isError($result)) {
                    break;
                }
                $created_objects++;
            }
        }

        if ($support_transactions) {
            $res = $this->db->completeNestedTransaction();
            if (PEAR::isError($res)) {
                $result = $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                    'Could not end transaction ('.
                    $res->getMessage().' ('.$res->getUserinfo().'))');
            }
        } elseif (PEAR::isError($result) && $created_objects) {
            $result = $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                'the database was only partially created ('.
                $result->getMessage().' ('.$result->getUserinfo().'))');
        }

        $this->db->setDatabase($previous_database_name);

        if (PEAR::isError($result) && $create
            && PEAR::isError($result2 = $this->db->manager->dropDatabase($database_definition['name']))
        ) {
            return $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                'Could not drop the created database after unsuccessful creation attempt ('.
                $result2->getMessage().' ('.$result2->getUserinfo().'))');
        }

        return $result;
    }

    // }}}
    // {{{ compareDefinitions()

    /**
     * Compare a previous definition with the currently parsed definition
     *
     * @param array multi dimensional array that contains the current definition
     * @param array multi dimensional array that contains the previous definition
     * @return array|MDB2_Error array of changes on success, or a error object
     * @access public
     */
    function compareDefinitions($current_definition, $previous_definition)
    {
        $changes = array();

        if (!empty($current_definition['tables']) && is_array($current_definition['tables'])) {
            $changes['tables'] = $defined_tables = array();
            foreach ($current_definition['tables'] as $table_name => $table) {
                $previous_tables = array();
                if (!empty($previous_definition) && is_array($previous_definition)) {
                    $previous_tables = $previous_definition['tables'];
                }
                $change = $this->compareTableDefinitions($table_name, $table, $previous_tables, $defined_tables);
                if (PEAR::isError($change)) {
                    return $change;
                }
                if (!empty($change)) {
                    $changes['tables'] = MDB2_Schema::arrayMergeClobber($changes['tables'], $change);
                }
            }
            if (!empty($previous_definition['tables']) && is_array($previous_definition['tables'])) {
                foreach ($previous_definition['tables'] as $table_name => $table) {
                    if (empty($defined_tables[$table_name])) {
                        $changes['remove'][$table_name] = true;
                    }
                }
            }
        }
        if (!empty($current_definition['sequences']) && is_array($current_definition['sequences'])) {
            $changes['sequences'] = $defined_sequences = array();
            foreach ($current_definition['sequences'] as $sequence_name => $sequence) {
                $previous_sequences = array();
                if (!empty($previous_definition) && is_array($previous_definition)) {
                    $previous_sequences = $previous_definition['sequences'];
                }
                $change = $this->compareSequenceDefinitions(
                    $sequence_name,
                    $sequence,
                    $previous_sequences,
                    $defined_sequences
                );
                if (PEAR::isError($change)) {
                    return $change;
                }
                if (!empty($change)) {
                    $changes['sequences'] = MDB2_Schema::arrayMergeClobber($changes['sequences'], $change);
                }
            }
            if (!empty($previous_definition['sequences']) && is_array($previous_definition['sequences'])) {
                foreach ($previous_definition['sequences'] as $sequence_name => $sequence) {
                    if (empty($defined_sequences[$sequence_name])) {
                        $changes['remove'][$sequence_name] = true;
                    }
                }
            }
        }
        return $changes;
    }

    // }}}
    // {{{ compareTableFieldsDefinitions()

    /**
     * Compare a previous definition with the currently parsed definition
     *
     * @param string name of the table
     * @param array multi dimensional array that contains the current definition
     * @param array multi dimensional array that contains the previous definition
     * @return array|MDB2_Error array of changes on success, or a error object
     * @access public
     */
    function compareTableFieldsDefinitions($table_name, $current_definition,
        $previous_definition)
    {
        $changes = $defined_fields = array();

        if (is_array($current_definition)) {
            foreach ($current_definition as $field_name => $field) {
                // OPENADS:
                // this check allows comparison of two definitions
                // that were reverse-engineered
                // the 'was' field will not exist in such definitions
                if (isset($field['was']))
                {
                    $was_field_name = $field['was'];
                }
                else
                {
                    $was_field_name = $field_name;
                }
                if (!empty($previous_definition[$field_name])
                    && isset($previous_definition[$field_name]['was'])
                    && $previous_definition[$field_name]['was'] == $was_field_name
                ) {
                    $was_field_name = $field_name;
                }
                if (!empty($previous_definition[$was_field_name])) {
                    if ($was_field_name != $field_name) {
                        $changes['rename'][$was_field_name] = array('name' => $field_name, 'definition' => $field);
                    }
                    if (!empty($defined_fields[$was_field_name])) {
                        return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                            'the field "'.$was_field_name.
                            '" was specified for more than one field of table');
                    }
                    $defined_fields[$was_field_name] = true;
                    $change = $this->db->compareDefinition($field, $previous_definition[$was_field_name]);
                    if (PEAR::isError($change)) {
                        return $change;
                    }
                    if (!empty($change)) {
                        $change['definition'] = $field;
                        $changes['change'][$field_name] = $change;
                    }
                } else {
                    if ($field_name != $was_field_name) {
                        return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                            'it was specified a previous field name ("'.
                            $was_field_name.'") for field "'.$field_name.'" of table "'.
                            $table_name.'" that does not exist');
                    }
                    $changes['add'][$field_name] = $field;
                }
            }
        }
        if (isset($previous_definition) && is_array($previous_definition)) {
            foreach ($previous_definition as $field_previous_name => $field_previous) {
                if (empty($defined_fields[$field_previous_name])) {
                    $changes['remove'][$field_previous_name] = true;
                }
            }
        }
        return $changes;
    }

    // }}}
    // {{{ compareTableIndexesDefinitions()

    /**
     * Compare a previous definition with the currently parsed definition
     *
     * @param string name of the table
     * @param array multi dimensional array that contains the current definition
     * @return array|MDB2_Error array of changes on success, or a error object
     * @access public
     */
    function compareTableIndexesDefinitions($table_name, $current_definition,
        $previous_definition)
    {
        $changes = $defined_indexes = array();

        if (is_array($current_definition)) {
            foreach ($current_definition as $index_name => $index) {
                // OPENADS:
                // this check allows comparison of two definitions
                // that were reverse-engineered
                // the 'was' field will not exist in such definitions
                if (isset($index['was']))
                {
                    $was_index_name = $index['was'];
                }
                else
                {
                    $was_index_name = $index_name;
                }
                if (!empty($previous_definition[$index_name])
                    && isset($previous_definition[$index_name]['was'])
                    && $previous_definition[$index_name]['was'] == $was_index_name
                ) {
                    $was_index_name = $index_name;
                }
                if (!empty($previous_definition[$was_index_name])) {
                    $change = array();
                    if ($was_index_name != $index_name) {
                        $change['name'] = $was_index_name;
                    }
                    if (!empty($defined_indexes[$was_index_name])) {
                        return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                            'the index "'.$was_index_name.'" was specified for'.
                            ' more than one index of table "'.$table_name.'"');
                    }
                    $defined_indexes[$was_index_name] = true;

                    $previous_unique = array_key_exists('unique', $previous_definition[$was_index_name])
                        ? $previous_definition[$was_index_name]['unique'] : false;
                    $unique = array_key_exists('unique', $index) ? $index['unique'] : false;
                    if ($previous_unique != $unique) {
                        $change['unique'] = $unique;
                    }
                    $previous_primary = array_key_exists('primary', $previous_definition[$was_index_name])
                        ? $previous_definition[$was_index_name]['primary'] : false;
                    $primary = array_key_exists('primary', $index) ? $index['primary'] : false;
                    if ($previous_primary != $primary) {
                        $change['primary'] = $primary;
                    }
                    $defined_fields = array();
                    $previous_fields = $previous_definition[$was_index_name]['fields'];
                    if (!empty($index['fields']) && is_array($index['fields'])) {
                        foreach ($index['fields'] as $field_name => $field) {
                            if (!empty($previous_fields[$field_name])) {
                                $defined_fields[$field_name] = true;
                                $previous_sorting = array_key_exists('sorting', $previous_fields[$field_name])
                                    ? $previous_fields[$field_name]['sorting'] : '';
                                $sorting = array_key_exists('sorting', $field) ? $field['sorting'] : '';
                                if ($previous_sorting != $sorting) {
                                    $change['change'] = true;
                                }
                            } else {
                                $change['change'] = true;
                            }
                        }
                    }
                    if (isset($previous_fields) && is_array($previous_fields)) {
                        foreach ($previous_fields as $field_name => $field) {
                            if (empty($defined_fields[$field_name])) {
                                $change['change'] = true;
                            }
                        }
                    }
                    if (!empty($change)) {
                        $changes['change'][$index_name] = $current_definition[$index_name];
                    }
                } else {
                    if ($index_name != $was_index_name) {
                        return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                            'it was specified a previous index name ("'.$was_index_name.
                            ') for index "'.$index_name.'" of table "'.$table_name.'" that does not exist');
                    }
                    $changes['add'][$index_name] = $current_definition[$index_name];
                }
            }
        }
        foreach ($previous_definition as $index_previous_name => $index_previous) {
            if (empty($defined_indexes[$index_previous_name])) {
                $changes['remove'][$index_previous_name] = true;
            }
        }
        return $changes;
    }

    // }}}
    // {{{ compareTableDefinitions()

    /**
     * Compare a previous definition with the currently parsed definition
     *
     * @param string name of the table
     * @param array multi dimensional array that contains the current definition
     * @param array multi dimensional array that contains the previous definition
     * @param array table names in the schema
     * @return array|MDB2_Error array of changes on success, or a error object
     * @access public
     */
    function compareTableDefinitions($table_name, $current_definition,
        $previous_definition, &$defined_tables)
    {
        $changes = array();

        if (is_array($current_definition)) {
            $was_table_name = $table_name;
            if (!empty($current_definition['was'])) {
                $was_table_name = $current_definition['was'];
            }
            if (!empty($previous_definition[$was_table_name])) {
                $changes['change'][$was_table_name] = array();
                if ($was_table_name != $table_name) {
                    $changes['change'][$was_table_name] = array('name' => $table_name);
                }
                if (!empty($defined_tables[$was_table_name])) {
                    return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                        'the table "'.$was_table_name.
                        '" was specified for more than one table of the database');
                }
                $defined_tables[$was_table_name] = true;
                if (!empty($current_definition['fields']) && is_array($current_definition['fields'])) {
                    $previous_fields = array();
                    if (isset($previous_definition[$was_table_name]['fields'])
                        && is_array($previous_definition[$was_table_name]['fields'])
                    ) {
                        $previous_fields = $previous_definition[$was_table_name]['fields'];
                    }
                    $change = $this->compareTableFieldsDefinitions(
                        $table_name,
                        $current_definition['fields'],
                        $previous_fields
                    );
                    if (PEAR::isError($change)) {
                        return $change;
                    }
                    if (!empty($change)) {
                        $changes['change'][$was_table_name] =
                            MDB2_Schema::arrayMergeClobber($changes['change'][$was_table_name], $change);
                    }
                }
                if (!empty($current_definition['indexes']) && is_array($current_definition['indexes'])) {
                    $previous_indexes = array();
                    if (isset($previous_definition[$was_table_name]['indexes'])
                        && is_array($previous_definition[$was_table_name]['indexes'])
                    ) {
                        $previous_indexes = $previous_definition[$was_table_name]['indexes'];
                    }
                    $change = $this->compareTableIndexesDefinitions(
                        $table_name,
                        $current_definition['indexes'],
                        $previous_indexes
                    );
                    if (PEAR::isError($change)) {
                        return $change;
                    }
                    if (!empty($change)) {
                        $changes['change'][$was_table_name]['indexes'] = $change;
                    }
                }
                if (empty($changes['change'][$was_table_name])) {
                    unset($changes['change'][$was_table_name]);
                }
                if (empty($changes['change'])) {
                    unset($changes['change']);
                }
            } else {
                if ($table_name != $was_table_name) {
                    return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                        'it was specified a previous table name ("'.$was_table_name.
                        '") for table "'.$table_name.'" that does not exist');
                }
                $changes['add'][$table_name] = true;
            }
        }

        return $changes;
    }

    // }}}
    // {{{ compareSequenceDefinitions()

    /**
     * Compare a previous definition with the currently parsed definition
     *
     * @param string name of the sequence
     * @param array multi dimensional array that contains the current definition
     * @param array multi dimensional array that contains the previous definition
     * @param array sequence names in the schema
     * @return array|MDB2_Error array of changes on success, or a error object
     * @access public
     */
    function compareSequenceDefinitions($sequence_name, $current_definition,
        $previous_definition, &$defined_sequences)
    {
        $changes = array();

        if (is_array($current_definition)) {
            $was_sequence_name = $sequence_name;
            if (!empty($previous_definition[$sequence_name])
                && isset($previous_definition[$sequence_name]['was'])
                && $previous_definition[$sequence_name]['was'] == $was_sequence_name
            ) {
                $was_sequence_name = $sequence_name;
            } elseif (!empty($current_definition['was'])) {
                $was_sequence_name = $current_definition['was'];
            }
            if (!empty($previous_definition[$was_sequence_name])) {
                if ($was_sequence_name != $sequence_name) {
                    $changes['change'][$was_sequence_name]['name'] = $sequence_name;
                }
                if (!empty($defined_sequences[$was_sequence_name])) {
                    return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                        'the sequence "'.$was_sequence_name.'" was specified as base'.
                        ' of more than of sequence of the database');
                }
                $defined_sequences[$was_sequence_name] = true;
                $change = array();
                if (!empty($current_definition['start'])
                    && isset($previous_definition[$was_sequence_name]['start'])
                    && $current_definition['start'] != $previous_definition[$was_sequence_name]['start']
                ) {
                    $change['start'] = $previous_definition[$sequence_name]['start'];
                }
                if (isset($current_definition['on']['table'])
                    && isset($previous_definition[$was_sequence_name]['on']['table'])
                    && $current_definition['on']['table'] != $previous_definition[$was_sequence_name]['on']['table']
                    && isset($current_definition['on']['field'])
                    && isset($previous_definition[$was_sequence_name]['on']['field'])
                    && $current_definition['on']['field'] != $previous_definition[$was_sequence_name]['on']['field']
                ) {
                    $change['on'] = $current_definition['on'];
                }
                if (!empty($change)) {
                    $changes['change'][$was_sequence_name][$sequence_name] = $change;
                }
            } else {
                if ($sequence_name != $was_sequence_name) {
                    return $this->customRaiseError(MDB2_SCHEMA_ERROR_INVALID, null, null,
                        'it was specified a previous sequence name ("'.$was_sequence_name.
                        '") for sequence "'.$sequence_name.'" that does not exist');
                }
                $changes['add'][$sequence_name] = true;
            }
        }
        return $changes;
    }
    // }}}
    // {{{ verifyAlterDatabase()

    /**
     * Verify that the changes requested are supported
     *
     * @param array associative array that contains the definition of the changes
     *              that are meant to be applied to the database structure.
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function verifyAlterDatabase($changes)
    {
        if (!empty($changes['tables']['change']) && is_array($changes['tables']['change'])) {
            foreach ($changes['tables']['change'] as $table_name => $table) {
                if (!empty($table['indexes']) && is_array($table['indexes'])) {
                    if (!$this->db->supports('indexes')) {
                        return $this->customRaiseError(MDB2_SCHEMA_ERROR_UNSUPPORTED, null, null,
                            'indexes are not supported');
                    }
                    $table_changes = count($table['indexes']);
                    if (!empty($table['indexes']['add'])) {
                        $table_changes--;
                    }
                    if (!empty($table['indexes']['remove'])) {
                        $table_changes--;
                    }
                    if (!empty($table['indexes']['change'])) {
                        $table_changes--;
                    }
                    if ($table_changes) {
                        return $this->customRaiseError(MDB2_SCHEMA_ERROR_UNSUPPORTED, null, null,
                            'index alteration not yet supported: '.implode(', ', array_keys($table['indexes'])));
                    }
                }
                unset($table['indexes']);
                $result = $this->db->manager->alterTable($table_name, $table, true);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }
        if (!empty($changes['sequences']) && is_array($changes['sequences'])) {
            if (!$this->db->supports('sequences')) {
                return $this->customRaiseError(MDB2_SCHEMA_ERROR_UNSUPPORTED, null, null,
                    'sequences are not supported');
            }
            $sequence_changes = count($changes['sequences']);
            if (!empty($changes['sequences']['add'])) {
                $sequence_changes--;
            }
            if (!empty($changes['sequences']['remove'])) {
                $sequence_changes--;
            }
            if (!empty($changes['sequences']['change'])) {
                $sequence_changes--;
            }
            if ($sequence_changes) {
                return $this->customRaiseError(MDB2_SCHEMA_ERROR_UNSUPPORTED, null, null,
                    'sequence alteration not yet supported: '.implode(', ', array_keys($changes['sequences'])));
            }
        }
        return MDB2_OK;
    }

    // }}}
    // {{{ alterDatabaseIndexes()

    /**
     * Execute the necessary actions to implement the requested changes
     * in the indexes inside a database structure.
     *
     * @param string name of the table
     * @param array associative array that contains the definition of the changes
     *              that are meant to be applied to the database structure.
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function alterDatabaseIndexes($table_name, $changes)
    {
        $alterations = 0;
        if (empty($changes)) {
            return $alterations;
        }

        if (!empty($changes['remove']) && is_array($changes['remove'])) {
            foreach ($changes['remove'] as $index_name => $index) {
                if (!empty($index['primary']) || !empty($index['unique'])) {
                    $result = $this->db->manager->dropConstraint($table_name, $index_name, !empty($index['primary']));
                } else {
                    $result = $this->db->manager->dropIndex($table_name, $index_name);
                }
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
            }
        }
        if (!empty($changes['change']) && is_array($changes['change'])) {
            foreach ($changes['change'] as $index_name => $index) {
                if (!empty($index['primary']) || !empty($index['unique'])) {
                    $result = $this->db->manager->dropConstraint($table_name, $index_name, !empty($index['primary']));
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                    $result = $this->db->manager->createConstraint($table_name, $index_name, $index);
                } else {
                    $result = $this->db->manager->dropIndex($table_name, $index_name);
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                    $result = $this->db->manager->createIndex($table_name, $index_name, $index);
                }
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
            }
        }
        if (!empty($changes['add']) && is_array($changes['add'])) {
            foreach ($changes['add'] as $index_name => $index) {
                if (!empty($index['primary']) || !empty($index['unique'])) {
                    $result = $this->db->manager->createConstraint($table_name, $index_name, $index);
                } else {
                    $result = $this->db->manager->createIndex($table_name, $index_name, $index);
                }
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
            }
        }

        return $alterations;
    }

    // }}}
    // {{{ alterDatabaseTables()

    /**
     * Execute the necessary actions to implement the requested changes
     * in the tables inside a database structure.
     *
     * @param array multi dimensional array that contains the current definition
     * @param array multi dimensional array that contains the previous definition
     * @param array associative array that contains the definition of the changes
     *              that are meant to be applied to the database structure.
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function alterDatabaseTables($current_definition, $previous_definition, $changes)
    {
        $alterations = 0;
        if (empty($changes)) {
            return $alterations;
        }

        if (!empty($changes['remove']) && is_array($changes['remove'])) {
            foreach ($changes['remove'] as $table_name => $table) {
                $result = $this->db->manager->dropTable($table_name);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
            }
        }

        if (!empty($changes['add']) && is_array($changes['add'])) {
            foreach ($changes['add'] as $table_name => $table) {
                $result = $this->createTable($table_name, $current_definition[$table_name]);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
            }
        }

        if (!empty($changes['change']) && is_array($changes['change'])) {
            foreach ($changes['change'] as $table_name => $table) {
                $indexes = array();
                if (!empty($table['indexes'])) {
                    $indexes = $table['indexes'];
                    unset($table['indexes']);
                }
                if (!empty($indexes['remove'])) {
                    $result = $this->alterDatabaseIndexes($table_name, array('remove' => $indexes['remove']));
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                    unset($indexes['remove']);
                    $alterations += $result;
                }
                $result = $this->db->manager->alterTable($table_name, $table, false);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
                if (!empty($indexes)) {
                    $result = $this->alterDatabaseIndexes($table_name, $indexes);
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                    $alterations += $result;
                }
            }
        }

        return $alterations;
    }

    // }}}
    // {{{ alterDatabaseSequences()

    /**
     * Execute the necessary actions to implement the requested changes
     * in the sequences inside a database structure.
     *
     * @param array multi dimensional array that contains the current definition
     * @param array multi dimensional array that contains the previous definition
     * @param array associative array that contains the definition of the changes
     *              that are meant to be applied to the database structure.
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function alterDatabaseSequences($current_definition, $previous_definition, $changes)
    {
        $alterations = 0;
        if (empty($changes)) {
            return $alterations;
        }

        if (!empty($changes['add']) && is_array($changes['add'])) {
            foreach ($changes['add'] as $sequence_name => $sequence) {
                $result = $this->createSequence($sequence_name, $current_definition[$sequence_name]);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
            }
        }

        if (!empty($changes['remove']) && is_array($changes['remove'])) {
            foreach ($changes['remove'] as $sequence_name => $sequence) {
                $result = $this->db->manager->dropSequence($sequence_name);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
            }
        }

        if (!empty($changes['change']) && is_array($changes['change'])) {
            foreach ($changes['change'] as $sequence_name => $sequence) {
                $result = $this->db->manager->dropSequence($previous_definition[$sequence_name]['was']);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $result = $this->createSequence($sequence_name, $sequence);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $alterations++;
            }
        }

        return $alterations;
    }

    // }}}
    // {{{ alterDatabase()

    /**
     * Execute the necessary actions to implement the requested changes
     * in a database structure.
     *
     * @param array multi dimensional array that contains the current definition
     * @param array multi dimensional array that contains the previous definition
     * @param array associative array that contains the definition of the changes
     *              that are meant to be applied to the database structure.
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function alterDatabase($current_definition, $previous_definition, $changes)
    {
        $alterations = 0;
        if (empty($changes)) {
            return $alterations;
        }

        $result = $this->verifyAlterDatabase($changes);
        if (PEAR::isError($result)) {
            return $result;
        }

        if (!empty($current_definition['name'])) {
            $previous_database_name = $this->db->setDatabase($current_definition['name']);
        }

        if (($support_transactions = $this->db->supports('transactions'))
            && PEAR::isError($result = $this->db->beginNestedTransaction())
        ) {
            return $result;
        }

        if (!empty($changes['tables']) && !empty($current_definition['tables'])) {
            $current_tables = isset($current_definition['tables']) ? $current_definition['tables'] : array();
            $previous_tables = isset($previous_definition['tables']) ? $previous_definition['tables'] : array();
            $result = $this->alterDatabaseTables($current_tables, $previous_tables, $changes['tables']);
            if (is_numeric($result)) {
                $alterations += $result;
            }
        }

        if (!PEAR::isError($result) && !empty($changes['sequences'])) {
            $current_sequences = isset($current_definition['sequences']) ? $current_definition['sequences'] : array();
            $previous_sequences = isset($previous_definition['sequences']) ? $previous_definition['sequences'] : array();
            $result = $this->alterDatabaseSequences($current_sequences, $previous_sequences, $changes['sequences']);
            if (is_numeric($result)) {
                $alterations += $result;
            }
        }

        if ($support_transactions) {
            $res = $this->db->completeNestedTransaction();
            if (PEAR::isError($res)) {
                $result = $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                    'Could not end transaction ('.
                    $res->getMessage().' ('.$res->getUserinfo().'))');
            }
        } elseif (PEAR::isError($result) && $alterations) {
            $result = $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                'the requested database alterations were only partially implemented ('.
                $result->getMessage().' ('.$result->getUserinfo().'))');
        }

        if (isset($previous_database_name)) {
            $this->db->setDatabase($previous_database_name);
        }
        return $result;
    }

    // }}}
    // {{{ dumpDatabaseChanges()

    /**
     * Dump the changes between two database definitions.
     *
     * @param array associative array that specifies the list of database
     *              definitions changes as returned by the _compareDefinitions
     *              manager class function.
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function dumpDatabaseChanges($changes)
    {
        if (!empty($changes['tables'])) {
            if (!empty($changes['tables']['add']) && is_array($changes['tables']['add'])) {
                foreach ($changes['tables']['add'] as $table_name => $table) {
                    $this->db->debug("$table_name:", __FUNCTION__);
                    $this->db->debug("\tAdded table '$table_name'", __FUNCTION__);
                }
            }
            if (!empty($changes['tables']['remove']) && is_array($changes['tables']['remove'])) {
                foreach ($changes['tables']['remove'] as $table_name => $table) {
                    $this->db->debug("$table_name:", __FUNCTION__);
                    $this->db->debug("\tRemoved table '$table_name'", __FUNCTION__);
                }
            }
            if (!empty($changes['tables']['change']) && is_array($changes['tables']['change'])) {
                foreach ($changes['tables']['change'] as $table_name => $table) {
                    if (array_key_exists('name', $table)) {
                        $this->db->debug("\tRenamed table '$table_name' to '".$table['name']."'", __FUNCTION__);
                    }
                    if (!empty($table['add']) && is_array($table['add'])) {
                        foreach ($table['add'] as $field_name => $field) {
                            $this->db->debug("\tAdded field '".$field_name."'", __FUNCTION__);
                        }
                    }
                    if (!empty($table['remove']) && is_array($table['remove'])) {
                        foreach ($table['remove'] as $field_name => $field) {
                            $this->db->debug("\tRemoved field '".$field_name."'", __FUNCTION__);
                        }
                    }
                    if (!empty($table['rename']) && is_array($table['rename'])) {
                        foreach ($table['rename'] as $field_name => $field) {
                            $this->db->debug("\tRenamed field '".$field_name."' to '".$field['name']."'", __FUNCTION__);
                        }
                    }
                    if (!empty($table['change']) && is_array($table['change'])) {
                        foreach ($table['change'] as $field_name => $field) {
                            $field = $field['definition'];
                            if (array_key_exists('type', $field)) {
                                $this->db->debug(
                                    "\tChanged field '$field_name' type to '".$field['type']."'", __FUNCTION__);
                            }
                            if (array_key_exists('unsigned', $field)) {
                                $this->db->debug(
                                    "\tChanged field '$field_name' type to '".
                                    (!empty($field['unsigned']) && $field['unsigned'] ? '' : 'not ')."unsigned'",
                                    __FUNCTION__);
                            }
                            if (array_key_exists('length', $field)) {
                                $this->db->debug(
                                    "\tChanged field '$field_name' length to '".
                                    (!empty($field['length']) ? $field['length']: 'no length')."'", __FUNCTION__);
                            }
                            if (array_key_exists('default', $field)) {
                                $this->db->debug(
                                    "\tChanged field '$field_name' default to ".
                                    (isset($field['default']) ? "'".$field['default']."'" : 'NULL'), __FUNCTION__);
                            }
                            if (array_key_exists('notnull', $field)) {
                                $this->db->debug(
                                   "\tChanged field '$field_name' notnull to ".
                                    (!empty($field['notnull']) && $field['notnull'] ? 'true' : 'false'),
                                    __FUNCTION__
                                );
                            }
                        }
                    }
                    if (!empty($table['indexes']) && is_array($table['indexes'])) {
                        if (!empty($table['indexes']['add']) && is_array($table['indexes']['add'])) {
                            foreach ($table['indexes']['add'] as $index_name => $index) {
                                $this->db->debug("\tAdded index '".$index_name.
                                    "' of table '$table_name'", __FUNCTION__);
                            }
                        }
                        if (!empty($table['indexes']['remove']) && is_array($table['indexes']['remove'])) {
                            foreach ($table['indexes']['remove'] as $index_name => $index) {
                                $this->db->debug("\tRemoved index '".$index_name.
                                    "' of table '$table_name'", __FUNCTION__);
                            }
                        }
                        if (!empty($table['indexes']['change']) && is_array($table['indexes']['change'])) {
                            foreach ($table['indexes']['change'] as $index_name => $index) {
                                if (array_key_exists('name', $index)) {
                                    $this->db->debug(
                                        "\tRenamed index '".$index_name."' to '".$index['name'].
                                        "' on table '$table_name'", __FUNCTION__);
                                }
                                if (array_key_exists('unique', $index)) {
                                    $this->db->debug(
                                        "\tChanged index '".$index_name."' unique to '".
                                        !empty($index['unique'])."' on table '$table_name'", __FUNCTION__);
                                }
                                if (array_key_exists('primary', $index)) {
                                    $this->db->debug(
                                        "\tChanged index '".$index_name."' primary to '".
                                        !empty($index['primary'])."' on table '$table_name'", __FUNCTION__);
                                }
                                if (array_key_exists('change', $index)) {
                                    $this->db->debug("\tChanged index '".$index_name.
                                        "' on table '$table_name'", __FUNCTION__);
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($changes['sequences'])) {
            if (!empty($changes['sequences']['add']) && is_array($changes['sequences']['add'])) {
                foreach ($changes['sequences']['add'] as $sequence_name => $sequence) {
                    $this->db->debug("$sequence_name:", __FUNCTION__);
                    $this->db->debug("\tAdded sequence '$sequence_name'", __FUNCTION__);
                }
            }
            if (!empty($changes['sequences']['remove']) && is_array($changes['sequences']['remove'])) {
                foreach ($changes['sequences']['remove'] as $sequence_name => $sequence) {
                    $this->db->debug("$sequence_name:", __FUNCTION__);
                    $this->db->debug("\tAdded sequence '$sequence_name'", __FUNCTION__);
                }
            }
            if (!empty($changes['sequences']['change']) && is_array($changes['sequences']['change'])) {
                foreach ($changes['sequences']['change'] as $sequence_name => $sequence) {
                    if (array_key_exists('name', $sequence)) {
                        $this->db->debug(
                            "\tRenamed sequence '$sequence_name' to '".
                            $sequence['name']."'", __FUNCTION__);
                    }
                    if (!empty($sequence['change']) && is_array($sequence['change'])) {
                        foreach ($sequence['change'] as $sequence_name => $sequence) {
                            if (array_key_exists('start', $sequence)) {
                                $this->db->debug(
                                    "\tChanged sequence '$sequence_name' start to '".
                                    $sequence['start']."'", __FUNCTION__);
                            }
                        }
                    }
                }
            }
        }
        return MDB2_OK;
    }

    // }}}
    // {{{ dumpDatabase()

    /**
     * Dump a previously parsed database structure in the Metabase schema
     * XML based format suitable for the Metabase parser. This function
     * may optionally dump the database definition with initialization
     * commands that specify the data that is currently present in the tables.
     *
     * @param array multi dimensional array that contains the current definition
     * @param array associative array that takes pairs of tag
     * names and values that define dump options.
     *                 <pre>array (
     *                     'output_mode'    =>    String
     *                         'file' :   dump into a file
     *                         default:   dump using a function
     *                     'output'        =>    String
     *                         depending on the 'Output_Mode'
     *                                  name of the file
     *                                  name of the function
     *                     'end_of_line'        =>    String
     *                         end of line delimiter that should be used
     *                         default: "\n"
     *                 );</pre>
     * @param int that determines what data to dump
     *              + MDB2_SCHEMA_DUMP_ALL       : the entire db
     *              + MDB2_SCHEMA_DUMP_STRUCTURE : only the structure of the db
     *              + MDB2_SCHEMA_DUMP_CONTENT   : only the content of the db
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function dumpDatabase($database_definition, $arguments, $dump = MDB2_SCHEMA_DUMP_ALL)
    {
        $class_name = $this->options['writer'];
        $result = MDB2::loadClass($class_name, $this->db->getOption('debug'));
        if (PEAR::isError($result)) {
            return $result;
        }
        $prefix = '';
        if (isset($arguments['prefix']))
        {
            $prefix = $arguments['prefix'];
        }
        // get initialization data
        if (isset($database_definition['tables']) && is_array($database_definition['tables'])
            && $dump == MDB2_SCHEMA_DUMP_ALL || $dump == MDB2_SCHEMA_DUMP_CONTENT
        ) {
            foreach ($database_definition['tables'] as $table_name => $table) {
                $fields = array();
                foreach ($table['fields'] as $field_name => $field) {
                    $fields[$field_name] = $field['type'];
                }
                $query = 'SELECT '.implode(', ', array_keys($fields)).' FROM ';
                $query.= $this->db->quoteIdentifier($prefix.$table_name, true);
                $data = $this->db->queryAll($query, $fields, MDB2_FETCHMODE_ASSOC);
                if (PEAR::isError($data)) {
                    return $data;
                }
                if (!empty($data)) {
                    $initialization = array();
                    $lob_buffer_length = $this->db->getOption('lob_buffer_length');
                    foreach ($data as $row) {
                        $rows = array();
                        foreach($row as $key => $lob) {
                            if (is_resource($lob)) {
                                $value = '';
                                while (!feof($lob)) {
                                    $value.= fread($lob, $lob_buffer_length);
                                }
                                $row[$key] = $value;
                            }
                            $rows[] = array('name' => $key, 'group' => array('type' => 'value', 'data' => $row[$key]));
                        }
                        $initialization[] = array('type' => 'insert', 'data' => array('field' => $rows));
                    }
                    $database_definition['tables'][$table_name]['initialization'] = $initialization;
                }
            }
        }
        $writer = new $class_name($this->options['valid_types']);
        return $writer->dumpDatabase($database_definition, $arguments, $dump);
    }

    // }}}
    // {{{ dumpDatabaseContent()

    /**
     * Dump a previously parsed database structure in the Metabase schema
     * XML based format suitable for the Metabase parser. This function
     * may optionally dump the database definition with initialization
     * commands that specify the data that is currently present in the tables.
     *
     * @param array multi dimensional array that contains the current definition
     * @param array associative array that takes pairs of tag
     * names and values that define dump options.
     *                 <pre>array (
     *                     'output_mode'    =>    String
     *                         'file' :   dump into a file
     *                         default:   dump using a function
     *                     'output'        =>    String
     *                         depending on the 'Output_Mode'
     *                                  name of the file
     *                                  name of the function
     *                     'end_of_line'        =>    String
     *                         end of line delimiter that should be used
     *                         default: "\n"
     *                 );</pre>
     * @param int that determines what data to dump
     *              + MDB2_SCHEMA_DUMP_ALL       : the entire db
     *              + MDB2_SCHEMA_DUMP_STRUCTURE : only the structure of the db
     *              + MDB2_SCHEMA_DUMP_CONTENT   : only the content of the db
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function dumpDatabaseContent($database_definition, $arguments)
    {
        $class_name = $this->options['writer'];
        $result = MDB2::loadClass($class_name, $this->db->getOption('debug'));
        if (PEAR::isError($result)) {
            return $result;
        }
        $prefix = '';
        if (isset($arguments['prefix']))
        {
            $prefix = $arguments['prefix'];
        }
        $writer = new $class_name($this->options['valid_types']);
        $writer->dumpDatabaseHeader($database_definition, $arguments);
        // get initialization data
        if (isset($database_definition['tables']) && is_array($database_definition['tables']))
        {
            foreach ($database_definition['tables'] as $table_name => $table) {
                $fields = array();
                foreach ($table['fields'] as $field_name => $field) {
                    $fields[$field_name] = $field['type'];
                }
                $query = 'SELECT '.implode(', ', array_keys($fields)).' FROM ';
                $query.= $this->db->quoteIdentifier($prefix.$table_name, true);
                $data = $this->db->queryAll($query, $fields, MDB2_FETCHMODE_ASSOC);
                if (PEAR::isError($data)) {
                    return $data;
                }
                if (!empty($data)) {
                    $initialization = array();
                    $lob_buffer_length = $this->db->getOption('lob_buffer_length');
                    foreach ($data as $row) {
                        $rows = array();
                        foreach($row as $key => $lob) {
                            if (is_resource($lob)) {
                                $value = '';
                                while (!feof($lob)) {
                                    $value.= fread($lob, $lob_buffer_length);
                                }
                                $row[$key] = $value;
                            }
                            $rows[] = array('name' => $key, 'group' => array('type' => 'value', 'data' => $row[$key]));
                        }
                        $initialization[] = array('type' => 'insert', 'data' => array('field' => $rows));
                    }
                    $writer->dumpDatabaseTable($table_name, $initialization, $arguments);
                }
            }
        }
        $writer->dumpDatabaseFooter($database_definition, $arguments);
    }

    // }}}
    // {{{ writeDumpArray()

    function writeDumpArray($dir, $table, $array)
    {
        @mkdir(MAX_PATH.'/var/data/'.$dir);
        $fh = fopen(MAX_PATH.'/var/data/'.$table.'.txt','w');
        if (!$fh)
        {
            return false;
        }
        $result = fwrite($fh,serialize($array));
        fclose($fh);
        return true;
    }

    // }}}
    // {{{ writeInitialization()

    /**
     * Write initialization and sequences
     *
     * @param string|array  data file or data array
     * @param string|array  structure file or array
     * @param array associative array that is passed to the argument
     * of the same name to the parseDatabaseDefinitionFile function. (there third
     * param)
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function writeInitialization($data, $structure = false, $variables = array())
    {
        if ($structure) {
            $structure = $this->parseDatabaseDefinition($structure, false, $variables);
            if (PEAR::isError($structure)) {
                return $structure;
            }
        }

        $data = $this->parseDatabaseDefinition($data, false, $variables, false, $structure);
        if (PEAR::isError($data)) {
            return $data;
        }

        $previous_database_name = null;
        if (!empty($data['name'])) {
            $previous_database_name = $this->db->setDatabase($data['name']);
        } elseif(!empty($structure['name'])) {
            $previous_database_name = $this->db->setDatabase($structure['name']);
        }

        if (!empty($data['tables']) && is_array($data['tables'])) {
            foreach ($data['tables'] as $table_name => $table) {
                if (empty($table['initialization'])) {
                    continue;
                }
                $result = $this->initializeTable($table_name, $table);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }

        if (!empty($structure['sequences']) && is_array($structure['sequences'])) {
            foreach ($structure['sequences'] as $sequence_name => $sequence) {
                if (isset($data['sequences'][$sequence_name])
                    || !isset($sequence['on']['table'])
                    || !isset($data['tables'][$sequence['on']['table']])
                ) {
                    continue;
                }
                $result = $this->createSequence($sequence_name, $sequence, true);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }
        if (!empty($data['sequences']) && is_array($data['sequences'])) {
            foreach ($data['sequences'] as $sequence_name => $sequence) {
                $result = $this->createSequence($sequence_name, $sequence, true);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }

        if (isset($previous_database_name)) {
            $this->db->setDatabase($previous_database_name);
        }

        return MDB2_OK;
    }

    // }}}
    // {{{ updateDatabase()

    /**
     * Compare the correspondent files of two versions of a database schema
     * definition: the previously installed and the one that defines the schema
     * that is meant to update the database.
     * If the specified previous definition file does not exist, this function
     * will create the database from the definition specified in the current
     * schema file.
     * If both files exist, the function assumes that the database was previously
     * installed based on the previous schema file and will update it by just
     * applying the changes.
     * If this function succeeds, the contents of the current schema file are
     * copied to replace the previous schema file contents. Any subsequent schema
     * changes should only be done on the file specified by the $current_schema_file
     * to let this function make a consistent evaluation of the exact changes that
     * need to be applied.
     *
     * @param string|array filename or array of the updated database schema definition.
     * @param string|array filename or array of the previously installed database schema definition.
     * @param array associative array that is passed to the argument of the same
     *              name to the parseDatabaseDefinitionFile function. (there third param)
     * @param bool determines if the disable_query option should be set to true
     *              for the alterDatabase() or createDatabase() call
     * @return bool|MDB2_Error MDB2_OK or error object
     * @access public
     */
    function updateDatabase($current_schema, $previous_schema = false
        , $variables = array(), $disable_query = false)
    {
        $current_definition = $this->parseDatabaseDefinition(
            $current_schema, false, $variables, $this->options['fail_on_invalid_names']
        );
        if (PEAR::isError($current_definition)) {
            return $current_definition;
        }

        $previous_definition = false;
        if ($previous_schema) {
            $previous_definition = $this->parseDatabaseDefinition(
                $previous_schema, true, $variables, $this->options['fail_on_invalid_names']
            );
            if (PEAR::isError($previous_definition)) {
                return $previous_definition;
            }
        }

        if ($previous_definition) {
            $errorcodes = array(MDB2_ERROR_UNSUPPORTED, MDB2_ERROR_NOT_CAPABLE);
            $this->db->expectError($errorcodes);
            $databases = $this->db->manager->listDatabases();
            $this->db->popExpect();
            if (PEAR::isError($databases)) {
                if (!MDB2::isError($databases, $errorcodes)) {
                    return $databases;
                }
            } elseif (!is_array($databases) ||
                !in_array($current_definition['name'], $databases)
            ) {
                return $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                    'database to update does not exist: '.$current_definition['name']);
            }

            $changes = $this->compareDefinitions($current_definition, $previous_definition);
            if (PEAR::isError($changes)) {
                return $changes;
            }

            if (is_array($changes)) {
                $this->db->setOption('disable_query', $disable_query);
                $result = $this->alterDatabase($current_definition, $previous_definition, $changes);
                $this->db->setOption('disable_query', false);
                if (PEAR::isError($result)) {
                    return $result;
                }
                $copy = true;
                if ($this->db->options['debug']) {
                    $result = $this->dumpDatabaseChanges($changes);
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                }
            }
        } else {
            $this->db->setOption('disable_query', $disable_query);
            $result = $this->createDatabase($current_definition);
            $this->db->setOption('disable_query', false);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        if (!$disable_query
            && is_string($previous_schema) && is_string($current_schema)
            && !copy($current_schema, $previous_schema)
        ) {
            return $this->customRaiseError(MDB2_SCHEMA_ERROR, null, null,
                'Could not copy the new database definition file to the current file');
        }

        return MDB2_OK;
    }
    // }}}
    // {{{ errorMessage()

    /**
     * Return a textual error message for a MDB2 error code
     *
     * @param   int|array integer error code,
     *                     <code>null</code> to get the current error code-message map,
     *                    or an array with a new error code-message map
     * @return  string  error message, or false if the error code was not recognized
     * @access public
     */
    function errorMessage($value = null)
    {
        static $errorMessages;
        if (is_array($value)) {
            $errorMessages = $value;
            return MDB2_OK;
        } elseif (!isset($errorMessages)) {
            $errorMessages = array(
                MDB2_SCHEMA_ERROR              => 'unknown error',
                MDB2_SCHEMA_ERROR_PARSE        => 'schema parse error',
                MDB2_SCHEMA_ERROR_VALIDATE     => 'schema validation error',
                MDB2_SCHEMA_ERROR_INVALID      => 'invalid',
                MDB2_SCHEMA_ERROR_UNSUPPORTED  => 'not supported',
                MDB2_SCHEMA_ERROR_WRITER       => 'schema writer error',
            );
        }

        if (is_null($value)) {
            return $errorMessages;
        }

        if (PEAR::isError($value)) {
            $value = $value->getCode();
        }

        return !empty($errorMessages[$value]) ?
           $errorMessages[$value] : $errorMessages[MDB2_SCHEMA_ERROR];
    }

    // }}}
    // {{{ customRaiseError()

    /**
     * This method is used to communicate an error and invoke error
     * callbacks etc.  Basically a wrapper for PEAR::raiseError
     * without the message string.
     *
     * @param int|PEAR_Error  integer error code or and PEAR_Error instance
     * @param int      error mode, see PEAR_Error docs
     *
     *                 error level (E_USER_NOTICE etc).  If error mode is
     *                 PEAR_ERROR_CALLBACK, this is the callback function,
     *                 either as a function name, or as an array of an
     *                 object and method name.  For other error modes this
     *                 parameter is ignored.
     * @param array    Options, depending on the mode, @see PEAR::setErrorHandling
     * @param string   Extra debug information.  Defaults to the last
     *                 query and native error code.
     * @return object  a PEAR error object
     * @access  public
     * @see PEAR_Error
     */
    function customRaiseError($code = null, $mode = null, $options = null, $userinfo = null)
    {
        $err = PEAR::raiseError(null, $code, $mode, $options, $userinfo, 'MDB2_Schema_Error', true);
        return $err;
    }

    // }}}
    // {{{ isError()

    /**
     * Tell whether a value is an MDB2_Schema error.
     *
     * @param   mixed the value to test
     * @param   int   if $data is an error object, return true only if $code is
                      a string and $db->getMessage() == $code or
     *                $code is an integer and $db->getCode() == $code
     * @return  bool  true if parameter is an error
     */
    public static function isError($data, $code = null)
    {
        if ($data instanceof MDB2_Schema_Error) {
            if (is_null($code)) {
                return true;
            } elseif (is_string($code)) {
                return $data->getMessage() === $code;
            } else {
                $code = (array)$code;
                return in_array($data->getCode(), $code);
            }
        }

        return false;
    }

    // }}}
    /**
     * create a new writer object
     * and output the changes array
     * in xml format to a file
     *
     * @param unknown_type $changes
     * @param unknown_type $options
     * @return unknown
     */
    function dumpChangeset($changes, $options)
    {
        require_once("MDB2/Schema/WriterChangeset.php");

        $class_name = 'MDB2_Schema_Changeset_Writer';
        $result = MDB2::loadClass($class_name, $this->db->getOption('debug'));
        if (PEAR::isError($result)) {
            return $result;
        }
        $writer = new $class_name($this->options['valid_types']);
        if (PEAR::isError($writer)) {
            return $writer;
        }
        if (isset($options['split']) && $options['split'])
        {
            return $writer->dumpSplitChanges($changes, $options);
        }
        else if (isset($options['rewrite']) && $options['rewrite'])
        {
            return $writer->rewriteSplitChanges($changes, $options);
        }
        else
        {
            return $writer->dumpChanges($changes, $options);
        }
    }

    // }}}
    // {{{ parseChangesetDefinitionFile()

    /**
     * Parse a changeset definition file by creating a schema
     * parser object and passing the file contents as parser input data stream.
     *
     * @param string the changeset schema file.
     * @param array associative array that the defines the text string values
     *              that are meant to be used to replace the variables that are
     *              used in the schema description.
     * @param bool make function fail on invalid names
     * @param array database structure definition
     * @access public
     */
    function parseChangesetDefinitionFile($input_file, $variables = array(),
        $fail_on_invalid_names = true, $structure = false)
    {
        $dtd_file = $this->options['dtd_file'];
        if ($dtd_file) {
            require_once 'XML/DTD/XmlValidator.php';
            $dtd = new XML_DTD_XmlValidator;
            if (!$dtd->isValid($dtd_file, $input_file)) {
                return $this->customRaiseError(MDB2_SCHEMA_ERROR_PARSE, null, null, $dtd->getMessage());
            }
        }
        require_once("MDB2/Schema/ParserChangeset.php");
        $class_name = 'MDB2_Changeset_Parser';
        $result = MDB2::loadClass($class_name, $this->db->getOption('debug'));
        if (PEAR::isError($result)) {
            return $result;
        }

        $parser = new $class_name($variables, $fail_on_invalid_names, $structure, $this->options['valid_types'], $this->options['force_defaults']);

        $class_name = 'MDB2_Schema_Validate';
        $parser->val = new $class_name($fail_on_invalid_names, $this->options['valid_types'], $this->options['force_defaults']);

        $result = $parser->setInputFile($input_file);
        if (PEAR::isError($result)) {
            return $result;
        }

        $result = $parser->parse();
        if (PEAR::isError($result)) {
            return $result;
        }
        if (PEAR::isError($parser->error)) {
            return $parser->error;
        }

        $changes = $parser->instructionset;

        return $changes;
    }

    // }}}
    // {{{ parseDictionaryDefinitionFile()

    /**
     * Parse a changeset definition file by creating a schema
     * parser object and passing the file contents as parser input data stream.
     *
     * @param string the changeset schema file.
     * @param array associative array that the defines the text string values
     *              that are meant to be used to replace the variables that are
     *              used in the schema description.
     * @param bool make function fail on invalid names
     * @param array database structure definition
     * @access public
     */
    function parseDictionaryDefinitionFile($input_file, $variables = array(),
        $fail_on_invalid_names = true, $structure = false)
    {
        $dtd_file = $this->options['dtd_file'];
        if ($dtd_file) {
            require_once 'XML/DTD/XmlValidator.php';
            $dtd = new XML_DTD_XmlValidator;
            if (!$dtd->isValid($dtd_file, $input_file)) {
                return $this->customRaiseError(MDB2_SCHEMA_ERROR_PARSE, null, null, $dtd->getMessage());
            }
        }
        require_once("MDB2/Schema/ParserDictionary.php");
        $class_name = 'MDB2_Dictionary_Parser';
        $result = MDB2::loadClass($class_name, $this->db->getOption('debug'));
        if (PEAR::isError($result)) {
            return $result;
        }

        $parser = new $class_name($variables, $fail_on_invalid_names, $structure, $this->options['valid_types'], $this->options['force_defaults']);

        $class_name = 'MDB2_Schema_Validate';
        $parser->val = new $class_name($fail_on_invalid_names, $this->options['valid_types'], $this->options['force_defaults']);

        $result = $parser->setInputFile($input_file);
        if (PEAR::isError($result)) {
            return $result;
        }

        $result = $parser->parse();
        if (PEAR::isError($result)) {
            return $result;
        }
        if (PEAR::isError($parser->error)) {
            return $parser->error;
        }

        $dictionary = $parser->dictionary_definition;

        return $dictionary;
    }

    // }}}
}

/**
 * MDB2_Schema_Error implements a class for reporting portable database error
 * messages.
 *
 * @package MDB2_Schema
 * @category Database
 * @author  Stig Bakken <ssb@fast.no>
 */
class MDB2_Schema_Error extends PEAR_Error
{
    /**
     * MDB2_Schema_Error constructor.
     *
     * @param mixed     error code, or string with error message.
     * @param int       what 'error mode' to operate in
     * @param int       what error level to use for $mode & PEAR_ERROR_TRIGGER
     * @param mixed     additional debug info, such as the last query
     * @access  public
     */
    function __construct($code = MDB2_SCHEMA_ERROR, $mode = PEAR_ERROR_RETURN,
              $level = E_USER_NOTICE, $debuginfo = null)
    {
        parent::__construct('MDB2_Schema Error: ' . MDB2_Schema::errorMessage($code), $code,
            $mode, $level, $debuginfo);
    }
}

?>