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

define('UPGRADE_ACTION_UPGRADE_SUCCEEDED',                      1);
define('UPGRADE_ACTION_UPGRADE_FAILED',                         0);

define('UPGRADE_ACTION_ROLLBACK_SUCCEEDED',                     2);
define('UPGRADE_ACTION_ROLLBACK_FAILED',                        3);

define('UPGRADE_ACTION_INSTALL_SUCCEEDED',                      4);
define('UPGRADE_ACTION_INSTALL_FAILED',                         5);

define('UPGRADE_ACTION_UNINSTALL_SUCCEEDED',                    6);
define('UPGRADE_ACTION_UNINSTALL_FAILED',                       7);

require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_PATH.'/lib/OA/DB/Table.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_UpgradeAuditor.php');
require_once MAX_PATH.'/lib/OA/Upgrade/BaseUpgradeAuditor.php';

class OA_UpgradeAuditor extends OA_BaseUpgradeAuditor
{
    var $oLogger;
    var $oDbh;
    var $oDBAuditor;

    var $logTable   = 'upgrade_action';
    var $action_table_xml_filename   = '/etc/upgrade_action.xml';

    var $prefix = '';

    var $aParams = array();

    var $aEvents = array();

    /**
     * php5 class constructor
     *
     * simpletest throws a BadGroupTest error
     * Redefining already defined constructor for class
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
    }

    function init($oDbh='', $oLogger='')
    {
        $result = parent::init($oDbh, $oLogger);
        return $this->_initDBAuditor();
    }

    function _initDBAuditor()
    {
        if (is_null($this->oDBAuditor))
        {
            $this->oDBAuditor = new OA_DB_UpgradeAuditor();
            return $this->oDBAuditor->init($this->oDbh, $this->oLogger);
        }
        return true;
    }

    function getNextUpgradeActionId()
    {
        $this->_initDBAuditor();
        $aAuditTableStatus = $this->oDBAuditor->getTableStatus($this->logTable);
        if ((!is_array($aAuditTableStatus) || (count($aAuditTableStatus)<1)) || (!isset($aAuditTableStatus[0]['auto_increment'])))
        {
            return false;
        }
        return $aAuditTableStatus[0]['auto_increment'];
    }

    function setUpgradeActionId()
    {
        $this->oDBAuditor->auditId = $this->getNextUpgradeActionId();
    }

    function getUpgradeActionId()
    {
        return $this->oDBAuditor->auditId;
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

    /**
     * return all columns from upgrade_action table for given upgrade_action_id
     *
     * @param integer $id
     * @return array
     */
    function queryAuditByUpgradeId($id)
    {
        $table = $this->getLogTableName();
        $query = "SELECT * FROM {$table} WHERE upgrade_action_id = " . (int) $id;
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying database audit table"))
        {
            return array();
        }
        return $aResult;
    }

    /**
     * return all columns from database_action table for given upgrade_action_id
     *
     * @param integer $id
     * @return array
     */
    function queryAuditArtifactsByUpgradeId($id)
    {
        $aResult = $this->oDBAuditor->queryAuditByUpgradeId($id);
        if ($this->isPearError($aResult, "error querying upgrade audit table"))
        {
            return false;
        }
        return $aResult;
    }

    /**
     * main backup tables query method
     *
     * @param integer $id
     * @return array
     */
    function queryAuditBackupTablesByUpgradeId($id)
    {
        $aResult = $this->oDBAuditor->queryAuditBackupTablesByUpgradeId($id);
        if ($this->isPearError($aResult, "error querying upgrade audit table"))
        {
            return false;
        }
        $aResult = $this->getBackupTableStatus($aResult);
        return $aResult;
    }

    /**
     * get list of tables that were added for an upgrade_action_id
     *
     * @param integer $id
     * @return array
     */
    function queryAuditAddedTablesByUpgradeId($id)
    {
        $aResult = $this->oDBAuditor->queryAuditAddedTablesByUpgradeId($id);
        if ($this->isPearError($aResult, "error querying upgrade audit table"))
        {
            return false;
        }
        return $aResult;
    }

    /**
     * used by queryAuditBackupTablesByUpgradeId(0
     *
     * @param array $aTables
     * @return array
     */
    function getBackupTableStatus($aTables)
    {
        foreach ($aTables AS $k => &$aRec)
        {
            $aStatus = $this->oDBAuditor->getTableStatus($aRec['tablename_backup']);
            $aTables[$k]['backup_size']   = $aStatus[0]['data_length']/1024;
            $aTables[$k]['backup_rows']   = $aStatus[0]['rows'];
        }
        return $aTables;
    }

