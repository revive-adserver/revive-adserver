<?

require ("config.php");


phpAds_checkAccess(phpAds_Admin);


if ($value == "true")
	$value = "false";
else
	$value = "true";

$res = db_query("
	UPDATE
		$phpAds_tbl_banners
	SET
		active = '$value'
	WHERE
		bannerID = $bannerID
	") or mysql_die();

Header("Location: banner.php?clientID=$clientID&message=".urlencode($strBannerChanged));

?>
