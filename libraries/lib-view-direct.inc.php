<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set define to prevent duplicate include
define ('LIBVIEWDIRECT_INCLUDED', true);


/*********************************************************/
/* Get a banner                                          */
/*********************************************************/

function phpAds_fetchBannerDirect($remaining, $clientid = 0, $context = 0, $source = '', $richmedia = true)
{
	global $phpAds_config;
	
	// Get first part, store second part
	$what = strtok($remaining, '|');
	$remaining = strtok ('');
	
	
	// Expand paths to regular statements
	if (strpos($what, '/') > 0)
	{
		if (strpos($what, '@') > 0)
			list ($what, $append) = explode ('@', $what);
		else
			$append = '';
		
		$seperate  = explode ('/', $what);
		$expanded  = '';
		$collected = array();
		
		while (list(,$v) = each($seperate))
		{
			$expanded .= ($expanded != '' ? ',+' : '') . $v;
			$collected[] = $expanded . ($append != '' ? ',+'.$append : '');
		}
		
		$what = strtok(implode('|', array_reverse ($collected)), '|');
		$remaining = strtok('').($remaining != '' ? '|'.$remaining : '');
	}
	
	$cacheid = 'what='.$what.'&clientid='.$clientid.'&remaining='.($remaining == '' ? 'true' : 'false');
	
	
	
	// Get cache
	if (!defined('LIBVIEWCACHE_INCLUDED'))
		@include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
	
	$cache = @phpAds_cacheFetch ($cacheid);
	
	if (!$cache)
	{
		if (!defined('LIBVIEWQUERY_INCLUDED'))  include (phpAds_path.'/libraries/lib-view-query.inc.php');
		
		if ($clientid > 0)
			$precondition = " AND ".$phpAds_config['tbl_banners'].".clientid = '".$clientid."' ";
		else
			$precondition = '';
		
		$select = phpAds_buildQuery ($what, $remaining == '', $precondition);
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
			$rows,
			$what,
			$prioritysum
		);
		
		phpAds_cacheStore ($cacheid, $cache);
		
		// Unpack cache
		list ($rows, $what, $prioritysum) = $cache;
	}
	else
	{
		// Unpack cache
		list ($rows, $what, $prioritysum) = $cache;
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
	
	
	
	$maxindex = sizeof($rows);
	
	// Create campaign mapping
	$campaign_mapping = array();
	for ($i=0; $i<$maxindex; $i++)
		$campaign_mapping[$rows[$i]['clientid']][] = $i;

	// Use a multiplier to make sure we don't have rounding problems afterwards
	$multiplier = 1000;
	
	while ($prioritysum && sizeof($rows))
	{
		$low = 0;
		$high = 0;
		$ranweight = ($prioritysum > 1) ? mt_rand(0, $prioritysum * $multiplier - 1) : 0;
		
		for ($i=0; $i<$maxindex; $i++)
		{
			if (is_array($rows[$i]))
			{
				$low = $high;
				$high += $rows[$i]['priority'];
				
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
							foreach ($campaign_mapping[$campaignid] as $ii)
							{
								if (is_array($rows[$ii]) && $rows[$ii]['priority'])
									$rows[$ii]['priority'] += $bannerpriority * $rows[$ii]['priority'] / $campaingprioritysum;
							}
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
					$rows[$i]['zoneid'] = 0;
					return $rows[$i];
				}
			}
		}
	}
	
	return ($remaining);
}


?>
