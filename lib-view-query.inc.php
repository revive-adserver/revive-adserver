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
define ('LIBVIEWQUERY_INCLUDED', true);


/*********************************************************/
/* Build the query needed to fetch banners               */
/*********************************************************/

function phpAds_buildQuery ($part, $lastpart, $precondition)
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
				".$phpAds_config['tbl_banners'].".filename as filename,
				".$phpAds_config['tbl_banners'].".imageurl as imageurl,
				".$phpAds_config['tbl_banners'].".url as url,
				".$phpAds_config['tbl_banners'].".htmlcache as htmlcache,
				".$phpAds_config['tbl_banners'].".width as width,
				".$phpAds_config['tbl_banners'].".height as height,
				".$phpAds_config['tbl_banners'].".weight as weight,
				".$phpAds_config['tbl_banners'].".seq as seq,
				".$phpAds_config['tbl_banners'].".target as target,
				".$phpAds_config['tbl_banners'].".alt as alt,
				".$phpAds_config['tbl_banners'].".block as block,
				".$phpAds_config['tbl_banners'].".capping as capping,
				".$phpAds_config['tbl_banners'].".compiledlimitation as compiledlimitation
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
						if ($operator == 'OR')
							$conditions .= "OR ";
						elseif ($operator == 'AND')
							$conditions .= "AND ";
						else
							$conditions .= "AND NOT ";
						
						$conditions .= "CONCAT(' ',".$phpAds_config['tbl_banners'].".keyword,' ') LIKE '% $part_array[$k] %' ";
					}
				}
			}
		}
		
		// Strip first AND or OR from $conditions
		$conditions = strstr($conditions, ' ');
		
		// Add global keyword
		if ($lastpart == true && $onlykeywords == true)
			$conditions .= "OR CONCAT(' ',".$phpAds_config['tbl_banners'].".keyword,' ') LIKE '% global %' ";
		
		// Add conditions to select
		if ($conditions != '') $select .= ' AND ('.$conditions.') ';
	}
	
	return ($select);
}


?>