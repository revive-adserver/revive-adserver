<?
	require ("config.php");

	$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	
	
	echo "<html><body>";
	
	if ($res)
	{
		$row = @mysql_fetch_array($res);
		
		echo stripslashes ($row[banner]);
	}
	
	echo "</body></html>";

?>