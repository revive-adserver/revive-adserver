<?

require("config.inc.php");
require("language/$phpAds_language.inc.php");
require("lib.inc.php");

$pages = array(
	"1" => array("admin.php$fncpageid"=>"$strHome"),
	"1.1" => array("client.php$fncpageid"=>"$strAddClient"),
	"1.2" => array("client.php$fncpageid"=>"$strModifyClient"),
	"1.3" => array("banner.php$fncpageid"=>"$strBannerAdmin"),
	"1.3.1" => array("banneradd.php$fncpageid"=>"$strAddBanner"),
	"1.3.2" => array("banneradd.php$fncpageid"=>"$strModifyBanner"),
	"1.3.3" => array("banneraddcal.php$fncpageid"=>"$strModifyBannerAcl"),
	"1.4" => array("clientstats.php$fncpageid"=>"$strStats"),
	"1.4.1" => array("detailstats.php$fncpageid"=>"$strDetailStats"),
	"1.4.1.1" => array("dailystats.php$fncpageid"=>"$strDailyStats"),
	"1.4.2" => array("weeklystats.php$fncpageid"=>"$strWeeklyStats"),
	"1.5" => array("detailstats.php$fncpageid"=>"$strDetailStats"),
	"1.6" => array("liststats.php$fncpageid"=>"$strCreditStats"),
	"2" => array("index.php$fncpageid"=>"$strHome"),
	"2.1" => array("detailstats.php$fncpageid"=>"$strDetailStats"),
	"2.1.1" => array("dailystats.php$fncpageid"=>"$strDailyStats"),
	"2.2" => array("weeklystats.php$fncpageid"=>"$strWeeklyStats"),
	"2.3" => array("client.php$fncpageid"=>"$strModifyClient")
);
?>
