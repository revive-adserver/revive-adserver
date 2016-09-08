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

require_once MAX_PATH . '/lib/OA/Dal.php';

/**
 * This is the default value which will be used for all
 * fields which don't have data set.
 * If you do not want to use this default value use method:
 * DataGenerator::defaultValueByType(MAX_DATAGENERATOR_DEFAULT_TYPE, 'your_default_data_here');
 */
define('MAX_DATAGENERATOR_DEFAULT_VALUE', 1);

/**
 * Use this this data type to set default data.
 * @see MAX_DATAGENERATOR_DEFAULT_VALUE
 */
define('MAX_DATAGENERATOR_DEFAULT_TYPE', -1);

/**
 * Default date value used for generating default data for date fields
 */
define('MAX_DATAGENERATOR_DEFAULT_DATE_VALUE', date('Y-m-d'));

/**
 * A DataGenerator class for easy data generation
 *
 * Online manual: https://developer.openx.org/wiki/DataGenerator
 *
 * @package    OpenXDal
 */
class DataGenerator
{
    /**
     * Data conteiner
     * Use this data to populate any new records
     * @see getFieldValueFromDataContainer()
     *
     * @var array
     */
    var $data;

    /**
     * Generate one record. Wrapper for: generate($do, 1, $generateParents)
     * Returns id of created record
     *
     * @static
     * @access public
     * @param DB_DataObjectCommon $do Either DataObject or table name (as string)
     * @param bool $generateParents   Generate parent records
     * @return int                    Id of created record
     * @see DB_DataObject::insert()
     */
    function generateOne($do, $generateParents = false)
    {
        if (!empty($this) && is_a($this, 'DataGenerator')) {
            $ids = $this->generate($do, 1, $generateParents);
        } else {
            $ids = DataGenerator::generate($do, 1, $generateParents);
        }
        return array_pop($ids);
    }

    /**
     * Generate records (populate them with either prepared or default values) and insert into database.
     * This method could create parent records (we call "parent" all records in tables where generated
     * record has foreign keys linked to).
     *
     * Returns array ids of created records.
     *
     * Examples:
     *
     * // Lazy generate 7 records
     * $aMytableIds = DataGenerator::generate('mytable', 7);
     *
     * // Create dataobject and pass it into generator
     * $doMyTable = OA_Dal::factoryDO('mytable');
     * $doMyTable->column1 = 'some value';
     * $aMytableIds = DataGenerator::generate($doMyTable, 7);
     *
     * @see DB_DataObject::insert()
     * @param mixed $do              Either DataObject or table name (as string)
     * @param int $numberOfCopies    How many records should be generated
     * @param bool $generateParents  Should parent records be generated?
     * @return array                 Array ids of created records
     * @access public
     * @static
     */
    function generate($do, $numberOfCopies = 1, $generateParents = false)
    {
        // Cleanup ancestor ids
        DataGenerator::getReferenceId();

        if (is_string($do)) {
            // Lazy DataObject initialization
            $do = OA_Dal::factoryDO($do);
            if (PEAR::isError($do)) {
                return array();
            }
        }
        if ($generateParents) {
	        if (!empty($this) && is_a($this, 'DataGenerator')) {
    	       $this->generateParents($do);
	        } else {
    	       DataGenerator::generateParents($do);
	        }
        }
        $doOriginal = clone($do);
        if (isset($this) && is_a($this, 'DataGenerator')) {
            $this->setDefaultValues($do);
        } else {
            DataGenerator::setDefaultValues($do);
        }
        DataGenerator::trackData($do->getTableWithoutPrefix());

        $ids = array();
        for ($i = 0; $i < $numberOfCopies; $i++) {
            $id = $do->insert();
            $do = clone($doOriginal);
            if (!empty($this) && is_a($this, 'DataGenerator')) {
                $this->setDefaultValues($do, $i+1);
            } else {
                DataGenerator::setDefaultValues($do, $i+1);
            }
            $ids[] = $id;
        }
        return $ids;
    }

