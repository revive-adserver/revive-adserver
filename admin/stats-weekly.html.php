<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the Martin Braun <martin@braun.cc>             */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/*********************************************************/
/* Adjust day index to specific installation             */
/*********************************************************/

function DayInd($ind)
{
	global $phpAds_config;
	
	$ind += $phpAds_config['begin_of_week'];
	return $ind > 6 ? 0 : $ind;
}



/*********************************************************/
/* Replace zero's with -'s                               */
/*********************************************************/

function tabecho($value)
{
	echo (double)$value>0?$value:'-';
}



/*********************************************************/
/* Reset week data                                       */
/*********************************************************/

function WeekInit()
{
	global $week;
	$week['num']='';
	for ($i=0; $i<7; $i++)
	{
		$week['date'][$i]='';
		$week['views'][$i]=0;
		$week['clicks'][$i]=0;
		$week["ctr"][$i]=0;
		$week['unix_time'][$i]=0;
	}
}



/*********************************************************/
/* Set all missing dates in week                         */
/*********************************************************/

function WeekSetDates()
{
	global $phpAds_config;
	global $php_week_sign, $week;
	
	// find first col with valid date
	$i=0;
	while(empty($week['date'][$i])){$i++;}
	
	// calc timestamp for first row
	$stamp = $week['unix_time'][$i]-$i*24*60*60;
	
	// adjust timestamp to country settings if needed
	if ($i==0 && $phpAds_config['begin_of_week']==1) 
		$stamp -= 7*24*60*60;
	
	// check all day rows
	for ($i=0;$i<7;$i++)
	{
		// fill date in row if empty
		if (empty($week['date'][$i]))
		{
			$mult = $i;
			// adjust multiplier to country settings if needed
			if ($mult==0 && $phpAds_config['begin_of_week']==1) 
				$mult=7; // sunday (col=0) is last day of the week
			$week['date'][$i] = strftime($GLOBALS['date_format'],$stamp+$mult*24*60*60); 
		}
	}
	
	/*
	// check calendar week for zero value
	if (strftime($php_week_sign,$stamp) == 0)
		// replace by last calendar week of elapsed year
		$week['num']=strftime($php_week_sign."/%Y",mktime(0,0,0,12,31,strftime('%Y',$stamp)-1));
	*/
}



/*********************************************************/
/* Calculate daily CTR and summary                       */
/*********************************************************/

function WeekStat()
{
	global $week;
	$weekdays_complete = 0;
	$week['clicksum']=0;
	$week['viewsum']=0;
	$week['days_set']=0;
	for ($i=0; $i<7; $i++)
	{
		$week["ctr"][$i] = $week['views'][$i] > 0 ? $week['clicks'][$i]/$week['views'][$i]*100 : 0;
		if ($week['views'][$i])
		{
			$week['viewsum']+=$week['views'][$i];
			$week['days_set']++;
		}
		if ($week['clicks'][$i])
		{
			$week['clicksum']+=$week['clicks'][$i];
		}
		if (empty($week['date'][$i]) && !$weekdays_complete)
		{
			WeekSetDates(); // set all missing dates
			$weekdays_complete=1;
		}
	}
	
	$week['ctrsum'] = $week['viewsum'] > 0 ? $week['clicksum']/$week['viewsum']*100 : 0;
}



/*********************************************************/
/* Insert actual day in weekly data                      */
/*********************************************************/

function WeekFill($day_array, $actweek)
{
	global $week, $php_week_sign;
	
	$week['num'] = $day_array['week_num'];
	// internally work with sunday = 0
	$day_of_week = $day_array['day_num'];
	$week['views'][$day_of_week]=$day_array['views'];
	$week['clicks'][$day_of_week]=$day_array['clicks'];
	$week['date'][$day_of_week]=$day_array['date'];
	$week['unix_time'][$day_of_week]=$day_array['unix_time'];
}



/*********************************************************/
/* HTML generator for one week                           */
/*********************************************************/

