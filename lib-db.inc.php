<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Phil Hord				                        */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// MySQL DB Resource
$phpAds_db_link = '';


/*********************************************************/
/* Open a connection to the database			         */
/*********************************************************/

function phpAds_dbConnect()
{
	global $phpAds_persistent_connections;
	global $phpAds_hostname, $phpAds_mysqluser, $phpAds_mysqlpassword, $phpAds_db;
	global $phpAds_db_link;
	
    if ($phpAds_persistent_connections)
        $phpAds_db_link = @mysql_pconnect ($phpAds_hostname, $phpAds_mysqluser, $phpAds_mysqlpassword);
    else
        $phpAds_db_link = @mysql_connect ($phpAds_hostname, $phpAds_mysqluser, $phpAds_mysqlpassword);
	
	if (@mysql_select_db ($phpAds_db, $phpAds_db_link))
		return $phpAds_db_link;
}



/*********************************************************/
/* Close the connection to the database			         */
/*********************************************************/

function phpAds_dbClose()
{
	global $phpAds_persistent_connections;
	global $phpAds_db_link;
	
	if (!$phpAds_persistent_connections)
		@mysql_close ($phpAds_db_link);
}



/*********************************************************/
/* Execute a query								         */
/*********************************************************/

function phpAds_dbQuery($query)
{
    global $phpAds_last_query;
	global $phpAds_db_link;
	
    $phpAds_last_query = $query;
    return @mysql_query ($query, $phpAds_db_link);
}



/*********************************************************/
/* Get the number of rows returned                       */
/*********************************************************/

function phpAds_dbNumRows($res)
{
	return @mysql_num_rows($res);
}



/*********************************************************/
/* Get next row as an array with keys                    */
/*********************************************************/

function phpAds_dbFetchArray($res)
{
	return @mysql_fetch_array($res);
}



/*********************************************************/
/* Get next row as an array                              */
/*********************************************************/

function phpAds_dbFetchRow($res)
{
	return @mysql_fetch_row($res);
}



/*********************************************************/
/* Get a specific row and column                         */
/*********************************************************/

function phpAds_dbResult($res, $row, $column)
{
	return @mysql_result($res, $row, $column);
}



/*********************************************************/
/* Free the result from memory                           */
/*********************************************************/

function phpAds_dbFreeResult($res)
{
	return @mysql_free_result($res);
}



/*********************************************************/
/* Return the number of affected rows                    */
/*********************************************************/

function phpAds_dbAffectedRows($res)
{
	return @mysql_affected_rows($res);
}



/*********************************************************/
/* Go to the specified row                               */
/*********************************************************/

function phpAds_dbSeekRow($res, $row)
{
	return @mysql_data_seek($res, $row);
}



/*********************************************************/
/* Get the ID of the last inserted row                   */
/*********************************************************/

function phpAds_dbInsertID()
{
	global $phpAds_db_link;
	
	return @mysql_insert_id($phpAds_db_link);
}



/*********************************************************/
/* Get the error message if something went wrong         */
/*********************************************************/

function phpAds_dbError ()
{
	global $phpAds_db_link;
	
	return @mysql_error($phpAds_db_link);
}


?>