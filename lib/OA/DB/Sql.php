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
    public static function sqlForInsert($table, $aValues)
    {
        foreach ($aValues as $column => $value) {
            $aValues[$column] = DBC::makeLiteral($value);
        }
        $sColumns = implode(",", array_keys($aValues));
        $sValues = implode(",", $aValues);
        $table = self::modifyTableName($table);
        return "INSERT INTO {$table} ($sColumns) VALUES ($sValues)";
    }

    /**
     * Returns database tables prefix.
     *
     * @return string
     */
    private static function getPrefix()
    {
        return $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }

    private static function modifyTableName($table)
    {
        $oDbh = OA_DB::singleton();

        return $oDbh->quoteIdentifier(self::getPrefix() . $table, true);
    }
}
