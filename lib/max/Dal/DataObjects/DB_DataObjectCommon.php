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
     * If true delete() method will try to delete also all records which has reference to this record
     *
     * @var boolean
     */
    var $onDeleteCascade = false;
    
    /**
     * //// Public methods, added to help users to optimize the use of DataObjects
     */
    
    /**
     * This method is a equivalent of MAX_Dal_Common::getSqlListOrder
     * but instead of SQL it adds orderBy() limitations to current DB_DataObject
     * 
     * This method is used as a common way of sorting rows in OpenAds UI
     *
     * @see MAX_Dal_Common::getSqlListOrder
     * @param string|array $nameColumns
     * @param string $direction
     * @access public
     */
    function addListOrderBy($nameColumns, $direction)
    {
        if (!is_array($nameColumns)) {
            $nameColumns = array($nameColumns);
        }
        foreach ($nameColumns as $nameColumn) {
            $this->orderBy($nameColumn . ' ' . $direction);
        }
    }
    
    /**
     * Adds a case-insensitive (lower) WHERE condition using the MySQL LOWER() function.
     *
     * @param string $field  the database column to test
     * @param mixed $value  the value to compare
     * @access public
     */
    function whereAddLower($field, $value)
    {
        $this->whereAdd("LOWER($field) = " . strtolower($this->escape($value)));
    }
    
    /**
     * //// Protected methods, could be overwritten in child classes but
     * //// a good practice is to call them in child methods by parent::methodName()
     */
    
    /**
     * Overwrite DB_DataObject::delete() method and add a "ON DELETE CASCADE"
     *
     * @param boolean $cascadeDelete  If true it deletes also referenced tables
     *                                if this behavior is set in DataObject.
     *                                With this parameter it's possible to turn off default behavior
     *                                @see DB_DataObjectCommon:onDeleteCascade
     * @param boolean $useWhere
     * @return boolean
     * @access protected
     */
    function delete($useWhere = false, $cascadeDelete = true)
    {

        $this->_addPrefixToTableName();

        if ($this->onDeleteCascade && $cascadeDelete) {
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
     * //// Private methods - shouldn't be overwritten and you shouldn't call them directly
     * //// until it's really necessary and you know what your are doing
     */
    
    /**
     * Keeps the original (without prefix) table name
     *
     * @var string
     */
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
     * @access private
     */
    function _addPrefixToTableName()
    {
        if (empty($this->_tableName)) {
            $this->prefix = $GLOBALS['MAX']['conf']['table']['prefix'];
            $this->_tableName = $this->__table;
            $this->__table = $this->prefix . $this->__table;
        }
    }

    /**
     * Delete all referenced records
     *
     * Although it's a public access to this method it shouldn't be called outside
     * this class. The only reason it's not private is because it needs to be executed
     * on new objects.
     * 
     * @return boolean  True on success else false
     * @access public
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
    
    /**
     * Connect is used inside DB_DataObject to connect preload config
     * We will override this "private" method to add additional settings required
     * to use prefixes
     *
     * @return true | PEAR::error
     * @access private
     */
    function _connect()
    {
        $this->_addPrefixToTableName();
        return parent::_connect();
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
     * @access private
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
}

?>