// $Id$

<?
if (isset($pageid) && $pageid =="client")
{
	Header("Location: ./index.php");
	exit;
}
if (!isset($pageid))
{
	$pageid = "admin";
}

require ("config.php");
require("kcsm.php");

kc_auth_admin();

page_header("$strAdminstration");
show_nav("1");

unset($Session["clientID"]);

function make_options($description)
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
	echo "<td><input type=submit value=\"$GLOBALS[strGo]\"></td>";
	echo "</tr>";
}

// total number of clients
$res_clients = db_query("SELECT * FROM $phpAds_tbl_clients ORDER BY clientname") or mysql_die();
$res_active_clients = db_query("SELECT count(clientID) from $phpAds_tbl_clients WHERE views <> 0 or clicks <> 0");
$res_active_banners = db_query("SELECT count(bannerID) from $phpAds_tbl_banners where active='true'");

$res_tot_adviews = db_query("SELECT count(*) as qnt FROM $phpAds_tbl_adviews") or mysql_die();
$res_tot_adclicks = db_query("SELECT count(*) as qnt FROM $phpAds_tbl_adclicks") or mysql_die();
$row_tot_adviews = mysql_fetch_array($res_tot_adviews);
$row_tot_adclicks = mysql_fetch_array($res_tot_adclicks);
$adviews = $row_tot_adviews["qnt"];
$adclicks = $row_tot_adclicks["qnt"];
if ($adviews > 0)
	$ctr = number_format($adclicks/$adviews*100,2);
else
	$ctr=0;


if (isset($message))
{
	show_message($message);
}

echo "<a href=client.php?pageid=$pageid>$strAddClient</a>";
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
<form action="client.php" method="post">
	<input type="hidden" name="pageid" value="<? echo ($pageid) ?>">
<table width="100%">
<?
make_options($strModifyClient);
?>
</form>

<form action="clientdelete.php" method="post" name="client_delete">
	<input type="hidden" name="pageid" value="<? echo ($pageid) ?>">
<?
	@mysql_data_seek($res_clients, 0);
	echo "<tr>";
	echo "<td>$strDeleteClient:</td>";
	echo '<td><select name="clientID">';
	while ($row_clients = mysql_fetch_array($res_clients))
	{
		echo "<option value=$row_clients[clientID]>$row_clients[clientname]";
	}
	echo "</select></td>";
	echo "<td><input type=submit value=\"$GLOBALS[strGo]\" onClick=\"confirm_delete(); return false;\"></td>";
	echo "</tr>";
?>
</form>

<form action="banner.php" method="post">
 <input type="hidden" name="pageid" value="<? echo ($pageid) ?>">
<?
make_options($strBannerAdmin);
?>
</form>

<form action="clientstats.php" method="post">
 <input type="hidden" name="pageid" value="<? echo ($pageid) ?>">
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
		<td colspan="3" align=center><form method="post" action="creditstats.php"><input type=hidden name=pageid value=<?print $pageid;?>><input type=Submit value="<?print $strGo;?>"><br><?print $strCreditStats;?></form></td>
	</tr>
	<tr><td colspan="3"><br><a href="logout.php"><?print $strLogout;?></a></td></tr>
</table>


<?
page_footer();
?>
