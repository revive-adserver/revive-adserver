<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Define constants
define ("phpAds_Clicks", 1);
define ("phpAds_Views", 2);



/*********************************************************/
/* Check the expiration of a client				         */
/*********************************************************/

function phpAds_logExpire ($clientid, $type=0)
{
	global $phpAds_config;
	
	// Get campaign information
	$campaignresult = phpAds_dbQuery(
		"SELECT *, UNIX_TIMESTAMP(expire) AS expire_st, UNIX_TIMESTAMP(activate) AS activate_st FROM ".
		$phpAds_config['tbl_clients']." WHERE clientid = '".$clientid."'");
	
	
	if ($campaign = phpAds_dbFetchArray ($campaignresult))
	{
		// Decrement views
		if ($type == phpAds_Views && $campaign['views'] > 0)
		{
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET views = views - 1 WHERE clientid = '".$clientid."'");
			$campaign['views']--;
			
			// Mail warning - preset is reached
			if ($campaign['views'] == $phpAds_config['warn_limit'] &&
			   ($phpAds_config['warn_admin'] || $phpAds_config['warn_client']))
			{
				// Include warning library
				if (!defined('LIBWARNING_INCLUDED'))
					require (phpAds_path.'/lib-warning.inc.php');
				
				phpAds_warningMail ($campaign);
			}
		}
		
		
		// Decrement clicks
		if ($type == phpAds_Clicks && $campaign['clicks'] > 0)
		{
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET clicks = clicks - 1 WHERE clientid='".$clientid."'");
			$campaign['clicks']--;
		}
		
		
		// Check activation status
		$active = "t";
		
		if (($campaign["clicks"] == 0) ||
			($campaign["views"] == 0) ||
			(time() < $campaign["activate_st"]) || 
			(time() > $campaign["expire_st"] && $campaign["expire_st"] != 0))
			$active = "f";
		
		if ($campaign["active"] != $active)
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET active='".$active."' WHERE clientid='".$clientid."'");
		
		// Send deactivation warning
		if ($active == 'f')
		{
			// Include warning library
			if (!defined('LIBWARNING_INCLUDED'))
				require (phpAds_path.'/lib-warning.inc.php');
			
			phpAds_deactivateMail ($campaign);
		}
	}
}



/*********************************************************/
/* Check if host has to be ignored                       */
/*********************************************************/

function phpads_logCheckHost()
{
	global $phpAds_config;
	global $REMOTE_HOST, $REMOTE_ADDR;
	
	$found = 0;
	
	reset($phpAds_config['ignore_hosts']);
	
	while (($found == 0) && (list (, $h) = each($phpAds_config['ignore_hosts'])))
	{
		if (ereg("^([0-9]{1,3}\.){1,3}([0-9]{1,3}|\*)$", $h))
		{
			// It's an IP address, evenually with a wildcard, so I create a regexp
			$h = str_replace(".", '\.', str_replace("*$", "", "^".$h."$"));
			
			if (ereg($h, $REMOTE_ADDR))
				$found = 1;
		}
		elseif (eregi("^(\*\.)?([a-z0-9-]+\.)*[a-z0-9-]+$", $h))
		{
			// It's an host name, evenually with a wildcard, so I create a regexp
			$h = str_replace(".", '\.', str_replace("^*", "", "^".$h."$"));
						
			if (eregi($h, $REMOTE_HOST))
				$found = 1;
		}
		elseif (eregi($REMOTE_HOST."|".$REMOTE_ADDR, $h)) // This check is backwards compatibile
				$found = 1;
	}
	
	// Returns hostname or IP address if OK, false if host is ignored
	if ($found)
		return false;
	else
		return $phpAds_config['reverse_lookup'] ? $REMOTE_HOST : $REMOTE_ADDR;
}



/*********************************************************/
/* Log an impression                                     */
/*********************************************************/

function phpAds_logImpression ($bannerid, $clientid, $zoneid, $source)
{
	global $phpAds_config;
	
	// Check if host is on list of hosts to ignore
	if ($host = phpads_logCheckHost())
	{
		if ($phpAds_config['compact_stats'])
	    {
	        $result = phpAds_dbQuery(
				"UPDATE ".($phpAds_config['insert_delayed'] ? 'LOW_PRIORITY' : '')." ".
				$phpAds_config['tbl_adstats']." SET views = views + 1 WHERE day = NOW() 
				AND hour = HOUR(NOW()) AND bannerid = '$bannerid' AND zoneid = '$zoneid' 
				AND source = '$source' ");
			
       		if (phpAds_dbAffectedRows() == 0) 
       		{
           		$result = phpAds_dbQuery(
					"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
                   	$phpAds_config['tbl_adstats']." SET clicks = 0, views = 1, day = NOW(),
					hour = HOUR(NOW()), bannerid = '$bannerid', zoneid = '$zoneid', 
					source = '$source' ");
       		}
   		}
		else
   		{
   			$result = phpAds_dbQuery(
				"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
				$phpAds_config['tbl_adviews']." SET bannerid = '$bannerid', 
				zoneid = '$zoneid', host = '$host', source = '$source' ");
		}
		
		phpAds_logExpire ($clientid, phpAds_Views);
	}
}



/*********************************************************/
/* Log an click                                          */
/*********************************************************/

function phpAds_logClick($bannerid, $clientid, $zoneid, $source)
{
	global $phpAds_config;
	
	
	if ($host = phpads_logCheckHost())
	{
   		if ($phpAds_config['compact_stats'])
	    {
    	    $result = phpAds_dbQuery(
				"UPDATE ".($phpAds_config['insert_delayed'] ? 'LOW_PRIORITY' : '')." ".
				$phpAds_config['tbl_adstats']." SET clicks = clicks + 1 WHERE day = NOW() AND
				hour = HOUR(NOW()) AND bannerid = '$bannerid' AND zoneid = '$zoneid' AND
				source = '$source' ");
			
	        if (phpAds_dbAffectedRows() == 0) 
        	{
            	$result = phpAds_dbQuery(
					"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
					$phpAds_config['tbl_adstats']." SET clicks = 1, views = 0, day = NOW(),
					hour = HOUR(NOW()), bannerid = '$bannerid', zoneid = '$zoneid',
					source = '$source' ");
	        }
    	}
		else
		{
    		$result = phpAds_dbQuery(
				"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
				$phpAds_config['tbl_adclicks']." SET bannerid = '$bannerid', zoneid = '$zoneid',
				host = '$host', source = '$source' ");
		}
		
		phpAds_logExpire ($clientid, phpAds_Clicks);
	}
}

?>