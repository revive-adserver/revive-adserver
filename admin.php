<?
// $Id$

require ("config.php");


phpAds_checkAccess(phpAds_Admin);


page_header("$strAdminstration");
show_nav("1");


function make_options($description, $onClick="")
{
	global $res_clients;
	@mysql_data_seek($res_clients, 0);
	echo "<tr>";
	echo "<td>$description:</td>";
	echo '<td><select name="clientID">';
	while ($row_clients = mysql_fetch_array($res_clients))
	{
		echo "<option value=$row_clients[clientID]>$row_clients[clientname]";
	}
	echo "</select></td>";
	
	if ($onClick)
		echo "<td><input type=submit value=\"$GLOBALS[strGo]\" onClick=\"$onClick\"></td>";
	else
		echo "<td><input type=submit value=\"$GLOBALS[strGo]\"></td>";
	echo "</tr>";
}

// total number of clients
$res_clients = db_query("SELECT * FROM $phpAds_tbl_clients ORDER BY clientname") or mysql_die();
$res_active_clients = db_query("SELECT count(clientID) from $phpAds_tbl_clients WHERE views <> 0 or clicks <> 0");
$res_active_banners = db_query("SELECT count(bannerID) from $phpAds_tbl_banners where active='true'");

$adviews = db_total_views();
$adclicks = db_total_clicks();
if ($adviews > 0)
	$ctr = number_format($adclicks/$adviews*100,2);
else
	$ctr=0;


if (isset($message))
{
	show_message($message);
}

echo "<a href=client.php>$strAddClient</a>";
?>
<script language="JavaScript">
<!--
function confirm_delete()
{
	if(confirm('<? print($strConfirmDeleteClient);?>'))
	{
		document.client_delete.submit();
	}
}
//-->
</script>

<br><br>
<table width="100%">

<form action="client.php" method="post">
<?
make_options($strModifyClient);
?>
</form>

<form action="clientdelete.php" method="post" name="client_delete">
<?
make_options($strDeleteClient, "confirm_delete(); return false;");
?>
</form>

<form action="banner.php" method="post">
<?
make_options($strBannerAdmin);
?>
</form>

<form action="clientstats.php" method="post">
<?
make_options($strViewClientStats);
?>
</form>

</table>

<br>

</td></tr>
</table></td></tr>
<tr><td>

<table border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="5" width=100%>
	<tr><td colspan="3" bgcolor="#CCCCCC"><?print $strStats;?></td></tr>
	<tr>
		<td><?print $strTotalViews;?>: <b><?print($adviews);?></b></td>
		<td><?print $strTotalClicks;?>: <b><?print($adclicks);?></b></td>
		<td><?print $strCTR;?>: <b><?print($ctr);?>%</b></td>
	</tr>
	<tr>
		<td><?print $strTotalClients;?>: <b><?print(MYSQL_NUMROWS($res_clients));?></b></td>
		<td><?print $strActiveClients;?>: <b><?print(MYSQL_RESULT($res_active_clients,0,"count(clientID)"));?></b></td>
		<td><?print $strActiveBanners;?>: <b><?print(MYSQL_RESULT($res_active_banners,0,"count(bannerID)"));?></b></td>
	</tr>
	<tr><td colspan="3"><br></td></tr>
	<tr>
		<td colspan="3" align=center>
			<form method="post" action="creditstats.php">
				<input type=Submit value="<?print $strGo;?>"><br><?print $strCreditStats;?>
			</form>
		</td>
	</tr>
	<tr><td colspan="3"><br><a href="logout.php"><?print $strLogout;?></a></td></tr>
</table>


<?
page_footer();
?>
