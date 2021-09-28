<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: record.php,v 1.3 2004/05/27 22:28:24 jeffmoore Exp $
*/
//--------------------------------------------------------------------------------

/**
* Encapsulates INSERT, UPDATE, or DELETE operations on a MySQL database.
* @see http://wact.sourceforge.net/index.php/Record
* @package WACT_DB
*/
abstract class Record extends DataSpace {

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
	abstract public function insert($table, $fields, $extrafields = NULL);

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
    abstract public function insertId($table, $fields, $primary_key_field, $extrafields = NULL);
	
	/**
	* Performs an UPDATE on a single table
	* @param string table name
	* @param array associative of field_name => type
	* @param string (optional) SQL where clause
	* @param array associative (optional)  of field_name => value
	* @return boolean true on success, false on failure
	*/
    abstract public function update($table, $fields, $where = NULL, $extrafields = NULL);

	/**
	* Gets the number of rows changed by an insert, delete or update query.
	* @return int number of affected rows
	*/
    abstract public function getAffectedRowCount();

}

?>