function WeekPrint()
{
	global $phpAds_config;
	global $total_views, $total_clicks;
	global $week;
	static $j=1;
	
	if (isset($week['num']) && $week['num']) // only if already filled (not at first call)
	{
		// set background color
		$bgcolor="#FFFFFF";
		$j % 2 ? 0: $bgcolor = "#F6F6F6";
		$j++;       
		
		WeekStat(); // calculate daily ctr and summary  
		
		$total_views += $week['viewsum'];
		$total_clicks += $week['clicksum'];

		//echo sprintf("      <!-- %s: %s -->\n", $GLOBALS['strWeek'], $week['num'] );
		?>
		<tr>
			<td height='80' valign="middle" align="left" rowspan="4" bgcolor="<?php echo $bgcolor; ?>">&nbsp;<?php echo $week['num']; ?></td>
			<td height='20' align="left" bgcolor="<?php echo $bgcolor; ?>"><?php echo $GLOBALS["strDate"]; ?></td>
		<?php 
		for ( $i=0; $i<7; $i++ ) 
		{
			?>
        	<td height='20' align="right" bgcolor="<?php echo $bgcolor; ?>"><?php echo substr ($week['date'][DayInd($i)], 0, -5); ?></td>
			<?php
		}
		?>
			<td height='20' bgcolor="<?php echo $bgcolor; ?>">&nbsp;</td>
			<td height='20' bgcolor="<?php echo $bgcolor; ?>">&nbsp;</td>
		</tr>
		<tr height='20'>
			<td height='20' align="left" bgcolor="<?php echo $bgcolor; ?>"><?php echo $GLOBALS["strViews"]; ?></td>
		<?php
		for ( $i=0; $i<7; $i++ ) 
		{ 
			?>
			<td height='20' align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho($week['views'][DayInd($i)]); ?></td>
			<?php
		}
		$week_avg = $week['days_set']>0?$week['viewsum']/7:0; //$week['days_set']
		?>
			<td height='20' align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho(sprintf(' %.'.$phpAds_config['percentage_decimals'].'f',$week_avg)); ?></td>
			<td height='20' align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho($week['viewsum']); ?>&nbsp;</td>
		</tr>        
		<tr>
			<td height='20' class="normal" align="left" bgcolor="<?php echo $bgcolor; ?>"><?php echo $GLOBALS['strClicks']; ?></td>
		<?php
		for ( $i=0; $i<7; $i++ ) 
		{ 
			?>
			<td height='20' class="small" align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho($week['clicks'][DayInd($i)]); ?></td>
			<?php
		}
		$week_avg = $week['days_set']>0?$week['clicksum']/7:0; //$week['days_set']
		?>
			<td height='20' class="normal" align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho(sprintf(" %.".$phpAds_config['percentage_decimals']."f",$week_avg)); ?></td>
			<td height='20' class="normal" align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho($week['clicksum']); ?>&nbsp;</td>
		</tr>        
		<tr>
			<td height='20' class="normal" align="left" bgcolor="<?php echo $bgcolor; ?>"><?php echo $GLOBALS["strCTRShort"]; ?></td>
		<?php
		for ( $i=0; $i<7; $i++ )
		{
			?>
			<td height='20' class="small" align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho(sprintf(" %.".$phpAds_config['percentage_decimals']."f%%",$week["ctr"][DayInd($i)])); ?></td>
			<?php
		}
		$week_avg = $week['days_set']>0?$week['ctrsum']/7:0; //$week['days_set']
		?>
			<td height='20' class="normal" align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho(sprintf(" %.".$phpAds_config['percentage_decimals']."f%%",$week['ctrsum'])); ?></td>
			<td height='20' class="normal" align="right" bgcolor="<?php echo $bgcolor; ?>"><?php tabecho(sprintf(" %.".$phpAds_config['percentage_decimals']."f%%",$week['ctrsum'])); ?>&nbsp;</td>
		</tr>
		<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>        
		<?php
	}
}



/*********************************************************/
/* Generate weekly statistics                            */
/*********************************************************/

