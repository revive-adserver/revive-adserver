<?

require ("config.php");
require("kcsm.php");

if($pageid  == "admin") //Allen 7/26/99 - allenb@home-networking.org
{
	page_header();
	show_nav("1.4.1.1");
}

if($pageid  == "client")
{
	$result = db_query("
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
	show_nav("2.1.1");
}
									

require("./dailystats.inc.php");

page_footer();
?>
