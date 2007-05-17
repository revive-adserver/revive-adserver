<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: mysql.inc.php,v 1.34 2004/11/12 21:25:05 jeffmoore Exp $
*/
//--------------------------------------------------------------------------------

/**
* Check dataspace is loaded
*/
if (!class_exists('DataSpace')) {
	require MAX_PATH . '/lib/wact/db/dataspace.inc.php';
}

/**
* Encapsulates a database connection.  Allows for lazy connections.
* implements Connection interface
* @see Connection
* @see http://wact.sourceforge.net/index.php/Connection
* @access public
* @package WACT_DB
*/
class MySQLConnection {

	/**
	* Resource representing connection to MySQL database
	* @var resource
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
	* Create a MySQL database connection.
    * @param object Connection Configuration information
	* @access private
	*/
	function MySQLConnection(&$config) {
	    $this->config =& $config;
	}

	/**
	* Return connectionId for a mysql database.  Allow a lazy connection.
	* @return resource
	* @access protected
	*/
	function getConnectionId() {
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
	function connect($makeNewConnection = false) {
		$this->ConnectionId = mysql_connect(
		    $this->config->get('host'),
		    $this->config->get('user'),
		    $this->config->get('password'),
		    $makeNewConnection);
		if ($this->ConnectionId === FALSE) {
			$this->RaiseError();
		}

		if (mysql_select_db($this->config->get('database'), $this->ConnectionId) === FALSE) {
			$this->RaiseError();
		}
	}

	/**
	* Raises an error, passing it on to the framework level error mechanisms
	* @param string (optional) SQL statement
	* @return void
	* @access private
	*/
	function RaiseError($sql = NULL) {
		$errno = mysql_errno($this->getConnectionId());
		$id = 'DB_ERROR';
		$info = array('driver' => 'MySQL');
		if ($errno != 0) {
			$info['errorno'] = $errno;
			$info['error'] = mysql_error($this->getConnectionId());
			$id .= '_MESSAGE';
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
	* @param mixed value to convert
	* @param string (optional) type to convert to
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
                return "'" . mysql_escape_string($value) . "'";
            case 'boolean':
                return ($value) ? 1 : 0;
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
    function &NewRecord($DataSpace = NULL) {
        $Record =& new MySqlRecord($this);
        if (!is_null($DataSpace)) {
            $Record->import($DataSpace->export());
        }
        return $Record;
    }

    /**
    * Factory function used to retrieve more than one row from a MySQL database,
    * applying a filter to the data if supplied as an argument
    * @see http://wact.sourceforge.net/index.php/NewRecordSet
    * @param string SQL statement
    * @param object filter class (optional)
    * @return RecordSet reference
    * @access public
    */
    function &NewRecordSet($query, $filter = NULL) {
        $RecordSet =& new MySqlRecordSet($this, $query);
        if (!is_null($filter)) {
            $RecordSet->registerFilter($filter);
        }
        return $RecordSet;
    }

    /**
    * Factory function used to retrieve more than one row from a MySQL database,
    * applying a filter to the data if supplied as an argument, and applying a
    * pager to the result set as well.
    * @param string SQL statement
    * @param object pager
    * @param object filter class (optional)
    * @return RecordSet reference
    * @access public
    */
    function &NewPagedRecordSet($query, &$pager, $filter = NULL) {
        $RecordSet =& $this->NewRecordSet($query, $filter);
        $RecordSet->paginate($pager);
        return $RecordSet;
    }

	/**
	* Retreive a single record from the database based on a query.
	* @param string SQL Query
	* @return Record object or NULL if not found
	* @access public
	*/
	function &FindRecord($query) {
		$Record =& new MySqlRecord($this);
		$QueryId = $this->_execute($query);
		$Record->properties =& mysql_fetch_assoc($QueryId);
		mysql_free_result($QueryId);
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
		$row = mysql_fetch_row($QueryId);
		mysql_free_result($QueryId);
		if (is_array($row)) {
			return $row[0];
		}
	}

	/**
	* Retreive an array where each element of the array is the value from the
	* first column of a database query.
	* @param string SQL Query
	* @access public
	*/
	function getOneColumnArray($query) {
		$Column = array();
		$QueryId = $this->_execute($query);
		while (is_array($row = mysql_fetch_row($QueryId))) {
			$Column[] = $row[0];
		}
		mysql_free_result($QueryId);
		return $Column;
	}

	/**
	* Retreive an associative array where each element of the array is based
	* on the first column as a key and the second column as data.
	* @param string SQL Query
	* @access public
	*/
	function getTwoColumnArray($query) {
		$Column = array();
		$QueryId = $this->_execute($query);
		while (is_array($row = mysql_fetch_row($QueryId))) {
			$Column[$row[0]] = $row[1];
		}
		mysql_free_result($QueryId);
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

	/*
	* For internal driver use only
	* @param string SQL query
	* @return resource MySQL result resource
	* @access protected
	*/
	function _execute($sql) {
		$result = mysql_query($sql, $this->getConnectionId());

		if ($result === FALSE) {
			$this->RaiseError($sql);
		}
		return $result;
	}

	/**
	* Disconnect from database
	* @return void
	* @access public
	*/
	function disconnect() {
	    if(!defined('HEARTBEAT_DONT_CLOSE_DB_CONNECTION')) {
		    mysql_close($this->ConnectionId);
		    $this->ConnectionId = NULL;
	    }
	}

}

/**
* Encapsulates INSERT, UPDATE, or DELETE operations on a MySQL database.
* implements Record interface
* @see Record
* @see http://wact.sourceforge.net/index.php/Record
* @access public
* @package WACT_DB
*/
class MySqlRecord extends DataSpace {
	/**
	* Connection to MySQL
	* @var resource
	* @access private
	*/
	var $Connection;

	/**
	* Conecruct a record
	* @param object Connection
	*/
	function MySqlRecord($Connection) {
		$this->Connection = $Connection;
	}

	/**
	* Build SQL fragment to assign values to columns
	* @param array associative of field_name => type
	* @param array associative (optional)  of field_name => value
	* @return string SQL fragment
	* @access protected
	*/
	function buildAssignmentSQL($fields, $extrafields) {
		$query = ' SET ';
		$sep = '';
		foreach($fields as $fieldname => $type) {
			if (!is_string($fieldname)) {
				$fieldname = $type; // Swap if no type is specified
				$type = NULL;
			}
			$query .= $sep . $fieldname . '=' .
				$this->Connection->makeLiteral($this->get($fieldname), $type);
			$sep = ', ';
		}
		if (!is_null($extrafields)) {
			foreach($extrafields as $fieldname => $value) {
				$query .= $sep . $fieldname . '=' . $value;
				$sep = ', ';
			}
		}
		return $query;
	}

	/**
	* INSERT a record into a table with a primary key represented by a
	* auto_increment/serial column and return the primary key of the
	* inserted record.
	* the field list parameter allows expressions to defined in the sql
	* statements as well as field values defined in the record.
	* requires MySQL Version 3.22.10 or better.
	* @param string table name
	* @param array associative of field_name => type
	* @param string Name of primary key field field
	* @param array associative (optional)  of field_name => value
	* @return integer Primary key of the newly inserted record or FALSE if no
	*   record was inserted.
	*/
	function insertId($table, $fields, $primary_key_field, $extrafields = NULL) {
		$query = 'INSERT INTO ' . $table . $this->buildAssignmentSQL($fields, $extrafields);
		$result = $this->Connection->execute($query);
		if ($result) {
			return mysql_insert_id($this->Connection->getConnectionId());
		} else {
		    return FALSE;
		}
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
		$query = 'INSERT INTO ' . $table . $this->buildAssignmentSQL($fields, $extrafields);
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

		$query = 'UPDATE ' . $table . $this->buildAssignmentSQL($fields, $extrafields, 'update');

		if (!is_null($where)) {
			$query .= ' WHERE ' . $where;
		}

		return (Boolean) $this->Connection->execute($query);
	}

	/**
	* Gets the number of rows changed by an insert, delete or update query.
	* @return int number of affected rows
	* @access public
	*/
	function getAffectedRowCount() {
		return mysql_affected_rows($this->Connection->getConnectionId());
	}

}

/**
* Encapsulates the cursor result of a SELECT, SHOW, DESCRIBE or EXPLAIN
* sql statement.  Implements the Iterator interface.
* implements RecordSet and PagedDataSet interfaces
* @see RecordSet
* @see PagedDataSet
* @see http://wact.sourceforge.net/index.php/RecordSet
* @access public
* @package WACT_DB
*/
class MySqlRecordSet /* implements iterator */ extends MySqlRecord {
	/**
	* MySQL query resource
	* @var resource
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
	* Construct a record set.
	* @param object MySQL Connection
	* @param string SQL SELECT, SHOW, DESCRIBE, or EXPLAIN statement
	* @return void
	* @access public
	*/
	function MySqlRecordSet($Connection, $Query_String) {
		$this->Connection = $Connection;
		$this->Query = $Query_String;
	}

	/**
	* Assign a query for this object to process.
	* @param string SQL statement
	* @return void
	* @access public
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
	* Frees up the Query resource.  can be called even if no
	* resource is set or if has already been freed.
	* @return void
	* @access private
	*/
	function freeQuery() {
		if (isset($this->QueryId) && is_resource($this->QueryId)) {
			mysql_free_result($this->QueryId);
			$this->QueryId = NULL;
		}
	}

	/**
	* Move the current pointer to the first position in the cursor.
	* @access public
	* @return boolean TRUE if the query is valid.
	*/
	function reset() {
		if (isset($this->QueryId) && is_resource($this->QueryId)) {
			if (mysql_data_seek($this->QueryId, 0) === FALSE) {
				$this->Connection->RaiseError();
			}
		} else {
			$query = $this->Query;
			if (isset($this->pager)) {
				$query .= ' LIMIT ' .
					$this->pager->getStartingItem() . ',' .
					$this->pager->getItemsPerPage();
			}

			$this->QueryId = $this->Connection->_execute($query);
		}
    	return TRUE;
	}

	/**
	* Iterator next method.  Load the data values from the next record
	* in the query into the current data values.
	* @return boolean TRUE if there are more results to fetch
	* @access public
	*/
	function next() {
		if (!isset($this->QueryId)) {
			return FALSE;
		}

		$this->properties =& mysql_fetch_assoc($this->QueryId);

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
		return mysql_num_rows($this->QueryId);
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
			$row = mysql_fetch_row($QueryId);
			mysql_free_result($QueryId);
			if (is_array($row)) {
				return $row[0];
			}
		}

		// could not re-write the query, try a different method.

		$QueryId = $this->Connection->_execute($this->Query);
		$count = mysql_num_rows($QueryId);
		mysql_free_result($QueryId);
		return $count;
	}
}
?>