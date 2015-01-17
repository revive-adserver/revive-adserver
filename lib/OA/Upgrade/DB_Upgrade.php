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
* OpenX Schema Management Utility
*
*/

require_once MAX_PATH . '/lib/OA/DB/XmlCache.php';



class OA_DB_Upgrade
{
    var $schema;
    var $versionTo;

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
    function __construct($oLogger='')
    {
        //this->__construct();
        $this->path_changes = MAX_PATH.'/etc/changes/';

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
        $result  = MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
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
        $this->_logOnly('to version: '.$this->versionTo);
        $this->_logOnly('timing: '.$this->timingStr);

        // if only switching the timing
        // it should not be necessary to reparse the definitions
        if (!$switchTimingOnly)
        {
            $this->aDBTables = array();
            $this->aChanges = array();
            $this->aDefinitionNew = array();

            $this->file_schema  = "{$this->path_changes}schema_{$schema}_{$this->versionTo}.xml";
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
                $this->_logOnly('migration file found: '.$this->file_migrate);
                require_once($this->file_migrate);
                $classname = 'Migration_'.$this->versionTo;
                $this->oMigrator = new $classname();
                if ($this->oMigrator)
                {
                    $this->oMigrator->init($this->oSchema->db, $this->logFile);
                    $this->_logOnly('migration class '.$classname.' instantiated');
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

        $this->_logOnly('target database: '.$this->database);
        $this->_logOnly('table prefix: '.$this->prefix);

        $this->_logOnly('successfully initialised DB Upgrade');
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
        $this->_logOnly('schema file found: '.$this->file_schema);

        // Load definitions from cache
        $this->oTable->init($this->file_schema, true);

        $this->_logOnly('schema definition from cache '. ($this->oTable->cached_definition ? 'TRUE':'FALSE'));

        if (!is_array($this->oTable->aDefinition))
        {
            $this->_logError('problem with parsing schema definition');
            return false;
        }

        $this->aDefinitionNew = $this->oTable->aDefinition;
        $this->aDefinitionNew['prefixedTblNames'] = false; // we got this from the xml so it has no table prefixes
        $this->aDefinitionNew['prefixedIdxNames'] = false; // we got this from the xml so it has no index prefixes
        $this->aDefinitionNew['expandedIdxNames'] = true; // we got this from the xml, it has long index names ( + tablename + indexname)
        $this->_logOnly('successfully parsed the schema');
        $this->_logOnly('schema name: '.$this->aDefinitionNew['name']);
        $this->_logOnly('schema version: '.$this->aDefinitionNew['version']);
        $this->_logOnly('schema status: '.$this->aDefinitionNew['status']);
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
            $this->oLogger->logOnly('changeset definition from cache FALSE');
            $this->aChanges = $this->oSchema->parseChangesetDefinitionFile($this->file_changes);

            if ($this->_isPearError($this->aChanges, 'failed to parse changeset ('.$this->file_changes.')'))
            {
                return false;
            }
            // On-the fly cache writing disabled
            //$this->oCache->save($this->aChanges, $this->file_changes);
        }
        else
        {
            $this->oLogger->logOnly('changeset definition from cache TRUE');
        }

        $this->_logOnly('successfully parsed the changeset');
        $this->_logOnly('changeset name: '.$this->aChanges['name']);
        $this->_logOnly('changeset version: '.$this->aChanges['version']);
        $this->_logOnly('changeset comments: '.$this->aChanges['comments']);
        $this->_logOnly(($this->aDefinitionNew['version']==$this->aChanges['version'] ? 'schema and changeset versions match' : 'hmmm.. schema and changeset versions don\'t match'));
        $this->_logOnly(($this->aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found'));
        $this->_logOnly(($this->aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found'));
        return true;
    }

    function applySchemaDefinitionChanges($version)
    {
        if ($version == '049') {
            // We need to ensure that the XML index definition matches the actual name, which might be truncated
            foreach ($this->aDefinitionNew['tables'] as $tableName => &$aTable) {
                foreach ($aTable['indexes'] as $indexName => &$aIndex) {
                    $newIndexName = OA_phpAdsNew::phpPgAdsIndexToOpenads($indexName, $tableName, $this->prefix);
                    if (empty($aIndex['primary']) && $indexName != $newIndexName) {
                        $this->_logOnly('phppgads index detected, renaming '.$indexName.' to '.$newIndexName);
                        $aIndex['was'] = $newIndexName;
                        $this->aDefinitionNew['tables'][$tableName]['indexes'][$newIndexName] = $aIndex;
                        unset($this->aDefinitionNew['tables'][$tableName]['indexes'][$indexName]);
                    }
                }
            }
        }

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
            $this->_logOnly('acquiring script '.$file);
            require_once $file;
            $classname = $classprefix.'_'.$this->schema.'_'.$this->versionTo;
            if (class_exists($classname))
            {
                $this->_logOnly('instantiating class '.$classname);
                $this->$object = new $classname;
                $method = 'execute_'.$this->timingStr;
                if (is_callable(array($this->$object, $method)))
                {
                    $this->_logOnly('method is callable '.$method);
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

    function runPreScript($aParams=array())
    {
        $method = 'execute_'.$this->timingStr;
        array_unshift($aParams, $this);
        return call_user_func(array($this->oPreScript, $method), $aParams);
    }

    function prepPostScript($file)
    {
        return $this->_prepScript($file, 'postscript', 'oPostScript');
    }

    function runPostScript($aParams=array())
    {
        $method = 'execute_'.$this->timingStr;
        array_unshift($aParams, $this);
        return call_user_func(array($this->oPostScript, $method), $aParams);
    }

    /**
     * perform the necessary tasks to move a database schema
     * to a later version
     *
     * @return boolean
     */
    function upgrade($versionFrom='')
    {
        $this->_logOnly('verifying '.$this->timingStr.' changes');
        $result = $this->oSchema->verifyAlterDatabase($this->aChanges[$this->timingStr]);
        if (!$this->_isPearError($result, 'MDB2_SCHEMA verification failed'))
        {
            $this->aDBTables = $this->_listTables();
            $result = $this->_verifyTasks();
            if ($result)
            {
                $this->oAuditor->logAuditAction(array('info1'=>'UPGRADE STARTED',
                                                      'info2'=>$versionFrom,
                                                      'action'=>DB_UPGRADE_ACTION_UPGRADE_STARTED,
                                                     )
                                               );
                if ($this->_backup())
                {
                    if (!$this->_executeTasks())
                    {
                        $this->_logError('UPGRADE FAILED: '.$this->schema.'_'.$this->versionTo);
                        $this->oAuditor->logAuditAction(array('info1'=>'UPGRADE FAILED',
                                                              'info2'=>'',
                                                              'action'=>DB_UPGRADE_ACTION_UPGRADE_FAILED,
                                                             )
                                                       );
                       return false;
                    }
                    else
                    {
                        $this->_logOnly('UPGRADE SUCCEEDED');
                        $this->oAuditor->logAuditAction(array('info1'=>'UPGRADE SUCCEEDED',
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
            $this->oAuditor->logAuditAction(array('info1'=>'DESTRUCTIVE OUTSTANDING',
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
        $this->_logOnly('running integrity check');
        $this->_logOnly('comparing database '.$this->oSchema->db->connected_database_name.' with schema '.$this->file_schema);
        // compare the schema and implemented definitions
        $aDefinitionOld = $this->_getDefinitionFromDatabase();
        if ($this->_isPearError($aDefinitionOld, 'error getting database definition'))
        {
            return false;
        }
        $aDefinitionNew = $this->_stripPrefixesFromDatabaseDefinition($this->aDefinitionNew);
        OA_DB::setCaseSensitive();
        $aDiffs = $this->oSchema->compareDefinitions($aDefinitionNew, $aDefinitionOld);
        OA_DB::disableCaseSensitive();
        if ($this->_isPearError($aDiffs, 'error comparing definitions'))
        {
            return false;
        }
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
            foreach ($aChanges['constructive']['tables']['add'] AS $k => &$v)
            {
                $this->_logOnly('table is missing: '.$k);
            }
        }
        if (array_key_exists('change', $aChanges['constructive']['tables']))
        {
            foreach ($aChanges['constructive']['tables']['change'] AS $k => &$v)
            {
                // empty arrays should not exist
                if (count($v)>0)
                {
                    if (isset($v['add']))
                    {
                        foreach ($v['add']['fields'] AS $column => &$bool)
                        {
                            $this->_logOnly('column missing from table: '.$k.'.'.$column);
                        }
                    }
                    if (isset($v['change']))
                    {
                        $this->_logOnly('column definition does not match: '.$k.'.'.key($v['change']['fields']));
                    }
                    if (isset($v['indexes']))
                    {
                        if (isset($v['indexes']['add']))
                        {
                            foreach ($v['indexes']['add'] AS $index => $def)
                            {
                                $this->_logOnly('index missing from table: '.$k.'.'.$index);
                            }
                        }
                    }
                }
            }
        }
        if (array_key_exists('remove',$aChanges['destructive']['tables']))
        {
            foreach ($aChanges['destructive']['tables']['remove'] AS $k => &$v)
            {
                $this->_logOnly('table is not part of schema: '.$k);
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
	            $this->oAuditor->logAuditAction(array('info1'=>'BACKUP STARTED',
	                                                  'action'=>DB_UPGRADE_ACTION_BACKUP_STARTED,
	                                                 )
	                                           );

                // Create backup SQL functions if needed
                $result = OA_DB::createFunctions(true);
                if ($this->_isPearError($result, 'error creating backup SQL functions'))
                {
                    $this->_halt();
                    $this->oAuditor->logAuditAction(array('info1'=>'BACKUP FAILED',
                                                          'info2'=>'creating backup SQL functions',
                                                          'action'=>DB_UPGRADE_ACTION_BACKUP_FAILED,
                                                         )
                                                   );
                    return false;
                }

                // Backup tables
	            foreach ($aTables AS $k => &$table)
	            {
	                if (in_array($this->prefix.$table, $this->aDBTables))
	                {
	                    $string     = $this->versionTo.$this->timingStr.$this->database.$this->prefix.$table.OA::getNow();
	                    // Create the table name using a 64bit hex string (16 char)
	                    // Uniqueness is guaranteed using a second crc32 call with a
	                    // slightly modified string
	                    $table_bak  = sprintf('z_%08x%08x', crc32($string), crc32("@".$string));
	                    $this->aMessages[]  = "backing up table {$this->prefix}{$table} to table {$this->prefix}{$table_bak} ";

	                    $statement = $this->aSQLStatements['table_copy'];
	                    $query      = sprintf($statement, $this->prefix.$table_bak, $this->prefix.$table);
	                    $result     = $this->oSchema->db->exec($query);
	                    if ($this->_isPearError($result, 'error creating backup'))
	                    {
	                        $this->_halt();
	                        $this->oAuditor->logAuditAction(array('info1'=>'BACKUP FAILED',
	                                                              'info2'=>'creating backup table'.$table_bak,
	                                                              'action'=>DB_UPGRADE_ACTION_BACKUP_FAILED,
	                                                             )
	                                                       );
	                        return false;
	                    }
	                    $aDef = $this->_getDefinitionFromDatabase($table);
	                    $aBakDef = $aDef['tables'][$table];
//                      keeping the restore array alive is no longer necessary after refactored recovery
//	                    $this->aRestoreTables[$table] = array(
//	                                                          'bak'=>$table_bak,
//	                                                          'def'=>$aBakDef
//	                                                         );
	                    $this->oAuditor->logAuditAction(array('info1'=>'copied table',
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
	            $this->oAuditor->logAuditAction(array('info1'=>'BACKUP COMPLETE',
	                                                  'action'=>DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,
	                                                 )
	                                           );
	        }
	        else
	        {
	            $this->oAuditor->logAuditAction(array('info1'=>'BACKUP UNNECESSARY',
	                                                  'action'=>DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,
	                                                 )
	                                           );
	        }
	    }
        else
        {
            $this->oAuditor->logAuditAction(array('info1'=>'BACKUP IGNORED',
                                                  'action'=>DB_UPGRADE_ACTION_BACKUP_IGNORED,
                                                 )
                                           );
        }
        return true;
    }

    /**
     * for each schema:version:table:timing
     * restore the backup table
     * drop all tables that were added
     *
     * @return boolean
     */
    function rollback()
    {
        if (!(empty($this->aRestoreTables) && empty($this->aAddedTables)))
        {
            $this->aDBTables = $this->_listTables();
            if ($this->_isPearError($this->aDBTables, 'error listing tables during rollback'))
            {
                return false;
            }
            // restore backup tables
            if (!empty($this->aRestoreTables))
            {
                foreach ($this->aRestoreTables AS $schema => &$aVersions)
                {
                    $ok = krsort($aVersions, SORT_NUMERIC);
                    foreach ($aVersions AS $version => &$aTables)
                    {
                        foreach ($aTables AS $table => &$aTimings)
                        {
                            $ok = krsort($aTimings, SORT_NUMERIC);  // destructive first
                            foreach ($aTimings AS $timing => &$aTableRec)
                            {
                                $this->oAuditor->setKeyParams(array('schema_name'=>$aTableRec['schema_name'],
                                                                    'version'=>$aTableRec['version'],
                                                                    'timing'=>$aTableRec['timing'],
                                                                   )
                                                             );
                                if (in_array($this->prefix.$aTableRec['tablename_backup'], $this->aDBTables))
                                {
                                    $strSourceTable = "{$aTableRec['schema_name']}:{$aTableRec['version']}:{$this->prefix}{$table}";
                                    $dropfirst  = (in_array($this->prefix.$table, $this->aDBTables));
                                    $aBakDef    = unserialize($aTableRec['table_backup_schema']);
                                    $result = $this->_restoreFromBackup($table, $aTableRec['tablename_backup'], $aBakDef, $dropfirst);
                                    if (!$result)
                                    {
                                        $this->_logError("failed to restore backup table: {$this->prefix}{$aTableRec['tablename_backup']} => {$strSourceTable}");
                                        $this->_halt();
                                        $this->oAuditor->logAuditAction(array('info1'=>'ROLLBACK FAILED',
                                                                              'info2'=>'failed to restore table',
                                                                              'tablename'=>$table,
                                                                              'action'=>DB_UPGRADE_ACTION_ROLLBACK_FAILED,
                                                                             )
                                                                       );
                                        return false;
                                    }
                                    $this->_logOnly("backup table restored: {$this->prefix}{$aTableRec['tablename_backup']} => $strSourceTable");
                                    $this->oAuditor->logAuditAction(array('info1'=>'reverted table',
                                                                          'tablename'=>$table,
                                                                          'tablename_backup'=>$aTableRec['tablename_backup'],
                                                                          'action'=>DB_UPGRADE_ACTION_ROLLBACK_TABLE_RESTORED,
                                                                         )
                                                                   );
                                    if (!$this->dropBackupTable($aTableRec, 'dropped after successful restore'))
                                    {
                                        $this->_logError("failed to drop backup table {$this->prefix}{$aTableRec['tablename_backup']} after successfully restoring {$strSourceTable}");
                                    }
                                }
                                else
                                {
                                    $this->_halt();
                                    $this->_logError("backup table not found during rollback: {$this->prefix}{$aTableRec['tablename_backup']}");
                                    $this->oAuditor->logAuditAction(array('info1'=>'ROLLBACK FAILED',
                                                                          'info2'=>"backup table not found: {$aTableRec['tablename_backup']}",
                                                                          'action'=>DB_UPGRADE_ACTION_ROLLBACK_FAILED,
                                                                         )
                                                                   );
                                    return false;
                                }
                            }
                        }
                    }
                }
            }
            // drop added tables
            if (!empty($this->aAddedTables))
            {
                foreach ($this->aAddedTables AS $schema => &$aVersions)
                {
                    $ok = krsort($aVersions, SORT_NUMERIC);
                    foreach ($aVersions AS $version => &$aTables)
                    {
                        foreach ($aTables AS $table => &$aTableRec)
                        {
                            $this->oAuditor->setKeyParams(array('schema_name'=>$aTableRec['schema_name'],
                                                                'version'=>$aTableRec['version'],
                                                                'timing'=>$aTableRec['timing'],
                                                               )
                                                         );
                            if ($this->dropTable($table))
                            {
                                $this->_logOnly("table dropped: {$aTable['schema_name']}:{$aTableRec['version']}:{$this->prefix}{$table}");
                                $this->oAuditor->logAuditAction(array('info1'=>'dropped new table',
                                                                      'tablename'=>$table,
                                                                      'action'=>DB_UPGRADE_ACTION_ROLLBACK_TABLE_DROPPED,
                                                                     )
                                                               );
                            }
                            else
                            {
                                $this->_halt();
                                $this->_logError("failed to drop table: {$aTableRec['schema_name']}:{$aTableRec['version']}:{$this->prefix}{$table}");
                                $this->oAuditor->logAuditAction(array('info1'=>'ROLLBACK FAILED',
                                                                      'info2'=>"table not deleted: {$table}",
                                                                      'action'=>DB_UPGRADE_ACTION_ROLLBACK_FAILED,
                                                                     )
                                                               );
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
     * retrieve the actions from the upgrade audit tables
     * for a given upgrade_action_id
     * use these arrays to compile the arrays for restoring and dropping tables
     *
     * @param integer $id
     * @return boolean
     */
    function prepRollbackByAuditId($id, &$versionInitialSchema, &$schemaName)
    {

        $aResult = $this->oAuditor->queryAuditUpgradeStartedByUpgradeId($id);
        if ($this->_isPearError($aResult))
        {
            $this->_logError('failed to retrieve the details of the schema that was upgraded');
            $aResult[0]['schema_name'] = 'unkown';
            $aResult[1]['info2']       = 'unkown';
        }
        $schemaName = $aResult[0]['schema_name'];
        $versionInitialSchema = $aResult[0]['info2'];

        $this->aRestoreTables   = array();
        $this->aAddedTables     = array();

        $this->aDBTables = $this->_listTables();
        $aResult = $this->oAuditor->queryAuditBackupTablesByUpgradeId($id);
        if (!is_array($aResult))
        {
            return false;
        }
        foreach ($aResult as $k => &$aAction)
        {
            $this->aRestoreTables[$aAction['schema_name']][$aAction['version']][$aAction['tablename']][$aAction['timing']] = $aAction;
            $this->_logOnly("require backup table {$this->prefix}{$aAction['tablename_backup']} to restore {$aAction['schema']}:{$aAction['version']} table: {$this->prefix}{$aAction['tablename']}");
            if (in_array($this->prefix.$aAction['tablename_backup'], $this->aDBTables))
            {
                $this->_logOnly("backup table {$this->prefix}{$aAction['tablename_backup']} found in database");
            }
            else
            {
                $this->_logError("backup table {$this->prefix}{$aAction['tablename_backup']} not found in database");
                return false;
            }
        }

        $aResult = $this->oAuditor->queryAuditAddedTablesByUpgradeId($id);
        if (!is_array($aResult))
        {
            return false;
        }
        foreach ($aResult as $k => &$aAction)
        {
            if (in_array($this->prefix.$aAction['tablename'], $this->aDBTables))
            {
                $this->_logOnly("new table {$this->prefix}{$aAction['tablename']} found in database");
            }
            else
            {
                $this->_logOnly("new table {$this->prefix}{$aAction['tablename']} not found in database");
            }
            $this->aAddedTables[$aAction['schema_name']][$aAction['version']][$aAction['tablename']] = $aAction;
        }
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
            $result = $this->dropTable($table, true);
            if (!$result)
            {
                $this->_logError('dropping '.$this->prefix.$table. ' during rollback');
                return false;
            }
        }
//        if (!empty($this->aSQLStatements['table_move']))
//        {
//            $oTable = new OA_DB_Table();
//            $oTable->init(MAX_PATH.'/etc/tables_core.xml');
//            $oTable->aDefinition = array('tables' => array($table => $aDef_bak));
//            $result = $oTable->createTable($table);
//            if (!$result)
//            {
//                $this->_logError('creating empty table during rollback');
//                $this->_halt();
//                return false;
//            }
//            $statement = $this->aSQLStatements['table_move'];
//            $query  = sprintf($statement, $this->prefix.$table, $this->prefix.$table_bak);
//            $result = $this->oSchema->db->exec($query);
//            if ($this->_isPearError($result, 'error populating table during rollback'))
//            {
//                $this->_halt();
//                return false;
//            }
//        }
//        else
//        {
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
//        }

        // compare the original and the restored definitions
        $aRestoredDef = $this->_getDefinitionFromDatabase($table);
        $aPreviousDef = array('tables'=>array($table=>$aDef_bak));
        $aDiffs       = $this->oSchema->compareDefinitions($aPreviousDef, $aRestoredDef);
        // not expecting any diffs other than autoincrement property
        if (count($aDiffs)>0)
        {
            if ($aDiffs['tables']['change'][$table]['change'])
            {
                foreach ($aDiffs['tables']['change'][$table]['change'] AS $field_name => &$aFldDiff)
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
     * drop a given backup table
     *
     * @param string $table
     * @return boolean
     */
    function _dropBackup($table)
    {
        $this->_logOnly('dropping your backup: '.$table);

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
        $this->_logOnly('verifying/creating '.$this->timingStr.' tasklist');
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
        $this->_logOnly('executing '.$this->timingStr.' tasks');
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
            foreach ($this->aTaskList['fields']['add'] as $k => &$aTask)
            {
                $table = $aTask['name'];
                $this->_logOnly($this->_formatExecuteMsg($k,  $this->prefix.$table, 'alter'));
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'beforeAddField');
                if ($this->_isPearError($result, "data migration error beforeAddField: {$this->prefix}{$table}{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$table))
                {
                    $this->_logOnly('successfully altered table '.$this->prefix.$table);
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
            foreach ($this->aTaskList['fields']['remove'] as $k => &$aTask)
            {
                $table = $aTask['name'];
                $this->_logOnly($this->_formatExecuteMsg($k,  $table, 'alter'));
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'beforeRemoveField');
                if ($this->_isPearError($result, "data migration error beforeRemoveField: {$this->prefix}{$table}{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$this->prefix.$table))
                {
                    $this->_logOnly('successfully altered table '.$this->prefix.$table);
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

            foreach ($this->aTaskList['fields']['change'] as $k => &$aTask)
            {
                $table = $aTask['name'];
                $this->_logOnly($this->_formatExecuteMsg($k,  $this->prefix.$table, 'alter'));
                $result = $this->_executeMigrationMethodField($table, $aTask['field'], 'beforeAlterField');
                if ($this->_isPearError($result, "data migration error beforeAlterField: {$this->prefix}{$table}.{$aTask['field']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$this->prefix.$table))
                {
                    $this->_logOnly('successfully altered table '.$this->prefix.$table);
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

            foreach ($this->aTaskList['fields']['rename'] as $k => &$aTask)
            {
                $table = $aTask['name'];
                $this->_logOnly($this->_formatExecuteMsg($k,  $this->prefix.$table, 'alter'));
                $result = $this->_executeMigrationMethodField($table, $aTask['was'], 'beforeRenameField');
                if ($this->_isPearError($result, "data migration error beforeRenameField: {$aTask['name']}.{$aTask['was']}"))
                {
                    $this->_halt();
                    return false;
                }
                $result = $this->oSchema->db->manager->alterTable($this->prefix.$table, $aTask['cargo'], false);
                if (!$this->_isPearError($result, 'error altering table '.$this->prefix.$table))
                {
                    $this->_logOnly('successfully altered table '.$this->prefix.$table);
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
            foreach ($this->aTaskList['tables']['add'] as $k => &$aTask)
            {
                $table = $aTask['name'];
                $this->_logOnly($this->_formatExecuteMsg($k,  $this->prefix.$table, 'create'));

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
                        $this->oAuditor->logAuditAction(array('info1'=>'added new table',
                                                              'tablename'=>$table,
                                                              'action'=>DB_UPGRADE_ACTION_UPGRADE_TABLE_ADDED,
                                                             )
                                                       );
                        if (!$this->_executeMigrationMethodTable($table, 'afterAddTable'))
                        {
                            $this->_halt();
                            return false;
                        }
                        else
                        {
                            $this->_logOnly('successfully created table '.$this->prefix.$table);
                        }
                    }
                    else
                    {
                        $this->_logError('failed to create table '.$this->prefix.$table);
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
            foreach ($this->aTaskList['tables']['rename'] as $k => &$aTask)
            {
                $tbl_new = $this->prefix.$aTask['name'];
                $tbl_old = $this->prefix.$aTask['cargo']['was'];
                $this->_logOnly($this->_formatExecuteMsg($k,  $tbl_old, 'rename'));

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
                        $this->oAuditor->logAuditAction(array('info1'=>'renamed table',
                                                              'tablename'=>$aTask['name'],
                                                              'action'=>DB_UPGRADE_ACTION_UPGRADE_TABLE_ADDED,
                                                             )
                                                       );
                        if (!$this->_executeMigrationMethodTable($aTask['name'], 'afterRenameTable'))
                        {
                            $this->_halt();
                            return false;
                        }
                        else
                        {
                            $this->_logOnly('successfully renamed table '.$tbl_old.' to '.$tbl_new);
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
            foreach ($this->aTaskList['tables']['remove'] as $k => &$aTask)
            {
                $table = $aTask['name'];
                $this->_logOnly($this->_formatExecuteMsg($k,  $this->prefix.$table, 'remove'));
                if (!$this->_executeMigrationMethodTable($table, 'beforeRemoveTable'))
                {
                    $this->_halt();
                    return false;
                }
                else
                {
                    $this->oTable->dropTable($this->prefix.$table);
                    if (!$this->_isPearError($result, 'error removing table '.$this->prefix.$table))
                    {
                        if (!$this->_executeMigrationMethodTable($table, 'afterRemoveTable'))
                        {
                            $this->_halt();
                            return false;
                        }
                        else
                        {
                            $this->_logOnly('successfully removed table '.$this->prefix.$table);
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
            foreach ($this->aTaskList['indexes']['add'] as $k => &$aTask)
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
            foreach ($this->aTaskList['indexes']['remove'] as $k => &$aTask)
            {
                $table = $this->prefix.$aTask['table'];
                $indexOrig = $aTask['name'];
                $index = $this->oTable->_generateIndexName($table, $indexOrig);

                $aDBIndexes = $this->_listIndexes($table);
                $aDBConstraints = $this->_listConstraints($table);

                if (!empty($aTask['primary']))
                {
                    if (in_array($index, $aDBConstraints))
                    {
                        $result = $this->oSchema->db->manager->dropConstraint($table, $index, true);
                    }
                    elseif (in_array($indexOrig, $aDBConstraints))
                    {
                        // Ensure that the index is dropped even if it is not prefixed
                        $result = $this->oSchema->db->manager->dropConstraint($table, $indexOrig, true);
                    }
                }
                else
                {
                    if (in_array($index, $aDBIndexes))
                    {
                        $result = $this->oSchema->db->manager->dropIndex($table, $index);
                    }
                    elseif (in_array($index, $aDBConstraints))
                    {
                        $result = $this->oSchema->db->manager->dropConstraint($table, $index, false);
                    }
                    elseif (in_array($indexOrig, $aDBIndexes))
                    {
                        // Ensure that the index is dropped even if it is not prefixed
                        $result = $this->oSchema->db->manager->dropIndex($table, $indexOrig);
                    }
                    elseif (in_array($indexOrig, $aDBConstraints))
                    {
                        // Ensure that the index is dropped even if it is not prefixed
                        $result = $this->oSchema->db->manager->dropConstraint($table, $indexOrig, false);
                    }
                }
                if ($this->_isPearError($result, 'error dropping index '.$index))
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
            $result = call_user_func(array($this->oMigrator, $method));
            if (!$result)
            {
                $this->_logError('failure during migration: '.$method);
            }
            return $result;
        }
        $this->_logError('migration method not found: '.$method);
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
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => &$aTable_tasks)
            {
                if (isset($aTable_tasks['indexes']))
                {
                    $aDBIndexes     = $this->_listIndexes($this->prefix.$table);
                    $aDBConstraints = $this->_listConstraints($this->prefix.$table);
                    foreach ($aTable_tasks['indexes'] AS $index => &$aIndex_tasks)
                    {
                        // if the index/constraint already exists on the table
                        if ( (in_array($index, $aDBIndexes) || in_array($index, $aDBConstraints) ) )
                        {
                            // and there is no task to remove it first
                            if (!array_key_exists('remove', $aIndex_tasks))
                            {
                                $strippedIdx = preg_replace("/^{$table}_/", '', $index);
                                // Are we trying to add an index with the table prefix and remiving the one without it?
                                if ($strippedIdx == $index || !isset($aTable_tasks['indexes'][$strippedIdx]['remove'])) {
                                    $this->_logError('index '.$index.' already exists in table '.$this->prefix.$table.' in database '.$this->oSchema->db->database_name);
                                    $halt = true;
                                } elseif ($strippedIdx != $index) {
                                    $method = $aIndex_tasks['add'];
                                    $this->_logOnly('remove/add index with a prefix, skipped task: '.$method);
                                    continue;
                                }
                            }
                        }
                        if (!$halt)
                        {
                            if (isset($aIndex_tasks['add']))
                            {
                                $method = $aIndex_tasks['add'];
                                $this->_logOnly('task found: '.$method);
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
     * @todo Fix the primary key name
     *
     * @return boolean
     */
    function _verifyTasksIndexesRemove()
    {
        if (isset($this->aChanges['tasks'][$this->timingStr]['tables']))
        {
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => &$aTable_tasks)
            {
                if (isset($aTable_tasks['indexes']))
                {
                    $aDBIndexes     = $this->_listIndexes($this->prefix.$table);
                    $aDBConstraints = $this->_listConstraints($this->prefix.$table);
                    foreach ($aTable_tasks['indexes'] AS $index => &$aIndex_tasks)
                    {
                        // Matteo - todo fix primary key name
                        $indexName = $this->oTable->_generateIndexName($this->prefix.$table, $index);
                        if (in_array($indexName, $aDBIndexes) || in_array($indexName, $aDBConstraints))
                        {
                            if (isset($aIndex_tasks['remove']))
                            {
                                $strippedIdx = substr($indexName, strlen($this->prefix));
                                if ($strippedIdx != $index && isset($aTable_tasks['indexes'][$strippedIdx]['add'])) {
                                    $method = $aIndex_tasks['remove'];
                                    $this->_logOnly('remove/add index with a prefix, skipped task: '.$method);
                                } else {
                                    $method = $aIndex_tasks['remove'];
                                    $this->_logOnly('task found: '.$method);
                                    $this->aTaskList['indexes']['remove'][] = $this->_compileTaskIndex('remove', $table, $index);
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
     * verify and compile tasks of type 'table alter'
     * add field, change field, remove field
     *
     * @return boolean
     */
    function _verifyTasksTablesAlter()
    {
        if (isset($this->aChanges['tasks'][$this->timingStr]['tables']))
        {
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => &$aTable_tasks)
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
                        foreach ($aTable_tasks['fields'] AS $field => &$aField_tasks)
                        {
                            $this->_logOnly('checking field: '.$this->prefix.$table.' '.$field);
                            if (!in_array($field, $aDBFields))
                            {
                                if (array_key_exists('rename', $aField_tasks))
                                {
                                    $method -= $aField_tasks['rename'];
                                    $this->_logOnly('task found: '.$method);
                                    $was = $this->_getPreviousFieldname($table, $field);
                                    if ($was)
                                    {
                                        $this->_logOnly('found that this field : '.$table.'.'.$field.' was called: '.$table.'.'.$was);
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
                                    $this->_logOnly('task found: '.$method);
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
                                $this->_logOnly('found field '.$field);
                                foreach ($aField_tasks AS $task => &$method)
                                {
                                    if ($task != 'rename')
                                    {
                                        $this->aTaskList['fields'][$task][] = $this->_compileTaskField($task, $table, $field, $field);
//                                        $this->_logOnly(print_r($this->oSchema->db->reverse->getTableFieldDefinition($this->prefix.$table, $field), true));
//                                        $this->_logOnly(print_r($this->aTaskList['fields'][$task][count($this->aTaskList['fields'][$task]) - 1], true));
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
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => &$aTable_tasks)
            {
                if (isset($aTable_tasks['self']))
                {
                    foreach ($aTable_tasks['self'] AS $task => &$method)
                    {
                        if ($task == 'remove')
                        {
                            $this->_logOnly('task found: '.$method);
                            if (in_array($this->prefix.$table, $this->aDBTables))
                            {
                                $this->_logOnly('found table in database: '.$this->prefix.$table);
                                $this->aTaskList['tables']['remove'][] = $this->_compileTaskTable($task, $table);
                            }
                            else
                            {echo "{$table} not found<br />";
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
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => &$aTable_tasks)
            {
                if (isset($aTable_tasks['self']))
                {
                    foreach ($aTable_tasks['self'] AS $task => &$method)
                    {
                        if ($task == 'rename')
                        {
                            $this->_logOnly('task found: '.$method);
                            $table_was = $this->_getPreviousTablename($table);
                            if ($table_was)
                            {
                                if (in_array($this->prefix.$table_was, $this->aDBTables))
                                {
                                    $this->_logOnly('found that this table : '.$table.' was called: '.$table_was);
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
            foreach ($this->aChanges['tasks'][$this->timingStr]['tables'] AS $table => &$aTable_tasks)
            {
                if (isset($aTable_tasks['self']))
                {
                    foreach ($aTable_tasks['self'] AS $task => &$method)
                    {
                        if ($task == 'add')
                        {
                            $this->_logOnly('task found: '.$method);
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
            foreach ($aTableDef['indexes'] AS $index_name=>&$aIndex_def)
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
                                    'primary'=>(strpos($index_name,'_pkey')>0 ? true : false)  //$aTableDef['indexes'][$index_name]['primary']
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
            foreach ($aIndex_def['fields'] as $field => &$aDef)
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
            foreach ($aIdx_sort as $k => &$field)
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
                        $indexOrig = '';
                    }
                    else
                    {
                        $indexOrig = $index;
                        $index = $this->oTable->_generateIndexName($table_name, $index);
                    }
                    if (in_array($index, $aDBConstraints))
                    {
                        $result = $this->oSchema->db->manager->dropConstraint($table_name, $index, $primary);
                    }
                    elseif (in_array($indexOrig, $aDBConstraints))
                    {
                        // Ensure that the index is dropped even if it is not prefixed
                        $result = $this->oSchema->db->manager->dropConstraint($table_name, $indexOrig, $primary);
                    }
                    $result = $this->oSchema->db->manager->createConstraint($table_name, $index, $aIndex_def);
                }
                else
                {
                    $indexOrig = $index;
                    $index = $this->oTable->_generateIndexName($table_name, $index);
                    if (in_array($index, $aDBIndexes))
                    {
                        $result = $this->oSchema->db->manager->dropIndex($table_name, $index);
                    }
                    elseif (in_array($indexOrig, $aDBIndexes))
                    {
                        // Ensure that the index is dropped even if it is not prefixed
                        $result = $this->oSchema->db->manager->dropIndex($table_name, $indexOrig);
                    }
                    $result = $this->oSchema->db->manager->createIndex($table_name, $index, $aIndex_def);
                }
                if (!$this->_isPearError($result, "error creating index {$index} on table {$table_name}"))
                {
                    $this->_logOnly("success creating index {$index} on table {$table_name}");
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
                $this->aSQLStatements['table_move']     = "";
                $this->aSQLStatements['table_rename']   = "RENAME TABLE %s TO %s";
                break;
            case 'pgsql':
                // Defaults disabled, they give issues with sequence dependencies
                //$this->aSQLStatements['table_copy']     = 'CREATE TABLE "%1$s" (LIKE "%2$s"); INSERT INTO "%1$s" SELECT * FROM "%2$s"';
                $this->aSQLStatements['table_copy']     = "SELECT oxp_backup_table_copy('%s', '%s')";
                $this->aSQLStatements['table_move']     = 'INSERT INTO "%s" SELECT * FROM "%s"';
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
        return OA_DB_Table::listOATablesCaseSensitive($prefix);
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
        OA_DB::setCaseSensitive();
        $aResult = $this->oSchema->db->manager->listTableConstraints($table_name);
        OA_DB::disableCaseSensitive();
        return $aResult;
    }

    function _listIndexes($table_name)
    {
        OA_DB::setCaseSensitive();
        $aResult = $this->oSchema->db->manager->listTableIndexes($table_name);
        OA_DB::disableCaseSensitive();
        return $aResult;
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

    function _logOnly($message)
    {
        if ($this->oLogger)
        {
            $this->oLogger->logOnly($message);
        }
        else
        {
            $this->aMessages[] = $message;
            $this->_logWrite($message);
        }
    }

    function _logWarning($message)
    {
        if ($this->oLogger)
        {
            $this->oLogger->logWarning($message);
        }
        else
        {
            $this->aMessages[] = $message;
            $this->_logWrite("WARNING: {$message}");
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
     * @param string $table
     * @return boolean
     */
    function dropBackupTableByName($table, $logmsg = 'dropped')
    {
        if (!$this->dropTable($table))
        {
            return false;
        }
        $this->oAuditor->updateAuditBackupDroppedByName($table, $logmsg);
        return true;
    }

    /**
     * @param string $table
     * @return boolean
     */
    function dropBackupTable($aTable, $logmsg = 'dropped')
    {
        if (!$this->dropTable($aTable['tablename_backup']))
        {
            return false;
        }
        $this->oAuditor->updateAuditBackupDroppedById($aTable['database_action_id'], $logmsg);
        return true;
    }

    /**
     * drop a given table
     *
     * @param string $table
     * @return boolean
     */
    function dropTable($table, $critical=false)
    {
        $this->aDBTables = $this->_listTables();
        if ($critical && (!in_array($this->prefix.$table, $this->aDBTables)))
        {
            $this->_logError('wanted to drop table '.$this->prefix.$table.' but it wasn\'t there');
            return false;
        }
        $result = $this->oTable->dropTable($this->prefix.$table);
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
        OA_DB::setCaseSensitive();

        $aDef = $this->oSchema->getDefinitionFromDatabase($aParams);
        OA_DB::disableCaseSensitive();
        if ($this->_isPearError($aDef, 'error getting database definition'))
        {
            return array();
        }
        $aDef['prefixedTblNames'] = true; // we got this from the db so it has table prefixes
        $aDef['prefixedIdxNames'] = true; // we got this from the db so it has index prefixes
        $aDef['expandedIdxNames'] = true; // we got this from the db so it has long index names ( + tablename + indexname)
        return $this->_stripPrefixesFromDatabaseDefinition($aDef);
    }

    /**
     * remove openads prefixes from a definition array
     * these will commonly be found in table names and index names
     *
     * @param array $aDefinition
     * @return array
     */
    /**
     * remove openads prefixes from a definition array
     * these will commonly be found in table names and index names
     *
     * @param array $aDefinition
     * @return array
     */
    function _stripPrefixesFromDatabaseDefinition($aDefinition)
    {
        $prefix = strtolower($this->prefix);
        $aTables = array();
        $isPrefixedTable = ((!empty($prefix)) && isset($aDefinition['tables'][$prefix.'users']));
        $isPrefixedIndex = ((!empty($prefix)) && isset($aDefinition['tables'][$prefix.'users']['indexes'][$prefix.'users_username']));
        foreach ($aDefinition['tables'] AS $tablename => &$aDef)
        {
            $strippedname = strtolower($tablename);
            if ($aDefinition['prefixedTblNames'])
            {
                $strippedname = preg_replace("/^{$prefix}/", '', $strippedname, 1);
            }
            if (isset($aDef['indexes']))
            {
                foreach ($aDef['indexes'] AS $indexname => $aIndex)
                {
                    $strippedidx = strtolower($indexname);
                    $iOffset = 63 - strlen($prefix);
                    if ($aDefinition['prefixedIdxNames'])
                    {
                        $strippedidx = preg_replace("/^{$prefix}/", '', $strippedidx, 1);
                    }
                    if (!isset($aIndex['primary']))
                    {
                        $iOffset-= 1;
                        if ($aDefinition['expandedIdxNames'])
                        {
                            $strippedidx = preg_replace("/^{$strippedname}_/", '', $strippedidx, 1);
                            $iOffset-= strlen($strippedname) ;
                        }
                    }
                    $strippedidx = substr($strippedidx, 0, $iOffset);
                    if ($strippedidx != $indexname)
                    {
                        if (isset($aIndex['was'])) {
                            $aIndex['was'] = $strippedidx;
                        }
                        $aDef['indexes'][$strippedidx] = $aIndex;
                        unset($aDef['indexes'][$indexname]);
                    }
                }
            }
            $aTables[$strippedname] = $aDef;
        }
        unset($aDefinition['tables']);
        $aDefinition['tables'] = $aTables;
        return $aDefinition;
    }

    function checkPotentialUpgradeProblems()
    {
        $tableName = $GLOBALS['_MAX']['CONF']['table']['prefix'].'campaigns';

        $query = "
            SELECT
                campaignid,
                revenue_type
            FROM
                ".$this->oSchema->db->quoteIdentifier($tableName)."
            WHERE
                (revenue_type = ".MAX_FINANCE_CPM." AND (clicks > 0 OR conversions > 0)) OR
                (revenue_type = ".MAX_FINANCE_CPC." AND conversions  > 0)
            ORDER BY
                campaignid
        ";

        OX::disableErrorHandling();
        $aResult = $this->oSchema->db->queryAll($query);
        OX::enableErrorHandling();

        if (!PEAR::isError($aResult) && count($aResult) > 0) {
            $warning = false;
            foreach ($aResult as $row) {
                if ($v['revenue_type'] == MAX_FINANCE_CPM) {
                    $type = 'CPM';
                    $what = 'clicks and/or conversions';
                } else {
                    $type = 'CPC';
                    $what = 'conversions';
                }

                $message = "campaign [id{$row['campaignid']}] is {$type} but has booked {$what} set";

                if (!$warning) {
                    $warning = "Warning: the revenue type of some campaigns doesn't match the campaign targets. For example, {$message}. Check the install.log for the detailed campaign list.";
                    $this->_logWarning($warning);
                }

                $this->_logOnly('Revenue type mismatch: '.$message);
            }
        }

        return true;
    }

}

?>
