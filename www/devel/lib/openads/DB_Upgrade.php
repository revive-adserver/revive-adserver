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


class Openads_DB_Upgrade
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

    /**
     * php5 class constructor
     *
     */
    function __construct()
    {
    }

    /**
     * php4 class constructor
     *
     */
    function Openads_DB_Upgrade()
    {
        $this->__construct();
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

        $result  = & MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
        if (!PEAR::isError($result))
        {
            $this->oSchema = $result;
            $result = $this->oSchema->parseDatabaseDefinitionFile($this->file_schema);
            if (!PEAR::isError($result))
            {
                $this->aDefinitionNew = $result;
                $this->aMessages[] = 'successfully parsed the schema';
                $this->aMessages[] = 'schema name: '.$this->aDefinitionNew['name'];
                $this->aMessages[] = 'schema version: '.$this->aDefinitionNew['version'];
                $this->aMessages[] = 'schema status: '.$this->aDefinitionNew['status'];

                $result = $this->oSchema->parseChangesetDefinitionFile($this->file_changes);
                if (!PEAR::isError($result))
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
                    $this->aErrors[] = 'failed to parse changeset ('.$this->file_changes.'): '.$result->getMessage();
                    return false;
                }
            }
            else
            {
                $this->aErrors[] = 'failed to parse new schema ('.$this->file_schema.'): '.$result->getMessage();
                return false;
            }
        }
        else
        {
            $this->aErrors[] = 'failed to instantiate MDB2_Schema: '.$result->getMessage();
            return false;
        }
        $this->aChangeset = $this->aChanges[$this->timing];
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
        //$this->_compileTaskList();

        //$this->aDefinitionOld = $this->oSchema->getDefinitionFromDatabase();

        $this->aMessages[] = 'verifying '.$timing.' changes: initial';
        $result = $this->oSchema->verifyAlterDatabase($this->aChangeset);
        $msg = (PEAR::isError($result) ? ' INITIAL VERIFICATION FAILED:'.$result->getMessage() : ' initial verification OK');
        $this->aMessages[] = $timing.$msg;
        if ($result)
        {
            $this->aMessages[] = 'verifying '.$timing.' changes: detailed';
            $result = $this->_verifyAlterDatabase();
        }
        $msg = (!$result ? ' DETAILED VERIFICATION FAILED' : ' detailed verification OK');
        $this->aMessages[] = $timing.$msg;
        if ($result)
        {
            $this->aMessages[] = 'executing '.$timing.' changes';
            //$this->_executeTasks();
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

    /**
     * create uniquely name copies of affected tables
     * audit each backup
     *
     */
    function _createBackup()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $database_name = $aConf['database']['name'];
        $table_prefix = $aConf['table']['prefix'];
        $this->aMessages[] = 'backing up your database: '.OA_DB::getDsn();

        $aTables = $this->aChanges['affected_tables'][$this->timing];

        foreach ($aTables AS $k => $table)
        {
            $this->_logDatabaseAction(DB_UPGRADE_ACTION_CODE_BACKUP, $database_name.'.'.$table_prefix.$table);
        }
    }

    /**
     * drop a given backup table
     *
     */
    function _dropBackup($table)
    {
        $this->aMessages[] = 'dropping your backup: '.$table;
    }

    /**
     * read the parsed list of tasks
     *
     * @return boolean
     */
