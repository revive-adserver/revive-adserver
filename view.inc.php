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



// Seed the random number generator
mt_srand((double) microtime() * 1000000);



/*********************************************************/
/* Build the query needed to fetch banners               */
/*********************************************************/

function phpAds_buildQuery ($part, $numberofparts, $precondition)
{
	global $phpAds_config;
	
	// Setup basic query
	$select = "
			SELECT
				".$phpAds_config['tbl_banners'].".bannerid as bannerid,
				".$phpAds_config['tbl_banners'].".clientid as clientid,
				".$phpAds_config['tbl_banners'].".priority as priority,
				".$phpAds_config['tbl_clients'].".weight as clientweight,
				".$phpAds_config['tbl_banners'].".contenttype as contenttype,
				".$phpAds_config['tbl_banners'].".storagetype as storagetype,
				".$phpAds_config['tbl_banners'].".htmlcache as htmlcache,
				".$phpAds_config['tbl_banners'].".width as width,
				".$phpAds_config['tbl_banners'].".height as height,
				".$phpAds_config['tbl_banners'].".weight as weight,
				".$phpAds_config['tbl_banners'].".seq as seq,
				".$phpAds_config['tbl_banners'].".target as target
			FROM
				".$phpAds_config['tbl_banners'].",
				".$phpAds_config['tbl_clients']."
			WHERE
				".$phpAds_config['tbl_banners'].".active = 't' AND 
				".$phpAds_config['tbl_clients'].".active = 't' AND 
				".$phpAds_config['tbl_banners'].".clientid = ".$phpAds_config['tbl_clients'].".clientid";
	
	// Add preconditions to query
	if ($precondition != '')
		$select .= " $precondition ";
	
	
	// Other
	if ($part != '')
	{
		$conditions = '';
		$onlykeywords = true;
		
		$part_array = explode(',', $part);
		for ($k=0; $k < count($part_array); $k++)
		{
			// Process switches
			if ($phpAds_config['con_key'])
			{
				if (substr($part_array[$k], 0, 1) == '+' || substr($part_array[$k], 0, 1) == '_')
				{
					$operator = 'AND';
					$part_array[$k] = substr($part_array[$k], 1);
				}
				elseif (substr($part_array[$k], 0, 1) == '-')
				{
					$operator = 'NOT';
					$part_array[$k] = substr($part_array[$k], 1);
				}
				else
					$operator = 'OR';
			}
			else
				$operator = 'OR';
			
			
			//	Test statements
			if($part_array[$k] != '' && $part_array[$k] != ' ')
			{
				// Banner dimensions
				if(ereg('^[0-9]+x[0-9]+$', $part_array[$k]))
				{
					list($width, $height) = explode('x', $part_array[$k]);
						
					if ($operator == 'OR')
						$conditions .= "OR (".$phpAds_config['tbl_banners'].".width = $width AND ".$phpAds_config['tbl_banners'].".height = $height) ";
					elseif ($operator == 'AND')
						$conditions .= "AND (".$phpAds_config['tbl_banners'].".width = $width AND ".$phpAds_config['tbl_banners'].".height = $height) ";
					else
						$conditions .= "AND (".$phpAds_config['tbl_banners'].".width != $width OR ".$phpAds_config['tbl_banners'].".height != $height) ";
					
					$onlykeywords = false;
				}
				
				// Banner Width
				elseif (substr($part_array[$k],0,6) == 'width:')
				{
					$part_array[$k] = substr($part_array[$k], 6);
					if($part_array[$k] != '' && $part_array[$k] != ' ')
						
					if ($operator == 'OR')
						$conditions .= "OR ".$phpAds_config['tbl_banners'].".width = '".trim($part_array[$k])."' ";
					elseif ($operator == 'AND')
						$conditions .= "AND ".$phpAds_config['tbl_banners'].".width = '".trim($part_array[$k])."' ";
					else
						$conditions .= "AND ".$phpAds_config['tbl_banners'].".width != '".trim($part_array[$k])."' ";
					
					$onlykeywords = false;
				}
				
				// Banner ID
				elseif ((substr($part_array[$k], 0, 9) == 'bannerid:') || (ereg('^[0-9]+$', $part_array[$k])))
				{
					if (substr($part_array[$k], 0, 9) == 'bannerid:')
						$part_array[$k] = substr($part_array[$k], 9);
					
					if ($part_array[$k] != '' && $part_array[$k] != ' ')
					{
						if ($operator == 'OR')
							$conditions .= "OR ".$phpAds_config['tbl_banners'].".bannerid='".trim($part_array[$k])."' ";
						elseif ($operator == 'AND')
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".bannerid='".trim($part_array[$k])."' ";
						else
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".bannerid!='".trim($part_array[$k])."' ";
					}
					
					$onlykeywords = false;
				}
				
				// Client ID
				elseif (substr($part_array[$k], 0, 9) == 'clientid:')
				{
					$part_array[$k] = substr($part_array[$k], 9);
					if ($part_array[$k] != '' && $part_array[$k] != ' ')
					{
						if ($operator == 'OR')
							$conditions .= "OR (".$phpAds_config['tbl_clients'].".clientid='".trim($part_array[$k])."' OR ".$phpAds_config['tbl_clients'].".parent='".trim($part_array[$k])."') ";
						elseif ($operator == 'AND')
							$conditions .= "AND (".$phpAds_config['tbl_clients'].".clientid='".trim($part_array[$k])."' OR ".$phpAds_config['tbl_clients'].".parent='".trim($part_array[$k])."') ";
						else
							$conditions .= "AND (".$phpAds_config['tbl_clients'].".clientid!='".trim($part_array[$k])."' AND ".$phpAds_config['tbl_clients'].".parent!='".trim($part_array[$k])."') ";
					}
					
					$onlykeywords = false;
				}
				
				// Format
				elseif (substr($part_array[$k], 0, 7) == 'format:')
				{
					$part_array[$k] = substr($part_array[$k], 7);
					if($part_array[$k] != '' && $part_array[$k] != ' ')
					{
						if ($operator == 'OR')
							$conditions .= "OR ".$phpAds_config['tbl_banners'].".contenttype='".trim($part_array[$k])."' ";
						elseif ($operator == 'AND')
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".contenttype='".trim($part_array[$k])."' ";
						else
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".contenttype!='".trim($part_array[$k])."' ";
					}
					
					$onlykeywords = false;
				}
				
				// HTML
				elseif($part_array[$k] == 'html')
				{
					if ($operator == 'OR')
						$conditions .= "OR ".$phpAds_config['tbl_banners'].".contenttype='html' ";
					elseif ($operator == 'AND')
						$conditions .= "AND ".$phpAds_config['tbl_banners'].".contenttype='html' ";
					else
						$conditions .= "AND ".$phpAds_config['tbl_banners'].".contenttype!='html' ";
					
					$onlykeywords = false;
				}
				
				// Keywords
				else
				{
					if(!$phpAds_config['mult_key'])
					{
						if ($operator == 'OR')
							$conditions .= "OR ".$phpAds_config['tbl_banners'].".keyword = '".trim($part_array[$k])."' ";
						elseif ($operator == 'AND')
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".keyword = '".trim($part_array[$k])."' ";
						else
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".keyword != '".trim($part_array[$k])."' ";
					}
					else
					{
						$mult_key_match = "(".$phpAds_config['tbl_banners'].".keyword LIKE '% $part_array[$k] %'".
										  " OR ".$phpAds_config['tbl_banners'].".keyword LIKE '$part_array[$k] %'".
										  " OR ".$phpAds_config['tbl_banners'].".keyword LIKE '% $part_array[$k]'".
										  " OR ".$phpAds_config['tbl_banners'].".keyword LIKE '$part_array[$k]')";
						
						if ($operator == 'OR')
							$conditions .= "OR $mult_key_match ";
						elseif ($operator == 'AND')
							$conditions .= "AND $mult_key_match ";
						else
							$conditions .= "AND NOT $mult_key_match ";
					}
				}
			}
		}
		
		// Strip first AND or OR from $conditions
		$conditions = strstr($conditions, ' ');
		
		// Add global keyword
		if ($numberofparts == 1 && $onlykeywords == true)
		{
			$conditions .= "OR ".$phpAds_config['tbl_banners'].".keyword = 'global' ";
		}
		
		// Add conditions to select
		if ($conditions != '') $select .= ' AND ('.$conditions.') ';
	}
	
	return ($select);
}



