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
				zoneid = $zoneid
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
	
	
	// Delete banner
	$res = phpAds_dbQuery("
		DELETE FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			zoneid = $zoneid
		") or phpAds_sqlDie();
}

Header("Location: zone-index.php?affiliateid=$affiliateid");

?>
