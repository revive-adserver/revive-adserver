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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client+phpAds_Affiliate);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	Header("Location: ".$phpAds_config['url_prefix']."/admin/client-index.php");
	exit;
}

if (phpAds_isUser(phpAds_Client))
{
	Header("Location: ".$phpAds_config['url_prefix']."/admin/stats-client-history.php?clientid=".phpAds_getUserID());
	exit;
}

if (phpAds_isUser(phpAds_Affiliate))
{
	Header("Location: ".$phpAds_config['url_prefix']."/admin/stats-affiliate-zones.php?affiliateid=".phpAds_getUserID());
	exit;
}

?>