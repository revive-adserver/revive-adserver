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
	global $phpAds_config;
	global $SessionID, $Session;
	
	if(isset($SessionID) && !empty($SessionID) && !defined('phpAds_installing'))
	{
		$result = phpAds_dbQuery("SELECT sessiondata FROM ".$phpAds_config['tbl_session']." WHERE sessionid='$SessionID'" .
					 	         " AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastused) < 3600");
		
		if($row = phpAds_dbFetchArray($result))
		{
			$Session = unserialize(stripslashes($row['sessiondata']));
			
			// Reset LastUsed, prevent from timing out
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_session']." SET lastused = NOW() WHERE sessionid = '$SessionID'");
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
	global $phpAds_config;
	global $SessionID, $Session;
	
	if(isset($SessionID))
		phpAds_dbQuery("REPLACE INTO ".$phpAds_config['tbl_session']." VALUES ('$SessionID', '" .
					   AddSlashes(serialize($Session)) . "', null )");
	
	// Randomly purge old sessions
	srand((double)microtime()*1000000);
	if(rand(1, 100) == 42)	
		phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_session']." WHERE UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastused) > 43200");
}



/*********************************************************/
/* Destroy the current session                           */
/*********************************************************/

function phpAds_SessionDataDestroy()
{
	global $phpAds_config;
	global $SessionID, $Session;
	
	// Remove the session data from the database
	phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_session']." WHERE sessionid='$SessionID'");
	
	// Kill the cookie containing the session ID
	SetCookie("SessionID", "");
	
	// Clear all local session data and the session ID
	$Session = "";
	$SessionID = "";
	unset($SessionID);
	unset($Session);
}

?>