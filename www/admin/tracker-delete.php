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
$Id: tracker-delete.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

if (phpAds_isUser(phpAds_Agency))
{
	$res = phpAds_dbQuery(
		"SELECT c.clientid".
		" FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
		",".$conf['table']['prefix'].$conf['table']['trackers']." AS t".
		" WHERE t.clientid=c.clientid".
		" AND t.trackerid='".$trackerid."'".
		" AND c.agencyid=".phpAds_getUserID()
	) or phpAds_sqlDie();
	
	if (phpAds_dbNumRows($res) == 0)
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

function phpAds_DeleteTracker($trackerid)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	
	// Delete Campaign
	$res = phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['trackers'].
		" WHERE trackerid='".$trackerid."'"
	) or phpAds_sqlDie();
	
	// Delete Campaign/Tracker links
	$res = phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['campaigns_trackers'].
		" WHERE trackerid='".$trackerid."'"
	) or phpAds_sqlDie();
	
	// Delete Conversions Logged to this Tracker
	//$res = phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['conversionlog'].
	//	" WHERE trackerid='".$trackerid."'"
	//) or phpAds_sqlDie();
	
	// Delete stats for each banner
	phpAds_deleteStatsByTrackerID($trackerid);
}


if (isset($trackerid) && $trackerid != '')
{
	// Campaign is specified, delete only this campaign
	phpAds_DeleteTracker($trackerid);
}
elseif (isset($clientid) && $clientid != '')
{
	// No campaign specified, delete all trackers for this client
	$res_trackers = phpAds_dbQuery("
		SELECT
			trackerid
		FROM
			".$conf['table']['prefix'].$conf['table']['trackers']."
		WHERE
			clientid = '".$clientid."'
	");
	
	while ($row = phpAds_dbFetchArray($res_trackers))
	{
		phpAds_DeleteTracker($row['trackerid']);
	}
}


if (!isset($returnurl) && $returnurl == '')
	$returnurl = 'advertiser-trackers.php';

header ("Location: ".$returnurl."?clientid=".$clientid);

?>