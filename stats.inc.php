<?
require("expiration.inc.php");
$i = 0;

?>
<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td bgcolor=#99999>
<table width="100%" cellpadding=3 cellspacing=1 border=0>
<?
$totaladviews = 0;
$totaladclicks = 0;
$where = "";

while ($row_banners = mysql_fetch_array($res_banners))
{
	$where .= " bannerID = $row_banners[bannerID] OR";
	$bgcolor="#F7F7F7";
	$i % 2 ? 0: $bgcolor= "#ECECFF";
	$i++;
	?>
	<tr>
		<td colspan="2" bgcolor="<?echo $bgcolor;?>" width="100%">
		<?
		if ($row_banners["format"] == "html")
			print htmlspecialchars(stripslashes($row_banners["banner"]));
		else
			print "<p><img src=\"./viewbanner.php$fncpageid&bannerID=$row_banners[bannerID]\" width=$row_banners[width] height=$row_banners[height]>";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor="#eeeeee" width="90%">
		<?
		$res_adviews = db_query("
			SELECT
				count(*) as qnt
			FROM
				$phpAds_tbl_adviews
			WHERE
				bannerID = $row_banners[bannerID]
			") or mysql_die();
		$row_adviews = mysql_fetch_array($res_adviews);                 
		print "$strViews:";
		?>
		</td>
		<td bgcolor="<?echo $bgcolor;?>" width="10%"><b>
		<?
		print $row_adviews["qnt"];
		$totaladviews += $row_adviews["qnt"];
		?>
		</b>
		</td>
	</tr>
	<tr>
		<td bgcolor="#eeeeee" width="90%">
		<?
		$res_adclicks = db_query("
			SELECT
				count(*) as qnt
			FROM
				$phpAds_tbl_adclicks
			WHERE
				bannerID = $row_banners[bannerID]
			") or mysql_die();
		$row_adclicks = mysql_fetch_array($res_adclicks);
		print "$strClicks:";
		?>
		</td>
		<td bgcolor="<?echo $bgcolor;?>" width="10%"><b>
		<?
		print $row_adclicks["qnt"];
		$totaladclicks += $row_adclicks["qnt"];
		?>
		</b>
		</td>
	</tr>
	<tr>
		<td bgcolor="#eeeeee" width="90%">
		<?
		print "$strRatio:";
		?>
		</td>
		<td bgcolor="<?echo $bgcolor;?>" width="10%"><b>
		<?
		if ($row_adclicks["qnt"] != 0 && $row_adviews["qnt"] != 0)
		{
			$percent = 100 / ($row_adviews["qnt"]/$row_adclicks["qnt"]);
			printf(" %.2f%%", $percent);
		}
		else
			print "0%";
		?>
		</b>
		</td>
	</tr>      
	<tr>
		<td bgcolor="<?echo $bgcolor;?>">
		<?
		if ($row_adclicks["qnt"] > 0 || $row_adviews["qnt"] > 0)
			echo "<a href=\"detailstats.php$fncpageid&bannerID=$row_banners[bannerID]\">$strDetailStats</a>";
		?>
		</td>
		<?
		if ($row_adclicks["qnt"] > 0 || $row_adviews["qnt"] > 0)
		{
			?>
			<form action="resetstats.php" method="post" name="client_reset">
			<input type="hidden" name="pageid" value="<? print $pageid; ?>">
			<input type="hidden" name="bannerID" value="<? print $row_banners[bannerID]; ?>">
			<td bgcolor="<?echo $bgcolor;?>">
			<?print "<input type=submit value=\"$strResetStats\" onClick=\"return confirm('$strConfirm')\">\n";?>
			</td>
			</form>
			<?
		}
		?>
	</tr>
	<?
}
?>
	<tr>
		<td bgcolor="#CCCCCC" width="90%"><?echo $strTotalViews;?>:</td>
		<td bgcolor="#CCCCCC" width="10%"><b><?echo $totaladviews;?></b></td>
	</tr>
	<tr>
		<td bgcolor="#CCCCCC" width="90%"><?echo $strTotalClicks;?>:</td>
		<td bgcolor="#CCCCCC" width="10%"><b><?echo $totaladclicks;?></b></td>
	</tr>
<?
if(function_exists("imagegif") && $totaladviews > 0)
{
?>
	<tr>
		<td bgcolor="#CCCCCC" colspan=2 width="90%" align="center"><img  src="sphourly.php?where=<?$where = ereg_replace("OR$", "", $where); echo urlencode("$where");?>" border="0" width="385" height="150"></td>
	</tr>
<?
}
list($desc,$enddate,$daysleft)=days_left($clientID);
?>
	<tr>
		<td bgcolor="#CCCCCC"><? echo $desc; ?></td>
		<td bgcolor="#CCCCCC">
<?
if ($totaladclicks > 0 || $totaladviews > 0)
{
	print "<a href=\"weeklystats.php$fncpageid&clientID=$clientID\">$strWeeklyStats</a>";
}
?>
		</td>
	</tr>
</table>
</td></tr>
</table>
<a href=logout.php>Logout</a>
