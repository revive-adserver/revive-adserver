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
define ('LIBVIEWDIRECT_INCLUDED', true);


/*********************************************************/
/* Get a banner                                          */
/*********************************************************/

function phpAds_fetchBannerDirect($remaining, $clientid = 0, $context = 0, $source = '', $richmedia = true)
{
	global $phpAds_config, $HTTP_COOKIE_VARS;
	
	
	// Get first part, store second part
	$what = strtok($remaining, '|');
	$remaining = strtok ('');
	$cacheid = 'what='.$what.'&clientid='.$clientid.'&remaining='.($remaining == '' ? 'true' : 'false');
	
	
	// Get cache
	if (!defined('LIBVIEWCACHE_INCLUDED'))  include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
	$cache = phpAds_cacheFetch ($cacheid);
	
	if (!$cache)
	{
		if (!defined('LIBVIEWQUERY_INCLUDED'))  include (phpAds_path.'/libraries/lib-view-query.inc.php');
		
		if ($clientid > 0)
			$precondition = "(".$phpAds_config['tbl_clients'].".clientid = ".$clientid." OR ".$phpAds_config['tbl_clients'].".parent = ".$clientid.") ";
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
				$value = explode(':', $value);
				
				if (count($value) == 1)
					list($value) = $value;
				else
					list($type, $value) = $value;
				
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
					
					// Excludelist banners
					if (isset($excludeBannerID[$rows[$i]['bannerid']]))
						$postconditionSucces = false;
					
					// Excludelist campaigns
					if ($postconditionSucces == true &&
						isset($excludeCampaignID[$rows[$i]['clientid']]))
						$postconditionSucces = false;
					
					// Includelist banners
					if ($postconditionSucces == true &&
						sizeof($includeBannerID) &&
					    !isset ($includeBannerID[$rows[$i]['bannerid']]))
						$postconditionSucces = false;
					
					// Includelist campaigns
					if ($postconditionSucces == true &&
						sizeof($includeCampaignID) &&
					    !isset ($includeCampaignID[$rows[$i]['clientid']]))
						$postconditionSucces = false;
					
					// HTML or Flash banners
					if ($postconditionSucces == true &&
					    $richmedia == false &&
					    ($rows[$i]['contenttype'] != 'jpeg' && $rows[$i]['contenttype'] != 'gif' && $rows[$i]['contenttype'] != 'png'))
						$postconditionSucces = false;
					
					// Blocked
					if ($postconditionSucces == true &&
						$rows[$i]['block'] > 0 &&
						isset($HTTP_COOKIE_VARS['phpAds_blockAd'][$rows[$i]['bannerid']]) &&
						$HTTP_COOKIE_VARS['phpAds_blockAd'][$rows[$i]['bannerid']] > time())
						$postconditionSucces = false;
					
					// Capped
					if ($postconditionSucces == true &&
						$rows[$i]['capping'] > 0 &&
						isset($HTTP_COOKIE_VARS['phpAds_capAd'][$rows[$i]['bannerid']]) &&
						$HTTP_COOKIE_VARS['phpAds_capAd'][$rows[$i]['bannerid']] >= $rows[$i]['capping'])
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
							$rows[$i]['zoneid'] = 0;
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
						$rows[$i]['zoneid'] = 0;
						return ($rows[$i]);
					}
				}
			}
		}
	}
	
	return ($remaining);
}


?>