<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: mdb2.inc.php,v 1.32 2004/11/27 02:06:42 jeffmoore Exp $
*/
//--------------------------------------------------------------------------------
/**
* Make sure dataspace is loaded
*/
if (!class_exists('DataSpace')) {
	require MAX_PATH . '/lib/wact/db/dataspace.inc.php';
}

/**
* Include PEAR::MDB2
*/
require_once 'MDB2.php';

//--------------------------------------------------------------------------------
/**
* Encapsulates a database connection.  Allows for lazy connections.
* implements Connection interface
* @see Connection
* @see http://wact.sourceforge.net/index.php/Connection
* @access public
* @package WACT_DB
*/
class MDB2Connection {
	/**
	* PEAR MDB2 Connection object
	* @var object subclass of PEAR::MDB2_Common
	* @access private
	*/
	var $ConnectionId;

	/**
	* Configuration information
	* @var string
	* @access private
	*/
	var $config;

	/**
	* Create a PEAR::MDB2 database connection.
	* @param object Connection Configuration information
	* @access private
	*/
	function __construct(&$config) {
		$this->config =& $config;
	}

	/**
	* Return connectionId for a PEAR database.  Allow a lazy connection.
	* @return object subclass of PEAR::MDB2_Common
	* @access protected
	*/
	function & getConnectionId() {
		if (!isset($this->ConnectionId)) {
			$this->connect();
		}
		return $this->ConnectionId;
	}

	/**
	* Connect to the the database
	* @return void
	* @access protected
	*/
	function connect() {
	    // use existing connection
	    $dbh = OA_DB::singleton();

	    if (PEAR::isError($dbh)) {
	        $this->RaiseError();
	    } else {
	        $this->ConnectionId =& $dbh;
	    }
	}

	/**
	* Raises an error, passing it on to the framework level error mechanisms
	* @param string (optional) SQL statement
	* @return void
	* @access private
	*/
	function RaiseError($error = NULL, $sql = NULL) {
	    if (empty($error)) {
		    $error = & $this->getConnectionId();
	    }
		$id = 'DB_ERROR';
		$info = array('driver' => 'mdb2');
		if (MDB2::isError($error)) {
			$errno = $error->getCode();
			if ($errno != -1) {
				$info['errorno'] = $errno;
				$info['error'] = $error->getMessage();
				$id .= '_MESSAGE';
			}
		}
		if (!is_null($sql)) {
			$info['sql'] = $sql;
			$id .= '_SQL';
		}
		RaiseError('db', $id, $info);
	}

	/**
	* Convert a PHP value into an SQL literal.  The type to convert to is
	* based on the type of the PHP value passed, or the type string passed.
	*
	* WARNING: while in MDB2 a boolean is mapped to CHAR(1) ['Y' | 'N'],
	* the WACT preferred way is an integer [1 | 0]
	* (as a side note, MDB2 is still in its beta stage,
	* so the bool-char(1) mapping may be changed in the near future)
	*
	* @param mixed value to convert
	* @param string (optional) type to convert to
	*   Allowable types are: boolean, string, int, float.
	* @return string literal SQL fragment
	* @access public
	*/
	function makeLiteral($value, $type = NULL) {
		if (is_null($value)) {
			return 'NULL';
		}
		if (is_null($type)) {
			$type = gettype($value);
		}
		switch (strtolower($type)) {
            case 'string':
                $conn = & $this->getConnectionId();
                return $conn->quote($value, 'text');
            case 'boolean':
                $conn = & $this->getConnectionId();
                //return $conn->quote($value, 'boolean');
                return $conn->quote($value, 'integer');
            case 'null':
                return 'NULL';
            default:
                return strval($value);
		}
	}

	/**
	* Factory function to create a Record object
	* @see http://wact.sourceforge.net/index.php/NewRecord
	* @param DataSpace or subclass (optional)
	*   used to initialize the fields of the new record prior to calling insert()
	* @return Record reference
	* @access public
	*/
	function NewRecord($DataSpace = NULL) {
		$Record = new MDB2Record($this);
		if (!is_null($DataSpace)) {
			$Record->import($DataSpace->export());
		}
		return $Record;
	}

