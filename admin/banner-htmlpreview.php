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
require ("lib-statistics.inc.php");



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_banners
	WHERE
		bannerID = $bannerID
	") or mysql_die();



if ($res)
{
	$row = @mysql_fetch_array($res);
	
	echo "<html><head><title>".phpAds_buildBannerName ($bannerID, $row['description'], $row['alt'])."</title></head>";
	echo "<body marginheight='0' marginwidth='0' leftmargin='0' topmargin='0'>";
	echo stripslashes ($row['banner']);
	echo "</body></html>";
}


?>