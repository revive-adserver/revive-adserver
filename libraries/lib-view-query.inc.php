<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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
				".$phpAds_config['tbl_banners'].".contenttype as contenttype,
				".$phpAds_config['tbl_banners'].".width as width,
				".$phpAds_config['tbl_banners'].".height as height,
				".$phpAds_config['tbl_banners'].".block as block,
				".$phpAds_config['tbl_banners'].".capping as capping,
				".$phpAds_config['tbl_banners'].".compiledlimitation as compiledlimitation
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				".$phpAds_config['tbl_banners'].".priority > 0";

	
	
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
				if(preg_match('#^[0-9]+x[0-9]+$#', $part_array[$k]))
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

					if ($part_array[$k] != '' && $part_array[$k] != ' ')
					{
						if (is_int(strpos($part_array[$k], '-')))
						{
							// Width range
							list($min, $max) = explode('-', $part_array[$k]);
							
							// Only upper limit, set lower limit to make sure not text ads are delivered
							if ($min == '')
								$min = 1;
							
							// Only lower limit
							if ($max == '')
							{
								if ($operator == 'OR')
									$conditions .= "OR ".$phpAds_config['tbl_banners'].".width >= '".trim($min)."' ";
								elseif ($operator == 'AND')
									$conditions .= "AND ".$phpAds_config['tbl_banners'].".width >= '".trim($min)."' ";
								else
									$conditions .= "AND ".$phpAds_config['tbl_banners'].".width < '".trim($min)."' ";
							}
	
							// Both lower and upper limit
							if ($max != '')
							{
								if ($operator == 'OR')
									$conditions .= "OR (".$phpAds_config['tbl_banners'].".width >= '".trim($min)."' AND ".$phpAds_config['tbl_banners'].".width <= '".trim($max)."') ";
								elseif ($operator == 'AND')
									$conditions .= "AND (".$phpAds_config['tbl_banners'].".width >= '".trim($min)."' AND ".$phpAds_config['tbl_banners'].".width <= '".trim($max)."') ";
								else
									$conditions .= "AND (".$phpAds_config['tbl_banners'].".width < '".trim($min)."' OR ".$phpAds_config['tbl_banners'].".width > '".trim($max)."') ";
							}
						}
						else
						{
							// Single value
							
							if ($operator == 'OR')
								$conditions .= "OR ".$phpAds_config['tbl_banners'].".width = '".trim($part_array[$k])."' ";
							elseif ($operator == 'AND')
								$conditions .= "AND ".$phpAds_config['tbl_banners'].".width = '".trim($part_array[$k])."' ";
							else
								$conditions .= "AND ".$phpAds_config['tbl_banners'].".width != '".trim($part_array[$k])."' ";
						}
					}
															
					$onlykeywords = false;
				}
				
				// Banner Height
				elseif (substr($part_array[$k],0,7) == 'height:')
				{
					$part_array[$k] = substr($part_array[$k], 7);
					if ($part_array[$k] != '' && $part_array[$k] != ' ')
					{
						if (is_int(strpos($part_array[$k], '-')))
						{
							// Height range
							list($min, $max) = explode('-', $part_array[$k]);
							
							// Only upper limit, set lower limit to make sure not text ads are delivered
							if ($min == '')
								$min = 1;
							
							// Only lower limit
							if ($max == '')
							{
								if ($operator == 'OR')
									$conditions .= "OR ".$phpAds_config['tbl_banners'].".height >= '".trim($min)."' ";
								elseif ($operator == 'AND')
									$conditions .= "AND ".$phpAds_config['tbl_banners'].".height >= '".trim($min)."' ";
								else
									$conditions .= "AND ".$phpAds_config['tbl_banners'].".height < '".trim($min)."' ";
							}
	
							// Both lower and upper limit
							if ($max != '')
							{
								if ($operator == 'OR')
									$conditions .= "OR (".$phpAds_config['tbl_banners'].".height >= '".trim($min)."' AND ".$phpAds_config['tbl_banners'].".height <= '".trim($max)."') ";
								elseif ($operator == 'AND')
									$conditions .= "AND (".$phpAds_config['tbl_banners'].".height >= '".trim($min)."' AND ".$phpAds_config['tbl_banners'].".height <= '".trim($max)."') ";
								else
									$conditions .= "AND (".$phpAds_config['tbl_banners'].".height < '".trim($min)."' OR ".$phpAds_config['tbl_banners'].".height > '".trim($max)."') ";
							}
						}
						else
						{
							// Single value
							
							if ($operator == 'OR')
								$conditions .= "OR ".$phpAds_config['tbl_banners'].".height = '".trim($part_array[$k])."' ";
							elseif ($operator == 'AND')
								$conditions .= "AND ".$phpAds_config['tbl_banners'].".height = '".trim($part_array[$k])."' ";
							else
								$conditions .= "AND ".$phpAds_config['tbl_banners'].".height != '".trim($part_array[$k])."' ";
						}
					}
										
					$onlykeywords = false;
				}

				// Banner ID
				elseif ((substr($part_array[$k], 0, 9) == 'bannerid:') || (preg_match('#^[0-9]+$#', $part_array[$k])))
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
							$conditions .= "OR ".$phpAds_config['tbl_banners'].".clientid='".trim($part_array[$k])."' ";
						elseif ($operator == 'AND')
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".clientid='".trim($part_array[$k])."' ";
						else
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".clientid!='".trim($part_array[$k])."' ";
					}
					
					$onlykeywords = false;
				}
				
				// Client ID
				elseif (substr($part_array[$k], 0, 11) == 'campaignid:')
				{
					$part_array[$k] = substr($part_array[$k], 11);
					if ($part_array[$k] != '' && $part_array[$k] != ' ')
					{
						if ($operator == 'OR')
							$conditions .= "OR ".$phpAds_config['tbl_banners'].".clientid='".trim($part_array[$k])."' ";
						elseif ($operator == 'AND')
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".clientid='".trim($part_array[$k])."' ";
						else
							$conditions .= "AND ".$phpAds_config['tbl_banners'].".clientid!='".trim($part_array[$k])."' ";
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
				
				// TextAd
				elseif($part_array[$k] == 'textad')
				{
					if ($operator == 'OR')
						$conditions .= "OR ".$phpAds_config['tbl_banners'].".contenttype='txt' ";
					elseif ($operator == 'AND')
						$conditions .= "AND ".$phpAds_config['tbl_banners'].".contenttype='txt' ";
					else
						$conditions .= "AND ".$phpAds_config['tbl_banners'].".contenttype!='txt' ";
					
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
							$conditions .= "OR CONCAT(' ',".$phpAds_config['tbl_banners'].".keyword,' ') LIKE '% $part_array[$k] %' ";
						elseif ($operator == 'AND')
							$conditions .= "AND CONCAT(' ',".$phpAds_config['tbl_banners'].".keyword,' ') LIKE '% $part_array[$k] %' ";
						else
							$conditions .= "AND CONCAT(' ',".$phpAds_config['tbl_banners'].".keyword,' ') NOT LIKE '% $part_array[$k] %' ";
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