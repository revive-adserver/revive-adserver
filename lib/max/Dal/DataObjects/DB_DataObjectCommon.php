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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/max/Util/ArrayUtils.php';
require_once MAX_PATH . '/lib/OA/Permission.php';

require_once 'DB/DataObject.php';

define('OA_DATETIME_PEAR_FORMAT', '%Y-%m-%d %H:%M:%S');
define('OA_DATETIME_FORMAT', 'Y-m-d H:i:s');

/**
 * A constant to force DataObjects to update a field and set it to the SQL NULL
 *
 * This is required as a PHP null would just make DO ignore the field when updating
 */
define('OX_DATAOBJECT_NULL', 'NULL');

/**
 * The non-DB specific Data Abstraction Layer (DAL) class for the User Interface (Admin).
 *
 * This class extends the PEAR::DB_DataObjects class, and adds extra functionality!
 *
 * @package    DataObjects
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

    /**
     * The local instance of a DB_DataOjects object for the audit table
     *
     * @var DataObjects_Audit
     */
    var $doAudit;

    //////////////////////////////////////////////////////////////////////
    // Public methods, added to help users to optimize the use of       //
    // DB_DataObjects                                                   //
    //////////////////////////////////////////////////////////////////////

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
     * Either insert new record or update existing one,
     * if the object already exists in the database
     *
     * @return mixed The ID of new record (if the PK is sequence), or
     *               or the boolean true.
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
     * A method to check if this DB_DataOject is in the hierarchy of objects which
     * belongs to the current Account User.
     *
     * The method uses information from the link.ini file to build the object hierarchy.
     *
     * @return mixed Returns true if belong to account, false if doesn't and null
     *               if it wasn't able to find this object in references.
     */
    function belongsToUsersAccount()
    {
        $accountId = OA_Permission::getAccountId();
        return $this->belongsToAccount($accountId);
    }

    /**
     * This method uses information from the DB_DataObjects links.ini file to handle
     * the hierarchy of tables, and find out if a DB_DataOjects "entity" belongs to
     * a given account ID.
     *
     * It checks if there is a linked (referenced) object to this object with
     * table==$accountTable and id==$accountId
     *
     * @param string $accountId The account ID to test if this DB_DataObject is
     *                          owned by.
     * @return boolean|null     Returns true if the entity belongs to the specified
     *                          account, false if doesn't, or null if it was not
     *                          possible to find the required object references.
     */
    function belongsToAccount($accountId = null)
    {
        // Set the account ID, if not passed in
        if (empty($accountId)) {
            $accountId = OA_Permission::getAccountId();
        }
        // Prepare $this with the required info of the "entity" to be tested
        if (!$this->N) {
            $key = $this->getFirstPrimaryKey();
            if (empty($this->$key)) {
                MAX::raiseError('Key on object is not set, table: '.$this->getTableWithoutPrefix());
                return null;
            }
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
        if (isset($cachedTables[$table][$link][$this->$key])) {
            $doCheck = OA_Dal::factoryDO($table);
            $doCheck->setFrom($cachedTables[$table][$link][$this->$key]);
            $doCheck->N = 1;
        } else {
            $doCheck = $this->getLink($key, $table, $link);
            if (!$doCheck) {
                return null;
            }
            $cachedTables[$table][$link][$this->$key] = $doCheck->toArray();
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
    * A method to return the number of rows found by the last call
    * to this DB_DataObject's find() method.
    *
    * @see DB_DataObject::count()
    *
    * @return integer The number of rows found.
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
     * @param string $listOrder
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
        $regs = null;
        if (preg_match("/^(.*) \([0-9]+\)$/D", $this->$columnName, $regs)) {
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

    //////////////////////////////////////////////////////////////////////
    // Protected methods. Could be overwritten in child classes but     //
    // it's good practice is to call them in child methods via          //
    // parent::methodName().                                            //
    //////////////////////////////////////////////////////////////////////

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
     * @return mixed True on success, false on failure, 0 on no data affected
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
        $result = parent::delete($useWhere);
        if ($result)
        {
            if (is_null($id))
            {
                $doAffected->fetch();
                $doAffected->audit(3, null, $parentid);
            }
            return true;
        }
        return $result;
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
     * A method for updating the data stored in the database for a given
     * DB_DataObject. Extends the {@link DB_DataObject::update()} method
     * to include auditing of the changes, if required.
     *
     * @see DB_DataObject::update()
     *
     * @access public
     * @param mixed $dataObject An optional parameter. Either a DB_DataObject
     *                          object that should be used for the update, or
     *                          the constant DB_DATAOBJECT_WHEREADD_ONLY, in
     *                          which case the current object's whereAdd()
     *                          method call value will be used to idenfity
     *                          one or more rows which will *all* be updated.
     * @return boolean True on update success, false otherwise.
     */
    function update($dataObject = false)
    {
        // Is this update for a single DB_DataObject, or potentially
        // more than one record?
        if ($dataObject == DB_DATAOBJECT_WHEREADD_ONLY)
        {
            $aDB_DataObjects = array();
            if ($this->_auditEnabled()) {
                // Prepare a new DB_DataObject to obtain all rows
                // that will be affected
                $doAffected = OA_Dal::factoryDO($this->_tableName);
                $doAffected->_query['condition'] = $this->_query['condition'];
                // Generate an array of all DB_DataObjects that will
                // be udpated
                $doAffected->find();
                while ($doAffected->fetch())
                {
                    $aDB_DataObjects[] = $doAffected->_cloneObjectFromDatabase();
                }
            }
            // Update ALL of the required records
            $result = parent::update($dataObject);
            if ($result)
            {
                // If required, log the changes in the audit trail
                foreach ($aDB_DataObjects as $doAffected)
                {
                    // Re-clone the object from the database to obtain
                    // what is now the updated DB_DataObject
                    $doUpdated = $doAffected->_cloneObjectFromDatabase();
                    $doUpdated->audit(2, $doAffected);
                }
            }
            return $result;
        }
        // Obtain a copy of the original DB_DataObject from the
        // database before updating the data
        $doOriginal = $this->_cloneObjectFromDatabase();
        // Update the "updated" field of this object
        $this->_refreshUpdated();
        // Update!
        $result = parent::update($dataObject);
        if ($result)
        {
            // If required, log the change in the audit trail
            $this->audit(2, $doOriginal);
        }
        return $result;
    }

    function setDefaultValue($fieldName, $fieldType)
    {
        if (isset($this->defaultValues[$fieldName]))
        {
            if ($this->defaultValues[$fieldName] === '%DATE_TIME%')
            {
                return date('Y-m-d H:i:s');
            }
            else if ($this->defaultValues[$fieldName] === '%NO_DATE_TIME%')
            {
                return OX_DATAOBJECT_NULL;
            }
            return $this->defaultValues[$fieldName];
        }
        else if ($fieldName == 'updated')
        {
            return date('Y-m-d H:i:s');
        }
        return NULL;
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

    //////////////////////////////////////////////////////////////////////
    // Private methods. Shouldn't be overwritten and shouldn't be       //
    // called directly unless it's really necessary and you know what   //
    // you are doing!                                                   //
    //////////////////////////////////////////////////////////////////////

    /**
     * A private method to create a new DB_DataObject of the same type
     * as the current DB_DataObject, copy over all of the current object's
     * primary key values (based on the result of the keys() method), and
     * then try to locate this record in the database.
     *
     * @access private
     * @return mixed Either the "original" DB_DataObject, if it can be
     *               found, otherwise false.
     */
    function _cloneObjectFromDatabase()
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
        global $_DB_DATAOBJECT;

        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }

        $_DB_DATAOBJECT['INI'][$this->_database]    = $this->_mergeIniFiles($_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"]);
        if (empty($_DB_DATAOBJECT['INI'][$this->_database]))
        {
            return false;
        }
        $_DB_DATAOBJECT['LINKS'][$this->_database]  = $this->_mergeIniFiles($_DB_DATAOBJECT['CONFIG']["links_{$this->_database}"]);
        if (empty($_DB_DATAOBJECT['LINKS'][$this->_database]))
        {
            return false;
        }

        $configDatabase = &$_DB_DATAOBJECT['INI'][$this->_database];

        // databaseStructure() is cached in memory so we have to add prefix to all definitions on first run
        if (!empty($this->_prefix))
        {
            $oldConfig = $configDatabase;
            foreach ($oldConfig as $tableName => $config)
            {
                $configDatabase[$this->_prefix.$tableName] = $configDatabase[$tableName];
            }
        }
        return true;
    }

    function _mergeIniFiles($aFiles)
    {
        $aResult = array();
        foreach ($aFiles as $ini)
        {
            if (file_exists($ini) && is_file($ini) && is_readable($ini))
            {
                $aIni = parse_ini_file($ini, true);
                $aResult = array_merge($aResult, $aIni);
                if (!empty($_DB_DATAOBJECT['CONFIG']['debug']))
                {
                    $this->debug("Loaded ini file: $ini","databaseStructure",1);
                }
            }
            else
            {
                if (!empty($_DB_DATAOBJECT['CONFIG']['debug']))
                {
                    if (!file_exists($ini))
                    {
                        $this->debug("Missing ini file: $ini","databaseStructure",1);
                    }
                    if ((!is_file($ini)) || (!is_readable ($ini)))
                    {
                        $this->debug("ini file is not readable: $ini","databaseStructure",1);
                    }
                }
            }
        }
        return $aResult;
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
     * Used by both insert() and update() to update the date/time
     * value stored in an "updated" field of the table.
     *
     * @TODO Deprecate this method if/when all "updated" fields have
     *       been removed from the schemata.
     *
     * @access private
     */
    function _refreshUpdated()
    {
        if ($this->refreshUpdatedFieldIfExists)
        {
            $fields = $this->table();
            if (array_key_exists('updated', $fields))
            {
                $this->updated = gmdate(OA_DATETIME_FORMAT);
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
        return true;
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

    /**
     * A private method to determine if auditing should be enabled for
     * a DB_DataObjectCommon-based class, or not (assuming that auditing
     * is globally enabled in the OpenX settings).
     *
     * Default is to not enable. Override in any children classes, as
     * required.
     *
     * @access private
     * @return boolean True if auditing should be performed, false
     *                 otherwise.
     */
    function _auditEnabled()
    {
        return false;
    }

    /**
     * A method to return an array of account IDs of the account(s) that
     * should "own" any audit trail entries for this entity type; these
     * are NOT related to the account ID of the currently active account
     * (which is performing some kind of action on the entity), but is
     * instead related to the type of entity, and where in the account
     * heirrachy the entity is located.
     *
     * @param boolean $resetCache When true, reset the internal cache and
     *                            return null.
     *
     * @return array An array containing up to three indexes:
     *                  - "OA_ACCOUNT_ADMIN" or "OA_ACCOUNT_MANAGER":
     *                      Contains the account ID of the manager account
     *                      that needs to be able to see the audit trail
     *                      entry, or, the admin account, if the entity
     *                      is a special case where only the admin account
     *                      should see the entry.
     *                  - "OA_ACCOUNT_ADVERTISER":
     *                      Contains the account ID of the advertiser account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     *                  - "OA_ACCOUNT_TRAFFICKER":
     *                      Contains the account ID of the trafficker account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     */
    public function getOwningAccountIds($resetCache = false)
    {
        return $this->_getOwningAccountIds(null, null, $resetCache);
    }

    /**
     * The underlying private method to getOwningAccountIdsreturn an array of account IDs of the account(s) that
     * should "own" any audit trail entries for this entity type; these
     * are NOT related to the account ID of the currently active account
     * (which is performing some kind of action on the entity), but is
     * instead related to the type of entity, and where in the account
     * heirrachy the entity is located.
     *
     * Works by locating the "account_id" column in this DB_DataObject,
     * and converting this into the array of owning account IDs.
     *
     * @param string $parentTable The name of another table to look in
     *                            for the "account_id" column, if this
     *                            DB_DataObject does not have such a column.
     * @param string $parentKey Name of the key that relates this
     *                          DB_DataObject and the parent entity in
     *                          $parentTable.
     * @param boolean $resetCache When true, reset the internal cache and
     *                            return null.
     *
     * @see DB_DataObjectCommon::getOwningAccountIds()
     */
    protected function _getOwningAccountIds($parentTable = null, $parentKeyName = null, $resetCache = false)
    {
        // Use a static cache to store previously calculated owning
        // account IDs
        static $aCache = array();

        // Reset the cache?
        if ($resetCache) {
            $aCache = array();
            return;
        }

        // Get this DB_DataObject's table name and primary key name
        $tableName      = $this->getTableWithoutPrefix();
        $primaryKeyName = $this->getFirstPrimaryKey();

        // Is this a call to get the owning account IDs directly from
        // this DB_DataObject, or do we need to look at a parent?
        if (is_null($parentTable) && is_null($parentKeyName)) {

            // Get the directly owning account ID from this DB_DataObject

            // If the owning account IDs have already been calculated,
            // return them directly
            if (!empty($aCache[$tableName][$this->$primaryKeyName])) {
                return $aCache[$tableName][$this->$primaryKeyName];
            }

            // Test to ensure that the account ID column exists in this
            // DB_DataObject
            $aColumns = $this->table();
            if (!isset($aColumns['account_id'])) {
                $message = "Cannot locate owning account IDs for entity in table '$tableName', " .
                            "as the table is not directly linked to an account.";
                OA::debug($message, PEAR_LOG_ERR);
                return false;
            }

            // Set the directly owning account ID based on the account_id
            // column value
            if (empty($this->account_id)) {
                $doThis = OA_Dal::staticGetDO($tableName, $this->$primaryKeyName);
                if ($doThis != false) {
                    $directOwnerAccountId = $doThis->account_id;
                }
            } else {
                $directOwnerAccountId = $this->account_id;
            }

            // Do we have the directly owning account ID?
            if (empty($directOwnerAccountId)) {
                $message = "Cannot locate owning account IDs for entity in table '$tableName', " .
                            "as the 'account_id' column was empty where column '$primaryKeyName' was " .
                            " equal to '{$this->$primaryKeyName}'.";
                OA::debug($message, PEAR_LOG_ERR);
                return false;
            }

            // Convert the directly onwing account ID into an array of owning
            // account IDs
            $aResult = $this->_getOwningAccountIdsByAccountId($directOwnerAccountId);

            // Store the result in the cache array
            $aCache[$tableName][$this->$primaryKeyName] = $aResult;

            // Return the result
            return $aCache[$tableName][$this->$primaryKeyName];

        } else {

            // Get the directly owning account ID from a parent table

            // If the owning account IDs have already been calculated,
            // return them directly
            if (!empty($aCache[$tableName][$this->$primaryKeyName][$parentTable])) {
                return $aCache[$tableName][$this->$primaryKeyName][$parentTable];
            }

            // Test to ensure that the parent key column passed into the
            // method exists in this DB_DataObject
            if (empty($this->$parentKeyName)) {
                $doThis = OA_Dal::staticGetDO($tableName, $this->$primaryKeyName);
                if ($doThis) {
                    $parentKeyValue = $doThis->$parentKeyName;
                }
            } else {
                $parentKeyValue = $this->$parentKeyName;
            }

            // Do we have the parent table key value?
            if (empty($parentKeyValue)) {
                $message = "Cannot locate owning account IDs for entity in table '$tableName', " .
                            "as the parent key value could not be located where column " .
                            "'$primaryKeyName' was  equal to '{$this->$primaryKeyName}'.";
                OA::debug($message, PEAR_LOG_ERR);
                return false;
            }

            // Get the DB_DataObject for the parnet table
            $doParent = OA_Dal::staticGetDO($parentTable, $parentKeyValue);
            if ($doParent == false) {
                $message = "Cannot locate owning account IDs for entity in table '$tableName', " .
                            "as the parent data object could not be created where column " .
                            "'$primaryKeyName' was  equal to '{$this->$primaryKeyName}'.";
                OA::debug($message, PEAR_LOG_ERR);
                return false;
            }

            // Get the result of calling the getOwningAccountIds() method on the
            // parent DB_DataObject
            $aResult = $doParent->getOwningAccountIds();

            // Store the result in the cache array
            $aCache[$tableName][$this->$primaryKeyName][$parentTable] = $aResult;

            // Return the result
            return $aCache[$tableName][$this->$primaryKeyName][$parentTable];
        }
    }

    /**
     * A private method to return the owning account IDs in a format suitable
     * for use by the DB_DataObjectCommon::getOwningAccountIds() method as a
     * return parameter, given the account ID of the account that is the owner
     * of the entity being audited.
     *
     * @access private
     * @param integer $accountId The account ID that "owns" the entity being
     *                           audited.
     * @return array An array with the same format as the return array of the
     *               DB_DataObjectCommon::getOwningAccountIds() method.
     */
    protected function _getOwningAccountIdsByAccountId($accountId)
    {
        // Get the type of the "owning" account
        $accountType = OA_Permission::getAccountTypeByAccountId($accountId);
        if ($accountType == OA_ACCOUNT_ADMIN) {
            // Simply return the admin account ID
            $aAccountIds = array(
                OA_ACCOUNT_ADMIN => $accountId
            );
        } else if ($accountType == OA_ACCOUNT_MANAGER) {
            // Simply return the manager account ID
            $aAccountIds = array(
                OA_ACCOUNT_MANAGER => $accountId
            );
        } else if ($accountType == OA_ACCOUNT_ADVERTISER) {
            // Set the owning manager account ID to the admin
            // account ID, in case something goes wrong
            $managerAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');
            // This is an advertiser account, so find the
            // "owning" manager account ID
            $doClients = OA_Dal::factoryDO('clients');
            $doClients->account_id = $accountId;
            $doClients->find();
            if ($doClients->getRowCount() == 1) {
                $doClients->fetch();
                $managerAccountId = $doClients->getOwningManagerId();
            }
            // Return the manager and advertiser account IDs
            $aAccountIds = array(
                OA_ACCOUNT_MANAGER    => $managerAccountId,
                OA_ACCOUNT_ADVERTISER => $accountId
            );
        } else if ($accountType == OA_ACCOUNT_TRAFFICKER) {
            // Set the owning manager account ID to the admin
            // account ID, in case something goes wrong
            $managerAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');
            // This is a trafficker account, so find the
            // "owning" manager account ID
            $doAffiliates = OA_Dal::factoryDO('affiliates');
            $doAffiliates->account_id = $accountId;
            $doAffiliates->find();
            if ($doAffiliates->getRowCount() == 1) {
                $doAffiliates->fetch();
                $managerAccountId = $doAffiliates->getOwningManagerId();
            }
            // Return the manager and trafficker account IDs
            $aAccountIds = array(
                OA_ACCOUNT_MANAGER    => $managerAccountId,
                OA_ACCOUNT_TRAFFICKER => $accountId
            );
        }
        return $aAccountIds;
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
        if (OA::getConfigOption('audit', 'enabled', false))
        {
            if ($this->_auditEnabled())
            {
                if (is_null($this->doAudit))
                {
                    $this->doAudit = $this->factory('audit');
                }
                $this->doAudit->actionid   = $actionid;
                $this->doAudit->context    = $this->getTableWithoutPrefix();
                $this->doAudit->contextid  = $this->_getContextId();
                $this->doAudit->parentid   = $parentid;
                $this->doAudit->username   = OA_Permission::getUsername();
                $this->doAudit->userid     = OA_Permission::getUserId();
                if (!isset($this->doAudit->usertype)) {
                    $this->doAudit->usertype = 0;
                }
                // Set the account IDs that need to be used in auditing
                // this type of entity record
                $aAccountIds = $this->getOwningAccountIds();
                // Set the primary account ID
                if (isset($aAccountIds[OA_ACCOUNT_MANAGER])) {
                    $this->doAudit->account_id = $aAccountIds[OA_ACCOUNT_MANAGER];
                } else {
                    $this->doAudit->account_id = $aAccountIds[OA_ACCOUNT_ADMIN];
                }
                // Set the advertiser account ID, if required
                if (isset($aAccountIds[OA_ACCOUNT_ADVERTISER])) {
                    $this->doAudit->advertiser_account_id = $aAccountIds[OA_ACCOUNT_ADVERTISER];
                }
                // Set the trafficker account ID, if required
                if (isset($aAccountIds[OA_ACCOUNT_TRAFFICKER])) {
                    $this->doAudit->website_account_id = $aAccountIds[OA_ACCOUNT_TRAFFICKER];
                }
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
                    // Perform post-audit actions
                    $this->_postAuditTrigger($actionid, $oDataObject, $id);
                    return $id;
                }
            }
        }

        return false;
    }

    function _getContext()
    {
        return false;
    }

    /**
     * Returns the date transformed into default format (as string)
     *
     * @param Date $date
     * @return string
     */
    function formatDate($date, $format = OA_DATETIME_PEAR_FORMAT)
    {
        return $date->format($format);
    }

    /**
     * perform post-audit actions
     *
     * @param integer $actionid
     * @param DB_DataObject_Common $dataobjectOld�
     * @param integer $auditId
     */
    function _postAuditTrigger($actionid, $dataobjectOld, $auditId)
    {
        // Stub function
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

        $aAuditFields = array();
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_INSERT:
            case OA_AUDIT_ACTION_DELETE:
                        // audit all data
                        foreach ($aFields AS $name => $type)
                        {
                            $aAuditFields[$name] = $this->_formatValue($name, $type);
                            if ($aAuditFields[$name] === NULL)
                            {
                                $aAuditFields[$name] = 'null';
                            }
                        }
                        break;
            case OA_AUDIT_ACTION_UPDATE:
                        $dataobjectNew = $this->_cloneObjectFromDatabase();
                        // only audit data that has changed
                        if ($dataobjectNew)
                        {
                            foreach ($aFields AS $name => $type)
                            {
                                // don't bother auditing timestamp changes?
                                if ($name <> 'updated')
                                {
                                    $valNew = $dataobjectNew->_formatValue($name, $type);
                                    $valOld = !empty($dataobjectOld) ? $dataobjectOld->_formatValue($name,$type) : '';
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

    /**
     * The child _formatValue() method is called first
     * allowing us to override specific formatting
     * this will fill in default formatting
     *
     * @param string $field
     * @param integer $type : dataobject type (found in db_schema.ini)
     * @return mixed
     */

    function _formatValue($field, $type ='')
    {
        switch ($type)
        {
            case 129:
            case 1:
                return (int) $this->$field;
            case 145:
                return $this->_boolToStr($this->$field);
//  text / blob fields
// override these in children?
            case 194:
            case 66:
                //return 'data too large to audit';
                return htmlspecialchars($this->$field);
            default:
                return $this->$field;
        }
    }

    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = '';
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