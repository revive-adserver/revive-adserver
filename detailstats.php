<?

require("config.php");
require("kcsm.php");

if($pageid == "client")
{
	$result = mysql_db_query($phpAds_db, "
		SELECT
			clientID
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $GLOBALS[bannerID]
		") or mysql_die();
	$row = mysql_fetch_array($result);
	if($row["clientID"] != $Session[clientID])
	{
		print($strAccessDenied);    
		page_footer();
		exit();
	}

	page_header();
	show_nav("2.1");

	if(!isset($bannerID))
		$bannerID = $Session["bannerID"];
	include("./detailstats.inc.php");
	$Session["bannerID"] = $bannerID;
	page_footer();
}

if($pageid == "admin")
{
	kc_auth_admin();
	page_header();
	show_nav("1.4.1");
	if (!isset($bannerID))
		$bannerID = $Session["bannerID"];
	include("./detailstats.inc.php");
	$Session["bannerID"] = $bannerID;
	page_footer();
}
?>
