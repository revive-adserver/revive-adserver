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
 * @author     Monique Szpak <monique.szpak@openx.org>
 *
 * $Id$
 *
 */

require_once('MDB2.php');

define('TIMESTAMP_FORMAT', '%Y-%m-%d %H:%M:%S');

/**
 * Event handling class for OpenX deployment system
 *
 */

class Migration
{
    var $aObjectMap = array();
	//$this->aObjectMap['totablename'] = array('fromTable'=>'fromtablename');
	//or
    //$this->aObjectMap['totablename']['tofieldname'] = array('fromTable'=>'fromtablename', 'fromField'=>'fromfieldname');

    var $aTaskList_constructive;
    var $aTaskList_destructive;

    var $aErrors    = array();
    var $aMessages  = array();
    var $logFile = '';

    var $aSQLStatements = array();

    var $aDefinition = array();

    var $affectedRows = 0;

    /**
     * @var MDB2_Driver_Common
     */
    var $oDBH;

    var $prefix;

    function Migration()
    {
        $this->_setupSQLStatements();
        //$this->__construct();
    }

//    function __construct()
//    {
//    }

    function init(&$oDbh, $logfile='')
    {
        if ($oDbh)
        {
            $this->oDBH = $oDbh;
        }
        if (!$this->oDBH)
        {
            $this->oDBH = OA_DB::singleton();
            if (PEAR::isError($this->oDBH))
            {
                return false;
            }
        }
        if ($logfile)
        {
            $this->logFile = $logfile;
        }
        elseif (!$this->logfile)
        {
            $this->logFile = MAX_PATH.'/var/migration.log';
        }
        $this->_setupSQLStatements();
        $this->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        return true;
    }

    /**
     * write a message to the logfile
     *
     * @param string $message
     */
    function _log($message)
    {
        $this->aMessages[] = $message;
        $log = fopen($this->logFile, 'a');
        fwrite($log, "{$message}\n");
        fclose($log);
    }

    /**
     * write an error to the log file
     *
     * @param string $message
     */
    function _logError($message)
    {
        $this->aErrors[] = $message;
        $log = fopen($this->logFile, 'a');
        fwrite($log, "#! {$message}\n");
        fclose($log);
    }

    function _setupSQLStatements()
    {
        switch ($this->oDBH->dbsyntax)
        {
            case 'mysql':
                $engine = $this->oDBH->getOption('default_table_type');
                $this->aSQLStatements['table_copy_all']     = "INSERT IGNORE INTO %s SELECT * FROM %s";
                //$this->aSQLStatements['table_copy_cols'] = "INSERT IGNORE INTO (%s %s) VALUES (SELECT %s FROM %s)";
                $this->aSQLStatements['table_update_col']   = "UPDATE IGNORE %s SET %s = %s.%s";
                $this->aSQLStatements['table_copy']         = "CREATE TABLE %s ENGINE={$engine} (SELECT * FROM %s)";
                $this->aSQLStatements['table_copy_temp']    = "CREATE TEMPORARY TABLE %s ENGINE={$engine} (SELECT * FROM %s)";
                $this->aSQLStatements['table_rename']       = "RENAME TABLE %s TO %s";
                $this->aSQLStatements['table_select']       = 'SELECT %s FROM %s';
                $this->aSQLStatements['table_insert']       = 'INSERT INTO %s (%s) VALUES %s';
                break;
            case 'pgsql':
                $this->aSQLStatements['table_copy_all']   = 'INSERT INTO "%s" SELECT * FROM "%s"';
                $this->aSQLStatements['table_update_col'] = 'UPDATE "%s" SET %s = "%s".%s';
                $this->aSQLStatements['table_copy']       = 'CREATE TABLE "%1$s" (LIKE "%2$s" INCLUDING DEFAULTS); INSERT INTO "%1$s" SELECT * FROM "%2$s"';
                $this->aSQLStatements['table_copy_temp']  = 'CREATE TABLE "%1$s" (LIKE "%2$s" INCLUDING DEFAULTS); INSERT INTO "%1$s" SELECT * FROM "%2$s"';
                $this->aSQLStatements['table_rename']     = 'ALTER TABLE "%s" RENAME TO "%s"';
                $this->aSQLStatements['table_select']     = 'SELECT %s FROM "%s"';
                $this->aSQLStatements['table_insert']     = 'INSERT INTO "%s" (%s) VALUES %s';
                break;
            default:
                '';
                break;
        }
    }


