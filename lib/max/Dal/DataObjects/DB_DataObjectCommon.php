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
require_once MAX_PATH . '/lib/max/Util/ArrayUtils.php';

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
     * If true "updated" field is automatically updated with current time on every insert and update
     *
     * @var unknown_type
     */
    var $refreshUpdatedFieldIfExists = false;
    
    /**
     * Any default values which could be set before inserting record into database.
     * So far it is only in use with DataGenerator
     * 
     * @see DataGenerator
     * @var array
     */
    var $defaultValues = array();
    
    /**
     * Store table prefix
     *
     * @var string
     */
    var $_prefix;
    
    /**
     * Keep reference dataobjects - required by addReferenceFilter()
     *
     * @var array
     * @see DB_DataObjectCommon::addReferenceFilter()
     */
    var $_aReferences = array();
    
    /**
     * If $triggerSqlDie is true DataObject behaves in exactly
     * the same way as we would execute phpAdsSqlDie() on any SQL failure.
     *
     * @var boolean
     */
    var $triggerSqlDie = true;
    
    /**
     * //// Public methods, added to help users to optimize the use of DataObjects
     */
    
    /**
     * Loads corresponding DAL class. Plain SQL should be kept inside DAL class
     *
     * @return object|false
     */
    function factoryDAL()
    {
    	include_once MAX_PATH . '/lib/max/Dal/Common.php';
    	return MAX_Dal_Common::factory($this->_tableName);
    }
    
    /**
     * OpenAds uses in many places arrays containing all records, for example 
     * array of all zones Ids associated with specific advertiser.
     * It is not encouraged to use this method for all purposes as it's
     * better to loop through all records and analyze one at a time.
     * But if you are looping through records just to create a array
     * use this method instead.
     *
     * @param array $filter  Contains fields which should be returned in each row
     * @param boolean $indexWithPrimaryKey  Should the array be indexed with primary key
     * @param boolean $flattenIfOneOnly     Flatten multidimensional array into one dimensional
     *                                      if $filter array contains only one field name
     * @return array
     */
    function getAll($filter = array(), $indexWithPrimaryKey = false, $flattenIfOneOnly = true)
    {
    	if (!is_array($filter)) {
    	    if (empty($filter)) $filter = array();
    	    $filter = array($filter);
    	}
        $primaryKey = null;
    	if ($indexWithPrimaryKey) {
			$primaryKey = $this->getFirstPrimaryKey();
    	}
    	if ($filter) {
    	    // select only what is required
    	    $this->selectAdd();
    	    foreach ($filter as $field) {
    	        $this->selectAdd($field);
    	    }
    	    // if we are indexing with pk add it here
    	    if ($indexWithPrimaryKey && !in_array($primaryKey, $filter)) {
    	        $this->selectAdd($primaryKey);
    	    }
    	}
        $this->find();
    	
    	$rows = array();
    	$fields = $this->table();
    	while ($this->fetch()) {
    		$row = array();
    		foreach ($fields as $k => $v) {
    			if (!isset($this->$k)) {
    				continue;
    			}
    			if (empty($filter) || in_array($k, $filter)) {
    			    $row[$k] = $this->$k;
    			}
    		}
    		if ($flattenIfOneOnly && count($row) == 1) {
    		    $row = array_pop($row);
    		}
    		if (!empty($primaryKey) && isset($this->$primaryKey)) {
    			$rows[$this->$primaryKey] = $row;
    		} else {
    			$rows[] = $row;
    		}
    	}
    	$this->free();
    	return $rows;
    }
    
    /**
     * This method uses information from links.ini to handle hierarchy of tables.
     * It checks if there is a linked (referenced) object to this object with
     * table==$userTable and id==$userId
     *
     * @param string $userTable It's table name where user belongs, eg: agency, affiliates, clients
     * @param string $userId    User id
     * @return boolean|null     Returns true if belong to user, false if doesn't and null if it wasn't able to find
     *                          object in references
     */
    function belongToUser($userTable, $userId)
    {
    	if (!$this->N && !$this->find($autoFetch = true)) {
    		return null;
    	}
    	
      	$found = null;
      	
    	$links = $this->links();
        if(!empty($links)) {
        	foreach ($links as $key => $match) {
        		list($table,$link) = explode(':', $match);
        		$table = $this->getTableWithoutPrefix($table);
        		if ($table == $userTable) {
        			return (isset($this->$key)
        			     && $this->$key == $userId);
        		} else {
        			// recursive
        			$doCheck = $this->getLink($key, $table, $link);
        			if (!$doCheck) {
        				return null;
        			}
        			$found = $doCheck->belongToUser($userTable, $userId);
        			if ($found !== null) {
        				return $found;
        			}
        		}
        	}
        }
        return $found;
    }
    
    /**
     * This method allows to automatically join DataObject with other records
     * using information from links.ini file. It allow for example to very
     * easly select all campaign which belong to specific agency.
     * {{{
     * $doCampaigns = MAX_DB::factoryDO('campaigns');
     * $doCampaigns->addReferenceFilter('agency', $agencyId);
     * $doCampaigns->find();
     * }}}
     * 
     * It's possible to add many filters to the same DataObject.
     * 
     * It raise PEAR_Error in case referenced table wasn't find
     *
     * @param string $referenceTable
     * @param string $tableId
     * @return boolean  True on success
     * @access public
     */
    function addReferenceFilter($referenceTable, $tableId)
    {
        if ($this->_tableName == $referenceTable) {
            $key = $this->getFirstPrimaryKey();
            $this->$key = $tableId;
            return true;
        }
        $found = $this->_addReferenceFilterRecursively($referenceTable, $tableId);
        if (!$found) {
            DB_DataObject::raiseError(
                    "Reference '{$referenceTable}' doesn't exist for table {$this->_tableName}",
                    DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        return $found;
    }
    
   /**
	* Returns the number of rows in a query
	* Note it returns number of records from the last search (find())
	* 
	* @see count()
	* @return int number of rows
	* @access public
	*/
	function getRowCount() {
		return $this->N;
	}
    
    /**
     * This method is a equivalent of phpAds_getFooListOrder
     * It adds orderBy() limitations to current DB_DataObject
     * 
     * This method is used as a common way of sorting rows in OpenAds UI
     *
     * @see MAX_Dal_Common::getSqlListOrder
     * @param string|array $nameColumns
     * @param string $direction
     * @access public
     */
    function addListOrderBy($listOrder, $orderDirection)
    {
        $dalModel = &$this->factoryDAL();
    	if (!$dalModel) {
    		return false;
    	}
    	$nameColumns = $dalModel->getOrderColumn($listOrder);
    	$direction   = $dalModel->getOrderDirection($orderDirection);
    	
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
        $this->whereAdd("LOWER($field) = '" . $this->escape(strtolower($value)) . "'");
    }
    
    /**
     * Return table name without the prefix
     *
     * @param string $table
     * @return string
     * @access public
     */
    function getTableWithoutPrefix($table)
    {
        if (!empty($this->_prefix) && strpos($table, $this->_prefix) === 0) {
            return substr($table, strlen($this->_prefix));
        }
        return $table;
    }
    
    /**
     * Get array of unique values from this object table and it's $columnName
     *
     * @param string $columnName  Column name to look for unique values inside
     * @param string $exceptValue Usually we need a list of unique value except
     *                            the one we already have
     * @return array
     * @access public
     */
    function getUniqueValuesFromColumn($columnName, $exceptValue = null) {
        $fields = $this->table();
        if (!array_key_exists($columnName, $fields)) {
            DB_DataObject::raiseError(
                    "no such field '{$columnName}' exists in table '{$this->_tableName}'",
                    DB_DATAOBJECT_ERROR_INVALIDARGS);
            return array();
        }
        $this->whereAdd($columnName . " <> ''");
        $aValues = $this->getAll(array($columnName));
        ArrayUtils::unsetIfKeyNumeric($aValues, $exceptValue);
        return $aValues;
    }
    
    /**
     * Used by duplicate() methods to create a new unique name for a record before
     * creating a copy of it.
     *
     * @param string $columnName  Column name to create a new unique name for
     * @return string
     */
    function getUniqueNameForDuplication($columnName)
    {
        $fields = $this->table();
        if (!array_key_exists($columnName, $fields)) {
            DB_DataObject::raiseError(
                    "no such field '{$columnName}' exists in table '{$this->_tableName}'",
                    DB_DATAOBJECT_ERROR_INVALIDARGS);
            return null;
        }
        if (ereg("^(.*) \([0-9]+\)$", $this->$columnName, $regs = null)) {
            $basename = $regs[1];
        } else {
            $basename = $this->$columnName;
        }
        
        $doCheck = $this->factory($this->_tableName);
        $names = $doCheck->getUniqueValuesFromColumn($columnName);
        // Get unique name
        $i = 2;
        while (in_array($basename.' ('.$i.')', $names)) {
            $i++;
        }
        return $basename.' ('.$i.')';
    }
    
    /**
     * Delete record by it's primary key id
     *
     * @param int $primaryId
     * @param boolean $useWhere
     * @param boolean $cascadeDelete
     * @return boolean  True on success
     * @see DB_DataObjectCommon::delete()
     * @access public
     */
    function deleteById($primaryId, $useWhere = false, $cascadeDelete = true)
    {
        $keys = $this->keys();
        if (count($keys) != 1) {
            DB_DataObject::raiseError(
                    "no primary key defined or more than one pk in table '{$this->_tableName}'",
                    DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        $primaryKey = $keys[0];
        $this->$primaryKey = $primaryId;
        $this->delete($useWhere, $cascadeDelete);
    }
    
    /**
     * Adds a condition to the WHERE statement
     * eg: bracketAdd('affiliateid', array(1,2,3), 'AND')
     * is changed into: whereAdd('(affiliateid = 1 OR affiliateid = 2 OR affiliateid = 3)', 'AND');
     * 
     * Question: Should we change it into WHERE IN?
     *
     * @param string $field
     * @param array $values
     * @param string $logic OR | AND
     * @return boolean  True on success
     * @access public
     */
    function whereInAdd($field, $values, $logic = 'AND')
    {
        if (empty($values)) {
            return true;
        }
        
        $condistions = array();
        foreach ($values as $value) {
            $condistions[] = $field." = '".$this->escape($value)."'";
        }
        $query = implode ($condistions, ' OR ');
        return $this->whereAdd($query, $logic);
    }
    
    /**
     * //// Protected methods, could be overwritten in child classes but
     * //// a good practice is to call them in child methods by parent::methodName()
     */
    
    /**
     * This method is calles explicite by MAX_DB class which
     * 
     * @access public
     */
    function init()
    {
        $ret = $this->_connect();
        if ($ret !== true) {
            return $ret;
        }
        global $_DB_DATAOBJECT;
        $_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"] = array(
            "{$_DB_DATAOBJECT['CONFIG']['schema_location']}/db_schema.ini",
        );
        $_DB_DATAOBJECT['CONFIG']["links_{$this->_database}"] = 
            "{$_DB_DATAOBJECT['CONFIG']['schema_location']}/db_schema.links.ini";
    	
        $this->databaseStructure();
        $this->_addPrefixToTableName();
    }
    
    /**
     * Override standard links() method, to make sure it reads correctly data from links.ini
     * file even if DataObjects uses prefix.
     * 
     * @access public
     * @see DB_DataObject::links()
     * @return array
     */
    function links()
    {
    	$links = parent::links();
    	if (empty($this->_prefix)) {
    		return $links;
    	} else {
    	    $prefixedLinks = array();
            $links = $GLOBALS['_DB_DATAOBJECT']['LINKS'][$this->_database][$this->_tableName];
            foreach ($links as $k => $v) {
    	        // add prefix
    	        $prefixedLinks[$k] = $this->_prefix.$v;
    	    }
    	    return $prefixedLinks;
    	}
    }
    
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
     * Override parent method to make sure that newly created dataobject
     * is properly initialized with prefixes.
     *
     * @param  string  $table  tablename (use blank to create a new instance of the same class.)
     * @access private
     * @return DataObject|PEAR_Error 
     */
    function factory($table = '')
    {
        if (isset($this) && !empty($this->_prefix)) {
            $table = $this->getTableWithoutPrefix($table);
            $do = parent::factory($table);
            if (!PEAR::isError($do)) {
                $do->init();
            }
            return $do;
        }
        return parent::factory($table);
    }
    
    /**
     * Could automatically handle updating "updated" datetime field
     * before calling parent update()
     *
     * @see DB_DataObject::update()
     * @param object $dataObject
     * @return boolean
     * @access public
     */
    function update($dataObject = false)
    {
        $this->_refreshUpdated();
        return parent::update($dataObject);
    }
    
    /**
     * Could automatically handle updating "updated" datetime field
     * before calling parent insert()
     *
     * @see DB_DataObject::insert()
     * @param object $dataObject
     * @return mixed
     * @access public
     */
    function insert()
    {
        $this->_refreshUpdated();
        return parent::insert();
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
        if (!parent::databaseStructure() && empty($_DB_DATAOBJECT['INI'][$this->_database])) {
            return false;
        }

        global $_DB_DATAOBJECT;
        $configDatabase = &$_DB_DATAOBJECT['INI'][$this->_database];

        // databaseStructure() is cached in memory so we have to add prefix to all definitions on first run
        if (!empty($this->_prefix)) {
            $oldConfig = $configDatabase;
            foreach ($oldConfig as $tableName => $config) {
                $configDatabase[$this->_prefix.$tableName] = $configDatabase[$tableName];
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
            $this->_prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
            $this->_tableName = $this->__table;
            $this->__table = $this->_prefix . $this->__table;
        }
    }

    /**
     * Used by both insert() and update() to update "updated" field
     * @access private
     */
    function _refreshUpdated()
    {
        if ($this->refreshUpdatedFieldIfExists) {
            $fields = $this->table();
            if (array_key_exists('updated', $fields)) {
                $this->updated = date('Y-m-d H:i:s');
            }
        }
    }
    
    /**
     * Added storing reference to DataBase connection
     * 
     * @todo Add sharing connections in connection Pool
     * @see DB_DataObject::_connect()
     * 
     * @return PEAR::error | true
     */
    function _connect()
    {
        $ret = parent::_connect();
        if (PEAR::isError($ret)) {
            return false;
        }
        global $_DB_DATAOBJECT;
        $dbh = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
        // store the reference in ADMIN_DB_LINK
        $GLOBALS['_MAX']['ADMIN_DB_LINK'] = &$dbh->connection;
        
        return $ret;
        /*
        // FIXME: following doesn't work because MAX doesn't use standard DB_mysql extension...
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            $this->_loadConfig();
        }
        $dbh = &MAX_DB::singleton();
        if (PEAR::isError($dbh)) {
            return $dbh;
        }
        $this->_database_dsn_md5 = md5(MAX_DB::getDsn(MAX_DSN_STRING, false));
        $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5] = &$dbh;
        */
    }
    
    /**
     * Disconnects from the database server
     *
     * @return boolean
     * @static 
     */
    function disconnect()
    {
        $ret = true;
        // reset DataObject cache
        $dsn = MAX_DB::getDsn(MAX_DSN_STRING, false);
        $dsn_md5 = md5($dsn);
        global $_DB_DATAOBJECT;
        if (isset($_DB_DATAOBJECT['CONNECTIONS'][$dsn_md5])) {
            $dbh = &$_DB_DATAOBJECT['CONNECTIONS'][$dsn_md5];
            if (!PEAR::isError($dbh)) {
                $ret = $dbh->disconnect();
            }
            unset($_DB_DATAOBJECT['CONNECTIONS'][$dsn_md5]);
        }
        
        return $ret;
    }
    
    /**
     * Added handling any errors caused by queries send from DataObjects to database
     *
     * @param string $string  Query
     * @return PEAR_Error or mixed none
     */
    function _query($string)
    {
        $production = empty($GLOBALS['_MAX']['CONF']['debug']['production']) ? false : true;
	    if ($production) {
	       // supress any PEAR errors if in production
	       PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
	    }
	    
	    // execute query
	    $ret = parent::_query($string);
	    
	    if (PEAR::isError($ret)) {
	        if(!$production) {
	           $GLOBALS['_MAX']['ERRORS'][] = $ret;
	        }
    	    if ($this->triggerSqlDie) {
    	        global $phpAds_last_query;
                $phpAds_last_query = $ret->userinfo;
// quick fix for CC, working atm on generalization of this
//                include_once MAX_PATH . '/www/admin/lib-gui.inc.php';
//                phpAds_sqlDie();
    	    }
	    }
	    if ($production) {
		  PEAR::staticPopErrorHandling();
	    }
	    return $ret;
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
            $doLinkded->init();

            $doLinkded->$column = $this->$primaryKey;
            // ON DELETE CASCADE
            $doLinkded->delete();
        }
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
    
    /**
     * Recursively join DataObject with referenced table by it's id.
     *
     * @param string $referenceTable
     * @param string $tableId
     * @return boolean  True if founf reference
     */
    function _addReferenceFilterRecursively($referenceTable, $tableId)
    {
      	$found = false;
      	
    	$links = $this->links();
        if(!empty($links)) {
        	foreach ($links as $key => $match) {
        	    if ($found) {
        	        break;
        	    }
        		list($table,$link) = explode(':', $match);
        		$table = $this->getTableWithoutPrefix($table);
        		if ($table == $referenceTable) {
        		    // if the same table just add a reference
        		    $this->$key = $tableId;
        		    $found = true;
        		} else {
        			// recursive step
        			if (isset($this->_aReferences[$table])) {
        			    // check if DataObject is already created
        			    // it allows to add few filters to one DataObject
        			    $doReference = &$this->_aReferences[$table];
        			    $doReference->$link = $this->$key;
        			    $found = true;
        			} else {
            			$doReference = $this->factory($table);
            			$this->_aReferences[$table] = &$doReference;
            			if (PEAR::isError($doReference)) {
            				return false;
            			}
            			$doReference->$link = $this->$key;
            			if ($doReference->_addReferenceFilterRecursively($referenceTable, $tableId)) {
            			    $this->joinAdd($doReference);
            			    $found = true;
            			}
        			}
        		}
        	}
        }
        return $found;
    }
    
    /**
     * Returns first primary key (if exists)
     *
     * @return string
     * @access public
     */
    function getFirstPrimaryKey()
    {
    	$keys = $this->keys();
    	return !empty($keys) ? $keys[0] : null;
    }
    
}

?>