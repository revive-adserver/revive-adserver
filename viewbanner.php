<?

require ("config.php");

// Test for $clientID
if(!isset($bannerID))
	php_die("hu?", "Where is my ID? I've lost my ID! Moooommmeee... I want my ID back!");

$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_banners  
	WHERE
		bannerID = $bannerID
	") or mysql_die();

if(mysql_num_rows($res) == 0)
{
	print "$strNoBanners";
}
else
{
	$row = mysql_fetch_array($res);
	if($row["format"] == "url")   // bkl
	{
		Header("Location: $row[banner]");
	} 
	else 
	{
		Header("Content-type: image/$row[format]");
		print $row["banner"];
	}
}
?>
