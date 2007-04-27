<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * $Id$
 *
 */

class OA_DB_Upgrade
{
    var $schema;
    var $versionTo;

    var $path_changes;
    var $file_schema;
    var $file_changes;
    var $file_migrate;

    var $oSchema;
    var $oMigrator;
    var $oLogger;
    var $oAuditor;

    var $aDefinitionNew;
    var $aDefinitionOld;
    var $aChanges;

    var $aErrors    = array();
    var $aMessages  = array();

    var $timingStr;
    var $timingInt;

    var $aActionCodes   = array();
    var $aTaskList      = array();
    var $aRestoreTables = array();
    var $aDBTables      = array();

    var $logTable   = 'database_action';

    var $prefix = '';
    var $database = '';

    var $continue = true;

    var $aSQLStatements = array();

    var $executeMsg = 'executing task %s : %s => %s';

    var $logFile;
    var $logBuffer = array();
    var $recoveryFile;

    /**
     * A variable to store the default value of PEAR::MDB2 protability options.
     *
     * @var integer
     */
    var $portability;

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
    function OA_DB_Upgrade($oLogger='')
    {
        //this->__construct();
        $this->recoveryFile = MAX_PATH.'/var/recover.log';

        // so that this class can log to the caller's log
        // and write it's own log if necessary (testing)
        if ($oLogger)
        {
            $this->oLogger = $oLogger;
        }
        $this->schema = 'tables_core';
        $this->_setTiming('constructive');
    }

    /**
     * instantiate the mdb2_schema object
     */
    function initMDB2Schema()
    {
        $result  = & MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
        if (!$this->_isPearError($result, 'failed to instantiate MDB2_Schema'))
        {
            $this->oSchema = $result;
            $this->portability = $this->oSchema->db->getOption('portability');
            $this->_setupSQLStatements();
        }
    }

