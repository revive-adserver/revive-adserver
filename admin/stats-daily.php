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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	$result = phpAds_dbQuery("
		SELECT
			clientid
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = $bannerid
		") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($result);
	
	if ($row["clientid"] == '' || phpAds_getUserID() != phpAds_getParentID ($row["clientid"]))
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$campaignid = $row["clientid"];
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$extra = '';

if ($phpAds_config['compact_stats']) 
{
	$res = phpAds_dbQuery("
		SELECT
			DATE_FORMAT(day, '%Y%m%d') as date,
			DATE_FORMAT(day, '$date_format') as date_formatted
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			bannerid = $bannerid
		GROUP BY
			day
		ORDER BY
			day DESC
		LIMIT 7
	") or phpAds_sqlDie();
}
else
{
	$res = phpAds_dbQuery("
		 SELECT
			DATE_FORMAT(t_stamp, '%Y%m%d') as date,
			DATE_FORMAT(t_stamp, '$date_format') as date_formatted
		 FROM
			".$phpAds_config['tbl_adviews']."
		 WHERE
			bannerid = $bannerid
		 GROUP BY
			date
		 ORDER BY
			date DESC
		 LIMIT 7
	") or phpAds_sqlDie();
}

while ($row = phpAds_dbFetchArray($res))
{
	if ($day == $row['date'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	
	$extra .= "<a href='stats-daily.php?day=".$row['date']."&campaignid=$campaignid&bannerid=$bannerid'>".$row['date_formatted']."</a>";
	$extra .= "<br>"; 
}

$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";


if (phpAds_isUser(phpAds_Admin))
{
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strCampaignProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignid=$campaignid>$strBannerOverview</a><br>";
	$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<a href=banner-edit.php?campaignid=$campaignid&bannerid=$bannerid>$strBannerProperties</a><br>";
		
	if ($phpAds_config['acl'])
	{
		$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-acl.gif' align='absmiddle'>&nbsp;<a href=banner-acl.php?campaignid=$campaignid&bannerid=$bannerid>$strModifyBannerAcl</a><br>";
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("2.1.2.1.1", $extra);
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;".phpAds_getBannerName($bannerid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;<b>".date(str_replace('%', '', $date_format), mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)))."</b><br><br>";
		echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
		phpAds_ShowSections(array("2.1.2.1.1"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.1.1.1.1", $extra);
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;".phpAds_getBannerName($bannerid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;<b>".date(str_replace('%', '', $date_format), mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)))."</b><br><br>";
		echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
		phpAds_ShowSections(array("1.1.1.1.1"));
}



/*********************************************************/
/* Show hourly statistics                                */
/*********************************************************/

if ($phpAds_config['compact_stats'])
{
	$result = phpAds_dbQuery("
		SELECT
			hour,
			SUM(views) AS views,
			SUM(clicks) AS clicks
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			bannerid = ".$bannerid."
			AND day = ".$day."
		GROUP BY 
			hour
	") or phpAds_sqlDie();
	
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$views[$row['hour']] = $row['views'];
		$clicks[$row['hour']] = $row['clicks'];
	}
}
else
{
	$begin = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)));
	$end   = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2) + 1, substr($day, 0, 4)));
	
	$result = phpAds_dbQuery("
		SELECT
			HOUR(t_stamp) AS hour,
			COUNT(*) AS qnt
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			bannerid = ".$bannerid." AND 
			t_stamp >= $begin AND t_stamp < $end
		GROUP BY 
			hour
	") or phpAds_sqlDie();
	
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$views[$row['hour']] = $row['qnt'];
	}
	
	
	$result = phpAds_dbQuery("
		SELECT
			HOUR(t_stamp) AS hour,
			COUNT(*) AS qnt
		FROM
			".$phpAds_config['tbl_adclicks']."
		WHERE
			bannerid = ".$bannerid." AND 
			t_stamp >= $begin AND t_stamp < $end
		GROUP BY 
			hour
	") or phpAds_sqlDie();
	
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$clicks[$row['hour']] = $row['qnt'];
	}
}




/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br><br>";




echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr bgcolor='#FFFFFF' height='25'>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strHour</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strViews</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strClicks</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strCTRShort</b>&nbsp;&nbsp;</td>";
echo "</tr>";

echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

for ($i=0; $i<24; $i++)
{
	$bgcolor = ($i % 2 ? "#FFFFFF": "#F6F6F6");
	
	if (isset($views[$i]))
	{
		$ctr = phpAds_buildCTR($views[$i], $clicks[$i]);
		$totalviews += $views[$i];
	}
	else
	{
		$ctr = '-';
		$views[$i] = '-';
	}
	
	if (isset($clicks[$i]))
		$totalclicks += $clicks[$i];
	else
		$clicks[$i] = '-';
	
	echo "<tr>";
	echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$i.":00 - ".$i.":59</td>";
	echo "<td height='25' bgcolor='$bgcolor'>".$views[$i]."</td>";
	echo "<td height='25' bgcolor='$bgcolor'>".$clicks[$i]."</td>";
	echo "<td height='25' bgcolor='$bgcolor'>".$ctr."</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

if ($totalviews > 0 || $totalclicks > 0)
{
	echo "<tr>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
	echo "<td height='25'>".$totalviews."</td>";
	echo "<td height='25'>".$totalclicks."</td>";
	echo "<td height='25'>".phpAds_buildCTR($totalviews, $totalclicks)."</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "<tr>";
	echo "<td height='25'>&nbsp;<b>$strAverage</b></td>";
	echo "<td height='25'>".number_format (($totalviews / 24), $phpAds_config['percentage_decimals'])."</td>";
	echo "<td height='25'>".number_format (($totalclicks / 24), $phpAds_config['percentage_decimals'])."</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";
?>

<br><br>
<br><br>

<?php if (!$phpAds_config['compact_stats']) { ?>
<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='2'><b><?php print $strTopTenHosts;?></b></td></tr>
  <tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <?php
    	$result = phpAds_dbQuery("
        		SELECT
        			host,
        			COUNT(*) AS qnt
        		FROM
        			".$phpAds_config['tbl_adviews']."
        		WHERE
        			bannerid = $bannerid AND
					t_stamp >= $begin AND t_stamp < $end
        		GROUP BY
        			host
        		ORDER BY
        			qnt DESC
        		LIMIT 10
        		") or phpAds_sqlDie();
        
        	$i = 0;
        	while ($row = phpAds_dbFetchArray($result))
        	{
        		$bgcolor="#FFFFFF";
        		$i % 2 ? 0: $bgcolor= "#F6F6F6";
        		$i++;
        		?>
        		<tr>
        			<td height='25' bgcolor="<?php print $bgcolor;?>">
        			&nbsp;<?php print $row["host"];?>
        			</td>
        			<td height='25' bgcolor="<?php print $bgcolor;?>">
        			<b><?php print $row["qnt"];?></b>
        			</td>
        		</tr>
				<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
        		<?php
        	}
        }
    ?>
</table>

<br><br>

<?php

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

