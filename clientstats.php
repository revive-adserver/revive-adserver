<?

require("config.php");
require("kcsm.php");

page_header($strStats);
show_nav("1.4");
if (!isset($clientID))
	$clientID = $Session["clientID"];
$res_banners = db_query("
	SELECT
		banner,
		bannerID,
		width,
		height,
		format
	FROM
		$phpAds_tbl_banners
	WHERE
		clientID = $clientID
	") or mysql_die() ;
$Session["clientID"] = $clientID;
require("./stats.inc.php");
page_footer();
?>
