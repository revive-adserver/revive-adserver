<?

require ("config.php");
require("kcsm.php");

kc_auth_admin();

page_header("$strBannerAdmin");   
show_nav("1.3");

unset($Session["bannerID"]);
if (isset($message))
	show_message($message);
if (isset($clientID) && !empty($clientID))
	$Session["clientID"] = $clientID;
elseif(!isset($Session["clientID"]) || empty($Session["clientID"]))
	$Session["clientID"] = 0;
$res = mysql_db_query($phpAds_db, "
	SELECT
		*
	FROM
		$phpAds_tbl_banners  
	WHERE
		clientID = $Session[clientID]
	") or mysql_die();
?>
	<p><a href="banneradd.php<? echo ($fncpageid) ?>"><?echo $strAddBanner;?></a></p><B><?echo $strClientID;?>: <? echo ($Session["clientID"]) ?></b>
</b>
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
			<b><?echo $strKeyword;?>:</b> <em>
			<?echo $row["keyword"];?>
			</em>
		</td>
                <td colspan=2 bgcolor="<?echo $bgcolor;?>" align="Left">
			<b><?echo $strWeight;?>:</b> <em>
			<?echo $row["weight"];?>
			</em>
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
			<a href="banneractivate.php<? echo ($fncpageid) ?>&bannerID=<?echo $row["bannerID"];?>&value=<?echo $row["active"];?>">
<?
		if ($row["active"] == "true")
			echo $strDeActivate;
		else
			echo $strActivate;
?>
			</a>
		</td>
		<td bgcolor="<?echo $bgcolor;?>">
			<a href="bannerdelete.php<? echo ($fncpageid) ?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strDelete;?></a>
		</td>
		<td bgcolor="<?echo $bgcolor;?>">
			<a href="banneradd.php<? echo ($fncpageid) ?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strModifyBanner;?></a>
		</td>
		<td bgcolor="<?echo $bgcolor;?>">
			<a href="banneracl.php<? echo ($fncpageid) ?>&bannerID=<?echo $row["bannerID"];?>"><?echo $strModifyBannerAcl;?></a>
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
