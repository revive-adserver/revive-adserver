<?

require ("config.php");
require("kcsm.php");

kc_auth_admin();

if (isset($bannerID))
{
    db_delete_stats($bannerID);
	Header("Location: clientstats.php$fncpageid");
}  
else
{
}
?>
