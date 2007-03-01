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
include_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/other/common.php';

// Register input variables
//phpAds_registerGlobal ('moveto', 'returnurl', 'duplicate', 'clientid', 'campaignid');
phpAds_registerGlobal ('campaignid', 'clientid', 'newclientid', 'returnurl', 'duplicate');

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);
if (!empty($newclientid)) {
    MAX_Permission::checkAccessToObject('campaigns', $campaignid);
    MAX_Permission::checkAccessToObject('clients', $clientid);
    MAX_Permission::checkAccessToObject('clients', $newclientid);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($campaignid)) {
    if (!empty($duplicate)) {
        $newCampaignId = MAX_duplicatePlacement($campaignid, $clientid);
        if ($newCampaignId) {
            Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$newCampaignId}");
            exit;
        } else {
            phpAds_sqlDie();
        }

    } else if (!empty($newclientid)) {

        /*-------------------------------------------------------*/
        /* Restore cache of $node_array, if it exists            */
        /*-------------------------------------------------------*/

        if (isset($session['prefs']['advertiser-index.php']['nodes'])) {
            $node_array = $session['prefs']['advertiser-index.php']['nodes'];
        }

        /*-------------------------------------------------------*/

        // Delete any campaign-tracker links
        $doCampaign_trackers = MAX_DB::factoryDO('campaigns_trackers');
        $doCampaign_trackers->campaignid = $campaignid;
        $doCampaign_trackers->delete();
        
        // Move the campaign
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->get($campaignid);
        $doCampaigns->clientid = $newclientid;
        $doCampaigns->update();
        
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
