<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-banner.inc.php");
require ("lib-storage.inc.php");


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
	if ($current['storagetype'] == 'sql')
	{
		// Get the filename
		$filename = $current['filename'];
		
		// Copy the file
		$buffer = phpAds_ImageRetrieve ('sql', $filename);
		$current['filename'] = phpAds_ImageStore('web', $filename, $buffer);
		
		if ($current['filename'] != false)
		{
			// Delete the original file
			phpAds_ImageDelete ('sql', $filename);
			
			// Update fields
			$current['imageurl'] 	= $phpAds_config['type_web_url'].'/'.$current['filename'];
			$current['storagetype'] = 'web';
			
			// Rebuild banner cache
			$current['htmltemplate'] = stripslashes($current['htmltemplate']);
			$current['htmlcache']    = addslashes(phpAds_getBannerCache($current));
			
			phpAds_dbQuery("
				UPDATE
					".$phpAds_config['tbl_banners']."
				SET
					filename  = '".$current['filename']."',
					imageurl  = '".$current['imageurl']."',
					storagetype = '".$current['storagetype']."',
					htmlcache = '".$current['htmlcache']."'
				WHERE
					bannerid = ".$current['bannerid']."
			");
		}
	}
}
				

// Rebuild delivery cache
if (!defined('LIBVIEWCACHE_INCLUDED')) 
	include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');

phpAds_cacheDelete();


header("Location: maintenance-storage.php");

?>