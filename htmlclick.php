<?

require("config.php");

if($phpAds_log_adclicks)
{
	$getclientID=db_query("SELECT clientID FROM $phpAds_tbl_banners WHERE bannerID='$bannerID'");
	if($gotclientID=mysql_fetch_array($getclientID))
	{
		$clientID=$gotclientID["clientID"];
	}
	$currentclick=db_query("SELECT * FROM $phpAds_tbl_clients WHERE clientID='$clientID' and clicks > 0");
	if($clickcount=mysql_fetch_array($currentclick))
	{
		$clickcount["clicks"]=$clickcount["clicks"]-1;
		// Mail warning preset is reached
		if($clickcount["clicks"]==$phpAds_warn_limit)
			warn_mail($clickcount);

		db_query("UPDATE $phpAds_tbl_clients SET clicks='$clickcount[clicks]' WHERE clientID='$clientID'");
		// Check click count and de-activate banner if needed
		if($clickcount["views"]==0 && $clickcount["clicks"]==0)
			db_query("UPDATE $phpAds_tbl_banners SET active='false' WHERE clientID='$clientID'");
	}

	if($phpAds_reverse_lookup)
		$host = isset($REMOTE_HOST) ? $REMOTE_HOST : @gethostbyaddr($REMOTE_ADDR);
	else
		$host = $REMOTE_ADDR;

	// Check if host is on list of hosts to ignore

	$found=0;
	while (($found == 0) && (list ($key, $ignore_host)=each($phpAds_ignore_hosts)))
		if (eregi($ignore_host, $host)) // host found in ignore list
			$found=1;

	if ($found == 0)
	{
		$res = db_log_click($bannerID, "null", $host);
	}
}
Header("Location: ".urldecode($dest));
?>
