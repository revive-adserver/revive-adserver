<?

require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-gd.inc.php");
require ("stats-weekly.inc.php");

phpAds_checkAccess(phpAds_Admin+phpAds_Client);



$result = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_clients
	WHERE
		clientID = $clientID
	") or mysql_die();
$row = mysql_fetch_array($result);



if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageHeader($GLOBALS['strWeeklyStats']);

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
		
		$extra .= "<a href=stats-weekly.php?clientID=$row[clientID]>".phpAds_buildClientName ($row[clientID], $row[clientname])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=banner-client.php?clientID=$clientID>$strBannerAdmin</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=client-edit.php?clientID=$clientID>$strModifyClient</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";	
	
	phpAds_ShowNav('1.4.2', $extra);
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader($GLOBALS['strWeeklyStats']);
	phpAds_ShowNav('2.2');
	
	if($Session["clientID"] != $clientID)
	{
		php_die ($strAccessDenied, $strNotAdmin);
	}
}


$res = db_query("
	SELECT
		count(*) as count
	FROM
		$phpAds_tbl_banners  
	WHERE
		clientID='$clientID'
") or mysql_die();

$row = mysql_fetch_array($res);

if ($row[count] > 0)
{
	require('./stats-weekly.html.php');
}

phpAds_PageFooter();
?>
