<?

require ("config.php");
require("kcsm.php");
require("expiration.inc.php");

page_header($strStats);
show_nav("1.6");

print "<CENTER>Client name begins with : ";
for ($x=0;$x<26;$x=$x+1)
{
	$num_other_clients_query=$num_other_clients_query."clientname NOT LIKE \"".chr($x+65)."%\" AND clientname NOT like \"".chr($x+97)."%\" AND ";
	$res_num_clients = mysql_db_query($phpAds_db, "SELECT count(clientID) FROM $phpAds_tbl_clients where clientname like \"".chr($x+65)."%\" or clientname like \"".chr($x+97)."%\"") or mysql_die();
	if ($res_num_clients && MYSQL_RESULT($res_num_clients,0,"count(clientID)") > 0)
		print "<A HREF=$PHP_SELF?pageid=$pageid&startletter=".chr($x+97).">".chr($x+97)."</A> ";
	else
		print chr($x+97)." ";
}
$num_other_clients_query=substr($num_other_clients_query,0,strlen($num_other_clients_query)-4);
$num_other_clients_query_complete="SELECT count(clientID) FROM $phpAds_tbl_clients WHERE ".$num_other_clients_query;
$res_num_other_clients = mysql_db_query($phpAds_db, $num_other_clients_query_complete);
if ($res_num_other_clients && MYSQL_RESULT($res_num_other_clients,0,"count(clientID)") > 0)
	print "<A HREF=$PHP_SELF?pageid=$pageid&startletter=other>Other</A>";
else
	print "Other";


print "</CENTER><BR>\n";

$client_query="
	SELECT
		clientID,
		clientname,
		contact,
		email,
		views,
		clicks,
		expire
	FROM
		$phpAds_tbl_clients";
if (isset($startletter) && strlen($startletter)>0)
{
	if ($startletter=="other")
		$client_query=$client_query." WHERE ".$num_other_clients_query;
	else
		$client_query=$client_query." WHERE clientname like \"".strtolower($startletter)."%\" or clientname like \"".strtoupper($startletter)."%\"";
} else
{
	$client_query=$client_query."
	WHERE clientname like \"a%\" or clientname like \"A%\"";
}
$client_query=$client_query."
	ORDER BY
		clientID";
$res_clients = mysql_db_query($phpAds_db, $client_query) or mysql_die() ;

?>
<table width="100%" cellpadding=3 cellspacing=1 border=0>
<?
while ($row_clients = mysql_fetch_array($res_clients))
{
	$total_adviews=0;
	$total_adclicks=0;
	$highID=$row_clients[clientID];
?>
	<tr>
		<td colspan="2" bgcolor="#CCCCCC"><?print $row_clients[clientname];?></td>
		<td colspan=2 bgcolor="#CCCCCC"><?print $strContact.": ";
		if (strlen($row_clients[contact])==0)
			print "None";
		else
			print "<A HREF=mailto:$row_clients[email]>$row_clients[contact]</a>";
		?>
		</td>
	</tr>
	<?
	$res_banners = mysql_db_query($phpAds_db, "
		SELECT
			bannerID,
			banner,
			active,
			weight,
			format,
			width,
			height
		FROM
			$phpAds_tbl_banners
		WHERE
			clientID = $row_clients[clientID]
		") or mysql_die();
	while ($row_banners = mysql_fetch_array($res_banners)) 
	{
	?>
	<tr>
		<td colspan="2" bgcolor="#eeeeee">
		<?
		if ($row_banners["format"] == "html")
			print $row_banners["banner"];
		else
			print "<img src=\"./viewbanner.php$fncpageid&bannerID=$row_banners[bannerID]\" width=$row_banners[width] height=$row_banners[height]>";
		?>
		</td>
		<td bgcolor="#eeeeee"><?print $strViews;?>: 
		<?
		$res_adviews = mysql_db_query($phpAds_db, "
			SELECT
				count(bannerID)
			FROM
				$phpAds_tbl_adviews
			WHERE
				bannerID = $row_banners[bannerID]
			") or mysql_die();
		print MYSQL_RESULT($res_adviews,0,"count(bannerID)");
		$total_adviews=$total_adviews+MYSQL_RESULT($res_adviews,0,"count(bannerID)");
		?>
		</td>
		<td bgcolor="#eeeeee"><?print $strClicks;?>:
		<?
		$res_adclicks = mysql_db_query($phpAds_db, "
			SELECT
				count(bannerID)
			FROM
				$phpAds_tbl_adclicks
			WHERE
				bannerID = $row_banners[bannerID]
			") or mysql_die();
		print MYSQL_RESULT($res_adclicks,0,"count(bannerID)");
		$total_adclicks=$total_adclicks+MYSQL_RESULT($res_adclicks,0,"count(bannerID)");
		?>
		</td>
	</tr>
	<?
	}
	?>
	<tr>
		<td width=25% bgcolor="#CCCCCC"><?print $strTotalViews;?>: <?print $total_adviews;?></td>
		<td width=25% bgcolor="#CCCCCC"><?print $strViewCredits;?>: <?if ($row_clients[views]!=-1)print $row_clients[views];else print "Unlimited";?></td>
		<td width=25% bgcolor="#CCCCCC"><?print $strTotalClicks;?>: <?print $total_adclicks;?></td>
		<td width=25% bgcolor="#CCCCCC"><?print $strClickCredits;?>: <?if ($row_clients[clicks]!=-1)print $row_clients[clicks];else print "Unlimited";?></td>
	</tr>
	<?
	if ($row_clients[views]!=-1 || $row_clients[clicks]!=-1)
	{
	?>
	<tr>
		<td colspan=2 bgcolor="#CCCCCC" align="center">
		<?
		if ($row_clients[views]==-1)
			print "&nbsp;";
		else
			print "<img src=graph.php?width=200&data=Views^$total_adviews^^Credits^$row_clients[views]^^></td>\n";
		print "<td colspan=2 bgcolor=\"#CCCCCC\" align=\"center\">";
		if ($row_clients[clicks]==-1)
			print "&nbsp;";
		else
			print "<img src=graph.php?width=200&data=Clicks^$total_adclicks^^Credits^$row_clients[clicks]^^></td>\n";
		?>
	</tr>
	<?
	}
	list($desc,$enddate,$daysleft)=days_left($row_clients["clientID"]);
	?>
	<tr>
		<td colspan="4" bgcolor="#CCCCCC"><? echo $desc; ?></td>
	</tr>
	<tr><td><br></td></tr>
	<?
}
?>
</table>
</td></tr>
</table>
<?    
page_footer();
?>