	/**
	* Factory function used to retrieve more than one row from a MDB2 database,
	* applying a filter to the data if supplied as an argument
	* @see http://wact.sourceforge.net/index.php/NewRecordSet
	* @param string SQL statement
	* @param object filter class (optional)
	* @return RecordSet reference
	* @access public
	*/
	function NewRecordSet($query, $filter = NULL) {
		$RecordSet = new MDB2RecordSet($this, $query);
		if (!is_null($filter)) {
			$RecordSet->registerFilter($filter);
		}
		return $RecordSet;
	}

	/**
	* Factory function used to retrieve more than one row from a MDB database,
	* applying a filter to the data if supplied as an argument, and applying a
	* pager to the result set as well.
	* @param string SQL statement
	* @param object pager
	* @param object filter class (optional)
	* @return RecordSet reference
	* @access public
	*/
	function NewPagedRecordSet($query, &$pager, $filter = NULL) {
		$RecordSet = $this->NewRecordSet($query, $filter);
		$RecordSet->paginate($pager);
		return $RecordSet;
	}

	/**
	* Retrieve a single record from the database based on a query.
	* @param string SQL Query
	* @return Record object or NULL if not found
	* @access public
	*/
	function FindRecord($query) {
		$Record = new MDB2Record($this);
		$QueryId = $this->_execute($query);
		$Record->properties =& $QueryId->fetchRow(MDB2_FETCHMODE_ASSOC);
		$QueryId->free();
		if (is_array($Record->properties)) {
			return $Record;
		}
	}

	/**
	* Get a single value from the first column of a single record from
	* a database query.
	* @param string SQL Query
	* @return Value or NULL if not found
	* @access public
	*/
	function getOneValue($query) {
		$QueryId = $this->_execute($query);
		$val = $QueryId->fetch();
		$QueryId->free();
		return $val;
	}

	/**
	* Retrieve an array where each element of the array is the value from the
	* first column of a database query.
	* @param string SQL Query
	* @access public
	*/
	function getOneColumnArray($query) {
		$Column = array();
		$QueryId = $this->_execute($query);
		$Column = $QueryId->fetchCol();
		$QueryId->free();
		return $Column;
	}

	/**
	* Retrieve an associative array where each element of the array is based
	* on the first column as a key and the second column as data.
	* @param string SQL Query
	* @access public
	*/
	function getTwoColumnArray($query) {
		$Column = array();
		$QueryId = $this->_execute($query);
		while (is_array($row = $QueryId->fetchRow())) {
			$Column[$row[0]] = $row[1];
		}
		$QueryId->free();
		return $Column;
	}

	/**
	* Performs any query that does not return a cursor.
	* @param string SQL query
	* @return boolean TRUE if query is successful
	*/
	function execute($sql) {
		return (Boolean) $this->_execute($sql);
	}

	/**
	* For internal driver use only
	* @param string SQL query
	* @return object PEAR MDB2_Result or MDB2_Error
	* @access public
	*/
	function _execute($sql) {
	    $conf = $GLOBALS['_MAX']['CONF'];
	    if (!empty($conf['debug']['production'])) {
	       // supress any PEAR errors as we are handling them anyway in RaiseError method
	       PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
	    }
		$conn = & $this->getConnectionId();
		$result = & $conn->query($sql);
	    if (!empty($conf['debug']['production'])) {
		  PEAR::staticPopErrorHandling();
	    }

		if (MDB2::isError($result)) {
			$this->RaiseError($result, $sql);
			return;
		}
		return $result;
	}

	/**
	* Disconnect from database
	* @return void
	* @access public
	*/
	function disconnect() {
	    if (is_object($this->ConnectionId)) {
    		$this->ConnectionId->disconnect();
    		$this->ConnectionId = NULL;
        }
	}

}

/**
* Encapsulates operations on a database via PEAR::MDB2. Generally this
* class is only used for INSERT, UPDATE and DELETE operations
* implements Record interface
* @see Record
* @see http://wact.sourceforge.net/index.php/Record
* @access public
* @package WACT_DB
*/
class MDB2Record extends DataSpace {
	/**
	* Database connection encasulated in MDB2Connection
	* @var MDB2Connection instance
	* @access private
	*/
	var $Connection;

