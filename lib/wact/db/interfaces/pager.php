<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: pager.php,v 1.2 2004/11/13 19:57:50 jeffmoore Exp $
*/
//--------------------------------------------------------------------------------

/**
* A Pager object is used to control the pagination of a PagedDataSet.
* @see http://wact.sourceforge.net/index.php/Pager
* @see PagedDataSet
* @see RecordSet
* @package WACT_DB
*/
interface Pager {

	/**
	* Set the DataSet which this pager controls.
	* @return void
	*/
    function setPagedDataSet(PagedDataSet $DataSet);

	/**
	* Get the item number of the first item in the list.
	* Usually called by the PagedDataSet to determine where to
	* begin query.
	* @return integer
	*/
    function getStartingItem();

	/**
	* Get the item number of the first item in the list.
	* Usually called by the PagedDataSet to determine how many
	* items are on a page.
	* @return integer
	*/
    function getItemsPerPage();

}
?>