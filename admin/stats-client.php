<?

require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-expiration.inc.php");
require ("lib-gd.inc.php");

phpAds_checkAccess(phpAds_Admin+phpAds_Client);



if (phpAds_isUser(phpAds_Client))
{
	$clientID = $Session["clientID"];
	
	phpAds_PageHeader($strStats);
	
	$res_banners = db_query("
		SELECT
			banner,
			bannerID,
			width,
			height,
			format
		FROM
			$phpAds_tbl_banners
		WHERE
			clientID = $clientID
		") or mysql_die();
		
	phpAds_ShowNav("2");
}

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageHeader($strStats);
	
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
		
		$extra .= "<a href=stats-client.php?clientID=$row[clientID]>".phpAds_buildClientName ($row[clientID], $row[clientname])."</a>";
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
	
	phpAds_ShowNav("1.4", $extra);
}




$UpdateSession = false;

if ($compact == "")
	$compact = $Session["stats_compact"];
elseif ($compact != $Session["stats_compact"])
{
	$Session["stats_compact"] = $compact;
	$UpdateSession = true;
}

if ($view == "")
	$view = $Session["stats_view"];
elseif ($view != $Session["stats_view"])
{
	$Session["stats_view"] = $view;
	$UpdateSession = true;
}

if ($order == "")
	$order = $Session["stats_order"];
elseif ($order != $Session["stats_order"])
{
	$Session["stats_order"] = $order;
	$UpdateSession = true;
}

if ($UpdateSession == true)
	phpAds_SessionDataStore();



require("./stats-client.inc.php");

phpAds_PageFooter();
?>