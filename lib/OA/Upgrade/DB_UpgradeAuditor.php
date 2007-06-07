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

define('DB_UPGRADE_TIMING_CONSTRUCTIVE_DEFAULT',                   0);
define('DB_UPGRADE_TIMING_DESTRUCTIVE_DEFAULT',                    1);

define('DB_UPGRADE_ACTION_UPGRADE_STARTED',                        10);
define('DB_UPGRADE_ACTION_BACKUP_STARTED',                         20);
define('DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED',                    30);
define('DB_UPGRADE_ACTION_BACKUP_SUCCEEDED',                       40);
define('DB_UPGRADE_ACTION_BACKUP_FAILED',                          50);
define('DB_UPGRADE_ACTION_UPGRADE_TABLE_ADDED',                    59);
define('DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED',                      60);
define('DB_UPGRADE_ACTION_UPGRADE_FAILED',                         70);
define('DB_UPGRADE_ACTION_ROLLBACK_STARTED',                       80);
define('DB_UPGRADE_ACTION_ROLLBACK_TABLE_RESTORED',                90);
define('DB_UPGRADE_ACTION_ROLLBACK_TABLE_DROPPED',                 91);
define('DB_UPGRADE_ACTION_ROLLBACK_SUCCEEDED',                     100);
define('DB_UPGRADE_ACTION_ROLLBACK_FAILED',                        110);
define('DB_UPGRADE_ACTION_OUTSTANDING_UPGRADE',                    120);
define('DB_UPGRADE_ACTION_IGNORE_OUTSTANDING_UPGRADE_UNTIL',       130);
define('DB_UPGRADE_ACTION_IGNORE_OUTSTANDING_UPGRADE',             140);
define('DB_UPGRADE_ACTION_OUTSTANDING_DROP_BACKUP',                150);
define('DB_UPGRADE_ACTION_IGNORE_OUTSTANDING_DROP_BACKUP_UNTIL',   160);
define('DB_UPGRADE_ACTION_IGNORE_OUTSTANDING_DROP_BACKUP',         170);

require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_PATH.'/lib/OA/DB/Table.php';

class OA_DB_UpgradeAuditor
{
    var $oLogger;
    var $oDbh;

    var $logTable   = 'database_action';

    var $prefix = '';

    var $aParams = array();

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
    function OA_DB_UpgradeAuditor()
    {
        //this->__construct();
    }

    function init(&$oDbh, $oLogger='')
    {
        $this->oDbh = $oDbh;
        $this->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        // so that this class can log to the caller's log
        // and write it's own log if necessary (testing)
        if ($oLogger)
        {
            $this->oLogger= $oLogger;
        }
        return $this->_checkCreateAuditTable();
    }

    function setKeyParams($aParams='')
    {
        $this->aParams = $this->_escapeParams($aParams);
    }

    /**
     * audit actions taken
     *
     * @param integer $action
     * @param string $info1
     * @param string $info2
     * @return boolean
     */
    function logDatabaseAction($aParams=array())
    {
        $aParams = $this->_escapeParams($aParams);
        $columns = implode(",", array_keys($this->aParams)).','.implode(",", array_keys($aParams));
        $values  = implode(",", array_values($this->aParams)).','.implode(",", array_values($aParams));

        $query = "INSERT INTO {$this->prefix}{$this->logTable} ({$columns}, updated) VALUES ({$values}, '". OA::getNow() ."')";
        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error updating {$this->prefix}{$this->logTable}"))
        {
            return false;
        }
        return true;
    }

    function _escapeParams($aParams)
    {
        foreach ($aParams AS $k => $v)
        {
            $aParams[$k] = $this->oDbh->quote($v);
        }
        return $aParams;
    }

    /**
     * the database_action table must exist for all upgrade events
     * currently the schema is stored in a separate xml file which is not part of an upgrade pkg
     * eventually this table schema should be merged into the core tables schema
     *
     * @return boolean
     */
    function _createAuditTable()
    {
        $xmlfile = MAX_PATH.'/etc/database_action.xml';

        $oTable = new OA_DB_Table();
        $oTable->init($xmlfile);
        return $oTable->createTable($this->logTable);
    }

    function _checkCreateAuditTable()
    {
        $this->aDBTables = $this->oDbh->manager->listTables();
        if (!in_array($this->prefix.$this->logTable, $this->aDBTables))
        {
            $this->log('creating database_action audit table');
            if (!$this->_createAuditTable())
            {
                $this->logError('failed to create database_action audit table');
                return false;
            }
            $this->log('successfully created database_action audit table');
        }
        return true;
    }

    /**
     * write a message to the logfile
     *
     * @param string $message
     */
    function log($message)
    {
        if ($this->oLogger)
        {
            $this->oLogger->log($message);
        }
    }

    /**
     * write an error to the log file
     *
     * @param string $message
     */
    function logError($message)
    {
        if ($this->oLogger)
        {
            $this->oLogger->logError($message);
        }
    }

    function isPearError($message)
    {
        if ($this->oLogger)
        {
            return $this->oLogger->isPearError($message);
        }
        return false;
    }

    function queryAuditAll()
    {
        $query = "SELECT * FROM {$this->prefix}{$this->logTable}";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAudit($version='', $timing=null, $schema='tables_core', $action=null)
    {
        $query =   "SELECT * FROM {$this->prefix}{$this->logTable}"
                   ." WHERE schema_name ='{$schema}'";
        if ($version)
        {
            $query.= " AND version ={$version}";
        }
        if (!is_null($timing))
        {
            $query.= " AND timing ={$timing}";
        }
        if (!is_null($action))
        {
            $query.= " AND action ={$action}";
        }
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying (one) database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditForABackup($name)
    {
        $query = "SELECT * FROM {$this->prefix}{$this->logTable} WHERE tablename_backup = '{$name}'";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function updateAuditBackupDropped($tablename_backup, $reason = '')
    {
        $query = "UPDATE {$this->prefix}{$this->logTable} SET tablename_backup='dropped {$reason}', updated='". OA::getNow() ."' WHERE tablename_backup='{$tablename_backup}'";

        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error updating {$this->prefix}{$this->logTables}"))
        {
            return false;
        }
        return true;
    }

    /**
     * retrieve an array of table names from currently connected database
     *
     * @return array
     */
    function _listBackups()
    {
        $aResult = array();
        $prefix = $this->prefix.'z_';
        OA_DB::setCaseSensitive();
        $aBakTables = $this->oDbh->manager->listTables(null, $prefix);
        OA_DB::disableCaseSensitive();

        $prelen = strlen($prefix);
        krsort($aBakTables);
        foreach ($aBakTables AS $k => $name)
        {
            // workaround for mdb2 problem "show table like"
            if (substr($name,0,$prelen)==$prefix)
            {
                $name = str_replace($this->prefix, '', $name);
                $aInfo = $this->queryAuditForABackup($name);
                $aResult[$k]['backup_table'] = $name;
                $aResult[$k]['copied_table'] = $aInfo[0]['tablename'];
                $aResult[$k]['copied_date']  = $aInfo[0]['updated'];
                $aStatus = $this->getTableStatus($name);
                $aResult[$k]['data_length'] = $aStatus[0]['data_length']/1024;
                $aResult[$k]['rows'] = $aStatus[0]['rows'];
            }
        }
        return $aResult;
    }

    function getTableStatus($table)
    {
        $query      = "SHOW TABLE STATUS LIKE '{$this->prefix}{$table}'";
        $result     = $this->oDbh->queryAll($query);
        if (PEAR::isError($result))
        {
            return array();
        }
        return $result;
    }


}

?>