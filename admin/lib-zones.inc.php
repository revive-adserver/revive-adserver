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


// Set define to prevent duplicate include
define ('LIBZONES_INCLUDED', true);


// Define zonetypes
define ("phpAds_ZoneBanners", 0);
define ("phpAds_ZoneInteractive", 1);
define ("phpAds_ZoneRaw", 2);
define ("phpAds_ZoneCampaign", 3);

define ("phpAds_ZoneBanner", 0);
define ("phpAds_ZoneInterstitial", 1);
define ("phpAds_ZonePopup", 2);
define ("phpAds_ZoneText", 3);


// Define appendtypes
define ("phpAds_ZoneAppendRaw", 0);
define ("phpAds_ZoneAppendZone", 1);



/*********************************************************/
/* Determine if a banner included in a zone              */
/*********************************************************/

function phpAds_IsBannerInZone ($bannerid, $zoneid, $what = '')
{
	global $phpAds_config;
	
	if ($what == '')
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
		") or phpAds_sqlDie();
		
		if ($zone = phpAds_dbFetchArray($res))
			$what = $zone['what'];
	}
	
	
	$what_array = explode(",", $what);
	
	for ($k=0; $k < count($what_array); $k++)
	{
		if (substr($what_array[$k],0,9) == "bannerid:" && 
		    substr($what_array[$k],9) == $bannerid)
		{
			return (true);
		}
	}
	
	return (false);
}



/*********************************************************/
/* Determine if a campaign included in a zone            */
/*********************************************************/

function phpAds_IsCampaignInZone ($clientid, $zoneid, $what = '')
{
	global $phpAds_config;
	
	if ($what == '')
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
		") or phpAds_sqlDie();
		
		if ($zone = phpAds_dbFetchArray($res))
			$what = $zone['what'];
	}
	
	
	$what_array = explode(",", $what);
	
	for ($k=0; $k < count($what_array); $k++)
	{
		if (substr($what_array[$k],0,9) == "clientid:" && 
		    substr($what_array[$k],9) == $clientid)
		{
			return (true);
		}
	}
	
	return (false);
}



/*********************************************************/
/* Add a banner to a zone                                */
/*********************************************************/

function phpAds_ToggleBannerInZone ($bannerid, $zoneid)
{
	global $phpAds_config;
	
	
	if (isset($zoneid) && $zoneid != '')
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
		
		if (phpAds_dbNumRows($res))
		{
			$zone = phpAds_dbFetchArray($res);
			
			if ($zone['what'] != '')
				$what_array = explode(",", $zone['what']);
			else
				$what_array = array();
			
			$available = false;
			$changed = false;
			
			for ($k=0; $k < count($what_array); $k++)
			{
				if (substr($what_array[$k],0,9) == "bannerid:" && 
				    substr($what_array[$k],9) == $bannerid)
				{
					// Remove from array
					unset ($what_array[$k]);
					$available = true;
					$changed = true;
				}
			}
			
			if ($available == false)
			{
				// Add to array
				$what_array[] = 'bannerid:'.$bannerid;
				$changed = true;
			}
			
			if ($changed == true)
			{
				// Convert back to a string
				$zone['what'] = implode (",", $what_array);
				
				// Store string back into database
				$res = phpAds_dbQuery("
					UPDATE
						".$phpAds_config['tbl_zones']."
					SET 
						what = '".$zone['what']."'
					WHERE
						zoneid = '$zoneid'
					") or phpAds_sqlDie();
				
				// Rebuild Cache
				if (!defined('LIBVIEWCACHE_INCLUDED')) 
					include (phpAds_path.'/lib-view-cache-'.$phpAds_config['delivery_caching'].'.inc.php');
				
				phpAds_cacheDelete('zone:'.$zoneid);
			}
		}
	}
	
	return (false);
}



/*********************************************************/
/* Add a campaign to a zone                              */
/*********************************************************/

function phpAds_ToggleCampaignInZone ($clientid, $zoneid)
{
	global $phpAds_config;
	
	if (isset($zoneid) && $zoneid != '')
	{
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
		
		if (phpAds_dbNumRows($res))
		{
			$zone = phpAds_dbFetchArray($res);
			
			if ($zone['what'] != '')
				$what_array = explode(",", $zone['what']);
			else
				$what_array = array();
			
			$available = false;
			$changed = false;
			
			for ($k=0; $k < count($what_array); $k++)
			{
				if (substr($what_array[$k],0,9) == "clientid:" && 
				    substr($what_array[$k],9) == $clientid)
				{
					// Remove from array
					unset ($what_array[$k]);
					$available = true;
					$changed = true;
				}
			}
			
			if ($available == false)
			{
				// Add to array
				$what_array[] = 'clientid:'.$clientid;
				$changed = true;
			}
			
			if ($changed == true)
			{
				// Convert back to a string
				$zone['what'] = implode (",", $what_array);
				
				// Store string back into database
				$res = phpAds_dbQuery("
					UPDATE
						".$phpAds_config['tbl_zones']."
					SET 
						what = '".$zone['what']."'
					WHERE
						zoneid = '$zoneid'
					") or phpAds_sqlDie();
				
				// Rebuild cache
				if (!defined('LIBVIEWCACHE_INCLUDED')) 
					include (phpAds_path.'/lib-view-cache-'.$phpAds_config['delivery_caching'].'.inc.php');
				
				phpAds_cacheDelete('zone:'.$zoneid);
			}
		}
	}
	
	return (false);
}



/*********************************************************/
/* Fetch parameters from append code                     */
/*********************************************************/

function phpAds_ZoneParseAppendCode ($append)
{
	global $phpAds_config;
	
	$ret = array(
		array('zoneid' => '', 'delivery' => phpAds_ZonePopup),
		array()
	);
	
	if (ereg("ad(popup|layer)\.php\?([^'\"]+)['\"]", $append, $match))
	{
		if (!empty($match[2]))
		{
			$ret[0]['delivery'] = ($match[1] == 'popup') ? phpAds_ZonePopup : phpAds_ZoneInterstitial;
			
			$append = str_replace('&amp;', '&', $match[2]);
			
			if (ereg('[?&]what=zone:([0-9]+)(&|$)', $append, $match))
			{
				$ret[0]['zoneid'] = $match[1];
				
				$append = explode('&', $append);
				while (list(, $v) = each($append))
				{
					$v = explode('=', $v);
					if (count($v) == 2)
						$ret[1][urldecode($v[0])] = urldecode($v[1]);
				}
			}
		}
	}
	
	return $ret;
}

?>