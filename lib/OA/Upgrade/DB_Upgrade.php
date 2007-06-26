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

require_once MAX_PATH . '/lib/OA/DB/XmlCache.php';



class OA_DB_Upgrade
{
    var $schema;
    var $versionTo;

    var $path_schema;
    var $path_changes;
    var $file_schema;
    var $file_changes;
    var $file_migrate;

    var $oSchema;
    var $oLogger;
    var $oAuditor;
    var $oMigrator;
    var $oPreScript;
    var $oPostScript;
    var $oTable;

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
    var $aAddedTables  = array();
    var $aDBTables      = array();

    var $logTable   = 'database_action';

    var $prefix = '';
    var $database = '';

    var $doBackups = true;

    var $continue = true;

    var $aSQLStatements = array();

    var $executeMsg = 'executing task %s : %s => %s';

    var $logFile;
    var $logBuffer = array();

    /**
     * A variable to store the default value of PEAR::MDB2 protability options.
     *
     * @var integer
     */
    var $portability;

    /**
     * OA_DB_XmlCache instance to load/save cached schema and changeset files
     *
     * @var OA_DB_XmlCache
     */
    var $oCache;

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
        $this->path_changes = MAX_PATH.'/etc/changes/';
        $this->path_schema = $this->path_changes;

        // so that this class can log to the caller's log
        // and write it's own log if necessary (testing)
        if ($oLogger)
        {
            $this->oLogger = $oLogger;
        }
        $this->schema = 'tables_core';
        $this->_setTiming('constructive');

