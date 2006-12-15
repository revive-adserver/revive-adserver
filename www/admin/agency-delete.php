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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
//require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';

// Register input variables
phpAds_registerGlobal ('returnurl','agencyid');

// Security check
phpAds_checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($agencyid) && $agencyid != '' && $agencyid != 0) {

	// ----------------------------------------------------------------------
	// Delete clients
	// ----------------------------------------------------------------------

	// Need to delete all the advertisers under this agency
	$res_clients = phpAds_dbQuery(
		"SELECT clientid".
		" FROM ".$conf['table']['prefix'].$conf['table']['clients'].
		" WHERE agencyid='".$agencyid."'"
	) or phpAds_sqlDie();

	while ($row_client = phpAds_dbFetchArray($res_clients)) {
		$clientid = $row_client['clientid'];
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
		    /*
			// Delete Conversions Logged to this Campaign
			$res = phpAds_dbQuery("DELETE FROM ".$conf['table']['prefix'].$conf['table']['conversionlog'].
				" WHERE campaignid='".$campaignid."'"
			) or phpAds_sqlDie();
			*/
			// Loop through each banner
			$res_banners = phpAds_dbQuery(
				"SELECT".
				" bannerid".
				",storagetype AS type".
				",filename".
				" FROM ".$conf['table']['prefix'].$conf['table']['banners'].
				" WHERE campaignid=".$row_campaign['campaignid']
			) or phpAds_sqlDie();
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
		        /*
 				// Delete stats for each banner
				phpAds_deleteStatsByBannerID($bannerid);
				*/
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
	}

	// ----------------------------------------------------------------------
	// Delete clients END
	// ----------------------------------------------------------------------

	// ----------------------------------------------------------------------
	// Delete affiliates
	// ----------------------------------------------------------------------


	// Need to delete all the advertisers under this agency
	$res_affiliate = phpAds_dbQuery(
		"SELECT affiliateid".
		" FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
		" WHERE agencyid='".$agencyid."'"
	) or phpAds_sqlDie();
	while ($row_affiliate = phpAds_dbFetchArray($res_affiliate)) {
		$affiliateid = $row_affiliate['affiliateid'];
		// Reset append codes which called this affiliate's zones
		$res_zone = phpAds_dbQuery(
			"SELECT zoneid".
			" FROM ".$conf['table']['prefix'].$conf['table']['zones'].
			" WHERE affiliateid='".$affiliateid."'"
		) or phpAds_sqlDie();
		while ($row_zone = phpAds_dbFetchArray($res_zone)) {
			$zones[] = $row_zone['zoneid'];
		}
		if (is_array($zones) && sizeof($zones) > 0) {
			$res_zone = phpAds_dbQuery(
				"SELECT zoneid,append".
				" FROM ".$conf['table']['prefix'].$conf['table']['zones'].
				" WHERE appendtype=".phpAds_ZoneAppendZone.
				" AND affiliateid<>".$affiliateid
			) or phpAds_sqlDie();
			while ($row_zone = phpAds_dbFetchArray($res_zone)) {
				$append = phpAds_ZoneParseAppendCode($row_zone['append']);
				if (in_array($append[0]['zoneid'], $zones)) {
					phpAds_dbQuery(
						"UPDATE ".$conf['table']['prefix'].$conf['table']['zones'].
						" SET appendtype=".phpAds_ZoneAppendRaw.
						", append=''".
						", updated = '".date('Y-m-d H:i:s')."'".
						" WHERE zoneid=".$row_zone['zoneid']
					) or phpAds_sqlDie();
				}
			}
			// Delete zones
			$res = phpAds_dbQuery(
				"DELETE FROM ".$conf['table']['prefix'].$conf['table']['zones'].
				" WHERE affiliateid='".$affiliateid."'"
			) or phpAds_sqlDie();
		}
	}
	// Delete affiliates_extra row
	$res = phpAds_dbQuery(
		"DELETE FROM ".$conf['table']['prefix'].$conf['table']['affiliates_extra'].
		" WHERE agencyid='".$agencyid."'"
	) or phpAds_sqlDie();
	// Delete Affiliate
	$res = phpAds_dbQuery(
		"DELETE FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
		" WHERE agencyid='".$agencyid."'"
	) or phpAds_sqlDie();

	// ----------------------------------------------------------------------
	// Delete affiliates END
	// ----------------------------------------------------------------------

	// Delete the agency configuration
	$res = phpAds_dbQuery(
		"DELETE FROM ".$conf['table']['prefix'].$conf['table']['preference'].
		" WHERE agencyid='".$agencyid."'"
	) or phpAds_sqlDie();
	// Finally delete the agency
	$res = phpAds_dbQuery(
		"DELETE FROM ".$conf['table']['prefix'].$conf['table']['agency'].
		" WHERE agencyid='".$agencyid."'"
	) or phpAds_sqlDie();
}

// Run the Maintenance Priority Engine process
MAX_Maintenance_Priority::run();

// Rebuild cache
// phpAds_cacheDelete();

if (!isset($returnurl) || $returnurl == '') {
	$returnurl = 'advertiser-index.php';
}

MAX_Admin_Redirect::redirect($returnurl);

?>