function stats()
{
	global $phpAds_config;
	global $phpAds_tbl_color;
	global $campaignid, $which;
	global $max_weeks, $php_week_sign, $mysql_week_sign;
	global $strDayShortCuts;
	global $strClientName, $strOverall;
	global $total_views, $total_clicks;
	global $phpAds_TextDirection;
	
	// get all significant banner-ids to build where-clause
	$banner_query = "
		SELECT
			bannerid, bannertext, alt, description
		FROM
			".$phpAds_config['tbl_banners']."
		";
	
	if ($campaignid > 0)
	$banner_query .= "
		WHERE 
			clientid = $campaignid
		";
	
	$res = phpAds_dbQuery($banner_query) or phpAds_sqlDie();
	
	// Get the number of banners
	$countbanners = phpAds_dbNumRows($res);
	
	if ($countbanners == 1)
	{
		// single banner client
		$where = 'WHERE bannerid='.phpAds_dbResult ($res, 0, 0);
	}
	else
	{
		// multi banner client
		
		if ($campaignid > 0) 
			$where = 'WHERE bannerid IN (';
		else
			$where = '';
		
		$ids = '';
		$banner_select = array();
		$i=0;
		
		while ($banner_row = phpAds_dbFetchArray ($res))
		{
			if ($ids) $ids.= ',';
				$ids .= $banner_row['bannerid'];
				
			// collect banner names for select-box
			$banner_select[$i]			= array();
			$banner_select[$i]['id']	= $banner_row['bannerid'];
			$banner_select[$i]['name'] 	= phpAds_buildBannerName ($banner_row['bannerid'], $banner_row['description'], $banner_row['alt']);
			
			$i++;
		}
		
		if (!$ids)
			$ids = '0';
			
		if ($campaignid > 0) 
			$where .= $ids.')';
		
		if ($which != '0')  // there! forget set theory!
			$where = 'WHERE bannerid='.$which;
	}
	
	
    // I tried to do this with one section of code and a few internal checks
    // for the stats mode, but the queries were just much too inefficient to share.
    if ($phpAds_config['compact_stats']) 
    {
        // get views global data
    	$global_view_query="
    		SELECT
				MAX(TO_DAYS(day)),
    			MIN(TO_DAYS(day))
    		FROM
    			".$phpAds_config['tbl_adstats']."
    		$where
		";
		
    	$views_global = phpAds_dbQuery($global_view_query) or phpAds_sqlDie();
    	list($views_last_day_index, $views_first_day_index) = phpAds_dbFetchRow($views_global);
    	phpAds_dbFreeResult($views_global);
    	
    	$last_day_index = $views_last_day_index;
    	
    	// get views & clicks daily data
    	
		$daily_query="
    		SELECT
    			sum(views) as days_total_views,
    			sum(clicks) as days_total_clicks,
    			DATE_FORMAT(day, '".$GLOBALS['date_format']."') as date,
    			DATE_FORMAT(day, '$mysql_week_sign') as week_num,
    			DATE_FORMAT(day, '%w') as day_num,
    			UNIX_TIMESTAMP(day) as unix_time,
    			$last_day_index-TO_DAYS(day) AS day_index,
    			TO_DAYS(day) AS abs_day
    		FROM
    			".$phpAds_config['tbl_adstats']."
   			$where
			GROUP BY
				day
    		ORDER BY
    			abs_day DESC
    		LIMIT ".$max_weeks*7;
    	$daily = phpAds_dbQuery($daily_query) or phpAds_sqlDie();
    	
    	$days = array();
    	while ($row = phpAds_dbFetchArray($daily))
    	{
    		$i = $row['day_index'];
    		if ( !isset($days[$i]) )
    		{
				$days[$i] = array();
    			$days[$i]['day_index'] = $i + $last_day_index;
    			$days[$i]['week_num']  = $row['week_num'];
    			$days[$i]['day_num']   = $row['day_num'];
    			$days[$i]['unix_time'] = $row['unix_time'];
    			$days[$i]['date']      = $row['date'];
    		}
			
			if (isset($days[$i]['views']))
	    		$days[$i]['views']    += $row['days_total_views'];
			else
	    		$days[$i]['views']     = $row['days_total_views'];
			
			if (isset($days[$i]['clicks']))
				$days[$i]['clicks']   += $row['days_total_clicks'];
			else
				$days[$i]['clicks']    = $row['days_total_clicks'];
    	}
    	
    	phpAds_dbFreeResult($daily);
    }
    else        // ! $phpAds_config['compact_stats']
    {
        // get views global data
    	$global_view_query="
    		SELECT
    			MAX(TO_DAYS(t_stamp)),
    			MIN(TO_DAYS(t_stamp))
    		FROM
    			".$phpAds_config['tbl_adviews']."
    		$where
		";
		
    	$views_global = phpAds_dbQuery($global_view_query) or phpAds_sqlDie();
    	list($views_last_day_index, $views_first_day_index) = phpAds_dbFetchRow($views_global);
    	phpAds_dbFreeResult($views_global);
    	
    	// get clicks global data
    	$global_click_query="
    		SELECT
    			MAX(TO_DAYS(t_stamp)),
    			MIN(TO_DAYS(t_stamp))
    		FROM
    			".$phpAds_config['tbl_adclicks']."
    		$where
			";
    		// echo $global_click_query;			   
    	$clicks_global = phpAds_dbQuery($global_click_query) or phpAds_sqlDie();
    	list($clicks_last_day_index, $clicks_first_day_index) = phpAds_dbFetchRow($clicks_global);
    	phpAds_dbFreeResult($clicks_global);
    	
    	$last_day_index = max($views_last_day_index,$clicks_last_day_index);
    	
    	// get views daily data
    	$view_query="
    		SELECT
    			count(*) as days_total_views,
    			DATE_FORMAT(t_stamp, '".$GLOBALS['date_format']."') as date,
    			DATE_FORMAT(t_stamp, '$mysql_week_sign') as week_num,
    			DATE_FORMAT(t_stamp, '%w') as day_num,
    			UNIX_TIMESTAMP(t_stamp) as unix_time,
    			$last_day_index-TO_DAYS(t_stamp) AS day_index,
    			TO_DAYS(t_stamp) AS abs_day
    		FROM
    			".$phpAds_config['tbl_adviews']."
    		$where
    		GROUP BY 
    			abs_day
    		ORDER BY
    			abs_day DESC
    		LIMIT ".$max_weeks*7;
    	$view_daily = phpAds_dbQuery($view_query) or phpAds_sqlDie();
    	
    	// get clicks daily data
    	$click_query="
    		SELECT
    			count(*) as days_total_clicks,
    			DATE_FORMAT(t_stamp, '".$GLOBALS['date_format']."') as date,
    			DATE_FORMAT(t_stamp, '$mysql_week_sign') as week_num,
    			DATE_FORMAT(t_stamp, '%w') as day_num,
    			UNIX_TIMESTAMP(t_stamp) as unix_time,
    			$last_day_index-TO_DAYS(t_stamp) AS day_index,
    			TO_DAYS(t_stamp) AS abs_day
    		FROM
    			".$phpAds_config['tbl_adclicks']."
    		$where
    		GROUP BY 
    			abs_day
    		ORDER BY
    			abs_day DESC
    		LIMIT ".$max_weeks*7;
    	$click_daily = phpAds_dbQuery($click_query) or phpAds_sqlDie();
    	
    	// now let's join the daily data in a days array
    	$days = array();
    	
    	// insert view data
    	while ($row = phpAds_dbFetchArray($view_daily))
    	{
    		$i = $row['day_index'];
    		
			$days[$i] = array();
    		$days[$i]['day_index'] = $i + $last_day_index;
    		$days[$i]['week_num']  = $row['week_num'];
    		$days[$i]['day_num']   = $row['day_num'];
    		$days[$i]['unix_time'] = $row['unix_time'];
    		$days[$i]['date']      = $row['date'];
    		$days[$i]['views']     = $row['days_total_views'];
			$days[$i]['clicks']	   = 0;
    	}
    	
    	// now insert click data
    	while ($row = phpAds_dbFetchArray($click_daily))
    	{
    		$i = $row['day_index'];
    		if ( !isset($days[$i]) )
    		{
				$days[$i] = array();
    			$days[$i]['day_index'] = $i + $last_day_index;
    			$days[$i]['week_num']  = $row['week_num'];
    			$days[$i]['day_num']   = $row['day_num'];
    			$days[$i]['unix_time'] = $row['unix_time'];
    			$days[$i]['date']      = $row['date'];
				$days[$i]['views']	   = 0;
				$days[$i]['clicks']    = $row['days_total_clicks'];
    		}
    		else
	    		$days[$i]['clicks']    = $row['days_total_clicks'];
    	}
	    
    	phpAds_dbFreeResult($view_daily);
    	phpAds_dbFreeResult($click_daily);
    }
	
    
    // display interval form 
	// (yes poor Opera and NS6 users we know that it is not conforming w3c
	// how the two forms are embedded in the table but believe that it looks pretty
	// nice in older NS6- and actual IE versions)
	
	
	if (sizeof($days) < 1)
		printf("<table border=\"0\"><tr><td>%s</td></tr></table>",$which==0?$GLOBALS["strNoStats"]:$GLOBALS["strBannerNoStats"]);
	else
	{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='40' rowspan="2" bgcolor="#F6F6F6">&nbsp;<?php echo $GLOBALS["strWeek"]; ?></td>
		<td height='40' rowspan="2" bgcolor="#F6F6F6">&nbsp;</td>
		<td height='20' colspan="7" align="center" bgcolor="#F6F6F6"><?php echo $GLOBALS["strWeekDay"]; ?></td>
		<td height='40' rowspan="2" align="right" bgcolor="#F6F6F6"><?php echo $GLOBALS["strAvg"]; ?></td>
		<td height='40' rowspan="2" align="right" bgcolor="#F6F6F6"><?php echo $GLOBALS["strTotal"]; ?>&nbsp;</td>
	</tr>            
	<tr>
	<?php
	// display weekday-names from Sunday/Monday
	for ($i=0;$i<7;$i++)
	{
		echo "<td height='20' align=\"right\" bgcolor=\"#F6F6F6\">".$strDayShortCuts[DayInd($i)]."</td>\n";
	}	
	?>
	</tr>
	<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<?php

	$weeks_done = 0;
	$lastweek='';
	
	// loop over all days in array
	reset($days);
	while (list ($i,) = each ($days))
	{      
		$currentweek = $days[$i]['week_num'];
		
		if ($lastweek != $currentweek)	 
		{
			// change in actual week
			if ($weeks_done >= $max_weeks)
				break;
			
			// print old week
			WeekPrint();
			$lastweek = $currentweek;
			
			// reset old values
			WeekInit();
			$weeks_done++;
		}
		
		// insert daily data into weeks data
		WeekFill( $days[$i], $currentweek );
	}
	
	// print the last week
	WeekPrint();

	?>  
</table>	

<br><br>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<?php if (phpAds_GDImageFormat() != "none") { ?>
	<tr><td colspan="3" align="left" bgcolor="#FFFFFF"><img src="graph-weekly.php?<?php echo "campaignid=$campaignid&max_weeks=$max_weeks&where=".urlencode("$where"); ?>"></td></tr>
	<?php } ?>          
	<tr>
		<td height='25' bgcolor="#FFFFFF"><?php echo $GLOBALS["strTotalViews"]; ?>: <b><?php tabecho($total_views); ?></b></td>
		<td height='25' bgcolor="#FFFFFF"><?php echo $GLOBALS["strTotalClicks"]; ?>: <b><?php tabecho($total_clicks); ?></b></td>
		<td height='25' bgcolor="#FFFFFF"><?php echo $GLOBALS["strCTR"]; ?>: <b><?php tabecho($total_views>0?sprintf(" %.".$phpAds_config['percentage_decimals']."f%%",$total_clicks/$total_views*100):0); ?></b></td>
	</tr>
	<tr><td height='10' colspan='2'></td></tr>	
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>   
	
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
		<form action="stats-weekly.php">
			<input type="hidden" name="campaignid" value="<?php echo $campaignid;?>">
			<input type="hidden" name="which" value="<?php echo $which;?>">
			<td height='35'>
				<?php echo $GLOBALS['strShowWeeks']; ?>
				<select name="max_weeks" onChange="this.form.submit();">
					<option value="4" <?php echo $max_weeks==4?'selected':''; ?>>4</option>
					<option value="8" <?php echo $max_weeks==8?'selected':''; ?>>8</option>
					<option value="12" <?php echo $max_weeks==12?'selected':''; ?>>12</option>
					<option value="999" <?php echo $max_weeks==999?'selected':''; ?>><?php echo $GLOBALS['strAll']; ?></option>
				</select>
				<input type="image" src="images/<?php echo $phpAds_TextDirection; ?>/go_blue.gif" border="0" name="submit">
			</td>
		</form>
	<?php
	}

	// display choice of banners
	if ( $countbanners > 1 )
	{
		?>
		<form action="stats-weekly.php">
			<input type="hidden" name="campaignid" value="<?php echo $campaignid;?>">
			<input type="hidden" name="max_weeks" value="<?php echo $max_weeks;?>">
			<td height='35' align="right">
				<img src='images/icon-banner-stored.gif' align='absmiddle'>
				<select name="which" onChange="this.form.submit();">
					<option value="0" <?php echo $which==0?'SELECTED':''; ?>><?php echo $GLOBALS['strAll']; ?></option>
		<?php
		for ( $i=0; $i<$countbanners; $i++ )
		{
			?>   
					<option value="<?php echo $banner_select[$i]['id']; ?>" <?php echo $which==$banner_select[$i]['id']?'SELECTED':''; ?>><?php echo $banner_select[$i]['name']; ?></option>
			<?php
		}
		?>
				</select>
				<input type="image" src="images/<?php echo $phpAds_TextDirection; ?>/go_blue.gif" border="0" name="submit">&nbsp;
			</td>
		</form>
	</tr>
		<?php
	}
	?>
</table>
	<?php

} // end-of-function "stats()"









/*********************************************************/
/* Main code                                             */
/*********************************************************/

// preset max_weeks
if (!isset($max_weeks))
	$max_weeks = 4;

// preset which banner
if (!isset($which))
	$which = 0;

// get week signs for mySQL queries
list($php_week_sign, $mysql_week_sign) = GetWeekSigns();

$week = array();
$week['date'] = array();
$week['views'] = array();
$week['clicks'] = array();
$week["ctr"] = array();
$week['clicksum']=0;
$week['viewsum']=0;
$week['days_set']=0;

$total_views = 0;
$total_clicks = 0;

stats();

?>