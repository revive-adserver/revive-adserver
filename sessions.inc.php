<?
/*
 * Session Management for PHP3
 *
 * (C) Copyright 2001 Niels Leenheer
 *     Partly based on KCSM by Kyle Cordes
 *
 *     This file is released under the GNU GENERAL PUBLIC LICENSE
 *
 */ 



	function phpAds_SessionDataFetch()
	{
		global $SessionID, $Session, $phpAds_tbl_session;
		
		if(isset($SessionID) && !empty($SessionID))
		{
			$result = db_query("SELECT SessionData FROM $phpAds_tbl_session WHERE SessionID='$SessionID'" .
						 	   " AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LastUsed) < 3600") or mysql_die();
			
			if($row = mysql_fetch_array($result))
			{
				$Session = unserialize(stripslashes($row[0]));
			}
		}
		else
			return (False);
	}


	function phpAds_SessionDataRegister($key, $value='')
	{
		global $SessionID, $Session;
		
		if (!isset($SessionID) || $SessionID=='')
		{
			// Start a new session
			$Session = array();
			$SessionID = uniqid("phpads");
			
			$url = parse_url($GLOBALS["phpAds_url_prefix"]);
			SetCookie("SessionID", $GLOBALS["SessionID"], 0, $url["path"]);
		}
		
		if (is_array($key) && $value=='')
		{
			for (reset($key);$name=key($key);next($key))
			{
				$Session[$name] = $key[$name];
			}
		}
		else
			$Session[$key] = $value;
		
		register_shutdown_function("phpAds_SessionDataStore");
	}


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


	function phpAds_SessionDataDestroy()
	{
		global $SessionID, $Session, $phpAds_tbl_session;
		
		db_query("DELETE FROM $phpAds_tbl_session WHERE SessionID='$SessionID'") or mysql_die();
		
		$url = parse_url($GLOBALS["phpAds_url_prefix"]);
		SetCookie("SessionID", "", 0, $url["path"]);
		
		$Session = "";
		$SessionID = "";
		unset($SessionID);
		unset($Session);
	}


?>