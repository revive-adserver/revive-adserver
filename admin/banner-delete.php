<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($bannerID))
{
	phpAds_PageHeader("$strBannerAdmin");
	php_die("hu?", "Where is my ID? I've lost my ID! Moooommmeee... I want my ID back!");
}

db_query("
	DELETE FROM
		$phpAds_tbl_banners
	WHERE
		bannerID = $bannerID
	") or mysql_die();

db_query("
	DELETE FROM
		$phpAds_tbl_acls
	WHERE
		bannerID = $bannerID
	") or mysql_die();

db_delete_stats($bannerID);

Header("Location: banner-client.php?clientID=$clientID&message=".urlencode($strBannerDeleted));

?>
