<?
require ("config.php");
require("kcsm.php");

kc_auth_admin();

if ($value == "true")
    $value = "false";
else
    $value = "true";
$res = mysql_db_query($phpAds_db, "
       UPDATE
         $phpAds_tbl_banners
       SET
         active = '$value'
       WHERE
         bannerID = $bannerID
       ") or mysql_die();
Header("Location: banner.php$fncpageid&message=".urlencode($strBannerChanged));
?>