    /**
     * Generate parents records using the relationship defined in links.ini file
     *
     * @param DB_DataObject $do
     */
    function generateParents(&$do)
    {
        $links = $do->links();
    	foreach ($links as $foreignKey => $linkedTableField) {
    	    if (!empty($do->$foreignKey)) {
    	        // parent is already set
    	        continue;
    	    }
    		list($linkedTable, $linkedField) = explode(':', $linkedTableField);
    		$table = $do->getTableWithoutPrefix($linkedTable);
    	    if ($table == 'accounts') {
    	        // Don't create accounts via DataGenerator. DataObjects already take care of it.
    	        continue;
    	    }
	        $linkedPrimaryKeyVal = isset($do->$foreignKey) ? $do->$foreignKey : null;
	        if (!empty($this) && is_a($this, 'DataGenerator')) {
    	       $do->$foreignKey = $this->addAncestor($table, $linkedPrimaryKeyVal);
	        } else {
    	       $do->$foreignKey = DataGenerator::addAncestor($table, $linkedPrimaryKeyVal);
	        }
    	}
    }

    /**
     * Remove the data from all tables where DataGenerator generated any records,
     * and also reset the auditing account ownership cache.
     *
     * @param array $addTablesToCleanUp  Array of any additional tables DataGenerator should
     *                                   delete data from
     * @access public
     * @static
     */
    function cleanUp($addTablesToCleanUp = array())
    {
        $tables = DataGenerator::trackData();
        $tables = array_merge($tables, $addTablesToCleanUp);
        foreach ($tables as $table) {
            $do = OA_Dal::factoryDO($table);
            $do->whereAdd('1=1');
            $do->delete($useWhere = true);
            DataGenerator::resetSequence($table);
        }
        // Cleanup ancestor ids
        DataGenerator::getReferenceId();
        // Clean up the auditing account ownership cache
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->getOwningAccountIds(true);
    }

    /**
     * This method allows to store and retreive any primary key's ids which were created
     * for ancestors records
     *
     * Example of use:
     * // Assume following line will create 'subtable' table and it's parent 'table' record
     * $subtableId = DataGenerator::generate('subtable', 1, $generateParents = true);
     * // Following command retrieves ID of 'table' record
     * $tableId = DataGenerator::getReferenceId('table');
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
     * This method is used for tracking tables where some data were generated
     * so DataGenerator knows how and what to clean up later
     *
     * @param string $table     Table name to track, if it's equal null it reset all the data
     * @return array            Array of stored tables names
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
     * Method adds related "parent/ancestor" records recursively.
     *
     * It should be used only to create records which have only one primary key.
     *
     * Note: in theory it should work for ancestor records with multiple primary keys
     * but this behaviour is undefined.
     *
     * @param string $table       Table name
     * @param string $primaryKey  Used as primary key for ancestor
     * @return int  New ID
     * @access package private
     */
    function addAncestor($table, $primaryKey = null)
    {
        $doAncestor = OA_Dal::factoryDO($table);
        if ($primaryKey && $primaryKeyField = $doAncestor->getFirstPrimaryKey()) {
            // it's possible to preset parent id's (only one level up so far)
            $doAncestor->$primaryKeyField = $primaryKey;
        }
        if (!empty($this) && is_a($this, 'DataGenerator')) {
            $this->setDefaultValues($doAncestor);
        } else {
            DataGenerator::setDefaultValues($doAncestor);
        }

        $links = $doAncestor->links();
    	foreach ($links as $foreignKey => $linkedTableField) {
    		list($ancestorTableWithPrefix, $link) = explode(':', $linkedTableField);
    		$ancestorTable = $doAncestor->getTableWithoutPrefix($ancestorTableWithPrefix);
    	    if ($ancestorTable == 'accounts') {
    	        // Don't create accounts via DataGenerator. DataObjects already take care of it.
    	        continue;
    	    }
    		if (isset($this) && is_a($this, 'DataGenerator')) {
    		    $fieldValue = $this->getFieldValueFromDataContainer($table, $foreignKey);
    		} else {
    		    $fieldValue = DataGenerator::getFieldValueFromDataContainer($table, $foreignKey);
    		}
    		if(isset($fieldValue) && !isset($GLOBALS['dataGeneratorDontOptimize'])) { //hack for quick test fix
    		    $doAncestor->$foreignKey = $fieldValue;
    		} else {
        		if (isset($this) && is_a($this, 'DataGenerator')) {
        		    $doAncestor->$foreignKey = $this->addAncestor($ancestorTable);
        		} else {
        		    $doAncestor->$foreignKey = DataGenerator::addAncestor($ancestorTable);
        		}
    		}
    	}
    	DataGenerator::trackData($table);
    	$id = $doAncestor->insert();
    	DataGenerator::getReferenceId($table, $id); // store the id
        return $id;
    }

