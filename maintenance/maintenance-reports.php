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
require	("../lib-reports.inc.php"); 



/*********************************************************/
/* Mail clients and check for activation  				 */
/* and expiration dates					 				 */
/*********************************************************/
/*                                                       */
/* Some extra info: The client interval is the number of */
/* days between reports and thus also the maximum number */
/* of day of statistics of this report. The report       */
/* last date is the date on which the last report was    */
/* generated. A report never included the current date   */
/* because the statistics are not completely collected   */
/* for the current day. The last date therefor must be   */
/* included in the statistics for today.                 */
/*                                                       */
/*********************************************************/

$res_clients = db_query("
	SELECT
		clientID,
		report,
		reportinterval,
		reportlastdate,
		UNIX_TIMESTAMP(reportlastdate) AS reportlastdate_t
	FROM
		$phpAds_tbl_clients
	WHERE
		parent = 0 AND report='true'
	");

while($client = @mysql_fetch_array($res_clients))
{
	// Determine date of interval days ago
	$intervaldaysago = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - ($client['reportinterval'] * (60 * 60 * 24));
	
	// Check if the date is interval is reached
	if (($client['reportlastdate_t'] <= $intervaldaysago && 
	     $client['reportlastdate'] != '0000-00-00') ||
	    ($client['reportlastdate'] == '0000-00-00'))
	{
		// Determine first and last date
		$last_unixtimestamp   = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
		$first_unixtimestamp  = $client['reportlastdate_t'];
		
		// Sent report
		$result = phpAds_SendMaintenanceReport ($client['clientID'], $first_unixtimestamp, $last_unixtimestamp, true);
		
		if ($result)
			echo "[id".$client['clientID']."] Statistics report sent!<br>";
	}
}

?>