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



$report = '';


$res_campaigns = phpAds_dbQuery("
	SELECT
		clientid,
		clientname,
		DATE_FORMAT(expire, '%Y-%m-%d') AS expire,
		target,
		views
	FROM
		".$phpAds_config['tbl_clients']."
	WHERE
		parent > 0 AND
		active = 't' AND
		expire != '0000-00-00' AND
		views > 0 AND
		weight = 0
	ORDER BY
		clientid
	") or die($strLogErrorClients);

while ($row = phpAds_dbFetchArray($res_campaigns))
{
	$target = ceil($row['views']/(((strtotime($row['expire']) -
		mktime(0, 0, 0, date('m'), date('d'), date('Y'))) / (double)(60*60*24))));
	
	phpAds_dbQuery("
		UPDATE
			".$phpAds_config['tbl_clients']."
		SET
			target = ".$target."
		WHERE
			clientid = ".$row['clientid']
	);
	
	$report .= "$row[clientname] [id$row[clientid]]: $target ($row[target])\n";
}

if ($report != '' && $phpAds_config['userlog_priority'])
	phpAds_userlogAdd (phpAds_actionPriorityAutoTargeting, 0, $report);

?>