    /**
     * Puts the $sql query template into the $this->aSQLStatements array
     * if and only if current database syntax is equal to the $syntax
     * argument supplied.
     *
     * @param string $syntax The database vendor ('mysql', 'pgsql')
     * @param string $index The index to be used in the $this->aSQLStatements array
     * @param string $sql The query template.
     */
    function _putSqlStatement($syntax, $index, $sql)
    {
        if ($this->oDBH->dbsyntax == $syntax) {
            $this->aSQLStatements[$index] = $sql;
        }
    }

	function _getQuotedTableName($table)
	{
	    $table = $this->getPrefix().($GLOBALS['_MAX']['CONF']['table'][$table] ? $GLOBALS['_MAX']['CONF']['table'][$table] : $table);
	    $quoted = $this->oDBH->quoteIdentifier($table,true);
	    if (PEAR::isError($quoted))
	    {
	        $this->_logError('Error quoting identifier: '.$quoted->getUserInfo());
	        return $table;
	    }
	    return $quoted;
	}

	/**
	 * Returns database table prefix.
	 *
	 * @return string Table prefix
	 */
    function getPrefix()
    {
        return $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }


    /**
     * Logs the MDB2_Error to the error log and returns false.
     *
     * @param string $error
     * @return boolean Always false
     */
    function _logErrorAndReturnFalse($error)
    {
        $this->_logError($error);
        return false;
    }

    /**
     * @param string $fromTable
     * @param string $toTable
     * @param array $aColumns
     * @return boolean
     */
    function copyTableData($fromTable, $toTable)
    {
        $statement  = $this->aSQLStatements['table_copy_all'];
        $prefix     = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $query      = sprintf($statement, $prefix.$toTable, $prefix.$fromTable);
        $this->_log('select query prepared: '.$query);
        $result     =&  $this->oDBH->exec($query);
        if (PEAR::isError($result))
        {
            $this->_logError('error executing query: '.$result->getUserInfo());
            return false;
        }
        $this->affectedRows = $result;
        return true;
    }

    /**
     * this method is not finished yet
     * expand for array of columns
     *
     * @param string $fromTable
     * @param string $fromColumn
     * @param string $toTable
     * @param string $toColumn
     * @return boolean
     */
//    function insertColumnData($fromTable, $fromColumn, $toTable, $toColumn)
//    {
//        $prefix = $this->getPrefix();
//        $statement  = $this->aSQLStatements['table_select'];
//        $query      = sprintf($statement, $fromColumn, $prefix.$fromTable);
//        //$query  = "SELECT {$fromColumn} FROM {$prefix}{$fromTable}";
//        $this->_log('select query prepared: '.$query);
//        $aData  = $this->oDBH->queryCol($query);
//
//        $statement  = $this->aSQLStatements['table_insert'];
//        $query      = sprintf($statement, $prefix.$fromTable, $toColumn, '(:data)');
//        //$query  = "INSERT INTO {$prefix}{$toTable} ({$toColumn}) VALUES (:data)";
//        $stmt   =&  $this->oDBH->prepare($query, array(), MDB2_PREPARE_MANIP);
//        if (PEAR::isError($stmt))
//        {
//            $this->_logError('error preparing statement: '.$stmt->getUserInfo());
//            return false;
//        }
//        $this->_log('statement prepared '.$query);
//        foreach ($aData AS $k=>$v)
//        {
//            $result = $stmt->execute(array('data' => $v));
//            if (PEAR::isError($result)) {
//                $this->_logError('error executing statement: '.$stmt->getUserInfo());
//                return false;
//            }
//            $this->affectedRows++;
//        }
//        $stmt->free();
//        return true;
//    }

