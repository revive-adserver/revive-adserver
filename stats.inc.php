<?
require("expiration.inc.php");
require("gd.php");
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
		    $adviews = db_total_views($row_banners["bannerID"]);
    		print "$strViews:";
		?>
		</td>
		<td bgcolor="<?echo $bgcolor;?>" width="10%"><b>
		<?
		print $adviews;
		$totaladviews += $adviews;
		?>
		</b>
		</td>
	</tr>
	<tr>
		<td bgcolor="#eeeeee" width="90%">
		<?
		    $adclicks = db_total_clicks($row_banners["bannerID"]);
    		print "$strClicks:";
		?>
		</td>
		<td bgcolor="<?echo $bgcolor;?>" width="10%"><b>
		<?
    		print $adclicks;
    		$totaladclicks += $adclicks;
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
		if ($adclicks != 0 && $adviews != 0)
		{
			$percent = 100 / ($adviews/$adclicks);
			printf(" %.2f%%", $percent);
		}
		else
			print "0.00%";
		?>
		</b>
		</td>
	</tr>      
	<tr>
		<td bgcolor="<?echo $bgcolor;?>">
		<?
		if ($adclicks > 0 || $adviews > 0)
			echo "<a href=\"detailstats.php$fncpageid&bannerID=$row_banners[bannerID]\">$strDetailStats</a>";
		?>
		</td>
		<?
		if ($adclicks > 0 || $adviews > 0)
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
if($gdimageformat != "none" && $totaladviews > 0)
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
