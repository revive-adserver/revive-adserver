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
    
    /**
     * Method overrides default DB_DataObject behaviour by adding table prefixes and
     * having a default database schema location
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
        
        $tableNameWithoutPrefix = $this->__table;

        $this->prefix = $GLOBALS['MAX']['conf']['table']['prefix'];
        $this->__table = $this->prefix . $this->__table;
        
        $configDatabase = &$_DB_DATAOBJECT['INI'][$this->_database];
        
        // "__table" has a prefix already, make sure it points to the same definition as used to before adding prefix
        if (!isset($configDatabase[$this->__table])) {
            $configDatabase[$this->__table] = $configDatabase[$this->tableNameWithoutPrefix];
        }
        
        if (!isset($configDatabase[$this->__table."__keys"])) {
            $configDatabase[$this->__table."__keys"] = $configDatabase[$this->tableNameWithoutPrefix."__keys"];
        }
        
        return true;
    }
    
    function delete($useWhere = false)
    {
        if ($this->onDeleteCascade) {
            // Find all affected tuples
            $doAffected = clone($this);
            if (!$useWhere) {
                // Clear any additional WHEREs if it's not used in delete statement
                $object->whereAdd();
            }
            $doAffected->find();
            
            // Simulate "ON DELETE CASCADE"
            $aKeys = $this->keys();
            if (count($aKeys) == 1) {
                // Resolve references automatically only for records with one column as Primary Key
                // If table has more than one column in PK it is still possible to remove
                // manually connected tables (by overriding delete() method)
                $primaryKey = $aKeys[0];
                
                $linkedRefs = $this->_collectRefs($primaryKey);
                $this->_deleteCascade($linkedRefs);
            }
        }
        
        return parent::delete($useWhere);
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
            $column = array_search($this->__table.':'.$primaryKey, $references);
            if ($column !== false) {
                $linkedRefs[$table] = $column;
            }
        }
        return $linkedRefs;
    }
    
    /**
     * Delete all records referenced
     * 
     * @access private
     * @return boolean  True on success else false
     **/
    function _deleteCascade($linkedRefs, $primaryKey)
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