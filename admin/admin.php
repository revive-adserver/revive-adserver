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


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$extra = '';

if ($phpAds_compact_stats)
{
	// Determine left over verbose stats
	$viewresult = db_query("SELECT COUNT(*) AS cnt FROM $phpAds_tbl_adviews");
	$viewrow = @mysql_fetch_array($viewresult);
	$verboseviews = $viewrow["cnt"];
	
	$clickresult = db_query("SELECT COUNT(*) AS cnt FROM $phpAds_tbl_adclicks");
	$clickrow = @mysql_fetch_array($viewresult);
	$verboseclicks = $clickrow["cnt"];
	
	if ($verboseviews > 0 || $verboseclicks > 0)
	{
		// Show link to verbose stats convertor
		$extra = "<br><br>
				  <table cellspacing='1' cellpadding='0' width='140' bgcolor='#000088'><tr><td>
				  <table cellspacing='4' bgcolor='#FFFFFF'><tr>
				  <td valign='top'><img src='images/info.gif' vspace='absmiddle'></td>
				  <td valign='top'><b>Alert:</b><br>
				  You have enabled the compact statistics, but your old statistics are still 
				  in verbose format. Do you want to convert your verbose statistics to the 
				  new compact format?<br><br>
				  <a href='stats-convert.php?command=frame' target='_new'><img src='images/go_blue.gif' border='0'>&nbsp;Convert</a>
				  </td>
				  </tr></table>
				  </td></tr></table>";
	}
}

phpAds_PageHeader("$strAdminstration");
phpAds_ShowNav("1", $extra);

