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



/*********************************************************/
/* Determine the AdViews left before expiration          */
/*********************************************************/

function adviews_left ($clientid)
{
	global $phpAds_config;
	global $strUnlimited;
	
	$client_query="
		SELECT
			views
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE 
			clientid = ".$clientid;
	
	$res_client = phpAds_dbQuery($client_query);
	
	if (phpAds_dbNumRows($res_client) == 1)
	{
		$row = phpAds_dbFetchArray($res_client);
		$views = $row['views'];
		
		if ($views == -1)
			$views = $strUnlimited;
			
		return ($views);
	}
}



/*********************************************************/
/* Determine the AdClicks left before expiration         */
/*********************************************************/

function adclicks_left ($clientid)
{
	global $phpAds_config;
	global $strUnlimited;
	
	$client_query="
		SELECT
			clicks
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE 
			clientid = ".$clientid;
	
	$res_client = phpAds_dbQuery($client_query);
	
	if (phpAds_dbNumRows($res_client) == 1)
	{
		$row = phpAds_dbFetchArray($res_client);
		$clicks = $row['clicks'];
		
		if ($clicks == -1)
			$clicks = $strUnlimited;
			
		return ($clicks);
	}
}



/*********************************************************/
/* Estimate time before expiration                       */
/*********************************************************/
/*                                                       */
/* this function calculates the estimated end of a       */
/* clients credits in clicks or views based on used      */
/* views and clicks, the time from the first to the last */
/* view and click and the current date. If the client    */
/* has an expiration date this one will have priority.   */
/*                                                       */
/* The return value is an array which returns a ready to */
/* use string with expiration and left days contents     */
/* based on language string settings, a string with the  */
/* date und an integer value with the amount of days     */
/* left for alternate usage                              */
/*                                                       */
/* Usage:                                                */
/* list($desc,$enddate,$daysleft)=days_left($clientid)   */
/*                                                       */
/* This function will temporarily not work properly, if  */
/* statistics are reset or the amount of the credit in   */
/* views or clicks or left days is modified              */
/*********************************************************/

