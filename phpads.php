<?

require("config.inc.php");
require("view.inc.php");
require("acl.inc.php");

if (!$clientID)
	$clientID=0;

mysql_pconnect($GLOBALS["phpAds_hostname"], $GLOBALS["phpAds_mysqluser"], $GLOBALS["phpAds_mysqlpassword"]);
if (eregi("^[[:digit:]]+$", $what))
	$what = (int)$what;
$row = get_banner($what,$clientID);

if(!empty($row["bannerID"]))
{
	$url = parse_url($GLOBALS["phpAds_url_prefix"]);
	SetCookie("bannerNum", $row["bannerID"], 0, $url["path"]);
	if(isset($n)) SetCookie("banID[$n]", $row["bannerID"], 0, $url["path"]);

	if ($row["format"] == "html")
	{
		echo $row["banner"];
		log_adview($row["bannerID"],$row["clientID"]);
	}
	else
	{
		if($row["format"] == "url")   // bkl
		{
			Header("Location: $row[banner]");
			log_adview($row["bannerID"],$row["clientID"]);
		}
		else
		{
			Header("Content-type: image/$row[format]; name=".microtime());
			echo $row["banner"];
			log_adview($row["bannerID"],$row["clientID"]);
		} 
	}
}
else
{
	Header( "Content-type: image/$row[format]");
	echo $row["banner"];
}  
?>
