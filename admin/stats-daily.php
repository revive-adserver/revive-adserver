<?

require ("config.php");
require ("lib-statistics.inc.php");

phpAds_checkAccess(phpAds_Admin+phpAds_Client);



if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageHeader($strDailyStats);
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader($strDailyStats);
	
	$result = db_query("
		SELECT
			clientID
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $GLOBALS[bannerID]
		") or mysql_die();
	$row = mysql_fetch_array($result);
	
	if($row["clientID"] != phpAds_clientID())
	{
		phpAds_ShowNav("2.1.1");
		php_die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$clientID = phpAds_clientID();
	}
}


	$res = db_query("
		 SELECT
			*,
			count(*) as qnt,
			DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f
		 FROM
			$phpAds_tbl_adviews
		 WHERE
			bannerID = $GLOBALS[bannerID]
		 GROUP BY
			t_stamp_f
		 ORDER BY
			t_stamp DESC
		 LIMIT 7
	") or mysql_die();
	
	while ($row = mysql_fetch_array($res))
	{
		if ($day == $row[t_stamp_f])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='stats-daily.php?day=".urlencode($row["t_stamp_f"])."&clientID=$clientID&bannerID=$bannerID'>$row[t_stamp_f]</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";


if (phpAds_isUser(phpAds_Admin))
{
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=banner-client.php?clientID=$clientID>$strBannerAdmin</a><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=banner-edit.php?clientID=$clientID&bannerID=$bannerID>$strModifyBanner</a><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=banner-acl.php?clientID=$clientID&bannerID=$bannerID>$strModifyBannerAcl</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=client-edit.php?clientID=$clientID>$strModifyClient</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_ShowNav("1.4.1.1", $extra);
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_ShowNav("2.1.1", $extra);
}






// Main functions

function showHourlyStats($what)
{
	global $phpAds_db, $phpAds_url_prefix;
	$result = db_query("
		SELECT
			*,
			DATE_FORMAT(t_stamp, '$GLOBALS[time_format]') as t_stamp_f,
			DATE_FORMAT(t_stamp, '%H') as hour,
			count(*) as qnt
		FROM
			$what
		WHERE
			bannerID = $GLOBALS[bannerID]
			AND DATE_FORMAT(t_stamp, '$GLOBALS[date_format]') = '$GLOBALS[day]'
		GROUP BY 
			hour
		") or mysql_die();
	$max = 0;
	$total = 0;
	while ($row = mysql_fetch_array($result))
	{
		if ($row["qnt"] > $max)
			$max = $row["qnt"];
		$total += $row["qnt"];
	}
	@mysql_data_seek($result, 0);

	$i = 0;
	while ($row = mysql_fetch_array($result))
	{
		$bgcolor="#FFFFFF";
		$i % 2 ? 0: $bgcolor= "#F6F6F6";
		$i++;       
		?>
		<tr height='25'>
			<td bgcolor="<?print $bgcolor;?>">
				&nbsp;<? print $row["hour"];?>:00
			</td>
			<td bgcolor="<?print $bgcolor;?>" align='right'>
			    <b><?print $row["qnt"];?></b>&nbsp;&nbsp;&nbsp;
			</td>
			<td bgcolor="<?print $bgcolor;?>" align='left'>
				<img src="images/bar.gif" width="<?print ($row["qnt"]*300)/$max;?>" height="11"><img src="images/bar_off.gif" width="<?print 300-(($row["qnt"]*300)/$max);?>" height="11">
			</td>
		</tr>
		<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
		<?
	}
}


// Page HTML
?>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='4'>
  	<b><?echo $strBanner.': '.phpAds_getBannerName($bannerID);?></b>
	<img src='images/caret-rs.gif'>
	<?echo $strClientName.': '.phpAds_getClientName($clientID);?>
  </td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <tr><td colspan='4' align='left'><br><?echo phpAds_getBannerCode($bannerID);?><br><br></td></tr>
</table>

<br><br>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='3'><b><?print $strViews;?></b></td></tr>
  <tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <? showHourlyStats("$phpAds_tbl_adviews");; ?>
</table>

<br><br>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='3'><b><?print $strClicks;?></b></td></tr>
  <tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <? showHourlyStats("$phpAds_tbl_adclicks");; ?>
</table>

<br><br>

<? if (!$phpAds_compact_stats) { ?>
<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='2'><b><?print $strTopTenHosts;?></b></td></tr>
  <tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <?
    	$result = db_query("
        		SELECT
        			*,
        			count(*) as qnt
        		FROM
        			$phpAds_tbl_adviews
        		WHERE
        			bannerID = $GLOBALS[bannerID]
        			AND DATE_FORMAT(t_stamp, '$GLOBALS[date_format]') = '$GLOBALS[day]'
        		GROUP BY
        			host
        		ORDER BY
        			qnt DESC
        		LIMIT 10
        		") or mysql_die();
        
        	$i = 0;
        	while ($row = mysql_fetch_array($result))
        	{
        		$bgcolor="#FFFFFF";
        		$i % 2 ? 0: $bgcolor= "#F6F6F6";
        		$i++;
        		?>
        		<tr height='25'>
        			<td bgcolor="<?print $bgcolor;?>">
        			<?print $row["host"];?>
        			</td>
        			<td bgcolor="<?print $bgcolor;?>">
        			<b><?print $row["qnt"];?></b>
        			</td>
        		</tr>
				<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
        		<?
        	}
        }
    ?>
</table>



<?
// Footer
phpAds_PageFooter();
?>

