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
require ("lib-banner.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
");

while ($current = phpAds_dbFetchArray($res))
{
	// Rebuild filename
	if ($current['storagetype'] == 'sql')
		$current['imageurl'] = $phpAds_config['url_prefix']."/adimage.php?filename=".$current['filename']."&contenttype=".$current['contenttype'];
	
	if ($current['storagetype'] == 'web')
		$current['imageurl'] = $phpAds_config['type_web_url'].'/'.$current['filename'];
	
	
	
	// Rebuild cache
	$current['htmltemplate'] = stripslashes($current['htmltemplate']);
	$current['htmlcache']    = addslashes(phpAds_getBannerCache($current));
	
	phpAds_dbQuery("
		UPDATE
			".$phpAds_config['tbl_banners']."
		SET
			htmlcache = '".$current['htmlcache']."',
			imageurl  = '".$current['imageurl']."'
		WHERE
			bannerid = ".$current['bannerid']."
	");
}

Header("Location: client-index.php");

?>
