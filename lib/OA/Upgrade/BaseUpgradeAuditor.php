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
 * OpenX Upgrade Audit Class
 *
 */

class OA_BaseUpgradeAuditor
{
    // needs to be defined in the child class
    public $action_table_xml_filename;

    public $logTable = '';

    /** @var MDB2_Driver_Common */
    public $oDbh;

    public $oLogger;

    public $prefix = '';

    public $aParams = [];

    public function __construct()
    {
    }

    public function init($oDbh = '', $oLogger = '')
    {
        if ($oDbh) {
            $this->oDbh = $oDbh;
        } else {
            $this->oDbh = OA_DB::singleton();
        }
        $this->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        // so that this class can log to the caller's log
        // and write it's own log if necessary (testing)
        if ($oLogger) {
            $this->oLogger = $oLogger;
        }
        return $this->_checkCreateAuditTable();
    }

    public function getLogTableName()
    {
        return $this->oDbh->quoteIdentifier($this->prefix . $this->logTable, true);
    }

    /**
     * audit actions taken
     *
     * @param array $aParams
     * @return boolean
     */
    public function logAuditAction($aParams = [])
    {
        $aParams = $this->_escapeParams($aParams);
        $columns = implode(",", array_keys($this->aParams)) . ',' . implode(",", array_keys($aParams));
        $values = implode(",", array_values($this->aParams)) . ',' . implode(",", array_values($aParams));
        $table = $this->getLogTableName();
        $query = "INSERT INTO {$table} ({$columns}, updated) VALUES ({$values}, '" . OA::getNow() . "')";
        $auditId = $this->getNextUpgradeActionId();
        $result = $this->oDbh->exec($query);
        if ($this->isPearError($result, "error inserting {$this->prefix}{$this->logTable}")) {
            return false;
        }
        return $auditId;
    }

    public function updateAuditAction($aParams = [])
    {
        $id = (isset($aParams['id']) ? $aParams['id'] : $this->getUpgradeActionId());
        unset($aParams['id']);
        if (!$id) {
            $this->logError('upgrade_action_id is empty');
            return false;
        }
        $aParams = $this->_escapeParams($aParams);

        $values = '';
        foreach ($aParams as $k => $v) {
            $values .= "{$k}={$v},";
        }
        $values .= "updated='" . OA::getNow() . "'";
        $table = $this->getLogTableName();
        $query = "UPDATE {$table} SET {$values} WHERE upgrade_action_id={$id}";
        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error inserting {$this->prefix}{$this->logTable}")) {
            return false;
        }
        return true;
    }

    public function setKeyParams($aParams = '')
    {
        $this->aParams = $this->_escapeParams($aParams);
    }

    public function getNextUpgradeActionId()
    {
        return true;
    }

    public function getUpgradeActionId()
    {
        return null;
    }

    /**
     * the action_table_name table must exist for all upgrade events
     * currently the schema is stored in a separate xml file which is not part of an upgrade pkg
     * eventually this table schema should be merged into the core tables schema
     *
     * @return boolean
     */
    public function _createAuditTable()
    {
        $xmlfile = MAX_PATH . $this->action_table_xml_filename;

        $oTable = new OA_DB_Table();
        $oTable->init($xmlfile);
        return $oTable->createTable($this->logTable);
    }

    public function _checkCreateAuditTable()
    {
        $aDBTables = OA_DB_Table::listOATablesCaseSensitive();
        if (!in_array($this->prefix . $this->logTable, $aDBTables)) {
            $this->log('creating ' . $this->logTable . ' audit table');
            if (!$this->_createAuditTable()) {
                $this->logError('failed to create ' . $this->logTable . ' audit table');
                return false;
            }
            $this->log('successfully created ' . $this->logTable . ' audit table');
        }
        return true;
    }

    public function _escapeParams($aParams)
    {
        foreach ($aParams as $k => $v) {
            $aParams[$k] = $this->oDbh->quote($v);
        }
        return $aParams;
    }

    /**
     * write a message to the logfile
     *
     * @param string $message
     */
    public function log($message)
    {
        if ($this->oLogger) {
            $this->oLogger->log($message);
        }
    }

    /**
     * write an error to the log file
     *
     * @param string $message
     */
    public function logError($message)
    {
        if ($this->oLogger) {
            $this->oLogger->logError($message);
        }
    }

    public function isPearError($message)
    {
        if ($this->oLogger) {
            return $this->oLogger->isPearError($message);
        }
        return false;
    }
}
