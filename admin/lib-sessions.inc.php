<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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
	global $HTTP_COOKIE_VARS, $Session;
	
	if(isset($HTTP_COOKIE_VARS['SessionID']) && !empty($HTTP_COOKIE_VARS['SessionID']) && !defined('phpAds_installing'))
	{
		$result = phpAds_dbQuery("SELECT sessiondata FROM ".$phpAds_config['tbl_session']." WHERE sessionid='".$HTTP_COOKIE_VARS['SessionID']."'" .
					 	         " AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastused) < 3600");
		
		if($row = phpAds_dbFetchArray($result))
		{
			$Session = unserialize(stripslashes($row['sessiondata']));
			
			// Reset LastUsed, prevent from timing out
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_session']." SET lastused = NOW() WHERE sessionid = '".$HTTP_COOKIE_VARS['SessionID']."'");
		}
	}
	else
	{
		$HTTP_COOKIE_VARS['SessionID'] = '';
		return (False);
	}
}



/*********************************************************/
/* Create a new sessionid                                */
/*********************************************************/

function phpAds_SessionStart()
{
	global $HTTP_COOKIE_VARS, $Session;
	
	if (!isset($HTTP_COOKIE_VARS['SessionID']) || $HTTP_COOKIE_VARS['SessionID'] == '')
	{
		// Start a new session
		$Session = array();
		$HTTP_COOKIE_VARS['SessionID'] = uniqid('phpads');
		
		phpAds_setCookie ('SessionID', $HTTP_COOKIE_VARS['SessionID']);
		phpAds_flushCookie ();
	}
	
	return $HTTP_COOKIE_VARS['SessionID'];
}



/*********************************************************/
/* Register the data in the session array                */
/*********************************************************/

function phpAds_SessionDataRegister($key, $value='')
{
	global $Session;
	
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
	global $HTTP_COOKIE_VARS, $Session;
	
	if(isset($HTTP_COOKIE_VARS['SessionID']))
		phpAds_dbQuery("REPLACE INTO ".$phpAds_config['tbl_session']." VALUES ('".$HTTP_COOKIE_VARS['SessionID']."', '" .
					   addslashes(serialize($Session)) . "', null )");
	
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
	global $HTTP_COOKIE_VARS, $Session;
	
	// Remove the session data from the database
	phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_session']." WHERE sessionid='".$HTTP_COOKIE_VARS['SessionID']."'");
	
	// Kill the cookie containing the session ID
	phpAds_setCookie ('SessionID', '');
	phpAds_flushCookie ();
	
	// Clear all local session data and the session ID
	$Session = "";
	unset($Session);
	
	$HTTP_COOKIE_VARS['SessionID'] = "";
	unset($HTTP_COOKIE_VARS['SessionID']);
}

?>