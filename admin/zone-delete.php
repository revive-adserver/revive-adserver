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
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($zoneid) && $zoneid != '')
{
	if (phpAds_isUser(phpAds_Affiliate))
	{
		$result = phpAds_dbQuery("
			SELECT
				affiliateid
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"] || !phpAds_isAllowed(phpAds_DeleteZone))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$affiliateid = $row["affiliateid"];
		}
	}
	
	
	// Reset append codes which called this zone
	$res = phpAds_dbQuery("
			SELECT
				zoneid,
				append
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				appendtype = ".phpAds_ZoneAppendZone."
		");
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$append = phpAds_ZoneParseAppendCode($row['append']);

		if ($append[0]['zoneid'] == $zoneid)
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
	
	
	// Delete zone
	$res = phpAds_dbQuery("
		DELETE FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			zoneid = '$zoneid'
		") or phpAds_sqlDie();
}

if (!isset($returnurl) && $returnurl == '')
	$returnurl = 'affiliate-zones.php';

// Prevent HTTP response splitting
if (strpos($returnurl, "\r\n") === false)
{
	$url = stripslashes($returnurl);

	header("Location: ".$returnurl."?affiliateid=$affiliateid");
}

?>