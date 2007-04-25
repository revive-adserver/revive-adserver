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

require_once('MDB2.php');

/**
 * Event handling class for Openads deployment system
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

    var $oDBH;

    function Migration()
    {
        $this->_setupSQLStatements();
        //$this->__construct();
    }

//    function __construct()
//    {
//    }

    function init($oDbh, $logfile='')
    {
        $this->oDBH = $oDbh;
        if ($logfile)
        {
            $this->logFile = $logfile;
        }
        else
        {
            $this->logFile = MAX_PATH.'/var/migration.log';
        }
        $this->_setupSQLStatements();
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
        fwrite($log, "ERROR: {$message}\n");
        fclose($log);
    }

    function _setupSQLStatements()
    {
        switch ($this->oDBH->dbsyntax)
        {
            case 'mysql':
                $engine = $this->oDBH->getOption('default_table_type');
                $this->aSQLStatements['table_copy_all'] = "INSERT IGNORE INTO %s SELECT * FROM %s";
                //$this->aSQLStatements['table_copy_cols'] = "INSERT IGNORE INTO (%s %s) VALUES (SELECT %s FROM %s)";
                $this->aSQLStatements['table_update_col'] = "UPDATE IGNORE %s SET %s = %s.%s";
                break;
            case 'pgsql':
                $this->aSQLStatements['table_copy_all'] = "INSERT INTO %s SELECT * FROM %s";
                $this->aSQLStatements['table_update_col'] = "UPDATE %s SET %s = %s.%s";
                break;
            default:
                '';
                break;
        }
    }

//    /**
//     * not finished
//     * copy all data from one table to another
//     * incomplete
//     * expand
//     *
//     * @param string $fromTable
//     * @param string $toTable
//     * @param array $aColumns
//     * @return boolean
//     */
//    function copyTableData($fromTable, $toTable)
//    {
//        $statement  = $this->aSQLStatements['table_copy_all'];
//        $query      = sprintf($statement, $toTable, $fromTable);
//        $this->_log('select query prepared: '.$query);
//        $result     = & $this->oDBH->exec($query);
//        if (PEAR::isError($result))
//        {
//            $this->_logError('error executing query: '.$result->getUserInfo());
//            return false;
//        }
//        $this->affectedRows = $result;
//        return true;
//    }

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
    function insertColumnData($fromTable, $fromColumn, $toTable, $toColumn)
    {
        $query  = "SELECT {$fromColumn} FROM {$fromTable}";
        $this->_log('select query prepared: '.$query);
        $aData  = $this->oDBH->queryCol($query);

        $query  = "INSERT INTO {$toTable} ({$toColumn}) VALUES (:data)";
        $stmt   = & $this->oDBH->prepare($query, array(), MDB2_PREPARE_MANIP);
        if (PEAR::isError($stmt))
        {
            $this->_logError('error preparing statement: '.$stmt->getUserInfo());
            return false;
        }
        $this->_log('statement prepared '.$query);
        foreach ($aData AS $k=>$v)
        {
            $result = $stmt->execute(array('data' => $v));
            if (PEAR::isError($result)) {
                $this->_logError('error executing statement: '.$stmt->getUserInfo());
                return false;
            }
            $this->affectedRows++;
        }
        $stmt->free();
        return true;
    }

    /**
     * * this method is not finished yet
     *
     * @param string $fromTable
     * @param string $fromColumn
     * @param string $toTable
     * @param string $toColumn
     * @return boolean
     */
    function updateColumn($fromTable, $fromColumn, $toTable, $toColumn)
    {
        // ERROR: $this not initialised

        $statement  = $this->aSQLStatements['table_update_col'];
        $query      = sprintf($statement, $toTable, $toColumn, $fromTable, $fromColumn);
        $this->_log('select query prepared: '.$query);
        $result     = & $this->oDBH->exec($query);
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
//            $fromTable = $this->aObjectMap[$table]['fromTable'];
//            return $this->copyTableData($fromTable, $table);
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
            return $this->updateColumn($fromTable, $fromField, $table, $field);
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

}

?>