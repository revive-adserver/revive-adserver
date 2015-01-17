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

define('DB_UPGRADE_TIMING_CONSTRUCTIVE_DEFAULT',                   0);
define('DB_UPGRADE_TIMING_DESTRUCTIVE_DEFAULT',                    1);

define('DB_UPGRADE_ACTION_UPGRADE_STARTED',                        10);
define('DB_UPGRADE_ACTION_BACKUP_STARTED',                         20);
define('DB_UPGRADE_ACTION_BACKUP_IGNORED',                         21);
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
require_once MAX_PATH.'/lib/OA/Upgrade/BaseUpgradeAuditor.php';


class OA_DB_UpgradeAuditor extends OA_BaseUpgradeAuditor
{
    var $oLogger;
    var $oDbh;

    var $logTable   = 'database_action';
    var $action_table_xml_filename   = '/etc/database_action.xml';

    var $auditId;

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
    function __construct()
    {
    	parent::__construct();
        //this->__construct();
    }

    function setKeyParams($aParams='')
    {
        $aParams['upgrade_action_id'] = $this->auditId;
		parent::setKeyParams($aParams);
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
        $table = $this->getLogTableName();
        $query = "SELECT * FROM {$table}";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditByUpgradeId($id)
    {
        $table = $this->getLogTableName();
        $query = "SELECT * FROM {$table} WHERE upgrade_action_id = " . (int) $id;
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditBackupTablesByUpgradeId($id)
    {
        $table = $this->getLogTableName();
        $query = "SELECT * FROM {$table} WHERE upgrade_action_id = " . (int) $id
                 ." AND action =".DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED
                 ." AND info2 IS NULL"
                 ." ORDER BY database_action_id DESC";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditAddedTablesByUpgradeId($id)
    {
        $table = $this->getLogTableName();
        $query = "SELECT * FROM {$table} WHERE upgrade_action_id = " . (int) $id
                 ." AND action =".DB_UPGRADE_ACTION_UPGRADE_TABLE_ADDED
                 ." AND info2 IS NULL";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditUpgradeStartedByUpgradeId($id)
    {
        $table = $this->getLogTableName();
        $query = "SELECT * FROM {$table} WHERE upgrade_action_id = " . (int) $id
                 ." AND action =".DB_UPGRADE_ACTION_UPGRADE_STARTED.' LIMIT 1';
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditByDBUpgradeId($id)
    {
        $table = $this->getLogTableName();
        $query = "SELECT * FROM {$table} WHERE database_action_id = " . (int) $id;
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAudit($version='', $timing=null, $schema='tables_core', $action=null)
    {
        $table = $this->getLogTableName();
        $query =   "SELECT * FROM {$table}"
                   ." WHERE schema_name ='" . $this->oDbh->escape($schema) . "'";
        if ($version)
        {
            $query.= " AND version = " . $this->oDbh->escape($version);
        }
        if (!is_null($timing))
        {
            $query.= " AND timing = " . $this->oDbh->escape($timing);
        }
        if (!is_null($action))
        {
            $query.= " AND action = " . $this->oDbh->escape($action);
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
        $table = $this->getLogTableName();
        $query = "SELECT * FROM {$table} WHERE tablename_backup='" . $this->oDbh->escape($name) . "' AND info2 IS NULL";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditForBackupsBySchema($version, $schema='tables_core')
    {
        $table = $this->getLogTableName();
        $query =   "SELECT * FROM {$table}"
                   ." WHERE schema_name ='" . $this->oDbh->escape($schema) . "'"
                   ." AND version = " . $this->oDbh->escape($version)
                   ." AND action =".DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED
                   ." AND info2 IS NULL";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying (one) database audit table"))
        {
            return array();
        }
        return $aResult;
    }

    function updateAuditBackupDroppedByName($tablename_backup, $reason = 'dropped')
    {
        $table = $this->getLogTableName();
        $query = "UPDATE {$table} SET info2='" . $this->oDbh->escape($reason) . "' WHERE tablename_backup='" . $this->oDbh->escape($tablename_backup) . "'";

        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error updating {$this->prefix}{$this->logTables}"))
        {
            return false;
        }
        return true;
    }

    function updateAuditBackupDroppedById($database_action_id, $reason = 'dropped')
    {
        $table = $this->getLogTableName();
        $query = "UPDATE {$table} SET info2='" . $this->oDbh->escape($reason) . "' WHERE database_action_id=" . (int) $database_action_id;

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
        $aBakTables = OA_DB_Table::listOATablesCaseSensitive();
        OA_DB::disableCaseSensitive();

        $prelen = strlen($prefix);
        krsort($aBakTables);
        foreach ($aBakTables AS $k => &$name)
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
        $result = $this->oDbh->manager->getTableStatus($this->prefix.$table);
        if (PEAR::isError($result))
        {
            return array();
        }
        return $result;
    }

}

?>