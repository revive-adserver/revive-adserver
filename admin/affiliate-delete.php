<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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

if (isset($affiliateid) && $affiliateid != '')
{
	// Delete banner
	$res = phpAds_dbQuery("
		DELETE FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			affiliateid = $affiliateid
		") or phpAds_sqlDie();
	
	// Delete affiliate
	$res = phpAds_dbQuery("
		DELETE FROM
			".$phpAds_config['tbl_affiliates']."
		WHERE
			affiliateid = $affiliateid
		") or phpAds_sqlDie();
}

if (!isset($returnurl) && $returnurl == '')
	$returnurl = 'affiliate-index.php';

Header("Location: ".$returnurl);

?>