    /**
     * @param string $fromTable
     * @param string $fromColumn
     * @param string $toTable
     * @param string $toColumn
     * @return boolean
     */
    function updateColumn($fromTable, $fromColumn, $toTable, $toColumn)
    {
        // ERROR: $this not initialised
        $prefix = $this->getPrefix();
        $statement  = $this->aSQLStatements['table_update_col'];
        $query      = sprintf($statement, $prefix.$toTable, $toColumn, $prefix.$fromTable, $fromColumn);
        $this->_log('select query prepared: '.$query);
        $result     =&  $this->oDBH->exec($query);
        if (PEAR::isError($result))
        {
            $this->_logError('error executing statement: '.$result->getUserInfo());
            return false;
        }
        $this->affectedRows = $result;
        $this->_log('update complete: '.$this->affectedRows.' rows affected');
        return true;
    }

    function beforeAddTable($table)
    {
        return true;
    }

    function afterAddTable($table)
    {
        if ($this->aObjectMap[$table])
        {
            $fromTable = $this->aObjectMap[$table]['fromTable'];
            return $this->copyTableData($fromTable, $table);
        }
        return true;
    }

    function beforeAddField($table, $field)
    {
        return true;
    }

    function afterAddField($table, $field)
    {
        if ($this->aObjectMap[$table][$field])
        {
            $fromTable = $this->aObjectMap[$table][$field]['fromTable'];
            $fromField = $this->aObjectMap[$table][$field]['fromField'];
            if ($fromTable.$fromField != $table.$field)
            {
                return $this->updateColumn($fromTable, $fromField, $table, $field);
            }
        }
        return true;
    }

    function beforeRenameField($table, $field)
    {
        // the $field param is the new field name
        // look up the field map to get the old field name
        return true;
    }

    function afterRenameField($table, $field)
    {
        // the $field param is the new field name
        // look up the field map to get the old field name
        return true;
    }

    function beforeAlterField($table, $field)
    {
        return true;
    }

    function afterAlterField($table, $field)
    {
        return true;
    }

    function beforeAddIndex($table, $index)
    {
        return true;
    }

    function afterAddIndex($table, $index)
    {
        return true;
    }

    function beforeRemoveTable($table)
    {
        return true;
    }

    function afterRemoveTable($table)
    {
        return true;
    }

    function beforeRenameTable($table)
    {
        return true;
    }

    function afterRenameTable($table)
    {
        return true;
    }

    function beforeRemoveField($table, $field)
    {
        return true;
    }

    function afterRemoveField($table, $field)
    {
        return true;
    }

    function beforeRemoveIndex($table, $index)
    {
        return true;
    }

    function afterRemoveIndex($table, $index)
    {
        return true;
    }

    /**
     * Resets the sequence value for a given table and its id field to the
     * maximum value currently in the table. This way after upgrade the
     * sequence should be ready to use for inserting new campaigns, websites...
     * This function have effect only on PostgreSQL. It does nothing when
     * called on a different database.
     *
     * On database error the function logs an error and returns false.
     *
     * @param string $table Name of the table (without prefix)
     * @param string $field Name of the id field (eg. affiliateid, campaignid)
     * @param int $idxMigration Migration number which calls this function
     * @return boolean True on success, false on error.
     */
    function resetSequence($table, $field, $idxMigration)
    {
        if ($this->oDBH->dbsyntax == 'pgsql') {
            $dbTable = new OA_DB_Table();
            $result = $dbTable->resetSequenceByData($table, $field);
            if (PEAR::isError($result)) {
                return $this->_logErrorAndReturnFalse(
                    "Error resetting {$table} sequence during migration $idxMigration: ".$result->getUserInfo());
            }
        }
        return true;
    }
}

?>