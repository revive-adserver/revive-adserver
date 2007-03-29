<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
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
/**
 * Openads Schema Management Utility
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

//require_once MAX_DEV.'/lib/pear.inc.php';
//require_once 'MDB2.php';
//require_once 'MDB2/Schema.php';
//require_once 'Config.php';
//
//require_once MAX_PATH.'/lib/OA/DB.php';
//require_once MAX_PATH.'/lib/OA/DB/Table.php';
//require_once MAX_PATH.'/lib/OA/Dal/Links.php';

define('DB_UPGRADE_ACTION_CODE_BACKUP',                                 0);
define('DB_UPGRADE_ACTION_CODE_UPGRADE',                                1);
define('DB_UPGRADE_ACTION_CODE_UPGRADE_OUTSTANDING',                    2);
define('DB_UPGRADE_ACTION_CODE_IGNORE_OUTSTANDING_UPGRADE_UNTIL',       3);
define('DB_UPGRADE_ACTION_CODE_IGNORE_OUTSTANDING_UPGRADE',             4);
define('DB_UPGRADE_ACTION_CODE_OUTSTANDING_DROP_BACKUP',                5);
define('DB_UPGRADE_ACTION_CODE_IGNORE_OUTSTANDING_DROP_BACKUP_UNTIL',   6);
define('DB_UPGRADE_ACTION_CODE_IGNORE_OUTSTANDING_DROP_BACKUP',         7);


class OA_DB_Upgrade
{
    var $versionFrom;
    var $versionTo;

    var $path_changes;
    //var $path_schema;
    //var $path_links;
    //var $path_dbo;

    var $file_schema;
    var $file_changes;
    var $file_migrate;
    //var $file_links;

    var $oSchema;

    var $aDefinitionNew;
    var $aDefinitionOld;
    var $aChangeset;
    var $aChanges;

    var $aErrors;
    var $aMessages;

    var $timing;

    var $aActionCodes = array();
    var $aTaskList = array();
    var $aRestoreTables = array();

    var $logToDB = true;

    var $prefix = '';
    var $database = '';
    var $engine = '';

    var $continue = true;

    /**
     * php5 class constructor
     *
     * simpletest throws a BadGroupTest error
     * Redefining already defined constructor for class Openads_DB_Upgrade
     * when both constructors are present
     *
     */
