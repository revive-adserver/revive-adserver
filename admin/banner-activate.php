<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-zones.inc.php");
require ("../libraries/lib-priority.inc.php");


// Register input variables
phpAds_registerGlobal ('value');


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if ($value == "t")
	$value = "f";
else
	$value = "t";

if (phpAds_isUser(phpAds_Client))
{
	if (($value == 'f' && phpAds_isAllowed(phpAds_DisableBanner)) || 
	    ($value == 't' && phpAds_isAllowed(phpAds_ActivateBanner)))
	{
		$result = phpAds_dbQuery("
			SELECT
				clientid
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = '$bannerid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["clientid"] == '' || phpAds_getUserID() != phpAds_getParentID ($row["clientid"]))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignid = $row["clientid"];
			
			$res = phpAds_dbQuery("
				UPDATE
					".$phpAds_config['tbl_banners']."
				SET
					active = '$value'
				WHERE
					bannerid = '$bannerid'
				") or phpAds_sqlDie();
			
			
			// Rebuild priorities
			phpAds_PriorityCalculate ();
			
			
			// Rebuild cache
			if (!defined('LIBVIEWCACHE_INCLUDED')) 
				include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
			
			phpAds_cacheDelete();
			
			
			Header("Location: stats-campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid);
		}
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}


if (phpAds_isUser(phpAds_Admin))
{
	if (isset($bannerid) && $bannerid != '')
	{
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_banners']."
			SET
				active = '$value'
			WHERE
				bannerid = '$bannerid'
		") or phpAds_sqlDie();
	}
	elseif (isset($campaignid) && $campaignid != '')
	{
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_banners']."
			SET
				active = '$value'
			WHERE
				clientid = '$campaignid'
		") or phpAds_sqlDie();
	}
	
	// Rebuild priorities
	phpAds_PriorityCalculate ();
	
	
	// Rebuild cache
	if (!defined('LIBVIEWCACHE_INCLUDED')) 
		include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
	
	phpAds_cacheDelete();
	
	
	Header("Location: campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid);
}


?>