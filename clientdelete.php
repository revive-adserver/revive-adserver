<?

require ("config.php");


phpAds_checkAccess(phpAds_Admin);


// Delete that client
if (isset($clientID))
{
	$foo = db_query("
		DELETE FROM
			$phpAds_tbl_clients
		WHERE
			clientID = $clientID
		") or mysql_die();
	
	$res_banners = db_query("
		SELECT
			bannerID
		FROM
			$phpAds_tbl_banners
		WHERE
			clientID = $clientID
		") or mysql_die();
	
	while ($row = mysql_fetch_array($res_banners))
		db_delete_stats($row['bannerID']);
	
	db_query("
		DELETE FROM
			$phpAds_tbl_banners
		WHERE
			clientID = $clientID
		") or mysql_die();
	
	Header("Location: admin.php?message=".urlencode($strClientDeleted));
}

?>
