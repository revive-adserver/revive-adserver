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



// Include required files
include (phpAds_path."/view.inc.php");


// Define zonetypes
define ("phpAds_ZoneBanners", 0);
define ("phpAds_ZoneInteractive", 1);
define ("phpAds_ZoneRaw", 2);


/*********************************************************/
/* Rebuild zonecache                                     */
/*********************************************************/

function phpAds_RebuildZoneCache ($zoneid = '')
{
	global $phpAds_config;
	
	if ($zoneid == '')
	{
		$res_zones = phpAds_dbQuery("
			SELECT 
				*
			FROM 
				".$phpAds_config['tbl_zones']."
			") or phpAds_sqlDie();
		
		while ($row_zones = phpAds_dbFetchArray($res_zones))
		{
			phpAds_RebuildZoneCache ($row_zones['zoneid']);
		}
	}
	else
	{
		// Get zone
		$zoneres = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE zoneid='$zoneid' ");
		
		if (phpAds_dbNumRows($zoneres) > 0)
		{
			$zone = phpAds_dbFetchArray($zoneres);
			
			// Set what parameter to zone settings
			if (isset($zone['what']) && $zone['what'] != '')
				$what = $zone['what'];
			else
				$what = '';
		}
		else
			$what = '';
		
		
		if ($phpAds_config['zone_cache'])
		{
			$precondition = '';
			
			// Size preconditions
			if ($zone['width'] > -1)
				$precondition .= " AND ".$phpAds_config['tbl_banners'].".width = ".$zone['width']." ";
			
			if ($zone['height'] > -1)
				$precondition .= " AND ".$phpAds_config['tbl_banners'].".height = ".$zone['height']." ";
			
			
			// Get banners
			$select = phpAds_buildQuery ($what, 1, $precondition);
			$res    = phpAds_dbQuery($select);
			
			// Build array for further processing...
			$rows = array();
			$prioritysum = 0;
			while ($tmprow = phpAds_dbFetchArray($res))
			{
				// weight of 0 disables the banner
				if ($tmprow['priority'])
				{
					$prioritysum += $tmprow['priority'];
					$rows[] = $tmprow; 
				}
			}
			
			$cachecontents = addslashes (serialize (array ($prioritysum, $rows)));
			$cachetimestamp = time();
		}
		else
		{
			$cachecontents = '';
			$cachetimestamp = 0;
		}
		
		phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_zones']." SET cachecontents='$cachecontents', cachetimestamp=$cachetimestamp WHERE zoneid='$zoneid' ");
	}
}



/*********************************************************/
/* Determine if a banner included in a zone              */
/*********************************************************/

function phpAds_IsBannerInZone ($bannerid, $zoneid)
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
				zoneid = $zoneid
			") or phpAds_sqlDie();
		
		if (phpAds_dbNumRows($res))
		{
			$zone = phpAds_dbFetchArray($res);
			$what_array = explode(",", $zone['what']);
			
			for ($k=0; $k < count($what_array); $k++)
			{
				if (substr($what_array[$k],0,9) == "bannerid:" && 
				    substr($what_array[$k],9) == $bannerid)
				{
					return (true);
				}
			}
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
				zoneid = $zoneid
			") or phpAds_sqlDie();
		
		if (phpAds_dbNumRows($res))
		{
			$zone = phpAds_dbFetchArray($res);
			$what_array = explode(",", $zone['what']);
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
						zoneid = $zoneid
					") or phpAds_sqlDie();
				
				// Rebuild Cache
				phpAds_RebuildZoneCache ($zoneid);
			}
		}
	}
	
	return (false);
}

?>