if (isset($message))
{
	phpAds_ShowMessage($message);
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

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



<?
	if ($selection == "") $selection = "all";

	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
	echo "<tr><td height='25' colspan='2'><b><?echo $strClients;?></b></td></tr>";
	echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	echo "<form name='client_selection' action='admin.php'>";
	echo "<tr><td height='35' colspan='2'>";
	echo "<select name='selection' onChange='this.form.submit();'>";
	
	echo "<option value='all' ".($selection=="all"?"selected":"").">$strShowAllClients</option>";
	echo "<option value='active' ".($selection=="active"?"selected":"").">$strShowClientsActive</option>";
	echo "<option value='nonactive' ".($selection=="nonactive"?"selected":"").">$strShowClientsInactive</option>";
	
	echo "</select>";
	echo "&nbsp;<a href='javascript:document.client_selection.submit();'><img src='images/go_blue.gif' border='0'></a>";
	echo "</td></tr>";
	echo "</form>";
	echo "</table>";


	echo "<br><br>";


	if ($selection == "all")
		$res_clients = db_query("SELECT clientname, clientID FROM $phpAds_tbl_clients ORDER BY clientname") or mysql_die();
	
	if ($selection == "active")
		$res_clients = db_query("SELECT $phpAds_tbl_clients.clientname, $phpAds_tbl_clients.clientID FROM $phpAds_tbl_clients, $phpAds_tbl_banners WHERE $phpAds_tbl_clients.clientID=$phpAds_tbl_banners.clientID AND $phpAds_tbl_banners.active='true' GROUP BY clientID ORDER BY clientname") or mysql_die();
	
	if ($selection == "nonactive")
		$res_clients = db_query("SELECT $phpAds_tbl_clients.clientname, $phpAds_tbl_clients.clientID FROM $phpAds_tbl_clients, $phpAds_tbl_banners WHERE $phpAds_tbl_clients.clientID=$phpAds_tbl_banners.clientID AND $phpAds_tbl_banners.active='false' GROUP BY clientID ORDER BY clientname") or mysql_die();
	
	@mysql_data_seek($res_clients, 0);


	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
	echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "<form name='client_delete' action='client-delete.php'>";
	
	$i==0;
	while ($row_clients = mysql_fetch_array($res_clients))
	{
		echo "<tr height='30' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		echo "<td height='30'>&nbsp;<input type='checkbox' name='clientID[]' value='$row_clients[clientID]'>";
		echo "&nbsp;$row_clients[clientname]</td>";	
		echo "<td height='30' align='right'><a href='client-edit.php?clientID=$row_clients[clientID]'>[ $strModifyClient ]</a>&nbsp;&nbsp;";
		echo "<a href='banner-client.php?clientID=$row_clients[clientID]'>[ $strBannerAdmin ]</a>&nbsp;&nbsp;";
		echo "<a href='stats-client.php?clientID=$row_clients[clientID]'>[ $strStats ]</a>&nbsp;&nbsp;";
		echo "</td></tr>";
				
		echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
	}
	
	echo "</form>";
	
	echo "<tr height='25'><td height='25' colspan='2'>";
	echo "<img src='images/go_blue.gif'>&nbsp;<a href=client-edit.php>$strAddClient</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<img src='images/go_blue.gif'>&nbsp;<a href='javascript:confirm_delete()'>$strDeleteClient</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
?>
</table>

<br><br><br><br>




<?
	// total number of clients
	$res_clients = db_query("SELECT * FROM $phpAds_tbl_clients ORDER BY clientname") or mysql_die();
	$res_active_clients = db_query("SELECT count(clientID) from $phpAds_tbl_clients WHERE views <> 0 or clicks <> 0");
	$res_total_banners = db_query("SELECT count(bannerID) from $phpAds_tbl_banners");
	$res_active_banners = db_query("SELECT count(bannerID) from $phpAds_tbl_banners where active='true'");
?>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='4'><b><?echo $strOverall;?></b></td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <tr><td height='25'><?echo $strTotalClients;?>: <b><?echo @mysql_numrows($res_clients);?></b></td>
      <td height='25'><?echo $strActiveClients;?>: <b><?echo @mysql_result($res_active_clients, 0, "count(clientID)");?></b></td>
      <td height='25'><?echo $strTotalBanners;?>: <b><?echo @mysql_result($res_total_banners, 0, "count(bannerID)");?></b></td>
      <td height='25'><?echo $strActiveBanners;?>: <b><?echo @mysql_result ($res_active_banners, 0, "count(bannerID)");?></b></td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

</table>   

<br><br>


<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='4'><b><?echo $strStats;?></b></td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

<?
	// total number of clients
	$adviews = db_total_views("", "day");
	$adclicks = db_total_clicks("", "day");
	if ($adviews > 0)
		$ctr = number_format($adclicks/$adviews*100,2);
	else
		$ctr="0.00";
?>

  <tr><td height='25'><?echo $strToday;?></td>
  	  <td height='25'><?echo $strViews;?>: <b><?echo $adviews;?></b></td>
      <td height='25'><?echo $strClicks;?>: <b><?echo $adclicks;?></b></td>
      <td height='25'><?echo $strCTRShort;?>: <b><?echo $ctr;?>%</b></td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>

<?
	// total number of clients
	$adviews = db_total_views("", "week");
	$adclicks = db_total_clicks("", "week");
	if ($adviews > 0)
		$ctr = number_format($adclicks/$adviews*100,2);
	else
		$ctr="0.00";
?>

  <tr><td height='25'><?echo $strThisWeek;?></td>
   	  <td height='25'><?echo $strViews;?>: <b><?echo $adviews;?></b></td>
      <td height='25'><?echo $strClicks;?>: <b><?echo $adclicks;?></b></td>
      <td height='25'><?echo $strCTRShort;?>: <b><?echo $ctr;?>%</b></td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>

<?
	// total number of clients
	$adviews = db_total_views("", "month");
	$adclicks = db_total_clicks("", "month");
	if ($adviews > 0)
		$ctr = number_format($adclicks/$adviews*100,2);
	else
		$ctr="0.00";
?>

  <tr><td height='25'><?echo $strThisMonth;?></td>
  	  <td height='25'><?echo $strViews;?>: <b><?echo $adviews;?></b></td>
      <td height='25'><?echo $strClicks;?>: <b><?echo $adclicks;?></b></td>
      <td height='25'><?echo $strCTRShort;?>: <b><?echo $ctr;?>%</b></td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>
  
  
<?
	// total number of clients
	$adviews = db_total_views();
	$adclicks = db_total_clicks();
	if ($adviews > 0)
		$ctr = number_format($adclicks/$adviews*100,2);
	else
		$ctr="0.00";
?>

  <tr><td height='25'><?echo $strOverall;?></td>
  	  <td height='25'><?echo $strViews;?>: <b><?echo $adviews;?></b></td>
      <td height='25'><?echo $strClicks;?>: <b><?echo $adclicks;?></b></td>
      <td height='25'><?echo $strCTRShort;?>: <b><?echo $ctr;?>%</b></td></tr>
  <tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  
  <tr height='25'>
	<td colspan='4' height='25'>
	<?
		if ($adclicks > 0 || $adviews > 0)
		{
			print "<img src='images/go_blue.gif'>&nbsp;<a href='stats-weekly.php?clientID=0'>$strWeeklyStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	?>
	</td>
  </tr>
</table>   

<br><br>



<?

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
