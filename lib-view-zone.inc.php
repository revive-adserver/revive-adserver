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


// Set define to prevent duplicate include
define ('LIBVIEWZONE_INCLUDED', true);


/*********************************************************/
/* Get a banner                                          */
/*********************************************************/

function phpAds_fetchBannerZone($what, $clientid, $context = 0, $source = '', $richmedia = true)
{
	global $phpAds_config;
	
	
	// Get zone
	$zoneid  = substr($what,5);
	$zoneres = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE zoneid='$zoneid' OR zonename='$zoneid'");
	
	if (phpAds_dbNumRows($zoneres) > 0)
	{
		$zone = phpAds_dbFetchArray($zoneres);
		
		// Set what parameter to zone settings
		if (isset($zone['what']) && $zone['what'] != '')
			$what = $zone['what'];
		else
			$what = 'default';
		
		$zoneid = $zone['zoneid'];
	}
	else
	{
		$zoneid = '';
		$what = '';
	}
	
	if (isset($zone) &&
		$phpAds_config['zone_cache'] && 
		time() - $zone['cachetimestamp'] < $phpAds_config['zone_cache_limit'] && 
		$zone['cachecontents'] != '')
	{
		// If zone is found and cache is not expired
		// and cache exists use it.
		list($prioritysum, $rows) = unserialize ($zone['cachecontents']);
	}
	else
	{
		// If zone does not exists or cache has expired
		// or cache is empty build a query
		// Include the query builder sub-library
		if (!defined('LIBVIEWQUERY_INCLUDED'))  require (phpAds_path.'/lib-view-query.inc.php');
		
		
		$precondition = '';
		
		// Size preconditions
		if ($zone['width'] > -1)
			$precondition .= " AND ".$phpAds_config['tbl_banners'].".width = ".$zone['width']." ";
		
		if ($zone['height'] > -1)
			$precondition .= " AND ".$phpAds_config['tbl_banners'].".height = ".$zone['height']." ";
		
		
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
		
		if ($phpAds_config['zone_cache'] && isset($zone) &&
			($zone['cachecontents'] == '' ||
			time() - $zone['cachetimestamp'] >= $phpAds_config['zone_cache_limit']))
		{
			// If exists and cache is empty or expired
			// Store the rows which were just build in the cache
			
			$cachecontents = addslashes (serialize (array ($prioritysum, $rows)));
			$cachetimestamp = time();
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_zones']." SET cachecontents='$cachecontents', cachetimestamp=$cachetimestamp WHERE zoneid='$zoneid' ");
		}
	}
	
	
	
	// Build preconditions
	$excludeBannerID = array();
	$includeBannerID = array();
	
	if (is_array ($context))
	{
		for ($i=0; $i < count($context); $i++)
		{
			list ($key, $value) = each($context[$i]);
			{
				switch ($key)
				{
					case '!=': $excludeBannerID[$value] = true; break;
					case '==': $includeBannerID[$value] = true; break;
				}
			}
		}
	}
	
	
	
	$maxindex = sizeof($rows);
	
	while ($prioritysum && sizeof($rows))
	{
		$low = 0;
		$high = 0;
		$ranweight = ($prioritysum > 1) ? mt_rand(0, $prioritysum - 1) : 0;
		
		for ($i=0; $i<$maxindex; $i++)
		{
			if (is_array($rows[$i]))
			{
				$low = $high;
				$high += $rows[$i]['priority'];
				
				if ($high > $ranweight && $low <= $ranweight)
				{
					$postconditionSucces = true;
					
					// Excludelist
					if (isset ($excludeBannerID[$rows[$i]['bannerid']]) &&
						$excludeBannerID[$rows[$i]['bannerid']] == true)
						$postconditionSucces = false;
					
					// Includelist
					if ($postconditionSucces == true &&
					    sizeof($includeBannerID) > 0 &&
					    (!isset ($includeBannerID[$rows[$i]['bannerid']]) ||
						$includeBannerID[$rows[$i]['bannerid']] != true))
						$postconditionSucces = false;
					
					// HTML or Flash banners
					if ($postconditionSucces == true &&
					    $richmedia == false &&
					    ($rows[$i]['contenttype'] != 'jpeg' && $rows[$i]['contenttype'] != 'gif' && $rows[$i]['contenttype'] != 'png'))
						$postconditionSucces = false;
					
					
					if ($postconditionSucces == false)
					{
						// Failed one of the postconditions
						// Delete this row and adjust $prioritysum
						$prioritysum -= $rows[$i]['priority'];
						$rows[$i] = '';
						
						// Break out of the for loop to try again
						break;
					}
					
					// Banner was not on exclude list
					// and was on include list (if one existed)
					// Now continue with ACL check
					
					if ($phpAds_config['acl'])
					{
						if (phpAds_aclCheck($rows[$i], $source))
						{
							$rows[$i]['zoneid'] = $zoneid;
							return ($rows[$i]);
						}
						
						// Matched, but phpAds_aclCheck failed.
						// Delete this row and adjust $prioritysum
						$prioritysum -= $rows[$i]['priority'];
						$rows[$i] = '';
						
						// Break out of the for loop to try again
						break;
					}
					else
					{
						// Don't check ACLs, found banner!
						$rows[$i]['zoneid'] = $zoneid;
						return ($rows[$i]);
					}
				}
			}
		}
	}
	
	return false;
}


?>