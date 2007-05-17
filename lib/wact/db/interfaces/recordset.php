<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: recordset.php,v 1.2 2004/05/24 21:05:40 jeffmoore Exp $
*/
//--------------------------------------------------------------------------------

/**
* Encapsulates the cursor result of a SELECT, SHOW, DESCRIBE or EXPLAIN
* sql statement.  Implements the Iterator interface.
* @see NewRecordSet
* @see http://wact.sourceforge.net/index.php/RecordSet
* @package WACT_DB
*/
interface RecordSet extends iterator, record {

	/**
	* Assign a query for this object to process.
	* @param string SQL statement
	* @return void
	*/
	function query($Query_String);

	/**
	* Assign a pager to this query for the purposes of breaking up the resulting
	* cursor into paged chucks.
	* The pager must implement an interface with three methods:
	*	setPagedDataSet()
	*	getStartingItem()
	*	getItemsPerPage()
	* The pager may call back to this object using one of two functions:
	*	getTotalRowCount()
	*	getRowCount()
	* The callback interface is to allow the pager to determine the number
	* of items in the full query.  Not all pagers require this information so
	* it was implemented as a call back.
	* @return void
	*/
	function paginate(Pager $pager);

	/**
	* Move the current pointer to the first position in the cursor.
	* @access public
	* @return boolean TRUE if the query is valid.
	*/
	function reset();

	/**
	* Iterator next method.  Load the data values from the next record
	* in the query into the current data values.
	* @return boolean TRUE if there are more results to fetch
	*/
	function next();

	/**
	* Returns the number of rows in a query
	* @return int number of rows
	*/
	function getRowCount();

	/**
	* Returns the total number of rows that a query would return, ignoring paging
	* restrictions.  Query re-writing based on _adodb_getcount.
	* @return int number of rows
	*/
	function getTotalRowCount();
}
?>