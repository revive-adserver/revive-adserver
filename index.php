<?
if (isset($pageid) && $pageid =="admin")
   {
   Header("Location: ./admin.php");
   exit;
}

if (!isset($pageid))
   {
   $pageid = "client";
   }

require ("config.php");
require("kcsm.php");


if(!isset($clientID) && $Session["username"] == $phpAds_admin && $Session["password"] == $phpAds_admin_pw)
{
   Header("Location: ./admin.php");
   exit;
}

page_header();
show_nav("2");
$res_banners = mysql_db_query($phpAds_db, "
       SELECT
         banner,
         bannerID,
         width,
         height,
         format
       FROM
         $phpAds_tbl_banners
       WHERE
         clientID = $Session[clientID]
       ") or mysql_die();

require("./stats.inc.php");
page_footer();
?>
