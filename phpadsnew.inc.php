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


// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__)) - 1));
else
    define ('phpAds_path', '.');

// If this path doesn't work for you, customize it here like this
// Note: no trailing backslash
// define ('phpAds_path', "/home/myname/www/phpAdsNew");


// Include required files
require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/lib-db.inc.php");


if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/lib-acl.inc.php");
}

require	(phpAds_path."/lib-view-main.inc.php");

?>