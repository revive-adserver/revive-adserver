<?
/* weeklystats.php, v1.0 2000/12/29 11:06:00 Martin Braun */
require ("config.php");


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
	page_header($GLOBALS['strWeeklyStats'].' / '.$row['clientname'] );
	show_nav('1.4.2');
}

if (phpAds_isUser(phpAds_Client))
{
	page_header($GLOBALS['strWeeklyStats'].' / '.$row['clientname']);
	show_nav('2.2');
	
	if($Session["clientID"] != $clientID)
	{
		php_die ($strAccessDenied, $strNotAdmin);
	}
}

require('./weeklystats.html.php');

page_footer();
?>