    /**
     * This method checks if there is any data prepared for record or it uses
     * default data based on type of the field.
     *
     * It looks for data for each field in record in following order:
     * 1. Checks if data is set in DataObject
     * 2. Checks data from data container (@see setData())
     * 3. Checks data from $defaultValues variables defined in each DataObject
     * 4. Generate data based on type of the field
     *
     * It populates primary keys fields only if data for key field was specifically
     * set using any of methods defined in 1, 2 or 3 (it doesn't
     * populate it with default data based on field type)
     *
     * @param DataObject $do    DataObject to populate data in
     * @param int $counter      Used to generate a key for data container array to retreive data
     * @access package private
     * @static
     */
    function setDefaultValues(&$do, $counter = 0)
    {
        $fields = $do->table();
        $keys = $do->keys();
        $table = $do->getTableWithoutPrefix();
        foreach ($fields as $fieldName => $fieldType) {
            if (!isset($do->$fieldName)) {
                if (!empty($this) && is_a($this, 'DataGenerator')) {
                    $fieldValue = $this->getFieldValueFromDataContainer($table, $fieldName, $counter);
                } else {
                    $fieldValue = DataGenerator::getFieldValueFromDataContainer($table, $fieldName, $counter);
                }
                if(!isset($fieldValue) && !in_array($fieldName, $keys))
                {
                    $fieldValue = DataGenerator::defaultValueForObject($do, $fieldName, $fieldType);
                    if(!isset($fieldValue))
                    {
                        $fieldValue = DataGenerator::defaultValueByType($fieldType);
                    }
                }
                if (isset($fieldValue)) {
                    if ($fieldValue != OX_DATAOBJECT_NULL) {
                        // exception for NULLs
                        $do->$fieldName = $fieldValue;
                    }
                }
            }
        }
    }

    /**
     * Return value for a specified field in the table
     * if it was previously set in data container
     *
     * @param string $table     Table name
     * @param string $fieldName Field (column) name
     * @return mixed Data defined for field or null if data wasn't prepared in data container
     * @access package private
     * @static
     */
    function getFieldValueFromDataContainer($table, $fieldName, $counter = 0)
    {
        if (isset($this)) {
            if (isset($this->data[$table]) && isset($this->data[$table][$fieldName])) {
                if (is_array($this->data[$table][$fieldName])) {
                    $index = $counter % count($this->data[$table][$fieldName]);
                    return $this->data[$table][$fieldName][$index];
                } else {
                    return $this->data[$table][$fieldName];
                }
            }
        }
        return null;
    }
    /**
     * Return (or set) a default field value based individual dataobjects default array
     *
     * @see DB_DataObject for list of defined field types
     *
     * @param DataObject $do    DataObject to populate data in
     * @param string $fieldName Field (column) name
     * @return string
     * @static
     */
    function defaultValueForObject(&$do, $fieldName, $fieldType)
    {
        return $do->setDefaultValue($fieldName, $fieldType);
    }

