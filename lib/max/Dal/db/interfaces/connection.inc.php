<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: connection.inc.php,v 1.1 2004/05/24 20:16:04 jeffmoore Exp $
*/
//--------------------------------------------------------------------------------

/**
* Represents a database connection
* @see http://wact.sourceforge.net/index.php/Connection
* @package WACT_DB
*/
interface Connection {

	/**
	* Convert a PHP value into an SQL literal.  The type to convert to is
	* based on the type of the PHP value passed, or the type string passed.
	* @param mixed value to convert
	* @param string (optional) type to convert to
	* @return string literal SQL fragment
	*/
	function makeLiteral($value, $type = NULL);
	
    /**
    * Factory function to create a Record object
    * @see http://wact.sourceforge.net/index.php/NewRecord
    * @param DataSpace or subclass (optional)
    *   used to initialize the fields of the new record prior to calling insert()
    * @return Record reference
    */
    function &NewRecord($DataSpace = NULL);

    /**
    * Factory function used to retrieve more than one row from a MySQL database,
    * applying a filter to the data if supplied as an argument
    * @see http://wact.sourceforge.net/index.php/NewRecordSet
    * @param string SQL statement
    * @param object filter class (optional)
    * @return RecordSet reference
    */
    function &NewRecordSet($query, $filter = NULL);

    /**
    * Factory function used to retrieve more than one row from a MySQL database,
    * applying a filter to the data if supplied as an argument, and applying a
    * pager to the result set as well.
    * @param string SQL statement
    * @param object pager
    * @param object filter class (optional)
    * @return RecordSet reference
    */
    function &NewPagedRecordSet($query, &$pager, $filter = NULL);

	/**
	* Retreive a single record from the database based on a query.
	* @param string SQL Query
	* @return Record object or NULL if not found
	*/
	function &FindRecord($query);

	/**
	* Get a single value from the first column of a single record from
	* a database query.
	* @param string SQL Query
	* @return Value or NULL if not found
	* @access public
	*/
	function getOneValue($query);

	/**
	* Retreive an array where each element of the array is the value from the
	* first column of a database query.
	* @param string SQL Query
	*/
	function getOneColumnArray($query);

	/**
	* Retreive an associative array where each element of the array is based
	* on the first column as a key and the second column as data.
	* @param string SQL Query
	*/
	function getTwoColumnArray($query);
	
	/**
	* Performs any query that does not return a cursor.
	* @param string SQL query
	* @return boolean True if successful.
	*/
	function execute($sql);

	/**
	* Disconnect from database
	* @return void
	* @access public
	*/
	function disconnect();

}

?>