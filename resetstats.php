<?

require ("config.php");
require("kcsm.php");

kc_auth_admin();

if (isset($bannerID))
{
	$res=MYSQL_DB_QUERY($phpAds_db, "
		DELETE FROM
			$phpAds_tbl_adviews
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	$res=MYSQL_DB_QUERY($phpAds_db, "
		DELETE FROM
			$phpAds_tbl_adclicks
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	Header("Location: clientstats.php$fncpageid");
}  
else
{
}
?>
