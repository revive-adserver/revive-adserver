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

for ($i=0;$i<count($clientID);$i++)
{
	// Delete that client
	if ($clientID[$i])
	{
		$foo = db_query("
			DELETE FROM
				$phpAds_tbl_clients
			WHERE
				clientID = $clientID[$i]
			") or mysql_die();
		
		$res_banners = db_query("
			SELECT
				bannerID
			FROM
				$phpAds_tbl_banners
			WHERE
				clientID = $clientID[$i]
			") or mysql_die();
		
		while ($row = mysql_fetch_array($res_banners))
			db_delete_stats($row['bannerID']);
		
		db_query("
			DELETE FROM
				$phpAds_tbl_banners
			WHERE
				clientID = $clientID[$i]
			") or mysql_die();
	}	
}

Header("Location: admin.php?message=".urlencode($strClientDeleted));

?>
