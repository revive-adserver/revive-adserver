<?
/* weeklystats.inc.php,v 1.0 2000/12/29 11:06:00 martin braun */

/* placed to GNU by martin@braun.cc */

require('weeklystats.inc.php');

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
		$bgcolor=$GLOBALS['phpAds_table_back_color_alternative'];;
		$j % 2 ? 0: $bgcolor = $GLOBALS['phpAds_table_back_color'];
		$j++;       

		WeekStat(); // calculate daily ctr and summary  
		echo sprintf("      <!-- %s: %s -->\n", $GLOBALS['strWeek'], $week['num'] );
		?>
		<TR>
			<TD CLASS="head" VALIGN="MIDDLE" ALIGN="CENTER" ROWSPAN="4" BGCOLOR="<? echo $bgcolor; ?>"><? echo $week['num']; ?></TD>
			<TD CLASS="normal" ALIGN="CENTER" BGCOLOR="<? echo $bgcolor; ?>"><? echo $GLOBALS["strDate"]; ?></TD>
		<? 
		for ( $i=0; $i<7; $i++ ) 
		{
			?>
        	<TD CLASS="small" ALIGN="CENTER" BGCOLOR="<? echo $bgcolor; ?>"><? echo $week['date'][DayInd($i)]; ?></TD>
			<?
		}
		?>
			<TD BGCOLOR="<? echo $bgcolor; ?>">&nbsp;</TD>
			<TD BGCOLOR="<? echo $bgcolor; ?>">&nbsp;</TD>
		</TR>
		<TR>
			<TD CLASS="normal" ALIGN="CENTER" BGCOLOR="<? echo $bgcolor; ?>"><? echo $GLOBALS["strViews"]; ?></TD>
		<? 
		for ( $i=0; $i<7; $i++ ) 
		{ 
			?>
			<TD CLASS="small" ALIGN="RIGHT" BGCOLOR="<? echo $bgcolor; ?>"><? tabecho($week['views'][DayInd($i)]); ?></TD>
			<?
		}
		$week_avg = $week['days_set']>0?$week['viewsum']/$week['days_set']:0;
		?>
			<TD CLASS="normal" ALIGN="RIGHT" BGCOLOR="<? echo $bgcolor; ?>"><? tabecho(sprintf(' %.'.$GLOBALS['phpAds_percentage_decimals'].'f',$week_avg)); ?></TD>
			<TD CLASS="normal" ALIGN="RIGHT" BGCOLOR="<? echo $bgcolor; ?>"><? tabecho($week['viewsum']); ?></TD>
		</TR>        
		<TR>
			<TD CLASS="normal" ALIGN="CENTER" BGCOLOR="<? echo $bgcolor; ?>"><? echo $GLOBALS['strClicks']; ?></TD>
		<?
		for ( $i=0; $i<7; $i++ ) 
		{ 
			?>
			<TD CLASS="small" ALIGN="RIGHT" BGCOLOR="<? echo $bgcolor; ?>"><? tabecho($week['clicks'][DayInd($i)]); ?></TD>
			<?
		}
		$week_avg = $week['days_set']>0?$week['clicksum']/$week['days_set']:0;
		?>
			<TD CLASS="normal" ALIGN="RIGHT" BGCOLOR="<? echo $bgcolor; ?>"><? tabecho(sprintf(" %.".$GLOBALS['phpAds_percentage_decimals']."f",$week_avg)); ?></TD>
			<TD CLASS="normal" ALIGN="RIGHT" BGCOLOR="<? echo $bgcolor; ?>"><? tabecho($week['clicksum']); ?></TD>
		</TR>        
		<TR>
			<TD CLASS="normal" ALIGN="CENTER" BGCOLOR="<? echo $bgcolor; ?>"><? echo $GLOBALS["strCTRShort"]; ?></TD>
		<?
		for ( $i=0; $i<7; $i++ )
		{
			?>
			<TD CLASS="small" ALIGN="RIGHT" BGCOLOR="<? echo $bgcolor; ?>"><? tabecho(sprintf(" %.".$phpAds_percentage_decimals."f%%",$week["ctr"][DayInd($i)])); ?></TD>
			<?
		}
		$week_avg = $week['days_set']>0?$week['ctrsum']/$week['days_set']:0;
		?>
			<TD CLASS="normal" ALIGN="RIGHT" BGCOLOR="<? echo $bgcolor; ?>"><? tabecho(sprintf(" %.".$phpAds_percentage_decimals."f%%",$week['ctrsum'])); ?></TD>
			<TD BGCOLOR="<? echo $bgcolor; ?>">&nbsp;</TD>
		</TR>        
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

	// get all significant banner-ids to build where-clause
	$banner_query='
		SELECT
			bannerID, bannertext, alt
		FROM
			'.$phpAds_tbl_banners.'
		WHERE 
			clientID = '.$clientID;
	$res = db_query($banner_query) or mysql_die();

	$countbanners = mysql_num_rows($res);
	if ( $countbanners == 1 )   // single banner client
		$where = 'bannerID='.mysql_result($res,0,0);
	else                        // multi banner client
	{  
		$where = 'bannerID IN (';
		$ids = '';
		$banner_select = array();
		$i=0;
		while ( $banner_row = mysql_fetch_array($res) )
		{
			if ($ids) $ids.= ',';
				$ids .= $banner_row['bannerID'];
			// collect banner names for select-box
			$banner_select[$i]=array();
			$banner_select[$i]['id']=$banner_row['bannerID'];
			$banner_select[$i]['name']=$banner_row['bannertext']?$banner_row['bannertext']:$banner_row['alt'];
			$i++;
		}
		$where .= $ids.')';
		if ( $which != '0')  // there! forget set theory!
			$where = 'bannerID='.$which;
	}

	
    
    // I tried to do this with one section of code and a few internal checks
    // for the stats mode, but the queries were just much too inefficient to share.
    if ($phpAds_compact_stats) 
    {
        // get views global data
    	$global_view_query='
    		SELECT
    			sum(clicks),
                sum(views),
    			MAX(TO_DAYS(when)),
    			MIN(TO_DAYS(when))
    		FROM
    			'.$phpAds_tbl_adstats.'
    		WHERE '.
    			$where;
    	// echo $global_view_query;			   
    	$views_global = db_query($global_view_query) or mysql_die();
    	list($total_views, $total_clicks, $views_last_day_index, $views_first_day_index) = mysql_fetch_row($views_global);
    	mysql_free_result($views_global);
    
    	$last_day_index = $views_last_day_index;
    
    	// get views & clicks daily data
    	$daily_query="
    		SELECT
    			views as days_total_views,
    			clicks as days_total_clicks,
    			DATE_FORMAT(when, '".$GLOBALS['date_format']."') as date,
    			DATE_FORMAT(when, '".$mysql_week_sign."') as week_num,
    			DATE_FORMAT(when, '%w') as day_num,
    			UNIX_TIMESTAMP(when) as unix_time,
    			".$last_day_index."-TO_DAYS(when) AS day_index,
    			TO_DAYS(when) AS abs_day
    		FROM
    			".$phpAds_tbl_adstats.' 
    		WHERE 
    			'.$where.'
    		ORDER BY
    			abs_day DESC
    		LIMIT '.$max_weeks*7;
    	$daily = db_query($daily_query) or mysql_die();
    
    	$days = array();
    	while ($row = mysql_fetch_array($daily))
    	{
    		$i = $row['day_index'];
    		$days[$i] = array();
    		$days[$i]['day_index'] = $i + $last_day_index;
    		$days[$i]['week_num']  = $row['week_num'];
    		$days[$i]['day_num']   = $row['day_num'];
    		$days[$i]['unix_time'] = $row['unix_time'];
    		$days[$i]['date']      = $row['date'];
    		$days[$i]['views']     = $row['days_total_views'];
    		$days[$i]['clicks']    = $row['days_total_clicks'];
    	}
    
    	mysql_free_result($daily);
    }
    else        // ! $phpAds_compact_stats
    {
        // get views global data
    	$global_view_query='
    		SELECT
    			count(*),
    			MAX(TO_DAYS(t_stamp)),
    			MIN(TO_DAYS(t_stamp))
    		FROM
    			'.$phpAds_tbl_adviews.'
    		WHERE '.
    			$where;
    	// echo $global_view_query;			   
    	$views_global = db_query($global_view_query) or mysql_die();
    	list($total_views, $views_last_day_index, $views_first_day_index) = mysql_fetch_row($views_global);
    	mysql_free_result($views_global);
    
    	// get clicks global data
    	$global_click_query='
    		SELECT
    			count(*),
    			MAX(TO_DAYS(t_stamp)),
    			MIN(TO_DAYS(t_stamp))
    		FROM
    			'.$phpAds_tbl_adclicks.'
    		WHERE '.
    			$where;
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
    			DATE_FORMAT(t_stamp, '".$mysql_week_sign."') as week_num,
    			DATE_FORMAT(t_stamp, '%w') as day_num,
    			UNIX_TIMESTAMP(t_stamp) as unix_time,
    			".$last_day_index."-TO_DAYS(t_stamp) AS day_index,
    			TO_DAYS(t_stamp) AS abs_day
    		FROM
    			".$phpAds_tbl_adviews.' 
    		WHERE 
    			'.$where.'
    		GROUP BY 
    			abs_day
    		ORDER BY
    			abs_day DESC
    		LIMIT '.$max_weeks*7;
    	$view_daily = db_query($view_query) or mysql_die();
    
    	// get clicks daily data
    	$click_query="
    		SELECT
    			count(*) as days_total_clicks,
    			DATE_FORMAT(t_stamp, '".$GLOBALS['date_format']."') as date,
    			DATE_FORMAT(t_stamp, '".$mysql_week_sign."') as week_num,
    			DATE_FORMAT(t_stamp, '%w') as day_num,
    			UNIX_TIMESTAMP(t_stamp) as unix_time,
    			".$last_day_index."-TO_DAYS(t_stamp) AS day_index,
    			TO_DAYS(t_stamp) AS abs_day
    		FROM
    			".$phpAds_tbl_adclicks."
    		WHERE 
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
    		$days[$i] = array();
    		$days[$i]['day_index'] = $i + $last_day_index;
    		$days[$i]['week_num']  = $row['week_num'];
    		$days[$i]['day_num']   = $row['day_num'];
    		$days[$i]['unix_time'] = $row['unix_time'];
    		$days[$i]['date']      = $row['date'];
    		$days[$i]['views']     = $row['days_total_views'];
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
    		$days[$i]['clicks']       = $row['days_total_clicks'];
    	}
    
    	mysql_free_result($view_daily);
    	mysql_free_result($click_daily);
    }
	
    
    // display interval form 
	// (yes poor Opera and NS6 users we know that it is not conforming w3c
	// how the two forms are embedded in the table but believe that it looks pretty
	// nice in older NS6- and actual IE versions)
	?> 
	<table border="0" cellspacing="3">
	<tr>
		<FORM ACTION="<? echo $GLOBALS['PHP_SELF']; ?>">
		<td><? echo $GLOBALS['strShowWeeks']; ?></TD>
		<td>
		<SELECT NAME="max_weeks">
			<OPTION VALUE="4" <? echo $max_weeks==4?'SELECTED':''; ?>>4</OPTION>
			<OPTION VALUE="8" <? echo $max_weeks==8?'SELECTED':''; ?>>8</OPTION>
			<OPTION VALUE="12" <? echo $max_weeks==12?'SELECTED':''; ?>>12</OPTION>
			<OPTION VALUE="999" <? echo $max_weeks==999?'SELECTED':''; ?>><? echo $GLOBALS['strAll']; ?></OPTION>
			</SELECT>
		</TD>
		<td>
			<input type="hidden" name="pageid" value="<? echo $pageid;?>">
			<input type="hidden" name="clientID" value="<? echo $clientID;?>">
			<input type="hidden" name="which" value="<? echo $which;?>">
			<input type=Submit value="<?print $GLOBALS['strGo'];?>">
		</TD>
		</FORM>
	</TR>
	<?
	// display choice of banners
	if ( $countbanners > 1 )
	{
		?>
		<tr>
			<FORM ACTION="<? echo $GLOBALS['PHP_SELF']; ?>">
			<td align="RIGHT"><? echo $GLOBALS['strBannerID']; ?></TD>
			<td>
			<SELECT NAME="which">
			<OPTION VALUE="0" <? echo $which==0?'SELECTED':''; ?>><? echo $GLOBALS['strAll']; ?></OPTION>
		<?
		for ( $i=0; $i<$countbanners; $i++ )
		{
			?>   
			<OPTION VALUE="<? echo $banner_select[$i]['id']; ?>" <? echo $which==$banner_select[$i]['id']?'SELECTED':''; ?>><? echo $banner_select[$i]['name']; ?></OPTION>
			<?
		}
		?>
        </SELECT>
		</TD>
		<td>
			<input type="hidden" name="pageid" value="<? echo $pageid;?>">
			<input type="hidden" name="clientID" value="<? echo $clientID;?>">
			<input type="hidden" name="max_weeks" value="<? echo $max_weeks;?>">
			<input type=Submit value="<?print $GLOBALS['strGo'];?>">
		</TD>
		</TR>
		</FORM>
		<?
	}
	?>
	</TABLE>
	<?
	if ($total_views == 0 && $total_clicks == 0)
		printf("<table border=\"0\"><TR><TD>%s</TD></TR></TABLE>",$which=0?$GLOBALS["strClientNoStats"]:$GLOBALS["strBannerNoStats"]);
	else
	{
	?>
	<table border="0" cellpadding="0" cellspacing="0" BGCOLOR="<?print $GLOBALS["phpAds_table_back_color"];?>">
		<TR>
			<TD>
				<table border="0" cellpadding="2" cellspacing="1">
					<TR>
						<TD class="head" ROWSPAN="2" BGCOLOR="<?print $GLOBALS["phpAds_table_back_color"];?>"><? echo $GLOBALS["strWeek"]; ?></TD>
						<TD ROWSPAN="2" BGCOLOR="<?print $GLOBALS["phpAds_table_back_color"];?>">&nbsp;</TD>
						<TD class="head" COLSPAN="7" ALIGN="CENTER" BGCOLOR="<?print $GLOBALS["phpAds_table_back_color"];?>"><? echo $GLOBALS["strWeekDay"]; ?></TD>
						<TD class="head" ROWSPAN="2" ALIGN="CENTER" BGCOLOR="<?print $GLOBALS["phpAds_table_back_color"];?>"><? echo $GLOBALS["strAvg"]; ?></TD>
						<TD class="head" ROWSPAN="2" ALIGN="CENTER" BGCOLOR="<?print $GLOBALS["phpAds_table_back_color"];?>"><? echo $GLOBALS["strTotal"]; ?></TD>
					</TR>            
					<TR>
						<!--<TD>void column</TD>-->
	<?
	// display weekday-names from Sunday/Monday
	for ($i=0;$i<7;$i++)
	{
		echo "<TD class=\"normal\" ALIGN=\"center\" BGCOLOR=\"".$GLOBALS["phpAds_table_back_color"]."\">".$strDayShortCuts[DayInd($i)]."</TD>\n";
	}	
	?>
	</TR>
	<?
	// break loop if requested count of weeks is reached
	$weeks_done = 0;
	for($i=0, $oldweek=''; $i<count($days); $i++)  // loop over all days in array
	{      
		$actweek = $days[$i]['week_num'];
		if ( $oldweek != $actweek )                  // change in actual week
		{
			if ( $weeks_done >= $max_weeks )
				break;
			WeekPrint();                              // print old week
			$oldweek = $actweek;
			WeekInit();
			$weeks_done++;                            // reset old values
		}
		WeekFill( $days[$i], $actweek );             // insert daily data into weeks data
	}     
	WeekPrint();                    	            // print the last week
	?>  
	<TR>
		<TD class="normal" COLSPAN="10" BGCOLOR="#DDDDDD"><? echo $GLOBALS["strTotalViews"]; ?></TD>
		<TD class="normal" align="RIGHT" BGCOLOR="#DDDDDD"><B><? tabecho($total_views); ?></B></TD>
	</TR>
	<TR>
		<TD class="normal" COLSPAN="10" BGCOLOR="#DDDDDD"><? echo $GLOBALS["strTotalClicks"]; ?></TD>
		<TD class="normal" align="RIGHT" BGCOLOR="#DDDDDD"><B><? tabecho($total_clicks); ?></B></TD>
	</TR>            
	<TR>
		<TD class="normal" COLSPAN="10" BGCOLOR="#DDDDDD"><? echo $GLOBALS["strCTR"]; ?></TD>
		<TD class="normal" align="RIGHT" BGCOLOR="#DDDDDD"><B><? tabecho($total_views>0?sprintf(" %.".$GLOBALS['phpAds_percentage_decimals']."f%%",$total_clicks/$total_views*100):0); ?></B></TD>
	</TR>  
	<TR>
		<TD COLSPAN="11" ALIGN="CENTER" BGCOLOR="#DDDDDD"><IMG SRC="weeklystats.graph.php?<?php echo "$fncpageid&clientID=$clientID&max_weeks=$max_weeks&where=".urlencode("$where"); ?>"></TD>
	</TR>          
	</TABLE>   
	</TD>
	</TR>
	</TABLE>
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
<STYLE TYPE="text/css">
td {font-family:Arial,Helvetica,sans-serif;color:#000000}
td.small {font-size:8pt;}
td.normal {font-size:10pt;}
td.head {font-size:12pt;}
</STYLE>
<?
stats();
?>
 
