<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/lib-reports.inc.php';

// Register input variables
phpAds_registerGlobal ('startday', 'startmonth', 'startyear', 
					   'endday', 'endmonth', 'endyear');


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

if (phpAds_isUser(phpAds_Agency))
{
	$query = "SELECT clientid FROM ".$conf['table']['prefix'].$conf['table']['clients']." WHERE clientid='".$clientid."' AND agencyid=".phpAds_getUserID();
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();
	if (phpAds_dbNumRows($res) == 0)
	{
		phpAds_PageHeader("2");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($clientid) && $clientid != '')
{
	if (isset($startyear) && isset($startmonth) && isset($startday) &&
		$startyear != '' && $startmonth != '' && $startday != '')
		$first_unixtimestamp = mktime(0, 0, 0, $startmonth, $startday, $startyear);
	else
		$first_unixtimestamp = 0;
	
	if (isset($endyear) && isset($endmonth) && isset($endday))
		$last_unixtimestamp = mktime(23, 59, 59, $endmonth, $endday, $endyear);
	else
		$last_unixtimestamp = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
	
	if (phpAds_SendMaintenanceReport ($clientid, $first_unixtimestamp, $last_unixtimestamp, false))
	{
		$message = $strAdReportSent;
	}
	else
	{
		$message = $strErrorOccurred;
	}
}
else
{
	$message = $strErrorOccurred;
}

header("Location: stats.php?entity=advertiser&breakdown=history&clientid=$clientid&message=".urlencode($message));

?>
