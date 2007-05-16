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
$Id$
*/

/**
 * A class used for creating simple custom queries.
 *
 * @package    OpenadsDB
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class OA_DB_Sql
{
    /**
     * Generates INSERT INTO... command. Assumes that $aValues contains
     * a list of pairs column => value. Escapes values as necessary and adds
     * '' for strings.
     *
     * @param string $table
     * @param array $aValues
     * @return string
     */
	function sqlForInsert($table, $aValues)
	{
	    foreach($aValues as $column => $value) {
	        $aValues[$column] = DBC::makeLiteral($value);
	    }
        $sColumns = implode(",", array_keys($aValues));
        $sValues = implode(",", $aValues);
        return "INSERT INTO $table ($sColumns) VALUES ($sValues)";
	}
    
    
    /**
     * Deletes all the rows in the $table having column $idColumn value $id.
     * The operation is performed without data objects, so it can be used during
     * install / upgrade!
     *
     * @param string $table
     * @param string $idColumn
     * @param string $id
     * @return Number of deleted rows on success and PEAR::Error on exit.
     */
    function deleteWhereOne($table, $idColumn, $id)
    {
        $prefix = OA_DB_Sql::getPrefix();
        $dbh = &OA_DB::singleton();
        $sql = "DELETE FROM {$prefix}$table WHERE $idColumn = $id";
        return $dbh->exec($sql);
    }
    
    
    /**
     * Selects specified columns from the $table and returns
     * initialized (after find()) RecordSet or PEAR::Error
     * if initialization didn't work correctly.
     *
     * @param string $table
     * @param string $idColumn
     * @param string $id
     * @param array $aColumns List of columns, defaults to '*'.
     * @return DataSpace
     */
    function &selectWhereOne($table, $idColumn, $id, $aColumns = array('*'))
    {
        $prefix = OA_DB_Sql::getPrefix();
        $sColumns = implode(' ', $aColumns);
        $sql = "SELECT $sColumns FROM {$prefix}$table WHERE $idColumn = $id";
        $rs = &DBC::NewRecordSet($sql);
        $result = $rs->find();
        if (PEAR::isError($result)) {
            return $result;
        }
        return $rs;
    }
    
    
    /**
     * Updates the table with the specified $aValues where $idColumn equals
     * $id. Returns number of rows updated on success or PEAR::Error on
     * failure.
     *
     * @param string $table
     * @param string $idColumn
     * @param string $id
     * @param array $aValues A map from column name => new value
     * @return int Number of rows updated on success or PEAR::Error on failure.
     */
    function updateWhereOne($table, $idColumn, $id, $aValues)
    {
        $prefix = OA_DB_Sql::getPrefix();
        $aSet = array();
        foreach ($aValues as $column => $value) {
            $aSet []= "$column = " . DBC::makeLiteral($value);
        }
        $sSet = implode(",", $aSet);
        $sql = "UPDATE {$prefix}$table SET $sSet WHERE $idColumn = $id";
        $dbh = &OA_DB::singleton();
        return $dbh->exec($sql);
    }
    
    /**
     * Returns database tables prefix.
     *
     * @return string
     */
    function getPrefix()
    {
        return $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }
}

?>
