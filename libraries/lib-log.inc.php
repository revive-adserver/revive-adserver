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
					require (phpAds_path.'/libraries/lib-warnings.inc.php');
				
				if (!defined('LIBMAIL_INCLUDED'))
					require (phpAds_path.'/libraries/lib-mail.inc.php');
				
				if (!defined('LIBUSERLOG_INCLUDED'))
					require (phpAds_path.'/libraries/lib-userlog.inc.php');
				
				phpAds_userlogSetUser (phpAds_userDeliveryEngine);
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
		{
			if (!defined('LIBUSERLOG_INCLUDED'))
				require (phpAds_path.'/libraries/lib-userlog.inc.php');
			
			// Log deactivation
			phpAds_userlogSetUser (phpAds_userDeliveryEngine);
			phpAds_userlogAdd (phpAds_actionDeactiveCampaign, $campaign['clientid']);
			
			// Deactivate campaign
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET active='".$active."' WHERE clientid='".$clientid."'");
			
			// Send deactivation warning
			if ($active == 'f')
			{
				// Rebuild priorities
				if (!defined('LIBPRIORITY_INCLUDED'))  
					require (phpAds_path.'/libraries/lib-priority.inc.php');
				
				phpAds_PriorityCalculate ();
				
				
				// Recalculate cache
				if (!defined('LIBVIEWCACHE_INCLUDED'))  
					include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
				
				phpAds_cacheDelete();
				
				
				// Include warning library
				if (!defined('LIBWARNING_INCLUDED'))
					require (phpAds_path.'/libraries/lib-warnings.inc.php');
				
				if (!defined('LIBMAIL_INCLUDED'))
					require (phpAds_path.'/libraries/lib-mail.inc.php');
				
				phpAds_deactivateMail ($campaign);
			}
		}
	}
}



/*********************************************************/
/* Check if host has to be ignored                       */
/*********************************************************/

function phpads_logCheckHost()
{
	global $phpAds_config;
	global $HTTP_SERVER_VARS;
	
	if (count($phpAds_config['ignore_hosts']))
	{
		$hosts = "#(".implode ('|',$phpAds_config['ignore_hosts']).")$#i";
		
		if ($hosts != '')
		{
			$hosts = str_replace (".", '\.', $hosts);
			$hosts = str_replace ("*", '[^.]+', $hosts);
			
			if (preg_match($hosts, $HTTP_SERVER_VARS['REMOTE_ADDR']))
				return false;
			
			if (preg_match($hosts, $HTTP_SERVER_VARS['REMOTE_HOST']))
				return false;
		}
	}
	
	return true; //$HTTP_SERVER_VARS['REMOTE_HOST'];
}



/*********************************************************/
/* Log an impression                                     */
/*********************************************************/

function phpAds_logImpression ($bannerid, $clientid, $zoneid, $source)
{
	global $HTTP_SERVER_VARS, $phpAds_config, $phpAds_CountryLookup;
	
	
	// Check if host is on list of hosts to ignore
	if ($host = phpads_logCheckHost())
	{
		$log_source = $phpAds_config['log_source'] ? $source : '';
		
		if ($phpAds_config['compact_stats'])
	    {
	        $result = phpAds_dbQuery(
				"UPDATE ".($phpAds_config['insert_delayed'] ? 'LOW_PRIORITY' : '')." ".
				$phpAds_config['tbl_adstats']." SET views = views + 1 WHERE day = NOW() 
				AND hour = HOUR(NOW()) AND bannerid = '".$bannerid."' AND zoneid = '".$zoneid."' 
				AND source = '".$log_source."' ");
			
       		if (phpAds_dbAffectedRows() == 0) 
       		{
           		$result = phpAds_dbQuery(
					"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
                   	$phpAds_config['tbl_adstats']." SET clicks = 0, views = 1, day = NOW(),
					hour = HOUR(NOW()), bannerid = '".$bannerid."', zoneid = '".$zoneid."', 
					source = '".$log_source."' ");
       		}
   		}
		else
   		{
			$log_country = $phpAds_config['geotracking_stats'] && isset ($phpAds_CountryLookup) && $phpAds_CountryLookup ? $phpAds_CountryLookup : '';
			$log_host    = $phpAds_config['log_hostname'] ? $HTTP_SERVER_VARS['REMOTE_HOST'] : '';
			$log_host    = $phpAds_config['log_iponly'] ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : $log_host;
			
   			$result = phpAds_dbQuery(
				"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
				$phpAds_config['tbl_adviews']." SET bannerid = '".$bannerid."', 
				zoneid = '".$zoneid."', host = '".$log_host."', source = '".$log_source."', 
				country = '".$log_country."' ");
		}
		
		phpAds_logExpire ($clientid, phpAds_Views);
	}
}



/*********************************************************/
/* Log an click                                          */
/*********************************************************/

function phpAds_logClick($bannerid, $clientid, $zoneid, $source)
{
	global $HTTP_SERVER_VARS, $phpAds_config, $phpAds_CountryLookup;
	
	
	if ($host = phpads_logCheckHost())
	{
		$log_source = $phpAds_config['log_source'] ? $source : '';
		
   		if ($phpAds_config['compact_stats'])
	    {
    	    $result = phpAds_dbQuery(
				"UPDATE ".($phpAds_config['insert_delayed'] ? 'LOW_PRIORITY' : '')." ".
				$phpAds_config['tbl_adstats']." SET clicks = clicks + 1 WHERE day = NOW() AND
				hour = HOUR(NOW()) AND bannerid = '".$bannerid."' AND zoneid = '".$zoneid."' AND
				source = '".$log_source."' ");
			
	        if (phpAds_dbAffectedRows() == 0) 
        	{
            	$result = phpAds_dbQuery(
					"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
					$phpAds_config['tbl_adstats']." SET clicks = 1, views = 0, day = NOW(),
					hour = HOUR(NOW()), bannerid = '".$bannerid."', zoneid = '".$zoneid."',
					source = '".$log_source."' ");
	        }
    	}
		else
		{
			$log_country = $phpAds_config['geotracking_stats'] && isset ($phpAds_CountryLookup) && $phpAds_CountryLookup ? $phpAds_CountryLookup : '';
			$log_host    = $phpAds_config['log_hostname'] ? $HTTP_SERVER_VARS['REMOTE_HOST'] : '';
			$log_host    = $phpAds_config['log_iponly'] ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : $log_host;
			
    		$result = phpAds_dbQuery(
				"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
				$phpAds_config['tbl_adclicks']." SET bannerid = '".$bannerid."', zoneid = '".$zoneid."',
				host = '".$log_host."', source = '".$log_source."', country = '".$log_country."' ");
		}
		
		phpAds_logExpire ($clientid, phpAds_Clicks);
	}
}

?>