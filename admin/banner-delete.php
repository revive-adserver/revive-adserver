<?

require ("config.php");


phpAds_checkAccess(phpAds_Admin);


// Test for $bannerID
if (!isset($bannerID))
{
	phpAds_PageHeader("$strBannerAdmin");
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

Header("Location: banner-client.php?clientID=$clientID&message=".urlencode($strBannerDeleted));

?>
