<?
require ("config.php");


phpAds_checkAccess(phpAds_Admin+phpAds_Client);


if (phpAds_isUser(phpAds_Admin))
{
	Header("Location: ./admin.php");
	exit;
}

if (phpAds_isUser(phpAds_Client))
{
	$clientID = $Session[clientID];
	
	page_header();
	show_nav("2");
	
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
	
	require("./stats.inc.php");
	page_footer();
}
?>
