<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer			                        */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/*********************************************************/
/* Fetch sessiondata from the database                   */
/*********************************************************/

function phpAds_SessionDataFetch()
{
	global $SessionID, $Session, $phpAds_tbl_session;
	
	if(isset($SessionID) && !empty($SessionID))
	{
		$result = @db_query("SELECT SessionData FROM $phpAds_tbl_session WHERE SessionID='$SessionID'" .
					 	   " AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LastUsed) < 3600") or mysql_die();
		
		if($row = mysql_fetch_array($result))
		{
			$Session = unserialize(stripslashes($row[0]));
			
			// Reset LastUsed, prevent from timing out
			@db_query("UPDATE $phpAds_tbl_session SET LastUsed = NOW() WHERE SessionID = '$SessionID'") or mysql_die();
		}
	}
	else
	{
		$SessionID = '';
		return (False);
	}
}



/*********************************************************/
/* Create a new sessionid                                */
/*********************************************************/

function phpAds_SessionStart()
{
	global $SessionID, $Session;
	
	if (!isset($SessionID) || $SessionID=='')
	{
		// Start a new session
		$Session = array();
		$SessionID = uniqid("phpads");
		
		SetCookie("SessionID", $GLOBALS["SessionID"]);
	}
	
	return $SessionID;
}



/*********************************************************/
/* Register the data in the session array                */
/*********************************************************/

function phpAds_SessionDataRegister($key, $value='')
{
	global $SessionID, $Session;
	
	phpAds_SessionStart();
	
	if (is_array($key) && $value=='')
	{
		for (reset($key);$name=key($key);next($key))
		{
			$Session[$name] = $key[$name];
		}
	}
	else
		$Session[$key] = $value;
	
	phpAds_SessionDataStore();
	
	// This function has been disabled because of incompatibility
	// problem with ZendOptimizer 1.00. Call sessionDataStore
	// manually if have modified the session array.
	// register_shutdown_function("phpAds_SessionDataStore");
}



/*********************************************************/
/* Store the session array in the database               */
/*********************************************************/

function phpAds_SessionDataStore()
{
	global $SessionID, $Session, $phpAds_tbl_session;
	
	if(isset($SessionID))
		db_query("REPLACE INTO $phpAds_tbl_session VALUES ('$SessionID', '" .
		AddSlashes(serialize($Session)) . "', null )") or mysql_die();
	
	// Randomly purge old sessions
	srand((double)microtime()*1000000);
	if(rand(1, 100) == 42)	
		db_query("DELETE FROM $phpAds_tbl_session WHERE UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LastUsed) > 43200") or mysql_die();
}



/*********************************************************/
/* Destroy the current session                           */
/*********************************************************/

function phpAds_SessionDataDestroy()
{
	global $SessionID, $Session, $phpAds_tbl_session;
	
	// Remove the session data from the database
	db_query("DELETE FROM $phpAds_tbl_session WHERE SessionID='$SessionID'") or mysql_die();
	
	// Kill the cookie containing the session ID
	SetCookie("SessionID", "");
	
	// Clear all local session data and the session ID
	$Session = "";
	$SessionID = "";
	unset($SessionID);
	unset($Session);
}

?>