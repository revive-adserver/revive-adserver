<?

require ("config.php");


phpAds_checkAccess(phpAds_Admin);


for ($i=0;$i<count($clientID);$i++)
{
	// Delete that client
	if ($clientID[$i])
	{
		$foo = db_query("
			DELETE FROM
				$phpAds_tbl_clients
			WHERE
				clientID = $clientID[$i]
			") or mysql_die();
		
		$res_banners = db_query("
			SELECT
				bannerID
			FROM
				$phpAds_tbl_banners
			WHERE
				clientID = $clientID[$i]
			") or mysql_die();
		
		while ($row = mysql_fetch_array($res_banners))
			db_delete_stats($row['bannerID']);
		
		db_query("
			DELETE FROM
				$phpAds_tbl_banners
			WHERE
				clientID = $clientID[$i]
			") or mysql_die();
	}	
}

Header("Location: admin.php?message=".urlencode($strClientDeleted));

?>
