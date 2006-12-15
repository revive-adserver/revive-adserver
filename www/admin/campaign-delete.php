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
$Id: campaign-delete.php 5025 2006-06-16 16:15:32Z andrew@m3.net $
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
    if (isset($campaignid) && $campaignid != '') {
        $query = "SELECT c.clientid".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
        ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
        " WHERE c.clientid=m.clientid".
        " AND c.clientid='".$clientid."'".
        " AND m.campaignid='".$campaignid."'".
        " AND agencyid=".phpAds_getUserID();
    } else {
        $query = "SELECT c.clientid".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
        " WHERE c.clientid='".$clientid."'".
        " AND agencyid=".phpAds_getUserID();
    }
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

function phpAds_DeleteCampaign($campaignid) {
    $conf = $GLOBALS['_MAX']['CONF'];

    // Delete Campaign_Zone Associations
    phpAds_dbQuery("DELETE FROM {$conf['table']['prefix']}{$conf['table']['placement_zone_assoc']} WHERE placement_id=$campaignid") or phpAds_sqlDie();

    // Delete Campaign
    phpAds_dbQuery("DELETE FROM {$conf['table']['prefix']}{$conf['table']['campaigns']} WHERE campaignid=$campaignid") or phpAds_sqlDie();

    // Delete Campaign/Tracker links
    phpAds_dbQuery("DELETE FROM {$conf['table']['prefix']}{$conf['table']['campaigns_trackers']} WHERE campaignid=$campaignid") or phpAds_sqlDie();

    // Delete Conversions Logged to this Campaign
    //$res = phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['conversionlog'].
    //" WHERE campaignid='".$campaignid."'"
    //) or phpAds_sqlDie();

    // Loop through each banner
    $res_banners = phpAds_dbQuery("
		SELECT
			bannerid,
			storagetype AS type,
			filename
		FROM
			".$conf['table']['prefix'].$conf['table']['banners']."
		WHERE
			campaignid = '$campaignid'
	") or phpAds_sqlDie();

    while ($row = phpAds_dbFetchArray($res_banners)) {

    	$bannerid = $row['bannerid'];

        // Cleanup stored images for each banner
        if (($row['type'] == 'web' || $row['type'] == 'sql') && $row['filename'] != '') {
            phpAds_ImageDelete ($row['type'], $row['filename']);
        }

        // Delete Banner ACLs
        phpAds_dbQuery("
			DELETE FROM
				".$conf['table']['prefix'].$conf['table']['acls']."
			WHERE
				bannerid = $bannerid
		") or phpAds_sqlDie();

	    // Delete Ad_Zone Associations
	    phpAds_dbQuery("DELETE FROM {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']} WHERE ad_id=$bannerid") or phpAds_sqlDie();

        // Delete stats for each banner
        //phpAds_deleteStatsByBannerID($bannerid);
    }

    // Delete Banners
    phpAds_dbQuery("
		DELETE FROM
			".$conf['table']['prefix'].$conf['table']['banners']."
		WHERE
			campaignid = '$campaignid'
	") or phpAds_sqlDie();
}


if (isset($campaignid) && $campaignid != '') {
    // Campaign is specified, delete only this campaign
    phpAds_DeleteCampaign($campaignid);
    // Find and delete the campains from $node_array, if
    // necessary. (Later, it would be better to have
    // links to this file pass in the clientid as well,
    // to facilitate the process below.
    if (!empty($node_array['clients'])) {
        foreach ($node_array['clients'] as $key => $val) {
            if (isset($node_array['clients'][$key]['campaigns'])) {
                unset($node_array['clients'][$key]['campaigns'][$campaignid]);
            }
        }
    }
}

// Run the Maintenance Priority Engine process
MAX_Maintenance_Priority::run();

// Rebuild cache
// include_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
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
    $returnurl = 'advertiser-campaigns.php';
}

header ("Location: ".$returnurl."?clientid=".$clientid);

?>
