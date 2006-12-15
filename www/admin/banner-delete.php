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
    $query = "
        SELECT
            b.bannerid AS bannerid
        FROM
            {$conf['table']['prefix']}{$conf['table']['clients']} AS cl,
            {$conf['table']['prefix']}{$conf['table']['campaigns']} AS ca,
            {$conf['table']['prefix']}{$conf['table']['banners']} AS b
        WHERE
            ca.clientid = $clientid
            AND b.campaignid = $campaignid
            AND b.bannerid = $bannerid
            AND b.campaignid = ca.campaignid
            AND ca.clientid = cl.clientid
            AND cl.agencyid = " .phpAds_getUserID();
    $res = phpAds_dbQuery($query) or phpAds_sqlDie();
    if (phpAds_dbNumRows($res) == 0) {
        phpAds_PageHeader("2");
        phpAds_Die ($strAccessDenied, $strNotAdmin);
    }
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

function phpAds_DeleteBanner($bannerid)
{
	$conf = $GLOBALS['_MAX']['CONF'];

	// Cleanup webserver stored image
    $query = "
        SELECT
            storagetype AS type, filename
        FROM
            {$conf['table']['prefix']}{$conf['table']['banners']}
        WHERE
            bannerid = '$bannerid'
    ";
    $res = phpAds_dbQuery($query) or phpAds_sqlDie();

	if ($row = phpAds_dbFetchArray($res))
	{
		if (($row['type'] == 'web' || $row['type'] == 'sql') && $row['filename'] != '') {
			phpAds_ImageDelete ($row['type'], $row['filename']);
		}
	}

	// Delete banner
    $query = "
        DELETE FROM
            {$conf['table']['prefix']}{$conf['table']['banners']}
        WHERE
            bannerid = '$bannerid'
        ";
    $res = phpAds_dbQuery($query) or phpAds_sqlDie();

	// Delete banner ACLs
    $query = "
        DELETE FROM
            {$conf['table']['prefix']}{$conf['table']['acls']}
        WHERE
            bannerid = '$bannerid'
        ";
    $res = phpAds_dbQuery($query) or phpAds_sqlDie();

    // Delete Ad_Zone Associations
    phpAds_dbQuery("DELETE FROM {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']} WHERE ad_id=$bannerid");

 	// Delete statistics for this banner
	//phpAds_deleteStatsByBannerID($bannerid);
}

if (isset($bannerid) && $bannerid != '') {
    phpAds_DeleteBanner($bannerid);
} else if (isset($campaignid) && $campaignid != '') {
    $query = "
        SELECT
            bannerid
        FROM
            ".$conf['table']['prefix'].$conf['table']['banners']."
        WHERE
            campaignid = '$campaignid'
    ";
    $res = phpAds_dbQuery($query);
    while ($row = phpAds_dbFetchArray($res)) {
        phpAds_DeleteBanner($row['bannerid']);
    }
}

// Run the Maintenance Priority Engine process
MAX_Maintenance_Priority::run();

// Rebuild cache
// include_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
// phpAds_cacheDelete();

if (!isset($returnurl) && $returnurl == '') {
    $returnurl = 'campaign-banners.php';
}

header("Location: ".$returnurl."?clientid=".$clientid."&campaignid=".$campaignid);

?>
