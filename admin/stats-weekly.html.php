<?
/* stats-weekly.inc.php,v 1.0 2000/12/29 11:06:00 martin braun */

/* placed to GNU by martin@braun.cc */


function DayInd($ind)   // adjust day index to specific installation
{              
	$ind += $GLOBALS['phpAds_begin_of_week'];
	return $ind > 6 ? 0 : $ind;
}

function tabecho($value)
{
	echo (double)$value>0?$value:'-';
}

function WeekInit()   // reset week data
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

function WeekSetDates() // set all missing dates in week
{
	global $week;
	global $php_week_sign;

	// find first col with valid date
	$i=0;
	while(empty($week['date'][$i])){$i++;}

	// calc timestamp for first row
	$stamp = $week['unix_time'][$i]-$i*24*60*60;

	// adjust timestamp to country settings if needed
	if ($i==0 && $GLOBALS['phpAds_begin_of_week']==1) 
		$stamp -= 7*24*60*60;

	// check all day rows
	for ($i=0;$i<7;$i++)
	{
		// fill date in row if empty
		if (empty($week['date'][$i]))
		{
			$mult = $i;
			// adjust multiplier to country settings if needed
			if ($mult==0 && $GLOBALS['phpAds_begin_of_week']==1) 
				$mult=7; // sunday (col=0) is last day of the week
			$week['date'][$i] = strftime($GLOBALS['date_format'],$stamp+$mult*24*60*60); 
		}
	}

	// check calendar week for zero value
	if (strftime($php_week_sign,$stamp) == 0)
		// replace by last calendar week of elapsed year
		$week['num']=strftime($php_week_sign."/Y",mktime(0,0,0,12,31,strftime('Y',$stamp)-1));
}

function WeekStat()  // calculate daily ctr and summary
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

function WeekFill($day_array, $actweek) // insert actual day in weekly data
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

function WeekPrint() // html generator for one week
{
	global $week;
	global $phpAds_percentage_decimals;
	static $j=1;
	if ( $week['num'] ) // only if already filled (not at first call)
	{

		// set background color
		$bgcolor="#FFFFFF";
		$j % 2 ? 0: $bgcolor = "#F6F6F6";
		$j++;       

		WeekStat(); // calculate daily ctr and summary  
		//echo sprintf("      <!-- %s: %s -->\n", $GLOBALS['strWeek'], $week['num'] );
		?>
		<tr>
			<td height='80' valign="middle" align="left" rowspan="4" bgcolor="<? echo $bgcolor; ?>">&nbsp;<? echo $week['num']; ?></td>
			<td height='20' align="left" bgcolor="<? echo $bgcolor; ?>"><? echo $GLOBALS["strDate"]; ?></td>
		<? 
		for ( $i=0; $i<7; $i++ ) 
		{
			?>
        	<td height='20' align="right" bgcolor="<? echo $bgcolor; ?>"><? echo substr ($week['date'][DayInd($i)], 0, -5); ?></td>
			<?
		}
		?>
			<td height='20' bgcolor="<? echo $bgcolor; ?>">&nbsp;</td>
			<td height='20' bgcolor="<? echo $bgcolor; ?>">&nbsp;</td>
		</tr>
		<tr height='20'>
			<td height='20' align="left" bgcolor="<? echo $bgcolor; ?>"><? echo $GLOBALS["strViews"]; ?></td>
		<? 
		for ( $i=0; $i<7; $i++ ) 
		{ 
			?>
			<td height='20' align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho($week['views'][DayInd($i)]); ?></td>
			<?
		}
		$week_avg = $week['days_set']>0?$week['viewsum']/7:0; //$week['days_set']
		?>
			<td height='20' align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho(sprintf(' %.'.$GLOBALS['phpAds_percentage_decimals'].'f',$week_avg)); ?></td>
			<td height='20' align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho($week['viewsum']); ?>&nbsp;</td>
		</tr>        
		<tr>
			<td height='20' class="normal" align="left" bgcolor="<? echo $bgcolor; ?>"><? echo $GLOBALS['strClicks']; ?></td>
		<?
		for ( $i=0; $i<7; $i++ ) 
		{ 
			?>
			<td height='20' class="small" align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho($week['clicks'][DayInd($i)]); ?></td>
			<?
		}
		$week_avg = $week['days_set']>0?$week['clicksum']/7:0; //$week['days_set']
		?>
			<td height='20' class="normal" align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho(sprintf(" %.".$GLOBALS['phpAds_percentage_decimals']."f",$week_avg)); ?></td>
			<td height='20' class="normal" align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho($week['clicksum']); ?>&nbsp;</td>
		</tr>        
		<tr>
			<td height='20' class="normal" align="left" bgcolor="<? echo $bgcolor; ?>"><? echo $GLOBALS["strCTRShort"]; ?></td>
		<?
		for ( $i=0; $i<7; $i++ )
		{
			?>
			<td height='20' class="small" align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho(sprintf(" %.".$phpAds_percentage_decimals."f%%",$week["ctr"][DayInd($i)])); ?></td>
			<?
		}
		$week_avg = $week['days_set']>0?$week['ctrsum']/7:0; //$week['days_set']
		?>
			<td height='20' class="normal" align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho(sprintf(" %.".$phpAds_percentage_decimals."f%%",$week['ctrsum'])); ?></td>
			<td height='20' class="normal" align="right" bgcolor="<? echo $bgcolor; ?>"><? tabecho(sprintf(" %.".$phpAds_percentage_decimals."f%%",$week['ctrsum'])); ?>&nbsp;</td>
		</tr>
		<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>        
		<?
	}
}