//    function __construct()
//    {
//    }

    /**
     * php4 class constructor
     *
     */
    function OA_DB_Upgrade()
    {
        //this->__construct();

        $result  = & MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
        if (!$this->_isPearError($result, 'failed to instantiate MDB2_Schema'))
        {
            $this->oSchema = $result;
            if ($this->oSchema->db->options['default_table_type'])
            {
                $this->engine = 'ENGINE='.$this->oSchema->db->getOption('default_table_type');
            }
        }
        else
        {
            return false;
        }
    }

    function init($timing='constructive', $versionTo, $versionFrom='')
    {
        $this->aErrors = array();
        $this->aMessages = array();

        $this->versionFrom  = ($versionFrom ? $versionFrom : 1);
        $this->versionTo    = $versionTo;
        $this->timing       = $timing;

        $this->aMessages[] = 'from version: '.$this->versionFrom;
        $this->aMessages[] = 'to version: '.$this->versionTo;
        $this->aMessages[] = 'timing: '.$this->timing;

        $this->path_changes = MAX_PATH.'/etc/changes/';
        //$this->path_schema  = MAX_PATH.'/etc/';
        //$this->path_links   = MAX_PATH.'/etc/';
        //$this->path_dbo     = $this->path_changes.'DataObjects_'.$this->versionTo;

        $this->file_schema  = $this->path_changes.'schema_'.$this->versionTo.'.xml';
        $this->file_changes = $this->path_changes.'changes_'.$this->versionTo.'.xml';
        $this->file_migrate = $this->path_changes.'migration_'.$this->versionTo.'.php';
        //$this->file_links   = $this->path_links.'db_schema.links.ini';

        if (!file_exists($this->file_schema))
        {
            $this->aErrors[] = 'boo! file not found: '.$this->file_schema;
            return false;
        }
        else
        {
            $this->aMessages[] = 'yay! file found: '.$this->file_schema;
        }
        if (!file_exists($this->file_changes))
        {
            $this->aErrors[] = 'boo! file not found: '.$this->file_changes;
            return false;
        }
        else
        {
            $this->aMessages[] = 'yay! file found: '.$this->file_changes;
        }
        if (!file_exists($this->file_migrate))
        {
            $this->aErrors[] = 'boo! file not found: '.$this->file_migrate;
        }
        else
        {
            $this->aMessages[] = 'yay! file found: '.$this->file_migrate;
        }

//        $result  = & MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
//        if (!$this->_isPearError($result, 'failed to instantiate MDB2_Schema'))
//        {
            //$this->oSchema = $result;
            $result = $this->oSchema->parseDatabaseDefinitionFile($this->file_schema);
            if (!$this->_isPearError($result, 'failed to parse new schema ('.$this->file_schema.')'))
            {
                $this->aDefinitionNew = $result;
                $this->aMessages[] = 'successfully parsed the schema';
                $this->aMessages[] = 'schema name: '.$this->aDefinitionNew['name'];
                $this->aMessages[] = 'schema version: '.$this->aDefinitionNew['version'];
                $this->aMessages[] = 'schema status: '.$this->aDefinitionNew['status'];

                $result = $this->oSchema->parseChangesetDefinitionFile($this->file_changes);
                if (!$this->_isPearError($result, 'failed to parse changeset ('.$this->file_changes.')'))
                {
                    $this->aChanges = $result;
                    $this->aMessages[] = 'successfully parsed the changeset';
                    $this->aMessages[] = 'changeset name: '.$this->aChanges['name'];
                    $this->aMessages[] = 'changeset version: '.$this->aChanges['version'];
                    $this->aMessages[] = ($this->aDefinitionNew['version']==$this->aChanges['version'] ? 'yay! schema and changeset versions match' : 'hmmm.. schema and changeset versions don\'t match');
                    $this->aMessages[] = ($this->aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found');
                    $this->aMessages[] = ($this->aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found');
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
//        }
//        else
//        {
//            return false;
//        }
        $this->aChangeset = $this->aChanges[$this->timing];

        $this->prefix   = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->database = $GLOBALS['_MAX']['CONF']['database']['name'];

        $this->aMessages[] = 'target database: '.$this->database;
        $this->aMessages[] = 'table prefix: '.$this->prefix;

        $aDBTables = $this->_listTables();
        $this->logToDB = in_array($this->prefix.'database_action', $aDBTables);

        $this->aMessages[] = 'successfully initialised DB Upgrade';
        return true;
    }

    /**
     * perform the necessary tasks to move a database schema
     * to a later version
     *
     * @return boolean
     */
    function upgrade()
    {

        //$this->aDefinitionOld = $this->oSchema->getDefinitionFromDatabase();

        $this->aMessages[] = 'verifying '.$timing.' changes';
        $result = $this->oSchema->verifyAlterDatabase($this->aChangeset);
        if (!$this->_isPearError($result, 'VERIFICATION FAILED'))
        {
            $this->aMessages[] = ' verified OK';
            $this->aMessages[] = 'creating '.$timing.' tasklist';
            $result = $this->_verifyTaskList();
            if (!$this->_isPearError($result, 'TASKLIST CREATION FAILED'))
            {
                $this->aMessages[] = 'executing '.$timing.' tasks';
                if (!$this->_executeTasks())
                {
                    $result = $this->_rollback();
                    if ($result)
                    {
                        $this->aErrors[] = 'upgrade failed but rollback succeeded';
                        return false;
                    }
                    else
                    {
                        $this->aErrors[] = 'upgrade failed and rollback failed';
                        return false;
                    }
                }
                else
                {
                    $this->aMessages[] = 'upgrade succeeded';
                    $this->_logDatabaseAction(DB_UPGRADE_ACTION_CODE_UPGRADE, 'success');
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        return true;
    }

    /**
     * perform tasks to revert a database to a previous version
     *
     * @return boolean
     */
    function downgrade()
    {
        return true;
    }

    function _listTables()
    {
        $portability = $this->oSchema->db->getOption('portability');
        $this->oSchema->db->setOption('portability', MDB2_PORTABILITY_NONE);
        $aDBTables = $this->oSchema->db->manager->listTables();
        $this->oSchema->db->setOption('portability', $portability);
        return $aDBTables;
    }

    /**
     * create uniquely named copies of affected tables
     * audit each backup
     *
     * @return boolean
     */
    function _createBackup()
    {
        $aDBTables = $this->_listTables();
        $aTables = $this->aChanges['affected_tables'][$this->timing];
        foreach ($aTables AS $k => $table)
        {
            $table = $this->prefix.$table;
            if (in_array($table, $aDBTables))
            {
                $string     = $this->versionFrom.$this->timing.$this->database.$table.date('Y-m-d h:i:s');
                $hash       = str_replace(array('+','/','='),array('_','_',''),base64_encode(pack("H*",md5($string)))); // packs down to 22 chars and removes illegal chars
                $table_bak  ="{$this->prefix}zzz_{$hash}";
                $this->aMessages[]  = "backing up table {$table} to table {$table_bak} ";

                // better query? increment off first?
                $query      = "CREATE TABLE {$table_bak} {$this->engine} (SELECT * FROM {$table})";
                $result     = $this->oSchema->db->exec($query);
                if ($this->_isPearError($result, 'error creating backup'))
                {
                    $this->_halt();
                    return false;
                }
                $this->_logDatabaseAction(DB_UPGRADE_ACTION_CODE_BACKUP, $table, $table_bak);
                $aBakDef = $this->oSchema->getDefinitionFromDatabase(array($table));
                $aBakDef = $aBakDef['tables'][$table];
                // error: index fields are being re-ordered alphabetically
                // but now have an 'order' value in the def
                $this->aRestoreTables[$table] = array(
                                                        'bak'=>$table_bak,
                                                        'def'=>$aBakDef
                                                     );
            }
        }
        return true;
    }

    /**
     * restore all affected tables
     *
     * @return boolean
     */
    function _rollback()
    {
        $aDBTables = $this->_listTables();

        if ($this->_isPearError($result, 'error listing tables during rollback'))
        {
            return false;
        }
        else
        {
            krsort($this->aRestoreTables);
            foreach ($this->aRestoreTables AS $table => $aTable_bak)
            {
                if (in_array($aTable_bak['bak'], $aDBTables))
                {
                    $dropfirst = (in_array($this->prefix.$table, $aDBTables));
                    $result = $this->_restoreFromBackup($this->prefix.$table, $aTable_bak['bak'], $aTable_bak['def'], $dropfirst);
                    if (!$result)
                    {
                        return false;
                    }
                }
                else
                {
                    $this->aErrors[] = "backup table not found during rollback: {$aTable_bak['bak']}";
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * restore individual tables
     * remove the backups?
     * audit each restore?
     * remove the database_action recs?  null them somehow?
     *
     * @param string $table
     * @param string $table_bak
     * @param array $aDef_bak
     * @param boolean $dropfirst
     * @return boolean
     */
    function _restoreFromBackup($table, $table_bak, $aDef_bak, $dropfirst=true)
    {
        if ($dropfirst)
        {
            $result = $this->oSchema->db->manager->dropTable($table);
            if ($this->_isPearError($result, 'error dropping '.$table. ' during rollback'))
            {
                return false;
            }
        }
        $query  = "CREATE TABLE {$table} {$this->engine} (SELECT * FROM {$table_bak})";
        $result = $this->oSchema->db->exec($query);
        if ($this->_isPearError($result, 'error creating table during rollback'))
        {
            $this->_halt();
            return false;
        }
        foreach ($aDef_bak['indexes'] as $index => $aIndex_def)
        {
            $aIndex_def = $this->_sortIndexFields($aIndex_def);
            if (array_key_exists('primary', $aIndex_def) || array_key_exists('unique', $aIndex_def))
            {
                $result = $this->oSchema->db->manager->createConstraint($table, $index, $aIndex_def);
            }
            else
            {
                $result = $this->oSchema->db->manager->createIndex($table, $index, $aIndex_def);
            }
            if (!$this->_isPearError($result, 'error creating index on table during rollback'))
            {
                $this->aMessages[] = 'create index success';
            }
            else
            {
                $this->_halt();
                return false;
            }
        }
        //$this->_logDatabaseAction(DB_UPGRADE_ACTION_CODE_BACKUP, $table, $table_bak);
        return true;
    }

    /**
     * drop a given backup table
     *
     * @param string $table
     * @return boolean
     */
    function _dropBackup($table)
    {
        $this->aMessages[] = 'dropping your backup: '.$table;
        return true;
    }

    /**
     * audit actions taken
     *
     * @param integer $action
     * @param string $info1
     * @param string $info2
     * @return boolean
     */
    function _logDatabaseAction($action, $info1='', $info2='')
    {
        $this->aMessages[] = '_logDatabaseAction start';
        $backup_record = array();
        $record['version']   = $this->versionFrom;
        $record['timing']    = $this->timing;
        $record['action']    = $action;
        $record['info1']     = $info1;
        $record['info2']     = $info2;
        //$record['updated']   = 'NOW()';

        foreach ($record AS $k => $v)
        {
            $this->aMessages[] = $k.' : '.$v;
        }
        $this->aMessages[] = '_logDatabaseAction end';
        if ($this->logToDB)
        {
            $columns = implode(",", array_keys($record));
            $values  = implode("','", array_values($record));
            //$values  = implode("','", mysql_escape_string(array_values($record)));

            $query = "INSERT INTO {$this->prefix}database_action ({$columns}, updated) VALUES ('{$values}', NOW())";

            $result = $this->oSchema->db->exec($query);

            if ($this->_isPearError($result, "error updating {$this->prefix}database_action"))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * iterate through the task list and perform each task
     * handle errors and report
     *
     * @return boolean
     */
    function _executeTasks()
    {
        foreach ($this->aTaskList['tables']['add'] as $k => $aTask)
        {
            $this->aMessages[] = 'executing tables task '.$k.' : '.$this->prefix.$aTask['name'].'=>'.'create';
            $result = $this->oSchema->db->manager->createTable($this->prefix.$aTask['name'], $aTask['task'], array());
            if (!$this->_isPearError($result, ''))
            {
                if (isset($aTask['indexes']))
                {
                    foreach ($aTask['indexes'] AS $k => $aIndex)
                    {
                        $this->aMessages[] = 'executing tables task '.$k.' : '.$this->prefix.$aTask['name'].'=>'.'create index';
                        $result = $this->oSchema->db->manager->createIndex($this->prefix.$aIndex['table'], $aIndex['name'], $aIndex['task']);
                        if (!$this->_isPearError($result, ''))
                        {
                            $this->aMessages[] = 'create index success';
                        }
                        else
                        {
                            $this->_halt();
                            return false;
                        }
                    }
                }
                $this->aMessages[] = 'create table success';
            }
            else
            {
                $this->_halt();
                return false;
            }
        }
        if ($this->continue)
        {
            foreach ($this->aTaskList['fields'] as $k => $aTask)
            {
                $this->aMessages[] = 'executing fields task '.$k.' : '.$this->prefix.$aTask['name'].'=>'.$aTask['task'];
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$aTask['name'], $aTask['task'], false);
                if (!$this->_isPearError($result, ''))
                {
                    $this->aMessages[] = 'task success';
                }
                else
                {
                    $this->_halt();
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * check that for each of the tables affected by a task
     * the table exists and that any field affected exists
     * also compiles the tasklist in a format ready for schema _alterTable method
     *
     * @return boolean;
     */
    function _verifyTaskList()
    {
        $aDBTables = $this->_listTables();

        foreach ($this->aChanges['tasks'][$this->timing]['tables'] AS $table => $aTable_tasks)
        {
            $continue = true;
            foreach ($aTable_tasks['self'] AS $task => $method)
            {
                $this->aMessages[] = 'task found: '.$method;
                if ($task == 'add')
                {
                    if (in_array($this->prefix.$table, $aDBTables))
                    {
                        $this->aErrors[] = 'table '.$this->prefix.$table.' already exists in database '.$this->oSchema->db->database_name;
                    }
                    else
                    {
                        $this->_addCreateTableTasks($task, $table);
                    }
                    $continue = false;
                }
                else
                {
                    $this->aTaskList['tables'][$task][] = $this->_compileTableTask($task, $table);
                }
            }
            if ($continue)
            {
                $this->aMessages[] = 'checking table: '.$this->prefix.$table;
                if (!in_array($this->prefix.$table, $aDBTables))
                {
                    $this->aErrors[] = 'table '.$this->prefix.$table.' not found in database '.$this->oSchema->db->database_name;
                }
                else
                {
                    $this->aMessages[] = 'yay! found table '.$this->prefix.$table;
                    $aDBFields = $this->oSchema->db->manager->listTableFields($this->prefix.$table);

                    foreach ($aTable_tasks['fields'] AS $field => $aField_tasks)
                    {
                        $this->aMessages[] = 'checking field: '.$field;
                        if (!in_array($field, $aDBFields))
                        {
                            $this->aMessages[] = 'task found: '.$method;

                            if (array_key_exists('rename', $aField_tasks))
                            {
                                $was = $this->_getPreviousFieldname($table, $field);
                                if ($was)
                                {
                                    $this->aMessages[] = 'yay! found that this field : '.$table.'.'.$field.' was called: '.$table.'.'.$was;
                                    $this->aTaskList['fields']['rename'][] = $this->_compileFieldTask('rename', $table, $was, $field);
                                }
                                else
                                {
                                    $this->aErrors[] = 'hmmm.. couldn\'t find what this field was called: '.$table.'.'.$field;
                                }
                            }
                            else
                            {
                                $this->aErrors[] = 'oh dear.. field '.$field.' not found in table '.$this->prefix.$table;
                            }
                        }
                        else
                        {
                            $this->aMessages[] = 'yay! found field '.$field;
                            foreach ($aField_tasks AS $task => $method)
                            {
                                if ($task != 'rename')
                                {
                                    $this->aTaskList['fields'][$task][] = $this->_compileFieldTask($task, $table, $field, $field);
                                }
                            }
                        }
                    }
                    foreach ($aTable_tasks['indexes'] AS $index => $aIndex_tasks)
                    {
                        $this->aMessages[] = 'task found: '.$method;
                        $this->aTaskList['indexes'][$task][] = $this->_compileIndexTask($task, $table, $index);
                    }
                }
            }
        }
        return true;
    }

    /**
     * when renaming a field
     * the changes array indexes the new field name
     * you need to retrieve the 'was' field name
     * to know which field you are actually renaming
     *
     * @param string $table
     * @param string $field
     * @return string old field name
     */
    function _getPreviousFieldname($table, $field)
    {
        $result = false;
        if (isset($this->aChanges[$this->timing]['tables']['change'][$table]['rename']['fields'][$field]['was']))
        {
            $result = $this->aChanges[$this->timing]['tables']['change'][$table]['rename']['fields'][$field]['was'];
        }
        return $result;
    }

    /**
     * retrieve the table definition from a parsed schema
     *
     * @param string $table
     * @return array
     */
    function _getTableDefinition($aDefinition, $table)
    {
        $result = false;
        if (isset($aDefinition['tables'][$table]))
        {
            $result = $aDefinition['tables'][$table];
        }
        return $result;
    }

    /**
     * retrieve the field definition from a parsed schema
     *
     * @param string $table
     * @param string $field
     * @return array
     */
    function _getFieldDefinition($aDefinition, $table, $field)
    {
        $result = false;
        if (isset($aDefinitionOld['tables'][$table]))
        {
            if (isset($aDefinitionOld['tables'][$table]['fields'][$field]))
            {
                $result = $aDefinitionOld['tables'][$table]['fields'][$field];
            }
        }
        return $result;
    }

    /**
     * multiple tasks are required for table creation
     *
     * @param string $task
     * @param string $table
     * @return array
     */
    function _addCreateTableTasks($task, $table)
    {
        $aTableDef  = $this->_getTableDefinition($this->aDefinitionNew, $table);

        $aTable =  array(
                        'name'=>$this->prefix.$table,
                        'task'=>$aTableDef['fields']
                        );

        if (isset($aTableDef['indexes']))
        {
            foreach ($aTableDef['indexes'] AS $index_name=>$aIndex_def)
            {
                $aTable['indexes'][] = array(
                                              'table'=>$this->prefix.$table,
                                              'name'=>$index_name,
                                              'task'=>$aIndex_def
                                            );
            }
        }
        $this->aTaskList['tables'][$task][] = $aTable;

        return true;
    }

    /**
     * return an array that can be passed to mdb2_schema _alterTable() method
     *
     * $field_name and $field_name_new should be the same except in the case of rename task
     * $field_name_new is the field for which the definition is retrieved
     *
     * @param string $task
     * @param string $table
     * @param string $field_name
     * @param string $field_name_new
     * @return array
     */
    function _compileFieldTask($task, $table, $field_name, $field_name_new)
    {
        $result =   array('name'=>$this->prefix.$table,
                          'task'=>array(
                                        $task=>array(
                                                     $field_name=>array(
                                                                       'name'=>$field_name_new,
                                                                       'definition'=>$this->_getFieldDefinitionNew($table, $field_name_new)
                                                                      )
                                                    )
                                        )
                         );
        return $result;

    }

    /**
     * Enter description here...
     *
     * @param string $task
     * @param string $table
     * @param string $index
     * @return array
     */
    function _compileIndexTask($task, $table, $index_name)
    {
        if ($task=='add')
        {
            $aTableDef = $this->_getTableDefinition($this->aDefinitionNew, $table);
            $result =   array(
                              'table'=>$this->prefix.$table,
                              'name'=>$index_name,
                              'task'=>$aTableDef['indexes']
                             );
        }
        else
        {
            $result = array();
        }
        return $result;
    }

    /**
     * Enter description here...
     *
     * @param string $task
     * @param string $table
     * @return array
     */
    function _compileTableTask($task, $table)
    {
        $aTableDef = $this->_getTableDefinition($this->aDefinitionNew, $table);
        $result =   array(
                          'name'=>$this->prefix.$table,
                          'task'=>$aTableDef['fields']
                         );
        return $result;
    }

    /**
     * check for a Pear error
     * log the error
     * returns true if pear error, false if not
     *
     * @param mixed $result
     * @param string $message
     * @return boolean
     */
    function _isPearError($result, $message='omg it all went PEAR shaped!')
    {
        if (PEAR::isError($result))
        {
            $this->aErrors[] = $message.' '. $result->getUserInfo();
            return true;
        }
        return false;
    }

    /**
     * set the continue flag to false
     *
     */
    function _halt()
    {
        $this->continue = false;
    }

    function _sortIndexFields($aIndex_def)
    {
        foreach ($aIndex_def['fields'] as $field => $aDef)
        {
            $aIdx_sort[$aDef['order']] = $field;
        }
        ksort($aIdx_sort);
        reset($aIdx_sort);
        foreach ($aIdx_sort as $k => $field)
        {
            $sorting = ($aIndex_definition['fields'][$field]['sorting']?'ascending':'descending');
            $aIdx_new['fields'][$field] = array('sorting'=>$sorting);
        }
        reset($aIdx_new['fields']);
        if (array_key_exists('primary', $aIndex_def))
        {
            $aIdx_new['primary'] = true;
        }
        if (array_key_exists('unique', $aIndex_def))
        {
            $aIdx_new['unique'] = true;
        }
        return $aIdx_new;
    }
}

/*
CREATE TABLE `database_action` (
  `version` int(11) default NULL,
  `timing` varchar(255) NOT NULL default '',
  `action` int(11) default NULL,
  `info1` varchar(255) NOT NULL,
  `info2` varchar(255) NOT NULL,
  `updated` datetime default NULL,
  KEY `updated` (`updated`),
  KEY `version_timing_action` (`version`,`timing`,`action`,`info1`,`info2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


            $query = "SELECT FROM database_action
                        WHERE version='{$this->versionFrom}'
                        AND timing = '{$this->timing}'
                        AND action = ".DB_UPGRADE_ACTION_CODE_BACKUP."
                        AND info1 = '{$table}'";

*/

?>