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
     * @return int
     * @access public
     * @static 
     */
    function generate($do, $numberOfCopies = 1, $generateReferences = false)
    {
        DataGenerator::setDefaultValues($do);

        if ($generateReferences) {
            $links = $do->links();
        	foreach ($links as $key => $match) {
        		list($table,$link) = explode(':', $match);
        		$table = $do->getTableWithoutPrefix($table);
    	        $primaryKey = isset($do->$key) ? $do->$key : null;
        		$do->$key = DataGenerator::addAncestor($table, $primaryKey);
        	}
        }
        
        
        $ids = array();
        
        for ($i = 0; $i < $numberOfCopies; $i++) {
            $doInsert = clone($do);
            $id = $doInsert->insert();
            $ids[] = $id;
        }
        return $ids;
    }
    
    /**
     * Method adds related records recursively
     *
     * @param string $table  Table name
     * @return int  New ID
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
    		list($table,$link) = explode(':', $match);
    		$table = $doAncestor->getTableWithoutPrefix($table);
    		$doAncestor->$key = DataGenerator::addAncestor($table);
    	}
        return $doAncestor->insert();
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
     * @access public
     * @static 
     */
    function setDefaultValues(&$do)
    {
        foreach ($do->defaultValues as $k => $v) {
            if (!isset($do->$k)) {
                $do->$k = $v;
            }
        }
        $fields = $do->table();
        $keys = $do->keys();
        foreach ($fields as $fieldName => $fieldType) {
            if (!array_key_exists($fieldName, $keys) && !isset($do->$fieldName)) {
                $do->$fieldName = DataGenerator::setDefaultValue($fieldType);
            }
        }
    }
    
    /**
     * Return default data by type
     *
     * @todo Implement
     * 
     * @param string $fieldType
     * @return mixed
     */
    function setDefaultValue($fieldType)
    {
        return 1; // @TODO: Add a default value by type
    }
}

?>