/*********************************************************/
/* Get a banner                                          */
/*********************************************************/

function phpAds_fetchBanner($what, $clientid, $context=0, $source='', $allowhtml=true)
{
	global $phpAds_config;
	global $REMOTE_HOST, $REMOTE_ADDR, $HTTP_USER_AGENT, $HTTP_ACCEPT_LANGUAGE;
	global $phpAds_zone_used;
	
	
	
	// Zones
	if (substr($what,0,5) == 'zone:')
	{
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
				$what = '';
			
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
		
		$phpAds_zone_used = true;
		
		
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
	}
	
	
	// What parameter
	else
	{
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
		
		if ($allowhtml == false)
		{
			$precondition .= " AND ".$phpAds_config['tbl_banners'].".contenttype != 'html' AND ".$phpAds_config['tbl_banners'].".contenttype != 'swf' ";
		}
		
		// Separate parts
		$what_parts = explode ('|', $what);	
		
		for ($wpc=0; $wpc < sizeof($what_parts); $wpc++)	// build a query and execute for each part
		{
			// Build the query needed to fetch the banners
			$select = phpAds_buildQuery ($what_parts[$wpc], sizeof($what_parts), $precondition);
			
			// Handle sequential banner retrieval
			if($phpAds_config['retrieval_method'] != 0)
			{
				$seq_select = $select." AND ".$phpAds_config['tbl_banners'].".seq > 0";
				
				// Full sequential retrieval
				if ($phpAds_config['retrieval_method'] == 3)
					$seq_select .= " ORDER BY ".$phpAds_config['tbl_banners'].".bannerid LIMIT 1";
				
				// First attempt to fetch a banner
				$res = phpAds_dbQuery($seq_select);
				
				if (phpAds_dbNumRows($res) == 0)
				{
					// No banner left, reset all banners in this category to 'unused', try again below
					
					// Get all matching banners
					$updateres = phpAds_dbQuery($select);
					while ($update_row = phpAds_dbFetchArray($updateres))
					{
						if ($phpAds_config['retrieval_method'] == 2)
						{
							// Set banner seq to weight
							$updateweight  = $update_row['weight'] * $update_row['clientweight'];
							$delete_select = "UPDATE ".$phpAds_config['tbl_banners']." SET seq='$updateweight' WHERE bannerid='".$update_row['bannerid']."'";
							phpAds_dbQuery($delete_select);
						}
						else
						{
							// Set banner seq to 1
							$delete_select = "UPDATE ".$phpAds_config['tbl_banners']." SET seq=1 WHERE bannerid='".$update_row['bannerid']."'";
							phpAds_dbQuery($delete_select);
						}
					}
					
					// Set query to be used next to sequential banner retrieval
					$select = $seq_select;
				}
				else
				{
					// Found banners, continue
					break;
				}
			}
			
			// Attempt to fetch a banner
			$res = phpAds_dbQuery($select);
			if ($res) 
			{
				if (phpAds_dbNumRows($res) > 0)	break;	// Found banners, continue
			}
			
			// No banners found in this part, try again with next part
		}
		
		
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
		
		$phpAds_zone_used = false;
	}
	
	if ($phpAds_config['acl'])
	{
		$date = getdate(time());
		$request = array(
			'remote_host'		=>	$REMOTE_ADDR,
			'user_agent'		=>	$HTTP_USER_AGENT,
			'accept-language'	=>	$HTTP_ACCEPT_LANGUAGE,
			'weekday'			=>	$date['wday'],
			'source'			=>	$source,
			'time'				=>	$date['hours']);
	}
	
	$maxindex = sizeof($rows);
	
	while ($prioritysum && sizeof($rows))
	{
		$low = 0;
		$high = 0;
		$ranweight = ($prioritysum > 1) ? mt_rand(0, $prioritysum - 1) : 0;
		
		for ($i=0; $i<$maxindex; $i++)
		{
			if ($rows[$i] != null)
			{
				$low = $high;
				$high += $rows[$i]['priority'];
				
				if ($high > $ranweight && $low <= $ranweight)
				{
					if ($phpAds_zone_used)
					{
						// Preconditions can't be used with zones,
						// so use postconditions instead
						
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
						    $allowhtml == false &&
						    ($rows[$i]['contenttype'] == 'html' || $rows[$i]['contenttype'] == 'swf'))
							$postconditionSucces = false;
						
						
						if ($postconditionSucces == false)
						{
							// Failed one of the postconditions
							// No more posibilities left, exit!
							if (sizeof($rows) == 1)
								return false;
							
							// Delete this row and adjust $prioritysum
							$prioritysum -= $rows[$i]['priority'];
							$rows[$i] = null;
							
							// Break out of the for loop to try again
							break;
						}
					}
					
					// Banner was not on exclude list
					// and was on include list (if one existed)
					// Now continue with ACL check
					
					if ($phpAds_config['acl'])
					{
						if (phpAds_aclCheck($request, $rows[$i]))
						{
							// ACL check passed, found banner!
							if ($phpAds_zone_used) 
								$rows[$i]['zoneid'] = $zoneid;
							else
								$rows[$i]['zoneid'] = 0;
							
							return ($rows[$i]);
						}
						
						// Matched, but phpAds_aclCheck failed.
						// No more posibilities left, exit!
						if (sizeof($rows) == 1)
							return false;
						
						// Delete this row and adjust $prioritysum
						$prioritysum -= $rows[$i]['priority'];
						$rows[$i] = null;
						
						// Break out of the for loop to try again
						break;
					}
					else
					{
						// Don't check ACLs, found banner!
						if ($phpAds_zone_used) 
							$rows[$i]['zoneid'] = $zoneid;
						else
							$rows[$i]['zoneid'] = 0;
						
						return ($rows[$i]);
					}
				}
			}
		}
	}
}