    /**
     * main audit query method
     * return all columns from the upgrade_action table
     * along with a count of the backup table artifacts for each upgrade_action_id
     *
     * @return array
     */
    function queryAuditAllDescending()
    {
        $table  = $this->getLogTableName();
        $tableJ = $this->oDBAuditor->getLogTableName();
        $query = "SELECT u.*, COUNT(d.upgrade_action_id) AS backups"
                 ." FROM {$table} AS u"
                ." LEFT JOIN {$tableJ} AS d ON u.upgrade_action_id = d.upgrade_action_id"
                ." AND d.action=30 AND d.info2 IS NULL"
                ." GROUP BY u.upgrade_action_id, u.upgrade_name, u.version_to, u.version_from,"
                ."  u.action, u.description, u.logfile, u.confbackup, u.updated"
                ." ORDER BY u.upgrade_action_id DESC";

        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying upgrade audit table"))
        {
            return false;
        }
        for ($i = 0; $i < count($aResult); $i++) {
            if ($aResult[$i]['description'] == "UPGRADE COMPLETE") {
                $aResult[$i]['description'] = "UPGRADE_COMPLETE";
            }
            elseif ($aResult[$i]['description'] == "UPGRADE FAILED") {
                $aResult[$i]['description'] = 'UPGRADE_FAILED';
            }
        }
        return $aResult;
    }

    /**
     * drops all backup artifacts for given upgrade_id
     * logs a reason
     *
     * @param integer $upgrade_id
     * @param string $reason
     * @return boolean
     */
    function cleanAuditArtifacts($upgrade_id, $reason = 'cleaned')
    {
        $aResult = $this->queryAuditByUpgradeId($upgrade_id);
        $aResultDB = $this->queryAuditBackupTablesByUpgradeId($upgrade_id);

        foreach ($aResultDB AS $k => &$aTable)
        {
            $result = $this->oDbh->manager->dropTable($this->prefix.$aTable['tablename_backup']);
            if ($this->isPearError($result,'error dropping backup table'))
            {
                return false;
            }
            $this->oDBAuditor->updateAuditBackupDroppedById($aTable['database_action_id'],'cleaned by user');
        }

        foreach ($aResult AS $k => &$aRec)
        {
            if ($aRec['logfile'] && file_exists(MAX_PATH.'/var/'.$aRec['logfile']))
            {
                if (!@unlink(MAX_PATH.'/var/'.$aRec['logfile']))
                {
                    return false;
                }
                $this->updateAuditBackupLogDroppedById($upgrade_id, 'cleaned by user');
            }
            else
            {
                $this->updateAuditBackupLogDroppedById($upgrade_id, 'file not found');
            }
            if ($aRec['confbackup'] && file_exists(MAX_PATH.'/var/'.$aRec['confbackup']))
            {
                if (!@unlink(MAX_PATH.'/var/'.$aRec['confbackup']))
                {
                    return false;
                }
                $this->updateAuditBackupConfDroppedById($upgrade_id, 'cleaned by user');
            }
            else
            {
                $this->updateAuditBackupConfDroppedById($upgrade_id, 'file not found');
            }
        }

        return true;
    }

    /**
     * replace the backup conf column with reason for deletion
     *
     * @param integer $upgrade_action_id
     * @param string $reason
     * @return boolean
     */
    function updateAuditBackupConfDroppedById($upgrade_action_id, $reason = 'dropped')
    {
        $table = $this->getLogTableName();
        $query = "UPDATE {$table} SET confbackup='" . $this->oDbh->escape($reason) . "' WHERE upgrade_action_id='" . $this->oDbh->escape($upgrade_action_id) . "'";

        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error updating {$this->prefix}{$this->logTable}"))
        {
            return false;
        }
        return true;
    }

    /**
     * replace the logfile column with reason for deletion
     *
     * @param integer $upgrade_action_id
     * @param string $reason
     * @return boolean
     */
     function updateAuditBackupLogDroppedById($upgrade_action_id, $reason = 'dropped')
    {
        $table = $this->getLogTableName();
        $query = "UPDATE {$table} SET logfile='" . $this->oDbh->escape($reason) . "' WHERE upgrade_action_id='" . $this->oDbh->escape($upgrade_action_id) . "'";

        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error updating {$this->prefix}{$this->logTable}"))
        {
            return false;
        }
        return true;
    }

}

?>