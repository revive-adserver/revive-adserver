<?
require ("config.php");
require("kcsm.php");

kc_auth_admin();

// Test for $bannerID
if (!isset($bannerID))
{
	php_die("hu?", "Where is my ID? I've lost my ID! Moooommmeee... I want my ID back!");
}

$res = db_query("
	DELETE FROM
		$phpAds_tbl_banners
	WHERE
		bannerID = $bannerID
	") or mysql_die();

$res = db_query("
	DELETE FROM
		$phpAds_tbl_adviews 
	WHERE
		bannerID = $bannerID
	") or mysql_die();

$res = db_query("
	DELETE FROM
		$phpAds_tbl_adclicks
	WHERE
		bannerID = $bannerID
	") or mysql_die();
$res = db_query("
	DELETE FROM
		$phpAds_tbl_acls
	WHERE
		bannerID = $bannerID
	") or mysql_die();
Header("Location: banner.php$fncpageid&message=".urlencode($strBannerDeleted));
?>
