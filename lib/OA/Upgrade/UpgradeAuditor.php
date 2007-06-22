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

//define('UPGRADE_ACTION_PARTIAL_SUCCEEDED',                      2);
define('UPGRADE_ACTION_UPGRADE_SUCCEEDED',                      1);
define('UPGRADE_ACTION_UPGRADE_FAILED',                         0);

require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_PATH.'/lib/OA/DB/Table.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_UpgradeAuditor.php');

class OA_UpgradeAuditor
{
    var $oLogger;
    var $oDbh;
    var $oDBAuditor;

    var $logTable   = 'upgrade_action';

    var $prefix = '';

    var $aParams = array();

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
    function OA_UpgradeAuditor()
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
        $this->oDBAuditor = new OA_DB_UpgradeAuditor();
        $this->oDBAuditor->init($this->oDbh, $this->oLogger);
        return $this->_checkCreateAuditTable();
    }

    function setKeyParams($aParams='')
    {
        $this->aParams = $this->_escapeParams($aParams);
    }

    /**
     * audit actions taken
     *
     * @param array $aParams
     * @return boolean
     */
    function logUpgradeAction($aParams=array())
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

    function getUpgradeActionId()
    {
        $aAuditTableStatus = $this->oDBAuditor->getTableStatus($this->logTable);
        if (count($aAuditTableStatus)<1)
        {
            return false;
        }
        return $aAuditTableStatus[0]['auto_increment'];
    }

    function setUpgradeActionId()
    {
        $this->oDBAuditor->auditId = $this->getUpgradeActionId();
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
        $xmlfile = MAX_PATH.'/etc/upgrade_action.xml';

        $oTable = new OA_DB_Table();
        $oTable->init($xmlfile);
        return $oTable->createTable($this->logTable);
    }

    function _checkCreateAuditTable()
    {
        $this->aDBTables = $this->oDbh->manager->listTables();
        if (!in_array($this->prefix.$this->logTable, $this->aDBTables))
        {
            $this->log('creating upgrade_action audit table');
            if (!$this->_createAuditTable())
            {
                $this->logError('failed to create upgrade_action audit table');
                return false;
            }
            $this->log('successfully created upgrade_action audit table');
        }
        return true;
    }

    function upgradeAuditTable()
    {

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
        $query = "SELECT * FROM {$this->prefix}{$this->logTable} WHERE upgrade_action_id = {$id}";
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
     * used by queryAuditBackupTablesByUpgradeId(0
     *
     * @param array $aTables
     * @return array
     */
    function getBackupTableStatus($aTables)
    {
        foreach ($aTables AS $k => $aRec)
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
        $query = "SELECT u.*, COUNT(d.upgrade_action_id) AS backups"
                 ." FROM {$this->prefix}{$this->logTable} AS u"
                ." LEFT JOIN {$this->prefix}{$this->oDBAuditor->logTable} AS d ON u.upgrade_action_id = d.upgrade_action_id"
                ." AND d.action=30 AND d.info2 IS NULL"
                ." GROUP BY u.upgrade_action_id"
                ." ORDER BY u.upgrade_action_id DESC";

        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying upgrade audit table"))
        {
            return false;
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

        foreach ($aResultDB AS $k => $aTable)
        {
            $result = $this->oDbh->manager->dropTable($this->prefix.$aTable['tablename_backup']);
            if ($this->isPearError($result,'error dropping backup table'))
            {
                return false;
            }
            $this->oDBAuditor->updateAuditBackupDroppedById($aTable['database_action_id'],'cleaned by user');
        }

        foreach ($aResult AS $k => $aRec)
        {
            if ($aRec['logfile'] && file_exists(MAX_PATH.'/var/'.$aRec['logfile']))
            {
                if (!unlink(MAX_PATH.'/var/'.$aRec['logfile']))
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
                if (!unlink(MAX_PATH.'/var/'.$aRec['confbackup']))
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
        $query = "UPDATE {$this->prefix}{$this->logTable} SET confbackup='{$reason}' WHERE upgrade_action_id='{$upgrade_action_id}'";

        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error updating {$this->prefix}{$this->logTables}"))
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
     */    function updateAuditBackupLogDroppedById($upgrade_action_id, $reason = 'dropped')
    {
        $query = "UPDATE {$this->prefix}{$this->logTable} SET logfile='{$reason}' WHERE upgrade_action_id='{$upgrade_action_id}'";

        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error updating {$this->prefix}{$this->logTables}"))
        {
            return false;
        }
        return true;
    }


    function queryAudit($versionTo=null, $versionFrom=null, $upgradeName=null, $action=null)
    {
        $query =   "SELECT * FROM {$this->prefix}{$this->logTable}"
                   ." WHERE 1";
        if ($versionTo)
        {
            $query.= " AND version_to ='{$versionTo}'";
        }
        if ($versionFrom)
        {
            $query.= " AND version_from ='{$versionFrom}'";
        }
        if ($upgradeName)
        {
            $query.= " AND upgrade_name ='{$upgradeName}'";
        }
        if (!is_null($action))
        {
            $query.= " AND action ={$action}";
        }
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying (one) upgrade audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditForAnUpgradeByName($name)
    {
        $query = "SELECT * FROM {$this->prefix}{$this->logTable} WHERE upgrade_name='{$name}'";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying upgrade audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditAll()
    {
        $query = "SELECT * FROM {$this->prefix}{$this->logTable}";
        $aResult = $this->oDbh->queryAll($query);
        if ($this->isPearError($aResult, "error querying upgrade audit table"))
        {
            return false;
        }
        return $aResult;
    }

    function queryAuditAllWithArtifacts()
    {
        $aResult = $this->queryAuditAll();
        foreach ($aResult AS $k => $aItem)
        {
            if (!is_null($aItem['dbschemas']))
            {
                $aSchemas = unserialize($aItem['dbschemas']);
                foreach ($aSchemas AS $schemaName => $aVersions)
                {
                    foreach ($aVersions AS $k1 => $version)
                    {
                        $aDBArray = $this->oDBAuditor->queryAuditForBackupsBySchema($version, $schemaName);
                        $aSchemas[$schemaName][$k1]= array($version=> array());
                        foreach ($aDBArray AS $k2 => $aDBAudit)
                        {
                            $aStatus = $this->oDBAuditor->getTableStatus($aDBAudit['tablename_backup']);
                            $aSchemas[$schemaName][$k1][$version][$k2]['backup'] = $aDBArray[0]['tablename_backup'];
                            $aSchemas[$schemaName][$k1][$version][$k2]['source'] = $aDBArray[0]['tablename'];
                            $aSchemas[$schemaName][$k1][$version][$k2]['size']   = $aStatus[0]['data_length']/1024;
                            $aSchemas[$schemaName][$k1][$version][$k2]['rows']   = $aStatus[0]['rows'];
                        }
                    }
                }
                $aResult[$k]['dbschemas'] = $aSchemas;
            }
        }
        return $aResult;
    }

}

?>