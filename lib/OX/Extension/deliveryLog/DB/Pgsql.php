<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once LIB_PATH . '/Extension/deliveryLog/DB/Common.php';
require_once LIB_PATH . '/Extension/deliveryLog/DeliveryLog.php';

/**
 * A PostgreSQL specific deliveryLog extension database layer class to provide
 * require special database support functionality to allow the deliveryLog
 * extension to work effectively when using the PostgreSQL database type.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class OX_Extension_DeliveryLog_DB_Pgsql extends OX_Extension_DeliveryLog_DB_Common
{
    /**
     * Keeps the reference to the result of the process of creating postgres language
     * to avoid checking the language each time
     *
     * @var mixed
     */
    static $pgsqlLanguage = null;

    /**
     * Prefix of PostgreSQL stored procedure name which is used
     * to update the table bucket.
     *
     * @var string
     */
    protected $storedProcedurePrefix = 'bucket_update_';

    function createLanguage()
    {
        if (is_null(self::$pgsqlLanguage)) {
            self::$pgsqlLanguage = OA_DB::_createLanguage();
        }
        return self::$pgsqlLanguage;
    }

    /**
     * This sets up all the required PL/SQL functions for the database.
     *
     * @return mixed True on success, PEAR_Error otherwise.
     */
    function createStoredProcedureFunction($query)
    {
        $oDbh =& OA_DB::singleton();
        if (PEAR::isError($oDbh)) {
            return $oDbh;
        }
        $result = $this->createLanguage();
        if (PEAR::isError($result)) {
            return $result;
        }
        $rows = $oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return $rows;
        }
        return true;
    }

    /**
     * Install component store procedures
     *
     * @return boolean  True on success otherwise false
     */
    public function install(Plugins_DeliveryLog $component)
    {
        $query = $this->getCreateStoredProcedureQuery($component);
        return $this->createStoredProcedureFunction($query);
    }

    /**
     * Uninstall stored procedures
     *
     * @return boolean  True on success otherwise false
     */
    public function uninstall($component)
    {
        // currently this operation can't be performed using existing plugin framework
        return true;
    }

    /**
     * Returns the bucket stored procedure name
     *
     * @return string
     */
    function getStoredProcedureName(Plugins_DeliveryLog $component)
    {
        return $this->storedProcedurePrefix . $component->getBucketTableName();
    }

    /**
     * Returns the stored procedure query body. Used on install
     * to create required procedures inside postgres database
     *
     * @return string
     */
    function getCreateStoredProcedureQuery(Plugins_DeliveryLog $component)
    {
        $tableName = $component->getBucketTableName();
        $query = 'CREATE OR REPLACE FUNCTION '
            . $this->getStoredProcedureName($component) . '
            ('.$this->_getColumnTypesList($component).', cnt integer)
            RETURNS void AS
            $BODY$DECLARE
              x int;
            BEGIN
              LOOP
                -- first try to update
                UPDATE ' . $tableName . ' SET count = count + cnt WHERE '
                    .$this->_getSPWhere($component).';
                GET DIAGNOSTICS x = ROW_COUNT;
                IF x > 0 THEN
                  RETURN;
                END IF;
                -- not there, so try to insert the key
                -- if someone else inserts the same key concurrently,
                -- we could get a unique-key failure
                BEGIN
                  INSERT INTO ' . $tableName . ' VALUES ('
                        .$this->_getSPValuesList($component).', cnt);
                  RETURN;
                EXCEPTION WHEN unique_violation THEN
                  -- do nothing, and loop to try the UPDATE again
                END;
              END LOOP;
            END$BODY$
            LANGUAGE \'plpgsql\'';
        return $query;
    }

    /**
     * Prepares a list of columnt types. Used by PostgreSQL stored procedure
     *
     * @param array $aIgnore  List of column names to ignore (count is not included by default)
     * @return string  Comma separated ordered list of columns
     */
    protected function _getColumnTypesList(Plugins_DeliveryLog $component,
        $aIgnore = array(Plugins_DeliveryLog::COUNT_COLUMN))
    {
        $str = '';
        $aColumns = $component->getBucketTableColumns();
        $comma = '';
        foreach ($aColumns as $columnName => $columnType) {
            if (in_array($columnName, $aIgnore)) {
                continue;
            }
            $str .= $comma . $columnType;
            $comma = ', ';
        }
        return $str;
    }

    /**
     * Prepares a WHERE query, required by PostgreSQL stored procedure
     *
     * @param array $aIgnore  List of columns to ignore (count is not included by default)
     * @return string  WHERE clause
     */
    protected function _getSPWhere(Plugins_DeliveryLog $component,
        $aIgnore = array(Plugins_DeliveryLog::COUNT_COLUMN))
    {
        $where = '';
        $c = 1;
        $and = '';
        $aColumns = $component->getBucketTableColumns();
        foreach ($aColumns as $columnName => $columnType) {
            if (in_array($columnName, $aIgnore)) {
                continue;
            }
            $where .= $and . $columnName . ' = $' . $c;
            $and = ' AND ';
            $c++;
        }
        return $where;
    }

    /**
     * Prepares a VALUES part of PostgreSQL stored procedure.
     *
     * @param array $aIgnore  List of columns to ignore (count is not included by default)
     * @return string  Comma separated VALUES list
     */
    protected function _getSPValuesList(Plugins_DeliveryLog $component,
        $aIgnore = array(Plugins_DeliveryLog::COUNT_COLUMN))
    {
        $values = '';
        $c = 1;
        $comma = '';
        $aColumns = $component->getBucketTableColumns();
        foreach ($aColumns as $columnName => $columnType) {
            if (in_array($columnName, $aIgnore)) {
                continue;
            }
            $values .= $comma.'$'.$c;
            $comma = ', ';
            $c++;
        }
        return $values;
    }
}

?>
