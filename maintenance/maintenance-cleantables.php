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
require	(phpAds_path."/lib-cleantables.inc.php"); 


$report = ''

if ($phpAds_config['auto_clean_tables'])
	$report .= phpAds_cleanTables($phpAds_config['auto_clean_tables_interval'], true);

if ($phpAds_config['auto_clean_userlog'])
	$report .= phpAds_cleanTables($phpAds_config['auto_clean_userlog_interval'], false);

if ($report != '' && $phpAds_config['userlog_autoclean'])
	phpAds_userlogAdd (phpAds_actionAutoClean, 0, $report);


?>