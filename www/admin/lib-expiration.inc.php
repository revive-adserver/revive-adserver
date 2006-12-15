<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/*-------------------------------------------------------*/
/* Determine the AdViews left before expiration          */
/*-------------------------------------------------------*/

function phpAds_getAdViewsLeft($campaignid)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	global $strUnlimited;
	
	$campaign_query =
		"SELECT views".
		" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
		" WHERE campaignid='".$campaignid."'"
	;
	
	$res_campaign = phpAds_dbQuery($campaign_query)
		or phpAds_sqlDie();
	
	if (phpAds_dbNumRows($res_campaign) == 1)
	{
		$row = phpAds_dbFetchArray($res_campaign);
		$views = $row['views'];
		
		if ($views == -1)
			$views = $strUnlimited;
			
		return ($views);
	}
}



/*-------------------------------------------------------*/
/* Determine the AdClicks left before expiration         */
/*-------------------------------------------------------*/

function phpAds_getAdClicksLeft($campaignid)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	global $strUnlimited;
	
	$campaign_query = 
		"SELECT clicks".
		" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
		" WHERE campaignid='".$campaignid."'";
	
	$res_campaign = phpAds_dbQuery($campaign_query);
	
	if (phpAds_dbNumRows($res_campaign) == 1)
	{
		$row = phpAds_dbFetchArray($res_campaign);
		$clicks = $row['clicks'];
		
		if ($clicks == -1)
			$clicks = $strUnlimited;
			
		return ($clicks);
	}
}

/*-------------------------------------------------------*/
/* Determine the AdClicks left before expiration         */
/*-------------------------------------------------------*/

function phpAds_getAdConversionsLeft($campaignid)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	global $strUnlimited;
	
	$campaign_query = 
		"SELECT conversions".
		" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
		" WHERE campaignid='".$campaignid."'";
	
	$res_campaign = phpAds_dbQuery($campaign_query);
	
	if (phpAds_dbNumRows($res_campaign) == 1)
	{
		$row = phpAds_dbFetchArray($res_campaign);
		$conversions = $row['conversions'];
		
		if ($conversions == -1)
			$conversions = $strUnlimited;
			
		return ($conversions);
	}
}


/*-------------------------------------------------------*/
/* Estimate time before expiration                       */
/*-------------------------------------------------------*/
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
/* list($desc,$enddate,$daysleft)=phpAds_getDaysLeft($clientid)   */
/*                                                       */
/* This function will temporarily not work properly, if  */
/* statistics are reset or the amount of the credit in   */
/* views or clicks or left days is modified              */
/*-------------------------------------------------------*/