function stats() // generate weekly statistics
{
	global $phpAds_db, $phpAds_url_prefix;
	global $phpAds_tbl_color;
	global $phpAds_begin_of_week;
	global $phpAds_tbl_adviews, $phpAds_tbl_adclicks, $phpAds_tbl_adstats, $phpAds_tbl_banners;
    	global $phpAds_compact_stats;
	global $clientID, $which;
	global $max_weeks, $php_week_sign, $mysql_week_sign;
	global $strDayShortCuts;
	global $strClientName, $strOverall;

	// get all significant banner-ids to build where-clause
	$banner_query = "
		SELECT
			bannerID, bannertext, alt, description
		FROM
			$phpAds_tbl_banners
		";
	
	if ($clientID > 0)
	$banner_query .= "
		WHERE 
			clientID = $clientID
		";
	
	$res = db_query($banner_query) or mysql_die();
	
	// Get the number of banners
	$countbanners = mysql_num_rows($res);
	
	if ($countbanners == 1)
	{
		// single banner client
		$where = 'WHERE bannerID='.mysql_result ($res, 0, 0);
	}
	else
	{
		// multi banner client
		
		if ($clientID > 0) 
			$where = 'WHERE bannerID IN (';
		
		$ids = '';
		$banner_select = array();
		$i=0;
		
		while ($banner_row = mysql_fetch_array ($res))
		{
			if ($ids) $ids.= ',';
				$ids .= $banner_row['bannerID'];
				
			// collect banner names for select-box
			$banner_select[$i]			= array();
			$banner_select[$i]['id']	= $banner_row['bannerID'];
			$banner_select[$i]['name'] 	= phpAds_buildBannerName ($banner_row[bannerID], $banner_row[description], $banner_row[alt]);
			
			$i++;
		}
		
		if ($clientID > 0) 
			$where .= $ids.')';
		
		if ($which != '0')  // there! forget set theory!
			$where = 'WHERE bannerID='.$which;
	}


    // I tried to do this with one section of code and a few internal checks
    // for the stats mode, but the queries were just much too inefficient to share.
    if ($phpAds_compact_stats) 
    {
        // get views global data
    	$global_view_query="
    		SELECT
    			sum(clicks),
                	sum(views),
    			MAX(TO_DAYS(day)),
    			MIN(TO_DAYS(day))
    		FROM
    			$phpAds_tbl_adstats
    		$where;
		";
		
    	$views_global = db_query($global_view_query) or mysql_die();
    	list($total_clicks, $total_views, $views_last_day_index, $views_first_day_index) = mysql_fetch_row($views_global);
    	mysql_free_result($views_global);
    
    	$last_day_index = $views_last_day_index;
    
    	// get views & clicks daily data
    	$daily_query="
    		SELECT
    			views as days_total_views,
    			clicks as days_total_clicks,
    			DATE_FORMAT(day, '".$GLOBALS['date_format']."') as date,
    			DATE_FORMAT(day, '$mysql_week_sign') as week_num,
    			DATE_FORMAT(day, '%w') as day_num,
    			UNIX_TIMESTAMP(day) as unix_time,
    			$last_day_index-TO_DAYS(day) AS day_index,
    			TO_DAYS(day) AS abs_day
    		FROM
    			$phpAds_tbl_adstats
   			$where
    		ORDER BY
    			abs_day DESC
    		LIMIT ".$max_weeks*7;
    	$daily = db_query($daily_query) or mysql_die();
    
    	$days = array();
    	while ($row = mysql_fetch_array($daily))
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
    		$days[$i]['views']     = $days[$i]['views'] + $row['days_total_views'];
    		$days[$i]['clicks']    = $days[$i]['clicks'] + $row['days_total_clicks'];
    	}
    
    	mysql_free_result($daily);
    }
    else        // ! $phpAds_compact_stats
    {
        // get views global data
    	$global_view_query="
    		SELECT
    			count(*),
    			MAX(TO_DAYS(t_stamp)),
    			MIN(TO_DAYS(t_stamp))
    		FROM
    			$phpAds_tbl_adviews
    		$where
		";

    	$views_global = db_query($global_view_query) or mysql_die();
    	list($total_views, $views_last_day_index, $views_first_day_index) = mysql_fetch_row($views_global);
    	mysql_free_result($views_global);
    
    	// get clicks global data
    	$global_click_query="
    		SELECT
    			count(*),
    			MAX(TO_DAYS(t_stamp)),
    			MIN(TO_DAYS(t_stamp))
    		FROM
    			$phpAds_tbl_adclicks
    		$where
			";
    		// echo $global_click_query;			   
    	$clicks_global = db_query($global_click_query) or mysql_die();
    	list($total_clicks, $clicks_last_day_index, $clicks_first_day_index) = mysql_fetch_row($clicks_global);
    	mysql_free_result($clicks_global);
    
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
    			$phpAds_tbl_adviews
    		$where
    		GROUP BY 
    			abs_day
    		ORDER BY
    			abs_day DESC
    		LIMIT ".$max_weeks*7;
    	$view_daily = db_query($view_query) or mysql_die();
    
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
    			$phpAds_tbl_adclicks
    		$where
    		GROUP BY 
    			abs_day
    		ORDER BY
    			abs_day DESC
    		LIMIT ".$max_weeks*7;
    	$click_daily = db_query($click_query) or mysql_die();
    
    	// now let's join the daily data in a days array
    	$days = array();
    
    	// insert view data
    	while ($row = mysql_fetch_array($view_daily))
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
    			$days[$i]['views']     = $row['days_total_views'];
    		}
    		else
				$days[$i]['views']     = $days[$i]['views'] + $row['days_total_views'];
    	}
    
    	// now insert click data
    	while ($row = mysql_fetch_array($click_daily))
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
    		else
	    		$days[$i]['clicks']       = $days[$i]['clicks'] + $row['days_total_clicks'];
    	}
	    
    	mysql_free_result($view_daily);
    	mysql_free_result($click_daily);
    }
	
    
    // display interval form 
	// (yes poor Opera and NS6 users we know that it is not conforming w3c
	// how the two forms are embedded in the table but believe that it looks pretty
	// nice in older NS6- and actual IE versions)
	?> 

	
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<?
		if ($clientID > 0)
			echo "<tr><td height='25' colspan='2'><b>$strClientName: ".phpAds_getClientName($clientID)."</b></td></tr>";
		else
			echo "<tr><td height='25' colspan='2'><b>$strOverall</b></td></tr>";
	?>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr>
		<form action="<? echo $GLOBALS['PHP_SELF']; ?>">
			<input type="hidden" name="clientID" value="<? echo $clientID;?>">
			<input type="hidden" name="which" value="<? echo $which;?>">
			<td height='35'>
				<? echo $GLOBALS['strShowWeeks']; ?>
				<select name="max_weeks" onChange="this.form.submit();">
					<option value="4" <? echo $max_weeks==4?'selected':''; ?>>4</option>
					<option value="8" <? echo $max_weeks==8?'selected':''; ?>>8</option>
					<option value="12" <? echo $max_weeks==12?'selected':''; ?>>12</option>
					<option value="999" <? echo $max_weeks==999?'selected':''; ?>><? echo $GLOBALS['strAll']; ?></option>
				</select>
				<input type="image" src="images/go_blue.gif" border="0" name="submit">
			</td>
		</form>
	<?
	
	// display choice of banners
	if ( $countbanners > 1 )
	{
		?>
		<form action="<? echo $GLOBALS['PHP_SELF']; ?>">
			<input type="hidden" name="clientID" value="<? echo $clientID;?>">
			<input type="hidden" name="max_weeks" value="<? echo $max_weeks;?>">
			<td height='35' align="left">
				<? echo $GLOBALS['strBannerID']; ?>
				<select name="which" onChange="this.form.submit();">
					<option value="0" <? echo $which==0?'SELECTED':''; ?>><? echo $GLOBALS['strAll']; ?></option>
		<?
		for ( $i=0; $i<$countbanners; $i++ )
		{
			?>   
					<option value="<? echo $banner_select[$i]['id']; ?>" <? echo $which==$banner_select[$i]['id']?'SELECTED':''; ?>><? echo $banner_select[$i]['name']; ?></option>
			<?
		}
		?>
				</select>
				<input type="image" src="images/go_blue.gif" border="0" name="submit">&nbsp;
			</td>
		</form>
	</tr>
		<?
	}
	?>
