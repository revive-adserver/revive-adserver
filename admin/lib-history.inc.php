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


// Include required files
require ('lib-gd.inc.php');


if (!isset($source))
	$source = '-';

if ($source != '-')
	$lib_history_source = "source = '".$source."'";

if (!isset($period) || $period == '')
	$period = 'd';

if (isset($lib_history_params))
{
	for (reset($lib_history_params); $key = key($lib_history_params); next($lib_history_params))
	{
		$params[] = $key.'='.$lib_history_params[$key];
	}
	
	$params = '?'.implode ('&', $params).'&';
}
else
	$params = '?';

$tabindex = 1;


/*********************************************************/
/* Determine span of statistics                          */
/*********************************************************/

if ($phpAds_config['compact_stats']) 
{
	$result = phpAds_dbQuery("
		SELECT
			UNIX_TIMESTAMP(MIN(day)) AS span,
			TO_DAYS(NOW()) - TO_DAYS(MIN(day)) + 1 AS span_days
		FROM
			".$phpAds_config['tbl_adstats']."
			".(isset($lib_history_where) ? 'WHERE '.$lib_history_where : '')."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$span 	     = $row['span'];
		$span_days   = $row['span_days'];
		$span_months = ((date('Y') - date('Y', $span)) * 12) + (date('m') - date('m', $span)) + 1;
		$span_weeks  = (int)($span_days / 7) + ($span_days % 7 ? 1 : 0);
	}
}
else
{
	$result = phpAds_dbQuery("
		SELECT
			UNIX_TIMESTAMP(MIN(t_stamp)) AS span,
			TO_DAYS(NOW()) - TO_DAYS(MIN(t_stamp)) + 1 AS span_days
		FROM
			".$phpAds_config['tbl_adviews']."
			".(isset($lib_history_where) ? 'WHERE '.$lib_history_where : '')."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$span 	     = $row['span'];
		$span_days   = $row['span_days'];
		$span_months = ((date('Y') - date('Y', $span)) * 12) + (date('m') - date('m', $span)) + 1;
		$span_weeks  = (int)($span_days / 7) + ($span_days % 7 ? 1 : 0);
	}
}

