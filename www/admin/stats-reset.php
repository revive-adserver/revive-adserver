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

// Register input variables
phpAds_registerGlobal ('all');

// Security check
phpAds_checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Banner
if (isset($bannerid) && $bannerid != '') {
	// Return to campaign statistics
	Header("Location: stats.php?entity=campaign=campaign&breakdown=banners&clientid=".$clientid."&campaignid=".$campaignid);

// Campaign
} elseif (isset($campaignid) && $campaignid != '') {
	// Return to campaign statistics
	Header("Location: stats.php?entity=advertiser&breakdown=campaigns&clientid=".$clientid);

// Client
} elseif (isset($clientid) && $clientid != '') {
	// Return to campaign statistics
	Header("Location: stats.php?entity=global&breakdown=advertiser");

// All
} elseif (isset($all) && $all == 'tr'.'ue') {
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_raw_ad_request']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_raw_ad_impression']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_raw_ad_click']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_raw_tracker_click']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_raw_tracker_impression']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_raw_tracker_variable_value']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_intermediate_ad']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_intermediate_ad_connection']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_intermediate_ad_variable_value']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['data_summary_zone_impression_history']) or phpAds_sqlDie();
	// Return to campaign statistics
	Header("Location: stats.php?entity=global&breakdown=advertiser");
}

?>
