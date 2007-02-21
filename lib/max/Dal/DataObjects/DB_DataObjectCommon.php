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
$Id$
*/

/**
 * Table Definition for campaigns
 */
require_once 'DB/DataObject.php';

/**
 * The non-DB specific Data Access Layer (DAL) class for the User Interface (Admin).
 *
 * @package    DataObjects
 * @author     David Keen <david.keen@openads.org>
 * @author     Radek Maciaszek <radek.maciaszek@openads.org>
 */
class DB_DataObjectCommon extends DB_DataObject
{
    /**
     * If true delete() will delete also all connected rows in database defined in links file.
     *
     * @var boolean
     */
    var $onDeleteCascade = false;

    var $_tableName;

    /**
     * Method overrides default DB_DataObject database schema location and adds prefixes to schema
     * definitions
     *
     * @return boolean  True on success, else false
     */
    function databaseStructure()
    {
        global $_DB_DATAOBJECT;

        $_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"] = array(
            "{$_DB_DATAOBJECT['CONFIG']['schema_location']}/db_schema.ini"
        );

        if (!parent::databaseStructure() && empty($_DB_DATAOBJECT['INI'][$this->_database])) {
            return false;
        }

        $configDatabase = &$_DB_DATAOBJECT['INI'][$this->_database];
        $prefix = $GLOBALS['MAX']['conf']['table']['prefix'];

        // databaseStructure() is cached in memory so we have to add prefix to all definitions on first run
        if (!empty($prefix)) {
            foreach ($configDatabase as $tableName => $config) {
                $configDatabase[$prefix.$tableName] = $configDatabase[$tableName];
                $configDatabase[$prefix.$tableName."__keys"] = $configDatabase[$tableName."__keys"];
            }
        }
        return true;
    }

    /**
     * Add a prefix to table name and save oroginal table name in _tableName
     *
     */
    function addPrefixToTableName()
    {
        if (empty($this->_tableName)) {
            $this->prefix = $GLOBALS['MAX']['conf']['table']['prefix'];
            $this->_tableName = $this->__table;
            $this->__table = $this->prefix . $this->__table;
        }
    }

    /**
     * Connect is used inside DB_DataObject to connect preload config
     * We will override this "private" method to add additional settings required
     * to use prefixes
     *
     * @return unknown
     */
    function _connect()
    {
        $this->addPrefixToTableName();
        return parent::_connect();
    }

    /**
     * Overwrite DB_DataObject::delete() method and add a "ON DELETE CASCADE"
     *
     * @param boolean $onDeleteCascade  If true it deletes also referenced tables
     * @param boolean $useWhere
     * @return boolean
     */
    function delete($useWhere = false, $onDeleteCascade = true)
    {

        $this->addPrefixToTableName();

        if ($this->onDeleteCascade && $onDeleteCascade) {
            $aKeys = $this->keys();

            // Simulate "ON DELETE CASCADE"
            if (count($aKeys) == 1) {
                // Resolve references automatically only for records with one column as Primary Key
                // If table has more than one column in PK it is still possible to remove
                // manually connected tables (by overriding delete() method)
                $primaryKey = $aKeys[0];
                $linkedRefs = $this->_collectRefs($primaryKey);

                // Find all affected tuples
                $doAffected = clone($this);
                if (!$useWhere) {
                    // Clear any additional WHEREs if it's not used in delete statement
                    $doAffected->whereAdd();
                }
                $doAffected->find();

                while ($doAffected->fetch()) {
                    // Simulate "ON DELETE CASCADE"
                    $doAffected->deleteCascade($linkedRefs, $primaryKey);
                }
            }
        }

        return parent::delete($useWhere);
    }

    /**
     * Adds a case-insensitive (lower) WHERE condition using the MySQL LOWER() function.
     *
     * @param string $field  the database column to test
     * @param mixed $value  the value to compare
     */
    function whereAddLower($field, $value)
    {
        $this->whereAdd("LOWER($field) = " . strtolower($this->escape($value)));
    }

     /**
     * Make sure column(s) exists before trying to ordering by them
     * This method works as a security check, it doesn't allow for db injection
     * in "ORDER BY" passed from User Interface
     *
     * @see Db_DataObject::orderBy()
     * @access public
     * @return none|false|PEAR::Error - invalid args only
     */
    function orderBy($order = false)
    {
        if (!empty($order)) {
            $aOrderBy = explode(',', $order);
            $columns = $this->table();
            foreach ($aOrderBy as $orderBy) {
                $expr = explode(" ", $orderBy);
                if (count($expr) > 2) {
                    return false;
                }
                if (!array_key_exists($expr[0], $columns)) {
                    return false;
                }
                if (count($expr) == 2 && !in_array(strtoupper($expr[1]), array('ASC', 'DESC'))) {
                    return false;
                }
            }
        }
        return parent::orderBy($order);
    }

    /**
     * Collects references from links file
     *
     * Example references:
     *  [log]
     *  usr_id = usr:id
     *  module_id = module:id
     *
     * in above example table log has two foreign keys,
     * eg "usr_id" is a forein key to column "id" in table "usr"
     *
     * @access private
     * @return array   Collected linked references
     **/
    function _collectRefs($primaryKey)
    {
        $linkedRefs = array();

        // read in links ini file
        $this->links();
        // collect references between removed and linked to it objects
        global $_DB_DATAOBJECT;
        $links = $_DB_DATAOBJECT['LINKS'][$this->_database];
        foreach ($links as $table => $references){
            $column = array_search($this->_tableName.':'.$primaryKey, $references);
            if ($column !== false) {
                $linkedRefs[$table] = $column;
            }
        }
        return $linkedRefs;
    }

    /**
     * Delete all records referenced
     *
     * @access public
     * @return boolean  True on success else false
     **/
    function deleteCascade($linkedRefs, $primaryKey)
    {
        foreach ($linkedRefs as $table => $column) {
            $doLinkded = DB_DataObject::factory($table);
            if (PEAR::isError($doLinkded)) {
                return false;
            }

            $doLinkded->$column = $this->$primaryKey;
            // ON DELETE CASCADE
            $doLinkded->delete();
        }
    }

}

?>