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



// Define constants
define ("phpAds_Clicks", 1);
define ("phpAds_Views", 2);



/*********************************************************/
/* Check the expiration of a client				         */
/*********************************************************/

function phpAds_logExpire ($clientid, $type = 0, $number = 1, $force_run = false)
{
	global $phpAds_config;
	
	// Do not run when distributed stats are used
	if ($phpAds_config['lb_enabled'] && !$force_run)
		return;
	
	// Get campaign information
	$campaignresult = phpAds_dbQuery(
		"SELECT *, UNIX_TIMESTAMP(expire) AS expire_st, UNIX_TIMESTAMP(activate) AS activate_st FROM ".
		$phpAds_config['tbl_clients']." WHERE clientid = '".$clientid."'");
	
	
	if ($campaign = phpAds_dbFetchArray ($campaignresult))
	{
		$views_before	= $views_after	=$campaign['views'];
		$clicks_before	= $clicks_after	= $campaign['clicks'];

		// Decrement views
		if ($type == phpAds_Views && $views_before > 0)
		{
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET views = IF(views - ".$number." < 0, 0, views - ".$number.")
				WHERE clientid = '".$clientid."'");
			
			$views_after -= $number;
			
			// Mail warning - preset is reached
			if ($views_before > $phpAds_config['warn_limit'] &&
				$views_after <= $phpAds_config['warn_limit'] &&
			   ($phpAds_config['warn_admin'] || $phpAds_config['warn_client']))
			{
				// Include warning library
				if (!defined('LIBWARNING_INCLUDED'))
					require (phpAds_path.'/libraries/lib-warnings.inc.php');
				
				if (!defined('LIBMAIL_INCLUDED'))
					require (phpAds_path.'/libraries/lib-mail.inc.php');
				
				if (!defined('LIBUSERLOG_INCLUDED'))
					require (phpAds_path.'/libraries/lib-userlog.inc.php');
				
				if ($phpAds_config['lb_enabled'])
					phpAds_userlogSetUser (phpAds_userMaintenance);
				else
					phpAds_userlogSetUser (phpAds_userDeliveryEngine);
				
				phpAds_warningMail ($campaign);
			}
		}
		
		
		// Decrement clicks
		if ($type == phpAds_Clicks && $clicks_before > 0)
		{
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET
				clicks = IF(clicks - ".$number." < 0, 0, clicks - ".$number.")
				WHERE clientid = '".$clientid."'");

			$clicks_after -= $number;
		}
		
		
		// Check activation status
		$active = "t";
		
		if (($clicks_before > 0 && $clicks_after <= 0) ||
			($views_before > 0 && $views_after <= 0) ||
			(time() < $campaign["activate_st"]) || 
			(time() > $campaign["expire_st"] && $campaign["expire_st"] != 0))
			$active = "f";
		
		if ($campaign["active"] != $active)
		{
			if (!defined('LIBUSERLOG_INCLUDED'))
				require (phpAds_path.'/libraries/lib-userlog.inc.php');
			
			// Log deactivation
			if ($phpAds_config['lb_enabled'])
				phpAds_userlogSetUser (phpAds_userMaintenance);
			else
				phpAds_userlogSetUser (phpAds_userDeliveryEngine);
			
			phpAds_userlogAdd (phpAds_actionDeactiveCampaign, $campaign['clientid']);
			
			// Deactivate campaign
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET active='".$active."' WHERE clientid='".$clientid."'");
			
			// Send deactivation warning 
			if ($active == 'f')
			{
				if (!$phpAds_config['lb_enabled'])
				{
					// Rebuild priorities
					if (!defined('LIBPRIORITY_INCLUDED'))  
						require (phpAds_path.'/libraries/lib-priority.inc.php');
					
					phpAds_PriorityCalculate ();
					
					
					// Recalculate cache
					if (!defined('LIBVIEWCACHE_INCLUDED'))  
						include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
					
					phpAds_cacheDelete();
				}
				
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

	if (count($phpAds_config['ignore_hosts']))
	{
		$hosts = "#(".implode ('|',$phpAds_config['ignore_hosts']).")$#i";
		
		if ($hosts != '')
		{
			$hosts = str_replace (".", '\.', $hosts);
			$hosts = str_replace ("*", '[^.]+', $hosts);
			
			if (preg_match($hosts, $_SERVER['REMOTE_ADDR']))
				return false;
			
			if (preg_match($hosts, $_SERVER['REMOTE_HOST']))
				return false;
		}
	}
	
	return true; //$_SERVER['REMOTE_HOST'];
}



/*********************************************************/
/* Log an impression                                     */
/*********************************************************/

function phpAds_logImpression ($bannerid, $clientid, $zoneid, $source)
{
	global $phpAds_config, $phpAds_geo;
	
	
	// Check if host is on list of hosts to ignore
	if ($host = phpads_logCheckHost())
	{
		$log_source = $phpAds_config['log_source'] ? $source : '';
		
		// Switch databases if needed
		phpAds_dbDistributedMode();

		if ($phpAds_config['compact_stats'])
	    {
			// LOW PRIORITY UPDATEs are disabled until further notice - Matteo
	        $result = phpAds_dbQuery(
				"UPDATE ".(false && $phpAds_config['insert_delayed'] ? 'LOW_PRIORITY' : '')." ".
				$phpAds_config['tbl_adstats']." SET views = views + 1 WHERE day = NOW() 
				AND hour = HOUR(NOW()) AND bannerid = '".$bannerid."' AND zoneid = '".$zoneid."' 
				AND source = '".$log_source."' ");
			
       		if (phpAds_dbAffectedRows() == 0) 
       		{
           		$result = phpAds_dbQuery(
					"INSERT ".(false && $phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
                   	$phpAds_config['tbl_adstats']." SET clicks = 0, views = 1, day = NOW(),
					hour = HOUR(NOW()), bannerid = '".$bannerid."', zoneid = '".$zoneid."', 
					source = '".$log_source."' ");

				if (!$result) 
				{
					// INSERT failed because of primary key constraint violation, retry to UPDATE
					$result = phpAds_dbQuery(
						"UPDATE ".(false && $phpAds_config['insert_delayed'] ? 'LOW_PRIORITY' : '')." ".
						$phpAds_config['tbl_adstats']." SET views = views + 1 WHERE day = NOW() 
						AND hour = HOUR(NOW()) AND bannerid = '".$bannerid."' AND zoneid = '".$zoneid."' 
						AND source = '".$log_source."' ");
				}
       		}
   		}
		else
   		{
			$log_country = $phpAds_config['geotracking_stats'] && isset($phpAds_geo['country']) && $phpAds_geo['country'] ? $phpAds_geo['country'] : '';
			$log_host    = $phpAds_config['log_hostname'] ? $_SERVER['REMOTE_HOST'] : '';
			$log_host    = $phpAds_config['log_iponly'] ? $_SERVER['REMOTE_ADDR'] : $log_host;
			
   			$result = phpAds_dbQuery(
				"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
				$phpAds_config['tbl_adviews']." SET bannerid = '".$bannerid."', 
				zoneid = '".$zoneid."', host = '".$log_host."', source = '".$log_source."', 
				country = '".$log_country."' ");
		}
		
		// Switch databases if needed
		phpAds_dbNormalMode();
		
		phpAds_logExpire ($clientid, phpAds_Views);
	}
}



/*********************************************************/
/* Log an click                                          */
/*********************************************************/

function phpAds_logClick($bannerid, $clientid, $zoneid, $source)
{
	global $phpAds_config, $phpAds_geo;
	
	
	if ($host = phpads_logCheckHost())
	{
		$log_source = $phpAds_config['log_source'] ? $source : '';
		
		// Switch databases if needed
		phpAds_dbDistributedMode();
		
   		if ($phpAds_config['compact_stats'])
	    {
			// LOW PRIORITY UPDATEs are disabled until further notice - Matteo
    	    $result = phpAds_dbQuery(
				"UPDATE ".(false && $phpAds_config['insert_delayed'] ? 'LOW_PRIORITY' : '')." ".
				$phpAds_config['tbl_adstats']." SET clicks = clicks + 1 WHERE day = NOW() AND
				hour = HOUR(NOW()) AND bannerid = '".$bannerid."' AND zoneid = '".$zoneid."' AND
				source = '".$log_source."' ");
			
	        if (phpAds_dbAffectedRows() == 0) 
        	{
            	$result = phpAds_dbQuery(
					"INSERT ".(false && $phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
					$phpAds_config['tbl_adstats']." SET clicks = 1, views = 0, day = NOW(),
					hour = HOUR(NOW()), bannerid = '".$bannerid."', zoneid = '".$zoneid."',
					source = '".$log_source."' ");

				if (!$result) 
				{
					// INSERT failed because of primary key constraint violation, retry to UPDATE
					$result = phpAds_dbQuery(
						"UPDATE ".(false && $phpAds_config['insert_delayed'] ? 'LOW_PRIORITY' : '')." ".
						$phpAds_config['tbl_adstats']." SET clicks = clicks + 1 WHERE day = NOW() AND
						hour = HOUR(NOW()) AND bannerid = '".$bannerid."' AND zoneid = '".$zoneid."' AND
						source = '".$log_source."' ");
				}
	        }
    	}
		else
		{
			$log_country = $phpAds_config['geotracking_stats'] && $phpAds_geo && $phpAds_geo['country'] ? $phpAds_geo['country'] : '';
			$log_host    = $phpAds_config['log_hostname'] ? $_SERVER['REMOTE_HOST'] : '';
			$log_host    = $phpAds_config['log_iponly'] ? $_SERVER['REMOTE_ADDR'] : $log_host;
			
    		$result = phpAds_dbQuery(
				"INSERT ".($phpAds_config['insert_delayed'] ? 'DELAYED' : '')." INTO ".
				$phpAds_config['tbl_adclicks']." SET bannerid = '".$bannerid."', zoneid = '".$zoneid."',
				host = '".$log_host."', source = '".$log_source."', country = '".$log_country."' ");
		}
		
		// Switch databases if needed
		phpAds_dbNormalMode();
		
		phpAds_logExpire ($clientid, phpAds_Clicks);
	}
}



/*********************************************************/
/* Set block/cap/geotargeting cookies                    */
/*********************************************************/

function phpAds_setDeliveryCookies($row)
{
	global $phpAds_config, $phpAds_geo;
	
	// Block
	if ($row['block'] != '' && $row['block'] != '0')
		phpAds_setCookie ("phpAds_blockAd[".$row['bannerid']."]", time() + $row['block'], time() + $row['block'] + 43200);
	
	
	// Set capping
	if ($row['capping'] != '' && $row['capping'] != '0')
		phpAds_setCookie ("phpAds_newCap[".md5(uniqid('', true))."]", $row['bannerid'], time() + 31536000);


	// Cache geotargeting info
	if ($phpAds_config['geotracking_type'] != '')
	{
		if ($phpAds_config['geotracking_cookie'] && isset($phpAds_geo))
			phpAds_setCookie ("phpAds_geoInfo", join('|', $phpAds_geo), time() + 900);
		elseif (isset($_COOKIE['phpAds_geoInfo']))
			phpAds_setCookie ("phpAds_geoInfo", '', time() - 900);
	}
}

?>
