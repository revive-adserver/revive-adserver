<?
/* weeklystats.php, v1.0 2000/12/29 11:06:00 Martin Braun */

require('config.php');
require('kcsm.php');
$result = db_query("
	SELECT
		*
	FROM
		".$phpAds_tbl_clients."
	WHERE
		clientID = ".$Session["clientID"]) or mysql_die();

$row = mysql_fetch_array($result);
mysql_free_result($result);

if($pageid  == 'admin')
{
	kc_auth_admin();
	page_header($GLOBALS['strWeeklyStats'].' / '.$row['clientname'] );
	show_nav('1.4.2');
}
else
{
	if($clientID != $Session['clientID'])
	{
		print($strAccessDenied);
		page_footer();
		exit();
	}
	page_header($GLOBALS['strWeeklyStats'].' / '.$row['clientname']);
	show_nav('2.2');
}

$Session["clientID"] = $clientID;

require('./weeklystats.html.php');

page_footer();
?>
