<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: pageddataset.php,v 1.1 2004/05/24 20:16:05 jeffmoore Exp $
*/
//--------------------------------------------------------------------------------

/**
* Encapsulates the cursor result of a SELECT, SHOW, DESCRIBE or EXPLAIN
* sql statement.  Implements the Iterator interface.
* @see NewRecordSet
* @see http://wact.sourceforge.net/index.php/PagedDataSet
* @package WACT_DB
*/
interface PagedDataSet extends iterator {

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