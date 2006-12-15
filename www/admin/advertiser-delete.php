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
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';

// Register input variables
phpAds_registerGlobal ('returnurl');

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

if (phpAds_isUser(phpAds_Agency)) {
    $query = "SELECT clientid".
    " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
    " WHERE clientid='".$clientid."'".
    " AND agencyid=".phpAds_getUserID();
    $res = phpAds_dbQuery($query) or phpAds_sqlDie();
    if (phpAds_dbNumRows($res) == 0) {
        phpAds_PageHeader("2");
        phpAds_Die ($strAccessDenied, $strNotAdmin);
    }
}

/*-------------------------------------------------------*/
/* Restore cache of $node_array, if it exists            */
/*-------------------------------------------------------*/

if (isset($session['prefs']['advertiser-index.php']['nodes'])) {
    $node_array = $session['prefs']['advertiser-index.php']['nodes'];
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($clientid) && $clientid != '') {
    // Loop through each campaign
    $res_campaign = phpAds_dbQuery(
    "SELECT campaignid".
    " FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
    " WHERE clientid='".$clientid."'"
    ) or phpAds_sqlDie();

    while ($row_campaign = phpAds_dbFetchArray($res_campaign)) {
        $campaignid = $row_campaign['campaignid'];

        // Delete Campaign/Tracker links
        phpAds_dbQuery("DELETE FROM {$conf['table']['prefix']}{$conf['table']['campaigns_trackers']} WHERE campaignid=$campaignid") or phpAds_sqlDie();

	    // Delete Campaign_Zone Associations
	    phpAds_dbQuery("DELETE FROM {$conf['table']['prefix']}{$conf['table']['placement_zone_assoc']} WHERE placement_id=$campaignid") or phpAds_sqlDie();

        // Delete Conversions Logged to this Campaign
        //$res = phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['conversionlog'].
        //" WHERE campaignid='".$campaignid."'"
        //) or phpAds_sqlDie();

        // Loop through each banner
        $res_banners = phpAds_dbQuery(
        "SELECT".
        " bannerid".
        ",storagetype AS type".
        ",filename".
        " FROM ".$conf['table']['prefix'].$conf['table']['banners'].
        " WHERE campaignid=".$row_campaign['campaignid']."
			") or phpAds_sqlDie();

        while ($row_banners = phpAds_dbFetchArray($res_banners)) {
            $bannerid = $row_banners['bannerid'];

            // Cleanup stored images for each banner
            if (($row_banners['type'] == 'web' || $row_banners['type'] == 'sql') && $row_banners['filename'] != '') {
                phpAds_ImageDelete ($row_banners['type'], $row_banners['filename']);
            }

            // Delete Banner ACLs
            phpAds_dbQuery(
            "DELETE FROM ".$conf['table']['prefix'].$conf['table']['acls'].
            " WHERE bannerid='".$bannerid."'"
            ) or phpAds_sqlDie();

	        // Delete Ad_Zone Associations
	        phpAds_dbQuery("DELETE FROM {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']} WHERE ad_id=$bannerid") or phpAds_sqlDie();

            // Delete stats for each banner
            //phpAds_deleteStatsByBannerID($bannerid);
        }

        // Delete Banners
        phpAds_dbQuery(
        "DELETE FROM ".$conf['table']['prefix'].$conf['table']['banners'].
        " WHERE campaignid='".$campaignid."'"
        ) or phpAds_sqlDie();

    }

    // Loop through each tracker
    $res_tracker = phpAds_dbQuery(
    "SELECT trackerid".
    " FROM ".$conf['table']['prefix'].$conf['table']['trackers'].
    " WHERE clientid='".$clientid."'"
    ) or phpAds_sqlDie();

    while ($row_tracker = phpAds_dbFetchArray($res_tracker)) {
        $trackerid = $row_tracker['trackerid'];

        // Delete Campaign/Tracker links
        $res = phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['campaigns_trackers'].
        " WHERE trackerid='".$trackerid."'"
        ) or phpAds_sqlDie();

        // Delete stats for each tracker
        phpAds_deleteStatsByTrackerID($trackerid);
    }

    // Delete Clients
    $res = phpAds_dbQuery(
    "DELETE FROM ".$conf['table']['prefix'].$conf['table']['clients'].
    " WHERE clientid='".$clientid."'"
    ) or phpAds_sqlDie();

    // Delete Campaigns
    $res = phpAds_dbQuery(
    "DELETE FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
    " WHERE clientid='".$clientid."'"
    ) or phpAds_sqlDie();

    // Delete Trackers
    $res = phpAds_dbQuery(
    "DELETE FROM ".$conf['table']['prefix'].$conf['table']['trackers'].
    " WHERE clientid='".$clientid."'"
    ) or phpAds_sqlDie();

    // Delete the advertiser from the $node_array,
    // if necessary
    if (isset($node_array)) {
        unset($node_array['clients'][$clientid]);
    }
}

// Run the Maintenance Priority Engine process
MAX_Maintenance_Priority::run();

// Rebuild cache
// require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
// phpAds_cacheDelete();

/*-------------------------------------------------------*/
/* Save the $node_array, if necessary                    */
/*-------------------------------------------------------*/

if (isset($node_array)) {
    $session['prefs']['advertiser-index.php']['nodes'] = $node_array;
    phpAds_SessionDataStore();
}

/*-------------------------------------------------------*/
/* Return to the index page                              */
/*-------------------------------------------------------*/

if (!isset($returnurl) && $returnurl == '') {
    $returnurl = 'advertiser-index.php';
}

header("Location: ".$returnurl);

?>