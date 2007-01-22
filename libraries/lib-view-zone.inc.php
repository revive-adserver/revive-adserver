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


// Set define to prevent duplicate include
define ('LIBVIEWZONE_INCLUDED', true);


/*********************************************************/
/* Get a banner                                          */
/*********************************************************/

function phpAds_fetchBannerZone($remaining, $clientid, $context = 0, $source = '', $richmedia = true)
{
	global $phpAds_config;
	global $phpAds_followedChain;
	
	// Get first part, store second part
	$what = strtok($remaining, '|');
	$remaining = strtok ('');
	$zoneid  = substr($what,5);
	
	// Check if zone was already evaluated in the chain
	if (isset($phpAds_followedChain) && in_array($zoneid, $phpAds_followedChain))
		return ($remaining);
	else
		$phpAds_followedChain[] = $zoneid;
	
	
	// Get cache
	if (!defined('LIBVIEWCACHE_INCLUDED'))
		@include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
	
	$cache = @phpAds_cacheFetch ('what=zone:'.$zoneid);
	
	if (!$cache)
	{
		$zoneres = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE zoneid='".$zoneid."'");
		
		if ($zone = phpAds_dbFetchArray($zoneres))
		{
			// No linked banners
			if ($remaining == '')
				$remaining = $zone['chain'];
			
			if ($zone['what'] == '')
				return ($remaining);
			
			if (!defined('LIBVIEWQUERY_INCLUDED'))  include (phpAds_path.'/libraries/lib-view-query.inc.php');
			
			
			$precondition = '';
			
			// Size preconditions
			if ($zone['width'] > -1)
				$precondition .= " AND ".$phpAds_config['tbl_banners'].".width = ".$zone['width']." ";
			
			if ($zone['height'] > -1)
				$precondition .= " AND ".$phpAds_config['tbl_banners'].".height = ".$zone['height']." ";
			
			// Text Ads preconditions
			// Matching against the value instead of the constant phpAds_ZoneText (3).
			// Didn't want to include the whole lib-zones just for a constant
			if ($zone['delivery'] == 3)
				$precondition .= " AND ".$phpAds_config['tbl_banners'].".storagetype = 'txt' ";
			else
				$precondition .= " AND ".$phpAds_config['tbl_banners'].".storagetype <> 'txt' ";
			
			
			$select = phpAds_buildQuery ($zone['what'], false, $precondition);
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
			
			$cache = array (
				$zone['zoneid'],
				$rows,
				$zone['what'],
				$prioritysum,
				$zone['chain'],
				$zone['prepend'],
				$zone['append']
			);
			
			phpAds_cacheStore ('what=zone:'.$zone['zoneid'], $cache);
			
			// Unpack cache
			list ($zoneid, $rows, $what, $prioritysum, $chain, $prepend, $append) = $cache;
		}
		else
			// Zone not found
			return ($remaining);
	}
	else
	{
		// Unpack cache
		list ($zoneid, $rows, $what, $prioritysum, $chain, $prepend, $append) = $cache;
		
		if ($remaining == '')
			$remaining = $chain;
		
		if (count($rows) == 0)
			return ($remaining);
	}
	
	
	
	
	
	
	// Build preconditions
	$excludeBannerID = array();
	$excludeCampaignID = array();
	$includeBannerID = array();
	$includeCampaignID = array();
	
	if (is_array ($context))
	{
		for ($i=0; $i < count($context); $i++)
		{
			list ($key, $value) = each($context[$i]);
			{
				$type = 'bannerid';
				$valueArray = explode(':', $value);
				
				if (count($valueArray) == 1)
					list($value) = $valueArray;
				else
					list($type, $value) = $valueArray;
				
				if ($type == 'bannerid')
				{
					switch ($key)
					{
						case '!=': $excludeBannerID[$value] = true; break;
						case '==': $includeBannerID[$value] = true; break;
					}
				}
				
				if ($type == 'campaignid')
				{
					switch ($key)
					{
						case '!=': $excludeCampaignID[$value] = true; break;
						case '==': $includeCampaignID[$value] = true; break;
					}
				}
			}
		}
	}

	// Get number of rows
	$maxindex = sizeof($rows);
	
	// Create campaign mapping
	$campaign_mapping = array();
	for ($i=0; $i<$maxindex; $i++)
		$campaign_mapping[$rows[$i]['clientid']][] = $i;

	// Use a multiplier to make sure we don't have rounding problems afterwards
	$multiplier = 1000;
	
	// Make sure that prioritysum * multiplier works with mt_rand
	while ($prioritysum * $multiplier > mt_getrandmax())	
		$multiplier /= 10; 

	// Track remaining rows
	$remaining_rows = sizeof($rows);

	// Start main loop
	while ($prioritysum >= 1 && $remaining_rows > 0)
	{
		$low = 0;
		$high = 0;
		$ranweight = ($prioritysum > 1) ? mt_rand(0, $prioritysum * $multiplier - 1) : 0;

		for ($i=0; $i<$maxindex; $i++)
		{
			if (is_array($rows[$i]))
			{
				$low = $high;
				$high += round($rows[$i]['priority'] * $multiplier);

				if ($high > $ranweight && $low <= $ranweight)
				{
					$postconditionSuccess = true;
					
					// Excludelist banners
					if (isset($excludeBannerID[$rows[$i]['bannerid']]))
						$postconditionSuccess = false;
					
					// Excludelist campaigns
					if ($postconditionSuccess == true &&
						isset($excludeCampaignID[$rows[$i]['clientid']]))
						$postconditionSuccess = false;
					
					// Includelist banners
					if ($postconditionSuccess == true &&
						sizeof($includeBannerID) &&
					    !isset ($includeBannerID[$rows[$i]['bannerid']]))
						$postconditionSuccess = false;
					
					// Includelist campaigns
					if ($postconditionSuccess == true &&
						sizeof($includeCampaignID) &&
					    !isset ($includeCampaignID[$rows[$i]['clientid']]))
						$postconditionSuccess = false;
					
					// HTML or Flash banners
					if ($postconditionSuccess == true &&
					    $richmedia == false &&
					    ($rows[$i]['contenttype'] != 'jpeg' && $rows[$i]['contenttype'] != 'gif' && $rows[$i]['contenttype'] != 'png'))
						$postconditionSuccess = false;
					
					// Blocked
					if ($postconditionSuccess == true &&
						$rows[$i]['block'] > 0 &&
						isset($_COOKIE['phpAds_blockAd'][$rows[$i]['bannerid']]) &&
						$_COOKIE['phpAds_blockAd'][$rows[$i]['bannerid']] > time())
						$postconditionSuccess = false;
					
					// Capped
					if ($postconditionSuccess == true &&
						$rows[$i]['capping'] > 0 &&
						isset($_COOKIE['phpAds_capAd'][$rows[$i]['bannerid']]) &&
						$_COOKIE['phpAds_capAd'][$rows[$i]['bannerid']] >= $rows[$i]['capping'])
						$postconditionSuccess = false;
					
					// ACLs
					if ($postconditionSuccess == true &&
						$phpAds_config['acl'] &&
						!phpAds_aclCheck($rows[$i], $source))
						$postconditionSuccess = false;

					if ($postconditionSuccess == false)
					{
						// Failed one of the postconditions
						// Delete this row
						$bannerpriority = $rows[$i]['priority'];
						$campaignid = $rows[$i]['clientid'];
						$rows[$i] = '';
						$remaining_rows--;
						
						// Assign lost priority to the other banners in the same campaign
						// Start getting the sum of all priorities
						$campaingprioritysum = 0;
						foreach ($campaign_mapping[$campaignid] as $ii)
						{
							if (is_array($rows[$ii]) && $rows[$ii]['priority'])
								$campaingprioritysum += $rows[$ii]['priority'];
						}
						
						if ($campaingprioritysum)
						{
							// Distribute the priority in a weighted manner
							
							$total_increment = 0;
							foreach ($campaign_mapping[$campaignid] as $ii)
							{
								if (is_array($rows[$ii]) && $rows[$ii]['priority'])
								{
									$increment = $bannerpriority * $rows[$ii]['priority'] / $campaingprioritysum;
									$rows[$ii]['priority'] += $increment;
									
									$total_increment += $increment;
								}
							}
							
							// Adjust priority sum, there may have been roundings
							$prioritysum += $total_increment - $bannerpriority;
						}
						else
						{
							// No other banners from the same campaign, discard priority
							$prioritysum -= $bannerpriority;
						}
									
						// Break out of the for loop to try again
						break;
					}

					// Found banner!
					$rows[$i]['zoneid'] = $zoneid;
					$rows[$i]['append'] = $append;
					$rows[$i]['prepend'] = $prepend;
					return $rows[$i];
				}
			}
		}
	}
	
	return ($remaining);
}


?>
