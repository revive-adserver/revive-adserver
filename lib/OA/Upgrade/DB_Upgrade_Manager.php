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
 * $Id$
 *
 */

define('DB_UPGRADE_TIMING_CONSTRUCTIVE_DEFAULT',                   0);
define('DB_UPGRADE_TIMING_DESTRUCTIVE_DEFAULT',                    1);

define('DB_UPGRADE_ACTION_UPGRADE_STARTED',                        10);
define('DB_UPGRADE_ACTION_BACKUP_STARTED',                         20);
define('DB_UPGRADE_ACTION_BACKUP_TABLE',                           30);
define('DB_UPGRADE_ACTION_BACKUP_SUCCEEDED',                       40);
define('DB_UPGRADE_ACTION_BACKUP_FAILED',                          50);
define('DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED',                      60);
define('DB_UPGRADE_ACTION_UPGRADE_FAILED',                         70);
define('DB_UPGRADE_ACTION_ROLLBACK_STARTED',                       80);
define('DB_UPGRADE_ACTION_ROLLBACK_TABLE',                         90);
define('DB_UPGRADE_ACTION_ROLLBACK_SUCCEEDED',                     100);
define('DB_UPGRADE_ACTION_ROLLBACK_FAILED',                        110);
define('DB_UPGRADE_ACTION_OUTSTANDING_UPGRADE',                    120);
define('DB_UPGRADE_ACTION_IGNORE_OUTSTANDING_UPGRADE_UNTIL',       130);
define('DB_UPGRADE_ACTION_IGNORE_OUTSTANDING_UPGRADE',             140);
define('DB_UPGRADE_ACTION_OUTSTANDING_DROP_BACKUP',                150);
define('DB_UPGRADE_ACTION_IGNORE_OUTSTANDING_DROP_BACKUP_UNTIL',   160);
define('DB_UPGRADE_ACTION_IGNORE_OUTSTANDING_DROP_BACKUP',         170);


class OA_DB_Upgrade_Manager
{
    var $path_changes;
    var $schema;

    var $oSchema;
    var $aChangesetList;
    var $aChanges;

    var $aErrors    = array();
    var $aMessages  = array();
    var $logFile;

    var $prefix     = '';
    var $logTable   = 'database_action';

    //var $aSQLStatements = array();

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
     * @param string $schema : 'tables_core'...
     * @return boolean
     */
    function OA_DB_Upgrade_Manager($schema)
    {
        //this->__construct();

        $result  = & MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
        if (!$this->_isPearError($result, 'failed to instantiate MDB2_Schema'))
        {
            $this->oSchema      = $result;
            $this->path_changes = MAX_PATH.'/etc/changes/';
            $this->schema       = $schema;
            $this->logFile      = MAX_PATH . "/var/dbu_manager.log";
        }
        else
        {
            return false;
        }
    }

