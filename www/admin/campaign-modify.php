<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
include_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/other/common.php';

// Register input variables
phpAds_registerGlobal ('campaignid', 'clientid', 'newclientid', 'returnurl', 'duplicate');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients',   $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);
if (!empty($newclientid)) {
    OA_Permission::enforceAccessToObject('clients', $newclientid);
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
        $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaign_trackers->campaignid = $campaignid;
        $doCampaign_trackers->delete();

        // Move the campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->get($campaignid);
        $doCampaigns->clientid = $newclientid;
        $doCampaigns->update();

        // Find and delete the campains from $node_array, if
        // necessary. (Later, it would be better to have
        // links to this file pass in the clientid as well,
        // to facilitate the process below.
        if (isset($node_array['clients'])) {
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
