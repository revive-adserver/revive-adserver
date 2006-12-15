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
$Id: campaign-modify.php 5025 2006-06-16 16:15:32Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
include_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/other/common.php';

// Register input variables
//phpAds_registerGlobal ('moveto', 'returnurl', 'duplicate', 'clientid', 'campaignid');
phpAds_registerGlobal ('campaignid', 'clientid', 'newclientid', 'returnurl', 'duplicate');

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($campaignid) && $campaignid != '') {
    if (isset($duplicate) && $duplicate != '' && (phpAds_isUser(phpAds_Agency) || phpAds_isUser(phpAds_Admin))) {
        $newCampaignId = MAX_duplicatePlacement($campaignid, $clientid);
        if ($newCampaignId) {
            Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$newCampaignId}");
            exit;
        } else {
            phpAds_sqlDie();
        }

    } else if (isset($newclientid) && $newclientid != '') {

        /*-------------------------------------------------------*/
        /* Restore cache of $node_array, if it exists            */
        /*-------------------------------------------------------*/

        if (isset($session['prefs']['advertiser-index.php']['nodes'])) {
            $node_array = $session['prefs']['advertiser-index.php']['nodes'];
        }

        /*-------------------------------------------------------*/

        if (phpAds_isUser(phpAds_Agency)) {
            $query = "SELECT c.clientid".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
                ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
                " WHERE c.clientid=m.clientid".
                " AND c.clientid='".$clientid."'".
                " AND m.campaignid='".$campaignid."'".
                " AND agencyid=".phpAds_getUserID();
            $res = phpAds_dbQuery($query) or phpAds_sqlDie();
            if (phpAds_dbNumRows($res) == 0) {
                phpAds_PageHeader("2");
                phpAds_Die ($strAccessDenied, $strNotAdmin);
            }
            $query = "SELECT c.clientid".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
                " WHERE c.clientid='".$newclientid."'".
                " AND agencyid=".phpAds_getUserID();
            $res = phpAds_dbQuery($query) or phpAds_sqlDie();
            if (phpAds_dbNumRows($res) == 0) {
                phpAds_PageHeader("2");
                phpAds_Die ($strAccessDenied, $strNotAdmin);
            }
        }

        // Delete any campaign-tracker links
        $res = phpAds_dbQuery(
            "DELETE FROM ".$conf['table']['prefix'].$conf['table']['campaigns_trackers'].
            " WHERE campaignid='".$campaignid."'"
        ) or phpAds_sqlDie();

        // Move the campaign
        $res = phpAds_dbQuery(
            "UPDATE ".$conf['table']['prefix'].$conf['table']['campaigns'].
            " SET clientid='".$newclientid."'".
            ", updated = '".date('Y-m-d H:i:s')."'".
            " WHERE campaignid='".$campaignid."'"
        ) or phpAds_sqlDie();

        // Find and delete the campains from $node_array, if
        // necessary. (Later, it would be better to have
        // links to this file pass in the clientid as well,
        // to facilitate the process below.
        if (isset($node_array)) {
            foreach ($node_array['clients'] as $key => $val) {
                if (isset($node_array['clients'][$key]['campaigns'])) {
                    unset($node_array['clients'][$key]['campaigns'][$campaignid]);
                }
            }
        }

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

    }
}

Header ("Location: ".$returnurl."?clientid=".(isset($newclientid) ? $newclientid : $clientid)."&campaignid=".$campaignid);
exit;
?>