	/**
	* Construct a record
	* @param MDB2Connection
	* @access protected
	*/
	function __construct(& $Connection) {
		$this->Connection = & $Connection;
	}

	/**
	* Build a list of values to assign to columns
	* @param array associative of field_name => type
	* @param array associative (optional)  of field_name => value
	* @return array List of values to assign
	* @access protected
	*/
	function buildAssignmentList($fields, $extrafields) {
		$queryParams = array();
		foreach ($fields as $fieldname => $type) {
			if (!is_string($fieldname)) {
				$fieldname = $type; // Swap if no type is specified
				$type = NULL;
			}
			$queryParams[$fieldname] = $this->Connection->makeLiteral(
				$this->get($fieldname), $type
			);
		}
		if (!is_null($extrafields)) {
			foreach ($extrafields as $fieldname => $value) {
				$queryParams[$fieldname] = $value;
			}
		}
		return $queryParams;
	}

	/**
	* INSERT a record into a table with a primary key represented by a
	* auto_increment/serial column and return the primary key of the
	* inserted record.
	* the field list parameter allows expressions to defined in the sql
	* statements as well as field values defined in the record.
	* @param string table name
	* @param array associative of field_name => type
	* @param string Name of primary key field field
	* @param array associative (optional)  of field_name => value
	* @return integer Primary key of the newly inserted record or FALSE if no
	*   record was inserted.
	*/
	function insertId($table, $fields, $primary_key_field, $extrafields = NULL) {
		$valueList = $this->buildAssignmentList($fields, $extrafields);
		$query = 'INSERT INTO ' . $table .
			' (' . implode(',', array_keys($valueList)) .') VALUES' .
			' (' . implode(',', $valueList) . ')';
		$result = $this->Connection->execute($query);
		if ($result) {
			$valueList = $this->buildAssignmentList($fields, null);
			$pairs = array();
			foreach ($valueList as $key => $value) {
				$pairs[] = $key .'='. $value;
			}
			$query = 'SELECT MAX('.$primary_key_field.') FROM ' . $table .
					' WHERE (' . implode(' AND ', $pairs) . ')';
			$result = (int)$this->Connection->getOneValue($query);
		}
		return $result;
	}

	/**
	* INSERTs the values of this record into a single table
	* the field list parameter allows expressions to defined in the sql
	* statements as well as field values defined in the record.
	* @param string table name
	* @param array associative of field_name => type
	* @param string (default = null) Name of autoincrement field
	* @param array associative (optional)  of field_name => value
	* @return Boolean True on success.
	*/
	function insert($table, $fields, $extrafields = NULL) {
		$valueList = $this->buildAssignmentList($fields, $extrafields);
		$query = 'INSERT INTO ' . $table .
			' (' . implode(',', array_keys($valueList)) .') VALUES' .
			' (' . implode(',', $valueList) . ')';
		return (Boolean) $this->Connection->execute($query);
	}

	/**
	* Performs an UPDATE on a single table
	* @param string table name
	* @param array associative of field_name => type
	* @param string (optional) SQL where clause
	* @param array associative (optional)  of field_name => value
	* @return boolean true on success, false on failure
	* @access public
	*/
	function update($table, $fields, $where = NULL, $extrafields = NULL) {
		$valueList = $this->buildAssignmentList($fields, $extrafields);
		$query = 'UPDATE ' . $table . ' SET ';
		$sep = '';
		foreach ($valueList as $key => $value) {
			$query .= $sep . $key .'='. $value;
			$sep = ', ';
		}
		if (!is_null($where)) {
			$query .= ' WHERE ' . $where;
		}
		return (Boolean) $this->Connection->execute($query);
	}

	/**
	* Gets the number of rows changed by a query
	* @return int number of affected rows
	* @access public
	*/
	function getAffectedRowCount() {
		$QueryId = & $this->Connection->getConnectionId();
		return $QueryId->affectedRows();
	}

}

