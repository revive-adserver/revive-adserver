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



// Define zonetypes
define ("phpAds_ZoneBanners", 0);
define ("phpAds_ZoneInteractive", 1);
define ("phpAds_ZoneRaw", 2);


/*********************************************************/
/* Rebuild zonecache                                     */
/*********************************************************/

function phpAds_RebuildZoneCache ($zoneid)
{
	global $phpAds_tbl_zones, $phpAds_zone_cache;
	
	// Get zone
	$zoneres = @db_query("SELECT * FROM $phpAds_tbl_zones WHERE zoneid='$zoneid' ");
	
	if (@mysql_num_rows($zoneres) > 0)
	{
		$zone = mysql_fetch_array($zoneres);
		
		// Set what parameter to zone settings
		if (isset($zone['what']) && $zone['what'] != '')
			$what = $zone['what'];
		else
			$what = '';
	}
	else
		$what = '';
	
	
	if ($phpAds_zone_cache)
	{
		// Get banners
		$select = phpAds_buildQuery ($what, 1, '');
		$res    = @db_query($select);
		
		// Build array for further processing...
		$rows = array();
		$weightsum = 0;
		while ($tmprow = @mysql_fetch_array($res))
		{
			// weight of 0 disables the banner
			if ($tmprow['weight'])
			{
				if ($tmprow['format'] == 'gif' ||
					$tmprow['format'] == 'jpeg' ||
					$tmprow['format'] == 'png' ||
					$tmprow['format'] == 'swf')
				{
					$tmprow['banner'] = '';
				}
				
				$weightsum += ($tmprow['weight'] * $tmprow['clientweight']);
				$rows[] = $tmprow; 
			}
		}
		
		$cachecontents = addslashes (serialize (array ($weightsum, $rows)));
		$cachetimestamp = time();
	}
	else
	{
		$cachecontents = '';
		$cachetimestamp = 0;
	}
	
	@db_query("UPDATE $phpAds_tbl_zones SET cachecontents='$cachecontents', cachetimestamp=$cachetimestamp WHERE zoneid='$zoneid' ");
}


?>