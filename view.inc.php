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
require ("$phpAds_path/dblib.php");
require ("$phpAds_path/lib-expire.inc.php");

// Seed the random number generator
mt_srand((double) microtime() * 1000000);



/*********************************************************/
/* Build the query needed to fetch banners               */
/*********************************************************/

function phpAds_buildQuery ($part, $numberofparts, $precondition)
{
	global $phpAds_tbl_banners, $phpAds_tbl_clients;
	global $phpAds_con_key, $phpAds_mult_key;
	
	
	// Setup basic query
	$select = "
			SELECT
				$phpAds_tbl_banners.bannerID as bannerID,
				$phpAds_tbl_banners.banner as banner,
				$phpAds_tbl_banners.clientID as clientID,
				$phpAds_tbl_banners.format as format,
				$phpAds_tbl_banners.width as width,
				$phpAds_tbl_banners.height as height,
				$phpAds_tbl_banners.alt as alt,
				$phpAds_tbl_banners.status as status,
				$phpAds_tbl_banners.bannertext as bannertext,
				$phpAds_tbl_banners.url as url,
				$phpAds_tbl_banners.weight as weight,
				$phpAds_tbl_banners.seq as seq,
				$phpAds_tbl_banners.target as target,
				$phpAds_tbl_banners.autohtml as autohtml,
				$phpAds_tbl_clients.weight as clientweight
			FROM
				$phpAds_tbl_banners,
				$phpAds_tbl_clients
			WHERE
				$phpAds_tbl_banners.active = 'true' AND 
				$phpAds_tbl_clients.active = 'true' AND 
				$phpAds_tbl_banners.clientID = $phpAds_tbl_clients.clientID";
	
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
			if ($phpAds_con_key == '1')
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
						$conditions .= "OR ($phpAds_tbl_banners.width = $width AND $phpAds_tbl_banners.height = $height) ";
					elseif ($operator == 'AND')
						$conditions .= "AND ($phpAds_tbl_banners.width = $width AND $phpAds_tbl_banners.height = $height) ";
					else
						$conditions .= "AND ($phpAds_tbl_banners.width != $width OR $phpAds_tbl_banners.height != $height) ";
					
					$onlykeywords = false;
				}
				
				// Banner Width
				elseif (substr($part_array[$k],0,6) == 'width:')
				{
					$part_array[$k] = substr($part_array[$k], 6);
					if($part_array[$k] != '' && $part_array[$k] != ' ')
						
					if ($operator == 'OR')
						$conditions .= "OR $phpAds_tbl_banners.width = '".trim($part_array[$k])."' ";
					elseif ($operator == 'AND')
						$conditions .= "AND $phpAds_tbl_banners.width = '".trim($part_array[$k])."' ";
					else
						$conditions .= "AND $phpAds_tbl_banners.width != '".trim($part_array[$k])."' ";
					
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
							$conditions .= "OR $phpAds_tbl_banners.bannerID='".trim($part_array[$k])."' ";
						elseif ($operator == 'AND')
							$conditions .= "AND $phpAds_tbl_banners.bannerID='".trim($part_array[$k])."' ";
						else
							$conditions .= "AND $phpAds_tbl_banners.bannerID!='".trim($part_array[$k])."' ";
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
							$conditions .= "OR ($phpAds_tbl_clients.clientID='".trim($part_array[$k])."' OR $phpAds_tbl_clients.parent='".trim($part_array[$k])."') ";
						elseif ($operator == 'AND')
							$conditions .= "AND ($phpAds_tbl_clients.clientID='".trim($part_array[$k])."' OR $phpAds_tbl_clients.parent='".trim($part_array[$k])."') ";
						else
							$conditions .= "AND ($phpAds_tbl_clients.clientID!='".trim($part_array[$k])."' AND $phpAds_tbl_clients.parent!='".trim($part_array[$k])."') ";
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
							$conditions .= "OR $phpAds_tbl_banners.format='".trim($part_array[$k])."' ";
						elseif ($operator == 'AND')
							$conditions .= "AND $phpAds_tbl_banners.format='".trim($part_array[$k])."' ";
						else
							$conditions .= "AND $phpAds_tbl_banners.format!='".trim($part_array[$k])."' ";
					}
					
					$onlykeywords = false;
				}
				
				// HTML
				elseif($part_array[$k] == 'html')
				{
					if ($operator == 'OR')
						$conditions .= "OR $phpAds_tbl_banners.format='html' ";
					elseif ($operator == 'AND')
						$conditions .= "AND $phpAds_tbl_banners.format='html' ";
					else
						$conditions .= "AND $phpAds_tbl_banners.format!='html' ";
					
					$onlykeywords = false;
				}
				
				// Keywords
				else
				{
					if($phpAds_mult_key != '1')
						if ($operator == 'OR')
							$conditions .= "OR $phpAds_tbl_banners.keyword = '".trim($part_array[$k])."' ";
						elseif ($operator == 'AND')
							$conditions .= "AND $phpAds_tbl_banners.keyword = '".trim($part_array[$k])."' ";
						else
							$conditions .= "AND $phpAds_tbl_banners.keyword != '".trim($part_array[$k])."' ";
					else
					{
					$mult_key_match = "($phpAds_tbl_banners.keyword LIKE '% $part_array[$k] %'".
						" OR $phpAds_tbl_banners.keyword LIKE '$part_array[$k] %'".
						" OR $phpAds_tbl_banners.keyword LIKE '% $part_array[$k]'".
						" OR $phpAds_tbl_banners.keyword LIKE '$part_array[$k]')";
					
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
			$conditions .= "OR $phpAds_tbl_banners.keyword = 'global' ";
		}
		
		// Add conditions to select
		if ($conditions != '') $select .= ' AND ('.$conditions.') ';
	}
	
	return ($select);
}



