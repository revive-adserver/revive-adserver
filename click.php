<?

require("config.php");

if(!isset($bannerID))
{
	if(isset($bannerNum) && !empty($bannerNum)) $bannerID = $bannerNum;
	if(isset($n) && is_array($banID)) $bannerID = $banID[$n];
}

$res = db_query("
	SELECT
		url,clientID
	FROM
		$phpAds_tbl_banners
	WHERE
		bannerID = $bannerID
	") or mysql_die();
$url = mysql_result($res,0 ,0);
$clientID=mysql_result($res,0,1);

if($phpAds_log_adclicks)
{
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
		db_log_click($bannerID, $host);

		$currentclick=db_query("SELECT * FROM $phpAds_tbl_clients WHERE clientID=$clientID and clicks > 0");
		if($clickcount=mysql_fetch_array($currentclick))
		{
			$clickcount["clicks"]=$clickcount["clicks"]-1;
			// Mail warning preset is reached
			if($clickcount["clicks"]==$phpAds_warn_limit)
				warn_mail($clickcount);

			db_query("UPDATE $phpAds_tbl_clients SET clicks='$clickcount[clicks]' WHERE clientID='$clientID'");
			// Check click count and de-activate banner if needed
			if($clickcount["clicks"]==0)        // phord: && $clickcount["views"]==0
				db_query("UPDATE $phpAds_tbl_banners SET active='false' WHERE clientID='$clientID'");
		}
	}
}
Header("Location: $url");
?>
