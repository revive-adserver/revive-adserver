<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
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
	global $Session;
	
	if (isset($_COOKIE['sessionID']) && preg_match('/^[0-9a-f]+$/D', $_COOKIE['sessionID']))
	{
		$result = phpAds_dbQuery("SELECT sessiondata FROM ".$phpAds_config['tbl_session']." WHERE sessionid='".addslashes($_COOKIE['sessionID'])."'" .
					 	         " AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastused) < 3600");
		
		if ($row = phpAds_dbFetchArray($result))
		{
			$Session = unserialize($row['sessiondata']);
			
			// Reset LastUsed, prevent from timing out
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_session']." SET lastused = NOW() WHERE sessionid = '".addslashes($_COOKIE['sessionID'])."'");
		}
	}
	else
	{
		$_COOKIE['sessionID'] = '';
		return (False);
	}
}



/*********************************************************/
/* Create a new sessionid                                */
/*********************************************************/

function phpAds_SessionStart()
{
	global $Session;
	
	if (!isset($_COOKIE['sessionID']) || !preg_match('/^[0-9a-f]+$/D', $_COOKIE['sessionID']))
	{
		// Start a new session
		$Session = array();
		$_COOKIE['sessionID'] = md5(uniqid('phpads', 1));
		
		phpAds_setCookie ('sessionID', $_COOKIE['sessionID']);
		phpAds_flushCookie ();
	}
	
	return $_COOKIE['sessionID'];
}



/*********************************************************/
/* Register the data in the session array                */
/*********************************************************/

function phpAds_SessionDataRegister($key, $value='')
{
	global $Session;
	
	if (!defined('phpAds_installing'))
		phpAds_SessionStart();
	
	if (is_array($key) && $value=='')
	{
		foreach (array_keys($key) as $name)
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
	global $Session;
	
	if (isset($_COOKIE['sessionID']) && preg_match('/^[0-9a-f]+$/D', $_COOKIE['sessionID']))
	{
		phpAds_dbQuery("REPLACE INTO ".$phpAds_config['tbl_session']." VALUES ('".addslashes($_COOKIE['sessionID'])."', '" .
					   addslashes(serialize($Session)) . "', null )");
	}
	
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
	global $Session;
	
	if (isset($_COOKIE['sessionID']) && preg_match('/^[0-9a-f]+$/D', $_COOKIE['sessionID']))
	{
		// Remove the session data from the database
		phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_session']." WHERE sessionid='".addslashes($_COOKIE['sessionID'])."'");
	}
	
	// Kill the cookie containing the session ID
	phpAds_setCookie ('sessionID', '');
	phpAds_flushCookie ();
	
	// Clear all local session data and the session ID
	$Session = "";
	unset($Session);
	
	$_COOKIE['sessionID'] = "";
	unset($_COOKIE['sessionID']);
}

?>