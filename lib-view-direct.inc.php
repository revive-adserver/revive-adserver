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
define ('LIBVIEWDIRECT_INCLUDED', true);


/*********************************************************/
/* Get a banner                                          */
/*********************************************************/

function phpAds_fetchBannerDirect($remaining, $clientid, $context = 0, $source = '', $richmedia = true)
{
	global $phpAds_config;
	
	// Build preconditions
	if (is_array ($context))
	{
		for ($i=0; $i < count($context); $i++)
		{
			list ($key, $value) = each($context[$i]);
			{
				switch ($key)
				{
					case '!=': $contextExclusive[] = $phpAds_config['tbl_banners'].'.bannerid <> '.$value; break;
					case '==': $contextInclusive[] = $phpAds_config['tbl_banners'].'.bannerid = '.$value; break;
				}
			}
		}
		
		$where_exclusive = !empty($contextExclusive) ? implode(' AND ', $contextExclusive) : '';
		$where_inclusive = !empty($contextInclusive) ? implode(' OR ', $contextInclusive) : '';
		
		$precondition = sprintf("$where_inclusive %s $where_exclusive", (!empty($where_inclusive) && !empty($where_exclusive)) ? 'AND' : '');
		$precondition = trim($precondition);
		
		if (!empty($precondition))
			$precondition = ' AND '.$precondition;
	}
	else
		$precondition = '';
	
	if ($clientid != 0)
		$precondition .= " AND (".$phpAds_config['tbl_clients'].".clientid = $clientid OR ".$phpAds_config['tbl_clients'].".parent = $clientid) ";
	
	if ($richmedia == false)
		$precondition .= " AND (".$phpAds_config['tbl_banners'].".contenttype = 'jpeg' OR ".$phpAds_config['tbl_banners'].".contenttype = 'gif' OR ".$phpAds_config['tbl_banners'].".contenttype = 'png') ";
	
	
	
	// Get first part, store second part
	$what = strtok($remaining, '|');
	$remaining = strtok ('');
	
	$select = phpAds_buildQuery ($what, $remaining == '', $precondition);
	$res    = phpAds_dbQuery($select);
	
	if (phpAds_dbNumRows($res) > 0)	
	{
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
						// Blocked
						if (isset($GLOBALS['phpAds_blockAd'][$rows[$i]['bannerid']]))
						{
							// Delete this row and adjust $prioritysum
							$prioritysum -= $rows[$i]['priority'];
							$rows[$i] = '';
							
							// Break out of the for loop to try again
							break;
						}
						
						if ($phpAds_config['acl'])
						{
							if (phpAds_aclCheck($rows[$i], $source))
							{
								// ACL check passed, found banner!
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
	}
	
	return ($remaining);
}


?>