<?

require ("config.php");


phpAds_checkAccess(phpAds_Admin+phpAds_Client);


$result = db_query("
	SELECT
		clientID
	FROM
		$phpAds_tbl_banners
	WHERE
		bannerID = $GLOBALS[bannerID]
	") or mysql_die();
$row = mysql_fetch_array($result);


if (phpAds_isUser(phpAds_Admin))
{
	page_header();
	show_nav("1.4.1.1");
}

if (phpAds_isUser(phpAds_Client))
{
	page_header();
	show_nav("2.1.1");
	
	if($row["clientID"] != $clientID)
	{
		php_die ($strAccessDenied, $strNotAdmin);
	}
}

require("./dailystats.inc.php");

page_footer();

?>
