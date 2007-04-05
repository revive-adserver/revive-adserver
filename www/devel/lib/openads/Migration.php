<?php

require_once('MDB2.php');

/**
 * Event handling class for Openads deployment system
 *
 */

class Migration
{
    var $aObjectMap;

    var $aTaskList_constructive;
    var $aTaskList_destructive;

    var $oDBH;

    function Migration()
    {
        $this->__construct();
    }

    function __construct()
    {
		$this->aObjectMap = array();
		//$this->aObjectMap['totablename'] = array('fromTable'=>'fromtablename');
		//or
	    //$this->aObjectMap['totablename']['tofieldname'] = array('fromTable'=>'fromtablename', 'fromField'=>'fromfieldname');
    }

    function logEvent($event, $params=array())
    {

    }

    function copyTableData($fromTable, $toTable, $aColumns)
    {
        $columns = implode("','",$aColumns);
        $query = "INSERT IGNORE INTO {$toTable} ({$columns})"
                ." SELECT {$columns} FROM {$fromTable}";
        $result =& $this->oDBH->exec($query);
        if (PEAR::isError($result))
        {
            return $result;
        }
        return true;
    }

    function copyColumnData($fromTable, $fromColumn, $toTable, $toColumn)
    {
        $query = "UPDATE IGNORE {$toTable} SET {$toColumn} = {$fromTable}.{$fromColumn}";
        $result =& $this->oDBH->exec($query);
        if (PEAR::isError($result))
        {
            return $result;
        }
        return true;
    }

    function beforeAddTable($table)
    {
        if ($this->aObjectMap[$table])
        {
            $fromTable = $this->aObjectMap[$table]['fromTable'];
            return $this->copyData($fromTable, '', $table, '');
        }
        return true;
    }

    function afterAddTable($table)
    {
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
            return $this->copyData($fromTable, $fromField, $table, $field);
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