    /**
     * Open each changeset and determine the version and timings
     *
     * @return boolean
     */
    function _compileChangesetInfo()
    {
        $this->aChangesetList = $this->_getChangesetList();
        foreach ($this->aChangesetList as $version=>$aFiles)
        {
            $file       = MAX_PATH.'/etc/changes/'.$aFiles['changeset'];
            $aChanges   = $this->oSchema->parseChangesetDefinitionFile($file);
            if (!$this->_isPearError($aChanges, "failed to parse changeset ({$file})"))
            {
                $this->_log('changeset found in file: '.$file);
                $this->_log('name: '.$aChanges['name']);
                $this->_log('version: '.$aChanges['version']);
                $this->_log('comments: '.$aChanges['comments']);
                $this->_log(($aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found'));
                $this->_log(($aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found'));
            }
            else
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Open each changeset and determine the version and timings
     *
     * @return boolean
     */
    function _checkChangesetAudit()
    {
        $this->aChangesetList = $this->_getChangesetList();
        foreach ($this->aChangesetList as $version=>$aFiles)
        {
            $aResult = $this->_queryLogTable($version, '', $this->schema, DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED);
            $aResult = $aResult[0];
            $this->_log($aResult['schema_name'].' upgraded to version '.$aResult['version'].' on '.$aResult['updated']);
        }
        return true;
    }

    /**
     * compile a list of changesets
     *
     * @return array
     */
    function _getChangesetList()
    {
        $aFiles = array();
        $dh = opendir(MAX_PATH.'/etc/changes');
        if ($dh) {
            while (false !== ($file = readdir($dh)))
            {
                $aMatches = array();
                if (preg_match("/schema_{$this->schema}_([\d])+\.xml/", $file, $aMatches))
                {
                    $version = $aMatches[1];
                    $fileSchema = basename($file);
                    $aFiles[$version] = array();
                    $fileChanges = str_replace('schema', 'changes', $fileSchema);
                    $fileMigrate = str_replace('schema', 'migration', $fileSchema);
                    $fileMigrate = str_replace('xml', 'php', $fileMigrate);
                    if (!file_exists(MAX_CHG.$fileChanges))
                    {
                        $fileChanges = 'not found';
                    }
                    $aFiles[$version]['changeset'] = $fileChanges;
                    if (!file_exists(MAX_CHG.$fileMigrate))
                    {
                        $fileMigrate = 'not found';
                    }
                    $aFiles[$version]['migration'] = $fileMigrate;
                    $aFiles[$version]['schema'] = $fileSchema;
                }
            }
        }
        closedir($dh);
        return $aFiles;
    }

    // misc methods

    /**
     * audit actions taken
     *
     * @param integer $action
     * @param string $info1
     * @param string $info2
     * @return boolean
     */
    function _logDatabaseAction($action, $aParams=array())
    {
        $this->_log('_logDatabaseAction start');

        $aParams['schema']    = $this->schema;
        $aParams['version']   = $this->versionTo;
        $aParams['timing']    = $this->timingInt;
        $aParams['action']    = $action;

        foreach ($aParams AS $k => $v)
        {
            $this->_log($k.' : '.$v);
            $aParams[$k] = $this->oSchema->db->escape($v);
        }
        $this->_log('_logDatabaseAction end');
        $columns = implode(",", array_keys($aParams));
        $values  = implode("','", array_values($aParams));

        $query = "INSERT INTO {$this->prefix}{$this->logTable} ({$columns}, updated) VALUES ('{$values}', NOW())";

        $result = $this->oSchema->db->exec($query);

        if ($this->_isPearError($result, "error updating {$this->prefix}{$this->logTables}"))
        {
            return false;
        }
        return true;
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
     * write a message to the logfile
     *
     * @param string $message
     */
    function _log($message)
    {
        $this->aMessages[] = $message;
        $this->_logWrite($message);
    }

    /**
     * write an error to the log file
     *
     * @param string $message
     */
    function _logError($message)
    {
        $this->aErrors[] = $message;
        $this->_logWrite("ERROR: {$message}");
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

    function _queryAllLogTable()
    {
        $query = "SELECT * FROM {$this->prefix}{$this->logTable}";
        $aResult = $this->oSchema->db->queryAll($query);
        if ($this->_isPearError($aResult, "error querying (all) database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function _queryLogTable($version, $timing='', $schema='tables_core', $action='')
    {
        $query =   "SELECT * FROM {$this->prefix}{$this->logTable}"
                   ." WHERE schema_name ='{$schema}'"
                   ." AND version ={$version}";
        if ($timing)
        {
            $query.= " AND timing ={$timing}";
        }
        if ($action)
        {
            $query.= " AND action ={$action}";
        }
        $aResult = $this->oSchema->db->queryAll($query);
        if ($this->_isPearError($aResult, "error querying (one) database audit table"))
        {
            return false;
        }
        return $aResult;
    }

}

?>