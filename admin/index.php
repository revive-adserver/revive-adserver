<?
require ("config.php");


phpAds_checkAccess(phpAds_Admin+phpAds_Client);


if (phpAds_isUser(phpAds_Admin))
{
	Header("Location: $phpAds_url_prefix/admin/admin.php");
	exit;
}

if (phpAds_isUser(phpAds_Client))
{
	Header("Location: $phpAds_url_prefix/admin/stats-client.php");
	exit;
}
?>