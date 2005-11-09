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



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



// Include required files
require (phpAds_path.'/libraries/lib-gd.inc.php');



/*********************************************************/
/* Build targeting success ratio                         */
/*********************************************************/

function phpAds_buildTargetRatio($views, $target)
{
	global $phpAds_config, $phpAds_DecimalPoint, $phpAds_ThousandsSeperator;
	
	if ($target > 0)
		$ratio = number_format(($views*100)/$target, $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%";
	else
		$ratio="-";
		
	return ($ratio);
}



/*********************************************************/
/* Return hex-color based on targeting success           */
/*********************************************************/

function phpAds_getTargetColor($views, $target, $d)
{
	if ($target > 0)
	{
		$ratio = ($views*100)/$target;
		if ($ratio < 90)
			$color = 'ffeeee';
		elseif ($ratio > 110)
			$color = 'ffffee';
		else
			$color = 'eeffee';
	}
	elseif ($d % 2)
		$color = 'ffffff';
	else
		$color = 'f6f6f6';

	return '#'.$color;
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($period) || $period == '')
	$period = 'd';

if (isset($lib_targetstats_params))
{
	foreach (array_keys($lib_targetstats_params) as $key)
	{
		$params[] = $key.'='.$lib_targetstats_params[$key];
	}
	
	$params = '?'.implode ('&', $params).'&';
}
else
	$params = '?';

$tabindex = 1;


/*********************************************************/
/* Determine span of statistics                          */
/*********************************************************/

$result = phpAds_dbQuery("
	SELECT
		UNIX_TIMESTAMP(MIN(day)) AS span,
		TO_DAYS(NOW()) - TO_DAYS(MIN(day)) + 1 AS span_days
	FROM
		".$phpAds_config['tbl_targetstats']."
		".(isset($lib_targetstats_where) ? 'WHERE '.$lib_targetstats_where : '')."
");

if ($row = phpAds_dbFetchArray($result))
{
	$span 	     = $row['span'];
	$span_days   = $row['span_days'];
	$span_months = ((date('Y') - date('Y', $span)) * 12) + (date('m') - date('m', $span)) + 1;
	$span_weeks  = (int)($span_days / 7) + ($span_days % 7 ? 1 : 0);
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
	
	$result = phpAds_dbQuery("
		SELECT
			SUM(views) AS sum_views,
			SUM(target) AS sum_target
		FROM
			".$phpAds_config['tbl_targetstats']."
			".(isset($lib_targetstats_where) ? 'WHERE '.$lib_targetstats_where : '')."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$totals['views'] = $row['sum_views'];
		$totals['target'] = $row['sum_target'];
	}
	
	
	
	/*********************************************************/
	/* Get statistics for selected period                    */
	/*********************************************************/
	
	$begin = date('Ymd', $begin_timestamp);
	$end   = date('Ymd', $end_timestamp);
	
	$result = phpAds_dbQuery("
		SELECT
			sum(views) AS sum_views,
			sum(target) AS sum_target,
			max(modified) AS modified,
			DATE_FORMAT(day, '".$formatted."') AS date,
			DATE_FORMAT(day, '".$unformatted."') AS date_u
		FROM
			".$phpAds_config['tbl_targetstats']."
		WHERE
			day >= $begin AND day < $end
			".(isset($lib_targetstats_where) ? 'AND '.$lib_targetstats_where : '')."
		GROUP BY
			date, date_u
		ORDER BY
			date_u DESC
		LIMIT 
			$returnlimit
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['date']]['sum_views'] = $row['sum_views'];
		$stats[$row['date']]['sum_target'] = $row['sum_target'];
		$stats[$row['date']]['modified'] = $row['modified'] != 0;
	}
	
	
	
	/*********************************************************/
	/* Get statistics for today                              */
	/*********************************************************/

	$clientids = array();

	$result = phpAds_dbQuery("
		SELECT
			clientid
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent > 0 AND
			target > 0
		");
	
	while ($row = phpAds_dbFetchArray($result))
		$clientids[] = $row['clientid'];
	
	if (count($clientids))
	{
		$clientids = join(', ', $clientids);

		if ($phpAds_config['compact_stats']) 
		{
			// Get stats for selected period
			$day = date('Ymd');
			
			$result = phpAds_dbQuery("
				SELECT
					sum(views) AS sum_views,
					DATE_FORMAT(day, '".$formatted."') AS date
				FROM
					".$phpAds_config['tbl_adstats'].",
					".$phpAds_config['tbl_banners']."
				WHERE
					".$phpAds_config['tbl_adstats'].".bannerid = ".$phpAds_config['tbl_banners'].".bannerid AND
					day = $day AND
					clientid IN ($clientids)
					".(isset($lib_targetstats_where) ? 'AND '.$lib_targetstats_where : '')."
				GROUP BY
					date
			");

			while ($row = phpAds_dbFetchArray($result))
			{
				$stats[$row['date']]['sum_views'] += $row['sum_views'];
				$totals['views'] += $row['sum_views'];
			}
		}
		else
		{
			// Get stats for selected period
			$begin = date('Ymd000000');
			$end   = date('Ymd235959');
			
			$result = phpAds_dbQuery("
				SELECT
					COUNT(*) AS sum_views,
					DATE_FORMAT(t_stamp, '".$formatted."') AS date
				FROM
					".$phpAds_config['tbl_adviews'].",
					".$phpAds_config['tbl_banners']."
				WHERE
					".$phpAds_config['tbl_adviews'].".bannerid = ".$phpAds_config['tbl_banners'].".bannerid AND
					t_stamp >= $begin AND t_stamp <= $end AND
					clientid IN ($clientids)
					".(isset($lib_targetstats_where) ? 'AND '.$lib_targetstats_where : '')."
				GROUP BY
					date
			") or phpAds_sqlDie();
			
			while ($row = phpAds_dbFetchArray($result))
			{
				$stats[$row['date']]['sum_views'] += $row['sum_views'];
				$totals['views'] += $row['sum_views'];
			}
		}
	}
	
	/*********************************************************/
	/* Main code                                             */
	/*********************************************************/
	
	if (!isset($lib_targetstats_misc_stats) || !$lib_targetstats_misc_stats)
		echo "<form action='".$HTTP_SERVER_VARS['PHP_SELF']."'>";
	
	if (isset($lib_targetstats_params))
		foreach (array_keys($lib_targetstats_params) as $key)
		{
			if (!(isset($lib_targetstats_misc_stats) && $lib_targetstats_misc_stats) && $key != 'type')
				echo "<input type='hidden' name='".$key."' value='".$lib_targetstats_params[$key]."'>";
		}
	
	echo "<select name='period' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
		echo "<option value='d'".($period == 'd' ? ' selected' : '').">".$strDailyHistory."</option>";
		echo "<option value='w'".($period == 'w' ? ' selected' : '').">".$strWeeklyHistory."</option>";
		echo "<option value='m'".($period == 'm' ? ' selected' : '').">".$strMonthlyHistory."</option>";
	echo "</select>";
	
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
		echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strCampaignTarget</b></td>";
		echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strViews</b></td>";
		echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strTargetRatio</b>&nbsp;&nbsp;</td>";
		echo "</tr>";
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		
		$totalviews  = 0;
		$totaltarget = 0;
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
				$modified = isset($stats[$key]['modified']) ? $stats[$key]['modified'] : false;
				
				$target = isset($stats[$key]['sum_target']) ? $stats[$key]['sum_target'] : 0;
				$views  = isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
				$ratio	= phpAds_buildTargetRatio($views, $target);
				
				$totalviews  += $views;
				$totaltarget += $target;
				
				$available = true;
			}
			else
			{
				$modified = false;
				
				if ($timestamp >= $span)
				{
					$views  = 0;
					$target = 0;
					$ratio	= phpAds_buildTargetRatio($views, $target);
					$available = true;
				}
				else
				{
					$views  = '-';
					$target = '-';
					$ratio	= '-';
					$available = false;
				}
			}
			
			$bgcolor = phpAds_getTargetColor($views, $target, $d);
			
			echo "<tr>";
			
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;";
			echo "<img src='images/icon-date.gif' align='absmiddle'>&nbsp;";
			
			if (isset($lib_targetstats_hourlyurl) && $period == 'd' && $available)
				echo "<a href='".$lib_targetstats_hourlyurl.$params."day=".strftime('%Y%m%d', $timestamp)."'>".$key."</a></td>";
			else
				echo $key."</td>";
			
			echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>";
				if ($modified)
					echo "<img src='images/warning.gif' align='absmiddle' alt='".($period == 'd' ? $strTargetModifiedDay : $strTargetModifiedMonth)."'>&nbsp;";
				echo phpAds_formatNumber($target)."</td>";
			echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($views)."</td>";
			echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".$ratio."&nbsp;&nbsp;</td>";
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
					echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."'><u>".$limits[$i]."</u></a>";
				else
					echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."'>".$limits[$i]."</a>";
				
				if ($i < count($limits) - 1) echo "&nbsp;|&nbsp;";
			}
		echo "</td>";
		echo "<td height='35' colspan='3' align='".$phpAds_TextAlignRight."'>";
			if ($start > 0)
			{
				echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$previous."' accesskey='".$keyPrevious."'>";
				echo "<img src='images/arrow-l.gif' border='0' align='absmiddle'>".$strPrevious_Key."</a>";
			}
			if ($timestamp > $span)
			{
				if ($start > 0) echo "&nbsp;|&nbsp;";
				
				echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$next."' accesskey='".$keyNext."'>";
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
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['target'] ? $totaltarget / $totals['target'] * 100 : 0), $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totaltarget)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['views'] ? $totalviews / $totals['views'] * 100 : 0), $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalviews)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildTargetRatio($totalviews, $totaltarget)."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;$strAverageThisPeriod (".$span_this." ".$title.")</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totaltarget / $span_this)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalviews / $span_this)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber((int)$totals['target'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber((int)$totals['views'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildTargetRatio($totals['views'], $totals['target'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;$strAverage (".$span_period." ".$title.")</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['target'] / $span_period : 0)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['views'] / $span_period : 0)."</td>";
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
		$totaltarget = 0;
		
		$today = time();
		
		for ($d=0;$d<$limit;$d++)
		{
			$totalweekviews = 0;
			$totalweektarget = 0;
			
			$bgcolor="#FFFFFF";
			$d % 2 ? 0: $bgcolor= "#F6F6F6";
			
			$shift = date('w') - ($phpAds_config['begin_of_week'] ? 1 - (date('w') == 0 ? 7 : 0) : 0);
			$week_timestamp = mktime(0, 0, 0, date('m'), date('d') - $shift - (7 * ($d + $start)), date('Y'));
			$week_formatted = strftime("%V") != '' ? strftime ($weekiso_format, $week_timestamp + ($phpAds_config['begin_of_week'] ? 0 : (60*60*24))) : 
							  						 strftime ($week_format, $week_timestamp + ($phpAds_config['begin_of_week'] ? 0 : (60*60*24)));
			
			$days = 0;
			$modifiedweek = false;
			
			for ($i = 0; $i < 7; $i++)
			{
				$day_timestamp = $week_timestamp + ($i * (60 * 60 * 24));
				$key = strftime ($formatted, $week_timestamp + ($i * (60 * 60 * 24)));
				
				if (isset($stats[$key]))
				{
					$modified[$i] = isset($stats[$key]['modified']) ? $stats[$key]['modified'] : false;
					if ($modified[$i])
						$modifiedweek = true;
						
					$views[$i]	= isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
					$target[$i]	= isset($stats[$key]['sum_target']) ? $stats[$key]['sum_target'] : 0;
					$ratio[$i]	= phpAds_buildTargetRatio($views[$i], $target[$i]);
					$bgcolorw[$i] = phpAds_getTargetColor($views[$i], $target[$i], $d);
					
					$totalweekviews  += $views[$i];
					$totalweektarget += $target[$i];
					
					$views[$i] = phpAds_formatNumber($views[$i]);
					$target[$i] = phpAds_formatNumber($target[$i]);
					$days++;
				}
				else
				{
					$modified[$i] = false;
			
					if ($day_timestamp >= $span && $day_timestamp <= $today)
					{
						$views[$i]  = 0;
						$target[$i] = 0;
						$ratio[$i]	= phpAds_buildTargetRatio($views[$i], $target[$i]);
						$bgcolorw[$i] = phpAds_getTargetColor($views[$i], $target[$i], $d);
						$days++;
					}
					else
					
					{
						$views[$i]  = '-';
						$target[$i] = '-';
						$ratio[$i]	= '-';
						$bgcolorw[$i] = $bgcolor;
					}
				}
			}
			
			$totalviews += $totalweekviews;
			$totaltarget += $totalweektarget;
			
			
			if ($days > 0)
			{
				$avgviews  = $totalweekviews / $days;
				$avgtarget = $totalweektarget / $days;
				$avgratio    = '';
				
				$avgviews  = phpAds_formatNumber($avgviews);
				$avgtarget = phpAds_formatNumber($avgtarget);
				
				$totalweekratio = phpAds_buildTargetRatio($totalweekviews, $totalweektarget);
				$bgcolortot = phpAds_getTargetColor($totalweekviews, $totalweektarget, $d);
			}
			else
			{
				$avgviews  = '-';
				$avgtarget = '-';
				$avgratio    = '-';
				
				$totalweekviews = '-';
				$totalweektarget = '-';
				$totalweekratio = '-';
				$bgcolortot = $bgcolor;
			}
			
			echo "<tr>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$week_formatted."</td>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strDate."</td>";
				
			for ($i = 0; $i < 7; $i++)
			{
				$day_timestamp = $week_timestamp + ($i * (60 * 60 * 24));
				echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='".$bgcolorw[$i]."'>";
				
				$available = ($views[$i] && $views[$i] != '-') || ($target[$i] && $target[$i] != '-');
				
				if (isset($lib_targetstats_hourlyurl) && $available)
					echo "<a href='".$lib_targetstats_hourlyurl.$params."day=".strftime('%Y%m%d', $day_timestamp)."'>".strftime($day_format, $day_timestamp)."</a>&nbsp;</td>";
				else
					echo strftime($day_format, $day_timestamp)."&nbsp;</td>";
			}
			
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolortot'>&nbsp;</td>";
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolortot'>&nbsp;</td>";
			echo "</tr>";
			
			
			
			
			// Target
			echo "<tr>";
			echo "<td height='15' bgcolor='$bgcolor'>&nbsp;</td>";
			echo "<td height='15' bgcolor='$bgcolor'>&nbsp;".$strCampaignTarget."</td>";
			
			for ($i = 0; $i < 7; $i++)
			{
				echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='15' bgcolor='".$bgcolorw[$i]."'>";
				if ($modified[$i])
					echo "<img src='images/warning.gif' align='absmiddle' alt='".$strTargetModifiedDay."'>&nbsp;";
				echo $target[$i]."&nbsp;</td>";
			}
			
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolortot'>";
			if ($modifiedweek)
				echo "<img src='images/warning.gif' align='absmiddle' alt='".$strTargetModifiedWeek."'>&nbsp;";
			echo $avgtarget."&nbsp;</td>";
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolortot'>".phpAds_formatNumber($totalweektarget)."&nbsp;</td>";
			echo "</tr>";
			
			
			// Views
			echo "<tr>";
			echo "<td height='15' bgcolor='$bgcolor'>&nbsp;</td>";
			echo "<td height='15' bgcolor='$bgcolor'>&nbsp;".$strViews."</td>";
			
			for ($i = 0; $i < 7; $i++)
				echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='".$bgcolorw[$i]."'>".$views[$i]."&nbsp;</td>";
			
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolortot'>".$avgviews."&nbsp;</td>";
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolortot'>".phpAds_formatNumber($totalweekviews)."&nbsp;</td>";
			echo "</tr>";
			
			
			// Target Ratio
			echo "<tr>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;</td>";
			echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strTargetRatio."</td>";
			
			for ($i = 0; $i < 7; $i++)
				echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='".$bgcolorw[$i]."'>".$ratio[$i]."&nbsp;</td>";
			
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolortot'>".$avgratio."&nbsp;</td>";
			echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolortot'>".$totalweekratio."&nbsp;</td>";
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
					echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."'><u>".$limits[$i]."</u></a>";
				else
					echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."'>".$limits[$i]."</a>";
				
				if ($i < count($limits) - 1) echo "&nbsp;|&nbsp;";
			}
		echo "</td>";
		echo "<td height='35' colspan='9' align='".$phpAds_TextAlignRight."'>";
			if ($start > 0)
			{
				echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$previous."'>";
				echo "<img src='images/arrow-l.gif' border='0' align='absmiddle'>".$strPrevious."</a>";
			}
			if ($day_timestamp > $span)
			{
				if ($start > 0) echo "&nbsp;|&nbsp;";
				
				echo "<a href='".$HTTP_SERVER_VARS['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$next."'>";
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
		echo "<td align='".$phpAds_TextAlignRight."' width='20%' nowrap height='25'><b>$strCampaignTarget</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' width='20%' nowrap height='25'><b>$strViews</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' width='20%' nowrap height='25'><b>$strTargetRatio</b>&nbsp;&nbsp;</td>";
		echo "</tr>";
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;<b>$strTotalThisPeriod</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['target'] ? $totaltarget / $totals['target'] * 100 : 0), $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totaltarget)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['views'] ? $totalviews / $totals['views'] * 100 : 0), $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalviews)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildTargetRatio($totalviews, $totaltarget)."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;$strAverageThisPeriod (".$span_this." ".$title.")</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totaltarget / $span_this)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalviews / $span_this)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totals['target'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totals['views'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildTargetRatio($totals['views'], $totals['target'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;$strAverage (".$span_period." ".$title.")</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['target'] / $span_period : 0)."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['views'] / $span_period : 0)."</td>";
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
		echo "<img src='graph-target.php".$params."period=".$period."&start=".$start."&limit=".$limit."' border='0'>";
		echo "</td></tr><tr><td height='10' colspan='1'>&nbsp;</td></tr>";
		echo "<tr><td height='1' colspan='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
}
else
{
	if (isset($lib_targetstats_misc_stats) && $lib_targetstats_misc_stats)
	{
		echo "<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif' border='0' name='submit'>&nbsp;";
		
		phpAds_ShowBreak();
		echo "</form><br>";
	}
	
	echo "<br><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
	echo $strNoTargetStats.'</div>';
}

echo "<br><br>";


?>