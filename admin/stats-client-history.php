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
require ("lib-statistics.inc.php");

// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	$clientid = phpAds_getUserID();
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$extra = '';

if (phpAds_isUser(phpAds_Admin))
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = 0
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($clientid == $row['clientid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='stats-client-history.php?clientid=".$row['clientid']."'>";
		$extra .= phpAds_buildClientName ($row['clientid'], $row['clientname']);
		$extra .= "</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=$clientid>$strClientProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("2.1.1", $extra);
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.1.1"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.2", $extra);
	phpAds_ShowSections(array("1.1", "1.2"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$idresult = phpAds_dbQuery ("
	SELECT
		b.bannerid
	FROM
		".$phpAds_config['tbl_banners']." AS b,
		".$phpAds_config['tbl_clients']." AS c
	WHERE
		c.parent = $clientid AND
		c.clientid = b.clientid
");

if (phpAds_dbNumRows($idresult) > 0)
{
	while ($row = phpAds_dbFetchArray($idresult))
	{
		$bannerids[] = "bannerid = ".$row['bannerid'];
	}
	
	$lib_history_where     = "(".implode(' OR ', $bannerids).")";
	$lib_history_params    = array ('clientid' => $clientid);
	
	include ("lib-history.inc.php");
}



/*********************************************************/
/* Maintenance                                           */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	echo "<br><br><br>";
	
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
	echo "<tr><td height='25'><b>$strMaintenance</b></td></tr>";
  	echo "<tr><td height='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "<tr><td height='35'>";
	echo "<img src='images/icon-mail.gif' align='absmiddle'>&nbsp;";
	echo $strSendAdvertisingReport;
	echo "</td></tr>";
	
	echo "<tr><td height='25'>";
	echo "<form method='get' action='client-mailreport.php'>";
	echo "<input type='hidden' name='clientid' value='$clientid'>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$strFrom&nbsp;&nbsp;";
	
	// Starting date
	echo "<select name='startday'>\n";
	echo "<option value='' selected>-</option>\n";
	for ($i=1;$i<=31;$i++)
		echo "<option value='$i'>$i</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='startmonth'>\n";
	echo "<option value='' selected>-</option>\n";
	for ($i=1;$i<=12;$i++)
		echo "<option value='$i'>".$strMonth[$i-1]."</option>\n";
	echo "</select>&nbsp;\n";
	
	$end = date('Y');
	
	echo "<select name='startyear'>\n";
	echo "<option value='' selected>-</option>\n";
	for ($i=date('Y')-4;$i<=date('Y');$i++)
		echo "<option value='$i'>$i</option>\n";
	echo "</select>\n";	
	
	// To
	echo "&nbsp;$strTo&nbsp;&nbsp;";
	
	// End date
	echo "<select name='endday'>\n";
	for ($i=1;$i<=31;$i++)
		echo "<option value='$i'".($i == date('d') ? ' selected' : '').">$i</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='endmonth'>\n";
	for ($i=1;$i<=12;$i++)
		echo "<option value='$i'".($i == date('m') ? ' selected' : '').">".$strMonth[$i-1]."</option>\n";
	echo "</select>&nbsp;\n";
	
	$end = date('Y');
	
	echo "<select name='endyear'>\n";
	for ($i=date('Y')-4;$i<=date('Y');$i++)
		echo "<option value='$i'".($i == date('Y') ? ' selected' : '').">$i</option>\n";
	echo "</select>\n";	
	
	echo "&nbsp;";
	echo "<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'>";
	
	echo "</form>";
	
	echo "</td></tr>";
  	echo "<tr><td height='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	// Reset statistics
	echo "<tr><td height='25'>";
	echo "<a href='stats-reset.php?clientid=$clientid'".phpAds_DelConfirm($strConfirmResetClientStats).">";
	echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' align='absmiddle' border='0'>&nbsp;$strResetStats</a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
	
	echo "</table>";
}




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
