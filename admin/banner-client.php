<?

require ("config.php");
require ("lib-statistics.inc.php");



phpAds_checkAccess(phpAds_Admin);
phpAds_PageHeader("$strBannerAdmin");

if($clientID == "") $clientID = 0;



$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_clients  
	") or mysql_die();
	
while ($row = mysql_fetch_array($res))
{
	if ($clientID == $row[clientID])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	
	$extra .= "<a href=banner-client.php?clientID=$row[clientID]>".phpAds_buildClientName ($row[clientID], $row[clientname])."</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

$extra .= "<br><br><br><br><br>";
$extra .= "<b>$strShortcuts</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=client-edit.php?clientID=$clientID>$strModifyClient</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=stats-client.php?clientID=$clientID>$strStats</a><br>";
$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=stats-weekly.php?clientID=$clientID>$strWeeklyStats</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

phpAds_ShowNav("1.3", $extra);


if (isset($message))
	phpAds_ShowMessage($message);






$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_banners  
	WHERE
		clientID = $clientID
	") or mysql_die();


?>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='2'><b><?echo $strClientName.': '.phpAds_getClientName($clientID);?></b></td></tr>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='25' colspan='2'>
		<img src='images/go_blue.gif'>&nbsp;<a href='banner-edit.php?clientID=<? echo $clientID; ?>'><?echo $strAddBanner;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
	</td></tr>
</table>


<br><br>



<?
if (mysql_num_rows($res) == 0)
{
	echo "$strNoBanners<br>";
}
else
{
?>
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<?
	$i = 0;
	while ($row = mysql_fetch_array($res))
	{
		$bgcolor="#F6F6F6";
		$i % 2 ? 0: $bgcolor= "#F6F6F6";
		$i++;
?>
	<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='10' colspan='4' bgcolor='<?echo $bgcolor;?>'>&nbsp;</td></tr>
	<tr>
	   <td bgcolor='<?echo $bgcolor;?>' colspan='4' align='center'>
	   	  <?echo phpAds_buildBannerCode ($row[bannerID], $row[banner], $row[active], $row[format], $row[width], $row[height], $row[bannertext]);?>
	   </td>
	</tr>
	<tr><td height='10' colspan='4' bgcolor='<?echo $bgcolor;?>'>&nbsp;</td></tr>
	<tr>
		<td height='25' bgcolor="<?echo $bgcolor;?>" align="Left">
			&nbsp;<?echo $strID;?>: <b><?echo $row["bannerID"];?></b>
		</td>
		<td height='25' bgcolor="<?echo $bgcolor;?>" align="Left">
			<?echo $strWeight;?>: <b><?echo $row["weight"];?></b>
		</td>
		<td height='25' bgcolor="<?echo $bgcolor;?>" align="Left">
			<?echo $strKeyword;?>: <b><?echo $row["keyword"];?></b>
		</td>
		<td height='25' bgcolor="<?echo $bgcolor;?>" align="Left">
			<?echo $row["url"];?>
		</td>
	</tr>
	<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='25' colspan='4'>
			<img src='images/go_blue.gif'>&nbsp;<a href="banner-activate.php?clientID=<?echo $clientID;?>&bannerID=<?echo $row["bannerID"];?>&value=<?echo $row["active"];?>">
<?
		if ($row["active"] == "true")
			echo $strDeActivate;
		else
			echo $strActivate;
?>
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<img src='images/go_blue.gif'>&nbsp;<a href="banner-delete.php?clientID=<?echo $clientID;?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strDelete;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<img src='images/go_blue.gif'>&nbsp;<a href="banner-edit.php?clientID=<?echo $clientID;?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strModifyBanner;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<img src='images/go_blue.gif'>&nbsp;<a href="banner-acl.php?clientID=<?echo $clientID;?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strModifyBannerAcl;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
	<tr>
		<td height='35' colspan=4 bgcolor='#FFFFFF'>&nbsp;</td>
	</tr>
<?
	}
?>
</table>
<br>	
<?
}

phpAds_PageFooter();
?>
