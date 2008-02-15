<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/max/Util/ArrayUtils.php';
require_once MAX_PATH . '/lib/OA/Permission.php';

require_once 'DB/DataObject.php';

/**
 * The non-DB specific Data Abstraction Layer (DAL) class for the User Interface (Admin).
 *
 * @package    DataObjects
 * @author     David Keen <david.keen@openx.org>
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class DB_DataObjectCommon extends DB_DataObject
{
    /**
     * If its true the delete() method will try to delete also all
     * records which has reference to this record
     *
     * @var boolean
     */
    var $onDeleteCascade = false;

    /**
     * An array that contains tables that need to be skipped during on delete cascade
     *
     * @var array
     */
    var $onDeleteCascadeSkip = array();

    /**
     * If true "updated" field is automatically updated with
     * current time on every insert and update
     *
     * @var unknown_type
     */
    var $refreshUpdatedFieldIfExists = false;

    /**
     * Any default values which could be set before inserting records into database
     * using DataGenerator.
     *
     * There is one template variable:
     * %DATE_TIME% is replaced with date('Y-m-d H:i:s')
     *
     * @see DataGenerator
     * @var array
     */
    var $defaultValues = array(
        'updated' => '%DATE_TIME%'
    );

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

    var $doAudit;

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
     * OpenX uses in many places arrays containing all records, for example
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
            if (empty($filter)) {
                $filter = array();
            } else {
               $filter = array($filter);
            }
        }

        $fields = $this->table();
        $primaryKey = null;
        if ($indexWithPrimaryKey) {
            if ($indexWithPrimaryKey === true) {
                // index by first primary key
                $primaryKey = $this->getFirstPrimaryKey();
            } else {
                // use as a primary key to index
                $primaryKey = $indexWithPrimaryKey;
            }
        }
        if (!$this->N) {
            // search only if find() wasn't executed yet
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
        }

        $rows = array();
        while ($this->fetch()) {
            $row = array();
            foreach ($fields as $field => $fieldType) {
                if (!isset($this->$field)) {
                    continue;
                }
                if (empty($filter) || in_array($field, $filter)) {
                    $row[$field] = $this->$field;
                }
            }
            if ($flattenIfOneOnly && count($row) == 1) {
                $row = array_pop($row);
            }
            if (!empty($primaryKey) && isset($this->$primaryKey)) {
                // add primaty key to row if filter is empty or if it exists in filter
                if ((empty($filter) || in_array($primaryKey, $filter)) && !array_key_exists($primaryKey, $row)) {
                    $row[$primaryKey] = $this->$primaryKey;
                }
                $rows[$this->$primaryKey] = $row;
            } else {
                $rows[] = $row;
            }
        }
        $this->free();
        return $rows;
    }

    /**
     * Either insert new record or update existing one
     * if the object is already created
     *
     * @return integer  ID of new record (if PK is sequence) or boolean
     */
    function save()
    {
        $this->limit(1);
        if (!$this->update()) {
            return $this->insert();
        }
        return true;
    }

    /**
     * Checks if there is any object in hierarchy of objects (it uses information from link.ini to buil hierarchy)
     * which belongs to user's account.
     *
     * @return boolean|null     Returns true if belong to account, false if doesn't and null if it wasn't
     *                          able to find object in references
     */
    function belongsToUsersAccount()
    {
        $accountId = OA_Permission::getAccountId();
        return $this->belongsToAccount($accountId);
    }

    /**
     * This method uses information from links.ini to handle hierarchy of tables.
     * It checks if there is a linked (referenced) object to this object with
     * table==$accountTable and id==$accountId
     *
     * @param string $accountId Account id
     * @return boolean|null     Returns true if belong to account, false if doesn't and null if it wasn't
     *                          able to find object in references
     */
    function belongsToAccount($accountId = null)
    {
        if (empty($accountId)) {
            $accountId = OA_Permission::getAccountId();
        }
        if (!$this->N) {
            if (!$this->find($autoFetch = true)) {
                return null;
            }
        }
        // Does the table have an account_id field?
        $aFields = $this->table();
        if (isset($aFields['account_id']) && $this->account_id == $accountId) {
            return true;
        }
        $found = null;
        $links = $this->links();
        if(!empty($links)) {
            foreach ($links as $key => $match) {
                list($table,$link) = explode(':', $match);
                $table = $this->getTableWithoutPrefix($table);
                $doCheck = &$this->getCachedLink($key, $table, $link);
                if (!$doCheck) {
                    return null;
                }
                $found = $doCheck->belongsToAccount($accountId);
                if ($found !== null) {
                    return $found;
                }
            }
        }
        return $found;
    }

    /**
     * Cache in static variable records found in the process of checking
     * whether the object belongs to user. This eliminates sending some
     * queries few times to database.
     *
     * @see DB_DataObject::getLink() for a description of used parameters.
     *
     * @param string $key
     * @param string $table
     * @param string $link
     * @return DB_DataObject_Common
     */
    function &getCachedLink($key, $table, $link)
    {
        static $cachedTables;
        if (is_null($cachedTables)) {
            $cachedTables = array();
        }
        if (isset($cachedTables[$table][$link][$ths->$key])) {
            $doCheck = OA_Dal::factoryDO($table);
            $doCheck->setFrom($cachedTables[$table][$link][$ths->$key]);
            $doCheck->N = 1;
        } else {
            $doCheck = $this->getLink($key, $table, $link);
            if (!$doCheck) {
                return null;
            }
            $cachedTables[$table][$link][$ths->$key] = $doCheck->toArray();
        }
        return $doCheck;
    }

    /**
     * This method allows to automatically join DataObject with other records
     * using information from links.ini file. It allow for example to very
     * easly select all campaign which belong to specific agency.
     * {{{
     * $doCampaigns = OA_Dal::factoryDO('campaigns');
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
     * Reads the correct sorting order from session and calls addListOrderBy()
     *
     * This method is used as a common way of sorting rows in OpenX UI
     *
     * @see MAX_Dal_Common::addListOrderBy
     * @param string $pageName  Page name where session sorting data is kept
     * @access public
     */
    function addSessionListOrderBy($pageName)
    {
        global $session;
        if (isset($session['prefs'][$pageName]['listorder'])) {
			$navorder = $session['prefs'][$pageName]['listorder'];
		} else {
			$navorder = '';
		}
		if (isset($session['prefs'][$pageName]['orderdirection'])) {
			$navdirection = $session['prefs'][$pageName]['orderdirection'];
		} else {
			$navdirection = '';
		}
		$this->addListOrderBy($navorder, $navdirection);
    }

    /**
     * This method is a equivalent of phpAds_getFooListOrder
     * It adds orderBy() limitations to current DB_DataObject
     *
     * This method is used as a common way of sorting rows in OpenX UI
     *
     * @see MAX_Dal_Common::getSqlListOrder
     * @param string|array $nameColumns
     * @param string $direction
     * @access public
     */
    function addListOrderBy($listOrder = '', $orderDirection = '')
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
     * @access private
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
    function getTableWithoutPrefix($table = null)
    {
        if ($table === null) {
            $table = $this->__table;
        }
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
        $this->selectAdd();
        $this->selectAdd("DISTINCT $columnName AS $columnName");
        $this->whereAdd($columnName . " <> ''");
        $this->find();
        $aValues = $this->getAll($columnName);
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
        return $this->delete($useWhere, $cascadeDelete);
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
     * This method is called explicitly by the OA_Dal class methods used
     * to instantiate implementations of this class.
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
            if ($GLOBALS['_DB_DATAOBJECT']['LINKS'][$this->_database][$this->_tableName]) {
                $links = $GLOBALS['_DB_DATAOBJECT']['LINKS'][$this->_database][$this->_tableName];
                foreach ($links as $k => $v) {
                    // add prefix
                    $prefixedLinks[$k] = $this->_prefix.$v;
                }
            }
            return $prefixedLinks;
        }
    }

    /**
     * Overwrite DB_DataObject::delete() method and add a "ON DELETE CASCADE"
     *
     * @param boolean $useWhere
     * @param boolean $cascadeDelete  If true it deletes also referenced tables
     *                                if this behavior is set in DataObject.
     *                                With this parameter it's possible to turn off default behavior
     *                                @see DB_DataObjectCommon:onDeleteCascade
     * @param boolean $parentid The audit ID of the parent object causing the cascade.
     * @return boolean
     * @access protected
     */
    function delete($useWhere = false, $cascadeDelete = true, $parentid = null)
    {
        $this->_addPrefixToTableName();

        // clone this object and retrieve current values for auditing
        $doAffected = clone($this);
        if (!$useWhere) {
            // Clear any additional WHEREs if it's not used in delete statement
            $doAffected->whereAdd();
        }
        $doAffected->find();

        if ($this->onDeleteCascade && $cascadeDelete) {
            $aKeys = $this->keys();

            // Simulate "ON DELETE CASCADE"
            if (count($aKeys) == 1) {
                // Resolve references automatically only for records with one column as Primary Key
                // If table has more than one column in PK it is still possible to remove
                // manually connected tables (by overriding delete() method)
                $primaryKey = $aKeys[0];
                $linkedRefs = $this->_collectRefs($primaryKey);

                foreach ($this->onDeleteCascadeSkip as $table) {
                    unset($linkedRefs[$table]);
                }

                // Find all affected tuples
                while ($doAffected->fetch())
                {
                    $id = $doAffected->audit(3, null, $parentid);
                    // Simulate "ON DELETE CASCADE"
                    $doAffected->deleteCascade($linkedRefs, $primaryKey, $id);
                }
            }
        }
        if (parent::delete($useWhere))
        {
            if (is_null($id))
            {
                $doAffected->fetch();
                $doAffected->audit(3, null, $parentid);
            }
            return true;
        }
        return false;
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
        $ret = parent::factory($table);
        $ret->init();
        return $ret;
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
        $doOriginal = $this->getChanges();
        $this->_refreshUpdated();
        $result = parent::update($dataObject);
        if ($result) {
            $this->audit(2, $doOriginal);
        }
        return $result;
    }

    function getChanges()
    {
        $aKeys = $this->keys();
        if ($aKeys)
        {
            $doOriginal = OA_Dal::factoryDO($this->_tableName);
            if ($doOriginal)
            {
                foreach ($aKeys as $k => $v)
                {
                    $doOriginal->$v = $this->$v;
                }
                if ($doOriginal->find(true))
                {
                    return $doOriginal;
                }
            }
        }
        return false;
    }

    function _getKey()
    {
        $key = false;
        $aKeys = $this->keys();
        if (isset($aKeys[0]))
        {
            $key = $aKeys[0];
        }
        return $key;
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
        $result = parent::insert();
        $this->audit(1);
        return $result;
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
     * @access package private
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
            $this->_prefix = OA_Dal::getTablePrefix();
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
     * @return PEAR_Error | true
     */
    function _connect()
    {
        if ($this->_database_dsn_md5 && !empty($GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'][$this->_database_dsn_md5]) && $this->_database) {
            return true;
        }

        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            $this->_loadConfig();
        }
        $dbh = &OA_DB::singleton();
        if (PEAR::isError($dbh)) {
            return $dbh;
        }
        $this->_database_dsn_md5 = md5(OA_DB::getDsn());
        $GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'][$this->_database_dsn_md5] = &$dbh;
        $GLOBALS['_DB_DATAOBJECT']['CONFIG']['quote_identifiers'] = ($dbh->options['quote_identifier']);

        $this->_database = $dbh->getDatabase();

        // store the reference in ADMIN_DB_LINK - backward compatibility
        $GLOBALS['_MAX']['ADMIN_DB_LINK'] = &$dbh->connection;

        return parent::_connect();
    }

    function _loadConfig()
    {
        global $_DB_DATAOBJECT;

        if(!isset($_DB_DATAOBJECT['CONFIG'])) {
            parent::_loadConfig();
        }

        // Set DB Driver as MDB2
        $_DB_DATAOBJECT['CONFIG']['db_driver'] = 'MDB2';
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
        $dsn = OA_DB::getDsn();
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
        if ($production) {
          PEAR::staticPopErrorHandling();
        }

        if (PEAR::isError($ret)) {
            if(!$production) {
               $GLOBALS['_MAX']['ERRORS'][] = $ret;
            }
            if ($this->triggerSqlDie && function_exists('phpAds_sqlDie')) {
                $GLOBALS['phpAds_last_query'] = $string;
                if (empty($GLOBALS['_MAX']['PAN']['DB'])) {
                    $GLOBALS['_MAX']['PAN']['DB'] = $GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'][$this->_database_dsn_md5];
                }
                phpAds_sqlDie();
            }
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
    function deleteCascade($linkedRefs, $primaryKey, $parentid)
    {
        foreach ($linkedRefs as $table => $column) {
            $doLinkded = DB_DataObject::factory($table);
            if (PEAR::isError($doLinkded)) {
                return false;
            }
            $doLinkded->init();

            $doLinkded->$column = $this->$primaryKey;
            // ON DELETE CASCADE
            $doLinkded->delete(false, true, $parentid);
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
    
    /**
     * Quotes the string so it could be used safely inside SQL queries
     *
     * @param string $string  Value to quote
     * @return string
     */
    function quote($val)
    {
        $oDbh = &OA_DB::singleton();
        return $oDbh->quote($val);
    }
    
    /**
     * Fetch DataObject by property
     *
     * @param unknown_type $propertyName
     * @param unknown_type $propertyValue
     * @return unknown
     */
    function loadByProperty($propertyName, $propertyValue)
    {
        $fields = $this->table();
        if (!isset($fields[$propertyName])) {
            MAX::raiseError($propertyName.' is not a field in table '.$this->getTableWithoutPrefix(), PEAR_LOG_ERR);
            return false;
        }
        $this->$propertyName = $propertyValue;
        if (!$this->find()) {
            return false;
        }
        return $this->fetch();
    }


    /**
     * A method to create a new account for entities
     *
     * @param string $accountType
     * @return boolean
     */
    function createAccount($accountType, $accountName)
    {
        $doAccount = $this->factory('accounts');
        $doAccount->account_type = $accountType;
        $doAccount->account_name = $accountName;
        $this->account_id = $doAccount->insert();
        return $this->account_id;
    }

    /**
     * Updates account name
     *
     * @param String $name
     * @return boolean
     */
    function updateAccountName($name)
    {
        if (empty($this->account_id)) {
            // do not perform update if object wasn't fetched
            return true;
        }
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->get($this->account_id);
        $doAccounts->account_name = $name;
        return $doAccounts->update();
    }

    /**
     * A method to delete an account linked to an entity
     *
     * @return boolean
     */
    function deleteAccount()
    {
        if (!empty($this->account_id)) {
            $doAccount = $this->factory('accounts');
            $doAccount->account_id = $this->account_id;
            $doAccount->delete();
        }
    }

    /**
     * A method to create a new user
     *
     * @param array $aUser
     * @return int The User Id
     */
    function createUser($aUser) {
        $doUser = OA_Dal::factoryDO('users');
        $doUser->setFrom($aUser);
        $userId = $doUser->insert();
        if (!$userId) {
            return false;
        }

        $result = OA_Permission::setAccountAccess($this->account_id, $userId);
        if (!$result) {
            return false;
        }

        return $userId;
    }

    function _auditEnabled()
    {
        return false;
    }

    /**
     * A private method to return the account ID of the
     * account that should "own" audit trail entries for
     * this entity type; NOT related to the account ID
     * of the currently active account performing an
     * action.
     *
     * @return int The account ID to insert into the
     *             "account_id" column of the audit trail
     *             database table
     */
    function getOwningAccountId()
    {
        static $aCache = array();

        $primaryKey = $this->getFirstPrimaryKey();
        $tableName  = $this->getTableWithoutPrefix();

        if (!empty($aCache[$tableName][$this->$primaryKey])) {
            return $aCache[$tableName][$this->$primaryKey];
        }

        $aColumns = $this->table();
        if (!isset($aColumns['account_id'])) {
            MAX::raiseError($tableName.' is not directly linked to accounts', PEAR_LOG_ERR);
        }
        if (!empty($this->account_id)) {
            $doThis = OA_Dal::staticGetDO($tableName, $this->$primaryKey);
            if ($doThis) {
                $account_id = $doThis->account_id;
            }
        } else {
            $account_id = $this->account_id;
        }

        if (empty($account_id)) {
            MAX::raiseError('No account ID associated to the entity', PEAR_LOG_ERR);
        }

        return $aCache[$tableName][$this->$primaryKey] = $account_id;
    }

    /**
     * A private method to return all the account IDs of the
     * accounts that own the entity
     *
     * @return array An array containing all the account IDs
     */
    function getAllOwningAccountIds()
    {
        return array($this->getOwningAccountId());
    }

    /**
     * A private method to return the account ID of the
     * parent entity
     *
     * @param string $parentTable The parent table name
     * @param string $parentKey   The parent key in the current table
     * @param bool   $allAccounts If true, the function returns all the possible accounts,
     *                            not only the root (manager) account
     * @return mixed The account ID to insert into the
     *               "account_id" column of the audit trail
     *               database table, or an array in case $allAccounts is true
     */
    function _getOwningAccountIdFromParent($parentTable, $parentKey, $allAccounts = false)
    {
        static $aCache = array();

        $primaryKey = $this->getFirstPrimaryKey();
        $tableName  = $this->getTableWithoutPrefix();

        if (!empty($aCache[$tableName][$this->$primaryKey][$allAccounts])) {
            return $aCache[$tableName][$this->$primaryKey][$allAccounts];
        }

        if (empty($this->$parentKey)) {
            $doThis = OA_Dal::staticGetDO($tableName, $this->$primaryKey);
            if ($doThis) {
                $value = $doThis->$parentKey;
            }
        } else {
            $value = $this->$parentKey;
        }
        if (empty($value)) {
            MAX::raiseError('No parent ID associated to the entity', PEAR_LOG_ERR);
        }

        $doParent = OA_Dal::staticGetDO($parentTable, $value);
        if (!$doParent) {
            MAX::raiseError('No parent entity found', PEAR_LOG_ERR);
        }

        $method = $allAccounts ? 'getAllOwningAccountIds' : 'getOwningAccountId';

        return $aCache[$tableName][$this->$primaryKey][$allAccounts] = $doParent->$method();
    }

    /**
     * Enter description here...
     *
     * @param integer $actionid One of the following:
     *                              - 1 for INSERT
     *                              - 2 for UPDATE
     *                              - 3 for DELETE
     * @param unknown_type $oDataObject
     * @param unknown_type $parentid
     * @return unknown
     */
    function audit($actionid, $oDataObject = null, $parentid = null)
    {
        if (isset($GLOBALS['_MAX']['CONF']['audit']) && $GLOBALS['_MAX']['CONF']['audit']['enabled'])
        {
            if ($this->_auditEnabled())
            {
                if (is_null($this->doAudit))
                {
                    $this->doAudit = $this->factory('audit');
                }
                $this->doAudit->actionid   = $actionid;
                $this->doAudit->context    = $this->_getContext();
                $this->doAudit->contextid  = $this->_getContextId();
                $this->doAudit->parentid   = $parentid;
                $this->doAudit->username   = OA_Permission::getUsername();
                $this->doAudit->userid     = OA_Permission::getUserId();
                if (!isset($this->doAudit->usertype)) {
                    $this->doAudit->usertype = 0;
                }
                // Set the account ID of the account that directly owns the
                // item being audited
                $this->doAudit->account_id = $this->getOwningAccountId();
                // Prepare a generic array of data to be stored in the audit record
                $aAuditFields = $this->_prepAuditArray($actionid, $oDataObject);
                // Individual objects can customise this data (add, remove, format...)
                $this->_buildAuditArray($actionid, $aAuditFields);
                // Do not audit if nothing has changed
                if (count($aAuditFields)) {
                    // Serialise the data
                    $this->doAudit->details = serialize($aAuditFields);
                    $this->doAudit->updated = OA::getNowUTC();
                    // Finally, insert the audit record
                    $id = $this->doAudit->insert();
                    return $id;
                }
            }
        }

        return false;
    }

    /**
     * build a generic audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _prepAuditArray($actionid, $dataobjectOld)
    {
        global $_DB_DATAOBJECT;
        $oDbh = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
        $aFields = $_DB_DATAOBJECT['INI'][$oDbh->database_name][$this->_tableName];

        switch ($actionid)
        {
            case OA_AUDIT_ACTION_INSERT:
            case OA_AUDIT_ACTION_DELETE:
                        // audit all data
                        foreach ($aFields AS $name => $type)
                        {
                            $aAuditFields[$name] = $this->$name;
                        }
                        break;
            case OA_AUDIT_ACTION_UPDATE:
                        $dataobjectNew = $this->getChanges();
                        // only audit data that has changed
                        if ($dataobjectNew)
                        {
                            foreach ($aFields AS $name => $type)
                            {
                                // don't bother auditing timestamp changes?
                                if ($name <> 'updated')
                                {
                                    $valNew = $dataobjectNew->_formatValue($name);
                                    $valOld = !empty($dataobjectOld) ? $dataobjectOld->_formatValue($name) : '';
                                    if ($valNew != $valOld)
                                    {
                                        $aAuditFields[$name]['was'] = $valOld;
                                        $aAuditFields[$name]['is']  = $valNew;
                                    }
                                }
                            }
                        }
                        else
                        {
                            //MAX::raiseError('No dataobject for '.$this->_tableName.'. Unable to prep the audit array', PEAR_LOG_ERR);
                        }
        }
        return $aAuditFields;
    }

    function _formatValue($field)
    {
        return $this->$field;
    }

    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = '';
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_INSERT:
                        break;
            case OA_AUDIT_ACTION_UPDATE:
                        break;
            case OA_AUDIT_ACTION_DELETE:
                        break;
        }
    }

    function _boolToStr($val)
    {
        if (is_numeric($val))
        {
            switch ($val)
            {
                case '0':
                case 0:
                    return 'false';
                case '1':
                case 1:
                    return 'true';
                default:
                    return $val;
            }
        }
        elseif (is_bool($val))
        {
            switch ($val)
            {
                case false:
                    return 'false';
                case true:
                    return 'true';
            }
        }
        else
        {
            switch ($val)
            {
                case 'f':
                case 'n':
                case 'N':
                case 'false':
                    return 'false';
                case 't':
                case 'y':
                case 'Y':
                case 'true':
                    return 'true';
                default:
                    return $val;
            }
        }
    }

}

?>
