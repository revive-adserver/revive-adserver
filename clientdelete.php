<?

require ("config.php");
require("kcsm.php");

kc_auth_admin();

// Delete that client
if (isset($clientID))
{
	$foo = mysql_db_query($phpAds_db, "
		DELETE FROM
			$phpAds_tbl_clients
		WHERE
			clientID = $clientID
		") or mysql_die();
	$res_banners = mysql_db_query($phpAds_db, "
		SELECT
			bannerID
		FROM
			$phpAds_tbl_banners
		WHERE
			clientID = $clientID
		") or mysql_die();
	while ($row = mysql_fetch_array($res_banners))
	{
		$foo = mysql_db_query($phpAds_db, "
			DELETE FROM
				$phpAds_tbl_adviews 
			WHERE
				bannerID = " . $row["bannerID"]
			) or mysql_die();

		$foo = mysql_db_query($phpAds_db, "
			DELETE FROM
				$phpAds_tbl_adclicks
			WHERE
				bannerID = " . $row["bannerID"]
			) or mysql_die();

		$foo = mysql_db_query($phpAds_db, "
			DELETE FROM
				$phpAds_tbl_acls
			WHERE
				bannerID = " . $row["bannerID"]
			) or mysql_die();
	}

	$foo = mysql_db_query($phpAds_db, "
		DELETE FROM
			$phpAds_tbl_banners
		WHERE
			clientID = $clientID
		") or mysql_die();
	Header("Location: admin.php$fncpageid&message=".urlencode($strClientDeleted));
}  
else
{

}
?>
