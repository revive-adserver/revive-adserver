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
 * A Data Generator class for easy 
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataGenerator
{
    /**
     * Use this data to populate any new records
     *
     * @var array
     */
    var $data;
    
    /**
     * Generate one record with default values and add insert it into database.
     * Returns id of created record
     *
     * @see DB_DataObject::insert()
     * @param DB_DataObjectCommon $do
     * @param bool $generateReferences
     * @return int
     * @access public
     * @static 
     */
    function generateOne($do, $generateReferences = false)
    {
        $ids = DataGenerator::generate($do, 1, $generateReferences);
        return array_pop($ids);
    }
    
    /**
     * Generate many records with default values and insert them into database.
     * Returns array ids of created records
     *
     * @todo generate parent references (all the records this record has a foreign key to)
     * 
     * @see DB_DataObject::insert()
     * @param DB_DataObjectCommon $do
     * @param int $numberOfCopies  How many records should be generated
     * @param bool $generateReferences
     * @return array
     * @access public
     * @static 
     */
    function generate($do, $numberOfCopies = 1, $generateReferences = false)
    {
        // cleanup ancestor ids
        DataGenerator::getReferenceId();
        
        if (is_string($do)) {
            $do = MAX_DB::factoryDO($do);
            if (PEAR::isError($do)) {
                return array();
            }
        }
        
        if ($generateReferences) {
            $links = $do->links();
        	foreach ($links as $key => $match) {
        		list($table,$link) = explode(':', $match);
        		$table = $do->getTableWithoutPrefix($table);
    	        $primaryKey = isset($do->$key) ? $do->$key : null;
        		$do->$key = DataGenerator::addAncestor($table, $primaryKey);
        	}
        }
        $doOriginal = clone($do);
        DataGenerator::setDefaultValues($do);
        DataGenerator::trackData($do->getTableWithoutPrefix());
        
        $ids = array();
        for ($i = 0; $i < $numberOfCopies; $i++) {
            $id = $do->insert();
            $do = clone($doOriginal);
            DataGenerator::setDefaultValues($do, $i+1);
            $ids[] = $id;
        }
        return $ids;
    }
    
    /**
     * Remove the data from all tables where DataGenerator generated any records
     *
     * @access public
     * @static 
     */
    function cleanUp($addTablesToCleanUp = array())
    {
        $tables = DataGenerator::trackData();
        $tables = array_merge($tables, $addTablesToCleanUp);
        foreach ($tables as $table) {
            $do = MAX_DB::factoryDO($table);
            $do->whereAdd('1=1');
            $do->delete($useWhere = true);
        }
        // cleanup ancestor ids
        DataGenerator::getReferenceId();
    }
    
    /**
     * This method allows to store and retreive any ids which were created
     * for ancestors records (all records created atuomatically if $generateReferences is true)
     *
     * @param string $table
     * @param int $id
     * @return int | false  Id or false if doesn't exist
     * @access public
     * @static 
     */
    function getReferenceId($table = null, $id = null)
    {
        static $ids;
        if (!isset($ids) || $table === null) {
            $ids = array();
        }
        if ($id !== null) {
            $ids[$table] = $id;
        }
        return isset($ids[$table]) ? $ids[$table] : false;
    }
    
    /**
     * Track tables where some data were generated so we could easily clean it up later
     *
     * @param string $table  If equal null it reset the static $tables
     * @return array
     * @access package private
     * @static 
     */
    function trackData($table = null)
    {
        static $tables;
        if (!isset($tables)) {
            $tables = array();
        }
        if ($table === null) {
            $ret = $tables;
            $tables = array();
            return $ret;
        } else {
            $tables[$table] = $table;
        }
        return $tables;
    }
    
    /**
     * Method adds related records recursively
     *
     * @param string $table  Table name
     * @return int  New ID
     * @access package private
     */
    function addAncestor($table, $primaryKey = null)
    {
        $doAncestor = MAX_DB::factoryDO($table);
        if ($primaryKey && $primaryKeyField = $doAncestor->getFirstPrimaryKey()) {
            // it's possible to preset parent id's (only one level up so far)
            $doAncestor->$primaryKeyField = $primaryKey;
        }
        DataGenerator::setDefaultValues($doAncestor);
        
        $links = $doAncestor->links();
    	foreach ($links as $key => $match) {
    		list($ancestorTable,$link) = explode(':', $match);
    		// remove prefix from it
    		$ancestorTable = $doAncestor->getTableWithoutPrefix($ancestorTable);
    		$doAncestor->$key = DataGenerator::addAncestor($ancestorTable);
    	}
    	DataGenerator::trackData($table);
    	$id = $doAncestor->insert();
    	DataGenerator::getReferenceId($table, $id); // store the id
        return $id;
    }
    
    /**
     * Check if DataObject has defined "defaultValues" array and if it does
     * set default values on DataObject. For all others fields
     * which are not set in default values set global default values
     * depends on field type.
     * 
     * This method doesn't change a value if DataObject already has a value assigned
     * to some of it's fields.
     *
     * @param DataObject $do
     * @return DataObject
     * @access package private
     * @static 
     */
    function setDefaultValues(&$do, $counter = 0)
    {
        foreach ($do->defaultValues as $k => $v) {
            if (!isset($do->$k)) {
                $do->$k = $v;
            }
        }
        $fields = $do->table();
        $keys = $do->keys();
        foreach ($fields as $fieldName => $fieldType) {
            if (!array_key_exists($fieldName, $keys) && (!isset($do->$fieldName))) {
                $do->$fieldName = DataGenerator::setDefaultValue($do->getTableWithoutPrefix(),
                    $fieldName, $counter);
            }
        }
    }
    
    /**
     * Return default data
     *
     * @todo Implement
     * 
     * @param string $fieldType
     * @return mixed
     * @access package private
     * @static 
     */
    function setDefaultValue($table, $fieldName, $counter)
    {
        if (isset($this)) {
            if (isset($this->data[$table]) && isset($this->data[$table][$fieldName])) {
                $index = $counter % count($this->data[$table][$fieldName]);
                return $this->data[$table][$fieldName][$index];
            }
        }
        return 1; // @TODO: Add a default value by type
    }
    
    /**
     * This method sets data which is used by DataGenerator to populate records
     * 
     *
     * @param string $table
     * @param array $data
     * @access public
     */
    function setData($table = null, $data = array())
    {
        if ($table === null) {
            // reset all
            $this->data = array();
        }
        $this->data[$table] = $data;
    }
}

?>