function phpAds_getDaysLeft($campaignid)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	global $date_format;
	
	// uses the following language settings:
	global $strExpiration, $strNoExpiration, $strDaysLeft, $strEstimated;
	
	// preset return values
	$estimated_end = "-";
	$days_left="-";
	$description="";
	$absolute=0;

	// Get client record
	$campaign_query=
		"SELECT".
		" views".
		",clicks".
		",expire".
		",DATE_FORMAT(expire, '".$date_format."') as expire_f".
		",TO_DAYS(expire)-TO_DAYS(NOW()) as days_left".
		" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
		" WHERE campaignid='".$campaignid."'"
	;
	
	$res_campaign = phpAds_dbQuery($campaign_query) or phpAds_sqlDie() ;
	
	if (phpAds_dbNumRows ($res_campaign) == 1) {
		$row_campaign = phpAds_dbFetchArray($res_campaign);
		
		// Check if the expiration date is set
		if ($row_campaign['expire'] != '0000-00-00' && $row_campaign['expire'] != '') {
			$expiration[] = array (
				"days_left" => round($row_campaign["days_left"]),
				"date"	  	=> $row_campaign["expire_f"],
				"absolute"  => true
			);
		}
		
		if ($row_campaign["views"] != -1) {
           	$view_query =
           		"SELECT".
           		" SUM(impressions) as total_views".
           		",MAX(TO_DAYS(day))-TO_DAYS(NOW()) as days_since_last_view".
           		",TO_DAYS(NOW())-MIN(TO_DAYS(day)) as days_since_start".
           		" FROM ".$conf['table']['prefix'].$conf['table']['banners']." AS b".
           		" LEFT JOIN ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." AS v".
           		" ON b.bannerid=v.ad_id".
           		" WHERE b.campaignid='".$campaignid."'"
           	;
			
			$res_views = phpAds_dbQuery($view_query) or phpAds_sqlDie();
			if (phpAds_dbNumRows ($res_views) == 1) {
				$row_views = phpAds_dbFetchArray($res_views);
				
				if (!isset($row_views["days_since_start"]) ||
				    $row_views["days_since_start"] == '' ||
				    $row_views["days_since_start"] == 0  ||
					$row_views["days_since_start"] == null)
				{
					$row_views["days_since_start"] = 1;
				}
				
				if (!empty ($row_views["total_views"]) && $row_views["total_views"] > 0) {
					$days_left = round ($row_campaign["views"] / ($row_views["total_views"] / $row_views["days_since_start"]));
					
					if ($row_campaign["views"] > 0) {
						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") + $days_left, date("Y")));
						$expiration[] = array (
							"days_left" => $days_left,
							"date"	  	=> $estimated_end,
							"absolute"  => false
						);
					} else {
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
		
		if ($row_campaign["clicks"] != -1) {
        	$click_query=
        		"SELECT".
        		" SUM(clicks) as total_clicks".
        		",MAX(TO_DAYS(day))-TO_DAYS(NOW()) as days_since_last_click".
        		",TO_DAYS(NOW())-MIN(TO_DAYS(day)) as days_since_start".
        		" FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." AS a
        		  LEFT JOIN ".$conf['table']['prefix'].$conf['table']['banners']." AS b
        		  ON a.ad_id=b.bannerid".
        		" WHERE campaignid='".$campaignid."'".
        		" AND clicks > 0"
        	;

        	$res_clicks = phpAds_dbQuery($click_query) or phpAds_sqlDie();

        	if (phpAds_dbNumRows($res_clicks) == 1) {
				$row_clicks = phpAds_dbFetchArray($res_clicks);
				
				if (!isset($row_clicks["days_since_start"]) ||
				    $row_clicks["days_since_start"] == '' ||
				    $row_clicks["days_since_start"] == 0  ||
					$row_clicks["days_since_start"] == null)
				{
					$row_clicks["days_since_start"] = 1;
				}
				
				if (!empty ($row_clicks["total_clicks"]) && $row_clicks["total_clicks"] > 0) {
					$days_left = round($row_campaign["clicks"] / ($row_clicks["total_clicks"] / $row_clicks["days_since_start"]));
					
					if ($row_campaign["clicks"] > 0) {
						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") + $days_left, date("Y")));
						$expiration[] = array (
							"days_left" => $days_left,
							"date"	  	=> $estimated_end,
							"absolute"  => false
						);
					} else {
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
	
	if (isset($expiration) && sizeof($expiration) > 0) {
		$sooner = $expiration[0];
		
		for ($i = 0; $i < sizeof($expiration); $i++) {
			if ($expiration[$i]['days_left'] < $sooner['days_left']) {
				$sooner = $expiration[$i];
			}
		}
		
		if ($sooner['days_left'] < 0) {
		    $sooner['days_left'] = 0;
		}
		
		if ($sooner['absolute']) {
			$ret_val[] = $strExpiration.": ".$sooner['date']." (".$strDaysLeft.": ".$sooner['days_left'].")";
		} else {
			$ret_val[] = $strEstimated.": ".$sooner['date']." (".$strDaysLeft.": ".$sooner['days_left'].")";
		}
		
		$ret_val[]=$sooner['date'];
		$ret_val[]=$sooner['days_left'];
	} else {
		// Unknown
		$ret_val[] = $strExpiration.": ".$strNoExpiration;
		$ret_val[] = '';
		$ret_val[] = '';
	}
	
	return isset($ret_val) ? $ret_val : false;
}

?>
