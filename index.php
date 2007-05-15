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
require	("config.inc.php");

// Redirect to the admin interface
if (defined('phpAds_installed') && phpAds_installed)
{
	// Redirect to the admin URL
	if (!empty($phpAds_config['lb_enabled']))
		$phpAds_config['url_prefix'] = $phpAds_config['lb_admin_url_prefix'];
	
	header("Location: ".$phpAds_config['url_prefix']."/admin/index.php");
}
else
	header("Location: admin/index.php");

?>