        $this->oCache = new OA_DB_XmlCache();
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
            $this->oTable = new OA_DB_Table();
        }
    }

    /**
     * initialises the class
     * configures filenames
     * checks that files exist
     * checks that files can be parsed
     * creates the audit table if not found
     *
     * @param string $timing : 'constructive', 'destructive', other...
     * @param string $schema : 'tables_core'...
     * @param string $versionTo
     * @param boolean $switchTimingOnly : if we want to only reset this object, not re-parse the files
     * @return boolean
     */
    function init($timing='constructive', $schema, $versionTo, $switchTimingOnly=false)
    {
        if (!$this->oSchema)
        {
            $this->initMDB2Schema();
        }

        $this->aTaskList = array();
        $this->aRestoreTables = array();
        $this->aAddedTables = array();

        $this->versionTo    = $versionTo;
        $this->schema       = $schema;
        $this->_setTiming($timing);
        $this->oAuditor->setKeyParams(array('schema_name'=>$this->schema,
                                            'version'=>$this->versionTo,
                                            'timing'=>$this->timingInt
                                            )
                                     );
        $this->_log('to version: '.$this->versionTo);
        $this->_log('timing: '.$this->timingStr);

        // if only switching the timing
        // it should not be necessary to reparse the definitions
        if (!$switchTimingOnly)
        {
            $this->aDBTables = array();
            $this->aChanges = array();
            $this->aDefinitionNew = array();

            $this->file_schema  = "{$this->path_schema}schema_{$schema}_{$this->versionTo}.xml";
            $this->file_changes  = "{$this->path_changes}changes_{$schema}_{$this->versionTo}.xml";
            $this->file_migrate  = "{$this->path_changes}migration_{$schema}_{$this->versionTo}.php";

            // this will parse the schema definition file
            if (!$this->buildSchemaDefinition())
            {
                return false;
            }

            if (!$this->buildChangesetDefinition())
            {
                return false;
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
                $this->oMigrator = & new $classname();
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
        }

        $this->prefix   = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->database = $GLOBALS['_MAX']['CONF']['database']['name'];

        $this->_log('target database: '.$this->database);
        $this->_log('table prefix: '.$this->prefix);

        $this->_log('successfully initialised DB Upgrade');
        return true;
    }

    function buildSchemaDefinition()
    {
        if (!$this->oSchema)
        {
            $this->initMDB2Schema();
        }
        if (!file_exists($this->file_schema))
        {
            $this->_logError('schema file not found: '.$this->file_schema);
            return false;
        }
        $this->_log('schema file found: '.$this->file_schema);

        // Load definitions from cache
        $this->oTable->init($this->file_schema, true);

        if (!is_array($this->oTable->aDefinition))
        {
            $this->_logError('problem with parsing schema definition');
            return false;
        }

        $this->aDefinitionNew = $this->oTable->aDefinition;
        $this->_log('successfully parsed the schema');
        $this->_log('schema name: '.$this->aDefinitionNew['name']);
        $this->_log('schema version: '.$this->aDefinitionNew['version']);
        $this->_log('schema status: '.$this->aDefinitionNew['status']);
        return true;
    }

    function buildChangesetDefinition()
    {
        if (!file_exists($this->file_changes))
        {
            $this->_logError('changes file not found: '.$this->file_changes);
            return false;
        }

        $this->aChanges = $this->oCache->get($this->file_changes);

        if (!$this->aChanges)
        {
            $this->aChanges = $this->oSchema->parseChangesetDefinitionFile($this->file_changes);

            if ($this->_isPearError($this->aChanges, 'failed to parse changeset ('.$this->file_changes.')'))
            {
                return false;
            }

            // On-the fly cache writing disabled
            //$this->oCache->save($this->aChanges, $this->file_changes);
        }

        $this->_log('successfully parsed the changeset');
        $this->_log('changeset name: '.$this->aChanges['name']);
        $this->_log('changeset version: '.$this->aChanges['version']);
        $this->_log('changeset comments: '.$this->aChanges['comments']);
        $this->_log(($this->aDefinitionNew['version']==$this->aChanges['version'] ? 'schema and changeset versions match' : 'hmmm.. schema and changeset versions don\'t match'));
        $this->_log(($this->aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found'));
        $this->_log(($this->aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found'));
        return true;
    }

    function _prepScript($file, $classprefix, $object)
    {
        if (!$file)
        {
            return true;
        }
        else if (file_exists($file))
        {
            $this->_log('acquiring script '.$file);
            require_once $file;
            $classname = $classprefix.'_'.$this->schema.'_'.$this->versionTo;
            if (class_exists($classname))
            {
                $this->_log('instantiating class '.$classname);
                $this->$object = new $classname;
                $method = 'execute_'.$this->timingStr;
                if (is_callable(array($this->$object, $method)))
                {
                    $this->_log('method is callable '.$method);
                    return true;
                }
                $this->_logError('method not found '.$method);
                return false;
            }
            $this->_logError('class not found '.$classname);
            return false;
        }
        $this->_logError('script not found '.$file);
        return false;
    }

    function prepPreScript($file)
    {
        return $this->_prepScript($file, 'prescript', 'oPreScript');
    }

    function runPreScript($aParams='')
    {
        $method = 'execute_'.$this->timingStr;
        return call_user_func(array($this->oPreScript, $method), $aParams);
    }

    function prepPostScript($file)
    {
        return $this->_prepScript($file, 'postscript', 'oPostScript');
    }

    function runPostScript($aParams='')
    {
        $method = 'execute_'.$this->timingStr;
        return call_user_func(array($this->oPostScript, $method), $aParams);
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
            $this->_log('verified OK');
            $result = $this->_verifyTasks();
            if ($result)
            {
                $this->oAuditor->logDatabaseAction(array('info1'=>'UPGRADE STARTED',
                                                         'action'=>DB_UPGRADE_ACTION_UPGRADE_STARTED,
                                                        )
                                                  );
                if ($this->_backup())
                {
                    if (!$this->_executeTasks())
                    {
                        $this->_logError('UPGRADE FAILED: '.$this->schema.'_'.$this->versionTo);
                        $this->oAuditor->logDatabaseAction(array('info1'=>'UPGRADE FAILED',
                                                                 'info2'=>'ROLLING BACK',
                                                                 'action'=>DB_UPGRADE_ACTION_UPGRADE_FAILED,
                                                                )
                                                          );
                        if ($this->rollback())
                        {
                            $this->_logError('ROLLBACK SUCCEEDED: '.$this->schema.'_'.$this->versionTo);
                            return false;
                        }
                        else
                        {
                            $this->_logError('ROLLBACK FAILED: '.$this->schema.'_'.$this->versionTo);
                            return false;
                        }
                    }
                    else
                    {
                        $this->_log('UPGRADE SUCCEEDED');
                        foreach ($this->aAddedTables AS $table => $added)
                        {
                            $this->oAuditor->logDatabaseAction(array('info1'=>'added new table',
                                                                     'tablename'=>$table,
                                                                     'action'=>DB_UPGRADE_ACTION_UPGRADE_TABLE_ADDED,
                                                                    )
                                                              );
                        }
                        $this->oAuditor->logDatabaseAction(array('info1'=>'UPGRADE SUCCEEDED',
                                                                 'action'=>DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                                                )
                                                          );
                        // currently we are executing constructive immediately after destructive
                        //$this->_scheduleDestructive();
                    }
                }
                else
                {
                    $this->_logError('failed to create backup');
                    return false;
                }
            }
            else
            {
                $this->_logError('TASKLIST CREATION FAILED: '.$this->schema.'_'.$this->versionTo);
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
     * not currently used
     *
     * @return boolean
     */
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
     *
     */
    function checkSchemaIntegrity($filename='changes_tables_core')
    {
        $this->_log('running integrity check');
        $this->_log('comparing database '.$this->oSchema->db->connected_database_name.' with schema '.$this->file_schema);
        OA_DB::setCaseSensitive();
        // compare the schema and implemented definitions
        $aDefinitionOld = $this->_getDefinitionFromDatabase();
        if ($this->_isPearError($aDefinitionOld, 'error getting database definition'))
        {
            OA_DB::disableCaseSensitive();
            return false;
        }
        $aDiffs = $this->oSchema->compareDefinitions($this->aDefinitionNew, $aDefinitionOld);
        if ($this->_isPearError($aDiffs, 'error comparing definitions'))
        {
            OA_DB::disableCaseSensitive();
            return false;
        }

        OA_DB::disableCaseSensitive();
        $aOptions = array (
                            'output_mode'   =>    'file',
                            'output'        =>    $filename,
                            'end_of_line'   =>    "\n",
                            'xsl_file'      =>    "xsl/mdb2_schema.xsl",
                            'custom_tags'   =>    array(),
                            'split'         =>    true,
                          );
        if ($this->_isPearError($this->oSchema->dumpChangeset($aDiffs, $aOptions), 'error writing changeset'))
        {
            return false;
        }

        $aChanges  = $this->oSchema->parseChangesetDefinitionFile($aOptions['output']);
        if ($this->_isPearError($aChanges, 'error parsing changeset'))
        {
            return false;
        }

        if (array_key_exists('add',$aChanges['constructive']['tables']))
        {
            foreach ($aChanges['constructive']['tables']['add'] AS $k => $v)
            {
                $this->_log('table is missing: '.$k);
            }
        }
        if (array_key_exists('change', $aChanges['constructive']['tables']))
        {
            foreach ($aChanges['constructive']['tables']['change'] AS $k => $v)
            {
                // empty arrays should not exist
                if (count($v)>0)
                {
                    if (isset($v['add']))
                    {
                        foreach ($v['add']['fields'] AS $column => $bool)
                        {
                            $this->_log('column missing from table: '.$k.'.'.$column);
                        }
                    }
                    if (isset($v['change']))
                    {
                        $this->_log('column definition does not match: '.$k.'.'.key($v['change']['fields']));
                    }
                    if (isset($v['indexes']))
                    {
                        if (isset($v['indexes']['add']))
                        {
                            foreach ($v['indexes']['add'] AS $index => $def)
                            {
                                $this->_log('index missing from table: '.$k.'.'.$index);
                            }
                        }
                    }
                }
            }
        }
        if (array_key_exists('remove',$aChanges['destructive']['tables']))
        {
            foreach ($aChanges['destructive']['tables']['remove'] AS $k => $v)
            {
                $this->_log('table is not part of schema: '.$k);
            }
        }
        $this->aChanges = $aChanges;
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
        if ($this->doBackups)
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
                    if (in_array($this->prefix.$table, $this->aDBTables))
                    {
                        $string     = $this->versionTo.$this->timingStr.$this->database.$this->prefix.$table.OA::getNow();
                        $hash       = str_replace(array('+','/','='),array('_','_',''),base64_encode(pack("H*",md5($string)))); // packs down to 22 chars and removes illegal chars
                        $table_bak  ="z_{$hash}";
                        $this->aMessages[]  = "backing up table {$this->prefix}{$table} to table {$this->prefix}{$table_bak} ";

                        $statement = $this->aSQLStatements['table_copy'];
                        $query      = sprintf($statement, $this->prefix.$table_bak, $this->prefix.$table);
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
                        $aDef = $this->_getDefinitionFromDatabase($table);
                        $aBakDef = $aDef['tables'][$table];
                        $this->aRestoreTables[$table] = array(
                                                                'bak'=>$table_bak,
                                                                'def'=>$aBakDef
                                                             );
                        $this->oAuditor->logDatabaseAction(array('info1'=>'copied table',
                                                                 'tablename'=>$table,
                                                                 'tablename_backup'=>$table_bak,
                                                                 'table_backup_schema'=>serialize($aBakDef),
                                                                 'action'=>DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED,
                                                                )
                                                          );
                    }
                    else
                    {
                        $this->aAddedTables[$table] = true;
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
        }
        else
        {
            $this->oAuditor->logDatabaseAction(array('info1'=>'BACKUP IGNORED',
                                                     'action'=>DB_UPGRADE_ACTION_BACKUP_IGNORED,
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
    function rollback()
    {
        $this->aDBTables = $this->_listTables();
        if ($this->_isPearError($this->aDBTables, 'error listing tables during rollback'))
        {
            return false;
        }
        if (empty($this->aRestoreTables) && empty($this->aAddedTables))
        {
            $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK UNNECESSARY',
                                                     'action'=>DB_UPGRADE_ACTION_ROLLBACK_SUCCEEDED,
                                                    )
                                              );
        }
        else
        {
            if (!empty($this->aRestoreTables))
            {
                krsort($this->aRestoreTables);
                $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK STARTED',
                                                         'action'=>DB_UPGRADE_ACTION_ROLLBACK_STARTED,
                                                        )
                                                  );
                foreach ($this->aRestoreTables AS $table => $aTable_bak)
                {
                    if (in_array($this->prefix.$aTable_bak['bak'], $this->aDBTables))
                    {
                        $dropfirst = (in_array($this->prefix.$table, $this->aDBTables));
                        $result = $this->_restoreFromBackup($table, $aTable_bak['bak'], $aTable_bak['def'], $dropfirst);
                        if (!$result)
                        {
                            $this->_logError("failed to restore backup table: {$this->prefix}{$aTable_bak['bak']} => {$this->prefix}{$table}");
                            $this->_halt();
                            $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK FAILED',
                                                                     'info2'=>'failed to restore table',
                                                                     'tablename'=>$table,
                                                                     'action'=>DB_UPGRADE_ACTION_ROLLBACK_FAILED,
                                                                    )
                                                              );
                            return false;
                        }
                        $this->_log("backup table restored: {$this->prefix}{$aTable_bak['bak']} => {$this->prefix}{$table}");
                        $this->oAuditor->logDatabaseAction(array('info1'=>'reverted table',
                                                                 'tablename'=>$table,
                                                                 'tablename_backup'=>$aTable_bak['bak'],
                                                                 'action'=>DB_UPGRADE_ACTION_ROLLBACK_TABLE_RESTORED,
                                                                )
                                                          );
                        if (!$this->dropBackupTable($aTable_bak['bak'], 'dropped after successful restore'))
                        {
                            $this->_log("failed to drop backup table {$this->prefix}{$aTable_bak['bak']} after successfully restoring {$this->prefix}{$table}");
                        }
                    }
                    else
                    {
                        $this->_halt();
                        $this->_logError("backup table not found during rollback: {$this->prefix}{$aTable_bak['bak']}");
                        $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK FAILED',
                                                                 'info2'=>"backup table not found: {$aTable_bak['bak']}",
                                                                 'action'=>DB_UPGRADE_ACTION_ROLLBACK_FAILED,
                                                                )
                                                          );
                        return false;
                    }
                }
            }
            if (!empty($this->aAddedTables))
            {
                foreach ($this->aAddedTables AS $table => $added)
                {
                    if ($this->dropTable($table))
                    {
                        $this->oAuditor->logDatabaseAction(array('info1'=>'dropped new table',
                                                                 'tablename'=>$table,
                                                                 'action'=>DB_UPGRADE_ACTION_ROLLBACK_TABLE_DROPPED,
                                                                )
                                                          );
                    }
                    else
                    {
                        $this->_halt();
                        $this->_logError("table not deleted during rollback: {$table}");
                        $this->oAuditor->logDatabaseAction(array('info1'=>'ROLLBACK FAILED',
                                                                 'info2'=>"table not deleted: {$table}",
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
        }
        return true;
    }

    function prepRollback()
    {
        $this->aDBTables = $this->_listTables();
        $aResult = $this->oAuditor->queryAudit($this->versionTo, $this->timingInt, $this->schema, DB_UPGRADE_ACTION_UPGRADE_TABLE_ADDED);
        if (!is_array($aResult))
        {
            return false;
        }
        $this->aAddedTables = $this->_prepAddedTables($aResult);
        $aResult = $this->oAuditor->queryAudit($this->versionTo, $this->timingInt, $this->schema, DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED);
        if (!is_array($aResult))
        {
            return false;
        }
        $this->aRestoreTables = $this->_prepRestoreTables($aResult);
        return true;
    }

    function _prepRestoreTables($aTables)
    {
        $aResult = array();
        foreach ($aTables AS $k=>$aAction)
        {
            // info2 holds the reason for table having been dropped
            // ie dropped by user, dropped after successful restore
            if (is_null($aAction['info2']))
            {
                $table = $aAction['tablename'];
                $table_bak = $aAction['tablename_backup'];
                $aBakDef = unserialize($aAction['table_backup_schema']);
                $aResult[$table] = array(
                                        'bak'=>$table_bak,
                                        'def'=>$aBakDef
                                        );
                $this->_log("Require backup table {$this->prefix}{$table_bak} to restore table: {$this->prefix}{$table}");
                if (in_array($this->prefix.$table_bak, $this->aDBTables))
                {
                    $this->_log("Backup table {$this->prefix}{$table_bak} found in database");
                }
                else
                {
                    $this->_logError("Backup table {$this->prefix}{$table_bak} not found in database");
                }
            }
        }
        return $aResult;
    }

    function _prepAddedTables($aTables)
    {
        $aResult = array();
        foreach ($aTables AS $k=>$aAction)
        {
            $table = $aAction['tablename'];
            $aResult[$table] = true;
        }
        return $aResult;
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
            $result = $this->dropTable($table);
            if (!$result)
            {
                $this->_logError('dropping '.$this->prefix.$table. ' during rollback');
                return false;
            }
        }
        $statement = $this->aSQLStatements['table_copy'];
        $query  = sprintf($statement, $this->prefix.$table, $this->prefix.$table_bak);
        $result = $this->oSchema->db->exec($query);
        if ($this->_isPearError($result, 'error creating table during rollback'))
        {
            $this->_halt();
            return false;
        }
        if (!$this->_createAllIndexes($aDef_bak, $this->prefix.$table))
        {
            $this->_halt();
            return false;
        }

        // compare the original and the restored definitions
        $aRestoredDef = $this->_getDefinitionFromDatabase($table);
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
        $table_name = $this->prefix.$table_name;
        $result = $this->oSchema->db->manager->alterTable($table_name, $aTask['cargo'], false);
        if ($this->_isPearError($result, 'error restoring autoincrement field during rollback: '.$table_name.'.'.$field_name))
        {
            $this->_halt();
            return false;
        }
        return true;
    }

    /**
     * execute recovery
     *
     * @return boolean
     */
//    function doRecovery()
//    {
//        if (!empty($this->aRestoreTables))
//        {
//            $this->_log('NOW ATTEMPTING TO RESTORE BACKUP TABLES');
//            $this->oAuditor->setKeyParams(array('schema_name'=>$this->schema,
//                                          'version'=>$this->versionTo,
//                                          'timing'=>$this->timingInt
//                                         ));
//            if ($this->rollback())
//            {
//                $this->_log('ROLLBACK SUCCESSFUL');
//                return true;
//            }
//            else
//            {
//                $this->_logError('ROLLBACK FAILED');
//                return false;
//            }
//        }
//        $this->_log('No tables need restoring');
//        return true;
//    }

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
        $this->aDBTables = $this->_listTables();
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
            $this->_executeTasksIndexesRemove();
        }
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
                $table = $aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $this->prefix.$table, 'alter'));
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'beforeAddField');
                if ($this->_isPearError($result, "data migration error beforeAddField: {$this->prefix}{$table}{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$table))
                {
                    $this->_log('successfully altered table '.$this->prefix.$table);
                }
                else
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'afterAddField');
                if ($this->_isPearError($result, "data migration error afterAddField: {$table}.{$aTask['field']}"))
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
                $table = $aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $table, 'alter'));
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'beforeRemoveField');
                if ($this->_isPearError($result, "data migration error beforeRemoveField: {$this->prefix}{$table}{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$this->prefix.$table))
                {
                    $this->_log('successfully altered table '.$this->prefix.$table);
                }
                else
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'afterRemoveField');
                if ($this->_isPearError($result, "data migration error afterRemoveField: {$this->prefix}{$table}{$aTask['field']}"))
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
                $table = $aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $this->prefix.$table, 'alter'));
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'beforeAlterField');
                if ($this->_isPearError($result, "data migration error beforeAlterField: {$this->prefix}{$table}.{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$this->prefix.$table))
                {
                    $this->_log('successfully altered table '.$this->prefix.$table);
                }
                else
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'afterAlterField');
                if ($this->_isPearError($result, "data migration error afterAlterField: {$this->prefix}{$table}{$aTask['field']}"))
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
                $table = $aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $this->prefix.$table, 'alter'));
                $result = $this->_executeMigrationMethodField($table, $aTask['was'], 'beforeRenameField');
                if ($this->_isPearError($result, "data migration error beforeRenameField: {$aTask['name']}.{$aTask['was']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$this->prefix.$table))
                {
                    $this->_log('successfully altered table '.$this->prefix.$table);
                }
                else
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->_executeMigrationMethodField($table, $aTask['was'], 'afterRenameField');
                if ($this->_isPearError($result, "data migration error afterRenameField: {$this->prefix}{$table}{$aTask['was']}"))
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
                $table = $aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $this->prefix.$table, 'create'));

                if (!$this->_executeMigrationMethodTable($table, 'beforeAddTable'))
                {
                    $this->_halt();
                    return false;
                }
                else
                {
                    $result = $this->oTable->createTable($table);
                    if (($result) && (!$this->_isPearError($result, 'error creating table '.$this->prefix.$table)))
                    {
                        if (!$this->_executeMigrationMethodTable($table, 'afterAddTable'))
                        {
                            $this->_halt();
                            return false;
                        }
                        else
                        {
                            $this->_log('successfully created table '.$this->prefix.$table);
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

                if (!$this->_executeMigrationMethodTable($aTask['name'], 'beforeRenameTable'))
                {
                    $this->_halt();
                    return false;
                }
                else
                {
                    $result = $this->oSchema->db->exec($query);
                    if (!$this->_isPearError($result, 'error renaming table '.$tbl_old.' to '.$tbl_new))
                    {
                        if (!$this->_executeMigrationMethodTable($aTask['name'], 'afterRenameTable'))
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
                $table = $aTask['name'];
                $this->_log($this->_formatExecuteMsg($k,  $this->prefix.$table, 'remove'));
                if (!$this->_executeMigrationMethodTable($table, 'beforeRemoveTable'))
                {
                    $this->_halt();
                    return false;
                }
                else
                {
                    $query  = "DROP TABLE {$this->prefix}{$table}";
                    $result = $this->oSchema->db->exec($query);
                    if (!$this->_isPearError($result, 'error removing table '.$this->prefix.$table))
                    {
                        if (!$this->_executeMigrationMethodTable($table, 'afterRemoveTable'))
                        {
                            $this->_halt();
                            return false;
                        }
                        else
                        {
                            $this->_log('successfully removed table '.$this->prefix.$table);
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
                $result = $this->_createAllIndexes($aIndex_def, $this->prefix.$table);
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
                $primary = $aTask['primary'];
                $result = $this->oSchema->db->manager->dropConstraint($this->prefix.$table, $index, $primary);
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
     * verify and compile tasks of type 'add index'
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
                    $aDBIndexes     = $this->_listIndexes($this->prefix.$table);
                    $aDBConstraints = $this->_listConstraints($this->prefix.$table);
                    foreach ($aTable_tasks['indexes'] AS $index => $aIndex_tasks)
                    {
                        // if the index/constraint already exists on the table
                        if ( (in_array($index, $aDBIndexes) || in_array($index, $aDBConstraints) ) )
                        {
                            // and there is no task to remove it first
                            if (!array_key_exists('remove', $aIndex_tasks))
                            {
                                $this->_logError('index '.$index.' already exists in table '.$this->prefix.$table.' in database '.$this->oSchema->db->database_name);
                                $halt = true;
                            }
                        }
                        if (!$halt)
                        {
                            if (isset($aIndex_tasks['add']))
                            {
                                $method = $aIndex_tasks['add'];
                                $this->_log('task found: '.$method);
                                $this->aTaskList['indexes']['add'][] = $this->_compileTaskIndex('add', $table, $index);
                            }
                        }
                    }
                    if ($halt)
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
                    $aDBIndexes     = $this->_listIndexes($this->prefix.$table);
                    $aDBConstraints = $this->_listConstraints($this->prefix.$table);
                    foreach ($aTable_tasks['indexes'] AS $index => $aIndex_tasks)
                    {
                        if (in_array($index, $aDBIndexes) || in_array($index, $aDBConstraints))
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
        }
        return true;
    }

    /**
     * verify and compile tasks of type 'table alter'
     * add field, change field, remove field
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
                        $aDBFields = $this->_listTableFields($table);
                        foreach ($aTable_tasks['fields'] AS $field => $aField_tasks)
                        {
                            $this->_log('checking field: '.$this->prefix.$table.$field);
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
     * verify and compile tasks of type 'table remove'
     *
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
     * verify and compile tasks of type 'add table'
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
                         'name'=>$table,
                         'cargo'=>$aTableDef['fields']
                        );

        if (isset($aTableDef['indexes']))
        {
            foreach ($aTableDef['indexes'] AS $index_name=>$aIndex_def)
            {
                $aTable['indexes'][] = array(
                                                'table'=>$table,
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
        'name'=>$table,
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
        $aTableDef = $this->_getTableDefinition($this->aDefinitionNew, $table);
        switch($task)
        {
            case 'add':
                $result =   array(
                                 'table'=>$table,
                                 'name'=>$index_name,
                                 'cargo'=>array(
                                                'indexes'=>array(
                                                                 $index_name=>$aTableDef['indexes'][$index_name]
                                                                 )
                                               )
                                 );
                break;
                case'remove':
                $result =   array(
                                    'table'=>$table,
                                    'name'=>$index_name,
                                    'primary'=>$aTableDef['indexes'][$index_name]['primary']
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
                            'name'=>$table,
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

    /**
     * because MDB2_schema uses associative arrays to list index fields...
     * which don't take into account the field order...
     * the use of an 'order' key and sort method was suggested
     *
     * @param array $aIndex_def
     * @return boolean
     */
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
            $table_name = $table_name;
            $aDBIndexes = $this->_listIndexes($table_name);
            $aDBConstraints = $this->_listConstraints($table_name);
            foreach ($aDef['indexes'] as $index => $aIndex_def)
            {
                $aIndex_def = $this->_sortIndexFields($aIndex_def);
                if (array_key_exists('primary', $aIndex_def) || array_key_exists('unique', $aIndex_def))
                {
                    $primary = array_key_exists('primary', $aIndex_def);
                    if ($primary)
                    {
                        $index = $this->prefix.$index;
                    }
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
    function _doesConstraintExist($table_name, $index_name)
    {
        $aDBIndexes = $this->_listIndexes($table_name);
        $aDBConstraints = $this->_listConstraints($table_name);
        if (in_array($index_name, $aDBIndexes))
        {
            return true;
        }
        if (in_array($index_name, $aDBConstraints))
        {
            return true;
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
     * uses the conf table prefix to search only for tables from the openads schema
     *
     *
     * @param string : any additional (post-prefix) string to search for
     * @return array
     */
    function _listTableFields($table)
    {
        OA_DB::setCaseSensitive();
        $aDBFields = $this->oSchema->db->manager->listTableFields($this->prefix.$table);
        OA_DB::disableCaseSensitive();
        return $aDBFields;
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
     *
     *
     * @param string $table
     * @return boolean
     */
    function dropBackupTable($table, $logmsg = 'dropped')
    {
        if (!$this->dropTable($table))
        {
            return false;
        }
        $this->oAuditor->updateAuditBackupDroppedByName($table, $logmsg);
        return true;
    }

    /**
     * drop a given table
     *
     * @param string $table
     * @return boolean
     */
    function dropTable($table)
    {
        $this->aDBTables = $this->_listTables();
        if (in_array($this->prefix.$table, $this->aDBTables))
        {
            $result = $this->oTable->dropTable($this->prefix.$table);
        }
        else
        {
            $this->_logError('wanted to drop table '.$this->prefix.$table.' but it wasn\'t there');
            $result = false;
        }
        if (!$result)
        {
            $this->_logError('error dropping '.$this->prefix.$table);
            return false;
        }
        if ($this->_isPearError($result, 'error dropping '.$this->prefix.$table))
        {
            return false;
        }
        return true;
    }

    /**
     * retrieve a schema definition
     * from one table as specified in parameter
     * or from all tables with openads prefix
     * the definitions then have the openads prefix stripped from them
     * to make the definition generic and suitable for schema comparison
     *
     * @param string $table
     * @return boolean
     */
    function _getDefinitionFromDatabase($table=null)
    {
        $aParams = null;
        if ($table)
        {
            $aParams = array($this->prefix.$table);
        }
        else
        {
            $aParams = $this->_listTables();
        }
        $aDef = $this->oSchema->getDefinitionFromDatabase($aParams);
        if (!$this->_isPearError($aDef, 'error getting database definition'))
        {
            $aDef = $this->_stripPrefixesFromDatabaseDefinition($aDef);
        }
        return $aDef;
    }

    /**
     * remove openads prefixes from a definition array
     * these will commonly be found in table names and index names
     *
     * @param array $aDefinition
     * @return array
     */
    function _stripPrefixesFromDatabaseDefinition($aDefinition)
    {
        if ($this->prefix !== '')
        {
            foreach ($aDefinition['tables'] AS $tablename => $aDef)
            {
                if (substr($tablename, 0, strlen($this->prefix))==$this->prefix)
                {
                    $strippedname = substr($tablename, strlen($this->prefix), strlen($tablename));
                    if (isset($aDef['indexes']))
                    {
                        foreach ($aDef['indexes'] AS $indexname => $aIndex)
                        {
                            if (isset($aIndex['primary']))
                            {
                                $strippedidx = str_replace($this->prefix, '', $indexname);
                                $aDef['indexes'][$strippedidx] = $aIndex;
                                unset($aDef['indexes'][$indexname]);
                            }
                        }
                    }
                    $aTables[$strippedname] = $aDef;
                }
            }
            unset($aDefinition['tables']);
            $aDefinition['tables'] = $aTables;
        }
        return $aDefinition;
    }

}

?>