/*********************************************************/
/* Log an adview for the banner with $bannerid           */
/*********************************************************/

function phpAds_prepareLog ($bannerid, $clientid, $zoneid)
{
	global $phpAds_config;
	global $phpAds_zone_used;
	
	// If sequential banner retrieval is used, set banner as "used"
	if ($phpAds_config['retrieval_method'] > 0 && $phpAds_zone_used != true)
		phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_banners']." SET seq=seq-1 WHERE bannerid='$bannerid'");
	
	if(!$phpAds_config['log_adviews'])
		return(false);
	
	// Check if host is on list of hosts to ignore
	if($host = phpads_ignore_host())
	{ 
		$res = phpAds_logView($bannerid, $zoneid, $host);
		phpAds_expire ($clientid, phpAds_Views);
	}
}



/*********************************************************/
/* Parse the PHP inside a HTML banner                    */
/*********************************************************/

function phpAds_ParseHTMLExpressions ($parser_html)
{
	if (eregi ("(\<\?php(.*)\?\>)", $parser_html, $parser_regs))
	{
		// Extract PHP script
		$parser_php 	= $parser_regs[2];
		$parser_result 	= '';
		
		// Replace output function
		$parser_php = eregi_replace ("echo([^;]*);", '$parser_result .=\\1;', $parser_php);
		$parser_php = eregi_replace ("print([^;]*);", '$parser_result .=\\1;', $parser_php);
		$parser_php = eregi_replace ("printf([^;]*);", '$parser_result .= sprintf\\1;', $parser_php);
		
		// Split the PHP script into lines
		$parser_lines = explode (";", $parser_php);
		for ($parser_i = 0; $parser_i < sizeof($parser_lines); $parser_i++)
		{
			if (trim ($parser_lines[$parser_i]) != '')
				eval (trim ($parser_lines[$parser_i]).';');
		}
		
		// Replace the script with the result
		$parser_html = str_replace ($parser_regs[1], $parser_result, $parser_html);
	}
	
	return ($parser_html);
}



