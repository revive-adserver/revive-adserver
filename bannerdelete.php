<?
require ("config.php");
require("kcsm.php");

kc_auth_admin();

// Test for $bannerID
if (!isset($bannerID))
{
	php_die("hu?", "Where is my ID? I've lost my ID! Moooommmeee... I want my ID back!");
}

db_query("
	DELETE FROM
		$phpAds_tbl_banners
	WHERE
		bannerID = $bannerID
	") or mysql_die();

db_query("
	DELETE FROM
		$phpAds_tbl_acls
	WHERE
		bannerID = $bannerID
	") or mysql_die();

db_delete_stats($bannerID);

Header("Location: banner.php$fncpageid&message=".urlencode($strBannerDeleted));
?>
