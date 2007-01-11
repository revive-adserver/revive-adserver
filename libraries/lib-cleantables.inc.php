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


// Set define to prevent duplicate include
define ('LIBCLEANTABLES_INCLUDED', true);



/*********************************************************/
/* Clean stats and userlog entries                       */
/*********************************************************/

function phpAds_cleanTables($weeks, $stats)
{
	global $phpAds_config;
	
	$report = '';
	
	
	// Determine tables
	if ($stats)
		$tables = array(
			$phpAds_config['tbl_adstats'] => array('day', 'Ymd'),
			$phpAds_config['tbl_adviews'] => array('t_stamp', 'YmdHis'),
			$phpAds_config['tbl_adclicks'] => array('t_stamp', 'YmdHis')
		);
	else
		$tables = array(
			$phpAds_config['tbl_userlog'] => array('timestamp', '')
		);
	
	
	$t_stamp = phpAds_makeTimestamp(mktime (0, 0, 0, date('m'),
		date('d'), date('Y')), (-7 * $weeks + 1) * 60*60*24);
	
	while (list($k, $v) = each($tables))
	{
		if (!$v[1])
			$begin = $t_stamp;
		else
			$begin = date($v[1], $t_stamp);
		
		phpAds_dbQuery("
			DELETE FROM
				".$k."
			WHERE
				".$v[0]." < ".$begin."
		");
	
		$report .= 'Table '.$k.': deleted '.phpAds_dbAffectedRows().' rows'."\n";
	}
	
	return $report;
}

?>