//    function _compileTaskList()
//    {
//        $this->aMessages[] = 'compiling task list...';
//        foreach ($this->aChanges['tasks'][$this->timing]['tables'] AS $table => $aTable_tasks)
//        {
//            foreach ($aTable_tasks['self'] AS $parent => $method)
//            {
//                $this->aMessages[] = 'task found: '.$method;
//                $this->aTaskList[] = $method;
//            }
//
//            foreach ($aTable_tasks['fields'] AS $field => $aField_tasks)
//            {
//                foreach ($aField_tasks AS $parent => $method)
//                {
//                    $this->aMessages[] = 'task found: '.$method;
//                    $was = $this->_getPreviousFieldname($table, $field);
//                    if ($was)
//                    {
//                        $this->aMessages[] = 'yay! found that this field : '.$table.'.'.$field.' was called: '.$table.'.'.$was;
//                    }
//                    else
//                    {
//                        $this->aMessages[] = 'hmmm.. couldn\'t find what this field was called: '.$table.'.'.$field;
//                    }
//                }
//            }
//            foreach ($aTable_tasks['indexes'] AS $index => $aIndex_tasks)
//            {
//                $this->aMessages[] = 'task found: '.$method;
//            }
//        }
//        $this->aMessages[] = 'task list complete';
//        return true;
//    }

    /**
     * audit actions taken
     *
     * @param integer $action
     * @param string $info
     */
    function _logDatabaseAction($action, $info='')
    {
        $this->aMessages[] = '';
        $backup_record = array();
        $backup_record['version']   = $this->versionFrom;
        $backup_record['timing']    = $this->timing;
        $backup_record['action']    = $action;
        $backup_record['updated']   = date('Y-m-d h:i:s');
        $backup_record['info']     = $info;
        foreach ($backup_record AS $k => $v)
        {
            $this->aMessages[] = $k.' : '.$v;
        }
    }

    /**
     * check that for each of the tables affected by a task
     * the table exists and that any field affected exists
     *
     * @return boolean;
     */
    function _verifyAlterDatabase()
    {

        $aDBTables = $this->oSchema->db->manager->listTables();

        foreach ($this->aChanges['tasks'][$this->timing]['tables'] AS $table => $aTable_tasks)
        {
            foreach ($aTable_tasks['self'] AS $parent => $method)
            {
                $this->aMessages[] = 'task found: '.$method;
                $this->aTaskList[] = $this->_compileTask($table, $task, '', '');
            }
            $this->aMessages[] = 'checking table: '.$table;
            if (!in_array($table, $aDBTables))
            {
                $this->aErrors[] = 'table '.$table.' not found in database '.$this->oSchema->db->database_name;
            }
            else
            {
                $this->aMessages[] = 'yay! found table '.$table;
                $aDBFields = $this->oSchema->db->manager->listTableFields($table);

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
                                $this->aTaskList[] = $this->_compileTask($table, 'rename', $field, $was);
                            }
                            else
                            {
                                $this->aErrors[] = 'hmmm.. couldn\'t find what this field was called: '.$table.'.'.$field;
                            }
                        }
                        else
                        {
                            $this->aErrors[] = 'oh dear.. field '.$field.' not found in table '.$table;
                        }
                    }
                    else
                    {
                        $this->aMessages[] = 'yay! found field '.$field;
                        foreach ($aField_tasks AS $task => $method)
                        {
                            if ($task != 'rename')
                            {
                                $this->aTaskList[] = $this->_compileTask($table, $task, $field, $field);
                            }
                        }

                        $this->aTaskList[] = $aField_tasks;
                    }
                }
                foreach ($aTable_tasks['indexes'] AS $index => $aIndex_tasks)
                {
                    $this->aMessages[] = 'task found: '.$method;
                    $this->aTaskList[] = $this->_compileTask($table, $task, '', '');
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

    function _getFieldDefinitionNew($table, $field)
    {
        $result = false;
        if (isset($this->aDefinitionNew['tables'][$table]))
        {
            if (isset($this->aDefinitionNew['tables'][$table]['fields'][$field]))
            {
                $result = $this->aDefinitionNew['tables'][$table]['fields'][$field];
            }
        }
        return $result;
    }

    function _getFieldDefinitionOld($table, $field)
    {
        $result = false;
        if (isset($this->aDefinitionOld['tables'][$table]))
        {
            if (isset($this->aDefinitionOld['tables'][$table]['fields'][$field]))
            {
                $result = $this->aDefinitionOld['tables'][$table]['fields'][$field];
            }
        }
        return $result;
    }

    function _compileTask($table, $task, $field_new, $field_old)
    {
        $result =   array('name'=>$table,
                          'task'=>array(
                                        $task=>array(
                                                     $field_new=>array(
                                                                       'name'=>$field_old,
                                                                       'definition'=>$this->_getFieldDefinitionNew($table, $field_new)
                                                                      )
                                                    )
                                        )
                         );

    }
}
?>