/*********************************************************/
/* Create the HTML needed to display the banner          */
/*********************************************************/

function view_raw($what, $clientid=0, $target='', $source='', $withtext=0, $context=0)
{
	global $phpAds_config;
	global $REMOTE_HOST, $HTTP_USER_AGENT;
	
	// If $clientid consists of alpha-numeric chars it is
	// not the clientid, but the target parameter.
	if(!ereg('^[0-9]+$', $clientid))
	{
		$target = $clientid;
		$clientid = 0;
	}
	
	// Open database connection
	phpAds_dbConnect();
	
	// Get one valid banner
	$row = phpAds_fetchBanner($what, $clientid, $context, $source);
	
	
	if (is_array($row) && $row['bannerid'] != '')
	{
		// Get HTML cache
		$outputbuffer = $row['htmlcache'];
		
		
		// Determine target
		if ($row['target'] == '')
		{
			if ($target == '') $target = '_blank';  // default
		}
		else
			$target = $row['target'];
		
		
		// Set basic variables
		$outputbuffer = str_replace ('{bannerid}', $row['bannerid'], $outputbuffer);
		$outputbuffer = str_replace ('{zoneid}', $row['zoneid'], $outputbuffer);
		$outputbuffer = str_replace ('{target}', $target, $outputbuffer);
		
		
		// Add text below banner
		if ($withtext)
		{
			$outputbuffer = str_replace ('[bannertext]', '', $outputbuffer);
			$outputbuffer = str_replace ('[/bannertext]', '', $outputbuffer);
		}
		else
			$outputbuffer = eregi_replace ("\[bannertext\](.*)\[\/bannertext\]", '', $outputbuffer);
		
		
		// Add text below banner
		if ($withtext && $row['bannertext'] != '')
			$outputbuffer .= '<br><a href=\''.$phpAds_config['url_prefix'].'/adclick.php?bannerid='.$row['bannerid'].'&zoneid='.$row['zoneid'].'\''.$targettag.$status.'>'.$row['bannertext'].'</a>';
		
		
		// HTML/URL banner options
		if ($row['storagetype'] == 'html' || 
			$row['storagetype'] == 'url' || 
			$row['storagetype'] == 'network')
		{
			// Replace timestamp
			$outputbuffer = str_replace ('{timestamp}',	time(), $outputbuffer);
			$outputbuffer = str_replace ('%7Btimestamp%7D',	time(), $outputbuffer);
			
			// Replace random
			while (eregi ('(%7B|{)random((%3A|:)([1-9]+)){0,1}(%7D|})', $outputbuffer, $matches))
			{
				if ($matches[4])
					$randomdigits = $matches[4];
				else
					$randomdigits = 8;
				
				if ($lastdigits == $randomdigits)
					$randomnumber = $lastrandom;
				else
				{
					$randomnumber = '';
					
					for ($r=0; $r<$randomdigits; $r=$r+10)
						$randomnumber .= (string)mt_rand (1111111111, 9999999999);
					
					$randomnumber  = substr($randomnumber, 0 - $randomdigits);
				}
				
				$outputbuffer = str_replace ($matches[0], $randomnumber, $outputbuffer);
				
				$lastdigits = $randomdigits;
				$lastrandom = $randomnumber;
			}
		}
		
		
		// Parse PHP code inside HTML banners
		if ($row['storagetype'] == 'html')
		{
			if ($phpAds_config['type_html_php'])
			{
				$outputbuffer = phpAds_ParseHTMLExpressions ($outputbuffer);
			}
		}
		
		
		// Prepare impression logging
		if (!$phpAds_config['log_beacon'])
		{
			// Log now
			phpAds_prepareLog($row['bannerid'], $row['clientid'], $row['zoneid']);
		}
		else
		{
			// Add beacon image for logging
			if (ereg ("Mozilla/(1|2|3|4)", $HTTP_USER_AGENT) && !ereg("compatible", $HTTP_USER_AGENT))
			{
				$outputbuffer .= '<layer id="beacon_'.$row['bannerid'].'" width="0" height="0" border="0" visibility="hide">';
				$outputbuffer .= '<img src=\''.$phpAds_config['url_prefix'].'/adlog.php?bannerid='.$row['bannerid'].'&clientid='.$row['clientid'].'&zoneid='.$row['zoneid'].'&cb='.md5(uniqid('')).'\' width=\'0\' height=\'0\'>';
				$outputbuffer .= '</layer>';
			}
			else
				$outputbuffer .= '<img src=\''.$phpAds_config['url_prefix'].'/adlog.php?bannerid='.$row['bannerid'].'&clientid='.$row['clientid'].'&zoneid='.$row['zoneid'].'&cb='.md5(uniqid('')).'\' width=\'0\' height=\'0\' style=\'width: 0px; height: 0px;\'>';
		}
	}
	else
	{
		// An error occured, or there are no banners to display at all
		// Use the default banner if defined
		
		if ($phpAds_config['default_banner_target'] != '' && $phpAds_config['default_banner_url'] != '')
		{
			// Determine target
			if ($target == '') $target = '_blank';  // default
			
			// Show default banner
			$outputbuffer = '<a href=\''.$phpAds_config['default_banner_target'].'\' target=\''.$target.'\'><img src=\''.$phpAds_config['default_banner_url'].'\' border=\'0\'></a>';
			
			return( array('html' => $outputbuffer, 
						  'bannerid' => '')
				  );
		}
	}
	
	phpAds_dbClose();
	
	return( array('html' => $outputbuffer, 
				  'bannerid' => $row['bannerid'],
				  'width' => $row['width'],
				  'height' => $row['height'])
		  );
}



/*********************************************************/
/* Display a banner                                      */
/*********************************************************/

function view($what, $clientid=0, $target='', $source='', $withtext=0, $context=0)
{
	$output = view_raw($what, $clientid, "$target", "$source", $withtext, $context);
	print($output['html']);
	return($output['bannerid']);
}

?>