if (isset($row['span']) && $row['span'] > 0)
{
	/*********************************************************/
	/* Prepare for different periods                         */
	/*********************************************************/
	
	if ($period == 'd')
	{
		if (!isset($limit) || $limit=='') $limit = '7';
		if (!isset($start) || $start=='') $start = '0';
		
		$title = $strDays;
		$limits = array(7, 14, 21, 28);
		
		$formatted   = $date_format;
		$unformatted = "%d%m%Y";
		$returnlimit = $limit;
		$span_period = $span_days;
		
		$begin_timestamp = mktime(0, 0, 0, date('m'), date('d') - $limit + 1 - $start, date('Y'));
		$end_timestamp	 = mktime(0, 0, 0, date('m'), date('d') + 1 - $start, date('Y'));
	}
	
	if ($period == 'w')
	{
		if (!isset($limit) || $limit=='') $limit = '4';
		if (!isset($start) || $start=='') $start = '0';
		
		$title = $strWeeks;
		$limits = array(4, 8, 12, 16);
		
		$formatted   = $date_format;
		$unformatted = "%d%m%Y";
		$returnlimit = $limit * 7;
		$span_period = $span_weeks;
		
		$shift = date('w') - ($phpAds_config['begin_of_week'] ? 1 - (date('w') == 0 ? 7 : 0) : 0);
		$begin_timestamp = mktime(0, 0, 0, date('m'), date('d') - $shift + 7 - (7 * ($limit + $start)), date('Y'));
		$end_timestamp   = mktime(0, 0, 0, date('m'), date('d') - $shift + 7 - (7 * $start), date('Y'));
	}
	
	if ($period == 'm')
	{
		if (!isset($limit) || $limit=='') $limit = '6';
		if (!isset($start) || $start=='') $start = '0';
		
		$title = $strMonths;
		$limits = array(6, 12);
		
		$formatted   = $month_format;
		$unformatted = "%m%Y";
		$returnlimit = $limit;
		$span_period = $span_months;
		
		$begin_timestamp = mktime(0, 0, 0, date('m') - $limit + 1 - $start, 1, date('Y'));
		$end_timestamp   = mktime(0, 0, 0, date('m') + 1 - $start, 1, date('Y'));
	}
	
	
	
	/*********************************************************/
	/* Get total statistics                                  */
	/*********************************************************/
	
	if ($phpAds_config['compact_stats']) 
	{
		$result = phpAds_dbQuery("
			SELECT
				SUM(views) AS sum_views,
				SUM(clicks) AS sum_clicks
			FROM
				".$phpAds_config['tbl_adstats']."
				".(isset($lib_history_where) ? 'WHERE '.$lib_history_where : '')."
				".(isset($lib_history_source) ? 'AND '.$lib_history_source : '')."
		");
		
		if ($row = phpAds_dbFetchArray($result))
		{
			$totals['views'] = $row['sum_views'];
			$totals['clicks'] = $row['sum_clicks'];
		}
	}
	else
	{
		$result = phpAds_dbQuery("
			SELECT
				COUNT(*) AS sum_views
			FROM
				".$phpAds_config['tbl_adviews']."
				".(isset($lib_history_where) ? 'WHERE '.$lib_history_where : '')."
				".(isset($lib_history_source) ? 'AND '.$lib_history_source : '')."
		");
		
		if ($row = phpAds_dbFetchArray($result))
		{
			$totals['views'] = $row['sum_views'];
		}
		
		
		$result = phpAds_dbQuery("
			SELECT
				COUNT(*) AS sum_clicks
			FROM
				".$phpAds_config['tbl_adclicks']."
				".(isset($lib_history_where) ? 'WHERE '.$lib_history_where : '')."
				".(isset($lib_history_source) ? 'AND '.$lib_history_source : '')."
		");
		
		if ($row = phpAds_dbFetchArray($result))
		{
			$totals['clicks'] = $row['sum_clicks'];
		}
	}
	
	
	
	/*********************************************************/
	/* Get different sources                                 */
	/*********************************************************/
	
	$sources = array();
	
	if ($phpAds_config['compact_stats']) 
	{
		$result = phpAds_dbQuery("
			SELECT
				DISTINCT source as source
			FROM
				".$phpAds_config['tbl_adstats']."
				".(isset($lib_history_where) ? 'WHERE '.$lib_history_where : '')."
		");
		
		while ($row = phpAds_dbFetchArray($result))
		{
			$sources[] = $row['source'];
		}
	}
	else
	{
		$result = phpAds_dbQuery("
			SELECT
				DISTINCT source as source
			FROM
				".$phpAds_config['tbl_adviews']."
				".(isset($lib_history_where) ? 'WHERE '.$lib_history_where : '')."
		");
		
		while ($row = phpAds_dbFetchArray($result))
		{
			$sources[] = $row['source'];
		}
		
		$result = phpAds_dbQuery("
			SELECT
				DISTINCT source as source
			FROM
				".$phpAds_config['tbl_adclicks']."
				".(isset($lib_history_where) ? 'WHERE '.$lib_history_where : '')."
		");
		
		while ($row = phpAds_dbFetchArray($result))
		{
			if (!in_array($row['source'], $sources))
				$sources[] = $row['source'];
		}
	}
	
	
	
	/*********************************************************/
	/* Get statistics for selected period                    */
	/*********************************************************/
	
	if ($phpAds_config['compact_stats']) 
	{
		// Get stats for selected period
		$begin = date('Ymd', $begin_timestamp);
		$end   = date('Ymd', $end_timestamp);
		
		$result = phpAds_dbQuery("
			SELECT
				sum(views) AS sum_views,
				sum(clicks) AS sum_clicks,
				DATE_FORMAT(day, '".$formatted."') AS date,
				DATE_FORMAT(day, '".$unformatted."') AS date_u
			FROM
				".$phpAds_config['tbl_adstats']."
			WHERE
				day >= $begin AND day < $end
				".(isset($lib_history_where) ? 'AND '.$lib_history_where : '')."
				".(isset($lib_history_source) ? 'AND '.$lib_history_source : '')."
			GROUP BY
				date_u
			ORDER BY
				date_u DESC
			LIMIT 
				$returnlimit
		");
		
		while ($row = phpAds_dbFetchArray($result))
		{
			$stats[$row['date']]['sum_views'] = $row['sum_views'];
			$stats[$row['date']]['sum_clicks'] = $row['sum_clicks'];
		}
	}
	else
	{
		// Get stats for selected period
		$begin = date('YmdHis', $begin_timestamp);
		$end   = date('YmdHis', $end_timestamp);
		
		$result = phpAds_dbQuery("
			SELECT
				COUNT(*) AS sum_views,
				DATE_FORMAT(t_stamp, '".$formatted."') AS date,
				DATE_FORMAT(t_stamp, '".$unformatted."') AS date_u
			FROM
				".$phpAds_config['tbl_adviews']."
			WHERE
				t_stamp >= $begin AND t_stamp < $end
				".(isset($lib_history_where) ? 'AND '.$lib_history_where : '')."
				".(isset($lib_history_source) ? 'AND '.$lib_history_source : '')."
			GROUP BY
				date_u
			ORDER BY
				date_u DESC
			LIMIT 
				$returnlimit
		");
		
		while ($row = phpAds_dbFetchArray($result))
		{
			$stats[$row['date']]['sum_views'] = $row['sum_views'];
			$stats[$row['date']]['sum_clicks'] = '0';
		}
		
		
		$result = phpAds_dbQuery("
			SELECT
				COUNT(*) AS sum_clicks,
				DATE_FORMAT(t_stamp, '".$formatted."') AS date,
				DATE_FORMAT(t_stamp, '".$unformatted."') AS date_u
			FROM
				".$phpAds_config['tbl_adclicks']."
			WHERE
				t_stamp >= $begin AND t_stamp < $end
				".(isset($lib_history_where) ? 'AND '.$lib_history_where : '')."
				".(isset($lib_history_source) ? 'AND '.$lib_history_source : '')."
			GROUP BY
				date_u
			ORDER BY
				date_u DESC
			LIMIT 
				$returnlimit
		");
		
		while ($row = phpAds_dbFetchArray($result))
		{
			$stats[$row['date']]['sum_clicks'] = $row['sum_clicks'];
		}
	}
	
	
	
	/*********************************************************/
	/* Main code                                             */
	/*********************************************************/
	
	echo "<form action='".$HTTP_SERVER_VARS['PHP_SELF']."'>";
	
	if (isset($lib_history_params))
		for (reset($lib_history_params); $key = key($lib_history_params); next($lib_history_params))
			echo "<input type='hidden' name='".$key."' value='".$lib_history_params[$key]."'>";
	
	echo "<select name='period' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
		echo "<option value='d'".($period == 'd' ? ' selected' : '').">".$strDailyHistory."</option>";
		echo "<option value='w'".($period == 'w' ? ' selected' : '').">".$strWeeklyHistory."</option>";
		echo "<option value='m'".($period == 'm' ? ' selected' : '').">".$strMonthlyHistory."</option>";
	echo "</select>";
	
	if ((count($sources) == 1 && $sources[0] != '') || count($sources) > 1)
	{
		echo "&nbsp;&nbsp;";
		echo $strFilterBySource;
		echo "&nbsp;&nbsp;";
		
		echo "<select name='source' onChange='this.form.submit();' tabindex='".($tabindex++)."'>";
		echo "<option value='-'".($source == '-' ? ' selected' : '').">".$strNone."</option>";
		echo "<option value='-'>-----------------</option>";
		
		asort ($sources);
		reset ($sources);
		
		while (list($key, $value) = each ($sources))
		{
			if ($value == '') 
				$readable = $strDefault;
			else
				$readable = ucfirst($value);
			
			echo "<option value='".$value."'".($source == $value ? ' selected' : '').">".$readable."</option>";
		}
		echo "</select>";
	}
	
	echo "&nbsp;&nbsp;";
	echo "<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif' border='0' name='submit'>&nbsp;";
	
	phpAds_ShowBreak();
	echo "</form>";
	
	echo "<br><br>";
	
	
	if ($period == 'm' || $period == 'd')
	{
		// Header
		echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
		echo "<tr bgcolor='#FFFFFF' height='25'>";
		echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;<b>$title</b></td>";
		echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strViews</b></td>";
		echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strClicks</b></td>";
		echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strCTRShort</b>&nbsp;&nbsp;</td>";
		echo "</tr>";
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		
		$totalviews  = 0;
		$totalclicks = 0;
		$today = time();
		
		
		for ($d=0;$d<$limit;$d++)
		{
			switch ($period)
			{
				case 'm':	$timestamp = mktime (0, 0, 0, date('m') - $d - $start, 1, date('Y'));
							$span      = mktime (0, 0, 0, date('m', $span), 1, date('Y', $span));
							break;
						
				case 'd':	$timestamp = mktime (0, 0, 0, date('m'), date('d') - $d - $start, date('Y'));
							$span      = mktime (0, 0, 0, date('m', $span), date('d', $span), date('Y', $span));
							break;
			}
			
			$key = strftime ($formatted, $timestamp);
			
			
			if (isset($stats[$key]))
			{
				$views  = isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
				$clicks = isset($stats[$key]['sum_clicks']) ? $stats[$key]['sum_clicks'] : 0;
				$ctr	= phpAds_buildCTR($views, $clicks);
				
				$totalviews  += $views;
				$totalclicks += $clicks;
				
				$available = true;
			}
			else
			{
				if ($timestamp >= $span)
				{
					$views  = 0;
					$clicks = 0;
					$ctr	= phpAds_buildCTR($views, $clicks);
					$available = true;
				}
				else
				{
					$views  = '-';
					$clicks = '-';
					$ctr	= '-';
					$available = false;
				}
			}
			
			$bgcolor="#FFFFFF";
			$d % 2 ? 0: $bgcolor= "#F6F6F6";
			
			echo "<tr>";
			
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;";
			echo "<img src='images/icon-date.gif' align='absmiddle'>&nbsp;";
			
			if (isset($lib_history_hourlyurl) && $period == 'd' && $available)
				echo "<a href='".$lib_history_hourlyurl.$params."day=".strftime('%Y%m%d', $timestamp)."'>".$key."</a></td>";
			else
				echo $key."</td>";
			
			echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($views)."</td>";
			echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($clicks)."</td>";
			echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".$ctr."&nbsp;&nbsp;</td>";
			echo "</tr>";
			
			echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		}
		
		
		$previous = $start < $limit ? 0 : $start - $limit;
		$next = $start + $limit;
		
		echo "<tr>";
		echo "<td height='35' colspan='1' align='".$phpAds_TextAlignLeft."'>";
			echo "&nbsp;".$title.":&nbsp;";
			for ($i = 0; $i < count($limits); $i++)
			{
				if ($limit == $limits[$i])
					echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."&source=".$source."'><u>".$limits[$i]."</u></a>";
				else
					echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."&source=".$source."'>".$limits[$i]."</a>";
				
				if ($i < count($limits) - 1) echo "&nbsp;|&nbsp;";
			}
		echo "</td>";
		echo "<td height='35' colspan='3' align='".$phpAds_TextAlignRight."'>";
			if ($start > 0)
			{
				echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$previous."&source=".$source."' accesskey='".$keyPrevious."'>";
				echo "<img src='images/arrow-l.gif' border='0' align='absmiddle'>".$strPrevious_Key."</a>";
			}
			if ($timestamp > $span)
			{
				if ($start > 0) echo "&nbsp;|&nbsp;";
				
				echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$next."&source=".$source."' accesskey='".$keyNext."'>";
				echo $strNext_Key."<img src='images/arrow-r.gif' border='0' align='absmiddle'></a>";
			}
		echo "</td>";
		echo "</tr>";
		
		
		
		$span_this = (($start + $limit < $span_period ? $start + $limit : $span_period) - $start);
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;</td>";
		echo "<td height='25'>&nbsp;</td>";
		echo "<td height='25'>&nbsp;</td>";
		echo "<td height='25'>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;<b>$strTotalThisPeriod</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['views'] ? $totalviews / $totals['views'] * 100 : 0), $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalviews)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['clicks'] ? $totalclicks / $totals['clicks'] * 100 : 0), $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalclicks)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;$strAverageThisPeriod (".$span_this." ".$title.")</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalviews / $span_this)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalclicks / $span_this)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber((int)$totals['views'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber((int)$totals['clicks'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildCTR($totals['views'], $totals['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;$strAverage (".$span_period." ".$title.")</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['views'] / $span_period : 0)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['clicks'] / $span_period : 0)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "</table>";
	}
	
	
	if ($period == 'w')
	{
		// Header
		echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
		echo "<tr bgcolor='#FFFFFF' height='25'>";
		echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;<b>$title</b></td>";
		echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;</td>";
		
		for ($i=0; $i < 7; $i++)
			echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strDayShortCuts[($i + ($phpAds_config['begin_of_week'] ? 1 : 0)) % 7]."</b></td>";
		
		echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25' width='10%'><b>$strAvg</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strTotal</b>&nbsp;&nbsp;</td>";
		echo "</tr>";
		echo "<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		
		$totalviews  = 0;
		$totalclicks = 0;
		
		$today = time();
		
		for ($d=0;$d<$limit;$d++)
		{
			$totalweekviews = 0;
			$totalweekclicks = 0;
			
			$bgcolor="#FFFFFF";
			$d % 2 ? 0: $bgcolor= "#F6F6F6";
			
			$shift = date('w') - ($phpAds_config['begin_of_week'] ? 1 - (date('w') == 0 ? 7 : 0) : 0);
			$week_timestamp = mktime(0, 0, 0, date('m'), date('d') - $shift - (7 * ($d + $start)), date('Y'));
			$week_formatted = strftime("%V") != '' ? strftime ($weekiso_format, $week_timestamp + ($phpAds_config['begin_of_week'] ? 0 : (60*60*24))) : 
							  						 strftime ($week_format, $week_timestamp + ($phpAds_config['begin_of_week'] ? 0 : (60*60*24)));
			
			$days = 0;
			
			for ($i = 0; $i < 7; $i++)
			{
				$day_timestamp = $week_timestamp + ($i * (60 * 60 * 24));
				$key = strftime ($formatted, $week_timestamp + ($i * (60 * 60 * 24)));
				
				if (isset($stats[$key]))
				{
					$views[$i]  = isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
					$clicks[$i] = isset($stats[$key]['sum_clicks']) ? $stats[$key]['sum_clicks'] : 0;
					$ctr[$i]	= phpAds_buildCTR($views[$i], $clicks[$i]);
					
					$totalweekviews  += $views[$i];
					$totalweekclicks += $clicks[$i];
					
					$views[$i] = phpAds_formatNumber($views[$i]);
					$clicks[$i] = phpAds_formatNumber($clicks[$i]);
					$days++;
				}
				else
				{
					if ($day_timestamp >= $span && $day_timestamp <= $today)
					{
						$views[$i]  = 0;
						$clicks[$i] = 0;
						$ctr[$i]	= phpAds_buildCTR($views[$i], $clicks[$i]);
						$days++;
					}
					else
					{
						$views[$i]  = '-';
						$clicks[$i] = '-';
						$ctr[$i]	= '-';
					}
				}
			}
			
			$totalviews += $totalweekviews;
			$totalclicks += $totalweekclicks;
			
			
			if ($days > 0)
			{
				$avgviews  = $totalweekviews / $days;
				$avgclicks = $totalweekclicks / $days;
				$avgctr    = phpAds_buildCTR($avgviews, $avgclicks);
				
				$avgviews  = phpAds_formatNumber($avgviews);
				$avgclicks = phpAds_formatNumber($avgclicks);
				
				$totalweekctr = phpAds_buildCTR($totalweekviews, $totalweekclicks);
			}
			else
			{
				$avgviews  = '-';
				$avgclicks = '-';
				$avgctr    = '-';
				
				$totalweekviews = '-';
				$totalweekclicks = '-';
				$totalweekctr = '-';
			}
			
			echo "<tr>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$week_formatted."</td>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strDate."</td>";
				
			for ($i = 0; $i < 7; $i++)
			{
				$day_timestamp = $week_timestamp + ($i * (60 * 60 * 24));
				echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>";
				
				$available = ($views[$i] && $views[$i] != '-') || ($clicks[$i] && $clicks[$i] != '-');
				
				if (isset($lib_history_hourlyurl) && $available)
					echo "<a href='".$lib_history_hourlyurl.$params."day=".strftime('%Y%m%d', $day_timestamp)."'>".strftime($day_format, $day_timestamp)."</a>&nbsp;</td>";
				else
					echo strftime($day_format, $day_timestamp)."&nbsp;</td>";
			}
			
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>&nbsp;</td>";
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>&nbsp;</td>";
			echo "</tr>";
			
			
			
			
			// Views
			echo "<tr>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;</td>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strViews."</td>";
			
			for ($i = 0; $i < 7; $i++)
				echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$views[$i]."&nbsp;</td>";
			
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$avgviews."&nbsp;</td>";
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totalweekviews)."&nbsp;</td>";
			echo "</tr>";
			
			
			// Clicks
			echo "<tr>";
			echo "<td height='15' bgcolor='$bgcolor'>&nbsp;</td>";
			echo "<td height='15' bgcolor='$bgcolor'>&nbsp;".$strClicks."</td>";
			
			for ($i = 0; $i < 7; $i++)
				echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='15' bgcolor='$bgcolor'>".$clicks[$i]."&nbsp;</td>";
			
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='15' bgcolor='$bgcolor'>".$avgclicks."&nbsp;</td>";
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='15' bgcolor='$bgcolor'>".phpAds_formatNumber($totalweekclicks)."&nbsp;</td>";
			echo "</tr>";
			
			
			// CTR
			echo "<tr>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;</td>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strCTRShort."</td>";
			
			for ($i = 0; $i < 7; $i++)
				echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$ctr[$i]."&nbsp;</td>";
			
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$avgctr."&nbsp;</td>";
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$totalweekctr."&nbsp;</td>";
			echo "</tr>";
			
			echo "<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		}
		
		
		$previous = $start < $limit ? 0 : $start - $limit;
		$next = $start + $limit;
		
		echo "<tr>";
		echo "<td height='35' colspan='2' align='".$phpAds_TextAlignLeft."'>";
			echo "&nbsp;".$title.":&nbsp;";
			for ($i = 0; $i < count($limits); $i++)
			{
				if ($limit == $limits[$i])
					echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."&source=".$source."'><u>".$limits[$i]."</u></a>";
				else
					echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."&source=".$source."'>".$limits[$i]."</a>";
				
				if ($i < count($limits) - 1) echo "&nbsp;|&nbsp;";
			}
		echo "</td>";
		echo "<td height='35' colspan='9' align='".$phpAds_TextAlignRight."'>";
			if ($start > 0)
			{
				echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$previous."&source=".$source."'>";
				echo "<img src='images/arrow-l.gif' border='0' align='absmiddle'>".$strPrevious."</a>";
			}
			if ($day_timestamp > $span)
			{
				if ($start > 0) echo "&nbsp;|&nbsp;";
				
				echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$next."&source=".$source."'>";
				echo $strNext."<img src='images/arrow-r.gif' border='0' align='absmiddle'></a>";
			}
		echo "</td>";
		echo "</tr>";
		
		echo "</table>";
		
		
		
		$span_this = (($start + $limit < $span_period ? $start + $limit : $span_period) - $start);
		
		echo "<br><br>";
		echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
		echo "<tr bgcolor='#FFFFFF' height='25'>";
		echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;</td>";
		echo "<td align='".$phpAds_TextAlignRight."' width='20%' nowrap height='25'><b>$strViews</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' width='20%' nowrap height='25'><b>$strClicks</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' width='20%' nowrap height='25'><b>$strCTRShort</b>&nbsp;&nbsp;</td>";
		echo "</tr>";
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;<b>$strTotalThisPeriod</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['views'] ? $totalviews / $totals['views'] * 100 : 0), $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalviews)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['clicks'] ? $totalclicks / $totals['clicks'] * 100 : 0), $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalclicks)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;$strAverageThisPeriod (".$span_this." ".$title.")</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalviews / $span_this)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalclicks / $span_this)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totals['views'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totals['clicks'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildCTR($totals['views'], $totals['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;$strAverage (".$span_period." ".$title.")</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['views'] / $span_period : 0)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['clicks'] / $span_period : 0)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "</table>";
	}
	
	if (phpAds_GDImageFormat() != "none")
	{
		echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
		echo "<tr><td height='20' colspan='1'>&nbsp;</td></tr>";
		echo "<tr><td bgcolor='#FFFFFF' colspan='1'>";
		echo "<img src='graph-history.php".$params."period=".$period."&start=".$start."&limit=".$limit."&source=".$source."' border='0'>";
		echo "</td></tr><tr><td height='10' colspan='1'>&nbsp;</td></tr>";
		echo "<tr><td height='1' colspan='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
}
else
{
	echo "<br><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
	echo $strNoStats.'</div>';
}

echo "<br><br>";


?>