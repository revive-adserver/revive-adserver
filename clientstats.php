<?

require ("config.php");


phpAds_checkAccess(phpAds_Admin+phpAds_Client);


if (phpAds_isUser(phpAds_Client))
{
	$clientID = $Session["clientID"];
}


page_header($strStats);
show_nav("1.4");

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
	") or mysql_die() ;

require("./stats.inc.php");

page_footer();
?>
