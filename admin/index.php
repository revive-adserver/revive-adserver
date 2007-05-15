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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client+phpAds_Affiliate);


// Deal with load balacing having a different admin URL
if (!empty($phpAds_config['lb_enabled'])
	$phpAds_config['url_prefix'] = $phpAds_config['lb_admin_url_prefix'];



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
	header("Location: ".$phpAds_config['url_prefix']."/admin/client-index.php");
elseif (phpAds_isUser(phpAds_Client))
	header("Location: ".$phpAds_config['url_prefix']."/admin/stats-client-history.php?clientid=".phpAds_getUserID());
elseif (phpAds_isUser(phpAds_Affiliate))
	header("Location: ".$phpAds_config['url_prefix']."/admin/stats-affiliate-zones.php?affiliateid=".phpAds_getUserID());

exit;

?>