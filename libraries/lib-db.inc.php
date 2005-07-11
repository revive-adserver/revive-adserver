<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// MySQL DB Resource
$phpAds_db_link = '';


// Add database name to table names if compatibility mode is used
if ($phpAds_config['compatibility_mode'])
{
	$phpAds_config['tbl_adclicks'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_adclicks'];
	$phpAds_config['tbl_adviews'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_adviews'];
	$phpAds_config['tbl_adstats'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_adstats'];
	$phpAds_config['tbl_banners'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_banners'];
	$phpAds_config['tbl_clients'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_clients'];
	$phpAds_config['tbl_session'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_session'];
	$phpAds_config['tbl_acls'] 		= $phpAds_config['dbname'].".".$phpAds_config['tbl_acls'];
	$phpAds_config['tbl_zones'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_zones'];
	$phpAds_config['tbl_config'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_config'];
	$phpAds_config['tbl_affiliates']= $phpAds_config['dbname'].".".$phpAds_config['tbl_affiliates'];
	$phpAds_config['tbl_images'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_images'];
	$phpAds_config['tbl_userlog'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_userlog'];
	$phpAds_config['tbl_cache'] 	= $phpAds_config['dbname'].".".$phpAds_config['tbl_cache'];
}

// Disable delayed inserts when not using MyISAM tables
if ($phpAds_config['table_type'] != 'MYISAM')
	$phpAds_config['insert_delayed'] = false;



/*********************************************************/
/* Check if the extension is available                   */
/*********************************************************/

function phpAds_dbAvailable()
{
	return (function_exists('mysql_connect'));
}


/*********************************************************/
/* Open a connection to the database			         */
/*********************************************************/

function phpAds_dbConnect()
{
	global $phpAds_config;
	global $phpAds_db_link;
	
	// Add port to connect, if needed
	if (!isset($phpAds_config['dbport']) || !$phpAds_config['dbport']) 
		$phpAds_config['dbport'] = 3306;

	$host = $phpAds_config['dbhost'];
	
	if ($phpAds_config['dbport'] != 3306)
		$host .= ':'.$phpAds_config['dbport'];

    if ($phpAds_config['persistent_connections'])
        $phpAds_db_link = @mysql_pconnect ($host, $phpAds_config['dbuser'], $phpAds_config['dbpassword']);
    else
        $phpAds_db_link = @mysql_connect ($host, $phpAds_config['dbuser'], $phpAds_config['dbpassword']);
	
	if ($phpAds_config['compatibility_mode'])
		return $phpAds_db_link;
	
	if (@mysql_select_db ($phpAds_config['dbname'], $phpAds_db_link))
		return $phpAds_db_link;
}



/*********************************************************/
/* Close the connection to the database			         */
/*********************************************************/

function phpAds_dbClose()
{
	// Never close the database connection, because
	// it may interfere with other scripts which
	// share the same connection.
}



/*********************************************************/
/* Execute a query								         */
/*********************************************************/

function phpAds_dbQuery($query)
{
    global $phpAds_last_query;
	global $phpAds_db_link;
	
	// Connect to the database, if needed
	if (!$phpAds_db_link &&	!phpAds_dbConnect())
		return false;
	
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
	return @mysql_fetch_array($res, MYSQL_ASSOC);
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

function phpAds_dbAffectedRows()
{
	global $phpAds_db_link;
	
	return @mysql_affected_rows($phpAds_db_link);
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

function phpAds_dbErrorNo ()
{
	global $phpAds_db_link;
	
	return @mysql_errno($phpAds_db_link);
}

?>