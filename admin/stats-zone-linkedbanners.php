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
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-size.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	$affiliateid = phpAds_getUserID();
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$extra = '';
	
	$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_zones']."
	WHERE
		affiliateid = ".$affiliateid."
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($zoneid == $row['zoneid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href=stats-zone-linkedbanners.php?affiliateid=".$affiliateid."&zoneid=".$row['zoneid'].">".phpAds_buildZoneName ($row['zoneid'], $row['zonename'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	
	phpAds_PageHeader("2.4.2.2", $extra);
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.4.2.1", "2.4.2.2"));
}
else
{
	phpAds_PageHeader("1.1.2");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections(array("1.1.1", "1.1.2"));
}


/*********************************************************/
/* Main code                                             */
/*********************************************************/


// Get the zone information
$res_stats = phpAds_dbQuery("
	SELECT
		what
	FROM 
		".$phpAds_config['tbl_zones']."
	WHERE
		zoneid = ".$zoneid."
");

if ($row_zone = phpAds_dbFetchArray($res_stats))
{
	$zone = $row_zone;
	
	
	// Get the adviews/clicks for each banner
	if ($phpAds_config['compact_stats'])
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				SUM(views) AS views,
				sum(clicks) AS clicks
			FROM 
				".$phpAds_config['tbl_adstats']."
			WHERE
				zoneid = ".$zoneid."
			GROUP BY
				zoneid, bannerid
		");
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$linkedbanners[$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$linkedbanners[$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
			$linkedbanners[$row_stats['bannerid']]['views'] = $row_stats['views'];
		}
	}
	else
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				bannerid,
				count(bannerid) as views
			FROM 
				".$phpAds_config['tbl_adviews']."
			WHERE
				zoneid = ".$zoneid."
			GROUP BY
				zoneid, bannerid
		");
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$linkedbanners[$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$linkedbanners[$row_stats['bannerid']]['clicks'] = 0;
			$linkedbanners[$row_stats['bannerid']]['views'] = $row_stats['views'];
		}
		
		
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				bannerid,
				count(bannerid) as clicks
			FROM 
				".$phpAds_config['tbl_adclicks']."
			WHERE
				zoneid = ".$zoneid."
			GROUP BY
				zoneid, bannerid
		");
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$linkedbanners[$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$linkedbanners[$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
		}
	}
}


echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

echo "<tr height='25'>";
echo '<td height="25"><b>&nbsp;&nbsp;'.$GLOBALS['strName'].'</b></td>';
echo '<td height="25"><b>'.$GLOBALS['strID'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo "<td height='25' align='right'><b>".$GLOBALS['strViews']."</b></td>";
echo "<td height='25' align='right'><b>".$GLOBALS['strClicks']."</b></td>";
echo "<td height='25' align='right'><b>".$GLOBALS['strCTRShort']."</b>&nbsp;&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";


$totalviews = 0;
$totalclicks = 0;

if (!isset($linkedbanners) || !is_array($linkedbanners) || count($linkedbanners) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
	echo "&nbsp;&nbsp;".$strNoLinkedBanners;
	echo "</td></tr>";
	
	echo "<td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}
else
{
	$i=0;
	for (reset($linkedbanners);$key=key($linkedbanners);next($linkedbanners))
	{
		$linkedbanner = $linkedbanners[$key];
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Icon & name
		echo "<td height='25'>";
		
		if (ereg ('bannerid:'.$linkedbanner['bannerid'], $zone['what']))
			echo "&nbsp;&nbsp;<img src='images/icon-zone-linked.gif' align='absmiddle'>&nbsp;";
		else
			echo "&nbsp;&nbsp;<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
		
		echo "<a href='stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$linkedbanner['bannerid']."'>".phpAds_getBannerName($linkedbanner['bannerid'], 30, false)."</a>";
		echo "</td>";
		
		echo "<td height='25'>".$linkedbanner['bannerid']."</td>";
		echo "<td height='25' align='right'>".$linkedbanner['views']."</td>";
		echo "<td height='25' align='right'>".$linkedbanner['clicks']."</td>";
		echo "<td height='25' align='right'>".phpAds_buildCTR($linkedbanner['views'], $linkedbanner['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
		
		$totalclicks += $linkedbanner['clicks'];
		$totalviews  += $linkedbanner['views'];
	}
	
	// Total
	echo "<tr height='25'><td height='25'>&nbsp;&nbsp;<b>".$strTotal."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25' align='right'>".$totalviews."</td>";
	echo "<td height='25' align='right'>".$totalclicks."</td>";
	echo "<td height='25' align='right'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	//echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";

echo "<br><br>";

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
