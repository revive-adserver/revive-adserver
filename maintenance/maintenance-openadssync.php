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



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



if ($phpAds_config['updates_enabled'])
{
	include(phpAds_path.'/libraries/lib-openadssync.inc.php');

	$res = phpAds_checkForUpdates(0, true);
	
	if ($res[0] != 0 && $res[0] != 800)
		phpAds_userlogAdd (phpAds_actionOpenadsSync, "Openads Sync error ($res[0]): $res[1]");
}


?>