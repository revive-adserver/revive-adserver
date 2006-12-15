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

// Required files
require_once MAX_PATH . '/lib/max/other/lib-db.inc.php';

// Define usertypes
define ("phpAds_userDeliveryEngine", 1);
define ("phpAds_userMaintenance", 2);
define ("phpAds_userAdministrator", 3);
define ("phpAds_userAdvertiser", 4);
define ("phpAds_userPublisher", 5);

// Define actions
define ("phpAds_actionAdvertiserReportMailed", 0);
define ("phpAds_actionPublisherReportMailed", 1);
define ("phpAds_actionWarningMailed", 2);
define ("phpAds_actionDeactivationMailed", 3);
define ("phpAds_actionPriorityCalculation", 10);
define ("phpAds_actionPriorityAutoTargeting", 11);
define ("phpAds_actionDeactiveCampaign", 20);
define ("phpAds_actionActiveCampaign", 21);
define ("phpAds_actionAutoClean", 30);
define ("phpAds_actionBatchStatistics", 40);

$GLOBAL['phpAds_Usertype'] = 0;

/*-------------------------------------------------------*/
/* Add an entry to the userlog                           */
/*-------------------------------------------------------*/

function phpAds_userlogAdd($action, $object, $details = '')
{
    $conf = $GLOBALS['_MAX']['CONF'];
	global $phpAds_Usertype;
	if ($phpAds_Usertype != 0) {
		$usertype = $phpAds_Usertype;
		$userid   = 0;
	} else {
		$usertype = phpAds_userAdministrator;
		$userid   = 0;
	}
	$res = phpAds_dbQuery("
		INSERT INTO
			".$conf['table']['prefix'].$conf['table']['userlog']."
		SET
			timestamp = ".time().",
			usertype = '".$usertype."',
			userid = '".$userid."',
			action = '".$action."',
			object = '".$object."',
			details = '".addslashes($details)."'
	");
}

function phpAds_userlogSetUser ($usertype)
{
	global $phpAds_Usertype;
	$phpAds_Usertype = $usertype;
}

?>
