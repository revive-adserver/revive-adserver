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

    var $aSQLStatements = array();

    var $oDBH;

    function Migration()
    {
        $this->aObjectMap = array();
        //$this->__construct();
    }

//    function __construct()
//    {
//		$this->aObjectMap = array();
//		//$this->aObjectMap['totablename'] = array('fromTable'=>'fromtablename');
//		//or
//	    //$this->aObjectMap['totablename']['tofieldname'] = array('fromTable'=>'fromtablename', 'fromField'=>'fromfieldname');
//    }

    function logEvent($event, $params=array())
    {

    }

    function _setupSQLStatements()
    {
        switch ($this->oSchema->db->dbsyntax)
        {
            case 'mysql':
                $engine = $this->oSchema->db->getOption('default_table_type');
                $this->aSQLStatements['table_copy']     = "CREATE TABLE %s ENGINE={$engine} (SELECT * FROM %s)";
                $this->aSQLStatements['table_rename']   = "RENAME TABLE %s TO %s";
                break;
            case 'pgsql':
                $this->aSQLStatements['table_copy']     = 'CREATE TABLE "%1$s" (LIKE "%2$s" INCLUDING DEFAULTS); INSERT INTO "%1$s" SELECT * FROM "%2$s"';
                $this->aSQLStatements['table_rename']   = 'ALTER TABLE "%s" RENAME TO "%s"';
                break;
            default:
                '';
                break;
        }
    }

    /**
     * this method is not finished yet
     *
     * @param string $fromTable
     * @param string $toTable
     * @param array $aColumns
     * @return boolean
     */
    function copyTableData($fromTable, $toTable, $aColumns='')
    {
        if (!$aColumns)
        {
            $query = "INSERT IGNORE INTO {$toTable}"
                    ." SELECT * FROM {$fromTable}";
        }
        else
        {
            $columns = implode("','",$aColumns);
            $query = "INSERT IGNORE INTO {$toTable} ({$columns})"
                    ." SELECT {$columns} FROM {$fromTable}";
        }
        $result =& $this->oDBH->exec($query);
        if (PEAR::isError($result))
        {
            return $result;
        }
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
            return $this->copyTableData($fromTable, $table);
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
            return $this->copyColumnData($fromTable, $fromField, $table, $field);
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