function days_left($clientid)
{
	global $phpAds_config;
	global $date_format;
	
	// uses the following language settings:
	global $strExpiration, $strNoExpiration, $strDaysLeft, $strEstimated;
	
	// preset return values
	$estimated_end = "-";
	$days_left="-";
	$description="";
	$absolute=0;
	
	
	
	// Get client record
	$client_query="
		SELECT
			views,
			clicks,
			expire,
			DATE_FORMAT(expire, '".$date_format."') as expire_f,
			TO_DAYS(expire)-TO_DAYS(NOW()) as days_left
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE 
			clientid = ".$clientid;
	$res_client = phpAds_dbQuery($client_query) or phpAds_sqlDie() ;
	
	
	if (phpAds_dbNumRows ($res_client) == 1)
	{
		$row_client = phpAds_dbFetchArray($res_client);
		
		// Check if the expiration date is set
		if ($row_client['expire'] != '0000-00-00' && $row_client['expire'] != '')
		{
			$expiration[] = array (
				"days_left" => round($row_client["days_left"]),
				"date"	  	=> $row_client["expire_f"],
				"absolute"  => true
			);
		}
		
		if ($row_client["views"] != -1)
		{
			if ($phpAds_config['compact_stats']) 
			{
	           	$view_query="
	               	SELECT
	                   	SUM(views) as total_views,
	                    MAX(TO_DAYS(day))-TO_DAYS(NOW()) as days_since_last_view,
	                    TO_DAYS(NOW())-MIN(TO_DAYS(day)) as days_since_start
	                FROM
	                   	".$phpAds_config['tbl_banners']." AS b
	                    LEFT JOIN ".$phpAds_config['tbl_adstats']." AS v USING (bannerid)
	                WHERE
	                  	b.clientid = $clientid";
            }
			else
			{
	            $view_query="
					SELECT
						count(*) as total_views,
						MAX(TO_DAYS(v.t_stamp))-TO_DAYS(NOW()) as days_since_last_view,
						TO_DAYS(NOW())-MIN(TO_DAYS(v.t_stamp)) as days_since_start
					FROM
						".$phpAds_config['tbl_adviews']." AS v, 
						".$phpAds_config['tbl_banners']." AS b 
					WHERE
						b.clientid = $clientid 
						AND
						b.bannerid = v.bannerid";
			}
			
			$res_views = phpAds_dbQuery($view_query) or phpAds_sqlDie();
			if (phpAds_dbNumRows ($res_views) == 1)
			{
				$row_views = phpAds_dbFetchArray($res_views);
				
				if (!isset($row_views["days_since_start"]) ||
				    $row_views["days_since_start"] == '' ||
				    $row_views["days_since_start"] == 0  ||
					$row_views["days_since_start"] == null)
				{
					$row_views["days_since_start"] = 1;
				}
				
				if (!empty ($row_views["total_views"]) && $row_views["total_views"] > 0)
				{
					$days_left = round ($row_client["views"] / ($row_views["total_views"] / $row_views["days_since_start"]));
					
					if ($row_client["views"] > 0)
					{
						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") + $days_left, date("Y")));
						$expiration[] = array (
							"days_left" => $days_left,
							"date"	  	=> $estimated_end,
							"absolute"  => false
						);
					}
					else
					{
						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") - $row_views["days_since_last_view"], date("Y")));
						$expiration[] = array (
							"days_left" => 0 - $row_views["days_since_last_view"],
							"date"	  	=> $estimated_end,
							"absolute"  => true
						);
					}
				}
			}
		}
		
		if ($row_client["clicks"] != -1)
		{
			if ($phpAds_config['compact_stats']) 
            {
            	$click_query="
                	SELECT
                    	SUM(clicks) as total_clicks,
                        MAX(TO_DAYS(day))-TO_DAYS(NOW()) as days_since_last_click,
                        TO_DAYS(NOW())-MIN(TO_DAYS(day)) as days_since_start
					FROM
						".$phpAds_config['tbl_adstats']."
						LEFT JOIN ".$phpAds_config['tbl_banners']." USING (bannerid)
					WHERE
						clientid = '$clientid' AND
						clicks > 0";
			}
			else
			{
				$click_query="
					SELECT
						count(*) as total_clicks,
						MAX(TO_DAYS(c.t_stamp))- TO_DAYS(NOW()) as days_since_last_click,
						TO_DAYS(NOW())-MIN(TO_DAYS(c.t_stamp)) as days_since_start
					FROM
						".$phpAds_config['tbl_adclicks']." AS c, 
						".$phpAds_config['tbl_banners']." AS b 
					WHERE 
						b.clientid = $clientid AND
						b.bannerid = c.bannerid";
			}
			
			$res_clicks = phpAds_dbQuery($click_query) or phpAds_sqlDie();
			if (phpAds_dbNumRows($res_clicks) == 1)
			{
				$row_clicks = phpAds_dbFetchArray($res_clicks);
				
				if (!isset($row_clicks["days_since_start"]) ||
				    $row_clicks["days_since_start"] == '' ||
				    $row_clicks["days_since_start"] == 0  ||
					$row_clicks["days_since_start"] == null)
				{
					$row_clicks["days_since_start"] = 1;
				}
				
				if (!empty ($row_clicks["total_clicks"]) && $row_clicks["total_clicks"] > 0)
				{
					$days_left = round($row_client["clicks"] / ($row_clicks["total_clicks"] / $row_clicks["days_since_start"]));
					
					if ($row_client["clicks"] > 0)
					{
						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") + $days_left, date("Y")));
						$expiration[] = array (
							"days_left" => $days_left,
							"date"	  	=> $estimated_end,
							"absolute"  => false
						);
					}
					else
					{
						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") - $row_clicks["days_since_last_view"], date("Y")));
						$expiration[] = array (
							"days_left" => 0 - $row_clicks["days_since_last_view"],
							"date"	  	=> $estimated_end,
							"absolute"  => true
						);
					}
				}
			}
		}
	}
	
	
	
	
	// Build Return value
	
	if (isset($expiration) && sizeof($expiration) > 0)
	{
		$sooner = $expiration[0];
		
		for ($i=0;$i<sizeof($expiration);$i++)
		{
			if ($expiration[$i]['days_left'] < $sooner['days_left'])
				$sooner = $expiration[$i];
		}
		
		if ($sooner['days_left'] < 0) $sooner['days_left'] = 0;
		
		if ($sooner['absolute'])
		{
			$ret_val[] = $strExpiration.": ".$sooner['date']." (".$strDaysLeft.": ".$sooner['days_left'].")";
		}
		else
		{
			$ret_val[] = $strEstimated.": ".$sooner['date']." (".$strDaysLeft.": ".$sooner['days_left'].")";
		}
		
		$ret_val[]=$sooner['date'];
		$ret_val[]=$sooner['days_left'];
	}
	else
	{
		// Unknown
		$ret_val[] = $strExpiration.": ".$strNoExpiration;
		$ret_val[] = '';
		$ret_val[] = '';
	}
	
	return isset($ret_val) ? $ret_val : false;
}


?>