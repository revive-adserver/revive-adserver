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
// | Author: Paul Cooper <pgc@ucecom.com>                                 |
// +----------------------------------------------------------------------+

require_once 'MDB2/Driver/Manager/Common.php';

/**
 * MDB2 MySQL driver for the management modules
 *
 * @package MDB2
 * @category Database
 * @author  Paul Cooper <pgc@ucecom.com>
 */
class MDB2_Driver_Manager_pgsql extends MDB2_Driver_Manager_Common
{
    // {{{ createDatabase()

    /**
     * create a new database
     *
     * @param string $name name of the database that should be created
     * @return mixed MDB2_OK on success, a MDB2 error on failure
     * @access public
     **/
    function createDatabase($name)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $name = $db->quoteIdentifier($name, true);
        $query = "CREATE DATABASE $name";
        // Charset handling - custom OpenX
        if ($charset = $db->getOption('default_charset')) {
            $charset = "'".addslashes($charset)."'";
            $query .= " ENCODING $charset";
        }
        return $db->standaloneQuery($query, null, true);
    }

    // }}}
    // {{{ dropDatabase()

    /**
     * drop an existing database
     *
     * @param string $name name of the database that should be dropped
     * @return mixed MDB2_OK on success, a MDB2 error on failure
     * @access public
     **/
    function dropDatabase($name)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $name = $db->quoteIdentifier($name, true);
        return $db->standaloneQuery("DROP DATABASE $name", null, true);
    }

    // }}}
    // {{{ alterTable()

    /**
     * alter an existing table
     *
     * @param string $name         name of the table that is intended to be changed.
     * @param array $changes     associative array that contains the details of each type
     *                             of change that is intended to be performed. The types of
     *                             changes that are currently supported are defined as follows:
     *
     *                             name
     *
     *                                New name for the table.
     *
     *                            add
     *
     *                                Associative array with the names of fields to be added as
     *                                 indexes of the array. The value of each entry of the array
     *                                 should be set to another associative array with the properties
     *                                 of the fields to be added. The properties of the fields should
     *                                 be the same as defined by the MDB2 parser.
     *
     *
     *                            remove
     *
     *                                Associative array with the names of fields to be removed as indexes
     *                                 of the array. Currently the values assigned to each entry are ignored.
     *                                 An empty array should be used for future compatibility.
     *
     *                            rename
     *
     *                                Associative array with the names of fields to be renamed as indexes
     *                                 of the array. The value of each entry of the array should be set to
     *                                 another associative array with the entry named name with the new
     *                                 field name and the entry named Declaration that is expected to contain
     *                                 the portion of the field declaration already in DBMS specific SQL code
     *                                 as it is used in the CREATE TABLE statement.
     *
     *                            change
     *
     *                                Associative array with the names of the fields to be changed as indexes
     *                                 of the array. Keep in mind that if it is intended to change either the
     *                                 name of a field and any other properties, the change array entries
     *                                 should have the new names of the fields as array indexes.
     *
     *                                The value of each entry of the array should be set to another associative
     *                                 array with the properties of the fields to that are meant to be changed as
     *                                 array entries. These entries should be assigned to the new values of the
     *                                 respective properties. The properties of the fields should be the same
     *                                 as defined by the MDB2 parser.
     *
     *                            Example
     *                                array(
     *                                    'name' => 'userlist',
     *                                    'add' => array(
     *                                        'quota' => array(
     *                                            'type' => 'integer',
     *                                            'unsigned' => 1
     *                                        )
     *                                    ),
     *                                    'remove' => array(
     *                                        'file_limit' => array(),
     *                                        'time_limit' => array()
     *                                    ),
     *                                    'change' => array(
     *                                        'name' => array(
     *                                            'length' => '20',
     *                                            'definition' => array(
     *                                                'type' => 'text',
     *                                                'length' => 20,
     *                                            ),
     *                                        )
     *                                    ),
     *                                    'rename' => array(
     *                                        'sex' => array(
     *                                            'name' => 'gender',
     *                                            'definition' => array(
     *                                                'type' => 'text',
     *                                                'length' => 1,
     *                                                'default' => 'M',
     *                                            ),
     *                                        )
     *                                    )
     *                                )
     *
     * @param boolean $check     indicates whether the function should just check if the DBMS driver
     *                             can perform the requested table alterations if the value is true or
     *                             actually perform them otherwise.
     * @access public
     *
     * @todo OpenX note - Altering column type is only partially working. There are issue when moving
     *       to a type which doesn't allow implicit casts from the original datatype (i.e. TEXT to INT)
     *       and when the old default is not compatible with the new type. We might need to improve the
     *       method to get the original definition of the field and correctly deal with not currently
     *       not supported cases. Also, changing a field to become "serial" doesn't correctly link the
     *       sequence to the table, so any drop statement won't cascade to the sequence. As a workaround
     *       we might rename the old field, add a new serial field with the correct definition, migrate
     *       the data and drop the old field. The only issue with that is that the field order will change,
     *       but since the SQL standard doesn't in fact guarantee any row/column order, it should be a
     *       minor issue.
     *
     * @return mixed MDB2_OK on success, a MDB2 error on failure
     */
    function alterTable($name, $changes, $check)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        foreach ($changes as $change_name => $change) {
            switch ($change_name) {
            case 'add':
            case 'remove':
            case 'change':
            case 'name':
            case 'rename':
                break;
            default:
                return $db->raiseError(MDB2_ERROR_CANNOT_ALTER, null, null,
                    'change type "'.$change_name.'\" not yet supported', __FUNCTION__);
            }
        }

        if ($check) {
            return MDB2_OK;
        }

        $tableName = $db->quoteIdentifier($name,true);

        if (!empty($changes['add']) && is_array($changes['add'])) {
            foreach ($changes['add'] as $field_name => $field) {
                $query = 'ADD ' . $db->getDeclaration($field['type'], $field_name, $field);
                $result = $db->exec("ALTER TABLE $tableName $query");
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }

        if (!empty($changes['remove']) && is_array($changes['remove'])) {
            foreach ($changes['remove'] as $field_name => $field) {
                $field_name = $db->quoteIdentifier($field_name, true);
                $query = 'DROP ' . $field_name;
                $result = $db->exec("ALTER TABLE $tableName $query");
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }

        if (!empty($changes['change']) && is_array($changes['change'])) {
            foreach ($changes['change'] as $field_name => $field) {
                $field_name = $db->quoteIdentifier($field_name, true);
                if (!empty($field['definition']['type'])) {
                    $server_info = $db->getServerVersion();
                    if (PEAR::isError($server_info)) {
                        return $server_info;
                    }
                    if (is_array($server_info) && $server_info['major'] < 8) {
                        return $db->raiseError(MDB2_ERROR_CANNOT_ALTER, null, null,
                            'changing column type for "'.$change_name.'\" requires PostgreSQL 8.0 or above', __FUNCTION__);
                    }
                    //$db->loadModule('Datatype', null, true);
                    //$query = "ALTER $field_name TYPE ".$db->datatype->getTypeDeclaration($field['definition']);
                    $options = $field['definition'];
                    unset($options['notnull']);
                    unset($options['default']);
                    unset($options['autoincrement']);
                    $declaration = $db->getDeclaration($field['definition']['type'], '', $options);
                    $declaration = preg_replace('/ DEFAULT NULL$/', '', $declaration);
                    $query = "ALTER $field_name TYPE".$declaration;
                    if (strpos($declaration, 'INTEGER') === 1) {
                        $query .= " USING $field_name::INTEGER";
                    }
                    $result = $db->exec("ALTER TABLE $tableName $query");
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                    if (!empty($field['definition']['autoincrement'])) {
                        unset($field['definition']['default']);
                        $field['definition']['notnull'] = true;
                        $result = $this->createSequence($name.'_'.$field_name);
                        if (PEAR::isError($result)) {
                            return $result;
                        }
                        $query = "ALTER $field_name SET DEFAULT nextval('".$db->quoteIdentifier($db->getSequenceName($name.'_'.$field_name))."')";
                        $result = $db->exec("ALTER TABLE $tableName $query");
                        if (PEAR::isError($result)) {
                            return $result;
                        }
                    }
                }
                if (array_key_exists('default', $field['definition'])) {
                    $query = "ALTER $field_name SET DEFAULT ".$db->quote($field['definition']['default'], $field['definition']['type']);
                    $result = $db->exec("ALTER TABLE $tableName $query");
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                }
                if (!empty($field['definition']['notnull'])) {
                    $query = "ALTER $field_name ".($field['definition']['notnull'] ? "SET" : "DROP").' NOT NULL';
                    $result = $db->exec("ALTER TABLE $tableName $query");
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                }
            }
        }

        if (!empty($changes['rename']) && is_array($changes['rename'])) {
            foreach ($changes['rename'] as $field_name => $field) {
                $field_name = $db->quoteIdentifier($field_name, true);
                $result = $db->exec("ALTER TABLE $tableName RENAME COLUMN $field_name TO ".$db->quoteIdentifier($field['name'], true));
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }

        if (!empty($changes['name'])) {
            $change_name = $db->quoteIdentifier($changes['name'], true);
            $result = $db->exec("ALTER TABLE $tableName RENAME TO ".$change_name);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        return MDB2_OK;
    }

    // }}}
    // {{{ listDatabases()

    /**
     * list all databases
     *
     * @return mixed data array on success, a MDB2 error on failure
     * @access public
     **/
    function listDatabases()
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $query = 'SELECT datname FROM pg_database';
        $result2 = $db->standaloneQuery($query, array('text'), false);
        if (!MDB2::isResultCommon($result2)) {
            return $result2;
        }

        $result = $result2->fetchCol();
        $result2->free();
        if (PEAR::isError($result)) {
            return $result;
        }
        if ($db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
            $result = array_map(($db->options['field_case'] == CASE_LOWER ? 'strtolower' : 'strtoupper'), $result);
        }
        return $result;
    }

    // }}}
    // {{{ listUsers()

    /**
     * list all users
     *
     * @return mixed data array on success, a MDB2 error on failure
     * @access public
     **/
    function listUsers()
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $query = 'SELECT usename FROM pg_user';
        $result2 = $db->standaloneQuery($query, array('text'), false);
        if (!MDB2::isResultCommon($result2)) {
            return $result2;
        }

        $result = $result2->fetchCol();
        $result2->free();
        return $result;
    }

    // }}}
    // {{{ listViews()

    /**
     * list the views in the database
     *
     * @return mixed MDB2_OK on success, a MDB2 error on failure
     * @access public
     **/
    function listViews($database = null)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $query = 'SELECT viewname FROM pg_views';
        $result = $db->queryCol($query);
        if (PEAR::isError($result)) {
            return $result;
        }
        if ($db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
            $result = array_map(($db->options['field_case'] == CASE_LOWER ? 'strtolower' : 'strtoupper'), $result);
        }
        return $result;
    }

    // }}}
    // {{{ listTableViews()

    /**
     * list the views in the database that reference a given table
     *
     * @param string table for which all references views should be found
     * @return mixed MDB2_OK on success, a MDB2 error on failure
     * @access public
     **/
    function listTableViews($table)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $query = 'SELECT viewname FROM pg_views NATURAL JOIN pg_tables';
        $query.= ' WHERE tablename ='.$db->quote($table, 'text');
        $result = $db->queryCol($query);
        if (PEAR::isError($result)) {
            return $result;
        }
        if ($db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
            $result = array_map(($db->options['field_case'] == CASE_LOWER ? 'strtolower' : 'strtoupper'), $result);
        }
        return $result;
    }

    // }}}
    // {{{ listFunctions()

    /**
     * list all functions in the current database
     *
     * @return mixed data array on success, a MDB2 error on failure
     * @access public
     */
    function listFunctions()
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        // In Postgres 11 the functionality provided by pg_proc.proisagg was replaced by pg_proc.prokind
        $prokind = (int) $db->queryOne("SHOW server_version_num") < 110000 ?
            'pr.proisagg = FALSE' :
            "pr.prokind = 'f'";

        $query = "
            SELECT
                proname
            FROM
                pg_proc pr JOIN
                pg_type tp ON (tp.oid = pr.prorettype) JOIN
                pg_namespace ns ON (ns.oid = pr.pronamespace)
            WHERE
                {$prokind}
                AND tp.typname <> 'trigger'
                AND ns.nspname NOT LIKE 'pg_%' AND ns.nspname <> 'information_schema'
                AND pg_catalog.pg_function_is_visible(pr.oid)
            ";
        $result = $db->queryCol($query);
        if (PEAR::isError($result)) {
            return $result;
        }
        if ($db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
            $result = array_map(($db->options['field_case'] == CASE_LOWER ? 'strtolower' : 'strtoupper'), $result);
        }
        return $result;
    }

    // }}}
    // {{{ listTables()

    /**
     * list all tables in the current database
     *
     * @param OPENADS:: string database, ignored in the pgsql driver
     * @param OPENADS:: string prefix : allow a LIKE comparison search for table prefixes
     * @return mixed data array on success, a MDB2 error on failure
     * @access public
     **/
    function listTables($database = null, $prefix='')
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        // gratuitously stolen from PEAR DB _getSpecialQuery in pgsql.php
        $query = 'SELECT c.relname AS "Name"'
            . ' FROM pg_class c, pg_user u'
            . ' WHERE c.relowner = u.usesysid'
            . " AND c.relkind = 'r'"
            . (!empty($prefix) ? 'AND c.relname ILIKE '.$db->quote($prefix.'%', 'text') : '')
            . ' AND NOT EXISTS'
            . ' (SELECT 1 FROM pg_views'
            . '  WHERE viewname = c.relname)'
            . " AND c.relname !~ '^(pg_|sql_)'"
            . ' AND pg_catalog.pg_table_is_visible(c.oid)'
            . ' UNION'
            . ' SELECT c.relname AS "Name"'
            . ' FROM pg_class c'
            . " WHERE c.relkind = 'r'"
            . ' AND NOT EXISTS'
            . ' (SELECT 1 FROM pg_views'
            . '  WHERE viewname = c.relname)'
            . ' AND NOT EXISTS'
            . ' (SELECT 1 FROM pg_user'
            . '  WHERE usesysid = c.relowner)'
            . " AND c.relname !~ '^pg_'"
            . ' AND pg_catalog.pg_table_is_visible(c.oid)'
            . (!empty($prefix) ? 'AND c.relname ILIKE '.$db->quote($prefix.'%', 'text') : '');
        $result = $db->queryCol($query);
        if (PEAR::isError($result)) {
            return $result;
        }
        if ($db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
            $result = array_map(($db->options['field_case'] == CASE_LOWER ? 'strtolower' : 'strtoupper'), $result);
        }
        return $result;
    }

    // }}}
    // {{{ listTableFields()

    /**
     * list all fields in a tables in the current database
     *
     * @param string $table name of table that should be used in method
     * @return mixed data array on success, a MDB2 error on failure
     * @access public
     */
    function listTableFields($table)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $table = $db->quoteIdentifier($table, true);
        $db->setLimit(1);
        $result2 = $db->query("SELECT * FROM $table");
        if (PEAR::isError($result2)) {
            return $result2;
        }
        $result = $result2->getColumnNames();
        $result2->free();
        if (PEAR::isError($result)) {
            return $result;
        }
        return array_flip($result);
    }

    // }}}
    // {{{ listTableIndexes()

    /**
     * list all indexes in a table
     *
     * @param string    $table      name of table that should be used in method
     * @return mixed data array on success, a MDB2 error on failure
     * @access public
     */
    function listTableIndexes($table)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $oid = $this->_getMatchingTableOid($table);

        if (empty($oid)) {
            return array();
        }

        $query = "
            SELECT
                ci.relname
            FROM
                pg_class ci JOIN
                pg_index i ON (ci.oid = i.indexrelid)
            WHERE
                i.indisunique <> 't' AND
                i.indisprimary <> 't' AND
                i.indrelid = {$oid}
        ";
        $indexes = $db->queryCol($query, 'text');
        if (PEAR::isError($indexes)) {
            return $indexes;
        }

        $result = array();
        foreach ($indexes as $index) {
            $index = $this->_fixIndexName($index);
            if (!empty($index)) {
                $result[$index] = true;
            }
        }

        if ($db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
            $result = array_change_key_case($result, $db->options['field_case']);
        }
        return array_keys($result);
    }

    // }}}
    // {{{ listTableConstraints()

    /**
     * list all constraints in a table
     *
     * @param string    $table      name of table that should be used in method
     * @return mixed data array on success, a MDB2 error on failure
     * @access public
     */
    function listTableConstraints($table)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $oid = $this->_getMatchingTableOid($table);

        if (empty($oid)) {
            return array();
        }

        $query = "
            SELECT
                ci.relname
            FROM
                pg_class ci JOIN
                pg_index i ON (ci.oid = i.indexrelid)
            WHERE
                (i.indisunique = 't' OR i.indisprimary = 't') AND
                i.indrelid = {$oid}
        ";
        $constraints = $db->queryCol($query);
        if (PEAR::isError($constraints)) {
            return $constraints;
        }

        $result = array();
        foreach ($constraints as $constraint) {
            $constraint = $this->_fixIndexName($constraint);
            if (!empty($constraint)) {
                $result[$constraint] = true;
            }
        }

        if ($db->options['portability'] & MDB2_PORTABILITY_FIX_CASE
            && $db->options['field_case'] == CASE_LOWER
        ) {
            $result = array_change_key_case($result, $db->options['field_case']);
        }
        return array_keys($result);
    }

    // }}}
    // {{{ createSequence()

    /**
     * create sequence
     *
     * @param string $seq_name name of the sequence to be created
     * @param string $start start value of the sequence; default is 1
     * @return mixed MDB2_OK on success, a MDB2 error on failure
     * @access public
     **/
    function createSequence($seq_name, $start = 1)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $sequence_name = $db->quoteIdentifier($db->getSequenceName($seq_name), true);
        return $db->exec("CREATE SEQUENCE $sequence_name INCREMENT 1".
            ($start < 1 ? " MINVALUE $start" : '')." START $start");
    }

    // }}}
    // {{{ dropSequence()

    /**
     * drop existing sequence
     *
     * @param string $seq_name name of the sequence to be dropped
     * @return mixed MDB2_OK on success, a MDB2 error on failure
     * @access public
     **/
    function dropSequence($seq_name)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $sequence_name = $db->quoteIdentifier($db->getSequenceName($seq_name), true);
        return $db->exec("DROP SEQUENCE $sequence_name");
    }

    // }}}
    // {{{ listSequences()

    /**
     * list all sequences in the current database
     *
     * @return mixed data array on success, a MDB2 error on failure
     * @access public
     **/
    function listSequences($database = null)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $query = "SELECT relname FROM pg_class WHERE relkind = 'S' AND relnamespace IN";
        $query.= " (SELECT oid FROM pg_namespace WHERE nspname NOT LIKE 'pg_%' AND nspname != 'information_schema')";
        $query.= " AND pg_catalog.pg_table_is_visible(oid)";
        $table_names = $db->queryCol($query);
        if (PEAR::isError($table_names)) {
            return $table_names;
        }
        $result = array();
        foreach ($table_names as $table_name) {
            $result[] = $this->_fixSequenceName($table_name);
        }
        if ($db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
            $result = array_map(($db->options['field_case'] == CASE_LOWER ? 'strtolower' : 'strtoupper'), $result);
        }
        return $result;
    }

    /**
     * New OPENADS method
     *
     *
     * this simulated show table status assumed that pgsql was compiled with a default page size (8k)
     * and will return wrong data if it isn't.
     *
     *
     * @param string $table
     * @return array
     */
    function getTableStatus($table)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $autoIncrement = NULL;
        if (!empty($GLOBALS['_MAX']['CONF']['databasePgsql']['schema'])) {
            $schemaName    = $GLOBALS['_MAX']['CONF']['databasePgsql']['schema'];
        } else {
            $aSchemas = $this->listCurrentSchemas();
            $schemaName = $aSchemas[0];
        }
        $blockSz       = 8192;

        $qSchemaName = $db->quote($schemaName);
        $qTableName  = $db->quote($table);

        // We need to ANALYZE the table if we want a meaningful result
        // this can take minutes to execute
        // it will give the most up-to-date statistics
        // otherwise we will get the last analyzed statistics
        // which will depend on when the scheduled analysis was last run
        $db->exec("ANALYZE ".$db->quoteIdentifier($table, true));

        $pkeyDefault = $db->queryOne("
            SELECT
                column_default
            FROM
                information_schema.table_constraints tc JOIN
                information_schema.constraint_column_usage ccu USING (table_schema, table_name, constraint_name) JOIN
                information_schema.columns c USING (table_schema, table_name, column_name)
            WHERE
                tc.table_schema = {$qSchemaName} AND
                tc.table_name = {$qTableName} AND
                tc.constraint_type = 'PRIMARY KEY' AND
                c.column_default LIKE 'nextval(%';
            ");

        if (!PEAR::isError($pkeyDefault) && preg_match('/^nextval\(\'(.+)\'.*\).*$/', $pkeyDefault, $aMatches)) {
            $pkeySequence = $aMatches[1];
            // Strip eventual schema (8.0 seems to return the schema as well)
            $pkeySequence = preg_replace('/^.*?\./', '', $pkeySequence);
            $query =   "SELECT
                            last_value + CASE WHEN is_called THEN 1 ELSE 0 END
                        FROM
                            ".$db->quoteIdentifier($schemaName, true).".".$db->quoteIdentifier($pkeySequence, true);

            $autoIncrement = $db->queryOne($query);
        }

        $result = $db->queryRow("
            SELECT
                reltuples AS \"Rows\",
                relpages * $blockSz AS \"Data_length\",
                ".$db->quote($autoIncrement)."::integer AS \"Auto_Increment\"
            FROM
                pg_class c JOIN
                pg_namespace n ON (c.relnamespace = n.oid)
            WHERE
                n.nspname = {$qSchemaName} AND
                c.relname = {$qTableName};
            ", null, MDB2_FETCHMODE_ASSOC);

        if (PEAR::isError($result)) {
            return array();
        }

        return array($result);
    }

    function checkTable($tableName)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }
        $result = $db->query('SELECT * FROM '.$tableName);
        if (PEAR::isError($result))
        {
            return array('msg_text' => $result->getUserInfo());
        }
        return array('msg_text' => 'OK');
    }

    function listCurrentSchemas()
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $schemas = $db->queryOne("SELECT pg_catalog.current_schemas(false)");

        if (PEAR::isError($schemas)) {
            return array();
        }

        $schemas = substr($schemas, 1, -1);
        $aSchemas = explode(',', $schemas);
        foreach ($aSchemas as $k => $v) {
            $aSchemas[$k] = preg_replace('/^"(.*)"$/', '$1', $v);
        }

        return $aSchemas;
    }

    function _getMatchingTableOid($table)
    {
        $db = $this->getDBInstance();
        if (PEAR::isError($db)) {
            return $db;
        }

        $table = $db->quote($table, 'text');

        foreach ($this->listCurrentSchemas() as $schema) {
            $schema = $db->quote($schema, 'text');
            $query = "
                SELECT
                    c.oid
                FROM
                    pg_class c JOIN
                    pg_namespace n ON (n.oid = c.relnamespace)
                WHERE
                    pg_catalog.pg_table_is_visible(c.oid) AND
                    c.relname = {$table} AND
                    n.nspname = {$schema}
            ";
            $oid = $db->queryOne($query);

            if (PEAR::isError($oid)) {
                return $oid;
            } elseif (!empty($oid)) {
                break;
            }
        }

        if (empty($oid)) {
            return false;
        }

        return $oid;
    }

    /**
     * New OPENX method to check database name according to specifications:
     *  PostgreSQL specification: http://www.postgresql.org/docs/8.3/interactive/tutorial-createdb.html
     *
     * @param string $name database name to check
     * @return true in name is correct and PEAR error on failure
     */
    function validateDatabaseName($name)
    {
        // Test for length
        if (strlen($name)>63 ) {
            return PEAR::raiseError(
                'Database names are limited to 63 characters in length');
        }
        // Test for first character (is alfabetic?)
        if ( !preg_match( '/^([a-zA-z]).*/', $name) ) {
            return PEAR::raiseError(
                'Database names must have an alphabetic first character');
        }
        return true;
    }


    /**
     * New OPENX method to check database name according to specifications:
     *  PostgreSQL specification: http://www.postgresql.org/docs/8.1/interactive/sql-syntax.html#SQL-SYNTAX-IDENTIFIERS
     *
     * - SQL identifiers and key words must begin with a letter (a-z, but also letters with diacritical marks and non-Latin letters)
     *  or an underscore (_).
     * - Subsequent characters in an identifier or key word can be letters, underscores,
     *  digits (0-9), or dollar signs ($).
     *  (Note that dollar signs are not allowed in identifiers according to the letter of the SQL standard,
     *  so their use may render applications less portable.
     * - maximum identifier length is 63
     *
     *
     * @param string $name table name to check
     * @return true if name is correct and PEAR error on failure
     */
    function validateTableName($name)
    {
        // Maximum identifier length is 63
        if (strlen($name) > 63 ) {
            return PEAR::raiseError(
                'Table names are limited to 63 characters in length');
        }
        // Database, table, and column names should not end with space characters.
        // Extended for leading and ending spaces
        if ($name != trim($name)) {
            return PEAR::raiseError(
                'Table names should not start or end with space characters');
        }
        // Test for first character (is alphabetic?)
        if ( !preg_match( '/^([_a-zA-Z])/', $name) ) {
            return PEAR::raiseError(
                'Table names must start with an alphabetic character or underscore');
        }
        return true;
    }
}
?>