    /**
     * Return (or set) a default field value based on field type
     *
     * @see DB_DataObject for list of defined field types
     *
     * @param string $fieldType        Field type to set
     * @param string $setDefaultValue  Value to set
     * @return string
     * @static
     */
    function defaultValueByType($fieldType, $setDefaultValue = null)
    {
        static $aDefaultValues;

        if ($setDefaultValue !== null) {
            $aDefaultValues[$fieldType] = $setDefaultValue;
        }
        if (isset($aDefaultValues[$fieldType])) {
            return $aDefaultValues[$fieldType];
        }
        // This is the only exception we found so far, if we will find more we may need
        // to refactor following
        if ($fieldType & DB_DATAOBJECT_DATE) {
            if ($fieldType & DB_DATAOBJECT_NOTNULL) {
                return MAX_DATAGENERATOR_DEFAULT_DATE_VALUE;
            }
            return null;
        }
        // If no default set for this data type try default type
        if (isset($aDefaultValues[MAX_DATAGENERATOR_DEFAULT_TYPE])) {
            return $aDefaultValues[MAX_DATAGENERATOR_DEFAULT_TYPE];
        }
        // If still nothing found use a global default
        return MAX_DATAGENERATOR_DEFAULT_VALUE;
    }

    /**
     * This method sets data in data container which is used by DataGenerator to populate records
     *
     * Format of data to use. Example:
     * $data = array(
     *   'column1' => array('value for first record', 'value for second record'),
     *   'column2' => array('populare all created records with this'),
     * );
     * $dg = new DataGenerator();
     * $dg->setData('mytable', $data);
     * $dg->generateOne('mytable');
     *
     * Generator use data set in data container to populate fields for new
     * records. It loops over columns arrays and reuse data for few records.
     * For example if we will generate 10 records with data defined in example
     * five records will consist 'value for first record' and five
     * 'value for second record'.
     * Example:
     * $data = array(
     *   'fieldName' => array('value 1', 'value 2'),
     *   'agency_id' => array(1),
     * );
     * $dg = new DataGenerator();
     * $dg->setData('tableName', $data);
     * $dg->generate('tableName', 3);
     *
     *
     * @param string $table  Table name
     * @param array $data    Save prepared data in data container
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


    /**
     * Performs the same operation as #setData($table,$data), but the
     * $data must contain only a single value for a column instead of
     * an array of values.
     *
     * Example:
     * $data = array('clientsid' => 1, 'name' => 'Mega Pack');
     *
     * @param string $table
     * @param array $data
     */
    function setDataOne($table = null, $data = array())
    {
        $convertedData = array();
        foreach($data as $column => $value) {
            $convertedData[$column] = array($value);
        }
        $this->setData($table, $convertedData);
    }

    /**
     * Resets a (postgresql) sequence to 1
     * similar to OA_DB_Table::resetSequence()
     * DOESN'T SEEM TO WORK THO
     *
     * @param string $sequence the name of the sequence to reset
     * @return boolean true on success, false otherwise
     */
    function resetSequence($tableName)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();

        if ($aConf['database']['type'] == 'pgsql')
        {
            OA_DB::setCaseSensitive();
            $aSequences = $oDbh->manager->listSequences();
            OA_DB::disableCaseSensitive();
            if (is_array($aSequences))
            {
                OA::debug('Resetting sequence ' . $sequence, PEAR_LOG_DEBUG);
                RV::disableErrorHandling();
                $tableName = substr($aConf['table']['prefix'].$tableName, 0, 29).'_';
                foreach ($aSequences AS $k => $sequence)
                {
                    if (strpos($sequence, $tableName) === 0)
                    {
                        $sequence = $oDbh->quoteIdentifier($sequence.'_seq',true);
                        $result = $oDbh->exec("SELECT setval('$sequence', 1, false)");
                        break;
                    }
                }
                RV::enableErrorHandling();
                if (PEAR::isError($result)) {
                    OA::debug('Unable to reset sequence on table ' . $tableName, PEAR_LOG_ERR);
                    return false;
                }
            }

        }
        else if ($aConf['database']['type'] == 'mysql' || $aConf['database']['type'] == 'mysqli')
        {
            $tableName = $aConf['table']['prefix'].$tableName;
            RV::disableErrorHandling();
            $result = $oDbh->exec("ALTER TABLE {$tableName} AUTO_INCREMENT = 1");
            RV::enableErrorHandling();
            if (PEAR::isError($result)) {
                OA::debug('Unable to reset sequence on table ' . $tableName, PEAR_LOG_ERR);
                return false;
            }
        }

        return true;
    }
}

?>