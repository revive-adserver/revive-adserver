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
 * A class used for creating simple custom queries.
 *
 * @package    OpenXDB
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
        $table = OA_DB_Sql::modifyTableName($table);
        return "INSERT INTO {$table} ($sColumns) VALUES ($sValues)";
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
        $dbh =& OA_DB::singleton();
        $table = OA_DB_Sql::modifyTableName($table);
        $sql = "DELETE FROM {$table} WHERE $idColumn = $id";
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
        $sColumns = implode(' ', $aColumns);
        $table = OA_DB_Sql::modifyTableName($table);
        $sql = "SELECT $sColumns FROM {$table} WHERE $idColumn = $id";
        $rs =& DBC::NewRecordSet($sql);
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
        $aSet = array();
        foreach ($aValues as $column => $value) {
            $aSet []= "$column = " . DBC::makeLiteral($value);
        }
        $sSet = implode(",", $aSet);
        $table = OA_DB_Sql::modifyTableName($table);
        $sql = "UPDATE {$table} SET $sSet WHERE $idColumn = $id";
        $dbh =& OA_DB::singleton();
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

    function modifyTableName($table)
    {
        $prefix = OA_DB_Sql::getPrefix();
        $oDbh = OA_DB::singleton();
        return $oDbh->quoteIdentifier($prefix.$table, true);
    }
}

?>
