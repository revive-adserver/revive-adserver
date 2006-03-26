<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-zones.inc.php");


// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($affiliateid) && $affiliateid != '')
{
	// Reset append codes which called this affiliate's zones
	$res = phpAds_dbQuery("
			SELECT
				zoneid
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				affiliateid = '$affiliateid'
		");

	$zones = array();
	while ($row = phpAds_dbFetchArray($res))
		$zones[] = $row['zoneid'];
	
	if (count($zones))
	{
		$res = phpAds_dbQuery("
				SELECT
					zoneid,
					append
				FROM
					".$phpAds_config['tbl_zones']."
				WHERE
					appendtype = ".phpAds_ZoneAppendZone." AND
					affiliateid <> '$affiliateid'
			");
		
		while ($row = phpAds_dbFetchArray($res))
		{
			$append = phpAds_ZoneParseAppendCode($row['append']);

			if (in_array($append[0]['zoneid'], $zones))
			{
				phpAds_dbQuery("
						UPDATE
							".$phpAds_config['tbl_zones']."
						SET
							appendtype = ".phpAds_ZoneAppendRaw.",
							append = ''
						WHERE
							zoneid = '".$row['zoneid']."'
					");
			}
		}

		
		// Delete zones
		$res = phpAds_dbQuery("
			DELETE FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				affiliateid = '$affiliateid'
			") or phpAds_sqlDie();
	}

	// Delete affiliate
	$res = phpAds_dbQuery("
		DELETE FROM
			".$phpAds_config['tbl_affiliates']."
		WHERE
			affiliateid = '$affiliateid'
		") or phpAds_sqlDie();
}

if (!isset($returnurl) && $returnurl == '')
	$returnurl = 'affiliate-index.php';

// Prevent HTTP response splitting
if (strpos($returnurl, "\r\n") === false)
{
	$url = stripslashes($returnurl);

	header("Location: ".$returnurl);
}

?>