    /**
     * initialises the class     *
     * configures filenames
     * checks that files exist
     * checks that files can be parsed
     * creates the audit table if not found
     *
     * @param string $timing : 'constructive', 'destructive', other...
     * @param string $schema : 'tables_core'...
     * @param string $versionTo
     * @return boolean
     */
    function init($timing='constructive', $schema, $versionTo)
    {
        if (!$this->oSchema)
        {
            $this->initMDB2Schema();
        }

        $this->aChanges = array();
        $this->aTaskList = array();
        $this->aDBTables = array();
        $this->aRestoreTables = array();
        $this->aDefinitionNew = array();

        $this->versionTo    = $versionTo;
        $this->schema       = $schema;
        $this->_setTiming($timing);
        $this->oAuditor->setKeyParams(array('schema_name'=>$this->schema,
                                            'version'=>$this->versionTo,
                                            'timing'=>$this->timingInt
                                            ));
        $this->_log('to version: '.$this->versionTo);
        $this->_log('timing: '.$this->timingStr);

        //$this->path_changes = MAX_PATH.'/etc/changes/';
        $this->path_changes = MAX_PATH.'/var/upgrade/';
        $this->file_schema  = "{$this->path_changes}schema_{$schema}_{$this->versionTo}.xml";
        $this->file_changes  = "{$this->path_changes}changes_{$schema}_{$this->versionTo}.xml";
        $this->file_migrate  = "{$this->path_changes}migration_{$schema}_{$this->versionTo}.php";

        if (!file_exists($this->file_schema))
        {
            $this->_logError('schema file not found: '.$this->file_schema);
            return false;
        }
        else
        {
            $this->_log('schema file found: '.$this->file_schema);
        }
        if (!file_exists($this->file_changes))
        {
            $this->_logError('changes file not found: '.$this->file_changes);
            return false;
        }
        else
        {
            $this->_log('changes file found: '.$this->file_changes);
        }
        if (!file_exists($this->file_migrate))
        {
            $this->_logError('migration file not found: '.$this->file_migrate);
        }
        else
        {
            $this->_log('migration file found: '.$this->file_migrate);
            require_once($this->file_migrate);
            $classname = 'Migration_'.$this->versionTo;
            $this->oMigrator = & new $classname($this->oSchema->db, $this->logFile);
            if ($this->oMigrator)
            {
                $this->oMigrator->init($this->oSchema->db, $this->logFile);
                $this->_log('migration class '.$classname.' instantiated');
                $this->oMigrator->aMessages = $this->aMessages;
                $this->oMigrator->aErrors = $this->aErrors;
            }
            else
            {
                $this->_logError('migration class '.$classname.' instantiation failed');
                return false;
            }
        }

        $result = $this->oSchema->parseDatabaseDefinitionFile($this->file_schema);
        if (!$this->_isPearError($result, 'failed to parse new schema ('.$this->file_schema.')'))
        {
            $this->aDefinitionNew = $result;
            //$this->oMigrator->aDefinition = $this->aDefinitionNew;
            $this->_log('successfully parsed the schema');
            $this->_log('schema name: '.$this->aDefinitionNew['name']);
            $this->_log('schema version: '.$this->aDefinitionNew['version']);
            $this->_log('schema status: '.$this->aDefinitionNew['status']);

            $result = $this->oSchema->parseChangesetDefinitionFile($this->file_changes);
            if (!$this->_isPearError($result, 'failed to parse changeset ('.$this->file_changes.')'))
            {
                $this->aChanges = $result;
                $this->_log('successfully parsed the changeset');
                $this->_log('changeset name: '.$this->aChanges['name']);
                $this->_log('changeset version: '.$this->aChanges['version']);
                $this->_log('changeset comments: '.$this->aChanges['comments']);
                $this->_log(($this->aDefinitionNew['version']==$this->aChanges['version'] ? 'schema and changeset versions match' : 'hmmm.. schema and changeset versions don\'t match'));
                $this->_log(($this->aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found'));
                $this->_log(($this->aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found'));
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
        $this->prefix   = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->database = $GLOBALS['_MAX']['CONF']['database']['name'];

        $this->_log('target database: '.$this->database);
        $this->_log('table prefix: '.$this->prefix);

        $this->_log('successfully initialised DB Upgrade');
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
        $this->_log('verifying '.$this->timingStr.' changes');
        $result = $this->oSchema->verifyAlterDatabase($this->aChanges[$this->timingStr]);
        if (!$this->_isPearError($result, 'VERIFICATION FAILED'))
        {
            $this->aDBTables = $this->_listTables();
            $this->_log(' verified OK');
            $result = $this->_verifyTasks();
            if ($result)
            {
                $this->_dropRecoveryFile();
                $this->oAuditor->logDatabaseAction(array('info1'=>'UPGRADE STARTED',
                                                         'action'=>DB_UPGRADE_ACTION_UPGRADE_STARTED,
                                                        )
                                                  );
                if ($this->_backup())
                {
                    if (!$this->_executeTasks())
                    {
                        $this->_logError('UPGRADE FAILED');
                        $this->oAuditor->logDatabaseAction(array('info1'=>'UPGRADE FAILED',
                                                                 'info2'=>'ROLLING BACK',
                                                                 'action'=>DB_UPGRADE_ACTION_UPGRADE_FAILED,
                                                                )
                                                          );
                        if ($this->_rollback())
                        {
                            $this->_logError('ROLLBACK SUCCEEDED');
                            return false;
                        }
                        else
                        {
                            $this->_logError('ROLLBACK FAILED');
                            return false;
                        }
                    }
                    else
                    {
                        $this->_log('UPGRADE SUCCEEDED');
                        $this->oAuditor->logDatabaseAction(array('info1'=>'UPGRADE SUCCEEDED',
                                                                 'action'=>DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                                                 )
                                                          );
                        $this->_scheduleDestructive();
                    }
                }
                else
                {
                    $this->_logError('failed to create backup');
                    return false;
                }
                $this->_pickupRecoveryFile();
            }
            else
            {
                $this->_logError('TASKLIST CREATION FAILED');
                return false;
            }
        }
        else
        {
            return false;
        }
        return true;
    }

    function _scheduleDestructive()
    {
        if (count($this->aChanges['affected_tables']['destructive'])>0)
        {
            $this->oAuditor->logDatabaseAction(array('info1'=>'DESTRUCTIVE OUTSTANDING',
                                                     'action'=>DB_UPGRADE_ACTION_OUTSTANDING_UPGRADE,
                                                    )
                                              );
        }
        return true;
    }

    /**
     * perform tasks to revert a database to a previous version
     * ... to dream... the impossible dream....
     *
     * @return boolean
     */
    function downgrade()
    {
        return true;
    }

    /**
     * create uniquely named copies of affected tables
     * audit each backup
     *
     * @return boolean
     */
    function _backup()
    {
        $aTables = $this->aChanges['affected_tables'][$this->timingStr];
        $this->aDBTables = $this->_listTables();
        if (!empty($aTables))
        {
            $this->oAuditor->logDatabaseAction(array('info1'=>'BACKUP STARTED',
                                                     'action'=>DB_UPGRADE_ACTION_BACKUP_STARTED,
                                                     )
                                              );
            foreach ($aTables AS $k => $table)
            {
                $table = $this->prefix.$table;
                if (in_array($table, $this->aDBTables))
                {
                    $string     = $this->versionTo.$this->timingStr.$this->database.$table.OA::getNow();
                    $hash       = str_replace(array('+','/','='),array('_','_',''),base64_encode(pack("H*",md5($string)))); // packs down to 22 chars and removes illegal chars
                    $table_bak  ="{$this->prefix}z_{$hash}";
                    $this->aMessages[]  = "backing up table {$table} to table {$table_bak} ";

                    $statement = $this->aSQLStatements['table_copy'];
                    $query      = sprintf($statement, $table_bak, $table);
                    $result     = $this->oSchema->db->exec($query);
                    if ($this->_isPearError($result, 'error creating backup'))
                    {
                        $this->_halt();
                        $this->oAuditor->logDatabaseAction(array('info1'=>'BACKUP FAILED',
                                                                 'info2'=>'creating backup table'.$table_bak,
                                                                 'action'=>DB_UPGRADE_ACTION_BACKUP_FAILED,
                                                                 )
                                                          );
                        return false;
                    }
                    $aBakDef = $this->oSchema->getDefinitionFromDatabase(array($table));
                    $aBakDef = $aBakDef['tables'][$table];
                    $this->aRestoreTables[$table] = array(
                                                            'bak'=>$table_bak,
                                                            'def'=>$aBakDef
                                                         );
                    $this->oAuditor->logDatabaseAction(array('info1'=>'copied table',
                                                             'tablename'=>$table,
                                                             'tablename_backup'=>$table_bak,
                                                             'table_backup_schema'=>serialize($aBakDef),
                                                             'action'=>DB_UPGRADE_ACTION_BACKUP_TABLE,
                                                             )
                                                      );
                }
            }
            $this->oAuditor->logDatabaseAction(array('info1'=>'BACKUP COMPLETE',
                                                     'action'=>DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,
                                                     )
                                              );
        }
        else
        {
            $this->oAuditor->logDatabaseAction(array('info1'=>'BACKUP UNNECESSARY',
                                                     'action'=>DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,
                                                     )
                                              );
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
        $this->aDBTables = $this->_listTables();
        if ($this->_isPearError($result, 'error listing tables during rollback'))
        {
            return false;
        }
        else
        {
            krsort($this->aRestoreTables);
            if (!empty($this->aRestoreTables))
            {
                $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK STARTED',
                                                         'action'=>DB_UPGRADE_ACTION_ROLLBACK_STARTED,
                                                         )
                                                  );
                foreach ($this->aRestoreTables AS $table => $aTable_bak)
                {
                    if (in_array($aTable_bak['bak'], $this->aDBTables))
                    {
                        $dropfirst = (in_array($this->prefix.$table, $this->aDBTables));
                        $result = $this->_restoreFromBackup($this->prefix.$table, $aTable_bak['bak'], $aTable_bak['def'], $dropfirst);
                        if (!$result)
                        {
                            $this->_halt();
                            $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK FAILED',
                                                                     'info2'=>'failed to restore table',
                                                                     'tablename'=>$this->prefix.$table,
                                                                     'action'=>DB_UPGRADE_ACTION_ROLLBACK_FAILED,
                                                                     )
                                                              );
                            return false;
                        }
                        $this->oAuditor->logDatabaseAction(array('info1'=>'reverted table',
                                                                 'tablename'=>$this->prefix.$table,
                                                                 'tablename_backup'=>$aTable_bak['bak'],
                                                                 'action'=>DB_UPGRADE_ACTION_ROLLBACK_TABLE,
                                                                 )
                                                          );
                    }
                    else
                    {
                        $this->_halt();
                        $this->_logError("backup table not found during rollback: {$aTable_bak['bak']}");
                        $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK FAILED',
                                                                 'info2'=>"backup table not found: {$aTable_bak['bak']}",
                                                                 'action'=>DB_UPGRADE_ACTION_ROLLBACK_FAILED,
                                                                 )
                                                          );
                        return false;
                    }
                }
                $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK COMPLETE',
                                                         'action'=>DB_UPGRADE_ACTION_ROLLBACK_SUCCEEDED,
                                                         )
                                                  );
            }
            else
            {
                $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK UNNECESSARY',
                                                         'action'=>DB_UPGRADE_ACTION_ROLLBACK_SUCCEEDED,
                                                         )
                                                  );
            }
        }
        $this->_pickupRecoveryFile();
        return true;
    }

    /**
     * restore individual tables
     * remove the backups?
     * audit each restore?
     * remove the database_action recs?  flag them *done* somehow?
     *
     * @param string $table - must include prefix
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
        $statement = $this->aSQLStatements['table_copy'];
        $query  = sprintf($statement, $table, $table_bak);
        $result = $this->oSchema->db->exec($query);
        if ($this->_isPearError($result, 'error creating table during rollback'))
        {
            $this->_halt();
            return false;
        }
        if (!$this->_createAllIndexes($aDef_bak, $table))
        {
            $this->_halt();
            return false;
        }

        // compare the original and the restored definitions
        $aRestoredDef = $this->oSchema->getDefinitionFromDatabase(array($table));
        $aPreviousDef = array('tables'=>array($table=>$aDef_bak));
        $aDiffs       = $this->oSchema->compareDefinitions($aPreviousDef, $aRestoredDef);
        // not expecting any diffs other than autoincrement property
        if (count($aDiffs)>0)
        {
            if ($aDiffs['tables']['change'][$table]['change'])
            {
                foreach ($aDiffs['tables']['change'][$table]['change'] AS $field_name => $aFldDiff)
                {
                    if (array_key_exists('autoincrement',$aFldDiff))
                    {
                        if (!$this->_restoreAutoIncrement($table, $field_name, $aFldDiff))
                        {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * (mysql) backups do not keep the autoincrement flag
     * this method will restore that flag
     *
     * @param array $aDiffs
     */
    function _restoreAutoIncrement($table_name, $field_name, $aFldDiff)
    {
        $aTask['cargo'] =  array(
                                 'change'=>array(
                                                  $field_name=>$aFldDiff
                                                )
                                );
        $result = $this->oSchema->db->manager->alterTable($table_name, $aTask['cargo'], false);
        if ($this->_isPearError($result, 'error restoring autoincrement field during rollback: '.$table_name.'.'.$field_name))
        {
            $this->_halt();
            return false;
        }
        return true;
    }

    /**
     * seek a recovery file
     * look at the the last upgrade actions performed
     * recompile the array of tables to restore
     *
     *
     * @return boolean
     */
    function prepRecovery()
    {
        $aRecovery = $this->seekRecoveryFile();
        if ($aRecovery)
        {
            $this->aDBTables = $this->_listTables();

            $this->_setTiming('', $aRecovery['timingInt']);
            $this->versionTo    = $aRecovery['versionTo'];
            $this->schema       = $aRecovery['schema_name'];
            $this->_log("Detected interruption while upgrading to {$this->schema} version {$this->versionTo} ({$this->timingStr})");
            $this->_log('Attempting to compile details and recovery information...');

            $query = "SELECT * FROM {$this->prefix}{$this->logTable}
                      WHERE schema_name = '{$this->schema}'
                      AND version={$this->versionTo}
                      AND timing={$this->timingInt}
                      AND updated>='{$aRecovery['updated']}'";
            $aResult = $this->oSchema->db->queryAll($query);

            if ($this->_isPearError($aResult, "error querying recovery info in database audit table"))
            {
                return false;
            }
            else
            {
                foreach ($aResult AS $k=>$aAction)
                {
                    $this->_log("Action found: {$aAction['updated']} : {$aAction['info1']}");
                    if ($aAction['action']==DB_UPGRADE_ACTION_BACKUP_TABLE)
                    {
                        $table = $aAction['tablename'];
                        $table_bak = $aAction['tablename_backup'];
                        $aBakDef = unserialize($aAction['table_backup_schema']);
                        $this->aRestoreTables[$table] = array(
                                                                'bak'=>$table_bak,
                                                                'def'=>$aBakDef
                                                             );
                        $this->_log("Require backup table {$table_bak} to restore table: {$table}");
                        if (in_array($table_bak, $this->aDBTables))
                        {
                            $this->_log("Backup table {$table_bak} found in database");
                        }
                        else
                        {
                            $this->_logError("Backup table {$table_bak} not found in database");
                        }
                    }
                }
            }
        }
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
        $this->_log('dropping your backup: '.$table);

        $result = $this->oSchema->db->manager->dropTable($table);
        if ($this->_isPearError($result, 'error dropping '.$table))
        {
            return false;
        }
        return true;
    }

    /**
     * iterate through the task list and verify each task
     * prepare the tasks for execution
     * handle errors and report
     *
     * @return boolean
     */
    function _verifyTasks()
    {
        $this->_log('verifying/creating '.$this->timingStr.' tasklist');
        if ($this->continue)
        {
            $this->_verifyTasksTablesAdd();
        }
        if ($this->continue)
        {
            $this->_verifyTasksTablesRename();
        }
        if ($this->continue)
        {
            $this->_verifyTasksTablesAlter();
        }
        if ($this->continue)
        {
            $this->_verifyTasksTablesRemove();
        }
        if ($this->continue)
        {
            $this->_verifyTasksIndexesRemove();
        }
        if ($this->continue)
        {
            $this->_verifyTasksIndexesAdd();
        }
        return $this->continue;
    }

    /**
     * iterate through the task list and perform each task
     * handle errors and report
     *
     * @return boolean
     */
    function _executeTasks()
    {
         $this->_log('executing '.$this->timingStr.' tasks');
        if ($this->continue)
        {
            $this->_executeTasksTablesAdd();
        }
        if ($this->continue)
        {
            $this->_executeTasksTablesRename();
        }
        if ($this->continue)
        {
            $this->_executeTasksTablesAlter();
        }
        if ($this->continue)
        {
            $this->_executeTasksTablesRemove();
        }
        if ($this->continue)
        {
            $this->_executeTasksIndexesRemove();
        }
        if ($this->continue)
        {
            $this->_executeTasksIndexesAdd();
        }
        return $this->continue;
    }

    /**
     * execute table alterations
     *
     * @return boolean
     */
    function _executeTasksTablesAlter()
    {
        if (isset($this->aTaskList['fields']['add']))
        {
            foreach ($this->aTaskList['fields']['add'] as $k => $aTask)
            {
                $table = $this->prefix.$aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $table, 'alter'));
                $result = $this->_executeMigrationMethodField($aTask['name'], $aTask['field'], 'beforeAddField');
                if ($this->_isPearError($result, "data migration error beforeAddField: {$aTask['name']}.{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$table))
                {
                    $this->_log('successfully altered table '.$table);
                }
                else
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->_executeMigrationMethodField($aTask['name'], $aTask['field'], 'afterAddField');
                if ($this->_isPearError($result, "data migration error afterAddField: {$aTask['name']}.{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
            }
        }
        if (isset($this->aTaskList['fields']['remove']))
        {
            foreach ($this->aTaskList['fields']['remove'] as $k => $aTask)
            {
                $table = $this->prefix.$aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $table, 'alter'));
                $result = $this->_executeMigrationMethodField($aTask['name'], $aTask['field'], 'beforeRemoveField');
                if ($this->_isPearError($result, "data migration error beforeRemoveField: {$aTask['name']}.{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$table))
                {
                    $this->_log('successfully altered table '.$table);
                }
                else
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->_executeMigrationMethodField($aTask['name'], $aTask['field'], 'afterRemoveField');
                if ($this->_isPearError($result, "data migration error afterRemoveField: {$aTask['name']}.{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
            }
        }
        if (isset($this->aTaskList['fields']['change']))
        {

            foreach ($this->aTaskList['fields']['change'] as $k => $aTask)
            {
                $table = $this->prefix.$aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $table, 'alter'));
                $result = $this->_executeMigrationMethodField($aTask['name'], $aTask['field'], 'beforeAlterField');
                if ($this->_isPearError($result, "data migration error beforeAlterField: {$aTask['name']}.{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$table))
                {
                    $this->_log('successfully altered table '.$table);
                }
                else
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->_executeMigrationMethodField($aTask['name'], $aTask['field'], 'afterAlterField');
                if ($this->_isPearError($result, "data migration error afterAlterField: {$aTask['name']}.{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
            }
        }
        if (isset($this->aTaskList['fields']['rename']))
        {

            foreach ($this->aTaskList['fields']['rename'] as $k => $aTask)
            {
                $table = $this->prefix.$aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $table, 'alter'));
                $result = $this->_executeMigrationMethodField($aTask['name'], $aTask['was'], 'beforeRenameField');
                if ($this->_isPearError($result, "data migration error beforeRenameField: {$aTask['name']}.{$aTask['was']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$table))
                {
                    $this->_log('successfully altered table '.$table);
                }
                else
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->_executeMigrationMethodField($aTask['name'], $aTask['was'], 'afterRenameField');
                if ($this->_isPearError($result, "data migration error afterRenameField: {$aTask['name']}.{$aTask['was']}"))
                {
                    $this->_halt();
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * execute all table creations
     *
     * @return boolean
     */
    function _executeTasksTablesAdd()
    {
        if (isset($this->aTaskList['tables']['add']))
        {
            foreach ($this->aTaskList['tables']['add'] as $k => $aTask)
            {
                $table = $this->prefix.$aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $table, 'create'));

                if (!$this->_executeMigrationMethodTable($table, 'beforeAddTable'))
                {
                    $this->_halt();
                    return false;
                }
                else
                {
                    $result = $this->oSchema->db->manager->createTable($table, $aTask['cargo'], array());
                    if (!$this->_isPearError($result, 'error creating table '.$table))
                    {
                        if (isset($aTask['indexes']))
                        {
                            foreach ($aTask['indexes'] AS $index=>$aIndex_Def)
                            {
                                $aDef['indexes'][$aIndex_Def['name']] = $aIndex_Def['cargo'];
                                $this->_log('executing tables task : '.$table.'=>'.'create index');
                            }
                            if (!$this->_createAllIndexes($aDef, $table))
                            {
                                $this->_halt();
                                return false;
                            }
                        }
                        if (!$this->_executeMigrationMethodTable($table, 'afterAddTable'))
                        {
                            $this->_halt();
                            return false;
                        }
                        else
                        {
                            $this->_log('successfully created table '.$table);
                        }
                    }
                    else
                    {
                        $this->_halt();
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * execute all table renames
     *
     * @return boolean
     */
    function _executeTasksTablesRename()
    {
        if (isset($this->aTaskList['tables']['rename']))
        {
            foreach ($this->aTaskList['tables']['rename'] as $k => $aTask)
            {
                $tbl_new = $this->prefix.$aTask['name'];
                $tbl_old = $this->prefix.$aTask['cargo']['was'];
                $this->_log($this->_formatExecuteMsg($k,  $tbl_old, 'rename'));

                $statement = $this->aSQLStatements['table_rename'];
                $query     = sprintf($statement, $tbl_old, $tbl_new);

                if (!$this->_executeMigrationMethodTable($tbl_new, 'beforeRenameTable'))
                {
                    $this->_halt();
                    return false;
                }
                else
                {
                    $result = $this->oSchema->db->exec($query);
                    if (!$this->_isPearError($result, 'error renaming table '.$tbl_old.' to '.$tbl_new))
                    {
                        if (!$this->_executeMigrationMethodTable($tbl_new, 'afterRenameTable'))
                        {
                            $this->_halt();
                            return false;
                        }
                        else
                        {
                            $this->_log('successfully renamed table '.$tbl_old.' to '.$tbl_new);
                        }
                    }
                    else
                    {
                        $this->_halt();
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * execute all table drops
     *
     * @return boolean
     */
    function _executeTasksTablesRemove()
    {
        if (isset($this->aTaskList['tables']['remove']))
        {
            foreach ($this->aTaskList['tables']['remove'] as $k => $aTask)
            {
                $table = $this->prefix.$aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $table, 'remove'));
                if (!$this->_executeMigrationMethodTable($table, 'beforeRemoveTable'))
                {
                    $this->_halt();
                    return false;
                }
                else
                {
                    $query  = "DROP TABLE {$table}";
                    $result = $this->oSchema->db->exec($query);
                    if (!$this->_isPearError($result, 'error removing table '.$table))
                    {
                        if (!$this->_executeMigrationMethodTable($table, 'afterRemoveTable'))
                        {
                            $this->_halt();
                            return false;
                        }
                        else
                        {
                            $this->_log('successfully removed table '.$table);
                        }
                    }
                    else
                    {
                        $this->_halt();
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * execute all index creates
     * note: these are indexes created on existing tables
     * newly created tables have indexes created at table creation time
     *
     * @return boolean
     */
    function _executeTasksIndexesAdd()
    {
        if (isset($this->aTaskList['indexes']['add']))
        {
            foreach ($this->aTaskList['indexes']['add'] as $k => $aTask)
            {
                $table = $aTask['table'];
                $index = $aTask['name'];
                $aIndex_def = $aTask['cargo'];
                $result = $this->_createAllIndexes($aIndex_def, $table);
                if (!$result)
                {
                    $this->_logError('error adding constraint '.$index);
                    $this->_halt();
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * execute all index drops
     *
     * @return boolean
     */
    function _executeTasksIndexesRemove()
    {
        if (isset($this->aTaskList['indexes']['remove']))
        {
            foreach ($this->aTaskList['indexes']['remove'] as $k => $aTask)
            {
                $index = $aTask['name'];
                $table = $aTask['table'];
                $result = $this->oSchema->db->manager->dropConstraint($table, $index);
                if ($this->_isPearError($result, 'error dropping constraint '.$index))
                {
                    $this->_halt();
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * call a method of the Migration class
     *
     * @param string $method
     * @return boolean
     */
    function _executeMigrationMethod($method)
    {
        if ($method && is_callable(array($this->oMigrator, $method)))
        {
            return call_user_func(array($this->oMigrator, $method));
        }
        return false;
    }

    /**
     * fetch a Migration method for a given table and task
     * execute the method
     *
     * @param string $table_name
     * @param string $method
     * @return string
     */
    function _executeMigrationMethodTable($table_name, $method)
    {
        if (isset($this->aChanges['hooks'][$this->timingStr]['tables'][$table_name]['self'][$method]))
        {
            return $this->_executeMigrationMethod($this->aChanges['hooks'][$this->timingStr]['tables'][$table_name]['self'][$method]);
        }
        return false;
    }

    /**
     * fetch a Migration method for a given table.field and task
     * execute the method
     *
     * @param string $table_name
     * @param string $field_name
     * @param string $method
     * @return string
     */
    function _executeMigrationMethodField($table_name, $field_name, $method)
    {
        if (isset($this->aChanges['hooks'][$this->timingStr]['tables'][$table_name]['fields'][$field_name][$method]))
        {
            return $this->_executeMigrationMethod($this->aChanges['hooks'][$this->timingStr]['tables'][$table_name]['fields'][$field_name][$method]);
        }
        return false;
    }

    /**
     * verify and compile tasks
     *
     * @return boolean
     */
    function _verifyTasksIndexesAdd()
    {
        if (isset($this->aChanges['tasks'][$this->timingStr]['tables']))
        {
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => $aTable_tasks)
            {
                if (isset($aTable_tasks['indexes']))
                {
                    foreach ($aTable_tasks['indexes'] AS $index => $aIndex_tasks)
                    {
                        if (isset($aIndex_tasks['add']))
                        {
                            $method = $aIndex_tasks['add'];
                            $this->_log('task found: '.$method);
                            $this->aTaskList['indexes']['add'][] = $this->_compileTaskIndex('add', $table, $index);
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * verify and compile tasks
     *
     * @return boolean
     */
    function _verifyTasksIndexesRemove()
    {
        if (isset($this->aChanges['tasks'][$this->timingStr]['tables']))
        {
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => $aTable_tasks)
            {
                if (isset($aTable_tasks['indexes']))
                {
                    foreach ($aTable_tasks['indexes'] AS $index => $aIndex_tasks)
                    {
                        if (isset($aIndex_tasks['remove']))
                        {
                            $method = $aIndex_tasks['remove'];
                            $this->_log('task found: '.$method);
                            $this->aTaskList['indexes']['remove'][] = $this->_compileTaskIndex('remove', $table, $index);
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * verify and compile tasks
     *
     * @return boolean
     */
    function _verifyTasksTablesAlter()
    {
        if (isset($this->aChanges['tasks'][$this->timingStr]['tables']))
        {
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => $aTable_tasks)
            {
                if (isset($aTable_tasks['fields']))
                {
                    if (!in_array($this->prefix.$table, $this->aDBTables))
                    {
                        $this->_logError('hmmm.. couldn\'t find table in database: '.$this->prefix.$table);
                        $this->_halt();
                        return false;
                    }
                    else
                    {
                        $aDBFields = $this->oSchema->db->manager->listTableFields($this->prefix.$table);
                        foreach ($aTable_tasks['fields'] AS $field => $aField_tasks)
                        {
                            $this->_log('checking field: '.$field);
                            if (!in_array($field, $aDBFields))
                            {
                                if (array_key_exists('rename', $aField_tasks))
                                {
                                    $method -= $aField_tasks['rename'];
                                    $this->_log('task found: '.$method);
                                    $was = $this->_getPreviousFieldname($table, $field);
                                    if ($was)
                                    {
                                        $this->_log('found that this field : '.$table.'.'.$field.' was called: '.$table.'.'.$was);
                                        $this->aTaskList['fields']['rename'][] = $this->_compileTaskField('rename', $table, $was, $field);
                                    }
                                    else
                                    {
                                        $this->_logError('hmmm.. couldn\'t find what this field was called: '.$table.'.'.$field);
                                        $this->_halt();
                                        return false;
                                    }
                                }
                                else if (array_key_exists('add', $aField_tasks))
                                {
                                    $method = $aField_tasks['add'];
                                    $this->_log('task found: '.$method);
                                    $this->aTaskList['fields']['add'][] = $this->_compileTaskField('add', $table, $field, $field);
                                }
                                else
                                {
                                    $this->_logError('oh dear.. field '.$field.' not found in table '.$this->prefix.$table);
                                    $this->_halt();
                                    return false;
                                }
                            }
                            else
                            {
                                $this->_log('found field '.$field);
                                foreach ($aField_tasks AS $task => $method)
                                {
                                    if ($task != 'rename')
                                    {
                                        $this->aTaskList['fields'][$task][] = $this->_compileTaskField($task, $table, $field, $field);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * verify and compile tasks
     *
     * @return boolean
     */
    function _verifyTasksTablesRemove()
    {
        if (isset($this->aChanges['tasks'][$this->timingStr]['tables']))
        {
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => $aTable_tasks)
            {
                if (isset($aTable_tasks['self']))
                {
                    foreach ($aTable_tasks['self'] AS $task => $method)
                    {
                        if ($task == 'remove')
                        {
                            $this->_log('task found: '.$method);
                            if (in_array($this->prefix.$table, $this->aDBTables))
                            {
                                $this->_log('found table in database: '.$this->prefix.$table);
                                $this->aTaskList['tables']['remove'][] = $this->_compileTaskTable($task, $table);
                            }
                            else
                            {
                                $this->_logError('hmmm.. couldn\'t find table in database: '.$this->prefix.$table);
                                $this->_halt();
                                return false;
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * verify and compile tasks
     * confirm that the 'was' table exists
     * and that a table with the new name does not exist
     *
     * @return boolean
     */
    function _verifyTasksTablesRename()
    {
        if ($this->aChanges['tasks'][$this->timingStr]['tables'])
        {
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => $aTable_tasks)
            {
                if (isset($aTable_tasks['self']))
                {
                    foreach ($aTable_tasks['self'] AS $task => $method)
                    {
                        if ($task == 'rename')
                        {
                            $this->_log('task found: '.$method);
                            $table_was = $this->_getPreviousTablename($table);
                            if ($table_was)
                            {
                                if (in_array($this->prefix.$table_was, $this->aDBTables))
                                {
                                    $this->_log('found that this table : '.$table.' was called: '.$table_was);
                                    $this->aTaskList['tables']['rename'][] = $this->_compileTaskTable($task, $table, $table_was);
                                }
                                else
                                {
                                    $this->_logError('hmmm.. couldn\'t find table in database: '.$this->prefix.$table_was);
                                    $this->_halt();
                                    return false;
                                }
                            }
                            else
                            {
                                $this->_logError('hmmm.. couldn\'t find what this table was called: '.$this->prefix.$table_was);
                                $this->_halt();
                                return false;
                            };
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * and that a table with this name does not exist
     *
     * @return boolean
     */
    function _verifyTasksTablesAdd()
    {
        if (isset($this->aChanges['tasks'][$this->timingStr]['tables']))
        {
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => $aTable_tasks)
            {
                if (isset($aTable_tasks['self']))
                {
                    foreach ($aTable_tasks['self'] AS $task => $method)
                    {
                        if ($task == 'add')
                        {
                            $this->_log('task found: '.$method);
                            if (in_array($this->prefix.$table, $this->aDBTables))
                            {
                                $this->_logError('table '.$this->prefix.$table.' already exists in database '.$this->oSchema->db->database_name);
                                $this->_halt();
                                return false;
                            }
                            else
                            {
                                $this->_compileTaskCreateTable($task, $table);
                            }

                        }
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
        if (isset($this->aChanges[$this->timingStr]['tables']['change'][$table]['rename']['fields'][$field]['was']))
        {
            return $this->aChanges[$this->timingStr]['tables']['change'][$table]['rename']['fields'][$field]['was'];
        }
        return false;
    }

    /**
     * when renaming a table
     * the changes array indexes the new table name
     * you need to retrieve the 'was' table name
     * to know which table you are actually renaming
     *
     * @param string $table
     * @return string old table name
     */
    function _getPreviousTablename($table)
    {
        if (isset($this->aChanges[$this->timingStr]['tables']['rename'][$table]['was']))
        {
            return $this->aChanges[$this->timingStr]['tables']['rename'][$table]['was'];
        }
        return false;
    }

    /**
     * retrieve the table definition from a parsed schema
     *
     * @param string $table
     * @return array
     */
    function _getTableDefinition($aDefinition, $table)
    {
        if (isset($aDefinition['tables'][$table]))
        {
            return $aDefinition['tables'][$table];
        }
        return false;
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
        if (isset($aDefinition['tables'][$table]))
        {
            if (isset($aDefinition['tables'][$table]['fields'][$field]))
            {
                return $aDefinition['tables'][$table]['fields'][$field];
            }
        }
        return false;
    }

    /**
     * multiple tasks are required for table creation
     *
     * @param string $task
     * @param string $table
     * @return array
     */
    function _compileTaskCreateTable($task, $table)
    {
        $aTableDef  = $this->_getTableDefinition($this->aDefinitionNew, $table);

        $aTable =  array(
                        'name'=>$this->prefix.$table,
                        'cargo'=>$aTableDef['fields']
                        );

        if (isset($aTableDef['indexes']))
        {
            foreach ($aTableDef['indexes'] AS $index_name=>$aIndex_def)
            {
                $aTable['indexes'][] = array(
                                              'table'=>$this->prefix.$table,
                                              'name'=>$index_name,
                                              'cargo'=>$aIndex_def
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
    function _compileTaskField($task, $table, $field_name, $field_name_new)
    {
        $result =   array(
                          'name'=>$this->prefix.$table,
                          'field'=>$field_name,
                          'cargo'=>array()
                         );

        switch ($task)
        {
            case 'remove':
                $result['cargo'] =  array(
                                         $task=>array(
                                                      $field_name=>array()
                                                     )
                                        );
                break;
            case 'add':
                $aDef = $this->_getFieldDefinition($this->aDefinitionNew, $table, $field_name);
                $result['cargo'] =  array(
                                         $task=>array(
                                                      $field_name=>$aDef
                                                     )
                                        );
                break;
            case 'change':
                $aDef['definition'] = $this->_getFieldDefinition($this->aDefinitionNew, $table, $field_name);
                $result['cargo'] =  array(
                                         $task=>array(
                                                      $field_name=>$aDef
                                                     )
                                        );
                break;
            case 'rename':
                $aDef = $this->_getFieldDefinition($this->aDefinitionNew, $table, $field_name_new);
                $result['was'] = $field_name_new;
                $result['cargo'] =  array(
                                         $task=>array(
                                                      $field_name=>array(
                                                                         'name'=>$field_name_new,
                                                                         'definition'=>$aDef
                                                                        )
                                                     )
                                        );
                break;
        }
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
    function _compileTaskIndex($task, $table, $index_name)
    {
        switch($task)
        {
            case 'add':
                $aTableDef = $this->_getTableDefinition($this->aDefinitionNew, $table);
                $result =   array(
                                  'table'=>$this->prefix.$table,
                                  'name'=>$index_name,
                                  'cargo'=>array('indexes'=>array($index_name=>$aTableDef['indexes'][$index_name]))
                                 );
                break;
            case'remove':
                $result =   array(
                                  'table'=>$this->prefix.$table,
                                  'name'=>$index_name,
                                 );
                break;
        }
        return $result;
    }

    /**
     * compile task array for table rename, remove or change
     *
     * @param string $task
     * @param string $table
     * @return array
     */
    function _compileTaskTable($task, $table, $was='')
    {
        $result =   array(
                          'name'=>$this->prefix.$table,
                          'cargo'=>array()
                         );
        switch($task)
        {
            case 'rename':
                $result['cargo'] = array('was'=>$was);
                break;
            case 'remove':
                break;
            default:
                $aTableDef = $this->_getTableDefinition($this->aDefinitionNew, $table);
                $result['cargo'] = $aTableDef['fields'];
                break;
        }
        return $result;
    }

    function _sortIndexFields($aIndex_def)
    {
        if (isset($aIndex_def['fields']))
        {
            foreach ($aIndex_def['fields'] as $field => $aDef)
            {
                if (array_key_exists('order', $aDef))
                {
                    $aIdx_sort[$aDef['order']] = $field;
                }
            }
        }
        if (isset($aIdx_sort))
        {
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
        else
        {
            return $aIndex_def;
        }
    }

    /**
     * create each index/constraint in a definition array
     *
     * @param array $aDef
     * @param string $table_name - must include prefix
     * @return boolean
     */
    function _createAllIndexes($aDef, $table_name)
    {
        if (isset($aDef['indexes']))
        {
            $aDBIndexes = $this->_listIndexes($table_name);
            $aDBConstraints = $this->_listConstraints($table_name);
            foreach ($aDef['indexes'] as $index => $aIndex_def)
            {
                $aIndex_def = $this->_sortIndexFields($aIndex_def);
                if (array_key_exists('primary', $aIndex_def) || array_key_exists('unique', $aIndex_def))
                {
                    $primary = array_key_exists('primary', $aIndex_def);
                    if (in_array($index, $aDBConstraints))
                    {
                        $result = $this->oSchema->db->manager->dropConstraint($table_name, $index, $primary);
                    }
                    $result = $this->oSchema->db->manager->createConstraint($table_name, $index, $aIndex_def);
                }
                else
                {
                    if (in_array($index, $aDBIndexes))
                    {
                        $result = $this->oSchema->db->manager->dropIndex($table_name, $index);
                    }
                    $result = $this->oSchema->db->manager->createIndex($table_name, $index, $aIndex_def);
                }
                if (!$this->_isPearError($result, "error creating index {$index} on table {$table_name}"))
                {
                    $this->_log("success creating index {$index} on table {$table_name}");
                }
                else
                {
                    return false;
                }
            }
        }
        return true;
    }

    // misc methods

    /**
     * set the timing vars if you have only one or the other (str or int)
     *
     * @param string $timingStr
     * @param integer $timingInt
     */
    function _setTiming($timingStr='', $timingInt=0)
    {
        if ($timingStr)
        {
            $this->timingStr    = $timingStr;
            $this->timingInt    = ($timingStr=='constructive' ? DB_UPGRADE_TIMING_CONSTRUCTIVE_DEFAULT : DB_UPGRADE_TIMING_DESTRUCTIVE_DEFAULT );
        }
        else
        {
            $this->timingStr    = ($timingInt==DB_UPGRADE_TIMING_CONSTRUCTIVE_DEFAULT ? 'constructive' : 'destructive' );
            $this->timingInt    = $timingInt;
        }
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
            $this->_logError($message.' '. $result->getUserInfo());
            return true;
        }
        return false;
    }

    /**
     * format a standard message about the task being executed
     *
     * @param integer $idx
     * @param string $table
     * @param string $task
     * @return string
     */
    function _formatExecuteMsg($idx, $table, $task)
    {
        return sprintf('executing task %s : %s => %s', $idx, $table, $task);
    }

    /**
     * construct dbms independent sql statements
     *
     */
    function _setupSQLStatements()
    {
        switch ($this->oSchema->db->dbsyntax)
        {
            case 'mysql':
                $engine = $this->oSchema->db->getOption('default_table_type');
                $this->aSQLStatements['table_copy']     = "CREATE TABLE %s ENGINE={$engine} (SELECT * FROM %s)";
                $this->aSQLStatements['table_rename']   = "RENAME TABLE %s TO %s";
                break;
            case 'pgsql':
                $this->aSQLStatements['table_copy']     = 'CREATE TABLE "%1$s" (LIKE "%2$s" INCLUDING DEFAULTS); INSERT INTO "%1$s" SELECT * FROM "%2$s"';
                $this->aSQLStatements['table_rename']   = 'ALTER TABLE "%s" RENAME TO "%s"';
                break;
            default:
                '';
                break;
        }
    }

    /**
     * retrieve an array of table names from currently connected database
     * uses the conf table prefix to search only for tables from the openads schema
     *
     *
     * @param string : any additional (post-prefix) string to search for
     * @return array
     */
    function _listTables($prefix='')
    {
        OA_DB::setCaseSensitive();
        $aDBTables = $this->oSchema->db->manager->listTables(null, $this->prefix.$prefix);
        OA_DB::disableCaseSensitive();
        return $aDBTables;
    }

    /**
     * retrieve an array of table names from currently connected database
     *
     * @return array
     */
    function _listBackups()
    {
        $aResult = array();
        $aBakTables = $this->_listTables('z\_');
        $prefix = $this->prefix.'z_';
        $prelen = strlen($prefix);
        krsort($aBakTables);
        foreach ($aBakTables AS $k => $name)
        {
            // workaround for mdb2 problem "show table like"
            if (substr($name,0,$prelen)==$prefix)
            {
                $aInfo = $this->oAuditor->queryAuditForABackup($name);
                $aResult[$k]['backup_table'] = $name;
                $aResult[$k]['copied_table'] = $aInfo[0]['tablename'];
                $aResult[$k]['copied_date']  = $aInfo[0]['updated'];
            }
        }
        return $aResult;
    }

    function _listConstraints($table_name)
    {
        return $this->oSchema->db->manager->listTableConstraints($table_name);
    }

    function _listIndexes($table_name)
    {
        return $this->oSchema->db->manager->listTableIndexes($table_name);
    }
    /**
     * set the continue flag to false
     *
     */
    function _halt()
    {
        $this->continue = false;
    }

    /**
     * write a message to the logfile
     *
     * @param string $message
     */
    function _log($message)
    {
        if ($this->oLogger)
        {
            $this->oLogger->log($message);
        }
        else
        {
            $this->aMessages[] = $message;
            $this->_logWrite($message);
        }
    }

    /**
     * write an error to the log file
     *
     * @param string $message
     */
    function _logError($message)
    {
        if ($this->oLogger)
        {
            $this->oLogger->logError($message);
        }
        else
        {
            $this->aErrors[] = $message;
            $this->_logWrite("ERROR: {$message}");
        }
    }

    function _logWrite($message)
    {
        if (empty($this->logFile)) {
            $this->logBuffer[] = $message;
        } else {
            $log = fopen($this->logFile, 'a');
            if (count($this->logBuffer)) {
                $message = join("\n", $this->logBuffer);
                $this->logBuffer = array();
            }
            fwrite($log, "{$message}\n");
            fclose($log);
        }
    }
    /**
     * write the version, timing and timestamp to a small temp file in the var folder
     * this will be written when an upgrade starts and deleted when it ends
     * if this file is present outside of the upgrade process it indicates that
     * the upgrade was interrupted
     *
     * @return boolean
     */
    function _dropRecoveryFile()
    {
        //$this->_pickupRecoveryFile();
        $log = fopen($this->recoveryFile, 'w');
        $date = date('Y-m-d h:i:s');
        fwrite($log, "{$this->schema};{$this->versionTo};{$this->timingInt};{$date}");
        fclose($log);
        return file_exists($this->recoveryFile);
    }

    function _pickupRecoveryFile()
    {
        if (file_exists($this->recoveryFile))
        {
            unlink($this->recoveryFile);
            return true;
        }
        return true;
    }

    function seekRecoveryFile()
    {
        if (file_exists($this->recoveryFile))
        {
            $contents               = file_get_contents($this->recoveryFile);
            $aVars                  = explode(';', $contents);
            $aResult['schema_name'] = $aVars[0];
            $aResult['versionTo']   = $aVars[1];
            $aResult['timingInt']   = $aVars[2];
            $aResult['updated']     = $aVars[3];
            return $aResult;
        }
        return false;
    }

    function dropBackupTable($table)
    {
        if (!$this->dropTable($table))
        {
            return false;
        }
        $this->oAuditor->updateAuditBackupDropped($table);
        return true;
    }

    function dropTable($table)
    {
        $result = $this->oSchema->db->manager->dropTable($table);
        if ($this->_isPearError($result, 'error dropping '.$table))
        {
            return false;
        }
        return true;
    }

}

?>