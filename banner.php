<?

require ("config.php");


phpAds_checkAccess(phpAds_Admin);


page_header("$strBannerAdmin");
show_nav("1.3");


if (isset($message))
	show_message($message);


if($clientID == "") $clientID = 0;


$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_banners  
	WHERE
		clientID = $clientID
	") or mysql_die();


?>
	<p><a href="banneradd.php?clientID=<? echo $clientID; ?>"><?echo $strAddBanner;?></a></p>
	<b><?echo $strClientID;?>: <? echo $clientID; ?></b>



<?
if (mysql_num_rows($res) == 0)
{
	echo "$strNoBanners<br>";
}
else
{
?>
<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td bgcolor=#99999>
<table width="100%" cellpadding=3 cellspacing=1 border=0>
<?
	$i = 0;
	while ($row = mysql_fetch_array($res))
	{
		$bgcolor="#F7F7F7";
		$i % 2 ? 0: $bgcolor= "#ECECFF";
		$i++;
?>
	<tr>
		<td colspan=6 bgcolor="<?echo $bgcolor;?>" align="center">
<?
		if ($row["format"] == "html")
		{
			echo $row["banner"];
		}       
		elseif ($row["format"] == "url")
		{
			echo "<img src=\"$row[banner]\" width=$row[width] height=$row[height] alt=\"$row[alt]\" border=0>";		
		}
		else
		{
			echo "<img src=\"./viewbanner.php?bannerID=$row[bannerID]\" width=$row[width] height=$row[height] alt=\"$row[alt]\" border=0>";
		}
		if (!$row["bannertext"] == "")
			echo "<BR>".$row["bannertext"];
?>
		</td>
	</tr>
<?
		if (!empty($row["keyword"]))
		{
?>
	<tr>
		<td colspan=4 bgcolor="<?echo $bgcolor;?>" align="Left">
			<b><?echo $strKeyword;?>:</b> <em><?echo $row["keyword"];?></em>
		</td>
		<td colspan=2 bgcolor="<?echo $bgcolor;?>" align="Left">
			<b><?echo $strWeight;?>:</b> <em><?echo $row["weight"];?></em>
		</td>
	</tr>
<?
		}
?>
	<tr>
		<td bgcolor="<?echo $bgcolor;?>">
			<?echo $row["bannerID"];?>
		</td>
		<td bgcolor="<?echo $bgcolor;?>">
			<?echo $row["url"];?>&nbsp;
		</td>
		<td bgcolor="<?echo $bgcolor;?>">
			<a href="banneractivate.php?clientID=<?echo $clientID;?>&bannerID=<?echo $row["bannerID"];?>&value=<?echo $row["active"];?>">
<?
		if ($row["active"] == "true")
			echo $strDeActivate;
		else
			echo $strActivate;
?>
			</a>
		</td>
		<td bgcolor="<?echo $bgcolor;?>">
			<a href="bannerdelete.php?clientID=<?echo $clientID;?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strDelete;?></a>
		</td>
		<td bgcolor="<?echo $bgcolor;?>">
			<a href="banneradd.php?clientID=<?echo $clientID;?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strModifyBanner;?></a>
		</td>
		<td bgcolor="<?echo $bgcolor;?>">
			<a href="banneracl.php?clientID=<?echo $clientID;?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strModifyBannerAcl;?></a>
		</td>
	</tr>
	<tr>
		<td colspan=6 bgcolor='#FFFFFF'>&nbsp;</td>
	</tr>
<?
	}
?>
	</table></td></tr>
</table>
<?
}

page_footer();
?>