/*********************************************************/
/* Get a banner                                          */
/*********************************************************/

function get_banner($what, $clientID, $context=0, $source='', $allowhtml=true)
{
	global $REMOTE_HOST, $REMOTE_ADDR, $HTTP_USER_AGENT, $HTTP_ACCEPT_LANGUAGE;
	global $phpAds_tbl_banners, $phpAds_tbl_clients, $phpAds_tbl_zones;
	global $phpAds_random_retrieve, $phpAds_zone_cache_limit, $phpAds_zone_cache;
	global $phpAds_zone_used;
	
	// Build preconditions
	if (is_array ($context))
	{
		for ($i=0; $i < count($context); $i++)
		{
			list ($key, $value) = each($context[$i]);
			{
				switch ($key)
				{
					case '!=': $contextExclusive[] = $phpAds_tbl_banners.'.bannerID <> '.$value; break;
					case '==': $contextInclusive[] = $phpAds_tbl_banners.'.bannerID = '.$value; break;
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
	
	if ($clientID != 0)
		$precondition .= " AND ($phpAds_tbl_clients.clientID = $clientID OR $phpAds_tbl_clients.parent = $clientID) ";
	
	if ($allowhtml == false)
		$precondition .= " AND $phpAds_tbl_banners.format != 'html' AND $phpAds_tbl_banners.format != 'swf' ";
	
	
	
	
	
	// Zones
	if (substr($what,0,5) == 'zone:')
	{
		// Get zone
		$zoneid  = substr($what,5);
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
		
		
		if (isset($zone) &&
			$phpAds_zone_cache && 
			time() - $zone['cachetimestamp'] < $phpAds_zone_cache_limit && 
			$zone['cachecontents'] != '')
		{
			// If zone is found and cache is not expired
			// and cache exists use it.
			list($weightsum, $rows) = unserialize ($zone['cachecontents']);
		}
		else
		{
			// If zone does not exists or cache has expired
			// or cache is empty build a query
			
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
			
			if ($phpAds_zone_cache && isset($zone) &&
				($zone['cachecontents'] == '' ||
				time() - $zone['cachetimestamp'] >= $phpAds_zone_cache_limit))
			{
				// If exists and cache is empty or expired
				// Store the rows which were just build in the cache
				
				$cachecontents = addslashes (serialize (array ($weightsum, $rows)));
				$cachetimestamp = time();
				@db_query("UPDATE $phpAds_tbl_zones SET cachecontents='$cachecontents', cachetimestamp=$cachetimestamp WHERE zoneid='$zoneid' ");
			}
		}
		
		$phpAds_zone_used = true;
	}
	else
	{
		// Separate parts
		$what_parts = explode ('|', $what);	
		
		for ($wpc=0; $wpc < sizeof($what_parts); $wpc++)	// build a query and execute for each part
		{
			// Build the query needed to fetch the banners
			$select = phpAds_buildQuery ($what_parts[$wpc], sizeof($what_parts), $precondition);
			
			
			
			// Handle sequential banner retrieval
			if($phpAds_random_retrieve != 0)
			{
				$seq_select = $select . " AND $phpAds_tbl_banners.seq > 0";
				
				// Full sequential retrieval
				if ($phpAds_random_retrieve == 3)
					$seq_select .= " ORDER BY $phpAds_tbl_banners.bannerID LIMIT 1";
				
				// First attempt to fetch a banner
				$res = @db_query($seq_select);
				
				if (@mysql_num_rows($res) == 0)
				{
					// No banner left, reset all banners in this category to 'unused', try again below
					
					// Get all matching banners
					$updateres = @db_query($select);
					while ($update_row = @mysql_fetch_array($updateres))
					{
						if ($phpAds_random_retrieve == 2)
						{
							// Set banner seq to weight
							$updateweight = $update_row['weight'] * $update_row['clientweight'];
							$delete_select="UPDATE $phpAds_tbl_banners SET seq='$updateweight' WHERE bannerID='".$update_row['bannerID']."'";
							@db_query($delete_select);
						}
						else
						{
							// Set banner seq to 1
							$delete_select="UPDATE $phpAds_tbl_banners SET seq=1 WHERE bannerID='".$update_row['bannerID']."'";
							@db_query($delete_select);
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
			$res = @db_query($select);
			if ($res) 
			{
				if (@mysql_num_rows($res) > 0)	break;	// Found banners, continue
			}
			
			// No banners found in this part, try again with next part
		}
		
		
		// Build array for further processing...
		$rows = array();
		$weightsum = 0;
		while ($tmprow = @mysql_fetch_array($res))
		{
			// weight of 0 disables the banner
			if ($tmprow['weight'])
			{
				$weightsum += ($tmprow['weight'] * $tmprow['clientweight']);
				$rows[] = $tmprow; 
			}
		}
		
		$phpAds_zone_used = false;
	}
	
	
	
	$date = getdate(time());
	$request = array(
		'remote_host'		=>	$REMOTE_ADDR,
		'user_agent'		=>	$HTTP_USER_AGENT,
		'accept-language'	=>	$HTTP_ACCEPT_LANGUAGE,
		'weekday'			=>	$date['wday'],
		'source'			=>	$source,
		'time'				=>	$date['hours']);
	
	$maxindex = sizeof($rows);
	
	while ($weightsum && sizeof($rows))
	{
		$low = 0;
		$high = 0;
		$ranweight = ($weightsum > 1) ? mt_rand(0, $weightsum - 1) : 0;
		
		for ($i=0; $i<$maxindex; $i++)
		{
			$low = $high;
			$high += ($rows[$i]['weight'] * $rows[$i]['clientweight']);
			
			if ($high > $ranweight && $low <= $ranweight)
			{
				if ($phpAds_acl == '1')
				{
					if (acl_check($request, $rows[$i]))
						return ($rows[$i]);
					
					// Matched, but acl_check failed.
					// No more posibilities left, exit!
					if (sizeof($rows) == 1)
						return false;
					
					// Delete this row and adjust $weightsum
					$weightsum -= ($rows[$i]['weight'] * $rows[$i]['clientweight']);
					unset($rows[$i]);
					
					// Break out of the for loop to try again
					break;
				}
				else
				{
					return ($rows[$i]);
				}
			}
		}
	}
}



/*********************************************************/
/* Log an adview for the banner with $bannerID           */
/*********************************************************/

function log_adview ($bannerID, $clientID)
{
	global $phpAds_log_adviews;
	global $phpAds_tbl_banners;
	global $phpAds_random_retrieve;
	global $phpAds_zone_used;
	
	// If sequential banner retrieval is used, set banner as "used"
	if ($phpAds_random_retrieve > 0 && $phpAds_zone_used != true)
		@db_query("UPDATE $phpAds_tbl_banners SET seq=seq-1 WHERE bannerID='$bannerID'");
	
	if(!$phpAds_log_adviews)
		return(false);
	
	// Check if host is on list of hosts to ignore
	if($host = phpads_ignore_host())
	{ 
		$res = @db_log_view($bannerID, $host);
		phpAds_expire ($clientID, phpAds_Views);
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
/* Parse the HTML entered in order to log clicks         */
/*********************************************************/

function phpAds_ParseHTMLAutoLog ($html, $bannerID, $url, $target)
{
	global $phpAds_url_prefix;
	
	
	// Automatic replace all target='...' with the specified one
	$html = eregi_replace ("target=['|\"]{0,1}[^'|\"|[:space:]]+['|\"]{0,1}", "target='".$target."'", $html);
	
	
	// Check if a form is present in the HTML
	if (eregi('<form', $html))
	{
		// Add hidden field to forms
		$html = eregi_replace ("(<form([^>]*)action=['|\"]{0,1})([^'|\"|[:space:]]+)(['|\"]{0,1}([^>]*)>)", 
							   "\\1".$phpAds_url_prefix."/adclick.php\\4".
							   "<input type='hidden' name='dest' value='\\3'>".
							   "<input type='hidden' name='bannerID' value='".$bannerID."'>", $html);
	}
	
	
	// Check if links are present in the HTML
	if (eregi('<a', $html))
	{
		// Replace all links with adclick.php
		
		$newbanner	 = '';
		$prevhrefpos = '';
		
		$lowerbanner = strtolower($html);
		$hrefpos	 = strpos($lowerbanner, 'href=');
		
		while ($hrefpos > 0)
		{
			$hrefpos = $hrefpos + 5;
			$doublequotepos = strpos($lowerbanner, '"', $hrefpos);
			$singlequotepos = strpos($lowerbanner, "'", $hrefpos);
			
			if ($doublequotepos > 0 && $singlequotepos > 0)
			{
				if ($doublequotepos < $singlequotepos)
				{
					$quotepos  = $doublequotepos;
					$quotechar = '"';
				}
				else
				{
					$quotepos  = $singlequotepos;
					$quotechar = "'";
				}
			}
			else
			{
				if ($doublequotepos > 0)
				{
					$quotepos  = $doublequotepos;
					$quotechar = '"';
				}
				elseif ($singlequotepos > 0)
				{
					$quotepos  = $singlequotepos;
					$quotechar = "'";
				}
				else
					$quotepos  = 0;
			}
			
			if ($quotepos > 0)
			{
				$endquotepos = strpos($lowerbanner, $quotechar, $quotepos+1);
				
				if (substr ($html, $quotepos+1, 10) != '{targeturl')
				{
					$newbanner = $newbanner . 
							substr($html, $prevhrefpos, $hrefpos - $prevhrefpos) . 
							$quotechar . $phpAds_url_prefix . '/adclick.php?bannerID=' . 
							$bannerID . '&dest=' . 
							urlencode(substr($html, $quotepos+1, $endquotepos - $quotepos - 1)) .
							'&ismap=';
				}
				else
				{
					$newbanner = $newbanner . 
							substr($html, $prevhrefpos, $hrefpos - $prevhrefpos) . $quotechar . 
							substr($html, $quotepos+1, $endquotepos - $quotepos - 1);
				}
				
				$prevhrefpos = $hrefpos + ($endquotepos - $quotepos);
			}
			else
			{
				$spacepos = strpos($lowerbanner, ' ', $hrefpos+1);
				$endtagpos = strpos($lowerbanner, '>', $hrefpos+1);
				
				if ($spacepos < $endtagpos)
					$endpos = $spacepos;
				else
					$endpos = $endtagpos;
				
				if (substr($html, $hrefpos, 10) != '{targeturl')
				{
					$newbanner = $newbanner . 
							substr($html, $prevhrefpos, $hrefpos - $prevhrefpos) . 
							'"' . $phpAds_url_prefix . '/adclick.php?bannerID=' . 
							$bannerID . '&dest=' . 
							urlencode(substr($html, $hrefpos, $endpos - $hrefpos)) .
							'&ismap="';
				}
				else
				{
					$newbanner = $newbanner . 
							substr($html, $prevhrefpos, $hrefpos - $prevhrefpos) . '"' . 
							substr($html, $hrefpos, $endpos - $hrefpos) . '"';
				}
				
				$prevhrefpos = $hrefpos + ($endpos - $hrefpos);
			}
			
			$hrefpos = strpos($lowerbanner, 'href=', $hrefpos + 1);
		}
		
		$html = $newbanner.substr($html, $prevhrefpos);
	}
	
	if (!eregi('<form', $html) && !eregi('<a', $html) && $url != '')
	{
		if (strstr($target, '+'))
		{
			if ($row['target'] != '')
				$target = $row['target'];
			else
				$target = substr($target, 1);
		}
		
		$targettag = ' target="'.$target.'"';
		
		// No link or form
		$html = "<a href='$phpAds_url_prefix/adclick.php?bannerID=".$bannerID."&ismap='".$targettag.">".$html."</a>";
	}
	
	return ($html);
}



/*********************************************************/
/* Create the HTML needed to display the banner          */
/*********************************************************/

function view_raw($what, $clientID=0, $target='', $source='', $withtext=0, $context=0)
{
	global $phpAds_db, $REMOTE_HOST, $phpAds_url_prefix;
	global $phpAds_default_banner_url, $phpAds_default_banner_target;
	global $phpAds_type_html_auto, $phpAds_type_html_php;
	
	
	// If $clientID consists of alpha-numeric chars it is
	// not the clientID, but the target parameter.
	if(!ereg('^[0-9]+$', $clientID))
	{
		$target = $clientID;
		$clientID = 0;
	}
	
	// Open database connection
	db_connect();
	
	// Get one valid banner
	$row = get_banner($what, $clientID, $context, $source);
	
	
	
	$outputbuffer = "";
	
	if (is_array($row))
	{
		if (!empty($row['bannerID'])) 
		{
			if (!empty($target))
			{
				if (strstr($target, '+'))
				{
					if ($row['target'] != '')
						$target = $row['target'];
					else
						$target = substr($target, 1);
				}
				
				$targettag = ' target="'.$target.'"';
			}
			else
				$targettag = '';
			
			if ($row['status'] != '')
			{
				$status = stripslashes ($row['status']);
				$status = str_replace("\"", "\&quot;", $status);
				$status = str_replace("'", "\\'", $status);
				$status = " onMouseOver=\"self.status='".$status."';return true;\" onMouseOut=\"self.status='';return true;\"";
			}
			else
				$status = '';
			
			
			
			if($row['format'] == 'html')
			{
				// HTML banner
				$html = stripslashes($row['banner']);
				
				if ($phpAds_type_html_php == true)
					$html = phpAds_ParseHTMLExpressions ($html);
				
				if ($phpAds_type_html_auto == true && $row['autohtml'] == 'true')
					$html = phpAds_ParseHTMLAutoLog ($html, $row['bannerID'], $row['url'], $target);
				
				// Replace standard variables
				$html = str_replace ('{timestamp}',	time(), $html);
				$html = str_replace ('{bannerid}', 	$row['bannerID'], $html);
				$html = str_replace ('{targeturl}', $phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].'&ismap=', $html);
				
				if (strpos ($html, "{targeturl:") > 0)
				{
					while (eregi("{targeturl:([^}]*)}", $html, $regs))
					{
						$html = str_replace ($regs[0], $phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].'&dest='.urlencode($regs[1]).'&ismap=', $html);
					}
				}
				
				$lastrandom = 0;
				$lastdigits = 0;
				
				// Replace random
				while (eregi ('\{random(:([1-9])){0,1}\}', $html, $matches))
				{
					if ($matches[1] == "")
						$randomdigits = 8;
					else
						$randomdigits = $matches[2];
					
					if ($lastdigits == $randomdigits)
						$randomnumber = $lastrandom;
					else
						$randomnumber = sprintf ('%0'.$randomdigits.'d', mt_rand (0, pow (10, $randomdigits) - 1));
					
					$html = str_replace ($matches[0], $randomnumber, $html);
					
					$lastdigits = $randomdigits;
					$lastrandom = $randomnumber;
				}
				
				
				$outputbuffer = $html;
			}
			elseif ($row['format'] == 'url')
			{
				// Banner refered through URL
				
				// Replace standard variables
				$row['banner'] = str_replace ('{timestamp}',	time(), $row['banner']);
				
				// Determine cachebuster
				if (eregi ('\{random(:([1-9])){0,1}\}', $row['banner'], $matches))
				{
					if ($matches[1] == "")
						$randomdigits = 8;
					else
						$randomdigits = $matches[2];
					
					$randomnumber = sprintf ('%0'.$randomdigits.'d', mt_rand (0, pow (10, $randomdigits) - 1));
					$row['banner'] = str_replace ($matches[0], $randomnumber, $row['banner']);
					
					$randomstring = '&cb='.$randomnumber;
				}
				else
				{
					$randomstring = "";
				}
				
				if (eregi("swf$", $row['banner']))
				{
					$outputbuffer  = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ";
					$outputbuffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/";
					$outputbuffer .= "swflash.cab#version=5,0,0,0' width='".$row['width']."' height='".$row['height']."'>";
					$outputbuffer .= "<param name='movie' value='".$row['banner'].(empty($row['url']) ? '' : '?targeturl='.urlencode($phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].$randomstring))."'>";
					$outputbuffer .= "<param name='quality' value='high'>";
					$outputbuffer .= "<param name='bgcolor' value='#FFFFFF'>";
					$outputbuffer .= "<embed src='".$row['banner'].(empty($row['url']) ? '' : '?targeturl='.urlencode($phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].$randomstring))."' quality=high ";
					$outputbuffer .= "bgcolor='#FFFFFF' width='".$row['width']."' height='".$row['height']."' type='application/x-shockwave-flash' ";
					$outputbuffer .= "pluginspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>";
					$outputbuffer .= "</object>";
				}
				else
				{
					if (empty($row['url']))
						$outputbuffer .= '<img src=\''.$row['banner'].'\' width=\''.$row['width'].'\' height=\''.$row['height'].'\' alt=\''.$row['alt'].'\' title=\''.$row['alt'].'\' border=\'0\''.$status.'>';
					else
						$outputbuffer .= '<a href=\''.$phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].$randomstring.'\''.$targettag.$status.'><img src=\''.$row['banner'].'\' width=\''.$row['width'].'\' height=\''.$row['height'].'\' alt=\''.$row['alt'].'\' title=\''.$row['alt'].'\' border=\'0\'></a>';
				}
				
				if ($withtext && !empty($row['bannertext']))
					$outputbuffer .= '<br><a href=\''.$phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].'\''.$targettag.$status.'>'.$row['bannertext'].'</a>';
			}
			elseif ($row['format'] == 'web')
			{
				// Banner stored on webserver
				
				if (eregi("swf$", $row['banner']))
				{
					$outputbuffer  = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ";
					$outputbuffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/";
					$outputbuffer .= "swflash.cab#version=5,0,0,0' width='".$row['width']."' height='".$row['height']."'>";
					$outputbuffer .= "<param name='movie' value='".$row['banner'].(empty($row['url']) ? '' : '?targeturl='.urlencode($phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID']))."'>";
					$outputbuffer .= "<param name='quality' value='high'>";
					$outputbuffer .= "<param name='bgcolor' value='#FFFFFF'>";
					$outputbuffer .= "<embed src='".$row['banner'].(empty($row['url']) ? '' : '?targeturl='.urlencode($phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID']))."' quality=high ";
					$outputbuffer .= "bgcolor='#FFFFFF' width='".$row['width']."' height='".$row['height']."' type='application/x-shockwave-flash' ";
					$outputbuffer .= "pluginspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>";
					$outputbuffer .= "</object>";
				}
				else
				{
					if (empty($row['url']))
						$outputbuffer .= '<img src=\''.$row['banner'].'\' width=\''.$row['width'].'\' height=\''.$row['height'].'\' alt=\''.$row['alt'].'\' title=\''.$row['alt'].'\' border=\'0\''.$status.'>';
					else
						$outputbuffer .= '<a href=\''.$phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].'\''.$targettag.$status.'><img src=\''.$row['banner'].'\' width=\''.$row['width'].'\' height=\''.$row['height'].'\' alt=\''.$row['alt'].'\' title=\''.$row['alt'].'\' border=\'0\'></a>';
				}
				
				if ($withtext && !empty($row['bannertext']))
					$outputbuffer .= '<br><a href=\''.$phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].'\''.$targettag.$status.'>'.$row['bannertext'].'</a>';
			}
			else
			{
				// Banner stored in MySQL
				
				if ($row['format'] == 'swf')
				{
					$outputbuffer  = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' ";
					$outputbuffer .= "codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/";
					$outputbuffer .= "swflash.cab#version=5,0,0,0' width='".$row['width']."' height='".$row['height']."'>";
					$outputbuffer .= "<param name='movie' value='".$phpAds_url_prefix."/adview.php?bannerID=".$row['bannerID'].(empty($row['url']) ? '' : '&targeturl='.urlencode($phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID']))."'>";
					$outputbuffer .= "<param name='quality' value='high'>";
					$outputbuffer .= "<param name='bgcolor' value='#FFFFFF'>";
					$outputbuffer .= "<embed src='".$phpAds_url_prefix."/adview.php?bannerID=".$row['bannerID'].(empty($row['url']) ? '' : '&targeturl='.urlencode($phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID']))."' quality=high ";
					$outputbuffer .= "bgcolor='#FFFFFF' width='".$row['width']."' height='".$row['height']."' type='application/x-shockwave-flash' ";
					$outputbuffer .= "pluginspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>";
					$outputbuffer .= "</object>";
				}
				else
				{
					if (empty($row['url']))
						$outputbuffer .= '<img src=\''.$phpAds_url_prefix.'/adview.php?bannerID='.$row['bannerID'].'\' width=\''.$row['width'].'\' height=\''.$row['height'].'\' alt=\''.$row['alt'].'\' title=\''.$row['alt'].'\' border=\'0\''.$status.'>';
					else
						$outputbuffer .= '<a href=\''.$phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].'\''.$targettag.$status.'><img src=\''.$phpAds_url_prefix.'/adview.php?bannerID='.$row['bannerID'].'\' width=\''.$row['width'].'\' height=\''.$row['height'].'\' alt=\''.$row['alt'].'\' title=\''.$row['alt'].'\' border=\'0\'></a>';
				}
				
				if ($withtext && !empty($row['bannertext']))
					$outputbuffer .= '<br><a href=\''.$phpAds_url_prefix.'/adclick.php?bannerID='.$row['bannerID'].'\''.$targettag.$status.'>'.$row['bannertext'].'</a>';
			}
			
			// Log this AdView
			if (!empty($row['bannerID']))
				log_adview($row['bannerID'], $row['clientID']);
		}
	}
	else
	{
		// An error occured, or there are no banners to display at all
		// Use the default banner if defined
		
		if ($phpAds_default_banner_target != '' && $phpAds_default_banner_url != '')
		{
			if (!empty($target))
			{
				if (strstr($target,'+'))
				{
					if ($row['target'] != '')
						$target = $row['target'];
					else
						$target = substr($target, 1);
				}
				$target = ' target="'.$target.'"';
			}
			
			$outputbuffer .= '<a href=\''.$phpAds_default_banner_target.'\'$target><img src=\''.$phpAds_default_banner_url.'\' border=\'0\'></a>';
			
			return( array('html' => $outputbuffer, 
						  'bannerID' => '')
				  );
		}
	}
	
	db_close();
	
	return( array('html' => $outputbuffer, 
				  'bannerID' => $row['bannerID'])
		  );
}



/*********************************************************/
/* Display a banner                                      */
/*********************************************************/

function view($what, $clientID=0, $target='', $source='', $withtext=0, $context=0)
{
	$output = view_raw($what, $clientID, "$target", "$source", $withtext, $context);
	print($output['html']);
	return($output['bannerID']);
}



?>
