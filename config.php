<?

require("config.inc.php");
require("lib.inc.php");



// Authorize the user and load user
// specific settings.

require("permissions.inc.php");
phpAds_Start();


require("language/$phpAds_language.inc.php");

$pages = array(
        "1" => array("admin.php"=>"$strHome"),
        "1.1" => array("client.php"=>"$strAddClient"),
        "1.2" => array("client.php"=>"$strModifyClient"),
        "1.3" => array("banner.php?clientID=$clientID"=>"$strBannerAdmin"),
        "1.3.1" => array("banneradd.php"=>"$strAddBanner"),
        "1.3.2" => array("banneradd.php"=>"$strModifyBanner"),
        "1.3.3" => array("banneraddcal.php"=>"$strModifyBannerAcl"),
        "1.4" => array("clientstats.php?clientID=$clientID"=>"$strStats"),
        "1.4.1" => array("detailstats.php?clientID=$clientID&bannerID=$bannerID"=>"$strDetailStats"),
        "1.4.1.1" => array("dailystats.php"=>"$strDailyStats"),
        "1.4.2" => array("weeklystats.php"=>"$strWeeklyStats"),
        "1.5" => array("detailstats.php?clientID=$clientID&bannerID=$bannerID"=>"$strDetailStats"),
        "1.6" => array("liststats.php"=>"$strCreditStats"),
        "2" => array("index.php"=>"$strHome"),
        "2.1" => array("detailstats.php?clientID=$clientID&bannerID=$bannerID"=>"$strDetailStats"),
        "2.1.1" => array("dailystats.php"=>"$strDailyStats"),
        "2.2" => array("weeklystats.php"=>"$strWeeklyStats"),
        "2.3" => array("client.php"=>"$strModifyClient")
);

?>