</table>

<br><br>

	<?
		if ($total_views == 0 && $total_clicks == 0)
		printf("<table border=\"0\"><tr><td>%s</td></tr></table>",$which=0?$GLOBALS["strClientNoStats"]:$GLOBALS["strBannerNoStats"]);
	else
	{
	?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='40' rowspan="2" bgcolor="#F6F6F6">&nbsp;<? echo $GLOBALS["strWeek"]; ?></td>
		<td height='40' rowspan="2" bgcolor="#F6F6F6">&nbsp;</td>
		<td height='20' colspan="7" align="center" bgcolor="#F6F6F6"><? echo $GLOBALS["strWeekDay"]; ?></td>
		<td height='40' rowspan="2" align="right" bgcolor="#F6F6F6"><? echo $GLOBALS["strAvg"]; ?></td>
		<td height='40' rowspan="2" align="right" bgcolor="#F6F6F6"><? echo $GLOBALS["strTotal"]; ?>&nbsp;</td>
	</tr>            
	<tr>
	<?
	// display weekday-names from Sunday/Monday
	for ($i=0;$i<7;$i++)
	{
		echo "<td height='20' align=\"right\" bgcolor=\"#F6F6F6\">".$strDayShortCuts[DayInd($i)]."</td>\n";
	}	
	?>
	</tr>
	<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<?

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
	<? if (phpAds_GDImageFormat() != "none") { ?>
	<tr><td colspan="3" align="left" bgcolor="#FFFFFF"><img src="graph-weekly.php?<?php echo "clientID=$clientID&max_weeks=$max_weeks&where=".urlencode("$where"); ?>"></td></tr>
	<? } ?>          
	<tr>
		<td height='25' bgcolor="#FFFFFF"><? echo $GLOBALS["strTotalViews"]; ?>: <b><? tabecho($total_views); ?></b></td>
		<td height='25' bgcolor="#FFFFFF"><? echo $GLOBALS["strTotalClicks"]; ?>: <b><? tabecho($total_clicks); ?></b></td>
		<td height='25' bgcolor="#FFFFFF"><? echo $GLOBALS["strCTR"]; ?>: <b><? tabecho($total_views>0?sprintf(" %.".$GLOBALS['phpAds_percentage_decimals']."f%%",$total_clicks/$total_views*100):0); ?></b></td>
	</tr>
	<tr><td height='10' colspan='2'></td></tr>	
	<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>   
	<?
	}
} // end-of-function "stats()"









// --------------
// main procedure
// --------------

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

// Sorry, at this point there is no more access to page headers to place
// CSS where they usually belong, so we'll try it here (works at 
// least with NN4 and IE5
?>
<?
stats();
?>
 