/**
* Encapsulates the results of a SELECT, SHOW, DESCRIBE or EXPLAIN sql statement
* Implements the Iterator interface defined in the DataSpace
* implements RecordSet and PagedDataSet interfaces
* @see RecordSet
* @see PagedDataSet
* @see http://wact.sourceforge.net/index.php/RecordSet
* @access public
* @package WACT_DB
*/
class MDB2RecordSet extends MDB2Record {
	/**
	* PEAR::MDB2 Result Object
	* @var object
	* @access private
	*/
	var $QueryId;

	/**
	* Pager
	* @var object The current pager for this query.
	* @access private
	*/
	var $pager;

	/**
	* SQL Statement
	* @var string
	* @access private
	*/
	var $Query;

	/**
	* Switch to watch if this is the first row
	* @var boolean (default = TRUE)
	* @access private
	*/
	var $first = TRUE;

	/**
	* Switch to watch for resets
	* @var boolean (default = FALSE)
	* @access private
	*/
	var $reentry = FALSE;

	/**
	* Construct a record set.
	* @param object MDB2Connection
	* @param string SQL SELECT, SHOW, DESCRIBE, or EXPLAIN statement
	* @access public
	*/
	function __construct($Connection, $Query_String) {
		$this->Connection = $Connection;
		$this->Query = $Query_String;
	}

	/**
	* Stores the SQL statement and makes sure the result object is
	* empty
	* @param string SQL statement
	* @return void
	* @access protected
	*/
	function query($Query_String) {
		$this->freeQuery();
		$this->Query = $Query_String;
	}

	/**
	* Assign a pager to this query for the purposes of breaking up the resulting
	* cursor into paged chucks.
	* @param interface Pager
	* @return void
	* @access public
	*/
	function paginate(&$pager) {
		$this->pager =& $pager;
		$pager->setPagedDataSet($this);
	}

	/**
	* Frees up the Result object if one exists
	* @return void
	* @access private
	*/
	function freeQuery() {
		if (isset($this->QueryId) && is_object($this->QueryId)) {
			$this->QueryId->free();
			$this->QueryId = NULL;
		}
	}

	/**
	* Move the current pointer to the first position in the cursor.
	* @return void
	* @access public
	*/
	function reset() {
		if (isset($this->pager)) {
			$conn = & $this->Connection->getConnectionId();
			$conn->setLimit(
			    $this->pager->getItemsPerPage(),
			    $this->pager->getStartingItem()
            );
		}

		$this->QueryId = $this->Connection->_execute($this->Query);
		return TRUE;
	}

	/**
	* Iterator next method
	* @return boolean TRUE if there are more results to fetch
	* @access public
	*/
	function next() {
		if (!isset($this->QueryId)) {
			return FALSE;
		}
		$this->properties = $this->QueryId->fetchRow(MDB2_FETCHMODE_ASSOC);
	    if (is_array($this->properties)) {
			$this->prepare();
			return TRUE;
		} else {
			$this->freeQuery();
			return FALSE;
		}
	}

	/**
	* Returns the number of rows in a query
	* @return int number of rows
	* @access public
	*/
	function getRowCount() {
		if ($this->QueryId) {
			return $this->QueryId->numRows();
		}
		return 0;
	}

	/**
	* Returns the total number of rows that a query would return, ignoring paging
	* restrictions.  Query re-writing based on _adodb_getcount.
	* @return int number of rows
	* @access public
	*/
	function getTotalRowCount() {
		if (!(preg_match("/^\s*SELECT\s+DISTINCT/is", $this->Query) && preg_match('/\s+GROUP\s+BY\s+/is',$this->Query))) {
			$rewritesql = preg_replace(
						'/^\s*SELECT\s.*\s+FROM\s/Uis','SELECT COUNT(*) FROM ',$this->Query);
			$rewritesql = preg_replace('/(\sORDER\s+BY\s.*)/is','',$rewritesql);
			$QueryId = $this->Connection->_execute($rewritesql);
			if ($QueryId) {
				$val = $QueryId->fetch();
				$QueryId->free();
				return $val;
			} else {
				return 0;
			}
		}

		// could not re-write the query, try a different method.
		$QueryId = $this->Connection->_execute($this->Query);
		if ($QueryId) {
			$count = $QueryId->numRows();
			$QueryId->free();
			return $count;
		} else {
			return 0;
		}
	}
}
?>